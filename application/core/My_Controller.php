<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/General_m', 'general_m');

    //Do your magic here
    if ($this->session->userdata('logged_in')) {
      $this->first_load();
    } else {
      redirect('admin','refresh');
    }
  }

  public function first_load()
  {
    return $this->session->userdata('logged_in');
  }

  public function sidebar_activated(){
    $activated = array(
      'section'    => $this->general_m->count_all_results('section'),
      'globals'    => $this->general_m->count_all_results('globals'),
      'categories' => $this->general_m->count_all_results('categories'),
      'assets'     => $this->general_m->count_all_results('assets'),
      'usersgroup' => $this->general_m->count_all_results('usersgroup'),
    );
    return $activated;
  }

}

/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */