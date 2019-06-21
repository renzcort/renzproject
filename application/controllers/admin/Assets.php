<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Assets_m', 'assets_m');
    $this->data = array(
      'userdata' =>  $this->first_load(),
      'parentLink' => 'admin/settings/assets', 
    );
  
    $assets = $this->general_m->get_all_results('assets');
    $this->firstHandle = ($assets ? $assets[0]->handle : '');
    
    foreach ($assets as $key) {
      $handle[] = $key->handle;
    }
    array_push($handle, 'default');
    
    $this->data = array(
      'userdata'   =>  $this->first_load(),
      'parentLink' => 'admin/categories',
    );

    if ($this->router->method == 'index') {
      if ((uri_string() == 'admin/assets') || (! in_array($this->uri->segment(3), $handle))) {
        redirect("admin/assets/default",'refresh');
      }
    }
  }

    /*Assets entries*/
  public function index($handle) {
    // var_dump($handle);die;
    $handle = ($handle == 'default' ? '' : $this->general_m->get_row_by_fields('assets', array('handle' => $handle)));
    ($handle != '' ? $id = $handle->id : $id = '');
    $settings = array(
      'title'          =>  'assets',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  '+ Upload Files',
      'button_link'    =>  'Upload',
      'content'        =>  'template/bootstrap-4/admin/assets/assets-list',
      'table'          =>  'assets_content',
      'action'         =>  'admin/settings/assets',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'assets'         =>  $this->general_m->get_all_results('assets_content'),
      'assets_count'   =>  $this->general_m->count_all_results('assets_content'),
      'group_name'     => 'assets',
      'fields_element' => 'assets_content',
      'group_name'     =>  'assets',
      'group'          =>  $this->general_m->get_all_results('assets'),
      'group_count'    =>  $this->general_m->count_all_results('assets'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
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
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, $id, 'assets_id');
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }


  /*Volumens*/
  public function volumes() {
    $settings = array(
      'title'          =>  'assets',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  '+ New Assets',
      'button_link'    =>  'assets/create',
      'content'        =>  'template/bootstrap-4/admin/assets/assets-group-list',
      'table'          =>  'assets',
      'action'         =>  'admin/settings/assets',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'right_content'  =>  'template/bootstrap-4/admin/assets/assets-volumes-list',
      'fields_element' =>  'assets_element',
      'group_name'     =>  'assets_group',
      'group'          =>  $this->general_m->get_all_results('assets_group'),
      'group_count'    =>  $this->general_m->count_all_results('assets_group'),
      'group_id'       =>  ($this->input->post('group') ? $this->input->post('group') : ''),
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
  public function volumes_create() {
    $settings = array(
      'title'          =>  'assets',
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'button_tabs'    =>  TRUE,
      'content'        =>  'template/bootstrap-4/admin/assets/assets-volumes-form',
      'table'          =>  'assets',
      'action'         =>  'admin/settings/assets',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'assets_type'    =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
      'group_name'     =>  'assets_group',
      'group'          =>  $this->general_m->get_all_results('assets_group'),
      'group_count'    =>  $this->general_m->count_all_results('assets_group'),
      'group_id'       =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'fields_element' =>  'assets_element',
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('assets', 'order'),
    );

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        $data = array(
          'name'       => ucFirst($this->input->post('name')),
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
        helper_log('add', "Create {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        (isset($id) ? $id = $tableFieldsId : $id = $id);
        $this->general_m->delete("{$settings['table']}_element", $id);
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'assets_id'   =>  $id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
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
  public function volumes_update($id='') {
    $settings = array(
      'title'          =>  'assets',
      'subtitle'       =>  'update',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('edit'),
      'button'         =>  'Update',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,
      'content'        =>  'template/bootstrap-4/admin/assets/assets-volumes-form',
      'table'          =>  'assets',
      'action'         =>  'admin/settings/assets',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'assets_type'    =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
      'group_name'     =>  'assets_group',
      'group'          =>  $this->general_m->get_all_results('assets_group'),
      'group_count'    =>  $this->general_m->count_all_results('assets_group'),
      'group_id'       =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'fields_element' =>  'assets_element',
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('assets', 'order'),
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
        $data = array(
          'name'       => ucFirst($this->input->post('name')),
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
        helper_log('edit', "Update {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        (isset($id) ? $id = $tableFieldsId : $id = $id);
        $this->general_m->delete("{$settings['table']}_element", $id);
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'assets_id'   =>  $id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
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
  public function volumes_delete($id='') {
    $settings = array(
      'title'          => 'Assets',
      'table'          => 'assets',
      'action'         => 'admin/settings/assets',
      'fields_element' => 'assets_element',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $deleteElemant = $this->general_m->delete($settings['fields_element'], $id, "{$settings['table']}_id");

      // delte content
      (($settings['table'] == 'entries') ? $table_content = 'content' : $table_content = "{$settings['table']}_content");
      $getFieldsAll     = $this->fields_m->get_all_results();
      $getContentFields = $this->db->list_fields($table_content);
      $getElement       = $this->general_m->get_all_results($settings['fields_element']);
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
      $delete        = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");      
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }


  public function transforms() {
    $settings = array(
      'title'           =>  'assets',
      'subtitle'        =>  'transforms',
      'breadcrumb'      =>  array('settings'),
      'subbreadcrumb'   =>  FALSE,
      'button'          =>  '+ New Assets',
      'button_link'     =>  'transforms/create',
      'content'         =>  'template/bootstrap-4/admin/assets/assets-group-list',
      'table'           =>  'assets_transforms',
      'action'          =>  'admin/settings/assets',
      'session'         =>  $this->data,
      'no'              =>  $this->uri->segment(5),
      'right_content'   => 'template/bootstrap-4/admin/assets/assets-transforms-list',
      'fields_element' =>  'assets_element',
      'group_name'      =>  'assets_group',
      'group'           =>  $this->general_m->get_all_results('assets_group'),
      'group_count'     =>  $this->general_m->count_all_results('assets_group'),
      'group_id'        =>  ($this->input->post('group') ? $this->input->post('group') : ''),
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
  public function transforms_create() {
    $settings = array(
      'title'            =>  'assets Transforms',
      'subtitle'         =>  'create',
      'breadcrumb'       =>  array('settings'),
      'subbreadcrumb'    =>  array('create'),
      'button'           =>  'Save',
      'button_type'      =>  'submit',
      'button_name'      =>  'create',
      'content'          =>  'template/bootstrap-4/admin/assets/assets-transforms-form',
      'table'            =>  'assets_transforms',
      'action'           =>  'admin/settings/assets/transforms',
      'session'          =>  $this->data,
      'no'               =>  $this->uri->segment(4),
      'transforms_mode'  =>  array('Crop', 'Fit', 'Strech'),
      'transforms_point' =>  array(
                                  'top-left', 
                                  'top-center', 
                                  'top-right', 
                                  'center-left', 
                                  'center-center', 
                                  'center-right', 
                                  'bottom-left', 
                                  'bottom-center', 
                                  'bottom-right'),
      'transforms_quality'     =>  array('Auto', 'Low', 'Medium', 'High', 'Very High (Recommended)', 'Maximum'),
      'transforms_interlacing' =>  array('none', 'line', 'plane', 'partition'),
      'transforms_format'      =>  array('auto', 'jpg', 'png', 'gif'),
    );

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        $data = array(
          'name'        => ucFirst($this->input->post('name')),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'mode'        => $this->input->post('mode'),
          'point'       => $this->input->post('point'),
          'width'       => $this->input->post('width'),
          'height'      => $this->input->post('height'),
          'quality'     => $this->input->post('quality'),
          'interlacing' => $this->input->post('interlacing'),
          'format'      => $this->input->post('format'),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );
        $tableFieldsId = $this->general_m->create($settings['table'], $data);
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully Created");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function transforms_update($id='') {
    $settings = array(
      'title'           =>  'assets Transforms',
      'subtitle'        =>  'update',
      'breadcrumb'      =>  array('settings'),
      'subbreadcrumb'   =>  array('edit'),
      'button'          =>  'Update',
      'button_type'     =>  'submit',
      'button_name'     =>  'update',
      'content'         =>  'template/bootstrap-4/admin/assets/assets-transforms-form',
      'table'           =>  'assets_transforms',
      'action'          =>  'admin/settings/assets/transforms',
      'session'         =>  $this->data,
      'no'              =>  $this->uri->segment(3),
      'transforms_mode' =>  array('Crop', 'Fit', 'Strech'),
      'transforms_point' =>  array(
                                  'top-left', 
                                  'top-center', 
                                  'top-right', 
                                  'center-left', 
                                  'center-center', 
                                  'center-right', 
                                  'bottom-left', 
                                  'bottom-center', 
                                  'bottom-right'),
      'transforms_quality'     =>  array('Auto', 'Low', 'Medium', 'High', 'Very High (Recommended)', 'Maximum'),
      'transforms_interlacing' =>  array('none', 'line', 'plane', 'partition'),
      'transforms_format'      =>  array('auto', 'jpg', 'png', 'gif'),
      'id'                     => $id
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
    
    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'update') {
        $data = array(
          'name'        => ucFirst($this->input->post('name')),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'mode'        => $this->input->post('mode'),
          'point'       => $this->input->post('point'),
          'width'       => $this->input->post('width'),
          'height'      => $this->input->post('height'),
          'quality'     => $this->input->post('quality'),
          'interlacing' => $this->input->post('interlacing'),
          'format'      => $this->input->post('format'),
          'description' => $this->input->post('description'),
          'updated_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata("message", "{$settings['title']} has successfully Updated");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function transforms_delete($id='') {
    $settings = array(
      'title'           => 'Assets',
      'table'           => 'assets_transforms',
      'action'          => 'admin/settings/assets/transforms',
      'fields_element' => 'assets_element',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $delete        = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete {settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");      
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }


}

/* End of file Assets.php */
/* Location: ./application/controllers/admin/Assets.php */