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

    // check handle
    function check_handle($table, $id, $handle) {
      // get main object ci
      $CI =& get_instance();
      $check_handle   = $CI->general_m->get_row_by_fields($table, array('handle' => $handle));
      if (empty($check_handle)) {
        return TRUE;
      } elseif ($check_handle->id == $id) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    // check title
    function check_title($table, $id, $title) {
      // get main object ci
      $CI =& get_instance();
      $check_title   = $CI->general_m->get_row_by_fields($table, array('title' => $title));
      if (empty($check_title)) {
        return TRUE;
      } elseif ($check_title->id == $id) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    /*Validation Postdate*/
    function check_postdate($data, $post, $expiry) {
      $CI =& get_instance();
      $today      = now();
      $postdate   = strtotime(str_replace('/', '-', $post));
      $expirydate = strtotime(str_replace('/', '-', $expiry));
      if (!empty($data)) {
        if ($today > $postdate) {
          $CI->form_validation->set_message('postdate_check', "Postdate must greater than today");
          return FALSE;
        } elseif (!empty($expirydate) && $postdate > $expirydate) {
          $CI->form_validation->set_message('postdate_check', "Postdate must less then expirydate");
          return FALSE;
        } else {
          return TRUE;
        }
      }
    }

    /*Validation Exprydate*/
    function check_expirydate($data, $post, $expiry) {
      $CI =& get_instance();
      $today      = now();
      $postdate   = strtotime(str_replace('/', '-', $post));
      $expirydate = strtotime(str_replace('/', '-', $expiry));
      if (!empty($data)) {
        if ($today > $expirydate) {
          $CI->form_validation->set_message('expirydate_check', "Expirydate must greater than today");
          return FALSE;
        } elseif (!empty($postdate) && $postdate > $expirydate) {
          $CI->form_validation->set_message('expirydate_check', "Expirydate must greater than postdate");
          return FALSE;
        } else {
          return TRUE;
        }
      }
    }
  }

?>