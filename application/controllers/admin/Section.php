<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends My_Controller {

	protected $data = [];

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('admin/Section_m', 'section_m');
		$this->load->model('admin/General_m', 'general_m');
		$this->data = array(
			'title'    =>	'Section',
			'userdata' =>	$this->first_load(),
		);
	}

	public function index() {
		$settings = array(
			'title'     =>	'Section',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/index',
			'table'     =>	'section',
			'action'    => 'admin/section',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3)
		);

		// pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->section_m->count_all_results();
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page'];
    $config['uri_segment']  = 4;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->section_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end pagination
		
		$this->load->view('admin/layout/_default', $settings);
	}

	/*Create Section*/
	public function create(){
		$settings = array(
			'title'     =>	'Section',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/create',
			'table'     =>	'section',
			'action'    => 'admin/section',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3),
      'type'      =>  $this->general_m->get_all_results('section_type'),
		);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('type', 'Type Section', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (isset($_POST['create'])) {
				$data = array(
					'name'        =>	$this->input->post('name'),
					'type_id'     =>	$this->input->post('type'),
					'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'slug'        =>  url_title(strtolower($this->input->post('name'))),
					'description' =>	$this->input->post('description'),
					'order'       =>	$this->input->post('order'),
					'created_by'  =>	$this->data['userdata']['id'],
				);
				$this->section_m->create($data);
      	helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");				$this->session->set_flashdata('message', 'Data has created');
				redirect($settings['action']);
			}
		} else {
			$this->load->view('admin/layout/_default', $settings);
		}
	}

	/*Update Section*/
	public function update($id=''){
		$settings = array(
			'title'     =>	'Section',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/edit',
			'table'     =>	'section',
			'action'    => 'admin/section',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3),
      'type'      =>  $this->general_m->get_all_results('section_type'),
		);
		$settings['getdataby_id'] = $this->section_m->get_row_by_id($id);
 
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('type', 'Type Section', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (isset($_POST['update'])) {
				$data = array(
					'name'        =>	$this->input->post('name'),
					'type_id'     =>	$this->input->post('type'),
					'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'slug'        =>  url_title(strtolower($this->input->post('name'))),
					'description' =>	$this->input->post('description'),
					'order'       =>	$this->input->post('order'),
					'updated_by'  =>	$this->data['userdata']['id'],
				);
				$this->section_m->update($data, $id);
	      helper_log('update', "update data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
				$this->session->set_flashdata('message', 'Data has updated');
				redirect($settings['action']);
			}
		} else {
			$this->load->view('admin/layout/_default', $settings);
		}
	}

	/*Delete Section*/
	public function delete($id='') {
		$settings = array(
			'title'        =>	'Section',
			'subheader'    =>	'Manage Section',
			'content'      =>	'admin/section/index',
			'table'        =>	'section',
			'action'       => 'admin/section',
			'session'      =>	$this->data,
			'no'           =>	$this->uri->segment(3),
		);

		if ($this->section_m->get_row_by_id($id)) {
      $delete = $this->section_m->delete($id);
      helper_log('delete', "Delete data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");
      $this->session->set_flashdata('message', "Data has successfully Deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
	}


	/*Type Section*/
	public function type() {
		$settings = array(
			'header'    =>	'Type',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/type/index',
			'table'     =>	'section_type',
			'action'    =>	'admin/section/type',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(4),
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

	/*Create Type Section*/
	public function type_create() {
		$settings = array(
			'header'    =>	'Type',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/type/create',
			'table'     =>	'section_type',
			'action'    =>	'admin/section/type',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3),
		);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (isset($_POST['create'])) {
				$data = array(
					'name'        =>	$this->input->post('name'),
					'description' =>	$this->input->post('description'),
					'slug'        =>	url_title($this->input->post('name')),
					'created_at'  =>	$this->data['userdata']['id'],
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

	/*Update Type Section*/
	public function type_update($id='') {
		$settings = array(
			'header'    =>	'Type',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/type/edit',
			'table'     =>	'section_type',
			'action'    =>	'admin/section/type',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3),
		);
		$settings['getdataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (isset($_POST['update'])) {
				$data = array(
					'name'        =>	$this->input->post('name'),
					'description' =>	$this->input->post('description'),
					'slug'        =>	url_title($this->input->post('name')),
					'created_at'  =>	$this->data['userdata']['id'],
				);
				$this->general_m->update($settings['table'], $data, $id);
	      helper_log('update', "update data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");				$this->session->set_flashdata('message', 'Data has Updated');
				redirect($settings['action']);
			}
		} else {
			$this->load->view('admin/layout/_default', $settings);
		}
	}

	/*Delete Type Section*/
	public function type_delete($id='') {
		$settings = array(
			'header'    =>	'Type',
			'subheader' =>	'Manage Section',
			'content'   =>	'admin/section/index',
			'table'     =>	'section_type',
			'action'    =>	'admin/section/type',
			'session'   =>	$this->data,
			'no'        =>	$this->uri->segment(3),
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

/* End of file Section.php */
/* Location: ./application/controllers/admin/Section.php */