<?php
class M_login extends Model {
		
	function M_login() {
		parent::Model();  
	}


	function update_login($username,$swbipaddress) {
		$this->db->where('admin_username', $username);
		$this->db->set('admin_ipaddress',$swbipaddress);
		$this->db->set('admin_lastlogin','NOW()',false);
		if($this->db->update('d_admin'))
			return TRUE;
		else
			return FALSE;
	}

}
