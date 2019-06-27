<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends My_Controller {
  protected $data = [];

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/fields_m', 'fields_m');
    $this->load->model('admin/section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');

    $section = $this->section_m->get_all_results();
    $this->firstHandle = ($section ? $section[0]->handle : '');
    if ($section) {
      foreach ($section as $key) {
        $handle[] = $key->handle;
      }
    }
    //Do your magic here
    if ($this->router->method == 'index') {
      if ($section) {
        if ((uri_string() == 'admin/entries') || !in_array($this->uri->segment(3), $handle)) {
          redirect("admin/entries/{$this->firstHandle}",'refresh');
        } 
      } else {
        redirect("admin/entries/all",'refresh');
      }
    }

    $this->data = array(
      'title'    =>  'Entries',
      'userdata' =>  $this->first_load(),
    );


  }

  public function index($handle) {
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('section', array('handle' => $handle)) : '');
    $settings = array(
      'title'          =>  'entries',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  '+ New Entry',
      'button_link'    =>  "entries/create/{$handle}",
      'content'        =>  'template/bootstrap-4/admin/entries/entries-list',
      'table'          =>  'content',
      'action'         =>  'admin/entries',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'entries_group'  =>  $this->general_m->get_all_results('section_entries'),
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results('content');
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page']; 
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results('content', $config['per_page'], $start_offset, $params->id, 'entries_id');
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*Create Entries*/
  public function create() {
    $settings = array(
      'title'               =>  'entries',
      'subheader'           =>  'Manage entries',
      'content'             =>  'admin/entries/create',
      'table'               =>  'entries',
      'action'              =>  'admin/entries',
      'session'             =>  $this->data,
      'no'                  =>  $this->uri->segment(3),
      'entries_id'          =>  ($this->input->get('entries_id') ? $this->input->get('entries_id') : ''),
      'section_id'          =>  ($this->input->get('section_id') ? $this->input->get('section_id') : ''),
      'handle'              =>  ($this->input->get('handle') ? $this->input->get('handle') : ''),
    );
    $settings['elementByEntries_id'] =  $this->general_m->get_row_by_id('element', $settings['entries_id'], 'entries_id');
    $settings['fields']              =  $this->fields_m->get_field_by_element($settings['entries_id']);

    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'entries_id'  =>  $settings['entries_id'],
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
        redirect("{$settings['action']}/?entries_id={$settings['entries_id']}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }

  /*Create Entries*/
  public function update($id='') {
    $settings = array(
      'title'               =>  'entries',
      'subheader'           =>  'Manage entries',
      'content'             =>  'admin/entries/edit',
      'table'               =>  'entries',
      'action'              =>  'admin/entries',
      'session'             =>  $this->data,
      'no'                  =>  $this->uri->segment(3),
      'entries_id'          =>  ($this->input->get('entries_id') ? $this->input->get('entries_id') : ''),
      'section_id'          =>  ($this->input->get('section_id') ? $this->input->get('section_id') : ''),
      'handle'              =>  ($this->input->get('handle') ? $this->input->get('handle') : ''),
      'getdataby_id'        =>  $this->general_m->get_row_by_id('content', $id),
    );

    $settings['elementByEntries_id'] =  $this->general_m->get_row_by_id('element', $settings['entries_id'], 'entries_id');
    $settings['fields']              =  $this->fields_m->get_field_by_element($settings['entries_id']);
    // var_dump($settings['fields']);die;

    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'entries_id'  =>  $settings['entries_id'],
          'title'       =>  $this->input->post('title'),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        //get field content 
        foreach ($settings['fields'] as $key) {
          $data["field_{$key->handle}"] = $this->input->post("field_{$key->handle}");
        }

        $this->general_m->update('content', $data, $id);
        helper_log('update', "update data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");        
        $this->session->set_flashdata('message', 'Data has created');
        redirect("{$settings['action']}/?entries_id={$settings['entries_id']}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }

  public function delete($id='') {
    $entries_id =  $this->input->get('entries_id');
    $handle     = $this->input->get('handle');
    $settings = array(
      'title'               =>  'entries',
      'subheader'           =>  'Manage entries',
      'content'             =>  'admin/entries/index',
      'table'               =>  'content',
      'action'              =>  'admin/entries',
      'session'             =>  $this->data,
      'no'                  =>  $this->uri->segment(3),
      'entries_id'          =>  $entries_id,
      'handle'              =>  $handle,
      'elementByEntries_id' =>  $this->general_m->get_row_by_id('element', $entries_id, 'entries_id'),
      'fields'              =>  $this->fields_m->get_field_by_element($entries_id),
      'getdataby_id'        =>  $this->general_m->get_row_by_id('content', $id),
    );

    if ($settings['getdataby_id']) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect("{$settings['action']}/?entries_id={$entries_id}");
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect("{$settings['action']}/?entries_id={$entries_id}");
    }
  }
  
}

/* End of file Entries.php */
/* Location: ./application/controllers/admin/Entries.php */ 