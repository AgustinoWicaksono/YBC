<?php
class M_grsto extends Model {

	function M_grsto() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}

	// start of browse

	function grsto_headers_select_all() {
		$this->db->from('t_grsto_header');
		$this->db->order_by('id_grsto_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a grsto header.
	 * @return integer|false Count of result from a grsto header.
	 */
	function grsto_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grsto_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grsto_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'no_doc_gist';
					break;
				case 'd':
					$field_name_ori = 'delivery_plant';
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
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grsto_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grsto_no';
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
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'desc';
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
					$field_sort_name = 'delivery_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'delivery_plant';
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
				case 'hy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'hz':
					$field_sort_name = 'delivery_date';
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
	
	function grsto_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grsto_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grsto_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'no_doc_gist';
					break;
				case 'd':
					$field_name_ori = 'delivery_plant';
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
		
		if(!empty($back))
			$this->db->where('back', $back);
		
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grsto_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grsto_no';
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
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'desc';
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
					$field_sort_name = 'delivery_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'delivery_plant';
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
				case 'hy':
					$field_sort_name = 'back';
					$field_sort_type = 'asc';
					break;
				case 'hz':
					$field_sort_name = 'back';
					$field_sort_type = 'desc';
					break;
				case 'iy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'iz':
					$field_sort_name = 'delivery_date';
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
	
	function grsto_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grsto_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grsto_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'no_doc_gist';
					break;
				case 'd':
					$field_name_ori = 'delivery_plant';
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
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grsto_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'grsto_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'grsto_no';
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
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'no_doc_gist';
					$field_sort_type = 'desc';
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
					$field_sort_name = 'delivery_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'delivery_plant';
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
				case 'hy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'hz':
					$field_sort_name = 'delivery_date';
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

	function grsto_is_data_cancelled($id_grsto_header) {
		$this->db->from('t_grsto_detail');
		$this->db->where('id_grsto_header', $id_grsto_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function grsto_header_delete($id_grsto_header) {

		if($this->grsto_details_delete($id_grsto_header)) {

			$this->db->where('id_grsto_header', $id_grsto_header);

			if($this->db->delete('t_grsto_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	function sap_po_select_all($kd_plant="",$po_no="",$po_item="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
		
		$db_sap=$this->m_general->sap_db();
		$dba=$db_sap[0]['name'];
		$dbpass=$db_sap[0]['password'];
		$dbu=$db_sap[0]['user'];
		$dbh=$db_sap[0]['host'];
		//echo '{'.$dba;
//        $kd_plant = "B002";
        /*$this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_DISP_DELV_OUTS");
        $this->m_saprfc->importParameter(array ("PO_ITEM","PO_NUMBER","OUTLET"),
                                                array ($po_item,$po_no,$kd_plant));
        $this->m_saprfc->setInitTable("PO_STO_OUTS");
        $this->m_saprfc->executeSAP();
        $PO_STO_OUTS = $this->m_saprfc->fetch_rows("PO_STO_OUTS");
        $this->m_saprfc->free();
        $this->m_saprfc->close();*/
		$c=sqlsrv_connect($dbh, array( "Database"=>$dba, "UID"=>$dbu, "PWD"=>$dbpass ));
		
		$SAPquery1="select U_TransFor  from OWHS where  WhsCode = '$kd_plant'";
		$CON1=sqlsrv_query($c,$SAPquery1);
		$CON2=sqlsrv_fetch_array($CON1);
		$plant=$CON2['U_TransFor'];
		sqlsrv_close($c);
		
		$this->db->query('SET @num=0');
		$this->db->select('po_no EBELN, gistonew_out_no  MBLNR, plant SUPPL_PLANT, STOR_LOC_NAME SPLANT_NAME, posting_date DELIV_DATE,
                          DISPO, id_gistonew_out_h_detail EBELP, MATNR, MAKTX, (gr_quantity-receipt) BSTMG, uom BSTME,(@num := @num + 1) as NUMBER');
  	    $this->db->from('t_gistonew_out_header');
		$this->db->join('t_gistonew_out_detail','t_gistonew_out_detail.id_gistonew_out_header = t_gistonew_out_header.id_gistonew_out_header','inner');
		$this->db->join('m_item','m_item.MATNR = t_gistonew_out_detail.material_no','inner');
		$this->db->join('m_outlet','m_outlet.outlet = t_gistonew_out_header.plant','inner');
		$this->db->where('receiving_plant',$plant);
  	    $this->db->where('status',2);
     	$this->db->where('po_no != ""');
		$this->db->where('gistonew_out_no != ""');
		$this->db->where('gistonew_out_no != "C"');
		$this->db->where('(gr_quantity-receipt) > 0');
		$this->db->where('close = 0');
     $this->db->where('plant != "05WHST"');
		//$this->db->where('po_no NOT IN (SELECT po_no FROM t_grsto_header)');
 	    $query = $this->db->get();

  	    if($query->num_rows() > 0) {
        //if (count($PO_STO_OUTS) > 0) {
          $PO_STO_OUTS = $query->result_array();
          $count = count($PO_STO_OUTS)-1;
          for ($i=0;$i<=$count;$i++) {
            $poitems[$i+1] = $PO_STO_OUTS[$i];
          }

          return $poitems;
        } else {
          return FALSE;
        }
	}

	function sap_grsto_header_select_by_po_no($po_no) {
        if (empty($this->session->userdata['po_nos'])) {
            $poheader = $this->sap_po_select_all("",$po_no);
        } else {
            $po_nos = $this->session->userdata['po_nos'];
            $count = count($po_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($po_nos[$i]['EBELN']==$po_no){
                $poheader[1] = $po_nos[$i];
                break;
              }
            }
        }

        if (count($poheader) > 0) {
          return $poheader[1];
        }
        else {
          unset($poitems);
          return FALSE;
        }
	}

	function sap_grsto_details_select_by_po_no($po_no) {
        if (empty($this->session->userdata['po_nos'])) {
            $poitems = $this->sap_po_select_all("",$po_no);
        } else {
            $po_nos = $this->session->userdata['po_nos'];
            $k = 1;
            $count = count($po_nos);
            //echo "<pre>";
            //print_r($po_nos);
            //echo "</pre>";
            for ($i=1;$i<=$count;$i++) {
              if ($po_nos[$i]['EBELN']==$po_no){
                $poitems[$k] = $po_nos[$i];
                $k++;
              }
            }
        }
            //echo "<pre>";
            //print_r($poitems);
            //echo "</pre>";

        $count = count($poitems);
        if ($count > 0) {
          for($i=1;$i<=$count;$i++) {
            $poitems[$i]['id_grsto_h_detail'] = $i;
          }
          return $poitems;
        }
        else {
          unset($poitems);
          return FALSE;
        }
	}

	function sap_grsto_details_select_by_po_and_item($po_no,$item) {
        if (empty($this->session->userdata['po_nos'])) {
            $poitem = $this->sap_po_select_all("",$po_no,$item);
        } else {
            $po_nos = $this->session->userdata['po_nos'];
            $count = count($po_nos);
            for ($i=1;$i<=$count;$i++) {
              if(($po_nos[$i]['EBELN']==$po_no)&&($po_nos[$i]['EBELP']==$item)){
                $poitem[1] = $po_nos[$i];
                break;
              }
            }
        }

        if (count($poitem) > 0) {
          return $poitem[1];
        }
        else {
          return FALSE;
        }
	}

	function sap_grsto_select_item_group_po($po_no) {
        $poitems = $this->sap_grsto_details_select_by_po_no($po_no);
        $item_groups = $this->m_general->sap_item_groups_select_all();
        $count = count($item_groups);
        $count_po = count($poitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          for($j=1;$j<=$count_po;$j++) {
            if ($poitems[$j]['DISPO']==$item_groups[$i]['DISPO']){
              $item_groups_filter[$k] = $item_groups[$i]['DSNAM'];
              $k++;
              break;
            }
          }
        }
        if (count($item_groups_filter) > 0) {
          $item_groups_filter = array_unique($item_groups_filter);
          return $item_groups_filter;
        }
        else {
          return FALSE;
        }
	}

	function sap_grsto_details_select_by_po_and_item_group($po_no,$item_group_code) {
        $poitems = $this->sap_grsto_details_select_by_po_no($po_no);
        $count = count($poitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($poitems[$i]['DISPO']==$item_group_code){
            $poitem[$k] = $poitems[$i];
            $k++;
          }
        }
        if (count($poitem) > 0) {
          return $poitem;
        }
        else {
          return FALSE;
        }
	}

	function sap_grsto_details_select_by_po_and_item_code($po_no,$item_code) {
        $poitems = $this->sap_grsto_details_select_by_po_no($po_no);
        $count = count($poitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($poitems[$i]['MATNR']==$item_code){
            $poitem = $poitems[$i];
            break;
          }
          $k++;
        }
        if (count($poitem) > 0) {
          return $poitem;
        }
        else {
          return FALSE;
        }
	}

	function sap_grsto_detail_select_by_id_grsto_h_detail($id_grsto_h_detail) {

		$this->db->from('wiwid_s_grsto_detail');
		$this->db->where('id_grsto_h_detail', $id_grsto_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_grsto_plant_new_select($id_outlet,$posting_date="",$id_grsto_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grsto_plant');
		$this->db->from('t_grsto_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grsto_header)) {
    	  $this->db->where('id_grsto_header <> ', $id_grsto_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$grsto = $query->row_array();
			$id_grsto_outlet = $grsto['id_grsto_plant'] + 1;
		}	else {
			$id_grsto_outlet = 1;
		}

		return $id_grsto_outlet;
	}

    function grsto_header_insert($data) {
		if($this->db->insert('t_grsto_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grsto_header_approve($data) {
    //        echo "<pre>";
//            print_r($data);
//            echo "</pre>";
//            exit;

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GR_TRNSFO");
       $this->m_saprfc->importParameter(array ("GI_PO_DOCUMENT",
                                               "OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['po_no'],
                                             $data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['gr_quantity'][$i])&&($data['gr_quantity'][$i]>0))
            $this->m_saprfc->append ("I_ITEM",
              array ("ITEM_NO"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "GR_QNTY"=>$data['gr_quantity'][$i],
                    "GR_UOM"=>$data['uom'][$i],
                    "REC_PLANT"=>$data['plant'],
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
           'GI_PO_DOCUMENT : '.$data['po_no'].' <br> '.
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

	function sap_grsto_header_cancel($data) {
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
                                             $data['grsto_no'],
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
           'MATERIALDOCUMENT : '.$data['grsto_no'].' <br> '.
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

	function grsto_header_update($data) {
		$this->db->where('id_grsto_header', $data['id_grsto_header']);
		if($this->db->update('t_grsto_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grsto_detail_insert($data) {
		if($this->db->insert('t_grsto_detail', $data))
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
	function batch_master($data) {
		if($this->db->insert('m_batch', $data))
			return TRUE;
		else
			return FALSE;
	}

	function sap_grsto_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function grsto_header_select($id_grsto_header) {
		$this->db->from('t_grsto_header');
		$this->db->where('id_grsto_header', $id_grsto_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function grsto_details_select($id_grsto_header) {
		$this->db->from('t_grsto_detail');
		$this->db->where('id_grsto_header', $id_grsto_header);
		$this->db->order_by('id_grsto_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function grsto_detail_update($data) {
		$this->db->where('id_grsto_detail', $data['id_grsto_detail']);
		if($this->db->update('t_grsto_detail', $data))
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

	function grsto_details_delete($id_grsto_header) {
		$this->db->where('id_grsto_header', $id_grsto_header);
		if($this->db->delete('t_grsto_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function grsto_detail_delete($id_grsto_detail) {
		$this->db->where('id_grsto_detail', $id_grsto_detail);
		if($this->db->delete('t_grsto_detail'))
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
