<?php
/**
 * Admin Model
 * This model class related to admin data
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_admin extends Model {

	/**
	 * Admin Model
	 * This model class related to admin data
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_admin() {
		parent::Model();
    $this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->obj =& get_instance();
	}

	/**
	 * Check username when login
	 * is username exist on database?
	 * if exist, return TRUE
	 * if not exist, return FALSE
	 * @param string $username Username of the person
	 * @return bool TRUE if username exist on the database, FALSE if username not exist on the database.
	 */
	function check_username_exist($username) {

//		$query = $this->db->select('email_id')
		$this->db->select('admin_id');
		$this->db->from('d_admin');
		$this->db->where('admin_username', $username);
		//	->_compile_select();
		//echo $query;
		$rows = $this->db->count_all_results();
//		echo $this->db->last_query();

		if($rows)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Check employee when login
	 * is employee exist on database?
	 * if exist, return TRUE
	 * if not exist, return FALSE
	 * @param string $username Username of the person
	 * @return bool TRUE if username exist on the database, FALSE if username not exist on the database.
	 */
	function check_employee_exist($username) {

//		$query = $this->db->select('email_id')
		$this->db->select('employee_id');
		$this->db->from('m_employee');
		$this->db->where("(nik = '".$username."' OR email_kantor = '".$username."' OR email_pribadi = '".$username."') AND (portal_access = 1)");
		//	->_compile_select();
		//echo $query;
		$rows = $this->db->count_all_results();
//		echo $this->db->last_query();

		if($rows)
			return TRUE;
		else
			return FALSE;
	}	

    function admin_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '') {

		if(empty($field_content))
			$field_content = '';


		if(empty($field_content))
			$field_content = '';

		$this->db->from('d_admin');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'admin_id';
					break;
				case 'b':
					$field_name_ori = 'admin_username';
					break;
				case 'c':
					$field_name_ori = 'admin_realname';
					break;

			}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'admin_id';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'admin_id';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'admin_username';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'admin_username';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'admin_realname';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'admin_realname';
					$field_sort_type = 'desc';
					break;

			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		$query = $this->db->get();
//echo $this->db->last_query();

		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

  function admin_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('d_admin');

		// start of searching

		if(!empty($field_content)) {
			switch($field_name) {
				case 'a':
					$field_name_ori = 'admin_id';
					break;
				case 'b':
					$field_name_ori = 'admin_username';
					break;
				case 'c':
					$field_name_ori = 'admin_realname';
					break;

			}
			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}




		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'admin_id';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'admin_id';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'admin_username';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'admin_username';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'admin_realname';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'admin_realname';
					$field_sort_type = 'desc';
					break;

			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		$this->db->limit($limit, $start);

		$query = $this->db->get();

