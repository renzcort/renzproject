<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/Section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
    $this->data = array(
      'userdata'  =>  $this->first_load(),
      'parentLink' => 'admin/section', 
    );
  }

  /**
   * Section Entries Create
   * @return [type] [description]
   */
  public function jsonTabsFields() {
    ($this->input->post('id') ? $id = $this->input->post('id') : $id = '');
    ($this->input->post('section_id') ? $section_id = $this->input->post('section_id') : $section_id = '');

    $button     = $this->input->post('button');
    $settings = array(
      'title'          =>  $this->input->post('header'),
      'subtitle'       =>  ($this->input->post('subtitle') ? $this->input->post('subtitle') : FALSE),
      'breadcrumb'     =>  FALSE,
      'subbreadcrumb'  =>  FALSE,
      'button'         =>  (($button == 'create') ? 'Save' : 'Update'),
      'button_type'    =>  'submit',
      'button_name'    =>  (($button == 'create') ? 'create' : 'Update'),
      'button_tabs'    =>  TRUE,
      'content'        =>  $this->input->post('content'),
      'table'          =>  $this->input->post('table'),
      'fields_element' =>  $this->input->post('fields_element'),
      'action'         =>  $this->input->post('action'),
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'section_id'     =>  $section_id,
      'section'        =>  $this->section_m->get_row_by_id($section_id),
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
    );
    $table_id = (($settings['table'] == 'section_entries') ? 'entries_id' : "{$settings['table']}_id" );  
    if ($button == 'update') {
      $settings['getDataby_id']  =  $this->general_m->get_row_by_id($settings['table'], $id);
      $settings['element']       =  $this->general_m->get_result_by_id($settings['fields_element'], $id, $table_id);

      if ($settings['element']) {
        foreach ($settings['element'] as $key) {
          $fieldsId[] = $key->fields_id; 
        }
        $settings['elementFields'] = $fieldsId;
      } else {
        $settings['elementFields'] = [];
      }
    }        

    $this->form_validation->set_rules('name', 'Name', "trim|required|is_unique[renz_{$settings['table']}.name]");
    $this->form_validation->set_rules('handle', 'Handle', "trim|required|is_unique[renz_{$settings['table']}.handle]");
    if (isset($_POST['title'])) {
      $this->form_validation->set_rules('title', 'Title', 'trim|required');
    }

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
          'path'       => $this->input->post('path'),
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
      }

      
      if ($button == 'create') {
        $data['created_by'] = $this->data['userdata']['id'];
        $tableFieldsId      = $this->general_m->create($settings['table'], $data);
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

      //get fields to element 
      (empty($id) ? $id = $tableFieldsId : $id = $id);
      $this->general_m->delete($settings['fields_element'], $id, $table_id);
      /*add elements*/
      if (!empty($fieldsId)) {
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
      } 

      (($settings['table'] == 'section_entries') ? $table_content = 'content' : $table_content = "{$settings['table']}_content");
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

  // Update Move Order 
  public function jsonUpdateOrderEntrytypes(){
    $id = $this->input->post('id');
    $order = $this->input->post('order');
    $i = 0;
    foreach ($id as $key => $val) {
      $data = array('order' => ++$i);
      $update = $this->entries_m->update($data, $val);
    }
    echo json_encode($update);
  }
  /*END Section*/

  /**
   * GROUP API
   */
    // JSON update data 
  public function jsonGetGroupsById() {
    header('Content-type: application/json');
    $group_id   = $this->input->post('group_id');
    $group_name = $this->input->post('group_name');
    $groups     = $this->general_m->get_row_by_id($group_name, $group_id);
    echo json_encode($groups);
  }

    // JSON Delete
  public function jsonDeleteGroupsById() {
    header('Content-type: application/json');
    $group_id     = $this->input->post('group_id');
    $group_name   = $this->input->post('group_name');
    $element_name = $this->input->post('element_name');
    $table        = $this->input->post('table');
    $getFields  = $this->general_m->get_result_by_id($table, $group_id, 'group_id');
    if ($getFields) {
      if ($table == 'fields') {
        $opt_id = [];
        foreach ($getFields as $key) {
          $getContentFields = $this->db->list_fields('content');
          foreach ($getContentFields as $value) {
            if ($value == "fields_{$key->handle}") {
              $fields = array(
                'handle' => $key->handle,
              );
              modifyColumn($fields, 'drop');
            }
          }
          $opt_id[] = $key->option_id;
          $getElement = $this->general_m->get_row_by_id('element', $key->id, 'fields_id');
          if ($getElement) {
            $deleteElement = $this->general_m->delete('element', $key->id, 'fields_id');
          }
        } 
        $deleteTable = $this->general_m->delete($table, $group_id, 'group_id'); 
        foreach ($opt_id as $value) {
          $deleteOption = $this->general_m->delete('fields_option', $value);  
        }
      } else {
        if ($element_name) {
          foreach ($getFields as $key) {
            $getElement = $this->general_m->get_row_by_id("{$table}_element", $key->id, "{$table}_id");
            if ($getElement) {
              $deleteElement = $this->general_m->delete("{$table}_element", $key->id, "{$table}_id");
            }
          }
        }
        $delete = $this->general_m->delete($table, $group_id, 'group_id');
      }
    }
    $deleteGroup = $this->general_m->delete($group_name, $group_id);
    $data = array(
      'action' => "admin/{$table}",
      'delete' => 'success'
    );
    $this->session->set_flashdata('message', "Groups has successfully deleted");
    echo json_encode($data);
  }
  
  // Show Fields By Id Groups
  public function jsonGetDataByIdGroups(){
    header('content-type: application/json');
    $table = ($this->input->post('table') ? $this->input->post('table') : '');
    $group_name = ($this->input->post('group_name') ? $this->input->post('group_name') : '');
    $action_name = ($this->input->post('action_name') ? $this->input->post('action_name') : '');
    $settings = array(
      'table'       =>  $table,
      'action'      =>  $action_name,
      'group'       =>  $this->general_m->get_all_results($group_name),
      'group_count' =>  $this->general_m->count_all_results($group_name),
      'group_id'    =>  (($this->input->post('group_id') == 'all') ? '' : $this->input->post('group_id')),
    );
    $fields = ((in_array($table, array('fields', 'sites'))) ? 'group_id' : "{$group_name}_id");
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
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, $settings['group_id'], $fields);
    
    $settings['links']      = $this->pagination->create_links();
    if($settings['record_all']) {
      if ($table == 'sites') {
        $table_view = '
          <table class="table table-sm">
            <thead>
              <tr>
                <th scope="row">#</th>
                <th scope="col">Name</th>
                <th scope="col">Handle</th>
                <th scope="col">Languange</th>
                <th scope="col">Primary</th>
                <th scope="col">Base URL</th>
                <th scope="row"></th>
              </tr>
            </thead>
            <tbody>'; 
          $no = 0;
          foreach ($settings['record_all'] as $key) {
             $table_view .= '<tr>
                <td scope="row">'.++$no.'</td>
                <td><a href="'.base_url($settings['action'].'/edit/'.$key->id).'">'.($key->name ? $key->name : '').'</a></td>
                <td>'.($key->handle ? $key->handle : '').'</td>
                <td>'.($key->locale ? $key->locale : '').'</td>
                <td>'.(!empty($key->primary) ? 'Yes' : 'No').'</td>
                <td>'.($key->url ? $key->url : '').'</td>
                <td scope="row">
                  <a href="'.base_url($settings['action'].'/delete/'.$key->id).'" data-id="'.$key->id.'">
                  <i class="fas fa-minus-circle"></i></a>
                </td> 
              </tr>';
            }
          $table_view .= '</tbody></table>';
      } elseif ($table == 'fields') {
        $table_view = '
          <table class="table table-sm">
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
          foreach ($settings['record_all'] as $key) {
            $type = $this->general_m->get_row_by_id('fields_type', $key->type_id);
             $table_view .= '<tr>
                <th scope="row">'.++$no.'</th>
                <td><a href="'.base_url($settings['action'].'/edit/'.$key->id).'">'.($key->name ? $key->name : '').'</a></td>
                <td>'.($key->handle ? $key->handle : '').'</td>
                <td>'.$type->name.'</td>
                <td><a href="'.base_url($settings['action'].'/delete/'.$key->id).'" data-id="'.$key->id.'">
                  <i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>';
            }
          $table_view .= '</tbody></table>';
      } elseif ($table = 'assets_content') {
        $table_view = '
          <table class="table table-sm">
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
        foreach ($settings['record_all'] as $key) {
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
              <td>'.($key->created_at ? $key->created_at : '').'</td>
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
   * Fields API Start
   */
  // delete by json
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


  /*Upload Assets*/
  public function uploadWithoutSubmit() {
    (($this->input->post('group_id') == 'all') ? $id = '0' : $id = $this->input->post('group_id'));
    (($id == '') ? '' : $assets = $this->general_m->get_row_by_id('assets', $id));
    (($id == '') ? $folder = 'default' : $folder = lcfirst($assets->handle));
    $settings = array(
      'upload_path' => "uploads/admin/assets/{$folder}",
    );

    // if (file_exists("{$settings['upload_path']}/{$_FILES["file"]["name"]}")) {
    //   $this->output->set_status_header(401);
    //   exit;
    // }

    //upload.php
    if($_FILES["file"]["name"] != ''){
      $config = $this->config->item('setting_upload');
      $config['upload_path'] = $settings['upload_path'];
      $config['file_name']   = $_FILES["file"]["name"];
      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      } 
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('file')){
        $error = array('error' => $this->upload->display_errors());
      }
      else{
        $result = array('upload_data' => $this->upload->data());
        $path = "{$settings['upload_path']}/thumb";
        $data = array(
          'assets_id'  => (($id == '') ? 0 : $id),
          'file'       => $result['upload_data']['file_name'],
          'ext'        => $result['upload_data']['file_ext'],
          'size'       => $result['upload_data']['file_size'],
          'path'       => $path,
          'created_by' => $this->data['userdata']['id'],
        );
        //INSERT Assets content 
        $this->general_m->create('assets_content', $data);
        helper_log('add', "Create Assets Content has successfully");
      }

      // create Thumbs
      $config = $this->config->item('settings_image');
      $config['source_image'] = "{$settings['upload_path']}/{$_FILES["file"]["name"]}";
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

      $query = (($id == '0') ? $this->general_m->get_all_results('assets_content') : 
                $this->general_m->get_result_by_id('assets_content', $id, 'assets_id'));
      $record_all = $query;
      $no = 0;
      if ($record_all) {
        $table_view = '
          <table class="table table-sm">
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
              <td><img src="'.$file_thumb.'" class="img-thumbnail" heigth="10" width="20"/>'.ucfirst($name).'</td>
              <td>'.($key->file ? $key->file : '').'</td>
              <td>'.$getSize['Content-Length'].' kB </td>
              <td>'.($key->created_at ? $key->created_at : '').'</td>
              </tr>';
        }
        $table_view .= '</tbody></table>';
      } else {
        $table_view = '<p class="empty-data">Data is Empty</p>';
      }

      echo $table_view;
    }
  }

  /*Assets Upload*/
  public function jsonAssetsEntriesUpload(){
    $assets_id = (empty($this->input->post('id')) ? '0' : $this->input->post('id'));
    $settings = array(
      'assets'         => $this->general_m->get_row_by_id('assets', $assets_id),
      'assets_content' => $this->general_m->get_result_by_id('assets_content', $assets_id, 'assets_id'),
    );

    if ($settings['assets_content']) {
      $table_view = '
      <div id="uploadModal">
        <table class="table table-sm" id="datatableModal">
          <thead>
            <tr>
              <th style="width:5%" scope="row">#</th>
              <th scope="col">Title</th>
              <th scope="col">Post Date</th>
              <th style="width:10%" scope="col">File Size</th>
              <th style="width:25%" scope="col">File Modified Date</th>
            </tr>
          </thead>
          <tbody>'; 
        $no = 0;
      foreach ($settings['assets_content'] as $key) {
        $filename   = explode('.', $key->file);
        $name       = current($filename);
        $thumb      = current($filename).'_thumb.'.end($filename);
        $file_thumb = base_url("{$key->path}/{$thumb}");
        $getSize    = get_headers($file_thumb, 1); 
        $table_view .= '<tr>
            <input type="hidden" name="id" value="'.$key->id.'" data-id="'.$key->id.'">
            <td style:"width:5%;" scope="row">'.++$no.'</td>
            <td><img src="'.$file_thumb.'" class="img-thumbnail" heigth="10" width="20"/>'.ucfirst($name).'</td>
            <td>'.($key->file ? $key->file : '').'</td>
            <td style="width:10%;">'.$key->size.' kB </td>
            <td style="width:25%;">'.($key->created_at ? $key->created_at : '').'</td>
            </tr>';
      }
      $table_view .= '</tbody></table>';
    } else {
      $table_view = '<p class="empty-data">Data is Empty</p>';
    }
    $table_view .= '</div>';

    $data = array(
      'name'  =>  (!empty($settings['assets']->name) ? $settings['assets']->name : 'Default'),
      'table' =>  $table_view,
    );
    echo json_encode($data);
  }

  public function jsonAssetsSelectSubmit(){
    $assetsContentId = $this->input->post('assetsContentId');
    $assetsFields    = $this->input->post('assets_fields');
    $view = '';
    foreach ($assetsContentId as $key => $value) {
      $assetsContent  = $this->general_m->get_row_by_id('assets_content', $value);
      $filename   = explode('.', $assetsContent->file);
      $name       = current($filename);
      $thumb      = current($filename).'_thumb.'.end($filename);
      $file_thumb = base_url("{$assetsContent->path}/{$thumb}");
      $getSize    = get_headers($file_thumb, 1); 
      $view .= '
          <li><input type="hidden" name="'.$assetsFields.'[]" value="'.$value.'">
            <img src="'.$file_thumb.'" class="img-thumbnail assets-list" data-id="'.$value.'" heigth="20" width="30"/>
            <label for="input'.$name.'">'.$name.'</label>
            <a href=""><i class="fa fa-times" aria-hidden="true"></i></a
          </li>
        ';
    }

    $data = array(
      'html' =>  $view,
    );
    echo json_encode($data);
  }


  // Manage Entries 
  public function jsonEntriesManage() {
    $settings = array(
      'table'        => $this->input->post('table'),
      'button'       => $this->input->post('button'),
      'action'       => $this->input->post('action'),
      'parent_table' => (($this->input->post('parent_table') == 'section_entries') ? 'entries' : $this->input->post('parent_table')),
      'parent_id'    => $this->input->post('parent_id'),
      'id'           => $this->input->post('id'),
    ); 

    if ($this->input->post('parent_table') == 'section_entries') {
      $settings['section_id']  = $this->input->post('section_id');
      $settings['entriestype'] = $this->input->post('entriestype');
    }

    $parent_id = (($this->input->post('parent_table') == 'section_entries') ? $settings['entriestype'] : $settings['parent_id']);
    $data = array(
      'title'                          => $this->input->post('title'),
      'handle'                         => lcfirst(str_replace(' ', '', ucwords($this->input->post('title')))),
      'slug'                           => url_title(strtolower($this->input->post('title'))),
      'activated'                      => (empty($this->input->post('activated')) ? '0' : $this->input->post('activated')),
      'created_by'                     => $this->data['userdata']['id'],
      "{$settings['parent_table']}_id" => $parent_id,
    );
    (($this->input->post('parent_table') == 'section_entries') ? $data['section_id'] = $settings['section_id'] : ''  );

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
      $this->general_m->create($settings['table'], $data);
      helper_log('add', "Create {$settings['table']} has successfully");
      $this->session->set_flashdata('message', "data has successfully created");
    } elseif ($settings['button'] == 'update') {
      $this->general_m->update($settings['table'], $data, $settings['id']);
      helper_log('edit', "Update {$settings['table']} has successfully");
      $this->session->set_flashdata('message', "data has successfully updated");
    } 
    
    $settings['status'] = TRUE;
    echo json_encode($settings);
  }

  /*Select Entries Type*/
  public function jsonSelectEntriesType(){
    $id = $this->input->post('id');
    $section_entries = $this->general_m->get_row_by_id('section_entries', $id);
    $section         = $this->section_m->get_row_by_id($section_entries->section_id);
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
      'action'         =>  "admin/entries/{$section->handle}",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'section_id'     =>  $section->id,
      'section_entries'=>  $section_entries,
      'fields_element' =>  $this->general_m->get_result_by_fields('element', array('entries_id' => $id)),
      'fields'         =>  $this->fields_m->get_all_results(),
      'fields_type'    =>  $this->general_m->get_all_results('fields_type'),
      'fields_option'  =>  $this->general_m->get_all_results('fields_option'),
      'assets'         =>  $this->general_m->get_all_results('assets'),
      'assets_content' =>  $this->general_m->get_all_results('assets_content'),
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('section', 'order'),
      'parent_table'   =>  'section_entries',
      'parent_id'      =>  $section_entries->id,
      'id'             =>  $id,
      'getDataby_id'   =>  $this->general_m->get_row_by_id('content', $id),    
    );
    // var_dump($settings['fields']);die;
    $fields_id = [];
    foreach ($settings['fields_element'] as $key) {
      $fields_id[] = $key->fields_id;
    }
    $parent_id      = $settings['parent_id'];
    $fields_element = $settings['fields_element'];
    $fields         = $settings['fields'];
    $assets         = $settings['assets'];

    $html = '';
    if ($fields_element) {
      $html .= '<input type="hidden" name="parent_id" value="'.$parent_id.'">';
      foreach ($fields as $key) {
        if (in_array($key->id, $fields_id)) {
          $settings   = json_decode($key->settings);
          $fieldsName = "fields_{$key->handle}";
          $html .= '<div class="form-group">
            <label class="heading" for="input'.$key->handle.'">'.ucfirst($key->name).'</label>';
            if ($key->type_name == 'plainText') {
              if ($settings->plainLineBreak == 1) {
                $html .= '<textarea class="form-control"
                      name="fields_'.$key->handle.'" 
                      id="textarea"
                      rows="'.$settings->plainInitialRows.'"
                      placeholder="'.$settings->plainPlaceholder.'">'.(!empty($getDataby_id->$fieldsName) ? trim(strip_tags($getDataby_id->$fieldsName)) : '').'</textarea>';        
              } else {
                $html .= '<input type="text" class="form-control" 
                        name="fields_'.$key->handle.'" 
                        placeholder="'.(!empty($setttings->plainPlaceholder) ? $setttings->plainPlaceholder : '').'"
                        maxlength="'.(!empty($settings->plainCharlimit) ? $settings->plainCharlimit : '').'"
                        value="'.(!empty($getDataby_id->$fieldsName) ? $getDataby_id->$fieldsName : set_value($fieldsName)).'">';                    
              }
            } elseif ($key->type_name == 'assets') {
              foreach ($assets as $key2) {
                if ($key2->id == $settings->assetsSourcesList) {
                  $data['name'] = $key2->name;
                }
              }

              $html .= '<div id="fields-assets-entries">
                      <ul class="list-unstyled selected">';
                        if (!empty($getDataby_id->$fieldsName)) {
                          $assetsList = explode(', ', $getDataby_id->$fieldsName);
                          foreach ($assets_content as $ast) {
                            $filename   = explode('.', $ast->file);
                            $name       = current($filename);
                            $thumb      = current($filename).'_thumb.'.end($filename);
                            $file_thumb = base_url("{$ast->path}/{$thumb}");
                            $getSize    = get_headers($file_thumb, 1);
                            if (in_array($ast->id, $assetsList)) {
                              $html .= '
                                  <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$ast->id.'">
                                    <img src="'.$file_thumb.'" class="img-thumbnail assets-list" data-id="'.$ast->id.'" heigth="20" width="30"/>
                                    <label for="input'.$name.'">'.$name.'</label>
                                    <a><i class="fa fa-times" aria-hidden="true"></i></a
                                  </li>';
                            }
                          }
                        }
              $html .= '</ul>';
              $html .= '<div>
                      <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#assetsModal"
                      data-assets-id = "'.$settings->assetsSourcesList.'" 
                      data-assets-fields="fields_'.$key->handle.'">
                    + New Assets</button></div>';
              $html .= '</div>';
            } elseif ($key->type_name == 'richText') {
            } elseif ($key->type_name == 'categories') {
            } elseif ($key->type_name == 'checkboxes') {
              $val = $settings->checkboxesValue; 
              $i = 0;
              foreach ($settings->checkboxesLabel as $key2 => $value) {
                $dataResult[] = array(
                            'label' => $value,
                            'value' => $val[$i]
                          );
                $i++;
              }

              if (!empty($getDataby_id->$fieldsName)) {
                $checkList = explode(', ', $getDataby_id->$fieldsName);
              }

              foreach ($dataResult as $key3) {
                $html .= '<div class="form-check">
                        <input class="form-check-input" 
                          type="checkbox" 
                          name="fields_'.$key->handle.'[]" 
                          value="'.$key3['value'].'"
                          '.((!empty($getDataby_id->$fieldsName) && in_array($key3['value'], $checkList)) ? 'checked' : '').'>
                        <label class="form-check-label" 
                          for="defaultCheck1">'.$key3['label'].'
                        </label>
                      </div>';
              }
            } elseif ($key->type_name == 'dateTime') {
            } elseif ($key->type_name == 'dropdown') {
              $val = $settings->dropdownValue; 
              $i = 0;
              foreach ($settings->dropdownLabel as $key2 => $value) {
                $dataResult[] = array(
                            'label' => $value,
                            'value' => $val[$i]
                          );
                $i++;
              }
              $html .= '<select class="form-control costum-select" name="fields_{$key->handle}">';
              foreach ($dataResult as $key3) {
                $html .= '<option value="'.$key3['value'].'">'.$key3['label'].'</option>';
              }
              $html .= '</select>';
            } elseif ($key->type_name == 'radio') {
              $val = $settings->radioValue; 
              $i = 0;
              foreach ($settings->radioLabel as $key2 => $value) {
                $dataResult[] = array(
                            'label' => $value,
                            'value' => $val[$i]
                          );
                $i++;
              }
              foreach ($dataResult as $key3) {
                $html .= '<div class="form-check">
                        <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]" value="'.$key3['value'].'">
                        <label class="form-check-label" for="defaultCheck1">'.$key3['label'].'</label>
                      </div>';
              }
            }
          $html .= '</div>';
        }
      }
    } 
    echo json_encode($html);
  }
 


}

/* End of file Api.php */
/* Location: ./application/controllers/admin/Api.php */