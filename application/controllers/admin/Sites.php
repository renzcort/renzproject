<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends My_Controller {

 public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->data = array(
      'userdata' =>  $this->first_load(),
      'parentLink' => 'admin/sites', 
    );
  }

  public function index() {
    $settings = array(
      'title'         =>  'sites',
      'subtitle'      =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'button'        =>  '+ New sites',
      'button_link'   =>  'sites/create',
      'content'       =>  'template/bootstrap-4/admin/sites/sites-list',
      'table'         =>  'sites',
      'action'        =>  'admin/sites',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'group_name'    =>  'sites_group',
      'group'         =>  $this->general_m->get_all_results('sites_group'),
      'group_count'   =>  $this->general_m->count_all_results('sites_group'),
      'group_id'      =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
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
  public function create() {

    $settings = array(
      'title'         =>  'sites',
      'subtitle'      =>  'create',
      'subbreadcrumb' =>  FALSE,
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'button_tabs'   =>  TRUE,
      'content'       =>  'template/bootstrap-4/admin/sites/sites-form',
      'table'         =>  'sites',
      'action'        =>  'admin/sites',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
    );

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'group_id'   => $this->input->post('group_id'),
          'name'       => $this->input->post('name'),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type'       => $this->input->post('type'),
          'path'       => $this->input->post('path'),
          'url'        => $this->input->post('url'),
          'parent'     => $this->input->post('parent'),
          'order'      => $this->input->post('order'),
          'description'=> $this->input->post('description'),
          'created_by' => $this->data['userdata']['id'],
        );
        $tableFieldsId = $this->general_m->create($settings['table'], $data);
        helper_log('add', "add data {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        if (!empty($fieldsId)) {
          $i = 0;
          (isset($id) ? $id = $tableFieldsId : $id = $id);
          $this->general_m->delete($settings['fields_table'], $id);
          foreach ($fieldsId as $value) {
            $element = array(
              'sites_id'   =>  $id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
            $this->general_m->create('sites_element', $element, FALSE);
          }
          helper_log('add', "add element create has successfully {$element['order']} record");
          $this->session->set_flashdata("message", "Entries has successfully Create");
        }        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Create");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function update($id='') {
    $settings = array(
      'title'         =>  'sites',
      'subtitle'      =>  'update',
      'subbreadcrumb' =>  FALSE,
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'button_tabs'   =>  TRUE,
      'content'       =>  'template/bootstrap-4/admin/sites/sites-form',
      'table'         =>  'sites',
      'action'        =>  'admin/sites',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'fields_table'  =>  'sites_element',
      'sites_type'   =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
      'fields_group'  =>  $this->general_m->get_all_results('fields_group'),
      'fields'        =>  $this->fields_m->get_all_results(),
      'elementFields' =>  [],
      'order'         =>  $this->general_m->get_max_fields('sites', 'order'),
    );
    $settings['element']      = $this->general_m->get_result_by_id($settings['fields_table'], $id, "{$settings['table']}_id");
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
    
    if ($settings['element']) {
      foreach ($settings['element'] as $key) {
        $fieldsId[] = $key->fields_id; 
      }
      $settings['elementFields'] = $fieldsId;
    } else {
      $settings['elementFields'] = [];
    }
    
    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'group_id'   => $this->input->post('group_id'),
          'name'       => $this->input->post('name'),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type'       => $this->input->post('type'),
          'path'       => $this->input->post('path'),
          'url'        => $this->input->post('url'),
          'parent'     => $this->input->post('parent'),
          'order'      => $this->input->post('order'),
          'description'=> $this->input->post('description'),
          'updated_by' => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('edit', "Update data {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        if (!empty($fieldsId)) {
          $i = 0;
          (isset($id) ? $id = $tableFieldsId : $id = $id);
          $this->general_m->delete($settings['fields_table'], $id);
          foreach ($fieldsId as $value) {
            $element = array(
              'sites_id'   =>  $id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
            $this->general_m->create('sites_element', $element, FALSE);
          }
          helper_log('add', "add element create has successfully {$element['order']} record");
          $this->session->set_flashdata("message", "Entries has successfully Create");
        }        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Updated");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function delete($id='') {
    $settings = array(
      'title'        => 'sites',
      'table'        =>  'sites',
      'action'       => 'admin/sites',
      'fields_table' => 'sites_element',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $element_del = $this->general_m->delete($settings['fields_table'], $id, "{$settings['table']}_id");
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data {$settings['title']} has successfully");        
      $this->session->set_flashdata("message", "{$settings['title']} has successfully Deleted {$delete} Record");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

}

/* End of file Sites.php */
/* Location: ./application/controllers/admin/Sites.php */