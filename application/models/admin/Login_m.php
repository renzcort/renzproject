<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {
  protected $TABLE = 'renz_users';  

  public function check_login($email, $password)
  {
    var_dump('tesss');
    die;
    $query = '$this->db->get($TABLE)';
    return $query;
  }
}

/* End of file Login_m.php */
/* Location: ./application/models/admin/Login_m.php */