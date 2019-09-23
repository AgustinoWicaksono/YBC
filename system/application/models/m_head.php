<?php
/**
 * Head Model
 * This model related to script and css on <head> tag
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_head extends Model {

	/**
	 * Head Model
	 * This model related to script and css on <head> tag
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_head() {
		parent::Model();
		$this->obj =& get_instance();
	}

	/**
	 * Get head properties
	 * @param string $controller Controller name
	 * @param string $function Function name
	 * @return resource|false Script / CSS data.
	 */
	function heads_select($controller = '', $function = '') {
		$controller = (string) $controller;
		$function = (string) $function;
		
		$this->db->from('r_head');
		$this->db->join('r_head_script', 'head_scrpt_id = script_id');
		$this->db->where('head_controller', $controller);
		$this->db->where('head_function', $function);

		$query = $this->db->get();
		
		if(($query)&&($query->num_rows() > 0))// ($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
}

/* End of file m_head.php */
/* Location: ./system/application/models/m_head.php */