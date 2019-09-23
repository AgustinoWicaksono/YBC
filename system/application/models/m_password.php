<?php
require_once("class.phpmailer.php");

class M_password extends Model {
		
	function M_password() {
		parent::Model();  
	}
	
	function checkusername($password) {
		$this->db->select('admin_email,admin_realname,plant_type_id');
		$this->db->from('d_admin');
		$this->db->where('admin_username', strtolower($password["password_username"]));

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}
			
	function password_change($password) {
	
		$initial_code = strtoupper(substr(sha1(md5("bid".date('YmdHis').mt_rand(1000000,77000000))."jid"),3,7));
		while ((strpos("###".$initial_code,"0")>0)||(strpos("###".$initial_code,"1")>0)||(strpos("###".$initial_code,"4")>0)){
			$initial_code = strtoupper(substr(sha1(md5("bid".date('YmdHis').mt_rand(1000000,77000000))."jid"),3,7));
		}
		$admin_password = md5($initial_code);
		$password["admin_password"] = $admin_password;
		$password["initial_code"] = $initial_code;
		$admin_username = $password["admin_username"];
		$admin_email = $password["admin_email"];
		$admin_realname = $password["admin_realname"];
		$admin_company = strtoupper($password["plant_type_id"]);
		unset($password['admin_realname']);
		unset($password['admin_email']);
		unset($password['admin_username']);
		unset($password['plant_type_id']);
		if ($admin_company=="BID") 
			$admin_from="sap.helpdesk@ybc.co.id";
		elseif ($admin_company=="JID") 
			$admin_from="sap.helpdesk@jcodonuts.com";
		elseif ($admin_company=="RID") 
			$admin_from="it.helpdesk@ybc.co.id";
		else
			$admin_from="sap.helpdesk@ybc.co.id";
		
		$this->db->where('admin_username', $admin_username);
		if($this->db->update('d_admin', $password))
			$passupdate = TRUE;
		else
			$passupdate = FALSE;
				
				
		if ($passupdate){
			$to1 = $admin_email;
			$toname1 = $admin_realname;

			$from = $admin_from;
			$fromname = "YBC SAP Portal Helpdesk";
			$mailsubject = "Penggantian Password YBC SAP Portal: ".strtoupper($admin_username);
			$msg = "Berikut ini perubahan password user untuk login ke YBC SAP Portal untuk username <b>".strtoupper($admin_username)."</b>:<br /><br />";
			$msg .= "<ul>";
			$msg .= "<li>Username: <b>".$admin_username."</b></li>";
			$msg .= "<li>Password: <b>".$initial_code."</b></li>";
			$msg .= "</ul>";
			$msg .= "<br /><br />Silahkan email ke ".$admin_from." jika Anda masih tidak bisa login ke YBC SAP Portal.<br /><br />Salam,<br /><b>YBC SAP Portal Helpdesk</b>";
			
			if (swbsendmail($to1, $toname1, @$to2, @$toname2, @$cc1, @$ccname1, @$cc2, @$ccname2, $from, $fromname, $mailsubject, $msg)) {}
		}
		
		return $passupdate;
	}
	
	function generate_passwordsql($admin_username){
		$hasil = Array();
		$initial_code = strtoupper(substr(sha1(md5("bid".date('YmdHis').mt_rand(1000000,77000000))."jid"),3,7));
		while ((strpos("###".$initial_code,"0")>0)||(strpos("###".$initial_code,"1")>0)||(strpos("###".$initial_code,"4")>0)){
			$initial_code = strtoupper(substr(sha1(md5("bid".date('YmdHis').mt_rand(1000000,77000000))."jid"),3,7));
		}
		$admin_password = md5($initial_code);
		$swbquery = "update `d_admin` set `admin_password` = '".$admin_password."', `initial_code` = '".$initial_code."' WHERE `admin_username` = '".$admin_username."' ;";
		$hasil['sql']=$swbquery;
		$hasil['initial_code']=$initial_code;
		return $hasil;
	}

	function password_store_change($password) {
		$admin_email = $password["pass_email"];
		$admin_realname = $password["pass_name"];
		$admin_company = strtoupper($password["plant_type_id"]);
		if ($admin_company=="BID") {
			$admin_from="sap.helpdesk@ybc.co.id";
		} elseif ($admin_company=="JID") {
			$admin_from="sap.helpdesk@jcodonuts.com";
		} elseif ($admin_company=="RID") {
			$admin_from="it.helpdesk@ybc.co.id";
		} else {
			$admin_from="sap.helpdesk@ybc.co.id";
		}
		//die ($admin_from.'#'.$admin_company.'#');
		$data=Array();
		
		if ($password['pass_manager']!=FALSE){
			$passgen=$this->generate_passwordsql($password['user_manager']);
			$data['user_manager']=$password['user_manager'];
			$data['password_manager']=$passgen['initial_code'];
			$data['sql_manager']=$passgen['sql'];
			unset($passgen);
		}

		if ($password['pass_supervisor']!=FALSE){
			$passgen=$this->generate_passwordsql($password['user_supervisor']);
			$data['user_supervisor']=$password['user_supervisor'];
			$data['password_supervisor']=$passgen['initial_code'];
			$data['sql_supervisor']=$passgen['sql'];
			unset($passgen);
		}

		if ($password['pass_stocker']!=FALSE){
			$passgen=$this->generate_passwordsql($password['user_stocker']);
			$data['user_stocker']=$password['user_stocker'];
			$data['password_stocker']=$passgen['initial_code'];
			$data['sql_stocker']=$passgen['sql'];
			unset($passgen);
		}

		unset($password);
		
//		die($swbquery1."<hr>".$swbquery2."<hr>".$swbquery3."<hr>");
		$this->db->trans_start();
		if (!Empty($data['user_manager']))
			$this->db->query($data['sql_manager']);
		if (!Empty($data['user_supervisor']))
			$this->db->query($data['sql_supervisor']);
		if (!Empty($data['user_stocker']))
			$this->db->query($data['sql_stocker']);
		$this->db->trans_complete();
		
		$passupdate=TRUE;
		if ($this->db->trans_status() === FALSE)
		{
			$passupdate = FALSE;
		} 
			
				
		if ($passupdate){
			$to1 = $admin_email;
			$toname1 = $admin_realname;

			$from = $admin_from;
			$fromname = "YBC SAP Portal Helpdesk";
			$mailsubject = "Penggantian Password YBC SAP Portal untuk Outlet: ".strtoupper($this->session->userdata['ADMIN']['storage_location_name']);
			$msg = "Berikut ini perubahan password user untuk login ke YBC SAP Portal untuk outlet <b>".strtoupper($this->session->userdata['ADMIN']['storage_location_name'])."</b> (".$this->session->userdata['ADMIN']['plant_name']."):<br /><br />";
			$msg .= "<ul>";
			if (!Empty($data['user_manager'])){
				$msg .= "<li>Username: <b>".$data['user_manager']."</b><br />";
				$msg .= "Password: <b>".$data['password_manager']."</b><br />&nbsp;</li>";
			}
			if (!Empty($data['user_supervisor'])){
				$msg .= "<li>Username: <b>".$data['user_supervisor']."</b><br />";
				$msg .= "Password: <b>".$data['password_supervisor']."</b><br />&nbsp;</li>";
			}
			if (!Empty($data['user_stocker'])){
				$msg .= "<li>Username: <b>".$data['user_stocker']."</b><br />";
				$msg .= "Password: <b>".$data['password_stocker']."</b><br />&nbsp;</li>";
			}
			$msg .= "</ul>";
			$msg .= "<br />Perhatikan huruf besar atau kecil saat memasukkan password.<br /><br />Silahkan email ke ".$admin_from." jika Anda masih tidak bisa login ke YBC SAP Portal.<br /><br />Salam,<br /><b>YBC SAP Portal Helpdesk</b>";
			
//			die( $admin_company.'<hr />'.$msg."<hr />".$to1."<br />".$admin_from."<br />".$toname1);
//			die( "Subj: ".$mailsubject."<hr/>Msg:<br />".$msg."<hr />To: ".$to1."<br />From: ".$admin_from."<br />To Name: ".$toname1);
			if (swbsendmail($to1, $toname1, @$to2, @$toname2, @$cc1, @$ccname1, @$cc2, @$ccname2, $from, $fromname, $mailsubject, $msg)) {}
		} else {
			unset($data);
		}
		
		return $data;
	}
	

	function password_add($data) {
	
	/*
		if($this->db->insert('t_ticket', $data))
			return $this->db->insert_id();
		else
			return FALSE
	*/
	}


}
