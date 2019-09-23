<?php
class Feed extends Controller {
	private $jagmodule = array();

	function Feed() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1027);  //get module data from module ID
		$this->load->model('m_general');
		$this->load->model('m_saprfc');
		$this->load->model('m_updatedata');
		$this->load->model('m_sinkron_mysql');
		$this->load->model('m_sync_attendance');
		$this->load->library('l_upload_absent');
	}

	//FROM SYNCHR.PHP
	
	function employee_attendance() {
		if ($this->m_updatedata->check_running_jobs('sync_finger')==TRUE) {
			die('Process cancelled because "sync_finger" jobs already running in other process.');
		} else {
			$this->m_sync_attendance->sync_setidle();
		}
	
		$jobs = Array();
		$jobs['sync_finger']=2;
		$this->m_updatedata->insert_jobs($jobs);

		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_attendance_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /var/www/html/portal.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+1 hour")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start HR Attendance Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sync_attendance->sync_process();
		$data_sync .= $process_sync;

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$end_sync = "End HR Attendance Sync Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);

		// $this->dataoptimize('t_employee_absent');
		// $this->dataoptimize('t_employee_absent_noshift');
		// $this->dataoptimize('d_employee_shift');
		// $this->dataoptimize('t_upload_absent'); //too long
		// $this->dataoptimize('d_employee_absent');
		// $this->dataoptimize('t_status_sync');
		
		$this->m_updatedata->finish_jobs('sync_finger');
		$this->dataoptimize('r_sync');
		ob_flush();
	}	
	//END FROM SYNCHR.PHP
	
	
	//FROM SINKRON.PHP
	
	function update_end_of_month() {
		if ($this->m_updatedata->check_running_jobs('sync_eom')==TRUE) {
			die('Process cancelled because "sync_eom" jobs already running in other process.');
		}
	
		$jobs = Array();
		$jobs['sync_eom']=2;
		$this->m_updatedata->insert_jobs($jobs);

		header('Content-Type: text/plain');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = "/var/www/html/portal.ybc.co.id/system/application/";
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+25 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		echo "Proses update End Of Month Start: ".date("Ymd-His")."<br />";
		ob_flush();

        $this->m_sinkron_mysql->end_of_month();

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$this->m_updatedata->finish_jobs('sync_eom');
		$this->dataoptimize('r_sync');
		echo "Proses update End Of Month Finish: ".date("Ymd-His");
		ob_flush();
	}

	function update_employee() {
		if ($this->m_updatedata->check_running_jobs('sync_employee')==TRUE) {
			die('Process cancelled because "sync_employee" jobs already running in other process.');
		}
	
		$jobs = Array();
		$jobs['sync_employee']=2;
		$this->m_updatedata->insert_jobs($jobs);	
	
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_master_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /srv/www/vhosts/sap.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+5 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start Employee Master Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

		// die('aa');
        $process_sync = $this->m_sinkron_mysql->employee_update();
		

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);
		$this->dataoptimize('m_employee');
		$this->dataoptimize('m_outlet_employee');
		$this->dataoptimize('m_work_status');
		$this->dataoptimize('m_divisi');
		$this->dataoptimize('m_bagian');
		$this->dataoptimize('m_jabatan');
		$this->dataoptimize('m_dept');
		$this->dataoptimize('m_education');
		$this->dataoptimize('m_absent_type');
		$this->dataoptimize('m_shift');
		$this->dataoptimize('m_schedule_pembyaran');
		$this->dataoptimize('m_cuti_ph');
		
		$this->m_updatedata->finish_jobs('sync_employee');
		$this->dataoptimize('r_sync');

		$end_sync = "End HR Employee Master Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}	
	//END FROM SINKRON.PHP
	
	
	// main function
	function index()
	{

	}
	
	//Clean up string or text
	function CekString($isiString) {
		// $isiString = str_replace("'","''",$isiString);
		$isiString = mysql_real_escape_string($isiString);

		return $isiString;
	}	
	
	//Clean up string or text
	function CekStringTrim($isiString) {
		// $isiString = str_replace("'","''",$isiString);
		$isiString = mysql_real_escape_string(trim($isiString));

		return $isiString;
	}	
	
	//optimize table database MySQL
	function dataoptimize($namaTabel){
		$this->db->query('CHECK TABLE `'.$namaTabel.'`');
		$this->db->query('REPAIR TABLE `'.$namaTabel.'`');
		$this->db->query('OPTIMIZE TABLE `'.$namaTabel.'`');
	}

	/* Return Remintance of a day
	 * $date format: yyyymmdd
	 * $plant format: as output from SAP
	 * return float remintance
	 */
	function posinc($date = 0, $plant = 0) {

		$date = date("Y-m-d", strtotime($date));

		if(!empty($date) && !empty($plant)) {
			$this->db->select('total_remintance');
			$this->db->from('t_posinc_header');
			$this->db->where('DATE(posting_date)', $date);
			$this->db->where('status', 2);
    		$this->db->where('waste_no is not null');
			$this->db->where('plant', $plant);
			$query = $this->db->get();

			$posinc =  $query->row_array();
			$nilairem = @$posinc['total_remintance'];
			if (Empty($nilairem)) $nilairem = 0;
			echo intval($nilairem);
		}

	}

	function sap_item_groups_select_all() {
        $this->m_saprfc->setUserRfc("IN_WEB_SYN");
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_LIST_MATERIAL_ALL2013");

        $this->m_saprfc->setInitTable("MATERIAL_DATA");
        $this->m_saprfc->executeSAP();
        $item_groups = $this->m_saprfc->fetch_rows("MATERIAL_DATA");
		
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

    function update_item() {
	ini_set('memory_limit', '-1');

        $gicc = array("ZSP1",
                      "ZSP3",
                      "ZOT1",
                      "ZOT2");

        $gist = array("ZFGA","ZFGB","ZFG1",
                      "ZFG2",
                      "ZFG3",
                      "ZFG4",
                      "ZFG5",
                      "ZFG7",
                      "ZFG6",
                      "ZFG8",
                      "ZFG9",
                      "ZSF6",
                      "ZRM1",
                      "ZPA1",
                      "ZOT1",
                      "ZOT2",
                      "ZTG3",
					  "ZSP1");
/*
        $grfg_bid = array("ZFG1");
        $grfg_bid_spc = array("ZFG5"); //luar kota / special
		$kd_plant_bid_spc = array("B018","B019","B022","B026","B027","B031","B052","B053","B061","B068");


        $grfg_jid = array("ZFG1",
                      "ZFG2",
                      "ZFG3",
                      "ZFG7",
                      "ZFG9",
                      );
*/
        $grfg = array("ZFG1",
                      "ZFG2",
                      "ZFG5");

        $grnonpo = array("ZRM1",
                      "ZPA1");

        $stdstock = array("ZFGA","ZFGB","ZFG4",
                    "ZFG5",
                    "ZFG6",
                    "ZSF6",
                    "ZRM1",
                    "ZPA1",
                    "ZTG3",
                    "ZOT2");

        $nonstdstock = array(
                    "ZFG3",
                    "ZFG7",
					"ZFG9",
                    "ZSP1",
                    "ZSP2",
                    "ZSP3",
                    "ZOT1",
                    "ZOT2");

        $stockoutlet = array("ZFG3",
                    "ZFG4",
                    "ZFG5",
                    "ZFG7",
                    "ZFG8",
                    "ZSFB",
                    "ZSFJ",
                    "ZSF6",
                    "ZRM1",
                    "ZPA1",
                    "ZFG6",
                    "ZSFG",
                    "ZFW1",
                    "ZOT2",
                    "ZTG3",
                    "ZFGA","ZFGB"
                    );

        $tssck = array("ZFG3",
                      "ZFG4",
                      "ZFG5",
                      "ZFG7",
                      "ZFG6",
                      "ZSF6",
                      "ZRM1",
                      "ZPA1",
                      "ZSP1",
                      "ZSP3",
                      "ZOT1",
                      "ZOT2",
                      "ZTG3"
                    );

        $waste = array("ZFG4",
                      "ZFG5",
                      "ZSFB",
                      "ZSFJ",
                      "ZSF6",
                      "ZRM1",
                      "ZPA1",
                      "ZFG3",
                      "ZFG6",
                      "ZSFG",
                      "ZFW1",
                      "ZOT2",
                      "ZTG3","ZFGB"
                    );

        $pastry = array(
                    "ZFG3",
                    "ZFG7",
										"ZFG9"
                    );

        $utensil = array("ZSP1",
                      "ZSP2",
                      "ZSP3",
                      "ZOT1",
                      "ZOT2"
                    );

        $matr_type_check_proc_type = array("ZSFJ",
                      "ZSFB",
                      "ZFW1",
                    );

        $matrcode_incl_std_excl_nonstd = array(
                    "000000000000110030",
                    );

        $mrp_controller_to_ZOT2 = array("J09",
                      "B12",
                    );

        $items = $this->sap_item_groups_select_all();
        if(!empty($items)) {
          $this->db->truncate('m_item');
          $this->db->truncate('m_item_group');
          $this->db->truncate('m_map_item_trans');
          $this->db->truncate('m_mapping_item');
		  
		  
		  //20140523 - Add to table ZMM_BAPI_LIST_MATERIAL_ALL
          $this->db->truncate('ZMM_BAPI_LIST_MATERIAL_ALL');
		  $count = count($items);
			for ($i=1;$i<=$count;$i++) {
			
				$MATNR = $this->CekString($items[$i]['MATNR']);
				$MTART = $this->CekString($items[$i]['MTART']);
				$BISMT = $this->CekString($items[$i]['BISMT']);
	// if ((($BISMT!="BID") && ($BISMT!="JID")) || (strpos("###".$MTART,"Next")>0)) continue;

				$MEINS = $this->CekString($items[$i]['MEINS']);
				$MAKTX = $this->CekString($items[$i]['MAKTX']);
				$MAKTG = $this->CekString($items[$i]['MAKTG']);
				$MATKL = $this->CekString($items[$i]['MATKL']);
				$DISPO = $this->CekString($items[$i]['DISPO']);
				$WERKS = $this->CekString($items[$i]['WERKS']);
				$SOBSL = $this->CekString($items[$i]['SOBSL']);
				$WGBEZ = $this->CekString($items[$i]['WGBEZ']);
				$DSNAM = $this->CekString($items[$i]['DSNAM']);
				$UNIT = $this->CekString($items[$i]['UNIT']);
				$UNIT_STEXT = $this->CekString($items[$i]['UNIT_STEXT']);
				
				$sqlINSERT = "INSERT INTO `ZMM_BAPI_LIST_MATERIAL_ALL` (`MATNR`,`MTART`,`BISMT`,`MEINS`,`MAKTX`,`MAKTG`,
	`MATKL`,`DISPO`,`WERKS`,`SOBSL`,`WGBEZ`,`DSNAM`,`UNIT`,`UNIT_STEXT`) VALUES ('$MATNR','$MTART','$BISMT','$MEINS','$MAKTX','$MAKTG','$MATKL','$DISPO','$WERKS','$SOBSL','$WGBEZ','$DSNAM','$UNIT','$UNIT_STEXT');";
	
				$this->db->query($sqlINSERT);
			

			}		 
		   //20140523 END - Add to table ZMM_BAPI_LIST_MATERIAL_ALL

          foreach($items as $item) {

      		$this->db->from('m_item');
      		$this->db->where('MATNR',$item['MATNR']);
      		$this->db->where('DISPO',$item['DISPO']);

      		$query = $this->db->get();

      		if($query->num_rows() == 0) {
                $data = array(
                  'MATNR'=>$item['MATNR'],
                  'MTART'=>$item['MTART'],
                  'BISMT'=>$item['BISMT'],
                  'MEINS'=>$item['MEINS'],
                  'MAKTX'=>$item['MAKTX'],
                  'MAKTG'=>$item['MAKTG'],
                  'MATKL'=>$item['MATKL'],
                  'DISPO'=>$item['DISPO'],
                  'WGBEZ'=>$item['WGBEZ'],
                  'UNIT'=>$item['UNIT'],
                  'UNIT_STEXT'=>$item['UNIT_STEXT'],
                  'SOBSL'=>$item['SOBSL'],
                );
                $this->db->insert('m_item', $data);
            }

            $kd_plant = $item['WERKS'];
            if (strpos("###".$kd_plant,"B")>0) $kd_comp="BID";
            elseif (strpos("###".$kd_plant,"J")>0) $kd_comp="JID";
			else $kd_comp="";

          	$this->db->from('m_mapping_item');
      		$this->db->where('MATNR',$item['MATNR']);
      		$this->db->where('kdplant',$kd_plant);

      		$query = $this->db->get();

      		if($query->num_rows() == 0) {
			/*
                 $data = array(
                  'MATNR'=>$item['MATNR'],
                  'kdplant'=>$kd_plant,
                );
                $this->db->insert('m_mapping_item', $data);
			*/	
				$swbquery1="INSERT IGNORE INTO `m_mapping_item` (`MATNR`,`kdplant`) VALUES ('".$item['MATNR']."','".$kd_plant."');";
				$this->db->query($swbquery1);
            }

          	$this->db->from('m_item_group');
      		$this->db->where('DISPO',$item['DISPO']);
      		$this->db->where('kdplant',$kd_plant);

      		$query = $this->db->get();
			
      		if($query->num_rows() == 0) {
				 if (trim($item['DSNAM'])=="") $item['DSNAM']="Other";
                 $data = array(
                  'DISPO'=>$item['DISPO'],
                  'kdplant'=>$kd_plant,
                  'DSNAM'=>$item['DSNAM'],
                );
                $this->db->insert('m_item_group', $data);
            }

            if (in_array($item['MTART'],$gicc)) {
              $this->update_mapping_trans($item['MATNR'],'gicc');
            }
            if (in_array($item['MTART'],$gist)) {
              $this->update_mapping_trans($item['MATNR'],'gist');
            }
			/*
			//GR FG BID
            if (($kd_comp=="BID") && (in_array($item['MTART'],$grfg_bid))) {
              if((!(in_array($item['MTART'],$matr_type_check_proc_type))||
                ((in_array($item['MTART'],$matr_type_check_proc_type))&&(empty($item['SOBSL']))))
                &&(($item['MTART']!='ZOT2')||
                  (($item['MTART']=='ZOT2')&&
                  (in_array($item['DISPO'],$mrp_controller_to_ZOT2)))))
                $this->update_mapping_trans($item['MATNR'],'grfg');
            }
			//GR FG BID SPECIAL
            if ((in_array($kd_plant,$kd_plant_bid_spc)) && (in_array($item['MTART'],$grfg_bid_spc))) {
              if((!(in_array($item['MTART'],$matr_type_check_proc_type))||
                ((in_array($item['MTART'],$matr_type_check_proc_type))&&(empty($item['SOBSL']))))
                &&(($item['MTART']!='ZOT2')||
                  (($item['MTART']=='ZOT2')&&
                  (in_array($item['DISPO'],$mrp_controller_to_ZOT2)))))
                $this->update_mapping_trans($item['MATNR'],'grfg');
            }
			
			//GR FG JID
			
			*/
			
			
            if (in_array($item['MTART'],$grfg)) {
              if((!(in_array($item['MTART'],$matr_type_check_proc_type))||
                ((in_array($item['MTART'],$matr_type_check_proc_type))&&(empty($item['SOBSL']))))
                &&(($item['MTART']!='ZOT2')||
                  (($item['MTART']=='ZOT2')&&
                  (in_array($item['DISPO'],$mrp_controller_to_ZOT2)))))
                $this->update_mapping_trans($item['MATNR'],'grfg');
            }
			
			
            if (in_array($item['MTART'],$grnonpo)) {
              $this->update_mapping_trans($item['MATNR'],'grnonpo');
            }
            if ((in_array($item['MTART'],$stdstock))||(in_array($item['MATNR'],$matrcode_incl_std_excl_nonstd))) {
              $this->update_mapping_trans($item['MATNR'],'stdstock');
            }
            if ((in_array($item['MTART'],$nonstdstock))&&(!(in_array($item['MATNR'],$matrcode_incl_std_excl_nonstd)))) {
              $this->update_mapping_trans($item['MATNR'],'nonstdstock');
            }
            if ((in_array($item['MTART'],$stockoutlet)) && ($item['WERKS']!='HJ01') && ($item['WERKS']!='HB01')  && ($item['WERKS']!='CB01') && ($item['WERKS']!='HP01')) {
              if ((!(in_array($item['MTART'],$matr_type_check_proc_type))||
                ((in_array($item['MTART'],$matr_type_check_proc_type))&&($item['SOBSL']=='50')))
                &&(($item['MTART']!='ZOT2')||
                  (($item['MTART']=='ZOT2')&&
                  (in_array($item['DISPO'],$mrp_controller_to_ZOT2))))) 
                $this->update_mapping_trans($item['MATNR'],'stockoutlet');
            }
            if (in_array($item['MTART'],$tssck)) {
              $this->update_mapping_trans($item['MATNR'],'tssck');
            }
            if ((in_array($item['MTART'],$waste)) && ($item['DISPO']!='J10') && ($item['WERKS']!='HJ01') && ($item['WERKS']!='HB01') && ($item['WERKS']!='CB01') && ($item['WERKS']!='HP01')) {
              if ((!(in_array($item['MTART'],$matr_type_check_proc_type))||
                ((in_array($item['MTART'],$matr_type_check_proc_type))&&(empty($item['SOBSL']))))
                &&(($item['MTART']!='ZOT2')||
                  (($item['MTART']=='ZOT2')&&
                  (in_array($item['DISPO'],$mrp_controller_to_ZOT2))))) 
                $this->update_mapping_trans($item['MATNR'],'waste');
            }
            if ((in_array($item['MTART'],$pastry))&&(!(in_array($item['MATNR'],$matrcode_incl_std_excl_nonstd)))) {
              $this->update_mapping_trans($item['MATNR'],'pastry');
            }
            if (in_array($item['MTART'],$utensil)) {
              $this->update_mapping_trans($item['MATNR'],'utensil');
            }

            }
          }
		//$this->dataoptimize('m_item');
		//$this->dataoptimize('m_item_group');
		//$this->dataoptimize('m_map_item_trans');
		//$this->dataoptimize('m_mapping_item');
		//$this->dataoptimize('ZMM_BAPI_LIST_MATERIAL_ALL');
		$this->dataoptimize('r_sync');
    }

    function update_mapping_trans($item_code,$trans_type) {
      $this->db->from('m_map_item_trans');
      $this->db->where('MATNR',$item_code);
      $this->db->where('transtype',$trans_type);
      $query = $this->db->get();
      if($query->num_rows() == 0) {
            $data = array(
                'MATNR'=>$item_code,
                'transtype'=>$trans_type,
            );
         $this->db->insert('m_map_item_trans', $data);
      }
    }

	function update_master_item() {
		if ($this->m_updatedata->check_running_jobs('sync_material')==TRUE) {
			die('Process cancelled because "sync_material" jobs already running in other process.');
		}
	
		$jobs = Array();
		$jobs['sync_material']=2;
		$this->m_updatedata->insert_jobs($jobs);
		header('Content-Type: text/plain');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = "/var/www/html/portal.ybc.co.id/system/application/";
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+25 minute")).' WIB";$swbcurrprocess="sync";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);	 

		echo "Proses Update Master Item Start: ".date("Ymd-His")."<br />";

		ob_flush();
		$this->update_item();
//sleep(12);
		echo "Proses Update Master Item Finish: ".date("Ymd-His");
		ob_flush();
		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);	 
		$gz = ob_get_clean();
		echo $gz;
		$this->m_updatedata->finish_jobs('sync_material');
   }

	function empty_tables() {
      $this->db->truncate('ci_sessions');
      $days_old = -90;

	  $this->db->where('id_stockoutlet_header in
                       (select id_stockoutlet_header
                        FROM t_stockoutlet_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_stockoutlet_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_stockoutlet_header');

	  $this->db->where('id_grpo_header in
                       (select id_grpo_header
                        FROM t_grpo_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_grpo_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_grpo_header');

	  $this->db->where('id_grpodlv_header in
                       (select id_grpodlv_header
                        FROM t_grpodlv_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_grpodlv_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_grpodlv_header');

	  $this->db->where('id_gisto_header in
                       (select id_gisto_header
                        FROM t_gisto_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_gisto_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_gisto_header');

	  $this->db->where('id_grsto_header in
                       (select id_grsto_header
                        FROM t_grsto_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_grsto_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_grsto_header');

	  $this->db->where('id_waste_header in
                       (select id_waste_header
                        FROM t_waste_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_waste_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_waste_header');

	  $this->db->where('id_nonstdstock_header in
                       (select id_nonstdstock_header
                        FROM t_nonstdstock_header where datediff(date(created_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_nonstdstock_detail');

	  $this->db->where('datediff(date(created_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_nonstdstock_header');

	  $this->db->where('id_stdstock_header in
                       (select id_stdstock_header
                        FROM t_stdstock_header where datediff(date(created_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_stdstock_detail');

	  $this->db->where('datediff(date(created_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_stdstock_header');

	  $this->db->where('id_grfg_header in
                       (select id_grfg_header
                        FROM t_grfg_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_grfg_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_grfg_header');

	  $this->db->where('id_tssck_header in
                       (select id_tssck_header
                        FROM t_tssck_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_tssck_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_tssck_header');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_trend_utility_header');

	  $this->db->where('id_prodstaff_header in
                       (select id_prodstaff_header
                        FROM t_prodstaff_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_prodstaff_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_prodstaff_header');

	  $this->db->where('id_gitcc_header in
                       (select id_gitcc_header
                        FROM t_gitcc_header where datediff(date(posting_date),CURDATE()) = '.$days_old.')');
      $this->db->delete('t_gitcc_detail');

	  $this->db->where('datediff(date(posting_date),CURDATE()) = '.$days_old);
      $this->db->delete('t_gitcc_header');

      echo "Proses Pengosongan Table Selesai.";
	}

	
	function cron(){
		$sqlCron = "SELECT `sync_type` FROM `r_sync` WHERE `sync_status` = 0 ORDER BY `sync_schedule` LIMIT 0,1;";
		$zPOS = $this->db->query($sqlCron);
		$zPOSCount = $zPOS->num_rows();

		if ($zPOSCount>0) {
			$zPOS = $zPOS->row_array();
			if ($zPOS['sync_type']=='sync_material') { $this->update_master_item(); }
			elseif ($zPOS['sync_type']=='sync_finger') { $this->employee_attendance(); }
			elseif ($zPOS['sync_type']=='sync_employee') { $this->update_employee(); }
			elseif ($zPOS['sync_type']=='sync_eom') { $this->update_end_of_month(); }
			
			
		}
	}
	

	
		
}
