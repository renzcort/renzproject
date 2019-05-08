<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries_m extends My_Model {

  protected $_table = 'entries';
  
    /*count All results*/
  public function count_all_results(){
    return $this->db->count_all_results($this->_table);
  }

  /*Get All Data Records*/
  public function get_all_results($limit = '', $offset = '') {
    ($limit ? $this->db->limit($limit, $offset) : '' );
    $result = $this->db->get($this->_table);
    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return FALSE;
    }
  }

  /*Get Data By Id*/
  public function get_row_by_id($id, $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    $this->db->select("$this->_table.*, b.name as section_name");
    $this->db->join('section as b', "b.id = {$this->_table}.section_id", "LEFT");
    return $this->db->get_where($this->_table, array("{$this->_table}.{$key}" => $id))->row();
  }

  /*Get Result data By ID*/
  public function get_result_by_id($id, $limit = '', $offset = '', $key='') {
    ((!empty($key)) ? $key : $key = 'id');
    ($limit ? $this->db->limit($limit, $offset) : '' );
    return $this->db->get_where($this->_table, array("{$key}" => $id))->result();
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
    $data['updated_at'] = mdate("%Y-%m-%d %H:%i:%s");
    $this->db->trans_start();
    $this->db->where('id', $id);
    $this->db->update($this->_table, $data);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $res = array(
        'message' => 'unable to update',
        'status'  =>  FALSE
      );
    } else {
      $res = array(
        'message' =>  'Updated Successfully',
        'status'  =>  TRUE,
      );
    }
    return $res;
  }

  /*Delete Data By ID*/
  public function delete($id) {
    $this->db->where('id', $id);
    $this->db->delete($this->_table);
    // affected_rows this function use to know number data delete
    return $this->db->affected_rows();
  }
}

/* End of file Field_m.php */
/* Location: ./application/models/admin/Field_m.php */