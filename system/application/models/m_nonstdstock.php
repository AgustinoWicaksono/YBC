<?php
class M_nonstdstock extends Model {

	function M_nonstdstock() {
		parent::Model();
	}

	// start of browse

	function nonstdstock_headers_select_all() {
		$this->db->from('t_nonstdstock_header');
		$this->db->order_by('id_nonstdstock_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function nonstdstock_select_to_export($id_nonstdstock_header) {
		$this->db->from('v_nonstdstock_export');
		$this->db->where_in('id_nonstdstock_header', $id_nonstdstock_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a nonstdstock header.
	 * @return integer|false Count of result from a nonstdstock header.
	 */
	function nonstdstock_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_nonstdstock_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'pr_no';
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
				$this->db->where("created_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("created_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("created_date <= '$date_from2'");
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
					$field_sort_name = 'id_nonstdstock_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_nonstdstock_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'pr_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'pr_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'created_date';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'created_date';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'request_reason';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'request_reason';
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

	function nonstdstock_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_nonstdstock_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'pr_no';
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
				$this->db->where("created_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("created_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("created_date <= '$date_from2'");
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
					$field_sort_name = 'id_nonstdstock_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_nonstdstock_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'pr_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'pr_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'created_date';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'created_date';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'request_reason';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'request_reason';
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

	function nonstdstock_header_delete($id_nonstdstock_header) {

		if($this->nonstdstock_details_delete($id_nonstdstock_header)) {

			$this->db->where('id_nonstdstock_header', $id_nonstdstock_header);

			if($this->db->delete('t_nonstdstock_header'))
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
	
/*	
//original version
	function sap_item_lead_time_select($item_code) {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_LIST_LEAD_TIME");
        $this->m_saprfc->importParameter(array ("MATNR","OUTLET"),
                                         array ($item_code,$kd_plant));
        $this->m_saprfc->setInitTable("LEAD_TIME");
        $this->m_saprfc->executeSAP();
        $LEAD_TIME = $this->m_saprfc->fetch_rows("LEAD_TIME");
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        if (count($LEAD_TIME) > 0) {
          return $LEAD_TIME[1];
        } else {
          return FALSE;
        }
	}
*/	

	function sap_item_lead_time_select($item_code) {
		if ((!Empty($item_code)) || (trim($item_code)!="")) {
			$kd_plant = $this->session->userdata['ADMIN']['plant'];
			$this->db->from('ZMM_BAPI_LIST_LEAD_TIME_A');
			$this->db->where('MATNR', $item_code);
			$this->db->where('OUTLET',$kd_plant);
			$this->db->order_by('LEAD_TIME','desc');

			$query = $this->db->get();

			if($query->num_rows() > 0) {
				$leadtimes = $query->result_array();
				$count = count($leadtimes);
				$k = 1;
				for ($i=0;$i<=$count-1;$i++) {
				  $leadtm[$k] = $leadtimes[$i];
				  $k++;
				}
				return $leadtm[1];
			 } else {
				return FALSE;
			 }
		} else { return FALSE; }
	}

	function sap_nonstdstock_detail_select_by_id_nonstdstock_h_detail($id_nonstdstock_h_detail) {

		$this->db->from('wiwid_s_nonstdstock_detail');
		$this->db->where('id_nonstdstock_h_detail', $id_nonstdstock_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_nonstdstock_detail_select_by_item($item) {

		$this->db->from('wiwid_s_nonstdstock_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_nonstdstock_plant_new_select($id_outlet,$created_date="",$id_nonstdstock_header="") {

        if (empty($created_date))
           $created_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_nonstdstock_plant');
		$this->db->from('t_nonstdstock_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(created_date)', $created_date);
        if (!empty($id_nonstdstock_header)) {
    	  $this->db->where('id_nonstdstock_header <> ', $id_nonstdstock_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$nonstdstock = $query->row_array();
			$id_nonstdstock_outlet = $nonstdstock['id_nonstdstock_plant'] + 1;
		}	else {
			$id_nonstdstock_outlet = 1;
		}

		return $id_nonstdstock_outlet;
	}

	function nonstdstock_header_insert($data) {
		if($this->db->insert('t_nonstdstock_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_nonstdstock_header_approve($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_PR_STO_NONSTD");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "REQ_REASON",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['created_date'],
                                             $data['request_reason'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['requirement_qty'][$i]))
            $this->m_saprfc->append ("I_PR_ITEM",
              array ("MATNR"=>$data['material_no'][$i],
                    "QUANTITY"=>$data['requirement_qty'][$i],
                    "BSTME"=>$data['uom'][$i],
                    "DELIV_DATE"=>$data['delivery_date'][$i],
                    ));
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->setInitTable("I_PR_ITEM_EXP");
       $this->m_saprfc->executeSAP();
       $PR_NUMBER = $this->m_saprfc->export("PR_NUMBER");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_PR_ITEM_EXP = $this->m_saprfc->fetch_rows("I_PR_ITEM_EXP");
       $I_PR_ITEM = $this->m_saprfc->fetch_rows("I_PR_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       if ($I_RETURN[1]['TYPE'] !== 'S') {
          unset($PR_NUMBER);
       };
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if($ERRORX=='X') {
         $count = count($I_PR_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['created_date'].' <br> '.
           'REQ_REASON : '.$data['request_reason'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'MATNR :'.$I_PR_ITEM[$i]['MATNR'].' <br> '.
           'QUANTITY :'.$I_PR_ITEM[$i]['QUANTITY'].' <br> '.
           'BSTME :'.$I_PR_ITEM[$i]['BSTME'].' <br> '.
           'DELIV_DATE :'.$I_PR_ITEM[$i]['DELIV_DATE'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" =>$PR_NUMBER,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE'],
          "sap_pr_item" => $I_PR_ITEM_EXP
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

       return $approved_data;
	}

	function sap_nonstdstock_header_change($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CHANGE_PR_STO_NONSTD");
       $this->m_saprfc->importParameter(array ("PR_NUMBER_IN",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['pr_no'],
                                             $data['plant'],
                                             $data['created_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
         if (!empty($data['material_no'][$i])) {
           $this->m_saprfc->append ("I_PR_ITEM",
              array ("EBELP"=>$data['id_nonstdstock_pr_line_no'][$i],
                     "MATNR"=>$data['material_no'][$i],
                     "QUANTITY"=>$data['requirement_qty'][$i],
                     "QUANTITY_OLD"=>$data['requirement_qty_old'][$i],
                     "DELIV_DATE"=>$data['delivery_date'][$i],
                     "CHANGE_IND"=>"X",
                     ));
          }
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_PR_ITEM = $this->m_saprfc->fetch_rows("I_PR_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if ($I_RETURN[1]['TYPE']!='S') {
         $count = count($I_PR_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'PR_NUMBER_IN : '.$data['pr_no'].' <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['created_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'EBELP :'.$I_PR_ITEM[$i]['EBELP'].' <br> '.
           'MATNR :'.$I_PR_ITEM[$i]['MATNR'].' <br> '.
           'QUANTITY :'.$I_PR_ITEM[$i]['QUANTITY'].' <br> '.
           'QUANTITY_OLD :'.$I_PR_ITEM[$i]['QUANTITY_OLD'].' <br> '.
           'CHANGE_IND :'.$I_PR_ITEM[$i]['CHANGE_IND'].' <br> '.
           'DELIV_DATE :'.$I_PR_ITEM[$i]['DELIV_DATE'].' <br> ';
         }
       }

       $changed_data = array (
          "sap_return_type" => $I_RETURN[1]['TYPE'],
          "sap_messages" => $sap_messages,
        );

        return $changed_data;
	}

	function sap_nonstdstock_header_cancel($data) {
//echo "<pre>";
//print '$data';
//print_r($data);
//echo "</pre>";
//exit;

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_PR_NONSTD_CNCL");
       $this->m_saprfc->importParameter(array ("PR_NUMBER",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['pr_no'],
                                             $data['plant'],
                                             $data['created_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
         if (!empty($data['material_no'][$i])) {
           $this->m_saprfc->append ("I_PR_ITEM",
              array ("EBELP"=>$data['id_nonstdstock_pr_line_no'][$i],
                     "MATNR"=>$data['material_no'][$i],
                     "QUANTITY"=>$data['requirement_qty'][$i],
                     "DELETE_IND"=>"X",
                     )
            );
         }
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_PR_ITEM = $this->m_saprfc->fetch_rows("I_PR_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if (($I_RETURN[1]['TYPE']!='S')&&(!empty($I_RETURN[1]['TYPE']))) {
         $count = count($I_PR_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'PR_NUMBER : '.$data['pr_no'].' <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['created_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'EBELP :'.$I_PR_ITEM[$i]['EBELP'].' <br> '.
           'MATNR :'.$I_PR_ITEM[$i]['MATNR'].' <br> '.
           'QUANTITY :'.$I_PR_ITEM[$i]['QUANTITY'].' <br> '.
           'DELETE_IND :'.$I_PR_ITEM[$i]['DELETE_IND'].' <br> ';
         }
       }

       $cancelled_data = array (
          "sap_return_type" => $I_RETURN[1]['TYPE'],
          "sap_messages" => $sap_messages
        );

        return $cancelled_data;
	}

	function nonstdstock_header_update($data) {
		$this->db->where('id_nonstdstock_header', $data['id_nonstdstock_header']);
		if($this->db->update('t_nonstdstock_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function nonstdstock_detail_insert($data) {
		if($this->db->insert('t_nonstdstock_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_nonstdstock_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function nonstdstock_header_select($id_nonstdstock_header) {
		$this->db->from('t_nonstdstock_header');
		$this->db->where('id_nonstdstock_header', $id_nonstdstock_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function nonstdstock_details_select($id_nonstdstock_header) {
		$this->db->from('t_nonstdstock_detail');
		$this->db->where('id_nonstdstock_header', $id_nonstdstock_header);
		$this->db->order_by('id_nonstdstock_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function nonstdstock_detail_update($data) {
		$this->db->where('id_nonstdstock_detail', $data['id_nonstdstock_detail']);
		if($this->db->update('t_nonstdstock_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function nonstdstock_detail_update_by_id_h_detail($data) {
		$this->db->where('id_nonstdstock_h_detail', $data['id_nonstdstock_h_detail']);
		$this->db->where('id_nonstdstock_header', $data['id_nonstdstock_header']);
		if($this->db->update('t_nonstdstock_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function nonstdstock_detail_update_by_material_no($data) {
		$this->db->where('material_no', $data['material_no']);
		$this->db->where('id_nonstdstock_header', $data['id_nonstdstock_header']);
		if($this->db->update('t_nonstdstock_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function nonstdstock_details_delete($id_nonstdstock_header) {
		$this->db->where('id_nonstdstock_header', $id_nonstdstock_header);
		if($this->db->delete('t_nonstdstock_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function nonstdstock_detail_delete($id_nonstdstock_detail) {
		$this->db->where('id_nonstdstock_detail', $id_nonstdstock_detail);
		if($this->db->delete('t_nonstdstock_detail'))
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
