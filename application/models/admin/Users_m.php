<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_m extends CI_Model {
  protected $_table = 'users';
  protected $_role  = 'users_role';
  protected $_group = 'users_group';
  
  /**
   * ================================
   * Mange Users Role
   * ================================
   */
  /*cOUNT aLL rECORD rOLE*/
  public function count_all_record_users_role($table) {
    return $this->db->count_all_results($this->db->dbprefix($table));
  }

  /*Get All Record */
  public function all_record_users_role($table) {

  }

}

/* End of file Users_m.php */
/* Location: ./application/models/admin/Users_m.php */