//echo $this->db->last_query();
		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	/**
	 * Check [username and] password when login.
   * Assume username exist on the database.
	 * @param string $username Username of admin
	 * @param string $password Password of admin
	 * @return array
	 */
	function check_username_password($username, $password) {

		$return = array();

		$this->db->select('admin_id');
		$this->db->from('d_admin');
		$this->db->where('admin_username', $username);
		$this->db->where('admin_password', md5($password));
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();
			$return['username_right'] = TRUE;
			$return['password_right'] = TRUE;
		} else {
			$return['admin_id'] = FALSE;
			$return['admin_right'] = TRUE;
			$return['username_right'] = TRUE;
			$return['password_right'] = FALSE;
		}

		return $return;
	}

	/**
	 * Check [employee and] password when login.
   * Assume employee exist on the database.
	 * @param string $username Username of admin
	 * @param string $password Password of admin
	 * @return array
	 */
	function check_employee_password($username, $password) {

		$return = array();

		$this->db->select('employee_id,plant,nama,nik,portal_password,email_kantor');
		$this->db->from('m_employee');
		$this->db->where("(nik = '".$username."' OR email_kantor = '".$username."' OR email_pribadi = '".$username."') AND (portal_password = '".md5($password)."') ");
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();

			$this->db->select('admin_id');
			$this->db->from('d_admin');
			$this->db->where('admin_emp_id', intval($return['employee_id']));
			
			$query = $this->db->get();

			if($query->num_rows() > 0) {
				$admin_id = $query->row_array();
				$admin_id = $admin_id['admin_id'];
			} else {
				$admin_id = 1;
			}
			$return['admin_emp_id'] = $return['employee_id'];
			$return['admin_id'] = $admin_id;
			$return['username_right'] = TRUE;
			$return['password_right'] = TRUE;
		} else {
			$return['admin_id'] = FALSE;
			$return['admin_right'] = TRUE;
			$return['username_right'] = TRUE;
			$return['password_right'] = FALSE;
		}

		return $return;
	}
	
	/**
	 * Check [employee and] password when login.
   * Assume employee exist on the database.
	 * @param string $username Username of admin
	 * @param string $password Password of admin
	 * @return array
	 */
	function check_employee_data($admin_id) {

		$return = array();

		$this->db->select('a.employee_id, a.nik, a.nama');
		$this->db->from('m_employee a, d_admin b');
		$this->db->where("a.employee_id = b.admin_emp_id and b.admin_id = ".$admin_id);
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();

		} else {
			$return = FALSE;
		}

		return $return;
	}	
	
	/**
	 * Check password when login.
	 * @param string $password Password of admin (a admin can have multiple email address)
	 * @return bool TRUE if password right, FALSE if password wrong.
	 */
	function check_password($password) {
		$this->db->select('admin_id');
		$this->db->from('d_admin');
		$this->db->where('admin_id', $this->session->userdata['ADMIN']['admin_id']);
		$this->db->where('admin_password', md5($password));

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	/**
	 * Get admin fields.
	 * @param integer $admin_id Admin ID
	 * @return array|false Admin fields data
	 */
	function admin_select($admin_id = 0) {

		$admin_id = (int) $admin_id;

		if(empty($admin_id)){
			if (!empty($this->obj->session->userdata['ADMIN']))
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];
			else $admin_id=0;
		}

		$this->db->from('d_admin, d_perm_group');
		$this->db->where('admin_id', $admin_id);
//		$this->db->where('group_id = perm_grups_id');
			//->_compile_select();

		$query = $this->db->get();
//		 echo $this->db->last_query(); echo '<hr />';

		if($query->num_rows() > 0) {
			$admin = $query->row_array();

			return $admin;

		} else {
			return FALSE;
		}

	}

	/**
	 * Get admin username field from an admin.
	 * Used especially to post to SAP
	 * @param integer $admin_id Admin ID
	 * @return array|false Admin fields data
	 */
	function admin_select_username($admin_id) {

		$admin_id = (int) $admin_id;

		if(empty($admin_id))
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		$this->db->from('d_admin, d_perm_group');
		$this->db->where('admin_id', $admin_id);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$admin = $query->row_array();

			return $admin['admin_username'];

		} else {
			return FALSE;
		}

	}

	/**
	 * Get all admin fields.
	 * @return resource|false Query of admin table data
	 */
	function admins_select_all() {
//		$this->db->from('d_admin')
//			->order_by('admin_name');

//		$this->db->from('d_admin, d_perm_group');
//		$this->db->where('group_id = perm_grups_id');
//		$this->db->order_by('admin_name');

		$this->db->from('d_admin');
		$this->db->order_by('admin_username');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;

	}

	/**
	 * Get admin fields which started of specific alphabet.
	 * @param char $first_alphabet First alphabet of admin name
	 * @return resource|false Query of admin table data which started of specific alphabet
	 */
	function admins_select_all_alphabet($first_alphabet) {
//		$this->db->from('d_admin')
//			->order_by('admin_name');

//		$this->db->from('d_admin, d_perm_group');
//		$this->db->where('group_id = perm_grups_id');
//		$this->db->like('admin_name', $first, 'after');
//		$this->db->order_by('admin_name');

		$this->db->from('d_admin');
		$this->db->like('admin_name', $first_alphabet, 'after');
		$this->db->order_by('admin_name');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;

	}

	/**
	 * Get how many admin rows.
	 * @return integer|false Number of rows of admin table data
	 */
	function admins_count_all() {
//		$this->db->from('d_admin')
//			->order_by('admin_name');

//		$this->db->from('d_admin, d_perm_group');
//		$this->db->where('group_id = perm_grups_id');
//		$this->db->order_by('admin_name');

		$this->db->from('d_admin');
		$this->db->order_by('admin_username');

		$query = $this->db->get();

		if($query)
			return $query->num_rows;
		else
			return FALSE;

	}

	/**
	 * Add admin data to admin table.
	 * @param array $data Member data (name, address, etc)
	 * @return integer|false Member ID.
	 */
	function admin_add($data) {
		if($this->db->insert('d_admin', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	/**
	 * Update admin data based on admin_id field.
	 * @param array $data Member data (admin_id, name, address, etc)
	 * @return bool TRUE if success, FALSE if fail
	 */
	function admin_update($data) {
		$this->db->where('admin_id', $data['admin_id']);
		if($this->db->update('d_admin', $data))
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * Delete admin data based on admin_id field.
	 * @param array $admin_id Admin ID
	 * @return bool TRUE if success, FALSE if fail
	 */
	function admin_delete($admin_id) {
		$this->db->where('admin_id', $admin_id);
		if($this->db->delete('d_admin'))
			return TRUE;
		else
			return FALSE;
	}

}

/* End of file m_admin.php */
/* Location: ./system/application/models/m_admin.php */