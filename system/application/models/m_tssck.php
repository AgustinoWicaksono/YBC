<?php
class M_tssck extends Model {

	function M_tssck() {
		parent::Model();
	}

	// start of browse

	function tssck_headers_select_all() {
		$this->db->from('t_tssck_header');
		$this->db->order_by('id_tssck_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function tssck_do_select() {
		$posting_date = date('Y-m-d',strtotime($this->m_general->posting_date_select_max()));
		$posting_date_2 = $this->l_general->date_add_day_ymd($this->m_general->posting_date_select_max(),-10);
		$this->db->select('do_no');
		$this->db->from('v_tssck_do');
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('DATE(posting_date) <= ', $posting_date);
    	$this->db->where('DATE(posting_date) >= ', $posting_date_2);
		$this->db->group_by('do_no');

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function tssck_do_outstanding_update($do_no,$do_item,$qty,$oprd) {

        $kd_plant = $this->session->userdata['ADMIN']['plant'];

		$this->db->where('id_grpodlv_header IN
                        (SELECT id_grpodlv_header
                         FROM t_grpodlv_header
                         WHERE plant = "'.$kd_plant.'"
                         AND t_grpodlv_header.id_grpodlv_header =
                             t_grpodlv_detail.id_grpodlv_header
                         AND do_no = "'.$do_no.'") ');
		$this->db->where('material_no', $do_item);

		$this->db->set('tssck_qty','tssck_qty'.$oprd.$qty,FALSE);
		if($this->db->update('t_grpodlv_detail')) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function tssck_do_outstanding_update_to_0($id_tssck_header) {
        $kd_plant = $this->session->userdata['ADMIN']['plant'];

		$this->db->from('t_tssck_detail');
		$this->db->where('id_grpodlv_header IN
                        (SELECT id_grpodlv_header
                         FROM t_grpodlv_header INNER JOIN t_tssck_header on
                         t_tssck_header.do_no = t_grpodlv_header.do_no
                         WHERE t_grpodlv_header.plant = "'.$kd_plant.'"
                         AND id_tssck_header = '.$id_tssck_header.'
                         AND t_grpodlv_header.id_grpodlv_header =
                             t_grpodlv_detail.id_grpodlv_header) ');
		$this->db->where('material_no IN
                         (SELECT material_no FROM t_tssck_detail
                          WHERE t_tssck_detail.material_no = t_grpodlv_detail.material_no
                          AND id_tssck_header = '.$id_tssck_header.')');

		$this->db->set('tssck_qty','tssck_qty - (SELECT gr_quantity FROM t_tssck_detail
                          WHERE t_tssck_detail.material_no = t_grpodlv_detail.material_no
                          AND id_tssck_header = '.$id_tssck_header.' LIMIT 1)',FALSE);
		if($this->db->update('t_grpodlv_detail')) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function tssck_do_item_select($do_no) {
	    $this->db->select('v_tssck_do.*');
        $this->db->select('(REPLACE(material_no,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('v_tssck_do');
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('do_no', $do_no);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function tssck_do_item_select_by_material_no($do_no,$material_no) {
	    $this->db->select('v_tssck_do.*');
        $this->db->select('(REPLACE(material_no,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('v_tssck_do');
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('do_no', $do_no);
    	$this->db->where('material_no', $material_no);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
	/**
	 * Get how many result from a tssck header.
	 * @return integer|false Count of result from a tssck header.
	 */
	function tssck_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_tssck_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
					case 'a':
					$field_name_ori = 'tssck_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'do_no';
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
					$field_sort_name = 'id_tssck_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_tssck_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'tssck_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'tssck_no';
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
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'dz':
				    $field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'ey':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'do_no';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'do_no';
					$field_sort_type = 'desc';
					break;


			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}			// end of sorting

		$query = $this->db->get();
//echo $this->db->last_query();

		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function tssck_is_data_cancelled($id_tssck_header) {
		$this->db->from('t_tssck_detail');
		$this->db->where('id_tssck_header', $id_tssck_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function tssck_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_tssck_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
					case 'a':
					$field_name_ori = 'tssck_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'do_no';
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
					$field_sort_name = 'id_tssck_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_tssck_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'tssck_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'tssck_no';
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
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'dz':
				    $field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
				case 'ey':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'do_no';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'do_no';
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

	function tssck_header_delete($id_tssck_header) {

		if($this->tssck_details_delete($id_tssck_header)) {

			$this->db->where('id_tssck_header', $id_tssck_header);

			if($this->db->delete('t_tssck_header'))
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

	function sap_tssck_detail_select_by_id_tssck_h_detail($id_tssck_h_detail) {

		$this->db->from('wiwid_s_tssck_detail');
		$this->db->where('id_tssck_h_detail', $id_tssck_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_tssck_detail_select_by_item($item) {

		$this->db->from('wiwid_s_tssck_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_tssck_plant_new_select($id_outlet,$posting_date="",$id_tssck_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_tssck_plant');
		$this->db->from('t_tssck_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_tssck_header)) {
    	  $this->db->where('id_tssck_header <> ', $id_tssck_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$tssck = $query->row_array();
			$id_tssck_outlet = $tssck['id_tssck_plant'] + 1;
		}	else {
			$id_tssck_outlet = 1;
		}

		return $id_tssck_outlet;
	}

	function tssck_header_insert($data) {
		if($this->db->insert('t_tssck_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_tssck_header_approve($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_TRANSF_STOCK_CK");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "OUT_DELIV",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['do_no'],
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
           'OUT_DELIV : '.$data['do_no'].' <br> '.
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

	function sap_tssck_header_cancel($data) {
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
                                             $data['tssck_no'],
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
           'MATERIALDOCUMENT : '.$data['tssck_no'].' <br> '.
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
          "sap_messages" => $sap_messages
        );

        return $cancelled_data;
	}

	function tssck_header_update($data) {
		$this->db->where('id_tssck_header', $data['id_tssck_header']);
		if($this->db->update('t_tssck_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function tssck_detail_insert($data) {
		if($this->db->insert('t_tssck_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_tssck_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function tssck_header_select($id_tssck_header) {
		$this->db->from('t_tssck_header');
		$this->db->where('id_tssck_header', $id_tssck_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function tssck_details_select($id_tssck_header) {
		$this->db->from('t_tssck_detail');
		$this->db->where('id_tssck_header', $id_tssck_header);
		$this->db->order_by('id_tssck_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function tssck_detail_update($data) {
		$this->db->where('id_tssck_detail', $data['id_tssck_detail']);
		if($this->db->update('t_tssck_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function tssck_details_delete($id_tssck_header) {
	    if($this->tssck_do_outstanding_update_to_0($id_tssck_header)) {
    		$this->db->where('id_tssck_header', $id_tssck_header);
    		if($this->db->delete('t_tssck_detail'))
    			return TRUE;
    		else
    			return FALSE;
        } else
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
