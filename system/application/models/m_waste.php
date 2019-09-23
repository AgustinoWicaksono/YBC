<?php
class M_waste extends Model {

	function M_waste() {
		parent::Model();
	}

	// start of browse

	function waste_headers_select_all() {
		$this->db->from('t_waste_header');
		$this->db->order_by('id_waste_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a waste header.
	 * @return integer|false Count of result from a waste header.
	 */
	function waste_select_to_export($id_waste_header) {
//print_r($id_waste_header);die();
		$this->db->from('v_waste_export');
		$this->db->where_in('id_waste_header', $id_waste_header);

		$query = $this->db->get();
//echo $this->db-last_query();die();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function waste_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_waste_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'material_doc_no';
					break;
				}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from2'");
			}
		}

		if(!empty($status))
			$this->db->where('status', $status);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'status';
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

	function waste_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_waste_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'material_doc_no';
					break;
				}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from2'");
			}
		}

		if(!empty($status))
			$this->db->where('status', $status);
		if(!empty($back))
			$this->db->where('back', $back);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'back';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'back';
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

	function waste_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_waste_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'material_doc_no';
					break;
				
			}


			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}
		
		$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from2'");
			}
		}

		if(!empty($status))
			$this->db->where('status', $status);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_waste_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'material_doc_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'status';
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

	function waste_header_delete($id_waste_header) {

		if($this->waste_details_delete($id_waste_header)) {

			$this->db->where('id_waste_header', $id_waste_header);

			if($this->db->delete('t_waste_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function id_waste_plant_new_select($id_outlet,$posting_date="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();

		$this->db->select_max('id_waste_plant');
		$this->db->from('t_waste_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$waste = $query->row_array();
			$id_waste_outlet = $waste['id_waste_plant'] + 1;
		}	else {
			$id_waste_outlet = 1;
		}

		return $id_waste_outlet;
	}

	function waste_header_insert($data) {
		if($this->db->insert('t_waste_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}
	
	function user_delete($waste_delete) {
		if($this->db->insert('t_delete', $waste_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function waste_header_update($data) {
		$this->db->where('id_waste_header', $data['id_waste_header']);
		if($this->db->update('t_waste_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function waste_detail_insert($data) {
		if($this->db->insert('t_waste_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function waste_detail_bom_insert($data) {
		if($this->db->insert('t_waste_detail_bom', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function waste_reason_select_all() {
		$this->db->select('reason_name');
		$this->db->from('m_waste_reason');
		$this->db->order_by('reason_id');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
	}

	function waste_header_select($id_waste_header) {
		$this->db->from('t_waste_header');
		$this->db->where('id_waste_header', $id_waste_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function waste_header_select_id_by_posting_date($posting_date) {

        $posting_date = date('Y-m-d',strtotime($posting_date));

		$this->db->from('t_waste_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
            $waste =  $query->row_array();
            $id_waste_outlet = $waste['id_waste_header'];
			return $id_waste_outlet;
		} else {
			return FALSE;
        }
	}

	function waste_detail_select_reason_by_id_waste_detail($id_waste_detail) {

		$this->db->select('concat(reason_name,coalesce(other_reason,space(0))) as reason ');
		$this->db->from('t_waste_detail');
		$this->db->where('id_waste_detail', $id_waste_detail);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
        }
	}

	function waste_detail_select_reason_by_material_no($id_waste_header,$material_no) {

		$this->db->select('concat(reason_name,coalesce(other_reason,space(0))) as reason ');
		$this->db->from('t_waste_detail');
		$this->db->where('id_waste_header', $id_waste_header);
		$this->db->where('material_no', $material_no);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
        }
	}

	function waste_header_select_id_by_date_status_approve($posting_date) {

        $posting_date = date('Y-m-d',strtotime($posting_date));

		$this->db->from('t_waste_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('status', 2);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function waste_details_select($id_waste_header) {
		$this->db->from('t_waste_detail');
		$this->db->where('id_waste_header', $id_waste_header);
		$this->db->order_by('id_waste_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function waste_details_select_wo_sfg($id_waste_header) {
		$this->db->from('t_waste_detail');
		$this->db->where('id_waste_header', $id_waste_header);
		$this->db->where('material_no NOT IN
                         (SELECT material_no_sfg FROM t_waste_detail_bom
                          WHERE t_waste_detail.material_no = t_waste_detail_bom.material_no_sfg
                          AND id_waste_header = '.$id_waste_header.')
                         ');
		$this->db->order_by('material_no');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function waste_detail_bom_select($id_waste_header) {
		$this->db->from('t_waste_detail_bom');
		$this->db->where('id_waste_header', $id_waste_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function waste_detail_bom_selectdata($id_waste_header) {
		$this->db->select('material_no,uom');
		$this->db->select_sum('quantity');
		$this->db->from('v_waste_bom');
		$this->db->where('id_waste_header', $id_waste_header);
		$this->db->group_by('material_no,uom');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function waste_detail_bom_select_by_id_waste_detail($id_waste_detail) {
		$this->db->from('t_waste_detail_bom');
		$this->db->where('id_waste_detail', $id_waste_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function waste_detail_update($data) {
		$this->db->where('id_waste_detail', $data['id_waste_detail']);
		if($this->db->update('t_waste_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function waste_details_delete($id_waste_header) {
	    if($this->waste_detail_bom_delete($id_waste_header)) {
    		$this->db->where('id_waste_header', $id_waste_header);
    		if($this->db->delete('t_waste_detail'))
    			return TRUE;
    		else
    			return FALSE;
        }
	}
	
	function batch_delete($id_waste_header) {
	   // if($this->waste_detail_bom_delete($id_waste_header)) {
    		$this->db->where('BaseEntry', $id_waste_header);
			$this->db->where('BaseType',2);
    		if($this->db->delete('t_batch'))
    			return TRUE;
    		else
    			return FALSE;
       // }
	}

	function waste_detail_bom_delete($id_waste_header) {
	    if ($this->waste_detail_bom_select($id_waste_header)) {
    	   $this->db->where('id_waste_header', $id_waste_header);
    	   if($this->db->delete('t_waste_detail_bom'))
    	      return TRUE;
    	   else
    	      return FALSE;
        } else
			return TRUE;
	}
	
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}
	
	function batch_update($data) {
		$this->db->where('BaseEntry', $data['BaseEntry']);
		$this->db->where('ItemCode', $data['ItemCode']);
		$this->db->where('BatchNum', $data['BatchNum']);
		$this->db->where('BaseLinNum', $data['BaseLinNum']);
		if($this->db->update('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}


	function waste_detail_bom_delete_by_id_waste_detail($id_waste_detail) {
		$this->db->where('id_waste_detail', $id_waste_detail);

		if($this->db->delete('t_waste_detail_bom'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
