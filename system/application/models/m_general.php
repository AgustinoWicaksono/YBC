<?php
class M_general extends Model {

	
		
	function M_general() {
		parent::Model();
		$this->obj =& get_instance();
        $this->load->model('m_saprfc');
		$this->load->library('l_general');
	}

	function sap_plants_select_all($plant_type_id="",$is_ck_outlet="",$is_non_ck_outlet="",$plant_id="") {
       $plants = $this->sap_plants_select_by_plant_type($plant_type_id,$is_ck_outlet,$is_non_ck_outlet,$plant_id);
       return $plants;
	}

	function sap_plants_select_by_plant_type($plant_type_id,$is_ck_outlet,$is_non_ck_outlet,$plant_id="") {
      	$this->db->from('m_outlet');
        if (!empty($plant_type_id)) {
       	  $this->db->where('COMP_CODE', $plant_type_id);
        }
        if ($is_ck_outlet=="X") {
          $this->db->where('OUTLET LIKE "C%"');
        }
        if ($is_non_ck_outlet=="X") {
          $this->db->where('OUTLET NOT LIKE "C%"');
        }
        if (!empty($plant_id)) {
          $this->db->where('OUTLET',$plant_id);
        }
 	    $query = $this->db->get();

  	    if(($query)&&($query->num_rows() > 0)) {
  	        $plants = $query->result_array();
            $count = count($plants);
            $k = 1;
            for ($i=0;$i<=$count-1;$i++) {
              $plant[$k] = $plants[$i];
              $plant[$k]['plant'] = $plant[$k]['OUTLET'];
              $plant[$k]['plant_name'] = $plant[$k]['OUTLET_NAME1'];
              $plant[$k]['plant_name2'] = $plant[$k]['OUTLET_NAME2'];
              $plant[$k]['plant_type_id'] = $plant[$k]['COMP_CODE'];
              $plant[$k]['WERKS'] = $plant[$k]['plant'];
              $plant[$k]['NAME1'] = $plant[$k]['plant_name'];
              $plant[$k]['HR_CODE'] = $plant[$k]['HR_CODE'];
              $k++;
            }
            return $plant;
         } else {
            return FALSE;
         }
    }

	function sap_plants_select_all_ck_outlet() {
	    $plant_type_id = $this->session->userdata['ADMIN']['plant_type_id'];
        $plants = $this->sap_plants_select_all($plant_type_id,"X");
        if (count($plants) > 0) {
          return $plants;
        } else {
          return FALSE;
        }
	}

	function sap_plants_select_all_outlet() {
	    $plant_type_id = $this->session->userdata['ADMIN']['plant_type_id'];
        $plants = $this->sap_plants_select_all($plant_type_id);
        if (count($plants) > 0) {
          return $plants;
        } else {
          return FALSE;
        }
	}
	
	function sap_plants_select_all_outlet1($pl){
		$this->db->select('OUTLET , OUTLET_NAME1 ');
		$this->db->from('m_outlet');
		$this->db->where('LEFT(outlet,1) <> "T" ');
		//$this->db->like('otd_code',$pl);
		 $query = $this->db->get();
		  if(($query)&&($query->num_rows() > 0)) {
           $k = 1;
		   $plants = $query->result_array();
            $count = count($plants);
            for ($i=0;$i<=$count-1;$i++) {
              $plant[$k] = $plants[$i];
              $plant[$k]['plant'] = $plant[$k]['OUTLET'];
              $plant[$k]['plant_name'] = $plant[$k]['OUTLET_NAME1'];
             
              $k++;
            }
            return $plant;
          } else {
            return FALSE;
          }
	}

	function sap_plants_select_all_non_ck_outlet() {
	    $plant_type_id = $this->session->userdata['ADMIN']['plant_type_id'];
        $plants = $this->sap_plants_select_all($plant_type_id,"","X");
        if (count($plants) > 0) {
          return $plants;
        } else {
          return FALSE;
        }
	}

	function sap_plant_select($plant) {
    	  $this->db->from('m_outlet');
       	  $this->db->where('OUTLET', $plant);

		  $query = $this->db->get();
		  if(($query)&&($query->num_rows() > 0)) {
            $outlet = $query->row_array();
            $plant['WERKS'] = $outlet['OUTLET'];
            $plant['NAME1'] = $outlet['OUTLET_NAME1'];
            return $plant;
          } else {
            return FALSE;
          }
	}
	
	

	function sap_plant_select_2($plant) {
	    $plant_type_id = $this->session->userdata['ADMIN']['plant_type_id'];
        $plants = $this->sap_plants_select_all($plant_type_id,"","",$plant);
        if (count($plants) > 0) {
          return $plants[1];
        }
        return FALSE;
	}

    function sap_plant_select_by_id($plant) {
		if (Empty($plant)) $plant="";
		$plant = trim($plant);
		if ($plant!=""){
			$plants = $this->sap_plants_select_all("","","",$plant);
			if (count($plants) > 0) {
			
				return $plants[1];
			} else {
				return FALSE;
			}
		} else return FALSE;
	}

    function sap_plant_select_by_id_summary($plant) {
		if (Empty($plant)) $plant="";
		$plant = trim($plant);

		if ($plant!=""){

			$this->db->select('a.OUTLET,a.OUTLET_NAME1,a.OUTLET_NAME2,a.COMP_CODE,b.jenisoutlet');
			$this->db->from('m_outlet a, t_jenisoutlet b');
			if (!empty($plant)) {
			  $this->db->where('OUTLET',$plant);
			  $this->db->where('a.COMP_CODE = b.id_jenisoutlet');
			}
			$query = $this->db->get();

			if(($query)&&($query->num_rows() > 0)) {
				$plants = $query->result_array();
				$plant_result = $plants;
			 } else {
				$plant_result = FALSE;
			 }

			if (count($plant_result) > 0) {
				return $plant_result[0];
			} else {
				return FALSE;
			}
		} else return FALSE;
	}

	function sap_item_groups_select_all() {
		
	      $kd_plant = $this->session->userdata['ADMIN']['plant'];
    	  $this->db->from('m_item_group');
       	  $this->db->where('kdplant', $kd_plant);

		  $query = $this->db->get();
		  if(($query)&&($query->num_rows() > 0)) {
  	        $item_groups = $query->result_array();
            $count = count($item_groups);
            $k = 1;
            for ($i=0;$i<=$count-1;$i++) {
              $item_group[$k] = $item_groups[$i];
              $k++;
            }
            return $item_group;
          } else {
            return FALSE;
          }

	    /*$kd_plant = $this->session->userdata['ADMIN']['plant'];
//        $kd_plant = "B001"; //utk sementara
        $this->m_saprfc->setUserRfc();
        $this->m_saprfc->setPassRfc();
        $this->m_saprfc->sapAttr();
        $this->m_saprfc->connect();
        $this->m_saprfc->functionDiscover("ZMM_BAPI_LIST_MATERIAL_OUTLET");
        $this->m_saprfc->importParameter(array ("FINISH_GOOD",
                                                "NON_STD",
                                                "OUTLET",
                                                "STD_STOCK",
                                                "SEMI_FG",
                                                ),
                                         array ($fg_finish_goods,
                                                $fg_nonstd_stock,
                                                $kd_plant,
                                                $fg_std_stock,
                                                $fg_semi_fg,
                                                ));
        $this->m_saprfc->setInitTable("MATERIAL_DATA");
        $this->m_saprfc->executeSAP();
        $item_groups = $this->m_saprfc->fetch_rows("MATERIAL_DATA");
        $this->m_saprfc->free();
        $this->m_saprfc->close();
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }    */
	}

