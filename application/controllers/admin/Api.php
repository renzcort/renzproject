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
  public function jsonEntrytypes() {
    $section_id = $this->input->post('section_id');
    $id         = $this->input->post('id');
    $button     = $this->input->post('button');

    $settings = array(
      'title'         =>  ucfirst("New Entry Types"),
      'subtitle'      =>  FALSE,
      'subbreadcrumb' =>  FALSE,
      'button'        =>  (($button == 'create') ? 'Save' : 'Update'),
      'button_type'   =>  'submit',
      'button_name'   =>  (($button == 'create') ? 'create' : 'Update'),
      'button_tabs'   =>  TRUE,
      'content'       =>  'template/bootstrap-4/admin/section/section-entries-form',
      'table'         =>  'entries',
      'action'        =>  "admin/section/{$section_id}/entrytypes",
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'section_id'    =>  $section_id,
      'section'       =>  $this->section_m->get_row_by_id($section_id),
      'fields_group'  =>  $this->general_m->get_all_results('fields_group'),
      'fields'        =>  $this->fields_m->get_all_results(),
    );

    if ($button == 'update') {
      $settings['getDataby_id']  =  $this->entries_m->get_row_by_id($id);
      $settings['element']       =  $this->general_m->get_result_by_id('element', $id, 'entries_id');

      if ($settings['element']) {
        foreach ($settings['element'] as $key) {
          $fieldsId[] = $key->fields_id; 
        }
        $settings['elementFields'] = $fieldsId;
      } else {
        $settings['elementFields'] = [];
      }
    }        

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_entries.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_entries.handle]');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      $settings['errors'] = array(
        'name'   => form_error('name'),
        'handle' => form_error('handle'),
        'title'  => form_error('title'),
      );

      $data = array(
        'name'        =>  $this->input->post('name'),
        'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
        'section_id'  =>  $section_id,
        'title'       =>  ucfirst($this->input->post('title')),
        'slug'        =>  url_title(strtolower($this->input->post('name'))),
        'description' =>  $this->input->post('description'),
        'order'       =>  $this->input->post('order'),
        'created_by'  =>  $this->data['userdata']['id'],
      );
      if ($button == 'create') {
        $entries = $this->entries_m->create($data);
        helper_log('add', "add data entries has successfully");        
      } else {
        $entries = $this->entries_m->update($data, $id);
        helper_log('edit', "Update data entries has successfully");        
      }
      //get fields to element 
      if (!empty($this->input->post('fieldsId'))) {
        $fieldsId = $this->input->post('fieldsId');
        $this->general_m->delete('element', $id, 'fields_id');
        $i = 0;
        foreach ($fieldsId as $value) {
          $element = array(
            'entries_id'  =>  (($button == 'create') ? $entries : $id),
            'section_id'  =>  $section_id,
            'fields_id'   =>  $value,
            'order'       =>  ++$i,
          );
          $this->general_m->create('element', $element, FALSE);
        }
        helper_log('add', "add element create has successfully {$element['order']} record");
        $this->session->set_flashdata("message", "Entries has successfully Create");
      }
      $settings['status'] = TRUE;
      echo json_encode($settings);
    } else {
      $settings['errors'] = array(
        'name'   => form_error('name'),
        'handle' => form_error('handle'),
        'title'  => form_error('title'),
      );
      $settings['status'] = FALSE;
      echo json_encode($settings);
    }    
  }

  // Update Order
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
    $group_id = $this->input->post('group_id');
    $group_name = $this->input->post('group_name');
    $groups =  $this->general_m->get_row_by_id($group_name, $group_id);
    echo json_encode($groups);
  }

    // JSON Delete
  public function jsonDeleteGroupsById() {
    header('Content-type: application/json');
    $group_id   = $this->input->post('group_id');
    $group_name = $this->input->post('group_name');
    $table      = $this->input->post('table');
    $getFields = $this->general_m->get_result_by_id($table, $group_id, 'group_id');
    if (!empty($getFields)) {
      foreach ($getFields as $key) {
        $element_del = $this->general_m->delete('element', $key->id, 'fields_id');
        $fields = array(
          'handle' => $key->handle,
        );
        // Drop field column in content
        modifyColumn($fields, 'drop');
        $fields_del = $this->fields_m->delete($key->id);
        $option_del = $this->general_m->delete('fields_option', $key->option_id);
      }
    }
    $delete = $this->general_m->delete('fields_group', $group_id);
    echo json_encode($delete);
  }

  // CRUD Groups
  public function jsonGroupsManage() {

  }
  
  // Show Fields By Id Groups
  public function jsonGetDataByIdGroups(){
    header('content-type: application/json');
    $group_name = $this->input->post('group_name');
    $settings = array(
      'table'       =>  'fields',
      'action'      =>  'admin/fields',
      'group'       =>  $this->general_m->get_all_results($group_name),
      'group_count' =>  $this->general_m->count_all_results($group_name),
      'group_id'    =>  (($this->input->post('group_id') == 'all') ? '' : $this->input->post('group_id')),
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
    
    if($settings['record_all']) {
      $table = '
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
         $table .= '<tr>
            <th scope="row">'.++$no.'</th>
            <td><a href="'.base_url($settings['action'].'/update/'.$key->id).'">'.($key->name ? $key->name : '').'</a></td>
            <td>'.($key->handle ? $key->handle : '').'</td>
            <td>'.($key->type_name ? $key->type_name : '').'</td>
            <td><a href="'.base_url($settings['action'].'/delete/'.$key->id).'" data-id="'.$key->id.'">
              <i class="fas fa-minus-circle"></i></a>
            </td>
          </tr>';
        }
      $table .= '</tbody></table>';
    } else {
      $table = '<p class="empty-data">Data is Empty</p>';
    }
    echo json_encode($table);
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
      $element_del = $this->general_m->delete('element', $id, 'fields_id');
      $fields = array(
        'handle' => $getDataby_id->handle,
      );
      // Drop field column
      modifyColumn($fields, 'drop');
      $fields_del = $this->fields_m->delete($id);
      $option_del = $this->general_m->delete('fields_option', $getDataby_id->option_id);
      helper_log('delete', "Delete fields with id = {$id} has successfully");
      $this->session->set_flashdata('message', "Data has deleted {$delete} Records");
      echo json_encode($getDataby_id);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
    }
  }


}

/* End of file Api.php */
/* Location: ./application/controllers/admin/Api.php */