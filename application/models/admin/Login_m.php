<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends My_Model {
  protected $_table = 'users';  

  public function check_login($email, $password) {
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->where('password', md5($password));
    $query = $this->db->get($this->_table);
    if ($query->num_rows() == 1) {
      // Update Last Login
      $result = $query->row_array();
      $this->db->update($this->_table, array('last_login' => mdate("%Y-%m-%d %H:%i:%s")), "id = '{$result['id']}'");
      // end last login
      return $result;
    } else {
      log_message('debug', 'sql query fail in... ', FALSE);
      return FALSE;
    }
  }

  /**
   * This function used to activation code
   */
  public function activated($data) {
    if (empty($data['code'])) {
      $settings = array(
        'username'        => $data['username'],
        'token'           => $data['token'], 
      );
    } else {
      $settings = array(
        'username'        => $data['username'],
        'token'           => $data['token'], 
        'activation_code' => $data['code'],   
      );
    }
    $query = $this->db->get_where($this->_table, $settings);
    if ($query->num_rows() > 0) {
      $result = $query->row();
      $this->db->where('id', $result->id);
      $this->db->update($this->_table, array('activated' => 1));
      return $result;
    } else {
      log_message('debug', 'sql query fail in...', FALSE);
      return FALSE;
    }
  }

  /**
   * This Function Used to Forgoted Password with email
   */
  public function reset_password($data, $reset=FALSE) {
    // check email
    $query = $this->db->get_where($this->_table, array('email' => $data['email']));
    if ($query->num_rows() > 0) {
      $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
      $result = $query->row_array();
      if ($reset) {
        $data['remember_code']  = $result['password'];
        $data['forgotten_password_time'] = intval($result['forgotten_password_time']) + 1;
      }
      // update forgoted token
      $this->db->where('id', $result['id']);
      $this->db->update($this->_table, $data);
      return $result;
    } else {
      return FALSE;
    }
  }
  
}

/* End of file Login_m.php */
/* Location: ./application/models/admin/Login_m.php */