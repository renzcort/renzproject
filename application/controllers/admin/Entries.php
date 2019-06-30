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
    $this->firstHandle = ($section ? $section[0]->handle : $handle[] = 'all');
    if ($section) {
      foreach ($section as $key) {
        $handle[] = $key->handle;
      }
    }

    //Do your magic here
    if ($this->router->method == 'index') {
      if ((uri_string() == 'admin/entries') || !in_array($this->uri->segment(3), $handle)) {
        redirect("admin/entries/{$this->firstHandle}",'refresh');
      } 
    }

    $this->data = array(
      'title'    =>  'Entries',
      'userdata' =>  $this->first_load(),
    );


  }

  public function index($handle) {
    $params = (($handle == 'all') ? '' : $this->general_m->get_row_by_fields('section', array('handle' => $handle)));
    if ($params) {
      $section_entries = $this->general_m->get_result_by_id('section_entries', $params->id, 'section_id');
      foreach ($section_entries as $key) {
        if ($key->order == '1') {
          $firstEntries = $this->general_m->get_row_by_id('section_entries', $key->id);
        }
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

    if ($params) {
      $record_all = $this->general_m->get_all_results('content', $config['per_page'], $start_offset, $params->id, 'section_id');
    } else {
      $record_all = $this->general_m->get_all_results('content', $config['per_page'], $start_offset);
    }

    $settings['record_all'] = $record_all;
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
      'title'           =>  'entries',
      'subtitle'        =>  'create',
      'breadcrumb'      =>  array('settings'),
      'subbreadcrumb'   =>  array('create'),
      'table'           =>  'content',
      'action'          =>  "admin/entries/{$handle}",
      'session'         =>  $this->data,
      'no'              =>  $this->uri->segment(4),
      'button'          =>  'Save',
      'button_type'     =>  'submit',
      'button_name'     =>  'create',
      'button_tabs'     =>  TRUE,      
      'content'         =>  'template/bootstrap-4/admin/entries/entries-form',
      'section_id'      =>  $params->id,
      'section_entries' =>  $this->general_m->get_all_results('section_entries'),
      'element'         =>  $this->general_m->get_result_by_fields('element', array('entries_id' => $firstEntries->id)),
      'fields'          =>  $this->fields_m->get_all_results(),
      'fields_type'     =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'   =>  $this->general_m->get_all_results('fields_option'),
      'assets'          =>  $this->general_m->get_all_results('assets'),
      'assets_content'  =>  $this->general_m->get_all_results('assets_content'),
      'parent_table'    =>  'section_entries',
    );
    // var_dump($settings['fields']);die;
    foreach ($settings['element'] as $key) {
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
      'title'           =>  'entries',
      'subtitle'        =>  'create',
      'breadcrumb'      =>  array('settings'),
      'subbreadcrumb'   =>  array('create'),
      'table'           =>  'content',
      'action'          =>  "admin/entries/{$handle}",
      'session'         =>  $this->data,
      'no'              =>  $this->uri->segment(4),
      'button'          =>  'update',
      'button_type'     =>  'submit',
      'button_name'     =>  'update',
      'button_tabs'     =>  TRUE,      
      'content'         =>  'template/bootstrap-4/admin/entries/entries-form',
      'section_id'      =>  $params->id,
      'section_entries' =>  $this->general_m->get_all_results('section_entries'),
      'element'         =>  $this->general_m->get_result_by_fields('element', array('entries_id' => $content->entries_id)),
      'fields'          =>  $this->fields_m->get_all_results(),
      'fields_type'     =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'   =>  $this->general_m->get_all_results('fields_option'),
      'assets'          =>  $this->general_m->get_all_results('assets'),
      'assets_content'  =>  $this->general_m->get_all_results('assets_content'),
      'parent_table'    =>  'section_entries',
      'id'              =>  $id,
      'getDataby_id'    =>  $content,    
    );
    foreach ($settings['element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function delete($handle, $id='') {
    $params          = (($handle != '') ? $this->general_m->get_row_by_fields('section', array('handle' => $handle)) : '');
    $section_entries = $this->general_m->get_result_by_id('section_entries', $params->id, 'section_id');
    $content         = $this->general_m->get_row_by_id('content', $id);
    
    $settings = array(
      'title'           =>  'entries',
      'table'           =>  'content',
      'action'          =>  "admin/entries/{$handle}",
      'session'         =>  $this->data,
      'no'              =>  $this->uri->segment(4),
      'getDataby_id'    =>  $content,    
    );

    if ($settings['getDataby_id']) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "delete data {$settings['title']} with {$id} has successfully");
      $this->session->set_flashdata('message', "data has successfully deleted {$delete} records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }
  
}

/* End of file Entries.php */
/* Location: ./application/controllers/admin/Entries.php */ 