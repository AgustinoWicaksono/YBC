<?php
/**
 * Config Model
 * This model class related to configuration of this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_config extends Model {

	/**
	 * Config Model
	 * This model class related to configuration of this website
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_config() {
		parent::Model();
		$this->obj =& get_instance();
	}

	
	/**
	 * Get last running number data of a section (grpo, etc).
	 * @param string $field Name of field
	 * @return integer Running number
	 */
	function running_number_select($module_name, $id_outlet, $last_date) {

		$this->db->from('d_running_number');
		$this->db->where('module_name', $module_name);
		$this->db->where('id_outlet', $id_outlet);
		$this->db->where('last_date', $last_date);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			$return = $query->row_array();
			return $return['running_number'];
		} else {
			return FALSE;
		}
	}

	function running_number_select_update($module_name, $id_outlet, $last_date) {

		// check last_date
		$this->db->from('d_running_number');
		$this->db->where('module_name', $module_name);
		$this->db->where('id_outlet', $id_outlet);
		$this->db->where('last_date', $last_date);

		$query = $this->db->get();

		// if running number of this day exist, return the value
		// if not, check id outlet
		if(($query)&&($query->num_rows() > 0)) {
		
			$return = $query->row_array();
			return $return['running_number'];

		} else {
		
			// check id_outlet
			$this->db->from('d_running_number');
			$this->db->where('module_name', $module_name);
			$this->db->where('id_outlet', $id_outlet);
	
			$query = $this->db->get();
	
			// if running number of id_outlet exist, return the value
			// if not, check module_name
			if(($query)&&($query->num_rows() > 0)) {

				$data = array(
					'module_name'	=>	$module_name,
					'id_outlet'	=>	$id_outlet,
					'last_date'	=>	$last_date,
					'running_number'	=>	$running_number,
				);
	
				$this->db->insert('t_grpo_detail', $data);
				return $this->db->insert_id();
	
	
	
		
			
				$this->db->where('module_name', $module_name);
				$this->db->where('id_outlet', $id_outlet);
				$this->db->where('last_date', $last_date);
		
				if($this->db->update('d_running_number', $data))
					return TRUE;
				else
					return FALSE;
	
	
				$return = $query->row_array();
				return $return['last_number'];
			}
		}
		
	}

	/**
	 * Get all of configurations.
	 * @return resource All of configurations
	 */
	function configs_select_all() {
		$this->db->from('r_config_category');
		$this->db->join('r_config', 'cat_id = category_id');
		$this->db->order_by('category_order');
		$this->db->order_by('config_order');

		$query = $this->db->get();
		
		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}
	
	/**
	 * Update a content.
	 * @param array $data Configuration data
	 * @return void
	 */
	function config_update($data) {
		$this->db->where('config_name', $data['config_name']);
		$this->db->update('r_config', $data);
	}

	/**
	 * Get a content/value of a configuration.
	 * @param string $config_name Name of configuration
	 * @return string A configuration content/value
	 */
	function content_select($config_name) {
		$this->db->select('content');
		$this->db->from('r_config');
		$this->db->where('config_name', $config_name);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			$return = $query->row_array();
			return $return['content'];
		} else {
			return FALSE;
		}
	}

	/**
	 * Get system web module
	 * @param string $field Name of field
	 * @return Array web module data
	 */
	function system_web_module($module_id) {

		$this->db->from('r_system_module');
		$this->db->where('module_id', intval($module_id));

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			$return = $query->row_array();
			return $return;
		} else {
			return FALSE;
		}
	}	
}

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */