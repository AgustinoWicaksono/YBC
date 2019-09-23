<?php
class M_prodstaff extends Model {

	function M_prodstaff() {
		parent::Model();
	}

	// start of browse

	function prodstaff_headers_select_all() {
		$this->db->from('t_prodstaff_header');
		$this->db->order_by('id_prodstaff_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a prodstaff header.
	 * @return integer|false Count of result from a prodstaff header.
	 */
	function prodstaff_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_prodstaff_header');

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
					$field_sort_name = 'id_prodstaff_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_prodstaff_header';
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

	function prodstaff_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_prodstaff_header');

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
					$field_sort_name = 'id_prodstaff_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_prodstaff_header';
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

	function prodstaff_header_delete($id_prodstaff_header) {

		if($this->prodstaff_details_delete($id_prodstaff_header)) {

			$this->db->where('id_prodstaff_header', $id_prodstaff_header);

			if($this->db->delete('t_prodstaff_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

 	function id_prodstaff_plant_new_select($id_outlet,$posting_date="",$id_prodstaff_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_prodstaff_plant');
		$this->db->from('t_prodstaff_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_prodstaff_header)) {
    	  $this->db->where('id_prodstaff_header <> ', $id_prodstaff_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$prodstaff = $query->row_array();
			$id_prodstaff_outlet = $prodstaff['id_prodstaff_plant'] + 1;
		}	else {
			$id_prodstaff_outlet = 1;
		}

		return $id_prodstaff_outlet;
	}

	function prodstaff_header_insert($data) {
		if($this->db->insert('t_prodstaff_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function prodstaff_detail_select_posisi_status() {
        $posisi = $this->prodstaff_detail_select_posisi();
		$this->db->from('t_status');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
            $count = count($posisi);
            $i = 1;
            for($j=1;$j<=$count;$j++) {
    			foreach ($query->result_array() as $value) {
      			   $posisi_status[$i]['id_posisi'] = $posisi[$j]['STAFF_POS_ID'];
      			   $posisi_status[$i]['posisi'] = $posisi[$j]['STAFF_POS_DESC'];
      			   $posisi_status[$i]['id_status'] = $value['id_status'];
      			   $posisi_status[$i]['status'] = $value['status'];
                   $i++;
    			}
              $i++;
            }
		};
        if (count($posisi_status) > 0)
          return $posisi_status;
        else
          return FALSE;
	}

	function prodstaff_detail_select_posisi() {
        $this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_LIST_STAFF_POS");
        $this->m_saprfc->setInitTable("STAFF_POS");
        $this->m_saprfc->executeSAP();
        $STAFF_POS = $this->m_saprfc->fetch_rows("STAFF_POS");
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        if (count($STAFF_POS) > 0) {
          return $STAFF_POS;
        } else {
          return FALSE;
        }
	}

	function prodstaff_header_update($data) {
		$this->db->where('id_prodstaff_header', $data['id_prodstaff_header']);
		if($this->db->update('t_prodstaff_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function prodstaff_detail_insert($data) {
		if($this->db->insert('t_prodstaff_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_prodstaff_header_approve($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_PRODUCTIVITY_STAFF");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['prodstaff_header']['plant'],
                                             date('Ymd',strtotime($data['prodstaff_header']['posting_date'])),
                                             $data['prodstaff_header']['id_user_input'],
                                             $data['web_trans_id'])
                                      );

       $count = count($data['prodstaff_detail']['id_prodstaff_h_detail']);
       $this->m_saprfc->setInitTable("PROD_STAFF_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if((!empty($data['prodstaff_detail']['jml_karyawan'][$i]))||(!empty($data['prodstaff_detail']['total_jam'][$i]))) {
            $this->m_saprfc->append ("PROD_STAFF_ITEM",
              array (
                    "MANDT"=>$data['prodstaff_detail']['id_prodstaff_h_detail'][$i],
                    "OUTLET"=>$data['prodstaff_header']['plant'],
                    "POST_DATE"=>date('Ymd',strtotime($data['prodstaff_header']['posting_date'])),
                    "STAFF_POS_ID"=>$data['prodstaff_detail']['id_posisi'][$i],
                    "STAFF_STATUS"=>$data['prodstaff_detail']['id_status'][$i],
                    "STAFF_COUNT"=>$data['prodstaff_detail']['jml_karyawan'][$i],
                    "STAFF_HOUR"=>$data['prodstaff_detail']['total_jam'][$i],
                    ));
           }
       }

       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $PROD_STAFF_ITEM = $this->m_saprfc->fetch_rows("PROD_STAFF_ITEM");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if($ERRORX=='X') {
         $count = count($PROD_STAFF_ITEM);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['prodstaff_header']['plant'].' <br> '.
           'POSTING_DATE : '.date('Ymd',strtotime($data['prodstaff_header']['posting_date'])).' <br> '.
           'WEB_LOGIN_ID : '.$data['prodstaff_header']['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'MANDT :'.$PROD_STAFF_ITEM[$i]['MANDT'].' <br> '.
           'OUTLET :'.$PROD_STAFF_ITEM[$i]['OUTLET'].' <br> '.
           'POST_DATE :'.$PROD_STAFF_ITEM[$i]['POST_DATE'].' <br> '.
           'STAFF_POS_ID :'.$PROD_STAFF_ITEM[$i]['STAFF_POS_ID'].' <br> '.
           'STAFF_STATUS :'.$PROD_STAFF_ITEM[$i]['STAFF_STATUS'].' <br> '.
           'STAFF_COUNT :'.$PROD_STAFF_ITEM[$i]['STAFF_COUNT'].' <br> '.
           'STAFF_HOUR :'.$PROD_STAFF_ITEM[$i]['STAFF_HOUR'].' <br> ';
         }
       }

        $approved_data = array (
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

       return $approved_data;
	}


	// end of input

	// start of edit

	function prodstaff_header_select($id_prodstaff_header) {
		$this->db->from('t_prodstaff_header');
		$this->db->where('id_prodstaff_header', $id_prodstaff_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function prodstaff_details_select($id_prodstaff_header) {
		$this->db->from('t_prodstaff_detail');
		$this->db->where('id_prodstaff_header', $id_prodstaff_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function prodstaff_details_delete($id_prodstaff_header) {
		$this->db->where('id_prodstaff_header', $id_prodstaff_header);
		if($this->db->delete('t_prodstaff_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function prodstaff_detail_update($data) {
		$this->db->where('id_prodstaff_detail', $data['id_prodstaff_detail']);
		if($this->db->update('t_prodstaff_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

    function prodstaff_detail_select_all_array() {
		$this->db->from('t_posisi');
		$this->db->order_by('id_posisi');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
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
