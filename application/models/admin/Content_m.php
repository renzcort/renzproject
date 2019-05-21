<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_m extends My_Model {

  protected $_table = 'content';

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }
  
  /*Add Column*/
  public function add_column($column) {
    $this->dbforge->add_column($this->_table, $column);
    helper_log("add", 'add column successfully');
  }

  /*Modify Column*/
  public function modify_column($column) {
    $this->dbforge->modify_column($this->_table, $column);
    helper_log("update", 'update column successfully');
  }

  /*Drop Column*/
  public function drop_column($column) {
    $this->dbforge->drop_column($this->_table, $column);
    helper_log("delete", 'Drop column successfully');
  }

    /*Add Column*/
  public function add_column_table($table, $column) {
    $this->dbforge->add_column($table, $column);
    helper_log("add", 'add column successfully');
  }

  /*Modify Column*/
  public function modify_column_table($table, $column) {
    $this->dbforge->modify_column($table, $column);
    helper_log("update", 'update column successfully');
  }

  /*Drop Column*/
  public function drop_column_table($table, $column) {
    $this->dbforge->drop_column($table, $column);
    helper_log("delete", 'Drop column successfully');
  }

}

/* End of file Content_m.php */
/* Location: ./application/models/admin/Content_m.php */