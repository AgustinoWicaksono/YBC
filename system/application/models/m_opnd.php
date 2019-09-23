<?php
class M_opnd extends Model {

	function M_opnd() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function opnd_headers_select_all() {
		$this->db->from('m_opnd_header');
		$this->db->order_by('id_opnd_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a opnd header.
	 * @return integer|false Count of result from a opnd header.
	 */
	function opnd_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_opnd_header');

    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'periode';
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
					$field_sort_name = 'periode';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'periode';
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

	function opnd_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_opnd_header');

		// start of searching
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'periode';
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
					$field_sort_name = 'periode';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'periode';
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

	function opnd_header_delete($id_opnd_header) {

		if($this->opnd_details_delete($id_opnd_header)) {
			$this->db->where('id_opnd_header', $id_opnd_header);
			if($this->db->delete('m_opnd_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function opnd_header_delete_multiple($id_opnd_header) {
		$this->db->where_in('id_opnd_header',$id_opnd_header);
		if ($this->db->delete('m_opnd_detail_temp')){
		$this->db->where_in('id_opnd_header', $id_opnd_header);
		if($this->db->delete('m_opnd_detail')) {
			$this->db->where_in('id_opnd_header', $id_opnd_header);
			if($this->db->delete('m_opnd_header'))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
			}else
			return FALSE;
	}

	// end of browse

	// start of input

	function opnd_header_insert($data) {
		if($this->db->insert('m_opnd_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function opnd_header_update($data) {
		$this->db->where('id_opnd_header', $data['id_opnd_header']);
		if($this->db->update('m_opnd_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function opnd_detail_insert($data) {
		if($this->db->insert('m_opnd_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}
	
	function opnd_detail_insert_temp($data) {
		if($this->db->insert('m_opnd_detail_temp', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function opnd_header_select($id_opnd_header) {
		$this->db->from('m_opnd_header');
		$this->db->where('id_opnd_header', $id_opnd_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function opnd_header_select_by_periode($periode,$plant) {
		$this->db->from('m_opnd_header');
		$this->db->where('periode', $periode);
		$this->db->where('plant', $plant);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$opnd_headers = $query->result_array();
			foreach ($opnd_headers as $opnd_header) {
              $id_opnd_header[] = $opnd_header['id_opnd_header'];
			}
            return $id_opnd_header;
		} else
			return FALSE;
	}

	function opnd_details_select($id_opnd_header) {
		$this->db->from('m_opnd_detail');
		$this->db->where('id_opnd_header', $id_opnd_header);
		$this->db->order_by('id_opnd_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function opnd_details_select_by_kode_item($periode,$material_no) {
        $plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->from('m_opnd_detail');
  		$this->db->join('m_opnd_header','m_opnd_header.id_opnd_header = m_opnd_detail.id_opnd_header','inner');
		$this->db->where('periode', $periode);
		$this->db->where('plant', $plant);
		$this->db->where('material_no', $material_no);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function opnd_detail_update($data) {
		$this->db->where('id_opnd_detail', $data['id_opnd_detail']);
		if($this->db->update('m_opnd_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function opnd_details_delete($id_opnd_header) {
		$this->db->where('id_opnd_header', $id_opnd_header);
		if($this->db->delete('m_opnd_detail'))
			return TRUE;
		else
			return FALSE;
	}
	
	function opnd_details_temp_delete($id_opnd_header) {
		$this->db->where('id_opnd_header', $id_opnd_header);
		if($this->db->delete('m_opnd_detail_temp'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
