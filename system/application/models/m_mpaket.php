<?php
class M_mpaket extends Model {

	function M_mpaket() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function mpaket_t_headers_select_all() {
		$this->db->from('m_mpaket_t_header');
		$this->db->order_by('id_mpaket_t_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a mpaket_t header.
	 * @return integer|false Count of result from a mpaket_t header.
	 */
	function mpaket_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_mpaket_header');

    	//$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->where('plant', 'WMSIASST');
		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_paket';
					break;
				case 'b':
					$field_name_ori = 'nama_paket';
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
					$field_sort_name = 'kode_paket';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_paket';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_paket';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_paket';
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

	function mpaket_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_mpaket_header');

		// start of searching
    	//$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->where('plant', 'WMSIASST');

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_paket';
					break;
				case 'b':
					$field_name_ori = 'nama_paket';
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
					$field_sort_name = 'kode_paket';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'kode_paket';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama_paket';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama_paket';
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

	function mpaket_header_delete($id_mpaket_t_header) {

		if($this->mpaket_t_details_delete($id_mpaket_t_header)) {
			$this->db->where('id_mpaket_header', $id_mpaket_t_header);
			if($this->db->delete('m_mpaket_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function mpaket_header_delete_multiple($id_mpaket_t_header) {
		$this->db->where_in('id_mpaket_header', $id_mpaket_t_header);
		if($this->db->delete('m_mpaket_detail')) {
			$this->db->where_in('id_mpaket_header', $id_mpaket_t_header);
			if($this->db->delete('m_mpaket_header'))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	}

	// end of browse

	// start of input

	function mpaket_header_insert($data) {
		if($this->db->insert('m_mpaket_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function mpaket_header_update($data) {
		$this->db->where('id_mpaket_header', $data['id_mpaket_header']);
		if($this->db->update('m_mpaket_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function mpaket_detail_insert($data) {
		if($this->db->insert('m_mpaket_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function mpaket_header_select($id_mpaket_t_header) {
		$this->db->from('m_mpaket_header');
		$this->db->where('id_mpaket_header', $id_mpaket_t_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function mpaket_header_select_by_kode_paket($kode_paket,$plant) {
		$this->db->select('id_mpaket_header');
		$this->db->from('m_mpaket_header');
		$this->db->where('kode_paket', $kode_paket);
    	$this->db->where('plant', $plant);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$mpaket_t_headers = $query->result_array();
			foreach ($mpaket_t_headers as $mpaket_t_header) {
              $id_mpaket_t_header[] = $mpaket_t_header['id_mpaket_header'];
			}
            return $id_mpaket_t_header;
		} else
			return FALSE;
	}

	function mpaket_details_select($id_mpaket_t_header) {
		$this->db->from('m_mpaket_detail');
		$this->db->where('id_mpaket_header', $id_mpaket_t_header);
		$this->db->order_by('id_mpaket_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function mpaket_details_select_by_item_paket($kode_paket) {
        $this->db->select('m_mpaket_detail.*, m_mpaket_header.quantity_paket');
		$this->db->from('m_mpaket_detail');
		$this->db->join('m_mpaket_header','m_mpaket_header.id_mpaket_header = m_mpaket_detail.id_mpaket_header','inner');
		$this->db->where('kode_paket', $kode_paket);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->order_by('id_mpaket_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function mpaket_detail_update($data) {
		$this->db->where('id_mpaket_detail', $data['id_mpaket_detail']);
		if($this->db->update('m_mpaket_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function mpaket_details_delete($id_mpaket_t_header) {
		$this->db->where('id_mpaket_header', $id_mpaket_t_header);
		if($this->db->delete('m_mpaket_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
