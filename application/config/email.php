<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  /*$config['protocol'] = 'sendmail';
  $config['mailpath'] = '/usr/sbin/sendmail';
  $config['charset']  = 'iso-8859-1';
  $config['wordwrap'] = TRUE;*/

  /*$config['protocol']    = 'smtp';
  $config['smtp_host']    = 'ssl://smtp.gmail.com';
  $config['smtp_port']    = '465';
  $config['smtp_timeout'] = '7';
  $config['smtp_user']    = 'renzcoding@gmail.com';
  $config['smtp_pass']    = 'Kepompong1';
  $config['charset']    = 'utf-8';
  $config['newline']    = "\r\n";
  $config['mailtype'] = 'text'; // or html
  $config['validation'] = TRUE; // bool whether to validate email or not      
  // $this->email->initialize($config);*/
  
  $config['setting_email'] = array(
      'protocol'     => 'smtp',
      'smtp_host'    => 'ssl://smtp.gmail.com',
      'smtp_port'    => '465',
      'smtp_timeout' => '7',
      'smtp_user'    => 'renzcoding@gmail.com',
      'smtp_pass'    => 'Kepompong1',
      'charset'      => 'utf-8',
      'newline'      => "\r\n",
      'mailtype'     => 'text', // or html
      'validation'   => TRUE, // bool whether to validate email or not      
  );