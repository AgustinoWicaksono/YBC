<?php
class forget extends Controller {
	private $jagmodule = array();


	function forget() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1063);  //get module data from module ID
		

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_password');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}
	
	function index()
	{
		$this->input();
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


	function _data_check() {
		$this->form_validation->set_rules('password_username', 'Username', 'trim|required');
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
            $object['data']['email'] = "";

			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Lupa Password';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'forget/forget_input', $object);
		$this->template->render();
	}
	
	function not_exist() {
		$passuser = $this->uri->segment(3);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Username '.$passuser.' tidak terdaftar dalam sistem kami. Silahkan cek kembali apakah username tersebut sudah tepat?';
        $object['refresh_url'] = 'forget';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function password_failed() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Proses penggantian password gagal. Silahkan coba kembali beberapa saat lagi.';
        $object['refresh_url'] = 'forget';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '002';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function ask_am() {
		$passuser = $this->uri->segment(3);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Untuk mengganti password dengan username '.$passuser.' harus melalui Area Manager.<br>Silahkan hubungi Area Manager Anda agar menindaklanjuti ke SX.';
        $object['refresh_url'] = 'forget';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '003';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	

	function _data_add() {
		$password = $_POST;
		unset($password['button']);
		
		$swbuser = strtolower($password["password_username"]);
		// end of assign variables and delete not used variables
		if ((strpos($swbuser,"_manager")>0)||(strpos($swbuser,"_supervisor")>0)){
   		  redirect('forget/ask_am/'.$password["password_username"]);
		} else {
			$id_username = $this->m_password->checkusername($password);
			if ($id_username==FALSE) {
			  redirect('forget/not_exist/'.$password["password_username"]);
			}

			$password['admin_username'] = $password['password_username'];
			$password['admin_email'] = $id_username[0]['admin_email'];
			$password['admin_realname'] = $id_username[0]['admin_realname'];
			$password['plant_type_id'] = $id_username[0]['plant_type_id'];
			unset($password['password_username']);

			if ($this->m_password->password_change($password)) {

				$this->l_general->success_page('Password telah dikirim ke email Anda', site_url('/'));
			
			} else {
				redirect('forget/password_failed');
			}
		}
	}


}
