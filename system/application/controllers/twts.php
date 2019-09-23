<?php
class twts extends Controller {
	private $jagmodule = array();


	function twts() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1055);  //get module data from module ID
		

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
		$this->load->model('m_twts');
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
		$twts_browse_result = $this->session->userdata['PAGE']['twts_browse_result'];

		if(!empty($twts_browse_result))
			redirect($this->session->userdata['PAGE']['twts_browse_result']);
		else
			redirect('twts/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('twts/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('twts/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('twts_browse_result');

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
			'a'	=>	'Goods Issue No',
			'b'	=>	'Goods Receipt No',

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

		$sort_link1 = 'twts/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('twts/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_twts->twts_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['twts_headers'] = $this->m_twts->twts_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Transaksi Pemotongan Whole di Outlet  ';
		$this->template->write_view('content', 'twts/twts_browse', $object);
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

        $twts_detail_tmp = array('twts_detail' => '');
        $this->session->unset_userdata($twts_detail_tmp);
        unset($twts_detail_tmp);

    	//$data['item_groups'] = $this->m_general->sap_item_groups_select_all_twts();

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
			redirect('twts/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Transaksi Pemotongan Whole di Outlet';
		$this->template->write_view('content', 'twts/twts_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(isset($_POST['button']['add'])||isset($_POST['button']['save'])||isset($_POST['button']['approve'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['twts_detail']['id_twts_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['material_no'][$i], "twts_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['material_no_gr'][$i], "twts_detail[material_no_gr][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['uom_gr'][$i], "twts_detail[uom_gr][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['quantity'][$i], "twts_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['var'][$i], "twts_detail[var][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
          $twts_detail_tmp = array('twts_detail' => '');
          $this->session->unset_userdata($twts_detail_tmp);
          unset($twts_detail_tmp);
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
        $item_whole = $data['twts_detail']['material_no'][$data['count_k']];

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			//$data['items'] = $this->m_general->sap_item_groups_select_all_twts();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grfg','X');
		}
//exit;

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
        if(!empty($item_whole)) {
    		$data['items_gr'] = $this->m_twts->twts_item_slice_select($item_whole);

    		if($data['items_gr'] !== FALSE) {
    			$object['item_gr'][''] = '';

    			foreach ($data['items_gr'] as $data['item_gr']) {
    				if($item_choose == 1) {
    					$object['item_gr'][$data['item_gr']['MATNR']] = $data['item_gr']['MATNR1'].' - '.$data['item_gr']['MAKTX'].' ('.$data['item_gr']['UNIT'].')';
    				} elseif ($item_choose == 2) {
    					$object['item_gr'][$data['item_gr']['MATNR']] = $data['item_gr']['MAKTX'].' - '.$data['item_gr']['MATNR1'].' ('.$data['item_gr']['UNIT'].')';
    				}
    			}
    		}
        }

//        echo "<pre>";
//        print_r($object['item_gr']);
//        echo "</pre>";

        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
              ksort($object['item_gr']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
              asort($object['item_gr']);
            }
        }
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['twts_header'] = $_POST['twts_header'];//$this->m_twts->twts_details_select($this->uri->segment(3));
		  $object['data']['twts_detail'] = $_POST['twts_detail'];//$this->m_twts->twts_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Transaksi Pemotongan Whole di Outlet';
		$this->template->write_view('content', 'twts/twts_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$twts = $_POST;
		unset($twts['twts_header']['id_twts_header']);
		unset($twts['button']);
		// end of assign variables and delete not used variables

		$count = count($twts['twts_detail']['id_twts_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($twts['twts_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('twts/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($twts['twts_header']['posting_date'])==FALSE)) {
     	   redirect('twts/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

//		if($this->m_config->running_number_select_update('twts', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$twts_header['id_twts_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('twts_detail', $twts['twts_detail']);

    		$twts_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$twts_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$twts_header['posting_date'] = $this->m_general->posting_date_select_max($twts_header['plant']);
 			$twts_header['posting_date'] = $this->l_general->str_to_date($twts['twts_header']['posting_date']);
			$twts_header['id_twts_plant'] = $this->m_twts->id_twts_plant_new_select($twts_header['plant'],	$twts_header['posting_date']);

			$twts_header['gi_no'] = '';
			$twts_header['gr_no'] = '';

			if(isset($_POST['button']['approve']))
				$twts_header['status'] = '2';
			else
				$twts_header['status'] = '1';

			$twts_header['item_group_code'] = $twts['twts_header']['item_group_code'];
			$twts_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $internal_order = $this->m_twts->twts_internal_order_select();

            $web_trans_id = $this->l_general->_get_web_trans_id($twts_header['plant'],$twts_header['posting_date'],
                      $twts_header['id_twts_plant'],'16');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $twts_to_approve = array (
                      'internal_order' => $internal_order['internal_order'],
                      'plant' => $twts_header['plant'],
                      'storage_location' => $twts_header['storage_location'],
                      'posting_date' => date('Ymd',strtotime($twts_header['posting_date'])),
                      'id_user_input' => $twts_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $twts_header['receiving_plant'],
                );
              }
//              echo "<pre>";
//              print_r($twts['twts_detail']);
//              echo "</pre>";
//              exit;
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
			if($id_twts_header = $this->m_twts->twts_header_insert($twts_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($twts['twts_detail']['quantity'][$i]))&&(!empty($twts['twts_detail']['material_no'][$i]))) {

						$twts_detail['id_twts_header'] = $id_twts_header;
						$batch['BaseEntry'] = $id_twts_header;
						$batch1['BaseEntry'] = $id_twts_header;
  						$twts_detail['konv_qty'] = $twts['twts_detail']['konv_qty'][$i];
  						$twts_detail['quantity'] = $twts['twts_detail']['quantity'][$i];
						$batch['Quantity'] =  $twts['twts_detail']['quantity'][$i];
						$twts_detail['quantity_gr'] = $twts['twts_detail']['quantity'][$i]*$twts['twts_detail']['konv_qty'][$i];
						$batch1['Quantity'] = $twts_detail['quantity_gr'];
  						$twts_detail['id_twts_h_detail'] = $twts['twts_detail']['id_twts_h_detail'][$i];
						$twts_detail['num'] = $twts['twts_detail']['num'][$i];
						$batch['BatchNum'] = $twts['twts_detail']['num'][$i];
						$batch['BaseLinNum'] =$twts['twts_detail']['id_twts_h_detail'][$i];
						$batch1['BaseLinNum'] =$twts['twts_detail']['id_twts_h_detail'][$i];

   						$item = $this->m_general->sap_item_select_by_item_code($twts['twts_detail']['material_no'][$i]);
//   						$item_gr = $this->m_general->sap_item_select_by_item_code($twts['twts_detail']['material_no'][$i]);

  						$twts_detail['material_no'] = $twts['twts_detail']['material_no'][$i];
						$batch['ItemCode'] =  $twts['twts_detail']['material_no'][$i];
						$batch['Createdate'] = date('Y-m-d',strtotime($twts_header['posting_date']));
						$btc=$twts['twts_detail']['num'][$i];
						$batch['BaseType'] = 5;
						$batch['status'] = 10;
						$item=$twts['twts_detail']['material_no_gr'][$i];
						$batch1['ItemCode'] = $item;
						$batch1['Createdate'] = date('Y-m-d',strtotime($twts_header['posting_date']));
						// generate batch num batch1
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
						$batch1['BatchNum'] = $num;
						$batch1['BaseType'] = 5;
						$batch1['status'] = 11;
  						$twts_detail['material_desc'] = $twts['twts_detail']['material_desc'][$i];
  						$twts_detail['uom'] = $twts['twts_detail']['uom'][$i];
  						$twts_detail['material_no_gr'] = $twts['twts_detail']['material_no_gr'][$i];
  						$twts_detail['material_desc_gr'] = $twts['twts_detail']['material_desc_gr'][$i];
  						$twts_detail['uom_gr'] = $twts['twts_detail']['uom_gr'][$i];

                        //array utk parameter masukan pada saat approval
                        $twts_to_approve['item'][$i] = $twts_detail['id_twts_h_detail'];
                        $twts_to_approve['material_no'][$i] = $twts_detail['material_no'];
                        $twts_to_approve['material_no_gr'][$i] = $twts_detail['material_no_gr'];
                        $twts_to_approve['quantity'][$i] = $twts_detail['quantity'];
                        $twts_to_approve['quantity_gr'][$i] = $twts_detail['quantity_gr'];
						
//                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                           $twts_to_approve['uom'][$i] = $twts_detail['uom'];
//                        } else {
//                            $twts_to_approve['uom'][$i] = $item['MEINS'];
//                        }
                        $twts_to_approve['uom_gr'][$i] = $twts_detail['uom_gr'];
						
                        //
						if ($batch['BatchNum'] != "" && $batch1['BatchNum'] != "" /* && $b == 'Y'*/)
						{
						//echo "$batch[BaseEntry],$batch[Quantity],$batch[BaseLinNum],$batch[ItemCode],$batch[Createdate],$batch[BatchNum],";
						//echo "$batch1[BaseEntry],$batch1[Quantity],$batch1[BaseLinNum],$batch1[ItemCode],$batch1[Createdate],$batch1[BatchNum],";
							$this->m_twts->batch_insert($batch);
							$this->m_twts->batch_insert($batch1);
							if ($batch1['BatchNum'] != "")
							{
							mysql_query("INSERT INTO m_batch () VALUES ('$batch1[ItemCode]','$batch1[BatchNum]','$batch1[Quantity]','$whs')");
							}
							
						}

						if($this->m_twts->twts_detail_insert($twts_detail))
                          $input_detail_success = TRUE; 
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    //$approved_data = $this->m_twts->sap_twts_header_approve($twts_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $gi_no = '';//$approved_data['material_document'];
    			    $gr_no = '';//$approved_data['material_document_gr'];
    				$data = array (
    					'id_twts_header'	=>$id_twts_header,
    					'gi_no'	=>	$gi_no,
    					'gr_no'	=>	$gr_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_twts->twts_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Transaksi Pemotongan Whole di Outlet berhasil dimasukkan', site_url('twts/input'));
              } else {
                $this->m_twts->twts_header_delete($id_twts_header);
				$this->jagmodule['error_code'] = '003';
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Pemotongan Whole di Outlet tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));

              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			    $this->l_general->success_page('Data Transaksi Pemotongan Whole di Outlet berhasil dimasukkan', site_url('twts/input'));
              } else {
                $this->m_twts->twts_header_delete($id_twts_header);
				$this->jagmodule['error_code'] = '004';
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Pemotongan Whole di Outlet tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('twts/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet berhasil diapprove';
		$object['refresh_url'] = site_url('twts/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('twts/input');
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
	    $twts_header = $this->m_twts->twts_header_select($this->uri->segment(3));
		$status = $twts_header['status'];
        unset($twts_header);

        $twts_detail_tmp = array('twts_detail' => '');
        $this->session->unset_userdata($twts_detail_tmp);
        unset($twts_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(isset($_POST['button']['add'])||isset($_POST['button']['save'])||isset($_POST['button']['approve'])) {
//			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['twts_detail']['id_twts_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['material_no'][$i], "twts_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['twts_detail']['quantity'][$i], "twts_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
				$twts_header = $this->m_twts->twts_header_select($this->uri->segment(3));

				if($twts_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['twts_header'] = $this->m_twts->twts_header_select($this->uri->segment(3));
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
          $twts_detail_tmp = array('twts_detail' => '');
          $this->session->unset_userdata($twts_detail_tmp);
          unset($twts_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['twts_header']['status_string'] = ($object['data']['twts_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$receiving_plant = $data['twts_header']['receiving_plant'];
		$item_group_code = $data['twts_header']['item_group_code'];;
		$item_choose = $this->uri->segment(5);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['twts_header']['item_group_code'];
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

		$object['receiving_plant'] = $this->m_general->sap_plant_select($receiving_plant);
        $item_whole = $data['twts_detail']['material_no'][$data['count_k']];
//exit;

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			//$data['items'] = $this->m_general->sap_item_groups_select_all_twts();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grfg','X');
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

        if(!empty($item_whole)) {
    		$data['items_gr'] = $this->m_twts->twts_item_slice_select($item_whole);
    		if($data['items_gr'] !== FALSE) {
    			$object['item_gr'][''] = '';

    			foreach ($data['items_gr'] as $data['item_gr']) {
    				if($item_choose == 1) {
    					$object['item_gr'][$data['item_gr']['MATNR']] = $data['item_gr']['MATNR1'].' - '.$data['item_gr']['MAKTX'].' ('.$data['item_gr']['UNIT'].')';
    				} elseif ($item_choose == 2) {
    					$object['item_gr'][$data['item_gr']['MATNR']] = $data['item_gr']['MAKTX'].' - '.$data['item_gr']['MATNR1'].' ('.$data['item_gr']['UNIT'].')';
    				}
    			}
    		}
        }

        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
              ksort($object['item_gr']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
              asort($object['item_gr']);
            }
        }


		if(count($_POST) == 0) {
			$object['data']['twts_details'] = $this->m_twts->twts_details_select($object['data']['twts_header']['id_twts_header']);

			if($object['data']['twts_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['twts_details']->result_array() as $object['temp']) {
	//				$object['data']['twts_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['twts_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transaksi Pemotongan Whole di Outlet';
		$this->template->write_view('content', 'twts/twts_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$twts = $_POST;
		unset($twts['twts_header']['id_twts_header']);
		unset($twts['button']);
		// end of assign variables and delete not used variables

		$count = count($twts['twts_detail']['id_twts_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($twts['twts_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('twts/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($twts['twts_header']['posting_date'])==FALSE)) {
     	   redirect('twts/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('twts_detail', $twts['twts_detail']);

            $id_twts_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($twts['twts_header']['posting_date']);
			$id_twts_plant = $this->m_twts->id_twts_plant_new_select("",$postingdate,$id_twts_header);

    			$data = array (
    				'id_twts_header' => $id_twts_header,
                    'id_twts_plant' => $id_twts_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_twts->twts_header_update($data);
                $edit_twts_header = $this->m_twts->twts_header_select($id_twts_header);

    			if ($this->m_twts->twts_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_twts->twts_details_delete($id_twts_header) && $this->m_twts->batch_delete($id_twts_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($twts['twts_detail']['quantity'][$i]))&&(!empty($twts['twts_detail']['material_no'][$i]))) {

        					/*	$twts_detail['id_twts_header'] = $id_twts_header;
        						$twts_detail['konv_qty'] = $twts['twts_detail']['konv_qty'][$i];
        						$twts_detail['quantity'] = $twts['twts_detail']['quantity'][$i];
          						$twts_detail['quantity_gr'] = $twts['twts_detail']['quantity'][$i]*$twts['twts_detail']['konv_qty'][$i];
        						$twts_detail['id_twts_h_detail'] = $twts['twts_detail']['id_twts_h_detail'][$i];

           						$item = $this->m_general->sap_item_select_by_item_code($twts['twts_detail']['material_no'][$i]);

        						$twts_detail['material_no'] = $twts['twts_detail']['material_no'][$i];
        						$twts_detail['material_desc'] = $twts['twts_detail']['material_desc'][$i];
        						$twts_detail['uom'] = $twts['twts_detail']['uom'][$i];
        						$twts_detail['material_no_gr'] = $twts['twts_detail']['material_no_gr'][$i];
        						$twts_detail['material_desc_gr'] = $twts['twts_detail']['material_desc_gr'][$i];
        						$twts_detail['uom_gr'] = $twts['twts_detail']['uom_gr'][$i];

                                //array utk parameter masukan pada saat approval
                                $twts_to_approve['item'][$i] = $twts_detail['id_twts_h_detail'];
                                $twts_to_approve['material_no'][$i] = $twts_detail['material_no'];
                                $twts_to_approve['material_no_gr'][$i] = $twts_detail['material_no_gr'];
                                $twts_to_approve['quantity'][$i] = $twts_detail['quantity'];
                                $twts_to_approve['quantity_gr'][$i] = $twts_detail['quantity_gr']; */
						
						$twts_detail['id_twts_header'] = $id_twts_header;
						$batch['BaseEntry'] = $id_twts_header;
						$batch1['BaseEntry'] = $id_twts_header;
  						$twts_detail['konv_qty'] = $twts['twts_detail']['konv_qty'][$i];
  						$twts_detail['quantity'] = $twts['twts_detail']['quantity'][$i];
						$batch['Quantity'] =  $twts['twts_detail']['quantity'][$i];
						$twts_detail['quantity_gr'] = $twts['twts_detail']['quantity'][$i]*$twts['twts_detail']['konv_qty'][$i];
						$batch1['Quantity'] = $twts_detail['quantity_gr'];
  						$twts_detail['id_twts_h_detail'] = $twts['twts_detail']['id_twts_h_detail'][$i];
						$twts_detail['num'] = $twts['twts_detail']['num'][$i];
						$batch['BaseLinNum'] =$twts['twts_detail']['id_twts_h_detail'][$i];
						$batch1['BaseLinNum'] =$twts['twts_detail']['id_twts_h_detail'][$i];

   						$item = $this->m_general->sap_item_select_by_item_code($twts['twts_detail']['material_no'][$i]);
//   						$item_gr = $this->m_general->sap_item_select_by_item_code($twts['twts_detail']['material_no'][$i]);

  						$twts_detail['material_no'] = $twts['twts_detail']['material_no'][$i];
						$batch['ItemCode'] =  $twts['twts_detail']['material_no'][$i];
						$batch['Createdate'] = date('Y-m-d',strtotime($twts_header['posting_date']));
						$batch['BatchNum'] = $twts['twts_detail']['num'][$i];
						$batch['BaseType'] = 5;
						$batch['status'] = 10;
						$item=$twts['twts_detail']['material_no_gr'][$i];
						$batch1['ItemCode'] = $item;
						$batch1['Createdate'] = date('Y-m-d',strtotime($twts_header['posting_date']));
						// generate batch num
						$date=date('ymd');
						$whs=$this->session->userdata['ADMIN']['plant'];
						mysql_connect("localhost","root","");
						mysql_select_db("sap_php");
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
						$batch1['BatchNum'] = $num;
						$batch1['BaseType'] = 5;
						$batch1['status'] = 11;
  						$twts_detail['material_desc'] = $twts['twts_detail']['material_desc'][$i];
  						$twts_detail['uom'] = $twts['twts_detail']['uom'][$i];
  						$twts_detail['material_no_gr'] = $twts['twts_detail']['material_no_gr'][$i];
  						$twts_detail['material_desc_gr'] = $twts['twts_detail']['material_desc_gr'][$i];
  						$twts_detail['uom_gr'] = $twts['twts_detail']['uom_gr'][$i];

                        //array utk parameter masukan pada saat approval
                        $twts_to_approve['item'][$i] = $twts_detail['id_twts_h_detail'];
                        $twts_to_approve['material_no'][$i] = $twts_detail['material_no'];
                        $twts_to_approve['material_no_gr'][$i] = $twts_detail['material_no_gr'];
                        $twts_to_approve['quantity'][$i] = $twts_detail['quantity'];
                        $twts_to_approve['quantity_gr'][$i] = $twts_detail['quantity_gr'];
        //                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $twts_to_approve['uom'][$i] = $twts_detail['uom'];
        //                        } else {
        //                            $twts_to_approve['uom'][$i] = $item['MEINS'];
        //                        }
                                $twts_to_approve['uom_gr'][$i] = $twts_detail['uom_gr'];
								
                               if ($batch['BatchNum'] != "" && $batch1['BatchNum'] != "" /* && $b == 'Y'*/)
						{
						//echo "$batch[BaseEntry],$batch[Quantity],$batch[BaseLinNum],$batch[ItemCode],$batch[Createdate],$batch[BatchNum], <br>";
						//echo "$batch1[BaseEntry],$batch1[Quantity],$batch1[BaseLinNum],$batch1[ItemCode],$batch1[Createdate],$batch1[BatchNum],";
							$this->m_twts->batch_insert($batch);
							$this->m_twts->batch_insert($batch1);
							/*if ($batch1['BatchNum'] != "")
							{
							mysql_query("INSERT INTO m_batch () VALUES ('$batch1[ItemCode]','$batch1[BatchNum]','$batch1[Quantity]','$whs')");
							}*/
							
						}

        						if($this->m_twts->twts_detail_insert($twts_detail))
                                  $input_detail_success = TRUE;
        					}

               	    	}
                    }
                }

  			$this->db->trans_complete();
			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $internal_order = $this->m_twts->twts_internal_order_select();
                $twts_to_approve['internal_order'] = $internal_order['internal_order'];
                $twts_to_approve['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
                $twts_to_approve['posting_date'] = date('Ymd',strtotime($edit_twts_header['posting_date']));
                $twts_to_approve['plant'] = $edit_twts_header['plant'];
                $twts_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $twts_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_twts_header['plant'],$edit_twts_header['posting_date'],
                      $edit_twts_header['id_twts_plant'],'16');
			    //$approved_data = $this->m_twts->sap_twts_header_approve($twts_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $gi_no = '';//$approved_data['material_document'];
    			    $gr_no = '';//$approved_data['material_document_gr'];
    				$data = array (
    					'id_twts_header' =>$id_twts_header,
    					'gi_no'	=>	$gi_no,
    					'gr_no'	=>	$gr_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$twts_header_update_status = $this->m_twts->twts_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Transaksi Pemotongan Whole di Outlet berhasil diubah', site_url('twts/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005';
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Pemotongan Whole di Outlet tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Transaksi Pemotongan Whole di Outlet berhasil diapprove', site_url('twts/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006';
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Pemotongan Whole di Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'twts/browse';
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
		$twts = $_POST;
		unset($twts['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($twts['twts_header']['posting_date']!=$date_today) {
			redirect('twts/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($twts['cancel'])) {
            $quantity_exist = FALSE;
    	} else {
    		$quantity_exist = TRUE;
    	}

		if($quantity_exist == FALSE)
			redirect('twts/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('twts', 1, date("Y-m-d")) {

        $edit_twts_header = $this->m_twts->twts_header_select($twts['twts_header']['id_twts_header']);
		$edit_twts_details = $this->m_twts->twts_details_select($twts['twts_header']['id_twts_header']);
    	$i = 1;
	    foreach ($edit_twts_details->result_array() as $value) {
		    $edit_twts_detail[$i] = $value;
		    $i++;
        }
        unset($edit_twts_details);

		if(isset($_POST['button']['cancel'])) {

//			$twts_header['id_twts_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $internal_order = $this->m_twts->twts_internal_order_select();
            $twts_to_cancel['internal_order'] = $internal_order['internal_order'];
            $twts_to_cancel['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $twts_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_twts_header['posting_date']));
            $twts_to_cancel['posting_date'] = date('Ymd',strtotime($edit_twts_header['posting_date']));
            $twts_to_cancel['plant'] = $edit_twts_header['plant'];
			$twts_to_cancel['id_twts_plant'] = $this->m_twts->id_twts_plant_new_select($edit_twts_header['plant'],date('Y-m-d',strtotime($edit_twts_header['posting_date'])));
            $twts_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_twts_header['plant'],$edit_twts_header['posting_date'],
                      $twts_to_cancel['id_twts_plant'],'14');
            $twts_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_twts_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($twts['cancel'][$i])) {
       		     $twts_to_cancel['item'][$i] = $i;
                 $twts_to_cancel['material_no'][$i] = $edit_twts_detail[$i]['material_no'];
                 $twts_to_cancel['material_no_gr'][$i] = $edit_twts_detail[$i]['material_no_gr'];
                 $twts_to_cancel['quantity'][$i] = $edit_twts_detail[$i]['quantity'];
                 $twts_to_cancel['quantity_gr'][$i] = $edit_twts_detail[$i]['quantity_gr'];
                 $twts_to_cancel['uom'][$i] = $edit_twts_detail[$i]['uom'];
                 $twts_to_cancel['uom_gr'][$i] = $edit_twts_detail[$i]['uom_gr'];
               }
            }
            $cancelled_data = $this->m_twts->sap_twts_header_cancel($twts_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
			    $mat_doc_cancellation_gr = $cancelled_data['material_document_gr'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($twts['cancel'][$i])) {
    	    			$twts_header = array (
    						'id_twts_header'=>$twts['twts_header']['id_twts_header'],
    						'id_twts_plant'=>$twts_to_cancel['id_twts_plant'],
    					);
    		    		if($this->m_twts->twts_header_update($twts_header)==TRUE) {
        	    			$twts_detail = array (
        						'id_twts_detail'=>$edit_twts_detail[$i]['id_twts_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'material_docno_gr_cancellation'=>$mat_doc_cancellation_gr,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_twts->twts_detail_update($twts_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
		    $this->l_general->success_page('Data Transaksi Pemotongan Whole di Outlet berhasil dibatalkan', site_url('twts/browse'));

            } else {
			$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transaksi Pemotongan Whole di Outlet tidak  berhasil dibatalkan.<br>
                                          Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_twts_header) {

		$this->db->trans_start();

		// check approve status
		$twts_header = $this->m_twts->twts_header_select($id_twts_header);

		if($twts_header['status'] == '1') {
			$this->m_twts->twts_header_delete($id_twts_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_twts_header) {

		if($this->_delete($id_twts_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['twts_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['twts_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_twts_header']))
			redirect($this->session->userdata['PAGE']['twts_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_twts_header'][$i])) {
				$object['data']['twts_headers'][$j++] = $this->m_twts->twts_header_select($_POST['id_twts_header'][$i]);
			}
		}

		$this->template->write_view('content', 'twts/twts_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_twts_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transaksi Pemotongan Whole di Outlet berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['twts_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'twts_data';
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

		 	if($excel['cells'][1][1] == 'Trans. Pemotongan Whole di Outlet No.' && $excel['cells'][1][2] == 'Whole Item No.') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$item_group_code = 'all';
                    $Whole_Item_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];
                    $Slice_Item_No =  $excel['cells'][$i][4];

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

                        $j++;
						if($twts_header_temp = $this->m_general->sap_item_groups_select_all_twts()) {

							$object['twts_headers'][$j]['posting_date'] = date("Y-m-d H:i:s",strtotime($this->m_general->posting_date_select_max()));
                            $object['twts_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['twts_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['twts_headers'][$j]['status'] = '1';
							$object['twts_headers'][$j]['item_group_code'] = $item_group_code;
							$object['twts_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['twts_headers'][$j]['filename'] = $upload['file_name'];

                        	$twts_header_exist = TRUE;
							$k = 1; // grpo_detail number
						} else {
                        	$twts_header_exist = FALSE;
						}
					}

					if($twts_header_exist) {

						if($twts_detail_temp = $this->m_twts->twts_item_slice_select($Whole_Item_no,$Slice_Item_No)) {

							$object['twts_details'][$j][$k]['id_twts_h_detail'] = $k;
							$object['twts_details'][$j][$k]['material_no'] = $Whole_Item_no;
							$object['twts_details'][$j][$k]['material_no_gr'] = $Slice_Item_No;
							$object['twts_details'][$j][$k]['material_desc'] = $twts_detail_temp['nama_whi'];
							$object['twts_details'][$j][$k]['material_desc_gr'] = $twts_detail_temp['MAKTX'];
							$object['twts_details'][$j][$k]['quantity'] = $quantity;
							$object['twts_details'][$j][$k]['quantity_gr'] = $quantity*$twts_detail_temp['quantity'];
							$object['twts_details'][$j][$k]['konv_qty'] = $twts_detail_temp['quantity'];
                			$item_whi = $this->m_general->sap_item_select_by_item_code($Whole_Item_no);
                			$object['twts_details'][$j][$k]['uom'] = $item_whi['UNIT'];
                			$object['twts_details'][$j][$k]['uom_gr'] = $twts_detail_temp['UNIT'];

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'twts/twts_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transaksi Pemotongan Whole di Outlet atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'twts/browse_result/0/0/0/0/0/0/0/10';
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
	 	if($excel['cells'][1][1] == 'Trans. Pemotongan Whole di Outlet No.' && $excel['cells'][1][2] == 'Whole Item No.') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

					$item_group_code = 'all';
                    $Whole_Item_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];
                    $Slice_Item_No =  $excel['cells'][$i][4];



				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

                   $j++;
				   	if($twts_detail_temp = $this->m_general->sap_item_groups_select_all_twts()) {

					    $object['twts_headers'][$j]['posting_date'] = date("Y-m-d H:i:s",strtotime($this->m_general->posting_date_select_max()));
                        $object['twts_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
                        $object['twts_headers'][$j]['id_twts_plant'] = $this->m_twts->id_twts_plant_new_select($object['twts_headers'][$j]['plant'],$object['twts_headers'][$j]['posting_date']);
                        $object['twts_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
                        $object['twts_headers'][$j]['status'] = '1';
                        $object['twts_headers'][$j]['item_group_code'] = $item_group_code;
                        $object['twts_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                        $object['twts_headers'][$j]['filename'] = $upload['file_name'];

						$id_twts_header = $this->m_twts->twts_header_insert($object['twts_headers'][$j]);

                       	$twts_header_exist = TRUE;
						$k = 1; // grpo_detail number

					} else {
                       	$twts_header_exist = FALSE;
					}
				}

				if($twts_header_exist) {

					if($twts_detail_temp = $this->m_twts->twts_item_slice_select($Whole_Item_no,$Slice_Item_No)) {
   						$object['twts_details'][$j][$k]['id_twts_header'] = $id_twts_header;
                    	$object['twts_details'][$j][$k]['id_twts_h_detail'] = $k;
                    	$object['twts_details'][$j][$k]['material_no'] = $Whole_Item_no;
                    	$object['twts_details'][$j][$k]['material_no_gr'] = $Slice_Item_No;
                    	$object['twts_details'][$j][$k]['material_desc'] = $twts_detail_temp['nama_whi'];
                    	$object['twts_details'][$j][$k]['material_desc_gr'] = $twts_detail_temp['MAKTX'];
                    	$object['twts_details'][$j][$k]['quantity'] = $quantity;
                    	$object['twts_details'][$j][$k]['quantity_gr'] = $quantity*$twts_detail_temp['quantity'];
						$object['twts_details'][$j][$k]['konv_qty'] = $twts_detail_temp['quantity'];
                        $item_whi = $this->m_general->sap_item_select_by_item_code($Whole_Item_no);
                        $uom_import = $item_whi['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                         }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['twts_details'][$j][$k]['uom'] = $uom_import;

                        $uom_import = $twts_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['twts_details'][$j][$k]['uom_gr'] = $uom_import;

						$id_twts_detail = $this->m_twts->twts_detail_insert($object['twts_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Transaksi Pemotongan Whole di Outlet  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['twts_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transaksi Pemotongan Whole di Outlet atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'twts/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>