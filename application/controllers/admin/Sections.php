<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sections extends My_Controller {

	protected $data = [];

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
    $this->load->model('admin/fields_m', 'fields_m');
    $this->load->model('admin/Sections_m', 'sections_m');
    $this->load->model('admin/General_m', 'general_m');
    $this->load->model('admin/Entries_m', 'entries_m');
		$this->data = array(
      'userdata'  =>  $this->first_load(),
      'parentLink' => 'admin/fields', 
    );
	}

	public function index() {
    $settings = array(
      'title'              =>  'sections',
      'subtitle'           =>  FALSE,
      'subbreadcrumb'      =>  FALSE,
      'button'             =>  '+ New section',
      'button_link'        =>  'sections/create',
      'content'            =>  'template/bootstrap-4/admin/sections/section-list',
      'table'              =>  'sections',
      'action'             =>  'admin/sections',
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
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
    $settings['record_all'] = $this->sections_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
	}

	/*Create Section*/
	public function create(){
    $settings = array(
      'title'              =>  'sections',
      'subtitle'           =>  'create',
      'subbreadcrumb'      =>  FALSE,
      'button'             =>  'Save',
      'button_type'        =>  'submit',
      'button_name'        =>  'create',
      'content'            =>  'template/bootstrap-4/admin/sections/section-form',
      'table'              =>  'sections',
      'action'             =>  'admin/sections/create',
      'session'            =>  $this->data,
      'no'                 =>  $this->uri->segment(3),
      'sections_type'      =>  $this->general_m->get_all_results('sections_type'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_sections.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_sections.handle]');
		$this->form_validation->set_rules('type', 'Type Section', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (isset($_POST['create'])) {
				$data = array(
					'name'        =>	$this->input->post('name'),
					'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'type_id'     =>	$this->input->post('sectionType'),
					'slug'        =>  url_title(strtolower($this->input->post('name'))),
					'description' =>	$this->input->post('description'),
					'order'       =>	$this->input->post('order'),
					'created_by'  =>	$this->data['userdata']['id'],
				);
				$this->sections_m->create($data);
      	helper_log('add', "add data ".(isset($settings['title']) ? $settings['title'] : $this->data['title']." ".$settings['header'] )." {$id} has successfully");				$this->session->set_flashdata('message', 'Data has created');
				redirect($settings['action']);
			}
		} else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
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
		$settings['getdataby_id'] = $this->sections_m->get_row_by_id($id);
 
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
				$this->sections_m->update($data, $id);
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

		if ($this->sections_m->get_row_by_id($id)) {
      $this->general_m->delete('element', $id, 'section_id');
      $this->general_m->delete('entries', $id, 'section_id');
      $delete = $this->sections_m->delete($id);
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

  /*Entries Section*/
  public function entries_section() {
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage Entries',
      'content'    =>  'admin/section/entries/index',
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
  public function entries_section_create() {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/section/entries/create',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(3),
      'field'      =>  $this->fields_m->get_all_results(),
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
          $this->general_m->delete('element', $entries_id, 'section_id');
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
  public function entries_section_update($id='') {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/section/entries/edit',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(4),
      'field'      =>  $this->fields_m->get_all_results(),
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
  public function entries_section_delete($id='') {
    $section_id =  $this->input->get('section_id');
    $settings = array(
      'title'      =>  'entries',
      'subheader'  =>  'Manage entries',
      'content'    =>  'admin/section/entries/index',
      'table'      =>  'entries',
      'action'     =>  'admin/section/entries',
      'session'    =>  $this->data,
      'no'         =>  $this->uri->segment(4),
      'field'      =>  $this->fields_m->get_all_results(),
      'element'    =>  $this->general_m->get_result_by_id('element', $id, 'entries_id'),
      'section_id' =>  $section_id,
    );

    if ($this->entries_m->get_row_by_id($id)) {
      $this->general_m->delete('content', $id, 'entries_id');
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

/* End of file Section.php */
/* Location: ./application/controllers/admin/Section.php */