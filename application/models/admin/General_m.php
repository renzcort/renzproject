<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_m extends CI_Model {

  /**
   * [count_all_results description]
   * @param  [type] $table [description]
   * @return [type]        [description]
   * ===================================
   * Manage Global Setting Models
   * ===================================
   */

  /*count All results*/
  public function count_all_results($table){
    return $this->db->count_all_results($this->db->dbprefix($table));
  }

  /*Get All Data Records*/
  public function get_all_results($table, $limit = '', $offset = '') {
    if ($limit) {
      $this->db->limit($limit, $offset);
    }
    $result = $this->db->get($this->db->dbprefix($table));
    if($result->num_rows() > 0) {
      return $result->result();
    } else {
      return FALSE;
    }
  }

  /*Get Row Data By Id*/
  public function get_row_by_id($table, $id, $key = '') {
    if ($key) {
      $key = $key;
    } else {
      $key = 'id';
    }
    return $this->db->get_where($this->db->dbprefix($table), array("{$key}" => $id))->row();
  }

  /*Get Result data By ID*/
  public function get_result_by_id($table, $id, $key = '') {
    if ($key) {
      $key = $key;
    } else {
      $key = 'id';
    }
    return $this->db->get_where($this->db->dbprefix($table), array("{$key}" => $id))->result();
  }

  /*Insert All Records*/
  public function create($table, $data) {
    // set created and updated
    $data['created_at'] = mdate("%Y-%m-%d %H:%i:%s");
    $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
    
    $this->db->insert($this->db->dbprefix($table), $data);
  } 

  /*Update Data By ID*/
  public function update($table, $data, $id) {
    $this->db->where('id', $id);
    $this->db->update($this->db->dbprefix($table), $data);
  }

  /*Delete Data By ID*/
  public function delete($table, $id) {
    $this->db->where('id', $id);
    $this->db->delete($this->db->dbprefix($table));
    // affected_rows this function use to know number data delete
    return $this->db->affected_rows();
  }



}

/* End of file General_m.php */
/* Location: ./application/models/admin/General_m.php */