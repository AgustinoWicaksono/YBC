<?php
class M_posisi extends Model {
		
	function M_posisi() {
		parent::Model();  
	}

	function posisis_select_all() {
		 $kd_plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->from('error_log');
		$this->db->where('Whs',$kd_plant);
		$this->db->order_by('id_error');
		$this->db->limit(20,0);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}
	
	function posisi_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('error_log');

		// start of searching

	/*	if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'posisi_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'kd_vendor';
					break;
				case 'd':
					$field_name_ori = 'nm_vendor';
					break;
			}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}*/

	/*$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from2'");
			}
		}*/


		/*if(!empty($status))
			$this->db->where('status', $status);*/

    	$this->db->where('Whs', $this->session->userdata['ADMIN']['plant']);
		// end of searching

		// start of sorting
	/*	if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'id_posisi_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_posisi_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'posisi_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'posisi_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
			case 'ey':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;	
					case 'fy':
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'desc';
					break;	
			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}*/
		// end of sorting

		$query = $this->db->get();
//echo $this->db->last_query();

		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function posisi_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		$this->db->from('error_log');
		
    	$this->db->where('Whs', $this->session->userdata['ADMIN']['plant']);
		$this->db->order_by('id_error','DESC');
		
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		
		echo $query;

//echo $this->db->last_query();
		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}
	
	function posisis_select_all_count() {
		$this->db->from('error_log');
		$this->db->where('Whs',$kd_plant);
		$this->db->order_by('id_error');

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query->num_rows();
		else
			return FALSE;
	}

	function posisi_select($id) {
		$this->db->from('t_posisi');
		$this->db->order_by('id_posisi');
		$this->db->where('id_posisi', $id);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query->row_array();
		else
			return FALSE;
	}

	function posisi_add($data) {
		if($this->db->insert('t_posisi', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function posisi_update($data) {
		$this->db->where('id_posisi', $data['id_posisi']);
		if($this->db->update('t_posisi', $data))
			return TRUE;
		else
			return FALSE;
	}

}
