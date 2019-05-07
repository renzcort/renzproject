<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/fields_m', 'fields_m');
    //Do your magic here
    $this->data = array(
      'userdata'  =>  $this->first_load(),
      'parentLink' => 'admin/fields', 
    );
  }

  public function fields($id='') {
    $settings = array(
      'title'     => 'Group Fields',
      'table'     => 'fields_group',
      'action'    => 'admin/fields',
      'session'   =>  $this->data,
      'id'        =>  $this->input->post('id')
    );
    if ($settings['id']) { 
      $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $settings['id']);
    }

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      $data = array(
        'name'        => $this->input->post('name'),
        'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
        'slug'        => url_title(strtolower($this->input->post('name'))),
        'description' => $this->input->post('description'),
      );
      if (isset($_POST['create'])) {

        $data['created_by'] = $this->data['userdata']['id'];
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
      
      } elseif (isset($_POST['update'])) {
      
        $data['updated_by'] = $this->data['userdata']['id'];
        $this->general_m->update($settings['table'], $data, $settings['id']);
        helper_log('update', "update ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
      }
      redirect($settings['action']);
    } else {
      if (isset($_POST['delete'])) {
        $delete = $this->general_m->delete($settings['table'], $id);
        helper_log('delete', "Delete data ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
        $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
        redirect($settings['action']);
      }
    }
  }

}

/* End of file Groups.php */
/* Location: ./application/controllers/admin/Groups.php */