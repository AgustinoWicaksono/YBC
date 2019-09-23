<?php
/**
 * Page Model
 * This model related to page properties
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_page extends Model {

	/**
	 * Page Model
	 * This model  related page properties
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_page() {
		parent::Model();
		$this->obj =& get_instance();
	}

	/**
	 * Get page properties
	 * @param string $controller Controller name
	 * @param string $function Function name
	 * @return array|false Page properties.
	 */
	function page_select($controller = '', $function = '') {
		$controller = (string) $controller;
		$function = (string) $function;
		
		$this->db->from('r_page');
		$this->db->where('page_controller', $controller);
		$this->db->where('page_function', $function);

		$query = $this->db->get();
		
		if(($query)&&($query->num_rows() > 0)) {
			return $query->row_array();
		} else
			return FALSE;
	}
	
}

/* End of file m_page.php */
/* Location: ./system/application/models/m_page.php */