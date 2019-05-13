<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends My_Controller {
  
  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->data = array(
      'userdata'  =>  $this->first_load(),
    );
  }

  public function index()
  {
    $settings = array(
      'title'         =>  'settings',
      'subtitle'      =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'button'        =>  '+ New Categories',
      'button_link'   =>  'categories/create',
      'content'       =>  'template/bootstrap-4/admin/settings',
      'table'         =>  '',
      'action'        =>  '',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
    );
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

}

/* End of file Settings.php */
/* Location: ./application/Controllers/admin/Settings.php */