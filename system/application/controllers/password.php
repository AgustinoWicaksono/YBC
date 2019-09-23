<?php
class password extends Controller {
	private $jagmodule = array();


	function password() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1070);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('support_password'))
			redirect('');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_password');

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


	   	if(!empty($_POST)) {
			$this->_data_add();
	   	} else {
 			$this->_data_form();
		}

			

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

		$object['page_title'] = 'Ganti Password Personel Outlet';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'password/password_input', $object);
		$this->template->render();
	}
	
	function password_failed() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Proses penggantian password gagal. Silahkan coba kembali beberapa saat lagi.';
        $object['refresh_url'] = 'password';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function no_input() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Silahkan pilih minimal salah satu. Anda belum memilih username outlet untuk diubah kata sandinya.';
        $object['refresh_url'] = 'password';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '002';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function pass_success($data,$swbmail) {
		$object['refresh'] = 0;
		$keterangan = 'Password berhasil diubah. Berikut ini keterangan perubahan password:<br />&nbsp;';
		$keterangan .= '<div style="color:#353535;font-weight:normal;padding:10px;border:#aabbcc 1px solid;">';

		$keterangan .= '<ul>';
		if ($data['user_manager']!=FALSE){
			$keterangan .= '<li>Username: <b>'.$data['user_manager'].'</b><br />';
			$keterangan .= '<li>Password: <b>'.$data['password_manager'].'</b><br />&nbsp;</li>';
		}
		if ($data['user_supervisor']!=FALSE) {
			$keterangan .= '<li>Username: <b>'.$data['user_supervisor'].'</b><br />';
			$keterangan .= '<li>Password: <b>'.$data['password_supervisor'].'</b><br />&nbsp;</li>';
		}
		if ($data['user_stocker']!=FALSE) {
			$keterangan .= '<li>Username: <b>'.$data['user_stocker'].'</b><br />';
			$keterangan .= '<li>Password: <b>'.$data['password_stocker'].'</b><br />&nbsp;</li>';
		}
		$keterangan .= '</ul>Perhatikan huruf besar atau kecil saat memasukkan password.';
		$keterangan .= '</div>';
		$keterangan .= '<br />Salinan password juga telah dikirim ke email Anda di: '.@$swbmail;
		
		$object['refresh_text'] = $keterangan;
        $object['refresh_url'] = '/';
		$this->template->write_view('content', 'success', $object);
		$this->template->render();
	}
	

	function _data_add() {
		$password = $_POST;
		unset($password['button']);
		$swbmail=$password['pass_email'];
	
		
		if ((Empty($password['pass_manager']))&&(Empty($password['pass_supervisor']))&&(Empty($password['pass_stocker']))){
			redirect('password/no_input');
		} else {
			if (!Empty($password['pass_manager']))
				$password['user_manager'] = $password['pass_storecode']."_manager";
			if (!Empty($password['pass_supervisor']))
				$password['user_supervisor'] = $password['pass_storecode']."_supervisor";
			if (!Empty($password['pass_stocker']))
				$password['user_stocker'] = $password['pass_storecode']."_stocker";

			if ($data=$this->m_password->password_store_change($password)) {
				$this->pass_success($data,$swbmail);
			} else {
				redirect('password/password_failed');
			}
			
		}
	}


}
