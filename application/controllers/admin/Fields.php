<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fields extends My_Controller {
  
  public $data = [];

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/Section_m', 'section_m');
    //Do your magic here
    $this->data = array(
      'userdata'          =>  $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
      'parentLink'        => 'admin/settings/fields', 
    );
  }
  
  /*Fields Index*/
  public function index() {
    $settings = array(
      'title'          =>  'fields',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  FALSE,
      'table'          =>  'fields',
      'action'         =>  'admin/settings/fields',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'button'         =>  '+ New Fields',
      'button_link'    =>  'fields/create',
      'content'        =>  'template/bootstrap-4/admin/fields/fields-list',
      'group_name'     =>  'fields_group',
      'group'          =>  $this->general_m->get_all_results('fields_group'),
      'group_count'    =>  $this->general_m->count_all_results('fields_group'),
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
    $settings['record_all'] = $this->fields_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*Fields Create*/
  public function create() {
    $settings = array(
      'title'         =>  'fields',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'table'         =>  'fields',
      'action'        =>  'admin/settings/fields/create',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'content'       =>  'template/bootstrap-4/admin/fields/fields-form',
      'fields_type'   =>  $this->general_m->get_all_results('fields_type'),
      'group'         =>  $this->general_m->get_all_results('fields_group'),
      'group_count'   =>  $this->general_m->count_all_results('fields_group'),
      'group_id'      =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'assets'        =>  $this->general_m->get_all_results('assets'),
      'file'          =>  array(
                            'Audio', 
                            'Compressed', 
                            'Excel', 
                            'Flash', 
                            'HTML', 
                            'Image', 
                            'JSON', 
                            'JavaScript', 
                            'PDF', 
                            'PowerPoint', 
                            'Text', 
                            'Video', 
                            'Word'
                          ),
      'mode'          =>  array('List', 'List Thumbnails'),
      'categories'    =>  $this->general_m->get_all_results('categories'),
      'attributes'    =>  arraY('type' =>
                                    array(
                                    'text'     => array('maxlength', 'minlength', 'placeholder'),
                                    'email'    => array('list', 'maxlength', 'pattern', 'placeholder'),
                                    'password' => array('maxlength', 'pattern', 'placeholder'),
                                    'datetime' => array('list', 'max', 'min', 'step'),
                                    'file'     => array('multiple', 'accept', 'files', 'capture'),
                                    'checkbox' => array('checked'),
                                    'textarea' => array('placeholder', 'rows', 'cols', 'wrap'),
                                    ),
                                    'action' => array('required', 'autocomplete', 'autofocus', 'disabled', 'readonly')
                          ),
      'section'      => $this->section_m->get_all_results(),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_fields.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_fields.handle]');
    $this->form_validation->set_rules('fields-group', 'fields Group', 'trim|required');
    $this->form_validation->set_rules('fields-type', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        if ($this->input->post('fields-type')  == 'plainText') {
          $opt_settings = array(
            'plainPlaceholder'         => $this->input->post('plainPlaceholder'),
            'plainCharlimit'           => $this->input->post('plainCharlimit'),
            'plainMonospacedFont'      => $this->input->post('plainMonospacedFont'),
            'plainLineBreak'           => $this->input->post('plainLineBreak'),
            'plainInitialRows'         => $this->input->post('plainInitialRows'),
            'plainColumnType'          => $this->input->post('plainColumnType'),
          );
        } elseif ($this->input->post('fields-type') == 'assets') {
          $opt_settings = array(
            'assetsRestrictUpload'     => $this->input->post('assetsRestrictUpload'),
            'assetsSourcesList'        => $this->input->post('assetsSourcesList'),
            'assetsSourcesInput'       => $this->input->post('assetsSourcesInput'),
            'assetsSources'            => $this->input->post('assetsSources'),
            'assetsRestrictFileType'   => $this->input->post('assetsRestrictFileType'),
            'assetsType'               => $this->input->post('assetsType'),
            'assetsTargetLocale'       => $this->input->post('assetsTargetLocale'),
            'assetsLimit'              => $this->input->post('assetsLimit'),
            'assetsViewMode'           => $this->input->post('assetsViewMode'),
            'assetsSelectionLabel'     => $this->input->post('assetsSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'categories') {
          $opt_settings = array(
            'categoriesSource'         => $this->input->post('categoriesSource'),
            'categoriesTargetLocale'   => $this->input->post('categoriesTargetLocale'),
            'categoriesLimit'          => $this->input->post('categoriesLimit'),
            'categoriesSelectionLabel' => $this->input->post('categoriesSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'entries') {
          $opt_settings = array(
            'entriesSource'         => $this->input->post('entriesSource'),
            'entriesLimit'          => $this->input->post('entriesLimit'),
            'entriesSelectionLabel' => $this->input->post('entriesSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'checkboxes') {
          $opt_settings = array(
            'checkboxesLabel'          => $this->input->post('checkboxesLabel'),
            'checkboxesValue'          => $this->input->post('checkboxesValue'),
            'checkboxesDefault'        => $this->input->post('checkboxesDefault'),
          );
        } elseif ($this->input->post('fields-type') == 'dateTime') {
          $opt_settings = array(
            'datetimeList'             => $this->input->post('datetimeList'),
            'datetimeIncrement'        => $this->input->post('datetimeIncrement'),
          );
        } elseif ($this->input->post('fields-type') == 'dropdown') {
          $opt_settings = array(
            'dropdownLabel'            => $this->input->post('dropdownLabel'),
            'dropdownValue'            => $this->input->post('dropdownValue'),
            'dropdownDefault'          => $this->input->post('dropdownDefault'),
          );
        } elseif ($this->input->post('fields-type') == 'radio') {
          $opt_settings = array(
            'radioLabel'               => $this->input->post('radioLabel'),
            'radioValue'               => $this->input->post('radioValue'),
            'radioDefault'             => $this->input->post('radioDefault'),
          );
        } else {
          $opt_settings = NULL;
        }

        // Alter Add Column Table Content 
        $handle           = lcfirst(str_replace(' ', '', ucwords($this->input->post('name'))));
        $getFieldsType    = $this->general_m->get_row_by_fields('fields_type', array('handle' => $this->input->post('fields-type')));
        $getContentFields = $this->db->list_fields('content');
        if (!in_array("fields_{$handle}", $getContentFields)) {
          $fields = array(
            'handle' =>  $handle,
            'type'   =>  $getFieldsType->type,
          );
          // add Column content
          modifyColumn($fields, 'add'); 
        } else {
          $this->session->set_flashdata('message', "This fields {field_{$handle}} has exists");
        }

        $opt = array(
          'settings' => json_encode($opt_settings),
        );
        $option_id = $this->general_m->create('fields_option', $opt, FALSE);
        $data = array(
          'group_id'    =>  $this->input->post('fields-group'),
          'type_id'     =>  $getFieldsType->id,
          'option_id'   =>  $option_id,
          'name'        =>  $this->input->post('name'),
          'handle'      =>  $handle,
          'label'       =>  ucfirst($this->input->post('name')),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'activated'   =>  $this->input->post('activated'),
          'settings'    =>  json_encode($opt_settings),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->fields_m->create($data);        
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($this->data['parentLink']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*fields Update*/
  public function update($id='') {
    $settings = array(
      'title'         =>  'fields',
      'subtitle'      =>  'edit',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'table'         =>  'fields',
      'action'        =>  'admin/settings/fields/edit',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/fields/fields-form',
      'fields_type'   =>  $this->general_m->get_all_results('fields_type'),
      'group'         =>  $this->general_m->get_all_results('fields_group'),
      'group_count'   =>  $this->general_m->count_all_results('fields_group'),
      'group_id'      =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'id'            =>  $id,
      'getDataby_id'  =>  $this->fields_m->get_row_by_id($id),
      'assets'        =>  $this->general_m->get_all_results('assets'),
      'file'          =>  array(
                            'Audio', 
                            'Compressed', 
                            'Excel', 
                            'Flash', 
                            'HTML', 
                            'Image', 
                            'JSON', 
                            'JavaScript', 
                            'PDF', 
                            'PowerPoint', 
                            'Text', 
                            'Video', 
                            'Word'
                          ),
      'mode'          =>  array('List', 'List Thumbnails'),
      'categories'    =>  $this->general_m->get_all_results('categories'),
      'attributes'    =>  arraY('type' =>
                                    array(
                                    'text'     => array('maxlength', 'minlength', 'placeholder'),
                                    'email'    => array('list', 'maxlength', 'pattern', 'placeholder'),
                                    'password' => array('maxlength', 'pattern', 'placeholder'),
                                    'datetime' => array('list', 'max', 'min', 'step'),
                                    'file'     => array('multiple', 'accept', 'files', 'capture'),
                                    'checkbox' => array('checked'),
                                    'textarea' => array('placeholder', 'rows', 'cols', 'wrap'),
                                    ),
                                    'action' => array('required', 'autocomplete', 'autofocus', 'disabled', 'readonly')
                          ),

      'section'      => $this->section_m->get_all_results(),
    );
    $settings['getFieldType'] = json_decode($settings['getDataby_id']->settings);
    $settings['typeFields'] = $this->general_m->get_row_by_id('fields_type', $settings['getDataby_id']->type_id);

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
    $this->form_validation->set_rules('fields-group', 'fields Group', 'trim|required');
    $this->form_validation->set_rules('fields-type', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'update') {
        if ($this->input->post('fields-type')  == 'plainText') {
          $opt_settings = array(
            'plainPlaceholder'         => $this->input->post('plainPlaceholder'),
            'plainCharlimit'           => $this->input->post('plainCharlimit'),
            'plainMonospacedFont'      => $this->input->post('plainMonospacedFont'),
            'plainLineBreak'           => $this->input->post('plainLineBreak'),
            'plainInitialRows'         => $this->input->post('plainInitialRows'),
            'plainColumnType'          => $this->input->post('plainColumnType'),
          );
        } elseif ($this->input->post('fields-type') == 'assets') {
          $opt_settings = array(
            'assetsRestrictUpload'     => $this->input->post('assetsRestrictUpload'),
            'assetsSourcesList'        => $this->input->post('assetsSourcesList'),
            'assetsSourcesInput'       => $this->input->post('assetsSourcesInput'),
            'assetsSources'            => $this->input->post('assetsSources'),
            'assetsRestrictFileType'   => $this->input->post('assetsRestrictFileType'),
            'assetsType'               => $this->input->post('assetsType'),
            'assetsTargetLocale'       => $this->input->post('assetsTargetLocale'),
            'assetsLimit'              => $this->input->post('assetsLimit'),
            'assetsViewMode'           => $this->input->post('assetsViewMode'),
            'assetsSelectionLabel'     => $this->input->post('assetsSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'categories') {
          $opt_settings = array(
            'categoriesSource'         => $this->input->post('categoriesSource'),
            'categoriesTargetLocale'   => $this->input->post('categoriesTargetLocale'),
            'categoriesLimit'          => $this->input->post('categoriesLimit'),
            'categoriesSelectionLabel' => $this->input->post('categoriesSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'entries') {
          $opt_settings = array(
            'entriesSource'         => $this->input->post('entriesSource'),
            'entriesLimit'          => $this->input->post('entriesLimit'),
            'entriesSelectionLabel' => $this->input->post('entriesSelectionLabel'),
          );
        } elseif ($this->input->post('fields-type') == 'checkboxes') {
          $opt_settings = array(
            'checkboxesLabel'          => $this->input->post('checkboxesLabel'),
            'checkboxesValue'          => $this->input->post('checkboxesValue'),
            'checkboxesDefault'        => $this->input->post('checkboxesDefault'),
          );
        } elseif ($this->input->post('fields-type') == 'dateTime') {
          $opt_settings = array(
            'datetimeList'             => $this->input->post('datetimeList'),
            'datetimeIncrement'        => $this->input->post('datetimeIncrement'),
          );
        } elseif ($this->input->post('fields-type') == 'dropdown') {
          $opt_settings = array(
            'dropdownLabel'            => $this->input->post('dropdownLabel'),
            'dropdownValue'            => $this->input->post('dropdownValue'),
            'dropdownDefault'          => $this->input->post('dropdownDefault'),
          );
        } elseif ($this->input->post('fields-type') == 'radio') {
          $opt_settings = array(
            'radioLabel'               => $this->input->post('radioLabel'),
            'radioValue'               => $this->input->post('radioValue'),
            'radioDefault'             => $this->input->post('radioDefault'),
          );
        } else {
          $opt_settings = NULL;
        }

        $handle           = lcfirst(str_replace(' ', '', ucwords($this->input->post('name'))));
        $getFieldsType    = $this->general_m->get_row_by_fields('fields_type', array('handle' => $this->input->post('fields-type')));
        $getContentFields = $this->db->list_fields('content');
        if ($handle != $settings['getDataby_id']->handle) {
          if (!in_array("fields_{$handle}", $getContentFields)) {
            $fields = array(
              'old_name' =>  $settings['getDataby_id']->handle,
              'handle'   =>  $handle,
              'type'     =>  $getFieldsType->type,
            );
            // Modify Column content
            modifyColumn($fields, 'modify'); 
          }
        }

        $opt = array(
          'settings' => json_encode($opt_settings),
        );
        //update Fields Options 
        $this->general_m->update('fields_option', $opt, $settings['getDataby_id']->option_id, '', FALSE);
        $option_id  = $settings['getDataby_id']->option_id;
        $fieldsType = $this->general_m->get_row_by_fields('fields_type', array('handle' => $this->input->post('fieldsType')));
        $data = array(
          'group_id'    =>  $this->input->post('fields-group'),
          'type_id'     =>  $getFieldsType->id,
          'option_id'   =>  $option_id,
          'name'        =>  $this->input->post('name'),
          'handle'      =>  $handle,
          'label'       =>  ucfirst($this->input->post('name')),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'activated'   =>  $this->input->post('activated'),
          'settings'    =>  json_encode($opt_settings),
          'updated_by'  =>  $this->data['userdata']['id'],
        );
        $this->fields_m->update($data, $id); 
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully updated");
        redirect($this->data['parentLink']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /**
   * This Function To Delete All Fields in each Content and element 
   * @param  string $id [description]
   * @return [type]     [description]
   */
  public function delete($id='') {
    $settings = array(
      'title'        =>  'fields',
      'getDataby_id' => $this->fields_m->get_row_by_id($id)
    );
    if ($settings['getDataby_id']) {
      $fields_content            = $this->db->list_fields('content');
      $fields_categories_content = $this->db->list_fields('categories_content');
      $fields_assets_content     = $this->db->list_fields('assets_content');
      $fields_globals_content    = $this->db->list_fields('globals_content');
      $fields_users_content      = $this->db->list_fields('users_content');
      $fields_handle             = "fields_{$settings['getDataby_id']->handle}";

      /*Check Fields in Content Table if exist Drop fields in table content*/
      if (in_array($fields_handle, $fields_content)) {
        $fields = array(
          'handle'    => $settings['getDataby_id']->handle,
          'type'      => $settings['getDataby_id']->type_id,
          'option_id' => $settings['getDataby_id']->option_id,
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

        // chekc and drop fields in assets content
        if (in_array($fields_handle, $fields_globals_content)) {
          modifyColumn($fields, 'drop-table', 'globals_content');
        }

        // chekc and drop fields in assets content
        if (in_array($fields_handle, $fields_users_content)) {
          modifyColumn($fields, 'drop-table', 'users_content');
        }

        /*Deleete Element in Each Table */
        // check element each table element
        $check_element = $this->general_m->get_result_by_fields('element', array('fields_id' => $id));
        if ($check_element) {
          $delete_element = $this->general_m->delete('element', $id, 'fields_id');
          $delete_fields_option = $this->general_m->delete('fields_option', $fields['option_id']);
        }
        // check element each table element
        $check_categories_element = $this->general_m->get_result_by_fields('categories_element', array('fields_id' => $id));
        if ($check_categories_element) {
          $delete_categories_element = $this->general_m->delete('categories_element', $id, 'fields_id');
        }
        // check element each table element
        $check_assets_element = $this->general_m->get_result_by_fields('assets_element', array('fields_id' => $id));
        if ($check_assets_element) {
          $delete_assets_element = $this->general_m->delete('assets_element', $id, 'fields_id');
        }
        // check element each table element
        $check_globals_element = $this->general_m->get_result_by_fields('globals_element', array('fields_id' => $id));
        if ($check_globals_element) {
          $delete_globals_element = $this->general_m->delete('globals_element', $id, 'fields_id');
        } 
        // check element each table element
        $check_users_element = $this->general_m->get_result_by_fields('users_element', array('fields_id' => $id));
        if ($check_users_element) {
          $delete_users_element = $this->general_m->delete('users_element', $id, 'fields_id');
        } 
      }
      $delete = $this->general_m->delete('fields', $id);

      /*if (in_array("fields_{$settings['getDataby_id']->handle}", $fields_content)) {
        $fields = array(
          'handle' => $settings['getDataby_id']->handle,
          'type'   => $settings['getDataby_id']->type_id,
        );
        // Drop field column in content
        modifyColumn($fields, 'drop');
      }

      if (in_array("fields_{$settings['getDataby_id']->handle}", $fields_assets_content)) {
        $fields = array(
          'handle' => $settings['getDataby_id']->handle,
          'type'   => $settings['getDataby_id']->type_id,
        );
        // Drop field column in content
        modifyColumn($fields, 'drop-table', 'assets_content');
      }
      
      if (in_array("fields_{$settings['getDataby_id']->handle}", $fields_categories_content)) {
        $fields = array(
          'handle' => $settings['getDataby_id']->handle,
          'type'   => $settings['getDataby_id']->type_id,
        );
        // Drop field column in content
        modifyColumn($fields, 'drop-table', 'categories_content');
      }

      $delElement           = $this->general_m->delete('element', $id, 'fields_id');
      $delAssetsElement     = $this->general_m->delete('assets_element', $id, 'fields_id');
      $delCategoriesElement = $this->general_m->delete('categories_element', $id, 'fields_id');
      $del                  = $this->fields_m->delete($id);
      $delOption            = $this->general_m->delete('fields_option', $settings['getDataby_id']->option_id);*/
      helper_log('delete', "Delete {settings['title']} with id = {$id} has successfully");
      $this->session->set_flashdata("message", "Data has deleted {$delete} Records");
      redirect($this->data['parentLink']);
    } else {
      $this->session->set_flashdata('message', 'Delete Failed, Your data is Not Valid');
      redirect($this->data['parentLink']);
    }
  }

  /*TYPE fields*/
  public function type() {
    $settings = array(
      'title'         =>  'fields type',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'fields_type',
      'action'        => 'admin/settings/fields/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(5), 
      'button'        =>  '+ New Fields',
      'button_link'   =>  'type/create',
      'content'       =>  'template/bootstrap-4/admin/fields/fields-type-list',
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page'];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end pagination
   
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*Type Create*/
  public function type_create() {
    $settings = array(
      'title'         =>  'fields type',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'table'         =>  'fields_type',
      'action'        =>  'admin/settings/fields/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'content'       =>  'template/bootstrap-4/admin/fields/fields-type-form',
      'type'          =>  array('VARCHAR', 'INT', 'TEXT', 'DATE', 'DATETIME'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if ($_POST['button'] == 'create') {
        $data = array(
          'name'        => ucfirst($this->input->post('name')),
          'type'        => $this->input->post('type'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($settings['action']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*type Update*/
  public function type_update($id='') {
    $settings = array(
      'title'         =>  'fields type',
      'subtitle'      =>  'edit',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'table'         =>  'fields_type',
      'action'        =>  'admin/settings/fields/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/fields/fields-type-form',
      'type'          =>  array('VARCHAR', 'INT', 'TEXT', 'DATE', 'DATETIME'),
      'id'            =>  $id,
    );
    $settings['getDataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if ($_POST['button'] == 'update') {
        $data = array(
          'name'        => ucfirst($this->input->post('name')),
          'type'        => $this->input->post('type'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'updated_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully updated");
        redirect($settings['action']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*Delete type*/
  public function type_delete($id='') {
    $settings = array(
      'table'         =>  'fields_type',
      'action'        =>  'admin/settings/fields/type',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);
    if ($settings['getDataby_id']) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete {settings['title']} with id = {$id} has successfully");
      $this->session->set_flashdata("message", "Data has deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

}

/* End of file fields.php */
/* Location: ./application/controllers/admin/fields.php */