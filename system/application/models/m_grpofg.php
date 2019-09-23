<?php
class M_grpofg extends Model {

	function M_grpofg() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}

	// start of browse

	function grpofg_headers_select_all() {
		$this->db->from('t_grpofg_header');
		$this->db->order_by('id_grpofg_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a grpofg header.
	 * @return integer|false Count of result from a grpofg header.
	 */
	function grpofg_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grpofg_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
					break;
				case 'b':
					$field_name_ori = 'grfg_no';
					break;
				case 'c':
					$field_name_ori = 'do_no';
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
					$field_sort_name = 'id_grpofg_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grpofg_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'do_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'do_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'grfg_no';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'grfg_no';
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
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'gz':
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

	function grpofg_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_grpofg_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'grpo_no';
					break;
				case 'b':
					$field_name_ori = 'grfg_no';
					break;
				case 'c':
					$field_name_ori = 'do_no';
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
					$field_sort_name = 'id_grpofg_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_grpofg_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'do_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'do_no';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'grpo_no';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'grfg_no';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'grfg_no';
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
					$field_sort_name = 'status';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'status';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'gz':
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

	function grpofg_select_to_export($id_grpofg_header) {
		$this->db->from('v_grpofg_export');
		$this->db->where_in('id_grpofg_header', $id_grpofg_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function grpofg_is_data_cancelled($id_grpofg_header) {
		$this->db->from('t_grpofg_detail');
		$this->db->where('id_grpofg_header', $id_grpofg_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function grpofg_header_delete($id_grpofg_header) {

		if($this->grpofg_details_delete($id_grpofg_header)) {

			$this->db->where('id_grpofg_header', $id_grpofg_header);

			if($this->db->delete('t_grpofg_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	function sap_do_select_all($kd_plant="",$do_no="",$do_item="") {

	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_DISP_DELV_OUTS");
        $this->m_saprfc->importParameter(array ("DELV_ITEM","DELV_NUMBER","OUTLET",),
                                                array ($do_item,$do_no,$kd_plant));
        $this->m_saprfc->setInitTable("DELV_OUTS");
        $this->m_saprfc->executeSAP();
        $DELV_OUTS = $this->m_saprfc->fetch_rows("DELV_OUTS");
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        $item_ck = $this->grpofg_map_item_ck_pos_select();
        $count = count($DELV_OUTS);
        $j = 1;
    	for ($i=1;$i<=$count;$i++) {
    	  if (in_array($DELV_OUTS[$i]['MATNR'],$item_ck)) {
            $DELV_OUT[$j++] = $DELV_OUTS[$i];
    	  }
    	}
        if (count($DELV_OUT) > 0) {
          return $DELV_OUT;
        } else {
          return FALSE;
        }
/*
		$this->db->select('VBELN,POSNR,MATNR,MAKTX,(LFIMG-LFIMG_APRVD) AS LFIMG,VRKME,MATKL,DISPO,LGORT,MBLNR,UNIT,UNIT_STEXT,DELIV_DATE');
		$this->db->from('ZMM_BAPI_DISP_DELV_OUTS');
		$this->db->where('PLANT',$kd_plant);
		$this->db->order_by('VBELN');
		$this->db->order_by('MATNR');
		$this->db->order_by('POSNR');
		if(!empty($do_no)) {
			$this->db->where('VBELN',$do_no);
		}
		if(!empty($do_item)) {
			$this->db->where('POSNR',$do_item);
		}
		if(empty($do_no)&&empty($do_item)) {
			$this->db->where('(LFIMG-LFIMG_APRVD) > 0');
		}
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$dos = $query->result_array();
			$count = count($dos);
			$k = 1;
			for ($i=0;$i<=$count-1;$i++) {
				$do[$k] = $dos[$i];
				$k++;
			}
			return $do;
		} else {
			return FALSE;
		}
*/

	}

	function sap_grpofg_header_select_by_do_no($do_no) {

        if (empty($this->session->userdata['do_nos'])) {
            $doheader = $this->sap_do_select_all("",$do_no);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($do_nos[$i]['VBELN']==$do_no){
                $doheader[1] = $do_nos[$i];
                break;
              }
            }
        }

        if (count($doheader) > 0) {
          return $doheader[1];
        }
        else {
          unset($doitems);
          return FALSE;
        }
	}

	function sap_grpofg_details_select_by_do_no($do_no) {
        if (empty($this->session->userdata['do_nos'])) {
            $doitems = $this->sap_do_select_all("",$do_no);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $k = 1;
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($do_nos[$i]['VBELN']==$do_no){
                $doitems[$k] = $do_nos[$i];
                $k++;
              }
            }
        }

        $count = count($doitems);
        if ($count > 0) {
          for($i=1;$i<=$count;$i++) {
            $doitems[$i]['id_grpofg_h_detail'] = $i;
          }
          return $doitems;
        }
        else {
          unset($doitems);
          return FALSE;
        }
	}

	function sap_grpofg_details_select_by_do_and_item($do_no,$item) {
        if (empty($this->session->userdata['do_nos'])) {
            $doitem = $this->sap_do_select_all("",$do_no,$item);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $k = 1;
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if(($do_nos[$i]['VBELN']==$do_no)&&($do_nos[$i]['POSNR']==$item)){
                $doitem[1] = $do_nos[$i];
                break;
              }
            }
        }

        if (count($doitem) > 0) {
          return $doitem[1];
        }
        else {
          return FALSE;
        }
	}

	function sap_grpofg_select_item_group_do($do_no) {
        $doitems = $this->sap_grpofg_details_select_by_do_no($do_no);
        $item_groups = $this->m_general->sap_item_groups_select_all();
        $count = count($item_groups);
        $count_do = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          for($j=1;$j<=$count_do;$j++) {
            if ($doitems[$j]['DISPO']==$item_groups[$i]['DISPO']){
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

	function sap_grpofg_details_select_by_do_and_item_group($do_no,$item_group_code) {
        $doitems = $this->sap_grpofg_details_select_by_do_no($do_no);
        $count = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($doitems[$i]['DISPO']==$item_group_code){
            $doitem[$k] = $doitems[$i];
            $k++;
          }
        }
        if (count($doitem) > 0) {
          return $doitem;
          echo "<pre>";
          print_r($doitem);
          echo "</pre>";
        }
        else {
          return FALSE;
        }
	}

	function sap_grpofg_details_select_by_do_and_item_code($do_no,$item_code) {
        $doitems = $this->sap_grpofg_details_select_by_do_no($do_no);
        $count = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($doitems[$i]['MATNR']==$item_code){
            $doitem = $doitems[$i];
            break;
          }
          $k++;
        }
        if (count($doitem) > 0) {
          return $doitem;
        }
        else {
          return FALSE;
        }
	}

	function sap_grpofg_detail_select_by_id_grpofg_h_detail($id_grpofg_h_detail) {

		$this->db->from('wiwid_s_grpofg_detail');
		$this->db->where('id_grpofg_h_detail', $id_grpofg_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_grpofg_plant_new_select($id_outlet,$posting_date="",$id_grpofg_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grpofg_plant');
		$this->db->from('t_grpofg_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grpofg_header)) {
    	  $this->db->where('id_grpofg_header <> ', $id_grpofg_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$grpofg = $query->row_array();
			$id_grpofg_outlet = $grpofg['id_grpofg_plant'] + 1;
		}	else {
			$id_grpofg_outlet = 1;
		}

		return $id_grpofg_outlet;
	}

    function grpofg_header_insert($data) {
		if($this->db->insert('t_grpofg_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grpofg_header_approve($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GR_POSTO");
       $this->m_saprfc->importParameter(array ("DELIVERYDOCUMENT",
                                               "OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['do_no'],
                                             $data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_PO_STO");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['gr_quantity'][$i])) {
            $uom = trim($data['uom'][$i]);
            $this->m_saprfc->append ("I_PO_STO",
              array ("DELV_NMR"=>$data['do_no'],
                    "ITEM_NMR"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "STGE_LOC"=>$data['item_storage_location'][$i],
                    "GR_QNTY"=>$data['gr_quantity'][$i],
                    "GR_UOM"=>$uom));
         }
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $MATDOCUMENTYEAR = $this->m_saprfc->export("MATDOCUMENTYEAR");
       $MATERIALDOCUMENT = $this->m_saprfc->export("MATERIALDOCUMENT");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_PO_STO = $this->m_saprfc->fetch_rows("I_PO_STO");
       $this->m_saprfc->free();
       $this->m_saprfc->close();
       $count = count($I_RETURN);
       $sap_messages = '';
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }

       if($ERRORX=='X') {
         $count = count($I_PO_STO);
         $sap_messages = $sap_messages.
           '<br> -------------------------------------- <br> '.
           'Parameter Input yang dimasukkan : <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'DELIVERYDOCUMENT : '.$data['do_no'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'DELV_NMR :'.$I_PO_STO[$i]['DELV_NMR'].' <br> '.
           'ITEM_NMR :'.$I_PO_STO[$i]['ITEM_NMR'].' <br> '.
           'MATNR :'.$I_PO_STO[$i]['MATNR'].' <br> '.
           'STGE_LOC :'.$I_PO_STO[$i]['STGE_LOC'].' <br> '.
           'GR_QNTY :'.$I_PO_STO[$i]['GR_QNTY'].' <br> '.
           'GR_UOM :'.$I_PO_STO[$i]['GR_UOM'].' <br> ';
         }
       }

        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        } /*else {
           $count = count($I_PO_STO);
           for($i=1;$i<=$count;$i++) {
             $this->grpofg_db_update($I_PO_STO[$i]['DELV_NMR'],$I_PO_STO[$i]['ITEM_NMR'],$I_PO_STO[$i]['GR_QNTY'],'+');
           }

		}*/

        return $approved_data;
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
                                             $data['web_trans_fg_id'],
                                             )
                                      );
       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_MATERIAL_IN");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['grfg_quantity'][$i])) {
            $uom = trim($data['uom_fg'][$i]);
            $this->m_saprfc->append ("I_MATERIAL_IN",
              array ("ITEM_NO"=>$data['item'][$i],
                    "MATNR"=>$data['material_no_pos'][$i],
                    "QUANTITY"=>$data['grfg_quantity'][$i],
                    "UNIT"=>$uom,
                    ));
          }
       }

       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->setInitTable("I_MATERIAL_OUT");
       $this->m_saprfc->executeSAP();
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $DOC_YEAR = $this->m_saprfc->export("DOC_YEAR");
       $DOC_CREATED = $this->m_saprfc->export("DOC_CREATED");
       $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
       $I_MATERIAL_OUT = $this->m_saprfc->fetch_rows("I_MATERIAL_OUT");
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
          "material_document" => $DOC_CREATED,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE'],
        );

        if($ERRORX=='X') {
          unset($approved_data['material_document']);
        }

        return $approved_data;
	}

	function grpofg_db_update($vblen,$posnr,$qty,$oprd) {
	    if(!empty($qty)) {
          $kd_plant = $this->session->userdata['ADMIN']['plant'];
    	  $this->db->where('PLANT', $kd_plant);
    	  $this->db->where('VBELN', $vblen);
    	  $this->db->where('POSNR', $posnr);
    	  $this->db->set('LFIMG_APRVD','LFIMG_APRVD'.$oprd.$qty,FALSE);
    	  if($this->db->update('ZMM_BAPI_DISP_DELV_OUTS')) {
    			return TRUE;
    	  } else {
    			return FALSE;
           }
        } else
   			return FALSE;
	}

	function sap_grpofg_header_cancel($data) {
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
           'MATERIALDOCUMENT : '.$data['grpofg_no'].' <br> '.
           'OUTLET : '.$data['plant'].' <br> '.
           'POSTING_DATE : '.$data['posting_date'].' <br> '.
           'WEB_LOGIN_ID : '.$data['id_user_input'].' <br> '.
           'WEB_TRANSID : '.$data['web_trans_id'].' <br> ';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.
           '-------------------------------------- <br> '.
           'MATDOC_ITEM :'.$MATDOC_ITEM[$i]['MATDOC_ITEM'].' <br> ';
         }
       } else /*{
           $count = count($MATDOC_ITEM);
           for($i=1;$i<=$count;$i++) {
             $this->grpofg_db_update($data['do_no'],$data['item'][$i],$data['gr_quantity'][$i],'-');
           }
	   }*/

       $cancelled_data = array (
          "material_document" => $GOODSMVT_HEADRET['MAT_DOC'],
          "sap_messages" => $sap_messages
        );


        return $cancelled_data;
	}

	function grpofg_header_update($data) {
		$this->db->where('id_grpofg_header', $data['id_grpofg_header']);
		if($this->db->update('t_grpofg_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grpofg_detail_insert($data) {
		if($this->db->insert('t_grpofg_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_grpofg_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function grpofg_header_select($id_grpofg_header) {
		$this->db->from('t_grpofg_header');
		$this->db->where('id_grpofg_header', $id_grpofg_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function grpofg_details_select($id_grpofg_header) {
		$this->db->from('t_grpofg_detail');
		$this->db->where('id_grpofg_header', $id_grpofg_header);
		$this->db->order_by('id_grpofg_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function grpofg_map_item_ck_pos_select($material_no_ck="") {
		$this->db->select('material_no_pos,material_no_ck');
		$this->db->from('m_map_item_ck_pos');
        if(!empty($material_no_ck))
		  $this->db->where('material_no_ck', $material_no_ck);
		$this->db->order_by('material_no_ck');

		$query = $this->db->get();

		if($query->num_rows() > 0)
            if(!empty($material_no_ck))
    		  return $query->row_array();
            else {
              $items_ck = $query->result_array();
			  foreach ($items_ck as $item_ck) {
                $items[] = $item_ck['material_no_ck'];
			  }
    		  return $items;
            }
		else
			return FALSE;
	}

	function grpofg_map_item_ck_pos_select_uom($material_no_ck,$material_no_pos) {
		$this->db->select('uom_pos');
		$this->db->from('m_map_item_ck_pos');
		$this->db->where('material_no_ck', $material_no_ck);
		$this->db->where('material_no_pos', $material_no_pos);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function grpofg_detail_update($data) {
		$this->db->where('id_grpofg_detail', $data['id_grpofg_detail']);
		if($this->db->update('t_grpofg_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function grpofg_details_delete($id_grpofg_header) {
		$this->db->where('id_grpofg_header', $id_grpofg_header);
		if($this->db->delete('t_grpofg_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function grpofg_detail_delete($id_grpofg_detail) {
		$this->db->where('id_grpofg_detail', $id_grpofg_detail);
		if($this->db->delete('t_grpofg_detail'))
			return TRUE;
		else
			return FALSE;
	}


	function posto_lastupdate() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('postoout_lastupdate');
	  	$this->db->from('t_statusgetdataposto');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
 	  	$status = $query->row_array();
      $last_posto_update = $status["postoout_lastupdate"];
      if (empty($last_posto_update))
        return "Data tidak ditemukan.";
      else {
        return "Data per <b>".date("d M Y - H:i:s")." WIB</b> (REALTIME DATA)";
//        return "Data per <b>".date("d M Y - H:i:s",strtotime($last_posto_update))." WIB</b>";
      }
    }
    
	function is_posto_ref_btn_can_show() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('postoout_lastupdate');
	  	$this->db->from('t_statusgetdataposto');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
 	  	$status = $query->row_array();
      $last_posto_update = $status["postoout_lastupdate"];
      if (empty($last_posto_update))
        return TRUE;
      else {
        if ($this->l_general->dateDiff(date("Y-m-d H:i:s"),$last_posto_update) >= 2)
            return TRUE;
        else
            return FALSE;
      }
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

