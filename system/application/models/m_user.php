<?php
/**
 * Admin Model
 * This model class related to admin data
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_user extends Model {

	/**
	 * Admin Model
	 * This model class related to admin data
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_user() {
		parent::Model();
    $this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->load->model('m_constant_fixed');
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

		if(empty($admin_id))
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		$this->db->from('d_admin');
		$this->db->join('m_employee', 'admin_emp_id = employee_id', 'left');
		$this->db->where('admin_id', $admin_id);
//		$this->db->where('group_id = perm_grups_id');
			//->_compile_select();

		$query = $this->db->get();
//		echo $this->db->last_query();

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
	
	function select_plants_all($admin_id) {
		$this->db->select('admin_selectall');
		$this->db->from('d_admin');
		$this->db->where('admin_id', $admin_id);
		
		$query = $this->db->get();
  	    if($query->num_rows() > 0) {
  	        $sel_all = $query->row_array();
			return trim($sel_all['admin_selectall']);
		} else {
			return '';
		}
	}
	
	function select_employee_id($nik) {
		$this->db->select('employee_id');
		$this->db->from('m_employee');
		$this->db->where('nik', $nik);
		
		$query = $this->db->get();
  	    if($query->num_rows() > 0) {
  	        $emp_id = $query->row_array();
			return intval($emp_id['employee_id']);
		} else {
			return 0;
		}
	}
	
	function select_company_code($plant) {
		$this->db->select('COMP_CODE');
		$this->db->from('m_outlet');
		$this->db->where('OUTLET', $plant);
		
		$query = $this->db->get();
  	    if($query->num_rows() > 0) {
  	        $comp_code = $query->row_array();
			return $comp_code['COMP_CODE'];
		} else {
			return '';
		}
	}	
		
	
	function select_plants($plant_type_id,$admin_id,$selected_plants,$plant_terpilih = '',$plant_terpilih_count = 0){
		$office_array = $this->m_constant_fixed->office_plants();
		$tmp_plant_terpilih = '';
		$tmp_plant_terpilih_count = 0;
		unset($query);
		unset($hasil);
		$hasil = Array();
		$allplants = FALSE;
        if (!empty($plant_type_id)) {
			$cek_all = $this->select_plants_all($admin_id);
			$cek_all = explode(',',$cek_all);
			foreach($cek_all as $comp_code=>$value){
				if (trim($value)==$plant_type_id) $allplants = TRUE;
			}
			
			if ($plant_type_id=='OFFICE') {
				$this->db->from('m_outlet');
				$this->db->where_in('OUTLET', $office_array);
				$this->db->order_by("OUTLET", "asc");
				$this->db->not_like('OUTLET', 'T.');
			} else {
				$this->db->from('m_outlet');
				$this->db->where('COMP_CODE', $plant_type_id);
				$this->db->where_not_in('OUTLET', $office_array);
				$this->db->not_like('OUTLET', 'T.');
			}
        } else {
			return FALSE;
			exit;
		}
 
 	    $query = $this->db->get();

  	    if($query->num_rows() > 0) {
  	        $plants = $query->result_array();
            $count = count($plants);
            $k = 1;
            for ($i=0;$i<=$count-1;$i++) {
//              $plant[$k] = $plants[$i];
				$plants[$i]['OUTLET'] = trim($plants[$i]['OUTLET']);
				$plant[$plants[$i]['OUTLET']]['plant_name'] = $plants[$i]['OUTLET_NAME1'];
				if (((trim($plants[$i]['OUTLET_NAME2'])) == (trim($plants[$i]['HR_CODE']))) || (trim($plants[$i]['HR_CODE'])=='')) {
					$plant[$plants[$i]['OUTLET']]['plant_code'] = $plants[$i]['OUTLET_NAME2'];
				} else {
					if ($plant_type_id!='OFFICE')
						$plant[$plants[$i]['OUTLET']]['plant_code'] = $plants[$i]['OUTLET_NAME2']. ' / '.$plants[$i]['HR_CODE'];
					else
						$plant[$plants[$i]['OUTLET']]['plant_code'] = $plants[$i]['OUTLET_NAME2'];
				}
				$plant[$plants[$i]['OUTLET']]['plant_city'] = $plants[$i]['CITY'];
				
				if (($allplants) || (strpos('#'.$selected_plants,$plants[$i]['OUTLET'])>0)) {
					$plant[$plants[$i]['OUTLET']]['is_selected'] = TRUE;
					$tmp_plant_terpilih_count++;
					$tmp_plant_terpilih .= $plant[$plants[$i]['OUTLET']]['plant_code'].', ';
				} else {
					$plant[$plants[$i]['OUTLET']]['is_selected'] = FALSE;
				}
              $k++;
            }
			if ($tmp_plant_terpilih!='') {
				if ($allplants) 
					$tmp_plant_terpilih = '<span style="color:#187835;"><b>'.$plant_type_id.' *</b> (ALL '.$tmp_plant_terpilih_count.' plant)</span><hr />';
				else {
					if ($tmp_plant_terpilih_count>20){
						$tmp_plant_terpilih = '<span style="color:#575757;"><b>'.$plant_type_id.'</b> ('.$tmp_plant_terpilih_count.' plant)</span><hr />';
					} else {
						$tmp_plant_terpilih = '<b>'.$plant_type_id.'</b> ('.$tmp_plant_terpilih_count.' plant): '.$tmp_plant_terpilih.'<hr />';
					}
				}
			}
			$hasil['allplant'] = $allplants;
			$hasil['plant'] = $plant;
			$hasil['plant_terpilih'] = $plant_terpilih.$tmp_plant_terpilih;
			$hasil['plant_terpilih_count'] = $plant_terpilih_count + $tmp_plant_terpilih_count;
			
            return $hasil;
         } else {
            return FALSE;
         }
	}	

}

/* End of file m_user.php */
/* Location: ./system/application/models/m_user.php */