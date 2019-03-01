<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_m extends My_Model {
  protected $_table = 'users';

    /**
   * [count_all_results description]
   * @param  [type] $table [description]
   * @return [type]        [description]
   * ===================================
   * Manage Users
   * ===================================
   */

  /*count All results*/
  public function count_all_results(){
    return $this->db->count_all_results($this->_table);
  }

  /*Get All Data Records*/
  public function get_all_results($limit = '', $offset = '') {
    ($limit ? $this->db->limit($limit, $offset) : '' );
    $this->db->select("{$this->_table}.*, users_role.name");
    $this->db->join("users_role", "users_role.id = {$this->_table}.role_id");
    $result = $this->db->get($this->_table);
    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return FALSE;
    }
  }

  /*Get Data By Id*/
  public function get_row_by_id($id) {
    return $this->db->get_where($this->_table, array('id' => $id))->row();
  }

  /*Insert All Records*/
  public function create($data) {
    // set created and updated
    $data['created_at'] = mdate("%Y-%m-%d %H:%i:%s");
    $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
    
    $this->db->insert($this->_table, $data);
    return $this->db->insert_id();
  } 

  /*Update Data By ID*/
  public function update($data, $id) {
    $this->db->where('id', $id);
    $this->db->update($this->_table, $data);
  }

  /*Delete Data By ID*/
  public function delete($id) {
    $this->db->where('id', $id);
    $this->db->delete($this->_table);
    // affected_rows this function use to know number data delete
    return $this->db->affected_rows();
  }

  /*Get data by Email*/
  public function check_email($email) {
    return $this->db->get_where($this->_table, array('email' => $email))->row();
  }

  /*Get data by Username*/
  public function check_username($username) {
    return $this->db->get_where($this->_table, array('username' => $username))->row();
  }

}

/* End of file Users_m.php */
/* Location: ./application/models/admin/Users_m.php */