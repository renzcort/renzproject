<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends My_Controller {

  public function __construct(){
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/Section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
    $this->data = array(
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/section', 
    );
  }

  /**
   * Section Entries Create
   * This Function Used  to Submit  template tabs and there is Fields
   */
  public function jsonSubmitLayoutTabsFields() {
    $id         = ($this->input->post('id') ? $this->input->post('id') : '');
    $section_id = ($this->input->post('section_id') ? $this->input->post('section_id') : '');
    $button     = ($this->input->post('button') ? $this->input->post('button') : '');
    $table      = ($this->input->post('table') ? $this->input->post('table') : '');

    $settings = array(
      'title'          =>  $this->input->post('header'),
      'subtitle'       =>  ($this->input->post('subtitle') ? $this->input->post('subtitle') : FALSE),
      'breadcrumb'     =>  FALSE,
      'subbreadcrumb'  =>  FALSE,
      'table'          =>  $table,
      'action'         =>  $this->input->post('action'),
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  (($button == 'create') ? 'Save' : 'Update'),
      'button_type'    =>  'submit',
      'button_name'    =>  (($button == 'create') ? 'create' : 'Update'),
      'button_tabs'    =>  TRUE,
      'content'        =>  $this->input->post('content'),
      'fields_element' =>  $this->input->post('fields_element'),
      'section_id'     =>  $section_id,
      'section'        =>  $this->section_m->get_row_by_id($section_id),
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
    );
    $table_id = (($settings['table'] == 'section_entries') ? 'entries_id' : "{$settings['table']}_id" );  
    if ($button == 'update') {
      $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
      $settings['element']      = $this->general_m->get_result_by_id($settings['fields_element'], $id, $table_id);

      if ($settings['element']) {
        foreach ($settings['element'] as $key) {
          $fieldsId[] = $key->fields_id; 
        }
        $settings['elementFields'] = $fieldsId;
      } else {
        $settings['elementFields'] = [];
      }
    }        

    if ($button == 'create') {
      $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
      $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    } else {
      $this->form_validation->set_rules('name', 'Name', 
        array('required','trim', 
          function($str){
            return check_name($this->input->post('table'), $this->input->post('id'), $str);
          }
        )
      );
      $this->form_validation->set_rules('handle', 'Handle',      
        array('required','trim', 
          function($str){
            return check_handle($this->input->post('table'), $this->input->post('id'), $str);
          }
        )
      );
    }
    
    if (isset($_POST['title'])) { $this->form_validation->set_rules('title', 'Title', 'trim|required'); }

    if ($this->form_validation->run() == TRUE) {
      $settings['errors'] = array(
        'name'   => form_error('name'),
        'handle' => form_error('handle'),
        'title'  => (isset($_POST['title']) ? form_error('title') : ''),
      );

      if ($settings['table'] == 'section_entries') {
        $data = array(
          'name'        =>  ucfirst($this->input->post('name')),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'section_id'  =>  $section_id,
          'title'       =>  ucfirst($this->input->post('title')),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'order'       =>  $this->input->post('order'),
        );
      } elseif ($settings['table'] == 'assets') {
        $data = array(
          'name'       => ucfirst($this->input->post('name')),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type'       => $this->input->post('type'),
          'path'       => str_replace(' ', '-', strtolower($this->input->post('path'))),
          'url'        => $this->input->post('url'),
          'description'=> $this->input->post('description'),
          'order'      => $this->input->post('order'),
        );
      } elseif ($settings['table'] == 'categories') {
        (empty($this->input->post('locale-es')) ? $locale = $this->input->post('locale-id') : $locale = $this->input->post('locale-es'));
        (empty($this->input->post('parent-es')) ? $parent = $this->input->post('parent-id') : $parent = $this->input->post('parent-es'));
        $data = array(
          'name'        => ucfirst($this->input->post('name')),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'url'         => $this->input->post('url'),
          'template'    => $this->input->post('template'),
          'locale'      => $locale,
          'parent'      => $parent,
          'maxlevel'    => $this->input->post('maxlevel'),
          'description' => $this->input->post('description'),
          'order'       => $this->input->post('order'),
        );
      } elseif ($settings['table'] == 'globals') {
        $data = array(
          'name'       => ucfirst($this->input->post('name')),
          'handle'     => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'description'=> $this->input->post('description'),
          'order'      => $this->input->post('order'),
        );
      } elseif ($settings['table'] == 'users_settings') {
        $handle = ($this->input->post('handle') ? $this->input->post('handle') : '');
        $data = array(
          'name'     => ucfirst($handle),
          'handle'   => $handle,
        );
        if ($handle == 'settings') {
          $users_settings = array(
            'assetsSourcesList'  => $this->input->post('assetsSourcesList'),
            'path'               => $this->input->post('path'),
            'email_verification' => $this->input->post('email_verification'),
            'allowRegistration'  => $this->input->post('allowRegistration'),
            'default_group'      => $this->input->post('default_group'),
          );
          $data['settings'] = json_encode($users_settings);
        }
      }
      
      if ($button == 'create') {
        $data['created_by'] = $this->data['userdata']['id'];
        $table_fieldsId      = $this->general_m->create($settings['table'], $data);
        if ($settings['table'] == 'globals') {
          $globals = array(
            'globals_id'  =>  $table_fieldsId,
          );
          $this->general_m->create("{$settings['table']}_content", $globals); 
        }
        helper_log('add', "Create {$settings['title']} has successfully");        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully created");
      } else {
        $data['updated_by'] = $this->data['userdata']['id'];
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "Update {$settings['title']} has successfully");        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully updated");  
      }
      
      /*add contents*/
      $fieldsId = $this->input->post('fieldsId');

      /*get fields to element*/ 
      $id = (empty($id) ? $table_fieldsId : $id);

      /*check users groups forms*/
      if ($table == 'users_settings') {
        $table  = 'users';
      }
      
      // check content by id 
      $checkContent = $this->general_m->get_row_by_id($settings['fields_element'], $id, $table_id);
      if ($checkContent) {
        $this->general_m->delete($settings['fields_element'], $id, $table_id);
      }

      /*add elements*/
      /*if (!empty($fieldsId)) {
        $i = 0;
        foreach ($fieldsId as $value) {
          if ($settings['table'] == 'section_entries') {
            $element = array(
              "{$table_id}" =>  $id,
              'section_id'  =>  $section_id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
          } else {
            $element = array(
              "{$table_id}" =>  $id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
          }
          $this->general_m->create($settings['fields_element'], $element, FALSE);
        }
        helper_log('add', "add element create has successfully {$element['order']} record");
      } */

      /*multiple tabs element*/
      $multipleTabs = $this->input->post('multipleTabs');
      if (!empty($multipleTabs)) {
        $i = 0;
        foreach ($multipleTabs as $key) {
          foreach ($key['fields'] as $value) {
            if ($settings['table'] == 'section_entries') {
              $element = array(
                "{$table_id}"   => $id,
                'section_id'    => $section_id,
                'fields_id'     => $value,
                'tabs_settings' => json_encode(array('id' => $key['id'], 'title' => $key['title'], 'count' => $key['count'])),
                'order'         =>  ++$i
              );
            } else {
              $element = array(
                "{$table_id}"   => $id,
                'fields_id'     => $value,
                'tabs_settings' => json_encode(array('id' => $key['id'], 'title' => $key['title'], 'count' => $key['count'])),
                'order'         =>  ++$i
              );
            }
            $this->general_m->create($settings['fields_element'], $element, FALSE);
          }
        }
        helper_log('add', "add multiple tabs element create has successfully {$element['order']} record");
      }

      (($settings['table'] == 'section_entries') ? $table_content = 'content' : $table_content = "{$table}_content");
      $getFieldsAll     = $this->fields_m->get_all_results();
      $getContentFields = $this->db->list_fields($table_content);
      $getElement = $this->general_m->get_all_results($settings['fields_element']);
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

        // Add Column COntent
        foreach ($getFieldsAll as $key) {
          if (!in_array("fields_{$key->handle}", $getContentFields)) {
            if (in_array($key->id, array_unique($listFields))) {
              $getFieldsType = $this->general_m->get_row_by_id('fields_type', $key->type_id);
              $fields = array (
                'handle' => $key->handle,
                'type'   => $getFieldsType->type,
              );
              modifyColumn($fields, 'add-table', $table_content); 
            }
          }
        } 
      } else {
        /*Check Delete Column*/
        if ($getFieldsAll) {
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
      }

      $settings['status'] = TRUE;
      echo json_encode($settings);
    } else {
      $settings['errors'] = array(
        'name'   => form_error('name'),
        'handle' => form_error('handle'),
        'title'  => (isset($_POST['title']) ? form_error('title') : ''),
      );
      $settings['status'] = FALSE;
      echo json_encode($settings);
    }    
  }

  /**
   * This Function used to Change Order Entrytypes In Section
   */
  public function jsonChangeOrderEntryTypes(){
    $settings = array(
      'table'         => $this->input->post('table'),
      'section_id'    => $this->input->post('section_id'),
      'entrytypes_id' => $this->input->post('entrytypes_id'),
      'order'         => $this->input->post('order'),
    );
    $i = 0;
    foreach ($settings['entrytypes_id'] as $key => $val) {
      $data = array('order' => ++$i);
      $update = $this->general_m->update($settings['table'], $data, $val);
    }
    echo json_encode($update);
  }

  /**
   * GROUP API
   */
  // Add Groups by Table and Group name
  public function jsonModalAddGroups() {
    $settings = array(
      'table'       =>  $this->input->post('table'),
      'table_group' => $this->input->post('table_group'),
    );
    $data = $this->general_m->create($settings['table_group']);
    echo json_encode($data);
  }

  // get data groups by ID 
  public function jsonModalShowGroupsById() {
    header('Content-type: application/json');
    $settings = array(
      'table'       =>  $this->input->post('table'),
      'group_id'    => $this->input->post('group_id'),
      'table_group' => $this->input->post('table_group'),
    );
    $data = $this->general_m->get_row_by_id($settings['table_group'], $settings['group_id']);
    echo json_encode($data);
  }

  // This function use to delete Groups By Id
  public function jsonDeleteGroupsById() {
    header('Content-type: application/json');
    $settings = array(
      'table'        => $this->input->post('table'),
      'table_group'  => $this->input->post('table_group'),
      'group_id'     => $this->input->post('group_id'),
      'element_name' => ($this->input->post('element_name') ? $this->input->post('element_name') : ''),
    );
    $get_data_orderby_groups  = $this->general_m->get_result_by_id($settings['table'], $settings['group_id'], 'group_id');
    if ($get_data_orderby_groups) {
      if ($settings['table'] == 'fields') {
        $fields_content            = $this->db->list_fields('content');
        $fields_categories_content = $this->db->list_fields('categories_content');
        $fields_assets_content     = $this->db->list_fields('assets_content');
        $fields_globals_content    = $this->db->list_fields('globals_content');
        $fields_users_content      = $this->db->list_fields('users_content');
        foreach ($get_data_orderby_groups as $key) {
          $fields_handle = "fields_{$key->handle}";

          if (in_array($fields_handle, $fields_content)) {
            $fields = array(
              'id'        => $key->id,
              'handle'    => $key->handle,
              'type'      => $key->type_id,
              'option_id' => $key->option_id,
            );
            modifyColumn($fields, 'drop');

            // check and drop fields in categories content
            if (in_array($fields_handle, $fields_categories_content)) {
              modifyColumn($fields, 'drop-table', 'categories_content');
            }
            // chekc and drop fields in assets content
            if (in_array($fields_handle, $fields_assets_content)) {
              modifyColumn($fields, 'drop-table', 'assets_content');
            }
            // // chekc and drop fields in assets content
            if (in_array($fields_handle, $fields_globals_content)) {
              modifyColumn($fields, 'drop-table', 'globals_content');
            }
            // // chekc and drop fields in assets content
            if (in_array($fields_handle, $fields_users_content)) {
              modifyColumn($fields, 'drop-table', 'users_content');
            }

            /*Deleete Element in Each Table */
            // check element each table element
            $check_element = $this->general_m->get_result_by_fields('element', array('fields_id' => $fields['id']));
            if ($check_element) {
              $delete_element = $this->general_m->delete('element', $fields['id'], 'fields_id');
            }

            // check element each table element
            $check_categories_element = $this->general_m->get_result_by_fields('categories_element', array('fields_id' => $fields['id']));
            if ($check_categories_element) {
              $delete_categories_element = $this->general_m->delete('categories_element', $fields['id'], 'fields_id');
            }
            // check element each table element
            $check_assets_element = $this->general_m->get_result_by_fields('assets_element', array('fields_id' => $fields['id']));
            if ($check_assets_element) {
              $delete_assets_element = $this->general_m->delete('assets_element', $fields['id'], 'fields_id');
            }
            // check element each table element
            $check_globals_element = $this->general_m->get_result_by_fields('globals_element', array('fields_id' => $fields['id']));
            if ($check_globals_element) {
              $delete_globals_element = $this->general_m->delete('globals_element', $fields['id'], 'fields_id');
            } 
            // check element each table element
            $check_users_element = $this->general_m->get_result_by_fields('users_element', array('fields_id' => $fields['id']));
            if ($check_users_element) {
              $delete_users_element = $this->general_m->delete('users_element', $fields['id'], 'fields_id');
            } 
          } 
        } 
        /*Delete Fields*/
        $delete_fields_orderby_groups = $this->general_m->delete($settings['table'], $settings['group_id'], 'group_id');
      } else {
        if ($settings['element_name']) {
          foreach ($get_data_orderby_groups as $key) {
            $get_data_element = $this->general_m->get_row_by_id("{$settings['table']}_element", $key->id, "{$settings['table']}_id");
            if ($get_data_element) {
              $delete_element = $this->general_m->delete("{$settings['table']}_element", $key->id, "{$settings['table']}_id");
            }
          }
        }
        $delete_fields_orderby_groups = $this->general_m->delete($settings['table'], $settings['group_id'], 'group_id');
      }
    }
    $delete_group = $this->general_m->delete($settings['table_group'], $settings['group_id']);
    helper_log('delete', "Delete fields with id = {$settings['group_id']} has successfully");
    $data = array(
      'action' => "admin/{$settings['table']}",
      'delete' => 'success'
    );
    $this->session->set_flashdata('message', "Groups has successfully deleted");
    echo json_encode($data);
  }
  
  // This function use to Show Fields By Id Groups
  public function jsonDisplayDataByGroups(){
    header('content-type: application/json');
    $settings = array(
      'table'       => $this->input->post('table'),
      'table_group' => ($this->input->post('table_group') ? $this->input->post('table_group') : ''),
      'group_id'    => (($this->input->post('group_id') == 'all') ? '' : (($this->input->post('group_id') == 0) ? 0 : $this->input->post('group_id'))),
      'action'      => ($this->input->post('action') ? $this->input->post('action') : ''),
      'group'       => ($this->input->post('table_group') ? $this->general_m->get_all_results($this->input->post('table_group')) : ''),
      'group_count' => ($this->input->post('table_group') ? $this->general_m->count_all_results($this->input->post('table_group')) : ''),
    );
    $fields = ((in_array($settings['table'], array('fields', 'sites'))) ? 'group_id' : "{$settings['table_group']}_id");

    // Pagination
    $config                = $this->config->item('setting_pagination');
    $config['base_url']    = base_url($settings['action']);
    $config['total_rows']  = $this->general_m->count_all_results($settings['table']);
    $config['per_page']    = 10;
    $num_pages             = $config["total_rows"] / $config["per_page"];
    $config['uri_segment'] = 3;
    $config['num_links']   = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);

    if ($settings['group_id'] == '') {
     $record_all = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    } else {
     $record_all = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, strval($settings['group_id']), $fields);
    }

    $settings['links'] = $this->pagination->create_links();
    if($record_all) {
      if ($settings['table'] == 'sites') {
        $table_view = '
          <table class="table table-sm text-left">
            <thead>
              <tr>
                <th scope="row">#</th>
                <th scope="col">Name</th>
                <th scope="col">Handle</th>
                <th scope="col">Language</th>
                <th scope="col">Primary</th>
                <th scope="col">Base URL</th>
                <th scope="row"></th>
              </tr>
            </thead>
            <tbody>'; 
          $no = 0;
          foreach ($record_all as $key) {
             $table_view .= '<tr>
                <td scope="row">'.++$no.'</td>
                <td><a href="'.base_url($settings['action'].'/edit/'.$key->id).'">'.($key->name ? $key->name : '').'</a></td>
                <td>'.($key->handle ? $key->handle : '').'</td>
                <td>'.$key->language.'</td>
                <td>'.(!empty($key->primary) ? 'Yes' : 'No').'</td>
                <td>'.($key->url ? $key->url : '').'</td>
                <td scope="row">
                  <a href="'.base_url($settings['action'].'/delete/'.$key->id).'" data-id="'.$key->id.'">
                  <i class="fas fa-minus-circle"></i></a>
                </td> 
              </tr>';
            }
          $table_view .= '</tbody></table>';
      } elseif ($settings['table'] == 'fields') {
        $table_view = '
          <table class="table table-sm text-left">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Handle</th>
                <th scope="col">Type</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>'; 
          $no = 0;
          foreach ($record_all as $key) {
            $type = $this->general_m->get_row_by_id('fields_type', $key->type_id);
             $table_view .= '<tr>
                <td scope="row">'.++$no.'</td>
                <td><a href="'.base_url($settings['action'].'/edit/'.$key->id).'">'.($key->name ? $key->name : '').'</a></td>
                <td>'.($key->handle ? $key->handle : '').'</td>
                <td>'.$type->name.'</td>
                <td><a href="'.base_url($settings['action'].'/delete/'.$key->id).'" data-id="'.$key->id.'">
                  <i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>';
            }
          $table_view .= '</tbody></table>';
      } elseif ($settings['table'] = 'assets_content') {
        $table_view = '
          <table class="table table-sm text-left">
            <thead>
              <tr>
                <th scope="row">#</th>
                <th scope="col">Title</th>
                <th scope="col">Post Date</th>
                <th scope="col">File Size</th>
                <th scope="col">File Modified Date</th>
              </tr>
            </thead>
            <tbody>'; 
          $no = 0;
        foreach ($record_all as $key) {
          $filename   = explode('.', $key->file);
          $name       = current($filename);
          $thumb      = current($filename).'_thumb.'.end($filename);
          $file_thumb = base_url("{$key->path}/{$thumb}");
          $getSize    = get_headers($file_thumb, 1); 
          $table_view .= '<tr>
              <td scope="row">'.++$no.'</td>
              <td><img src="'.$file_thumb.'" class="img-thumbnail" heigth="10" width="20"/>'.ucfirst($name).'</td>
              <td>'.($key->file ? $key->file : '').'</td>
              <td>'.$key->size.' kB </td>
              <td>'.date("d/m/Y", strtotime($key->created_at)).'</td>
              </tr>';
        }
        $table_view .= '</tbody></table>';
      }
    } else {
      $table_view = '<p class="empty-data">Data is Empty</p>';
    }
    echo json_encode($table_view);
  }
  /*End Group API*/

  

  /**
   * fungsi ga jelas
   * This function use to Delete Fields By ID
   */
  public function jsonDeleteFieldsById() {
    header('Content-type: application/json');
    $id = $this->input->post('id');
    $getDataby_id = $this->fields_m->get_row_by_id($id);
    if ($getDataby_id) {
      $delElement = $this->general_m->delete('element', $id, 'fields_id');
      $fields = array(
        'handle' => $getDataby_id->handle,
      );
      // Drop field column
      modifyColumn($fields, 'drop');
      $fields_del = $this->fields_m->delete($id);
      $option_del = $this->general_m->delete('fields_option', $getDataby_id->option_id);
      helper_log('delete', "Delete fields with id = {$id} has successfully");
      $this->session->set_flashdata('message', "data has deleted {$delete} Records");
      echo json_encode($getDataby_id);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
    }
  }


  /**
   * This function for upload assets without submit button in assets List
   */
  public function jsonUploadAssetsList() {
    $settings = array(
      'assets_id' => (in_array($this->input->post('group_id'), array('all', 'default')) ? 0 : $this->input->post('group_id'))
    );
    $assets = (($settings['assets_id'] == 0) ? '' : $this->general_m->get_row_by_id('assets', $settings['assets_id']));
    $folder = ($assets ? $assets->path : 'default');

    $settings['upload_path'] = "uploads/admin/assets/{$folder}";

    // if (file_exists("{$settings['upload_path']}/{$_FILES["file"]["name"]}")) {
    //   $this->output->set_status_header(401);
    //   exit;
    // }

    //upload.php
    if($_FILES["file"]["name"] != ''){
      $file   = str_replace(' ', '-', $_FILES['file']['name']);
      $config = $this->config->item('setting_upload');
      $config['upload_path'] = $settings['upload_path'];
      $config['file_name']   = $file;
      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      } 
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('file')){
        $error = array('error' => $this->upload->display_errors());
      } else{
        $result     = array('upload_data' => $this->upload->data());
        $path_thumb = "{$settings['upload_path']}/thumb";
        $filename   = explode('.', $result['upload_data']['file_name']);
        $file_thumb = current($filename).'_thumb.'.end($filename);
        $data = array(
          'assets_id'  => $settings['assets_id'],
          'file'       => $result['upload_data']['file_name'],
          'file_thumb' => $file_thumb,
          'ext'        => $result['upload_data']['file_ext'],
          'size'       => $result['upload_data']['file_size'],
          'path'       => $settings['upload_path'],
          'path_thumb' => $path_thumb,
          'created_by' => $this->data['userdata']['id'],
        );
        //INSERT Assets content 
        $this->general_m->create('assets_content', $data);
        helper_log('add', "Create Assets Content has successfully");
      }

      // create Thumbs
      $config = $this->config->item('settings_image');
      $config['source_image'] = "{$settings['upload_path']}/{$file}";
      $config['create_thumb'] = TRUE;
      $config['new_image']    = "{$settings['upload_path']}/thumb";
      if (!is_dir($config['new_image'])) {
        mkdir($config['new_image'], 0777, TRUE);
      } 
      $this->image_lib->initialize($config);
      if ( ! $this->image_lib->resize()){
        echo $this->image_lib->display_errors();
      }
      // clear //
      $this->image_lib->clear();


     /* $test          = explode('.', $_FILES["file"]["name"]);
      var_dump(current($test));die;
      $ext           = end($test);
      $name          = rand(100, 999) . '.' . $ext;
      $location_file = base_url("{$settings['upload_path']}/{$_FILES["file"]["name"]}");  
      $location = './upload/' . $name;  
      move_uploaded_file($_FILES["file"]["tmp_name"], $location);*/

      $record_all = 
      ($assets ? $this->general_m->get_result_by_id('assets_content', $settings['assets_id'], 'assets_id') : $this->general_m->get_all_results('assets_content'));
      $no = 0;
      if ($record_all) {
        $table_view = '
          <table class="table table-sm text-left">
            <thead>
              <tr>
                <th scope="row">#</th>
                <th scope="col">Title</th>
                <th scope="col">Post Date</th>
                <th scope="col">File Size</th>
                <th scope="col">File Modified Date</th>
              </tr>
            </thead>
            <tbody>'; 
          $no = 0;
        foreach ($record_all as $key) {
          $filename = explode('.', $key->file);
          $name = current($filename);
          $thumb = current($filename).'_thumb.'.end($filename);
          $file_thumb = base_url("{$config['new_image']}/{$thumb}");
          $getSize = get_headers($file_thumb, 1); 
          $table_view .= '<tr>
              <td scope="row">'.++$no.'</td>
              <td><img src="'.$file_thumb.'" class="img-thumbnail" heigth="10" width="20"/>
              '.((strlen($name) <= 24) ? ucfirst($name) : substr(ucfirst($name), 0, 24)."...").'</td>
              <td>'.((strlen($name) <= 24) ? $key->file : substr($key->file, 0, 24)."...".$key->ext).'</td>
              <td>'.$getSize['Content-Length'].' kB </td>
              <td>'.date("d/m/Y h:i A", strtotime($key->created_at)).'</td>
              </tr>';
        }
        $table_view .= '</tbody></table>';
      } else {
        $table_view = '<p class="empty-data">Data is Empty</p>';
      }
      echo $table_view;
    }
  }


  /**
   * Manage Entries Template
   * This function use to manage form template entries
   */
  public function jsonSubmitEntriesForm() {
    $settings = array(
      'parent_id'     => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'  => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content' => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'            => ($this->input->post('id') ? $this->input->post('id') : ''),
      'button'        => $this->input->post('button'),
      'action'        => $this->input->post('action'), 
      'activated'     => (($this->input->post('activated') == 'on' || $this->input->post('activated')) ? 1 : 0),
    );
    if ($this->input->post('parent_table') == 'section_entries') {
      $settings['section_id']  = $this->input->post('section_id');
      $settings['entriestype'] = $this->input->post('entriestype');
    }
    $parent_id = (($this->input->post('parent_table') == 'section_entries') ? $settings['entriestype'] : $this->input->post('parent_id'));
    // check Datetime
    $today      = now();
    $postdate   = strtotime(str_replace('/', '-', $this->input->post('postdate')));
    $expirydate = strtotime(str_replace('/', '-', $this->input->post('expirydate')));

    if ($settings['button'] == 'create') {
      $this->form_validation->set_rules('title', 'Title', "trim|required|callback_title_child_check");
      $this->form_validation->set_rules('postdate', 'Postdate', "trim|required|callback_postdate_check");
      $this->form_validation->set_rules('expirydate', 'Expirydate', "trim|required|callback_expirydate_check");
    } else {
      $this->form_validation->set_rules('title', 'Title', "trim|required|callback_title_child_check");
      if ($settings['parent_table'] != 'globals') {
        $this->form_validation->set_rules('postdate', 'Postdate', "trim|required|callback_postdate_check");
        $this->form_validation->set_rules('expirydate', 'Expirydate', "trim|required|callback_expirydate_check");
      }
    }

    if ($this->form_validation->run() == TRUE) {
      $data = array(
        'title'                          => $this->input->post('title'),
        'handle'                         => lcfirst(str_replace(' ', '', ucwords($this->input->post('title')))),
        'slug'                           => url_title(strtolower($this->input->post('title'))),
        "{$settings['parent_table']}_id" => $parent_id,
      );
      (($this->input->post('parent_table') == 'section_entries') ? $data['section_id'] = $settings['section_id'] : ''  );
      if ($this->input->post('parent_table') != 'globals') {
        $data['postdate_at']   = date("Y-m-d H:i:s", $postdate);
        $data['expirydate_at'] = date("Y-m-d H:i:s", $expirydate);
        $data['activated']     = $settings['activated'];
      }

      $keys = array_keys($this->input->post());
      foreach ($keys as $key) {
        if (strpos($key, 'fields') !== false) {
          if (is_array($this->input->post($key))) {
            $data[$key] = implode(', ', $this->input->post($key));
          } else {
            $data[$key] = $this->input->post($key);
          }
        }
      }

      if ($settings['button'] == 'create') {
        $data['created_by'] = $this->data['userdata']['id'];
        $this->general_m->create($settings['table_content'], $data);
        helper_log('add', "Create {$settings['table_content']} has successfully");
        $this->session->set_flashdata('message', "data has successfully created");
      } elseif ($settings['button'] == 'update') {
        $data['updated_by'] = $this->data['userdata']['id'];
        $this->general_m->update($settings['table_content'], $data, $settings['id']);
        helper_log('edit', "Update {$settings['table_content']} has successfully");
        $this->session->set_flashdata('message', "data has successfully updated");
      } 
    
      $settings['status'] = TRUE;
      echo json_encode($settings);
    } else {
      $settings['errors'] = array(
        'title'      => (isset($_POST['title']) ? form_error('title') : ''),
        'postdate'   => form_error('postdate'),
        'expirydate' => form_error('expirydate')
      );
      $settings['status'] = FALSE;
      echo json_encode($settings);
    }   
  }

  public function title_child_check($str) {
    /*Check title in childeren parent*/
    $parent_id    = (($this->input->post('parent_table') == 'section_entries') ? $this->input->post('entriestype') : $this->input->post('parent_id'));
    $parent_table = (($this->input->post('parent_table') == 'section_entries') ? 'entries' : $this->input->post('parent_table'));
    $data = array(
      'title' =>  $str,
      "{$parent_table}_id" => $parent_id, 
    );
    return check_title_child($this->input->post('table_content'), $parent_id, $this->input->post('id'), $data);
  }

  public function postdate_check($data){
   return check_postdate($data, $this->input->post('postdate'), $this->input->post('expirydate'));
  }

  public function expirydate_check($data){
   return check_expirydate($data, $this->input->post('postdate'), $this->input->post('expirydate'));
  }

  /**
   * Select Entries Type
   * This function use to change entries type in right tabs
   */
  public function jsonChangeFormByEntryTypes(){
    $settings = array(
      'parent_table'  => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'section_id'    => ($this->input->post('section_id') ? $this->input->post('section_id') : '' ),
      'table_content' => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'            => ($this->input->post('id') ? $this->input->post('id') : ''),
      'button'        => ($this->input->post('button') ? $this->input->post('button') : ''),
      'action'        => ($this->input->post('action') ? $this->input->post('action') : ''),
      'element_table' => ($this->input->post('element_table') ? $this->input->post('element_table') : ''),
      'entrytypes_id' => ($this->input->post('entrytypes_id') ? $this->input->post('entrytypes_id') : ''),
    );
    $section            = $this->general_m->get_row_by_id('section', $settings['section_id']);
    $entriestype        = $this->general_m->get_row_by_id($settings['parent_table'], $settings['entrytypes_id']);
    $element            = $this->general_m->get_result_by_fields($settings['element_table'], array('entries_id' => $settings['entrytypes_id']));
    $tabs_elements      = tabs_layout($element);
    $fields             = $this->fields_m->get_all_results();
    $fields_type        = $this->general_m->get_all_results('fields_type');
    $assets             = $this->general_m->get_all_results('assets');
    $assets_content     = $this->general_m->get_all_results('assets_content');
    $categories         = $this->general_m->get_all_results('categories');
    $categories_content = $this->general_m->get_all_results('categories_content');
    $entries_content    = $this->general_m->get_all_results('content');


    $tabs = '';
    $i = 0; 
    foreach ($tabs_elements as $elm) {
      ++$i; 
      $tabs .= '
        <li class="nav-item">
          <a class="nav-link '.(($i == 1) ? 'active' : '').'" id="pills-'.$elm['id'].'-tab" 
          data-toggle="pill" href="#'.$elm['id'].'" role="tab" aria-controls="'.$elm['title'].'" 
          aria-selected="true">'.ucwords($elm['title']).'</a>
        </li>';
    }
    $content ='
        <div class="tab-content" id="myTabContent">';
    
    $i = 0; 
    foreach ($tabs_elements as $elm) {
      ++$i; 
      $content .= '
        <div class="tab-pane fade '.(($i == 1) ? 'show active' : '').'" id="'.$elm['id'].'" role="tabpanel" aria-labelledby="pills-'.$elm['id'].'-tab">
          <div class="form-group">
            <label for="inputTitle" class="heading">Title</label>
            <input type="text" name="title" placeholder="Title" class="form-control" 
            value="'.(!empty($getDataby_id->title) ? $getDataby_id->title : set_value('title')).'">
            <div class="form-error">'.form_error('title').'</div>
          </div>';
      foreach ($elm['fields'] as $val) {
        foreach ($fields as $key) {
          if ($val == $key->id) {
            $settings    = json_decode($key->settings);
            $fields_name = "fields_{$key->handle}";
            $content .= '
              <div class="form-group">
                <label class="heading" for="input'.$key->handle.'">'.ucfirst($key->name).'</label>';
              if ($key->type_name == 'plainText') {
                if ($settings->plainLineBreak == 1) {
                  $content .= '
                    <textarea class="form-control"
                      name="fields_'.$key->handle.'" 
                      id="textarea"
                      rows="'.$settings->plainInitialRows.'"
                      placeholder="'.$settings->plainPlaceholder.'">'.(!empty($getDataby_id->$fields_name) ? trim(strip_tags($getDataby_id->$fields_name)) : '').'
                    </textarea>';        
                } else {
                  $content .= '
                    <input type="text" class="form-control" 
                      name="fields_'.$key->handle.'" 
                      placeholder="'.(!empty($setttings->plainPlaceholder) ? $setttings->plainPlaceholder : '').'"
                      maxlength="'.(!empty($settings->plainCharlimit) ? $settings->plainCharlimit : '').'"
                      value="'.(!empty($getDataby_id->$fields_name) ? $getDataby_id->$fields_name : set_value($fields_name)).'">';                    
                }
              } elseif ($key->type_name == 'assets') {
                foreach ($assets as $ast) {
                  if ($ast->id == $settings->assetsSourcesList) {
                    $data['name'] = $ast->name;
                  }
                }

                $content .= '
                  <div id="assetscontent-list-selected">
                    <ul class="list-unstyled selected">';
                      if (!empty($getDataby_id->$fields_name)) {
                        $assetsList = explode(', ', $getDataby_id->$fields_name);
                        if ($assets_content) {
                          foreach ($assets_content as $astcont) {
                            $filename   = explode('.', $astcont->file);
                            $name       = current($filename);
                            $thumb      = current($filename).'_thumb.'.end($filename);
                            $file_thumb = base_url("{$astcont->path}/{$thumb}");
                            $getSize    = get_headers($file_thumb, 1);
                            if (in_array($astcont->id, $assetsList)) {
                              $content .= '
                                <li><input type="hidden" name="'.$fields_name.'[]" value="'.$astcont->id.'" class="assets-list">
                                  <img src="'.$file_thumb.'" class="img-thumbnail list" 
                                  data-id="'.$astcont->id.'" heigth="20" width="30"/>
                                  <label for="input'.$name.'">'.$name.'</label>
                                  <a><i class="fa fa-times" aria-hidden="true"></i></a
                                </li>';
                            }
                          }
                        }
                      }
                $content .= '</ul>';
                $content .= '
                  <div class="button-add">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#assets-modal"
                    data-assets-id = "'.$settings->assetsSourcesList.'" 
                    data-assets-limit ="'.$settings->assetsLimit.'" 
                    data-assets-fields="fields_'.$key->handle.'"
                    data-assets-source="'.$settings->assetsSourcesInput.'">
                    + '.($settings->assetsSelectionLabel ? ucwords($settings->assetsSelectionLabel) : 'New Assets').'</button>
                  </div>';
                $content .='</div>';
              } elseif ($key->type_name == 'richText') {
              } elseif ($key->type_name == 'categories') {
                foreach ($categories as $cat) {
                  if ($cat->id == $settings->categoriesSource) {
                    $data['name'] = $cat->name;
                  }
                }

                $content .= '
                  <div id="categoriescontent-list-selected">
                   <ul class="list-unstyled selected">';
                    if (!empty($getDataby_id->$fields_name)) {
                      $catList = explode(', ', $getDataby_id->$fields_name);
                      if ($categories_content) {
                        foreach ($categories_content as $catCont) {
                          if (in_array($catCont->id, $catList)) {
                            $content .= '
                              <li><input type="hidden" name="'.$fields_name.'[]" value="'.$catCont->id.'" class="categories-list">
                                <label for="input'.$catCont->title.'">'.$catCont->title.'</label>
                                <a><i class="fa fa-times" aria-hidden="true"></i></a
                              </li>';
                          }
                        }
                      }
                    }
                $content .= '</ul>';
                $content .= '
                  <div class="button-add">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#categories-modal"
                    data-categories-id = "'.$settings->categoriesSource.'" 
                    data-categories-limit ="'.$settings->categoriesLimit.'" 
                    data-categories-fields="fields_'.$key->handle.'">
                    + '.($settings->categoriesSelectionLabel ? ucwords($settings->categoriesSelectionLabel) : 'New Categories').'</button>
                  </div>';
                $content .= '</div>';
              } elseif ($key->type_name == 'checkboxes') {
                $val = $settings->checkboxesValue; 
                $i = 0;
                foreach ($settings->checkboxesLabel as $chk => $value) {
                  $checkResult[] = array(
                    'label' => $value,
                    'value' => $val[$i]
                  );
                  $i++;
                }

                if (!empty($getDataby_id->$fields_name)) {
                  $checkList = explode(', ', $getDataby_id->$fields_name);
                }

                foreach ($checkResult as $chkResult) {
                  $content .= '
                    <div class="form-check">
                      <input class="form-check-input" 
                        type="checkbox" 
                        name="fields_'.$key->handle.'[]" 
                        value="'.$chkResult['value'].'"
                        '.((!empty($getDataby_id->$fields_name) && in_array($chkResult['value'], $checkList)) ? 'checked' : '').'>
                      <label class="form-check-label" 
                        for="defaultCheck1">'.ucfirst($chkResult['label']).'
                      </label>
                    </div>';
                }
              } elseif ($key->type_name == 'dateTime') {
              } elseif ($key->type_name == 'dropdown') {
                $val = $settings->dropdownValue; 
                $i = 0;
                foreach ($settings->dropdownLabel as $drp => $value) {
                  $dropResult[] = array(
                    'label' => $value,
                    'value' => $val[$i]
                  );
                  $i++;
                }
                if (!empty($getDataby_id->$fields_name)) {
                  $checkList = explode(', ', $getDataby_id->$fields_name);
                }
                $content .= '<select class="form-control costum-select" name="fields_'.$key->handle.'">';
                foreach ($dropResult as $drpResult) {
                  $content .= '
                    <option value="'.$drpResult['value'].'"
                    '.((!empty($getDataby_id->$fields_name) && in_array($drpResult['value'], $checkList)) ? 'selected' : '').'>
                    '.ucfirst($drpResult['label']).'</option>';
                }
                $content .= '</select>';
              } elseif ($key->type_name == 'radio') {
                $val = $settings->radioValue; 
                $i = 0;
                foreach ($settings->radioLabel as $rad => $value) {
                  $radioResult[] = array(
                    'label' => $value,
                    'value' => $val[$i]
                  );
                  $i++;
                }
                if (!empty($getDataby_id->$fields_name)) {
                  $checkList = explode(', ', $getDataby_id->$fields_name);
                }
                foreach ($radioResult as $radResult) {
                  $content .= '
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]"  value="'.$radResult['value'].'"
                      '.((!empty($getDataby_id->$fields_name) && in_array($radResult['value'], $checkList)) ? 'checked' : '').'>
                      <label class="form-check-label" for="defaultCheck1">'.ucfirst($radResult['label']).'</label>
                    </div>';
                }
              } elseif ($key->type_name == 'entries') {
                $content .= '
                  <div id="entriescontent-list-selected">
                    <ul class="list-unstyled selected">';
                      if (!empty($getDataby_id->$fields_name)) {
                        $entList = explode(', ', $getDataby_id->$fields_name);
                        if ($entries_content) {
                          foreach ($entries_content as $entCont) {
                            if (in_array($entCont->id, $entList)) {
                              $content .= '
                                <li><input type="hidden" name="'.$fields_name.'[]" value="'.$entCont->id.'" class="entries-list">
                                  <label for="input'.$entCont->title.'">'.$entCont->title.'</label>
                                  <a><i class="fa fa-times" aria-hidden="true"></i></a
                                </li>';
                            }
                          }
                        }
                      }
                $content .= '</ul>';
                $content .= '
                  <div class="button-add">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#entries-modal"
                    data-section-id = "'.$settings->entriesSource.'"
                    data-entries-limit ="'.$settings->entriesLimit.'" 
                    data-entries-fields="fields_'.$key->handle.'">
                    + '.($settings->entriesSelectionLabel ? ucwords($settings->entriesSelectionLabel) : 'New Categories').'</button>
                  </div>';
                $content .= '</div>';
              }
            $content .= '</div>';
          }
        }
      }
      
      $content .= '</div>';
    }
    $content .= '</div>';

    $data = array(
      'tabs'    => $tabs,
      'content' => $content,
    );
    echo json_encode($data);
  }



  /**
   * This function use to update data Fields in Users settings
   */
  public function jsonSubmitUsersForm(){
    $settings = array(
      'button'        => $this->input->post('button'),
      'id'            => ($this->input->post('id') ? $this->input->post('id') : ''),
      'table'         => $this->input->post('table_content'),
      'parent_table'  => $this->input->post('parent_table'),
      'action'        => $this->input->post('action'),
    );

    if ($settings['button'] == 'create') {
      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[renz_users.username]');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[renz_users.email]');
    } else {
      $this->form_validation->set_rules('username', 'Username', 
        array('required','trim', 
          function($str){
            return check_username($this->input->post('parent_table'), $this->input->post('id'), $str);
          }
        )
      );
      $this->form_validation->set_rules('email', 'email',      
        array('required','trim', 
          function($str){
            return check_email($this->input->post('parent_table'), $this->input->post('id'), $str);
          }
        )
      );
    }
    if (isset($_POST['title'])) { $this->form_validation->set_rules('title', 'Title', "trim|required|callback_title_child_check"); }

    if ($this->form_validation->run() == TRUE) {
      $permission_settings = array(
        'generalAccessOff'              => $this->input->post('generalAccessOff'),
        'generalAccessCP'               => $this->input->post('generalAccessCP'),
        'generalCustomizeElementSource' => $this->input->post('generalCustomizeElementSource'),
        'generalAccessCPOffline'        => $this->input->post('generalAccessCPOffline'),
        'generalPerformPluginUpdate'    => $this->input->post('generalPerformPluginUpdate'),
        'generalCustomizeElementSource' => $this->input->post('generalCustomizeElementSource'),
        'usersEdit'                     => $this->input->post('usersEdit'),
        'usersModerate'                 => $this->input->post('usersModerate'),
        'usersAssignEdit'               => $this->input->post('usersAssignEdit'),
        'usersAssignGroups'             => $this->input->post('usersAssignGroups'),
        'usersAssigns'                  => $this->input->post('usersAssigns'),
        'usersAdministrate'             => $this->input->post('usersAdministrate'),
        'usersImpersonate'              => $this->input->post('usersImpersonate'),
        'usersDelete'                   => $this->input->post('usersDelete'),
        'sectionEdit'                   => $this->input->post('sectionEdit'),
        'sectionPublishLiveChange'      => $this->input->post('sectionPublishLiveChange'),
        'sectionEditOtherAuthors'       => $this->input->post('sectionEditOtherAuthors'),
        'sectionPublishOtherAuthors'    => $this->input->post('sectionPublishOtherAuthors'),
        'sectionDelete'                 => $this->input->post('sectionDelete'),
        'editGlobal'                    => $this->input->post('editGlobal'),
        'volumeView'                    => $this->input->post('volumeView'),
        'volumeUploadFiles'             => $this->input->post('volumeUploadFiles'),
        'volumeCreateSubfolder'         => $this->input->post('volumeCreateSubfolder'),
        'volumeRemoveFilesAndFolders'   => $this->input->post('volumeRemoveFilesAndFolders'),
        'volumeEditImages'              => $this->input->post('volumeEditImages'),
        'utilitiesUpdates'              => $this->input->post('utilitiesUpdates'),
        'utilitiesSystemReport'         => $this->input->post('utilitiesSystemReport'),
        'utilitiesPHPInfo'              => $this->input->post('utilitiesPHPInfo'),
        'utilitiesSystemMessage'        => $this->input->post('utilitiesSystemMessage'),
        'utilitiesAssetIndexes'         => $this->input->post('utilitiesAssetIndexes'),
        'utilitiesClearCaches'          => $this->input->post('utilitiesClearCaches'),
        'utilitiesDeprecationWarnings'  => $this->input->post('utilitiesDeprecationWarnings'),
        'utilitiesDatabaseBackup'       => $this->input->post('utilitiesDatabaseBackup'),
        'utilitiesFindAndReplace'       => $this->input->post('utilitiesFindAndReplace'),
        'utilitiesMigrations'           => $this->input->post('utilitiesMigrations'),
      );

      $data = array(
        'username'        =>  $this->input->post('username'),
        'group_id'        =>  $this->input->post('group'),
        'role_id'         =>  $this->input->post('role'),
        'email'           =>  $this->input->post('email'),
        'firstname'       =>  $this->input->post('firstname'),
        'lastname'        =>  $this->input->post('lastname'),
        'token'           =>  random_string('alnum', 30),
        'activation_code' =>  random_string('numeric', 6),
        'created_by'      =>  $this->data['userdata']['id'],
        'settings'        =>  json_encode($permission_settings),
      );
      ($settings['id'] ? $data['updated_by'] = $this->data['userdata']['id'] : $data['created_by'] = $this->data['userdata']['id']);
      ($settings['id'] ? $data_content['updated_by'] = $this->data['userdata']['id'] : $data_content['created_by'] = $this->data['userdata']['id']);

      if ($settings['button'] == 'create') {
        $data_content['users_id'] = $this->general_m->create('users', $data);
      } else {
        $this->general_m->update('users', $data, $settings['id']);
        $data_content['users_id'] = $settings['id'];
      }

      $keys = array_keys($this->input->post());
      foreach ($keys as $key) {
        if (strpos($key, 'fields') !== false) {
          if (is_array($this->input->post($key))) {
            $data_content[$key] = implode(', ', $this->input->post($key));
          } else {
            $data_content[$key] = $this->input->post($key);
          }
        }
      }
      if ($settings['button'] == 'create') {
        $this->general_m->create('users_content', $data_content);
        helper_log('add', "Create has successfully");
        $this->session->set_flashdata('message', "data {$settings['table']} has successfully created");
      } else {
        $this->general_m->update('users_content', $data_content, $settings['id'], 'users_id');
        helper_log('edit', "Update has successfully");
        $this->session->set_flashdata('message', "data {$settings['table']} has successfully updated");
      }
    
      $settings['status'] = TRUE;
      echo json_encode($settings);
    } else {
      $settings['errors'] = array(
        'username' => form_error('username'),
        'email'    => form_error('email')
      );
      $settings['status'] = FALSE;
      echo json_encode($settings);
    }
  }

  public function jsonUsersSettingsForm(){
    if ($this->input->post('handle') == 'fields') {
      $data = array(
        'fields_id'          => json_encode($this->input->post('fieldsId')),
        'updated_by'         => $this->data['userdata']['id'],
      );
    } else {
      $users_settings = array(
        'assetsSourcesList'  => $this->input->post('assetsSourcesList'),
        'allowRegistration'  => $this->input->post('allowRegistration'),
        'path'               => $this->input->post('path'),
        'email_verification' => $this->input->post('email_verification'),
        'default_group'      => $this->input->post('default_group'),
      );
      $data = array(
        'settings'   =>  json_encode($users_settings),
        'updated_by' => $this->data['userdata']['id'],
      );
    }
    $this->general_m->update($settings['table'], $data, $settings['id'], 'handle');

    if ($this->input->post('handle') == 'fields') {
      $settings['getDataby_id'] = $this->general_m->get_row_by_fields('users_settings', array('handle' => 'settings'));
      $table_content    = 'users_content';
      $getFieldsAll     = $this->fields_m->get_all_results();
      $getContentFields = $this->db->list_fields($table_content);
      if (json_decode($settings['getDataby_id']->fields_id) != NULL) {
        // check fieldsid in element
        $listFields = json_decode($settings['getDataby_id']->fields_id);
        
        /*Check Delete Column*/
        foreach ($getFieldsAll as $key) {
          if (in_array("fields_{$key->handle}", $getContentFields)) {
            if (!in_array($key->id, array_unique($listFields))) {
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
        /*Add Column COntent*/
        foreach ($getFieldsAll as $key) {
          if (!in_array("fields_{$key->handle}", $getContentFields)) {
            if (in_array($key->id, array_unique($listFields))) {
              $getFieldsType = $this->general_m->get_row_by_id('fields_type', $key->type_id);
              $fields = array (
                'handle' => $key->handle,
                'type'   => $getFieldsType->type,
              );
              modifyColumn($fields, 'add-table', $table_content); 
            }
          }
        } 
      } else {
        /*Check Delete Column*/
        if ($getFieldsAll) {
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
      }
    }
    $settings['status'] = TRUE;
    echo json_encode($settings);
  }


  /**
   * Assets Upload
   * This Function Use TO Show Modal Assets By ID
   */
  public function jsonDisplayModalAssets(){
    $settings = array(
      'parent_id'      => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'   => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'  => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'             => ($this->input->post('id') ? $this->input->post('id') : ''),
      'assets_fields'  => $this->input->post('assets_fields'),
      'assets_id'      => ($this->input->post('assets_id') ? $this->input->post('assets_id') : 0 ),
      'assets_source'  => ($this->input->post('assets_source') ?  $this->input->post('assets_source') : 'default'),
      'assets_limit'   => ($this->input->post('assets_limit') ? $this->input->post('assets_limit') : ''),      
      'list_selected'  => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
    );

    $settings['assets']         = $this->general_m->get_row_by_id('assets', $settings['assets_id']);
    $settings['assets_content'] = $this->general_m->get_result_by_id('assets_content', $settings['assets_id'], 'assets_id');
    $folder = (($settings['assets']) ? $settings['assets']->handle : lcfirst($settings['assets_source']));
    $i = 0;
    $table_view = '
      <div class="d-flex flex-wrap justify-content-between p-1" id="modal-main">
        <div class="col-2" id="modal-main-left">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    $table_view .= '
      <a class="nav-link '.((++$i == 1) ? 'active' : '').'" id="v-pills-'.$settings['assets_id'].'-tab" data-toggle="pill" 
      href="#v-pills-'.$settings['assets_id'].'" role="tab" aria-controls="v-pills-'.$settings['assets_id'].'" aria-selected="true">'
      .($settings['assets'] ? ucfirst($settings['assets']->name) : 'Default').'</a>';
    $table_view .= '</div></div>';

    $table_view .= '
    <div class="col-10" id="modal-main-right">
      <div class="tab-content" id="v-pills-tabContent">
        <input type="hidden" class="form-control" name="parent_id" value="'.$settings['parent_id'].'">
        <input type="hidden" class="form-control" name="parent_table" value="'.$settings['parent_table'].'">
        <input type="hidden" class="form-control" name="table_content" value="'.$settings['table_content'].'">
        <input type="hidden" class="form-control" name="id" value="'.$settings['id'].'">
        <input type="hidden" class="form-control" name="assets_id" value="'.$settings['assets_id'].'">
        <input type="hidden" class="form-control" name="assets_source" value="'.$folder.'">
        <input type="hidden" class="form-control" name="assets_limit" value="'.$settings['assets_limit'].'">';


    $i = 0;
    if ($settings['assets_content']) {
      $table_view .= '
        <div class="tab-pane fade '.((++$i == 1) ? 'show active' : '').'" id="v-pills-'.$settings['assets_id'].'" 
        role="tabpanel" aria-labelledby="v-pills-'.$settings['assets_id'].'-tab">';
      $check_content = $this->general_m->get_row_by_id('assets_content', $settings['assets_id'], 'assets_id');
      if ($check_content) {
        $table_view .= '
          <table class="table table-sm text-left assets-content-list datatableModal">
            <thead>
              <tr>
                <th class="table-no" scope="row">#</th>
                <th scope="col">Title</th>
                <th scope="col">Filename</th>
                <th style="width:15%" scope="col">File Size</th>
                <th style="width:25%" scope="col">File Modified Date</th>
              </tr>
            </thead>
            <tbody>';  
        $no = 0;
        foreach ($settings['assets_content'] as $key) {
          $filename   = explode('.', $key->file);
          $name       = current($filename);
          $thumb      = current($filename).'_thumb.'.end($filename);
          $file_thumb = base_url("{$key->path_thumb}/{$thumb}");
          $getSize    = get_headers($file_thumb, 1); 
          $table_view .= '
            <tr>
              <input type="hidden" name="id" value="'.$key->id.'" data-id="'.$key->id.'">
              <td class="table-no" scope="row">'.++$no.'</td>
              <td style="width:30%"><img src="'.$file_thumb.'" class="img-thumbnail"/>
              '.((strlen($name) <= 22) ? ucfirst($name) : substr(ucfirst($name), 0, 22)."...").'</td>
              <td style="width:30%">'.((strlen($name) <= 22) ? $key->file : substr($key->file, 0, 22)."...".$key->ext).'</td>
              <td style="width:15%;">'.$key->size.' kB </td>
              <td style="width:20%;">'.date("d/m/Y h:i A", strtotime($key->created_at)).'</td>
            </tr>';
        }
        $table_view .= '</tbody></table>';
      } else {
        $table_view .= '<p class="empty-data assets-content-list">Data is Empty</p>';
      }
      $table_view .= '</div>';
    } else {
      $table_view .= '<p class="empty-data assets-content-list">Data is Empty</p>';
    }
    $table_view .= '</div></div>';

    echo json_encode($table_view);
  }

 
  /**
   * This Function Use To Choice Assets In Modal Show 
   */
  public function jsonSubmitModalAssets(){
    $settings = array(
      'parent_id'         => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'      => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'     => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'                => ($this->input->post('id') ? $this->input->post('id') : ''),
      'assets_fields'     => $this->input->post('assets_fields'),
      'assets_id'         => ($this->input->post('assets_id') ? $this->input->post('assets_id') : 0 ),
      'assets_source'     => ($this->input->post('assets_source') ?  $this->input->post('assets_source') : 'default'),
      'assets_limit'      => ($this->input->post('assets_limit') ? $this->input->post('assets_limit') : ''),      
      'list_selected'     => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
      'assets_content_Id' => $this->input->post('assets_content_Id'),
    );

    if ($settings['assets_content_Id'] && $settings['list_selected']) {
      $assetsList = array_unique( array_merge($settings['list_selected'], $settings['assets_content_Id']));
    } elseif ($settings['assets_content_Id'] && empty($settings['list_selected'])) {
      $assetsList = $settings['assets_content_Id'];
    } elseif (empty($settings['assets_content_Id']) && $settings['list_selected']) {
      $assetsList = $settings['list_selected'];
    } else {
      $assetsList = [];
    }

    $view = '';
    $i = 0;
    foreach ($assetsList as $key => $value) {
      $assetsContentById = $this->general_m->get_row_by_id('assets_content', $value);
      $filename   = explode('.', $assetsContentById->file);
      $name       = current($filename);
      $thumb      = current($filename).'_thumb.'.end($filename);
      $file_thumb = base_url("{$assetsContentById->path_thumb}/{$thumb}");
      $getSize    = get_headers($file_thumb, 1);

      if ($settings['assets_limit']) {
        ++$i;
        if ($i <= $settings['assets_limit']) {
          $view .= '
              <li><input type="hidden" name="'.$settings['assets_fields'].'[]" value="'.$value.'" class="assets-list">
                <img src="'.$file_thumb.'" class="img-thumbnail list" data-id="'.$value.'" heigth="20" width="30"/>
                <label for="input'.$name.'">'.$name.'</label>
                <a><i class="fa fa-times" aria-hidden="true"></i></a
              </li>
            ';
        }
      } else {
        $view .= '
            <li><input type="hidden" name="'.$settings['assets_fields'].'[]" value="'.$value.'" class="assets-list">
              <img src="'.$file_thumb.'" class="img-thumbnail list" data-id="'.$value.'" heigth="20" width="30"/>
              <label for="input'.$name.'">'.$name.'</label>
              <a><i class="fa fa-times" aria-hidden="true"></i></a
            </li>
          ';
      }
    }

    $data = array(
      'html' =>  $view,
      'counter' => $i
    );
    echo json_encode($data);
  }

  /**
   * Function upload assets in entries
   * This function use to upload assets in entries template and auto reload in modal
   */
  public function jsonUploadModalAssets(){
    $settings = array(
      'assets_id'     => $this->input->post('assets_id'),
      'assets_source' => $this->input->post('assets_source'),
      'upload_path'   => "uploads/admin/assets/{$this->input->post('assets_source')}",
    );

    //upload.php
    if($_FILES["assets-modal-file"]["name"] != ''){
      $file = str_replace(' ', '-', $_FILES['assets-modal-file']['name']);
      $config = $this->config->item('setting_upload');
      $config['upload_path'] = $settings['upload_path'];
      $config['file_name']   = $file;

      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      } 
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('assets-modal-file')){
        $error = array('error' => $this->upload->display_errors());
      } else{
        $result     = array('upload_data' => $this->upload->data());
        $path_thumb = "{$settings['upload_path']}/thumb";
        $filename   = explode('.', $result['upload_data']['file_name']);
        $file_thumb = current($filename).'_thumb.'.end($filename);
        $data = array(
          'assets_id'  => $settings['assets_id'],
          'file'       => $result['upload_data']['file_name'],
          'file_thumb' => $file_thumb,
          'ext'        => $result['upload_data']['file_ext'],
          'size'       => $result['upload_data']['file_size'],
          'path'       => $settings['upload_path'],
          'path_thumb' => $path_thumb,
          'created_by' => $this->data['userdata']['id'],
        );
        //INSERT Assets content 
        $this->general_m->create('assets_content', $data);
        helper_log('add', "Create Assets Content has successfully");
      }

      // create Thumbs
      $config = $this->config->item('settings_image');
      $config['source_image'] = "{$settings['upload_path']}/{$file}";
      $config['create_thumb'] = TRUE;
      $config['new_image']    = "{$settings['upload_path']}/thumb";
      if (!is_dir($config['new_image'])) {
        mkdir($config['new_image'], 0777, TRUE);
      } 
      $this->image_lib->initialize($config);
      if ( ! $this->image_lib->resize()){
        echo $this->image_lib->display_errors();
      }
      // clear //
      $this->image_lib->clear();
  
      $table_view = '';
      $settings['assets_content'] = $this->general_m->get_result_by_id('assets_content', $settings['assets_id'], 'assets_id');
      $i = 0;
      if ($settings['assets_content']) {
        $check_content = $this->general_m->get_row_by_id('assets_content', $settings['assets_id'], 'assets_id');
        if ($check_content) {
          $table_view .= '
            <table class="table table-sm text-left assets-content-list datatableModal">
              <thead>
                <tr>
                  <th class="table-no" scope="row">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Filename</th>
                  <th style="width:15%" scope="col">File Size</th>
                  <th style="width:25%" scope="col">File Modified Date</th>
                </tr>
              </thead>
              <tbody>';  
            $no = 0;
            foreach ($settings['assets_content'] as $key) {
              $filename   = explode('.', $key->file);
              $name       = current($filename);
              $thumb      = current($filename).'_thumb.'.end($filename);
              $file_thumb = base_url("{$key->path_thumb}/{$thumb}");
              $getSize    = get_headers($file_thumb, 1); 
              $table_view .= '
                <tr>
                  <input type="hidden" name="id" value="'.$key->id.'" data-id="'.$key->id.'">
                  <td class="table-no" scope="row">'.++$no.'</td>
                  <td style="width:30%"><img src="'.$file_thumb.'" class="img-thumbnail"/>
                  '.((strlen($name) <= 22) ? ucfirst($name) : substr(ucfirst($name), 0, 22)."...").'</td>
                  <td style="width:30%">'.((strlen($name) <= 22) ? $key->file : substr($key->file, 0, 22)."...".$key->ext).'</td>
                  <td style="width:15%;">'.$key->size.' kB </td>
                  <td style="width:20%;">'.date("d/m/Y h:i A", strtotime($key->created_at)).'</td>
                </tr>';
            }
            $table_view .= '</tbody></table>';
        } else {
          $table_view .= '<p class="empty-data assets-content-list">Data is Empty</p>';
        }
      } else {
        $table_view .= '<p class="empty-data assets-content-list">Data is Empty</p>';
      }
      echo json_encode($table_view);
    }
  }


  /**
   * This Function Use TO Show Modal Categories By ID
   */
  public function jsonDisplayModalCategories(){
    $settings = array(
      'parent_id'          => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'       => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'      => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'                 => ($this->input->post('id') ? $this->input->post('id') : ''),
      'categories_fields'  => $this->input->post('categories_fields'),
      'categories_id'      => ($this->input->post('categories_id') ? $this->input->post('categories_id') : '' ),
      'categories_limit'   => ($this->input->post('categories_limit') ? $this->input->post('categories_limit') : ''),      
      'list_selected'      => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
      'categories'         => $this->general_m->get_row_by_id('categories', $this->input->post('categories_id')),
      'categories_content' => $this->general_m->get_result_by_id('categories_content', $this->input->post('categories_id'), 'categories_id'),
    );

    $i = 0;
    $table_view = '
      <div class="d-flex flex-wrap justify-content-between p-1" id="modal-main">
        <div class="col-3" id="modal-main-left">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    $table_view .= '
      <a class="nav-link '.((++$i == 1) ? 'active' : '').'" id="v-pills-'.$settings['categories']->id.'-tab" data-toggle="pill" href="#v-pills-'.$settings['categories']->id.'" role="tab" aria-controls="v-pills-'.$settings['categories']->id.'" aria-selected="true">'.ucfirst($settings['categories']->name).'</a>';
    $table_view .= '</div></div>';

    $table_view .= '
    <div class="col-9" id="modal-main-right">
      <div class="tab-content" id="v-pills-tabContent">
        <input type="hidden" class="form-control" name="parent_id" value="'.$settings['parent_id'].'">
        <input type="hidden" class="form-control" name="parent_table" value="'.$settings['parent_table'].'">
        <input type="hidden" class="form-control" name="table_content" value="'.$settings['table_content'].'">
        <input type="hidden" class="form-control" name="id" value="'.$settings['id'].'">
        <input type="hidden" class="form-control" name="categories_id" value="'.$settings['categories_id'].'">
        <input type="hidden" class="form-control" name="categories_limit" value="'.$settings['categories_limit'].'">';


    $i = 0;
    if ($settings['categories_content']) {
        $table_view .= '
          <div class="tab-pane fade '.((++$i == 1) ? 'show active' : '').'" id="v-pills-'.$settings['categories']->id.'" 
          role="tabpanel" aria-labelledby="v-pills-'.$settings['categories']->id.'-tab">';
        $check_content = $this->general_m->get_row_by_id('categories_content', $settings['categories_id'], 'categories_id');
        if ($check_content) {
          $table_view .= '
            <table class="table table-sm text-left datatableModal">
              <thead>
                <tr>
                  <th class="table-no" scope="row">#</th>
                  <th scope="col">Title</th>
                </tr>
              </thead>
              <tbody>'; 
          $no = 0;
          foreach ($settings['categories_content'] as $val) {
            $table_view .= '<tr>
                <input type="hidden" name="id" value="'.$val->id.'" data-id="'.$val->id.'">
                <td class="table-no" scope="row">'.++$no.'</td>
                <td>'.ucfirst($val->title).'</td>
                </tr>';
          }
          $table_view .= '</tbody></table>';
        } else {
          $table_view .= '<p class="empty-data">Data is Empty</p>';
        }
        $table_view .= '</div>';
    } else {
      $table_view .= '<p class="empty-data">Data is Empty</p>';
    }
    $table_view .= '</div></div>';

    echo json_encode($table_view);
  }

   /**
   * This Function Use To Choice Categories In Modal Show 
   */
  public function jsonSubmitModalCategories(){
    $settings = array(
      'parent_id'             => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'          => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'         => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'                    => ($this->input->post('id') ? $this->input->post('id') : ''),
      'categories_fields'     => $this->input->post('categories_fields'),
      'categories_id'         => ($this->input->post('categories_id') ? $this->input->post('categories_id') : '' ),
      'categories_limit'      => ($this->input->post('categories_limit') ? $this->input->post('categories_limit') : ''),      
      'list_selected'         => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
      'categories'            => $this->general_m->get_row_by_id('categories', $this->input->post('categories_id')),
      'categories_content'    => $this->general_m->get_result_by_id('categories_content', $this->input->post('categories_id'), 'categories_id'),
      'categories_content_id' => $this->input->post('categories_content_id'),
    );

    if ($settings['categories_content_id'] && $settings['list_selected']) {
      $categories_list = array_unique( array_merge($settings['list_selected'], $settings['categories_content_id']));
    } elseif ($settings['categories_content_id'] && empty($settings['list_selected'])) {
      $categories_list = $settings['categories_content_id'];
    } elseif (empty($settings['categories_content_id']) && $settings['list_selected']) {
      $categories_list = $settings['list_selected'];
    } else {
      $categories_list = [];
    }
  
    $list_view = '';
    $i = 0;
    foreach ($categories_list as $key => $value) {
      $categoriesContentby_id = $this->general_m->get_row_by_id('categories_content', $value);
      if ($settings['categories_limit']) {
        ++$i;
        if ($i <= $settings['categories_limit']) {
          $list_view .= '
              <li><input type="hidden" name="'.$settings['categories_fields'].'[]" value="'.$value.'" class="categories-list">
                <label for="input'.$categoriesContentby_id->title.'">'.$categoriesContentby_id->title.'</label>
                <a><i class="fa fa-times" aria-hidden="true"></i></a
              </li>
            ';
        }
      } else {
        $list_view .= '
            <li><input type="hidden" name="'.$settings['categories_fields'].'[]" value="'.$value.'" class="categories-list">
              <label for="input'.$categoriesContentby_id->title.'">'.$categoriesContentby_id->title.'</label>
              <a><i class="fa fa-times" aria-hidden="true"></i></a
            </li>
          ';
      }
    }

    $data = array(
      'list_view' =>  $list_view,
      'counter'   => $i
    );
    echo json_encode($data);
  }

  /**
   * This Function Use TO Show Modal Entries By ID
   */
  public function jsonDisplayModalEntries(){
    $settings = array(
      'parent_id'       => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'    => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'   => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'              => ($this->input->post('id') ? $this->input->post('id') : ''),
      'entries_fields'  => $this->input->post('entries_fields'),
      'section_id'      => ($this->input->post('section_id') ? $this->input->post('section_id') : '' ),
      'entries_limit'   => ($this->input->post('entries_limit') ? $this->input->post('entries_limit') : ''),      
      'list_selected'   => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
      'section'         => $this->general_m->get_row_by_id('section', $this->input->post('section_id')),
      'section_entries' => $this->general_m->get_result_by_id('section_entries', $this->input->post('section_id'), 'section_id'),
      'content'         => $this->general_m->get_result_by_id('content', $this->input->post('section_id'), 'section_id'),
    );

    $i = 0;
    $table_view = '
    <div class="d-flex flex-wrap justify-content-between p-1" id="modal-main">
      <div class="col-3" id="modal-main-left">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    foreach ($settings['section_entries'] as $key) {
      ++$i;
      $table_view .= '
          <a class="nav-link '.(($i == 1) ? 'active' : '').'" id="v-pills-'.$key->id.'-tab" data-toggle="pill" href="#v-pills-'.$key->id.'" role="tab" aria-controls="v-pills-'.$key->id.'" aria-selected="true">'.ucfirst($key->title).'</a>';
    }
    $table_view .= '</div></div>';

    $table_view .= '
    <div class="col-9" id="modal-main-right">
      <div class="tab-content" id="v-pills-tabContent">
        <input type="hidden" class="form-control" name="parent_id" value="'.$settings['parent_id'].'">
        <input type="hidden" class="form-control" name="parent_table" value="'.$settings['parent_table'].'">
        <input type="hidden" class="form-control" name="table_content" value="'.$settings['table_content'].'">
        <input type="hidden" class="form-control" name="id" value="'.$settings['id'].'">
        <input type="hidden" class="form-control" name="section_id" value="'.$settings['section_id'].'">
        <input type="hidden" class="form-control" name="entries_limit" value="'.$settings['entries_limit'].'">';


    $i = 0;
    if ($settings['content']) {
      foreach ($settings['section_entries'] as $key) {
        ++$i;
        $table_view .= '<div class="tab-pane fade '.(($i == 1) ? 'show active' : '').'" id="v-pills-'.$key->id.'" role="tabpanel" aria-labelledby="v-pills-'.$key->id.'-tab">';
        $check_content = $this->general_m->get_row_by_id('content', $key->id, 'entries_id');
        if ($check_content) {
          $table_view .= '
            <table class="table table-sm text-left datatableModal">
              <thead>
                <tr>
                  <th class="table-no" scope="row">#</th>
                  <th scope="col">Title</th>
                </tr>
              </thead>
              <tbody>'; 
          $no = 0;
          foreach ($settings['content'] as $val) {
            if ($key->id == $val->entries_id) {
              $table_view .= '<tr>
                  <input type="hidden" name="id" value="'.$val->id.'" data-id="'.$val->id.'">
                  <td class="table-no" scope="row">'.++$no.'</td>
                  <td>'.ucfirst($val->title).'</td>
                  </tr>';
              
            }
          }
         $table_view .= '</tbody></table>';
        } else {
          $table_view .= '<p class="empty-data">Data is Empty</p>';
        }
        $table_view .= '</div>';
      }
    } else {
      $table_view .= '<p class="empty-data">Data is Empty</p>';
    }
    $table_view .= '</div></div>';

    echo json_encode($table_view);
  }

   /**
   * This Function Use To Choice Entries In Modal Show 
   */
  public function jsonSubmitModalEntries(){
    $settings = array(
      'parent_id'          => ($this->input->post('parent_id') ? $this->input->post('parent_id') : ''),
      'parent_table'       => ($this->input->post('parent_table') ? $this->input->post('parent_table') : ''),
      'table_content'      => ($this->input->post('table_content') ? $this->input->post('table_content') : ''),
      'id'                 => ($this->input->post('id') ? $this->input->post('id') : ''),
      'entries_fields'     => $this->input->post('entries_fields'),
      'section_id'         => ($this->input->post('section_id') ? $this->input->post('section_id') : '' ),
      'entries_limit'      => ($this->input->post('entries_limit') ? $this->input->post('entries_limit') : ''),      
      'list_selected'      => ($this->input->post('list_selected') ? $this->input->post('list_selected') : ''),
      'section'            => $this->general_m->get_row_by_id('section', $this->input->post('section_id')),
      'section_entries'    => $this->general_m->get_result_by_id('section_entries', $this->input->post('section_id'), 'section_id'),
      'content'            => $this->general_m->get_result_by_id('content', $this->input->post('section_id'), 'section_id'),
      'entries_content_id' => $this->input->post('entries_content_id'),
    );

    if ($settings['entries_content_id'] && $settings['list_selected']) {
      $entries_List = array_unique( array_merge($settings['list_selected'], $settings['entries_content_id']));
    } elseif ($settings['entries_content_id'] && empty($settings['list_selected'])) {
      $entries_List = $settings['entries_content_id'];
    } elseif (empty($settings['entries_content_id']) && $settings['list_selected']) {
      $entries_List = $settings['list_selected'];
    } else {
      $entries_List = [];
    }

    $list_view = '';
    $i = 0;
    foreach ($entries_List as $key => $value) {
      $entriescontentby_id = $this->general_m->get_row_by_id('content', $value);
      if ($entries_List) {
        ++$i;
        if ($i <= $settings['entries_limit']) {
          $list_view .= '
              <li><input type="hidden" name="'.$settings['entries_fields'].'[]" value="'.$value.'" class="entries-list">
                <label for="input'.$entriescontentby_id->title.'">'.$entriescontentby_id->title.'</label>
                <a><i class="fa fa-times" aria-hidden="true"></i></a
              </li>
            ';
        }
      } else {
        $list_view .= '
            <li><input type="hidden" name="'.$settings['entries_fields'].'[]" value="'.$value.'" class="entries-list">
              <label for="input'.$entriescontentby_id->title.'">'.$entriescontentby_id->title.'</label>
              <a><i class="fa fa-times" aria-hidden="true"></i></a
            </li>
          ';
      }
    }

    $data = array(
      'list_view' =>  $list_view,
      'counter' => $i
    );
    echo json_encode($data);
  }


}

/* End of file Api.php */
/* Location: ./application/controllers/admin/Api.php */