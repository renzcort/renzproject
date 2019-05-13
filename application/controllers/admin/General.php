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
      'parentLink' => 'admin/categories', 
    );
  }

  public function index()
  {
    $settings = array(
      'title'         =>  'general',
      'subtitle'      =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/general',
      'table'         =>  'general',
      'action'        =>  'admin/general',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
    );

    $data = array(
      'systemname' => $this->input->post('systemname'),
      'status'     => $this->input->post('status'),
      'timezone'   => $this->input->post('timezone'),
    );
    
    $checkRecord = $this->general_m->count_all_results($settings['table']);
    if ($checkRecord == 0) {
      $data['created_by'] = $this->data['userdata']['id'];
      $this->general_m->create($settings['table'], $data);
    } else {
      $id = 1;
      $data['updated_by'] = $this->data['userdata']['id'];
      $this->general_m->update($settings['table'], $data, $id);
    }
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

}

/* End of file General.php */
/* Location: ./application/controllers/admin/General.php */