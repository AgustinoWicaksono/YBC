<?php
class M_grpo extends Model {

	function M_grpo() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}
	
	function user_delete($grpo_delete) {
		if($this->db->insert('t_delete', $grpo_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// start of browse

	function grpo_headers_select_all() {
		$this->db->from('t_grpo_header');
		$this->db->order_by('id_grpo_header');

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a grpo header.
	 * @return integer|false Count of result from a grpo header.
	 */
	function grpo_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grpo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'kd_vendor';
					break;
				case 'd':
					$field_name_ori = 'nm_vendor';
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
					$field_sort_name = 'id_grpo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grpo_header';
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
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'posting_date';
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

		if(($query)&&($query->num_rows() > 0)) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}
	
	function grpo_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grpo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'kd_vendor';
					break;
				case 'd':
					$field_name_ori = 'nm_vendor';
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
					$field_sort_name = 'id_grpo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grpo_header';
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
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'posting_date';
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

		if(($query)&&($query->num_rows() > 0)) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function grpo_is_data_cancelled($id_grpo_header) {
		$this->db->from('t_grpo_detail');
		$this->db->where('id_grpo_header', $id_grpo_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return TRUE;
		else
			return FALSE;
	}

	function grpo_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grpo_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'kd_vendor';
					break;
				case 'd':
					$field_name_ori = 'nm_vendor';
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
					$field_sort_name = 'id_grpo_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grpo_header';
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
					$field_sort_name = 'po_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'po_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'kd_vendor';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'nm_vendor';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'posting_date';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'status_string';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'status_string';
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
		if(($query)&&($query->num_rows() > 0)) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function grpo_header_delete($id_grpo_header) {

		if($this->grpo_details_delete($id_grpo_header)) {

			$this->db->where('id_grpo_header', $id_grpo_header);

			if($this->db->delete('t_grpo_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	function sap_vendors_select_all($kd_plant="") {
        $this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_LIST_VENDOR_OUTLET");
        $this->m_saprfc->importParameter(array ("Outlet"),array ($kd_plant));
        $this->m_saprfc->setInitTable("VENDOR_DATA");
        $this->m_saprfc->executeSAP();
        $VENDOR_DATA = $this->m_saprfc->fetch_rows("VENDOR_DATA");
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        sort($VENDOR_DATA);
        if (count($VENDOR_DATA) > 0) {
          return $VENDOR_DATA;
        } else {
          return FALSE;
        }

		/*$this->db->from('wiwid_s_vendor');
		$this->db->order_by('nm_vendor');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;*/
	}

	function sap_vendor_select_by_kd_vendor($kd_vendor) {
         $kd_plant = $this->session->userdata['ADMIN']['plant'];
         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_BAPI_DISP_VENDOR_DETAIL");
         $this->m_saprfc->importParameter(array ("VENDOR"),array ($kd_vendor));
         $this->m_saprfc->executeSAP();
         $VENDOR_DATA = $this->m_saprfc->export("VENDOR_DATA");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($VENDOR_DATA) > 0) {
          return $VENDOR_DATA;
        } else {
          return FALSE;
        }

/*		$this->db->from('wiwid_s_vendor');
		$this->db->where('kd_vendor', $kd_vendor);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
*/
	}

	function sap_vendor_select_by_nm_vendor($nm_vendor) {
        $vendors = $this->sap_vendors_select_all();
        foreach ( $vendors as $vendor ) {
           if (strcmp($vendor['NAME1'],$nm_vendor) == 0) {
             return $vendor;
           } else {
             continue;
           }
        }
/*		$this->db->from('wiwid_s_vendor');
		$this->db->where('nm_vendor', $nm_vendor);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
*/
	}

	function is_po_ref_btn_can_show() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('poout_lastupdate');
	  $this->db->from('t_statusgetdata');
	  $this->db->where('plant', $id_outlet);

	  $query = $this->db->get();
	  if (($query)&&($query->num_rows() > 0))
	  {			
 	    $status = $query->row_array();
        $last_po_update = $status["poout_lastupdate"];
	  }
      if (empty($last_po_update))
        return TRUE;
      else {
        if ($this->l_general->dateDiff(date("Y-m-d H:i:s"),$last_po_update,'MINUTE') >= 30)
            return TRUE;
        else
            return FALSE;
      }
    }
    
	function po_lastupdate() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('poout_lastupdate');
	  	$this->db->from('t_statusgetdata');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
 	  	//$status = $query->row_array();
      $last_po_update ="MSI" ;//$status["poout_lastupdate"];
	  if(($query)&&($query->num_rows() > 0)){
		  if (empty($last_po_update))
			return "Data tidak ditemukan.";
		  else {
			//return "Data per <b>".date("d M Y - H:i:s",strtotime($last_po_update))." WIB</b>";
		  }
	  } else {
		return FALSE;
	  }
    }

	function sap_grpo_headers_select_by_kd_vendor($kd_vendor="",$kd_plant="",$po_no="",$po_item="") {
       $kd_plant = $this->session->userdata['ADMIN']['plant'];
 	   $this->db->select('EBELN,EBELP,VENDOR,VENDOR_NAME,
                         MATNR,MAKTX,BSTMG,BSTME,
                         MATKL,DISPO,UNIT,UNIT_STEXT,DELIV_DATE,DOCNUM');
       /*BSTMG-(COALESCE((SELECT SUM(gr_quantity) FROM t_grpo_detail
						 JOIN t_grpo_header ON t_grpo_detail.id_grpo_header = t_grpo_header.id_grpo_header
						 where t_grpo_header.po_no  = EBELN),0)) AS */
  	   $this->db->from('zmm_bapi_disp_po_outstanding');
 	   $this->db->where('PLANT',$kd_plant);
	    $this->db->where('BSTMG >',0);
 	  // $this->db->where("DELIV_DATE >= '".date('Ymd')."'"); //.new 20120312
		$this->db->order_by('EBELN');
		$this->db->order_by('EBELP');
       if(!empty($po_no)) {
   	     $this->db->where('EBELN',$po_no);
       }
       if(!empty($po_item)) {
     	 $this->db->where('EBELP',$po_item);
       }
       if(empty($po_no)&&empty($po_item)) {
       }
	   $query = $this->db->get();
	   // echo "#".$query->num_rows()."#" ;
	   if(($query)&&($query->num_rows() > 0)) {
          $pos = $query->result_array();
          $count = count($pos);
          $k = 1;
          for ($i=0;$i<=$count-1;$i++) {
            $po[$k] = $pos[$i];
            $k++;
          }
          return $po;
		  //print_r $po;
       } else {
          return FALSE;
       }
      /*

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_DISP_PO_OUTSTANDING");
       $this->m_saprfc->importParameter(array ("OUTLET","PO_ITEM","PO_NUMBER","PO_VENDOR_FLG"),
                                      array ($kd_plant,$po_item,$po_no,"X"));
       $this->m_saprfc->setInitTable("PO_OUTS");
       $this->m_saprfc->executeSAP();
       $PO_OUTS = $this->m_saprfc->fetch_rows("PO_OUTS");
       $this->m_saprfc->free();
       $this->m_saprfc->close();

        if (count($PO_OUTS) > 0) {
         return $PO_OUTS;
        }
        else {
          return FALSE;
        }
        */
	}

	function sap_grpo_header_select_by_po_no($po_no) {
        if (empty($this->session->userdata['grpo_nos'])) {
            $poheader = $this->sap_grpo_headers_select_by_kd_vendor("","",$po_no);
        } else {
            $po_nos = $this->session->userdata['grpo_nos'];
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

	function sap_grpo_details_select_by_po_no($po_no) {
        if (empty($this->session->userdata['grpo_nos'])) {
            $poitems = $this->sap_grpo_headers_select_by_kd_vendor("","",$po_no);
        } else {
            $po_nos = $this->session->userdata['grpo_nos'];
            $k = 1;
            $count = count($po_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($po_nos[$i]['EBELN']==$po_no){
                $poitems[$k] = $po_nos[$i];
                $k++;
              }
            }
        }
        $count = count($poitems);
        if ($count > 0) {
          for($i=1;$i<=$count;$i++) {
            $poitems[$i]['id_grpo_h_detail'] = $i;
          }
          return $poitems;
        }
        else {
          unset($poitems);
          return FALSE;
        }

/*		$this->db->from('wiwid_s_grpo_detail');
		$this->db->where('po_no', $po_no);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
*/
	}

	function sap_grpo_details_select_by_po_and_item($po_no,$item) {
        if (empty($this->session->userdata['grpo_nos'])) {
            $poitem = $this->sap_grpo_headers_select_by_kd_vendor("","",$po_no,$item);
        } else {
            $po_nos = $this->session->userdata['grpo_nos'];
            $k = 1;
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

	function sap_grpo_select_item_group_po($po_no) {
        $poitems = $this->sap_grpo_details_select_by_po_no($po_no);
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

	function sap_grpo_details_select_by_po_and_item_group($po_no,$item_group_code) {
        $poitems = $this->sap_grpo_details_select_by_po_no($po_no);
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

	function sap_grpo_details_select_by_po_and_item_code($po_no,$item_code) {
        $poitems = $this->sap_grpo_details_select_by_po_no($po_no);
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

	function sap_grpo_detail_select_by_id_grpo_h_detail($id_grpo_h_detail) {

		$this->db->from('wiwid_s_grpo_detail');
		$this->db->where('id_grpo_h_detail', $id_grpo_h_detail);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_grpo_plant_new_select($id_outlet,$posting_date="",$id_grpo_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grpo_plant');
		$this->db->from('t_grpo_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grpo_header)) {
    	  $this->db->where('id_grpo_header <> ', $id_grpo_header);
        }

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			$grpo = $query->row_array();
			$id_grpo_outlet = $grpo['id_grpo_plant'] + 1;
		}	else {
			$id_grpo_outlet = 1;
		}

		return $id_grpo_outlet;
	}

    function grpo_header_insert($data) {
		if($this->db->insert('t_grpo_header', $data))
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
	
	function batch_update($data) {
		$this->db->where('BaseEntry', $data['BaseEntry']);
		$this->db->where('ItemCode', $data['ItemCode']);
		$this->db->where('BatchNum', $data['BatchNum']);
		$this->db->where('BaseLinNum', $data['BaseLinNum']);
		$this->db->where('BaseType',$data['BaseType']);
		if($this->db->update('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}

	function sap_grpo_header_approve($data) {
/*

print_r($data);
die("<hr/>Maaf sedang ada maintenance");
}
*/
/*
if ($data['plant']=='B064'){
	print_r($data);
	$cobaedo = Array();
	$count = count($data['item']);
	echo "<hr />JUMLAH DATA = ".$count.'<hr />';
	echo '<hr />';
		foreach($data['item'] as $key => $value){
          if(!empty($data['gr_quantity'][$key])&&($data['gr_quantity'][$key]>0)) {
            $cobaedo[] =  array ("PO_NO"=>$data['po_no'],
                    "ITEM_NO"=>$data['item'][$key],
                    "MATNR"=>$data['material_no'][$key],
                    "GR_QNTY"=>$data['gr_quantity'][$key],
                    "GR_UOM"=>$data['uom'][$key]);
			echo '<br />'.$i.'<hr />';		
			echo "PO_NO = ".$data['po_no'].'<hr />';
			echo "ITEM_NO = ".$data['item'][$key].'<hr />';
			echo "MATNR = ".$data['material_no'][$key].'<hr />';
			echo "GR_QNTY = ".$data['gr_quantity'][$key].'<hr />';
			echo "GR_UOM = ".$data['uom'][$key].'<hr /><br /><hr />';
			} else {
			echo '<hr />TIDAK BISA<br />'.$key.'<hr />';		
			echo "PO_NO = ".$data['po_no'].'<hr />';
			echo "ITEM_NO = ".$data['item'][$key].'<hr />';
			echo "MATNR = ".$data['material_no'][$key].'<hr />';
			echo "GR_QNTY = ".$data['gr_quantity'][$key].'<hr />';
			echo "GR_UOM = ".$data['uom'][$key].'<hr /><br /><hr />';
			}
       } 
	   
	   echo '<hr />HASIL:<br />';
	   print_r($cobaedo);
	die('<hr />Mohon maaf, ada gangguan, silahkan coba ulangi 5 menit lagi.');
}
*/

       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GR_POVNDR");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                             "POSTING_DATE",
                                             "PO_NUMBER",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['posting_date'],
                                             $data['po_no'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_PO_VENDOR");
       foreach($data['item'] as $key => $value){
          if(!empty($data['gr_quantity'][$key])&&($data['gr_quantity'][$key]>0)) {
            $this->m_saprfc->append ("I_PO_VENDOR",
              array ("PO_NO"=>$data['po_no'],
                    "ITEM_NO"=>$data['item'][$key],
                    "MATNR"=>$data['material_no'][$key],
                    "GR_QNTY"=>$data['gr_quantity'][$key],
                    "GR_UOM"=>$data['uom'][$key]));
			}
		}
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $MATDOCUMENTYEAR = $this->m_saprfc->export("MATDOCUMENTYEAR");
       $MATERIALDOCUMENT = $this->m_saprfc->export("MATERIALDOCUMENT");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_PO_VENDOR = $this->m_saprfc->fetch_rows("I_PO_VENDOR");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }
       if($ERRORX=='X') {
         $count = count($I_PO_VENDOR);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'PO_NUMBER : '.$data['po_no'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'PO_NO :'.$I_PO_VENDOR[$i]['PO_NO'].' <br> '.
           'ITEM_NO :'.$I_PO_VENDOR[$i]['ITEM_NO'].' <br> '.
           'MATNR :'.$I_PO_VENDOR[$i]['MATNR'].' <br> '.
           'GR_QNTY :'.$I_PO_VENDOR[$i]['GR_QNTY'].' <br> '.
           'GR_UOM :'.$I_PO_VENDOR[$i]['GR_UOM'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
           unset($approved_data['material_document']);
        } else {
           $count = count($I_PO_VENDOR);
           for($i=1;$i<=$count;$i++) {
             $this->sap_po_outstanding_update($I_PO_VENDOR[$i]['PO_NO'],$I_PO_VENDOR[$i]['ITEM_NO'],$I_PO_VENDOR[$i]['GR_QNTY'],'+');
           }
        }

        return $approved_data;
	}

	function sap_po_outstanding_update($po_no,$po_item,$qty,$oprd) {
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->where('PLANT', $kd_plant);
		$this->db->where('EBELN', $po_no);
		$this->db->where('EBELP', $po_item);
		$this->db->set('BSTMG_APRVD','BSTMG_APRVD'.$oprd.$qty,FALSE);
		if($this->db->update('ZMM_BAPI_DISP_PO_OUTSTANDING')) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function sap_grpo_header_cancel($data) {
	/*print_r($data);
	die('<hr />Coba ulangi lagi');
	*/
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
                                             $data['grpo_no'],
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
           'MATERIALDOCUMENT : '.$data['grpo_no'].' <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'MATDOC_ITEM :'.$MATDOC_ITEM[$i]['MATDOC_ITEM'].' <br> ';
         }
       } else {
         $count = count($MATDOC_ITEM);
         for($i=1;$i<=$count;$i++) {
             $this->sap_po_outstanding_update($data['po_no'],$data['item_po'][$i],$data['gr_quantity'][$i],'-');
         }
       }

       $cancelled_data = array (
          "material_document" => $GOODSMVT_HEADRET['MAT_DOC'],
          "sap_messages" => $sap_messages
        );

        return $cancelled_data;
	}

	function grpo_header_update($data) {
		$this->db->where('id_grpo_header', $data['id_grpo_header']);
		if($this->db->update('t_grpo_header', $data))
			return TRUE;
		else
			return FALSE;
	}


	function grpo_detail_insert($data) {
		if($this->db->insert('t_grpo_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grpo_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function grpo_header_select($id_grpo_header) {
		$this->db->from('t_grpo_header');
		$this->db->where('id_grpo_header', $id_grpo_header);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query->row_array();
		else
			return FALSE;
	}

	function grpo_details_select($id_grpo_header) {
		$this->db->from('t_grpo_detail');
		$this->db->where('id_grpo_header', $id_grpo_header);
		$this->db->order_by('id_grpo_detail');

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}

	function grpo_detail_update($data) {
		$this->db->where('id_grpo_detail', $data['id_grpo_detail']);
		if($this->db->update('t_grpo_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grpo_details_delete($id_grpo_header) {
		$this->db->where('id_grpo_header', $id_grpo_header);
		if($this->db->delete('t_grpo_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function grpo_detail_delete($id_grpo_detail) {
		$this->db->where('id_grpo_detail', $id_grpo_detail);
		if($this->db->delete('t_grpo_detail'))
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
?>