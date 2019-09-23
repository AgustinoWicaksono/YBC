<?php
require_once(APPPATH.'/models/class.phpmailer.php');

class mail extends Controller {
	private $jagmodule = array();


	function mail() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1069);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

	
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}
	
	function index()
	{
		$this->input();
	}

	
	
	


	function sendmail() {
		$data = $_POST;
		
		$data_checksum = md5('YBC'.$data['mail_user'].$data['mail_time'].$data['mail_outlet']);
		if ($data_checksum===$data['mail_checksum']){
		
			if ($this->session->userdata['ADMIN']['plant_type_id']=="JID") $mail_domain = "@jcodonuts.com";
			else $mail_domain = "@ybc.co.id";
			
			$mail_from = $this->session->userdata['ADMIN']['admin_email'];
			$mail_fromname = $this->session->userdata['ADMIN']['admin_realname'];
			
			if ($data['mail_type']=='SAP') {$mail_address = 'sap.helpdesk';$mail_addressname = 'SAP Helpdesk';}
			elseif ($data['mail_type']=='HR') {$mail_address = 'hr.helpdesk';$mail_addressname = 'HR Helpdesk';}
			elseif ($data['mail_type']=='SYSTEM') {$mail_address = 'it.helpdesk';$mail_addressname = 'IT Helpdesk';}
			else {$mail_address = 'it.helpdesk';$mail_addressname = 'IT Helpdesk';}
			
			$mail_address = $mail_address.$mail_domain;
			if (Empty($mail_from)) $mail_from = $mail_address;
			
			
			$mail_subject = '[Web '.$data['mail_type'].'-'.$data['mail_timestamp'].'-'.$data['mail_outlet'].']: Error '.$data['mail_trans'];

			$data['error_text'] = str_replace("\r\n",'<br />',$data['error_text']);
			$data['error_text'] = str_replace("\n",'<br />',$data['error_text']);
			$data['error_text'] = str_replace("\r",'<br />',$data['error_text']);
			
			$data['error_text'] = $data['error_text'].'<br /><br />=======<br />'.$data['mail_error'].'<br />=======';
			$mail_body = 'Dear '.$mail_addressname.',<br /><br />';
			$mail_body .= 'Mohon bantuan untuk menyelesaikan error berikut saat melakukan transaksi <b>Web '.$data['mail_type'].': '.$data['mail_trans'].'</b>. Berikut ini detail error:<br /><br /><table border="1" align="center" width="100%"><tr><td style="color:#AA1122;padding:0.5em;">'.$data['error_text'].'</td></tr></table>';
			$mail_body .= '<br /><br />Terima kasih,<br />'.$mail_fromname;
			
			/* //debug
			echo 'From: '.$mail_from.'<hr />';
			echo 'To: '.$mail_address.'<hr />';
			echo 'Subject: '.$mail_subject.'<hr />';
			echo 'Body: <br />'.$mail_body.'<hr />';
			die();
			*/			
			if (swbsendmail($mail_address, $mail_addressname, NULL, NULL, $mail_from, $mail_fromname, NULL, NULL, $mail_from, $mail_fromname, $mail_subject, $mail_body)) {}
			
			$object['refresh'] = 1;
			$object['refresh_time'] = 3;
			$object['refresh_text'] = 'Detail error telah berhasil dikirim ke SX. Silahkan menunggu balasan email dari SX untuk mengatasi error tersebut.';
			$object['refresh_url'] = $data['mail_redirect'];

			$this->template->write_view('content', 'success', $object);
			$this->template->render();
		}
	}


}
