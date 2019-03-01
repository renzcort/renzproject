<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_m extends My_Model {

  protected $_table = 'info';

  /*Get Last ID*/
  public function get_last_id() {
    return $this->db->order_by('id', 'DESC')->limit(1)->get($this->_table)->row();
  }

}

/* End of file Info_m.php */
/* Location: ./application/models/admin/Info_m.php */