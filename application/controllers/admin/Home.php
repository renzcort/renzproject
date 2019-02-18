<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function index()
  {
    $logged_in = $this->session->userdata('logged_in');
    $data['content'] = 'admin/home';
    $this->load->view('admin/layout/_default', $data);
  }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */