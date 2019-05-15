<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    //    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'userdata' =>  $this->first_load(),
      'parentLink' => 'admin/general', 
    );
  }

  public function index()
  {
    $settings = array(
      'title'         =>  'general',
      'subtitle'      =>  'Settings',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'save',
      'content'       =>  'template/bootstrap-4/admin/info/general',
      'table'         =>  'info',
      'action'        =>  'admin/general',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
    );
    $getLastRecord = $this->general_m->get_last_records($settings['table'], 'id');
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $getLastRecord->id);

    if (isset($_POST['save'])) {
      $data = array(
        'systemname' => $this->input->post('systemname'),
        'status'     => $this->input->post('status'),
        'timezone'   => $this->input->post('timezone'),
      );
      $checkRecord = $this->general_m->count_all_results($settings['table']);
      if ($checkRecord == 0) {
        $data['created_by'] = $this->data['userdata']['id'];
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add data {$settings['title']} has successfully");        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Created");
        redirect($this->data['parentLink']);
      } else {
        $data['updated_by'] = $this->data['userdata']['id'];
        $this->general_m->update($settings['table'], $data, $getLastRecord->id);
        helper_log('edit', "Update data {$settings['title']} has successfully");        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Updated");
        redirect($this->data['parentLink']);
      }
    }    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

}

/* End of file General.php */
/* Location: ./application/controllers/admin/General.php */