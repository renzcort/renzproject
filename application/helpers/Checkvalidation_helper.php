<?php 
  defined('BASEPATH') OR exit('No dirext script access allowed');

  if (!function_exists('checkName')) {
    function check_Name($table, $id, $name) {
      // get main object ci
      $CI =& get_instance();
      $check_name   = $CI->general_m->get_row_by_fields($table, array('name' => $name));
      if (empty($check_name)) {
        return TRUE;
      } elseif ($check_name->id == $id) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }

?>