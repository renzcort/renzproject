<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends My_Controller {
  protected $data = [];

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/Field_m', 'field_m');
    $this->load->model('admin/Section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
    //Do your magic here
    $this->data = array(
      'title'    =>  'Entries',
      'userdata' =>  $this->first_load(),
    );
  }

  public function index() {
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage Entries',
      'content'    =>  'admin/entries/index',
      'table'      =>  'entries',
      'action'     => 'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(4),
      'section_id' =>  $this->input->get('section_id'),
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->entries_m->count_all_results();
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page'];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->entries_m->get_result_by_id($settings['section_id'], $config['per_page'], $start_offset, 'section_id');
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    
    $this->load->view('admin/layout/_default', $settings);    
  }

  /*Create*/
  public function create() {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/entries/create',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(3),
      'field'      =>  $this->field_m->get_all_results(),
      'element'    =>  $this->general_m->get_result_by_id('element', $section_id, 'section_id'),
      'section_id' =>  $section_id,
    );

    if ($settings['element']) {
      foreach ($settings['element'] as $key => $value) {
        $settings['field_checked'][] = $value->field_id;
      }
    } else {
        $settings['field_checked'][] = '';
    }
    // var_dump($settings['section_id']); die;

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['create'])) {
        $data = array(
          'name'        =>  $this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'section_id'  =>  $section_id,
          'title'       =>  $this->input->post('title'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $entries_id = $this->entries_m->create($data);

        $field = $this->input->post('field');
        if (!empty($field)) {
          $this->general_m->delete('element', $entries_id);
          $i = 0;
          foreach ($field as $key => $value) {
            $element = array(
              'entries_id' =>  $entries_id,
              'section_id' =>  $section_id,
              'field_id'   =>  $value,
              'order'      =>  $i++, 
            );
            $this->general_m->create('element', $element, FALSE);
          }
        }
        helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");        
        $this->session->set_flashdata('message', 'Data has created');
        redirect("{$settings['action']}?section_id={$section_id}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }

  /*uPDATE*/
  public function update($id='') {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/entries/edit',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(4),
      'field'      =>  $this->field_m->get_all_results(),
      'element'    =>  $this->general_m->get_result_by_id('element', $id, 'entries_id'),
      'section_id' =>  $section_id,
    );
    $settings['getdataby_id'] = $this->entries_m->get_row_by_id($id);
    if ($settings['element']) {
      foreach ($settings['element'] as $key => $value) {
        $settings['field_checked'][] = $value->field_id;
      }
    } else {
        $settings['field_checked'][] = '';
    }
    // var_dump($settings['getdataby_id']); die;

    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if (isset($_POST['update'])) {
        $data = array(
          'name'        =>  $this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'section_id'  =>  $settings['section_id'],
          'title'       =>  $this->input->post('title'),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'updated_by'  =>  $this->data['userdata']['id'],
        );
        $this->entries_m->update($data, $id);

        $field = $this->input->post('field');
        $this->general_m->delete('element', $id, 'entries_id');
        $i = 0;
        foreach ($field as $key => $value) {
          $element = array(
            'entries_id' =>  $id,
            'section_id' =>  $settings['section_id'],
            'field_id'   =>  $value,
            'order'      =>  $i++, 
          );
          // var_dump($element);die;
          $this->general_m->create('element', $element, FALSE);
        }
        
        helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");        
        $this->session->set_flashdata('message', 'Data has created');
        redirect("{$settings['action']}/?section_id={$section_id}");
      }
    } else {
      $this->load->view('admin/layout/_default', $settings);
    }    
  }

  /*Delete*/
  public function delete($id='') {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/entries/edit',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(4),
      'field'      =>  $this->field_m->get_all_results(),
      'element'    =>  $this->general_m->get_result_by_id('element', $id, 'entries_id'),
      'section_id' =>  $section_id,
    );

    if ($this->entries_m->get_row_by_id($id)) {
      $this->general_m->delete('element', $id, 'entries_id');
      $delete = $this->entries_m->delete($id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect("{$settings['action']}/?section_id={$section_id}");
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect("{$settings['action']}/?section_id={$section_id}");
    }
  }
}

/* End of file Entries.php */
/* Location: ./application/controllers/admin/Entries.php */