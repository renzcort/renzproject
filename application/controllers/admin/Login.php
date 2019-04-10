<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/login_m', 'login_m');
    $this->session->unset_userdata('logged_in');
  }

  public function index() {
    if ($this->session->userdata('logged_in')) {
      $userdata = $this->session->userdata('logged_in');
      redirect('admin/home','refresh');
    } else {
      $data['content'] = 'template/bootstrap-4/admin/login';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
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
      $data['content'] = 'template/bootstrap-4/admin/login';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
     }
  }


  /*register*/
  public function register() {
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
          'token'           =>  random_string('alnum', 30),
          'activation_code' =>  random_string('numeric', 6),
        );
        $this->send_email($data, TRUE);
        // save log
        $this->login_m->create($data);
        helper_log('register', "register {$data['username']} successfully");
        $this->session->set_flashdata('message', 'data has successfully created');
        redirect("admin/validation-token/?username={$data['username']}&token={$data['token']}","refresh");
      } else {
        $this->session->set_flashdata('message', 'Please correct your data');
        $data['content']  = 'template/bootstrap-4/admin/register';
        $this->load->view('template/bootstrap-4/admin/layout/_register', $data);
      }
    } else {
      // $data['content']  = 'admin/register';
      // $this->load->view('admin/layout/_register', $data);
      $data['content']  = 'template/bootstrap-4/admin/register';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
    }
  }

  public function send_email($data, $register=FALSE) {  
    // call congig email
    $email = $this->config->item('setting_email');
    $this->email->initialize($email);
    $this->email->from($email['smtp_user'], 'Rendi');
    $this->email->to($data['email']); 
    // $this->email->cc('renzcort@gmail.com');
    // $this->email->bcc('rendi@maksimaselarasabadi.co.id');
    if ($register == TRUE) {
      $msg = $this->load->view('admin/email-activation-template', $data, TRUE);
      $this->email->subject('Activation Code');
    } else {
      $this->email->subject('Reset Password');
      $msg = $this->load->view('admin/email-forgot-template', $data, TRUE);
    }

    $this->email->message($msg);  
    if ($this->email->send()) {
      helper_log('email', "Send Email {$data['email']} successfully");
      log_message('info', 'Send Email OK');
    } else {
      echo $this->email->print_debugger();
    } 
  }

  /*validation token*/
  public function validation_token($token='') {  
    $params   = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);

    if (isset($_POST['submit'])) {
      $data['code'] = $this->input->post('code');
      // var_dump($data);die;
      $activated = $this->login_m->activated($data);
      if ($activated) {
        $data['content']  = 'template/bootstrap-4/admin/activation-success';
        $this->load->view('template/bootstrap-4/admin/layout/_activate', $data);
      } else {
        $this->session->set_flashdata('message', 'Please Correct, your code not valid');
        $data['params']  = $params;
        $data['content'] = 'template/bootstrap-4/admin/activation-code';
        $this->load->view('template/bootstrap-4/admin/layout/_activate', $data);
      }
    } else {
      $data['params']  = $params;
      $data['content'] = 'template/bootstrap-4/admin/activation-code';
      $this->load->view('template/bootstrap-4/admin/layout/_activate', $data);
    }     
  }

  /*activated*/
  public function activated() {
    $params   = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    $this->login_m->activated($data);
    $data['content']  = 'template/bootstrap-4/admin/activated';
    $this->load->view('template/bootstrap-4/admin/layout/_default', $data);
  }

  /*Forgoted password*/
  public function forgot_password() {
    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['submit'])) {
        $data = array(
          'email'                   => $this->input->post('email'),
          'forgotten_password_code' => random_string('alnum', 30), 
        );
        $forgot_password = $this->login_m->forgot_password($data);
        if ($forgot_password) {
          $this->send_email($forgot_password);  
          helper_log('forgot_password', "Forgoted password {$data['email']} successfully send email");
          $this->session->set_flashdata('message', 'Reset your password send by your email');      
        } else {
          helper_log('forgot-password', "Your Email {$data['email']} invalid");
          $this->session->set_flashdata('message', 'Your email is invalid');
        }
        $data['content'] = 'template/bootstrap-4/admin/forgot-password';
        $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
      }     
    } else {
      $data['content'] = 'template/bootstrap-4/admin/forgot-password';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
    }
  }

  /*reset password*/
  public function reset_password() {
    $params = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
  
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['submit'])) {
        $data['password'] = md5($this->input->post('password'));
        $new_password = $this->login_m->forgot_password($data, TRUE);
        helper_log('success', "reset password {$data['email']} successfully");
        $this->session->set_flashdata('message', 'Your Password has changes');
      }
    }     
    $data['params']  = $params;
    $data['content'] = 'template/bootstrap-4/admin/reset-password';
    $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
  
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