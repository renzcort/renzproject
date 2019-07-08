<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Globals extends My_Controller {

  public function __construct() {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'userdata' =>  $this->first_load(),
      'parentLink' => 'admin/settings/globals', 
    );
  }

  public function index() {
    $settings = array(
      'title'         =>  'globals',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'globals',
      'action'        =>  'admin/settings/globals',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
      'button'        =>  '+ New Globals',
      'button_link'   =>  'globals/create',
      'content'       =>  'template/bootstrap-4/admin/globals/globals-list',
      'element_name'  =>  FALSE,
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
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*CREATE*/
  public function create() {
    $settings = array(
      'title'          =>  'globals',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'table'          =>  'globals',
      'action'         =>  'admin/settings/globals/create',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'content'        =>  'template/bootstrap-4/admin/globals/globals-form',
      'group_name'     =>  'assets_group',
      'group'          =>  $this->general_m->get_all_results('assets_group'),
      'group_count'    =>  $this->general_m->count_all_results('assets_group'),
      'group_id'       =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'fields_element' =>  'assets_element',
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('assets', 'order'),
    );

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        $data = array(
          'group_id'    => $this->input->post('group'),
          'name'        => ucfirst($this->input->post('name')),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'primary'     => ($this->input->post('primary') ? $this->input->post('primary') : 0),
          'url'         => ($this->input->post('url') ? 1 : 0),
          'baseurl'     => $this->input->post('baseurl'),
          'language'    => $this->input->post('language'),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($this->data['parentLink']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function update($id='') {
    $settings = array(
      'title'         =>  'globals',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'table'         =>  'globals',
      'action'        =>  'admin/settings/globals/edit',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/globals/globals-form',
      'id'            =>  $id,
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'update') {
        $data = array(
          'group_id'    => $this->input->post('group'),
          'name'        => ucfirst($this->input->post('name')),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'primary'     => ($this->input->post('primary') ? $this->input->post('primary') : 0),
          'url'         => ($this->input->post('url') ? 1 : 0),
          'baseurl'     => $this->input->post('baseurl'),
          'language'    => $this->input->post('language'),
          'description' => $this->input->post('description'),
          'updated_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Updated");
        redirect($this->data['parentLink']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function delete($id='') {
    $settings = array(
      'title'  => 'globals',
      'table'  => 'globals',
      'action' => 'admin/settings/globals',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");   
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }
}

/* End of file Globals.php */
/* Location: ./application/controllers/admin/Globals.php */