	function sap_item_groups_select_all_2($GI_CC="",$GI_ST="",$GR_FG="",$GR_NONPO="",
                                          $GR_ST="",$REQ_NON_STDSTCK="",$REQ_STDSTCK="",
                                          $STOCK_OPNAME="",$TRNSF_STOCK_CK="",$WASTE="",
                                          $SFG="",$SFG_MATR="",$WTS="",$WTS_MATR="",
                                          $TWTS="",$MPAKET="",$TPAKET="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
   /*     if (strcasecmp($REQ_NON_STDSTCK,"P")==0) {
           $REQ_NON_STDSTCK = "";
           $UTENSIL = "";
           $PASTRY = "X";
		   $STORE ="";
		   $CAKESHOP ="";
		   $BAR="";
		   $HOT="";
        } else if (strcasecmp($REQ_NON_STDSTCK,"U")==0) {
           $REQ_NON_STDSTCK = "";
           $UTENSIL = "X";
           $PASTRY = "";
		   $STORE ="";
		   $CAKESHOP ="";
		   $BAR="";
		   $HOT="";
		} else if (strcasecmp($REQ_NON_STDSTCK,"S")==0) {
           $REQ_NON_STDSTCK = "";
           $UTENSIL = "";
           $PASTRY = "";
		   $STORE ="X";
		   $CAKESHOP ="";
		   $BAR="";
		   $HOT="";
		 } else if (strcasecmp($REQ_NON_STDSTCK,"C")==0) {
           $REQ_NON_STDSTCK = "";
           $UTENSIL = "";
           $PASTRY = "";
		   $STORE ="";
		   $CAKESHOP ="X";
		   $BAR="";
		   $HOT="";
		 } else if (strcasecmp($REQ_NON_STDSTCK,"B")==0) {
            $REQ_NON_STDSTCK = "";
           $UTENSIL = "";
           $PASTRY = "";
		   $STORE ="";
		   $CAKESHOP ="";
		   $BAR="X";
		   $HOT="";
		 } else if (strcasecmp($REQ_NON_STDSTCK,"H")==0) {
           $REQ_NON_STDSTCK = "";
           $PASTRY = "";
           $UTENSIL = "";
		   $STORE ="";
		   $CAKESHOP ="";
		   $BAR="";
		   $HOT="X";
        };*/
        if($GI_CC=="X"){
          $trans_type = 'gicc';
        } else if($GI_ST=="X"){
          $trans_type = 'gist';
        } else if(($GR_FG=="X")||($TWTS=="X")||($WTS=="X")||($WTS_MATR=="X")){
          $trans_type = 'grfg';
        } else if($GR_NONPO=="X"){
          $trans_type = 'grnonpo';
        } else if($GR_ST=="X"){
          $trans_type = 'grst';
        } else if(($REQ_STDSTCK=="X")||($SFG_MATR=="X")){
          $trans_type = 'stdstock';
        } else if($STOCK_OPNAME=="X"){
          $trans_type = 'stockoutlet';
        } else if($TRNSF_STOCK_CK=="X"){
          $trans_type = 'tssck';
        } else if($WASTE=="X"){
          $trans_type = 'waste';
        } else if($REQ_NON_STDSTCK=="X"){
          $trans_type = 'pastry';
	    } else if($STORE=="X"){
          $trans_type = 'Store';
	    }  else if($CAKESHOP=="X"){
          $trans_type = 'Cakeshop';
		}  else if($BAR=="X"){
          $trans_type = 'Bar';
		}  else if($HOT=="X"){
          $trans_type = 'Hot kitchen';
        } else if($UTENSIL=="X"){
          $trans_type = 'utensil';
        };
        if(((($kd_plant=='HB01')||($kd_plant=='HJ01'))&&($GI_CC=="X"))||($SFG=="X")||($MPAKET=="X")||($TPAKET=="X")) {
    		$this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
      		$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
    		$this->db->from('m_item');
//  		    $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
//		    $this->db->where('m_mapping_item.kdplant',$kd_plant);
            if($SFG=="X"){
              $where = "m_item.MATNR NOT IN
                       (SELECT kode_sfg FROM m_sfgs_header WHERE kode_sfg = m_item.MATNR
                        AND m_sfgs_header.plant = m_mapping_item.kdplant)";
              $this->db->where($where);
              if ($this->l_general->leftstr($kd_plant,1)=='J')
                $this->db->where('MTART','ZSFJ');
              else if ($this->l_general->leftstr($kd_plant,1)=='B')
                $this->db->where('MTART','ZSFB');
            }
            if($TPAKET=="X"){
              $where = "m_item.MATNR IN
                       (SELECT kode_paket FROM m_mpaket_header WHERE kode_paket = m_item.MATNR)";
              $this->db->where($where);
            }
          	$this->db->order_by('m_item.MATNR');
        } else {
			//print_r($this->sap_db());
      		$this->db->select('m_item.*,DSNAM');
      		$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
    		$this->db->from('m_item');
//    		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
    		$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
//    		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO AND m_item_group.kdplant = m_mapping_item.kdplant','inner');
    		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
          	$this->db->where('transtype', $trans_type);
    		$this->db->where('m_item_group.kdplant',$kd_plant); 

			$dept=substr($kd_plant,0,2);
			//2012-05-11 -- Mimi (BT): hilangkan ZOT2 Supplies, Santry & Ctk BJ --> Request Non Std Stock
            if ($REQ_NON_STDSTCK=="X"){
			//echo "(".$REQ_NON_STDSTCK.")";
				$where = "(m_item.PRC='Y')";
				$this->db->where($where);
			}
			/*if ($STOCK_OPNAME=="X"){
			//echo "(".$dept.")";
				if ($dept=="01")
				{
					$where = "(m_item.CSHOP='1')";
				}else if ($dept=="02")
				{
					$where = "(m_item.PASTRY='1')";
				}else if ($dept=="05")
				{
					$where = "(m_item.STORE='1')";
				}
				$this->db->where($where);
			}*/
			
            if($GR_FG=="X"){
//              $where = "(m_item.MTART<>'ZFG5' OR m_mapping_item.kdplant IN ('B018',
//                          'B019','B022','B026','B027','B031','B052','B053','B061','B068','B088','B093'))"; // 2012-02-07
			  //	$kd_plant_spc=Array('B018','B022','B026','B027','B031','B052','B053','B061','B068','B088','B093','B105','B106');
			  	//mysql_connect("localhost","root","");
				//mysql_select_db("sap_php");
				$t=mysql_query("SELECT OUTLET FROM m_outlet");
				while($r=mysql_fetch_array($t))
				{
					$kd_plant_spc[$r['OUTLET']] = $r['OUTLET'];
				}
               //print_r($kd_plant_spc);
				if ($this->l_general->leftstr($kd_plant,1)=='B'){  // 2012-04-14 -- Mimi request, BID hanya ZFG1
					if (in_array($kd_plant,$kd_plant_spc)) {
						$where = "(m_item.MTART='ZFG1' OR m_item.MTART='ZFG5')";
					} else {
						$where = "(m_item.MTART='ZFG1')";
					}
				} else {
					$where = "(m_item.MTART='ZFG1' OR m_item.MTART='ZFG2')";
//					$where = "(m_item.MTART='ZFG1' OR m_item.MTART='ZFG2' OR m_item.MTART='ZFG3' OR m_item.MTART='ZFG7' OR m_item.MTART='ZFG9')";
				}
				$this->db->where($where);
            }
            if(($TWTS=="X")||($WTS=="X")||($WTS_MATR=="X")){
//              $where = "LEFT(m_item.MATNR,2) = 'B1' ";
				//$group=Array(130,131,132,133,134,135,136);
				
              $where = "(m_item.DISPO = '125' OR m_item.DISPO = '126' OR m_item.DISPO = '127' OR m_item.DISPO = '133' OR m_item.DISPO = '134' OR m_item.DISPO = '135' OR m_item.DISPO = '136' )";
              $this->db->where($where);
			  // $this->db->where('m_item.DISPO', '131');

              if($TWTS=="X") {
                $where = 'm_item.MATNR IN (SELECT kode_whi FROM m_mwts_header
                                           WHERE kode_whi = m_item.MATNR AND plant = "'.$kd_plant.'")';
                $this->db->where($where);
              }
            }
          	$this->db->order_by('m_item.MATNR');
        }

