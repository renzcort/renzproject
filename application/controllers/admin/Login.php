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
    if ($this->session->userdata('logged')) {
    } else {
      $data['content'] = 'admin/login';
      $this->load->view('admin/layout/_login', $data);
    }
  }

  public function check_login() {

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );

    if ($this->form_validation->run() == TRUE) {
      $email    = $this->input->post('email');
      $password = $this->input->post('password');
      $check = $this->login_m->check_login($email, $password);
    } else {
      $data['content'] = 'admin/login';
      $this->load->view('admin/layout/_login', $data);
     }
  }

}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */