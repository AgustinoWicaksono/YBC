<?php
class M_mwts extends Model {

	function M_mwts() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function mwts_headers_select_all() {
		$this->db->from('m_mwts_header');
		$this->db->order_by('id_mwts_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a mwts header.
	 * @return integer|false Count of result from a mwts header.
	 */
	function mwts_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_mwts_header');

    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_whi';
					break;
				case 'b':
					$field_name_ori = 'nama_whi';
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
					$field_sort_name = 'kode_whi';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_whi';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_whi';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_whi';
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

	function mwts_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_mwts_header');

		// start of searching
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_whi';
					break;
				case 'b':
					$field_name_ori = 'nama_whi';
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
					$field_sort_name = 'kode_whi';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_whi';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_whi';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_whi';
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

	function mwts_header_delete($id_mwts_header) {

		if($this->mwts_details_delete($id_mwts_header)) {
			$this->db->where('id_mwts_header', $id_mwts_header);
			if($this->db->delete('m_mwts_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function mwts_header_delete_multiple($id_mwts_header) {
		$this->db->where_in('id_mwts_header', $id_mwts_header);
		if($this->db->delete('m_mwts_detail')) {
			$this->db->where_in('id_mwts_header', $id_mwts_header);
			if($this->db->delete('m_mwts_header'))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	}

	// end of browse

	// start of input

	function mwts_header_insert($data) {
		if($this->db->insert('m_mwts_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function mwts_header_update($data) {
		$this->db->where('id_mwts_header', $data['id_mwts_header']);
		if($this->db->update('m_mwts_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function mwts_detail_insert($data) {
		if($this->db->insert('m_mwts_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function mwts_header_select($id_mwts_header) {
		$this->db->from('m_mwts_header');
		$this->db->where('id_mwts_header', $id_mwts_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function mwts_header_select_by_kode_whi($kode_whi,$plant) {
		$this->db->from('m_mwts_header');
		$this->db->where('kode_whi', $kode_whi);
    	$this->db->where('plant', $plant);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$mwts_headers = $query->result_array();
			foreach ($mwts_headers as $mwts_header) {
              $id_mwts_header[] = $mwts_header['id_mwts_header'];
			}
            return $id_mwts_header;
		} else
			return FALSE;
	}

	function mwts_details_select($id_mwts_header) {
		$this->db->from('m_mwts_detail');
		$this->db->where('id_mwts_header', $id_mwts_header);
		$this->db->order_by('id_mwts_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function mwts_details_select_by_item_whi($kode_whi) {
        $this->db->select('m_mwts_detail.*, m_mwts_header.quantity_whi');
		$this->db->from('m_mwts_detail');
		$this->db->join('m_mwts_header','m_mwts_header.id_mwts_header = m_mwts_detail.id_mwts_header','inner');
		$this->db->where('kode_whi', $kode_whi);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->order_by('id_mwts_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function mwts_detail_update($data) {
		$this->db->where('id_mwts_detail', $data['id_mwts_detail']);
		if($this->db->update('m_mwts_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function mwts_details_delete($id_mwts_header) {
		$this->db->where('id_mwts_header', $id_mwts_header);
		if($this->db->delete('m_mwts_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
