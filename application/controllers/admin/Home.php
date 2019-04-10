<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->data = array(
      'title' =>  'Home',
      'userdata'  =>  $this->first_load(),
    );//Do your magic here
  }

  public function index() {
     $settings = array(
      'title'     =>  'Home',
      'subtitle'  =>  array('field'),
      'header'    =>  'Home',
      'button'    =>  '+ New',
      'content'   =>  'template/bootstrap-4/admin/dashboard',
      'session'   =>  $this->data,
    );
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */