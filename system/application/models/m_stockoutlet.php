<?php
class M_stockoutlet extends Model {

	function M_stockoutlet() {
		parent::Model();
		$this->load->model('m_saprfc');
	}

	// start of browse

	function stockoutlet_headers_select_all() {
		$this->db->from('t_stockoutlet_header');
		$this->db->order_by('id_stockoutlet_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a stockoutlet header.
	 * @return integer|false Count of result from a stockoutlet header.
	 */
	function stockoutlet_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_stockoutlet_header');

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
					$field_sort_name = 'id_stockoutlet_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_stockoutlet_header';
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
	
	function stockoutlet_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_stockoutlet_header');

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
					$field_sort_name = 'id_stockoutlet_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_stockoutlet_header';
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
	
	function stockoutlet_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_stockoutlet_header');

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
					$field_sort_name = 'id_stockoutlet_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_stockoutlet_header';
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

	function sap_stockoutlet_item_select_all() {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->select('m_item.MATNR,MTART,BISMT,MEINS,MAKTX,MAKTG,MATKL,UNIT,UNIT_STEXT');
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_item');
		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
      	$this->db->where('transtype', 'stockoutlet');
		$this->db->where('m_mapping_item.kdplant',$kd_plant);
      	$this->db->order_by('m_item.MATNR');
		$this->db->group_by('m_item.MATNR,MTART,BISMT,MEINS,MAKTX,MAKTG,MATKL,UNIT,UNIT_STEXT');
		$query = $this->db->get();
		// echo $this->db->last_query();

		if($query->num_rows() > 0) {
          $MATERIAL_DATA = $query->result_array();
        }
        $count = count($MATERIAL_DATA);
        if ($count > 0) {
          for($i=0;$i<=$count-1;$i++) {
            $MATERIAL_DATA[$i]['id_stockoutlet_h_detail'] = $i+1;
            $item[$i+1] = $MATERIAL_DATA[$i];
          }
          return $item;
        }
        else {
          unset($MATERIAL_DATA);
          return FALSE;
        }
	}

	function sap_stockoutlet_item_select_filter($mtart,$sobsl) {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->select('MATNR,MEINS');
//		$this->db->distinct();
		$this->db->from('ZMM_BAPI_LIST_MATERIAL_ALL');
		$this->db->where('WERKS',$kd_plant);
		$this->db->where('MTART',$mtart);
		$this->db->where('SOBSL',$sobsl);
      	$this->db->order_by('MATNR');
		$query = $this->db->get();

		if($query->num_rows() > 0) {
          $MATERIAL_DATA = $query->result_array();
//		  echo "<pre>";
//		  print_r($MATERIAL_DATA);
//		  echo "</pre><hr/>";
        }
        $count = count($MATERIAL_DATA);
        if ($count > 0) {
          for($i=0;$i<=$count-1;$i++) {
            $item[$i]['material_no'] = $MATERIAL_DATA[$i]['MATNR'];
            $item[$i]['quantity'] = '0.0000';
            $item[$i]['waste'] = '0.0000';
            $item[$i]['uom'] = $MATERIAL_DATA[$i]['MEINS'];
          }
          return $item;
        }
        else {
          unset($MATERIAL_DATA);
          return FALSE;
        }
	}

	function sap_stockoutlet_item_select_edited_item($id_stockoutlet_header) {
	    $stockoutlet_details = $this->stockoutlet_details_select_result_array($id_stockoutlet_header);
        $count = count($stockoutlet_details);

        for ($i=0;$i<=$count-1;$i++) {
           $stockoutlet_details[$i]['MATNR'] = $stockoutlet_details[$i]['material_no'];
           $stockoutlet_details[$i]['MAKTX'] = $stockoutlet_details[$i]['material_desc'];
           $stockoutlet_details[$i]['MEINS'] = $stockoutlet_details[$i]['uom'];
        }
        if ($count > 0) {
          return $stockoutlet_details;
        }
        else {
          return FALSE;
        }
	}

	function sap_stockoutlet_item_select_by_item_group($item_group_code) {

	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
        if ($item_group_code=='Item Opname Daily') {
          $periode = date('Y-m',strtotime($this->m_general->posting_date_select_max()));
        }
		//echo '{'.$periode.'}';

		$this->db->select('m_item.MATNR,MTART,BISMT,MEINS,MAKTX,MAKTG,MATKL,UNIT,UNIT_STEXT,DistNumber num');
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_item');
		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO AND m_item_group.kdplant = m_mapping_item.kdplant','inner');
        if ($item_group_code=='Item Opname Daily') {
 		  $this->db->join('m_opnd_detail','m_opnd_detail.material_no = m_item.MATNR','inner');
 		  $this->db->join('m_opnd_header','m_opnd_header.id_opnd_header = m_opnd_detail.id_opnd_header AND m_opnd_header.plant = "'.$kd_plant.'"','inner');
		  $this->db->join('m_batch','m_item.MATNR = m_batch.ItemCode AND m_batch.Whs = m_opnd_header.plant  ','left');
        }
      	$this->db->where('transtype','stockoutlet');
		$this->db->where('m_mapping_item.kdplant',$kd_plant);
        if ($item_group_code!='Item Opname Daily') {
          $this->db->where('m_item.DISPO',$item_group_code);
        } else {
          /*$this->db->where('m_opnd_header.periode IN
                          (SELECT MAX(periode) FROM m_opnd_header A
                           WHERE A.plant = m_opnd_header.plant AND A.periode <= "'.$periode.'")');*/
		$this->db->where('m_batch.Whs',$kd_plant);
        }
		$this->db->group_by('m_item.MATNR,MTART,BISMT,MEINS,MAKTX,MAKTG,MATKL,UNIT,UNIT_STEXT,DistNumber');

		$query = $this->db->get();
		if($query->num_rows() > 0) {
          $item = $query->result_array();
        }

        $count = count($item);
        if ($count > 0) {
          for($i=0;$i<=$count-1;$i++) {
            $item[$i]['id_stockoutlet_h_detail'] = $i+1;
            $item1[$i+1] = $item[$i];
          }
          return $item1;
        }
        else {
          unset($item);
          return FALSE;
        }
	}
	
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
		else
			return FALSE;
	}

function batch_delete($id_stockoutlet_header) {
		$this->db->where('BaseEntry', $id_stockoutlet_header);
		$this->db->where('BaseType', 6);
		if($this->db->delete('t_batch'))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_header_delete($id_stockoutlet_header) {

		if($this->stockoutlet_details_delete($id_stockoutlet_header)) {

			$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);

			if($this->db->delete('t_stockoutlet_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input


	function id_stockoutlet_plant_new_select($id_outlet,$posting_date="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();

		$this->db->select_max('id_stockoutlet_plant');
		$this->db->from('t_stockoutlet_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$stockoutlet = $query->row_array();
			$id_stockoutlet_outlet = $stockoutlet['id_stockoutlet_plant'] + 1;
		}	else {
			$id_stockoutlet_outlet = 1;
		}

		return $id_stockoutlet_outlet;
	}

	function stockoutlet_header_insert($data) {
		if($this->db->insert('t_stockoutlet_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_stockoutlet_header_approve($data) {
		return TRUE; // for testing purpose only
	}

	function stockoutlet_header_update($data) {
		$this->db->where('id_stockoutlet_header', $data['id_stockoutlet_header']);
		if($this->db->update('t_stockoutlet_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_detail_insert($data) {
		if($this->db->insert('t_stockoutlet_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_insert($data) {
		if($this->db->insert('t_stockoutlet_detail_bom', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_stockoutlet_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function stockoutlet_header_select_id_by_posting_date($posting_date) {

        $posting_date = date('Y-m-d',strtotime($posting_date));

		$this->db->from('t_stockoutlet_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
            $stockoutlet =  $query->row_array();
            $id_stockoutlet_outlet = $stockoutlet['id_stockoutlet_header'];
			return $id_stockoutlet_outlet;
		} else {
			return FALSE;
        }
	}

	function stockoutlet_header_select_id_by_date_status_approve($posting_date) {

        $posting_date = date('Y-m-d',strtotime($posting_date));

		$this->db->from('t_stockoutlet_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('status', 2);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
        }
	}

	function stockoutlet_header_select($id_stockoutlet_header) {
		$this->db->from('t_stockoutlet_header');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function stockoutlet_select_to_export($id_stockoutlet_header) {
		$this->db->from('v_stockoutlet_export');
		$this->db->where_in('id_stockoutlet_header', $id_stockoutlet_header);

		$query = $this->db->get();
		
		//echo $this->db->last_query();die('#');

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stockoutlet_detail_select_qty_by_date_and_material_no($posting_date) {

        $posting_date = date('Y-m-d',strtotime($this->l_general->str_to_date($posting_date)));
		$this->db->select('material_no, qty_gso, qty_gss, quantity');
		$this->db->from('t_stockoutlet_detail');
		$this->db->join('t_stockoutlet_header','t_stockoutlet_header.id_stockoutlet_header = t_stockoutlet_detail.id_stockoutlet_header','inner');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('quantity >', 0);
		$this->db->group_by('material_no, qty_gso, qty_gss, quantity');

		$query = $this->db->get();
		if($query->num_rows() > 0) {
		    $itemsall = $query->result_array();
  			foreach ($itemsall as $item) {
  			   $items['qty_gso'][$item['material_no']] = $item['qty_gso'];
  			   $items['qty_gss'][$item['material_no']] = $item['qty_gss'];
  			   $items['quantity'][$item['material_no']] = $item['quantity'];
  			}
			return $items;
		} else {
			return FALSE;
        }
	}

	function stockoutlet_details_select($id_stockoutlet_header) {
		$this->db->from('t_stockoutlet_detail');
		//$this->db->join('m_batch','');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
		$this->db->order_by('material_no');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stockoutlet_details_select_wo_sfg($id_stockoutlet_header) {
		$this->db->from('t_stockoutlet_detail');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
		$this->db->where('material_no NOT IN
                         (SELECT material_no_sfg FROM t_stockoutlet_detail_bom
                          WHERE t_stockoutlet_detail.material_no = t_stockoutlet_detail_bom.material_no_sfg
                          AND id_stockoutlet_header = '.$id_stockoutlet_header.')
                         ');
		$this->db->order_by('material_no');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_select($id_stockoutlet_header) {
		$this->db->from('t_stockoutlet_detail_bom');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_selectdata($id_stockoutlet_header) {
		$this->db->select('material_no,uom');
		$this->db->select_sum('quantity');
		$this->db->from('v_stockoutlet_bom');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
		$this->db->group_by('material_no,uom');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stockoutlet_waste_detail_bom_selectdata($id_stockoutlet_header,$id_waste_header,$posinc_posting_date) {
		$swbplant = $this->session->userdata['ADMIN']['plant'];
		$tglakhirposting = $posinc_posting_date;
		$rangetglawal=strtotime($posinc_posting_date);
		$rangetglakhir=strtotime($posinc_posting_date);
		$periode = date('Y-m',strtotime($posinc_posting_date));
		
		if ((date('N',strtotime($tglakhirposting))==7) || (date("Y-m-t",strtotime($tglakhirposting))==date('Y-m-d',strtotime($tglakhirposting)))) {
		//WEEKLY / MONTHLY OPNAME
			for ($i = 1; $i <= 7; $i++) {
				$tanggalposting = strtotime($tglakhirposting.' -'.$i.' day');
				//echo "DATE=".date('Y-m-d',$tanggalposting)."<hr>";
				if ((date('N',$tanggalposting)==7) || (date("Y-m-t",$tanggalposting)==date('Y-m-d',$tanggalposting))) {
					break;
				} else {
					$rangetglawal=$tanggalposting;
				}
			}
			
//			 if ($swbplant=='J037') echo date('Y-m-d',$rangetglawal)."<hr>";
//			 if ($swbplant=='J037') echo date('Y-m-d',$rangetglakhir)."<hr>";
			
			//tanggalposting adalah yang terakhir mundur berupa weekly/monthly
			
			if ($rangetglawal!=$rangetglakhir){
				$swbquery1 = "SELECT id_waste_header FROM `t_waste_header` WHERE (`posting_date`>='".date('Y-m-d',$rangetglawal)."' AND `posting_date`<'".date('Y-m-d',$rangetglakhir)."' AND `plant`='".$swbplant."' AND `status`=2) OR (`posting_date`='".date('Y-m-d',$rangetglakhir)."' AND `plant`='".$swbplant."' );";
				
				
// if ($swbplant=='J117')		echo $swbquery1."<hr>";


				$query1 = $this->db->query($swbquery1);


				if($query1->num_rows() > 0)
					$rangetgl = $query1->result_array();
				else
					$rangetgl = FALSE;
			} else $rangetgl = FALSE;
			
			$waste_id_list = "";
			$sqlwaste_id = "";
			$sqlwaste_id_bom = "";
			
			if ($rangetgl!=FALSE){
				foreach ($rangetgl as $rangetglvalue) {
					$waste_id_list .= $rangetglvalue["id_waste_header"].",";
					
				}
				$waste_id_list .= "#";
				$waste_id_list = str_replace(",#","",$waste_id_list);
			}

			if ($waste_id_list!=""){
				$sqlwaste_id= " (`t_waste_detail`.`id_waste_header` IN (".$waste_id_list.")) ";


				$sqlwaste_id_bom= " (`t_waste_detail_bom`.`id_waste_header` IN (".$waste_id_list.")) ";

//				$sqlwaste_id_bom= "`t_waste_detail_bom`.`id_waste_header` IN (".$waste_id_list.") ";
			} else {
				$sqlwaste_id= "`t_waste_detail`.`id_waste_header` = ".$id_waste_header." ";
				$sqlwaste_id_bom= "`t_waste_detail_bom`.`id_waste_header` = ".$id_waste_header." ";
			}
		
//			$swbquery = "select `material_no`,`uom`,sum(`quantity`) as `quantity`,sum(`waste`) as `waste` from `v_stockoutlet_waste_bom` where (`id_opname`=".$id_stockoutlet_header." or `id_waste`=".$id_waste_header.") group by `material_no`,`uom`;";

			$swbquery = "select `material_no`, `uom`, sum(quantity) as quantity, sum(waste) as waste from (select `material_no`, `uom`, sum(quantity) as quantity, 0 as waste from (select `t_stockoutlet_detail`.`id_stockoutlet_header` AS `id_stockoutlet_header`, `t_stockoutlet_detail`.`material_no` AS `material_no`, `t_stockoutlet_detail`.`uom` AS `uom`, sum(`t_stockoutlet_detail`.`quantity`) AS `quantity` from `t_stockoutlet_detail` where (not(`t_stockoutlet_detail`.`id_stockoutlet_detail` in (select `t_stockoutlet_detail_bom`.`id_stockoutlet_detail` AS `id_stockoutlet_detail` from `t_stockoutlet_detail_bom` where ((`t_stockoutlet_detail_bom`.`id_stockoutlet_header` = `t_stockoutlet_detail`.`id_stockoutlet_header`) and (`t_stockoutlet_detail_bom`.`id_stockoutlet_detail` = `t_stockoutlet_detail`.`id_stockoutlet_detail`))))) and `t_stockoutlet_detail`.`id_stockoutlet_header` = ".$id_stockoutlet_header." group by `t_stockoutlet_detail`.`id_stockoutlet_header`,`t_stockoutlet_detail`.`material_no`,`t_stockoutlet_detail`.`uom` union select `t_stockoutlet_detail_bom`.`id_stockoutlet_header` AS `id_stockoutlet_header`, `t_stockoutlet_detail_bom`.`material_no` AS `material_no`,`t_stockoutlet_detail_bom`.`uom` AS `uom`,sum(`t_stockoutlet_detail_bom`.`quantity`) AS `quantity` from `t_stockoutlet_detail_bom` where `t_stockoutlet_detail_bom`.`id_stockoutlet_header` = ".$id_stockoutlet_header." group by `t_stockoutlet_detail_bom`.`id_stockoutlet_header`, `t_stockoutlet_detail_bom`.`material_no`, `t_stockoutlet_detail_bom`.`uom`) as t1 group by `material_no`, `uom` union select `material_no`, `uom`, 0 as quantity, sum(quantity) as waste from (select `t_waste_detail`.`id_waste_header` AS `id_waste_header`, `t_waste_detail`.`material_no` AS `material_no`, `t_waste_detail`.`uom` AS `uom`, sum(`t_waste_detail`.`quantity`) AS `quantity` from `t_waste_detail` where (not(`t_waste_detail`.`id_waste_detail` in (select `t_waste_detail_bom`.`id_waste_detail` AS `id_waste_detail` from `t_waste_detail_bom` where ((`t_waste_detail_bom`.`id_waste_header` = `t_waste_detail`.`id_waste_header`) and (`t_waste_detail_bom`.`id_waste_detail` = `t_waste_detail`.`id_waste_detail`))))) and ".$sqlwaste_id." group by `t_waste_detail`.`id_waste_header`,`t_waste_detail`.`material_no`,`t_waste_detail`.`uom` union select `t_waste_detail_bom`.`id_waste_header` AS `id_waste_header`, `t_waste_detail_bom`.`material_no` AS `material_no`,`t_waste_detail_bom`.`uom` AS `uom`,sum(`t_waste_detail_bom`.`quantity`) AS `quantity` from `t_waste_detail_bom` where ".$sqlwaste_id_bom." group by `t_waste_detail_bom`.`id_waste_header`, `t_waste_detail_bom`.`material_no`, `t_waste_detail_bom`.`uom`) as t1 group by `material_no`, `uom`) as t0 group by `material_no`, `uom`;";
			
// if ($swbplant=='J117')			die($swbquery);
		} else {
		//DAILY OPNAME

//			$swbquery = "select `material_no`,`uom`,sum(`quantity`) as `quantity`,sum(`waste`) as `waste` from `v_stockoutlet_waste_bom` where (`id_opname`=".$id_stockoutlet_header." or `id_waste`=".$id_waste_header.") and `material_no` in (select `material_no` from `v_opnd` where `plant`='".$swbplant."' and `periode`=(select `periode` from `m_opnd_header` where `plant`='".$swbplant."' and `periode`<='".$periode."' order by `periode` desc limit 0,1)) group by `material_no`,`uom`;";
			
			
			$swbquery = "select `material_no`, `uom`, sum(quantity) as quantity, sum(waste) as waste from (select `material_no`, `uom`, sum(quantity) as quantity, 0 as waste from (select `t_stockoutlet_detail`.`id_stockoutlet_header` AS `id_stockoutlet_header`, `t_stockoutlet_detail`.`material_no` AS `material_no`, `t_stockoutlet_detail`.`uom` AS `uom`, sum(`t_stockoutlet_detail`.`quantity`) AS `quantity` from `t_stockoutlet_detail` where (not(`t_stockoutlet_detail`.`id_stockoutlet_detail` in (select `t_stockoutlet_detail_bom`.`id_stockoutlet_detail` AS `id_stockoutlet_detail` from `t_stockoutlet_detail_bom` where ((`t_stockoutlet_detail_bom`.`id_stockoutlet_header` = `t_stockoutlet_detail`.`id_stockoutlet_header`) and (`t_stockoutlet_detail_bom`.`id_stockoutlet_detail` = `t_stockoutlet_detail`.`id_stockoutlet_detail`))))) and `t_stockoutlet_detail`.`id_stockoutlet_header` = ".$id_stockoutlet_header." and `material_no` in (select `material_no` from `v_opnd` where `plant`='".$swbplant."' and `periode`=(select `periode` from `m_opnd_header` where `plant`='".$swbplant."' and `periode`<='".$periode."' order by `periode` desc limit 0,1)) group by `t_stockoutlet_detail`.`id_stockoutlet_header`,`t_stockoutlet_detail`.`material_no`,`t_stockoutlet_detail`.`uom` union select `t_stockoutlet_detail_bom`.`id_stockoutlet_header` AS `id_stockoutlet_header`, `t_stockoutlet_detail_bom`.`material_no` AS `material_no`,`t_stockoutlet_detail_bom`.`uom` AS `uom`,sum(`t_stockoutlet_detail_bom`.`quantity`) AS `quantity` from `t_stockoutlet_detail_bom` where `t_stockoutlet_detail_bom`.`id_stockoutlet_header` = ".$id_stockoutlet_header." and `material_no` in (select `material_no` from `v_opnd` where `plant`='".$swbplant."' and `periode`=(select `periode` from `m_opnd_header` where `plant`='".$swbplant."' and `periode`<='".$periode."' order by `periode` desc limit 0,1)) group by `t_stockoutlet_detail_bom`.`id_stockoutlet_header`, `t_stockoutlet_detail_bom`.`material_no`, `t_stockoutlet_detail_bom`.`uom`) as t1 group by `material_no`, `uom`) as t0 group by `material_no`, `uom`;";
			
		}
		
		$query = $this->db->query($swbquery);


		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_select_by_id_stockoutlet_detail($id_stockoutlet_detail) {
		$this->db->from('t_stockoutlet_detail_bom');
		$this->db->where('id_stockoutlet_detail', $id_stockoutlet_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_details_select_result_array($id_stockoutlet_header) {
     	$this->db->select('t_stockoutlet_detail.*');
     	$this->db->select('(REPLACE(material_no,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('t_stockoutlet_detail');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
		$this->db->order_by('material_no');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function stockoutlet_detail_selectmax_id_stockoutlet_h_detail($id_stockoutlet_header) {
		$this->db->select_max('id_stockoutlet_h_detail');
		$this->db->from('t_stockoutlet_detail');
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
            $stockoutlet =  $query->row_array();
            $id_stockoutlet_h_detail = $stockoutlet['id_stockoutlet_h_detail'];
			return $id_stockoutlet_h_detail;
		} else {
			return 0;
        }
	}

	function stockoutlet_detail_update($data) {
		$this->db->where('id_stockoutlet_detail', $data['id_stockoutlet_detail']);
		if($this->db->update('t_stockoutlet_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_update($data) {
		$this->db->where('id_stockoutlet_bom_detail', $data['id_stockoutlet_bom_detail']);
		if($this->db->update('t_stockoutlet_detail_bom', $data))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_details_delete($id_stockoutlet_header) {
	    if($this->stockoutlet_detail_bom_delete($id_stockoutlet_header)) {
    		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
    		if($this->db->delete('t_stockoutlet_detail'))
    			return TRUE;
    		else
    			return FALSE;
        }
	}

	function stockoutlet_detail_bom_delete($id_stockoutlet_header) {
	    if ($this->stockoutlet_detail_bom_select($id_stockoutlet_header)) {
    	   $this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
    	   if($this->db->delete('t_stockoutlet_detail_bom'))
    	      return TRUE;
    	   else
    	      return FALSE;
        } else
			return TRUE;
	}

	function stockoutlet_detail_bom_delete_by_id_stockoutlet_detail($id_stockoutlet_detail) {
		$this->db->where('id_stockoutlet_detail', $id_stockoutlet_detail);

		if($this->db->delete('t_stockoutlet_detail_bom'))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_detail_bom_delete_by_material_no($id_stockoutlet_header,$material_no_sfg) {
		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
  		$this->db->where_in('material_no_sfg', $material_no_sfg);

		if($this->db->delete('t_stockoutlet_detail_bom'))
			return TRUE;
		else
			return FALSE;
	}

	function stockoutlet_details_delete_by_material_no($id_stockoutlet_header,$material_no) {
  		$this->db->where('id_stockoutlet_header', $id_stockoutlet_header);
  		$this->db->where_in('material_no', $material_no);
  		if($this->db->delete('t_stockoutlet_detail'))
  			return TRUE;
  		else
  			return FALSE;
	}


}
