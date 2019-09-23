<?php
class grfg extends Controller {
	private $jagmodule = array();


	function grfg() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1030);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grfg'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('l_form_validation');
		$this->load->model('m_grfg');
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
		$grfg_browse_result = $this->session->userdata['PAGE']['grfg_browse_result'];

		if(!empty($grfg_browse_result))
			redirect($this->session->userdata['PAGE']['grfg_browse_result']);
		else
			redirect('grfg/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('grfg/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grfg/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grfg_browse_result');

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

		$sort_link1 = 'grfg/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('grfg/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grfg->grfg_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grfg_headers'] = $this->m_grfg->grfg_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Goods Receipt FG Outlet  ';
		$this->template->write_view('content', 'grfg/grfg_browse', $object);
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

        $grfg_detail_tmp = array('grfg_detail' => '');
        $this->session->unset_userdata($grfg_detail_tmp);
        unset($grfg_detail_tmp);

    	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_grfg();

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
			redirect('grfg/input2/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Goods Receipt FG Outlet';
		$this->template->write_view('content', 'grfg/grfg_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['grfg_detail']['id_grfg_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['grfg_detail']['material_no'][$i], "grfg_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['grfg_detail']['gr_quantity'][$i], "grfg_detail[gr_quantity][$i]", 'gr_quantity No. '.$i, 'required|is_numeric_no_zero');

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
		$this->l_general->error_page($this->jagmodule, $error_text, $this->jagmodule, site_url($this->session->userdata['PAGE']['next']));
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
          $grfg_detail_tmp = array('grfg_detail' => '');
          $this->session->unset_userdata($grfg_detail_tmp);
          unset($grfg_detail_tmp);
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
			$data['items'] = $this->m_general->sap_item_groups_select_all_grfg();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grfg');
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
		  $object['data']['grfg_header'] = $_POST['grfg_header'];//$this->m_grfg->grfg_details_select($this->uri->segment(3));
		  $object['data']['grfg_detail'] = $_POST['grfg_detail'];//$this->m_grfg->grfg_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Goods Receipt FG Outlet';
		$this->template->write_view('content', 'grfg/grfg_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$grfg = $_POST;
		unset($grfg['grfg_header']['id_grfg_header']);
		unset($grfg['button']);
		// end of assign variables and delete not used variables

		$count = count($grfg['grfg_detail']['id_grfg_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grfg['grfg_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grfg/input_error/Anda belum memasukkan data detail. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('grfg', 1, date("Y-m-d")) {
        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grfg['grfg_header']['posting_date'])==FALSE)) {
     	   redirect('grfg/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$grfg_header['id_grfg_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('grfg_detail', $grfg['grfg_detail']);

    		$grfg_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grfg_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$grfg_header['posting_date'] = $this->m_general->posting_date_select_max($grfg_header['plant']);
 			$grfg_header['posting_date'] = $this->l_general->str_to_date($grfg['grfg_header']['posting_date']);
			$grfg_header['id_grfg_plant'] = $this->m_grfg->id_grfg_plant_new_select($grfg_header['plant'],$grfg_header['posting_date']);

			$grfg_header['grfg_no'] = '';

			if(isset($_POST['button']['approve']))
				$grfg_header['status'] = '2';
			else
				$grfg_header['status'] = '1';

			$grfg_header['item_group_code'] = $grfg['grfg_header']['item_group_code'];
			$grfg_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($grfg_header['plant'],$grfg_header['posting_date'],
                      $grfg_header['id_grfg_plant'],'10');
            //print '$web_trans_id'.$web_trans_id;
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grfg_to_approve = array (
                      'plant' => $grfg_header['plant'],
                      'posting_date' => date('Ymd',strtotime($grfg_header['posting_date'])),
                      'id_user_input' => $grfg_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $grfg_header['receiving_plant'],
                );
              }

			if($id_grfg_header = $this->m_grfg->grfg_header_insert($grfg_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($grfg['grfg_detail']['gr_quantity'][$i]))&&(!empty($grfg['grfg_detail']['material_no'][$i]))) {

						$grfg_detail['id_grfg_header'] = $id_grfg_header;
						$grfg_detail['gr_quantity'] = $grfg['grfg_detail']['gr_quantity'][$i];
						$grfg_detail['id_grfg_h_detail'] = $grfg['grfg_detail']['id_grfg_h_detail'][$i];

   						$item = $this->m_general->sap_item_select_by_item_code($grfg['grfg_detail']['material_no'][$i]);

  						$grfg_detail['material_no'] = $grfg['grfg_detail']['material_no'][$i];
  						$grfg_detail['material_desc'] = $grfg['grfg_detail']['material_desc'][$i];
  						$grfg_detail['uom'] = $grfg['grfg_detail']['uom'][$i];

                        //array utk parameter masukan pada saat approval
                        $grfg_to_approve['item'][$i] = $grfg_detail['id_grfg_h_detail'];
                        $grfg_to_approve['material_no'][$i] = $grfg_detail['material_no'];
                        $grfg_to_approve['gr_quantity'][$i] = $grfg_detail['gr_quantity'];
                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $grfg_to_approve['uom'][$i] = $grfg_detail['uom'];
                        } else {
                            $grfg_to_approve['uom'][$i] = $item['MEINS'];
                        }
                        //

						if($this->m_grfg->grfg_detail_insert($grfg_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			
			    $approved_data = $this->m_grfg->sap_grfg_header_approve($grfg_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grfg_no = $approved_data['matdocyear'];
    				$data = array (
    					'id_grfg_header'	=>$id_grfg_header,
    					'grfg_no'	=>	$grfg_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if ($this->m_grfg->grfg_header_update($data))
						$approve_data_success = TRUE;
					else
						$approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Goods Receipt FG di Outlet berhasil dimasukkan', site_url('grfg/input'));
              } else {
                $this->m_grfg->grfg_header_delete($id_grfg_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt FG di Outlet tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              
			  
			  if($approve_data_success === TRUE) {
                 if ($approved_data['item_failed'] == 0) {
    			   $this->l_general->success_page('Seluruh Data Goods Receipt FG di Outlet berhasil diapprove', site_url('grfg/input'));
                 } else {
    			   $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Sebagian Data Goods Receipt FG di Outlet berhasil diapprove '.' <br> '.
                   $approved_data['item_success'].' item berhasil di approve, <br> '.
                   $approved_data['item_failed'].' item gagal di approve. <br> '.
                   $approved_data['sap_messages'],
                   site_url($this->session->userdata['PAGE']['next']));
                 }
              } else {
                $this->m_grfg->grfg_header_delete($id_grfg_header);
				$this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt FG di Outlet tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }

	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt FG Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grfg/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt FG Outlet berhasil diapprove';
		$object['refresh_url'] = site_url('grfg/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt FG Outlet berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('grfg/input');
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
	    $grfg_header = $this->m_grfg->grfg_header_select($this->uri->segment(3));
		$status = $grfg_header['status'];
        unset($grfg_header);

        $grfg_detail_tmp = array('grfg_detail' => '');
        $this->session->unset_userdata($grfg_detail_tmp);
        unset($grfg_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['grfg_detail']['id_grfg_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['grfg_detail']['material_no'][$i], "grfg_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['grfg_detail']['gr_quantity'][$i], "grfg_detail[gr_quantity][$i]", 'gr_quantity No. '.$i, 'required|is_numeric_no_zero');

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
				$grfg_header = $this->m_grfg->grfg_header_select($this->uri->segment(3));

				if($grfg_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grfg_header'] = $this->m_grfg->grfg_header_select($this->uri->segment(3));
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
          $grfg_detail_tmp = array('grfg_detail' => '');
          $this->session->unset_userdata($grfg_detail_tmp);
          unset($grfg_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['grfg_header']['status_string'] = ($object['data']['grfg_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$receiving_plant = $data['grfg_header']['receiving_plant'];
		$item_group_code = $data['grfg_header']['item_group_code'];;
		$item_choose = $this->uri->segment(5);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['grfg_header']['item_group_code'];
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
//exit;

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_grfg();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'grfg');
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
			$object['data']['grfg_details'] = $this->m_grfg->grfg_details_select($object['data']['grfg_header']['id_grfg_header']);

			if($object['data']['grfg_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['grfg_details']->result_array() as $object['temp']) {
	//				$object['data']['grfg_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['grfg_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Goods Receipt FG Outlet';
		$this->template->write_view('content', 'grfg/grfg_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grfg = $_POST;
		unset($grfg['grfg_header']['id_grfg_header']);
		unset($grfg['button']);
		// end of assign variables and delete not used variables

		$count = count($grfg['grfg_detail']['id_grfg_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grfg['grfg_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grfg/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grfg['grfg_header']['posting_date'])==FALSE)) {
     	   redirect('grfg/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('grfg_detail', $grfg['grfg_detail']);

            $id_grfg_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($grfg['grfg_header']['posting_date']);
   			$id_grfg_plant = $this->m_grfg->id_grfg_plant_new_select("",$postingdate,$id_grfg_header);

    			$data = array (
    				'id_grfg_header' => $id_grfg_header,
                    'id_grfg_plant' => $id_grfg_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_grfg->grfg_header_update($data);
                $edit_grfg_header = $this->m_grfg->grfg_header_select($id_grfg_header);

    			if ($this->m_grfg->grfg_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_grfg->grfg_details_delete($id_grfg_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($grfg['grfg_detail']['gr_quantity'][$i]))&&(!empty($grfg['grfg_detail']['material_no'][$i]))) {

        						$grfg_detail['id_grfg_header'] = $id_grfg_header;
        						$grfg_detail['gr_quantity'] = $grfg['grfg_detail']['gr_quantity'][$i];
        						$grfg_detail['id_grfg_h_detail'] = $grfg['grfg_detail']['id_grfg_h_detail'][$i];

           						$item = $this->m_general->sap_item_select_by_item_code($grfg['grfg_detail']['material_no'][$i]);
        						$grfg_detail['material_no'] = $grfg['grfg_detail']['material_no'][$i];
        						$grfg_detail['material_desc'] = $grfg['grfg_detail']['material_desc'][$i];
        						$grfg_detail['uom'] = $grfg['grfg_detail']['uom'][$i];

                                //array utk parameter masukan pada saat approval
                                $grfg_to_approve['item'][$i] = $grfg_detail['id_grfg_h_detail'];
                                $grfg_to_approve['material_no'][$i] = $grfg_detail['material_no'];
                                $grfg_to_approve['gr_quantity'][$i] = $grfg_detail['gr_quantity'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $grfg_to_approve['uom'][$i] = $grfg_detail['uom'];
                                } else {
                                    $grfg_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                //

        						if($this->m_grfg->grfg_detail_insert($grfg_detail))
                                  $input_detail_success = TRUE;
        					}

               	    	}
                    }
                }

            $this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grfg_to_approve['posting_date'] = date('Ymd',strtotime($edit_grfg_header['posting_date']));
                $grfg_to_approve['plant'] = $edit_grfg_header['plant'];
                $grfg_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grfg_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grfg_header['plant'],$edit_grfg_header['posting_date'],
                $edit_grfg_header['id_grfg_plant'],'10');
			    $approved_data = $this->m_grfg->sap_grfg_header_approve($grfg_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grfg_no = $approved_data['matdocyear'];
    				$data = array (
    					'id_grfg_header' =>$id_grfg_header,
    					'grfg_no'	=>	$grfg_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grfg_header_update_status = $this->m_grfg->grfg_header_update($data);
					if ($grfg_header_update_status)
						$approve_data_success = TRUE;
					else
						$approve_data_success = FALSE;

				} else {
				  $approve_data_success = FALSE;
				}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt FG Outlet  berhasil diubah', site_url('grfg/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt FG Outlet tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
                 if ($approved_data['item_failed'] == 0) {
    			   $this->l_general->success_page('Seluruh Data Goods Receipt FG di Outlet berhasil diapprove', site_url('grfg/input'));
                 } else {
    			   $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Sebagian Data Goods Receipt FG di Outlet berhasil diapprove '.' <br> '.
                   $approved_data['item_success'].' item berhasil di approve, <br> '.
                   $approved_data['item_failed'].' item gagal di approve. <br> '.
                   $approved_data['sap_messages'],
                   site_url($this->session->userdata['PAGE']['next']));
                 }

              } else {
			  $this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt FG Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grfg/browse';
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
		$grfg = $_POST;
		unset($grfg['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?


        $date_today = date('d-m-Y');
		if($grfg['grfg_header']['posting_date']!=$date_today) {
			redirect('grfg/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grfg['cancel'])) {
            $quantity_exist = FALSE;
    	} else {
    		$quantity_exist = TRUE;
    	}
		if($quantity_exist == FALSE)
			redirect('grfg/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grfg', 1, date("Y-m-d")) {

        $edit_grfg_header = $this->m_grfg->grfg_header_select($grfg['grfg_header']['id_grfg_header']);
		$edit_grfg_details = $this->m_grfg->grfg_details_select($grfg['grfg_header']['id_grfg_header']);
    	$i = 1;
	    foreach ($edit_grfg_details->result_array() as $value) {
		    $edit_grfg_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grfg_details);

		if(isset($_POST['button']['cancel'])) {

//			$grfg_header['id_grfg_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $grfg_to_cancel['grfg_no'] = $edit_grfg_header['grfg_no'];
            $grfg_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grfg_header['posting_date']));
            $grfg_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grfg_header['posting_date']));
            $grfg_to_cancel['plant'] = $edit_grfg_header['plant'];
			$grfg_to_cancel['id_grfg_plant'] = $this->m_grfg->id_grfg_plant_new_select($edit_grfg_header['plant'],date('Y-m-d',strtotime($edit_grfg_header['posting_date'])));
            $grfg_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grfg_header['plant'],$edit_grfg_header['posting_date'],
                      $grfg_to_cancel['id_grfg_plant'],'10');
            $grfg_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grfg_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grfg['cancel'][$i])) {
       		     $grfg_to_cancel['doc_in'][$i] = $edit_grfg_detail[$i]['material_docno_approval'];
       		     $grfg_to_cancel['year_in'][$i] = $grfg_to_cancel['mat_doc_year'];
               }
            }
            $cancelled_data = $this->m_grfg->sap_grfg_header_cancel($grfg_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
                $doc_out = $cancelled_data['doc_out'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grfg['cancel'][$i])) {
    	    			$grfg_header = array (
    						'id_grfg_header'=>$grfg['grfg_header']['id_grfg_header'],
    						'id_grfg_plant'=>$grfg_to_cancel['id_grfg_plant'],
    					);
    		    		if(($this->m_grfg->grfg_header_update($grfg_header)==TRUE)&&($doc_out[$i]['ERRORX']!='X')) {
        	    			$grfg_detail = array (
        						'id_grfg_header'=>$grfg['grfg_header']['id_grfg_header'],
        						'material_docno_approval'=>$edit_grfg_detail[$i]['material_docno_approval'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$doc_out[$i]['DOC_OUT'],
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grfg->grfg_detail_update_by_mat_doc_approval($grfg_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
                 if ($cancelled_data['doc_failed'] == 0) {
    			   $this->l_general->success_page('Seluruh Data Goods Receipt FG Outlet  berhasil dibatalkan ', site_url('grfg/browse'));
                 } else {
    			   $this->jagmodule['error_code'] = '009'; 
		$this->l_general->error_page($this->jagmodule, 'Sebagian Data Goods Receipt FG Outlet  berhasil dibatalkan '.' <br> '.
                   $cancelled_data['doc_success'].' item berhasil di dibatalkan, <br> '.
                   $cancelled_data['doc_failed'].' item gagal di dibatalkan. <br> '.
                   $cancelled_data['sap_messages'],
                   site_url($this->session->userdata['PAGE']['next']));
                 }
            } else {
				$this->jagmodule['error_code'] = '010'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt FG Outlet tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt FG Outlet tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grfg_header) {

		$this->db->trans_start();

		// check approve status
		$grfg_header = $this->m_grfg->grfg_header_select($id_grfg_header);

		if($grfg_header['status'] == '1') {
			$this->m_grfg->grfg_header_delete($id_grfg_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_grfg_header) {

		if($this->_delete($id_grfg_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt FG Outlet berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grfg_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt FG Outlet gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grfg_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '011';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grfg_header']))
			redirect($this->session->userdata['PAGE']['grfg_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grfg_header'][$i])) {
				$object['data']['grfg_headers'][$j++] = $this->m_grfg->grfg_header_select($_POST['id_grfg_header'][$i]);
			}
		}

		$this->template->write_view('content', 'grfg/grfg_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grfg_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt FG Outlet berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grfg_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grfg_data';
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
            $file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

		 	if($excel['cells'][1][1] == 'Goods Receipt FG. No' && $excel['cells'][1][2] == 'Material No.') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$item_group_code = 'all';
                   	$material_no =  $excel['cells'][$i][2];
					$gr_quantity = $excel['cells'][$i][3];

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;

                             if($grfg_header_temp = $this->m_general->sap_item_groups_select_all_grfg()) {
							$object['grfg_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grfg_headers'][$j]['grfg_no'] = $excel['cells'][$i][1];
                           $object['grfg_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grfg_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grfg_headers'][$j]['status'] = '1';
							$object['grfg_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grfg_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grfg_headers'][$j]['filename'] = $upload['file_name'];

            	$grfg_header_exist = TRUE;
							$k = 1; // grpo_detail number
                            } else {
           	$grfg_header_exist = FALSE;
					}

					}

					if($grfg_header_exist) {

                           if ($grfg_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
						    $object['grfg_details'][$j][$k]['id_grfg_header'] = $id_grfg_header;
							$object['grfg_details'][$j][$k]['id_grfg_h_detail'] = $k;
							$object['grfg_details'][$j][$k]['material_no'] = $material_no;
                    		$object['grfg_details'][$j][$k]['material_desc'] = $grfg_detail_temp['MAKTX'];
							$object['grfg_details'][$j][$k]['gr_quantity'] = $gr_quantity;

                            $uom_import = $grfg_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
                			$object['grfg_details'][$j][$k]['uom'] = $uom_import;

							$k++;
                          }

					}

				}

				$this->template->write_view('content', 'grfg/grfg_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt FG Outlet atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grfg/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '012';
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
	   	if($excel['cells'][1][1] == 'Goods Receipt FG. No' && $excel['cells'][1][2] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

			  	$item_group_code = 'all';
                   	$material_no =  $excel['cells'][$i][2];
					$gr_quantity = $excel['cells'][$i][3];



				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
                        if($grfg_header_temp = $this->m_general->sap_item_groups_select_all_grfg()) {
					   	$object['grfg_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                          $object['grfg_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
						  $object['grfg_headers'][$j]['id_grfg_plant'] = $this->m_grfg->id_grfg_plant_new_select($object['grfg_headers'][$j]['plant'],$object['grfg_headers'][$j]['posting_date']);
							$object['grfg_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grfg_headers'][$j]['status'] = '1';
							$object['grfg_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grfg_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grfg_headers'][$j]['filename'] = $upload['file_name'];

						$id_grfg_header = $this->m_grfg->grfg_header_insert($object['grfg_headers'][$j]);

           	$grfg_header_exist = TRUE;
						$k = 1; // grpo_detail number

                       } else {
           	$grfg_header_exist = FALSE;
					}
				}

				if($grfg_header_exist) {


                        if ($grfg_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
						$object['grfg_details'][$j][$k]['id_grfg_header'] = $id_grfg_header;
						$object['grfg_details'][$j][$k]['id_grfg_h_detail'] = $k;
						$object['grfg_details'][$j][$k]['material_no'] = $material_no;
                        $object['grfg_details'][$j][$k]['material_desc'] = $grfg_detail_temp['MAKTX'];
						$object['grfg_details'][$j][$k]['gr_quantity'] = $gr_quantity;

                        $uom_import = $grfg_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['grfg_details'][$j][$k]['uom'] = $uom_import;


						$id_grfg_detail = $this->m_grfg->grfg_detail_insert($object['grfg_details'][$j][$k]);

						$k++;
                }

           	}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt FG Outlet  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grfg_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt FG Outlet atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grfg/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '013';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
}

?>