<?php
class M_posinc extends Model {

	function M_posinc() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_waste');
		$this->load->model('m_stockoutlet');
		$this->load->model('m_general');
		$this->load->library('l_general');
	}

	// start of browse

	function posinc_headers_select_all() {
		$this->db->from('t_posinc_header');
		$this->db->order_by('id_posinc_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a posinc header.
	 * @return integer|false Count of result from a posinc header.
	 */
	function posinc_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_posinc_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'waste_no';
					break;
				case 'b':
					$field_name_ori = 'stockoutlet_no';
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
					$field_sort_name = 'id_posinc_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_posinc_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'total_remintance';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'total_remintance';
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
				case 'ey':
					$field_sort_name = 'waste_no';
					$field_sort_type = 'asc';
					break;
    			case 'ez':
					$field_sort_name = 'waste_no';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'stockoutlet_no';
					$field_sort_type = 'asc';
					break;
    			case 'fz':
					$field_sort_name = 'stockoutlet_no';
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

	function posinc_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_posinc_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'waste_no';
					break;
				case 'b':
					$field_name_ori = 'stockoutlet_no';
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
					$field_sort_name = 'id_posinc_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_posinc_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'total_remintance';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'total_remintance';
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
				case 'ey':
					$field_sort_name = 'waste_no';
					$field_sort_type = 'asc';
					break;
    			case 'ez':
					$field_sort_name = 'waste_no';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'stockoutlet_no';
					$field_sort_type = 'asc';
					break;
    			case 'fz':
					$field_sort_name = 'stockoutlet_no';
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

	function posinc_header_select_id_by_posting_date($posting_date) {

		$this->db->from('t_posinc_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
            $posinc =  $query->row_array();
            $id_posinc_outlet = $posinc['id_posinc_header'];
			return $id_posinc_outlet;
		} else {
			return FALSE;
        }
	}

	function posinc_header_select_other_id_by_posting_date($id_posinc_header,$posting_date) {

		$this->db->from('t_posinc_header');
		$this->db->where('DATE(posting_date)', $posting_date);
		$this->db->where('id_posinc_header <> ', $id_posinc_header);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function posinc_header_delete($id_posinc_header) {

    	$this->db->where('id_posinc_header', $id_posinc_header);

    	if($this->db->delete('t_posinc_header'))
    		return TRUE;
    	else
    		return FALSE;

	}

	// end of browse

	// start of input

	function posinc_header_select($id) {
		$this->db->from('t_posinc_header');
		$this->db->order_by('id_posinc_header');
		$this->db->where('id_posinc_header', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function id_posinc_plant_new_select($id_outlet,$posting_date="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();

		$this->db->select_max('id_posinc_plant');
		$this->db->from('t_posinc_header');
		$this->db->where('plant', $id_outlet);
   		$this->db->where('DATE(posting_date)', $posting_date);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$posinc = $query->row_array();
			$id_posinc_outlet = $posinc['id_posinc_plant'] + 1;
		}	else {
			$id_posinc_outlet = 1;
		}

		return $id_posinc_outlet;
	}


	// start of input
	function posinc_add($data) {
		if($this->db->insert('t_posinc_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function posinc_update($data) {
		$this->db->where('id_posinc_header', $data['id_posinc_header']);
		if($this->db->update('t_posinc_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function t_status_eod_update($data) {
        $posting_date = date('Y-m-d',strtotime($data['posting_date']));
		$this->db->where('posting_date', $posting_date);
		$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		if($this->db->update('t_statuseod', $data))
			return TRUE;
		else
			return FALSE;
	}


	function sap_waste_header_approve($posinc_posting_date) {

       $id_waste_header = $this->m_waste->waste_header_select_id_by_posting_date($posinc_posting_date);
       if ($id_waste_header !== FALSE) {
          $data_waste_header = $this->m_waste->waste_header_select($id_waste_header);
		  $data_waste_details_bom = $this->m_waste->waste_detail_bom_selectdata($id_waste_header);

          if($data_waste_details_bom !== FALSE) {
        		$i = 1;
        		foreach ($data_waste_details_bom->result_array() as $object['temp']) {
        			foreach($object['temp'] as $key => $value) {
        				$data_waste_detail_bom[$key][$i] = $value;
        			}
        			$i++;
        			unset($object['temp']);
        		}
          }

       }

//echo "<pre>";
//print '$data_waste_header';
//print_r($data_waste_header);
//echo "</pre>";
//echo "<pre>";
//print '$data_waste_detail';
//print_r($data_waste_detail);
//echo "</pre>";
//exit;

       if ((!empty($data_waste_header))&&(!empty($data_waste_detail_bom))) {

           $count = count($data_waste_detail_bom['material_no']);
           for ($i=1;$i<=$count;$i++) {
              $item = $this->m_general->sap_item_select_by_item_code($data_waste_detail_bom['material_no'][$i]);
              if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)||(empty($item['UNIT']))) {
                  $data_waste_detail_bom['uom'][$i] = $data_waste_detail_bom['uom'][$i];
              } else {
                  $data_waste_detail_bom['uom'][$i] = $item['MEINS'];
              }
           }
/*
echo "<pre>";
print '$data_waste_detail';
print_r($data_waste_detail);
echo "</pre>";

echo "<pre>";
print '$data_waste_detail_bom';
print_r($data_waste_detail_bom);
echo "</pre>";

$waste_reason[$i] = $this->m_waste->waste_detail_select_reason_by_id_stockoutlet_detail($data_waste_detail_bom['id_waste_detail'][$i]);
echo "<pre>";
print '$waste_reason[$i]';
print_r($waste_reason[$i]);
echo "</pre>";

exit;*/
           $this->m_saprfc->setUserRfc();
           $this->m_saprfc->setPassRfc();
           $this->m_saprfc->sapAttr();
           $this->m_saprfc->connect();
           $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GI_WASTE");
           $web_trans_id = $this->l_general->_get_web_trans_id($data_waste_header['plant'],$data_waste_header['posting_date'],
                      $data_waste_header['id_waste_plant'],'06');
           $this->m_saprfc->importParameter(array ("OUTLET",
                                                   "POSTING_DATE",
                                                   "WEB_LOGIN_ID",
                                                   "WEB_TRANSID"),
                                          array ($data_waste_header['plant'],
                                                 date('Ymd',strtotime($data_waste_header['posting_date'])),
                                                 $data_waste_header['id_user_input'],
                                                 $web_trans_id)
                                          );
//           $count = count($data_waste_detail['id_waste_h_detail']);
           $this->m_saprfc->setInitTable("I_ITEM");
           $c_bom = count($data_waste_detail_bom['material_no']);
           for ($i=1;$i<=$c_bom;$i++) {
              if(!empty($data_waste_detail_bom['quantity'][$i])) {
                $waste_reason[$i] = $this->m_waste->waste_detail_select_reason_by_material_no($id_waste_header,$data_waste_detail_bom['material_no'][$i]);
                $this->m_saprfc->append ("I_ITEM",
                  array ("ITEM_NO"=>$i,
                        "MATNR"=>$data_waste_detail_bom['material_no'][$i],
                        "QUANTITY"=>$data_waste_detail_bom['quantity'][$i],
                        "UNIT"=>$data_waste_detail_bom['uom'][$i],
                        "ITEM_TEXT"=>$waste_reason[$i]['reason'],
                        ));
               }
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
               'OUTLET : '.$data_waste_header['plant'].' <br> '.
               'POSTING_DATE : '.date('Ymd',strtotime($data_waste_header['posting_date'])).' <br> '.
               'WEB_LOGIN_ID : '.$data_waste_header['id_user_input'].' <br> '.
               'WEB_TRANSID : '.$web_trans_id.' <br> ';
             for($i=1;$i<=$count;$i++) {
               $sap_messages = $sap_messages.
               '-------------------------------------- <br> '.
               'ITEM_NO :'.$I_ITEM[$i]['ITEM_NO'].' <br> '.
               'MATNR :'.$I_ITEM[$i]['MATNR'].' <br> '.
               'QUANTITY :'.$I_ITEM[$i]['QUANTITY'].' <br> '.
               'UNIT :'.$I_ITEM[$i]['UNIT'].' <br> '.
               'ITEM_TEXT :'.$I_ITEM[$i]['ITEM_TEXT'].' <br> ';
             }
           }

            $approved_data = array (
                "material_document" => $MATERIALDOCUMENT,
                "sap_messages" => $sap_messages,
                "sap_messages_type" => $I_RETURN[1]['TYPE'],
                "id_waste_header"=>$id_waste_header
            );
            if($ERRORX=='X') {
              unset($approved_data['material_document']);
            }
        } else {
            $approved_data = array (
              "sap_messages" => 'No Waste Material Data to Approve for today, '.date('d-m-Y',strtotime($this->l_general->str_datetime_to_date($posinc_posting_date))),
            );
        }
        if (!empty($approved_data))
          return $approved_data;
        else
          return FALSE;
	}

	function sap_stockoutlet_header_approve($posinc_posting_date) {
       $id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select_id_by_posting_date($posinc_posting_date);
       if ($id_stockoutlet_header !== FALSE) {
          $data_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select($id_stockoutlet_header);
		  $data_stockoutlet_details_bom = $this->m_stockoutlet->stockoutlet_detail_bom_selectdata($id_stockoutlet_header);

          if($data_stockoutlet_details_bom !== FALSE) {
        		$i = 1;
        		foreach ($data_stockoutlet_details_bom->result_array() as $object['temp']) {
        			foreach($object['temp'] as $key => $value) {
        				$data_stockoutlet_detail_bom[$key][$i] = $value;
        			}
        			$i++;
        			unset($object['temp']);
        		}
          }

       }

       if ((!empty($data_stockoutlet_header))&&(!empty($data_stockoutlet_detail_bom))) {
           $count = count($data_stockoutlet_detail_bom['material_no']);
           for ($i=1;$i<=$count;$i++) {
              $item = $this->m_general->sap_item_select_by_item_code($data_stockoutlet_detail_bom['material_no'][$i]);
              if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)||(empty($item['UNIT']))) {
                  $data_stockoutlet_detail_bom['uom'][$i] = $data_stockoutlet_detail_bom['uom'][$i];
              } else {
                  $data_stockoutlet_detail_bom['uom'][$i] = $item['MEINS'];
              }
           }

//       echo "<pre>";
//       print_r($data_stockoutlet_detail_bom['material_no']);
//       echo "</pre>";
//       die("<hr />");

           $this->m_saprfc->setUserRfc();
           $this->m_saprfc->setPassRfc();
           $this->m_saprfc->sapAttr();
           $this->m_saprfc->connect();
           $this->m_saprfc->functionDiscover("Z_MM_BAPI_STOCK_AKHIR_N");
           $web_trans_id = $this->l_general->_get_web_trans_id($data_stockoutlet_header['plant'],$data_stockoutlet_header['posting_date'],
                      $data_stockoutlet_header['id_stockoutlet_plant'],'03');
           $this->m_saprfc->importParameter(array ("OUTLET",
                                                   "POSTING_DATE",
                                                   "WEB_LOGIN_ID",
                                                   "WEB_TRANSID"),
                                          array ($data_stockoutlet_header['plant'],
                                                 date('Ymd',strtotime($data_stockoutlet_header['posting_date'])),
                                                 $data_stockoutlet_header['id_user_input'],
                                                 $web_trans_id)
                                          );

           $this->m_saprfc->setInitTable("MATERIAL_ITEM");
           $c_bom = count($data_stockoutlet_detail_bom['material_no']);
           for ($i=1;$i<=$c_bom;$i++) {
              if(!empty($data_stockoutlet_detail_bom['quantity'][$i])) {
                $this->m_saprfc->append ("MATERIAL_ITEM",
                  array ("ITEM_NO"=>$i,
                        "MATNR"=>$data_stockoutlet_detail_bom['material_no'][$i],
                        "QUANTITY"=>$data_stockoutlet_detail_bom['quantity'][$i],
                        "UNIT"=>$data_stockoutlet_detail_bom['uom'][$i]
                        ));
               }
           }

           $this->m_saprfc->setInitTable("I_RETURN");
           $this->m_saprfc->executeSAP();
           $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
           $MATERIAL_ITEM = $this->m_saprfc->fetch_rows("MATERIAL_ITEM");

           $ERRORX = $this->m_saprfc->export("ERRORX");
           $this->m_saprfc->free();
           $this->m_saprfc->close();
           $count = count($I_RETURN);
           $sap_messages = '';
           for($i=1;$i<=$count;$i++) {
             $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
           }
           if($ERRORX=='X') {
             $count = count($MATERIAL_ITEM);
             $sap_messages = $sap_messages.
               '<br> -------------------------------------- <br> '.
               'Parameter Input yang dimasukkan : <br> '.
               'OUTLET : '.$data_stockoutlet_header['plant'].' <br> '.
               'POSTING_DATE : '.date('Ymd',strtotime($data_stockoutlet_header['posting_date'])).' <br> '.
               'WEB_LOGIN_ID : '.$data_stockoutlet_header['id_user_input'].' <br> '.
               'WEB_TRANSID : '.$web_trans_id.' <br> ';
             for($i=1;$i<=$count;$i++) {
               $sap_messages = $sap_messages.
               '-------------------------------------- <br> '.
               'ITEM_NO :'.$MATERIAL_ITEM[$i]['ITEM_NO'].' <br> '.
               'MATNR :'.$MATERIAL_ITEM[$i]['MATNR'].' <br> '.
               'QUANTITY :'.$MATERIAL_ITEM[$i]['QUANTITY'].' <br> '.
               'UNIT :'.$MATERIAL_ITEM[$i]['UNIT'].' <br> ';
             }
           }

            $approved_data = array (
              "material_document" => $web_trans_id,
              "sap_messages" => $sap_messages,
              "sap_messages_type" => $I_RETURN[1]['TYPE'],
              "id_stockoutlet_header"=>$id_stockoutlet_header
            );
            if($ERRORX=='X') {
              unset($approved_data['material_document']);
            }
        } else {
            $approved_data = array (
              "sap_messages" => 'No Stock Outlet Data to Approve for today, '.date('d-m-Y',strtotime($this->l_general->str_datetime_to_date($posinc_posting_date))),
            );
        }
        if (!empty($approved_data))
          return $approved_data;
        else
          return FALSE;
	}


	function sap_stockoutlet_waste_header_approve($posinc_posting_date) {
	
		$id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select_id_by_posting_date($posinc_posting_date);
		$id_waste_header = $this->m_waste->waste_header_select_id_by_posting_date($posinc_posting_date);
	   
		if (($id_stockoutlet_header !== FALSE) && ($id_waste_header !== FALSE)) {

		   if ($id_stockoutlet_header !== FALSE) {
			  $data_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select($id_stockoutlet_header);
			  $data_stockoutlet_details_bom = $this->m_stockoutlet->stockoutlet_waste_detail_bom_selectdata($id_stockoutlet_header,$id_waste_header,$posinc_posting_date);


			  if($data_stockoutlet_details_bom !== FALSE) {
					$i = 1;
					foreach ($data_stockoutlet_details_bom->result_array() as $object['temp']) {
						foreach($object['temp'] as $key => $value) {
							$data_stockoutlet_detail_bom[$key][$i] = $value;
						}
						$i++;
						unset($object['temp']);
					}
			  }

		   }

		   if ((!empty($data_stockoutlet_header))&&(!empty($data_stockoutlet_detail_bom))) {
			   $count = count($data_stockoutlet_detail_bom['material_no']);
			   for ($i=1;$i<=$count;$i++) {
				  $item = $this->m_general->sap_item_select_by_item_code($data_stockoutlet_detail_bom['material_no'][$i]);
				  if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)||(empty($item['UNIT']))) {
					  $data_stockoutlet_detail_bom['uom'][$i] = $data_stockoutlet_detail_bom['uom'][$i];
				  } else {
					  $data_stockoutlet_detail_bom['uom'][$i] = $item['MEINS'];
				  }
			   }

	//       echo "<pre>";
	//       print_r($data_stockoutlet_detail_bom['material_no']);
	//       echo "</pre>";
	//       exit;

				$c_bom = count($data_stockoutlet_detail_bom['material_no']);
				
				
	//new 20120301-Duma Request for JCO Only - Edward
				if ($this->session->userdata['ADMIN']['plant_type_id']=='JID'){
					$tglakhirposting = $data_stockoutlet_header['posting_date'];

					if ((date('N',strtotime($tglakhirposting))==7) || (date("Y-m-t",strtotime($tglakhirposting))==date('Y-m-d',strtotime($tglakhirposting)))) {

						$item_zfg2_1201 = $this->m_stockoutlet->sap_stockoutlet_item_select_filter('ZFG2','JZ');
						$count = count($item_zfg2_1201);
						if ($count>0) {
							for($i=0;$i<=$count-1;$i++) {
								$c_bom++;
								$data_stockoutlet_detail_bom['material_no'][$c_bom]=$item_zfg2_1201[$i]['material_no'];
								$data_stockoutlet_detail_bom['quantity'][$c_bom]=$item_zfg2_1201[$i]['quantity'];
								$data_stockoutlet_detail_bom['waste'][$c_bom]=$item_zfg2_1201[$i]['waste'];
								$data_stockoutlet_detail_bom['uom'][$c_bom]=$item_zfg2_1201[$i]['uom'];
							
							}

						}
					}
				}
	//end of new 20120301-Duma Request for JCO Only - Edward


			   $this->m_saprfc->setUserRfc();
			   $this->m_saprfc->setPassRfc();
			   $this->m_saprfc->sapAttr();
			   $this->m_saprfc->connect();
			   $this->m_saprfc->functionDiscover("Z_MM_BAPI_STOCK_AKHIR_N");
			   $web_trans_id = $this->l_general->_get_web_trans_id($data_stockoutlet_header['plant'],$data_stockoutlet_header['posting_date'],
						  $data_stockoutlet_header['id_stockoutlet_plant'],'03');
			   $this->m_saprfc->importParameter(array ("OUTLET",
													   "POSTING_DATE",
													   "WEB_LOGIN_ID",
													   "WEB_TRANSID"),
											  array ($data_stockoutlet_header['plant'],
													 date('Ymd',strtotime($data_stockoutlet_header['posting_date'])),
													 $data_stockoutlet_header['id_user_input'],
													 $web_trans_id)
											  );

			   $this->m_saprfc->setInitTable("MATERIAL_ITEM");
	/*		   
	if ($this->session->userdata['ADMIN']['plant_type_id']=='JID'){
			echo "Jumlah data=".$c_bom."<hr /><pre>";
			print_r($data_stockoutlet_detail_bom);
			echo "</pre>";
			die('<hr />');			
	}
	*/
			   
				$c_bom = count($data_stockoutlet_detail_bom['material_no']);
			   for ($i=1;$i<=$c_bom;$i++) {
				  if(!empty($data_stockoutlet_detail_bom['quantity'][$i])) {
					$this->m_saprfc->append ("MATERIAL_ITEM",
					  array ("ITEM_NO"=>$i,
							"MATNR"=>$data_stockoutlet_detail_bom['material_no'][$i],
							"QUANTITY"=>$data_stockoutlet_detail_bom['quantity'][$i],
							"WASTE"=>$data_stockoutlet_detail_bom['waste'][$i],
							"UNIT"=>$data_stockoutlet_detail_bom['uom'][$i]
							));
				   }
			   }

			   $this->m_saprfc->setInitTable("I_RETURN");
			   $this->m_saprfc->executeSAP();
			   $I_RETURN = $this->m_saprfc->fetch_rows("I_RETURN");
			   $MATERIAL_ITEM = $this->m_saprfc->fetch_rows("MATERIAL_ITEM");

			   $ERRORX = $this->m_saprfc->export("ERRORX");
			   $this->m_saprfc->free();
			   $this->m_saprfc->close();
			   $count = count($I_RETURN);
			   $sap_messages = '';
			   for($i=1;$i<=$count;$i++) {
				 $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
			   }
			   if($ERRORX=='X') {
				 $count = count($MATERIAL_ITEM);
				 $sap_messages = $sap_messages.
				   '<br> -------------------------------------- <br> '.
				   'Parameter Input yang dimasukkan : <br> '.
				   'OUTLET : '.$data_stockoutlet_header['plant'].' <br> '.
				   'POSTING_DATE : '.date('Ymd',strtotime($data_stockoutlet_header['posting_date'])).' <br> '.
				   'WEB_LOGIN_ID : '.$data_stockoutlet_header['id_user_input'].' <br> '.
				   'WEB_TRANSID : '.$web_trans_id.' <br> ';
				 for($i=1;$i<=$count;$i++) {
				   $sap_messages = $sap_messages.
				   '-------------------------------------- <br> '.
				   'ITEM_NO :'.$MATERIAL_ITEM[$i]['ITEM_NO'].' <br> '.
				   'MATNR :'.$MATERIAL_ITEM[$i]['MATNR'].' <br> '.
				   'QUANTITY :'.$MATERIAL_ITEM[$i]['QUANTITY'].' <br> '.
				   'WASTE :'.$MATERIAL_ITEM[$i]['WASTE'].' <br> '.
				   'UNIT :'.$MATERIAL_ITEM[$i]['UNIT'].' <br> ';
				 }
			   }

				$approved_data = array (
				  "material_document" => $web_trans_id,
				  "sap_messages" => $sap_messages,
				  "sap_messages_type" => $I_RETURN[1]['TYPE'],
				  "id_stockoutlet_header"=>$id_stockoutlet_header,
				  "id_waste_header"=>$id_waste_header
				);
				if($ERRORX=='X') {
				  unset($approved_data['material_document']);
				}
			} else {
				$approved_data = array (
				  "sap_messages" => 'No Stock Outlet Data to Approve for today, '.date('d-m-Y',strtotime($this->l_general->str_datetime_to_date($posinc_posting_date))),
				);
			}
		} else {
			unset($approved_data);
			$approved_incomplete = "";
			if ($id_stockoutlet_header == FALSE) $approved_incomplete .= "STOCK OPNAME";
			if ($id_waste_header == FALSE) $approved_incomplete .= "WASTE MATERIAL";
			$approved_incomplete = str_replace("OPNAMEWASTE","OPNAME dan WASTE",$approved_incomplete);
			
			$approved_data = array (
			  "sap_messages" => '<br>Anda belum memasukkan data '.$approved_incomplete.' untuk tanggal '.date('d-m-Y',strtotime($this->l_general->str_datetime_to_date($posinc_posting_date))).".<br><br>Pastikan Anda telah memasukkan baik STOCK OPNAME maupun WASTE MATERIAL terlebih dulu (keduanya wajib telah diisi).",
			);
		
		
		}
		
		if (!empty($approved_data))
		  return $approved_data;
		else
		  return FALSE;
		
	}

}
