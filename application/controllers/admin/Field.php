<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Field extends My_Controller {
  
  public $data = [];

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->data = array(
      'title' =>  'Field',
      'userdata'  =>  $this->first_load(),
    );
  }

  public function index() {
    $settings = array(
      'title'     =>  'Field',
      'subheader' =>  'Manage Field',
      'content'   =>  'admin/field/index',
      'table'     =>  'field'
      'action'    =>  'admin/field',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
    );

    // Pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $settings['total_rows'] / $settings['per_page'];
    $config['uri_segment']  = 3;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($settings['uri_segment']) : 0);
    $settings['record_all'] = $this->field_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('admin/layout/_default', $settings);
  }

  /*GROUP Field*/
  public function group() {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage Field',
      'content'   =>  'admin/field/group/index',
      'table'     =>  'field_group',
      'action'    => 'admin/field/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $settings['total_rows'] / $settings['per_page'];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($settings['uri_segment']) ? $this->uri->segment($settings['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $settings['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    
    $this->load->view('admin/layout/_default', $settings);
  }

  /*Group Create*/
  public function group_create() {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage Field',
      'content'   =>  'admin/field/group/create',
      'table'     =>  'field_group',
      'action'    => 'admin/field/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'       => $this->input->post('name'),
          'slug'       => url_title(strtolower($this->input->post('name'))),
          'created_by' => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Group Update*/
 public function group_update($id='') {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage Field',
      'content'   =>  'admin/field/group/edit',
      'table'     =>  'field_group',
      'action'    => 'admin/field/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );
    $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'       => $this->input->post('name'),
          'slug'       => url_title(strtolower($this->input->post('name'))),
          'created_by' => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Delete Group*/
  public function group_delete($id='') {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage Field',
      'content'   =>  'admin/field/group/edit',
      'table'     =>  'field_group',
      'action'    => 'admin/field/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
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

/* End of file Field.php */
/* Location: ./application/controllers/admin/Field.php */