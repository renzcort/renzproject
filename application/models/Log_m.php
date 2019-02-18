<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_m extends CI_Model {
  protected $_table = 'log';
  
  public function save($param) {
    $sql =  $this->db->insert_string($this->db->dbprefix($this->_table), $param);
    $ex  =  $this->db->query($sql);
    return $this->db->affected_rows($sql);
  }
  

}

/* End of file Log_m.php */
/* Location: ./application/models/Log_m.php */