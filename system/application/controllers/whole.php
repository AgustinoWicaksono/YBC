<?php
class whole extends Controller {
	private $jagmodule = array();


	function whole() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1028);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_tpaket'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_database');
		$this->load->model('m_whole');
		$this->load->model('m_retur');

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
		$whole_browse_result = $this->session->userdata['PAGE']['whole_browse_result'];

		if(!empty($whole_browse_result))
			redirect($this->session->userdata['PAGE']['whole_browse_result']);
		else
			redirect('whole/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('whole/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('whole/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('whole_browse_result');

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
			'd'	=>	'Vendor Name',
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

		$sort_link1 = 'whole/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('whole/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_whole->whole_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['whole_headers'] = $this->m_whole->whole_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Pemotongan Whole';
		$this->template->write_view('content', 'whole/whole_browse', $object);
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
			$object['data']['receiving_plant'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $whole_detail_tmp = array('whole_detail' => '');
        $this->session->unset_userdata($whole_detail_tmp);
        unset($whole_detail_tmp);
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
		$rq=mysql_fetch_array(mysql_query("SELECT otd_code FROM m_outlet where OUTLET ='$whs'", $con));
		$pl=$rq['otd_code'];
		//print_r($pl);F
  		$data['plants'] = $this->m_general->sap_plants_select_all_outlet1($pl);
  		if($data['plants'] !== FALSE) {
  			$object['receiving_plant'][0] = '';
  			foreach ($data['plants'] as $plant) {
  				$object['receiving_plant'][$plant['plant']] = $plant['plant'].' - '.$plant['plant_name'] ;
  			}
  		}
		
		

		/*if(!empty($data['receiving_plant'])) {
			$data['item_groups'] = $this->m_general->sap_item_groups_select_all_gisto();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}
		}
		
		$data['item_groups'] = $this->m_general->sap_item_groups_select_all_gisto();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}*/
		
		

		/*if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}*/

		if(!empty($data['kode_paket']) && !empty($data['whole_header']['quantity_paket']) ) {
			redirect('whole/input2/'.$data['kode_paket'].'/'.$data['whole_header']['quantity_paket']);
		}
		mysql_close($con);

		$object['page_title'] = 'Pemotongan Whole';
		$this->template->write_view('content', 'whole/whole_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(5);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['whole_detail']['id_whole_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['whole_detail']['material_no'][$i], "whole_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					/*$check[$j] = $this->l_form_validation->set_rules($_POST['whole_detail']['qty'][$i], "whole_detail[qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					
					
					$item=$_POST['whole_detail']['material_no'][$i];
					
					
					$db_mysql=$this->m_database->get_db_mysql();
					$user_mysql=$this->m_database->get_user_mysql();
					$pass_mysql=$this->m_database->get_pass_mysql();
					$db_sap=$this->m_database->get_db_sap();
					$user_sap=$this->m_database->get_user_sap();
					$pass_sap=$this->m_database->get_pass_sap();
					$host_sap=$this->m_database->get_host_sap();
					$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
					mysql_select_db($db_mysql, $con);
					
					$cek_req=mysql_num_rows(mysql_query("SELECT BATCH FROM m_item WHERE MATNR='$item' AND BATCH='Y'", $con));
					if ($cek_req == 1)
					{
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['whole_detail']['num'][$i], "whole_detail[num][$i]", 'Batch Number '.$i, 'required');

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
          $whole_detail_tmp = array('whole_detail' => '');
          $this->session->unset_userdata($whole_detail_tmp);
          unset($whole_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
     	    $kode_paket = $this->uri->segment(4);
			$qty = $this->uri->segment(5);
    		
        } else {
     	    $kode_paket = $this->uri->segment(3);
			$qty = $this->uri->segment(4);
    		
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $object['kode_paket'] = $kode_paket;
		$name=mysql_fetch_array(mysql_query("SELECT MAKTX FROM m_item WHERE MATNR='$kode_paket'"));
		 $object['nama_paket'] = $name['MAKTX'];
		 $object['qty_paket'] = $qty;
		
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_gisto();
			
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'gist');
		}
		
		$data['batch']=$this->m_general->batch();
//exit;

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';
		
			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
				$it=$data['item']['MATNR1'];
				
					$object['item'][$data['item']['MATNR']] = $it.' - '.$data['item']['MAKTX'];
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$it;
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
		  $object['data']['whole_header'] = $_POST['whole_header'];//$this->m_whole->whole_details_select($this->uri->segment(3));
		  $object['data']['whole_detail'] = $_POST['whole_detail'];//$this->m_whole->whole_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Pemotongan Whole';
		$this->template->write_view('content', 'whole/whole_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$whole = $_POST;
		unset($whole['whole_header']['id_whole_header']);
		unset($whole['button']);
		// end of assign variables and delete not used variables

		$count = count($whole['whole_detail']['id_whole_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($whole['whole_detail']['qty'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('whole/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($whole['whole_header']['posting_date'])==FALSE)) {
     	   redirect('whole/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {


			$this->db->trans_start();

   			$this->session->set_userdata('whole_detail', $whole['whole_detail']);

    		$whole_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$whole_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
 			$whole_header['posting_date'] = $this->l_general->str_to_date($whole['whole_header']['posting_date']);
			$whole_header['id_whole_plant'] = $this->m_whole->id_whole_plant_new_select($whole_header['plant'],$whole_header['posting_date']);

 			
 			$whole_header['whole_no'] = '';

			if(isset($_POST['button']['approve']))
				$whole_header['status'] = '2';
			else
				$whole_header['status'] = '1';

			$whole_header['kode_paket'] = $whole['whole_header']['kode_paket'];
			$whole_header['nama_paket'] = $whole['whole_header']['nama_paket'];
			$whole_header['qty_paket'] = $whole['whole_header']['qty_paket'];
			$whole_header['uom_paket'] = $whole['whole_header']['uom_paket'];
			$whole_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
			
			/*batch number*/
			$item=$whole_header['kode_paket'];
			$whs=$this->session->userdata['ADMIN']['plant'];
			$date=date('ym');
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
			$num=$item.$date.$dg.$count1;
			$whole_header['num'] = $num;
/*echo $whole_header['plant'].' - '.$whole_header['storage_location'].' - '.$whole_header['posting_date'].' - '.$whole_header['id_whole_plant'].' - '.$whole_header['kode_paket'].' - '.$whole_header['nama_paket'].' - '.$whole_header['qty_paket'].' - '.$whole_header['uom_paket'].' - '.$whole_header['id_user_input'].' - '.$whole_header['num'];*/

            $web_trans_id = $this->l_general->_get_web_trans_id($whole_header['plant'],$whole_header['posting_date'],
                      $whole_header['id_whole_plant'],'04');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $whole_to_approve = array (
                      'plant' => $whole_header['plant'],
                      'posting_date' => date('Ymd',strtotime($whole_header['posting_date'])),
                      'id_user_input' => $whole_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                     
                );
              }

			if($id_whole_header = $this->m_whole->whole_header_insert($whole_header)) {

                $input_detail_success = FALSE;
				for($i = 1; $i <= $count; $i++) {

					if((!empty($whole['whole_detail']['qty'][$i]))&&(!empty($whole['whole_detail']['material_no'][$i]))) {

						$whole_detail['id_whole_header'] = $id_whole_header;
						$whole_detail['qty'] = $whole['whole_detail']['qty'][$i];
						$whole_detail['id_whole_h_detail'] = $whole['whole_detail']['id_whole_h_detail'][$i];
						
						$item = $this->m_general->sap_item_select_by_item_code($whole['whole_detail']['material_no'][$i]);
						
  						$whole_detail['material_no'] = $whole['whole_detail']['material_no'][$i];
						$whole_detail['num'] = $whole['whole_detail']['num'][$i];
						$whole_detail['material_desc'] = $whole['whole_detail']['material_desc'][$i];
  						$whole_detail['uom'] = $whole['whole_detail']['uom'][$i];
						$whole_detail['qc'] = $whole['whole_detail']['qc'][$i];
						$whole_detail['OnHand'] = $whole['whole_detail']['OnHand'][$i];
						$whole_detail['MinStock'] = $whole['whole_detail']['MinStock'][$i];
						$whole_detail['OpenQty'] = $whole['whole_detail']['OpenQty'][$i];

						
                        //array utk parameter masukan pada saat approval
                        $whole_to_approve['item'][$i] = $whole_detail['id_whole_h_detail'];
                        $whole_to_approve['material_no'][$i] = $whole_detail['material_no'];
                        $whole_to_approve['gr_quantity'][$i] = $whole_detail['gr_quantity'];
                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $whole_to_approve['uom'][$i] = $whole_detail['uom'];
                        } else {
                            $whole_to_approve['uom'][$i] = $item['MEINS'];
                        }
                        //

						if($this->m_whole->whole_detail_insert($whole_detail) )
							
                          $input_detail_success = TRUE;
						  
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    /*$approved_data = $this->m_whole->sap_whole_header_approve($whole_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			  */  $whole_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_whole_header'	=>$id_whole_header,
    					'whole_no'	=>	$whole_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_whole->whole_header_update($data);
  				    $approve_data_success = TRUE;
					
				} else {
				  $approve_data_success = FALSE;
				}
            //}


            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE ) {
   			    $this->l_general->success_page('Data Pemotongan Whole berhasil dimasukkan', site_url('whole/input'));

              } 
			  else {
                $this->m_whole->whole_header_delete($id_whole_header);
 			    $this->$this->jagmodule['error_code'] = '003';
		        $this->l_general->error_page($this->jagmodule, 'Data Pemotongan Whole tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));

              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Pemotongan Whole berhasil diapprove', site_url('whole/input'));
              } else {
                $this->m_whole->whole_header_delete($id_whole_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Pemotongan Whole tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataTransferring Difference Stock To Department tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('whole/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataTransferring Difference Stock To Department berhasil diapprove';
		$object['refresh_url'] = site_url('whole/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataTransferring Difference Stock To Department berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('whole/input');
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function input_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
           */

	function edit() {

		$item_choose = $this->uri->segment(6);
		
	    $whole_header = $this->m_whole->whole_header_select($this->uri->segment(3));
		
		$status = $whole_header['status'];
        unset($whole_header);

        $whole_detail_tmp = array('whole_detail' => '');
        $this->session->unset_userdata($whole_detail_tmp);
        unset($whole_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['whole_detail']['id_whole_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
				
					$count2 = $count - 1;
					
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['whole_detail']['material_no'][$i], "whole_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['whole_detail']['qty'][$i], "whole_detail[qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					
					
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


		if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$whole_header = $this->m_whole->whole_header_select($this->uri->segment(3));

				if($whole_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['whole_header'] = $this->m_whole->whole_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {

			if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {
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

		if(isset($_POST['button']['add']) || isset($_POST['delete'])) {
          $whole_detail_tmp = array('whole_detail' => '');
          $this->session->unset_userdata($whole_detail_tmp);
          unset($whole_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['whole_header']['status_string'] = ($object['data']['whole_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$object['id_whole_header'] =$this->uri->segment(3);
		$item_group_code = $data['whole_header']['item_group_code'];
		
		$item_choose = $this->uri->segment(6);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['whole_header']['item_group_code'];
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

		$object['receiving_plant'] = $this->m_general->sap_plant_select_2($receiving_plant);
		
//exit;
		/*if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_gisto();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'gist');
		}

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
        }*/


		if(count($_POST) == 0) {
			$object['data']['whole_details'] = $this->m_whole->whole_details_select($object['data']['whole_header']['id_whole_header']);

			if($object['data']['whole_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['whole_details']->result_array() as $object['temp']) {
	//				$object['data']['whole_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['whole_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
			/*$object['data']['batch'] = $this->m_whole->batch($object['data']['batch']['ItemCode']);

			if($object['data']['batch'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['batch']->result_array() as $object['temp']) {
	//				$object['data']['whole_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['batch'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}*/
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Pemotongan Whole';
		$this->template->write_view('content', 'whole/whole_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$whole = $_POST;
		unset($whole['whole_header']['id_whole_header']);
		unset($whole['button']);
		// end of assign variables and delete not used variables

		$count = count($whole['whole_detail']['id_whole_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($whole['whole_detail']['qty'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

//echo "<pre>";
//print 'array ';
//print_r($whole['whole_detail']);
//echo "</pre>";
//exit;

		if($gr_quantity_exist == FALSE)
			redirect('whole/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($whole['whole_header']['posting_date'])==FALSE)) {
     	   redirect('whole/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('whole_detail', $whole['whole_detail']);

            $id_whole_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($whole['whole_header']['posting_date']);
			//$id_whole_plant = $this->m_whole->id_whole_plant_new_select("",$postingdate,$id_whole_header);

    			$data = array (
    				'id_whole_header' => $id_whole_header,
                    'posting_date' => $postingdate,
    			);

                $this->m_whole->whole_header_update($data);
                $edit_whole_header = $this->m_whole->whole_header_select($id_whole_header);

//       echo "<pre>";
//       print_r($whole['whole_detail']);
//       echo "</pre>";
//       exit;

    			if ($this->m_whole->whole_header_update($data)) {
				
                    $input_detail_success = FALSE;
    			    if($this->m_whole->whole_details_delete($id_whole_header)) {
						for($i = 1; $i <= $count; $i++) {
        					if((!empty($whole['whole_detail']['qty'][$i]))&&(!empty($whole['whole_detail']['material_no'][$i]))) {
								
        						$whole_detail['id_whole_header'] = $id_whole_header;
								$whole_detail['qty'] = $whole['whole_detail']['qty'][$i];
								$whole_detail['id_whole_h_detail'] = $whole['whole_detail']['id_whole_h_detail'][$i];
								
        						$whole_detail['material_no'] = $whole['whole_detail']['material_no'][$i];
								$whole_detail['material_desc'] = $whole['whole_detail']['material_desc'][$i];
        						$whole_detail['uom'] = $whole['whole_detail']['uom'][$i];
								$whole_detail['num'] = $whole['whole_detail']['num'][$i];
								$whole_detail['qc'] = $whole['whole_detail']['qc'][$i];
								$whole_detail['OnHand'] = $whole['whole_detail']['OnHand'][$i];
								$whole_detail['MinStock'] = $whole['whole_detail']['MinStock'][$i];
								$whole_detail['OpenQty'] = $whole['whole_detail']['OpenQty'][$i];
								
								
                                //array utk parameter masukan pada saat approval
                                $whole_to_approve['item'][$i] = $whole_detail['id_whole_h_detail'];
                                $whole_to_approve['material_no'][$i] = $whole_detail['material_no'];
                                $whole_to_approve['gr_quantity'][$i] = $whole_detail['gr_quantity'];

        					   $item = $this->m_general->sap_item_select_by_item_code($whole['whole_detail']['material_no'][$i]);
                               if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $whole_to_approve['uom'][$i] = $whole_detail['uom'];
                                } else {
                                    $whole_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                //
        						if($this->m_whole->whole_detail_insert($whole_detail))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($whole['whole_detail']['gr_quantity'][$i])) {
            	    			$whole_detail = array (
            						'id_whole_detail'=>$whole['whole_detail']['id_whole_detail'][$i],
            						'gr_quantity'=>$whole['whole_detail']['gr_quantity'][$i],
            					);
            		    		if($this->m_whole->whole_detail_update($whole_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_whole->whole_detail_delete($whole['whole_detail']['id_whole_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $whole_to_approve['posting_date'] = date('Ymd',strtotime($edit_whole_header['posting_date']));
                $whole_to_approve['plant'] = $edit_whole_header['plant'];
                $whole_to_approve['id_whole_plant'] = $edit_whole_header['id_whole_plant'];
                $whole_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $whole_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_whole_header['plant'],$edit_whole_header['posting_date'],
                      $edit_whole_header['id_whole_plant'],'04');
					  
			    /*$approved_data = $this->m_whole->sap_whole_header_approve($whole_to_approve);
 			    $approve_data_success = FALSE;
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			*/  $whole_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_whole_header' =>$id_whole_header,
    					'whole_no'	=>	$whole_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$whole_header_update_status = $this->m_whole->whole_header_update($data);
  				    $approve_data_success = TRUE;
				//}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Pemotongan Whole berhasil diubah', site_url('whole/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Pemotongan Whole tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));

 			  }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			    $this->l_general->success_page('Data Pemotongan Whole berhasil diapprove', site_url('whole/browse'));
              } else {
                $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Pemotongan Whole tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));            }
		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'whole/browse';
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

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$whole = $_POST;
		unset($whole['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($whole['whole_header']['posting_date']!=$date_today) {
			redirect('whole/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($whole['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}
		if($gr_quantity_exist == FALSE)
			redirect('whole/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('whole', 1, date("Y-m-d")) {


        $edit_whole_header = $this->m_whole->whole_header_select($whole['whole_header']['id_whole_header']);
		$edit_whole_details = $this->m_whole->whole_details_select($whole['whole_header']['id_whole_header']);
    	$i = 1;
	    foreach ($edit_whole_details->result_array() as $value) {
		    $edit_whole_detail[$i] = $value;
		    $i++;
        }
        unset($edit_whole_details);

		if(isset($_POST['button']['cancel'])) {

//			$whole_header['id_whole_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $whole_to_cancel['whole_no'] = $edit_whole_header['whole_no'];
            $whole_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_whole_header['posting_date']));
            $whole_to_cancel['posting_date'] = date('Ymd',strtotime($edit_whole_header['posting_date']));
            $whole_to_cancel['plant'] = $edit_whole_header['plant'];
			$whole_to_cancel['id_whole_plant'] = $this->m_whole->id_whole_plant_new_select($whole_to_cancel['plant'],date('Y-m-d',strtotime($edit_whole_header['posting_date'])));
			$whole_to_cancel['po_no'] = $edit_whole_header['po_no'];
            $whole_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_whole_header['plant'],$edit_whole_header['posting_date'],
                      $whole_to_cancel['id_whole_plant'],'04');
            $whole_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_whole_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($whole['cancel'][$i]))
       		     $whole_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_whole->sap_whole_header_cancel($whole_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($whole['cancel'][$i])) {
    	    			$whole_header = array (
    						'id_whole_header'=>$whole['whole_header']['id_whole_header'],
    						'id_whole_plant'=>$whole_to_cancel['id_whole_plant'],
    					);
    		    		if($this->m_whole->whole_header_update($whole_header)==TRUE) {
        	    			$whole_detail = array (
        						'id_whole_detail'=>$edit_whole_detail[$i]['id_whole_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_whole->whole_detail_update($whole_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                        }
                   }
        		}
            }

           $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			    $this->l_general->success_page('Data Pemotongan Whole berhasil dibatalkan', site_url('whole/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Pemotongan Whole tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataTransferring Difference Stock To Department tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_whole_header) {

		$this->db->trans_start();

		// check approve status
		$whole_header = $this->m_whole->whole_header_select($id_whole_header);

		if($whole_header['status'] == '1') {
			$this->m_whole->whole_header_delete($id_whole_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_whole_header) {

		if($this->_delete($id_whole_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Pemotongan Whole berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['whole_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Pemotongan Whole gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['whole_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_whole_header']))
			redirect($this->session->userdata['PAGE']['whole_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_whole_header'][$i])) {
				$object['data']['whole_headers'][$j++] = $this->m_whole->whole_header_select($_POST['id_whole_header'][$i]);
			}
		}

		$this->template->write_view('content', 'whole/whole_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_whole_header'][$i]);
		}

		$object['refresh'] = 1;
   		$object['refresh_text'] = 'Data Pemotongan Whole berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['whole_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'whole_data';
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

			// is it whole template file?
			if($excel['cells'][1][1] == 'Goods Issue Stock Transfer No' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // whole_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same whole header?

					$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                     $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];

					// check whole header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;

                       $plant = $this->m_general->sap_plant_select($receiving_plant);
                         if($plant!= FALSE){
//                            if($whole_receiving_temp = $this->m_general->sap_plants_select_all_non_ck_outlet()){
							$object['whole_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['whole_headers'][$j]['receiving_plant'] = $receiving_plant;
                            $object['whole_headers'][$j]['whole_no'] = $excel['cells'][$i][1];
							$object['whole_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['whole_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['whole_headers'][$j]['status'] = '1';
							$object['whole_headers'][$j]['item_group_code'] = $item_group_code;
							$object['whole_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['whole_headers'][$j]['filename'] = $upload['file_name'];

            	            $whole_header_exist = TRUE;
							$k = 1; // whole_detail number
						} else {
                        	$whole_header_exist = FALSE;
						}
                       }

					if($whole_header_exist) {


                             if($whole_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
							$object['whole_details'][$j][$k]['id_whole_h_detail'] = $k;
							$object['whole_details'][$j][$k]['item'] = $k;
							$object['whole_details'][$j][$k]['material_no'] = $material_no;
                            $object['whole_details'][$j][$k]['material_desc'] = $whole_detail_temp['MAKTX'];
							$object['whole_details'][$j][$k]['gr_quantity'] = $gr_quantity;
                            $uom_import = $whole_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
							$object['whole_details'][$j][$k]['uom'] = $uom_import;

							$k++;
                       }

					}

				}

				$this->template->write_view('content', 'whole/whole_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Pemotongan Whole atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'whole/browse_result/0/0/0/0/0/0/0/10';
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

		// is it whole template file?
		if($excel['cells'][1][1] == 'Goods Issue Stock Transfer No' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // whole_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same whole header?

					$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                     $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];


				// check whole header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;

                       $plant = $this->m_general->sap_plant_select($receiving_plant);
                       if($plant!= FALSE){
						    $object['whole_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

                       		$object['whole_headers'][$j]['receiving_plant'] = $receiving_plant;
                       		$object['whole_headers'][$j]['receiving_plant_name'] = $plant['NAME1'];
							$object['whole_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['whole_headers'][$j]['id_whole_plant'] = $this->m_whole->id_whole_plant_new_select($object['whole_headers'][$j]['plant'],$object['whole_headers'][$j]['posting_date']);
							$object['whole_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['whole_headers'][$j]['status'] = '1';
							$object['whole_headers'][$j]['item_group_code'] = $item_group_code;
							$object['whole_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['whole_headers'][$j]['filename'] = $upload['file_name'];

						$id_whole_header = $this->m_whole->whole_header_insert($object['whole_headers'][$j]);

           	$whole_header_exist = TRUE;
						$k = 1; // whole_detail number

					} else {
           	$whole_header_exist = FALSE;
					}
                    }

				if($whole_header_exist) {


                     if($whole_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
						$object['whole_details'][$j][$k]['id_whole_header'] = $id_whole_header;
						$object['whole_details'][$j][$k]['id_whole_h_detail'] = $k;

						$object['whole_details'][$j][$k]['material_no'] = $material_no;

						$object['whole_details'][$j][$k]['material_desc'] = $whole_detail_temp['MAKTX'];
						$object['whole_details'][$j][$k]['gr_quantity'] = $gr_quantity;

                        $uom_import = $whole_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['whole_details'][$j][$k]['uom'] = $uom_import;

						$id_whole_detail = $this->m_whole->whole_detail_insert($object['whole_details'][$j][$k]);

						$k++;
					}

                   }

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Pemotongan Whole berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['whole_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Pemotongan Whole atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'whole/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
		}

	}
	public function printpdf($id_whole_header)
	{
		$this->load->model('m_retur');
		//$this->load->model('m_stdstock');
		//$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);
		$data['data'] = $this->m_retur->tampil($id_whole_header);
		
		ob_start();
		$content = $this->load->view('retur',$data);
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

public function cetak($id_whole_header)
	{
		$this->load->model('m_retur');
		$data['data'] = $this->model_data->tampil($id_whole_header);
		$this->load->view('retur',$data);
	}	
}
