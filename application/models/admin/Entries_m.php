<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries_m extends My_Model {

  protected $_table = 'content';
  
  /*get result for single type entries*/
  public function get_result_data_singles($limit='', $offset=''){
    ($limit ? $this->db->limit($limit, $offset) : '' );
    $this->db->select("{$this->_table}.*, b.name as section_name");
    $this->db->join("section as b", "b.id = {$this->_table}.section_id", "LEFT");
    $this->db->where("b.type_id", '5');
    $result = $this->db->get($this->_table);
    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return FALSE;
    }
  }
}

/* End of file Field_m.php */
/* Location: ./application/models/admin/Field_m.php */