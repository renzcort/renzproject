<?php 
  
  function helper_log($type = "", $str = "") {
   $CI =& get_instance();

   if (strtolower($type) == 'login') {
      $type = 0;
    } elseif (strtolower($type) == 'logout') {
      $type = 1;
    } elseif (strtolower($type) == 'add') {
      $type = 2;
    } elseif (strtolower($type) == 'edit') {
      $type = 3;
    } else {
      $type = 4;
    }

    // parameter
    $logged_in = $CI->session->userdata('logged_in');
    $param['username']  = $logged_in->username;
    $param['type']  = $type;
    $param['desc']  = $str;
    $param['query'] = $CI->db->last_query();

    // load model log
    $CI->load->model('Log_m');

    // save to database
    $CI->Log_m->save($param);
  }
