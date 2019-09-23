<?php
class M_trend_utility extends Model {

	function M_trend_utility() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	/**
	 * Get how many result from a trend_utility header.
	 * @return integer|false Count of result from a trend_utility header.
	 */
	function trend_utility_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_trend_utility_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'trend_utility_no';
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
					$field_sort_name = 'id_trend_utility_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_trend_utility_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'kwh_awal';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'kwh_awal';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'kwh_akhir';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'kwh_akhir';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'kwh_total';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'kwh_total';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'jam_pencatatan';
					$field_sort_type = 'asc';
					break;
			    case 'fz':
					$field_sort_name = 'jam_pencatatan';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
			    case 'gz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
			    case 'hz':
					$field_sort_name = 'trend_utility_no';
					$field_sort_type = 'asc';
					break;
			    case 'hy':
					$field_sort_name = 'trend_utility_no';
					$field_sort_type = 'desc';
					break;
			    case 'iz':
					$field_sort_name = 'material_docno_cancellation';
					$field_sort_type = 'asc';
					break;
			    case 'iy':
					$field_sort_name = 'material_docno_cancellation';
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

	function trend_utility_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_trend_utility_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'trend_utility_no';
					break;

			}


	//		if($field_type == 'part')
	//			$this->db->like($field_name_ori, $field_content);
	//		else if($field_type == 'all')
	//			$this->db->where($field_name_ori, $field_content);

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
					$field_sort_name = 'id_trend_utility_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_trend_utility_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'kwh_awal';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'kwh_awal';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'kwh_akhir';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'kwh_akhir';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'kwh_total';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'kwh_total';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'jam_pencatatan';
					$field_sort_type = 'asc';
					break;
			    case 'fz':
					$field_sort_name = 'jam_pencatatan';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
			    case 'gz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
			    case 'hz':
					$field_sort_name = 'trend_utility_no';
					$field_sort_type = 'asc';
					break;
			    case 'hy':
					$field_sort_name = 'trend_utility_no';
					$field_sort_type = 'desc';
					break;
			    case 'iz':
					$field_sort_name = 'material_docno_cancellation';
					$field_sort_type = 'asc';
					break;
			    case 'iy':
					$field_sort_name = 'material_docno_cancellation';
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

	function trend_utility_header_delete($id_trend_utility_header) {
    	$this->db->where('id_trend_utility_header', $id_trend_utility_header);
    	if($this->db->delete('t_trend_utility_header'))
    		return TRUE;
    	else
    		return FALSE;
	}

	function trend_utilitys_select_all() {
		$this->db->from('t_trend_utility_header');
		$this->db->order_by('id_trend_utility_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function trend_utility_header_select($id) {
		$this->db->from('t_trend_utility_header');
		$this->db->order_by('id_trend_utility_header');
		$this->db->where('id_trend_utility_header', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function trend_utility_select_kwh_akhir() {
        $posting_date = date('Y-m-d');

		$this->db->select('kwh_akhir');
		$this->db->from('t_trend_utility_header');
		$this->db->where('DATE(posting_date) <=', $posting_date);
		$this->db->order_by('posting_date DESC, id_trend_utility_header DESC');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function sap_trend_utility_header_approve($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_TREND_UTILITY_KWH");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['plant'],
                                             date('Ymd',strtotime($data['posting_date'])),
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $this->m_saprfc->setInitTable("I_UTILITY_DETAIL");
       $this->m_saprfc->append ("I_UTILITY_DETAIL",
        array ("BUZEI"=>1,
              "SMEBTR"=>$data['kwh_akhir'][$i],
              "REC_TIME"=>date('Hs'),
              "MEINH"=>"KWH",
              ));
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $SKF_DOC = $this->m_saprfc->export("SKF_DOC");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_UTILITY_DETAIL = $this->m_saprfc->fetch_rows("I_UTILITY_DETAIL");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       if ($I_RETURN[1]['TYPE'] !== 'S') {
          unset($SKF_DOC);
       };
         $count = count($I_RETURN);
         $sap_messages = '';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
         }

       if($ERRORX=='X') {
         $count = count($I_UTILITY_DETAIL);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.date('Ymd',strtotime($data['posting_date'])).' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'BUZEI :'.$I_UTILITY_DETAIL[$i]['BUZEI'].' <br> '.
           'SMEBTR :'.$I_UTILITY_DETAIL[$i]['SMEBTR'].' <br> '.
           'REC_TIME :'.$I_UTILITY_DETAIL[$i]['REC_TIME'].' <br> '.
           'MEINH :'.$I_UTILITY_DETAIL[$i]['MEINH'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" =>$SKF_DOC,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

       return $approved_data;
	}

	function sap_trend_utility_header_cancel($data) {
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_TREND_UTILITY_KWH_CNC");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                             "SKF_DOC",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['trend_utility_no'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $SKF_DOC_REV = $this->m_saprfc->export("SKF_DOC_REV");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if (empty($SKF_DOC_REV)) {
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'SKF_DOC : '.$data['trend_utility_no'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
       }

       $cancelled_data = array (
          "material_document" => $SKF_DOC_REV,
          "sap_messages" => $sap_messages
        );

        return $cancelled_data;
	}

	function id_trend_utility_plant_new_select($id_outlet,$posting_date="",$id_trend_utility_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_trend_utility_plant');
		$this->db->from('t_trend_utility_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_trend_utility_header)) {
    	  $this->db->where('id_trend_utility_header <> ', $id_trend_utility_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$trend_utility = $query->row_array();
			$id_trend_utility_outlet = $trend_utility['id_trend_utility_plant'] + 1;
		}	else {
			$id_trend_utility_outlet = 1;
		}

		return $id_trend_utility_outlet;
	}

	function trend_utility_add($data) {
		if($this->db->insert('t_trend_utility_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function trend_utility_update($data) {
		$this->db->where('id_trend_utility_header', $data['id_trend_utility_header']);
		if($this->db->update('t_trend_utility_header', $data))
			return TRUE;
		else
			return FALSE;
	}

}
