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
    $section_entries = $this->general_m->get_result_by_id('section_entries', $params->id, 'section_id');
    foreach ($section_entries as $key) {
      if ($key->order == '1') {
        $firstEntries = $this->general_m->get_row_by_id('section_entries', $key->id);
      }
    }
    $settings = array(
      'title'          =>  'entries',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  '+ New Entry',
      'button_link'    =>  "{$handle}/create",
      'content'        =>  'template/bootstrap-4/admin/entries/entries-list',
      'table'          =>  'content',
      'action'         =>  'admin/entries',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'section'        =>  $this->section_m->get_all_results(),
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
    $settings['record_all'] = $this->general_m->get_all_results('content', $config['per_page'], $start_offset, $params->id, 'section_id');
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*Create Entries*/
  public function create($handle) {
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('section', array('handle' => $handle)) : '');
    $section_entries = $this->general_m->get_result_by_id('section_entries', $params->id, 'section_id');
    foreach ($section_entries as $key) {
      if ($key->order == '1') {
        $firstEntries = $this->general_m->get_row_by_id('section_entries', $key->id);
      }
    }

    $settings = array(
      'title'          =>  'entries',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'button_tabs'    =>  TRUE,      
      'content'        =>  'template/bootstrap-4/admin/entries/entries-form',
      'table'          =>  'content',
      'action'         =>  "admin/entries/{$handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'section_id'     =>  $params->id,
      'section_entries'=>  $this->general_m->get_all_results('section_entries'),
      'fields_element' =>  $this->general_m->get_result_by_fields('element', array('entries_id' => $firstEntries->id)),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('section', 'order'),
      'parent_table'   =>  'section_entries',
      'parent_id'      =>  $firstEntries->id,
    );
    // var_dump($settings['fields']);die;
    foreach ($settings['fields_element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
        
  }

  /*Create Entries*/
  public function update($handle, $id='') {
    $params          = (($handle != '') ? $this->general_m->get_row_by_fields('section', array('handle' => $handle)) : '');
    $section_entries = $this->general_m->get_result_by_id('section_entries', $params->id, 'section_id');
    $content         = $this->general_m->get_row_by_id('content', $id);
    
    $settings = array(
      'title'          =>  'entries',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'button'         =>  'update',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,      
      'content'        =>  'template/bootstrap-4/admin/entries/entries-form',
      'table'          =>  'content',
      'action'         =>  "admin/entries/{$handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'section_id'     =>  $params->id,
      'section_entries'=>  $this->general_m->get_all_results('section_entries'),
      'fields_element' =>  $this->general_m->get_result_by_fields('element', array('entries_id' => $content->entries_id)),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('section', 'order'),
      'parent_table'   =>  'section_entries',
      'parent_id'      =>  $content->entries_id,
      'id'             =>  $id,
      'getDataby_id'   =>  $content,    
    );
    // var_dump($settings['fields']);die;
    foreach ($settings['fields_element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
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