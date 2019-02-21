<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {
  public $data = [];

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Users_m', 'users_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'title'    => 'Users',
      'userdata' =>  $this->first_load(),
    );
  }

  public function index()
  {
    
  }

  /**
   * ======================================
   * MANAGE ROLE
   * ======================================
   */
  public function role(){
    $settings = array(
      'header'     =>  'Role',
      'subheader'  =>  'Manage Users',
      'content'    =>  'admin/users/role/index',
      'table'      =>  'users_role',
    );
    $settings['record_all'] = $this->general_m->get_all_results($settings['table']);

    // pagination
    $config['base_url']        = base_url('admin/users/role/');
    $config['total_rows']      = $this->general_m->count_all_results($settings['table']);
    $config['per_page']        = 10;
    $config['uri_segment']     = 3;
    $config['num_links']       = 3;
    $config['full_tag_open']   = '<p>';
    $config['full_tag_close']  = '</p>';
    $config['first_link']      = 'First';
    $config['first_tag_open']  = '<div>';
    $config['first_tag_close'] = '</div>';
    $config['last_link']       = 'Last';
    $config['last_tag_open']   = '<div>';
    $config['last_tag_close']  = '</div>';
    $config['next_link']       = '&gt;';
    $config['next_tag_open']   = '<div>';
    $config['next_tag_close']  = '</div>';
    $config['prev_link']       = '&lt;';
    $config['prev_tag_open']   = '<div>';
    $config['prev_tag_close']  = '</div>';
    $config['cur_tag_open']    = '<b>';
    $config['cur_tag_close']   = '</b>';
    $this->pagination->initialize($config);
    //end pagination    
    
    $data = array_merge($settings, $this->data);
    $this->load->view('admin/layout/_default', $data);
  }
  
  /*Create Add Users Role*/
  public function role_create() {
    $settings = array(
      'header'     =>  'Role',
      'subheader'  =>  'Create',
      'content'    =>  'admin/users/role/create',
      'table'      =>  'users_role',
    );

    if (isset($_POST['create'])) {
      $this->form_validation->set_rules('name', 'Name', 'trim|required');
      if ($this->form_validation->run() == TRUE) {
        $config = array(
          'name'        => $this->input->post('name'),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['id'],
        );  
        $this->general_m->create($settings['table'], $config);
        helper_log('add', "add users role successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect('admin/users/role','refresh');
      } 
    } else {
      $data = array_merge($settings, $this->data);
      $this->load->view('admin/layout/_default', $data);      
    }
  }

}



/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */