<?php
class tpaket extends Controller {
	private $jagmodule = array();


	function tpaket() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1052);  //get module data from module ID
		

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
		$this->load->model('m_tpaket');
		$this->load->model('m_general');
		$this->load->model('m_mpaket');
		$this->output->cache(30);

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
		$tpaket_browse_result = $this->session->userdata['PAGE']['tpaket_browse_result'];

		if(!empty($tpaket_browse_result))
			redirect($this->session->userdata['PAGE']['tpaket_browse_result']);
		else
			redirect('tpaket/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('tpaket/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('tpaket/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('tpaket_browse_result');

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
			'b'	=>	'Goods Issue No',

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

		$sort_link1 = 'tpaket/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('tpaket/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_tpaket->tpaket_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['tpaket_headers'] = $this->m_tpaket->tpaket_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List Of Bill Of Produksi Trnsaction';
		$this->template->write_view('content', 'tpaket/tpaket_browse', $object);
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

        $tpaket_detail_tmp = array('tpaket_detail' => '');
        $this->session->unset_userdata($tpaket_detail_tmp);
        unset($tpaket_detail_tmp);
		
		 $tpaket_detail_tmp1 = array('tpaket_detail_paket' => '');
        $this->session->unset_userdata($tpaket_detail_tmp1);
        unset($tpaket_detail_tmp1);

    	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_tpaket_back();

    	if($data['item_groups'] !== FALSE) {
    		$object['item_group_code'][0] = '';
    		$object['item_group_code']['all'] = '==All==';

    		foreach ($data['item_groups'] as $item_group) {
    			$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
    		}
    	}

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('tpaket/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Production Transaction';
		$this->template->write_view('content', 'tpaket/tpaket_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['tpaket_detail']['id_tpaket_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;
					
					 $check[1] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['qty'][1], "tpaket_detail[qty][1]", 'Quantity paket', 'required|is_numeric_no_zero');
				if($check[1]['error'] == TRUE)
				    $validation_temp = FALSE;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['material_no'][$i], "tpaket_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['quantity'][$i], "tpaket_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['quantity_total'][$i], "tpaket_detail[quantity_total][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['material_detail'][$i], "tpaket_detail[material_detail][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++; 
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['num'][$i], "tpaket_detail[num][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['qty'][$i], "tpaket_detail[qty][1]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
          $tpaket_detail_tmp = array('tpaket_detail' => '');
          $this->session->unset_userdata($tpaket_detail_tmp);
          unset($tpaket_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
    		$item_group_code = $this->uri->segment(4);
    		$item_choose = $this->uri->segment(5);
        } else {
    		$item_group_code = $this->uri->segment(3);
    		$item_choose = $this->uri->segment(4);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_tpaket_back();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'tpaket');
		}
exit;
		$data['items'] = $this->m_general->sap_item_groups_select_all_tpaket_back();
		//$data['items'] = $this->m_general->sap_item_groups_select_all_tpaket_back_2();
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
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['tpaket_header'] = $_POST['tpaket_header'];//$this->m_tpaket->tpaket_details_select($this->uri->segment(3));
		  $object['data']['tpaket_detail'] = $_POST['tpaket_detail'];//$this->m_tpaket->tpaket_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Production Transaction';
		$this->template->write_view('content', 'tpaket/tpaket_edit', $object);
		$this->template->render();
	}

	function input_transaksi_baru_error() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Transaksi Transaksi Paket untuk hari ini sudah diinput dan di approve.<br>
                                   Anda hanya bisa menginput 1 transaksi Transaksi Paket dalam 1 hari';
        $object['refresh_url'] = 'tpaket/browse';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '003';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$tpaket = $_POST;
		unset($tpaket['tpaket_header']['id_tpaket_header']);
		unset($tpaket['button']);
		// end of assign variables and delete not used variables

		$count = count($tpaket['tpaket_detail']['id_tpaket_h_detail'])-1;
		
		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($tpaket['tpaket_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('tpaket/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('tpaket', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$tpaket_header['id_tpaket_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('tpaket_detail', $tpaket['tpaket_detail']);

    		$tpaket_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$tpaket_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
			$tpaket_header['id_tpaket_plant'] = $this->m_tpaket->id_tpaket_plant_new_select($tpaket_header['plant']);
// 			$tpaket_header['posting_date'] = $this->m_general->posting_date_select_max($tpaket_header['plant']);
 			$tpaket_header['posting_date'] = $this->l_general->str_to_date($tpaket['tpaket_header']['posting_date']);

			$tpaket_header['material_doc_no'] = '';

			if(isset($_POST['button']['approve']))
				$tpaket_header['status'] = '2';
			else
				$tpaket_header['status'] = '1';

			$tpaket_header['item_group_code'] = $tpaket['tpaket_header']['item_group_code'];
			$tpaket_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($tpaket_header['plant'],$tpaket_header['posting_date'],
                      $tpaket_header['id_tpaket_plant'],'17');
            $internal_order = $this->m_tpaket->tpaket_internal_order_select();

			if($id_tpaket_header = $this->m_tpaket->tpaket_header_insert($tpaket_header)) {

             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $tpaket_to_approve = array (
                      'id_tpaket_header' => $id_tpaket_header,
                      'internal_order' => $internal_order['internal_order'],
                      'plant' => $tpaket_header['plant'],
                      'storage_location' => $tpaket_header['storage_location'],
                      'posting_date' => date('Ymd',strtotime($tpaket_header['posting_date'])),
                      'id_user_input' => $tpaket_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $tpaket_header['receiving_plant'],
                );
             }

//			if($id_tpaket_header = $this->m_tpaket->tpaket_header_insert($tpaket_header)) {

                $input_detail_success = FALSE;
						$tpaket_detail['id_tpaket_header'] = $id_tpaket_header;
						$batch['BaseEntry'] = $id_tpaket_header;
						//$qty=array_sum($tpaket['tpaket_detail']['quantity']);
						$tpaket_detail['quantity'] = $tpaket['tpaket_detail']['qty'][1];
						$tpaket_detail['qty'] = $tpaket['tpaket_detail']['qty'][1];
						$batch['Quantity'] = $tpaket['tpaket_detail']['qty'][1];
						$tpaket_detail['id_tpaket_h_detail'] = 1;
						$batch['BaseLinNum'] = 1;
  						$tpaket_detail['material_no'] = $tpaket['tpaket_detail']['material_no'];
						//$tpaket_detail['num'] = $tpaket['tpaket_detail']['num'][$i];
						$batch['ItemCode'] = $tpaket['tpaket_detail']['material_no'];
						$item=$tpaket['tpaket_detail']['material_no'];
						$date=date('ymd');
						$whs=$this->session->userdata['ADMIN']['plant'];
						//mysql_connect("localhost","root","");
						//mysql_select_db("sap_php");
						$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
						$cek="SELECT BATCH,MAKTX FROM m_item WHERE MATNR = '$item'";
						$cek1=mysql_query($cek);
						$ra=mysql_fetch_array($cek1);
						$b=$ra['BATCH'];
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
						$batch['BatchNum'] = $num;
						$tpaket_detail['num'] = $num;
						$batch['BaseType'] = 4;
						$batch['Createdate'] = $this->l_general->str_to_date($tpaket['tpaket_header']['posting_date']);
  						$tpaket_detail['material_desc'] = $ra['MAKTX'];;
  						$tpaket_detail['uom'] = $tpaket['tpaket_detail']['uom'][1];
						//echo "(".$tpaket['tpaket_detail']['uom'].")";
						
						if ($b=='Y')
						{
						//echo "$batch[BaseEntry],$batch[Quantity],$batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$b <br>";
						$batch_in=$this->m_tpaket->batch_insert($batch);
						}
						
						if($id_tpaket_detail = $this->m_tpaket->tpaket_detail_insert($tpaket_detail)) {
                        

					for($i = 1; $i <= $count; $i++) {
//echo " ".$count."-".$i."(".$tpaket['tpaket_detail']['quantity'][$i].") - (".$tpaket['tpaket_detail']['material_detail'][$i].")";
					if((!empty($tpaket['tpaket_detail']['quantity'][$i]))&&(!empty($tpaket['tpaket_detail']['material_detail'][$i]))) 
					{
					       
						   
						       $tpaket_detail_paket['id_tpaket_h_detail_paket'] = $i;
							   $batch1['BaseLinNum'] =$i;
                               $tpaket_detail_paket['id_tpaket_detail'] = $id_tpaket_detail;
                               $tpaket_detail_paket['id_tpaket_header'] = $id_tpaket_header;
							   $batch1['BaseEntry'] = $id_tpaket_header;
							   $batch1['BaseType'] = 4;
							   $batch1['BatchNum'] = $tpaket['tpaket_detail']['num'][$i];
							   $batch1['Createdate'] =$batch['Createdate'] ;
                               $tpaket_detail_paket['material_no_paket'] = $tpaket_detail['material_no'];
                               $tpaket_detail_paket['material_no'] = $tpaket['tpaket_detail']['material_detail'][$i];
							   $batch1['ItemCode'] = $tpaket['tpaket_detail']['material_detail'][$i];
                               $tpaket_detail_paket['material_desc'] = $item_paket['material_desc'][$i];
                               $tpaket_detail_paket['quantity'] = $tpaket['tpaket_detail']['quantity'][$i];
							   $batch1['Quantity'] =  $tpaket['tpaket_detail']['quantity'][$i];
                               $tpaket_detail_paket['uom'] = $tpaket['tpaket_detail']['detail_uom'][$i];
							   $tpaket_detail_paket['num'] = $tpaket['tpaket_detail']['num'][$i];
							   $tpaket_detail_paket['quantity_total'] = $tpaket['tpaket_detail']['quantity'][$i] * $tpaket['tpaket_detail']['qty'][1];
							  if ($batch1['Quantity'] != "")
								{
									$this->m_tpaket->batch_insert($batch1);
								}
         					   if($this->m_tpaket->tpaket_detail_paket_insert($tpaket_detail_paket)) {
                                   $input_detail_success = TRUE;
         					   } else
                                   $input_detail_success = FALSE; 
                    }    
                    } 
					} else {
                           $input_detail_success = FALSE;
                    	} 
					

				
				

			}

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			  /*  $approved_data = $this->m_tpaket->sap_tpaket_header_approve($tpaket_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '') &&
                   (!empty($approved_data['material_document_out'])) && ($approved_data['material_document_out'] !== '')) {
    			    $tpaket_no = $approved_data['material_document'];
    			    $tpaket_no_out = $approved_data['material_document_out'];*/
    				$data = array (
    					'id_tpaket_header'	=>$id_tpaket_header,
    					'material_doc_no'	=>	$tpaket_no,
    					'material_doc_no_out'	=>	$tpaket_no_out,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_tpaket->tpaket_header_update($data);
  				    $approve_data_success = TRUE;
			/*	} else {
				  $approve_data_success = FALSE;
				}*/
            }

            $this->db->trans_complete();

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Transaksi Paket berhasil dimasukkan', site_url('tpaket/input'));
              } else {
                $this->m_tpaket->tpaket_header_delete($id_tpaket_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Paket tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Transaksi Paket berhasil diapprove', site_url('tpaket/input'));
              } else {
                $this->m_tpaket->tpaket_header_delete($id_tpaket_header);
				$this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Paket tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Paket tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('tpaket/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Paket berhasil diapprove';
		$object['refresh_url'] = site_url('tpaket/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Paket berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('tpaket/input');
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
	}*/


	function edit() {

		$item_choose = $this->uri->segment(6);
	    $tpaket_header = $this->m_tpaket->tpaket_header_select($this->uri->segment(3));
		$status = $tpaket_header['status'];
        unset($tpaket_header);

        $tpaket_detail_tmp = array('tpaket_detail' => '');
        $this->session->unset_userdata($tpaket_detail_tmp);
        unset($tpaket_detail_tmp);
		
		$tpaket_detail_tmp1 = array('tpaket_detail_paket' => '');
        $this->session->unset_userdata($tpaket_detail_tmp1);
        unset($tpaket_detail_tmp1);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['tpaket_detail']['id_tpaket_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['material_no'][$i], "tpaket_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['tpaket_detail']['quantity'][$i], "tpaket_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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


		if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$tpaket_header = $this->m_tpaket->tpaket_header_select($this->uri->segment(3));

				if($tpaket_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['tpaket_header'] = $this->m_tpaket->tpaket_header_select($this->uri->segment(3));
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
          $tpaket_detail_tmp = array('tpaket_detail' => '');
          $this->session->unset_userdata($tpaket_detail_tmp);
          unset($tpaket_detail_tmp);
        }
		$tpaket_detail_tmp1 = array('tpaket_detail_paket' => '');
        $this->session->unset_userdata($tpaket_detail_tmp1);
        unset($tpaket_detail_tmp1);


		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['tpaket_header']['status_string'] = ($object['data']['tpaket_header']['status'] == '2') ? 'Approved' : 'Not Approved';

        if ($this->uri->segment(2) == 'edit') {
    		$item_group_code = 'all';
        } else {
    		$item_group_code = $data['tpaket_header']['item_group_code'];;
        }
		$item_choose = $this->uri->segment(5);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['tpaket_header']['item_group_code'];
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

//exit;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			//$data['items'] = $this->m_general->sap_item_groups_select_all_tpaket();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'tpaket');
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
        }


		if(count($_POST) == 0) { // ------------> ini ngambil data t_tpaket_detail alias header
			$object['data']['tpaket_details'] = $this->m_tpaket->tpaket_details_select($object['data']['tpaket_header']['id_tpaket_header']);

			if($object['data']['tpaket_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['tpaket_details']->result_array() as $object['temp']) {
	//				$object['data']['tpaket_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['tpaket_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		
		/*if(count($_POST) == 0) { //---------------> ini ngambil data t_tpaket_detail_paket (masih eror) alias detail
			$object['data']['tpaket_detail_paket'] = $this->m_tpaket->tpaket_detail_paket_selectdata($object['data']['tpaket_header']['id_tpaket_header']);

			if($object['data']['tpaket_detail_paket'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['tpaket_detail_paket']->result_array() as $object['temp']) {
	//				$object['data']['tpaket_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['tpaket_detail_paket'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		} */
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transaksi Produksi';
		$this->template->write_view('content', 'tpaket/tpaket_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$tpaket = $_POST;
		unset($tpaket['tpaket_header']['id_tpaket_header']);
		unset($tpaket['button']);
		// end of assign variables and delete not used variables

		$count = count($tpaket['tpaket_detail']['id_tpaket_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($tpaket['tpaket_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('tpaket/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('tpaket_detail', $tpaket['tpaket_detail']);

            $id_tpaket_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($tpaket['tpaket_header']['posting_date']);

    			$data = array (
    				'id_tpaket_header' => $id_tpaket_header,
    				'posting_date' => $postingdate,
    			);
				/*$sirah= $id_tpaket_header;
				$ti="SELECT * FROM t_tpaket_detail_paket WHERE id_tpaket_header='$sirah'";
				$tq=mysql_query($ta);
				$count1=mysql_num_rows($tq);*/
                                  	
			    $this->m_tpaket->tpaket_header_update($data);
                $edit_tpaket_header = $this->m_tpaket->tpaket_header_select($id_tpaket_header);

    			if ($this->m_tpaket->tpaket_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_tpaket->tpaket_details_delete($id_tpaket_header) && $this->m_tpaket->batch_delete($id_tpaket_header) ) {
                	//	for($i = 1; $i <= $count; $i++) {
        					if((!empty($tpaket['tpaket_detail']['quantity'][$i]))&&(!empty($tpaket['tpaket_detail']['material_no'][$i]))) {

        						/*$tpaket_detail['id_tpaket_header'] = $id_tpaket_header;
        						$tpaket_detail['quantity'] = $tpaket['tpaket_detail']['quantity'][$i];
        						$tpaket_detail['id_tpaket_h_detail'] = $tpaket['tpaket_detail']['id_tpaket_h_detail'][$i];

        						$tpaket_detail['material_no'] = $tpaket['tpaket_detail']['material_no'][$i];
        						$tpaket_detail['material_desc'] = $tpaket['tpaket_detail']['material_desc'][$i];
        						$tpaket_detail['uom'] = $tpaket['tpaket_detail']['uom'][$i];*/

                                $tpaket_to_approve['item'][$i] = $tpaket_detail['id_tpaket_h_detail'];
                                $tpaket_to_approve['material_no'][$i] = $tpaket_detail['material_no'];
                                $tpaket_to_approve['quantity'][$i] = $tpaket_detail['quantity'];
                                $tpaket_to_approve['uom'][$i] = $tpaket_detail['uom'];
								
								
					//
						$tpaket_detail['id_tpaket_header'] = $id_tpaket_header;
						$batch['BaseEntry'] = $id_tpaket_header;
						$tpaket_detail['quantity'] = $tpaket['tpaket_detail']['qty'][1];
						$tpaket_detail['qty'] = $tpaket['tpaket_detail']['qty'][1];
						$batch['Quantity'] = $tpaket['tpaket_detail']['qty'][1];
						$tpaket_detail['id_tpaket_h_detail'] = 1;
						$batch['BaseLinNum'] = 1;
  						$tpaket_detail['material_no'] = $tpaket['tpaket_detail']['material_no'];
						$batch['ItemCode'] = $tpaket['tpaket_detail']['material_no'];
						$item=$tpaket['tpaket_detail']['material_no'];
						$date=date('ymd');
						$whs=$this->session->userdata['ADMIN']['plant'];
						$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
						$cek="SELECT BATCH,MAKTX FROM m_item WHERE MATNR = '$item'";
						$cek1=mysql_query($cek);
						$ra=mysql_fetch_array($cek1);
						$b=$ra['BATCH'];
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
						if ($count1 < 2)
						{
						$batch['BatchNum'] = $num;
						}
						
						
						$batch['BaseType'] = 4;
						$tpaket_detail['num'] = $num;
						$batch['Createdate'] = $this->l_general->str_to_date($tpaket['tpaket_header']['posting_date']);
  						$tpaket_detail['material_desc'] = $ra['MAKTX'];
  						$tpaket_detail['uom'] = $tpaket['tpaket_detail']['uom'][1];
						if ($b=='Y')
						{
						$batch_in=$this->m_tpaket->batch_insert($batch);
							if ($count1 < 2)
							{
								mysql_query("INSERT INTO m_batch () VALUES ('$item','$num','$batch[Quantity]','$whs')");
							}
						}			
								
					/*	$batch['BaseEntry'] = $id_tpaket_header;
						$batch['Quantity'] =  $tpaket['tpaket_detail']['quantity'][$i];
						$batch['BaseLinNum'] = $tpaket['tpaket_detail']['id_tpaket_h_detail'][$i];
  						$batch['ItemCode'] = $tpaket['tpaket_detail']['material_no'][$i];
						$batch['BatchNum'] = $tpaket['tpaket_detail']['num'][$i];
						$batch['BaseType'] = 4;
						$batch['Createdate'] = $this->l_general->str_to_date($tpaket['tpaket_header']['posting_date']);*/

                         if($id_tpaket_detail = $this->m_tpaket->tpaket_detail_insert($tpaket_detail)) {
                              /*     if($item_pakets = $this->m_mpaket->mpaket_details_select_by_item_paket($tpaket_detail['material_no'])) {
                                     if($item_pakets !== FALSE) {
                                		$k = 1;
                                        unset($item_paket);
                                		foreach ($item_pakets->result_array() as $object['temp']) {
                                			foreach($object['temp'] as $key => $value) {
                                				$item_paket[$key][$k] = $value;
                                			}
                                			$k++;
                                			unset($object['temp']);
                                		}
                                 	 }*/
									// echo "$batch[BaseEntry],$batch[Quantity],$batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$b <br>";
					//	echo $tpaket_detail['id_tpaket_header'].",".$tpaket_detail['quantity'].",".$tpaket_detail['material_no'].",".$tpaket_detail['num'];
									 
									// $c_item_paket = count($item_paket['id_mpaket_h_detail']);
                        			for($i = 1; $i <= $count; $i++) {
                               $tpaket_detail_paket['id_tpaket_h_detail_paket'] = $i;
							   $batch1['BaseLinNum'] =$i;
                               $tpaket_detail_paket['id_tpaket_detail'] = $id_tpaket_detail;
                               $tpaket_detail_paket['id_tpaket_header'] = $id_tpaket_header;
							   $batch1['BaseEntry'] = $id_tpaket_header;
							   $batch1['BaseType'] = 4;
							   $batch1['ItemCode'] = $tpaket['tpaket_detail']['material_detail'][$i];
							   $qq="SELECT * FROM m_batch WHERE ItemCode = '$batch1[ItemCode]' AND Whs ='$whs'";
							   $cekQQ=mysql_query($qq);
							   $rQ=mysql_num_rows($cekQQ);
							   $num_detail=$tpaket['tpaket_detail']['num'][$i];
							   $date=date('ymd');
							   $cekq="SELECT BATCH,MAKTX FROM m_item WHERE MATNR = '$batch1[ItemCode]'";
							   $cekr=mysql_query($cekq);
							   $rai=mysql_fetch_array($cekr);
							   $tpaket_detail_paket['material_desc'] = $rai['MAKTX'];
							   $bet=$ra['MAKTX'];
							   
							   $batch1['Createdate'] =$batch['Createdate'] ;
                               $tpaket_detail_paket['material_no_paket'] = $tpaket_detail['material_no'];
                               $tpaket_detail_paket['material_no'] = $tpaket['tpaket_detail']['material_detail'][$i];
							   $tpaket_detail_paket['material_desc'] = $item_paket['material_desc'][$i];
                               $tpaket_detail_paket['quantity'] = $tpaket['tpaket_detail']['quantity'][$i];
							   $batch1['Quantity'] =  $tpaket['tpaket_detail']['quantity'][$i];
                               $tpaket_detail_paket['uom'] = $tpaket['tpaket_detail']['detail_uom'][$i];
							   $tpaket_detail_paket['num'] = $num_detail;
							    $tpaket_detail_paket['quantity_total'] = $tpaket['tpaket_detail']['quantity'][$i] * $tpaket['tpaket_detail']['qty'][1];
							   if ($num_detail != "" && $bet == 'Y')
							   {
							   $batch1['BatchNum'] = $num_detail;
							   }
							   else
							   {
							   		$count1=$rQ + 1;
										if ($count1 > 9 && $count1 < 100)
										{
											$dg="0";
										}
										else 
										{
											$dg="00";
										}
											$num=$batch1['ItemCode'].$date.$dg.$count1;
											$batch1['BatchNum'] = $num;
											mysql_query("INSERT INTO m_batch () VALUES ('$batch1[ItemCode]','$batch1[BatchNum]','$batch1[Quantity]','$whs')");
							   }
							  
							
							
							//   echo "$batch1[BaseEntry],$batch1[Quantity],$batch1[BaseLinNum],$batch1[ItemCode],$batch1[BatchNum],$b <br>";
							  if ($batch1['Quantity'] != "" && $bet=='Y')
								{
									$this->m_tpaket->batch_insert($batch1);
									
								}
         					   if($this->m_tpaket->tpaket_detail_paket_insert($tpaket_detail_paket)) {
                                   $input_detail_success = TRUE;
         					   } else {
                                   $input_detail_success = FALSE; } } }
                                 
                            	 else {
                                   $input_detail_success = FALSE;
								    //echo "aaaaaaaaaaaaaaaaa";
                            	}
//        						if($this->m_tpaket->tpaket_detail_insert($tpaket_detail))
//                                  $input_detail_success = TRUE;
        					}

            	    	//}
                    }
                }

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $internal_order = $this->m_tpaket->tpaket_internal_order_select();
                $tpaket_to_approve['plant'] = $edit_tpaket_header['plant'];
                $tpaket_to_approve['internal_order'] = $internal_order['internal_order'];
                $tpaket_to_approve['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
                $tpaket_to_approve['posting_date'] = date('Ymd',strtotime($edit_tpaket_header['posting_date']));
                $tpaket_to_approve['id_tpaket_header'] = $id_tpaket_header;
                $tpaket_to_approve['plant'] = $edit_tpaket_header['plant'];
                $tpaket_to_approve['id_tpaket_plant'] = $edit_tpaket_header['id_tpaket_plant'];
                $tpaket_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $tpaket_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_tpaket_header['plant'],$edit_tpaket_header['posting_date'],
                      $edit_tpaket_header['id_tpaket_plant'],'17');
			/*    $approved_data = $this->m_tpaket->sap_tpaket_header_approve($tpaket_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '') &&
                   (!empty($approved_data['material_document_out'])) && ($approved_data['material_document_out'] !== '')) {
    			    $tpaket_no = $approved_data['material_document'];
    			    $tpaket_no_out = $approved_data['material_document_out'];*/
    				$data = array (
    					'id_tpaket_header'	=>$id_tpaket_header,
    					'material_doc_no'	=>	$tpaket_no,
    					'material_doc_no_out'	=>	$tpaket_no_out,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$tpaket_header_update_status = $this->m_tpaket->tpaket_header_update($data);
  				    $approve_data_success = TRUE;
				/*} else {
				  $approve_data_success = FALSE;
				}*/
            }

  			$this->db->trans_complete();
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
   			    $this->l_general->success_page('Data Transaksi Paket berhasil diubah', site_url('tpaket/browse'));
              } else {
 			    $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Paket tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
  			     $this->l_general->success_page('Data Transaksi Paket berhasil diapprove', site_url('tpaket/browse'));
              } else {
    		     $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Paket tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'tpaket/browse';
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
		$tpaket = $_POST;
		unset($tpaket['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($tpaket['tpaket_header']['posting_date']!=$date_today) {
			redirect('tpaket/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($tpaket['cancel'])) {
            $quantity_exist = FALSE;
    	} else {
    		$quantity_exist = TRUE;
    	}

		if($quantity_exist == FALSE)
			redirect('tpaket/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('tpaket', 1, date("Y-m-d")) {

        $edit_tpaket_header = $this->m_tpaket->tpaket_header_select($tpaket['tpaket_header']['id_tpaket_header']);
		$edit_tpaket_details = $this->m_tpaket->tpaket_details_select($tpaket['tpaket_header']['id_tpaket_header']);
		$edit_tpaket_details_paket = $this->m_tpaket->tpaket_detail_paket_select($tpaket['tpaket_header']['id_tpaket_header'],$tpaket['tpaket_detail']['id_tpaket_detail']);
    	$i = 1;
	    foreach ($edit_tpaket_details->result_array() as $value) {
		    $edit_tpaket_detail[$i] = $value;
		    $i++;
        }
        unset($edit_tpaket_details);

		if(isset($_POST['button']['cancel'])) {

//			$tpaket_header['id_tpaket_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $internal_order = $this->m_tpaket->tpaket_internal_order_select();
            $tpaket_to_cancel['id_tpaket_header'] = $tpaket['tpaket_header']['id_tpaket_header'];
            $tpaket_to_cancel['internal_order'] = $internal_order['internal_order'];
            $tpaket_to_cancel['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $tpaket_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_tpaket_header['posting_date']));
            $tpaket_to_cancel['posting_date'] = date('Ymd',strtotime($edit_tpaket_header['posting_date']));
            $tpaket_to_cancel['plant'] = $edit_tpaket_header['plant'];
			$tpaket_to_cancel['id_tpaket_plant'] = $this->m_tpaket->id_tpaket_plant_new_select($edit_tpaket_header['plant'],date('Y-m-d',strtotime($edit_tpaket_header['posting_date'])));
            $tpaket_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_tpaket_header['plant'],$edit_tpaket_header['posting_date'],
                      $tpaket_to_cancel['id_tpaket_plant'],'17');
            $tpaket_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_tpaket_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($tpaket['cancel'][$i])) {
       		     $tpaket_to_cancel['item'][$i] = $i;
                 $tpaket_to_cancel['material_no'][$i] = $edit_tpaket_detail[$i]['material_no'];
                 $tpaket_to_cancel['quantity'][$i] = $edit_tpaket_detail[$i]['quantity'];
                 $tpaket_to_cancel['uom'][$i] = $edit_tpaket_detail[$i]['uom'];
               }
            }
            $cancelled_data = $this->m_tpaket->sap_tpaket_header_cancel($tpaket_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
			    $mat_doc_cancellation_out = $cancelled_data['material_document_out'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($tpaket['cancel'][$i])) {
    	    			$tpaket_header = array (
    						'id_tpaket_header'=>$tpaket['tpaket_header']['id_tpaket_header'],
    						'id_tpaket_plant'=>$tpaket_to_cancel['id_tpaket_plant'],
    					);
    		    		if($this->m_tpaket->tpaket_header_update($tpaket_header)==TRUE) {
        	    			$tpaket_detail = array (
        						'id_tpaket_detail'=>$edit_tpaket_detail[$i]['id_tpaket_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'material_docno_out_cancellation'=>$mat_doc_cancellation_out,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_tpaket->tpaket_detail_update($tpaket_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
		    $this->l_general->success_page('Data Transaksi Paket berhasil dibatalkan', site_url('tpaket/browse'));

            } else {
			$this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Paket tidak  berhasil dibatalkan.<br>
                                          Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Paket tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_tpaket_header) {

		$this->db->trans_start();

		// check approve status
		$tpaket_header = $this->m_tpaket->tpaket_header_select($id_tpaket_header);

		if($tpaket_header['status'] == '1') {
			$this->m_tpaket->tpaket_header_delete($id_tpaket_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_tpaket_header) {

		if($this->_delete($id_tpaket_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transaksi Paket berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tpaket_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transaksi Paket gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tpaket_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_tpaket_header']))
			redirect($this->session->userdata['PAGE']['tpaket_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_tpaket_header'][$i])) {
				$object['data']['tpaket_headers'][$j++] = $this->m_tpaket->tpaket_header_select($_POST['id_tpaket_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'tpaket/tpaket_export_confirm', $object);
        else
    	  $this->template->write_view('content', 'tpaket/tpaket_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_tpaket_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Produksi berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['tpaket_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_tpaket->tpaket_select_to_export($_POST['id_tpaket_header']);

    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'tpaket');
          //to_excel($data);
          //require_once 'php-excel.class.php';
          //$xls = new Excel_XML();
          //$xls->addArray($data);
          //$xls->generateXML('tpaket');
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'tpaket_data';
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

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpo template file?
			if($excel['cells'][1][1] == 'Material Doc. No' && $excel['cells'][1][2] == 'Material No.') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$item_group_code='all';
					$material_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];
					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
							$object['tpaket_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['tpaket_headers'][$j]['material_doc_no'] = $excel['cells'][$i][1];
							$object['tpaket_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['tpaket_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['tpaket_headers'][$j]['status'] = '1';
							$object['tpaket_headers'][$j]['item_group_code'] = $item_group_code;
							$object['tpaket_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['tpaket_headers'][$j]['filename'] = $upload['file_name'];
            	            $tpaket_header_exist = TRUE;
							$k = 1; // grpo_detail number
					}

					if($tpaket_header_exist) {

						if($tpaket_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['tpaket_details'][$j][$k]['id_grpo_h_detail'] = $k;
							$object['tpaket_details'][$j][$k]['item'] = $k;
							$object['tpaket_details'][$j][$k]['material_no'] = $material_no;
							$object['tpaket_details'][$j][$k]['material_desc'] = $tpaket_detail_temp['MAKTX'];
							$object['tpaket_details'][$j][$k]['quantity'] = $quantity;
                            if ($tpaket_detail_temp['UNIT']=='L')
                              $tpaket_detail_temp['UNIT'] = 'ML';
                            if ($tpaket_detail_temp['UNIT']=='KG')
                              $tpaket_detail_temp['UNIT'] = 'G';
							$object['tpaket_details'][$j][$k]['uom'] = $tpaket_detail_temp['UNIT'];
							$k++;
						}

					}

				}

				$this->template->write_view('content', 'tpaket/tpaket_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Paket atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'tpaket/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
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
	if($excel['cells'][1][1] == 'Material Doc. No' && $excel['cells'][1][2] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

			  	$item_group_code='all';
					$material_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];


				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;

					   	$object['tpaket_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

							$object['tpaket_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['tpaket_headers'][$j]['id_tpaket_plant'] = $this->m_tpaket->id_tpaket_plant_new_select($object['tpaket_headers'][$j]['plant']);
							$object['tpaket_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['tpaket_headers'][$j]['status'] = '1';
							$object['tpaket_headers'][$j]['item_group_code'] = $item_group_code;
							$object['tpaket_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['tpaket_headers'][$j]['filename'] = $upload['file_name'];

						$id_tpaket_header = $this->m_tpaket->tpaket_header_insert($object['tpaket_headers'][$j]);

                       	$tpaket_header_exist = TRUE;
						$k = 1; // grpo_detail number

				}

				if($tpaket_header_exist) {

					if($tpaket_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                            $object['tpaket_details'][$j][$k]['id_tpaket_header'] = $id_tpaket_header;
						    $object['tpaket_details'][$j][$k]['id_tpaket_h_detail'] = $k;
							$object['tpaket_details'][$j][$k]['material_no'] = $material_no;
							$object['tpaket_details'][$j][$k]['material_desc'] = $tpaket_detail_temp['MAKTX'];
							$object['tpaket_details'][$j][$k]['quantity'] = $quantity;
                            if ($tpaket_detail_temp['UNIT']=='L')
                              $tpaket_detail_temp['UNIT'] = 'ML';
                            if ($tpaket_detail_temp['UNIT']=='KG')
                              $tpaket_detail_temp['UNIT'] = 'G';
							$object['tpaket_details'][$j][$k]['uom'] = $tpaket_detail_temp['UNIT'];

//						$id_tpaket_detail = $this->m_tpaket->tpaket_detail_insert($object['tpaket_details'][$j][$k]);
    				    if($id_tpaket_detail = $this->m_tpaket->tpaket_detail_insert($object['tpaket_details'][$j][$k])) {

                           if(($quantity > 0)&&($item_pakets = $this->m_mpaket->mpaket_details_select_by_item_paket($material_no))) {
                             if($item_pakets !== FALSE) {
                        		$l = 1;
                        		foreach ($item_pakets->result_array() as $object['temp']) {
                        			foreach($object['temp'] as $key => $value) {
                        				$item_paket[$key][$l] = $value;
                        			}
                        			$l++;
                        			unset($object['temp']);
                        		}
                         	 }
                          	 $c_item_paket = count($item_paket['id_mpaket_h_detail']);
                			 for($m = 1; $m <= $c_item_paket; $m++) {
                               $tpaket_detail_paket['id_tpaket_h_detail_paket'] = $m;
                               $tpaket_detail_paket['id_tpaket_detail'] = $id_tpaket_detail;
                               $tpaket_detail_paket['id_tpaket_header'] = $id_tpaket_header;
                               $tpaket_detail_paket['material_no_paket'] = $material_no;
                               $tpaket_detail_paket['material_no'] = $item_paket['material_no'][$m];
                               $tpaket_detail_paket['material_desc'] = $item_paket['material_desc'][$m];
                               $tpaket_detail_paket['quantity'] = ($item_paket['quantity'][$m]/$item_paket['quantity_paket'][$m])*$quantity;
                               $tpaket_detail_paket['uom'] = $item_paket['uom'][$m];
         					   $this->m_tpaket->tpaket_detail_paket_insert($tpaket_detail_paket);
                             }
                          }
    				    }

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transaksi Paket berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tpaket_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Paket atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'tpaket/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '011';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>