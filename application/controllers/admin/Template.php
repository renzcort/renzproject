<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends My_Controller {

  public function index()
  {
    $settings['content'] = 'template/bootstrap-4/activation-success';
    $this->load->view('template/bootstrap-4/layout/_activate', $settings);
    // $this->load->view('template/bootstrap-4/login');
  }

}

/* End of file Template.php */
/* Location: ./application/controllers/admin/Template.php */