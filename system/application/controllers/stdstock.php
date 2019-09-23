<?php
class stdstock extends Controller {
	private $jagmodule = array();


	function stdstock() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1048);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_stdstock'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_stdstock');
		$this->load->model('m_database');
		$this->load->model('m_SR');

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
		$stdstock_browse_result = $this->session->userdata['PAGE']['stdstock_browse_result'];

		if(!empty($stdstock_browse_result))
			redirect($this->session->userdata['PAGE']['stdstock_browse_result']);
		else
			redirect('stdstock/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('stdstock/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('stdstock/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('stdstock_browse_result');

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
			'a'	=>	'SR Number',
			'b'	=>	'Request To',
			
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

		$sort_link1 = 'stdstock/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('stdstock/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_stdstock->stdstock_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['stdstock_headers'] = $this->m_stdstock->stdstock_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];
		//echo '{'.$object['total_rows'].'}';

		$object['page_title'] = 'List of Store Room Request (SR)';
		$this->template->write_view('content', 'stdstock/stdstock_browse', $object);
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

        $stdstock_detail_tmp = array('stdstock_detail' => '');
        $this->session->unset_userdata($stdstock_detail_tmp);
        unset($stdstock_detail_tmp);

    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Order'] = 'Order';
    	$object['request_reasons']['Order Tambahan'] = 'Order Tambahan';
    	$object['request_reasons']['Special Order'] = 'Special Order';
    	$object['request_reasons']['Big Order'] = 'Big Order';

		if(!empty($data['request_reason'])) {
		/*	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_stdstock();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}*/
		}

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}
		
		if(!empty($data['item_choose'])) {
			$object['to'][0] = '';
			//$object['to']['Departement'] = 'Departement';
			$object['to']['Outlet'] = 'Outlet';

		}

		if(!empty($data['to'])) {
			redirect('stdstock/input2/'.$data['request_reason'].'/'.$data['item_group_code'].'/'.$data['item_choose'].'/'.$data['to']);
		}

		$object['page_title'] = 'Store Room Request (SR)';
		$this->template->write_view('content', 'stdstock/stdstock_input', $object);
		$this->template->render();

	}

	function input2()	{

		$request_reason = $this->uri->segment(3);
		$item_choose = $this->uri->segment(5);
		$to=$this->uri->segment(6);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['stdstock_detail']['id_stdstock_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['material_no'][$i], "stdstock_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_header']['to_plant'], "stdstock_header[to_plant]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['requirement_qty'][$i], "stdstock_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['price'][$i], "stdstock_detail[price][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
          $stdstock_detail_tmp = array('stdstock_detail' => '');
          $this->session->unset_userdata($stdstock_detail_tmp);
          unset($stdstock_detail_tmp);
        }

        $object['data']['stdstock_header']['status_string'] = ($_POST['stdstock_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
     	    $request_reason = $this->uri->segment(4);
    		$item_group_code = $this->uri->segment(5);
    		$item_choose = $this->uri->segment(6);
			$to=$this->uri->segment(7);
        } else {
     	    $request_reason = $this->uri->segment(3);
    		$item_group_code = $this->uri->segment(4);
    		$item_choose = $this->uri->segment(5);
			$to=$this->uri->segment(6);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	$object['request_reason'] = $request_reason;
    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Order'] = 'Order';
    	$object['request_reasons']['Order Tambahan'] = 'Order Tambahan';
    	$object['request_reasons']['Special Order'] = 'Special Order';
    	$object['request_reasons']['Big Order'] = 'Big Order';

		if($item_group_code == 'all')  {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_stdstock();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'stdstock');
		}
		//echo '{'.$to.'}';
	
//exit;
$object['to'] = $to;

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
		  $object['data']['stdstock_header'] = $_POST['stdstock_header'];//$this->m_stdstock->stdstock_details_select($this->uri->segment(3));
		  $object['data']['stdstock_detail'] = $_POST['stdstock_detail'];//$this->m_stdstock->stdstock_details_select($this->uri->segment(3));
   	      $object['data']['stdstock_header']['status_string'] = ($_POST['stdstock_header']['status'] == '2') ? 'Approved' : 'Not Approved';
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Store Room Request (SR)';
		$this->template->write_view('content', 'stdstock/stdstock_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$stdstock = $_POST;
		unset($stdstock['stdstock_header']['id_stdstock_header']);
		unset($stdstock['button']);
		// end of assign variables and delete not used variables

		$count = count($stdstock['stdstock_detail']['id_stdstock_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($stdstock['stdstock_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$price = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($stdstock['stdstock_detail']['price'][$i])) {
				continue;
			} else {
				$price = TRUE;
				break;
			}
		}*/
		
		if($requirement_qty_exist == FALSE )
			redirect('stdstock/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('stdstock', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$stdstock_header['id_stdstock_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('stdstock_detail', $stdstock['stdstock_detail']);

    		$stdstock_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$stdstock_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$stdstock_header['created_date'] = $this->m_general->posting_date_select_max($stdstock_header['plant']);
 			$stdstock_header['created_date'] = $this->l_general->str_to_date($stdstock['stdstock_header']['created_date']);
			$stdstock_header['id_stdstock_plant'] = $this->m_stdstock->id_stdstock_plant_new_select($stdstock_header['plant'],$stdstock_header['created_date']);

 			$stdstock_header['delivery_date'] = $this->l_general->str_to_date($stdstock['stdstock_header']['delivery_date']);
 			$stdstock_header['request_reason'] = $stdstock['stdstock_header']['request_reason'];
			$stdstock_header['to_plant'] = $stdstock['stdstock_header']['to_plant'];

 			$stdstock_header['pr_no'] = '';

			if(isset($_POST['button']['approve']))
				$stdstock_header['status'] = '2';
			else
				$stdstock_header['status'] = '1';

			$stdstock_header['item_group_code'] = $stdstock['stdstock_header']['item_group_code'];
			$stdstock_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($stdstock_header['plant'],$stdstock_header['created_date'],
                      $stdstock_header['id_stdstock_plant'],'09');
             //array utk parameter masukan pada saat approval
             if (strcmp($stdstock_header['request_reason'],'Order Tambahan') == 0)
                 $request_reason_tmp = 'T';
             else
                 $request_reason_tmp = 'S';
             if(isset($_POST['button']['approve'])) {
               $stdstock_to_approve = array (
                      'plant' => $stdstock_header['plant'],
                      'created_date' => date('Ymd',strtotime($stdstock_header['created_date'])),
                      'id_user_input' => $stdstock_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'request_reason' => $request_reason_tmp,
                      'delivery_date' => date('Ymd',strtotime($stdstock_header['delivery_date'])),
                );
              }

			if($id_stdstock_header = $this->m_stdstock->stdstock_header_insert($stdstock_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($stdstock['stdstock_detail']['requirement_qty'][$i]))&&(!empty($stdstock['stdstock_detail']['material_no'][$i]))&&(!empty($stdstock['stdstock_header']['to_plant']))) {

						$stdstock_detail['id_stdstock_header'] = $id_stdstock_header;
						$stdstock_detail['requirement_qty'] = $stdstock['stdstock_detail']['requirement_qty'][$i];
						//$stdstock_detail['price'] = $stdstock['stdstock_detail']['price'][$i];
						$stdstock_detail['id_stdstock_h_detail'] = $stdstock['stdstock_detail']['id_stdstock_h_detail'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($stdstock['stdstock_detail']['material_no'][$i]);

						$stdstock_detail['material_no'] = $item['MATNR'];
						$stdstock_detail['material_desc'] = $item['MAKTX'];
   						$stdstock_detail['uom'] = $stdstock['stdstock_detail']['uom'][$i];
						if(!empty($stdstock['stdstock_detail']['OnHand'][$i]))
						   $stdstock_detail['OnHand'] = $stdstock['stdstock_detail']['OnHand'][$i];
						if(!empty($stdstock['stdstock_detail']['MinStock'][$i]))
							$stdstock_detail['MinStock'] = $stdstock['stdstock_detail']['MinStock'][$i];
						if(!empty($stdstock['stdstock_detail']['OpenQty'][$i]))
							$stdstock_detail['OpenQty'] = $stdstock['stdstock_detail']['OpenQty'][$i];
						//echo '{'.$stdstock_detail['OnHand'].'-'.$stdstock_detail['MinStock'].'-'.$stdstock_detail['OpenQty'].'}';
						//echo $stdstock_detail['uom'];
                        //array utk parameter masukan pada saat approval
                        $stdstock_to_approve['item'][$i] = $stdstock_detail['id_stdstock_h_detail'];
                        $stdstock_to_approve['material_no'][$i] = $stdstock_detail['material_no'];
                        $stdstock_to_approve['requirement_qty'][$i] = $stdstock_detail['requirement_qty'];
						//$stdstock_to_approve['price'][$i] = $stdstock_detail['price'];
                       // if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                         //   $stdstock_to_approve['uom'][$i] = $stdstock_detail['uom'];
                       // } else {
                            $stdstock_to_approve['uom'][$i] = $stdstock_detail['uom'];
                       // }
                        //
						if($this->m_stdstock->stdstock_detail_insert($stdstock_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			  //  $approved_data = $this->m_stdstock->sap_stdstock_header_approve($stdstock_to_approve);
    		//	if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_stdstock_header'=>$id_stdstock_header,
    					'pr_no'	=>	$pr_no,
    					'status' =>	'2',
    					'id_user_approved'=>$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if($this->m_stdstock->stdstock_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_stdstock_header'=>$id_stdstock_header,
            					'id_stdstock_h_detail'=>$stdstock['stdstock_detail']['id_stdstock_h_detail'][$i],
            					'id_stdstock_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_stdstock->stdstock_detail_update_by_id_h_detail($data)) {*/
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
   			    $this->l_general->success_page('Data Store Room Request (SR) berhasil dimasukkan', site_url('stdstock/input'));
              } else {
                $this->m_stdstock->stdstock_header_delete($id_stdstock_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Store Room Request (SR) berhasil diapprove', site_url('stdstock/input'));
              } else {
                $this->m_stdstock->stdstock_header_delete($id_stdstock_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak berhasil diapprove.<br>
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
		$object['refresh_text'] = 'Data Store Room Request (SR) berhasil diapprove';
		$object['refresh_url'] = site_url('stdstock/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Store Room Request (SR) berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('stdstock/input');
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
	    $stdstock_header = $this->m_stdstock->stdstock_header_select($this->uri->segment(3));
		$status = $stdstock_header['status'];
        unset($stdstock_header);

        $stdstock_detail_tmp = array('stdstock_detail' => '');
        $this->session->unset_userdata($stdstock_detail_tmp);
        unset($stdstock_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

//		if((count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['stdstock_detail']['id_stdstock_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['material_no'][$i], "stdstock_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['requirement_qty'][$i], "stdstock_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['stdstock_detail']['price'][$i], "stdstock_detail[price][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
				$stdstock_header = $this->m_stdstock->stdstock_header_select($this->uri->segment(3));
				if($stdstock_header['status'] == '2') {
    				$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['stdstock_header'] = $this->m_stdstock->stdstock_header_select($this->uri->segment(3));
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
          $stdstock_detail_tmp = array('stdstock_detail' => '');
          $this->session->unset_userdata($stdstock_detail_tmp);
          unset($stdstock_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['stdstock_header']['status_string'] = ($object['data']['stdstock_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_stdstock_header = $data['stdstock_header']['id_stdstock_header'];
		$request_reason = $data['stdstock_header']['request_reason'];
		$item_group_code = $data['stdstock_header']['item_group_code'];;
		$item_choose = $this->uri->segment(6);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['stdstock_header']['id_stdstock_header'] = $id_stdstock_header;
    	$object['request_reason'] = $request_reason;
    	$object['request_reasons'][0] = '';
    	$object['request_reasons']['Order Tambahan'] = 'Order Tambahan';
    	$object['request_reasons']['Special Order'] = 'Special Order';
    	$object['request_reasons']['Big Order'] = 'Big Order';

//exit;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_stdstock();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'stdstock');
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


		if(count($_POST) == 0) {
			$object['data']['stdstock_details'] = $this->m_stdstock->stdstock_details_select($object['data']['stdstock_header']['id_stdstock_header']);

			if($object['data']['stdstock_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['stdstock_details']->result_array() as $object['temp']) {
	//				$object['data']['stdstock_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['stdstock_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Store Room Request (SR)';
		$this->template->write_view('content', 'stdstock/stdstock_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$stdstock = $_POST;
		unset($stdstock['stdstock_header']['id_stdstock_header']);
		unset($stdstock['button']);
		// end of assign variables and delete not used variables

		$count = count($stdstock['stdstock_detail']['id_stdstock_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($stdstock['stdstock_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$price_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($stdstock['stdstock_detail']['price'][$i])) {
				continue;
			} else {
				$price_exist = TRUE;
				break;
			}
		}*/

		if($requirement_qty_exist == FALSE )
			redirect('stdstock/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('stdstock_detail', $stdstock['stdstock_detail']);

            $id_stdstock_header = $this->uri->segment(3);
            $createddate = $this->l_general->str_to_date($stdstock['stdstock_header']['created_date']);
            $deliverydate = $this->l_general->str_to_date($stdstock['stdstock_header']['delivery_date']);
			$id_stdstock_plant = $this->m_stdstock->id_stdstock_plant_new_select("",$createddate,$id_stdstock_header);

    			$data = array (
    				'id_stdstock_header' => $id_stdstock_header,
    				'created_date' => $createddate,
    				'delivery_date' => $deliverydate,
                    'id_stdstock_plant'=>$id_stdstock_plant,
    				'request_reason' => $stdstock['stdstock_header']['request_reason'],
    			);
                $this->m_stdstock->stdstock_header_update($data);
                $edit_stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);

    			if ($this->m_stdstock->stdstock_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_stdstock->stdstock_details_delete($id_stdstock_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($stdstock['stdstock_detail']['requirement_qty'][$i]))&&(!empty($stdstock['stdstock_detail']['material_no'][$i])) ) {

        						$stdstock_detail['id_stdstock_header'] = $id_stdstock_header;
        						$stdstock_detail['requirement_qty'] = $stdstock['stdstock_detail']['requirement_qty'][$i];
								//$stdstock_detail['price'] = $stdstock['stdstock_detail']['price'][$i];
        						$stdstock_detail['id_stdstock_h_detail'] = $stdstock['stdstock_detail']['id_stdstock_h_detail'][$i];

        						$item = $this->m_general->sap_item_select_by_item_code($stdstock['stdstock_detail']['material_no'][$i]);

        						$stdstock_detail['material_no'] = $item['MATNR'];
        						$stdstock_detail['material_desc'] = $item['MAKTX'];
        						$stdstock_detail['uom'] = $stdstock['stdstock_detail']['uom'][$i];
								
								if(!empty($stdstock['stdstock_detail']['OnHand'][$i])) {
  								  $stdstock_detail['OnHand'] = $stdstock['stdstock_detail']['OnHand'][$i];
								}
								if(!empty($stdstock['stdstock_detail']['MinStock'][$i])) {
									$stdstock_detail['MinStock'] = $stdstock['stdstock_detail']['MinStock'][$i];
								}
								if(!empty($stdstock['stdstock_detail']['OpenQty'][$i])) {
									$stdstock_detail['OpenQty'] = $stdstock['stdstock_detail']['OpenQty'][$i];
								}
                                //array utk parameter masukan pada saat approval
                                $stdstock_to_approve['item'][$i] = $stdstock_detail['id_stdstock_h_detail'];
                                $stdstock_to_approve['material_no'][$i] = $stdstock_detail['material_no'];
                                $stdstock_to_approve['requirement_qty'][$i] = $stdstock_detail['requirement_qty'];
								//$stdstock_to_approve['price'][$i] = $stdstock_detail['price'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $stdstock_to_approve['uom'][$i] = $stdstock_detail['uom'];
                                } else {
                                    $stdstock_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                $stdstock_to_approve['uom'][$i] = $item['MEINS'];
                                //

        						if($this->m_stdstock->stdstock_detail_insert($stdstock_detail))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($stdstock['stdstock_detail']['requirement_qty'][$i])) {
            	    			$stdstock_detail = array (
            						'id_stdstock_detail'=>$stdstock['stdstock_detail']['id_stdstock_detail'][$i],
            						'requirement_qty'=>$stdstock['stdstock_detail']['requirement_qty'][$i],
            					);
            		    		if($this->m_stdstock->stdstock_detail_update($stdstock_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_stdstock->stdstock_detail_delete($stdstock['stdstock_detail']['id_stdstock_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $stdstock_to_approve['created_date'] = date('Ymd',strtotime($edit_stdstock_header['created_date']));
                $stdstock_to_approve['plant'] = $edit_stdstock_header['plant'];
                $stdstock_to_approve['id_stdstock_plant'] = $edit_stdstock_header['id_stdstock_plant'];
                $stdstock_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $stdstock_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_stdstock_header['plant'],$edit_stdstock_header['created_date'],
                      $edit_stdstock_header['id_stdstock_plant'],'09');
                if (strcmp($edit_stdstock_header['request_reason'],'Order Tambahan') == 0)
                  $request_reason_tmp = 'T';
                else
                  $request_reason_tmp = 'S';
                $stdstock_to_approve['request_reason'] = $request_reason_tmp;
                $stdstock_to_approve['delivery_date'] = date('Ymd',strtotime($edit_stdstock_header['delivery_date']));

			   // $approved_data = $this->m_stdstock->sap_stdstock_header_approve($stdstock_to_approve);
    			//if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_stdstock_header' =>$id_stdstock_header,
    					'pr_no'	=>	$pr_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if($this->m_stdstock->stdstock_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_stdstock_header'=>$id_stdstock_header,
            					'id_stdstock_h_detail'=>$stdstock['stdstock_detail']['id_stdstock_h_detail'][$i],
            					'id_stdstock_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_stdstock->stdstock_detail_update_by_id_h_detail($data)) {*/
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
			  $this->l_general->success_page('Data Store Room Request (SR) berhasil diubah', site_url('stdstock/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success == TRUE) {
  			     $this->l_general->success_page('Data Store Room Request (SR) berhasil diapprove', site_url('stdstock/browse'));
              } else {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
              }

		    }
	    }
    }
	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'stdstock/browse';
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
		$stdstock = $_POST;
		unset($stdstock['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($stdstock['stdstock_header']['created_date']!=$date_today) {
			redirect('stdstock/edit_error/Anda tidak bisa mengganti atau menghapus transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        } else {

        	if(isset($_POST['button']['delete_item'])&& empty($stdstock['cancel'])) {
                $requirement_qty_exist = FALSE;
				//$price_exist = FALSE;
        	} else {
        		$requirement_qty_exist = TRUE;
				//$price_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('stdstock/edit_error/Anda belum memilih item yang akan di-delete. Mohon ulangi');

      		for($i = 1; $i <= $count; $i++) {
      			if(empty($stdstock['stdstock_detail']['requirement_qty'][$i])) {
      				continue;
      			} else {
      				$requirement_qty_exist = TRUE;
      				break;
      			}
              }
			  
			 /* for($i = 1; $i <= $count; $i++) {
      			if(empty($stdstock['stdstock_detail']['price'][$i])) {
      				continue;
      			} else {
      				$price_exist = TRUE;
      				break;
      			}
              }*/

    		if($requirement_qty_exist == FALSE )
    			redirect('stdstock/input_error/Anda belum memasukkan data Requirement Quantity atau Price. Mohon ulangi.');

        	if(isset($_POST['button']['change'])) {
                $requirement_qty_exist = FALSE;
                $count = count($stdstock['stdstock_detail']['id_stdstock_h_detail']);
                for($i=1;$i<=$count;$i++){
                  if($stdstock['stdstock_detail']['requirement_qty'][$i]!=$stdstock['stdstock_detail']['requirement_qty_old'][$i]){
               		$requirement_qty_exist = TRUE;
                    break;
                  }
                }
				
				/*$price_exist = FALSE;
                $count1 = count($stdstock['stdstock_detail']['id_stdstock_h_detail']);
                for($i=1;$i<=$count1;$i++){
                  if($stdstock['stdstock_detail']['price'][$i]!=$stdstock['stdstock_detail']['price_old'][$i]){
               		$price_exist = TRUE;
                    break;
                  }
                }*/
        	} else {
        		//$price_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('stdstock/edit_error/Anda belum mengganti item yang akan di-changed. Mohon ulangi');

    //		if($this->m_config->running_number_select_update('stdstock', 1, date("Y-m-d")) {

            $edit_stdstock_header = $this->m_stdstock->stdstock_header_select($stdstock['stdstock_header']['id_stdstock_header']);
    		$edit_stdstock_details = $this->m_stdstock->stdstock_details_select($stdstock['stdstock_header']['id_stdstock_header']);
        	$i = 1;
    	    foreach ($edit_stdstock_details->result_array() as $value) {
    		    $edit_stdstock_detail[$i] = $value;
    		    $i++;
            }
            unset($edit_stdstock_details);

    //echo "<pre>";
    //print '$edit_stdstock_detail';
    //print_r($edit_stdstock_detail);
    //echo "</pre>";
    //exit;

    		if(isset($_POST['button']['change'])||isset($_POST['button']['delete_item'])) {

        		$this->session->set_userdata('stdstock_detail', $stdstock['stdstock_detail']);

    			$this->db->trans_start();

                if(isset($_POST['button']['delete_item'])) {
                  $stdstock_to_cancel['pr_no'] = $edit_stdstock_header['pr_no'];
                  $stdstock_to_cancel['created_date'] = date('Ymd',strtotime($edit_stdstock_header['created_date']));
                  $stdstock_to_cancel['plant'] = $edit_stdstock_header['plant'];
          		  $stdstock_to_cancel['id_stdstock_plant'] = $this->m_stdstock->id_stdstock_plant_new_select($edit_stdstock_header['plant'],date('Y-m-d',strtotime($edit_stdstock_header['created_date'])));
                  $stdstock_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_stdstock_header['plant'],$edit_stdstock_header['created_date'],
                            $stdstock_to_cancel['id_stdstock_plant'],'09');
                  $stdstock_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                if(isset($_POST['button']['change'])) {
                  $stdstock_to_change['pr_no'] = $edit_stdstock_header['pr_no'];
                  $stdstock_to_change['created_date'] = date('Ymd',strtotime($edit_stdstock_header['created_date']));
                  $stdstock_to_change['plant'] = $edit_stdstock_header['plant'];
                  $stdstock_to_change['id_stdstock_plant'] = $this->m_stdstock->id_stdstock_plant_new_select($edit_stdstock_header['plant'],date('Y-m-d',strtotime($edit_stdstock_header['created_date'])));
                  $stdstock_to_change['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_stdstock_header['plant'],$edit_stdstock_header['created_date'],
                            $stdstock_to_change['id_stdstock_plant'],'09');
                  $stdstock_to_change['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                $count = count($edit_stdstock_detail);
        		for($i = 1; $i <= $count; $i++) {
        		   if (isset($_POST['button']['delete_item'])) {
         		       $stdstock_to_cancel['item'][$i] = $i;
            		   if(!empty($stdstock['cancel'][$i])) {
             		     $stdstock_to_cancel['id_stdstock_pr_line_no'][$i] = $edit_stdstock_detail[$i]['id_stdstock_pr_line_no'];
             		     $stdstock_to_cancel['material_no'][$i] = $edit_stdstock_detail[$i]['material_no'];
             		     $stdstock_to_cancel['requirement_qty'][$i] = $edit_stdstock_detail[$i]['requirement_qty'];
						 //$stdstock_to_cancel['price'][$i] = $edit_stdstock_detail[$i]['price'];
                       }
                   }
                   if(isset($_POST['button']['change'])) {
             		   $stdstock_to_change['item'][$i] = $i;
              		   if(($stdstock['stdstock_detail']['requirement_qty'][$i]!=$stdstock['stdstock_detail']['requirement_qty_old'][$i])) {
             		     $stdstock_to_change['id_stdstock_pr_line_no'][$i] = $edit_stdstock_detail[$i]['id_stdstock_pr_line_no'];
               		     $stdstock_to_change['material_no'][$i] = $edit_stdstock_detail[$i]['material_no'];
               		     $stdstock_to_change['requirement_qty'][$i] = $stdstock['stdstock_detail']['requirement_qty'][$i];
						/* $stdstock_to_change['price'][$i] = $stdstock['stdstock_detail']['price'][$i];
						 $stdstock_to_change['price_old'][$i] = $stdstock['stdstock_detail']['price_old'][$i];*/
               		     $stdstock_to_change['requirement_qty_old'][$i] = $stdstock['stdstock_detail']['requirement_qty_old'][$i];
                       }
                   }
                }
                if(isset($_POST['button']['delete_item'])) {
                    $cancelled_data = $this->m_stdstock->sap_stdstock_header_cancel($stdstock_to_cancel);
         			$cancel_data_success = FALSE;
        			if(empty($cancelled_data['sap_return_type'])||($cancelled_data['sap_return_type']=='S')) {
                		for($i = 1; $i <= $count; $i++) {
                			if(!empty($stdstock['cancel'][$i])) {
        	    			$stdstock_header = array (
        						'id_stdstock_header'=>$stdstock['stdstock_header']['id_stdstock_header'],
        						'id_stdstock_plant'=>$stdstock_to_cancel['id_stdstock_plant'],
        					);
        		    		if($this->m_stdstock->stdstock_header_update($stdstock_header)==TRUE) {
            		    		if($this->m_stdstock->stdstock_detail_delete($edit_stdstock_detail[$i]['id_stdstock_detail'])==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                          }
                        }
                    }
                }

                if(isset($_POST['button']['change'])) {
                    $changed_data = $this->m_stdstock->sap_stdstock_header_change($stdstock_to_change);
         			$cancel_data_success = FALSE;
        			if($changed_data['sap_return_type']=='S') {
                		for($i = 1; $i <= $count; $i++) {
                			if($stdstock['stdstock_detail']['requirement_qty'][$i]!=$stdstock['stdstock_detail']['requirement_qty_old'][$i] ) {
            	    			$stdstock_detail = array (
            						'id_stdstock_detail'=>$edit_stdstock_detail[$i]['id_stdstock_detail'],
            						'requirement_qty'=>$stdstock['stdstock_detail']['requirement_qty'][$i]
									//'price'=>$stdstock['stdstock_detail']['price'][$i]
            					);
            		    		if($this->m_stdstock->stdstock_detail_update($stdstock_detail)==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                        }
                    }
                }

          	    $this->db->trans_complete();

                if($cancel_data_success == TRUE) {
                    if(isset($_POST['button']['delete_item']))
    				  $this->l_general->success_page('Data Store Room Request (SR) berhasil dibatalkan', site_url('stdstock/browse'));
                    else
    				  $this->l_general->success_page('Data Store Room Request (SR) berhasil diganti', site_url('stdstock/browse'));
                } else {
                    if(isset($_POST['button']['delete_item'])) {
    				   $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak  berhasil dibatalkan.<br>
                                       Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
                    } else {
    				   $this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Store Room Request (SR) tidak  berhasil diganti.<br>
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

	function _delete($id_stdstock_header) {
	
	   $stdstock_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	   $stdstock_delete['module'] = "Store Room Request (SR) ";
	   $stdstock_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	   $stdstock_delete['id_delete'] = $id_stdstock_header;

		$this->db->trans_start();

		// check approve status
		$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);

		if($stdstock_header['status'] == '1') {
			$this->m_stdstock->stdstock_header_delete($id_stdstock_header);
			$this->m_stdstock->user_delete($stdstock_delete);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_stdstock_header) {

		if($this->_delete($id_stdstock_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Store Room Request (SR) berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stdstock_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Store Room Request (SR) gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stdstock_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_stdstock_header']))
			redirect($this->session->userdata['PAGE']['stdstock_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
        if(!empty($_POST['id_stdstock_header'][$i])) {
				$object['data']['stdstock_headers'][$j++] = $this->m_stdstock->stdstock_header_select($_POST['id_stdstock_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'stdstock/stdstock_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'stdstock/stdstock_delete_multiple_confirm', $object);

        $this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_stdstock_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Store Room Request (SR) berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['stdstock_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_stdstock->stdstock_select_to_export($_POST['id_stdstock_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'StandardStock');
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'stdstock_data';
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

		 	if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][2] == 'Request reason' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // stdstock_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same stdstock header?

					$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];

					// check stdstock header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($stdstock_header_temp = $this->m_general->sap_item_groups_select_all_stdstock()) {

							$object['stdstock_headers'][$j]['created_date'] = date("Y-m-d H:i:s");
                            $object['stdstock_headers'][$j]['pr_no'] = $excel['cells'][$i][1];
                            $object['stdstock_headers'][$j]['request_reason'] = $request_reason;
                            $object['stdstock_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['stdstock_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['stdstock_headers'][$j]['status'] = '1';
							$object['stdstock_headers'][$j]['item_group_code'] = $item_group_code;
							$object['stdstock_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['stdstock_headers'][$j]['filename'] = $upload['file_name'];

            	$stdstock_header_exist = TRUE;
							$k = 1; // stdstock_detail number
						} else {
            	$stdstock_header_exist = FALSE;
						}
					}

					if($stdstock_header_exist) {

						if($stdstock_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['stdstock_details'][$j][$k]['id_stdstock_h_detail'] = $k;

							$object['stdstock_details'][$j][$k]['material_no'] = $material_no;
							$object['stdstock_details'][$j][$k]['material_desc'] = $stdstock_detail_temp['MAKTX'];
							$object['stdstock_details'][$j][$k]['requirement_qty'] = $quantity;
							//$object['stdstock_details'][$j][$k]['price'] = $price;
							$object['stdstock_details'][$j][$k]['uom'] = $stdstock_detail_temp['UNIT'];

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'stdstock/stdstock_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'stdstock/browse_result/0/0/0/0/0/0/0/10';
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

		// is it stdstock template file?
		 	if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][2] == 'Request reason' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // stdstock_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same stdstock header?

			  	$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];



				// check stdstock header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
				   	if($stdstock_detail_temp = $this->m_general->sap_item_groups_select_all_stdstock()) {

    					   	$object['stdstock_headers'][$j]['created_date'] = $this->m_general->posting_date_select_max();
                            $object['stdstock_headers'][$j]['request_reason'] = $request_reason;
							$object['stdstock_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['stdstock_headers'][$j]['id_stdstock_plant'] = $this->m_stdstock->id_stdstock_plant_new_select($object['stdstock_headers'][$j]['plant'],$object['stdstock_headers'][$j]['created_date']);
							$object['stdstock_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['stdstock_headers'][$j]['status'] = '1';
                            $delivery_date = date("Y-m-d H:i:s");
                            $delivery_date = $this->l_general->str_to_date(date("d-m-Y",strtotime($delivery_date)));
                            $object['stdstock_headers'][$j]['delivery_date'] = $delivery_date;
							$object['stdstock_headers'][$j]['item_group_code'] = $item_group_code;
							$object['stdstock_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['stdstock_headers'][$j]['filename'] = $upload['file_name'];

						$id_stdstock_header = $this->m_stdstock->stdstock_header_insert($object['stdstock_headers'][$j]);

           	$stdstock_header_exist = TRUE;
						$k = 1; // stdstock_detail number

					} else {
           	$stdstock_header_exist = FALSE;
					}
				}

				if($stdstock_header_exist) {

					if($stdstock_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                        $object['stdstock_details'][$j][$k]['id_stdstock_header'] = $id_stdstock_header;
						$object['stdstock_details'][$j][$k]['id_stdstock_h_detail'] = $k;

							$object['stdstock_details'][$j][$k]['material_no'] = $material_no;
							$object['stdstock_details'][$j][$k]['material_desc'] = $stdstock_detail_temp['MAKTX'];
						   $object['stdstock_details'][$j][$k]['requirement_qty'] = $quantity;
						  //  $object['stdstock_details'][$j][$k]['price'] = $price;
							$object['stdstock_details'][$j][$k]['uom'] = $stdstock_detail_temp['UNIT'];


						$id_stdstock_detail = $this->m_stdstock->stdstock_detail_insert($object['stdstock_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Standard Stock  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stdstock_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'stdstock/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '011';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}


public function printpdf($id_stdstock_header)
	{
		$this->load->model('m_SR');
		//$this->load->model('m_stdstock');
		//$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);
		$data['data'] = $this->m_SR->tampil($id_stdstock_header);
		
		ob_start();
		$content = $this->load->view('store_room',$data);
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

public function cetak($id_stdstock_header)
	{
		$this->load->model('m_printstock');
		$data['data'] = $this->model_data->tampil($id_stdstock_header);
		$this->load->view('store_room',$data);
	}	
}