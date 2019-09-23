<?php
class M_wo extends Model {

	function M_wo() {
		parent::Model();
	}

	// start of browse

	function wo_headers_select_all() {
		$this->db->from('t_wo_header');
		$this->db->order_by('id_wo_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a wo header.
	 * @return integer|false Count of result from a wo header.
	 */
	function wo_select_to_export($id_wo_header) {
		$this->db->from('v_wo_export');
		$this->db->where_in('id_wo_header', $id_wo_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function wo_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_wo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'material_doc_no';
					break;
				case 'b':
					$field_name_ori = 'material_doc_no_out';
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
					$field_sort_name = 'id_wo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_wo_header';
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
					$field_sort_name = 'material_doc_no_out';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'material_doc_no_out';
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

	function wo_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_wo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'material_doc_no';
					break;
				case 'b':
					$field_name_ori = 'material_doc_no_out';
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
					$field_sort_name = 'id_wo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_wo_header';
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
					$field_sort_name = 'material_doc_no_out';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'material_doc_no_out';
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

	function wo_header_delete($id_wo_header) {

		if($this->wo_details_delete($id_wo_header)) {

			$this->db->where('id_wo_header', $id_wo_header);

			if($this->db->delete('t_wo_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function id_wo_plant_new_select($id_outlet,$posting_date="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();

		$this->db->select_max('id_wo_plant');
		$this->db->from('t_wo_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$wo = $query->row_array();
			$id_wo_outlet = $wo['id_wo_plant'] + 1;
		}	else {
			$id_wo_outlet = 1;
		}

		return $id_wo_outlet;
	}

	function wo_header_insert($data) {
		if($this->db->insert('t_wo_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function wo_header_update($data) {
		$this->db->where('id_wo_header', $data['id_wo_header']);
		if($this->db->update('t_wo_header', $data))
			return TRUE;
		else
			return FALSE;
	}
	
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}
	
	function batch_master($data) {
		if($this->db->insert('m_batch', $data))
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

	function wo_detail_insert($data) {
		if($this->db->insert('t_wo_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function wo_detail_paket_insert($data) {
		if($this->db->insert('t_wo_detail_paket', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function wo_internal_order_select() {
	  $kd_plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->select('internal_order');
	  $this->db->from('m_internal_order');
	  $this->db->where('plant',$kd_plant);

      $query = $this->db->get();

      if($query->num_rows() > 0)
      	return $query->row_array();
      else
      	return FALSE;
	}

	function wo_reason_select_all() {
		$this->db->select('reason_name');
		$this->db->from('m_wo_reason');
		$this->db->order_by('reason_id');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
	}

	function wo_header_select($id_wo_header) {
		$this->db->from('t_wo_header');
		$this->db->where('id_wo_header', $id_wo_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function sap_wo_header_approve($data) {

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GRGI_CONV_NEW");
       $this->m_saprfc->importParameter(array ("ORDER_NO",
                                               "OUTLET",
                                               "STORAGE_LOC",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['internal_order'],
                                             $data['plant'],
                                             $data['storage_location'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_MATERIAL_IN");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['quantity'][$i]))
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array (
                    "ITEM_NO"=>$i,
                    "MATNR"=>$data['material_no'][$i],
                    "QUANTITY"=>$data['quantity'][$i],
                    "UNIT"=>$data['uom'][$i],
                    "MOV_TYPE"=>"ZI1",
                    "MOV_TYPE_CNL"=>"ZI3",
                    "GM_CODE"=>"03",
                    "GM_CODE_CNL"=>"05",
                    ));
       }
       $count_detail = $count;

        $data_wo_details_paket = $this->m_wo->wo_detail_paket_selectdata($data['id_wo_header']);
        if($data_wo_details_paket !== FALSE) {
            $i = 1;
            foreach ($data_wo_details_paket->result_array() as $object['temp']) {
            	foreach($object['temp'] as $key => $value) {
            		$data_wo_detail_paket[$key][$i] = $value;
            	}
            	$i++;
            	unset($object['temp']);
            }
        }

       $count = count($data_wo_detail_paket['material_no']);
       for ($i=1;$i<=$count;$i++) {
            if(!empty($data_wo_detail_paket['quantity'][$i])) {
              $item = $this->m_general->sap_item_select_by_item_code($data_wo_detail_paket['material_no'][$i]);
              if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)||(empty($item['UNIT']))) {
                  $data_wo_detail_paket['uom'][$i] = $data_wo_detail_paket['uom'][$i];
              } else {
                  $data_wo_detail_paket['uom'][$i] = $item['MEINS'];
              }
              $this->m_saprfc->append ("I_MATERIAL_IN",
                array (
                      "ITEM_NO"=>$count_detail+$i,
                      "MATNR"=>$data_wo_detail_paket['material_no'][$i],
                      "QUANTITY"=>$data_wo_detail_paket['quantity'][$i],
                      "UNIT"=>$data_wo_detail_paket['uom'][$i],
                      "MOV_TYPE"=>"ZI3",
                      "MOV_TYPE_CNL"=>"ZI1",
                      "GM_CODE"=>"05",
                      "GM_CODE_CNL"=>"03",
                      ));
            }
       }
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";

       echo "<pre>";
       print_r($data_wo_detail_paket);
       echo "</pre>";

       exit;
*/
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $DOC_YEAR_GI = $this->m_saprfc->export("DOC_YEAR_GI");
       $DOC_CREATED_GI = $this->m_saprfc->export("DOC_CREATED_GI");
       $DOC_YEAR_GR = $this->m_saprfc->export("DOC_YEAR_GR");
       $DOC_CREATED_GR = $this->m_saprfc->export("DOC_CREATED_GR");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_MATERIAL_IN = $this->m_saprfc->fetch_rows("I_MATERIAL_IN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if(($ERRORX=='X')||(empty($DOC_CREATED_GI))||(empty($DOC_CREATED_GR))) {
         $count = count($I_MATERIAL_IN);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'ORDER_NO : '.$data['internal_order'].' <br> '.
           'STORAGE_LOC : '.$data['storage_location'].' <br> '.
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
           'UNIT :'.$I_MATERIAL_IN[$i]['UNIT'].' <br> '.
           'MOV_TYPE :'.$I_MATERIAL_IN[$i]['MOV_TYPE'].' <br> '.
           'MOV_TYPE_CNL :'.$I_MATERIAL_IN[$i]['MOV_TYPE_CNL'].' <br> '.
           'GM_CODE :'.$I_MATERIAL_IN[$i]['GM_CODE'].' <br> '.
           'GM_CODE_CNL :'.$I_MATERIAL_IN[$i]['GM_CODE_CNL'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" => $DOC_CREATED_GR,
          "material_document_out" => $DOC_CREATED_GI,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
          unset($approved_data['material_document_out']);
        }

        return $approved_data;
	}

	function sap_wo_header_cancel($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GRGI_CONV_NEW");
       $this->m_saprfc->importParameter(array ("CNCL_FLAG",
                                               "ORDER_NO",
                                               "OUTLET",
                                               "STORAGE_LOC",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ("X",
                                             $data['internal_order'],
                                             $data['plant'],
                                             $data['storage_location'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_MATERIAL_IN");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['quantity'][$i]))
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array (
                    "ITEM_NO"=>$i,
                    "MATNR"=>$data['material_no'][$i],
                    "QUANTITY"=>$data['quantity'][$i],
                    "UNIT"=>$data['uom'][$i],
                    "MOV_TYPE"=>"ZI3",
                    "MOV_TYPE_CNL"=>"ZI1",
                    "GM_CODE"=>"05",
                    "GM_CODE_CNL"=>"03",
                    ));
       }

        $count_detail = $count;

        $data_wo_details_paket = $this->m_wo->wo_detail_paket_selectdata($data['id_wo_header']);
        if($data_wo_details_paket !== FALSE) {
            $i = 1;
            foreach ($data_wo_details_paket->result_array() as $object['temp']) {
            	foreach($object['temp'] as $key => $value) {
            		$data_wo_detail_paket[$key][$i] = $value;
            	}
            	$i++;
            	unset($object['temp']);
            }
        }

       $count = count($data_wo_detail_paket['material_no']);
       for ($i=1;$i<=$count;$i++) {
            if(!empty($data_wo_detail_paket['quantity'][$i])) {
              $item = $this->m_general->sap_item_select_by_item_code($data_wo_detail_paket['material_no'][$i]);
              if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)||(empty($item['UNIT']))) {
                  $data_wo_detail_paket['uom'][$i] = $data_wo_detail_paket['uom'][$i];
              } else {
                  $data_wo_detail_paket['uom'][$i] = $item['MEINS'];
              }
              $this->m_saprfc->append ("I_MATERIAL_IN",
                array (
                      "ITEM_NO"=>$count_detail+$i,
                      "MATNR"=>$data_wo_detail_paket['material_no'][$i],
                      "QUANTITY"=>$data_wo_detail_paket['quantity'][$i],
                      "UNIT"=>$data_wo_detail_paket['uom'][$i],
                      "MOV_TYPE"=>"ZI1",
                      "MOV_TYPE_CNL"=>"ZI3",
                      "GM_CODE"=>"03",
                      "GM_CODE_CNL"=>"05",
                      ));
            }
       }

/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";

       echo "<pre>";
       print_r($data_wo_detail_paket);
       echo "</pre>";

       exit;
*/

       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $DOC_YEAR_GI = $this->m_saprfc->export("DOC_YEAR_GI");
       $DOC_CREATED_GI = $this->m_saprfc->export("DOC_CREATED_GI");
       $DOC_YEAR_GR = $this->m_saprfc->export("DOC_YEAR_GR");
       $DOC_CREATED_GR = $this->m_saprfc->export("DOC_CREATED_GR");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_MATERIAL_IN = $this->m_saprfc->fetch_rows("I_MATERIAL_IN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if(($ERRORX=='X')||(empty($DOC_CREATED_GI))||(empty($DOC_CREATED_GR))) {
         $count = count($I_MATERIAL_IN);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'CNCL_FLAG : "X" <br> '.
           'ORDER_NO : '.$data['internal_order'].' <br> '.
           'STORAGE_LOC : '.$data['storage_location'].' <br> '.
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
           'UNIT :'.$I_MATERIAL_IN[$i]['UNIT'].' <br> '.
           'MOV_TYPE :'.$I_MATERIAL_IN[$i]['MOV_TYPE'].' <br> '.
           'MOV_TYPE_CNL :'.$I_MATERIAL_IN[$i]['MOV_TYPE_CNL'].' <br> '.
           'GM_CODE :'.$I_MATERIAL_IN[$i]['GM_CODE'].' <br> '.
           'GM_CODE_CNL :'.$I_MATERIAL_IN[$i]['GM_CODE_CNL'].' <br> ';
         }
       }

       $cancelled_data = array (
          "material_document" => $DOC_CREATED_GR,
          "material_document_out" => $DOC_CREATED_GI,
          "sap_messages" => $sap_messages
        );

        if($ERRORX=='X') {
          unset($cancelled_data['material_document']);
          unset($cancelled_data['material_document_out']);
        }

        return $cancelled_data;
	}

	function wo_details_select($id_wo_header) {
		$this->db->from('t_wo_detail');
		$this->db->where('id_wo_header', $id_wo_header);
		$this->db->order_by('id_wo_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	/*function wo_detail_paket_select($id_wo_header) {
		$this->db->from('t_wo_detail_paket');
		$this->db->where('id_wo_header', $id_wo_header);
		//$this->db->where('id_wo_detail',$id_wo_detail);
		$this->db->order_by('id_wo_paket_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	} */

	function wo_details_select_wo_paket($id_wo_header) {
		$this->db->from('t_wo_detail');
		$this->db->where('id_wo_header', $id_wo_header);
		$this->db->where('material_no NOT IN
                         (SELECT material_no_paket FROM t_wo_detail_paket
                          WHERE t_wo_detail.material_no = t_wo_detail_paket.material_no_paket
                          AND id_wo_header = '.$id_wo_header.')
                         ');
		$this->db->order_by('material_no');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function wo_detail_paket_select($id_wo_header) {
		$this->db->from('t_wo_detail_paket');
		$this->db->where('id_wo_header', $id_wo_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function wo_detail_paket_selectdata($id_wo_header) {
		$this->db->select('material_no,uom,quantity');
		$this->db->select_sum('quantity');
		$this->db->from('t_wo_detail_paket');
		$this->db->where('id_wo_header', $id_wo_header);
		$this->db->group_by('material_no,uom,quantity');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function wo_detail_paket_select_by_id_wo_detail($id_wo_detail) {
		$this->db->from('t_wo_detail_paket');
		$this->db->where('id_wo_detail', $id_wo_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function wo_detail_update($data) {
		$this->db->where('id_wo_detail', $data['id_wo_detail']);
		if($this->db->update('t_wo_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function wo_details_delete($id_wo_header) {
	    if($this->wo_detail_paket_delete($id_wo_header)) {
    		$this->db->where('id_wo_header', $id_wo_header);
    		if($this->db->delete('t_wo_detail'))
    			return TRUE;
    		else
    			return FALSE;
        }
	}
	
	function batch_delete($id_wo_header) {
	    if($this->wo_detail_paket_delete($id_wo_header)) {
    		$this->db->where('BaseEntry', $id_wo_header);
			$this->db->where('BaseType', 4);
    		if($this->db->delete('t_batch'))
    			return TRUE;
    		else
    			return FALSE;
        }
	}

	function wo_detail_paket_delete($id_wo_header) {
	    if ($this->wo_detail_paket_select($id_wo_header)) {
    	   $this->db->where('id_wo_header', $id_wo_header);
    	   if($this->db->delete('t_wo_detail_paket'))
    	      return TRUE;
    	   else
    	      return FALSE;
        } else
			return TRUE;
	}

	function wo_detail_paket_delete_by_id_wo_detail($id_wo_detail) {
		$this->db->where('id_wo_detail', $id_wo_detail);

		if($this->db->delete('t_wo_detail_paket'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
