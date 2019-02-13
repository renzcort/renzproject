<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {
  protected $_table = 'users';  

  public function check_login($email, $password)
  {
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->where('password', md5($password));
    $row = $this->db->get($this->db->dbprefix($this->_table));
    if ($row->num_rows() == 1) {
      /**
       * Update Last Login
       * @var [type]
       */
      $result = $row->row();
      $this->db->update($this->db->dbprefix($this->_table), array('last_login' => mdate("%Y-%m-%d %H:%i:%s")), "id = '{$result->id}'");
      return $result;
    } else {
      return false;
    }
  }

  // register
  public function create($data) 
  {
    $this->db->insert($this->db->dbprefix($this->_table), $data);
  }

  
}

/* End of file Login_m.php */
/* Location: ./application/models/admin/Login_m.php */