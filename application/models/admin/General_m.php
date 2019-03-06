<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_m extends My_Model {

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
    return $this->db->count_all_results($table);
  }

  /*Get All Data Records*/
  public function get_all_results($table, $limit = '', $offset = '', $id='', $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    ((!empty($id)) ? $this->db->where("{$table}.{$key}", $id) : '');
    ($limit ? $this->db->limit($limit, $offset) : '' );
    $result = $this->db->get($table);
    if($result->num_rows() > 0) {
      return $result->result();
    } else {
      return FALSE;
    }
  }

  /*Get Row Data By Id*/
  public function get_row_by_id($table, $id, $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    return $this->db->get_where($table, array("{$key}" => $id))->row();
  }

  /*Get Result data By ID*/
  public function get_result_by_id($table, $id, $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    return $this->db->get_where($table, array("{$key}" => $id))->result();
  }

  /*Insert All Records*/
  public function create($table, $data, $flag_date=TRUE) {
    if ($flag_date) {
      // set created and updated
      $data['created_at'] = mdate("%Y-%m-%d %H:%i:%s");
      $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
    }
    
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  } 

  /*Update Data By ID*/
  public function update($table, $data, $id, $key='', $flag_date=TRUE) {
    ((!empty($key)) ? $key : $key = 'id');
    if ($flag_date) {
      // set created and updated
      $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
    }

    $this->db->where("{$key}", $id);
    $this->db->update($table, $data);
  }

  /*Delete Data By ID*/
  public function delete($table, $id, $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    // var_dump($key, $id);die;
    $this->db->where("{$key}", $id);
    $this->db->delete($table);
    // affected_rows this function use to know number data delete
    return $this->db->affected_rows();
  }

}

/* End of file General_m.php */
/* Location: ./application/models/admin/General_m.php */