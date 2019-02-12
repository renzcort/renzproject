<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {
  protected $_table = 'users';  

  public function check_login($email, $password)
  {
    /*$query = $this->db->query("SELECT * FROM {$this->db->dbprefix($this->_table)} WHERE email = '{$email}' AND password = md5('{$password}')");
    if ($query->num_rows > 1) {
      $data = $query->row();
      return $data;
    } else {
      return FALSE;
    }*/ 
    $this->db->where('email', $email);
    $this->db->where('password', md5($password));
    $result = $this->db->get($this->db->dbprefix($this->_table));
    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return $this->db->error();
    }
  }

  // register
  public function create($data) 
  {
    $this->db->insert($this->db->dbprefix($this->_table, $data));
  }

  
}

/* End of file Login_m.php */
/* Location: ./application/models/admin/Login_m.php */