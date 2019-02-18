<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/login_m', 'login_m');
    $this->session->unset_userdata('logged_in');
  }

  public function index()
  {
    if ($this->session->userdata('logged_in')) {
      $userdata = $this->session->userdata('logged_in');
      redirect('admin/home','refresh');
    } else {
      $data['content'] = 'admin/login';
      $this->load->view('admin/layout/_login', $data);
    }
  }

  public function check_login() {
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );

    if ($this->form_validation->run() == TRUE) {
      $email   = $this->input->post('email');
      $password= $this->input->post('password');
      $result  = $this->login_m->check_login($email, $password);
      if ($result) {
        $this->session->set_userdata('logged_in', $result);
        $this->session->set_flashdata('message', 'Welcome to your dashboard');
        helper_log('login', "login {$email} successfully");
        redirect('admin/home','refresh');
      } else {  
        $this->session->set_flashdata('message', 'Invalid Username and Password');
        redirect('admin', 'refresh');
      }
    } else {
      $data['content'] = 'admin/login';
      $this->load->view('admin/layout/_login', $data);
     }
  }


  /*register*/
  public function register()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('accept_terms', 'Accepts Term', 'required');

    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'username'        =>  $this->input->post('username'),
          'email'           =>  $this->input->post('email'),
          'password'        =>  md5($this->input->post('password')),
          'created_at'      => mdate("%Y-%m-%d %H:%i:%s"), 
          'updated_at'      => mdate("%Y-%m-%d %H:%i:%s"), 
          'activation_code' =>  random_string('alnum', 30),
        );
        $this->send_email($data);
        $this->login_m->create($data);
        $this->session->set_flashdata('message', 'data has successfully created');
        redirect("admin/validation-token/?username={$data['username']}&token={$data['activation_code']}","refresh");
      } else {
        $this->session->set_flashdata('message', 'Please correct your data');
        $data['content']  = 'admin/register';
        $this->load->view('admin/layout/_register', $data);
      }
    } else {
      $data['content']  = 'admin/register';
      $this->load->view('admin/layout/_register', $data);
    }
  }

  public function send_email($data)
  {    
    // call congig email
    $email = $this->config->item('setting_email');
    $this->email->initialize($email);
    $this->email->from($email['smtp_user'], 'Rendi');
    $this->email->to($data['email']); 
    // $this->email->cc('renzcort@gmail.com');
    // $this->email->bcc('rendi@maksimaselarasabadi.co.id');
    $msg = $this->load->view('admin/partial/email-template', $data, TRUE);

    $this->email->subject('Email Test');
    $this->email->message($msg);  
    if ($this->email->send()) {
      log_message('info', 'Send Email OK');
    } else {
      echo $this->email->print_debugger();
    } 
  }

  /*validation token*/
  public function validation_token($token='') {  
    $params   = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    
  }

  /*Logout*/
  public function logout()
  {
    $this->session->unset_userdata('logged_in');
    $this->session->sess_destroy();
    redirect('admin','refresh');
  }
}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */