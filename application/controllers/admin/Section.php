<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends My_Controller {

	protected $data = [];

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
      'parentLink' => 'admin/settings/section', 
    );
	}

	public function index() {
    $settings = array(
      'title'         =>  'section',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'table'         =>  'section',
      'action'        =>  'admin/settings/section',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
      'button'        =>  '+ New section',
      'button_link'   =>  'section/create',
      'content'       =>  'template/bootstrap-4/admin/section/section-list',
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
    $settings['record_all'] = $this->section_m->get_all_results($config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
	}

	/*Create Section*/
	public function create(){
    $settings = array(
      'title'         =>  'section',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'table'         =>  'section',
      'action'        =>  'admin/settings/section/create',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'content'       =>  'template/bootstrap-4/admin/section/section-form',
      'section_type'  =>  $this->general_m->get_all_results('section_type'),
      'sites'         =>  $this->general_m->get_row_by_fields('sites', $data = array('primary' => '1')),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_section.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_section.handle]');
		$this->form_validation->set_rules('section-type', 'Type Section', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if ($_POST['button'] == 'create') {
				$data = array(
					'name'        =>	ucfirst($this->input->post('name')),
					'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'type_id'     =>	$this->input->post('section-type'),
          'sites_id'  =>  $settings['sites']->id,
					'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'url'         =>  $this->input->post('url'),
          'template'    =>  $this->input->post('template'),
          'activated'   =>  ($this->input->post('activated') ? $this->input->post('activated') : 0),
					'description' =>	$this->input->post('description'),
					'order'       =>	$this->input->post('order'),
					'created_by'  =>	$this->data['userdata']['id'],
				);
        // create session
				$section_id = $this->section_m->create($data);
        // insert entries auto after create seassion
        $entries_data = array(
          'section_id'  =>  $section_id,
          'name'        =>  ucfirst($this->input->post('name')),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'order'       =>  '1',
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $this->general_m->create('section_entries', $entries_data);
      	helper_log('add', "Create {$settings['title']} has successfully");				
        $this->session->set_flashdata("message", "{$settings['title']} has successfully created");
				redirect($this->data['parentLink']);
			}
		} else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
		}
	}

	/*Update Section*/
	public function update($id=''){
    $settings = array(
      'title'         =>  ucfirst('section'),
      'subtitle'      =>  'edit',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'table'         =>  'section',
      'action'        =>  'admin/settings/section/edit',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(3),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/section/section-form',
      'section_type'  =>  $this->general_m->get_all_results('section_type'),
      'sites'         =>  $this->general_m->get_row_by_fields('sites', $data = array('primary' => '1')),
      'id'            =>  $id,
      'getDataby_id'  =>  $this->section_m->get_row_by_id($id),
    );


    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_name_check');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|callback_handle_check');
    $this->form_validation->set_rules('section-type', 'Type Section', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'update') {
        $data = array(
          'name'        =>  ucfirst($this->input->post('name')),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'type_id'     =>  $this->input->post('section-type'),
          'sites_id'  =>  $settings['sites']->id,
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'url'         =>  $this->input->post('url'),
          'template'    =>  $this->input->post('template'),
          'activated'   =>  ($this->input->post('activated') ? $this->input->post('activated') : 0),
          'description' =>  $this->input->post('description'),
          'order'       =>  $this->input->post('order'),
          'updated_by'  =>  $this->data['userdata']['id'],
        );
        $this->section_m->update($data, $id);
        helper_log('update', "Update {$settings['title']} has successfully");        
        $this->session->set_flashdata("message", "{$settings['title']} has successfully updated");
        redirect($this->data['parentLink']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }
	}

	/*Delete Section*/
	public function delete($id='') {
    $settings = array(
      'title'         =>  ucfirst('section'),
      'table'         =>  'section',
      'getDataby_id'  =>  $this->section_m->get_row_by_id($id)
    );

		if ($settings['getDataby_id']) {
      $deleteElement = $this->general_m->delete('element', $id, 'section_id');
      $deleteEntries = $this->general_m->delete('section_entries', $id, 'section_id');
      $delete        = $this->section_m->delete($id);
      helper_log('delete', "Delete {$settings['title']} with id = {$id} has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");      
      redirect($this->data['parentLink']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($this->data['parentLink']);
    }
	}

  public function name_check($str) {
    $id = $this->uri->segment(5);
    $field = $this->section_m->get_row_by_id($id);
    $data = array('name' => $str);
    $check = $this->general_m->get_row_by_fields('section', $data);
    if(empty($check)) {
      return TRUE;
    }elseif ($field->id == $check->id) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function handle_check($str) {
    $id = $this->uri->segment(5);
    $field = $this->section_m->get_row_by_id($id);
    $data = array('handle' => $str); 
    $check = $this->general_m->get_row_by_fields('section', $data);
    if (empty($check)) {
      return TRUE;
    } elseif ($field->id == $check->id) {
      return TRUE;
    } else {
      return TRUE;
    }
  }

  /*Entries Section*/
  public function entrytypes($section_id='') {
    $section = $this->section_m->get_row_by_id($section_id);
    $settings = array(
      'title'         =>  "{$section->name} Entry Type",
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('entries'),
      'table'         =>  'section_entries',
      'action'        =>  "admin/settings/section/{$section_id}/entrytypes",
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(5),
      'button'        =>  '+ New entry type',
      'button_link'   =>  "entrytypes/create",
      'content'       =>  'template/bootstrap-4/admin/section/section-entries-list',
    );

    // pagination
    $config                 = $this->config->item('setting_pagination');
    $config['base_url']     = base_url($settings['action']);
    $config['total_rows']   = $this->general_m->count_all_results($settings['table']);
    $config['per_page']     = 10;
    $num_pages              = $config['total_rows'] / $config['per_page'];
    $config['uri_segment']  = 5;
    $config['num_links']    = round($num_pages);
    $this->pagination->initialize($config);
    $start_offset           = ($this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0);
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset, $section_id, 'section_id');
    $settings['links']      = $this->pagination->create_links();
    // end pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

  /*entrues type create*/
  public function entrytypes_create($section_id='') {
    $settings = array(
      'title'          =>  "Entry Type",
      'subtitle'       =>  'create',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'table'          =>  'section_entries',
      'action'         =>  "admin/settings/section/{$section_id}/entrytypes",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'button'         =>  'Save',
      'button_type'    =>  'submit',
      'button_name'    =>  'create',
      'button_tabs'    =>  TRUE,
      'content'        =>  'template/bootstrap-4/admin/section/section-entries-form',
      'section_id'     =>  $section_id,
      'section'        =>  $this->section_m->get_row_by_id($section_id),
      'fields_element' =>  'element',
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'element'        =>  [],
      'elementFields'  =>  [],
      'order'          =>  $this->general_m->get_max_fields('section_entries', 'order'),
    );


    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_entries.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_entries.handle]');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'create') {
        $data = array(
          'name'        =>  ucfirst($this->input->post('name')),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'section_id'  =>  $section_id,
          'title'       =>  ucfirst($this->input->post('title')),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'order'       =>  $this->input->post('order'),
          'created_by'  =>  $this->data['userdata']['id'],
        );
        $entries = $this->general_m->create($settings['table'], $data);
        helper_log('add', "Create {$settings['title']} has successfully");
        //get fields to element 
        $fieldsId = $this->input->post('fieldsId');
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'entries_id'  =>  $entries,
              'section_id'  =>  $id_section,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
            $this->general_m->create('element', $element, FALSE);
          }
          helper_log('add', "Create element has successfully {$element['order']} records");
        }
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($settings['action']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }    
  }

  /*entries type update*/
  public function entrytypes_update($section_id='', $id) {
    $settings = array(
      'title'          =>  "Entry Type",
      'subtitle'       =>  'Edit',
      'breadcrumb'     =>  array('settings'),
      'subbreadcrumb'  =>  array('create'),
      'button'         =>  'Update',
      'button_type'    =>  'submit',
      'button_name'    =>  'update',
      'button_tabs'    =>  TRUE,
      'content'        =>  'template/bootstrap-4/admin/section/section-entries-form',
      'table'          =>  'section_entries',
      'action'         =>  "admin/settings/section/{$section_id}/entrytypes",
      'session'        =>  $this->data,
      'no'             =>  $this->uri->segment(3),
      'fields_element' =>  'element',
      'section_id'     =>  $section_id,
      'section'        =>  $this->section_m->get_row_by_id($section_id),
      'fields_group'   =>  $this->general_m->get_all_results('fields_group'),
      'fields'         =>  $this->fields_m->get_all_results(),
      'getDataby_id'   =>  $this->general_m->get_row_by_id('section_entries', $id),
      'element'        =>  $this->general_m->get_result_by_id('element', $id, 'entries_id'),
    );

    if ($settings['element']) {
      foreach ($settings['element'] as $key) {
        $fieldsId[] = $key->fields_id; 
      }
      $settings['elementFields'] = $fieldsId;
    } else {
      $settings['elementFields'] = [];
    }

    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_name_check');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|callback_handle_check');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
      if ($_POST['button'] == 'update') {
        $data = array(
          'name'        =>  ucfirst($this->input->post('name')),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
          'section_id'  =>  $section_id,
          'title'       =>  ucfirst($this->input->post('title')),
          'slug'        =>  url_title(strtolower($this->input->post('name'))),
          'description' =>  $this->input->post('description'),
          'order'       =>  $this->input->post('order'),
          'updated_by'  =>  $this->data['userdata']['id'],
        );
        $this->entries_m->update($data, $id);
        helper_log('edit', "Update {$settings['title']} has successfully");
        //get fields to element 
        $this->general_m->delete('elemet', $id, 'entries_id');
        $fieldsId = $this->input->post('fieldsId');
        if (!empty($fieldsId)) {
          $i = 0;
          foreach ($fieldsId as $value) {
            $element = array(
              'entries_id'  =>  $id,
              'section_id'  =>  $section_id,
              'fields_id'   =>  $value,
              'order'       =>  ++$i,
            );
            $this->general_m->create('element', $element, FALSE);
          }
          helper_log('edit', "edit element entries id {$id} has successfully {$element['order']} record");
        }
        $this->session->set_flashdata("message", "Entries has successfully updated");
        redirect($settings['action']);
      }
    } else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    }   
  }

  /*Enteie Type Delete*/
  public function entrytypes_delete($section_id, $id) {
    $settings = array(
      'title'          => 'Entries',
      'section_id'     => $section_id,
      'fields_element' => 'element',
      'getDataby_id'   => $this->general_m->get_row_by_id('section_entries', $id),
      'action'         =>  "admin/settings/section/{$section_id}/entrytypes",
    );

    if ($settings['getDataby_id']) {
      $deleteElement = $this->general_m->delete('element', $id, 'entries_id');
      $delete        = $this->general_m->delete('section_entries', $id);
      helper_log('delete', "Delete {$settings['title']} with id = {$id} has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }

  }


  /*Type Section*/
  public function type() {
    $settings = array(
      'title'         =>  'section',
      'subtitle'      =>  FALSE,
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  FALSE,
      'button'        =>  '+ New section',
      'button_link'   =>  'type/create',
      'content'       =>  'template/bootstrap-4/admin/section/type/section-type-list',
      'table'         =>  'section_type',
      'action'        =>  'admin/settings/section/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(5),
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
    $settings['record_all'] = $this->general_m->get_all_results($settings['table'], $config['per_page'], $start_offset);
    $settings['links']      = $this->pagination->create_links();
    // end Pagination
    
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
  }

	/*Create Type Section*/
	public function type_create() {
    $settings = array(
      'title'         =>  'Section Type',
      'subtitle'      =>  'create',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('create'),
      'button'        =>  'Save',
      'button_type'   =>  'submit',
      'button_name'   =>  'create',
      'content'       =>  'template/bootstrap-4/admin/section/type/section-type-form',
      'table'         =>  'section_type',
      'action'        =>  'admin/settings/section/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
    );

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if ($_POST['button'] == 'create') {
				$data = array(
					'name'        =>	$this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'description' =>	$this->input->post('description'),
					'slug'        =>	url_title($this->input->post('name')),
					'created_by'  =>	$this->data['userdata']['id'],
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

	/*Update Type Section*/
	public function type_update($id='') {
		$settings = array(
      'title'         =>  'Section Type',
      'subtitle'      =>  'update',
      'breadcrumb'    =>  array('settings'),
      'subbreadcrumb' =>  array('edit'),
      'button'        =>  'Update',
      'button_type'   =>  'submit',
      'button_name'   =>  'update',
      'content'       =>  'template/bootstrap-4/admin/section/type/section-type-form',
      'table'         =>  'section_type',
      'action'        =>  'admin/settings/section/type',
      'session'       =>  $this->data,
      'no'            =>  $this->uri->segment(4),
      'id'            =>  $id,
      'getDataby_id'  =>  $this->general_m->get_row_by_id('section_type', $id)
		);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if ($_POST['button'] == 'update') {
				$data = array(
					'name'        =>	$this->input->post('name'),
          'handle'      =>  lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'description' =>	$this->input->post('description'),
					'slug'        =>	url_title($this->input->post('name')),
					'created_by'  =>	$this->data['userdata']['id'],
				);
				$this->general_m->update($settings['table'], $data, $id);
        helper_log('edit', "Update {$settings['title']} has successfully");
        $this->session->set_flashdata("message", "Entries has successfully updated");
				redirect($settings['action']);
			}
		} else {
      $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
		}
	}

	/*Delete Type Section*/
	public function type_delete($id='') {
		$settings = array(
			'title'         =>  'Section Type',
      'table'         =>  'section_type',
      'action'        =>  'admin/settings/section/type',
      'getDataby_id'  =>  $this->general_m->get_row_by_id('section_type', $id)
		);
    
    if ($settings['getDataby_id']) {
      $delete = $this->general_m->delete($settings['table'], $id);
      helper_log('delete', "Delete {$settings['title']} with id = has successfully");
      $this->session->set_flashdata('message', "{$settings['title']} has deleted {$delete} Records");   
      redirect($settings['action']);
    } else {
      $this->session->set_flashdata('message', 'Your Id Not Valid');
      redirect($settings['action']);
    }
	}

}

/* End of file Section.php */
/* Location: ./application/controllers/admin/Section.php */