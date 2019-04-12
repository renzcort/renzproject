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
    );
  }

  public function index() {
    $settings = array(
      'title'       =>  'fields',
      'subtitle'    =>  FALSE,
      'button'      =>  '+ New Widget',
      'button_conf' =>  FALSE,
      'content'     =>  'template/bootstrap-4/admin/fields/fields-list',
      'table'       =>  'fields',
      'action'      =>  'admin/fields',
      'session'     =>  $this->data,
      'no'          =>  $this->uri->segment(3),
      'group'       =>  $this->general_m->get_all_results('fields_group'),
      'group_count' =>  $this->general_m->count_all_results('fields_group'),
      'group_id'    =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
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
    $settings['record_all'] = $this->fields_m->get_all_results($config['per_page'], $start_offset, $settings['group_id']);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  public function create() {
    $settings = array(
      'title'     =>  'fields',
      'subheader' =>  'Manage fields',
      'content'   =>  'admin/fields/create',
      'table'     =>  'fields',
      'action'    =>  'admin/fields',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(3),
      'group'     =>  $this->general_m->get_all_results('fields_group'),
      'type'      =>  $this->general_m->get_all_results('fields_type'),
      'group_id'  =>  ($this->input->get('group_id') ? $this->input->get('group_id') : ''),
      'attributes'=>  arraY('type' =>
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

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    // $this->form_validation->set_rules('handle', 'Handle', 'trim|required');
    $this->form_validation->set_rules('type', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {

        // get Attributes
        foreach ($this->input->post('attrType') as $key => $value) {
          $attrb[] = "`$key` => {$value[0]}";
        }
        $attributes = implode(', ', $attrb);
        
        $option = array(
          'asset_id'    =>  $this->input->post('asset'),
          'action'      =>  $this->input->post('attrAction'),
          'line_breaks' =>  $this->input->post('line_breaks'),
          'images'      =>  $this->input->post('images'),
          'limit'       =>  $this->input->post('limit'),
          'content'     =>  $this->input->post('content'),
          'settings'    =>  $attributes,
        );
        foreach ($this->input->post('attrType') as $key => $value) {
          $option["{$key}"] = implode($value);
        }
        $option = $this->general_m->create('fields_option', $option, FALSE);
        
        $data = array(
          'group_id'    =>  $this->input->post('group'),
          'option_id'   =>  $option,
          'name'        =>  $this->input->post('name'),
          'label'       =>  ucfirst($this->input->post('name')),
          'type_id'     =>  $this->input->post('type'),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'status'      =>  $this->input->post('status'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->fields_m->create($data);
        $getfields_type = $this->general_m->get_row_by_id('fields_type', $data['type_id']);
        $fieldss = array(
          'handle' =>  $data['handle'],
          'type'   =>  $getfields_type->type,
        );
        // add Column content
        modifyColumn($fieldss, 'add'); 
        
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*fields Update*/
  public function update($id='') {
    $settings = array(
      'title'        =>  'fields',
      'subheader'    =>  'Manage fields',
      'content'      =>  'admin/fields/edit',
      'table'        =>  'fields',
      'action'       =>  'admin/fields',
      'session'      =>  $this->data,
      'no'           =>  $this->uri->segment(3),
      'group'        =>  $this->general_m->get_all_results('fields_group'),
      'type'         =>  $this->general_m->get_all_results('fields_type'),
      'getdataby_id' =>  $this->fields_m->get_row_by_id($id),
      'attributes'=>  arraY('type' =>
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
    // var_dump($settings['getdataby_id']);die;
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    // $this->form_validation->set_rules('handle', 'Handle', 'trim|required');
    $this->form_validation->set_rules('type', 'fields Type', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {

        $data = array(
          'group_id'    =>  $this->input->post('group'),
          'option_id'   =>  $settings['getdataby_id']->option_id,
          'name'        =>  $this->input->post('name'),
          'label'       =>  ucfirst($this->input->post('name')),
          'type_id'     =>  $this->input->post('type'),
          'description' =>  $this->input->post('description'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'status'      =>  $this->input->post('status'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->fields_m->update($data, $id);
        $getfields_type = $this->general_m->get_row_by_id('fields_type', $data['type_id']);
        $fieldss = array(
          'old_name' =>  $settings['getdataby_id']->handle,
          'handle'   =>  $data['handle'],
          'type'     =>  $getfields_type->type,
        );
        // Modify Column content
        modifyColumn($fieldss, 'modify'); 

        // get Attributes
        foreach ($this->input->post('attrType') as $key => $value) {
          $attrb[] = "`$key` => {$value[0]}";
        }
        $attributes = implode(', ', $attrb);

        $option = array(
          'asset_id'    =>  $this->input->post('asset'),
          'action'      =>  $this->input->post('attrAction'),
          'line_breaks' =>  $this->input->post('line_breaks'),
          'images'      =>  $this->input->post('images'),
          'limit'       =>  $this->input->post('limit'),
          'content'     =>  $this->input->post('content'),
          'settings'    =>  $attributes,
        );
        foreach ($this->input->post('attrType') as $key => $value) {
          $option["{$key}"] = implode($value);
        }
        // var_dump($option);die;
        $this->general_m->update('fields_option', $option, $settings['getdataby_id']->option_id, '', FALSE);
        redirect($settings['action']);
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }
  }

  /*Delete fields*/
  public function delete($id='') {
    $settings = array(
      'title'        =>  'fields',
      'subheader'    =>  'Manage fields',
      'content'      =>  'admin/fields/edit',
      'table'        =>  'fields',
      'action'       =>  'admin/fields',
      'session'      =>  $this->data,
      'no'           =>  $this->uri->segment(3),
      'group'        =>  $this->general_m->get_all_results('fields_group'),
      'type'         =>  $this->general_m->get_all_results('fields_type'),
      'getdataby_id' =>  $this->fields_m->get_row_by_id($id),
    );
    if ($settings['getdataby_id']) {
      $this->general_m->delete('element', $id, 'fields_id');
      $delete = $this->general_m->delete($settings['table'], $id);
      $this->general_m->delete('fields_option', $settings['getdataby_id']->option_id);
      $fieldss = array(
        'handle'   =>  $settings['getdataby_id']->handle,
      );
      // Drop Column content
      modifyColumn($fieldss, 'drop'); 
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
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
    $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
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
    $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $id);
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