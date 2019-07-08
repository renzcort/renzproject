<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends My_Controller {
  
  public $data = [];

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Info_m', 'info_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'title'             => 'Info',
      'userdata'          => $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
    );
  }

  public function update($id = ''){
    $settings = array(
      'title'        =>  'Info',
      'subheader'    =>  'Manage Info',
      'content'      =>  'admin/info/edit',
      'table'        =>  'info',
      'action'       =>  'admin/info',
      'session'      =>  $this->data['userdata'],
      'no'           =>  $this->uri->segment(3),
      'getdataby_id' =>  $this->info_m->get_last_id(),
      'upload_path'  =>  'uploads/'.$this->data['title'],
    );
    // var_dump($settings['getdataby_id']->siteName);die;
    $this->form_validation->set_rules('sitename', 'Site Name', 'trim|required');
    $this->form_validation->set_rules('siteurl', 'Site URL', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'sitename'  =>  $this->input->post('sitename'),
          'siteurl'   =>  $this->input->post('siteurl'),
          'timezone'  =>  $this->input->post('timezone'),
          'created_by'  =>  $this->data['userdata']['id'],
        );

        if (!is_dir($settings['upload_path'])) {
          mkdir($settings['upload_path'], 0777, TRUE);
        } 
        // Upload Icon
        if (!empty($_FILES['siteicon'])) {
          $config                = $this->config->item('setting_upload');
          $config['upload_path'] = $settings['upload_path'];
          $config['file_name']   = url_title(strtolower($settings['title'].' siteicon'));
          $this->upload->initialize($config);
          if ( ! $this->upload->do_upload('siteicon')){
            $error = array('error' => $this->upload->display_errors());
          }
          else{
            $result = array('upload_data' => $this->upload->data());
            $data['siteicon'] =  $config['file_name'].$result['upload_data']['file_ext'];
          }
        }

        // upload Logo
        if (!empty($_FILES['sitelogo'])) {
          $config                = $this->config->item('setting_upload');
          $config['upload_path'] = $settings['upload_path'];
          $config['file_name']   = url_title(strtolower($settings['title'].' sitelogo'));
          $this->upload->initialize($config);
          if ( ! $this->upload->do_upload('sitelogo')){
            $error = array('error' => $this->upload->display_errors());
          }
          else{
            $result = array('upload_data' => $this->upload->data());
            $data['sitelogo'] =  $config['file_name'].$result['upload_data']['file_ext'];
          }
        }
        
        // check info exist row
        if ($settings['getdataby_id']) {
          $data['updated_by'] = $this->data['userdata']['id'];
          $this->general_m->update($settings['table'], $data, $settings['getdataby_id']->id);
        } else {
          $this->general_m->create($settings['table'], $data);
        }
        redirect('admin/info');
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }

  }

}

/* End of file Info.php */
/* Location: ./application/controllers/admin/Info.php */