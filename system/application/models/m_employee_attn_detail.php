<?php
class M_employee_attn_detail extends Model {

	function M_stdstock() {
		parent::Model();
	}

	// start of browse

	function stdstock_headers_select_all() {
		$this->db->from('t_stdstock_header');
		$this->db->order_by('id_stdstock_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a stdstock header.
	 * @return integer|false Count of result from a stdstock header.
	 */
	function stdstock_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_stdstock_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'gr':
					$field_name_ori = 'stdstock_no';
					break;
				case 'po':
					$field_name_ori = 'po_no';
					break;
				case 'vc':
					$field_name_ori = 'kd_vendor';
					break;
				case 'vn':
					$field_name_ori = 'nm_vendor';
					break;
			}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from' AND '$date_to'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from'");
			}
		}

		if(!empty($status))
			$this->db->where('status', $status);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'iy':
					$field_sort_name = 'id_stdstock_header';
					$field_sort_type = 'asc';
					break;
				case 'iz':
					$field_sort_name = 'id_stdstock_header';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'stdstock_no';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'stdstock_no';
					$field_sort_type = 'desc';
					break;
				case 'py':
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'pz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'vy':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'asc';
					break;
				case 'vz':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'desc';
					break;
				case 'ny':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'asc';
					break;
				case 'nz':
					$field_sort_name = 'nm_vendor';
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

	function stdstock_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_stdstock_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'gr':
					$field_name_ori = 'stdstock_no';
					break;
				case 'po':
					$field_name_ori = 'po_no';
					break;
				case 'vc':
					$field_name_ori = 'kd_vendor';
					break;
				case 'vn':
					$field_name_ori = 'nm_vendor';
					break;
			}


			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) && (!empty($date_to)) ) {
				$this->db->where("posting_date BETWEEN '$date_from' AND '$date_to'");
			} else if( (!empty($date_from))) {
				$this->db->where("posting_date >= '$date_from'");
			} else if( (!empty($date_to))) {
				$this->db->where("posting_date <= '$date_from'");
			}
		}

		if(!empty($status))
			$this->db->where('status', $status);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'iy':
					$field_sort_name = 'id_stdstock_header';
					$field_sort_type = 'asc';
					break;
				case 'iz':
					$field_sort_name = 'id_stdstock_header';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'stdstock_no';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'stdstock_no';
					$field_sort_type = 'desc';
					break;
				case 'py':
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'pz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'vy':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'asc';
					break;
				case 'vz':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'desc';
					break;
				case 'ny':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'asc';
					break;
				case 'nz':
					$field_sort_name = 'nm_vendor';
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

	function stdstock_header_delete($id_stdstock_header) {

		if($this->stdstock_details_delete($id_stdstock_header)) {

			$this->db->where('id_stdstock_header', $id_stdstock_header);

			if($this->db->delete('t_stdstock_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input


	function sap_item_groups_select_all() {
		$this->db->from('m_item_group');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
	}

	function sap_item_group_select($item_group_code) {
		$this->db->from('m_item_group');
		$this->db->where('item_group_code', $item_group_code);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
	}

	function sap_stdstock_detail_select_by_id_stdstock_h_detail($id_stdstock_h_detail) {

		$this->db->from('wiwid_s_stdstock_detail');
		$this->db->where('id_stdstock_h_detail', $id_stdstock_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_stdstock_detail_select_by_item($item) {

		$this->db->from('wiwid_s_stdstock_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_stdstock_plant_new_select($id_outlet) {

		$this->db->select_max('id_stdstock_plant');
		$this->db->from('t_stdstock_header');
		$this->db->where('plant', $id_outlet);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$stdstock = $query->row_array();
			$id_stdstock_outlet = $stdstock['id_stdstock_plant'] + 1;
		}	else {
			$id_stdstock_outlet = 1;
		}

		return $id_stdstock_outlet;
	}

	function stdstock_header_insert($data) {
		if($this->db->insert('t_stdstock_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_stdstock_header_approve($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GI_TRNSFO");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['gr_quantity'][$i]))
            $this->m_saprfc->append ("I_ITEM",
              array ("ITEM_NO"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "GR_QNTY"=>$data['gr_quantity'][$i],
                    "GR_UOM"=>$data['uom'][$i],
                    "REC_PLANT"=>$data['receiving_plant'],
                    ));
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $MATDOCUMENTYEAR = $this->m_saprfc->export("MATDOCUMENTYEAR");
       $MATERIALDOCUMENT = $this->m_saprfc->export("MATERIALDOCUMENT");
       $PO_DOCUMENT = $this->m_saprfc->export("PO_DOCUMENT");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "po_document" => $PO_DOCUMENT,
          "sap_messages" => $I_RETURN[1]['MESSAGE'],
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        return $approved_data;
	}

	function sap_stdstock_header_cancel($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CANCEL_GOODS_MOV");
       $this->m_saprfc->importParameter(array ("MATDOCUMENTYEAR",
                                             "MATERIALDOCUMENT",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['mat_doc_year'],
                                             $data['stdstock_no'],
                                             $data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("MATDOC_ITEM");
       for ($i=1;$i<=$count;$i++) {
         $this->m_saprfc->append ("MATDOC_ITEM",
            array ("MATDOC_ITEM"=>$data['item'][$i])
          );
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $GOODSMVT_HEADRET = $this->m_saprfc->export("GOODSMVT_HEADRET");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $cancelled_data = array (
          "material_document" => $GOODSMVT_HEADRET['MAT_DOC'],
          "sap_messages" => $I_RETURN[1]['MESSAGE']
        );

        return $cancelled_data;
	}

	function stdstock_header_update($data) {
		$this->db->where('id_stdstock_header', $data['id_stdstock_header']);
		if($this->db->update('t_stdstock_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function stdstock_detail_insert($data) {
		if($this->db->insert('t_stdstock_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_stdstock_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function stdstock_header_select($id_stdstock_header) {
		$this->db->from('t_stdstock_header');
		$this->db->where('id_stdstock_header', $id_stdstock_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function stdstock_details_select($id_stdstock_header) {
		$this->db->from('t_stdstock_detail');
		$this->db->where('id_stdstock_header', $id_stdstock_header);
		$this->db->order_by('id_stdstock_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stdstock_detail_update($data) {
		$this->db->where('id_stdstock_detail', $data['id_stdstock_detail']);
		if($this->db->update('t_stdstock_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function stdstock_details_delete($id_stdstock_header) {
		$this->db->where('id_stdstock_header', $id_stdstock_header);
		if($this->db->delete('t_stdstock_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit

/*
	function purchase_data_select($purchase_order_no) {
		$this->db->from('s_purchase_data');
		$this->db->where('purchase_order_no', $purchase_order_no);
		$this->db->order_by('vendor_name, item');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function purchase_data_select_1($purchase_order_no) {

		$this->db->from('s_purchase_data');
		$this->db->where('purchase_order_no', $purchase_order_no);
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}
*/

}
