<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/General_m', 'general_m');

    $assets = $this->general_m->get_all_results('assets');
    $this->firstHandle = ($assets ? $assets[0]->handle : '');
    if ($assets) {
      foreach ($assets as $key) {
        $handle[] = $key->handle;
      }
      array_push($handle, 'all', 'default');
    }

    if ($this->router->method == 'index') {
      if ($assets) {
        if ((uri_string() == 'admin/assets') || (! in_array($this->uri->segment(3), $handle))) {
          redirect("admin/assets/all");
        }
      } else {
        redirect("admin/settings/assets");
      }
    } elseif ($this->router->method == 'settings') {
      if ((uri_string() == 'admin/settings/assets') || (!in_array($this->uri->segment(4), array('volumes', 'transforms')))) {
        redirect("admin/settings/assets/volumes");
      }
    }

    $this->data = array(
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/settings/assets', 
    );

  }

    /*Assets entries*/
  public function index($handle) {
    $params = (in_array($handle, array('all', 'default')) ? '' : $this->general_m->get_row_by_fields('assets', array('handle' => $handle)));
    if ($handle == 'default') {
      $id = '0';
    } elseif ($handle == 'all') {
      $id = '';
    } else {
      $id = $params->id;
    }

    $settings = array(
      'title'                =>  'assets list',
      'subtitle'             =>  FALSE,
      'breadcrumb'           =>  FALSE,
      'subbreadcrumb'        =>  FALSE,
      'table'                =>  'assets_content',
      'action'               =>  'admin/assets',
      'session'              =>  $this->data,
      'no'                   =>  $this->uri->segment(4),
      'button'               =>  '+ Upload Files',
      'button_link'          =>  'Upload',
      'content'              =>  'template/bootstrap-4/admin/assets/assets-list',
      'fields_content'       =>  $this->general_m->get_all_results('assets_content'),
      'fields_content_count' =>  $this->general_m->count_all_results('assets_content'),
      'content_name'         => 'assets_content',
      'group_name'           =>  'assets',
      'group'                =>  $this->general_m->get_all_results('assets'),
      'group_count'          =>  $this->general_m->count_all_results('assets'),
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

  /*Delete Assets */
  public function delete($handle, $id){
    $settings = array(
      'title'        => 'assets list',
      'table'        => 'assets_content',
      'action'       => "admin/assets/{$handle}",
      'getDataby_id' =>  $this->general_m->get_row_by_id('assets_content', $id),          
    );

    if ($settings['getDataby_id']) {
      $path = "{$settings['getDataby_id']->path}/{$settings['getDataby_id']->file}";
      unlink($_SERVER['DOCUMENT_ROOT'].'/'.$path);
      $path_thumb = "{$settings['getDataby_id']->path_thumb}/{$settings['getDataby_id']->file_thumb}";
      unlink($_SERVER['DOCUMENT_ROOT'].'/'.$path_thumb);
      $delete = $this->general_m->delete('assets_content', $id); 
      helper_log('delete', "Delete {settings['table']} with handle {$handle} with id = {$id} has successfully");
      $this->session->set_flashdata("message", "data has deleted {$delete} records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Delete Failed, Your data is Not Valid');
      redirect($settings['action']);
    }
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }


  /*Volumens*/
  public function settings($handle) {
    $settings = array(
      'title'              =>  'assets',
      'subtitle'           =>  FALSE,
      'breadcrumb'         =>  array('settings'),
      'subbreadcrumb'      =>  FALSE,
      'table'              =>  (($handle == 'volumes') ? 'assets' : 'assets_transforms'),
      'action'             =>  "admin/settings/assets/{$handle}",
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(5),
      'button'             =>  (($handle == 'volumes') ? '+ New Assets' : '+ New Transforms'),
      'button_link'        =>  "{$handle}/create",
      'content'            =>  'template/bootstrap-4/admin/assets/assets-settings-template',
      'right_content'      =>  "template/bootstrap-4/admin/assets/assets-{$handle}-list",
      'element_name'       =>  'assets_element',
      'group_name'         =>  'assets_group',
      'handle'             =>  $handle,
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
  public function settings_create($handle) {
    $settings = array(
      'title'            =>  (($handle == 'volumes') ? 'assets' : 'assets Transforms'),
      'subtitle'         =>  'create',
      'breadcrumb'       =>  array('settings'),
      'subbreadcrumb'    =>  array('create'),
      'table'            =>  (($handle == 'volumes') ? 'assets' : 'assets_transforms'),
      'action'           =>  "admin/settings/assets/{$handle}",
      'session'          =>  $this->data,
      'no'               =>  $this->uri->segment(3),
      'button'           =>  'Save',
      'button_type'      =>  'submit',
      'button_name'      =>  'create',
      'button_tabs'      =>  (($handle == 'volumes') ? TRUE : FALSE),
      'content'          =>  "template/bootstrap-4/admin/assets/assets-{$handle}-form",
      'assets_type'      =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
      'fields_element'   =>  'assets_element',
      'element'          =>  [],
      'fields_group'     =>  $this->general_m->get_all_results('fields_group'),
      'fields'           =>  $this->fields_m->get_all_results(),
      'elementFields'    =>  [],
      'order'            =>  $this->general_m->get_max_fields('assets', 'order'),
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
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*UPDATE*/
  public function settings_update($handle, $id='') {
    $settings = array(
      'title'            =>  (($handle == 'volumes') ? 'assets' : 'assets Transforms'),
      'subtitle'         =>  'update',
      'breadcrumb'       =>  array('settings'),
      'subbreadcrumb'    =>  array('edit'),
      'table'            =>  (($handle == 'volumes') ? 'assets' : 'assets_transforms'),
      'action'           =>  "admin/settings/assets/{$handle}",
      'session'          =>  $this->data,
      'no'               =>  $this->uri->segment(3),
      'button'           =>  'Update',
      'button_type'      =>  'submit',
      'button_name'      =>  'update',
      'button_tabs'      =>  (($handle == 'volumes') ? TRUE : FALSE),
      'content'          =>  "template/bootstrap-4/admin/assets/assets-{$handle}-form",
      'assets_type'      =>  array('Amazon S3', 'Local Folder', 'Google Cloud Storage'),
      'fields_element'   =>  'assets_element',
      'element'          =>  $this->general_m->get_result_by_id('assets_element', $id, "assets_id"),
      'fields_group'     =>  $this->general_m->get_all_results('fields_group'),
      'fields'           =>  $this->fields_m->get_all_results(),
      'elementFields'    =>  [],
      'order'            =>  $this->general_m->get_max_fields('assets', 'order'),
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
      'id'                     => $id
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
    $settings['tabs_elements'] = tabs_layout($settings['element']);
    if ($settings['element']) {
      foreach ($settings['element'] as $key) {
        $fieldsId[] = $key->fields_id; 
      }
      $settings['elementFields'] = $fieldsId;
    } else {
      $settings['elementFields'] = [];
    }

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
        $this->session->set_flashdata("message", "{$settings['title']} has successfully updated");
        redirect($settings['action']);
      } 
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }  

  /*DELETE*/
  public function settings_delete($handle, $id='') {
    $settings = array(
      'title'         => (($handle == 'volumes') ? 'assets' : 'assets Transforms'),
      'table'         => (($handle == 'volumes') ? 'assets' : 'assets_transforms'),
      'action'        => "admin/settings/assets/{$handle}",
      'table_element' => 'assets_element',
      'table_content' => 'assets_content',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      if ($handle == 'volumes') {
        (($settings['table'] == 'entries') ? $table_content = 'content' : $table_content = "{$settings['table']}_content");
        $delElement = $this->general_m->delete($settings['table_element'], $id, "{$settings['table']}_id");

        // delete content with assets
        $contentList = $this->general_m->get_result_by_id($table_content, $id, "{$settings['table']}_id");
        if ($contentList) {
          foreach ($contentList as $key) { 
            $path = "{$key->path}/{$key->file}";
            unlink($_SERVER['DOCUMENT_ROOT'].'/'.$path);
            $path_thumb = "{$key->path_thumb}/{$key->file_thumb}";
            unlink($_SERVER['DOCUMENT_ROOT'].'/'.$path_thumb);
            $delContent = $this->general_m->delete($settings['table_content'], $key->id, "{$settings['table']}_id");
          }
        }
        /*delete folder*/
        delete_files("{$_SERVER['DOCUMENT_ROOT']}/uploads/admin/assets/{$settings['getDataby_id']->path}", true);

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
      }
      $delete = $this->general_m->delete($settings['table'], $id);

      /*check Fields contain assets volumes*/
      $all_fields_with_assets = $this->general_m->get_result_by_fields('fields', array('type_id' => 3));
      if ($all_fields_with_assets) {
        foreach ($all_fields_with_assets as $key ) {
          $settings = json_decode($key->settings);
          if ($settings->assetsSourcesList == $id) {
            $opt_settings = array(
              'assetsRestrictUpload'     => $settings->assetsRestrictUpload,
              'assetsSourcesList'        => 0,
              'assetsSourcesInput'       => '',
              'assetsSources'            => $settings->assetsSources,
              'assetsRestrictFileType'   => $settings->assetsRestrictFileType,
              'assetsType'               => $settings->assetsType,
              'assetsTargetLocale'       => $settings->assetsTargetLocale,
              'assetsLimit'              => $settings->assetsLimit,
              'assetsViewMode'           => $settings->assetsViewMode,
              'assetsSelectionLabel'     => $settings->assetsSelectionLabel,
            );
            $data = array(
              'settings' => json_encode($opt_settings),
            );
            $this->general_m->update('fields', $data, $key->id);
          }
        }
      }

      helper_log('delete', "Delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} records");      
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }
}

/* End of file Assets.php */
/* Location: ./application/controllers/admin/Assets.php */