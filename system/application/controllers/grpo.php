<?php
class Grpo extends Controller {
	private $jagmodule = array();


	function Grpo() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1032);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grpo'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_grpo');
		$this->load->model('m_general');
		$this->load->model('m_database');
		$this->load->model('m_printgrpo');

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));
	}

	// main function
	function index()
	{
		$this->browse();
	}

	// list data
	function browse() {
		$grpo_browse_result = $this->session->userdata['PAGE']['grpo_browse_result'];

		if(!empty($grpo_browse_result))
			redirect($this->session->userdata['PAGE']['grpo_browse_result']);
		else
			redirect('grpo/browse_result/0/0/0/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		if(empty($_POST['date_from']) || ($_POST['date_from'] == '--')) {
			$date_from = 0;
		} else {
			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['date_to']) || ($_POST['date_to'] == '--')) {
			$date_to = 0;
		} else {
			$date = explode("-", $_POST['date_to']);
			$date_to = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}
        if (empty($limit)) {
		  $limit = 10;
        }
//		redirect('grpo/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grpo/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grpo_browse_result');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);

		$object['form2'] = array(
			'name'	=>	'form2',
			'id'	=>	'form2',
		);
		// end of form attributes

		$object['data']['field_name'] = $field_name;
		$object['data']['field_type'] = $field_type;

		if($field_content !== '0') {
			$object['data']['field_content'] = $field_content;
		} else {
			$object['data']['field_content'] = '';
		}

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['data']['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
			$object['data']['date_from'] = '';
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['data']['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['data']['date_to'] = '';
			$date_to2 = '0';
		}


		unset($year);
		unset($month);
		unset($day);
/*
		$object['data']['sort1'] = $sort1;
		$object['data']['sort2'] = $sort2;
		$object['data']['sort3'] = $sort3;
*/
		$object['data']['sort'] = $sort;

		$object['data']['status'] = $status;
		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;

		$object['field_name'] = array (
			'a'	=>	'Goods Receipt No',
			'b'	=>	'Purchase Order No',
			'c'	=>	'Vendor Code',
		);

		$object['field_type'] = array (
			'part'	=>	'Any Part of Field',
			'all'	=>	'All Part of Field',
		);

		$object['status'] = array (
			'0'	=>	'',
			'1'	=>	'Not Approved',
			'2'	=>	'Approved',
		);
/*
		$object['sort'] = array (
			'gy'	=>	'Goods Receipt No ASC',
			'gz'	=>	'Goods Receipt No DESC',
			'py'	=>	'Purchase Order No ASC',
			'pz'	=>	'Purchase Order No DESC',
			'vy'	=>	'Vendor Code ASC',
			'vz'	=>	'Vendor Code DESC',
			'ny'	=>	'Vendor Name ASC',
			'nz'	=>	'Vendor Name DESC',
			'dy'	=>	'Posting Date ASC',
			'dz'	=>	'Posting Date DESC',
		);
*/

		$sort_link1 = 'grpo/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
			'by'	=>	$sort_link1.'by'.$sort_link2,
			'bz'	=>	$sort_link1.'bz'.$sort_link2,
			'cy'	=>	$sort_link1.'cy'.$sort_link2,
			'cz'	=>	$sort_link1.'cz'.$sort_link2,
			'dy'	=>	$sort_link1.'dy'.$sort_link2,
			'dz'	=>	$sort_link1.'dz'.$sort_link2,
			'ey'	=>	$sort_link1.'ey'.$sort_link2,
			'ez'	=>	$sort_link1.'ez'.$sort_link2,
			'fy'	=>	$sort_link1.'fy'.$sort_link2,
			'fz'	=>	$sort_link1.'fz'.$sort_link2,
			'gy'	=>	$sort_link1.'gy'.$sort_link2,
			'gz'	=>	$sort_link1.'gz'.$sort_link2,
			'hy'	=>	$sort_link1.'hy'.$sort_link2,
			'hz'	=>	$sort_link1.'hz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('grpo/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grpo->grpo_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grpo_headers'] = $this->m_grpo->grpo_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Goods Receipt PO from Vendor';
		$this->template->write_view('content', 'grpo/grpo_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
//		if(!empty($_POST['kd_vendor'])) {
			$data = $_POST;
			$object['data'] = $data;

            $gr_quantity = array('gr_quantity' => '');
            $this->session->unset_userdata($gr_quantity);

			// kd_vendor will be changed if nm_vendor changed
			// nm_vendor will be changed if kd_vendor changed

		} else {
			$object['data'] = NULL;
			
			$object['data']['po_no'] = '-';

		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
        if(empty($this->session->userdata['grpo_nos'])||(empty($data))) {
      		$data['po_nos'] = $this->m_grpo->sap_grpo_headers_select_by_kd_vendor();
      		$this->session->set_userdata('grpo_nos', $data['po_nos']);
			//print_r($data['po_nos']);
        } else {
            $data['po_nos'] = $this->session->userdata['grpo_nos'];
			//print_r($data['po_nos']);
        }
		
		$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
      $con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
      //$db=mssql_select_db('MSI',$con);

  		if($data['po_nos'] !== FALSE) {
  			$object['po_no']['-'] = '';
  			foreach ($data['po_nos'] as $po_no) {
				
				$rq=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT A.DocEntry FROM PRQ1 A
JOIN POR1 B ON B.BaseRef=A.DocEntry
WHERE B.DocEntry='$po_no[EBELN]'"));
//$DOC=mssql_fetch_array($QUERY);
$nopo=$rq['DocEntry'];

if (!empty($nopo))
{
	$nop=$nopo;
}else
{
	$nop="None";
}

  				$object['po_no'][$po_no['EBELN']] = $po_no['EBELN'].' - '.$po_no['DOCNUM'].'( PR ->'.$nop.' )';
  			}
  		}
		sqlsrv_close($con);
		
		if(!empty($data['po_no'])) {
			$object['data']['grpo_header'] = $this->m_grpo->sap_grpo_header_select_by_po_no($data['po_no']);
			$data['kd_vendor'] = $object['data']['grpo_header']['VENDOR'];
			$data['nm_vendor'] = $object['data']['grpo_header']['VENDOR_NAME'];
			$data['delivery_date'] = $object['data']['grpo_header']['DELIV_DATE'];

    		$data['item_groups'] = $this->m_grpo->sap_grpo_select_item_group_po($data['po_no']);

  			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			  $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
    	}

		$this->session->set_userdata('nm_vendor', $data['nm_vendor']);

		if(!empty($data['item_group_code'])) {
			redirect('grpo/input2/'.$data['kd_vendor'].'/'.$data['po_no'].'/'.$data['item_group_code'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'Goods Receipt PO from Vendor<div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang PO dari Vendor</div>';
		$this->template->write_view('content', 'grpo/grpo_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_no($_POST['grpo_header']['po_no']);

			$i = 1;
			foreach ($object['grpo_details'] as $object['grpo_detail']) {

                    if ($i==$_POST['grpo_detail']['id_grpo_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grpo_detail']['gr_quantity'][$i], "grpo_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpo_detail']['BSTMG']);
    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$i]['error'] == TRUE)
    						$validation_temp = FALSE;
                    }
				$i++;
			}

			// set $validation, based on $validation_temp value;
			$validation = $validation_temp;

		}

		if ($validation == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
 			$this->_input_form(0, $data, $check);
	   	} else {
     	        $this->_input_form();
			}

		} else {
			$this->_input_add();
		}

	}

	function _input_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if((count($_POST) != 0)&&(!empty($check))) {
	      $object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$kd_vendor = $this->uri->segment(3);
		$po_no = $this->uri->segment(4);
		$item_group_code = $this->uri->segment(5);
		$nm_vendor = $this->session->userdata['nm_vendor'];
        $DOCNUM='';
        if (empty($nm_vendor) || empty($DOCNUM)) {
    	   $vendor = $this->m_grpo->sap_grpo_header_select_by_po_no($po_no);
           $nm_vendor = $vendor['VENDOR_NAME'];
		   $DOCNUM = $vendor['DOCNUM'];
        }

        $nm_vendor1 = array('nm_vendor' => '');
        $this->session->unset_userdata($nm_vendor1);

		$delivery_date = $this->uri->segment(6);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
    	if(!empty($po_no)) {
    		$object['grpo_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$object['grpo_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
    		$object['grpo_header']['item_group_code'] = $item_group_code;
    		$object['grpo_header']['EBELN'] = $po_no;
    		$object['grpo_header']['kd_vendor'] = $kd_vendor;
    		$object['grpo_header']['nm_vendor'] = $nm_vendor;
    		$object['grpo_header']['delivery_date'] = $delivery_date;
			$object['grpo_header']['DOCNUM'] = $DOCNUM;
			//echo  '{'.$this->m_database->get_database().'}';

			
			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
				if($item_group_code == 'all') {
					$object['item_group']['item_group_code'] = $item_group_code;
					$object['item_group']['item_group_name'] = '<strong>All</strong>';
					$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_no($po_no);
					//echo print_r($object['grpo_details']);
				} else {
					$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
					$object['item_group']['item_group_name'] = $item_group_code;
					$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_and_item_group($po_no,$object['item_group']['DISPO']);
				}
			}
    	}
		if(($object['grpo_details'] !== FALSE)&&(!empty($object['grpo_details']))) {
			$i = 1;
			foreach ($object['grpo_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpo_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    		$object['data']['grpo_details'] = $this->m_grpo->grpo_details_select($object['data']['id_grpo_header']);

    		if($object['data']['grpo_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpo_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpo_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Goods Receipt PO from Vendor<div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang PO dari Vendor</div>';
		$this->template->write_view('content', 'grpo/grpo_edit', $object);
		$this->template->render();
	}

	function refresh_po_list() {
      $object['refresh'] = 1;
      $object['refresh_time'] = 1;
	  $db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
	  /*$server = '192.168.0.20';
      $username = 'sa';
      $password = 'M$1S@p!#@';
      $server1='localhost';
      $username1='root';
      $password1='';*/
      $con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));//mssql_connect($server, $username, $password);
      //$db=mssql_select_db('MSI',$con);

      $con1=mysql_connect("localhost", $user_mysql,$pass_mysql);
      $db1=mysql_select_db($db_mysql, $con1);
      
		//$this->m_database->get_mysql();
		//$this->m_database->get_sql();	
      $plant=$this->session->userdata['ADMIN']['plant'];

      $sqlDELETE = mysql_query("DELETE FROM `ZMM_BAPI_DISP_PO_OUTSTANDING` WHERE `PLANT`='$plant'", $con1);

	  $querySQL=mysql_query('SELECT EBELN FROM zmm_bapi_disp_po_outstanding', $con1);
	  $querySAP=sqlsrv_query($con,"SELECT WhsCode,POR1.DocEntry,LineNum,OPOR.CardCode, OPOR.CardName,
	   POR1.ItemCode, Dscription, OpenQty,(Quantity - OpenQty) as BSTMG_APRVD ,
	   unitMsr, OITM.ItmsGrpCod, CONVERT(VARCHAR(8),POR1.ShipDate,112) ShipDate
	   ,SeriesName + RIGHT('00000' + CONVERT(varchar, OPOR.DocNum), 5) AS NO_PO
      FROM POR1
      JOIN OPOR on POR1.DocEntry = OPOR.DocEntry
      JOIN OITM on POR1.ItemCode = OITM.ItemCode
	  JOIN NNM1 ON OPOR.Series=NNM1.Series WHERE WhsCode = '$plant'");
	  /*echo "SELECT WhsCode,POR1.DocEntry,LineNum,OPOR.CardCode, OPOR.CardName,
	   POR1.ItemCode, Dscription, OpenQty,(Quantity - OpenQty) as BSTMG_APRVD ,
	   unitMsr, OITM.ItmsGrpCod, CONVERT(VARCHAR(8),POR1.ShipDate,112) ShipDate
	   
      FROM POR1
      JOIN OPOR on POR1.DocEntry = OPOR.DocEntry
      JOIN OITM on POR1.ItemCode = OITM.ItemCode WHERE WhsCode = '$plant'"*/;
      if ($querySAP)
      {
          echo 'Berhasil konek!';
      }
      else
      {
          echo 'Koneksi GAGAL!';
      }
      while ($rowSAP = sqlsrv_fetch_array($querySAP))
      {
          /*$plant =strval($rowSAP['WhsCode']);
          $ebeln =$rowSAP['DocEntry'];
          $cekQuery=mysql_query("SELECT * FROM zmm_bapi_disp_po_outstanding where EBELN = '$ebeln'");
          $cekRow=mysql_num_rows($cekQuery);
          if ($cekRow==0)
          { */
          $plant =strval($rowSAP['WhsCode']);
          $ebeln =$rowSAP['DocEntry'];
          $ebelp = $rowSAP['LineNum'];
          $vendor =$rowSAP['CardCode'];
          $vendorName=$rowSAP['CardName'];
          $matnr=$rowSAP['ItemCode'];
          $maktx=$rowSAP['Dscription'];
          $bstmg=$rowSAP['OpenQty'];
          $bstmg_aprvd=$rowSAP['BSTMG_APRVD'];
          $bstme=$rowSAP['unitMsr'];
          $dispo=$rowSAP['ItmsGrpCod'];
          $deliv_date=strval($rowSAP['ShipDate']);
		  $DOCNUMBER=$rowSAP['NO_PO'];
		  $maktx = mysql_real_escape_string($maktx);
			
         /* $saveToSQL=mysql_query("INSERT INTO zmm_bapi_disp_po_outstanding
          (PLANT,EBELN,EBELP,VENDOR,VENDOR_NAME,MATNR,MAKTX,BSTMG,BSTMG_APRVD,BSTME,DISPO,DELIV_DATE)
          VALUES ('$plant',$ebeln,$ebelp,'$vendor','$vendorName','$matnr','$maktx',$bstmg,$bstmg_aprvd,
          '$bstme','$dispo','$deliv_date')") ;*/
		 $saveToSQL=mysql_query("INSERT INTO zmm_bapi_disp_po_outstanding
          (PLANT,EBELN,EBELP,VENDOR,VENDOR_NAME,MATNR,MAKTX,BSTMG,BSTMG_APRVD,BSTME,DISPO,DELIV_DATE,DOCNUM)
          VALUES ('$plant',$ebeln,$ebelp,'$vendor','$vendorName','$matnr','$maktx',$bstmg,$bstmg_aprvd,
          '$bstme','$dispo','$deliv_date','$DOCNUMBER')", $con1) ; 
		 
//}

       }
	   
		sqlsrv_close($con);
		mysql_close($con1);

//echo "INSERT INTO zmm_bapi_disp_po_outstanding  VALUES ($plant,$ebeln,$ebelp,'$vendor','$vendorName','','','$matnr','$maktx',$bstmg,$bstmg_aprvd,'$bstme','','$dispo','','','','$deliv_date',0,'')";


      //$object['refresh_url'] = 'grpo/input';
      //$object['po_refresh_url'] = base_url().'getpovendor.php?plant='.$this->session->userdata['ADMIN']['plant'];
      $this->template->write_view('content', 'po_refresh', $object);
      $this->template->render();
//      redirect(base_url().'getpovendor.php?plant='.$this->session->userdata['ADMIN']['plant']);
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$grpo = $_POST;
		unset($grpo['button']);

		$count_filled = count($grpo['grpo_detail']['gr_quantity']);

		$count = count($grpo['grpo_detail']['id_grpo_h_detail']);
//echo '{'.$count.'}<br>';
		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpo['grpo_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpo/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpo['grpo_header']['posting_date'])==FALSE)) {
     	   redirect('grpo/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gr_quantity', $grpo['grpo_detail']['gr_quantity']);

 			$grpo_header['po_no'] = $grpo['grpo_header']['po_no'];
			$grpo_header['grpo_no'] = '';
			$grpo_header['kd_vendor'] = $grpo['grpo_header']['kd_vendor'];
			$grpo_header['delivery_date'] = $grpo['grpo_header']['delivery_date'];
			$grpo_header['nm_vendor'] = $grpo['grpo_header']['nm_vendor'];
			$grpo_header['docnum'] = $grpo['grpo_header']['docnum'];

//			$sap_grpo_header = $this->m_grpo->sap_grpo_header_select_by_po_no($grpo['grpo_header']['po_no']);

    		$grpo_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grpo_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
 			$grpo_header['posting_date'] = $this->l_general->str_to_date($grpo['grpo_header']['posting_date']);
			$grpo_header['id_grpo_plant'] = $this->m_grpo->id_grpo_plant_new_select($grpo_header['plant'],$grpo_header['posting_date']);

			if(isset($_POST['button']['approve']))
				$grpo_header['status'] = '2';
			else
				$grpo_header['status'] = '1';

			$grpo_header['item_group_code'] = $grpo['grpo_header']['item_group_code'];
			$grpo_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

             $web_trans_id = $this->l_general->_get_web_trans_id($grpo_header['plant'],$grpo_header['posting_date'],
                      $grpo_header['id_grpo_plant'],'01');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])){
                 $grpo_to_approve = array (
                        'plant' => $grpo_header['plant'],
                        'po_no' => $grpo_header['po_no'],
                        'posting_date' => date('Ymd',strtotime($grpo_header['posting_date'])),
                        'id_user_input' => $grpo_header['id_user_input'],
                        'web_trans_id' => $web_trans_id,
                  );
              }
              //

			if($id_grpo_header = $this->m_grpo->grpo_header_insert($grpo_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {
//echo $i.'<='.$count;
					if(!empty($grpo['grpo_detail']['gr_quantity'][$i])&&($grpo['grpo_detail']['gr_quantity'][$i]>0)) {
					//	$grpo_detail = $this->m_grpo->sap_grpo_details_select_by_po_and_item($grpo_header['po_no'],$grpo['grpo_detail']['item'][$i]);
						$grpo_detail_to_save['id_grpo_header'] = $id_grpo_header;
						$batch['BaseEntry'] = $id_grpo_header;
						$grpo_detail_to_save['id_grpo_h_detail'] = $grpo['grpo_detail']['id_grpo_h_detail'][$i];
						
						$batch['BaseLinNum'] = $grpo['grpo_detail']['id_grpo_h_detail'][$i];
						$grpo_detail_to_save['item'] = $grpo['grpo_detail']['item'][$i];
						$batch['ItemCode'] =  $grpo['grpo_detail']['material_no'][$i];//$grpo_detail['MATNR'];
						$batch1['ItemCode'] =  $grpo['grpo_detail']['material_no'][$i];//$grpo_detail['MATNR'];
						$item= $grpo['grpo_detail']['material_no'][$i];//$grpo_detail['MATNR'];
						$date=date('ymd');
						$whs=$this->session->userdata['ADMIN']['plant'];
						$db_mysql=$this->m_database->get_db_mysql();
						$user_mysql=$this->m_database->get_user_mysql();
						$pass_mysql=$this->m_database->get_pass_mysql();
						$db_sap=$this->m_database->get_db_sap();
						$user_sap=$this->m_database->get_user_sap();
						$pass_sap=$this->m_database->get_pass_sap();
						$host_sap=$this->m_database->get_host_sap();
						$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
						mysql_select_db($db_mysql, $con);
						$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
						//echo $q;
						$cek="SELECT BATCH FROM m_item WHERE MATNR = '$item'";
						$cek1=mysql_query($cek, $con);
						$ra=mysql_fetch_array($cek1);
						$b=$ra['BATCH'];
						$tq=mysql_query($q, $con);
						$count1=mysql_num_rows($tq) + 1;
						if ($count1 > 9 && $count1 < 100)
						{
							$dg="0";
						}
						else 
						{
							$dg="00";
						}
						$num=$item.$date.$dg.$count1;
						$batch['BatchNum'] = $num;
						$batch1['DistNumber'] = $num;
						$batch['Createdate'] = $this->l_general->str_to_date($grpo['grpo_header']['posting_date']);
						$batch['BaseType'] = 3;
						$grpo_detail_to_save['material_no'] = $grpo['grpo_detail']['material_no'][$i];//$grpo_detail['MATNR'];
						$grpo_detail_to_save['material_desc'] = $grpo['grpo_detail']['material_desc'][$i];//$grpo_detail['MAKTX'];
						$grpo_detail_to_save['outstanding_qty'] = $grpo['grpo_detail']['outstanding_qty'][$i];//$grpo_detail['BSTMG'];
						$grpo_detail_to_save['gr_quantity'] = $grpo['grpo_detail']['gr_quantity'][$i];
						$grpo_detail_to_save['qc'] = $grpo['grpo_detail']['qc'][$i];
						//echo '['.$grpo_detail_to_save['qc'].']';
						$batch['Quantity'] =  $grpo['grpo_detail']['gr_quantity'][$i];
						$batch1['Quantity'] =  $grpo['grpo_detail']['gr_quantity'][$i];
						$batch1['Whs'] = $whs;
						//echo $grpo_detail_to_save['material_no'].' - ';
						//sini neehh
  						$grpo_detail_to_save['uom'] = $grpo['grpo_detail']['uom'][$i];
						//echo '{'.$grpo_detail_to_save['uom'];
						//================
						$grpo_detail_to_save['ok'] = '1';
                        //array utk parameter masukan pada saat approval
                        $grpo_to_approve['item'][$i] = $grpo_detail_to_save['item'];
                        $grpo_to_approve['material_no'][$i] = $grpo_detail_to_save['material_no'];
                        $grpo_to_approve['gr_quantity'][$i] = $grpo_detail_to_save['gr_quantity'];
                        $grpo_to_approve['uom'][$i] = $grpo_detail['BSTME'];
                        //
//echo "<br>$batch[BaseEntry], $batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[BaseType] , ($b),$cek";
						unset($grpo_detail);
						if ($b == 'Y')
						{
						//echo "<br>$batch[BaseEntry], $batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[BaseType] , ($b),$cek";
						 $this->m_grpo->batch_insert($batch);
						  $this->m_grpo->batch_master($batch1);
						
						}
						mysql_close($con);
						
						if($this->m_grpo->grpo_detail_insert($grpo_detail_to_save))
                         $input_detail_success = TRUE;

					}

				}

			}

            $this->db->trans_complete();
            $po_nos1 = array('grpo_nos' => '');
            $this->session->unset_userdata($po_nos1);


			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			   // $approved_data = $this->m_grpo->sap_grpo_header_approve($grpo_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			  //  $grpo_no = $approved_data['material_document'];
    				$data = array (
    					'id_grpo_header'	=>$id_grpo_header,
    					'grpo_no'	=>	$grpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grpo->grpo_header_update($data);
					
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
           // }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			     $this->l_general->success_page('Data Goods Receipt PO from Vendor berhasil dimasukkan', site_url('grpo/input'));
              } else {
                $this->m_grpo->grpo_header_delete($id_grpo_header);
 			    $this->jagmodule['error_code'] = '001';
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO from Vendor tidak berhasil dimasukkan', site_url($this->session->userdata['PAGE']['next']));              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Goods Receipt PO from Vendor berhasil diapprove', site_url('grpo/input'));
              } else {
                $this->m_grpo->grpo_header_delete($id_grpo_header);
				$this->jagmodule['error_code'] = '002';
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO from Vendor tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		}

        }
	}


	 /*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grpo/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor berhasil diapprove';
		$object['refresh_url'] = site_url('grpo/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor berhasil dimasukkan';
		$object['refresh_url'] = site_url('grpo/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	}

                 */
	function edit() {

	    $grpo_header = $this->m_grpo->grpo_header_select($this->uri->segment(3));
		$status = $grpo_header['status'];
        unset($grpo_header);

        $gr_quantity = array('gr_quantity' => '');
        $this->session->unset_userdata($gr_quantity);

    	$validation = FALSE;

        if ($status !== '2') {
    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

//    			$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_no($_POST['grpo_header']['po_no']);

				//echo "<pre>";
				//print_r($_POST['grpo_detail'] );
				//echo "</pre>";
				//die;
				
    			$i = 1;
				foreach ($_POST['grpo_detail']['id_grpo_h_detail'] as $object['grpo_detail']) {

    				$check[$i] = $this->l_form_validation->set_rules($_POST['grpo_detail']['gr_quantity'][$i], "grpo_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$_POST['grpo_detail']['outstanding_qty'][$i]);

    					// if one data FALSE, set $validation_temp to FALSE
    				if($check[$i]['error'] == TRUE)
    					$validation_temp = FALSE;
    				$i++;
    			}

    			/*
				foreach ($object['grpo_details'] as $object['grpo_detail']) {

                    if ($i==$_POST['grpo_detail']['id_grpo_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grpo_detail']['gr_quantity'][$i], "grpo_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpo_detail']['BSTMG']);

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$i]['error'] == TRUE)
    						$validation_temp = FALSE;
                    }
    				$i++;
    			}
				*/

    			// set $validation, based on $validation_temp value;
    			$validation = $validation_temp;
    		}
        }

		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$grpo_header = $this->m_grpo->grpo_header_select($this->uri->segment(3));

				if($grpo_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grpo_header'] = $this->m_grpo->grpo_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {
			$this->_edit_update();
		}

	}

	function _edit_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if((count($_POST) != 0)&&(!empty($check))) {
		  $object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['grpo_header']['status_string'] = ($object['data']['grpo_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_grpo_header = $data['grpo_header']['id_grpo_header'];
		$kd_vendor = $data['grpo_header']['kd_vendor'];
		$po_no = $data['grpo_header']['po_no'];

		if(count($_POST) == 0) {
    		$item_group_code = $data['grpo_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes


		$object['grpo_header']['id_grpo_header'] = $id_grpo_header;
		$object['grpo_header']['kd_vendor'] = $kd_vendor;
		$object['grpo_header']['nm_vendor'] = $data['grpo_header']['nm_vendor'];
		$object['grpo_header']['delivery_date'] = $data['grpo_header']['delivery_date'];
		$object['grpo_header']['EBELN'] = $po_no;
		$object['grpo_header']['DOCNUM'] = $data['grpo_header']['docnum'];

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_no($po_no);
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_name'] = $item_group_code;
			$object['grpo_details'] = $this->m_grpo->sap_grpo_details_select_by_po_and_item_group($po_no,$object['item_group']['DISPO']);
		}

		if(($object['grpo_details'] !== FALSE)&&(!empty($object['grpo_details']))) {
			$i = 1;
			foreach ($object['grpo_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpo_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    	    $object['data']['grpo_details'] = $this->m_grpo->grpo_details_select($object['data']['grpo_header']['id_grpo_header']);

    		if($object['data']['grpo_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpo_details']->result_array() as $object['temp']) {
    //				$object['data']['grpo_detail'][$i] = $object['temp'];
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpo_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }
   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Goods Receipt PO from Vendor';
		$this->template->write_view('content', 'grpo/grpo_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grpo = $_POST;
		unset($grpo['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($grpo['grpo_detail']['gr_quantity']);

		$count = count($grpo['grpo_detail']['id_grpo_h_detail']);

		// variable to check, is at least one product gr_quantity entered?
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpo['grpo_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpo/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpo['grpo_header']['posting_date'])==FALSE)) {
     	   redirect('grpo/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		$edit_grpo_details = $this->m_grpo->grpo_details_select($grpo['grpo_header']['id_grpo_header']);
    	$i = 1;
	    foreach ($edit_grpo_details->result_array() as $value) {
		    $edit_grpo_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grpo_details);

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

    		$this->session->set_userdata('gr_quantity', $grpo['grpo_detail']['gr_quantity']);

            $postingdate = $grpo['grpo_header']['posting_date'];
			$year = $this->l_general->rightstr($postingdate, 4);
			$month = substr($postingdate, 3, 2);
			$day = $this->l_general->leftstr($postingdate, 2);
            $postingdate = $year."-".$month."-".$day.' 00:00:00';
   			$id_grpo_plant = $this->m_grpo->id_grpo_plant_new_select("",$postingdate,$grpo['grpo_header']['id_grpo_header']);

    			$data = array (
    				'id_grpo_header' =>	$grpo['grpo_header']['id_grpo_header'],
                    'id_grpo_plant' => $id_grpo_plant,
    				'posting_date' => $postingdate//date('Y-m-d'),// H:i:s', strtotime($grpo['grpo_header']['posting_date'])),
    			);
                $this->m_grpo->grpo_header_update($data);

                $edit_grpo_header = $this->m_grpo->grpo_header_select($grpo['grpo_header']['id_grpo_header']);

    			if ($this->m_grpo->grpo_header_update($data)) {
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grpo['grpo_detail']['gr_quantity'][$i])) {
        	    			$grpo_detail = array (
        						'id_grpo_detail'=>$grpo['grpo_detail']['id_grpo_detail'][$i],
        						'gr_quantity'=>$grpo['grpo_detail']['gr_quantity'][$i],
        					);
							$itemC=$grpo['grpo_detail']['material_no'][$i];
							$entry=$grpo['grpo_header']['id_grpo_header'];
							$line=$grpo['grpo_detail']['id_grpo_h_detail'][$i];
							$base= 3;
							$db_mysql=$this->m_database->get_db_mysql();
							$user_mysql=$this->m_database->get_user_mysql();
							$pass_mysql=$this->m_database->get_pass_mysql();
							$db_sap=$this->m_database->get_db_sap();
							$user_sap=$this->m_database->get_user_sap();
							$pass_sap=$this->m_database->get_pass_sap();
							$host_sap=$this->m_database->get_host_sap();
							$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
							mysql_select_db($db_mysql, $con);
							$que="SELECT BatchNum FROM t_batch WHERE ItemCode ='$itemC' AND BaseEntry='$entry' AND BaseLinNum='$line' AND BaseType='$base'";
							$qe=mysql_query($que, $con);
							$re=mysql_fetch_array($qe);
							$btc=$re['BatchNum'];
							$batch = array (
								'BaseEntry'=>$entry,
								'ItemCode'=>$itemC,
								'BatchNum'=>$btc,
        						'BaseLinNum'=>$line ,
								'BaseType'=> $base,
        						'Quantity'=>$grpo['grpo_detail']['gr_quantity'][$i]
								);
								
							//Dari sini
        						$grpo_detail['uom'] = $grpo['grpo_detail']['uom'][$i];
							//==============
        		    		if($this->m_grpo->grpo_detail_update($grpo_detail) && $this->m_grpo->batch_update($batch)) {
                                $input_detail_success = TRUE;
        			    	} else {
                                $input_detail_success = FALSE;
        			    	}
							//echo $que;
            			} else {
                          $this->m_grpo->grpo_detail_delete($grpo['grpo_detail']['id_grpo_detail'][$i]);
            			}
						
        	    	}
				
				mysql_close($con);
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grpo_to_approve['posting_date'] = date('Ymd',strtotime($edit_grpo_header['posting_date']));
                $grpo_to_approve['plant'] = $edit_grpo_header['plant'];
                $grpo_to_approve['id_grpo_plant'] = $edit_grpo_header['id_grpo_plant'];
                $grpo_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grpo_to_approve['po_no'] = $edit_grpo_header['po_no'];
                $grpo_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpo_header['plant'],$edit_grpo_header['posting_date'],
                      $edit_grpo_header['id_grpo_plant'],'01');
        		for($i = 1; $i <= $count+1; $i++) {
        		   $grpo_to_approve['item'][$i] = $edit_grpo_detail[$i]['item'];
        		   $grpo_to_approve['material_no'][$i] = $edit_grpo_detail[$i]['material_no'];
                   $grpo_to_approve['gr_quantity'][$i] = $grpo['grpo_detail']['gr_quantity'][$i];
        		   $grpo_to_approve['uom'][$i] = $edit_grpo_detail[$i]['uom'];
                }
			  //  $approved_data = $this->m_grpo->sap_grpo_header_approve($grpo_to_approve);
    		//	if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			//    $grpo_no = $approved_data['material_document'];
    				$data = array (
    					'id_grpo_header' =>$grpo['grpo_header']['id_grpo_header'],
    					'grpo_no'	=>	$grpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
					
    				$grpo_header_update_status = $this->m_grpo->grpo_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
			//	}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
   			    $this->l_general->success_page('Data Goods Receipt PO from Vendor berhasil diubah', site_url('grpo/browse'));
              } else {
 			    $this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO from Vendor tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt PO from Vendor berhasil diapprove', site_url('grpo/browse'));
  			    } else {
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO from Vendor tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}
/*
	function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grpo/browse';
 		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	}*/

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$grpo = $_POST;
		unset($grpo['button']);
		// end of assign variables and delete not used variables

        $date_today = date('d-m-Y');
		if($grpo['grpo_header']['posting_date']!=$date_today) {
    	  redirect('grpo/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

		// variable to check, is at least one product cancellation entered?
    	if(empty($grpo['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('grpo/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grpo', 1, date("Y-m-d")) {

        $edit_grpo_header = $this->m_grpo->grpo_header_select($grpo['grpo_header']['id_grpo_header']);
		$edit_grpo_details = $this->m_grpo->grpo_details_select($grpo['grpo_header']['id_grpo_header']);
    	$i = 1;
	    foreach ($edit_grpo_details->result_array() as $value) {
		    $edit_grpo_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grpo_details);

		if(isset($_POST['button']['cancel'])) {

//			$grpo_header['id_grpo_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $grpo_to_cancel['grpo_no'] = $edit_grpo_header['grpo_no'];
            $grpo_to_cancel['po_no'] = $edit_grpo_header['po_no'];
            $grpo_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grpo_header['posting_date']));
            $grpo_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grpo_header['posting_date']));
            $grpo_to_cancel['plant'] = $edit_grpo_header['plant'];
			$grpo_to_cancel['id_grpo_plant'] = $this->m_grpo->id_grpo_plant_new_select($edit_grpo_header['plant'],date('Y-m-d',strtotime($edit_grpo_header['posting_date'])));
            $grpo_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpo_header['plant'],$edit_grpo_header['posting_date'],
                      $grpo_to_cancel['id_grpo_plant'],'01');
            $grpo_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grpo_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grpo['cancel'][$i])) {
       		     $grpo_to_cancel['item'][$i] = $i;
       		     $grpo_to_cancel['item_po'][$i] = $edit_grpo_detail[$i]['item'];
       		     $grpo_to_cancel['gr_quantity'][$i] = $edit_grpo_detail[$i]['gr_quantity'];
               }
            }
          //  $cancelled_data = $this->m_grpo->sap_grpo_header_cancel($grpo_to_cancel);
 			$cancel_data_success = FALSE;
   			//if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			  //  $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grpo['cancel'][$i])) {
    	    			$grpo_header = array (
    						'id_grpo_header'=>$grpo['grpo_header']['id_grpo_header'],
    						'id_grpo_plant'=>$grpo_to_cancel['id_grpo_plant'],
    					);
    		    		if($this->m_grpo->grpo_header_update($grpo_header)==TRUE) {
        	    			$grpo_detail = array (
        						'id_grpo_detail'=>$edit_grpo_detail[$i]['id_grpo_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grpo->grpo_detail_update($grpo_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
           // }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
    			$this->l_general->success_page('Data Goods Receipt PO from Vendor berhasil dibatalkan', site_url('grpo/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO from Vendor tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));            
            }

/*			if($this->m_grpo->grpo_details_delete($grpo['id_grpo_header'])) {

				if(isset($_POST['button']['approve'])) {
					if($grpo_header = $this->m_grpo->grpo_header_select($grpo['id_grpo_header'])) {
						if($grpo_no = $this->m_grpo->sap_grpo_header_approve($grpo_header)) {
							$data = array (
								'id_grpo_header'	=>	$grpo['id_grpo_header'],
								'grpo_no'	=>	$grpo_no,
							);

							$grpo_header_update_status = $this->m_grpo->grpo_header_update($data);
						}
					}
				}

				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpo['gr_quantity'][$i])) {
						$grpo_detail = $this->m_grpo->sap_grpo_detail_select_by_id_grpo_h_detail($grpo['id_grpo_h_detail'][$i]);
						unset($grpo_detail['id_grpo_header']);
						unset($grpo_detail['po_no']);
						unset($grpo_detail['plant']);
						unset($grpo_detail['storage_location']);

						$grpo_detail['id_grpo_header'] = $grpo['id_grpo_header'];
						$grpo_detail['gr_quantity'] = $grpo['gr_quantity'][$i];

						if($this->m_grpo->grpo_detail_insert($grpo_detail)) {
							if(isset($_POST['button']['approve']))
								$id_grpo_detail2 = $this->m_grpo->sap_grpo_detail_approve($grpo_detail);
						}

					}

				}

			}

			$this->db->trans_complete();

			$this->_edit_success();
*/
		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grpo_header) {
	 $grpo_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	  $grpo_delete['module'] = "GR PO From Vendor";
	 $grpo_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $grpo_delete['id_delete'] = $id_grpo_header;

		// check approve status
		$grpo_header = $this->m_grpo->grpo_header_select($id_grpo_header);

		if($grpo_header['status'] == '1') {
			$this->m_grpo->grpo_header_delete($id_grpo_header);
			$this->m_grpo->user_delete($grpo_delete);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_grpo_header) {

		if($this->_delete($id_grpo_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt PO from Vendor berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpo_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt PO from Vendor gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpo_browse_result'];
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grpo_header']))
			redirect($this->session->userdata['PAGE']['grpo_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grpo_header'][$i])) {
				$object['data']['grpo_headers'][$j++] = $this->m_grpo->grpo_header_select($_POST['id_grpo_header'][$i]);
			}
		}

		$this->template->write_view('content', 'grpo/grpo_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grpo_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grpo_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

		function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grpo_data';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '10000000';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
//			$this->load->view('upload_form', $error);
		} else {
			$upload = $this->upload->data();;

			// Load the spreadsheet reader library
			$this->load->library('excel_reader');

			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			
			$db_mysql=$this->m_database->get_db_mysql();
			$user_mysql=$this->m_database->get_user_mysql();
			$pass_mysql=$this->m_database->get_pass_mysql();
			$db_sap=$this->m_database->get_db_sap();
			$user_sap=$this->m_database->get_user_sap();
			$pass_sap=$this->m_database->get_pass_sap();
			$host_sap=$this->m_database->get_host_sap();
            if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/'.$db_mysql.'/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpo template file?
			if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$po_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;


							if($grpo_header_temp = $this->m_grpo->sap_grpo_header_select_by_po_no($po_no)) {

							$object['grpo_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grpo_headers'][$j]['grpo_no'] = $excel['cells'][$i][1];
							$object['grpo_headers'][$j]['po_no'] = $po_no;
							$object['grpo_headers'][$j]['kd_vendor'] = $grpo_header_temp['VENDOR'];
                            $grpo_vendor_temp = $this->m_grpo->sap_vendor_select_by_kd_vendor($grpo_header_temp['VENDOR']);
							$object['grpo_headers'][$j]['nm_vendor'] = $grpo_vendor_temp['NAME1'];
							$object['grpo_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grpo_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grpo_headers'][$j]['status'] = '1';
							$object['grpo_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grpo_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grpo_headers'][$j]['filename'] = $upload['file_name'];

            	$grpo_header_exist = TRUE;
							$k = 1; // grpo_detail number
						} else {
            	$grpo_header_exist = FALSE;
						}
                        }

					if($grpo_header_exist) {


                         if($grpo_detail_temp = $this->m_grpo->sap_grpo_details_select_by_po_and_item_code($po_no,$material_no)) {
                           	$object['grpo_details'][$j][$k]['id_grpo_h_detail'] = $k;
							$object['grpo_details'][$j][$k]['item_group_code'] = $item_group_code;
							$object['grpo_details'][$j][$k]['material_no'] = $material_no;
							$object['grpo_details'][$j][$k]['material_desc'] = $grpo_detail_temp['MAKTX'];
							$object['grpo_details'][$j][$k]['outstanding_qty'] = $grpo_detail_temp['BSTMG'];
							$object['grpo_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grpo_details'][$j][$k]['uom'] = $grpo_detail_temp['BSTME'];
							$k++;
               						}
                           	}

				}

				$this->template->write_view('content', 'grpo/grpo_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt PO from Vendor atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpo/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '009';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

			 }
		}

	}

	function file_import_execute() {

		// Load the spreadsheet reader library
		$this->load->library('excel_reader');

		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');

		$this->excel_reader->read($this->session->userdata('file_upload'));

		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it grpo template file?
		if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

				$po_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;


						if($grpo_header_temp = $this->m_grpo->sap_grpo_header_select_by_po_no($po_no)) {

							$object['grpo_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
							$object['grpo_headers'][$j]['po_no'] = $po_no;
							$object['grpo_headers'][$j]['kd_vendor'] = $grpo_header_temp['VENDOR'];
                            $grpo_vendor_temp = $this->m_grpo->sap_vendor_select_by_kd_vendor($grpo_header_temp['VENDOR']);
							$object['grpo_headers'][$j]['nm_vendor'] = $grpo_vendor_temp['NAME1'];
							$object['grpo_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grpo_headers'][$j]['id_grpo_plant'] = $this->m_grpo->id_grpo_plant_new_select($object['grpo_headers'][$j]['plant'],$object['grpo_headers'][$j]['posting_date']);
                            $object['grpo_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grpo_headers'][$j]['status'] = '1';
							$object['grpo_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grpo_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grpo_headers'][$j]['filename'] = $upload['file_name'];

						$id_grpo_header = $this->m_grpo->grpo_header_insert($object['grpo_headers'][$j]);

           	$grpo_header_exist = TRUE;
						$k = 1; // grpo_detail number

					} else {
           	$grpo_header_exist = FALSE;
					}
                    }


				if($grpo_header_exist) {



						if($grpo_detail_temp = $this->m_grpo->sap_grpo_details_select_by_po_and_item_code($po_no,$material_no)) {
                            $object['grpo_details'][$j][$k]['id_grpo_header'] = $id_grpo_header;
                            $object['grpo_details'][$j][$k]['id_grpo_h_detail'] = $k;
							$object['grpo_details'][$j][$k]['item_group_code'] = $item_group_code;
							$object['grpo_details'][$j][$k]['item'] = $grpo_detail_temp['EBELP'];
							$object['grpo_details'][$j][$k]['material_no'] = $material_no;
							$object['grpo_details'][$j][$k]['material_desc'] = $grpo_detail_temp['MAKTX'];
							$object['grpo_details'][$j][$k]['outstanding_qty'] = $grpo_detail_temp['BSTMG'];
							$object['grpo_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grpo_details'][$j][$k]['uom'] = $grpo_detail_temp['BSTME'];

						$id_grpo_detail = $this->m_grpo->grpo_detail_insert($object['grpo_details'][$j][$k]);

						$k++;
                 }

                }

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt PO berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpo_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt PO from Vendor atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpo/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
		}

        }
		
		public function printpdf($id_grpo_header)
	{
	//echo '{'.$id_grpo_header.'}';
		$this->load->model('m_printgrpo');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printgrpo->tampil($id_grpo_header);
		
		ob_start();
		$content = $this->load->view('grpo',$data);
		$content = ob_get_clean();		
		$this->load->library('html2pdf');
		try
		{
			$html2pdf = new HTML2PDF('P', 'F4', 'fr');
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('print.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}

/*public function cetak($id_grpo_header)
	{
		$this->load->model('m_printgrpo');
		$data['data'] = $this->m_printgrpo->tampil($id_grpo_header);
		$this->load->view('grpo',$data);
	}*/	
        }




?>