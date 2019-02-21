<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    if ($this->session->userdata('logged_in')) {
      $this->first_load();
    } else {
      redirect('admin','refresh');
    }
  }

  public function first_load()
  {
    return $this->session->userdata('logged_in');
  }

}

/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */