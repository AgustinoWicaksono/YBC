<?php
class M_twtsnew extends Model {

	function M_twtsnew() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	
	public function __construct()
 	{
  		parent::__construct();
		
		$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$dba=$db_sap[0]['name'];
        $this->db2 = $this->load->database($dba, TRUE);
	}
	
	function twtsnew_headers_select_all() {
		$this->db->from('m_twtsnew_header');
		$this->db->order_by('id_twtsnew_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a twtsnew header.
	 * @return integer|false Count of result from a twtsnew header.
	 */
	function twtsnew_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_twtsnew_header');

    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_paket';
					break;
				case 'b':
					$field_name_ori = 'gr_no';
					break;
				case 'c':
					$field_name_ori = 'gi_no';
					break;
				}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}
		
		if(!empty($status))
			$this->db->where('status', $status);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
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
				case 'cy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'id_twtsnew_header';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'id_twtsnew_header';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'last_update';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'last_update';
					$field_sort_type = 'desc';
					break;
			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		$query = $this->db->get();
//echo $this->db->last_query();

		if(($query)&&($query->num_rows() > 0)) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function twtsnew_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_twtsnew_header');

		// start of searching
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		//echo $this->session->userdata['ADMIN']['plant'];

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'kode_paket';
					break;
				case 'b':
					$field_name_ori = 'gr_no';
					break;
				case 'c':
					$field_name_ori = 'gi_no';
					break;

			}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}
		
		if(!empty($status))
			$this->db->where('status', $status);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		
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
				case 'cy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'id_twtsnew_header';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'id_twtsnew_header';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'last_update';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'last_update';
					$field_sort_type = 'desc';
					break;
    		}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		$this->db->limit($limit, $start);

		$query = $this->db->get();

//echo $this->db->last_query();
		if(($query)&&($query->num_rows() > 0)) {
			return $query;
		} else {
			return FALSE;
		}

	}
	
	function twtsnew_is_data_cancelled($id_twtsnew_header) {
		$this->db->from('t_twtsnew_detail');
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return TRUE;
		else
			return FALSE;
	}

	
	function posto_lastupdate() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('postoout_lastupdate');
	  	$this->db->from('t_statusgetdataposto');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
 	  	if (($query)&&($query->num_rows() > 0)) {
			$status = $query->row_array();
			$last_posto_update = $status["postoout_lastupdate"];
		}
      if (empty($last_posto_update))
        return "Data tidak ditemukan.";
      else {
        return "Data per <b>".date("d M Y - H:i:s")." WIB</b> (REALTIME DATA)";
//        return "Data per <b>".date("d M Y - H:i:s",strtotime($last_posto_update))." WIB</b>";
      }
    }
	
	function is_posto_ref_btn_can_show() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('postoout_lastupdate');
	  	$this->db->from('t_statusgetdataposto');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
		if (($query)&&($query->num_rows() > 0)) {
			$status = $query->row_array();
			$last_posto_update = $status["postoout_lastupdate"];
		}
      if (empty($last_posto_update))
        return TRUE;
      else {
        if ($this->l_general->dateDiff(date("Y-m-d H:i:s"),$last_posto_update) >= 2)
            return TRUE;
        else
            return FALSE;
      }
    }   
	
	function user_delete($twtsnew_delete) {
		if($this->db->insert('t_delete', $twtsnew_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function twtsnew_header_delete($id_twtsnew_header) {

		if($this->twtsnew_details_delete($id_twtsnew_header)) {
			//echo "ABCD";
			$this->db->where('id_twtsnew_header', $id_twtsnew_header);
			
			if($this->db->delete('m_twtsnew_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function twtsnew_header_delete_multiple($id_twtsnew_header) {
		$this->db->where_in('id_twtsnew_header', $id_twtsnew_header);
		if($this->db->delete('m_twtsnew_detail')) {
			$this->db->where_in('id_twtsnew_header', $id_twtsnew_header);
			if($this->db->delete('m_twtsnew_header'))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	}

	// end of browse

	// start of input

	function twtsnew_header_insert($data) {
		if($this->db->insert('m_twtsnew_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function twtsnew_header_update($data) {
		$this->db->where('id_twtsnew_header', $data['id_twtsnew_header']);
		if($this->db->update('m_twtsnew_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function twtsnew_detail_insert($data) {
		if($this->db->insert('m_twtsnew_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function twtsnew_header_select($id_twtsnew_header) {
		$this->db->from('m_twtsnew_header');
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function twtsnew_header_select_by_kode_paket($kode_paket,$plant) {
		$this->db->select('id_twtsnew_header');
		$this->db->from('m_twtsnew_header');
		$this->db->where('kode_paket', $kode_paket);
    	$this->db->where('plant', $plant);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$twtsnew_headers = $query->result_array();
			foreach ($twtsnew_headers as $twtsnew_header) {
              $id_twtsnew_header[] = $twtsnew_header['id_twtsnew_header'];
			}
            return $id_twtsnew_header;
		} else
			return FALSE;
	}

	function twtsnew_details_select($id_twtsnew_header) {
		$this->db->from('m_twtsnew_detail');
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);
		$this->db->order_by('id_twtsnew_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function twtsnew_details_select_by_item_paket($kode_paket) {
        $this->db->select('m_twtsnew_detail.*, m_twtsnew_header.quantity_paket');
		$this->db->from('m_twtsnew_detail');
		$this->db->join('m_twtsnew_header','m_twtsnew_header.id_twtsnew_header = m_twtsnew_detail.id_twtsnew_header','inner');
		$this->db->where('kode_paket', $kode_paket);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		$this->db->order_by('id_twtsnew_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function twtsnew_detail_update($data) {
		$this->db->where('id_twtsnew_detail', $data['id_twtsnew_detail']);
		if($this->db->update('m_twtsnew_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function twtsnew_details_delete($id_twtsnew_header) {
		//echo 'abcd'.$id_twtsnew_header;
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);
		if($this->db->delete('m_twtsnew_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
