<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

  public function index()
  {
    /*$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[10]|is_unique[renz_users.username]',
      array(
        'required'  =>  'You Have Not provided %s.',
        'is_unique' =>  'This is Already exists.'
      )
    );*/
    // $this->form_validation->set_rules('username', 'Username', 'callback_username_check');
    $this->form_validation->set_rules('username', 'Username', 
      array(
        'required', 
        array(
          'username_callable',
          function($str)
          {
            if ($str == 'test') {
              $this->form_validation->set_message('username_check', 'the {field} field can not be the word "Test"');
              return FALSE;
            } else {
              return TRUE;
            }
          }
        )
      )
    );
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.'))
    ;
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');

    if ($this->form_validation->run() == TRUE) {
      $this->load->view('tester/form-success');
    } else {
      $this->load->view('tester/form');
    }
  }

  public function username_check($str)
  {
    if ($str == 'test') {
      $this->form_validation->set_message('username_check', 'the {field} field can not be the word "Test"');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function test_composer()
  {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->setFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Hello World');
    $pdf->output();
  }

  public function test_log(){
    $some_var = "";
    if ($some_var == "") {
      log_message('error', 'Some variable did not contain a value.');
    }
    else {
      log_message('debug', 'Some variable was correctly set');
    }

    log_message('info', 'The purpose of some variable is to provide some value.');
    log_message('error', 'error message in this line');

    log_message('debug', 'debug message in this line');

    log_message('info', 'info message in this line');
  }

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */