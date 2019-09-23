<?php
class M_retin extends Model {


	function M_retin() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_general');
		
	}
	
	public function __construct()
 	{
  		parent::__construct();
		
		$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$dba=$db_sap[0]['name'];
        $this->db2 = $this->load->database($dba, TRUE);
	}
	

	// start of browse

	function retin_headers_select_all() {
		$this->db->from('t_retin_header');
		$this->db->order_by('id_retin_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function retin_headers_count_by_criteria1() {
		$this->db->from('t_retin_header');
		$this->db->where('status',1);
		$this->db->order_by('id_retin_header');
		

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return  $query->num_rows();
		else
			return FALSE;
	}

	/**
	 * Get how many result from a retin header.
	 * @return integer|false Count of result from a retin header.
	 */
	function retin_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_retin_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'do_no';
					break;
				case 'b':
					$field_name_ori = 'retin_no';
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
					$field_sort_name = 'id_retin_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_retin_header';
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
					$field_sort_name = 'retin_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'retin_no';
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
				case 'fy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'fz':
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
	
	function retin_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_retin_header');

		// start of searching

		if(!empty($field_content)) {
			switch($field_name) {
				case 'a':
					$field_name_ori = 'do_no';
					break;
				case 'b':
					$field_name_ori = 'retin_no';
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
					$field_sort_name = 'id_retin_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_retin_header';
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
					$field_sort_name = 'retin_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'retin_no';
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
				case 'fy':
					$field_sort_name = 'back';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'back';
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

	function retin_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_retin_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'do_no';
					break;
				case 'b':
					$field_name_ori = 'retin_no';
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
					$field_sort_name = 'id_retin_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_retin_header';
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
					$field_sort_name = 'retin_no';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'retin_no';
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
				case 'fy':
					$field_sort_name = 'delivery_date';
					$field_sort_type = 'asc';
					break;
				case 'fz':
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

	function retin_is_data_cancelled($id_retin_header) {
		$this->db->from('t_retin_detail');
		$this->db->where('id_retin_header', $id_retin_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function retin_header_delete($id_retin_header) {

		if($this->retin_details_delete($id_retin_header)) {

			$this->db->where('id_retin_header', $id_retin_header);

			if($this->db->delete('t_retin_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input

	public function sap_do_select_all($kd_plant="",$do_no="",$do_item="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
		
		$db_sap=$this->m_general->sap_db();
		$dba=$db_sap[0]['name'];
		$dbpass=$db_sap[0]['password'];
		$dbu=$db_sap[0]['user'];
		$dbh=$db_sap[0]['host'];

		$c=sqlsrv_connect($dbh, array( "Database"=>$dba, "UID"=>$dbu, "PWD"=>$dbpass ));
		//$b=mssql_select_db('Test_MSI',$c);
	
		$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		$CON=sqlsrv_query($c,$SAPquery);
		$CON1=sqlsrv_fetch_array($CON);
		$U_StrLoc=$CON1['U_StrLoc'];
		$SAPquery1="select U_TransFor from OWHS where  WhsCode = '$kd_plant'";
		$CON1=sqlsrv_query($c,$SAPquery1);
		$CON2=sqlsrv_fetch_array($CON1);
		$plant=$CON2['U_TransFor'];
		//echo $kd_plant.'-'.$plant;
		sqlsrv_close($c);
		
		//return $this->db2->get("OWTR");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		//{
		 $filler=Array('CW','CW1','CW2');
		 $this->db2->select('OWTR.DocEntry VBELN,OWTR.DocDate DELIV_DATE,OWTR.ToWhsCode,WTR1.LineNum POSNR,
							OITM.ItmsGrpCod DISPO,WTR1.ItemCode MATNR,Dscription MAKTX,(OpenQty-U_grqty_web) LFIMG ,unitMsr VRKME,WTR1.LineNum item, ToWhsCode PLANT, U_grqty_web');
		$this->db2->from('OWTR');
		$this->db2->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
		$this->db2->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
		//$this->db2->where_in('ToWhsCode',$kd_plant);
		$this->db2->where_in('ToWhsCode',$plant);
	//	$this->db2->where('U_StrLoc <>',$U_StrLoc);
		$this->db2->where('U_Stat <>',1);
		$this->db2->where('U_Retur =',1); 
		$this->db2->where('(OpenQty-U_grqty_web) >', 0);
		$this->db2->where('OWTR.U_Reverse','N');
		//$this->db2->where('Filler',$filler);
		//$this->db2->where(array('OWTR.U_Stat'=> NULL));
		$query = $this->db2->get();
		
		//$DELV_OUTS = $query->fetch_rows(); 
		
	if($query->num_rows() > 0) {
          $DELV_OUTS = $query->result_array();
		 $count = count($DELV_OUTS)-1;
          for ($i=0;$i<=$count;$i++) {
            $poitems[$i+1] = $DELV_OUTS[$i];
          }

          return $poitems;
          
        } else {
          return FALSE;
        } 
//}
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
	
	public function sap_do_select_all1($kd_plant="",$do_no="",$do_item="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];

       $this->db2->select('OWTR.DocEntry VBELN,OWTR.DocDate DELIV_DATE,OWTR.ToWhsCode,WTR1.LineNum POSNR,
							OITM.ItmsGrpCod DISPO,WTR1.ItemCode MATNR,Dscription MAKTX,Quantity LFIMG,unitMsr VRKME,WTR1.LineNum item');
		$this->db2->from('OWTR');
		$this->db2->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
		$this->db2->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
		$this->db2->where('Filler','CW');
		$query = $this->db2->get();
		//$DELV_OUTS = $query->fetch_rows(); 
		
	if($query->num_rows() > 0) {
          $DELV_OUTS = $query->result_array();
		 $count = count($DELV_OUTS)-1;
          for ($i=0;$i<=$count;$i++) {
            $poitems[$i+1] = $DELV_OUTS[$i];
          }

          return $poitems;
          
        } else {
          return FALSE;
        } 
}

	function retin_select_to_export($id_retin_header) {
		$this->db->from('v_retin_export');
		$this->db->where_in('id_retin_header', $id_retin_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function sap_retin_header_select_by_do_no($do_no) {

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

	function sap_retin_details_select_by_do_no($do_no) {
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
            $doitems[$i]['id_retin_h_detail'] = $i;
          }
          return $doitems;
        }
        else {
          unset($doitems);
          return FALSE;
        }
	}

	function sap_retin_details_select_by_do_and_item($do_no,$item) {
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

	function sap_retin_select_item_group_do($do_no) {
        $doitems = $this->sap_retin_details_select_by_do_no($do_no);
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

	function sap_retin_details_select_by_do_and_item_group($do_no,$item_group_code) {
        $doitems = $this->sap_retin_details_select_by_do_no($do_no);
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

	function sap_retin_details_select_by_do_and_item_code($do_no,$item_code) {
        $doitems = $this->sap_retin_details_select_by_do_no($do_no);
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

	function sap_retin_detail_select_by_id_retin_h_detail($id_retin_h_detail) {

		$this->db->from('wiwid_s_retin_detail');
		$this->db->where('id_retin_h_detail', $id_retin_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_retin_plant_new_select($id_outlet,$posting_date="",$id_retin_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_retin_plant');
		$this->db->from('t_retin_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_retin_header)) {
    	  $this->db->where('id_retin_header <> ', $id_retin_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$retin = $query->row_array();
			$id_retin_outlet = $retin['id_retin_plant'] + 1;
		}	else {
			$id_retin_outlet = 1;
		}

		return $id_retin_outlet;
	}

    function retin_header_insert($data) {
		if($this->db->insert('t_retin_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function sap_retin_header_approve($data) {
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
          if(!empty($data['gr_quantity'][$i]))
            $this->m_saprfc->append ("I_PO_STO",
              array ("DELV_NMR"=>$data['do_no'],
                    "ITEM_NMR"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "STGE_LOC"=>$data['item_storage_location'][$i],
                    "GR_QNTY"=>$data['gr_quantity'][$i],
                    "GR_UOM"=>$data['uom'][$i]));
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
        } else {
           $count = count($I_PO_STO);
           for($i=1;$i<=$count;$i++) {
             $this->retin_db_update($I_PO_STO[$i]['DELV_NMR'],$I_PO_STO[$i]['ITEM_NMR'],$I_PO_STO[$i]['GR_QNTY'],'+');
           }
		
		}

        return $approved_data;
	}

	function retin_db_update($vblen,$posnr,$qty,$oprd) {
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
	}

	function sap_retin_header_cancel($data) {
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
                                             $data['retin_no'],
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
           'MATERIALDOCUMENT : '.$data['retin_no'].' <br> '.
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
             $this->retin_db_update($data['do_no'],$data['item'][$i],$data['gr_quantity'][$i],'-');
           }
	   }

       $cancelled_data = array (
          "material_document" => $GOODSMVT_HEADRET['MAT_DOC'],
          "sap_messages" => $sap_messages
        );


        return $cancelled_data;
	}

	function retin_header_update($data) {
		$this->db->where('id_retin_header', $data['id_retin_header']);
		if($this->db->update('t_retin_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function retin_detail_insert($data) {
		if($this->db->insert('t_retin_detail', $data))
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


	function sap_retin_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function retin_header_select($id_retin_header) {
		$this->db->from('t_retin_header');
		$this->db->where('id_retin_header', $id_retin_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function retin_details_select($id_retin_header) {
		$this->db->from('t_retin_detail');
		$this->db->where('id_retin_header', $id_retin_header);
		$this->db->order_by('id_retin_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function user_delete($retin_delete) {
		if($this->db->insert('t_delete', $retin_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function retin_detail_update($data) {
		$this->db->where('id_retin_detail', $data['id_retin_detail']);
		if($this->db->update('t_retin_detail', $data))
			return TRUE;
		else
			return FALSE;
	}

	function retin_details_delete($id_retin_header) {
		$this->db->where('id_retin_header', $id_retin_header);
		if($this->db->delete('t_retin_detail'))
			return TRUE;
		else
			return FALSE;
	}

	function retin_detail_delete($id_retin_detail) {
		$this->db->where('id_retin_detail', $id_retin_detail);
		if($this->db->delete('t_retin_detail'))
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

