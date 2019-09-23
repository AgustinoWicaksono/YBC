<?php
class M_twts extends Model {

	function M_twts() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function twts_headers_select_all() {
		$this->db->from('t_twts_header');
		$this->db->order_by('id_twts_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a twts header.
	 * @return integer|false Count of result from a twts header.
	 */
	function twts_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_twts_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'gi_no';
					break;
				case 'b':
					$field_name_ori = 'gr_no';
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
					$field_sort_name = 'id_twts_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_twts_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'gi_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'gi_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'gr_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'gr_no';
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

	function twts_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_twts_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'gi_no';
					break;
				case 'b':
					$field_name_ori = 'gr_no';
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
					$field_sort_name = 'id_twts_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_twts_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'gi_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'gi_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'gr_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'gr_no';
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

	function twts_header_delete($id_twts_header) {

		if($this->twts_details_delete($id_twts_header)) {

			$this->db->where('id_twts_header', $id_twts_header);

			if($this->db->delete('t_twts_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	function id_twts_plant_new_select($id_outlet,$posting_date="",$id_twts_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_twts_plant');
		$this->db->from('t_twts_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_twts_header)) {
    	  $this->db->where('id_twts_header <> ', $id_twts_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$twts = $query->row_array();
			$id_twts_outlet = $twts['id_twts_plant'] + 1;
		}	else {
			$id_twts_outlet = 1;
		}

		return $id_twts_outlet;
	}

	function twts_header_insert($data) {
		if($this->db->insert('t_twts_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_twts_header_approve($data) {

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

       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['quantity_gr'][$i]))
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array (
                    "ITEM_NO"=>$count+$i,
                    "MATNR"=>$data['material_no_gr'][$i],
                    "QUANTITY"=>$data['quantity_gr'][$i],
                    "UNIT"=>$data['uom_gr'][$i],
                    "MOV_TYPE"=>"ZI3",
                    "MOV_TYPE_CNL"=>"ZI1",
                    "GM_CODE"=>"05",
                    "GM_CODE_CNL"=>"03",
                    ));
       }

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

       if($ERRORX=='X') {
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
          "material_document" => $DOC_CREATED_GI,
          "material_document_gr" => $DOC_CREATED_GR,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
          unset($approved_data['material_document_gr']);
        }

        return $approved_data;
	}

	function sap_twts_header_cancel($data) {
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

       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['quantity'][$i]))
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array (
                    "ITEM_NO"=>$count+$i,
                    "MATNR"=>$data['material_no_gr'][$i],
                    "QUANTITY"=>$data['quantity_gr'][$i],
                    "UNIT"=>$data['uom_gr'][$i],
                    "MOV_TYPE"=>"ZI1",
                    "MOV_TYPE_CNL"=>"ZI3",
                    "GM_CODE"=>"03",
                    "GM_CODE_CNL"=>"05",
                    ));
       }

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

       if($ERRORX=='X') {
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
          "material_document" => $DOC_YEAR_GR,
          "material_document_gr" => $DOC_CREATED_GI,
          "sap_messages" => $sap_messages
        );

        if($ERRORX=='X') {
          unset($cancelled_data['material_document']);
          unset($cancelled_data['material_document_gr']);
        }

        return $cancelled_data;
	}

	function twts_header_update($data) {
		$this->db->where('id_twts_header', $data['id_twts_header']);
		if($this->db->update('t_twts_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function twts_detail_insert($data) {
		if($this->db->insert('t_twts_detail', $data))
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
function batch_delete($id_gisto_header) {
		$this->db->where('BaseEntry', $id_gisto_header);
		$this->db->where('BaseType', 5);
		if($this->db->delete('t_batch'))
			return TRUE;
		else
			return FALSE;
	}

	// end of input

	// start of edit

	function twts_is_data_cancelled($id_twts_header) {
		$this->db->from('t_twts_detail');
		$this->db->where('id_twts_header', $id_twts_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function twts_header_select($id_twts_header) {
		$this->db->from('t_twts_header');
		$this->db->where('id_twts_header', $id_twts_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function twts_details_select($id_twts_header) {
		$this->db->from('t_twts_detail');
		$this->db->where('id_twts_header', $id_twts_header);
		$this->db->order_by('id_twts_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function twts_item_slice_select($item_whole,$item_slice="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
   		$this->db->select('material_no AS MATNR, material_desc AS MAKTX, uom AS UNIT, quantity, nama_whi');
     	$this->db->select('(REPLACE(material_no,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_mwts_detail');
		$this->db->join('m_mwts_header','m_mwts_header.id_mwts_header = m_mwts_detail.id_mwts_header','inner');
      	$this->db->where('m_mwts_header.kode_whi', $item_whole);
		$this->db->where('plant',$kd_plant);
        if(!empty($item_slice)) {
          $this->db->where('m_mwts_detail.material_no', $item_slice);
        }
		$query = $this->db->get();
		if($query->num_rows() > 0) {
            if(!empty($item_slice))
	    		return $query->row_array();
            else
	    		return $query->result_array();
		}	else {
			return FALSE;
		}
	}

	function twts_internal_order_select() {
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

	function twts_detail_update($data) {
		$this->db->where('id_twts_detail', $data['id_twts_detail']);
		if($this->db->update('t_twts_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function twts_details_delete($id_twts_header) {
		$this->db->where('id_twts_header', $id_twts_header);
		if($this->db->delete('t_twts_detail'))
			return TRUE;
		else
			return FALSE;
	}

	// end of edit


}
