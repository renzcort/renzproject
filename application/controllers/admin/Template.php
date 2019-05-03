<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends My_Controller {

  public function index()
  {
    $settings['content'] = 'template/bootstrap-4/admin/section/section-list';
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    // $this->load->view('template/bootstrap-4/layout/_activate', $settings);
  }

}

/* End of file Template.php */
/* Location: ./application/controllers/admin/Template.php */