<?php
class grnonpo extends Controller {
	private $jagmodule = array();


	function grnonpo() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1031);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grnonpo'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('l_form_validation');
		$this->load->model('m_grnonpo');
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
		$grnonpo_browse_result = $this->session->userdata['PAGE']['grnonpo_browse_result'];

		if(!empty($grnonpo_browse_result))
			redirect($this->session->userdata['PAGE']['grnonpo_browse_result']);
		else
			redirect('grnonpo/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('grnonpo/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grnonpo/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grnonpo_browse_result');

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

		$sort_link1 = 'grnonpo/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('grnonpo/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grnonpo->grnonpo_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grnonpo_headers'] = $this->m_grnonpo->grnonpo_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Goods Receipt Non PO  ';
		$this->template->write_view('content', 'grnonpo/grnonpo_browse', $object);
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

        $grnonpo_detail_tmp = array('grnonpo_detail' => '');
        $this->session->unset_userdata($grnonpo_detail_tmp);
        unset($grnonpo_detail_tmp);

    	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_grnonpo();

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
			redirect('grnonpo/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Goods Receipt Non PO';
		$this->template->write_view('content', 'grnonpo/grnonpo_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['grnonpo_detail']['id_grnonpo_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['grnonpo_detail']['material_no'][$i], "grnonpo_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['grnonpo_detail']['quantity'][$i], "grnonpo_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
          $grnonpo_detail_tmp = array('grnonpo_detail' => '');
          $this->session->unset_userdata($grnonpo_detail_tmp);
          unset($grnonpo_detail_tmp);
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
			$data['items'] = $this->m_general->sap_item_groups_select_all_grnonpo();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grnonpo');
		}
//exit;

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR'].' ('.$data['item']['UNIT'].')';
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
		  $object['data']['grnonpo_header'] = $_POST['grnonpo_header'];//$this->m_grnonpo->grnonpo_details_select($this->uri->segment(3));
		  $object['data']['grnonpo_detail'] = $_POST['grnonpo_detail'];//$this->m_grnonpo->grnonpo_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Goods Receipt Non PO';
		$this->template->write_view('content', 'grnonpo/grnonpo_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$grnonpo = $_POST;
		unset($grnonpo['grnonpo_header']['id_grnonpo_header']);
		unset($grnonpo['button']);
		// end of assign variables and delete not used variables

		$count = count($grnonpo['grnonpo_detail']['id_grnonpo_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grnonpo['grnonpo_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('grnonpo/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grnonpo['grnonpo_header']['posting_date'])==FALSE)) {
     	   redirect('grnonpo/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$grnonpo_header['id_grnonpo_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('grnonpo_detail', $grnonpo['grnonpo_detail']);

    		$grnonpo_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grnonpo_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
    		$grnonpo_header['cost_center'] = $this->session->userdata['ADMIN']['cost_center'];
// 			$grnonpo_header['posting_date'] = $this->m_general->posting_date_select_max($grnonpo_header['plant']);
 			$grnonpo_header['posting_date'] = $this->l_general->str_to_date($grnonpo['grnonpo_header']['posting_date']);
			$grnonpo_header['id_grnonpo_plant'] = $this->m_grnonpo->id_grnonpo_plant_new_select($grnonpo_header['plant'],$grnonpo_header['posting_date']);

			$grnonpo_header['grnonpo_no'] = '';

			if(isset($_POST['button']['approve']))
				$grnonpo_header['status'] = '2';
			else
				$grnonpo_header['status'] = '1';

			$grnonpo_header['item_group_code'] = $grnonpo['grnonpo_header']['item_group_code'];
			$grnonpo_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];


            $web_trans_id = $this->l_general->_get_web_trans_id($grnonpo_header['plant'],$grnonpo_header['posting_date'],
                      $grnonpo_header['id_grnonpo_plant'],'07');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grnonpo_to_approve = array (
                      'plant' => $grnonpo_header['plant'],
                      'posting_date' => date('Ymd',strtotime($grnonpo_header['posting_date'])),
                      'id_user_input' => $grnonpo_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $grnonpo_header['receiving_plant'],
                );
              }

			if($id_grnonpo_header = $this->m_grnonpo->grnonpo_header_insert($grnonpo_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($grnonpo['grnonpo_detail']['quantity'][$i]))&&(!empty($grnonpo['grnonpo_detail']['material_no'][$i]))) {

						$grnonpo_detail['id_grnonpo_header'] = $id_grnonpo_header;
						$grnonpo_detail['quantity'] = $grnonpo['grnonpo_detail']['quantity'][$i];
						$grnonpo_detail['id_grnonpo_h_detail'] = $grnonpo['grnonpo_detail']['id_grnonpo_h_detail'][$i];
						$grnonpo_detail['additional_text'] = $grnonpo['grnonpo_detail']['additional_text'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($grnonpo['grnonpo_detail']['material_no'][$i]);

  						$grnonpo_detail['material_no'] = $grnonpo['grnonpo_detail']['material_no'][$i];
						$grnonpo_detail['material_desc'] = $grnonpo['grnonpo_detail']['material_desc'][$i];
  						$grnonpo_detail['uom'] = $grnonpo['grnonpo_detail']['uom'][$i];
						
						//create batchnumber
						$batch['BaseEntry'] = $id_grnonpo_header;
						$batch['BaseLinNum'] = $grnonpo['grnonpo_detail']['id_grnonpo_h_detail'][$i];
						$batch['ItemCode'] =  $grnonpo['grnonpo_detail']['material_no'][$i];
						$batchMaster['ItemCode'] =  $grnonpo['grnonpo_detail']['material_no'][$i];
						$item= $grnonpo['grnonpo_detail']['material_no'][$i];
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
						//$this->m_database->get_database();
						$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
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
						$batchMaster['DistNumber'] = $num;
						$batch['Createdate'] = $this->l_general->str_to_date($grnonpo['grnonpo_header']['posting_date']);
						$batch['BaseType'] = 202;
						$batch['Quantity'] =  $grnonpo['grnonpo_detail']['quantity'][$i];
						$batchMaster['Quantity'] =  $grnonpo['grnonpo_detail']['quantity'][$i];
						$batchMaster['Whs'] = $whs;
						
                        //array utk parameter masukan pada saat approval
                        $grnonpo_to_approve['item'][$i] = $grnonpo_detail['id_grnonpo_h_detail'];
                        $grnonpo_to_approve['material_no'][$i] = $grnonpo_detail['material_no'];
                        $grnonpo_to_approve['quantity'][$i] = $grnonpo_detail['quantity'];
                       if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $grnonpo_to_approve['uom'][$i] = $grnonpo_detail['uom'];
                        } else {
                            $grnonpo_to_approve['uom'][$i] = $item['MEINS'];
                        }
                        $grnonpo_to_approve['additional_text'][$i] = $grnonpo_detail['additional_text'];
                        //
						
						if ($b == 'Y' && (isset($_POST['button']['approve'])))
						{
						//echo "<br>$batch[BaseEntry], $batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[BaseType] , ($b),$cek";
						 $this->m_grnonpo->batch_insert($batch);
						  //$this->m_grnonpo->batch_master($batchMaster);
						
						}
						
						mysql_close($con);
						if($this->m_grnonpo->grnonpo_detail_insert($grnonpo_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    //$approved_data = $this->m_grnonpo->sap_grnonpo_header_approve($grnonpo_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grnonpo_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_grnonpo_header'	=>$id_grnonpo_header,
    					'grnonpo_no'	=>	$grnonpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grnonpo->grnonpo_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Goods Receipt Non PO berhasil dimasukkan', site_url('grnonpo/input'));
              } else {
                $this->m_grnonpo->grnonpo_header_delete($id_grnonpo_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt Non PO tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
 			    
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Goods Receipt Non PO berhasil diapprove', site_url('grnonpo/input'));
              } else {
                $this->m_grnonpo->grnonpo_header_delete($id_grnonpo_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt Non PO tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));

            }

		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Non PO tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grnonpo/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Non PO berhasil diapprove';
		$object['refresh_url'] = site_url('grnonpo/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Non PO berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('grnonpo/input');
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
	    $grnonpo_header = $this->m_grnonpo->grnonpo_header_select($this->uri->segment(3));
		$status = $grnonpo_header['status'];
        unset($grnonpo_header);

        $grnonpo_detail_tmp = array('grnonpo_detail' => '');
        $this->session->unset_userdata($grnonpo_detail_tmp);
        unset($grnonpo_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['grnonpo_detail']['id_grnonpo_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['grnonpo_detail']['material_no'][$i], "grnonpo_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['grnonpo_detail']['quantity'][$i], "grnonpo_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
				$grnonpo_header = $this->m_grnonpo->grnonpo_header_select($this->uri->segment(3));

				if($grnonpo_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grnonpo_header'] = $this->m_grnonpo->grnonpo_header_select($this->uri->segment(3));
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
          $grnonpo_detail_tmp = array('grnonpo_detail' => '');
          $this->session->unset_userdata($grnonpo_detail_tmp);
          unset($grnonpo_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['grnonpo_header']['status_string'] = ($object['data']['grnonpo_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_grnonpo_header = $data['grnonpo_header']['id_grnonpo_header'];
		$receiving_plant = $data['grnonpo_header']['receiving_plant'];
		$item_group_code = $data['grnonpo_header']['item_group_code'];;
		$item_choose = $this->uri->segment(5);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['grnonpo_header']['item_group_code'];
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
		
		$object['grnonpo_header']['id_grnonpo_header'] = $id_grnonpo_header;
		$object['receiving_plant'] = $this->m_general->sap_plant_select($receiving_plant);
//exit;

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_grnonpo();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grnonpo');
		}

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR'].' ('.$data['item']['UNIT'].')';
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
			$object['data']['grnonpo_details'] = $this->m_grnonpo->grnonpo_details_select($object['data']['grnonpo_header']['id_grnonpo_header']);

			if($object['data']['grnonpo_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['grnonpo_details']->result_array() as $object['temp']) {
	//				$object['data']['grnonpo_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['grnonpo_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Goods Receipt Non PO';
		$this->template->write_view('content', 'grnonpo/grnonpo_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grnonpo = $_POST;
		unset($grnonpo['grnonpo_header']['id_grnonpo_header']);
		unset($grnonpo['button']);
		// end of assign variables and delete not used variables

		$count = count($grnonpo['grnonpo_detail']['id_grnonpo_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grnonpo['grnonpo_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('grnonpo/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grnonpo['grnonpo_header']['posting_date'])==FALSE)) {
     	   redirect('grnonpo/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('grnonpo_detail', $grnonpo['grnonpo_detail']);

            $id_grnonpo_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($grnonpo['grnonpo_header']['posting_date']);
   			$id_grnonpo_plant = $this->m_grnonpo->id_grnonpo_plant_new_select("",$postingdate,$id_grnonpo_header);

    			$data = array (
    				'id_grnonpo_header' => $id_grnonpo_header,
                    'id_grnonpo_plant' => $id_grnonpo_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_grnonpo->grnonpo_header_update($data);
                $edit_grnonpo_header = $this->m_grnonpo->grnonpo_header_select($id_grnonpo_header);

    			if ($this->m_grnonpo->grnonpo_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_grnonpo->grnonpo_details_delete($id_grnonpo_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($grnonpo['grnonpo_detail']['quantity'][$i]))&&(!empty($grnonpo['grnonpo_detail']['material_no'][$i]))) {

        						$grnonpo_detail['id_grnonpo_header'] = $id_grnonpo_header;
        						$grnonpo_detail['quantity'] = $grnonpo['grnonpo_detail']['quantity'][$i];
        						$grnonpo_detail['id_grnonpo_h_detail'] = $grnonpo['grnonpo_detail']['id_grnonpo_h_detail'][$i];
        						$grnonpo_detail['additional_text'] = $grnonpo['grnonpo_detail']['additional_text'][$i];

        						$item = $this->m_general->sap_item_select_by_item_code($grnonpo['grnonpo_detail']['material_no'][$i]);

        						$grnonpo_detail['material_no'] = $grnonpo['grnonpo_detail']['material_no'][$i];
        						$grnonpo_detail['material_desc'] = $grnonpo['grnonpo_detail']['material_desc'][$i];
        						$grnonpo_detail['uom'] = $grnonpo['grnonpo_detail']['uom'][$i];
								
								//create batchnumber
								$batch['BaseEntry'] = $id_grnonpo_header;
								$batch['BaseLinNum'] = $grnonpo['grnonpo_detail']['id_grnonpo_h_detail'][$i];
								$batch['ItemCode'] =  $grnonpo['grnonpo_detail']['material_no'][$i];
								$batchMaster['ItemCode'] =  $grnonpo['grnonpo_detail']['material_no'][$i];
								$item= $grnonpo['grnonpo_detail']['material_no'][$i];
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
								//$this->m_database->get_database();
								$q="SELECT * FROM m_batch WHERE ItemCode = '$item' AND Whs ='$whs'";
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
								$batchMaster['DistNumber'] = $num;
								$batch['Createdate'] = $this->l_general->str_to_date($grnonpo['grnonpo_header']['posting_date']);
								$batch['BaseType'] = 202;
								$batch['Quantity'] =  $grnonpo['grnonpo_detail']['quantity'][$i];
								$batchMaster['Quantity'] =  $grnonpo['grnonpo_detail']['quantity'][$i];
								$batchMaster['Whs'] = $whs;

                                //array utk parameter masukan pada saat approval
                                $grnonpo_to_approve['item'][$i] = $grnonpo_detail['id_grnonpo_h_detail'];
                                $grnonpo_to_approve['material_no'][$i] = $grnonpo_detail['material_no'];
                                $grnonpo_to_approve['quantity'][$i] = $grnonpo_detail['quantity'];
                               if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $grnonpo_to_approve['uom'][$i] = $grnonpo_detail['uom'];
                                } else {
                                    $grnonpo_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                $grnonpo_to_approve['additional_text'][$i] = $grnonpo_detail['additional_text'];
                                //
								
								if ($b == 'Y' && (isset($_POST['button']['approve'])))
								{
								//echo "<br>$batch[BaseEntry], $batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[BaseType] , ($b),$cek";
								 $this->m_grnonpo->batch_insert($batch);
								 //$this->m_grnonpo->batch_master($batchMaster);
								
								}
								mysql_close($con);

        						if($this->m_grnonpo->grnonpo_detail_insert($grnonpo_detail))
                                  $input_detail_success = TRUE;
        					}

               	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grnonpo_to_approve['posting_date'] = date('Ymd',strtotime($edit_grnonpo_header['posting_date']));
                $grnonpo_to_approve['plant'] = $edit_grnonpo_header['plant'];
                $grnonpo_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grnonpo_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grnonpo_header['plant'],$edit_grnonpo_header['posting_date'],
                      $edit_grnonpo_header['id_grnonpo_plant'],'07');
			    //$approved_data = $this->m_grnonpo->sap_grnonpo_header_approve($grnonpo_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grnonpo_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_grnonpo_header' =>$id_grnonpo_header,
    					'grnonpo_no'	=>	$grnonpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grnonpo_header_update_status = $this->m_grnonpo->grnonpo_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt Non PO berhasil diubah', site_url('grnonpo/browse'));
              } else {
    	      $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt Non PO tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt Non PO berhasil diapprove', site_url('grnonpo/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt Non PO tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

/*	function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grnonpo/browse';
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
		$grnonpo = $_POST;
		unset($grnonpo['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($grnonpo['grnonpo_header']['posting_date']!=$date_today) {
			redirect('grnonpo/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grnonpo['cancel'])) {
            $quantity_exist = FALSE;
    	} else {
    		$quantity_exist = TRUE;
    	}

		if($quantity_exist == FALSE)
			redirect('grnonpo/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grnonpo', 1, date("Y-m-d")) {

        $edit_grnonpo_header = $this->m_grnonpo->grnonpo_header_select($grnonpo['grnonpo_header']['id_grnonpo_header']);
		$edit_grnonpo_details = $this->m_grnonpo->grnonpo_details_select($grnonpo['grnonpo_header']['id_grnonpo_header']);
    	$i = 1;
	    foreach ($edit_grnonpo_details->result_array() as $value) {
		    $edit_grnonpo_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grnonpo_details);

		if(isset($_POST['button']['cancel'])) {

//			$grnonpo_header['id_grnonpo_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $grnonpo_to_cancel['grnonpo_no'] = $edit_grnonpo_header['grnonpo_no'];
            $grnonpo_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grnonpo_header['posting_date']));
            $grnonpo_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grnonpo_header['posting_date']));
            $grnonpo_to_cancel['plant'] = $edit_grnonpo_header['plant'];
			$grnonpo_to_cancel['id_grnonpo_plant'] = $this->m_grnonpo->id_grnonpo_plant_new_select($edit_grnonpo_header['plant'],date('Y-m-d',strtotime($edit_grnonpo_header['posting_date'])));
            $grnonpo_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grnonpo_header['plant'],$edit_grnonpo_header['posting_date'],
                      $grnonpo_to_cancel['id_grnonpo_plant'],'07');
            $grnonpo_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grnonpo_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grnonpo['cancel'][$i]))
       		     $grnonpo_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_grnonpo->sap_grnonpo_header_cancel($grnonpo_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grnonpo['cancel'][$i])) {
    	    			$grnonpo_header = array (
    						'id_grnonpo_header'=>$grnonpo['grnonpo_header']['id_grnonpo_header'],
    						'id_grnonpo_plant'=>$grnonpo_to_cancel['id_grnonpo_plant'],
    					);
    		    		if($this->m_grnonpo->grnonpo_header_update($grnonpo_header)==TRUE) {
        	    			$grnonpo_detail = array (
        						'id_grnonpo_detail'=>$edit_grnonpo_detail[$i]['id_grnonpo_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grnonpo->grnonpo_detail_update($grnonpo_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			$this->l_general->success_page('Data Goods Receipt Non PO berhasil dibatalkan', site_url('grnonpo/browse'));
            } else {
			$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt Non PO tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            } 

		}
	}

/*	function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Non PO tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grnonpo_header) {

		$this->db->trans_start();

		// check approve status
		$grnonpo_header = $this->m_grnonpo->grnonpo_header_select($id_grnonpo_header);

		if($grnonpo_header['status'] == '1') {
			$this->m_grnonpo->grnonpo_header_delete($id_grnonpo_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_grnonpo_header) {

		if($this->_delete($id_grnonpo_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt Non PO berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grnonpo_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt Non PO gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grnonpo_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grnonpo_header']))
			redirect($this->session->userdata['PAGE']['grnonpo_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grnonpo_header'][$i])) {
				$object['data']['grnonpo_headers'][$j++] = $this->m_grnonpo->grnonpo_header_select($_POST['id_grnonpo_header'][$i]);
			}
		}

		$this->template->write_view('content', 'grnonpo/grnonpo_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grnonpo_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Non PO berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grnonpo_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grnonpo_data';
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
			if($excel['cells'][1][1] == 'Goods Receipt No' && $excel['cells'][1][2] == 'Material No.') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$item_group_code = 'all';
					$material_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];
					$additional_text = $excel['cells'][$i][4];

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
                           if($grnonpo_header_temp = $this->m_general->sap_item_groups_select_all_grnonpo()) {
							$object['grnonpo_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grnonpo_headers'][$j]['grnonpo_no'] = $excel['cells'][$i][1];
                            $object['grnonpo_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grnonpo_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grnonpo_headers'][$j]['status'] = '1';
							$object['grnonpo_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grnonpo_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grnonpo_headers'][$j]['filename'] = $upload['file_name'];

            	$grnonpo_header_exist = TRUE;
							$k = 1; // grpo_detail number
                          } else {
           	$grpo_header_exist = FALSE;
					}
						}


					if($grnonpo_header_exist) {


                         if ($grnonpo_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
                      		$object['grnonpo_details'][$j][$k]['id_grnonpo_h_detail'] = $k;
							$object['grnonpo_details'][$j][$k]['material_no'] = $material_no;
                            $object['grnonpo_details'][$j][$k]['quantity'] = $quantity;
                             $object['grnonpo_details'][$j][$k]['additional_text'] = $text;

							$object['grnonpo_details'][$j][$k]['material_desc'] = $grnonpo_detail_temp['MAKTX'];
                            $object['grnonpo_details'][$j][$k]['uom'] = $grnonpo_detail_temp['UNIT'];
							$k++;

                     }

                      }

				}

				$this->template->write_view('content', 'grnonpo/grnonpo_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt Non PO atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grnonpo/browse_result/0/0/0/0/0/0/0/10';
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
		if($excel['cells'][1][1] == 'Goods Receipt No' && $excel['cells'][1][2] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

			  	$item_group_code = 'all';
					$material_no =  $excel['cells'][$i][2];
					$quantity = $excel['cells'][$i][3];
					$additional_text = $excel['cells'][$i][4];

				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
                         if($grnonpo_header_temp = $this->m_general->sap_item_groups_select_all_grnonpo()) {
					   	$object['grnonpo_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                        	$object['grnonpo_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grnonpo_headers'][$j]['id_grnonpo_plant'] = $this->m_grnonpo->id_grnonpo_plant_new_select($object['grnonpo_headers'][$j]['plant'],$object['grnonpo_headers'][$j]['posting_date']);
							$object['grnonpo_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grnonpo_headers'][$j]['status'] = '1';
							$object['grnonpo_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grnonpo_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grnonpo_headers'][$j]['filename'] = $upload['file_name'];

						$id_grnonpo_header = $this->m_grnonpo->grnonpo_header_insert($object['grnonpo_headers'][$j]);

           	$grnonpo_header_exist = TRUE;
						$k = 1; // grpo_detail number
                           	} else {
           	$grpo_header_exist = FALSE;
					}

					}


				if($grnonpo_header_exist) {


                            if ($grnonpo_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
							$object['grnonpo_details'][$j][$k]['id_grnonpo_header'] = $id_grnonpo_header;
						$object['grnonpo_details'][$j][$k]['id_grnonpo_h_detail'] = $k;

							$object['grnonpo_details'][$j][$k]['material_no'] = $material_no;
                            $object['grnonpo_details'][$j][$k]['quantity'] = $quantity;
                            $object['grnonpo_details'][$j][$k]['additional_text'] = $text;
                            $object['grnonpo_details'][$j][$k]['material_desc'] = $grnonpo_detail_temp['MAKTX'];
                            $object['grnonpo_details'][$j][$k]['uom'] = $grnonpo_detail_temp['UNIT'];


						$id_grnonpo_detail = $this->m_grnonpo->grnonpo_detail_insert($object['grnonpo_details'][$j][$k]);

						$k++;

                    }
				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt Non PO  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grnonpo_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt Non PO atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grnonpo/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
		}

	}
}
?>