<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->dbforge();
    $this->load->database();
  }

}

/* End of file My_Model.php */
/* Location: ./application/core/My_Model.php */