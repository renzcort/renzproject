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

  public function tester_template(){
    $this->load->view('admin/tester');
  }

  public function pagination(){
    // load db and model
    $this->load->database();
    $this->load->model('tester/Test_m', 'tester_m');

    // init params
    $params = array();
    $limit_per_page = 1;
    $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $total_records = $this->tester_m->get_total();

    if ($total_records > 0) 
    {
        // get current page records
        $params["results"] = $this->tester_m->get_current_page_records($limit_per_page, $start_index);
         
        $config['base_url'] = base_url() . 'test/pagination';
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config["uri_segment"] = 3;
         
        $this->pagination->initialize($config);
         
        // build paging links
        $params["links"] = $this->pagination->create_links();
    }
     
    $this->load->view('tester/pagination', $params);
  }

  public function pagination_custom() {
      // load db and model
      $this->load->database();
      $this->load->model('tester/Test_m', 'tester_m');
   
      // init params
      $params = array();
      $limit_per_page = 1;
      $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
      $total_records = $this->tester_m->get_total();
   
      if ($total_records > 0)
      {
          // get current page records
          $params["results"] = $this->tester_m->get_current_page_records($limit_per_page, $page*$limit_per_page);
               
          $config['base_url'] = base_url() . 'test/pagination_custom';
          $config['total_rows'] = $total_records;
          $config['per_page'] = $limit_per_page;
          $config["uri_segment"] = 3;
           
          // custom paging configuration
          $config['num_links'] = 2;
          $config['use_page_numbers'] = TRUE;
          $config['reuse_query_string'] = TRUE;
           
          $config['full_tag_open'] = '<div class="pagination">';
          $config['full_tag_close'] = '</div>';
           
          $config['first_link'] = 'First Page';
          $config['first_tag_open'] = '<span class="firstlink">';
          $config['first_tag_close'] = '</span>';
           
          $config['last_link'] = 'Last Page';
          $config['last_tag_open'] = '<span class="lastlink">';
          $config['last_tag_close'] = '</span>';
           
          $config['next_link'] = 'Next Page';
          $config['next_tag_open'] = '<span class="nextlink">';
          $config['next_tag_close'] = '</span>';

          $config['prev_link'] = 'Prev Page';
          $config['prev_tag_open'] = '<span class="prevlink">';
          $config['prev_tag_close'] = '</span>';

          $config['cur_tag_open'] = '<span class="curlink">';
          $config['cur_tag_close'] = '</span>';

          $config['num_tag_open'] = '<span class="numlink">';
          $config['num_tag_close'] = '</span>';
           
          $this->pagination->initialize($config);
               
          // build paging links
          $params["links"] = $this->pagination->create_links();
      }
   
      $this->load->view('tester/pagination', $params);
  }

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */