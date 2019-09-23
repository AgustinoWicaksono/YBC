<?php
class M_grfg extends Model {

	function M_grfg() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function grfg_headers_select_all() {
		$this->db->from('t_grfg_header');
		$this->db->order_by('id_grfg_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a grfg header.
	 * @return integer|false Count of result from a grfg header.
	 */
	function grfg_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grfg_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grfg_no';
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
					$field_sort_name = 'id_grfg_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grfg_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grfg_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grfg_no';
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

	function grfg_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grfg_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grfg_no';
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
					$field_sort_name = 'id_grfg_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grfg_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grfg_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grfg_no';
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

	function grfg_is_data_cancelled($id_grfg_header) {
		$this->db->from('t_grfg_detail');
		$this->db->where('id_grfg_header', $id_grfg_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function grfg_header_delete($id_grfg_header) {

		if($this->grfg_details_delete($id_grfg_header)) {

			$this->db->where('id_grfg_header', $id_grfg_header);

			if($this->db->delete('t_grfg_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	function id_grfg_plant_new_select($id_outlet,$posting_date="",$id_grfg_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grfg_plant');
		$this->db->from('t_grfg_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grfg_header)) {
    	  $this->db->where('id_grfg_header <> ', $id_grfg_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$grfg = $query->row_array();
			$id_grfg_outlet = $grfg['id_grfg_plant'] + 1;
		}	else {
			$id_grfg_outlet = 1;
		}

		return $id_grfg_outlet;
	}

	function grfg_header_insert($data) {
		if($this->db->insert('t_grfg_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grfg_header_approve($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("Z_MM_BAPI_CREATE_GRFG_N");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID",
                                               ),
                                      array ($data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'],
                                             )
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_MATERIAL_IN");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['gr_quantity'][$i]))
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array ("ITEM_NO"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "QUANTITY"=>$data['gr_quantity'][$i],
                    "UNIT"=>$data['uom'][$i],
                    ));
       }

       $this->m_saprfc->setInitTable("I_RETURN");
//       $this->m_saprfc->setInitTable("I_MATERIAL_OUT");
       $this->m_saprfc->executeSAP();
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $DOC_CREATED = $this->m_saprfc->export("DOC_CREATED");
       $DOC_YEAR = $this->m_saprfc->export("DOC_YEAR");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
//       $I_MATERIAL_OUT = $this->m_saprfc->fetch_rows("I_MATERIAL_OUT");
       $I_MATERIAL_IN = $this->m_saprfc->fetch_rows("I_MATERIAL_IN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

/*
       $count = count($I_MATERIAL_OUT);
       $item_success = 0;
       for($i=1;$i<=$count;$i++) {
         if (($I_MATERIAL_OUT[$i]['ERRORX']!=='X')&&(trim($I_MATERIAL_OUT[$i]['ITEM_TEXT'])!=='')) {
            $item_success++;
         }
       }
*/

        if($ERRORX=='X') {
         $count = count($I_MATERIAL_IN);
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
           'ITEM_NO :'.$I_MATERIAL_IN[$i]['ITEM_NO'].' <br> '.
           'MATNR :'.$I_MATERIAL_IN[$i]['MATNR'].' <br> '.
           'QUANTITY :'.$I_MATERIAL_IN[$i]['QUANTITY'].' <br> '.
           'UNIT :'.$I_MATERIAL_IN[$i]['UNIT'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" => $DOC_CREATED."-".$DOC_YEAR,
//          "material_document" => $data['web_trans_id'],
          "matdocyear" => $DOC_CREATED."-".$DOC_YEAR,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE'],
        );
		

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

        return $approved_data;
	}

	function sap_grfg_header_cancel($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GR_FG_CNCLGRP");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                             "POSTING_DATE",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['doc_in']);
       $this->m_saprfc->setInitTable("DOC_CNCL_IN");
       for ($i=1;$i<=$count;$i++) {
         if (trim($data['doc_in'][$i])!=='') {
            $this->m_saprfc->append ("DOC_CNCL_IN",
              array ("DOC_IN"=>$data['doc_in'][$i],
                    "YEAR_IN"=>$data['year_in'][$i],
                    ));
         }
       }

       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->setInitTable("DOC_CNCL_OUT");
       $this->m_saprfc->executeSAP();
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $DOC_CNCL_OUT = $this->m_saprfc->fetch_rows("DOC_CNCL_OUT");
       $DOC_CNCL_IN = $this->m_saprfc->fetch_rows("DOC_CNCL_IN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       $count = count($DOC_CNCL_OUT);
       $item_success = 0;
       for($i=1;$i<=$count;$i++) {
         if ($DOC_CNCL_OUT[$i]['ERRORX']!=='X') {
            $item_success++;
         }
       }

        if(($ERRORX=='X')||(count($DOC_CNCL_OUT)<1)||($item_success==0)) {
           $count = count($DOC_CNCL_IN);
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
             'DOC_IN :'.$DOC_CNCL_IN[$i]['DOC_IN'].' <br> '.
             'YEAR_IN :'.$DOC_CNCL_IN[$i]['YEAR_IN'].' <br> ';
           }
        }
//        echo "<pre>";
//        print_r($DOC_CNCL_OUT);
//        echo "</pre>";
//        exit;
       $cancelled_data = array (
          "material_document" => $data['web_trans_id'],
          "sap_messages" => $sap_messages,
          "doc_out" => $DOC_CNCL_OUT,
          "doc_success" => $item_success,
          "doc_failed" => count($DOC_CNCL_OUT)-$item_success,
        );

        if(($ERRORX=='X')||(count($DOC_CNCL_OUT)<1)||($item_success==0)) {
          unset($cancelled_data['material_document']);
        }

        return $cancelled_data;
	}

	function grfg_header_update($data) {
		$this->db->where('id_grfg_header', $data['id_grfg_header']);
		if($this->db->update('t_grfg_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grfg_detail_insert($data) {
		if($this->db->insert('t_grfg_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function grfg_header_select($id_grfg_header) {
		$this->db->from('t_grfg_header');
		$this->db->where('id_grfg_header', $id_grfg_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function grfg_details_select($id_grfg_header) {
		$this->db->from('t_grfg_detail');
		$this->db->where('id_grfg_header', $id_grfg_header);
		$this->db->order_by('id_grfg_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function grfg_detail_update($data) {
		$this->db->where('id_grfg_detail', $data['id_grfg_detail']);
		if($this->db->update('t_grfg_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grfg_detail_update_by_mat_doc_approval($data) {
		$this->db->where('id_grfg_header', $data['id_grfg_header']);
		$this->db->where('material_docno_approval', $data['material_docno_approval']);
		if($this->db->update('t_grfg_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grfg_details_delete($id_grfg_header) {
		$this->db->where('id_grfg_header', $id_grfg_header);
		if($this->db->delete('t_grfg_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
