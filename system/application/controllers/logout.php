<?php

class Logout extends Controller {
	private $jagmodule = array();


	function Logout() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1068);  //get module data from module ID
		
	}

	function index() {
		$this->session->sess_destroy();
//		$this->session->set_userdata('referer', $_SERVER['REQUEST_URI']);
//		$this->l_auth->save_referer_and_login();
		$this->l_page->save_page_and_login('login_redirect');
		//echo $this->session->userdata['PAGE']['referer'];
		redirect('');
	}

/*
	function index()
	{
		$data['page_title'] = "Logout";
		$this->load->view('logout/index', $data);
	}

	function logout_execute()
	{
		$this->session->sess_destroy();
		redirect('logout');
	}

	function confirm() {
		$data['page_title'] = "Confirmation";
		$this->load->view('logout/logout_confirm', $data);
	}
*/

}

/* End of file logout.php */