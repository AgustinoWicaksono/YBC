<?php
class opname extends Controller {
	private $jagmodule = array();


	function opname() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1048);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_opname'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_database');
		$this->load->model('m_opname');
		//$this->load->model('m_opnamei');

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
		$opname_browse_result = $this->session->userdata['PAGE']['opname_browse_result'];

		if(!empty($opname_browse_result))
			redirect($this->session->userdata['PAGE']['opname_browse_result']);
		else
			redirect('opname/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('opname/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('opname/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('opname_browse_result');

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
			'a'	=>	'Stock Opname No',
			
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

		$sort_link1 = 'opname/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['opnameev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('opname/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_opname->opname_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['opname_headers'] = $this->m_opname->opname_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'Stock Opname';
		$this->template->write_view('content', 'opname/opname_browse', $object);
		$this->template->render();

	}

	// input data
	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
			$data = $_POST;
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
			$object['data']['request_reason'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $opname_detail_tmp = array('opname_detail' => '');
        $this->session->unset_userdata($opname_detail_tmp);
        unset($opname_detail_tmp);

    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Cake Shop'] = 'Cake Shop';
    	$object['request_reasons']['Store'] = 'Store';
    	$object['request_reasons']['Bar'] = 'Bar';

	//	if(!empty($data['request_reason'])) {
		/*	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_stockoutlet();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}*/
	//	}

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('opname/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Stock Opname';
		$this->template->write_view('content', 'opname/opname_input', $object);
		$this->template->render();

	}

	function input2()	{

		//$request_reason = $this->uri->segment(3);
		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['opname_detail']['id_opname_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
				$item=$_POST['opname_detail']['material_no'][$i];
					$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['material_no'][$i], "opname_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['requirement_qty'][$i], "opname_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					/*mysql_connect("localhost","root","");
					mysql_select_db("sap_php");
					
					$cek_req=mysql_num_rows(mysql_query("SELECT BATCH FROM m_item WHERE MATNR='$item' AND BATCH='Y'"));
					if ($cek_req == 1)
					{
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['num'][$i], "opname_detail[num][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE )
						$validation_temp = FALSE;
						//print_r();

					$j++;
					}*/
					
					/*validasi opname SAP*/
				/*	$batch=$_POST['opname_detail']['stock_batch'][$i];
					$InWhs=$_POST['opname_detail']['stock'][$i];
					$qty=$_POST['opname_detail']['requirement_qty'][$i];
					$counted=$InWhs-$qty;
					echo '{'.$batch.'-'.$counted.'}';
					if ($batch < $counted)
					{
					echo "xxxx";
$check[$j] = $this->l_form_validation->set_rules(0, "opname_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
}*/
					
				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['uom'][$i], "opname_detail[uom][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					
					
				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['opnameice'][$i], "opname_detail[opnameice][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
          $opname_detail_tmp = array('opname_detail' => '');
          $this->session->unset_userdata($opname_detail_tmp);
          unset($opname_detail_tmp);
        }

        $object['data']['opname_header']['status_string'] = ($_POST['opname_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
     	    $item_group_code = $this->uri->segment(4);
    	//	$item_group_code = $this->uri->segment(5);
    		$item_choose = $this->uri->segment(5);
        } else {
     	    $item_group_code = $this->uri->segment(3);
    		//$item_group_code = $this->uri->segment(4);
    		$item_choose = $this->uri->segment(4);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	$object['request_reason'] = $request_reason;
    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Cake Shop'] = 'Cake Shop';
    	$object['request_reasons']['Store'] = 'Store';
    	$object['request_reasons']['Bar'] = 'Bar';

//echo $item_group_code;

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_stockoutlet();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group_opname($item_group_code, $item_choose);
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
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['opname_header'] = $_POST['opname_header'];//$this->m_opname->opname_details_select($this->uri->segment(3));
		  $object['data']['opname_detail'] = $_POST['opname_detail'];//$this->m_opname->opname_details_select($this->uri->segment(3));
   	      $object['data']['opname_header']['status_string'] = ($_POST['opname_header']['status'] == '2') ? 'Approved' : 'Not Approved';
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Stock Opname';
		$this->template->write_view('content', 'opname/opname_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$opname = $_POST;
		unset($opname['opname_header']['id_opname_header']);
		unset($opname['button']);
		// end of assign variables and delete not used variables

		$count = count($opname['opname_detail']['id_opname_h_detail']) - 1;

		// check, at least one opnameoduct requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($opname['opname_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$opnameice = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($opname['opname_detail']['opnameice'][$i])) {
				continue;
			} else {
				$opnameice = TRUE;
				break;
			}
		}*/
		
	/*	if($requirement_qty_exist == FALSE )
			redirect('opname/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');*/

//		if($this->m_config->running_number_select_update('opname', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$opname_header['id_opname_header'] = '0001'.date("Ymd").sopnameintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('opname_detail', $opname['opname_detail']);

    		$opname_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$opname_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
 			$opname_header['created_date'] = $this->m_general->posting_date_select_max($opname_header['plant']);
			//echo '{'.$opname['opname_header']['posting_date'].}';
			//echo'xxx';
 			$opname_header['posting_date'] = $opname['opname_header']['posting_date'];
			$opname_header['id_opname_plant'] = $this->m_opname->id_opname_plant_new_select($opname_header['plant'],$opname_header['created_date']);

 			//$opname_header['delivery_date'] = $this->l_general->str_to_date($opname['opname_header']['delivery_date']);
 			//$opname_header['request_reason'] = $opname['opname_header']['request_reason'];
			//$opname_header['to_plant'] = $opname['opname_header']['to_plant'];

 			$opname_header['opname_no'] = '';

			if(isset($_POST['button']['approve']))
				$opname_header['status'] = '2';
			else
				$opname_header['status'] = '1';

			$opname_header['item_group_code'] = $opname['opname_header']['item_group_code'];
			$opname_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($opname_header['plant'],$opname_header['created_date'],
                      $opname_header['id_opname_plant'],'09');
             //array utk parameter masukan pada saat apopnameoval
             if (strcmp($opname_header['request_reason'],'Order Tambahan') == 0)
                 $request_reason_tmp = 'T';
             else
                 $request_reason_tmp = 'S';
             if(isset($_POST['button']['approve'])) {
               $opname_to_approve = array (
                      'plant' => $opname_header['plant'],
                      //'created_date' => date('Ymd',strtotime($opname_header['created_date'])),
                      'id_user_input' => $opname_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      //'request_reason' => $request_reason_tmp,
                     // 'delivery_date' => date('Ymd',strtotime($opname_header['delivery_date'])),
                );
              }

			if($id_opname_header = $this->m_opname->opname_header_insert($opname_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					//if((!empty($opname['opname_detail']['requirement_qty'][$i]))&&(!empty($opname['opname_detail']['material_no'][$i]))) {
					if((!empty($opname['opname_detail']['material_no'][$i]))) {

						$opname_detail['id_opname_header'] = $id_opname_header;
						$opname_detail['requirement_qty'] = $opname['opname_detail']['requirement_qty'][$i];
						//$opname_detail['opnameice'] = $opname['opname_detail']['opnameice'][$i];
						$opname_detail['id_opname_h_detail'] = $opname['opname_detail']['id_opname_h_detail'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($opname['opname_detail']['material_no'][$i]);

						$opname_detail['material_no'] = $item['MATNR'];
						$opname_detail['material_desc'] = $item['MAKTX'];
   						$opname_detail['uom'] = $opname['opname_detail']['uom'][$i];
						$opname_detail['num'] = $opname['opname_detail']['num'][$i];
						$opname_detail['stock'] = $opname['opname_detail']['stock'][$i];
						$opname_detail['stock_batch'] = $opname['opname_detail']['stock_batch'][$i];
						//echo $opname_detail['stock'].'-'.$opname_detail['stock_batch'];
                        //array utk parameter masukan pada saat apopnameoval
                        $opname_to_approve['item'][$i] = $opname_detail['id_opname_h_detail'];
                        $opname_to_approve['material_no'][$i] = $opname_detail['material_no'];
                        $opname_to_approve['requirement_qty'][$i] = $opname_detail['requirement_qty'];
						//$opname_to_approve['opnameice'][$i] = $opname_detail['opnameice'];
                       // if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                         //   $opname_to_approve['uom'][$i] = $opname_detail['uom'];
                       // } else {
                            $opname_to_approve['uom'][$i] = $opname_detail['uom'];
                       // }
                        //
                     	if($this->m_opname->opname_detail_insert($opname_detail))
                          $input_detail_success = TRUE;
					}

				}

			}
            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			  //  $approved_data = $this->m_opname->sap_opname_header_approve($opname_to_approve);
    		//	if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $opname_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_opname_header'=>$id_opname_header,
    					'opname_no'	=>	$opname_no,
    					'status' =>	'2',
    					'id_user_approved'=>$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if($this->m_opname->opname_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_opname_header'=>$id_opname_header,
            					'id_opname_h_detail'=>$opname['opname_detail']['id_opname_h_detail'][$i],
            					'id_opname_opname_line_no' =>	$approved_data['sap_opname_item'][$i]['EBELP']
            				);
                            if($this->m_opname->opname_detail_update_by_id_h_detail($data)) {*/
              				    $approve_data_success = TRUE;
                            }
                      //  }
    				//}
				} else {
				  $approve_data_success = FALSE;
				}
           // }


            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Stock Opname berhasil dimasukkan', site_url('opname/input'));
              } else {
                $this->m_opname->opname_header_delete($id_opname_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Stock Opname berhasil diapprove', site_url('opname/input'));
              } else {
                $this->m_opname->opname_header_delete($id_opname_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		 }
	 }
  }
	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request Tambahan untuk Standard Stock tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil diapprove';
		$object['refresh_url'] = site_url('opname/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('opname/input');
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
	    $opname_header = $this->m_opname->opname_header_select($this->uri->segment(3));
		$status = $opname_header['status'];
        unset($opname_header);

        $opname_detail_tmp = array('opname_detail' => '');
        $this->session->unset_userdata($opname_detail_tmp);
        unset($opname_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

//		if((count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['opname_detail']['id_opname_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['material_no'][$i], "opname_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['uom'][$i], "opname_detail[uom][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['requirement_qty'][$i], "opname_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;*/
					
					/*validasi opname SAP*/
				/*	$batch=$_POST['opname_detail']['stock_batch'][$i];
					$InWhs=$_POST['opname_detail']['stock'][$i];
					$qty=$_POST['opname_detail']['requirement_qty'][$i];
					$counted=$InWhs-$qty;
					echo '{'.$batch.'-'.$InWhs.'-'.$qty.'-'.$counted.'}';
					if ($batch < $counted)
					{
					
$check[$j] = $this->l_form_validation->set_rules(0, "opname_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
}*/
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['opname_detail']['opnameice'][$i], "opname_detail[opnameice][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
				$opname_header = $this->m_opname->opname_header_select($this->uri->segment(3));
				if($opname_header['status'] == '2') {
    				$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['opname_header'] = $this->m_opname->opname_header_select($this->uri->segment(3));
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
          $opname_detail_tmp = array('opname_detail' => '');
          $this->session->unset_userdata($opname_detail_tmp);
          unset($opname_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['opname_header']['status_string'] = ($object['data']['opname_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_opname_header = $data['opname_header']['id_opname_header'];
		$request_reason = $data['opname_header']['request_reason'];
		$item_group_code = $data['opname_header']['item_group_code'];;
		$item_choose = $this->uri->segment(6);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
		$object['opname_header']['id_opname_header'] = $id_opname_header;
    	$object['request_reason'] = $request_reason;
    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Cake Shop'] = 'Cake Shop';
    	$object['request_reasons']['Store'] = 'Store';
    	$object['request_reasons']['Bar'] = 'Bar';

//exit;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_stockoutlet();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group_opname($item_group_code, $item_choose);
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

        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }


		if(count($_POST) == 0) {
			$object['data']['opname_details'] = $this->m_opname->opname_details_select($object['data']['opname_header']['id_opname_header']);

			if($object['data']['opname_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['opname_details']->result_array() as $object['temp']) {
	//				$object['data']['opname_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['opname_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Stock Opname';
		$this->template->write_view('content', 'opname/opname_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$opname = $_POST;
		unset($opname['opname_header']['id_opname_header']);
		unset($opname['button']);
		// end of assign variables and delete not used variables

		$count = count($opname['opname_detail']['id_opname_h_detail']) - 1;

		// check, at least one opnameoduct requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($opname['opname_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$opnameice_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($opname['opname_detail']['opnameice'][$i])) {
				continue;
			} else {
				$opnameice_exist = TRUE;
				break;
			}
		}*/

		/*if($requirement_qty_exist == FALSE )
			redirect('opname/edit_error/Anda belum memasukkan data detail. Mohon ulangi');*/

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('opname_detail', $opname['opname_detail']);

            $id_opname_header = $this->uri->segment(3);
            $createddate = $this->l_general->str_to_date($opname['opname_header']['created_date']);
            $deliverydate = $this->l_general->str_to_date($opname['opname_header']['delivery_date']);
			$id_opname_plant = $this->m_opname->id_opname_plant_new_select("",$createddate,$id_opname_header);

    			$data = array (
    				'id_opname_header' => $id_opname_header,
    				//'created_date' => $createddate,
    				//'delivery_date' => $deliverydate,
                    'id_opname_plant'=>$id_opname_plant,
    				//'request_reason' => $opname['opname_header']['request_reason'],
    			);
                $this->m_opname->opname_header_update($data);
                $edit_opname_header = $this->m_opname->opname_header_select($id_opname_header);

    			if ($this->m_opname->opname_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_opname->opname_details_delete($id_opname_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					//if((!empty($opname['opname_detail']['requirement_qty'][$i]))&&(!empty($opname['opname_detail']['material_no'][$i])) ) {
							if((!empty($opname['opname_detail']['material_no'][$i])) ) {

        						$opname_detail['id_opname_header'] = $id_opname_header;
        						$opname_detail['requirement_qty'] = $opname['opname_detail']['requirement_qty'][$i];
								//$opname_detail['opnameice'] = $opname['opname_detail']['opnameice'][$i];
        						$opname_detail['id_opname_h_detail'] = $opname['opname_detail']['id_opname_h_detail'][$i];

        						$item = $this->m_general->sap_item_select_by_item_code($opname['opname_detail']['material_no'][$i]);

        						$opname_detail['material_no'] = $item['MATNR'];
        						$opname_detail['material_desc'] = $item['MAKTX'];
        						$opname_detail['uom'] = $opname['opname_detail']['uom'][$i];
								$opname_detail['num'] = $opname['opname_detail']['num'][$i];
								$opname_detail['stock'] = $opname['opname_detail']['stock'][$i];
								$opname_detail['stock_batch'] = $opname['opname_detail']['stock_batch'][$i];

                                //array utk parameter masukan pada saat apopnameoval
                                $opname_to_approve['item'][$i] = $opname_detail['id_opname_h_detail'];
                                $opname_to_approve['material_no'][$i] = $opname_detail['material_no'];
                                $opname_to_approve['requirement_qty'][$i] = $opname_detail['requirement_qty'];
								//$opname_to_approve['opnameice'][$i] = $opname_detail['opnameice'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $opname_to_approve['uom'][$i] = $opname_detail['uom'];
                                } else {
                                    $opname_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                $opname_to_approve['uom'][$i] = $item['MEINS'];
                                //

        						if($this->m_opname->opname_detail_insert($opname_detail))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($opname['opname_detail']['requirement_qty'][$i])) {
            	    			$opname_detail = array (
            						'id_opname_detail'=>$opname['opname_detail']['id_opname_detail'][$i],
            						'requirement_qty'=>$opname['opname_detail']['requirement_qty'][$i],
            					);
            		    		if($this->m_opname->opname_detail_update($opname_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_opname->opname_detail_delete($opname['opname_detail']['id_opname_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
              //  $opname_to_approve['created_date'] = date('Ymd',strtotime($edit_opname_header['created_date']));
                $opname_to_approve['plant'] = $edit_opname_header['plant'];
                $opname_to_approve['id_opname_plant'] = $edit_opname_header['id_opname_plant'];
                $opname_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $opname_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_opname_header['plant'],$edit_opname_header['created_date'],
                      $edit_opname_header['id_opname_plant'],'09');
                /*if (strcmp($edit_opname_header['request_reason'],'Order Tambahan') == 0)
                  $request_reason_tmp = 'T';
                else
                  $request_reason_tmp = 'S';
                $opname_to_approve['request_reason'] = $request_reason_tmp;
                $opname_to_approve['delivery_date'] = date('Ymd',strtotime($edit_opname_header['delivery_date']));*/

			   // $approved_data = $this->m_opname->sap_opname_header_approve($opname_to_approve);
    			//if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $opname_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_opname_header' =>$id_opname_header,
    					'opname_no'	=>	$opname_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
						//'request_reason'=> $opname['opname_header']['request_reason']
    				);
    				if($this->m_opname->opname_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_opname_header'=>$id_opname_header,
            					'id_opname_h_detail'=>$opname['opname_detail']['id_opname_h_detail'][$i],
            					'id_opname_opname_line_no' =>	$approved_data['sap_opname_item'][$i]['EBELP']
            				);
                            if($this->m_opname->opname_detail_update_by_id_h_detail($data)) {*/
              				    $approve_data_success = TRUE;
                            }
                       // }
    				//}
  				    //$approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
          //  }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Stock Opname berhasil diubah', site_url('opname/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success == TRUE) {
  			     $this->l_general->success_page('Data Stock Opname berhasil diapprove', site_url('opname/browse'));
              } else {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
              }

		    }
	    }
    }
	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'opname/browse';
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
		$opname = $_POST;
		unset($opname['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one opnameoduct cancellation entered?

        $date_today = date('d-m-Y');
		if($opname['opname_header']['created_date']!=$date_today) {
			redirect('opname/edit_error/Anda tidak bisa mengganti atau menghapus transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        } else {

        	if(isset($_POST['button']['delete_item'])&& empty($opname['cancel'])) {
                $requirement_qty_exist = FALSE;
				//$opnameice_exist = FALSE;
        	} else {
        		$requirement_qty_exist = TRUE;
				//$opnameice_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('opname/edit_error/Anda belum memilih item yang akan di-delete. Mohon ulangi');

      		for($i = 1; $i <= $count; $i++) {
      			if(empty($opname['opname_detail']['requirement_qty'][$i])) {
      				continue;
      			} else {
      				$requirement_qty_exist = TRUE;
      				break;
      			}
              }
			  
			 /* for($i = 1; $i <= $count; $i++) {
      			if(empty($opname['opname_detail']['opnameice'][$i])) {
      				continue;
      			} else {
      				$opnameice_exist = TRUE;
      				break;
      			}
              }*/

    		if($requirement_qty_exist == FALSE )
    			redirect('opname/input_error/Anda belum memasukkan data Requirement Quantity atau Price. Mohon ulangi.');

        	if(isset($_POST['button']['change'])) {
                $requirement_qty_exist = FALSE;
                $count = count($opname['opname_detail']['id_opname_h_detail']);
                for($i=1;$i<=$count;$i++){
                  if($opname['opname_detail']['requirement_qty'][$i]!=$opname['opname_detail']['requirement_qty_old'][$i]){
               		$requirement_qty_exist = TRUE;
                    break;
                  }
                }
				
				/*$opnameice_exist = FALSE;
                $count1 = count($opname['opname_detail']['id_opname_h_detail']);
                for($i=1;$i<=$count1;$i++){
                  if($opname['opname_detail']['opnameice'][$i]!=$opname['opname_detail']['opnameice_old'][$i]){
               		$opnameice_exist = TRUE;
                    break;
                  }
                }*/
        	} else {
        		//$opnameice_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('opname/edit_error/Anda belum mengganti item yang akan di-changed. Mohon ulangi');

    //		if($this->m_config->running_number_select_update('opname', 1, date("Y-m-d")) {

            $edit_opname_header = $this->m_opname->opname_header_select($opname['opname_header']['id_opname_header']);
    		$edit_opname_details = $this->m_opname->opname_details_select($opname['opname_header']['id_opname_header']);
        	$i = 1;
    	    foreach ($edit_opname_details->result_array() as $value) {
    		    $edit_opname_detail[$i] = $value;
    		    $i++;
            }
            unset($edit_opname_details);

    //echo "<opnamee>";
    //opnameint '$edit_opname_detail';
    //opnameint_r($edit_opname_detail);
    //echo "</opnamee>";
    //exit;

    		if(isset($_POST['button']['change'])||isset($_POST['button']['delete_item'])) {

        		$this->session->set_userdata('opname_detail', $opname['opname_detail']);

    			$this->db->trans_start();

                if(isset($_POST['button']['delete_item'])) {
                  $opname_to_cancel['opname_no'] = $edit_opname_header['opname_no'];
                  $opname_to_cancel['created_date'] = date('Ymd',strtotime($edit_opname_header['created_date']));
                  $opname_to_cancel['plant'] = $edit_opname_header['plant'];
          		  $opname_to_cancel['id_opname_plant'] = $this->m_opname->id_opname_plant_new_select($edit_opname_header['plant'],date('Y-m-d',strtotime($edit_opname_header['created_date'])));
                  $opname_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_opname_header['plant'],$edit_opname_header['created_date'],
                            $opname_to_cancel['id_opname_plant'],'09');
                  $opname_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                if(isset($_POST['button']['change'])) {
                  $opname_to_change['opname_no'] = $edit_opname_header['opname_no'];
                  $opname_to_change['created_date'] = date('Ymd',strtotime($edit_opname_header['created_date']));
                  $opname_to_change['plant'] = $edit_opname_header['plant'];
                  $opname_to_change['id_opname_plant'] = $this->m_opname->id_opname_plant_new_select($edit_opname_header['plant'],date('Y-m-d',strtotime($edit_opname_header['created_date'])));
                  $opname_to_change['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_opname_header['plant'],$edit_opname_header['created_date'],
                            $opname_to_change['id_opname_plant'],'09');
                  $opname_to_change['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                $count = count($edit_opname_detail);
        		for($i = 1; $i <= $count; $i++) {
        		   if (isset($_POST['button']['delete_item'])) {
         		       $opname_to_cancel['item'][$i] = $i;
            		   if(!empty($opname['cancel'][$i])) {
             		     $opname_to_cancel['id_opname_opname_line_no'][$i] = $edit_opname_detail[$i]['id_opname_opname_line_no'];
             		     $opname_to_cancel['material_no'][$i] = $edit_opname_detail[$i]['material_no'];
             		     $opname_to_cancel['requirement_qty'][$i] = $edit_opname_detail[$i]['requirement_qty'];
						 //$opname_to_cancel['opnameice'][$i] = $edit_opname_detail[$i]['opnameice'];
                       }
                   }
                   if(isset($_POST['button']['change'])) {
             		   $opname_to_change['item'][$i] = $i;
              		   if(($opname['opname_detail']['requirement_qty'][$i]!=$opname['opname_detail']['requirement_qty_old'][$i])) {
             		     $opname_to_change['id_opname_opname_line_no'][$i] = $edit_opname_detail[$i]['id_opname_opname_line_no'];
               		     $opname_to_change['material_no'][$i] = $edit_opname_detail[$i]['material_no'];
               		     $opname_to_change['requirement_qty'][$i] = $opname['opname_detail']['requirement_qty'][$i];
						/* $opname_to_change['opnameice'][$i] = $opname['opname_detail']['opnameice'][$i];
						 $opname_to_change['opnameice_old'][$i] = $opname['opname_detail']['opnameice_old'][$i];*/
               		     $opname_to_change['requirement_qty_old'][$i] = $opname['opname_detail']['requirement_qty_old'][$i];
                       }
                   }
                }
                if(isset($_POST['button']['delete_item'])) {
                    $cancelled_data = $this->m_opname->sap_opname_header_cancel($opname_to_cancel);
         			$cancel_data_success = FALSE;
        			if(empty($cancelled_data['sap_return_type'])||($cancelled_data['sap_return_type']=='S')) {
                		for($i = 1; $i <= $count; $i++) {
                			if(!empty($opname['cancel'][$i])) {
        	    			$opname_header = array (
        						'id_opname_header'=>$opname['opname_header']['id_opname_header'],
        						'id_opname_plant'=>$opname_to_cancel['id_opname_plant'],
        					);
        		    		if($this->m_opname->opname_header_update($opname_header)==TRUE) {
            		    		if($this->m_opname->opname_detail_delete($edit_opname_detail[$i]['id_opname_detail'])==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                          }
                        }
                    }
                }

                if(isset($_POST['button']['change'])) {
                    $changed_data = $this->m_opname->sap_opname_header_change($opname_to_change);
         			$cancel_data_success = FALSE;
        			if($changed_data['sap_return_type']=='S') {
                		for($i = 1; $i <= $count; $i++) {
                			if($opname['opname_detail']['requirement_qty'][$i]!=$opname['opname_detail']['requirement_qty_old'][$i] ) {
            	    			$opname_detail = array (
            						'id_opname_detail'=>$edit_opname_detail[$i]['id_opname_detail'],
            						'requirement_qty'=>$opname['opname_detail']['requirement_qty'][$i]
									//'opnameice'=>$opname['opname_detail']['opnameice'][$i]
            					);
            		    		if($this->m_opname->opname_detail_update($opname_detail)==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                        }
                    }
                }

          	    $this->db->trans_complete();

                if($cancel_data_success == TRUE) {
                    if(isset($_POST['button']['delete_item']))
    				  $this->l_general->success_page('Data Stock Opname berhasil dibatalkan', site_url('opname/browse'));
                    else
    				  $this->l_general->success_page('Data Stock Opname berhasil diganti', site_url('opname/browse'));
                } else {
                    if(isset($_POST['button']['delete_item'])) {
    				   $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak  berhasil dibatalkan.<br>
                                       Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
                    } else {
    				   $this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak  berhasil diganti.<br>
                                       Pesan Kesalahan dari sistem SAP : '.$changed_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
                    }
                }
		    }

        }
	}

	/*function _edit_cancel_failed($ttype,$error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request Tambahan untuk Standard Stock tidak berhasil '.$ttype.'<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_opname_header) {

		$this->db->trans_start();
		
		 $opname_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	  $opname_delete['module'] = "Opname";
	 $opname_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $opname_delete['id_delete'] = $id_opname_header;

		// check approve status
		$opname_header = $this->m_opname->opname_header_select($id_opname_header);

		if($opname_header['status'] == '1') {
			$this->m_opname->opname_header_delete($id_opname_header);
			$this->m_opname->user_delete($opname_delete);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_opname_header) {

		if($this->_delete($id_opname_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Stock Opname berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['opname_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Stock Opname gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['opname_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_opname_header']))
			redirect($this->session->userdata['PAGE']['opname_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
        if(!empty($_POST['id_opname_header'][$i])) {
				$object['data']['opname_headers'][$j++] = $this->m_opname->opname_header_select($_POST['id_opname_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'opname/opname_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'opname/opname_delete_multiple_confirm', $object);

        $this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_opname_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['opname_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_opname->opname_select_to_export($_POST['id_opname_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'StandardStock');
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'opname_data';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '10000000';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			$error = array('error' => $this->upload->display_errors());
			opnameint_r($error);
//			$this->load->view('upload_form', $error);
		} else {
			$upload = $this->upload->data();;

			// Load the sopnameeadsheet reader library
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

		 	if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][2] == 'Request reason' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // opname_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same opname header?

					$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];

					// check opname header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($opname_header_temp = $this->m_general->sap_item_groups_select_all_opname()) {

							$object['opname_headers'][$j]['created_date'] = date("Y-m-d H:i:s");
                            $object['opname_headers'][$j]['opname_no'] = $excel['cells'][$i][1];
                            $object['opname_headers'][$j]['request_reason'] = $request_reason;
                            $object['opname_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['opname_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['opname_headers'][$j]['status'] = '1';
							$object['opname_headers'][$j]['item_group_code'] = $item_group_code;
							$object['opname_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['opname_headers'][$j]['filename'] = $upload['file_name'];

            	$opname_header_exist = TRUE;
							$k = 1; // opname_detail number
						} else {
            	$opname_header_exist = FALSE;
						}
					}

					if($opname_header_exist) {

						if($opname_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['opname_details'][$j][$k]['id_opname_h_detail'] = $k;

							$object['opname_details'][$j][$k]['material_no'] = $material_no;
							$object['opname_details'][$j][$k]['material_desc'] = $opname_detail_temp['MAKTX'];
							$object['opname_details'][$j][$k]['requirement_qty'] = $quantity;
							//$object['opname_details'][$j][$k]['opnameice'] = $opnameice;
							$object['opname_details'][$j][$k]['uom'] = $opname_detail_temp['UNIT'];

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'opname/opname_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'opname/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

			}

		}

	}

	function file_import_execute() {

		// Load the sopnameeadsheet reader library
		$this->load->library('excel_reader');

		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');

		$this->excel_reader->read($this->session->userdata('file_upload'));

		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it opname template file?
		 	if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][2] == 'Request reason' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // opname_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same opname header?

			  	$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];



				// check opname header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
				   	if($opname_detail_temp = $this->m_general->sap_item_groups_select_all_opname()) {

    					   	$object['opname_headers'][$j]['created_date'] = $this->m_general->posting_date_select_max();
                            $object['opname_headers'][$j]['request_reason'] = $request_reason;
							$object['opname_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['opname_headers'][$j]['id_opname_plant'] = $this->m_opname->id_opname_plant_new_select($object['opname_headers'][$j]['plant'],$object['opname_headers'][$j]['created_date']);
							$object['opname_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['opname_headers'][$j]['status'] = '1';
                            $delivery_date = date("Y-m-d H:i:s");
                            $delivery_date = $this->l_general->str_to_date(date("d-m-Y",strtotime($delivery_date)));
                            $object['opname_headers'][$j]['delivery_date'] = $delivery_date;
							$object['opname_headers'][$j]['item_group_code'] = $item_group_code;
							$object['opname_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['opname_headers'][$j]['filename'] = $upload['file_name'];

						$id_opname_header = $this->m_opname->opname_header_insert($object['opname_headers'][$j]);

           	$opname_header_exist = TRUE;
						$k = 1; // opname_detail number

					} else {
           	$opname_header_exist = FALSE;
					}
				}

				if($opname_header_exist) {

					if($opname_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                        $object['opname_details'][$j][$k]['id_opname_header'] = $id_opname_header;
						$object['opname_details'][$j][$k]['id_opname_h_detail'] = $k;

							$object['opname_details'][$j][$k]['material_no'] = $material_no;
							$object['opname_details'][$j][$k]['material_desc'] = $opname_detail_temp['MAKTX'];
						   $object['opname_details'][$j][$k]['requirement_qty'] = $quantity;
						  //  $object['opname_details'][$j][$k]['opnameice'] = $opnameice;
							$object['opname_details'][$j][$k]['uom'] = $opname_detail_temp['UNIT'];


						$id_opname_detail = $this->m_opname->opname_detail_insert($object['opname_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Standard Stock  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['opname_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'opname/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '011';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}


public function printpdf($id_opname_header)
	{
		$this->load->model('m_printopname');
		//$this->load->model('m_opname');
		//$opname_header = $this->m_opname->opname_header_select($id_opname_header);
		$data['data'] = $this->m_printopname->tampil($id_opname_header);
		
		ob_start();
		$content = $this->load->view('opname',$data);
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
	
public function import()
        {
		
  if(isset($_POST["import"]))
    {
	
        $filename=$_FILES["file"]["tmp_name"];
        if($_FILES["file"]["size"] > 0)
          {
		   $file = fopen($filename, "r");
             while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
             {
			        $data = array(
                        'id_opname_plant' => $importdata[0],
                        'posting_date' =>$importdata[1],
                        'created_date' => date('Y-m-d'),
                        );
             $insert = $this->m_opname->insertCSV($data);
             }                    
            fclose($file);
			$this->session->set_flashdata('message', 'Data are imported successfully..');
				redirect('uploadcsv/index');
          }else{
			$this->session->set_flashdata('message', 'Something went wrong..');
			redirect('uploadcsv/index');
		}
    }
}


}