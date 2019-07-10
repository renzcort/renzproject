<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('admin/General_m', 'general_m');
		$this->load->model('admin/Fields_m', 'fields_m');

		$this->data = array(
			'userdata'          => $this->first_load(),
			'sidebar_activated' => $this->sidebar_activated(),
		);
	}

	public function group(){
		$settings = array(
			'title'             =>  'users',
			'subtitle'          =>  FALSE,
			'breadcrumb'        =>  array('settings'),
			'subbreadcrumb'     =>  FALSE,
			'table'             =>  'usersgroup',
			'action'            =>  'admin/settings/users/group',
			'session'           =>  $this->data,
			'no'                =>  $this->uri->segment(5),
			'button'            =>  '+ New usersgroup',
			'button_link'       =>  'group/create',
			'content'           =>  'template/bootstrap-4/admin/users/users-settings-template',
			'right_content'     =>  'template/bootstrap-4/admin/users/users-group-list',
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

	public function group_create(){
		$settings = array(
			'title'         =>  'users',
			'subtitle'      =>  FALSE,
			'breadcrumb'    =>  array('settings'),
			'subbreadcrumb' =>  FALSE,
			'table'         =>  'usersgroup',
			'action'        =>  'admin/settings/users/group',
			'session'       =>  $this->data,
			'no'            =>  $this->uri->segment(4),
			'button'        =>  'Save',
			'button_type'   =>  'submit',
			'button_name'   =>  'create',
			'content'       =>  'template/bootstrap-4/admin/users/users-group-form',
			'usersgroup'		=>	$this->general_m->get_all_results('usersgroup'),
			'section'       =>	$this->general_m->get_all_results('section'),
			'globals'       =>	$this->general_m->get_all_results('globals'),
			'assets'        =>	$this->general_m->get_all_results('assets'),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_usersgroup.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_usersgroup.handle]');
		if ($this->form_validation->run() == TRUE) {
			if ($_POST['button'] == 'create') {
        $opt_settings = array(
					'generalAccessOff'              => $this->input->post('generalAccessOff'),
					'generalAccessCP'               => $this->input->post('generalAccessCP'),
					'generalCustomizeElementSource' => $this->input->post('generalCustomizeElementSource'),
					'usersEdit'                     => $this->input->post('usersEdit'),
					'usersModerate'                 => $this->input->post('usersModerate'),
					'usersAssignEdit'               => $this->input->post('usersAssignEdit'),
					'usersAssignGroups'             => $this->input->post('usersAssignGroups'),
					'usersAssign'                   => $this->input->post('usersAssign'),
					'usersAdministrate'             => $this->input->post('usersAdministrate'),
					'sectionEdit'                   => $this->input->post('sectionEdit'),
					'sectionPublishLiveChange'      => $this->input->post('sectionPublishLiveChange'),
					'sectionEditOtherAuthors'       => $this->input->post('sectionEditOtherAuthors'),
					'sectionPublishOtherAuthors'    => $this->input->post('sectionPublishOtherAuthors'),
					'sectionDelete'                 => $this->input->post('sectionDelete'),
					'volumeViewVolume'              => $this->input->post('volumeViewVolume'),
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
					'name'     => $this->input->post('name'),
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

	public function group_update($id){
		$settings = array(
			'title'         =>  'users',
			'subtitle'      =>  FALSE,
			'breadcrumb'    =>  array('settings'),
			'subbreadcrumb' =>  FALSE,
			'table'         =>  'usersgroup',
			'action'        =>  'admin/settings/users/group',
			'session'       =>  $this->data,
			'no'            =>  $this->uri->segment(4),
			'button'        =>  'Save',
			'button_type'   =>  'submit',
			'button_name'   =>  'create',
			'content'       =>  'template/bootstrap-4/admin/users/users-group-form',
			'usersgroup'		=>	$this->general_m->get_all_results('usersgroup'),
			'section'       =>	$this->general_m->get_all_results('section'),
			'globals'       =>	$this->general_m->get_all_results('globals'),
			'assets'        =>	$this->general_m->get_all_results('assets'),
			'id'						=>	$id,
      'getDataby_id'  =>  $this->general_m->get_row_by_id('usersgroup', $id),
    );

    $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[renz_usersgroup.name]');
    $this->form_validation->set_rules('handle', 'Handle', 'trim|required|is_unique[renz_usersgroup.handle]');
		if ($this->form_validation->run() == TRUE) {
			if ($_POST['button'] == 'create') {
        $opt_settings = array(
					'generalAccessOff'              => $this->input->post('generalAccessOff'),
					'generalAccessCP'               => $this->input->post('generalAccessCP'),
					'generalCustomizeElementSource' => $this->input->post('generalCustomizeElementSource'),
					'usersEdit'                     => $this->input->post('usersEdit'),
					'usersModerate'                 => $this->input->post('usersModerate'),
					'usersAssignEdit'               => $this->input->post('usersAssignEdit'),
					'usersAssignGroups'             => $this->input->post('usersAssignGroups'),
					'usersAssign'                   => $this->input->post('usersAssign'),
					'usersAdministrate'             => $this->input->post('usersAdministrate'),
					'sectionEdit'                   => $this->input->post('sectionEdit'),
					'sectionPublishLiveChange'      => $this->input->post('sectionPublishLiveChange'),
					'sectionEditOtherAuthors'       => $this->input->post('sectionEditOtherAuthors'),
					'sectionPublishOtherAuthors'    => $this->input->post('sectionPublishOtherAuthors'),
					'sectionDelete'                 => $this->input->post('sectionDelete'),
					'volumeViewVolume'              => $this->input->post('volumeViewVolume'),
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
					'name'     => $this->input->post('name'),
					'handle'   => lcfirst(str_replace(' ', '', ucwords($this->input->post('name')))),
					'settings' => json_encode($opt_settings),
        );

        $this->general_m->update('usersgroup', $data, $id);        
        helper_log('add', "Create {$settings['title']} has successfully");
        $this->session->set_flashdata('message', "{$settings['title']} has successfully created");
        redirect($settings['action']);
			}			
		} else {
	    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
		}
	}

	public function group_delete($id) {
		$settings = array(
      'title'  => 'usersgroup',
      'table'  => 'usersgroup',
      'action' => 'admin/settings/users/group',
    );
    $settings['getDataby_id'] = $this->general_m->get_row_by_id($settings['table'], $id);

    if ($settings['getDataby_id']) {
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