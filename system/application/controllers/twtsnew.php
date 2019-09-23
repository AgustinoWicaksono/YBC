<?php
class twtsnew extends Controller {
	private $jagmodule = array();


	function twtsnew() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1038);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_twts'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('l_form_validation');
		$this->load->model('m_twtsnew');
		$this->load->model('m_database');
		$this->load->model('m_general');

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
		$twtsnew_browse_result = $this->session->userdata['PAGE']['twtsnew_browse_result'];

		if(!empty($twtsnew_browse_result))
			redirect($this->session->userdata['PAGE']['twtsnew_browse_result']);
		else
			redirect('twtsnew/browse_result/0/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		
		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}
        if (empty($limit)) {
		  $limit = 10;
        }

		redirect('twtsnew/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('twtsnew_browse_result');

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
			'a'	=>	'Item No',
			'b'	=>	'Receipt Number',
			'c'	=>	'Issue Number',

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
		

		$sort_link1 = 'twtsnew/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$status.'/';
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
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 9;
		$config['base_url'] = site_url('twtsnew/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_twtsnew->twtsnew_headers_count_by_criteria($field_name, $field_type, $field_content, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['twtsnew_headers'] = $this->m_twtsnew->twtsnew_headers_select_by_criteria($field_name, $field_type, $field_content, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];
		//echo '{'.$object['total_rows'].'}';

		$object['page_title'] = 'List of Whole to Slice  ';
		$this->template->write_view('content', 'twtsnew/twtsnew_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
			$data = $_POST;
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $twtsnew_detail_tmp = array('twtsnew_detail' => '');
        $this->session->unset_userdata($twtsnew_detail_tmp);
        unset($twtsnew_detail_tmp);

        $item_choose = $data['item_choose'];

    	$object['item_choose'][0] = '';
    	$object['item_choose'][1] = 'Kode';
    	$object['item_choose'][2] = 'Nama';
		
		$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
		$con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
	
	if ($con)
	 {
		sqlsrv_close($con);
	 }
		
        if(!empty($data['item'])) {
          $item_code = $data['item'];
          $items = $this->m_general->sap_item_select_by_item_code($item_code);
          $item_name = $items['MAKTX'];
       	  $object['item_paket_name'] = $item_name;
        }
   		$data['items'] = $this->m_general->sap_item_groups_select_all_twts_back();

		if($data['items'] !== FALSE) {
			
			$object['item']['0'] = '';
			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT1'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR1'].' ('.$data['item']['UNIT1'].')';
				}
				
			}
			
		}
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }
		if(!empty($item_name)) {
			redirect('twtsnew/input2/'.$data['item_choose'].'/'.$item_code);
		}

		$object['page_title'] = 'Whole to Slice';
		$this->template->write_view('content', 'twtsnew/twtsnew_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['twtsnew_detail']['id_twtsnew_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field
				$total_vol_detail = 0;
				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['twtsnew_detail']['material_no'][$i], "twtsnew_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['twtsnew_detail']['quantity'][$i], "twtsnew_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					$db_mysql=$this->m_database->get_db_mysql();
					$user_mysql=$this->m_database->get_user_mysql();
					$pass_mysql=$this->m_database->get_pass_mysql();
					$db_sap=$this->m_database->get_db_sap();
					$user_sap=$this->m_database->get_user_sap();
					$pass_sap=$this->m_database->get_pass_sap();
					$host_sap=$this->m_database->get_host_sap();
					$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
					mysql_select_db($db_mysql, $con);
					
					$qtyH=$_POST['twtsnew_header']['quantity_paket'];
		 $itemSlice=$_POST['twtsnew_header']['kode_paket'];
		 $itemRec=$_POST['twtsnew_detail']['material_no'][$i];
		 if ($i == 1)
		 {
         $req=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemSlice'", $con));
		 $vol_hed=$req['VOL']*$qtyH;
		// echo '{'.$req['VOL']*.'}';
		 }
		 else
		 {
		  $req=mysql_fetch_array(mysql_query("SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'", $con));
		  $vol_hed=$req['VOL_TEMP'];
		  //echo "SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'";
		 }
		
		$req1=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemRec'", $con));
		$qty1=$_POST['twtsnew_detail']['quantity'][$i];
		$vol_det=$req1['VOL']*$qty1;
		$total_vol_detail = $total_vol_detail + $vol_det;
		$var_cek=$vol_hed-$vol_det;
	//echo "$vol_det=$req1[VOL]*$qty1 <br>";
		mysql_query("update m_item set VOL_TEMP ='$var_cek' WHERE MATNR='$itemSlice' ", $con);
 
 		  if ($var_cek < 0)
		  {
		  			echo "<script>alert('Pemotongan Melebihi batas');</script>";
		  			$check[$j] = $this->l_form_validation->set_rules(0, "twtsnew_detail[var][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					}
					
                    if(isset($_POST['button']['delete'])) {
                        $check[$j] = $this->l_form_validation->set_rules($_POST['delete'][$i], "delete[$i]", 'Tick Mark Delete. '.$i, 'required');

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$j]['error'] == TRUE)
    						$validation_temp = FALSE;

    					$j++;
                    }
				mysql_close($con);

				}

				// set $validation, based on $validation_temp value;
			if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {
				$j = 1;
				if ($total_vol_detail < $vol_hed)
				{
		  			echo "<script>alert('Total Volume Slice Cake tidak bisa lebih kecil dari pada total volume whole cake');</script>";
		  			//$check[$j] = $this->l_form_validation->set_rules(0, "twtsnew_detail[var][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					$check[$j]['error'] = TRUE;
					//if($check[$j]['error'] == TRUE)
					$validation_temp = FALSE;

					$j++;
				}
			}

				$validation = $validation_temp;

			}
		}

		if ($validation == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_input_form(0, $data, $check);
	   	} else {
	 			$this->_input_form();
			}

		} else {

			if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {
				$this->_input_add();
			} else {
    	   		$data = $_POST;
	 			$this->_input_form(0, $data, $check);
			}
		}

	}

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '001'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '002'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _input_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if(isset($_POST['button']['add']) || isset($_POST['delete'])) {
          $twtsnew_detail_tmp = array('twtsnew_detail' => '');
          $this->session->unset_userdata($twtsnew_detail_tmp);
          unset($twtsnew_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
    		$item_choose = $this->uri->segment(4);
    		$kode_item_paket = $this->uri->segment(5);
        } else {
    		$item_choose = $this->uri->segment(3);
    		$kode_item_paket = $this->uri->segment(4);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        if(!empty($kode_item_paket)) {
		  $items = $this->m_general->sap_item_select_by_item_code($kode_item_paket);
       	  $object['item_paket_name'] = $items['MAKTX'];
       	  $object['item_paket_code'] = $kode_item_paket;
       	  $object['uom_paket'] = $items['UNIT1'];
        }

		$data['items'] = $this->m_general->sap_item_groups_select_all_twts_back_2($kode_item_paket);
//exit;
		if($data['items'] !== FALSE) {
			$object['item'][''] = '';
//echo $kode_item_paket;
			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT1'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR1'].' ('.$data['item']['UNIT1'].')';
				}
			}
		}
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['twtsnew_header'] = $_POST['twtsnew_header'];//$this->m_twtsnew->twtsnew_details_select($this->uri->segment(3));
		  $object['data']['twtsnew_detail'] = $_POST['twtsnew_detail'];//$this->m_twtsnew->twtsnew_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Whole to Slice';
		$this->template->write_view('content', 'twtsnew/twtsnew_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$twtsnew = $_POST;
		unset($twtsnew['button']);
		// end of assign variables and delete not used variables

		$count = count($twtsnew['twtsnew_detail']['id_twtsnew_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($twtsnew['twtsnew_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('twtsnew/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('twtsnew', 1, date("Y-m-d")) {

		if (isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$twtsnew_header['kode_paket'] = '0001'.date("Ymd").sprintf("%04d", $running_number);
			
			$db_mysql=$this->m_database->get_db_mysql();
			$user_mysql=$this->m_database->get_user_mysql();
			$pass_mysql=$this->m_database->get_pass_mysql();
			$db_sap=$this->m_database->get_db_sap();
			$user_sap=$this->m_database->get_user_sap();
			$pass_sap=$this->m_database->get_pass_sap();
			$host_sap=$this->m_database->get_host_sap();
			$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
			mysql_select_db($db_mysql, $con);
			$this->db->trans_start();

   			$this->session->set_userdata('twtsnew_detail', $twtsnew['twtsnew_detail']);

            $twtsnew_header['kode_paket'] = $twtsnew['twtsnew_header']['kode_paket'];
			$item = $twtsnew['twtsnew_header']['kode_paket'];
			$twtsnew_header['nama_paket'] = $twtsnew['twtsnew_header']['nama_paket'];
			$twtsnew_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
    		$twtsnew_header['plant'] = $this->session->userdata['ADMIN']['plant'];
			$whs=$this->session->userdata['ADMIN']['plant'];
            $twtsnew_header['quantity_paket'] = $twtsnew['twtsnew_header']['quantity_paket'];
			$twtsnew_header['uom_paket'] = $twtsnew['twtsnew_header']['uom_paket'];
			/*$date=date('ym');
			$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
			$tq=mysql_query($q);
			$count1=mysql_num_rows($tq) + 1;
			if ($count1 > 9 && $count1 < 100)
			{
				$dg="0";
			}
			else 
			{
				$dg="00";
			}
			$num=$item.$date.$dg.$count1;*/
			
			$twtsnew_header['num'] = $twtsnew['twtsnew_header']['num'];
			
			//echo '{'.$twtsnew['twtsnew_header']['num'].'}';
			//$batch['BatchNum']=$twtsnew['twtsnew_header']['num'];
			//$this->m_twtsnew->batch_insert($batch);
			$conn= TRUE;
		/*$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		$b=mssql_select_db('Test_MSI',$c);
		
		if ($b)
		{
			$conn=TRUE;
		}
		else
		{
			$conn=FALSE;
		}*/

			if($id_twtsnew_header = $this->m_twtsnew->twtsnew_header_insert($twtsnew_header) ) {
                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {
//echo '{'. $twtsnew['twtsnew_detail']['num'][$i].'}';

					if((!empty($twtsnew['twtsnew_detail']['quantity'][$i]))&&(!empty($twtsnew['twtsnew_detail']['material_no'][$i]))) {

						$twtsnew_detail['id_twtsnew_header'] = $id_twtsnew_header;
						$twtsnew_detail['quantity'] = $twtsnew['twtsnew_detail']['quantity'][$i];//*  $twtsnew_header['quantity_paket'];
						$twtsnew_detail['id_twtsnew_h_detail'] = $twtsnew['twtsnew_detail']['id_twtsnew_h_detail'][$i];

  						$twtsnew_detail['material_no'] = $twtsnew['twtsnew_detail']['material_no'][$i];
						$item = $twtsnew['twtsnew_detail']['material_no'][$i];
  						$twtsnew_detail['material_desc'] = $twtsnew['twtsnew_detail']['material_desc'][$i];
						//$twtsnew_detail['num'] = $twtsnew['twtsnew_detail']['num'][$i];
  						$twtsnew_detail['uom'] = $twtsnew['twtsnew_detail']['uom'][$i];
						$twtsnew_detail['var'] = $twtsnew['twtsnew_detail']['var'][$i];
						//create batch number
						$batch1['BaseEntry'] = $id_twtsnew_header;
						$batch1['Quantity'] = $twtsnew_detail['quantity'];
						$batch1['BaseLinNum'] =$twtsnew_detail['id_twtsnew_h_detail'];
						$batch1['ItemCode'] = $item;
						$batch1['Createdate'] = date('Y-m-d');
						$date=date('ymd');
						$whs=$this->session->userdata['ADMIN']['plant'];
						
						$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
						$cek="SELECT BATCH,MAKTX FROM m_item WHERE MATNR = '$item'";
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
						$batch1['BatchNum'] = $num;
						$twtsnew_detail['num'] = $num;
						$batch1['BaseType'] = 5;
						$batch1['status'] = 11;
						
						//$sisa=$twtsnew['twtsnew_detail']['var'][$count];
						
						if ( $b == "Y" )
						{
							//$this->m_twtsnew->batch_insert($batch1);
						}
						if($this->m_twtsnew->twtsnew_detail_insert($twtsnew_detail) )
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();
			
			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    /*$approved_data = $this->m_gisto->sap_gisto_header_approve($gisto_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			  */  $gisto_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_twtsnew_header'	=>$id_twtsnew_header,
    					//'gisto_no'	=>	$gisto_no,
    					//'po_no'	=>	$po_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_twtsnew->twtsnew_header_update($data);
  				    $approve_data_success = TRUE;
					
				} else {
				  $approve_data_success = FALSE;
				}
				//mssql_close($con);

            if(isset($_POST['button']['save'])) {
			//echo '{'.$count.'}';
			//echo '{'.$sisa.'}';
              if ($input_detail_success === TRUE && $conn = TRUE) {
   			    $this->l_general->success_page('Data Whole to Slice berhasil dimasukkan', site_url('twtsnew/input'));
              }else if ($conn === FALSE) {
				  $this->m_twtsnew->twtsnew_header_delete($id_twtsnew_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
                $this->m_twtsnew->twtsnew_header_delete($id_twtsnew_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Whole to Slice tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            }
			else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE && $conn = TRUE) {
  			     $this->l_general->success_page('Data Whole to Slice berhasil diapprove', site_url('twtsnew/input'));
              } else if ($conn === FALSE) {
				  $this->m_twtsnew->twtsnew_header_delete($id_twtsnew_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  }
			  else {
                $this->m_twtsnew->twtsnew_header_delete($id_twtsnew_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Whole to Slice tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		mysql_close($con);

		

		}

	}

	function edit() {

		$item_choose = $this->uri->segment(4);
		$status = $twtsnew_header['status'];
        $twtsnew_detail_tmp = array('twtsnew_detail' => '');
        $this->session->unset_userdata($twtsnew_detail_tmp);
        unset($twtsnew_detail_tmp);

		$validation = FALSE;

		if (count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['twtsnew_detail']['id_twtsnew_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

                $check[0] = $this->l_form_validation->set_rules($_POST['twtsnew_header']['quantity_paket'], "twtsnew_header[quantity_paket]", 'Quantity paket', 'required|is_numeric_no_zero');
				if($check[0]['error'] == TRUE)
				    $validation_temp = FALSE;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['twtsnew_detail']['material_no'][$i], "twtsnew_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['twtsnew_detail']['quantity'][$i], "twtsnew_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

                    if(isset($_POST['button']['delete'])) {
                        $check[$j] = $this->l_form_validation->set_rules($_POST['delete'][$i], "delete[$i]", 'Tick Mark Delete. '.$i, 'required');

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$j]['error'] == TRUE)
    						$validation_temp = FALSE;


    					$j++;
                    }
				}

				// set $validation, based on $validation_temp value;
				$validation = $validation_temp;

			}

		}


		/*if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->_edit_form(0, $data, $check);
			} else {
				$data['twtsnew_header'] = $this->m_twtsnew->twtsnew_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		}*/ 
		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$twtsnew_header = $this->m_twtsnew->twtsnew_header_select($this->uri->segment(3));

				if($twtsnew_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['twtsnew_header'] = $this->m_twtsnew->twtsnew_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {

			if(isset($_POST['button']['save'])|| isset($_POST['button']['approve'])) {
				$this->_edit_update();
			} else {
//	 		  	$this->_edit_form(0, $data, $check);
	 		  	$this->_input_form(0, $data, $check);
			}

		}

	}

	function _edit_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;
		$object['data']['twtsnew_header']['status_string'] = ($object['data']['twtsnew_header']['status'] == '2') ? 'Approved' : 'Not Approved';


		if(isset($_POST['button']['add']) || isset($_POST['delete'])) {
          $twtsnew_detail_tmp = array('twtsnew_detail' => '');
          $this->session->unset_userdata($twtsnew_detail_tmp);
          unset($twtsnew_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
		
		$id_twtsnew_header = $data['twtsnew_header']['id_twtsnew_header'];
		$item_choose = $this->uri->segment(4);
        $id_twtsnew_header = $this->uri->segment(3);
/*		if(count($_POST) == 0) {
			$item_group_code = $data['twtsnew_header']['item_group_code'];
		} else {
			$item_group_code = $data['item_group']['item_group_code'];
		}
*/
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
		
		$object['twtsnew_header']['id_twtsnew_header'] = $id_twtsnew_header;
		$data['items'] = $this->m_general->sap_item_groups_select_all_wo_back();

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR1'].' ('.$data['item']['UNIT'].')';
				}
			}
		}

        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }


		if(count($_POST) == 0) {
			$object['data']['twtsnew_details'] = $this->m_twtsnew->twtsnew_details_select($id_twtsnew_header);

			if($object['data']['twtsnew_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['twtsnew_details']->result_array() as $object['temp']) {
	//				$object['data']['twtsnew_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['twtsnew_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		
		
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Whole to Slice';
		$this->template->write_view('content', 'twtsnew/twtsnew_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$twtsnew = $_POST;
//		unset($twtsnew['twtsnew_header']['kode_paket']);
		unset($twtsnew['button']);
		// end of assign variables and delete not used variables

		$count = count($twtsnew['twtsnew_detail']['id_twtsnew_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($twtsnew['twtsnew_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('twtsnew/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save'])|| isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('twtsnew_detail', $twtsnew['twtsnew_detail']);
            $id_twtsnew_header = $twtsnew['twtsnew_header']['id_twtsnew_header'];

  			$data = array (
  				'id_twtsnew_header' =>	$id_twtsnew_header,
                'quantity_paket' => $twtsnew['twtsnew_header']['quantity_paket'],
  				'uom_paket' => $twtsnew['twtsnew_header']['uom_paket'],
				'num' => $twtsnew['twtsnew_header']['num'],
  			);

            $input_detail_success = FALSE;
			
		$conn= TRUE;
		/*$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		$b=mssql_select_db('Test_MSI',$c);
		
		if ($b)
		{
			$conn=TRUE;
		}
		else
		{
			$conn=FALSE;
		}*/
		

            if(($this->m_twtsnew->twtsnew_header_update($data))&&
              ($this->m_twtsnew->twtsnew_details_delete($id_twtsnew_header))) {
        		for($i = 1; $i <= $count; $i++) {
					if((!empty($twtsnew['twtsnew_detail']['quantity'][$i]))&&(!empty($twtsnew['twtsnew_detail']['material_no'][$i]))) {

						$twtsnew_detail['id_twtsnew_header'] = $id_twtsnew_header;
						$twtsnew_detail['quantity'] = $twtsnew['twtsnew_detail']['quantity'][$i];
						$twtsnew_detail['id_twtsnew_h_detail'] = $twtsnew['twtsnew_detail']['id_twtsnew_h_detail'][$i];

						$twtsnew_detail['material_no'] = $twtsnew['twtsnew_detail']['material_no'][$i];
						$twtsnew_detail['material_desc'] = $twtsnew['twtsnew_detail']['material_desc'][$i];
						$twtsnew_detail['uom'] = $twtsnew['twtsnew_detail']['uom'][$i];
						$twtsnew_detail['num'] = $twtsnew['twtsnew_detail']['num'][$i];
						$twtsnew_detail['var'] = $twtsnew['twtsnew_detail']['var'][$i];
						//echo "abc";
						
						
						//$twtsnew_detail['qc'] = $twtsnew['twtsnew_detail']['qc'][$i];

						if($this->m_twtsnew->twtsnew_detail_insert($twtsnew_detail))
                          $input_detail_success = TRUE;
					}

       	    	}
            }
			
			
			

  			$this->db->trans_complete();
			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    /*$approved_data = $this->m_gisto->sap_gisto_header_approve($gisto_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			  */  $gisto_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_twtsnew_header'	=>$id_twtsnew_header,
    					//'gisto_no'	=>	$gisto_no,
    					//'po_no'	=>	$po_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
						'back' =>'0',
    				);
    				$this->m_twtsnew->twtsnew_header_update($data);
  				    $approve_data_success = TRUE;
					
				} else {
				  $approve_data_success = FALSE;
				}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE ) {
			  $this->l_general->success_page('Data Whole to Slice berhasil diubah', site_url('twtsnew/browse'));
              }else if($conn == FALSE){
				  $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
			  $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Whole to Slice tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE ) {
			  $this->l_general->success_page('Data Whole to Slice berhasil diapprove', site_url('twtsnew/browse'));
              }else if($conn == FALSE){
				  $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Whole to Slice tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'twtsnew/browse';
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function edit_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/


	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Master Paket tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_twtsnew_header) {
	
	   $twtsnew_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	   $twtsnew_delete['module'] = "Store Room Request (SR) ";
	   $twtsnew_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $twtsnew_delete['id_delete'] = $id_twtsnew_header;

		$this->db->trans_start();

		// check approve status
		if($this->m_twtsnew->twtsnew_header_delete($id_twtsnew_header))
		 {
		    $this->m_twtsnew->user_delete($id_twtsnew_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_twtsnew_header) {
		$del_header=mysql_query("DELETE FROM m_twtsnew_header WHERE id_twtsnew_header='$id_twtsnew_header'");
		$del_detail=mysql_query("DELETE FROM m_twtsnew_detail WHERE id_twtsnew_header='$id_twtsnew_header'");

		//if($this->_delete($id_twtsnew_header)) {
			if($del_header && $del_detail) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Whole to Slice berhasil dihapus '.$id_twtsnew_header;
			$object['refresh_url'] = $this->session->userdata['PAGE']['twtsnew_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Whole to Slice gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['twtsnew_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '006';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_twtsnew_header']))
			redirect($this->session->userdata['PAGE']['twtsnew_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_twtsnew_header'][$i])) {
				$object['data']['twtsnew_headers'][$j++] = $this->m_twtsnew->twtsnew_header_select($_POST['id_twtsnew_header'][$i]);
			}
		}

		$this->template->write_view('content', 'twtsnew/twtsnew_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_twtsnew_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Whole to Slice berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['twtsnew_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'twtsnew_data';
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

            if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/portalja/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);
			$this->session->set_userdata('filename_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

		 	if($excel['cells'][1][1] == 'BOM Item No.' && $excel['cells'][1][2] == 'BOM Quantity') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$kode_paket = $excel['cells'][$i][1];
					$quantity_paket = $excel['cells'][$i][2];
                    $material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];
					$plant = $excel['cells'][$i][5];
            	    if(empty($plant)) {
            	      $plant = $this->session->userdata['ADMIN']['plant'];
            	    }
					// check grpo header
					if(($excel['cells'][$i][1] != $excel['cells'][$x][1])||($excel['cells'][$i][5] != $excel['cells'][$x][5])) {

                        $j++;
//				   		if($twtsnew_header_temp = $this->m_general->sap_item_groups_select_all_twtsnew()) {

                            //echo "<pre>";
                            //print_r($twtsnew_header_temp);
                            //echo "</pre>";
                            $object['twtsnew_headers'][$j]['kode_paket'] = $kode_paket;
                            $item_temp = $this->m_general->sap_item_select_by_item_code($excel['cells'][$i][1]);
                            $object['twtsnew_headers'][$j]['nama_paket'] = $item_temp['MAKTX'];
                            $object['twtsnew_headers'][$j]['quantity_paket'] = $quantity_paket;
                            $object['twtsnew_headers'][$j]['uom_paket'] = $item_temp['UNIT'];
							$object['twtsnew_headers'][$j]['status'] = '1';
							$object['twtsnew_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['twtsnew_headers'][$j]['filename'] = $upload['file_name'];
							$object['twtsnew_headers'][$j]['plant'] = $plant;

                        	$twtsnew_header_exist = TRUE;
							$k = 1; // grpo_detail number
//				 		} else {
//            	            $twtsnew_header_exist = FALSE;
//						}
					}

					if($twtsnew_header_exist) {

						if($twtsnew_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['twtsnew_details'][$j][$k]['id_twtsnew_h_detail'] = $k;
							$object['twtsnew_details'][$j][$k]['material_no'] = $material_no;
							$object['twtsnew_details'][$j][$k]['material_desc'] = $twtsnew_detail_temp['MAKTX'];
							$object['twtsnew_details'][$j][$k]['quantity'] = $quantity;
                            $uom_import = $twtsnew_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
                			$object['twtsnew_details'][$j][$k]['uom'] = $uom_import;

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'twtsnew/twtsnew_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Whole to Slice atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'twtsnew/browse_result/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '007';
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
	   	if($excel['cells'][1][1] == 'BOM Item No.' && $excel['cells'][1][2] == 'BOM Quantity') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

				$kode_paket = $excel['cells'][$i][1];
				$quantity_paket = $excel['cells'][$i][2];
    			$material_no =  $excel['cells'][$i][3];
    			$quantity = $excel['cells'][$i][4];
            	$plant = $excel['cells'][$i][5];
                if(empty($plant)) {
                  $plant = $this->session->userdata['ADMIN']['plant'];
                }


				// check grpo header
				if(($excel['cells'][$i][1] != $excel['cells'][$x][1])||($excel['cells'][$i][5] != $excel['cells'][$x][5])) {

                        $twtsnew_header = $this->m_twtsnew->twtsnew_header_select_by_kode_paket($kode_paket,$plant);
                        if ($twtsnew_header!=FALSE) {
                          $this->m_twtsnew->twtsnew_header_delete_multiple($twtsnew_header);
                        }
                        $j++;
//				   	if($twtsnew_detail_temp = $this->m_general->sap_item_groups_select_all_twtsnew()) {
                        $object['twtsnew_headers'][$j]['plant'] = $plant;
                        $object['twtsnew_headers'][$j]['kode_paket'] = $excel['cells'][$i][1];
                        $item_temp = $this->m_general->sap_item_select_by_item_code($excel['cells'][$i][1]);
                        $object['twtsnew_headers'][$j]['nama_paket'] = $item_temp['MAKTX'];
                        $object['twtsnew_headers'][$j]['quantity_paket'] = $quantity_paket;
						$object['twtsnew_headers'][$j]['status'] = '1';
                        $object['twtsnew_headers'][$j]['uom_paket'] = $item_temp['UNIT'];
					    $object['twtsnew_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
					    $object['twtsnew_headers'][$j]['filename'] = $this->session->userdata('filename_upload');

						$id_twtsnew_header = $this->m_twtsnew->twtsnew_header_insert($object['twtsnew_headers'][$j]);

                       	$twtsnew_header_exist = TRUE;
						$k = 1; // grpo_detail number

//			  		} else {
//           	            $twtsnew_header_exist = FALSE;
//					}
				}

				if($twtsnew_header_exist) {

					if($twtsnew_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                        $object['twtsnew_details'][$j][$k]['id_twtsnew_header'] = $id_twtsnew_header;
						$object['twtsnew_details'][$j][$k]['id_twtsnew_h_detail'] = $k;
						$object['twtsnew_details'][$j][$k]['material_no'] = $material_no;
						$object['twtsnew_details'][$j][$k]['material_desc'] = $twtsnew_detail_temp['MAKTX'];
   					    $object['twtsnew_details'][$j][$k]['quantity'] = $quantity;

                        $uom_import = $twtsnew_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['twtsnew_details'][$j][$k]['uom'] = $uom_import;

						$id_twtsnew_detail = $this->m_twtsnew->twtsnew_detail_insert($object['twtsnew_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Master BOM  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['twtsnew_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Whole to Slice atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'twtsnew/browse_result/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '008';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>