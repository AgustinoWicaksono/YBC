<?php
class Config extends Controller {

	function config() {

		parent::Controller();

		if(!$this->l_auth->is_logged_in()) {
			$this->l_page->save_page_and_login('login_redirect');
		}

		$this->l_auth->startup();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_config');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_config', $this->session->userdata('lang_name'));
	}

	function index() {
		$this->view();
	}

	// display all segment of configuration
	function view() {

		// start of check page permission
		$perm_codes = array (
			'config_view_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$object['page_title'] = $this->lang->line('config_config');
		$object['configs'] = $this->m_config->configs_select_all();

		$this->template->write_view('content', 'config/config_view', $object);
		$this->template->render();

	}

	function config_edit() {
		// start of check page permission
		$perm_codes = array (
			'config_edit_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('config');
		// end of check page permission

		if(!empty($_POST)) {
			$this->_config_update();
		} else {
			$this->l_page->save_page('next', 'referer');
			$data = $this->m_config->configs_select_all();
			$this->_config_form(0, $data);
		}

	}

	function _config_form($reset=0, $data=NULL) {

		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
			//      $member['data']['sex'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = $this->lang->line('config_config_edit');

		$this->template->write_view('content', 'config/config_form', $object);
		$this->template->render();
	}

	// update config
	function _config_update()	{

		// start of check page permission 1
		$perm_codes = array (
			'config_edit_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('config');
		// end of check page permission 1

/*
		// assign member data
		$config = $_POST;

		// delete not used vars
		unset($config['submit']);
*/

		foreach($_POST['config'] as $key => $value) {

			$data['config_name'] = $key;
			$data['content'] = $value;

			$this->m_config->config_update($data);
		
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = $this->lang->line('redirect_config_update_success');
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

}

/* End of file config.php */
/* Location: ./system/application/controller/config.php */