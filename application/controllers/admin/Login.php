<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/login_m', 'login_m');
  }

  public function index()
  {
    $data['content'] = 'admin/login';
    $this->load->view('admin/layout/_login', $data);
  }

  public function check_login() {
    $this->form_validation->set_rules('Email', 'email', 'trim|required|xss_clean');
    $this->form_validation->set_rules('Password', 'password', 'trim|required|xss_clean');
    if ($this->form_validation->run() == TRUE) {
      $email    = $this->input->post('email');
      $password = $this->input->post('password');
      $check = $this->login_m->check_login($email, $password);
      var_dump($check);
      die;
    } else {
      var_dump('test');
      die;
    }
  }

}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */