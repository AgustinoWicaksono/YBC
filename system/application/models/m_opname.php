<?php
class M_opname extends Model {

	function M_opname() {
		parent::Model();
	}

	// start of browse

	function opname_headers_select_all() {
		$this->db->from('t_opname_header');
		$this->db->order_by('id_opname_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function user_delete($waste_delete) {
		if($this->db->insert('t_delete', $waste_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}
	
	public function insertCSV($data)
            {
                $this->db->insert('t_opname_header', $data);
                return TRUE;
				
            }


	/**
	 * Get how many result from a opname header.
	 * @return integer|false Count of result from a opname header.
	 */
	function opname_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_opname_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'opname_no';
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
				$this->db->where("delivery_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("delivery_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("delivery_date <= '$date_from2'");
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
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'opname_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'opname_no';
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
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'request_reason';
					$field_sort_type = 'asc';
					break;
				case 'ez':
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
	
	function opname_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_opname_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'opname_no';
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
				$this->db->where("delivery_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("delivery_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("delivery_date <= '$date_from2'");
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
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'opname_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'opname_no';
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
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'request_reason';
					$field_sort_type = 'asc';
					break;
				case 'ez':
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
				case 'gy':
					$field_sort_name = 'back';
					$field_sort_type = 'asc';
					break;
				case 'gz':
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

	function opname_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_opname_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'opname_no';
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
				$this->db->where("delivery_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("delivery_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("delivery_date <= '$date_from2'");
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
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_opname_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'opname_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'opname_no';
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
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'request_reason';
					$field_sort_type = 'asc';
					break;
				case 'ez':
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

	function opname_header_delete($id_opname_header) {

		if($this->opname_details_delete($id_opname_header)) {

			$this->db->where('id_opname_header', $id_opname_header);

			if($this->db->delete('t_opname_header'))
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

	function sap_opname_detail_select_by_id_opname_h_detail($id_opname_h_detail) {

		$this->db->from('wiwid_s_opname_detail');
		$this->db->where('id_opname_h_detail', $id_opname_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_opname_detail_select_by_item($item) {

		$this->db->from('wiwid_s_opname_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_opname_plant_new_select($id_outlet,$created_date="",$id_opname_header="") {

        if (empty($created_date))
           $created_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_opname_plant');
		$this->db->from('t_opname_header');
		$this->db->where('plant', $id_outlet);
	  	$this->db->where('DATE(created_date)', $created_date);
        if (!empty($id_opname_header)) {
    		$this->db->where('id_opname_header <> ', $id_opname_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$opname = $query->row_array();
			$id_opname_outlet = $opname['id_opname_plant'] + 1;
		}	else {
			$id_opname_outlet = 1;
		}

		return $id_opname_outlet;
	}

	function opname_header_insert($data) {
		if($this->db->insert('t_opname_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function opname_select_to_export($id_opname_header) {
		$this->db->from('v_opname_export');
		$this->db->where_in('id_opname_header', $id_opname_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function sap_opname_header_approve($data) {
//echo "<opnamee>";
//opnameint_r($data);
//echo "</opnamee>";
//exit;
       $this->m_saopnamefc->setUserRfc();
       $this->m_saopnamefc->setPassRfc();
       $this->m_saopnamefc->sapAttr();
       $this->m_saopnamefc->connect();
       $this->m_saopnamefc->functionDiscover("ZMM_BAPI_CREATE_PR_STO_STD");
       $this->m_saopnamefc->importParameter(array ("OUTLET",
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
       $this->m_saopnamefc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['requirement_qty'][$i]))
            $this->m_saopnamefc->append ("I_PR_ITEM",
              array ("MATNR"=>$data['material_no'][$i],
                    "QUANTITY"=>$data['requirement_qty'][$i],
                    "BSTME"=>$data['uom'][$i],
                    "DELIV_DATE"=>$data['delivery_date'],
                    ));
       }
       $this->m_saopnamefc->setInitTable("I_RETURN");
       $this->m_saopnamefc->setInitTable("I_PR_ITEM_EXP");
       $this->m_saopnamefc->executeSAP();
       $PR_NUMBER = $this->m_saopnamefc->export("PR_NUMBER");
       $ERRORX = $this->m_saopnamefc->export("ERRORX");
       $I_RETURN = $this->m_saopnamefc->fetch_rows("I_RETURN");
       $I_PR_ITEM_EXP = $this->m_saopnamefc->fetch_rows("I_PR_ITEM_EXP");
       $I_PR_ITEM = $this->m_saopnamefc->fetch_rows("I_PR_ITEM");
       $this->m_saopnamefc->free();
       $this->m_saopnamefc->close();
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
          "sap_opname_item" => $I_PR_ITEM_EXP
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

       return $approved_data;
	}

	function sap_opname_header_change($data) {
       $this->m_saopnamefc->setUserRfc();
       $this->m_saopnamefc->setPassRfc();
       $this->m_saopnamefc->sapAttr();
       $this->m_saopnamefc->connect();
       $this->m_saopnamefc->functionDiscover("ZMM_BAPI_CHANGE_PR_STO_STD");
       $this->m_saopnamefc->importParameter(array ("PR_NUMBER_IN",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['opname_no'],
                                             $data['plant'],
                                             $data['created_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saopnamefc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
         if (!empty($data['material_no'][$i])) {
           $this->m_saopnamefc->append ("I_PR_ITEM",
              array ("EBELP"=>$data['id_opname_opname_line_no'][$i],
                     "MATNR"=>$data['material_no'][$i],
                     "QUANTITY"=>$data['requirement_qty'][$i],
                     "QUANTITY_OLD"=>$data['requirement_qty_old'][$i],
                     "CHANGE_IND"=>"X",
                     ));
          }
       }
       $this->m_saopnamefc->setInitTable("I_RETURN");
       $this->m_saopnamefc->executeSAP();
       $I_RETURN = $this->m_saopnamefc->fetch_rows("I_RETURN");
       $I_PR_ITEM = $this->m_saopnamefc->fetch_rows("I_PR_ITEM");
       $this->m_saopnamefc->free();
       $this->m_saopnamefc->close();
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
           'PR_NUMBER_IN : '.$data['opname_no'].' <br> '.
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
           'CHANGE_IND :'.$I_PR_ITEM[$i]['CHANGE_IND'].' <br> ';
         }
       }

       $changed_data = array (
          "sap_return_type" => $I_RETURN[1]['TYPE'],
          "sap_messages" => $sap_messages
        );

        return $changed_data;
	}

	function sap_opname_header_cancel($data) {
//echo "<opnamee>";
//opnameint '$data';
//opnameint_r($data);
//echo "</opnamee>";
//exit;

       $this->m_saopnamefc->setUserRfc();
       $this->m_saopnamefc->setPassRfc();
       $this->m_saopnamefc->sapAttr();
       $this->m_saopnamefc->connect();
       $this->m_saopnamefc->functionDiscover("ZMM_BAPI_CREATE_PR_STD_CNCL");
       $this->m_saopnamefc->importParameter(array ("PR_NUMBER",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['opname_no'],
                                             $data['plant'],
                                             $data['created_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saopnamefc->setInitTable("I_PR_ITEM");
       for ($i=1;$i<=$count;$i++) {
         if (!empty($data['material_no'][$i])) {
           $this->m_saopnamefc->append ("I_PR_ITEM",
              array ("EBELP"=>$data['id_opname_opname_line_no'][$i],
                     "MATNR"=>$data['material_no'][$i],
                     "QUANTITY"=>$data['requirement_qty'][$i],
                     "DELETE_IND"=>"X",
                     )
            );
         }
       }
       $this->m_saopnamefc->setInitTable("I_RETURN");
       $this->m_saopnamefc->executeSAP();
       $I_RETURN = $this->m_saopnamefc->fetch_rows("I_RETURN");
       $I_PR_ITEM = $this->m_saopnamefc->fetch_rows("I_PR_ITEM");
       $this->m_saopnamefc->free();
       $this->m_saopnamefc->close();
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
           'PR_NUMBER : '.$data['opname_no'].' <br> '.
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

	function opname_header_update($data) {
		$this->db->where('id_opname_header', $data['id_opname_header']);
		if($this->db->update('t_opname_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function opname_detail_insert($data) {
		if($this->db->insert('t_opname_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_opname_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function opname_header_select($id_opname_header) {
		$this->db->from('t_opname_header');
		$this->db->where('id_opname_header', $id_opname_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function opname_details_select($id_opname_header) {
		$this->db->from('t_opname_detail');
		$this->db->where('id_opname_header', $id_opname_header);
		$this->db->order_by('id_opname_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function opname_detail_update($data) {
		$this->db->where('id_opname_detail', $data['id_opname_detail']);
		if($this->db->update('t_opname_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function opname_detail_update_by_id_h_detail($data) {
		$this->db->where('id_opname_h_detail', $data['id_opname_h_detail']);
		$this->db->where('id_opname_header', $data['id_opname_header']);
		if($this->db->update('t_opname_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function opname_details_delete($id_opname_header) {
		$this->db->where('id_opname_header', $id_opname_header);
		if($this->db->delete('t_opname_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function opname_detail_delete($id_opname_detail) {
		$this->db->where('id_opname_detail', $id_opname_detail);
		if($this->db->delete('t_opname_detail'))
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