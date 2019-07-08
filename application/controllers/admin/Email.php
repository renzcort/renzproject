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
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/settings/email', 
    );
  }

  public function index() {
    $siteurl = $this->general_m->get_row_by_fields('info', $data = array('siteurl' => base_url()));
    $id = ($siteurl ? $siteurl->id : '' );
    $settings = array(
      'title'         =>  'email',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'info',
      'action'        =>  'admin/settings/email',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'save',
      'content'       =>  'template/bootstrap-4/admin/info/email',
      'getDataby_id'  =>  $this->general_m->get_row_by_id('info', $id),
    );

    $this->form_validation->set_rules('email', 'email', 'trim|required');
    $this->form_validation->set_rules('email_sendername', 'email_sendername', 'trim|required');
    $this->form_validation->set_rules('email_template', 'email_template', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'save') {
        $data = array(
          'email'            => $this->input->post('email'),
          'email_sendername' => $this->input->post('email_sendername'),
          'email_template'   => $this->input->post('email_template'),
          'email_type'       => $this->input->post('email_type'),
          'email_status'     => $this->input->post('email_status'),
        );
        if ($settings['getDataby_id']) {
          $data['updated_by'] = $this->data['userdata']['id'];
          $this->general_m->update($settings['table'], $data, $id);
          helper_log('edit', "Update data {$settings['title']} has successfully");        
          $this->session->set_flashdata("message", "{$settings['title']} has successfully updated");
          redirect($this->data['parentLink']);
        } else {
          $data['created_by'] = $this->data['userdata']['id'];
          $this->general_m->create($settings['table'], $data);
          helper_log('add', "Create {$settings['title']} has successfully");
          $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
          redirect($this->data['parentLink']);
        }
      }    
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }
}

/* End of file Email.php */
/* Location: ./application/controllers/admin/Email.php */