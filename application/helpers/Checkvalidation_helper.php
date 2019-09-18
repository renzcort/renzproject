<?php 
  defined('BASEPATH') OR exit('No dirext script access allowed');

  if (!function_exists('checkName')) {

    function check_email($table, $id, $email) {
      // get main object ci
      $CI =& get_instance();
      $check_email = $CI->general_m->get_row_by_fields($table, array('email' => $email));

      if (empty($check_email)) {
        return TRUE;
      } elseif ($check_email->id == $id) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    function check_username($table, $id, $username) {
      // get main object ci
      $CI =& get_instance();
      $check_username = $CI->general_m->get_row_by_fields($table, array('username' => $username));

      if (empty($check_username)) {
        return TRUE;
      } elseif ($check_username->id == $id) {
        return TRUE;
      } else {
        $CI->form_validation->set_message('check_username', "Username has exists");
        return FALSE;
      }
    }

    function check_name($table, $id, $name) {
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

    /*Check validation in children title from content*/
    function check_title_child($table, $parent_id, $id, $child) {
      $CI =& get_instance();
      $check_title = $CI->general_m->get_row_by_fields($table, $child);
      if (empty($check_title)) {
        return TRUE; 
      } else {
        if ($check_title->id == $id) {
          return TRUE;
        } else {
          $CI->form_validation->set_message('title_child_check', "The Title field must contain a unique value.");
          return FALSE;
        }
      }
    }
  }

?>