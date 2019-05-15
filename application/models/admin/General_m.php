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

  // get row data by fields
  public function get_row_by_fields($table, $data) {
    return $this->db->get_where($table, $data)->row();
  }

  // get result by fields
  public function get_result_by_fields($table, $data) {
    return $this->db->get_where($table, $data)->result();
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
    $this->db->trans_start();
    $this->db->where("{$key}", $id);
    $this->db->update($table, $data);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  /*Delete Data By ID*/
  public function delete($table, $id, $key='') {
    ((!empty($key)) ? $key : $key = 'id');

    $this->db->where("{$key}", $id);
    $this->db->delete($table);
    // affected_rows this function use to know number data delete
    return $this->db->affected_rows();
  }

  /*Get Max order*/
  public function get_max_fields($table, $field) {
    $this->db->select_max($field);
    $result = $this->db->get($table);
    if($result->num_rows() > 0) {
      $max = $result->row();
      return $max->order+1;
    } else {
      return FALSE;
    }
  }

  /*GET LAST Records*/
  public function get_last_records($table, $fields) {
    return $this->db->order_by($fields, 'desc')->limit(1)->get($table)->row();
    print_r($this->db->last_query());
  }

}

/* End of file General_m.php */
/* Location: ./application/models/admin/General_m.php */