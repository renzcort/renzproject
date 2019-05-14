<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    //    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'userdata' =>  $this->first_load(),
      'parentLink' => 'admin/email', 
    );
  }

  public function index()
  {
    $settings = array(
      'title'         =>  'email',
      'subtitle'      =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'save',
      'content'       =>  'template/bootstrap-4/admin/info/email',
      'table'         =>  'info',
      'action'        =>  'admin/email',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
    );
    $getLastRecord = $this->general_m->get_last_records($settings['table'], 'id');
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $getLastRecord->id);

    if (isset($_POST['save'])) {
      $data = array(
        'email'            => $this->input->post('email'),
        'email_sendername' => $this->input->post('email_sendername'),
        'email_template'   => $this->input->post('email_template'),
        'email_type'       => $this->input->post('email_type'),
        'email_status'     => $this->input->post('email_status'),
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

/* End of file Email.php */
/* Location: ./application/controllers/admin/Email.php */