		$query = $this->db->get();
		if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_2_back() {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
        	$this->db->select('MATNR,MAKTX,UNIT');
      		//$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
    		$this->db->from('m_item');
    	  	$this->db->where('PRC', 'N');
			
			$query = $this->db->get();
		if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
    	

	}
	
	function sap_db() {
	    	$this->db->select('*');
      		//$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
    		$this->db->from('t_con');
    	  	//$this->db->where('PRC', 'N');
			
			$query = $this->db->get();
		if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
    	

	}

	function sap_item_groups_select_all_gitcc() {
        $item_groups = $this->sap_item_groups_select_all_2("X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_gisto() {
        $item_groups = $this->sap_item_groups_select_all_2("","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_grfg() {
        $item_groups = $this->sap_item_groups_select_all_2("","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_sfgs() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_sfgs_matr() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_mwts() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_mwts_matr() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_twts() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_twts_gr() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_mpaket() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_tpaket() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_tpaket_back() {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
//       $this->db->select('m_item.*,space(0) as DSNAM');
//      		$this->db->select('m_item.MATNR AS MATNR1');
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM, m_item.MATNR AS MATNR1');
    		$this->db->from('m_item');
  		    $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_mpaket_header','m_mpaket_header.kode_paket = m_item.MATNR','inner');
		    $this->db->where('m_mapping_item.kdplant',$kd_plant);
			$this->db->group_by('m_item.MATNR');
        
		$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	function sap_item_groups_select_all_wo_back() {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
     		$this->db->select('m_item.MATNR AS MATNR1,m_uom.UomCode as UNIT1');
//       $this->db->select('m_item.*,space(0) as DSNAM, m_item.MATNR AS MATNR1');
    		$this->db->from('m_item');
  		    $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_mpaket_header','m_mpaket_header.kode_paket = m_item.MATNR','inner');
			$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','inner');
		    $this->db->where('m_mapping_item.kdplant',$kd_plant);
			 $this->db->where('m_mpaket_header.plant',$kd_plant);
			$this->db->group_by('m_item.MATNR');
			
        
		$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function item_name($item) {
	 		$this->db->select('m_item.MAKTX');
    		$this->db->from('m_item');
			 $this->db->where('MATNR',$item);
			
        
		$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_twts_back() {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
     		$this->db->select('m_item.MATNR AS MATNR1,m_item.UNIT as UNIT1');
//       $this->db->select('m_item.*,space(0) as DSNAM, m_item.MATNR AS MATNR1');
    		$this->db->from('m_item');
  		    //$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_mwts_header','m_mwts_header.kode_whi = m_item.MATNR','inner');
		//	$this->db->join('m_mwts_detail','m_mwts_detail.material_no = m_item.MATNR','inner');
		//	$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','inner');
		    //$this->db->where('m_mapping_item.kdplant',$kd_plant);
			 $this->db->where('m_mwts_header.plant',$kd_plant);
			$this->db->group_by('m_item.MATNR');
        
		$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_prod() {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
     		$this->db->select('m_item.MATNR AS MATNR1,m_item.UNIT as UNIT1');
//       $this->db->select('m_item.*,space(0) as DSNAM, m_item.MATNR AS MATNR1');
    		$this->db->from('m_item');
  		    //$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_mpaket_header','m_mpaket_header.kode_paket = m_item.MATNR','inner');
		//	$this->db->join('m_mwts_detail','m_mwts_detail.material_no = m_item.MATNR','inner');
		//	$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','inner');
		    //$this->db->where('m_mapping_item.kdplant',$kd_plant);
			 $this->db->where('m_mpaket_header.plant','WMSIASST');
			$this->db->group_by('m_item.MATNR');
        
		$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_tpaket_back_2($kode_item_paket) {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM,m_uom.UomCode as UNIT1');
      		$this->db->select('m_mpaket_detail.material_no AS MATNR1');
    		$this->db->from('m_item');
  		    $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
			$this->db->join('m_mpaket_header','m_mpaket_header.kode_paket = m_item.MATNR','inner');
			$this->db->join('m_mpaket_detail','m_mpaket_detail.id_mpaket_header = m_mpaket_header.id_mpaket_header','inner');
		    $this->db->where('m_mapping_item.kdplant',$kd_plant);   
			$this->db->where('m_mpaket_header.plant',$kd_plant);   
			 $this->db->where('m_mpaket_header.kode_paket',$kode_item_paket);   
              //$this->db->where($where);

			$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}
	
	function sap_item_groups_select_all_twts_back_2($kode_item_paket) {
	 $kd_plant = $this->session->userdata['ADMIN']['plant'];
       $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM,m_uom.UomCode as UNIT1');
      		$this->db->select('m_mwts_detail.material_no AS MATNR1');
    		$this->db->from('m_item');
  		    $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
			$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
			$this->db->join('m_mwts_header','m_mwts_header.kode_whi = m_item.MATNR','inner');
			$this->db->join('m_mwts_detail','m_mwts_detail.id_mwts_header = m_mwts_header.id_mwts_header','inner');
		    $this->db->where('m_mapping_item.kdplant',$kd_plant);   
			$this->db->where('m_mwts_header.plant',$kd_plant);   
			 $this->db->where('m_mwts_header.kode_whi',$kode_item_paket);   
              //$this->db->where($where);
//echo $kode_item_paket;
			$query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
          return $query->result_array();
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_grnonpo() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_pr() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_stdstock() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_stockoutlet() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_opnd() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_tssck() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_waste() {
        $item_groups = $this->sap_item_groups_select_all_2("","","","","","","","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

    /*
	function sap_item_groups_select_all_finish_goods() {
        $item_groups = $this->sap_item_groups_select_all("X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_non_std_stock() {
        $item_groups = $this->sap_item_groups_select_all("","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_std_stock() {
        $item_groups = $this->sap_item_groups_select_all("","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}

	function sap_item_groups_select_all_semi_fg() {
        $item_groups = $this->sap_item_groups_select_all("","","","X");
        if (count($item_groups) > 0) {
          return $item_groups;
        } else {
          return FALSE;
        }
	}
    */
	function sap_item_group_select($item_group_code) {
		$this->db->from('m_item_group');
      	$this->db->where('DSNAM', $item_group_code);
      	$this->db->where('kdplant', $this->session->userdata['ADMIN']['plant']);
		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			return $query->row_array();
		}	else {
			return FALSE;
		}

	}

	function id_plant_new_select($id_outlet,$nm_modul,$field_tgl_posting="posting_date") {
        $posting_date = date('Y-m-d');

		$this->db->select_max('id_'.$nm_modul.'_plant');
		$this->db->from('t_'.$nm_modul.'_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE('.$field_tgl_posting.')', $posting_date);

		$query = $this->db->get();
		if(($query)&&($query->num_rows() > 0)) {
			$tmp = $query->row_array();
			$id_plant = $tmp['id_'.$nm_modul.'_plant'] + 1;
		}	else {
			$id_plant = 1;
		}
		return $id_plant;
	}

	function posting_date_select_max() {
	    $id_outlet = $this->session->userdata['ADMIN']['plant'];
		$this->db->select_max('posting_date');
		$this->db->from('t_posinc_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('status', 2);
//		$this->db->where('waste_no is not null AND waste_no <> "" ');

		$query = $this->db->get();
		if ($query) {
			$posting_date = $query->row_array();
		}
		if(!empty($posting_date['posting_date'])) {
		    $oneday = 60 * 60 * 24;
            $posting_date = date("Y-m-d H:i:s", strtotime($posting_date['posting_date'])+ $oneday);
            return $posting_date;
		}	else {
        	return date("Y-m-d H:i:s");
		}
	}


	function posting_date_current_date() {
     return date("Y-m-d H:i:s");
	}

	function check_is_can_approve($posting_date) {
   	    $id_outlet = $this->session->userdata['ADMIN']['plant'];
        $business_date = $this->posting_date_select_max();
        $posting_date = date("Y-m-d",strtotime($this->l_general->str_to_date($posting_date)));
        $posting_date1 = $posting_date;
        $posting_date = $this->l_general->date_add_day($posting_date,-1);
        $posting_date = date("Y-m-d",strtotime($this->l_general->str_to_date($posting_date)));

		$this->db->from('t_statuseod');
		$this->db->where('plant', $id_outlet);
		$this->db->where('status_eod_sap', 1);
		$this->db->where('DATE(posting_date) = ', $posting_date);
		$query = $this->db->get();
		if((($query)&&($query->num_rows() > 0)) ||
         ((date("H")>=3))) {
		}	else {
        	return TRUE;
		}
        
        if ($this->is_show_btn_approve()==TRUE)
            return TRUE;
        else
            return TRUE;
	}

	function is_show_btn_approve() {
      if ((date("H") >= 2)&&(date("H") <=4 ))
            return FALSE;
      else
            return TRUE;
   }

	function sap_items_select_by_item_group($item_group, $item_choose = 1,$trans_type,$twts="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];

  		if($item_choose == 1) {
    		$this->db->select('m_item.MATNR,MAKTX,MEINS,UNIT');
        } else if($item_choose == 2) {
    		$this->db->select('MAKTX,m_item.MATNR,MEINS,UNIT');
        }
		
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1, SPACE(1) AS DistNumber');
		$this->db->from('m_item');
//		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
//		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO AND m_item_group.kdplant = m_mapping_item.kdplant','inner');
		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
//		$this->db->join('m_batch','m_item.MATNR = m_batch.ItemCode','left');
		$this->db->where('transtype', $trans_type);
		$this->db->where('m_item_group.kdplant',$kd_plant);
      	$this->db->where('m_item_group.DSNAM', $item_group);

        if($twts=="X") {
          $where = 'm_item.MATNR IN (SELECT kode_whi FROM m_mwts_header
                                     WHERE kode_whi = m_item.MATNR AND plant = "'.$kd_plant.'")';
          $this->db->where($where);
        }

		$query = $this->db->get();
/*
if ($this->session->userdata['ADMIN']['plant']=='B001'){
echo '<pre>';
echo $this->db->last_query();
echo '</pre>';
	die('a');
}
*/

		if(($query)&&($query->num_rows() > 0)) {
			return $query->result_array();
		}	else {
			return FALSE;
		}
	}
	
	function sap_items_select_by_item_group_non($item_group, $item_choose = 1,$trans_type,$twts="") {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];

  		if($item_choose == 1) {
    		$this->db->select('m_item.MATNR,MAKTX,MEINS,UNIT');
        } else if($item_choose == 2) {
    		$this->db->select('MAKTX,m_item.MATNR,MEINS,UNIT');
        }
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_item');
		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		//$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO AND m_item_group.kdplant = m_mapping_item.kdplant','inner');
		//$this->db->join('m_batch','m_item.MATNR = m_batch.ItemCode','left');
		//$this->db->where('transtype', $trans_type);
		$this->db->where('m_mapping_item.kdplant',$kd_plant);
      	$this->db->where('m_item_group.DSNAM', $item_group);
		$this->db->where("m_item.PRC ='Y'");

        if($twts=="X") {
          $where = 'm_item.MATNR IN (SELECT kode_whi FROM m_mwts_header
                                     WHERE kode_whi = m_item.MATNR AND plant = "'.$kd_plant.'")';
          $this->db->where($where);
        }

		$query = $this->db->get();
/*
if ($this->session->userdata['ADMIN']['plant']=='B001'){
echo '<pre>';
echo $this->db->last_query();
echo '</pre>';
	die('a');
}
*/

		if(($query)&&($query->num_rows() > 0)) {
			return $query->result_array();
		}	else {
			return FALSE;
		}
	}
	
	function sap_items_select_by_item_group_opname($item_group, $item_choose = 1,$trans_type) {
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];

  		if($item_choose == 1) {
    		$this->db->select('m_item.MATNR,MAKTX,MEINS,UNIT');
        } else if($item_choose == 2) {
    		$this->db->select('MAKTX,m_item.MATNR,MEINS,UNIT');
        }
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_item');
//		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		//$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
		//$this->db->join('m_batch','m_item.MATNR = m_batch.ItemCode','left');
		//$this->db->where('transtype', $trans_type);
		$this->db->where('m_item_group.kdplant',$kd_plant);
      	$this->db->where('m_item_group.DSNAM', $item_group);
		//$this->db->where("m_item.PRC ='Y'");

        /*if($twts=="X") {
          $where = 'm_item.MATNR IN (SELECT kode_whi FROM m_mwts_header
                                     WHERE kode_whi = m_item.MATNR AND plant = "'.$kd_plant.'")';
          $this->db->where($where);
        }*/

		$query = $this->db->get();
/*
if ($this->session->userdata['ADMIN']['plant']=='B001'){
echo '<pre>';
echo $this->db->last_query();
echo '</pre>';
	die('a');
}
*/

		if(($query)&&($query->num_rows() > 0)) {
			return $query->result_array();
		}	else {
			return FALSE;
		}
	}

	function sap_item_select_by_item_code($item_code) {
	//echo $item_code;
	    $kd_plant = $this->session->userdata['ADMIN']['plant'];
   		$this->db->select('m_item.*,m_uom.UomCode as UNIT1');
      	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
		$this->db->from('m_item');
//		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
		$this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
		$this->db->where('m_item.MATNR', $item_code);
//		$this->db->where('m_mapping_item.kdplant',$kd_plant);
		$query = $this->db->get();
		if(($query)&&($query->num_rows() > 0)) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
	} 
	
	
	function sap_jenisoutlets_select_all() {
		$this->db->from('t_jenisoutlet');
		$this->db->order_by('jenisoutlet');

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}
	
	function batch() {
		$this->db->from('m_batch');
		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query;
		else
			return FALSE;
	}

	function sap_jenisoutlet_select($id_jenisoutlet) {
		$this->db->from('t_jenisoutlet');
		$this->db->where('id_jenisoutlet', $id_jenisoutlet);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query->row_array();
		else
			return FALSE;
	}

	function sap_get_plant_type_id($plant) {
		$this->db->select('comp_code');
		$this->db->from('m_outlet');
		$this->db->where('outlet', $plant);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)){
			$hasil =  $query->row_array();
			return $hasil['comp_code'];
		} else {
			return FALSE;
		}
	}
	
	function sap_get_user_plants($admin_id) {
		$this->db->select('plants');
		$this->db->from('d_admin');
		$this->db->where('admin_id', $admin_id);

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)){
			$hasil =  $query->row_array();
			return $hasil['plants'];
		} else {
			return FALSE;
		}
	}	

	// diubah dari yang sebelumnya
/*	function sap_plants_select_all($plant_type_id = 0) {
		$this->db->from('wiwid_s_plant');

		if(!empty($plant_type_id))
    	$this->db->where('plant_type_id', $plant_type_id);

		$this->db->order_by('plant');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}     */


}
?>
