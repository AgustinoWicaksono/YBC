<?php
class M_whole extends Model {

	function M_whole() {
		parent::Model();
	}

	// start of browse

	function whole_headers_select_all() {
		$this->db->from('t_whole_header');
		$this->db->order_by('id_whole_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a whole header.
	 * @return integer|false Count of result from a whole header.
	 */
	function whole_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_whole_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'whole_no';
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
					$field_sort_name = 'id_whole_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_whole_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'whole_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'whole_no';
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

	function whole_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_whole_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'whole_no';
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
					$field_sort_name = 'id_whole_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_whole_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'whole_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'whole_no';
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

	function whole_header_delete($id_whole_header) {

		if($this->whole_details_delete($id_whole_header)) {

			$this->db->where('id_whole_header', $id_whole_header);

			if($this->db->delete('t_whole_header'))
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
	
	

	function sap_whole_detail_select_by_id_whole_h_detail($id_whole_h_detail) {

		$this->db->from('wiwid_s_whole_detail');
		$this->db->where('id_whole_h_detail', $id_whole_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_whole_detail_select_by_item($item) {

		$this->db->from('wiwid_s_whole_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_whole_plant_new_select($id_outlet,$posting_date="",$id_whole_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_whole_plant');
		$this->db->from('t_whole_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_whole_header)) {
    	  $this->db->where('id_whole_header <> ', $id_whole_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$whole = $query->row_array();
			$id_whole_outlet = $whole['id_whole_plant'] + 1;
		}	else {
			$id_whole_outlet = 1;
		}

		return $id_whole_outlet;
	}

	function whole_header_insert($data) {
		if($this->db->insert('t_whole_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_whole_header_approve($data) {
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
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $PO_DOCUMENT = $this->m_saprfc->export("PO_DOCUMENT");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_ITEM = $this->m_saprfc->fetch_rows("I_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }
       if($ERRORX=='X') {
         $count = count($I_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'ITEM_NO :'.$I_ITEM[$i]['ITEM_NO'].' <br> '.
           'MATNR :'.$I_ITEM[$i]['MATNR'].' <br> '.
           'GR_QNTY :'.$I_ITEM[$i]['GR_QNTY'].' <br> '.
           'GR_UOM :'.$I_ITEM[$i]['GR_UOM'].' <br> '.
           'REC_PLANT :'.$I_ITEM[$i]['REC_PLANT'].' <br> ';
         }
       }
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }
        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "po_document" => $PO_DOCUMENT,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );
        if($ERRORX=='X') {
          unset($approved_data['material_document']);
          unset($approved_data['po_document']);
        }

        return $approved_data;
	}

	function sap_whole_header_cancel($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CANCEL_GI_TRANSFO");
       $this->m_saprfc->importParameter(array ("MATDOCUMENTYEAR",
                                             "MATERIALDOCUMENT",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "PO_DOC",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['mat_doc_year'],
                                             $data['whole_no'],
                                             $data['plant'],
                                             $data['posting_date'],
                                             $data['po_no'],
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
       $MATDOC_ITEM = $this->m_saprfc->fetch_rows("MATDOC_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }
       if (empty($GOODSMVT_HEADRET['MAT_DOC'])) {
         $count = count($MATDOC_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'MATDOCUMENTYEAR : '.$data['mat_doc_year'].' <br> '.
           'MATERIALDOCUMENT : '.$data['whole_no'].' <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'MATDOC_ITEM :'.$MATDOC_ITEM[$i]['MATDOC_ITEM'].' <br> ';
         }
       }

       $cancelled_data = array (
          "material_document" => $GOODSMVT_HEADRET['MAT_DOC'],
          "sap_messages" => $sap_messages,
          "mat_doc_item" => $MATDOC_ITEM
        );

        return $cancelled_data;
	}

	function whole_header_update($data) {
		$this->db->where('id_whole_header', $data['id_whole_header']);
		if($this->db->update('t_whole_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function whole_header_update_by_whole_no($data) {
		$this->db->where('whole_no', $data['whole_no']);
		if($this->db->update('t_whole_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function whole_detail_insert($data) {
		if($this->db->insert('t_whole_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}
	
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}


	function sap_whole_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function whole_header_select($id_whole_header) {
		$this->db->from('t_whole_header');
		$this->db->where('id_whole_header', $id_whole_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function whole_details_select($id_whole_header) {
		$this->db->from('t_whole_detail');
		$this->db->where('id_whole_header', $id_whole_header);
		$this->db->order_by('id_whole_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function batch($item) {
		$this->db->from('t_batch');
		$this->db->where('ItemCode', $item);
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function whole_is_data_cancelled($id_whole_header) {
		$this->db->from('t_whole_detail');
		$this->db->where('id_whole_header', $id_whole_header);
		//$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function whole_detail_update($data) {
		$this->db->where('id_whole_detail', $data['id_whole_detail']);
		if($this->db->update('t_whole_detail', $data))
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

	function whole_details_delete($id_whole_header) {
		$this->db->where('id_whole_header', $id_whole_header);
		if($this->db->delete('t_whole_detail'))
			return TRUE;
			
		else
			return FALSE;
	}
	
	function batch_delete($id_whole_header) {
		$this->db->where('BaseEntry', $id_whole_header);
		$this->db->where('BaseType', 0);
		if($this->db->delete('t_batch'))
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
