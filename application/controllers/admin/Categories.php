<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends My_Controller {
  var $handle = [];

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');

    $cat = $this->general_m->get_all_results('categories');
    $this->firstHandle = ($cat ? $cat[0]->handle : '');

    if ($cat) {
      foreach ($cat as $key) {
        $handle[] = $key->handle;
      }
    }

    $this->data = array(
      'userdata'   =>  $this->first_load(),
      'parentLink' => 'admin/categories',
    );

    if ($this->router->method == 'index') {
      if ($cat) {
        if ((uri_string() == 'admin/categories') || !in_array($this->uri->segment(3), $handle)) {
          redirect("admin/categories/{$this->firstHandle}",'refresh');
        } 
      } else {
        redirect("admin/settings/categories",'refresh');
      }
    }
  }
/*
  function _remap($method, $args) { 
    $args = $this->handle;
    if (method_exists($this, $method)){
       $this->$method($args);
    } else {
        $this->index($method, $args);
    }
  }*/
  
  // public function _remap($method, $params)
  // {
  //   $params = $this->handle;
  //   if ($method == 'index') {
  //     $this->index($params);
  //   }
  // }

  public function index($handle){
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('categories', array('handle' => $handle)) : '');
    $settings = array(
      'title'          =>  'categories',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  '+ New Categories',
      'button_link'    =>  "create/{$params->handle}",
      'content'        =>  'template/bootstrap-4/admin/categories/categories-list',
      'table'          =>  'categories_content',
      'action'         =>  'admin/categories',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'group_name'    =>  'categories',
      'fields_element' => 'categories_element',
      'group'          =>  $this->general_m->get_all_results('categories'),
      'group_count'    =>  $this->general_m->count_all_results('categories'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('categories', 'order'),
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
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, $params->id, 'categories_id');
    $settings['links']      = $this->pagination->create_links();
    // end Pagination

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);    
  }


  public function create($handle) {
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('categories', array('handle' => $handle)) : '');
    $settings = array(
      'title'          =>  'categories',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'button_tabs'    =>  TRUE,      
      'content'        =>  'template/bootstrap-4/admin/categories/categories-form',
      'table'          =>  'categories_content',
      'action'         =>  "admin/categories/{$params->handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'group_name'     =>  'categories',
      'fields_element' =>  $this->general_m->get_result_by_fields('categories_element', array('categories_id' => $params->id)),
      'group'          =>  $this->general_m->get_all_results('categories'),
      'group_count'    =>  $this->general_m->count_all_results('categories'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('categories', 'order'),
      'parent_table'   =>  'categories',
      'parent_id'      =>  $params->id          
    );
    // var_dump($settings['fields']);die;
    foreach ($settings['fields_element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function update($handle, $id) {
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('categories', array('handle' => $handle)) : '');
    $settings = array(
      'title'          =>  'categories',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  'update',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,      
      'content'        =>  'template/bootstrap-4/admin/categories/categories-form',
      'table'          =>  'categories_content',
      'action'         =>  "admin/categories/{$params->handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'group_name'     =>  'categories',
      'fields_element' =>  $this->general_m->get_result_by_fields('categories_element', array('categories_id' => $params->id)),
      'group'          =>  $this->general_m->get_all_results('categories'),
      'group_count'    =>  $this->general_m->count_all_results('categories'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('categories', 'order'),
      'parent_table'   =>  'categories',
      'parent_id'      =>  $params->id,
      'id'             =>  $id,
      'getDataby_id'   =>  $this->general_m->get_row_by_id('categories_content', $id),          
    );

    foreach ($settings['fields_element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function delete($handle, $id) {
    $params = (($handle != '') ? $this->general_m->get_row_by_fields('categories', array('handle' => $handle)) : '');
    $settings = array(
      'title'         => 'Categories',
      'table'         => 'categories_content',
      'action'        => "admin/categories/{$params}",
      'parent_table'   => 'categories',
      'parent_id'      =>  $params->id,
      'id'             =>  $id,
      'getDataby_id'   =>  $this->general_m->get_row_by_id('categories_content', $id),          
    );

    foreach ($settings['fields_element'] as $key) {
      $settings['fields_id'][] = $key->fields_id;
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }


  public function groups() {
    $settings = array(
      'title'         =>  'categories',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'button'        =>  '+ New Categories',
      'button_link'   =>  'categories/create',
      'content'       =>  'template/bootstrap-4/admin/categories/categories-group-list',
      'table'         =>  'categories',
      'action'        =>  'admin/settings/categories',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'fields_element'  =>  'categories_element',
      'fields_group'  =>  $this->general_m->get_all_results('fields_group'),
      'fields'        =>  $this->fields_m->get_all_results(),
      'elementFields' =>  [],
      'order'         =>  $this->general_m->get_max_fields('categories', 'order'),
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
      'title'         =>  'categories',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'button'        =>  'Create',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'button_tabs'   =>  TRUE,
      'content'       =>  'template/bootstrap-4/admin/categories/categories-group-form',
      'table'         =>  'categories',
      'action'        =>  'admin/settings/categories',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'fields_element'=>  'categories_element',
      'fields_group'  =>  $this->general_m->get_all_results('fields_group'),
      'fields'        =>  $this->fields_m->get_all_results(),
      'elementFields' =>  [],
      'order'         =>  $this->general_m->get_max_fields('categories', 'order'),
    );

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        (empty($this->input->post('locale-es')) ? $locale = $this->input->post('locale-id') : $locale = $this->input->post('locale-es'));
        (empty($this->input->post('parent-es')) ? $parent = $this->input->post('parent-id') : $parent = $this->input->post('parent-es'));
        $data = array(
          'name'       => ucfirst($this->input->post('name')),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'url'        => $this->input->post('url'),
          'template'   => $this->input->post('template'),
          'locale'     => $locale,
          'parent'     => $parent,
          'maxlevel'   => $this->input->post('maxlevel'),
          'description'=> $this->input->post('description'),
          'created_by' => $this->data['userdata']['id'],
        );
        $tableFieldsId = $this->general_m->create($settings['table'], $data);
        helper_log('add', "Create {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        (isset($id) ? $id = $tableFieldsId : $id = $id);
        $this->general_m->delete("{$settings['table']}_element", $id);
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'categories_id' =>  $id,
              'fields_id'     =>  $value,
              'order'         =>  ++$i,
            );
            $this->general_m->create("{$settings['table']}_element", $element, FALSE);
          }
          helper_log('add', "add element create has successfully {$element['order']} record");
        }        
        $this->session->set_flashdata('message', "{$settings['title']} has successfully Created");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function groups_update($id='') {
    $settings = array(
      'title'         =>  'categories',
      'subtitle'      =>  'Update',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'button_tabs'   =>  TRUE,
      'content'       =>  'template/bootstrap-4/admin/categories/categories-group-form',
      'table'         =>  'categories',
      'action'        =>  'admin/settings/categories',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'fields_element'=>  'categories_element',
      'fields_group'  =>  $this->general_m->get_all_results('fields_group'),
      'fields'        =>  $this->fields_m->get_all_results(),
      'elementFields' =>  [],
      'order'         =>  $this->general_m->get_max_fields('categories', 'order'),
    );

    $settings['element']      = $this->general_m->get_result_by_id($settings['fields_element'], $id, "{$settings['table']}_id");
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
      if ($_POST['button'] == 'update') {
        (empty($this->input->post('locale-es')) ? $locale = $this->input->post('locale-id') : $locale = $this->input->post('locale-es'));
        (empty($this->input->post('parent-es')) ? $parent = $this->input->post('parent-id') : $parent = $this->input->post('parent-es'));
        $data = array(
          'name'       => ucfirst($this->input->post('name')),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'url'        => $this->input->post('url'),
          'template'   => $this->input->post('template'),
          'locale'     => $locale,
          'parent'     => $parent,
          'maxlevel'   => $this->input->post('maxlevel'),
          'description'=> $this->input->post('description'),
          'created_by' => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
       helper_log('edit', "Update {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        (isset($id) ? $id = $tableFieldsId : $id = $id);
        $this->general_m->delete("{$settings['table']}_element", $id);
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'categories_id' =>  $id,
              'fields_id'     =>  $value,
              'order'         =>  ++$i,
            );
            $this->general_m->create("{$settings['table']}_element", $element, FALSE);
          }
          helper_log('add', "add element create has successfully {$element['order']} record");
        }        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Updated");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function groups_delete($id='') {
    $settings = array(
      'title'         => 'Categories',
      'table'         => 'categories',
      'action'        => 'admin/settings/categories',
      'table_element' => 'categories_element',
      'table_content' => 'categories_content',
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
      $this->session->set_flashdata("message", "{$settings['title']} has successfully Deleted {$delete} Record");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */