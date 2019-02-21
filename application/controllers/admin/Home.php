<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
  }

  public function index()
  {
    $userdata = $this->first_load();
    $config = array(
      'content'  => 'admin/home',
      // 'title'    =>  'Dashboard',
      'header'   =>  'Home',
      'subtitle' =>  'Control Panel,'
    );
    $data = array_merge($config, $userdata);
    $this->load->view('admin/layout/_default', $data);
  }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */