<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Authority and Permission Class
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class L_auth {

	function L_auth() {
		$this->obj =& get_instance();
		$this->obj->load->model('m_admin');
		$this->obj->load->model('m_perm');
		$this->obj->load->model('m_general');
		$this->obj->lang->load('g_perm',$this->obj->session->userdata('lang_name'));
	}

	/**
	 * ['email_right'] TRUE if email right, or FALSE if email wrong;
	 * ['password_right'] TRUE if password right, or FALSE if password wrong;
	 * @return array which contain TRUE or FALSE of some variables
	 */
	function login() {

		$username = $this->obj->input->post('username');
		$password = $this->obj->input->post('password');

		$return = array (
			'username_right' => FALSE,
			'password_right' => FALSE,
		);

		$return['username_right'] = $this->obj->m_admin->check_username_exist($username);

    if(!empty($password)) { // empty password used when user forgot the password
  		if($return['username_right']) {
  			$return = $this->obj->m_admin->check_username_password($username, $password);

  			if($return['password_right']) {
  				$userdata['ADMIN'] = $this->obj->m_admin->admin_select($return['admin_id']);

					$plant = $this->obj->m_general->sap_plant_select_by_id($userdata['ADMIN']['plant']);

					$userdata['ADMIN']['password'] = $password;
                	$userdata['ADMIN']['plant_name'] = $plant['OUTLET_NAME1'];
                	$userdata['ADMIN']['storage_location'] = $plant['STOR_LOC'];
                	$userdata['ADMIN']['storage_location_name'] = $plant['STOR_LOC_NAME'];
                	$userdata['ADMIN']['cost_center'] = $plant['COST_CENTER'];
                	$userdata['ADMIN']['cost_center_name'] = $plant['COST_CENTER_TXT'];
        		$userdata['ADMIN']['hr_plant_code'] = $plant['HR_CODE'];

					$plant_type = $this->obj->m_general->sap_jenisoutlet_select($userdata['ADMIN']['plant_type_id']);
					$userdata['ADMIN']['plant_type_name'] = $plant_type['jenisoutlet'];

					$userdata['logged_in'] = TRUE;
					$userdata['password'] = $password; // only for temporary, to check on $l_auth->startup()
					$userdata['startup'] = 1; // only for temporary, to run startup function
  				$this->obj->session->set_userdata($userdata);
  			}
  		}
    }
		return $return;
	}

	/**
	 * return TRUE or FALSE;
	 * if TRUE, if already logged in;
	 * if FALSE, if not logged in;
	 * @return bool
	 */
	function is_logged_in() {

		if ($this->obj->session) {

			//If user has valid session, check if is it logged in?
			if ($this->obj->session->userdata('logged_in'))
				return TRUE;
			else
				return FALSE;

		} else {
			return FALSE;
		}
	}

	/**
	 * return TRUE or FALSE;
	 * if TRUE, member have permission;
	 * if FALSE, member not have permission;
	 * @param string $perm_name permission name, based on milis_r_perm table, perm_name column
	 * @param int $member_id Member ID
	 * @return bool
	 */
	function is_have_perm($perm_name, $admin_id = 0) {

		if($admin_id === 0)
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		if(is_array($perm_name)) {

			foreach($perm_name as $perm_value) {

				if(empty($perm_value))
					return TRUE;

//				echo $perm_value;
				$perm_group_ids = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);
//				print_r($perm_groups_id);
//				echo $perm_group_id." ";

				foreach($perm_group_ids as $perm_group_id) {
					$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);

					$perm_code = $this->obj->m_perm->perm_code_select($perm_value);
	//				echo $perm_code." ";
					@$perm_have = substr_count($admin_perm, $perm_code);
	//				echo $perm_have." ";

					if($perm_have || ($admin_perm == "*"))
						return TRUE;
				}


			}
			return FALSE;

		} else {

			$perm_group_ids = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);
//				echo $perm_group_id." ";

			foreach($perm_group_ids as $perm_group_id) {
				if(empty($perm_group_id))
					return TRUE;

				$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);
	//				echo $member_perm." ";
				$perm_code = $this->obj->m_perm->perm_code_select($perm_name);
	//				echo $perm_code." ";
				@$perm_have = substr_count($admin_perm, $perm_code);

				if($perm_have || ($admin_perm == "*"))
					return TRUE;

			}

			return FALSE;

		}

	}

	/**
	 * return TRUE or FALSE;
	 * if TRUE, member have permission on that category;
	 * if FALSE, member not have permission on that category;
	 * @param string $perm_name permission name, based on milis_r_perm table, perm_name column
	 * @param integer $member_id member ID
	 * @return bool
	 */
	function is_have_perm_category($perm_name, $admin_id = 0) {
	// return TRUE or FALSE
	// if TRUE, admin have permission
	// if FALSE, admin not have permission

		if($admin_id === 0)
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		if(is_array($perm_name)) {

			foreach($perm_name as $perm_value) {
				if(empty($perm_value))
					return TRUE;

				$perm_groups_id = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);

				foreach($perm_groups_id as $perm_group_id) {
					$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);
					$perm_code = $this->obj->m_perm->perm_category_code_select($perm_value);
					@$perm_have = substr_count($admin_perm, $perm_code);

					if($perm_have || ($admin_perm == "*"))
						return TRUE;
				}

			}

			return FALSE;

		} else {

			$perm_groups_id = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);

			foreach($perm_groups_id as $perm_group_id) {
				$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);
				$perm_code = $this->obj->m_perm->perm_category_code_select($perm_name);
				@$perm_have = substr_count($admin_perm, $perm_code);

				if($perm_have || ($admin_perm == "*"))
					return TRUE;
			}

			return FALSE;

		}

	}

	/**
	 * Return the array which contains compossite of the keys of the input array
	 * For example
	 * $arr['one'] = array {
	 * 	'perm1',
	 * 	'perm2',
	 * }
	 * $arr['two'] = array {
	 *	 'perm3',
	 * }
	 * $arr_merge = $this->perm_code_merge($arr);
	 * $arr_merge will be => array {
	 * 	'perm1',
	 * 	'perm2',
	 * 	'perm3',
	 * }
	 * @param array $perm_code array with keys
	 * @return array
	 */
	function perm_code_merge($perm_code) {

		$temp = array_keys($perm_code);

		foreach($temp as $key1 => $value1) {
			foreach($perm_code[$value1] as $key2 => $value2) {
				if(!is_array($value2))
					$return[] = $value2;
			}
		}
		return $return;
	}

	/**
	 * Return array which contains permission category and list of permissions from a group permission
	 * @param integer $group_id
	 * @return array|false
	 */
	function perm_group_detail($group_id) {

		if(!$perm_group = $this->obj->m_perm->perm_group_select($group_id))
    	return FALSE;

		if(!$perms = $this->obj->m_perm->perms_select_all())
			return FALSE;

		$detail = array();
		// will be $detail[$i][$j]
		// $i and $j declared below, based on content of $perms

		foreach ($perms->result_array() as $perm) {

			$i = $perm['cat_id']; // array dimension 1
			$j = $perm['perm_order']; // array dimension 2

			// define GROUP permission
			if(!isset($detail[$i][0])) {
				$detail[$i][0] = $perm;
				$detail[$i][0]['category_name'] = $perm['category_name'];
				$detail[$i][0]['category_descr'] = $this->obj->lang->line('perm_opt_category_'.$perm['category_name']);
				$detail[$i][0]['category_code'] = $perm['category_code'];
			}

			// define permission
			if(substr_count($perm_group['group_perms'], $perm['category_code'].sprintf("%02s", $perm['perm_code']))) {
				$detail[$i][$j] = $perm;
				$detail[$i][$j]['perm_descr'] = $this->obj->lang->line('perm_opt_'.$perm['perm_name']);
			}

		}

		return $detail;

	}

	/**
	 * Show the layout of permission category and list of permissions from a group permission
	 * Based from $this->perm_group_detail()
	 * @param integer $group_id
	 * @return string HTML content which will be displayed to end user
	 */
	function perm_group_detail_show($group_id) {
		$return = '';

		$detail = $this->perm_group_detail($group_id);

		foreach ($detail as $key1 => $detail1) {

    	$count = count($detail1);

			if($count > 1) {
				$j = 1; // counter to match with last of $detail1
				foreach ($detail1 as $key2 => $detail2) {

					if($key2 == 0) {
						$return .= "<strong>".$detail2['category_descr']."</strong>\n";
						$return .= "<ul>\n";
					} else {
						$return .= "<li>".$detail2['perm_descr']."</li>\n";
					}

					if($j == ($count)) {
						$return .= "</ul>\n";
					}

					$j++;
				}
			}

		}

		return $return;
	}

	/**
	 * Go to index page
	 * @return void
	 */
  function go_index() {
/*
    $redirect_login = $this->obj->session->userdata('redirect_login');

    if (!empty($redirect_login))
      redirect($redirect_login);
    else
 */
     redirect('home');
  }

	function startup() {

		$startup = $this->obj->session->userdata('startup');

		if(!empty($startup)) {

			$this->obj->load->library('form_validation');
			$this->obj->load->model('m_admin');
			$this->obj->load->model('m_config');

			// start of check password
			/*
			$pwd = $this->obj->session->userdata('password');

			if(!empty($pwd)) {
				if(!$this->obj->form_validation->valid_password($pwd)) {
					if(uri_string(current_url()) != '/admin/password_edit')
						redirect('admin/password_edit');
				}
	//			} else {
	//				$this->obj->session->unset_userdata('password');
	//			}
			}

			 */
			// end of check password

//			if(!$this->is_have_perm('member_approve_all')) {
//				$member_tek_time_expire = $this->obj->m_config->content_select('member_tek_time_expire');
//
//				if($this->obj->m_member->check_tek_expire($this->obj->session->userdata['ADMIN']['admin_id'], $member_tek_time_expire)) {
//					if(uri_string(current_url()) != '/member/tek_add')
//						redirect('member/tek_add');
//				}
//			}
			// unset the startup variable
			$this->obj->session->unset_userdata('startup');
			$this->obj->session->unset_userdata('password');

		}
	}

}

/* End of file L_auth.php */
/* Location: ./system/application/libraries/L_auth.php */