<?php
class M_home extends Model {

function M_home() {
		parent::Model();
		$this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->load->library('l_general');
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
	
	function grpodlv_dept(){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		$CON=mssql_query($SAPquery);
		$CON1=mssql_fetch_array($CON);
		$U_StrLoc=$CON1['U_StrLoc'];
		$this->db2->select('OWTR.DocEntry VBELN,OWTR.DocDate DELIV_DATE,OWTR.ToWhsCode,WTR1.LineNum POSNR,
							OITM.ItmsGrpCod DISPO,WTR1.ItemCode MATNR,Dscription MAKTX,(OpenQty-U_grqty_web) LFIMG,unitMsr VRKME,WTR1.LineNum item');
		$this->db2->from('OWTR');
		$this->db2->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
		$this->db2->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
		$this->db2->where('ToWhsCode',$kd_plant);
		$this->db2->where('U_StrLoc',$U_StrLoc);
		$this->db2->where('U_Stat <>',1);
		$this->db2->where('(OpenQty-U_grqty_web) >', 0);
		//$this->db2->where('Filler',$filler);
		//$this->db2->where(array('OWTR.U_Stat'=> NULL));
		$query = $this->db2->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	
	}
	
	function retin(){
		
		$db_sap=$this->m_general->sap_db();
		$dba=$db_sap[0]['name'];
		$dbpass=$db_sap[0]['password'];
		$dbu=$db_sap[0]['user'];
		$dbh=$db_sap[0]['host'];
		$con = sqlsrv_connect($dbh, array( "Database"=>$dba, "UID"=>$dbu, "PWD"=>$dbpass ));
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		//$b=mssql_select_db('Test_MSI',$c);
		//echo $db_sap.'-'.$dba;
	
		//$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		//$CON=mssql_query($SAPquery);
		//$CON1=mssql_fetch_array($CON);
		$CON1=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'"));
		$U_StrLoc=$CON1['U_StrLoc'];
		/*$SAPquery1="select U_TransFor from OWHS where  WhsCode = '$kd_plant'";
		$CON1=mssql_query($SAPquery1);
		$CON2=mssql_fetch_array($CON1);*/
		$CON2=sqlsrv_fetch_array(sqlsrv_query($con,"select U_TransFor from OWHS where  WhsCode = '$kd_plant'"));
		$plant=$CON2['U_TransFor'];
		//echo $kd_plant.'-'.$plant;
		sqlsrv_close($con);
		
		//return $this->db2->get("OWTR");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		//{
		 $filler=Array('CW','CW1','CW2');
		 $this->db2->distinct();
		 $this->db2->select('OWTR.DocEntry VBELN');
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
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	//mssql_close($c);
	}
	
	function grsto(){
		$db_sap=$this->m_general->sap_db();
		$dba=$db_sap[0]['name'];
		$dbpass=$db_sap[0]['password'];
		$dbu=$db_sap[0]['user'];
		$dbh=$db_sap[0]['host'];
		
		$con = sqlsrv_connect($dbh, array( "Database"=>$dba, "UID"=>$dbu, "PWD"=>$dbpass ));
		//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		//$b=mssql_select_db('Test_MSI',$c);
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
		//$SAPquery1="select U_TransFor  from OWHS where  WhsCode = '$kd_plant'";
		//$CON1=mssql_query($SAPquery1);
		//$CON2=mssql_fetch_array($CON1);
		$CON2=sqlsrv_fetch_array(sqlsrv_query($con,"select U_TransFor  from OWHS where  WhsCode = '$kd_plant'"));
		
		$plant=$CON2['U_TransFor'];
		sqlsrv_close($con);
		
		$this->db->distinct();
        $this->db->select('po_no EBELN');
  	    $this->db->from('t_gistonew_out_header');
		$this->db->join('t_gistonew_out_detail','t_gistonew_out_detail.id_gistonew_out_header = t_gistonew_out_header.id_gistonew_out_header','inner');
		//$this->db->join('m_item','m_item.MATNR = t_gistonew_out_detail.material_no','inner');
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
			return $query->num_rows();
		} else {
			return FALSE;
		}
	//mssql_close($c);
	}
	
	function gistonew_out(){
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];

       
		//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		//$b=mssql_select_db('Test_MSI',$c);
		
		$con = sqlsrv_connect($dbh, array( "Database"=>$db_sap, "UID"=>$dbu, "PWD"=>$dbpass ));
		//$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		//$CON=mssql_query($SAPquery);
		//$CON1=mssql_fetch_array($CON);
		$CON1=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'"));
		$U_StrLoc=$CON1['U_StrLoc'];
		//echo "{".$U_StrLoc."}";
	
		//$SAPquery1="select WhsCode from OWHS where U_TransFor = '$kd_plant'";
		//$CON1=mssql_query($SAPquery1);
		//$CON2=mssql_fetch_array($CON1);
		$CON2=sqlsrv_fetch_array(sqlsrv_query($con,"select WhsCode from OWHS where U_TransFor = '$kd_plant'"));
		$plant=$CON2['WhsCode'];
		sqlsrv_close($con);
		//return $this->db2->get("OWTQ");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		//{
		 $filler=Array('CW','CW1','CW2');
		 $this->db2->distinct();
		 $this->db2->select('OWTQ.DocEntry VBELN');
		$this->db2->from('OWTQ');
		$this->db2->join('WTQ1','OWTQ.DocEntry = WTQ1.DocEntry','inner');
		$this->db2->join('OITM','WTQ1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTQ.Filler','inner');
		$this->db2->where_in('Filler',$kd_plant);
		//$this->db2->where('RIGHT(ToWhsCode,2) <>',$U_StrLoc);
		$this->db2->where('U_Stat ',0);
		$this->db2->where('(OpenQty-U_grqty_web) >', 0);
		$this->db2->where('OWTQ.CANCELED','N');
		$this->db2->where('OWTQ.DocStatus','O');
		//$this->db2->where('Filler <>','05WHST');
		//$this->db2->where(array('OWTQ.U_Stat'=> NULL));
		$query = $this->db2->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	//mssql_close($c);
	}
	
	function grpodlv(){
		$db_sap=$this->m_general->sap_db();
		$dba=$db_sap[0]['name'];
		$dbpass=$db_sap[0]['password'];
		$dbu=$db_sap[0]['user'];
		$dbh=$db_sap[0]['host'];
		
		$con = sqlsrv_connect($dbh, array( "Database"=>$dba, "UID"=>$dbu, "PWD"=>$dbpass ));
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
		//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
	//	$b=mssql_select_db('Test_MSI',$c);
		
		/*if ($b)
		{
			echo "BERHASIL";
		}else
		{
			echo "GAGAL";
		}*/
	
		//$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		//$CON=mssql_query($SAPquery);
		//$CON1=mssql_fetch_array($CON);
		$CON1=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'"));
		$U_StrLoc=$CON1['U_StrLoc'];
		
		//$SAPquery1="select WhsCode from OWHS where U_TransFor = '$kd_plant'";
		//$CON1=mssql_query($SAPquery1);
		//$CON2=mssql_fetch_array($CON1);
		$CON2=sqlsrv_fetch_array(sqlsrv_query($con,"select WhsCode from OWHS where U_TransFor = '$kd_plant'"));
		$plant=$CON2['WhsCode'];
		sqlsrv_close($con);
		
		//echo $plant;
		//return $this->db2->get("OWTR");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		
		//{
		 $filler=Array('WMSISTBS','WMSISTFG','WMSISTPR','WMSISTQC','WMSISTRM','WMSISTTR','WDFGSYBS','WDFGSYFG','WDFGSYPR','WDGFGSYRM','WDFGSYQC');
		  $this->db2->distinct();
		 $this->db2->select("OWTR.DocEntry VBELN");
		$this->db2->from('OWTR');
		$this->db2->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
		$this->db2->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
		$this->db2->join('NNM1','OWTR.Series=NNM1.Series','inner');
		//$this->db2->join('OITL','OITL.DocEntry=OWTR.DocEntry','left');
		//$this->db2->join('ITL1','OITL.LogEntry = ITL1.LogEntry AND ITL1.ItemCode=WTR1.ItemCode','left');
		//$this->db2->join('OBTN','ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber','left');
		//$this->db2->join('OUOM','OITM.IUoMEntry=OUOM.UomEntry','inner');
		$this->db2->where('ToWhsCode',$plant);
		$this->db2->where('(OpenQty-U_grqty_web) >', 0);
		//$this->db2->where('(ITL1.Quantity-U_grqty_web) >', 0);
		//$this->db2->where('U_Stat <>',1);
		//$this->db2->where('U_StrLoc <>',$U_StrLoc);
		$this->db2->where('OWTR.CANCELED','N');
		$this->db2->where('OWTR.U_Reverse','N');
		$this->db2->where('OWTR.U_Stat',0);//buat ngilangin notifikasi
		//$this->db2->where('OWTR.U_Reverse IS NULL');
		$this->db2->where_in('Filler',$filler);
		//$this->db2->where('OITL.DocType',67);
		//$this->db2->where('OITL.StockQty >',0);
		
		$query = $this->db2->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	
	function error_log(){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->from('error_log');
	$this->db->where('Whs',$kd_plant);
	$this->db->order_by('id_error');
	$query = $this->db->get();
		if ($query ->num_rows() > 0){
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	
	function item_agging(){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->select('a.id_grpo_header,a.delivery_date,b.material_no,b.material_desc');
	$this->db->from('t_grpo_header a');
	$this->db->join('t_grpo_detail b','a.id_grpo_header=b.id_grpo_header','inner');
	$this->db->where('delivery_date >= CURDATE() -3');
	$this->db->where('delivery_date <= NOW()');
	$this->db->where('a.plant',$kd_plant);
	$query = $this->db->get();
		if ($query ->num_rows() > 0){
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	
	function gistonew_dept() {
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
		$SAPquery="SELECT U_StrLoc from owhs where WhsCode ='$kd_plant'";
		$CON=mssql_query($SAPquery);
		$CON1=mssql_fetch_array($CON);
		$U_StrLoc=$CON1['U_StrLoc'];
	
		//return $this->db2->get("OWTQ");
		//if ( $kd_plant == 'CW' || $kd_plant == 'CW1' || $kd_plant == 'CW2')
		//{
		 $filler=Array('CW','CW1','CW2');
		 $this->db2->select('OWTQ.DocEntry VBELN,OWTQ.DocDate DELIV_DATE,OWTQ.ToWhsCode');
		$this->db2->from('OWTQ');
		$this->db2->join('WTQ1','OWTQ.DocEntry = WTQ1.DocEntry','inner');
		$this->db2->join('OITM','WTQ1.ItemCode = OITM.ItemCode','inner');
		$this->db2->join('OWHS','OWHS.WhsCode = OWTQ.Filler','inner');
		$this->db2->where('ToWhsCode',$kd_plant);
		$this->db2->where('U_StrLoc',$U_StrLoc);
		$this->db2->where('U_Stat <>',1);
		$this->db2->where('(OpenQty-U_grqty_web) >', 0);
		//$this->db2->where('Filler',$filler);
		//$this->db2->where(array('OWTQ.U_Stat'=> NULL));
		$query = $this->db2->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
		
	}

	function home_po_vendor_outstanding() {

	
		/*$this->db->select('EBELN');
		$this->db->from('ZMM_BAPI_DISP_PO_OUTSTANDING');
		//$this->db->distinct();
    	$this->db->where("(BSTMG-BSTMG_APRVD)>0");
    	//$this->db->where("DELIV_DATE <= '".date("Ymd")."'");
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	//$this->db->where('EBELP', 10);*/
		
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
 	   $this->db->select('EBELN');
       /*BSTMG-(COALESCE((SELECT SUM(gr_quantity) FROM t_grpo_detail
						 JOIN t_grpo_header ON t_grpo_detail.id_grpo_header = t_grpo_header.id_grpo_header
						 where t_grpo_header.po_no  = EBELN),0)) AS */
  	   $this->db->from('zmm_bapi_disp_po_outstanding');
 	   $this->db->where('PLANT',$kd_plant);
	    $this->db->where('BSTMG >',0);
 	  // $this->db->where("DELIV_DATE >= '".date('Ymd')."'"); //.new 20120312
		$this->db->group_by('EBELN');
		//$this->db->order_by('EBELP');
		

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}

	function home_posto_do_ck_outstanding() {

		$this->db->distinct();
		$this->db->select('VBELN');
		$this->db->from('ZMM_BAPI_DISP_DELV_OUTS');
    	$this->db->where("LFIMG <> LFIMG_APRVD");
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}


	function home_web_sap() {
		$posting_date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-7, date("Y")));
		$this->db->select_max('posting_date');
		$this->db->from('t_posinc_header');
		$this->db->where("status",2);
		// $this->db->where("status_eod_waste",1);
    	$this->db->where("posting_date >= '".$posting_date."'");
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		

		if($query->num_rows() > 0) {
			$qResult = $query->result_array();
			if (Empty($qResult[0]['posting_date'])) unset($qResult); else $qResult=date('j F Y',strtotime($qResult[0]['posting_date']));
		}
		if(!Empty($qResult)) {
			return 'Data terkini tanggal '.$qResult;
		} else {
			$this->db->select_max('posting_date');
			$this->db->from('t_posinc_header');
			$this->db->where("status",1);
			// $this->db->where("status_eod_waste",1);
			$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
			

			$query = $this->db->get();
			
			
			if($query->num_rows() > 0) {
				$qResult = $query->result_array();
				if (Empty($qResult[0]['posting_date'])) {
					unset($qResult); 
					return '<b style="color:#AA1122;">OFFLINE</b> sejak awal';
				} else {
					$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['posting_date']));
					return $qResult;
				}

				
			} else {
				$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['posting_date']));
				return $qResult;
			}
		}
	}

	function home_web_hr() {
		$posting_date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-7, date("Y")));
		$this->db->select_max('tanggal');
		$this->db->from('t_upload_absent');
		// $this->db->where("status_hr",1);
    	$this->db->where("tanggal >= '".$posting_date."'");
    	$this->db->where('kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		
		$query = $this->db->get();
		//print_r($this->session->userdata['ADMIN']);
		//echo $this->db->last_query();
		

		if($query->num_rows() > 0) {
			$qResult = $query->result_array();
			if (Empty($qResult[0]['tanggal'])) unset($qResult); else $qResult=date('j F Y',strtotime($qResult[0]['tanggal']));
		}
		if(!Empty($qResult)) {
			return 'Data terkini tanggal '.$qResult;
		} else {
			$this->db->select_max('tanggal');
			$this->db->from('t_upload_absent');
			// $this->db->where("status_hr",1);
			$this->db->where('kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
			

			$query = $this->db->get();
			
			
			if($query->num_rows() > 0) {
				$qResult = $query->result_array();
				if (Empty($qResult[0]['tanggal'])) {
					unset($qResult); 
					return '<b style="color:#AA1122;">OFFLINE</b> sejak awal';
				} else {
					$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['tanggal']));
					return $qResult;
				}

				
			} else {
				$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['tanggal']));
				return $qResult;
			}
		}
	}

	function home_transight() {
		$posting_date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-7, date("Y")));
		$this->db->select_max('posting_date');
		$this->db->from('t_statuseod');
		$this->db->where("status_eod_transight",1);
    	$this->db->where("posting_date >= '".$posting_date."'");
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
		
		$query = $this->db->get();
		

		if($query->num_rows() > 0) {
			$qResult = $query->result_array();
			if (Empty($qResult[0]['posting_date'])) unset($qResult); else $qResult=date('j F Y',strtotime($qResult[0]['posting_date']));
		}
		if(!Empty($qResult)) {
			return 'Data terkini tanggal '.$qResult;
		} else {
			$this->db->select_max('posting_date');
			$this->db->from('t_statuseod');
			$this->db->where("status_eod_transight",1);
			$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
			

			$query = $this->db->get();
			
			
			if($query->num_rows() > 0) {
				$qResult = $query->result_array();
				if (Empty($qResult[0]['posting_date'])) {
					unset($qResult); 
					return '<b style="color:#AA1122;">OFFLINE</b> sejak awal';
				} else {
					$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['posting_date']));
					return $qResult;
				}

				
			} else {
				$qResult='<b style="color:#AA1122;">OFFLINE</b> sejak '.date('j F Y',strtotime($qResult[0]['posting_date']));
				return $qResult;
			}
		}
	}

}
