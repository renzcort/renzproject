<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/settings/general',
    );
  }

  public function index(){
    $siteurl = $this->general_m->get_row_by_fields('info', $data = array('siteurl' => base_url()));
    $id = ($siteurl ? $siteurl->id : '' );
    $settings = array(
      'title'         =>  'general',
      'subtitle'      =>  'settings',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'info',
      'action'        =>  'admin/settings/general',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'save',
      'button_type'   =>  'submit',
      'button_name'   =>  'save',
      'content'       =>  'template/bootstrap-4/admin/info/general',
      'getDataby_id'  =>  $this->general_m->get_row_by_id('info', $id),
    );

    $this->form_validation->set_rules('systemname', 'Systemname', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'save') {
        $data = array(
          'systemname' => $this->input->post('systemname'),
          'status'     => ($this->input->post('status') ? $this->input->post('status') : 0),
          'timezone'   => $this->input->post('timezone'),
          'siteurl'    => base_url(),
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

/* End of file General.php */
/* Location: ./application/controllers/admin/General.php */