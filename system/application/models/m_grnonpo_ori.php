<?php
class M_grnonpo extends Model {

	function M_grnonpo() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function grnonpo_headers_select_all() {
		$this->db->from('t_grnonpo_header');
		$this->db->order_by('id_grnonpo_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a grnonpo header.
	 * @return integer|false Count of result from a grnonpo header.
	 */
	function grnonpo_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grnonpo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
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
					$field_sort_name = 'id_grnonpo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grnonpo_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grpo_no';
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

	function grnonpo_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grnonpo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
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
					$field_sort_name = 'id_grnonpo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grnonpo_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grpo_no';
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

	function grnonpo_header_delete($id_grnonpo_header) {

		if($this->grnonpo_details_delete($id_grnonpo_header)) {

			$this->db->where('id_grnonpo_header', $id_grnonpo_header);

			if($this->db->delete('t_grnonpo_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	function grnonpo_is_data_cancelled($id_grnonpo_header) {
		$this->db->from('t_grnonpo_detail');
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function id_grnonpo_plant_new_select($id_outlet,$posting_date="",$id_grnonpo_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grnonpo_plant');
		$this->db->from('t_grnonpo_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grnonpo_header)) {
    	  $this->db->where('id_grnonpo_header <> ', $id_grnonpo_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$grnonpo = $query->row_array();
			$id_grnonpo_outlet = $grnonpo['id_grnonpo_plant'] + 1;
		}	else {
			$id_grnonpo_outlet = 1;
		}

		return $id_grnonpo_outlet;
	}

	function grnonpo_header_insert($data) {
		if($this->db->insert('t_grnonpo_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grnonpo_header_approve($data) {

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GR_NONPO");
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
          if(!empty($data['quantity'][$i]))
            $this->m_saprfc->append ("I_ITEM",
              array ("MATNR"=>$data['material_no'][$i],
                    "LABST"=>$data['quantity'][$i],
                    "MEINS"=>$data['uom'][$i],
                    "ITEM_TEXT"=>$data['additional_text'][$i],
                    ));
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $MATDOCUMENTYEAR = $this->m_saprfc->export("MATDOCUMENTYEAR");
       $MATERIALDOCUMENT = $this->m_saprfc->export("MATERIALDOCUMENT");
       $ERRORX = $this->m_saprfc->export("ERRORX");
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
           'MATNR :'.$I_ITEM[$i]['MATNR'].' <br> '.
           'LABST :'.$I_ITEM[$i]['LABST'].' <br> '.
           'MEINS :'.$I_ITEM[$i]['MEINS'].' <br> '.
           'ITEM_TEXT :'.$I_ITEM[$i]['ITEM_TEXT'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

        return $approved_data;
	}

	function sap_grnonpo_header_cancel($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
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
                                             $data['grnonpo_no'],
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
           'MATERIALDOCUMENT : '.$data['grnonpo_no'].' <br> '.
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

	function grnonpo_header_update($data) {
		$this->db->where('id_grnonpo_header', $data['id_grnonpo_header']);
		if($this->db->update('t_grnonpo_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grnonpo_detail_insert($data) {
		if($this->db->insert('t_grnonpo_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function grnonpo_header_select($id_grnonpo_header) {
		$this->db->from('t_grnonpo_header');
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function grnonpo_details_select($id_grnonpo_header) {
		$this->db->from('t_grnonpo_detail');
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);
		$this->db->order_by('id_grnonpo_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function grnonpo_detail_update($data) {
		$this->db->where('id_grnonpo_detail', $data['id_grnonpo_detail']);
		if($this->db->update('t_grnonpo_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grnonpo_details_delete($id_grnonpo_header) {
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);
		if($this->db->delete('t_grnonpo_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
