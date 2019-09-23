<?php
class Status extends Controller {
	private $jagmodule = array();


	function Status() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1015);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('masterdata_status'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_status');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}
	
	function index()
	{
		$this->browse();
	}

	function browse() {
		$status_browse_result = $this->session->userdata['PAGE']['status_browse_result'];

		if(!empty($status_browse_result))
			redirect($this->session->userdata['PAGE']['status_browse_result']);
		else
			redirect('status/browse_result');
	
	}

	function browse_result()	{

		$this->l_page->save_page('status_browse_result');

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['data']['status'] = $this->m_status->statuses_select_all();

		$object['page_title'] = 'List of Employee Status';
		$this->template->write_view('content', 'status/status_browse', $object);
		$this->template->render();

	}

	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_data_form(0, $data);
	   	} else {
	 			$this->_data_form();
	     }

		} else {
			$this->_data_add();
		}

	}

	function edit() {

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_data_form(0, $data);
    	} else {
        $data = $this->m_status->status_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
		$this->form_validation->set_rules('status', 'Employee Status', 'trim|required');
	}
	
	function _data_form($reset=0, $data=NULL) {
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
//			$member['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Employee Status';
		
		$uri_segment2 = $this->uri->segment(3);
		
//		if($uri_segment2 == 'input')
			$this->l_page->save_page('next');

		$this->template->write_view('content', 'status/status_input', $object);
		$this->template->render();
	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$status = $_POST;
		unset($status['button']);
		// end of assign variables and delete not used variables

		if($this->m_status->status_add($status)) {

			$object['page_title'] = 'Data Status Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data status berhasil dimasukkan.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
	
			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		
		}
	}

	function _data_update()	{
		// start of assign variables and delete not used variables
		$status = $_POST;
		unset($status['button']);
		// end of assign variables and delete not used variables

		if($this->m_status->status_update($status)) {
			
			$object['page_title'] = 'Data Status Berhasil Diubah';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data status berhasil diubah.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
	
			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
		
	}

}
