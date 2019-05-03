<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends My_Controller {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/fields_m', 'fields_m');
    //Do your magic here
    $this->data = array(
      'userdata'  =>  $this->first_load(),
      'parentLink' => 'admin/fields', 
    );
  }

  public function fields($id='') {
    $settings = array(
      'title'     => 'Group Fields',
      'table'     => 'fields_group',
      'action'    => 'admin/fields',
      'session'   =>  $this->data,
      'id'        =>  $this->input->post('id')
    );
    if ($settings['id']) { 
      $settings['getdataby_id'] =  $this->general_m->get_row_by_id($settings['table'], $settings['id']);
    }

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      $data = array(
        'name'        => $this->input->post('name'),
        'handle'      => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
        'slug'        => url_title(strtolower($this->input->post('name'))),
        'description' => $this->input->post('description'),
      );
      if (isset($_POST['create'])) {

        $data['created_by'] = $this->data['userdata']['id'];
        $this->general_m->create($settings['table'], $data);
        helper_log('add', "add ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'])." successfully");
        $this->session->set_flashdata('message', 'Data has created');
      
      } elseif (isset($_POST['update'])) {
      
        $data['updated_by'] = $this->data['userdata']['id'];
        $this->general_m->update($settings['table'], $data, $settings['id']);
        helper_log('update', "update ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'] )." has successfully");
        $this->session->set_flashdata('message', 'Data has Updated');
      }
      redirect($settings['action']);
    } else {
      if (isset($_POST['delete'])) {
        $delete = $this->general_m->delete($settings['table'], $id);
        helper_log('delete', "Delete data ".($settings['title'] ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
        $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
        redirect($settings['action']);
      }
    }
  }

  // JSON update data 
  public function fields_getdataById() {
    header('Content-type: application/json');
    $id = $this->input->post('id');
    $getdataby_id =  $this->general_m->get_row_by_id('fields_group', $id);
    echo json_encode($getdataby_id);
  }

  // JSON Delete
  public function fields_deleteById() {
    header('Content-type: application/json');
    $id = $this->input->post('id');
    $delete = $this->general_m->delete('fields_group', $id);
    echo json_encode($delete);
  }

  // get fields by broup id
  public function getFieldsByGroupsId(){
    header('content-type: application/json');
    
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
      'fields_group_id'    =>  (($this->input->post('group_id') == 'all') ? '' : $this->input->post('group_id')),
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


}

/* End of file Groups.php */
/* Location: ./application/controllers/admin/Groups.php */