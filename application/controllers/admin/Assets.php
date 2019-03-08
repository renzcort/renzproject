<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Assets_m', 'assets_m');
    $this->data = array(
      'title'    =>  'Assets',
      'userdata' =>  $this->first_load(),
    );
  }

  public function index() {
    $settings = array(
      'title'     =>  'Assets',
      'subheader' =>  'Manage Assets',
      'content'   =>  'admin/assets/index',
      'table'     =>  'assets',
      'action'    =>  'admin/assets',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
    );

    // Pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 3;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('admin/layout/_default', $settings);
  }

  /*CREATE*/
  public function create() {
    $settings = array(
      'title'     =>  'Assets',
      'subheader' =>  'Manage Assets',
      'content'   =>  'admin/assets/create',
      'table'     =>  'assets',
      'action'    =>  'admin/assets',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
      'type'      =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    // $this->form_validation->set_rules('handle', 'Handle', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'       => $this->input->post('name'),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type'       => $this->input->post('type'),
          'path'       => $this->input->post('path'),
          'url'        => $this->input->post('url'),
          'parent'     => $this->input->post('parent'),
          'order'      => $this->input->post('order'),
          'description'=> $this->input->post('description'),
          'created_by' => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', 'add '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function update($id='') {
    $settings = array(
      'title'     =>  'Assets',
      'subheader' =>  'Manage Assets',
      'content'   =>  'admin/assets/edit',
      'table'     =>  'assets',
      'action'    =>  'admin/assets',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
      'type'      =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
    );
    $settings['getdataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    // $this->form_validation->set_rules('handle', 'Handle', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'       => $this->input->post('name'),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type'       => $this->input->post('type'),
          'path'       => $this->input->post('path'),
          'url'        => $this->input->post('url'),
          'parent'     => $this->input->post('parent'),
          'order'      => $this->input->post('order'),
          'description'=> $this->input->post('description'),
          'updated_by' => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', 'update '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function delete($id='') {
    $settings = array(
      'title'     =>  'Assets',
      'subheader' =>  'Manage Assets',
      'content'   =>  'admin/assets/update',
      'table'     =>  'assets',
      'action'    =>  'admin/assets',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
    );

    if ($this->general_m->get_row_by_id($settings['table'], $id)) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
    
  }

}

/* End of file Assets.php */
/* Location: ./application/controllers/admin/Assets.php */