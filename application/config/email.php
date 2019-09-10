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
  $config['smtp_user']    = '';
  $config['smtp_pass']    = '';
  $config['charset']    = 'utf-8';
  $config['newline']    = "\r\n";
  $config['mailtype'] = 'text'; // or html
  $config['validation'] = TRUE; // bool whether to validate email or not      
  // $this->email->initialize($config);*/

  // $config['setting_email'] = array(
  //   'useragent'      => 'Codeigniter', 
  //   'protocol'       => 'smtp',
  //   'mailpath'       => 'mail',
  //   'smtp_host'      => 'ssl://smtp.gmail.com',
  //   'smtp_user'      => '',
  //   'smtp_pass'      => '',
  //   'smtp_port'      => 465,
  //   'smtp_timeout'   => 5,
  //   'smtp_keepalive' => FALSE,
  //   'smtp_crypto'    => 'ssl',
  //   'wordwrap'       => TRUE,
  //   'wrapchars'      => 76,
  //   'mailtype'       => 'html',
  //   'charset'        => "$config['charset']",
  //   'validate'       => FALSE,
  //   'priority'       => 3
  //   'crlf'           => "\n",
  //   'newline'        => "\n",
  //   'bcc_batch_mode' => FALSE, //Enable BCC Batch Mode.
  //   'bcc_batch_size' => 200,
  //   'dsn'            => FALSE
  // );

  
  $config['setting_email'] = array(
    'protocol'     => 'smtp',
    'smtp_host'    => 'ssl://smtp.gmail.com',
    'smtp_port'    => '465',
    'smtp_timeout' => '7',
    'smtp_user'    => 'renzcoding@gmail.com',
    'smtp_pass'    => 'Kepompong1',
    'charset'      => 'utf-8',
    'newline'      => "\r\n",
    'mailtype'     => 'html', // or html
    'validation'   => TRUE, // bool whether to validate email or not      
  );