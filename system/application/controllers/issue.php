<?php
class issue extends Controller {
	private $jagmodule = array();


	function issue() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1061);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_issue'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_issue');
		$this->load->model('m_database');
		$this->load->model('m_general');
		$this->load->model('m_sfgs');

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
		$issue_browse_result = $this->session->userdata['PAGE']['issue_browse_result'];

		if(!empty($issue_browse_result))
			redirect($this->session->userdata['PAGE']['issue_browse_result']);
		else
			redirect('issue/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('issue/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('issue/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('issue_browse_result');

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
			'a'	=>	'Issue No',
			
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

		$sort_link1 = 'issue/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('issue/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_issue->issue_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['issue_headers'] = $this->m_issue->issue_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Good Issue ';
		$this->template->write_view('content', 'issue/issue_browse', $object);
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

        $issue_detail_tmp = array('issue_detail' => '');
        $this->session->unset_userdata($issue_detail_tmp);
        unset($issue_detail_tmp);

    	/*$data['item_groups'] = $this->m_general->sap_item_groups_select_all_issue();

    	if($data['item_groups'] !== FALSE) {
    		$object['item_group_code'][0] = '';
    		$object['item_group_code']['all'] = '==All==';

    		foreach ($data['item_groups'] as $item_group) {
    			$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
    		}
    	}*/

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('issue/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Good Issue';
		$this->template->write_view('content', 'issue/issue_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['issue_detail']['id_issue_h_detail']);
				
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['material_no'][$i], "issue_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$stock=$_POST['issue_detail']['stock'][$i];
				$qty=$_POST['issue_detail']['quantity'][$i];
				if ($qty > $stock)
				{
					$check[$j] = $this->l_form_validation->set_rules(0, "issue_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
				}

					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['quantity'][$i], "issue_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['reason_name'][$i], "issue_detail[reason_name][$i]", 'Waste Material Reason No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					
					$item=$_POST['issue_detail']['material_no'][$i];
					/*mysql_connect("localhost","root","");
					mysql_select_db("sap_php_go");
					
					$cek_req=mysql_num_rows(mysql_query("SELECT BATCH FROM m_item WHERE MATNR='$item' AND BATCH='Y'"));
					if ($cek_req == 1)
					{
					//echo "xxx";
					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['num'][$i], "issue_detail[num][$i]", 'Batch Number '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
					}*/
					
					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_header']['no_acara'], "issue_header[no_acara]", 'No. Acara'.$i, 'required');

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
          $issue_detail_tmp = array('issue_detail' => '');
          $this->session->unset_userdata($issue_detail_tmp);
          unset($issue_detail_tmp);
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
			$data['items'] = $this->m_general->sap_item_groups_select_all_waste();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'issue');
		}
//exit;

    	$data['reason'] = $this->m_issue->issue_reason_select_all();

    	if($data['reason'] !== FALSE) {
    		$object['reason'][''] = '';

    		foreach ($data['reason']->result_array() as $reason) {
    			$object['reason'][$reason['reason_name']] = $reason['reason_name'];
    		}
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
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['issue_header'] = $_POST['issue_header'];//$this->m_issue->issue_details_select($this->uri->segment(3));
		  $object['data']['issue_detail'] = $_POST['issue_detail'];//$this->m_issue->issue_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Good Issue';
		$this->template->write_view('content', 'issue/issue_edit', $object);
		$this->template->render();
	}

	function input_transaksi_baru_error() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Transaksi Good Issue untuk hari ini sudah diinput dan di approve.<br>
                                   Anda hanya bisa menginput 1 transaksi Good Issue dalam 1 hari';
        $object['refresh_url'] = 'issue/browse';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '003';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$issue = $_POST;
		unset($issue['issue_header']['id_issue_header']);
		unset($issue['button']);
		// end of assign variables and delete not used variables

		$count = count($issue['issue_detail']['id_issue_h_detail']) - 1;

      /*  $id_issue_header = $this->m_issue->issue_header_select_id_by_date_status_approve($this->l_general->str_to_date($issue['issue_header']['posting_date']));
        if ($id_issue_header==TRUE) {
   		  redirect('issue/input_transaksi_baru_error');
        }*/

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($issue['issue_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('issue/input_error/Anda belum memasukkan Quantity atau belum klik Add Item. Mohon coba lagi.');

//		if($this->m_config->running_number_select_update('issue', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$issue_header['id_issue_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('issue_detail', $issue['issue_detail']);

    		$issue_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$issue_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
    		$issue_header['cost_center'] = $this->session->userdata['ADMIN']['cost_center'];
			$issue_header['id_issue_plant'] = $this->m_issue->id_issue_plant_new_select($issue_header['plant']);
// 			$issue_header['posting_date'] = $this->m_general->posting_date_select_max($issue_header['plant']);
 			$issue_header['posting_date'] = $this->l_general->str_to_date($issue['issue_header']['posting_date']);

			$issue_header['material_doc_no'] = '';

			if(isset($_POST['button']['approve']))
				$issue_header['status'] = '2';
			else
				$issue_header['status'] = '1';

			$issue_header['item_group_code'] = $issue['issue_header']['item_group_code'];
			$issue_header['no_acara'] = $issue['issue_header']['no_acara'];
			$issue_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];


            $web_trans_id = $this->l_general->_get_web_trans_id($issue_header['plant'],$issue_header['posting_date'],
                      $issue_header['id_issue_plant']);
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $issue_to_approve = array (
                      'plant' => $issue_header['plant'],
                      'posting_date' => date('Ymd',strtotime($issue_header['posting_date'])),
                      'id_user_input' => $issue_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
					  'no_acara' => $issue['issue_header']['no_acara']
                );
              }
			  
		$conn= TRUE;
		//$b=mssql_select_db('MSI',$c);
		$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
		$c=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));

		if ($c)
		{
			$conn=TRUE;
		}
		else
		{
			$conn=FALSE;
		}

            //$id_issue_header = $this->m_issue->issue_header_select_id_by_posting_date($issue_header['posting_date']);
			
            //if ($id_issue_header==FALSE) {
            //   $id_issue_header = $this->m_issue->issue_header_insert($issue_header);
            //}
            //if ($id_issue_header!==FALSE) {

			if($id_issue_header = $this->m_issue->issue_header_insert($issue_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($issue['issue_detail']['quantity'][$i]))&&(!empty($issue['issue_detail']['material_no'][$i]))) {

						$issue_detail['id_issue_header'] = $id_issue_header;
						$batch['BaseEntry'] = $id_issue_header;
						$issue_detail['quantity'] = $issue['issue_detail']['quantity'][$i];
						$batch['Quantity'] = $issue['issue_detail']['quantity'][$i];
						$issue_detail['id_issue_h_detail'] = $issue['issue_detail']['id_issue_h_detail'][$i];
						$batch['BaseLinNum'] = $issue['issue_detail']['id_issue_h_detail'][$i];
						$batch['BatchNum'] = $issue['issue_detail']['num'][$i];
						$issue_detail['num'] = $issue['issue_detail']['num'][$i];
						$issue_detail['reason_name'] = $issue['issue_detail']['reason_name'][$i];
						$issue_detail['other_reason'] = $issue['issue_detail']['other_reason'][$i];
						$batch['Createdate'] = $this->l_general->str_to_date($issue['issue_header']['posting_date']);
  						$issue_detail['material_no'] = $issue['issue_detail']['material_no'][$i];
						$batch['ItemCode'] = $issue['issue_detail']['material_no'][$i];
						$batch['BaseType']=201;
  						$issue_detail['material_desc'] = $issue['issue_detail']['material_desc'][$i];
  						$issue_detail['uom'] = $issue['issue_detail']['uom'][$i];
						$issue_detail['stock'] = $issue['issue_detail']['stock'][$i];
						

                    	if($id_issue_detail = $this->m_issue->issue_detail_insert($issue_detail)) {
                                      $input_detail_success = TRUE;
                 				   
                            	} else {
                                   $input_detail_success = FALSE;
                            	}
					}

				}
			}
			//}

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			 /*   $approved_data = $this->m_issue->sap_issue_header_approve($issue_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')
                    && ($approved_data['po_document'] !== '')) {*/
    			    $issue_no = '';
    			    $po_no = '';
    				$data = array (
    					'id_issue_header'	=>$id_issue_header,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
						'no_acara' =>  $issue['issue_header']['no_acara']
    				);
    				$this->m_issue->issue_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
				sqlsrv_close($c);
          //  }

            $this->db->trans_complete();

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE && $conn === TRUE) {
   			    $this->l_general->success_page('Data Good Issue berhasil dimasukkan', site_url('issue/input'));
              }else if ($conn === FALSE) {
				 $this->m_issue->issue_header_delete($id_issue_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
                $this->m_issue->issue_header_delete($id_issue_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Good Issue tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE && $conn === TRUE) {
  			     $this->l_general->success_page('Data Good Issue berhasil diapprove', site_url('issue/input'));
              } else if ($conn === FALSE){
				  $this->m_issue->issue_header_delete($id_issue_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  }else {
                $this->m_issue->issue_header_delete($id_issue_header);
				$this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Good Issue tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Waste Material tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('issue/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Waste Material berhasil diapprove';
		$object['refresh_url'] = site_url('issue/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Waste Material berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('issue/input');
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
	    $issue_header = $this->m_issue->issue_header_select($this->uri->segment(3));
		$status = $issue_header['status'];
        unset($issue_header);

        $issue_detail_tmp = array('issue_detail' => '');
        $this->session->unset_userdata($issue_detail_tmp);
        unset($issue_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['issue_detail']['id_issue_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['material_no'][$i], "issue_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['quantity'][$i], "issue_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['issue_detail']['reason_name'][$i], "issue_detail[reason_name][$i]", 'Waste Material Reason No. '.$i, 'required');

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
				$issue_header = $this->m_issue->issue_header_select($this->uri->segment(3));

				if($issue_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['issue_header'] = $this->m_issue->issue_header_select($this->uri->segment(3));
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
          $issue_detail_tmp = array('issue_detail' => '');
          $this->session->unset_userdata($issue_detail_tmp);
          unset($issue_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
	
		$id_issue_header = $data['issue_header']['id_issue_header'];
		$object['data']['issue_header']['status_string'] = ($object['data']['issue_header']['status'] == '2') ? 'Approved' : 'Not Approved';

        if ($this->uri->segment(2) == 'edit') {
    		$item_group_code = 'all';
        } else {
    		$item_group_code = $data['issue_header']['item_group_code'];;
        }
		$item_choose = $this->uri->segment(5);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['issue_header']['item_group_code'];
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
		$object['issue_header']['id_issue_header'] = $id_issue_header;
//exit;
    	$data['reason'] = $this->m_issue->issue_reason_select_all();

    	if($data['reason'] !== FALSE) {
    		$object['reason'][''] = '';

    		foreach ($data['reason']->result_array() as $reason) {
    			$object['reason'][$reason['reason_name']] = $reason['reason_name'];
    		}
    	}

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_waste();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'issue');
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
			$object['data']['issue_details'] = $this->m_issue->issue_details_select($object['data']['issue_header']['id_issue_header']);

			if($object['data']['issue_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['issue_details']->result_array() as $object['temp']) {
	//				$object['data']['issue_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['issue_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Good Issue';
		$this->template->write_view('content', 'issue/issue_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$issue = $_POST;
		unset($issue['issue_header']['id_issue_header']);
		unset($issue['button']);
		// end of assign variables and delete not used variables

		$count = count($issue['issue_detail']['id_issue_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($issue['issue_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('issue/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('issue_detail', $issue['issue_detail']);

            $id_issue_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($issue['issue_header']['posting_date']);

    			$data = array (
    				'id_issue_header' => $id_issue_header,
    				'posting_date' => $postingdate,
					'no_acara' =>  $issue['issue_header']['no_acara']
    			);
              $this->m_issue->issue_header_update($data);
		$conn= TRUE;
		//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
		//$b=mssql_select_db('MSI',$c);
		$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
		$c=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
		
		if ($c)
		{
			$conn=TRUE;
		}
		else
		{
			$conn=FALSE;
		}
                $edit_issue_header = $this->m_issue->issue_header_select($id_issue_header);
//echo $id_issue_header."-".$postingdate."-".$issue['issue_header']['no_acara']."<br>";
    			if ($this->m_issue->issue_header_update($data)) {
	//			echo "aaaaaaaaaaaaaa";
                    $input_detail_success = FALSE;
    			    if($this->m_issue->issue_details_delete($id_issue_header) && $this->m_issue->batch_delete($id_issue_header)) {
		//			echo "xxxxxxxxxxxx";
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($issue['issue_detail']['quantity'][$i]))&&(!empty($issue['issue_detail']['material_no'][$i]))) {
								
        						$issue_detail['id_issue_header'] = $id_issue_header;
        						$issue_detail['quantity'] = $issue['issue_detail']['quantity'][$i];
        						$issue_detail['id_issue_h_detail'] = $issue['issue_detail']['id_issue_h_detail'][$i];
        						$issue_detail['reason_name'] = $issue['issue_detail']['reason_name'][$i];
        						$issue_detail['other_reason'] = $issue['issue_detail']['other_reason'][$i];

        						$issue_detail['material_no'] = $issue['issue_detail']['material_no'][$i];
        						$issue_detail['material_desc'] = $issue['issue_detail']['material_desc'][$i];
        						$issue_detail['uom'] = $issue['issue_detail']['uom'][$i];
								$issue_detail['num'] = $issue['issue_detail']['num'][$i];
								$issue_detail['stock'] = $issue['issue_detail']['stock'][$i];
								$batch = array (
								'BaseEntry'=>$id_issue_header,
								'ItemCode'=>$issue['issue_detail']['material_no'][$i],
								'BatchNum'=>$issue['issue_detail']['num'][$i],
        						'BaseLinNum'=>$issue['issue_detail']['id_issue_h_detail'][$i],
        						'Quantity'=>$issue['issue_detail']['quantity'][$i],
								'Createdate'=>$postingdate,
								'BaseType'=>201
								);
									$t="$batch[BaseEntry]-$batch[ItemCode]-$batch[BatchNum]-($batch[BaseLinNum])-$batch[Quantity]";
							if($id_issue_detail = $this->m_issue->issue_detail_insert($issue_detail)) {
                                      $input_detail_success = TRUE;
                 				   
                            	} else {
                                   $input_detail_success = FALSE;
                            	} 
//        						if($this->m_issue->issue_detail_insert($issue_detail))
//                                  $input_detail_success = TRUE;
        					}

            	    	}
                    }
                }

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $issue_to_approve['posting_date'] = date('Ymd',strtotime($edit_issue_header['posting_date']));
                $issue_to_approve['plant'] = $edit_issue_header['plant'];
                $issue_to_approve['id_issue_plant'] = $edit_issue_header['id_issue_plant'];
                $issue_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $issue_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_issue_header['plant'],$edit_issue_header['posting_date'],
                      $edit_issue_header['id_issue_plant']);
			 /*   $approved_data = $this->m_issue->sap_issue_header_approve($issue_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')
                    && ($approved_data['po_document'] !== '')) {*/
    			    $issue_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
				//	echo $id_issue_header.'}}}';
    				$data = array (
    					'id_issue_header' =>$id_issue_header,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
						'no_acara' =>  $issue['issue_header']['no_acara']
    				);
    				$issue_header_update_status = $this->m_issue->issue_header_update($data);
  				    $approve_data_success = TRUE;
				} 
				sqlsrv_close($c);
         //   }

  			$this->db->trans_complete();
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE && $conn ==TRUE) {
   			    $this->l_general->success_page('Data Good Issue berhasil diubah', site_url('issue/browse'));
              }else if ($conn == FALSE) {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
 			    $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Good Issue tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE && $conn ==TRUE) {
  			     $this->l_general->success_page('Data Good Issue berhasil diapprove', site_url('issue/browse'));
              }else if ($conn == FALSE) {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Error In Connection', site_url($this->session->userdata['PAGE']['next']));
			  } else {
    		     $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Good Issue tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'issue/browse';
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
		$issue = $_POST;
		unset($issue['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

    	if(empty($issue['cancel'])) {
            $quantity_exist = FALSE;
    	} else {
    		$quantity_exist = TRUE;
    	}

		if($quantity_exist == FALSE)
			redirect('issue/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('issue', 1, date("Y-m-d")) {

        $edit_issue_header = $this->m_issue->issue_header_select($issue['issue_header']['id_issue_header']);
		$edit_issue_details = $this->m_issue->issue_details_select($issue['issue_header']['id_issue_header']);
    	$i = 1;
	    foreach ($edit_issue_details->result_array() as $value) {
		    $edit_issue_detail[$i] = $value;
		    $i++;
        }
        unset($edit_issue_details);

		if(isset($_POST['button']['cancel'])) {

//			$issue_header['id_issue_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $issue_to_cancel['issue_no'] = $edit_issue_header['issue_no'];
            $issue_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_issue_header['posting_date']));
            $issue_to_cancel['posting_date'] = date('Ymd',strtotime($edit_issue_header['posting_date']));
            $issue_to_cancel['plant'] = $edit_issue_header['plant'];
            $issue_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_issue_header['plant'],$edit_issue_header['posting_date'],
                      $edit_issue_header['id_issue_plant']);
            $issue_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_issue_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($issue['cancel'][$i]))
       		     $issue_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_issue->sap_issue_header_cancel($issue_to_cancel);
 			$cancel_data_success = FALSE;
			if(!empty($cancelled_data['material_document'])) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($issue['cancel'][$i])) {
    	    			$issue_detail = array (
    						'id_issue_detail'=>$edit_issue_detail[$i]['id_issue_detail'],
    						'ok_cancel'=>1,
    						'material_docno_cancellation'=>$mat_doc_cancellation,
    						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
    					);
    		    		if($this->m_issue->issue_detail_update($issue_detail)==TRUE) {
        				    $cancel_data_success = TRUE;
    			    	}
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
    			$this->l_general->success_page('Data Good Issue berhasil dibatalkan', site_url('issue/browse'));
            } else {
				$this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Issue tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Waste Material tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_issue_header) {
	
	 $issue_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	  $issue_delete['module'] = "Issue";
	 $issue_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $issue_delete['id_delete'] = $id_issue_header;
	 // echo '{'. $issue_delete['id_user_input'].'}-{'. $issue_delete['module'].'}-{'. $issue_delete['plant'].'}-{'. $issue_delete['id_delete'].'}';

		$this->db->trans_start();

		
// check approve status
		$issue_header = $this->m_issue->issue_header_select($id_issue_header);
		if($issue_header['status'] == '1') {
			$this->m_issue->issue_header_delete($id_issue_header);
			$this->m_issue->user_delete($issue_delete);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_issue_header) {

		if($this->_delete($id_issue_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Issue berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['issue_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Issue gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['issue_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_issue_header']))
			redirect($this->session->userdata['PAGE']['issue_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_issue_header'][$i])) {
				$object['data']['issue_headers'][$j++] = $this->m_issue->issue_header_select($_POST['id_issue_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'issue/issue_export_confirm', $object);
        else
    	  $this->template->write_view('content', 'issue/issue_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_issue_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Issue berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['issue_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_issue->issue_select_to_export($_POST['id_issue_header']);

    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'Waste');
          //to_excel($data);
          //require_once 'php-excel.class.php';
          //$xls = new Excel_XML();
          //$xls->addArray($data);
          //$xls->generateXML('issue');
          //require_once('export-xls.class.php');
          //$fields = $data->field_data();
          //foreach ($fields as $field) $headers[] = $field->name;
          //$xls = new ExportXLS('issue.xls');
          //$xls->addHeader($headers);
          //$xls->addRow($data->result_array());
          //$xls->sendFile();
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'issue_data';
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
                    $issue_reason = $excel['cells'][$i][4];
					$other_reason = $excel['cells'][$i][5];
					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
							$object['issue_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['issue_headers'][$j]['material_doc_no'] = $excel['cells'][$i][1];
							$object['issue_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['issue_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['issue_headers'][$j]['status'] = '1';
							$object['issue_headers'][$j]['item_group_code'] = $item_group_code;
							$object['issue_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['issue_headers'][$j]['filename'] = $upload['file_name'];
            	            $issue_header_exist = TRUE;
							$k = 1; // grpo_detail number
					}

					if($issue_header_exist) {

						if($issue_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['issue_details'][$j][$k]['id_grpo_h_detail'] = $k;
							$object['issue_details'][$j][$k]['item'] = $k;
							$object['issue_details'][$j][$k]['material_no'] = $material_no;
							$object['issue_details'][$j][$k]['material_desc'] = $issue_detail_temp['MAKTX'];
							$object['issue_details'][$j][$k]['quantity'] = $quantity;
							$object['issue_details'][$j][$k]['reason_name'] = $issue_reason;
							$object['issue_details'][$j][$k]['other_reason'] = $other_reason;
                            if ($issue_detail_temp['UNIT']=='L')
                              $issue_detail_temp['UNIT'] = 'ML';
                            if ($issue_detail_temp['UNIT']=='KG')
                              $issue_detail_temp['UNIT'] = 'G';
							$object['issue_details'][$j][$k]['uom'] = $issue_detail_temp['UNIT'];
							$k++;
						}

					}

				}

				$this->template->write_view('content', 'issue/issue_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Issue atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'issue/browse_result/0/0/0/0/0/0/0/10';
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
                    $issue_reason = $excel['cells'][$i][4];
					$other_reason = $excel['cells'][$i][5];


				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;

					   	$object['issue_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

							$object['issue_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['issue_headers'][$j]['id_issue_plant'] = $this->m_issue->id_issue_plant_new_select($object['issue_headers'][$j]['plant']);
							$object['issue_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['issue_headers'][$j]['status'] = '1';
							$object['issue_headers'][$j]['item_group_code'] = $item_group_code;
							$object['issue_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['issue_headers'][$j]['filename'] = $upload['file_name'];

						$id_issue_header = $this->m_issue->issue_header_insert($object['issue_headers'][$j]);

                       	$issue_header_exist = TRUE;
						$k = 1; // grpo_detail number

				}

				if($issue_header_exist) {

					if($issue_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                            $object['issue_details'][$j][$k]['id_issue_header'] = $id_issue_header;
						    $object['issue_details'][$j][$k]['id_issue_h_detail'] = $k;
							$object['issue_details'][$j][$k]['material_no'] = $material_no;
							$object['issue_details'][$j][$k]['material_desc'] = $issue_detail_temp['MAKTX'];
							$object['issue_details'][$j][$k]['quantity'] = $quantity;
							$object['issue_details'][$j][$k]['reason_name'] = $issue_reason;
							$object['issue_details'][$j][$k]['other_reason'] = $other_reason;
                            if ($issue_detail_temp['UNIT']=='L')
                              $issue_detail_temp['UNIT'] = 'ML';
                            if ($issue_detail_temp['UNIT']=='KG')
                              $issue_detail_temp['UNIT'] = 'G';
							$object['issue_details'][$j][$k]['uom'] = $issue_detail_temp['UNIT'];

//						$id_issue_detail = $this->m_issue->issue_detail_insert($object['issue_details'][$j][$k]);
    				    if($id_issue_detail = $this->m_issue->issue_detail_insert($object['issue_details'][$j][$k])) {

                           if(($quantity > 0)&&($item_boms = $this->m_sfgs->sfgs_details_select_by_item_sfg($material_no))) {
                             if($item_boms !== FALSE) {
                        		$l = 1;
                        		foreach ($item_boms->result_array() as $object['temp']) {
                        			foreach($object['temp'] as $key => $value) {
                        				$item_bom[$key][$l] = $value;
                        			}
                        			$l++;
                        			unset($object['temp']);
                        		}
                         	 }
                          	 $c_item_bom = count($item_bom['id_sfgs_h_detail']);
                			 for($m = 1; $m <= $c_item_bom; $m++) {
                               $issue_detail_bom['id_issue_h_detail_bom'] = $m;
                               $issue_detail_bom['id_issue_detail'] = $id_issue_detail;
                               $issue_detail_bom['id_issue_header'] = $id_issue_header;
                               $issue_detail_bom['material_no_sfg'] = $material_no;
                               $issue_detail_bom['material_no'] = $item_bom['material_no'][$m];
                               $issue_detail_bom['material_desc'] = $item_bom['material_desc'][$m];
                               $issue_detail_bom['quantity'] = ($item_bom['quantity'][$m]/$item_bom['quantity_sfg'][$m])*$quantity;
                               $issue_detail_bom['uom'] = $item_bom['uom'][$m];
         					   $this->m_issue->issue_detail_bom_insert($issue_detail_bom);
                             }
                          }
    				    }

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Issue berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['issue_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Waste Material atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'issue/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '011';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
	
	public function printpdf($id_issue_header)
	{
		//$this->load->model('m_gisto_pdf');
		$this->load->model('m_printissue');
		//$this->load->model('m_stdstock');
		//$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);
		$data['data'] = $this->m_printissue->tampil($id_issue_header);
		
		ob_start();
		//$content = $this->load->view('gisto_pdf',$data);
		$content = $this->load->view('issue',$data);
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

}
?>