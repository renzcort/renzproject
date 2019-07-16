<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Globals extends My_Controller {

  public function __construct() {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    
    $globals = $this->general_m->get_all_results('globals');
    $this->firstHandle = ($globals ? $globals[0]->handle : '');
    if ($globals) {
      foreach ($globals as $key) {
        $handle[] = $key->handle;
      }
    }

    if ($this->router->method == 'index') {
      if ($globals) {
        if ((uri_string() == 'admin/globals') || !in_array($this->uri->segment(3), $handle)) {
          redirect("admin/globals/{$this->firstHandle}");
        } 
      } else {
        redirect("admin/settings/globals");
      }
    }

    $this->data = array(
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/settings/globals', 
    );
  }

  public function index($handle){
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('globals', array('handle' => $handle)) : '');
    $settings = array(
      'title'          =>  'globals',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'table'          =>  'globals_content',
      'action'         =>  "admin/globals/{$handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,      
      'content'        =>  'template/bootstrap-4/admin/globals/globals-form',
      'fields_element' =>  'globals_element',
      'element'        =>  $this->general_m->get_result_by_fields('globals_element', array('globals_id' => $params->id)),
      'group_name'     =>  'globals',
      'group'          =>  $this->general_m->get_all_results('globals'),
      'group_count'    =>  $this->general_m->count_all_results('globals'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('globals', 'order'),
      'parent_table'   =>  'globals',
      'parent_id'      =>  $params->id,
      'getDataby_id'   =>  $this->general_m->get_row_by_id('globals_content', $params->id, 'globals_id'),      
    );
    foreach ($settings['element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);    
  }

  public function groups() {
    $settings = array(
      'title'         =>  'globals',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'globals',
      'action'        =>  'admin/settings/globals',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
      'button'        =>  '+ New Globals',
      'button_link'   =>  'globals/create',
      'content'       =>  'template/bootstrap-4/admin/globals/globals-group-list',
    );

    // Pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config["total_rows"] / $config["per_page"];
    $config['uri_segment']  = 3;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*CREATE*/
  public function groups_create() {
    $settings = array(
      'title'          =>  'globals',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'table'          =>  'globals',
      'action'         =>  'admin/settings/globals',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'button_tabs'    =>  TRUE,     
      'content'        =>  'template/bootstrap-4/admin/globals/globals-group-form',
      'fields_element' =>  'globals_element',
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'element'        =>  [],
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('assets', 'order'),
    );

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*UPDATE*/
  public function groups_update($id='') {
    $settings = array(
      'title'          =>  'globals',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('edit'),
      'table'          =>  'globals',
      'action'         =>  'admin/settings/globals',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  'Update',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,     
      'content'        =>  'template/bootstrap-4/admin/globals/globals-group-form',
      'id'             =>  $id,
      'fields_element' =>  'globals_element',
      'element'        =>  $this->general_m->get_result_by_id('globals_element', $id, 'globals_id'),
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('globals', 'order'),
    );

    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
    if ($settings['element']) {
      foreach ($settings['element'] as $key) {
        $fieldsId[] = $key->fields_id; 
      }
      $settings['elementFields'] = $fieldsId;
    } else {
      $settings['elementFields'] = [];
    }

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }  

  /*DELETE*/
  public function groups_delete($id='') {
    $settings = array(
      'title'         => 'globals',
      'table'         => 'globals',
      'action'        => 'admin/settings/globals',
      'table_element' => 'globals_element',
      'table_content' => 'globals_content',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      (($settings['table'] == 'entries') ? $table_content = 'content' : $table_content = "{$settings['table']}_content");
      $element_del = $this->general_m->delete($settings['table_element'], $id, "{$settings['table']}_id");
      $element_del = $this->general_m->delete($table_content, $id, "{$settings['table']}_id");

      // delte content
      $getFieldsAll     = $this->fields_m->get_all_results();
      $getContentFields = $this->db->list_fields($table_content);
      $getElement       = $this->general_m->get_all_results($settings['table_element']);
      if ($getElement) {
        // check fieldsid in element
        foreach ($getElement as $elm) {
          $listFields[] = $elm->fields_id;
        }
        /*Check Delete Column*/
        foreach ($getFieldsAll as $key) {
          if (in_array("fields_{$key->handle}", $getContentFields)) {
            if (! in_array($key->id, array_unique($listFields))) {
              $getFieldsType = $this->general_m->get_row_by_id('fields_type', $key->type_id);
              $fields = array(
                'handle' => $key->handle,
                'type'   => $getFieldsType->type,
              );
              // Drop field column in content
              modifyColumn($fields, 'drop-table', $table_content);
            }
          }
        }
      } else {
        /*Check Delete Column*/
        foreach ($getFieldsAll as $key) {
          if (in_array("fields_{$key->handle}", $getContentFields)) {
            $getFieldsType = $this->general_m->get_row_by_id('fields_type', $key->type_id);
            $fields = array(
              'handle' => $key->handle,
              'type'   => $getFieldsType->type,
            );
            // Drop field column in content
            modifyColumn($fields, 'drop-table', $table_content);
          }
        }
      }
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data {$settings['title']} has successfully");        
      $this->session->set_flashdata("message", "{$settings['title']} has successfully deleted {$delete} record");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }
}

/* End of file Globals.php */
/* Location: ./application/controllers/admin/Globals.php */