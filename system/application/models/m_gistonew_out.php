<?php
class M_gistonew_out extends Model {

function M_gistonew_out() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_database');
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
	
	function user_delete($grpo_delete) {
		if($this->db->insert('t_delete', $grpo_delete))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	// start of browse


	function gistonew_out_headers_select_all() {
		$this->Fdb->from('t_gistonew_out_header');
		$this->db->order_by('id_gistonew_out_header');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function posto_lastupdate() {
      $id_outlet = $this->session->userdata['ADMIN']['plant'];

      $this->db->select('postoout_lastupdate');
	  	$this->db->from('t_statusgetdataposto');
	  	$this->db->where('plant', $id_outlet);

	  	$query = $this->db->get();
		if ($query) {
			$status = $query->row_array();
			$last_posto_update = $status["postoout_lastupdate"];
		}
      if (empty($last_posto_update))
        return "Data tidak ditemukan.";
      else {
        return "Data per <b>".date("d M Y - H:i:s")." WIB</b> (REALTIME DATA)";
//        return "Data per <b>".date("d M Y - H:i:s",strtotime($last_posto_update))." WIB</b>";
      }
    }
    
	
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
		//echo "{".$U_StrLoc."}";
	
		$SAPquery1="select WhsCode from OWHS where U_TransFor = '$kd_plant'";
		$CON1=sqlsrv_query($c,$SAPquery1);
		$CON2=sqlsrv_fetch_array($CON1);
		$plant=$CON2['WhsCode'];
		//return $this->db2->get("OWTQ");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		//{
		 $filler=Array('CW','CW1','CW2');
		 $this->db2->select('OWTQ.DocEntry VBELN,OWTQ.DocDate DELIV_DATE,OWTQ.ToWhsCode receiving_plant,WTQ1.LineNum POSNR,
							OITM.ItmsGrpCod DISPO,WTQ1.ItemCode MATNR,Dscription MAKTX,(OpenQty) LFIMG,unitMsr VRKME,WTQ1.LineNum item, ToWhsCode PLANT,
							(SELECT WhsName FROM OWHS WHERE U_TransFor=ToWhsCode) as ABC');
//							OITM.ItmsGrpCod DISPO,WTQ1.ItemCode MATNR,Dscription MAKTX,(OpenQty-U_grqty_web) LFIMG,unitMsr VRKME,WTQ1.LineNum item, ToWhsCode PLANT,
// 							diubah agar melihat open qty yg di sap saja, karena qty web sering salah
		$this->db2->from('OWTQ');
		$this->db2->join('WTQ1','OWTQ.DocEntry = WTQ1.DocEntry','inner');
		$this->db2->join('OITM','WTQ1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTQ.Filler','inner');
		$this->db2->where_in('Filler',$kd_plant);
		//$this->db2->where('RIGHT(ToWhsCode,2) <>',$U_StrLoc);
		$this->db2->where('U_Stat',0);
		//$this->db2->where('(OpenQty-U_grqty_web) >', 0); // diubah agar melihat open qty yg di sap saja, karena qty web sering salah
		$this->db2->where('OpenQty >', 0);
		$this->db2->where('OWTQ.CANCELED','N');
		$this->db2->where('OWTQ.DocStatus','O');
		
		//$this->db2->where('Filler <>','05WHST');
		//$this->db2->where(array('OWTQ.U_Stat'=> NULL));
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
		sqlsrv_close($c);

	}
	
	function sap_gistonew_out_header_select_by_do_no($do_no) {

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
	
	function sap_gistonew_out_select_item_group_do($do_no) {
        $doitems = $this->sap_gistonew_out_details_select_by_do_no($do_no);
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

function sap_gistonew_out_details_select_by_do_no($do_no) {
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
            $doitems[$i]['id_gistonew_out_h_detail'] = $i;
          }
          return $doitems;
        }
        else {
          unset($doitems);
          return FALSE;
        }
	}
function sap_gistonew_out_details_select_by_do_and_item_group($do_no,$item_group_code) {
        $doitems = $this->sap_gistonew_out_details_select_by_do_no($do_no);
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

	function sap_gistonew_out_details_select_by_do_and_item_code($do_no,$item_code) {
        $doitems = $this->sap_gistonew_out_details_select_by_do_no($do_no);
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

	/**
	 * Get how many result from a gistonew_out header.
	 * @return integer|false Count of result from a gistonew_out header.
	 */
	function gistonew_out_headers_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_gistonew_out_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'gistonew_out_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'receiving_plant';
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
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'gistonew_out_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'gistonew_out_no';
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
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'receiving_plant';
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
	
	function gistonew_out_headers_count_by_criteria_sap($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $back = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_gistonew_out_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'gistonew_out_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'receiving_plant';
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
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'gistonew_out_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'gistonew_out_no';
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
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'receiving_plant';
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

	function gistonew_out_headers_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('t_gistonew_out_header');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'gistonew_out_no';
					break;
				case 'b':
					$field_name_ori = 'po_no';
					break;
				case 'c':
					$field_name_ori = 'receiving_plant';
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
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'id_gistonew_out_header';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'gistonew_out_no';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'gistonew_out_no';
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
					$field_sort_name = 'receiving_plant';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'receiving_plant';
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

	function gistonew_out_header_delete($id_gistonew_out_header) {
		//echo "ABCD";

		if($this->gistonew_out_details_delete($id_gistonew_out_header)) {
			
			$this->db->where('id_gistonew_out_header', $id_gistonew_out_header);

			if($this->db->delete('t_gistonew_out_header'))
				return TRUE;
			else
				return FALSE;

		}

	}

	// end of browse

	// start of input


	function sap_item_groups_select_all() {
		$this->db->from('m_item_group');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
	}

	function sap_item_group_select($item_group_code) {
		$this->db->from('m_item_group');
		$this->db->where('item_group_code', $item_group_code);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
	}
	
	

	function sap_gistonew_out_detail_select_by_id_gistonew_out_h_detail($id_gistonew_out_h_detail) {

		$this->db->from('wiwid_s_gistonew_out_detail');
		$this->db->where('id_gistonew_out_h_detail', $id_gistonew_out_h_detail);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function sap_gistonew_out_detail_select_by_item($item) {

		$this->db->from('wiwid_s_gistonew_out_detail');
		$this->db->where('item', $item);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_gistonew_out_plant_new_select($id_outlet,$posting_date="",$id_gistonew_out_header="") {

        if (empty($posting_date))
           $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_gistonew_out_plant');
		$this->db->from('t_gistonew_out_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_gistonew_out_header)) {
    	  $this->db->where('id_gistonew_out_header <> ', $id_gistonew_out_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$gistonew_out = $query->row_array();
			$id_gistonew_out_outlet = $gistonew_out['id_gistonew_out_plant'] + 1;
		}	else {
			$id_gistonew_out_outlet = 1;
		}

		return $id_gistonew_out_outlet;
	}

	function gistonew_out_header_insert($data) {
		$this->db->insert('t_gistonew_out_header', $data);
			return $this->db->insert_id();
	}

	function sap_gistonew_out_header_approve($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CREATE_GI_TRNSFO");
       $this->m_saprfc->importParameter(array ("OUTLET",
                                               "POSTING_DATE",
                                               "WEB_LOGIN_ID",
                                               "WEB_TRANSID"),
                                      array ($data['plant'],
                                             $data['posting_date'],
                                             $data['id_user_input'],
                                             $data['web_trans_id'])
                                      );

       $count = count($data['item']);
       $this->m_saprfc->setInitTable("I_ITEM");
       for ($i=1;$i<=$count;$i++) {
          if(!empty($data['gr_quantity'][$i]))
            $this->m_saprfc->append ("I_ITEM",
              array ("ITEM_NO"=>$data['item'][$i],
                    "MATNR"=>$data['material_no'][$i],
                    "GR_QNTY"=>$data['gr_quantity'][$i],
                    "GR_UOM"=>$data['uom'][$i],
                    "REC_PLANT"=>$data['receiving_plant'],
                    ));
       }
       $this->m_saprfc->setInitTable("I_RETURN");
       $this->m_saprfc->executeSAP();
       $MATDOCUMENTYEAR = $this->m_saprfc->export("MATDOCUMENTYEAR");
       $MATERIALDOCUMENT = $this->m_saprfc->export("MATERIALDOCUMENT");
       $ERRORX = $this->m_saprfc->export("ERRORX");
       $PO_DOCUMENT = $this->m_saprfc->export("PO_DOCUMENT");
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
       for($i=1;$i<=$count;$i++) {
         $sap_messages = $sap_messages.' <br> '.$I_RETURN[$i]['MESSAGE'];
       }
        $approved_data = array (
          "material_document" => $MATERIALDOCUMENT,
          "po_document" => $PO_DOCUMENT,
          "sap_messages" => $sap_messages,
          "sap_messages_type" => $I_RETURN[1]['TYPE']
        );
        if($ERRORX=='X') {
          unset($approved_data['material_document']);
          unset($approved_data['po_document']);
        }

        return $approved_data;
	}

	function sap_gistonew_out_header_cancel($data) {
       $this->m_saprfc->setUserRfc();
       $this->m_saprfc->setPassRfc();
       $this->m_saprfc->sapAttr();
       $this->m_saprfc->connect();
       $this->m_saprfc->functionDiscover("ZMM_BAPI_CANCEL_GI_TRANSFO");
       $this->m_saprfc->importParameter(array ("MATDOCUMENTYEAR",
                                             "MATERIALDOCUMENT",
                                             "OUTLET",
                                             "POSTING_DATE",
                                             "PO_DOC",
                                             "WEB_LOGIN_ID",
                                             "WEB_TRANSID"),
                                      array ($data['mat_doc_year'],
                                             $data['gistonew_out_no'],
                                             $data['plant'],
                                             $data['posting_date'],
                                             $data['po_no'],
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
           'MATERIALDOCUMENT : '.$data['gistonew_out_no'].' <br> '.
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
          "sap_messages" => $sap_messages,
          "mat_doc_item" => $MATDOC_ITEM
        );

        return $cancelled_data;
	}

	function gistonew_out_header_update($data) {
		$this->db->where('id_gistonew_out_header', $data['id_gistonew_out_header']);
		if($this->db->update('t_gistonew_out_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function gistonew_out_header_update_by_gistonew_out_no($data) {
		$this->db->where('gistonew_out_no', $data['gistonew_out_no']);
		if($this->db->update('t_gistonew_out_header', $data))
			return TRUE;
		else
			return FALSE;
	}

	function gistonew_out_detail_insert($data) {
		//echo "detail";
		if($this->db->insert('t_gistonew_out_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}
	
	function batch_insert($data) {
		if($this->db->insert('t_batch', $data))
			return TRUE;
			//$this->session->sess_destroy();
		else
			return FALSE;
	}


	function sap_gistonew_out_detail_approve($data) {
		return TRUE; // for testing purpose only
	}

	// end of input

	// start of edit

	function gistonew_out_header_select($id_gistonew_out_header) {
		$this->db->from('t_gistonew_out_header');
		$this->db->where('id_gistonew_out_header', $id_gistonew_out_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function gistonew_out_details_select($id_gistonew_out_header) {
		$this->db->from('t_gistonew_out_detail');
		$this->db->where('id_gistonew_out_header', $id_gistonew_out_header);
		$this->db->order_by('id_gistonew_out_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function batch($item) {
		$this->db->from('t_batch');
		$this->db->where('ItemCode', $item);
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		
			return $query;
		else
			return FALSE;
	}

	function gistonew_out_is_data_cancelled($id_gistonew_out_header) {
		$this->db->from('t_gistonew_out_detail');
		$this->db->where('id_gistonew_out_header', $id_gistonew_out_header);
		$this->db->where('ok_cancel', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function gistonew_out_detail_update($data) {
		$this->db->where('id_gistonew_out_detail', $data['id_gistonew_out_detail']);
		if($this->db->update('t_gistonew_out_detail', $data))
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

	function gistonew_out_details_delete($id_gistonew_out_header) {
		$this->db->where('id_gistonew_out_header', $id_gistonew_out_header);
		if($this->db->delete('t_gistonew_out_detail'))
			return TRUE;
			
		else
			return FALSE;
	}
	
	function batch_delete($id_gistonew_out_header) {
		$this->db->where('BaseEntry', $id_gistonew_out_header);
		$this->db->where('BaseType', 0);
		if($this->db->delete('t_batch'))
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
