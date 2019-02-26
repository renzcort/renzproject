<?php 
 defined('BASEPATH') OR exit('no direct script allowed');

 $config['setting_upload'] = array(
        'upload_path'            => './uploads/',
        'allowed_types'          => 'gif|jpg|png',
        'max_size'               => '',
        'max_width'              => '',
        'max_height'             => '',
        'min_width'              => '',
        'min_height'             => '',
        'file_name'              => '',
        'file_ext_tolower'       => FALSE,
        // 'overwrite'              => FALSE,
        'max_filename'           => '',
        'max_filename_increment' => '',
        'encrypt_name'           => FALSE,
        'remove_spaces'          => TRUE,
        'detect_mime'            => TRUE,
        'mod_mime_fix'           => TRUE, 
 );