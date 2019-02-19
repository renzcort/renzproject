<?php 
  
  function helper_log($type = "", $str = "") {
   $CI =& get_instance();

    if (strtolower($type) == 'login') 
    {
      $type = 1;
    } 
    elseif (strtolower($type) == 'logout') 
    {
      $type = 2;
    } 
    elseif (strtolower($type) == 'add') 
    {
      $type = 3;
    } 
    elseif (strtolower($type) == 'edit') 
    {
      $type = 4;
    } 
    elseif (strtolower($type) == 'register') 
    {
      $type = 5;
    } 
    elseif (strtolower($type) == 'email') 
    {
      $type = 6;
    } 
    elseif (strtolower($type) == 'forgot-password') 
    {
      $type = 7;
    } 
    elseif (strtolower($type) == 'Success') 
    {
      $type = 10;
    } 
    elseif (strtolower($type) == 'failed') 
    {
      $type = 11;
    } 
    else 
    {
      $type = 0;
    }

    // parameter
    $logged_in = $CI->session->userdata('logged_in');
    $param['username']  = ($logged_in ? $logged_in->username : NULL );
    $param['type']  = $type;
    $param['desc']  = $str;
    $param['query'] = $CI->db->last_query();

    // load model log
    $CI->load->model('Log_m');

    // save to database
    $CI->Log_m->save($param);
  }
