<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_m extends CI_Model {

	public function get_current_page_records($limit, $start) {
      $this->db->limit($limit, $start);
      $query = $this->db->get("users");
      if ($query->num_rows() > 0) 
      {
          foreach ($query->result() as $row) 
          {
              $data[] = $row;
          }
          return $data;
      }
      return false;
    }
     
    public function get_total() 
    {
        return $this->db->count_all("users");
    }
}

/* End of file Test_m.php */
/* Location: ./application/models/tester/Test_m.php */