<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends My_Controller {

  protected $data = [];
  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    $this->load->model('admin/Field_m', 'field_m');
    $this->load->model('admin/Section_m', 'section_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
    // $this->load->model('admin/Element_m', 'element_m');
    $this->data = array(
      'title'    =>  'Content',
      'userdata' =>  $this->first_load(),
    );
  }
 
  public function index() {
    $settings = array(
      'title'     =>  'content',
      'subheader' =>  'Manage Content',
      'content'   =>  'admin/content/index',
      'table'     =>  'content',
      'action'    => 'admin/content',
      'session'   =>  $this->data,
      'no'        =>  $this->uri->segment(4),
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
    $settings['entries']    = $this->entries_m->get_all_results($config['per_page'], $start_offset);
    $settings['record_all'] = $this->entries_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    
    $this->load->view('admin/layout/_default', $settings);        
  }

}

/* End of file Content.php */
/* Location: ./application/controllers/admin/Content.php */