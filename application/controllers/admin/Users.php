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
      'title'     => 'Users',
      'subheader' => 'Manage Users',
      'content'   => 'admin/users/index',
      'table'     => 'users',
      'action'    => 'admin/users',
      'session'   => $this->data,
      'no'        =>  $this->uri->segment(4),
    );
   // pagination
    $config = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 3;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    // var_dump($settings['table']);die;
    $settings['record_all'] = $this->users_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    //end pagination
    // var_dump($settings['record_all']);die;
    $this->load->view('admin/layout/_default', $settings);
  }

  /*Create Users*/
  public function create() {
    $settings = array(
      'title'       => 'Users',
      'subheader'   => 'create',
      'content'     =>  'admin/users/create',
      'table'       =>  'users',
      'action'      =>  'admin/users',
      'role'        =>  $this->general_m->get_all_results('users_role'),
      'group'       =>  $this->general_m->get_all_results('usersgroup'),
      'session'     =>  $this->data,
      'upload_path' => 'uploads/'.$this->data['title'],
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
        $data = array(
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

        // uppload photo
        if (!empty($_FILES['photo'])) {
          $config = $this->config->item('setting_upload');
          $config['upload_path'] = $settings['upload_path'];
          $config['file_name']   = $data['username'];
          if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
          } 
          $this->upload->initialize($config);
          if ( ! $this->upload->do_upload('photo')){
            $error = array('error' => $this->upload->display_errors());
          }
          else{
            $result = array('upload_data' => $this->upload->data());
            $data['photo'] =  $config['file_name'].$result['upload_data']['file_ext'];
            // $data['photo'] =  $result['upload_data']['file_name'];
          }
        }
        // end upload

        $users = $this->users_m->create($data);
        $usersgroup = $this->input->post('usersgroup');
        if (!empty($usersgroup)) {
          $this->general_m->delete('usersgroup_users', $users, 'users_id');
          foreach ($usersgroup as $key => $value) {
            $data = array(
              'users_id'   =>  $users,
              'group_id'   =>  $value,
              'created_by' => $this->data['userdata']['id'], 
            );
            $this->general_m->create('usersgroup_users', $data, FALSE);
          }
        }
        helper_log('add', 'add '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Update Users*/
  public function update($id = '') {
    $settings = array(
      'title'        => 'Users',
      'subheader'    => 'edit',
      'content'      => 'admin/users/edit',
      'table'        => 'users',
      'action'       => 'admin/users',
      'role'         => $this->general_m->get_all_results('users_role'),
      'group'        => $this->general_m->get_all_results('usersgroup'),
      'usersgroup'   => $this->general_m->get_result_by_id('usersgroup_users', $id, 'users_id'),
      'getdataby_id' => $this->users_m->get_row_by_id($id),
      'session'      => $this->data,
      'upload_path'  => 'uploads/'.$this->data['title'],
    );
    if ($settings['usersgroup']) {
      foreach ($settings['usersgroup'] as $key => $value) {
        $settings['group_checked'][] = $value->group_id;
      }
    } else {
        $settings['group_checked'][] = '';
    }

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
        $data = array(
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

        // upload photo
        if (!empty($_FILES['photo'])) {
          $config                = $this->config->item('setting_upload');
          $config['upload_path'] = $settings['upload_path'];
          $config['file_name']   = $data['username'];
          if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
          }
          $this->upload->initialize($config);
          if ( ! $this->upload->do_upload('photo')){
            $error = array('error' => $this->upload->display_errors());
          }
          else{
            $result = array('upload_data' => $this->upload->data());
            $data['photo'] =  $config['file_name'].$result['upload_data']['file_ext'];
            // $data['photo'] =  $result['upload_data']['file_name'];
          }
        }

        $this->users_m->update($data, $id);
        $usersgroup = $this->input->post('usersgroup');
        $this->general_m->delete('usersgroup_users', $id, 'users_id');
        foreach ($usersgroup as $key => $value) {
          $data = array(
            'users_id'   =>  $id,
            'group_id'   =>  $value,
            'created_by' => $this->data['userdata']['id'], 
          );
          $this->general_m->create('usersgroup_users', $data, FALSE);
        }
        helper_log('update', 'update '.(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] ).' successfully');
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*callback validation*/
  public function check_username($id = '') {
    $id           = $this->input->post('id');
    $username     = $this->input->post('username');
    $getdataby_id = $this->users_m->get_row_by_id($id);
    if ($this->users_m->check_username($username)) {
      if ($username == $getdataby_id->username) {
        return TRUE;
      } else {
        $this->form_validation->set_message('check_username', 'The Username fields must contain a unique value.');
        return FALSE;
      }
    } else {
      return TRUE;
    }
  } 

  public function check_email($id = '') {
    $id           = $this->input->post('id');
    $email        = $this->input->post('email');
    $getdataby_id = $this->users_m->get_row_by_id($id);
    if ($this->users_m->check_email($email)) {
      if ($email == $getdataby_id->email) {
        return TRUE;
      } else {
        $this->form_validation->set_message('check_email', 'The Email fields must contain a unique value.');
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
      'table'        => 'users',
      'action'       => 'admin/users',
      'role'         => $this->general_m->get_all_results('users_role'),
      'getdataby_id' => $this->users_m->get_row_by_id($id),
      'session'      => $this->data,
      'path'         => './uploads/',
      'checklist'    => $this->input->post('checklist'),
    );

    var_dump($settings['checklist']);die();
    
    if ($settings['getdataby_id']) {
      if ($settings['getdataby_id']->photo) {
        unlink($settings['path'].$settings['getdataby_id']->photo);
      }
      // delete usersgroup
      $this->general_m->delete('usersgroup_users', $id, 'users_id');
      $delete = $this->users_m->delete($id);
      // delete files upload
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
      'action'    =>  'admin/users/role',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4),
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 2;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    //end pagination

    $this->load->view('admin/layout/_default', $settings);
  }
  
  /*Create Add Users Role*/
  public function role_create() {
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'create',
      'content'   =>  'admin/users/role/create',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role',
      'session'   =>  $this->data,
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'        => $this->input->post('name'),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );  
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('admin/layout/_default', $settings);      
    }
  }

  /*Update Users Role*/
  public function role_update($id = ''){
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'edit',
      'content'   =>  'admin/users/role/edit',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role',
      'session'   =>  $this->data,
    );
    $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'           =>  $this->input->post('name'),
          'description'    =>  $this->input->post('description'),
          'created_by'     =>  $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  public function role_delete($id = '') {
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'edit',
      'table'     =>  'users_role',
      'action'    =>  'admin/users/role',
      'session'   =>  $this->data,
    );
    if ($this->general_m->get_row_by_id($settings['table'], $id)) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

  /*GROUP*/
  public function group() {
    $settings = array(
      'header'    =>  'Group',
      'subheader' =>  'Manage Users',
      'content'   =>  'admin/users/group/index',
      'table'     =>  'usersgroup',
      'action'    =>  'admin/users/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4),
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page'];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('admin/layout/_default', $settings);
  }

  /*Create Group*/ 
  public function group_create() {
    $settings = array(
      'header'    =>  'Group',
      'subheader' =>  'create',
      'content'   =>  'admin/users/group/create',
      'table'     =>  'usersgroup',
      'action'    =>  'admin/users/group',
      'session'   =>  $this->data,
    );
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'        =>  $this->input->post('name'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Update Groups*/
  public function group_update($id = '') {
    $settings = array(
      'header'    =>  'Group',
      'subheader' =>  'edit',
      'content'   =>  'admin/users/group/edit',
      'table'     =>  'usersgroup',
      'action'    =>  'admin/users/group',
      'session'   =>  $this->data,
    );
    $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'        =>  $this->input->post('name'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Delete Group*/
  public function group_delete($id = '') {
    $settings = array(
      'header'    =>  'Role',
      'subheader' =>  'edit',
      'table'     =>  'usersgroup',
      'action'    =>  'admin/users/group',
      'session'   =>  $this->data,
    );
    if ($this->general_m->get_row_by_id($settings['table'], $id)) {
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