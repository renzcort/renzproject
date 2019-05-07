<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fields extends My_Controller {
  
  public $data = [];

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/fields_m', 'fields_m');
    //Do your magic here
    $this->data = array(
      'userdata'  =>  $this->first_load(),
      'parentLink' => 'admin/fields', 
    );
  }

  public function index() {
    $settings = array(
      'title'              =>  'fields',
      'subtitle'           =>  FALSE,
      'subbreadcrumb'      =>  FALSE,
      'button'             =>  '+ New Fields',
      'button_link'        =>  'fields/create',
      'content'            =>  'template/bootstrap-4/admin/fields/fields-list',
      'table'              =>  'fields',
      'action'             =>  'admin/fields',
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
      'fields_group'       =>  $this->general_m->get_all_results('fields_group'),
      'fields_group_count' =>  $this->general_m->count_all_results('fields_group'),
      'fields_group_id'    =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
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
    $settings['record_all'] = $this->fields_m->get_all_results($config['per_page'], $start_offset, $settings['fields_group_id']);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function create() {
    $settings = array(
      'title'              =>  'fields',
      'subtitle'           =>  'create',
      'subbreadcrumb'      =>  FALSE,
      'button'             =>  'Save',
      'button_type'        =>  'submit',
      'button_name'        =>  'create',
      'content'            =>  'template/bootstrap-4/admin/fields/fields-form',
      'table'              =>  'fields',
      'action'             =>  'admin/fields/create',
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
      'fields_type'        =>  $this->general_m->get_all_results('fields_type'),
      'fields_group'       =>  $this->general_m->get_all_results('fields_group'),
      'fields_group_count' =>  $this->general_m->count_all_results('fields_group'),
      'fields_group_id'    =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
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
    );


    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_fields.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_fields.handle]');
    $this->form_validation->set_rules('fieldsGroupId', 'fields Group', 'trim|required');
    $this->form_validation->set_rules('fieldsTypeId', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        if ($this->input->post('fieldsType')  == 'plainText') {
          $opt_settings = array(
            'plainPlaceholder'         => $this->input->post('plainPlaceholder'),
            'plainCharlimit'           => $this->input->post('plainCharlimit'),
            'plainMonospacedFont'      => $this->input->post('plainMonospacedFont'),
            'plainLineBreak'           => $this->input->post('plainLineBreak'),
            'plainInitialRows'         => $this->input->post('plainInitialRows'),
            'plainColumnType'          => $this->input->post('plainColumnType'),
          );
        } elseif ($this->input->post('fieldsType') == 'assets') {
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
        } elseif ($this->input->post('fieldsType') == 'categories') {
          $opt_settings = array(
            'categoriesSource'         => $this->input->post('categoriesSource'),
            'categoriesTargetLocale'   => $this->input->post('categoriesTargetLocale'),
            'categorieslimit'          => $this->input->post('categorieslimit'),
            'categoriesSelectionLabel' => $this->input->post('categoriesSelectionLabel'),
          );
        } elseif ($this->input->post('fieldsType') == 'checkboxes') {
          $opt_settings = array(
            'checkboxesLabel'          => $this->input->post('checkboxesLabel'),
            'checkboxesValue'          => $this->input->post('checkboxesValue'),
            'checkboxesDefault'        => $this->input->post('checkboxesDefault'),
          );
        } elseif ($this->input->post('fieldsType') == 'dateTime') {
          $opt_settings = array(
            'datetimeList'             => $this->input->post('datetimeList'),
            'datetimeIncrement'        => $this->input->post('datetimeIncrement'),
          );
        } elseif ($this->input->post('fieldsType') == 'dropdown') {
          $opt_settings = array(
            'dropdownLabel'            => $this->input->post('dropdownLabel'),
            'dropdownValue'            => $this->input->post('dropdownValue'),
            'dropdownDefault'          => $this->input->post('dropdownDefault'),
          );
        } elseif ($this->input->post('fieldsType') == 'radio') {
          $opt_settings = array(
            'radioLabel'               => $this->input->post('radioLabel'),
            'radioValue'               => $this->input->post('radioValue'),
            'radioDefault'             => $this->input->post('radioDefault'),
          );
        } else {
          $opt_settings = NULL;
        }

        $opt = array(
          'settings' => json_encode($opt_settings),
        );
        
        $option = $this->general_m->create('fields_option', $opt, FALSE);
        $data = array(
          'group_id'    =>  $this->input->post('fieldsGroupId'),
          'type_id'     =>  $this->input->post('fieldsTypeId'),
          'option_id'   =>  $option,
          'name'        =>  $this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'label'       =>  ucfirst($this->input->post('name')),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'status'      =>  $this->input->post('status'),
          'created_by'  =>  $this->data['userdata']['id'],
        );

        $this->fields_m->create($data);
        // Alter Add Column Table Content 
        $getFields_type = $this->general_m->get_row_by_id('fields_type', $data['type_id']);
        $content_fields = array(
          'handle' =>  $data['handle'],
          'type'   =>  $getFields_type->type,
        );
        // add Column content
        modifyColumn($content_fields, 'add'); 
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully Create");
        redirect($this->data['parentLink']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  /*fields Update*/
  public function update($id='') {
    $settings = array(
      'title'              =>  'fields',
      'subtitle'           =>  'edit',
      'subbreadcrumb'      =>  FALSE,
      'button'             =>  'Update',
      'button_type'        =>  'submit',
      'button_name'        =>  'update',
      'content'            =>  'template/bootstrap-4/admin/fields/fields-form',
      'table'              =>  'fields',
      'action'             =>  'admin/fields/update',
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
      'fields_type'        =>  $this->general_m->get_all_results('fields_type'),
      'fields_group'       =>  $this->general_m->get_all_results('fields_group'),
      'fields_group_count' =>  $this->general_m->count_all_results('fields_group'),
      'fields_group_id'    =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'id'                 =>  $id,
      'getDataby_id'       =>  $this->fields_m->get_row_by_id($id),
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
    );
    $settings['getFieldType'] = json_decode($settings['getDataby_id']->settings);

    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_name_check');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|callback_handle_check');
    $this->form_validation->set_rules('fieldsGroupId', 'fields Group', 'trim|required');
    $this->form_validation->set_rules('fieldsTypeId', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        if ($this->input->post('fieldsType')  == 'plainText') {
          $opt_settings = array(
            'plainPlaceholder'         => $this->input->post('plainPlaceholder'),
            'plainCharlimit'           => $this->input->post('plainCharlimit'),
            'plainMonospacedFont'      => $this->input->post('plainMonospacedFont'),
            'plainLineBreak'           => $this->input->post('plainLineBreak'),
            'plainInitialRows'         => $this->input->post('plainInitialRows'),
            'plainColumnType'          => $this->input->post('plainColumnType'),
          );
        } elseif ($this->input->post('fieldsType') == 'assets') {
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
        } elseif ($this->input->post('fieldsType') == 'categories') {
          $opt_settings = array(
            'categoriesSource'         => $this->input->post('categoriesSource'),
            'categoriesTargetLocale'   => $this->input->post('categoriesTargetLocale'),
            'categorieslimit'          => $this->input->post('categorieslimit'),
            'categoriesSelectionLabel' => $this->input->post('categoriesSelectionLabel'),
          );
        } elseif ($this->input->post('fieldsType') == 'checkboxes') {
          $opt_settings = array(
            'checkboxesLabel'          => $this->input->post('checkboxesLabel'),
            'checkboxesValue'          => $this->input->post('checkboxesValue'),
            'checkboxesDefault'        => $this->input->post('checkboxesDefault'),
          );
        } elseif ($this->input->post('fieldsType') == 'dateTime') {
          $opt_settings = array(
            'datetimeList'             => $this->input->post('datetimeList'),
            'datetimeIncrement'        => $this->input->post('datetimeIncrement'),
          );
        } elseif ($this->input->post('fieldsType') == 'dropdown') {
          $opt_settings = array(
            'dropdownLabel'            => $this->input->post('dropdownLabel'),
            'dropdownValue'            => $this->input->post('dropdownValue'),
            'dropdownDefault'          => $this->input->post('dropdownDefault'),
          );
        } elseif ($this->input->post('fieldsType') == 'radio') {
          $opt_settings = array(
            'radioLabel'               => $this->input->post('radioLabel'),
            'radioValue'               => $this->input->post('radioValue'),
            'radioDefault'             => $this->input->post('radioDefault'),
          );
        } else {
          $opt_settings = NULL;
        }

        $opt = array(
          'settings' => json_encode($opt_settings),
        );
          
        $upt = $this->general_m->update('fields_option', $opt, $settings['getDataby_id']->option_id, '', FALSE);
        $option = $settings['getDataby_id']->option_id;
        $data = array(
          'group_id'    =>  $this->input->post('fieldsGroupId'),
          'type_id'     =>  $this->input->post('fieldsTypeId'),
          'option_id'   =>  $option,
          'name'        =>  $this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'label'       =>  ucfirst($this->input->post('name')),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'status'      =>  $this->input->post('status'),
          'created_by'  =>  $this->data['userdata']['id'],
        );

        $this->fields_m->update($data, $id);
        $getFields_type = $this->general_m->get_row_by_id('fields_type', $data['type_id']);
        $content_fields = array(
          'old_name' =>  $settings['getDataby_id']->handle,
          'handle'   =>  $data['handle'],
          'type'     =>  $getFields_type->type,
        );
        // Modify Column content
        modifyColumn($content_fields, 'modify'); 
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully Updated");
        redirect($this->data['parentLink']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
  }

  public function name_check($str) {
    $id = $this->uri->segment(4);
    $field = $this->fields_m->get_row_by_id($id);
    $data = array('name' => $str);
    $check = $this->general_m->get_row_by_fields('fields', $data);
    if(empty($check)) {
      return TRUE;
    }elseif ($field->id == $check->id) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function handle_check($str) {
    $id = $this->uri->segment(4);
    $field = $this->fields_m->get_row_by_id($id);
    $data = array('handle' => $str); 
    $check = $this->general_m->get_row_by_fields('fields', $data);
    if (empty($check)) {
      return TRUE;
    } elseif ($field->id == $check->id) {
      return TRUE;
    } else {
      return TRUE;
    }
  }

  /*Delete fields*/
  public function delete($id='') {
    $settings = array(
      'title'              =>  'fields',
      'subtitle'           =>  FALSE,
      'subbreadcrumb'      =>  FALSE,
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
      'fields_type'        =>  $this->general_m->get_all_results('fields_type'),
      'fields_group'       =>  $this->general_m->get_all_results('fields_group'),
      'fields_group_count' =>  $this->general_m->count_all_results('fields_group'),
      'fields_group_id'    =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'getDataby_id'       =>  $this->fields_m->get_row_by_id($id),
    );
    $settings['getFieldType'] = json_decode($settings['getDataby_id']->settings);

    if ($settings['getDataby_id']) {
      $element_del = $this->general_m->delete('element', $id, 'fields_id');
      $fields = array(
        'handle' => $settings['getDataby_id']->handle,
      );
      // Drop field column in content
      modifyColumn($fields, 'drop');
      $fields_del = $this->fields_m->delete($id);
      $option_del = $this->general_m->delete('fields_option', $settings['getDataby_id']->option_id);
      helper_log('delete', "Delete {settings['title']} with id = {$id} has successfully");
      $this->session->set_flashdata('message', "Data has deleted {$delete} Records");
      redirect($this->data['parentLink']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($this->data['parentLink']);
    }
  }


  /*GROUP fields*/
  public function group() {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/group/index',
      'table'     =>  'fields_group',
      'action'    => 'admin/fields/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
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
    $this->load->view('admin/layout/_default', $settings);
  }

  /*Group Create*/
  public function group_create() {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/group/create',
      'table'     =>  'fields_group',
      'action'    => 'admin/fields/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'        => $this->input->post('name'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Group Update*/
  public function group_update($id='') {
    $settings = array(
      'header'    => 'Group',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/group/edit',
      'table'     =>  'fields_group',
      'action'    => 'admin/fields/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );
    $settings['getDataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'        => $this->input->post('name'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'updated_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Delete Group*/
  public function group_delete($id='') {
    $settings = array(
      'header'    =>  'Group',
      'subheader' =>  'Manage fields',
      'content'   =>  'admin/fields/group/index',
      'table'     =>  'fields_group',
      'action'    =>  'admin/fields/group',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );
    if ($this->general_m->get_row_by_id($settings['table'], $id)) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

  /*TYPE fields*/
  public function type() {
    $settings = array(
      'header'    => 'Type',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/type/index',
      'table'     =>  'fields_type',
      'action'    => 'admin/fields/type',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
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
    
    $this->load->view('admin/layout/_default', $settings);
  }

  /*Type Create*/
  public function type_create() {
    $settings = array(
      'header'    => 'Type',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/type/create',
      'table'     =>  'fields_type',
      'action'    => 'admin/fields/type',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
      'type'      =>  array('VARCHAR', 'INT', 'TEXT', 'DATE', 'DATETIME'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'        => $this->input->post('name'),
          'type'        => $this->input->post('type'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'created_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*type Update*/
  public function type_update($id='') {
    $settings = array(
      'header'    => 'Type',
      'subheader' => 'Manage fields',
      'content'   =>  'admin/fields/type/edit',
      'table'     =>  'fields_type',
      'action'    => 'admin/fields/type',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
      'type'      =>  array('VARCHAR', 'INT', 'TEXT', 'DATE', 'DATETIME'),
    );
    $settings['getDataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE ) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'        => $this->input->post('name'),
          'type'        => $this->input->post('type'),
          'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        => url_title(strtolower($this->input->post('name'))),
          'description' => $this->input->post('description'),
          'updated_by'  => $this->data['userdata']['id'],
        );
        $this->general_m->update($settings['table'], $data, $id);
        helper_log('update', "update ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Delete type*/
  public function type_delete($id='') {
    $settings = array(
      'header'    =>  'Type',
      'subheader' =>  'Manage fields',
      'content'   =>  'admin/fields/type/index',
      'table'     =>  'fields_type',
      'action'    =>  'admin/fields/type',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4), 
    );
    if ($this->general_m->get_row_by_id($settings['table'], $id)) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
  }

}

/* End of file fields.php */
/* Location: ./application/controllers/admin/fields.php */