<?php
class pr extends Controller {
	private $jagmodule = array();


	function pr() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1040);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_pr'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_database');
		$this->load->model('m_pr');
		$this->load->model('m_printstock');

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
		$pr_browse_result = $this->session->userdata['PAGE']['pr_browse_result'];

		if(!empty($pr_browse_result))
			redirect($this->session->userdata['PAGE']['pr_browse_result']);
		else
			redirect('pr/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('pr/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('pr/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('pr_browse_result');

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
			'a'	=>	'PR Number',
			
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

		$sort_link1 = 'pr/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('pr/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_pr->pr_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['pr_headers'] = $this->m_pr->pr_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'Purchase Request (PR)';
		$this->template->write_view('content', 'pr/pr_browse', $object);
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

//echo date('Y-m-d');
        $pr_detail_tmp = array('pr_detail' => '');
        $this->session->unset_userdata($pr_detail_tmp);
        unset($pr_detail_tmp);

    	$object['request_reasons'][0] = '';
		$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Cake Shop'] = 'Cake Shop';
    	$object['request_reasons']['Store'] = 'Store';
    	$object['request_reasons']['Bar'] = 'Bar';

		if(!empty($data['request_reason'])) {
			/*$data['item_groups'] = $this->m_general->sap_item_groups_select_all_stdstock();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				//$object['item_group_code']['all'] = '==All==';

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
			redirect('pr/input2/'.$data['request_reason'].'/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Purchase Request (PR)';
		$this->template->write_view('content', 'pr/pr_input', $object);
		$this->template->render();

	}

	function input2()	{

		$request_reason = $this->uri->segment(3);
		$item_choose = $this->uri->segment(5);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['pr_detail']['id_pr_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['material_no'][$i], "pr_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['requirement_qty'][$i], "pr_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
				/*	$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['price'][$i], "pr_detail[price][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
          $pr_detail_tmp = array('pr_detail' => '');
          $this->session->unset_userdata($pr_detail_tmp);
          unset($pr_detail_tmp);
        }

        $object['data']['pr_header']['status_string'] = ($_POST['pr_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
     	    $request_reason = $this->uri->segment(4);
    		$item_group_code = $this->uri->segment(5);
    		$item_choose = $this->uri->segment(6);
        } else {
     	    $request_reason = $this->uri->segment(3);
    		$item_group_code = $this->uri->segment(4);
    		$item_choose = $this->uri->segment(5);
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

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_pr();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group_non($item_group_code, $item_choose, $request_reason);
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
		  $object['data']['pr_header'] = $_POST['pr_header'];//$this->m_pr->pr_details_select($this->uri->segment(3));
		  $object['data']['pr_detail'] = $_POST['pr_detail'];//$this->m_pr->pr_details_select($this->uri->segment(3));
   	      $object['data']['pr_header']['status_string'] = ($_POST['pr_header']['status'] == '2') ? 'Approved' : 'Not Approved';
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Purchase Request (PR)';
		$this->template->write_view('content', 'pr/pr_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$pr = $_POST;
		unset($pr['pr_header']['id_pr_header']);
		unset($pr['button']);
		// end of assign variables and delete not used variables

		$count = count($pr['pr_detail']['id_pr_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($pr['pr_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$price = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($pr['pr_detail']['price'][$i])) {
				continue;
			} else {
				$price = TRUE;
				break;
			}
		}*/
		
		if($requirement_qty_exist == FALSE )
			redirect('pr/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('pr', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$pr_header['id_pr_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('pr_detail', $pr['pr_detail']);

    		$pr_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$pr_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$pr_header['created_date'] = $this->m_general->posting_date_select_max($pr_header['plant']);
 			$pr_header['created_date'] = date('Y-m-d');
			$pr_header['id_pr_plant'] = $this->m_pr->id_pr_plant_new_select($pr_header['plant'],$pr_header['created_date']);

 			$pr_header['delivery_date'] = $this->l_general->str_to_date($pr['pr_header']['delivery_date']);
 			$pr_header['request_reason'] = $pr['pr_header']['request_reason'];
			//$pr_header['to_plant'] = $pr['pr_header']['to_plant'];

 			$pr_header['pr_no'] = '';

			if(isset($_POST['button']['approve']))
				$pr_header['status'] = '2';
			else
				$pr_header['status'] = '1';

			$pr_header['item_group_code'] = $pr['pr_header']['item_group_code'];
			$pr_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($pr_header['plant'],$pr_header['created_date'],
                      $pr_header['id_pr_plant'],'09');
             //array utk parameter masukan pada saat approval
             if (strcmp($pr_header['request_reason'],'Order Tambahan') == 0)
                 $request_reason_tmp = 'T';
             else
                 $request_reason_tmp = 'S';
             if(isset($_POST['button']['approve'])) {
               $pr_to_approve = array (
                      'plant' => $pr_header['plant'],
                      'created_date' => date('Y-m-d'),
                      'id_user_input' => $pr_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'request_reason' => $request_reason_tmp,
                      'delivery_date' => date('Ymd',strtotime($pr_header['delivery_date'])),
                );
              }

			if($id_pr_header = $this->m_pr->pr_header_insert($pr_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($pr['pr_detail']['requirement_qty'][$i]))&&(!empty($pr['pr_detail']['material_no'][$i]))) {

						$pr_detail['id_pr_header'] = $id_pr_header;
						$pr_detail['requirement_qty'] = $pr['pr_detail']['requirement_qty'][$i];
						if(!empty($pr['pr_detail']['price'][$i]))
							$pr_detail['price'] = $pr['pr_detail']['price'][$i];
						if(!empty($pr['pr_detail']['vendor'][$i]))
							$pr_detail['vendor'] = $pr['pr_detail']['vendor'][$i];

						$pr_detail['id_pr_h_detail'] = $pr['pr_detail']['id_pr_h_detail'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($pr['pr_detail']['material_no'][$i]);

						$pr_detail['material_no'] = $item['MATNR'];
						$pr_detail['material_desc'] = $item['MAKTX'];
   						$pr_detail['uom'] = $pr['pr_detail']['uom'][$i];
						if(!empty($pr['pr_detail']['OnHand'][$i]))
							$pr_detail['OnHand'] = $pr['pr_detail']['OnHand'][$i];
						if(!empty($pr['pr_detail']['MinStock'][$i]))
							$pr_detail['MinStock'] = $pr['pr_detail']['MinStock'][$i];
						if(!empty($pr['pr_detail']['OpenQty'][$i]))
							$pr_detail['OpenQty'] = $pr['pr_detail']['OpenQty'][$i];
						//echo $pr_detail['uom'];
                        //array utk parameter masukan pada saat approval
                        $pr_to_approve['item'][$i] = $pr_detail['id_pr_h_detail'];
                        $pr_to_approve['material_no'][$i] = $pr_detail['material_no'];
                        $pr_to_approve['requirement_qty'][$i] = $pr_detail['requirement_qty'];
						
						if(!empty($pr_detail['price']))
							$pr_to_approve['price'][$i] = $pr_detail['price'];
						if(!empty($pr_detail['vendor']))
							$pr_to_approve['vendor'][$i] = $pr_detail['vendor'];
						
                       // if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                         //   $pr_to_approve['uom'][$i] = $pr_detail['uom'];
                       // } else {
                            $pr_to_approve['uom'][$i] = $pr_detail['uom'];
                       // }
                        //

						if($this->m_pr->pr_detail_insert($pr_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			  //  $approved_data = $this->m_pr->sap_pr_header_approve($pr_to_approve);
    		//	if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_pr_header'=>$id_pr_header,
    					'pr_no'	=>	$pr_no,
    					'status' =>	'2',
    					'id_user_approved'=>$this->session->userdata['ADMIN']['admin_id'],
						'created_date' => date('Y-m-d')
    				);
    				if($this->m_pr->pr_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_pr_header'=>$id_pr_header,
            					'id_pr_h_detail'=>$pr['pr_detail']['id_pr_h_detail'][$i],
            					'id_pr_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_pr->pr_detail_update_by_id_h_detail($data)) {*/
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
   			    $this->l_general->success_page('Data Purchase Request (PR) berhasil dimasukkan', site_url('pr/input'));
              } else {
                $this->m_pr->pr_header_delete($id_pr_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Purchase Request (PR) berhasil diapprove', site_url('pr/input'));
              } else {
                $this->m_pr->pr_header_delete($id_pr_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak berhasil diapprove.<br>
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
		$object['refresh_text'] = 'Data Purchase Request (PR) berhasil diapprove';
		$object['refresh_url'] = site_url('pr/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Purchase Request (PR) berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('pr/input');
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
	    $pr_header = $this->m_pr->pr_header_select($this->uri->segment(3));
		$status = $pr_header['status'];
        unset($pr_header);

        $pr_detail_tmp = array('pr_detail' => '');
        $this->session->unset_userdata($pr_detail_tmp);
        unset($pr_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

//		if((count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['pr_detail']['id_pr_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['material_no'][$i], "pr_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['requirement_qty'][$i], "pr_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					/*$check[$j] = $this->l_form_validation->set_rules($_POST['pr_detail']['price'][$i], "pr_detail[price][$i]", 'Price No. '.$i, 'required|is_numeric_no_zero');

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
				$pr_header = $this->m_pr->pr_header_select($this->uri->segment(3));
				if($pr_header['status'] == '2') {
    				$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['pr_header'] = $this->m_pr->pr_header_select($this->uri->segment(3));
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
          $pr_detail_tmp = array('pr_detail' => '');
          $this->session->unset_userdata($pr_detail_tmp);
          unset($pr_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['pr_header']['status_string'] = ($object['data']['pr_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_pr_header = $data['pr_header']['id_pr_header'];
		$request_reason = $data['pr_header']['request_reason'];
		$item_group_code = $data['pr_header']['item_group_code'];;
		$item_choose = $this->uri->segment(6);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
		$object['pr_header']['id_pr_header'] = $id_grpo_header;
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
			$data['items'] = $this->m_general->sap_item_groups_select_all_pr();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'pr');
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
			$object['data']['pr_details'] = $this->m_pr->pr_details_select($object['data']['pr_header']['id_pr_header']);

			if($object['data']['pr_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['pr_details']->result_array() as $object['temp']) {
	//				$object['data']['pr_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['pr_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Purchase Request (PR)';
		$this->template->write_view('content', 'pr/pr_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$pr = $_POST;
		unset($pr['pr_header']['id_pr_header']);
		unset($pr['button']);
		// end of assign variables and delete not used variables

		$count = count($pr['pr_detail']['id_pr_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($pr['pr_detail']['requirement_qty'][$i])) {
				continue;
			} else {
				$requirement_qty_exist = TRUE;
				break;
			}
		}
		
		/*$price_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($pr['pr_detail']['price'][$i])) {
				continue;
			} else {
				$price_exist = TRUE;
				break;
			}
		}*/

		if($requirement_qty_exist == FALSE )
			redirect('pr/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('pr_detail', $pr['pr_detail']);

            $id_pr_header = $this->uri->segment(3);
            $createddate = $this->l_general->str_to_date($pr['pr_header']['created_date']);
            $deliverydate = $this->l_general->str_to_date($pr['pr_header']['delivery_date']);
			$id_pr_plant = $this->m_pr->id_pr_plant_new_select("",$createddate,$id_pr_header);

    			$data = array (
    				'id_pr_header' => $id_pr_header,
    			//	'created_date' => $createddate,
    				'delivery_date' => $deliverydate,
                    'id_pr_plant'=>$id_pr_plant,
    				'request_reason' => $pr['pr_header']['request_reason'],
    			);
                $this->m_pr->pr_header_update($data);
                $edit_pr_header = $this->m_pr->pr_header_select($id_pr_header);

    			if ($this->m_pr->pr_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_pr->pr_details_delete($id_pr_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($pr['pr_detail']['requirement_qty'][$i]))&&(!empty($pr['pr_detail']['material_no'][$i])) ) {

        						$pr_detail['id_pr_header'] = $id_pr_header;
        						$pr_detail['requirement_qty'] = $pr['pr_detail']['requirement_qty'][$i];
								if(!empty($pr['pr_detail']['price'][$i]))
								  $pr_detail['price'] = $pr['pr_detail']['price'][$i];
								if(!empty($pr['pr_detail']['vendor'][$i]))
								  $pr_detail['vendor'] = $pr['pr_detail']['vendor'][$i];
        						$pr_detail['id_pr_h_detail'] = $pr['pr_detail']['id_pr_h_detail'][$i];

        						$item = $this->m_general->sap_item_select_by_item_code($pr['pr_detail']['material_no'][$i]);

        						$pr_detail['material_no'] = $item['MATNR'];
        						$pr_detail['material_desc'] = $item['MAKTX'];
        						$pr_detail['uom'] = $pr['pr_detail']['uom'][$i];
								if(!empty($pr['pr_detail']['OnHand'][$i]))
								   $pr_detail['OnHand'] = $pr['pr_detail']['OnHand'][$i];
								if(!empty($pr['pr_detail']['MinStock'][$i]))
									$pr_detail['MinStock'] = $pr['pr_detail']['MinStock'][$i];
								if(!empty($pr['pr_detail']['OpenQty'][$i]))
									$pr_detail['OpenQty'] = $pr['pr_detail']['OpenQty'][$i];

                                //array utk parameter masukan pada saat approval
                                $pr_to_approve['item'][$i] = $pr_detail['id_pr_h_detail'];
                                $pr_to_approve['material_no'][$i] = $pr_detail['material_no'];
                                $pr_to_approve['requirement_qty'][$i] = $pr_detail['requirement_qty'];
								$pr_to_approve['price'][$i] = $pr_detail['price'];
								$pr_to_approve['vendor'][$i] = $pr_detail['vendor'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $pr_to_approve['uom'][$i] = $pr_detail['uom'];
                                } else {
                                    $pr_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                $pr_to_approve['uom'][$i] = $item['MEINS'];
                                //

        						if($this->m_pr->pr_detail_insert($pr_detail))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($pr['pr_detail']['requirement_qty'][$i])) {
            	    			$pr_detail = array (
            						'id_pr_detail'=>$pr['pr_detail']['id_pr_detail'][$i],
            						'requirement_qty'=>$pr['pr_detail']['requirement_qty'][$i],
            					);
            		    		if($this->m_pr->pr_detail_update($pr_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_pr->pr_detail_delete($pr['pr_detail']['id_pr_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
             //   $pr_to_approve['created_date'] = date('Ymd',strtotime($edit_pr_header['created_date']));
                $pr_to_approve['plant'] = $edit_pr_header['plant'];
                $pr_to_approve['id_pr_plant'] = $edit_pr_header['id_pr_plant'];
                $pr_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $pr_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_pr_header['plant'],$edit_pr_header['created_date'],
                      $edit_pr_header['id_pr_plant'],'09');
                if (strcmp($edit_pr_header['request_reason'],'Order Tambahan') == 0)
                  $request_reason_tmp = 'T';
                else
                  $request_reason_tmp = 'S';
                $pr_to_approve['request_reason'] = $request_reason_tmp;
                $pr_to_approve['delivery_date'] = date('Ymd',strtotime($edit_pr_header['delivery_date']));

			   // $approved_data = $this->m_pr->sap_pr_header_approve($pr_to_approve);
    			//if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_pr_header' =>$id_pr_header,
    					'pr_no'	=>	$pr_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
						'request_reason'=> $pr['pr_header']['request_reason']
    				);
    				if($this->m_pr->pr_header_update($data)) {
        			/*	for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_pr_header'=>$id_pr_header,
            					'id_pr_h_detail'=>$pr['pr_detail']['id_pr_h_detail'][$i],
            					'id_pr_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_pr->pr_detail_update_by_id_h_detail($data)) {*/
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
			  $this->l_general->success_page('Data Purchase Request (PR) berhasil diubah', site_url('pr/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve'])) {
              if($approve_data_success == TRUE) {
  			     $this->l_general->success_page('Data Purchase Request (PR) berhasil diapprove', site_url('pr/browse'));
              } else {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
              }

		    }
	    }
    }
	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'pr/browse';
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
		$pr = $_POST;
		unset($pr['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($pr['pr_header']['created_date']!=$date_today) {
			redirect('pr/edit_error/Anda tidak bisa mengganti atau menghapus transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        } else {

        	if(isset($_POST['button']['delete_item'])&& empty($pr['cancel'])) {
                $requirement_qty_exist = FALSE;
				//$price_exist = FALSE;
        	} else {
        		$requirement_qty_exist = TRUE;
				//$price_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('pr/edit_error/Anda belum memilih item yang akan di-delete. Mohon ulangi');

      		for($i = 1; $i <= $count; $i++) {
      			if(empty($pr['pr_detail']['requirement_qty'][$i])) {
      				continue;
      			} else {
      				$requirement_qty_exist = TRUE;
      				break;
      			}
              }
			  
			 /* for($i = 1; $i <= $count; $i++) {
      			if(empty($pr['pr_detail']['price'][$i])) {
      				continue;
      			} else {
      				$price_exist = TRUE;
      				break;
      			}
              }*/

    		if($requirement_qty_exist == FALSE )
    			redirect('pr/input_error/Anda belum memasukkan data Requirement Quantity atau Price. Mohon ulangi.');

        	if(isset($_POST['button']['change'])) {
                $requirement_qty_exist = FALSE;
                $count = count($pr['pr_detail']['id_pr_h_detail']);
                for($i=1;$i<=$count;$i++){
                  if($pr['pr_detail']['requirement_qty'][$i]!=$pr['pr_detail']['requirement_qty_old'][$i]){
               		$requirement_qty_exist = TRUE;
                    break;
                  }
                }
				
				/*$price_exist = FALSE;
                $count1 = count($pr['pr_detail']['id_pr_h_detail']);
                for($i=1;$i<=$count1;$i++){
                  if($pr['pr_detail']['price'][$i]!=$pr['pr_detail']['price_old'][$i]){
               		$price_exist = TRUE;
                    break;
                  }
                }*/
        	} else {
        		//$price_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE )
    			redirect('pr/edit_error/Anda belum mengganti item yang akan di-changed. Mohon ulangi');

    //		if($this->m_config->running_number_select_update('pr', 1, date("Y-m-d")) {

            $edit_pr_header = $this->m_pr->pr_header_select($pr['pr_header']['id_pr_header']);
    		$edit_pr_details = $this->m_pr->pr_details_select($pr['pr_header']['id_pr_header']);
        	$i = 1;
    	    foreach ($edit_pr_details->result_array() as $value) {
    		    $edit_pr_detail[$i] = $value;
    		    $i++;
            }
            unset($edit_pr_details);

    //echo "<pre>";
    //print '$edit_pr_detail';
    //print_r($edit_pr_detail);
    //echo "</pre>";
    //exit;

    		if(isset($_POST['button']['change'])||isset($_POST['button']['delete_item'])) {

        		$this->session->set_userdata('pr_detail', $pr['pr_detail']);

    			$this->db->trans_start();

                if(isset($_POST['button']['delete_item'])) {
                  $pr_to_cancel['pr_no'] = $edit_pr_header['pr_no'];
                  $pr_to_cancel['created_date'] = date('Ymd',strtotime($edit_pr_header['created_date']));
                  $pr_to_cancel['plant'] = $edit_pr_header['plant'];
          		  $pr_to_cancel['id_pr_plant'] = $this->m_pr->id_pr_plant_new_select($edit_pr_header['plant'],date('Y-m-d',strtotime($edit_pr_header['created_date'])));
                  $pr_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_pr_header['plant'],$edit_pr_header['created_date'],
                            $pr_to_cancel['id_pr_plant'],'09');
                  $pr_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                if(isset($_POST['button']['change'])) {
                  $pr_to_change['pr_no'] = $edit_pr_header['pr_no'];
                  $pr_to_change['created_date'] = date('Ymd',strtotime($edit_pr_header['created_date']));
                  $pr_to_change['plant'] = $edit_pr_header['plant'];
                  $pr_to_change['id_pr_plant'] = $this->m_pr->id_pr_plant_new_select($edit_pr_header['plant'],date('Y-m-d',strtotime($edit_pr_header['created_date'])));
                  $pr_to_change['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_pr_header['plant'],$edit_pr_header['created_date'],
                            $pr_to_change['id_pr_plant'],'09');
                  $pr_to_change['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                $count = count($edit_pr_detail);
        		for($i = 1; $i <= $count; $i++) {
        		   if (isset($_POST['button']['delete_item'])) {
         		       $pr_to_cancel['item'][$i] = $i;
            		   if(!empty($pr['cancel'][$i])) {
             		     $pr_to_cancel['id_pr_pr_line_no'][$i] = $edit_pr_detail[$i]['id_pr_pr_line_no'];
             		     $pr_to_cancel['material_no'][$i] = $edit_pr_detail[$i]['material_no'];
             		     $pr_to_cancel['requirement_qty'][$i] = $edit_pr_detail[$i]['requirement_qty'];
						 //$pr_to_cancel['price'][$i] = $edit_pr_detail[$i]['price'];
                       }
                   }
                   if(isset($_POST['button']['change'])) {
             		   $pr_to_change['item'][$i] = $i;
              		   if(($pr['pr_detail']['requirement_qty'][$i]!=$pr['pr_detail']['requirement_qty_old'][$i])) {
             		     $pr_to_change['id_pr_pr_line_no'][$i] = $edit_pr_detail[$i]['id_pr_pr_line_no'];
               		     $pr_to_change['material_no'][$i] = $edit_pr_detail[$i]['material_no'];
               		     $pr_to_change['requirement_qty'][$i] = $pr['pr_detail']['requirement_qty'][$i];
						/* $pr_to_change['price'][$i] = $pr['pr_detail']['price'][$i];
						 $pr_to_change['price_old'][$i] = $pr['pr_detail']['price_old'][$i];*/
               		     $pr_to_change['requirement_qty_old'][$i] = $pr['pr_detail']['requirement_qty_old'][$i];
                       }
                   }
                }
                if(isset($_POST['button']['delete_item'])) {
                    $cancelled_data = $this->m_pr->sap_pr_header_cancel($pr_to_cancel);
         			$cancel_data_success = FALSE;
        			if(empty($cancelled_data['sap_return_type'])||($cancelled_data['sap_return_type']=='S')) {
                		for($i = 1; $i <= $count; $i++) {
                			if(!empty($pr['cancel'][$i])) {
        	    			$pr_header = array (
        						'id_pr_header'=>$pr['pr_header']['id_pr_header'],
        						'id_pr_plant'=>$pr_to_cancel['id_pr_plant'],
        					);
        		    		if($this->m_pr->pr_header_update($pr_header)==TRUE) {
            		    		if($this->m_pr->pr_detail_delete($edit_pr_detail[$i]['id_pr_detail'])==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                          }
                        }
                    }
                }

                if(isset($_POST['button']['change'])) {
                    $changed_data = $this->m_pr->sap_pr_header_change($pr_to_change);
         			$cancel_data_success = FALSE;
        			if($changed_data['sap_return_type']=='S') {
                		for($i = 1; $i <= $count; $i++) {
                			if($pr['pr_detail']['requirement_qty'][$i]!=$pr['pr_detail']['requirement_qty_old'][$i] ) {
            	    			$pr_detail = array (
            						'id_pr_detail'=>$edit_pr_detail[$i]['id_pr_detail'],
            						'requirement_qty'=>$pr['pr_detail']['requirement_qty'][$i]
									//'price'=>$pr['pr_detail']['price'][$i]
            					);
            		    		if($this->m_pr->pr_detail_update($pr_detail)==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                        }
                    }
                }

          	    $this->db->trans_complete();

                if($cancel_data_success == TRUE) {
                    if(isset($_POST['button']['delete_item']))
    				  $this->l_general->success_page('Data Purchase Request (PR) berhasil dibatalkan', site_url('pr/browse'));
                    else
    				  $this->l_general->success_page('Data Purchase Request (PR) berhasil diganti', site_url('pr/browse'));
                } else {
                    if(isset($_POST['button']['delete_item'])) {
    				   $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak  berhasil dibatalkan.<br>
                                       Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
                    } else {
    				   $this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Purchase Request (PR) tidak  berhasil diganti.<br>
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

	function _delete($id_pr_header) {

		$this->db->trans_start();
		$pr_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	    $pr_delete['module'] = "Purchase Request";
	    $pr_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	    $pr_delete['id_delete'] = $id_pr_header;

		// check approve status
		$pr_header = $this->m_pr->pr_header_select($id_pr_header);

		if($pr_header['status'] == '1') {
			$this->m_pr->pr_header_delete($id_pr_header);
			$this->m_pr->user_delete($pr_delete);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_pr_header) {

		if($this->_delete($id_pr_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Purchase Request (PR) berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['pr_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Purchase Request (PR) gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['pr_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_pr_header']))
			redirect($this->session->userdata['PAGE']['pr_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
        if(!empty($_POST['id_pr_header'][$i])) {
				$object['data']['pr_headers'][$j++] = $this->m_pr->pr_header_select($_POST['id_pr_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'pr/pr_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'pr/pr_delete_multiple_confirm', $object);

        $this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_pr_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Purchase Request (PR) berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['pr_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_pr->pr_select_to_export($_POST['id_pr_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'StandardStock');
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'pr_data';
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

				$j = 0; // pr_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same pr header?

					$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];

					// check pr header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($pr_header_temp = $this->m_general->sap_item_groups_select_all_pr()) {

							$object['pr_headers'][$j]['created_date'] = date("Y-m-d H:i:s");
                            $object['pr_headers'][$j]['pr_no'] = $excel['cells'][$i][1];
                            $object['pr_headers'][$j]['request_reason'] = $request_reason;
                            $object['pr_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['pr_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['pr_headers'][$j]['status'] = '1';
							$object['pr_headers'][$j]['item_group_code'] = $item_group_code;
							$object['pr_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['pr_headers'][$j]['filename'] = $upload['file_name'];

            	$pr_header_exist = TRUE;
							$k = 1; // pr_detail number
						} else {
            	$pr_header_exist = FALSE;
						}
					}

					if($pr_header_exist) {

						if($pr_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['pr_details'][$j][$k]['id_pr_h_detail'] = $k;

							$object['pr_details'][$j][$k]['material_no'] = $material_no;
							$object['pr_details'][$j][$k]['material_desc'] = $pr_detail_temp['MAKTX'];
							$object['pr_details'][$j][$k]['requirement_qty'] = $quantity;
							//$object['pr_details'][$j][$k]['price'] = $price;
							$object['pr_details'][$j][$k]['uom'] = $pr_detail_temp['UNIT'];

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'pr/pr_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'pr/browse_result/0/0/0/0/0/0/0/10';
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

		// is it pr template file?
		 	if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][2] == 'Request reason' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // pr_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same pr header?

			  	$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];



				// check pr header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
				   	if($pr_detail_temp = $this->m_general->sap_item_groups_select_all_pr()) {

    					   	$object['pr_headers'][$j]['created_date'] = $this->m_general->posting_date_select_max();
                            $object['pr_headers'][$j]['request_reason'] = $request_reason;
							$object['pr_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['pr_headers'][$j]['id_pr_plant'] = $this->m_pr->id_pr_plant_new_select($object['pr_headers'][$j]['plant'],$object['pr_headers'][$j]['created_date']);
							$object['pr_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['pr_headers'][$j]['status'] = '1';
                            $delivery_date = date("Y-m-d H:i:s");
                            $delivery_date = $this->l_general->str_to_date(date("d-m-Y",strtotime($delivery_date)));
                            $object['pr_headers'][$j]['delivery_date'] = $delivery_date;
							$object['pr_headers'][$j]['item_group_code'] = $item_group_code;
							$object['pr_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['pr_headers'][$j]['filename'] = $upload['file_name'];

						$id_pr_header = $this->m_pr->pr_header_insert($object['pr_headers'][$j]);

           	$pr_header_exist = TRUE;
						$k = 1; // pr_detail number

					} else {
           	$pr_header_exist = FALSE;
					}
				}

				if($pr_header_exist) {

					if($pr_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                        $object['pr_details'][$j][$k]['id_pr_header'] = $id_pr_header;
						$object['pr_details'][$j][$k]['id_pr_h_detail'] = $k;

							$object['pr_details'][$j][$k]['material_no'] = $material_no;
							$object['pr_details'][$j][$k]['material_desc'] = $pr_detail_temp['MAKTX'];
						   $object['pr_details'][$j][$k]['requirement_qty'] = $quantity;
						  //  $object['pr_details'][$j][$k]['price'] = $price;
							$object['pr_details'][$j][$k]['uom'] = $pr_detail_temp['UNIT'];


						$id_pr_detail = $this->m_pr->pr_detail_insert($object['pr_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Standard Stock  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['pr_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Request Standard Stock atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'pr/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '011';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}


public function printpdf($id_pr_header)
	{
		$this->load->model('m_printstock');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printstock->tampil($id_pr_header);
		
		ob_start();
		$content = $this->load->view('data',$data);
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
	
	public function printpdfPO($id_pr_header)
	{
		$this->load->model('m_printstock');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printstock->tampil($id_pr_header);
		
		ob_start();
		$content = $this->load->view('dataPO',$data);
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

/*public function cetak($id_pr_header)
	{
		$this->load->model('m_printstock');
		$data['data'] = $this->model_data->tampil($id_pr_header);
		$this->load->view('store_room',$data);
	}	*/
}