<?php
class M_menu extends Model {

	function M_menu() {
		parent::Model();
		$this->obj =& get_instance();
	}

	function get_menu_list() {

		$results = array();

		$this->db->select('pages_id, name, file_name, icon, file_code, member_only, menu_order, menu_parent');
		$this->db->from('r_pages');
		$this->db->where('page_lang_id', $this->session->userdata('lang_id'));
		$this->db->where('menu_order !=', '0');
		$this->db->_compile_select();

//		echo $command;
		$query = $this->db->get();
/*
		$command = "SELECT pages_id, name, file_name, icon, file_code, member_only, menu_order FROM milis_pages WHERE page_lang_id = '".$this->session->userdata('lang_id')."' AND menu_order != '0' ORDER BY menu_order";
		$query = $this->db->query($command);
*/
		if ($query->num_rows() > 0) {
			$i = 1;
			foreach ($query->result_array() as $row) {
			
				if(!empty($row['file_name']))
					$row['link'] = site_url($row['file_name']);
				$results[$i] = $row;
				$i++;
			}
		}

		return $results;
	}

}

/* End of file m_menu.php */
/* Location: ./system/application/models/m_menu.php */