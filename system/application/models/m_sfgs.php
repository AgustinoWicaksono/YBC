<?php
class M_sfgs extends Model {

	function M_sfgs() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function sfgs_headers_select_all() {
		$this->db->from('m_sfgs_header');
		$this->db->order_by('id_sfgs_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a sfgs header.
	 * @return integer|false Count of result from a sfgs header.
	 */
	function sfgs_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_sfgs_header');

    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_sfg';
					break;
				case 'b':
					$field_name_ori = 'nama_sfg';
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
					$field_sort_name = 'kode_sfg';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_sfg';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_sfg';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_sfg';
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

	function sfgs_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_sfgs_header');

		// start of searching
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_sfg';
					break;
				case 'b':
					$field_name_ori = 'nama_sfg';
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
					$field_sort_name = 'kode_sfg';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_sfg';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_sfg';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_sfg';
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

	function sfgs_header_delete($id_sfgs_header) {

		if($this->sfgs_details_delete($id_sfgs_header)) {
			$this->db->where('id_sfgs_header', $id_sfgs_header);
			if($this->db->delete('m_sfgs_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function sfgs_header_delete_multiple($id_sfgs_header) {
		$this->db->where_in('id_sfgs_header', $id_sfgs_header);
		if($this->db->delete('m_sfgs_detail')) {
			$this->db->where_in('id_sfgs_header', $id_sfgs_header);
			if($this->db->delete('m_sfgs_header'))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	}

	// end of browse

	// start of input

	function sfgs_header_insert($data) {
		if($this->db->insert('m_sfgs_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sfgs_header_update($data) {
		$this->db->where('id_sfgs_header', $data['id_sfgs_header']);
		if($this->db->update('m_sfgs_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function sfgs_detail_insert($data) {
		if($this->db->insert('m_sfgs_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function sfgs_header_select($id_sfgs_header) {
		$this->db->from('m_sfgs_header');
		$this->db->where('id_sfgs_header', $id_sfgs_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function sfgs_header_select_by_kode_sfg($kode_sfg,$plant) {
		$this->db->select('id_sfgs_header');
		$this->db->from('m_sfgs_header');
		$this->db->where('kode_sfg', $kode_sfg);
    	$this->db->where('plant', $plant);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$sfgs_headers = $query->result_array();
			foreach ($sfgs_headers as $sfgs_header) {
              $id_sfgs_header[] = $sfgs_header['id_sfgs_header'];
			}
            return $id_sfgs_header;
		} else
			return FALSE;
	}

	function sfgs_details_select($id_sfgs_header) {
		$this->db->from('m_sfgs_detail');
		$this->db->where('id_sfgs_header', $id_sfgs_header);
		$this->db->order_by('id_sfgs_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function sfgs_details_select_by_item_sfg($kode_sfg) {
        $this->db->select('m_sfgs_detail.*, m_sfgs_header.quantity_sfg');
		$this->db->from('m_sfgs_detail');
		$this->db->join('m_sfgs_header','m_sfgs_header.id_sfgs_header = m_sfgs_detail.id_sfgs_header','inner');
		$this->db->where('kode_sfg', $kode_sfg);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->order_by('id_sfgs_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function sfgs_detail_update($data) {
		$this->db->where('id_sfgs_detail', $data['id_sfgs_detail']);
		if($this->db->update('m_sfgs_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function sfgs_details_delete($id_sfgs_header) {
		$this->db->where('id_sfgs_header', $id_sfgs_header);
		if($this->db->delete('m_sfgs_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
