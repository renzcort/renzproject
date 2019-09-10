<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct() {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/login_m', 'login_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->session->unset_userdata('logged_in');
  }

  public function index() {
    if ($this->session->userdata('logged_in')) {
      $userdata = $this->session->userdata('logged_in');
      redirect('admin/home','refresh');
    } else {
      $data['content'] = 'template/bootstrap-4/admin/login/login';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
    }
  }

  /**
   * This used to check login when login 
   */
  public function check_login() {
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );

    if ($this->form_validation->run() == TRUE) {
      $email    = $this->input->post('email');
      $password = $this->input->post('password');
      $result   = $this->login_m->check_login($email, $password);
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
      $data['content'] = 'template/bootstrap-4/admin/login/login';
      $this->load->view('template/bootstrap-4/admin/layout/_login', $data);
     }
  }


  /**
   * Register users and validation data
   */
  public function register() {
    $settings = array(
      'title'          =>  'Register',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  FALSE,
      'subbreadcrumb'  =>  FALSE,
      'table'          =>  'users',
      'action'         =>  'admin/validation-token/',
      'content'        =>  'template/bootstrap-4/admin/login/register',
    );

    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[renz_users.username]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('aggreement', 'Accepts Term', 'required');

    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'username'        =>  $this->input->post('username'),
          'email'           =>  $this->input->post('email'),
          'password'        =>  md5($this->input->post('password')),
          'token'           =>  random_string('alnum', 30),
          'activation_code' =>  random_string('numeric', 6),
        );
        email_send($data, TRUE);
        // save log
        $this->general_m->create($settings['table'], $data, TRUE);
        helper_log('register', "register {$data['username']} successfully");
        $this->session->set_flashdata('message', 'data has successfully created');
        redirect("{$settings['action']}?username={$data['username']}&token={$data['token']}","refresh");
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_login', $settings);
    }
  }

  /*public function send_email($data, $register=FALSE) {  
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
  }*/

  /**
   * Validation token after register with code 
   */
  public function validation_token($token='') {  
    $params = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    $settings = array(
      'title'         =>  'Validation Token',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'action'        =>  'admin/validation-token/?'.$params,
      'content'       =>  'template/bootstrap-4/admin/login/activation-code',
    );

    $this->form_validation->set_rules('code', 'Code', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['submit'])) {
        $data['code'] = $this->input->post('code');
        $activated = $this->login_m->activated($data);
        if ($activated) {
          helper_log('add', "Create {$settings['title']} has successfully");
          $this->session->set_flashdata('message', "{$data['code']} has successfully validation");
          redirect('admin/activation-success','refresh');
        } else {
          $this->session->set_flashdata('message', 'Please Correct, your code not valid');
        }
        $this->load->view('template/bootstrap-4/admin/layout/_activate', $settings);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_activate', $settings);
    }    
  }

  /**
   * Activation Token with URL send by email
   */
  public function activated() {
    $params = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    $settings = array(
      'title'         =>  'Activation Code',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'action'        =>  'admin/validation-token/?'.$params,
      'content'       =>  'template/bootstrap-4/admin/login/activated',
    );
    $data['code'] = '';
    $activated = $this->login_m->activated($data);
    if ($activated) {
      helper_log('add', "Create {$settings['title']} has successfully");
      $this->session->set_flashdata('message', "{$data['code']} has successfully validation");
      redirect('admin/activation-success','refresh');
    } else {
      $this->session->set_flashdata('message', 'Please Correct, your code not valid');
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /**
   * Activation Success 
   */
  public function activation_success() {
    $settings = array(
      'title'         =>  'Activation Success',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'content'       =>  'template/bootstrap-4/admin/login/activation-success',
    );
    $this->load->view('template/bootstrap-4/admin/layout/_activate', $settings);
  }

  /**
   * Forgot Password 
   */
  public function forgot_password() {
    $settings = array(
      'title'         =>  'Forgot Password',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'action'        =>  'admin/forgot-password',
      'content'       =>  'template/bootstrap-4/admin/login/forgot-password',
    );

    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['submit'])) {
        $data = array(
          'email'                   => $this->input->post('email'),
          'forgotten_password_code' => random_string('alnum', 30), 
        );
        $forgot_password = $this->login_m->forgot_password($data);
        if ($forgot_password) {
          email_send($forgot_password);  
          helper_log('forgot_password', "Forgoted password {$data['email']} successfully send email");
          $this->session->set_flashdata('message', 'Reset your password send by your email');      
        } else {
          helper_log('forgot-password', "Your Email {$data['email']} invalid");
          $this->session->set_flashdata('message', 'Your email is invalid');
        }
        $this->load->view('template/bootstrap-4/admin/layout/_login', $settings);
      }     
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_login', $settings);
    }
  }

  /*reset password*/
  public function reset_password() {
    $params = $_SERVER['QUERY_STRING'];
    parse_str($params, $data);
    $settings = array(
      'title'         =>  'Reset Password',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'action'        =>  'admin/reset-password/?'.$params,
      'content'       =>  'template/bootstrap-4/admin/login/reset-password',
    );

    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['submit'])) {
        $data['password'] = md5($this->input->post('password'));
        $reset_password   = $this->login_m->reset_password($data, TRUE);
        helper_log('success', "reset password {$data['email']} successfully");
        $this->session->set_flashdata('message', 'Your Password has changes');
        redirect('admin/reset-password-success','refresh');
      }
    } else {
     $this->load->view('template/bootstrap-4/admin/layout/_login', $settings);
    }     
  }

  /**
   * Activation Success 
   */
  public function reset_password_success() {
    $settings = array(
      'title'         =>  'Activation Success',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'users',
      'content'       =>  'template/bootstrap-4/admin/login/reset-password-success',
    );
    $this->load->view('template/bootstrap-4/admin/layout/_activate', $settings);
  }

  /**
   * Logout And Section Destroy
   */
  public function logout(){
    $this->session->unset_userdata('logged_in');
    $this->session->sess_destroy();
    redirect('admin','refresh');
  }
}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */