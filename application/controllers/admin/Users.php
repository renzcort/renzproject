<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/General_m', 'general_m');
		$this->load->model('admin/Fields_m', 'fields_m');
    $this->load->model('admin/Users_m', 'users_m');

    if ($this->router->method == 'settings') {
      if ((uri_string() == 'admin/settings/users') || !in_array($this->uri->segment(4), array('groups', 'fields', 'settings'))) {
        redirect("admin/settings/users/groups");
      } 
    }


    $this->data = array(
      'userdata'          => $this->first_load(),
      'sidebar_activated' => $this->sidebar_activated(),
    );

    $usersgroup = $this->general_m->get_all_results('usersgroup');
    if ($usersgroup) {
      foreach ($usersgroup as $key) {
        $handle[] = $key->handle;
      }
      array_push($handle, 'all', 'create');
    }

    if ($this->router->method == 'index') {
      if ($usersgroup) {
        if (in_array(uri_string(), array('admin/users')) || !in_array($this->uri->segment(3), $handle)) {
          redirect("admin/users/all");
        } 
      } else {
        redirect("admin/settings/users");
      }
    } elseif ($this->router->method == 'settings') {
      if (in_array(uri_string(), array('admin/settings/users')) || !in_array($this->uri->segment(4), array('groups', 'fields', 'settings'))) {
        redirect("admin/settings/users/groups");
      }
    }
	}

  public function index($handle) {
    $params = (in_array($handle, array('all')) ? '' : $this->general_m->get_row_by_fields('usersgroup', array('handle' => $handle)));
    $settings = array(
      'title'          =>  'users',
      'subtitle'       =>  FALSE,
      'breadcrumb'     =>  FALSE,
      'subbreadcrumb'  =>  FALSE,
      'table'          =>  'users',
      'action'         =>  'admin/users/account',
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(4),
      'button'         =>  '+ New Users',
      'button_link'    =>  "account/create",
      'content'        =>  'template/bootstrap-4/admin/users/users-list',
      'fields_element' => 'users_settings',
      'group_name'    =>  'usersgroup',
      'group'          =>  $this->general_m->get_all_results('usersgroup'),
      'group_count'    =>  $this->general_m->count_all_results('usersgroup'),
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
    if ($params) {
      $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, $params->id, 'group_id');
    } else {
      $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    }
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function create() {
    $settings = array(
      'title'              => 'users',
      'subtitle'           => 'create',
      'breadcrumb'         => array('settings'),
      'subbreadcrumb'      => array('create'),
      'table'              => 'users_content',
      'action'             => 'admin/users/account',
      'session'            => $this->data,
      'no'                 => $this->uri->segment(4),
      'button'             => 'save',
      'button_type'        => 'submit',
      'button_name'        => 'create',
      'button_tabs'        =>  TRUE,  
      'content'            => 'template/bootstrap-4/admin/users/users-form',
      'fields_element'     => 'users_element',
      'users_settings'     => $this->general_m->get_row_by_fields('users_settings', array('handle' => 'settings')),
      'usersgroup'         => $this->general_m->get_all_results('usersgroup'),
      'permissions'        => $this->general_m->get_all_results('users_role'),
      'section'            => $this->general_m->get_all_results('section'),
      'globals'            => $this->general_m->get_all_results('globals'),
      'assets'             => $this->general_m->get_all_results('assets'),
      'element'            => $this->general_m->get_result_by_fields('users_element', array('users_settings_id' => 2)),
      'fields'             => $this->fields_m->get_all_results(),
      'fields_type'        => $this->general_m->get_all_results('fields_type'),
      'assets'             => $this->general_m->get_all_results('assets'),
      'assets_content'     => $this->general_m->get_all_results('assets_content'),
      'categories'         => $this->general_m->get_all_results('categories'),
      'categories_content' => $this->general_m->get_all_results('categories_content'),
      'entries_content'    => $this->general_m->get_all_results('content'),
      'parent_table'       => 'users',
    );

    if ($settings['element'] != NULL) {
      foreach ($settings['element'] as $key) {
        $fields_id[] = $key->fields_id;
      }
      $settings['fields_id']  = $fields_id;
    }
    $settings['tabs_elements'] = tabs_layout($settings['element']);

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function update($id) {
    $settings = array(
      'title'              => 'users',
      'subtitle'           => 'Edit',
      'breadcrumb'         => array('users'),
      'subbreadcrumb'      => array('edit'),
      'table'              => 'users_content',
      'action'             => 'admin/users/account',
      'session'            => $this->data,
      'no'                 => $this->uri->segment(4),
      'button'             => 'Update',
      'button_type'        => 'submit',
      'button_name'        => 'update',
      'button_tabs'        => TRUE,
      'content'            => 'template/bootstrap-4/admin/users/users-form',
      'fields_element'     => 'users_settings',
      'users_settings'     => $this->general_m->get_row_by_fields('users_settings', array('handle' => 'settings')),
      'usersgroup'         => $this->general_m->get_all_results('usersgroup'),
      'permissions'        => $this->general_m->get_all_results('users_role'),
      'section'            => $this->general_m->get_all_results('section'),
      'globals'            => $this->general_m->get_all_results('globals'),
      'assets'             => $this->general_m->get_all_results('assets'),
      'element'            => $this->general_m->get_result_by_fields('users_element', array('users_settings_id' => 2)),
      'fields'             => $this->fields_m->get_all_results(),
      'fields_type'        => $this->general_m->get_all_results('fields_type'),
      'assets'             => $this->general_m->get_all_results('assets'),
      'assets_content'     => $this->general_m->get_all_results('assets_content'),
      'categories'         => $this->general_m->get_all_results('categories'),
      'categories_content' => $this->general_m->get_all_results('categories_content'),
      'entries_content'    => $this->general_m->get_all_results('content'),
      'id'                 => $id,
      'getDataby_id'       => $this->general_m->get_row_by_id('users', $id),
      'getContentby_Id'    => $this->general_m->get_row_by_id('users_content', $id, 'users_id'),
      'parent_table'       => 'users',
    );
    $settings['tabs_elements'] = tabs_layout($settings['element']);
    $users_settings = $settings['getDataby_id']->settings;
    if ($users_settings) {
      $settings['permission'] = json_decode($settings['getDataby_id']->settings);

      // permission section
      if ($settings['permission']->sectionEdit) {
        foreach ($settings['permission']->sectionEdit as $key => $value) {
          $settings['sectionEdit'][] = $key;
        }
        if ($settings['permission']->sectionPublishLiveChange) {
          foreach ($settings['permission']->sectionPublishLiveChange as $key => $value) {
            $settings['sectionPublishLiveChange'][] = $key;
          }
        }
        if ($settings['permission']->sectionEditOtherAuthors) {
          foreach ($settings['permission']->sectionEditOtherAuthors as $key => $value) {
            $settings['sectionEditOtherAuthors'][] = $key;
          }
        }
        if ($settings['permission']->sectionPublishOtherAuthors) {
          foreach ($settings['permission']->sectionPublishOtherAuthors as $key => $value) {
            $settings['sectionPublishOtherAuthors'][] = $key;
          }
        }
        if ($settings['permission']->sectionDelete) {
          foreach ($settings['permission']->sectionDelete as $key => $value) {
            $settings['sectionDelete'][] = $key;
          }
        }
      }
      // permission globals
      if ($settings['permission']->editGlobal) {
        foreach ($settings['permission']->editGlobal as $key => $value) {
          $settings['editGlobal'][] = $key;
        }
      }
      
      // permission volume assets
      if ($settings['permission']->volumeView) {
        foreach ($settings['permission']->volumeView as $key => $value) {
          $settings['volumeView'][] = $key;
        }
        if ($settings['permission']->volumeUploadFiles) {
          foreach ($settings['permission']->volumeUploadFiles as $key => $value) {
            $settings['volumeUploadFiles'][] = $key;
          }
        }
        if ($settings['permission']->volumeCreateSubfolder) {
          foreach ($settings['permission']->volumeCreateSubfolder as $key => $value) {
            $settings['volumeCreateSubfolder'][] = $key;
          }
        }
        if ($settings['permission']->volumeRemoveFilesAndFolders) {
          foreach ($settings['permission']->volumeRemoveFilesAndFolders as $key => $value) {
            $settings['volumeRemoveFilesAndFolders'][] = $key;
          }
        }
        if ($settings['permission']->volumeEditImages) {
          foreach ($settings['permission']->volumeEditImages as $key => $value) {
            $settings['volumeEditImages'][] = $key;
          }
        }
      }
    }

    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function delete($id) {
    $settings = array(
      'title'  => "users",
      'table'  => 'users',
      'action' => 'admin/users/account',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $delete_content = $this->general_m->delete('users_content', $id, 'users_id');
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} records");   
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }


	public function settings($handle){
    $table = (($handle == 'groups') ? 'usersgroup' : 'users_settings');
    if ($handle == 'groups') {
      $right_content = 'users-group-list';
    } elseif ($handle == 'fields') {
      $right_content = 'users-fields-form';
      $settings = $this->general_m->get_row_by_fields($table, $data = array('handle' => 'fields'));
    } else {
      $right_content = 'users-settings-form';
      $settings = $this->general_m->get_row_by_fields($table, $data = array('handle' => 'settings'));
    }
		$settings = array(
      'title'              =>  "users {$handle}",
      'subtitle'           =>  FALSE,
      'breadcrumb'         =>  array('settings'),
      'subbreadcrumb'      =>  FALSE,
      'table'              =>  $table,
      'action'             =>  "admin/settings/users/{$handle}",
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(5),
      'button'             =>  (($handle == 'groups') ? "+ New Users{$handle}" : 'save'),
      'button_type'        =>  (($handle == 'groups') ? FALSE : 'submit'),
      'button_name'        =>  (($handle == 'groups') ? FALSE : 'update'),
      'content'            =>  'template/bootstrap-4/admin/users/users-settings-template',
      'right_content'      =>  "template/bootstrap-4/admin/users/{$right_content}",
      'fields'             =>  $this->fields_m->get_all_results(),
      'fields_group'       =>  $this->general_m->get_all_results('fields_group'),
      'fields_type'        =>  $this->general_m->get_all_results('fields_type'),
      'fields_element'     =>  'users_element',
      'assets'             =>  $this->general_m->get_all_results('assets'),
      'assets_content'     =>  $this->general_m->get_all_results('assets_content'),
      'categories'         =>  $this->general_m->get_all_results('categories'),
      'categories_content' =>  $this->general_m->get_all_results('categories_content'),
      'entries_content'    =>  $this->general_m->get_all_results('content'),
      'usersgroup'         =>  $this->general_m->get_all_results('usersgroup'),
      'getDataby_id'       =>  $this->general_m->get_row_by_fields('users_settings', array('handle' => $handle)),
      'elementFields'      =>  [],
      'id'                 =>  (($handle == 'groups') ? FALSE : $settings->id),
      'handle'             =>  $handle,
    );
    (($handle == 'groups') ? $settings['button_link'] = "{$handle}/create" : $settings['button_tabs'] = TRUE);

    if ($handle != 'groups') {
      $users_settings = $settings['getDataby_id']->settings;
      if (empty($users_settings)) {
        $set = array(
          'assetsSourcesList'  => '',
          'path'               => '',
          'email_verification' => '',
          'allowRegistration'  => '',
          'default_group'      => '',
        );
        $users_settings = json_encode($set);
      }
      $settings['users_settings'] = json_decode($users_settings);
      $settings['element'] = $this->general_m->get_result_by_id($settings['fields_element'], $settings['id'], 'users_settings_id'); 
      $settings['tabs_elements'] = tabs_layout($settings['element']);
      if ($settings['element']) {
        foreach ($settings['element'] as $key) {
          $fieldsId[] = $key->fields_id; 
        }
        $settings['elementFields'] = $fieldsId;
      } else {
        $settings['elementFields'] = [];
      }
    }

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

  public function settings_create($handle){
    $settings = array(
      'title'         =>  "users {$handle}",
      'subtitle'      =>  "create",
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'table'         =>  'usersgroup',
      'action'        =>  "admin/settings/users/{$handle}",
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'content'       =>  'template/bootstrap-4/admin/users/users-group-form',
      'usersgroup'    =>  $this->general_m->get_all_results('usersgroup'),
      'section'       =>  $this->general_m->get_all_results('section'),
      'globals'       =>  $this->general_m->get_all_results('globals'),
      'assets'        =>  $this->general_m->get_all_results('assets'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_usersgroup.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_usersgroup.handle]');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        $opt_settings = array(
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
          'usersAssigns'                   => $this->input->post('usersAssigns'),
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
          'name'     => ucfirst($this->input->post('name')),
          'handle'   => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'settings' => json_encode($opt_settings),
        );

        $this->general_m->create('usersgroup', $data);        
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($settings['action']);
      }     
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  public function settings_update($handle, $id){
    $table = (($handle == 'groups') ? 'usersgroup' : 'users_settings');
    if ($handle == 'groups') {
      $content = 'users-group-form';
      $right_content = FALSE;
      $id = $id;
    } elseif ($handle == 'fields') {
      $content = 'users-settings-template';
      $right_content = 'users-fields-form';
      $settings = $this->general_m->get_row_by_fields($table, $data = array('handle' => 'settings'));
      $id = $settings->handle;
    } else {
      $right_content = 'users-settings-form';
      $settings = $this->general_m->get_row_by_fields($table, $data = array('handle' => 'settings'));
      $id = $settings->handle;
    }

    $settings = array(
      'title'         =>  "users {$handle}",
      'subtitle'      =>  'edit',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'table'         =>  $table,
      'action'        =>  "admin/settings/users/{$handle}",
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(5),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  "template/bootstrap-4/admin/users/{$content}",
      'right_content' =>  "template/bootstrap-4/admin/users/{$right_content}",
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'element'        =>  [],
      'elementFields'  =>  [],
      'id'             => $id,
      'usersgroup'    =>  $this->general_m->get_all_results('usersgroup'),
      'section'       =>  $this->general_m->get_all_results('section'),
      'globals'       =>  $this->general_m->get_all_results('globals'),
      'assets'        =>  $this->general_m->get_all_results('assets'),
      'getDataby_id'  =>  $this->general_m->get_row_by_id('usersgroup', $id),
    );
    $settings['permission'] = json_decode($settings['getDataby_id']->settings);
    // permission section
    if ($settings['permission']->sectionEdit) {
      foreach ($settings['permission']->sectionEdit as $key => $value) {
        $settings['sectionEdit'][] = $key;
      }
      if ($settings['permission']->sectionPublishLiveChange) {
        foreach ($settings['permission']->sectionPublishLiveChange as $key => $value) {
          $settings['sectionPublishLiveChange'][] = $key;
        }
      }
      if ($settings['permission']->sectionEditOtherAuthors) {
        foreach ($settings['permission']->sectionEditOtherAuthors as $key => $value) {
          $settings['sectionEditOtherAuthors'][] = $key;
        }
      }
      if ($settings['permission']->sectionPublishOtherAuthors) {
        foreach ($settings['permission']->sectionPublishOtherAuthors as $key => $value) {
          $settings['sectionPublishOtherAuthors'][] = $key;
        }
      }
      if ($settings['permission']->sectionDelete) {
        foreach ($settings['permission']->sectionDelete as $key => $value) {
          $settings['sectionDelete'][] = $key;
        }
      }
    }
    // permission globals
    if (isset($settings['permission']->editGlobal)) {
      foreach ($settings['permission']->editGlobal as $key => $value) {
        $settings['editGlobal'][] = $key;
      }
    }

    // permission volume assets
    if (isset($settings['permission']->volumeView)) {
      foreach ($settings['permission']->volumeView as $key => $value) {
        $settings['volumeView'][] = $key;
      }
      if ($settings['permission']->volumeUploadFiles) {
        foreach ($settings['permission']->volumeUploadFiles as $key => $value) {
          $settings['volumeUploadFiles'][] = $key;
        }
      }
      if ($settings['permission']->volumeCreateSubfolder) {
        foreach ($settings['permission']->volumeCreateSubfolder as $key => $value) {
          $settings['volumeCreateSubfolder'][] = $key;
        }
      }
      if ($settings['permission']->volumeRemoveFilesAndFolders) {
        foreach ($settings['permission']->volumeRemoveFilesAndFolders as $key => $value) {
          $settings['volumeRemoveFilesAndFolders'][] = $key;
        }
      }
      if ($settings['permission']->volumeEditImages) {
        foreach ($settings['permission']->volumeEditImages as $key => $value) {
          $settings['volumeEditImages'][] = $key;
        }
      }
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
        $opt_settings = array(
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
          'usersAssigns'                   => $this->input->post('usersAssigns'),
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
          'name'     => ucfirst($this->input->post('name')),
          'handle'   => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'settings' => json_encode($opt_settings),
        );
        $this->general_m->update('usersgroup', $data, $id);        
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully updated");
        redirect($settings['action']);
      }     
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

	public function settings_delete($handle, $id) {
		$table = (($handle == 'groups') ? 'usersgroup' : 'users_settings');
		$settings = array(
			'title'  => "users {$handle}",
			'table'  => $table,
			'action' => "admin/settings/users/{$handle}",
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
      $users = $this->general_m->get_all_results('users', $id, 'group_id');
      foreach ($users as $key) {
        $delete_content = $this->general_m->delete('users_content', $key->id, 'users_id');
      }
      $delete_users = $this->general_m->delete('users', $id, 'group_id');
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} records");   
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */