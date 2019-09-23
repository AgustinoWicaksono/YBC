<?php

class Login extends Controller {
	private $jagmodule = array();


	function Login() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1067);  //get module data from module ID
		

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_admin');
		$this->load->model('m_database');
		$this->load->model('m_login');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
	}

	function index() {

//		$referrer = $this->agent->referrer();

//    $this->session->set_userdata('redirect_login', $referrer);
//    $this->session->set_userdata('redirect_login');

		if ($this->l_auth->is_logged_in()) {
      $this->l_auth->go_index();
    } else {
    	$this->login_process();
    }
	}

	function login_process() {
		$this->_login_check();

		if ($this->form_validation->run() == FALSE)
			$this->_login_form();
		else
			$this->_login_process_run();
	}

	function username_wrong() {
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = $this->lang->line("auth_login_fail");
		$object['error_db_access'] = TRUE;
		$object['error_message'] = $this->lang->line("auth_username_wrong_message");
		$this->template->write_view('content', 'login/login_form', $object);
		$this->template->render();
	}

	function password_wrong() {
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = $this->lang->line("auth_login_fail");
		$object['error_db_access'] = TRUE;
		$object['error_message'] = $this->lang->line("auth_password_wrong_message");
		$this->template->write_view('content', 'login/login_form', $object);
		$this->template->render();
	}

	function _login_check() {
		$this->form_validation->set_rules('username', $this->lang->line('auth_username'), 'trim|required');
		$this->form_validation->set_rules('password', $this->lang->line('auth_password'), 'required');
	}

	function _login_form() {
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

//		$this->l_auth->is_have_perm(11, 'view_own_group_perm_name');
		$object['page_title'] = "Sign In";
		$this->template->write_view('content', 'login/login_form', $object);
		$this->template->render();
	}

	function _login_process_run() {
		$username = $this->input->post('username');

		if (!empty($username))
		{
			$login = $this->l_auth->login();

			if ($login['username_right'] == TRUE && $login['password_right'] == TRUE){

				if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
				{
				  $swbipaddress=$_SERVER['HTTP_CLIENT_IP'];
				}
				elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
				{
				  $swbipaddress=$_SERVER['HTTP_X_FORWARDED_FOR'];
				}
				else
				{
				  $swbipaddress=$_SERVER['REMOTE_ADDR'];
				}
				if (Empty($swbipaddress)) { $swbipaddress="";
				} 
				
				$this->m_login->update_login($username,$swbipaddress);


//				if(!empty($_POST['referer']))
//					header('location:'.$_POST['referer']);
//				if(!empty($this->session->userdata['PAGE']['referer']))
//					header('location:'.$this->session->userdata['PAGE']['referer']);
				if(!empty($this->session->userdata['PAGE']['login_redirect']))
					redirect($this->session->userdata['PAGE']['login_redirect']);
				else
						$this->l_auth->go_index();
			} else if ($login['username_right'] == TRUE)
				$this->password_wrong();
			else
				$this->username_wrong();
		}
		else
		{
			$object['page_title'] = $this->lang->line('auth_login');
			$this->template->write_view('content', 'login/login_form', $object);
			$this->template->render();
		}
	}

}

/* End of file login.php */