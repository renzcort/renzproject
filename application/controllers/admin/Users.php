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

  /*Get All Users*/
  public function index() {
    $settings = array(
      'title'      =>  'Users',
      'subheader'  =>  'Manage Users',
      'content'    =>  'admin/users/index',
      'table'      =>  'users',
      'action'     =>  'admin/users'
    );

   // pagination
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 1;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 3;
    $config['num_links']    = round($num_pages);
    $pagination             = array_merge($config, $this->config->item('setting_pagination'));
    $this->pagination->initialize($pagination);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment'])-1 : 0);
    // var_dump($start_offset);die();
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    //end pagination
    
    $data = array_merge($settings, $this->data);
    $this->load->view('admin/layout/_default', $data);
  }

  /*Create Users*/
  public function create() {
    $settings = array(
      'title'     => 'Users',
      'subheader' => 'create',
      'content'   =>  'admin/users/create',
      'table'     =>  'users',
      'action'    =>  'admin/users',
      'role'      =>  $this->general_m->get_all_results('users_role')
    );
    
    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|is_unique[renz_users.username]');
    $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
    $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('role', 'Role', 'trim|required');
    $this->form_validation->set_rules('accept_terms', 'Accepts Term', 'required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $config = array(
          'username'   =>  $this->input->post('username'),
          'firstname'  =>  $this->input->post('firstname'),
          'lastname'   =>  $this->input->post('lastnaame'),
          'email'      =>  $this->input->post('email'),
          'password'   =>  md5($this->input->post('password')),
          'role_id'    =>  $this->input->post('role'),
          'created_by' =>  $this->data['userdata']['id'],
          'created_at' =>  mdate("%Y-%m-%d %H:%i:%s"), 
          'updated_at' =>  mdate("%Y-%m-%d %H:%i:%s"), 
        );
        $this->users_m->create($config);
        helper_log('add', 'add '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $data = array_merge($settings, $this->data);
      $this->load->view('admin/layout/_default', $data);
    }
  }

  /*Update Users*/
  public function update($id = '') {
    $settings = array(
      'title'        => 'Users',
      'subheader'    => 'edit',
      'content'      =>  'admin/users/edit',
      'table'        =>  'users',
      'action'       =>  'admin/users',
      'role'         =>  $this->general_m->get_all_results('users_role'),
      'getdataby_id' =>  $this->users_m->get_data_by_id($id),
    );
    
    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|callback_check_username');
    $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
    $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]', 
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('role', 'Role', 'trim|required');
    $this->form_validation->set_rules('accept_terms', 'Accepts Term', 'required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $config = array(
          'username'   =>  $this->input->post('username'),
          'firstname'  =>  $this->input->post('firstname'),
          'lastname'   =>  $this->input->post('lastname'),
          'email'      =>  $this->input->post('email'),
          'password'   =>  md5($this->input->post('password')),
          'role_id'    =>  $this->input->post('role'),
          'created_by' =>  $this->data['userdata']['id'],
          'created_at' =>  mdate("%Y-%m-%d %H:%i:%s"), 
          'updated_at' =>  mdate("%Y-%m-%d %H:%i:%s"), 
        );
        $this->users_m->update($config, $id);
        helper_log('update', 'update '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $data = array_merge($settings, $this->data);
      $this->load->view('admin/layout/_default', $data);
    }
  }

  /*callback validation*/
  public function check_username($id = '') {
    $id           = $this->input->post('id');
    $username     = $this->input->post('username');
    $getdataby_id = $this->users_m->get_data_by_id($id);
    if ($this->users_m->check_username($username)) {
      if ($username == $getdataby_id->username) {
        return TRUE;
      } else {
        $this->form_validation->set_message('check_username', 'The Username field must contain a unique value.');
        return FALSE;
      }
    } else {
      return TRUE;
    }
  } 

  public function check_email($id = '') {
    $id           = $this->input->post('id');
    $email        = $this->input->post('email');
    $getdataby_id = $this->users_m->get_data_by_id($id);
    if ($this->users_m->check_email($email)) {
      if ($email == $getdataby_id->email) {
        return TRUE;
      } else {
        $this->form_validation->set_message('check_email', 'The Email field must contain a unique value.');
        return FALSE;
      }
    } else {
      return TRUE;
    }
  }

  /*Delete users*/
  public function delete($id = '') {
    $settings = array(
      'title'        => 'Users',
      'subheader'    => 'delete',
      'table'        =>  'users',
      'action'       =>  'admin/users',
      'role'         =>  $this->general_m->get_all_results('users_role'),
      'getdataby_id' =>  $this->users_m->get_data_by_id($id),
    );
    
    if ($settings['getdataby_id']) {
      $delete = $this->users_m->delete($id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

  /**
   * ======================================
   * MANAGE ROLE
   * ======================================
   */
  public function role(){
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'Manage Users',
      'content'   =>  'admin/users/role/index',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role'
    );

    // pagination
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 1;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $pagination             = array_merge($config, $this->config->item('setting_pagination'));
    $this->pagination->initialize($pagination);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    //end pagination

    $data = array_merge($settings, $this->data);
    $this->load->view('admin/layout/_default', $data);
  }
  
  /*Create Add Users Role*/
  public function role_create() {
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'create',
      'content'   =>  'admin/users/role/create',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role'
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $config = array(
          'name'        => $this->input->post('name'),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );  
        $this->general_m->create($settings['table'], $config);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $data = array_merge($settings, $this->data);
      $this->load->view('admin/layout/_default', $data);      
    }
  }

  /*Update Users Role*/
  public function role_update($id = ''){
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'edit',
      'content'   =>  'admin/users/role/edit',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role'
    );
    $settings['getdataby_id'] =  $this->general_m->get_data_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
    // var_dump($settings['getdataby_id']);die;
        $config = array(
          'name'           =>  $this->input->post('name'),
          'description'    =>  $this->input->post('description'),
          'created_by'     =>  $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $config, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $data = array_merge($settings, $this->data);
      $this->load->view('admin/layout/_default', $data);
    }
  }

  public function role_delete($id = '') {
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'edit',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role'
    );
    if ($this->general_m->get_data_by_id($settings['table'], $id)) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

}



/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */