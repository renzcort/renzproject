<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends My_Controller {
  protected $data = [];

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/Field_m', 'field_m');
    $this->load->model('admin/Section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
    //Do your magic here
    $this->data = array(
      'title'    =>  'Entries',
      'userdata' =>  $this->first_load(),
    );
  }

  public function index() {
    $settings = array(
      'title'     =>  'entries',
      'subheader' =>  'Manage entries',
      'content'   =>  'admin/entries/index',
      'table'     =>  'entries',
      'action'    => 'admin/entries',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4),
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->entries_m->count_all_results();
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page']; 
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->entries_m->get_all_results($config['per_page'], $start_offset);
    $settings['content_all']= $this->general_m->get_all_results('content');
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    
    $this->load->view('admin/layout/_default', $settings);        
  }

  /*Create Entries*/
  public function create() {
    $entries_id =  $this->input->get('entries_id');
    $handle     = $this->input->get('handle');
    $settings = array(
      'title'               =>  'entries',
      'subheader'           =>  'Manage entries',
      'content'             =>  'admin/entries/create',
      'table'               =>  'entries',
      'action'              =>  'admin/entries',
      'session'             =>  $this->data,
      'no'                  =>  $this->uri->segment(3),
      'entries_id'          =>  $entries_id,
      'handle'              =>  $handle,
      'elementByEntries_id' =>  $this->general_m->get_row_by_id('element', $entries_id, 'entries_id'),
      'fields'              =>  $this->field_m->get_field_by_element($entries_id),
    );

    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'section_id'  =>  $settings['elementByEntries_id']->section_id,
          'entries_id'  =>  $entries_id,
          'title'       =>  $this->input->post('title'),
          'created_by'  =>  $this->data['userdata']['id'],
        );

        //get field content 
        foreach ($settings['fields'] as $key) {
          $data["field_{$key->handle}"] = $this->input->post("field_{$key->handle}");
        }

        $this->general_m->create('content', $data);
        helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");        
        $this->session->set_flashdata('message', 'Data has created');
        redirect("{$settings['action']}?section_id={$section_id}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }

  /*Create Entries*/
  public function update($id='') {
    $entries_id =  $this->input->get('entries_id');
    $handle     = $this->input->get('handle');
    $settings = array(
      'title'               =>  'entries',
      'subheader'           =>  'Manage entries',
      'content'             =>  'admin/entries/edit',
      'table'               =>  'entries',
      'action'              =>  'admin/entries',
      'session'             =>  $this->data,
      'no'                  =>  $this->uri->segment(3),
      'entries_id'          =>  $entries_id,
      'handle'              =>  $handle,
      'elementByEntries_id' =>  $this->general_m->get_row_by_id('element', $entries_id, 'entries_id'),
      'fields'              =>  $this->field_m->get_field_by_element($entries_id),
      'getdataby_id'        =>  $this->general_m->get_row_by_id('content', $id),
    );
    // var_dump($settings['getdataby_id']);die;

    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'section_id'  =>  $settings['elementByEntries_id']->section_id,
          'entries_id'  =>  $entries_id,
          'title'       =>  $this->input->post('title'),
          'created_by'  =>  $this->data['userdata']['id'],
        );

        //get field content 
        foreach ($settings['fields'] as $key) {
          $data["field_{$key->handle}"] = $this->input->post("field_{$key->handle}");
        }

        $this->general_m->create('content', $data);
        helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");        
        $this->session->set_flashdata('message', 'Data has created');
        redirect("{$settings['action']}?section_id={$section_id}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }
  
}

/* End of file Entries.php */
/* Location: ./application/controllers/admin/Entries.php */ 