<?php
class utensil extends Controller {
	private $jagmodule = array();


	function utensil() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1057);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_utensil'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->library('l_general');
		$this->load->model('m_general');
		$this->load->model('m_utensil');

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
		$utensil_browse_result = $this->session->userdata['PAGE']['utensil_browse_result'];

		if(!empty($utensil_browse_result))
			redirect($this->session->userdata['PAGE']['utensil_browse_result']);
		else
			redirect('utensil/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('utensil/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('utensil/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('utensil_browse_result');

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

		$sort_link1 = 'utensil/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('utensil/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_utensil->utensil_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['utensil_headers'] = $this->m_utensil->utensil_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2,  $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Request untuk Utensil';
		$this->template->write_view('content', 'utensil/utensil_browse', $object);
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
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $utensil_detail_tmp = array('utensil_detail' => '');
        $this->session->unset_userdata($utensil_detail_tmp);
        unset($utensil_detail_tmp);

    	$object['request_reasons'][0] = '';
//    	$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Utensil'] = 'Utensil';

		if(!empty($data['request_reason'])) {
        	$data['item_groups'] = $this->m_general->sap_item_groups_select_all_utensil($this->get_request_reason_1($data['request_reason']));

        	if($data['item_groups'] !== FALSE) {
        		$object['item_group_code'][0] = '';
        		$object['item_group_code']['all'] = '==All==';

        		foreach ($data['item_groups'] as $item_group) {
        			$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
        		}
        	}
        }

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('utensil/input2/'.$data['request_reason'].'/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Request untuk Utensil';
		$this->template->write_view('content', 'utensil/utensil_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

//echo "<pre>";
//print '$_POST ';
//print_r($_POST);
//echo "</pre>";

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['utensil_detail']['id_utensil_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['material_no'][$i], "utensil_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['requirement_qty'][$i], "utensil_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

                    if (!empty($_POST['utensil_detail']['requirement_qty'][$i])&&($_POST['utensil_detail']['requirement_qty'][$i]>0)) {
                        $date1 =  $this->l_general->str_to_date($_POST['utensil_detail']['delivery_date'][$i]);
                        $date2 = $this->l_general->str_to_date($_POST['utensil_header']['created_date']);
                        $datediff = $this->l_general->dateDiff($date1,$date2,'DAY');
       					$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['lead_time'][$i], "utensil_detail[delivery_date][$i]", 'Delivery Date. '.$i, 'valid_lead_time;'.$datediff);

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
          $utensil_detail_tmp = array('utensil_detail' => '');
          $this->session->unset_userdata($utensil_detail_tmp);
          unset($utensil_detail_tmp);
        }

      $object['data']['utensil_header']['status_string'] = ($_POST['utensil_header']['status'] == '2') ? 'Approved' : 'Not Approved';

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
    	$object['request_reasons']['Utensil'] = 'Utensil';

		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_utensil($this->get_request_reason_1($request_reason));
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, $request_reason);
		}

//exit;

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';
            $i = 1;
			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR1'].' ('.$data['item']['UNIT'].')';
				}
                $item_to_display[$i] = $data['item']['MATNR'];
                $i++;
			}
		}
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }

		if(($this->uri->segment(2) == 'input2')&&(!isset($_POST['button']['add']))&&(!isset($_POST['delete']))&&(empty($check))) {
		   $count = count($item_to_display);
           $k = 1;
           for ($i=1;$i<=$count;$i++) {
             if(!in_array($item_to_display[$i],$object['data']['utensil_detail']['material_no'])) {
               $object['data']['utensil_detail']['id_utensil_h_detail'][$k] = $i;
               $object['data']['utensil_detail']['material_no'][$k] = $item_to_display[$i];
               $item_lead_time[$k] = $this->m_utensil->sap_item_lead_time_select($item_to_display[$i]);
               $object['data']['utensil_detail']['lead_time'][$k] = $item_lead_time[$k]['LEAD_TIME'];
			   
//			   echo $item_to_display[$i]."=".$object['data']['utensil_detail']['lead_time'][$k]."<br />";
               $delivery_date = $this->l_general->date_add_day(date('d-m-Y',strtotime($this->m_general->posting_date_select_max())),$object['data']['utensil_detail']['lead_time'][$k]);
               $object['data']['utensil_detail']['delivery_date'][$k] = $delivery_date;
               $object['data']['utensil_detail']['requirement_qty'][$k] = 0;
               $k++;
             }
           }
		}

		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['utensil_header'] = $_POST['utensil_header'];
		  $object['data']['utensil_detail'] = $_POST['utensil_detail'];
   	      $object['data']['utensil_header']['status_string'] = ($_POST['utensil_header']['status'] == '2') ? 'Approved' : 'Not Approved';
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Request untuk Utensil';
		$this->template->write_view('content', 'utensil/utensil_edit', $object);
		$this->template->render();
	}


	function get_request_reason_1($req_reason) {
      return $this->l_general->leftstr($req_reason,1);
    }

	function _input_add() {
		// start of assign variables and delete not used variables
		$utensil = $_POST;
		unset($utensil['utensil_header']['id_utensil_header']);
		unset($utensil['button']);
		// end of assign variables and delete not used variables

		$count = count($utensil['utensil_detail']['id_utensil_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;
		for($i = 1; $i <= $count; $i++) {
			if($utensil['utensil_detail']['requirement_qty'][$i]>0) {
				$requirement_qty_exist = TRUE;
				break;
			} else {
				continue;
			}
		}

//echo "<pre>";
//print '$request_reasons ';
//print_r($utensil['utensil_header']);
//echo "</pre>";
//exit;

		if($requirement_qty_exist == FALSE)
			redirect('utensil/input_error/Anda belum memasukkan data Requirement Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('utensil', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$utensil_header['id_utensil_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('utensil_detail', $utensil['utensil_detail']);

    		$utensil_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$utensil_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
 			$utensil_header['created_date'] = $this->l_general->str_to_date($utensil['utensil_header']['created_date']);
			$utensil_header['id_utensil_plant'] = $this->m_utensil->id_utensil_plant_new_select($utensil_header['plant'],$utensil_header['created_date']);
 			$utensil_header['request_reason'] = $utensil['utensil_header']['request_reason'];

 			$utensil_header['pr_no'] = '';

			if(isset($_POST['button']['approve']))
				$utensil_header['status'] = '2';
			else
				$utensil_header['status'] = '1';

			$utensil_header['item_group_code'] = $utensil['utensil_header']['item_group_code'];
			$utensil_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];


            $web_trans_id = $this->l_general->_get_web_trans_id($utensil_header['plant'],$utensil_header['created_date'],
                      $utensil_header['id_utensil_plant'],'08');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $utensil_to_approve = array (
                      'plant' => $utensil_header['plant'],
                      'created_date' => date('Ymd',strtotime($utensil_header['created_date'])),
                      'id_user_input' => $utensil_header['id_user_input'],
                      'request_reason' => $this->get_request_reason_1($utensil_header['request_reason']),
                      'web_trans_id' => $web_trans_id,
                );
              }

			if($id_utensil_header = $this->m_utensil->utensil_header_insert($utensil_header)) {

                $input_detail_success = FALSE;
                $j = 0;
				for($i = 1; $i <= $count; $i++) {

					if((!empty($utensil['utensil_detail']['requirement_qty'][$i]))&&(!empty($utensil['utensil_detail']['material_no'][$i]))&&($utensil['utensil_detail']['requirement_qty'][$i]>0)) {

						$utensil_detail['id_utensil_header'] = $id_utensil_header;
						$utensil_detail['requirement_qty'] = $utensil['utensil_detail']['requirement_qty'][$i];
						$utensil_detail['id_utensil_h_detail'] = $utensil['utensil_detail']['id_utensil_h_detail'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($utensil['utensil_detail']['material_no'][$i]);

						$utensil_detail['material_no'] = $item['MATNR'];
						$utensil_detail['material_desc'] = $item['MAKTX'];
						$utensil_detail['uom'] = $utensil['utensil_detail']['uom'][$i];
             			$utensil_detail['lead_time'] = $utensil['utensil_detail']['lead_time'][$i];
             			$utensil_detail['delivery_date'] = $this->l_general->str_to_date($utensil['utensil_detail']['delivery_date'][$i]);

                        //array utk parameter masukan pada saat approval
                        $j++;
                        $utensil_to_approve['item'][$j] = $utensil_detail['id_utensil_h_detail'];
                        $utensil_to_approve['material_no'][$j] = $utensil_detail['material_no'];
                        $utensil_to_approve['requirement_qty'][$j] = $utensil_detail['requirement_qty'];
                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $utensil_to_approve['uom'][$j] = $utensil_detail['uom'];
                        } else {
                            $utensil_to_approve['uom'][$j] = $item['MEINS'];
                        }
                        $utensil_to_approve['delivery_date'][$j] = date('Ymd',strtotime($utensil_detail['delivery_date']));
                        //

						if($this->m_utensil->utensil_detail_insert($utensil_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    $approved_data = $this->m_utensil->sap_utensil_header_approve($utensil_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = $approved_data['material_document'];
    				$data = array (
    					'id_utensil_header'=>$id_utensil_header,
    					'pr_no'	=>	$pr_no,
    					'status' =>	'2',
    					'id_user_approved'=>$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if($this->m_utensil->utensil_header_update($data)) {
    				    $count = count($approved_data['sap_pr_item']);
        				for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_utensil_header'=>$id_utensil_header,
            					'material_no'=>$approved_data['sap_pr_item'][$i]['MATNR'],
            					'id_utensil_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_utensil->utensil_detail_update_by_material_no($data)) {
              				    $approve_data_success = TRUE;
                            }
                        }
    				}
//                   echo "<pre>";
//                   print_r($approved_data);
//                   echo "</pre>";
//                   exit;
				} else {
				  $approve_data_success = FALSE;
				}
            }


            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Request untuk Utensil berhasil dimasukkan', site_url('utensil/input'));
              } else {
                $this->m_utensil->utensil_header_delete($id_utensil_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request untuk Utensil tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Request untuk Utensil  berhasil diapprove', site_url('utensil/input'));
              } else {
                $this->m_utensil->utensil_header_delete($id_utensil_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request untuk Utensil tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request untuk Utensil tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('utensil/input2');

		$this->template->write_view('content', 'error', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request untuk Utensil berhasil diapprove';
		$object['refresh_url'] = site_url('utensil/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request untuk Utensil berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('utensil/input');
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function input_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$this->template->write_view('content', 'error', $object);
		$this->template->render();
	}*/


	function edit() {

		$item_choose = $this->uri->segment(6);
	    $utensil_header = $this->m_utensil->utensil_header_select($this->uri->segment(3));
		$status = $utensil_header['status'];
        unset($utensil_header);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
        $utensil_detail_tmp = array('utensil_detail' => '');
        $this->session->unset_userdata($utensil_detail_tmp);
        unset($utensil_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {
//		if((count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['utensil_detail']['id_utensil_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['material_no'][$i], "utensil_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

    				$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['requirement_qty'][$i], "utensil_detail[requirement_qty][$i]", 'Quantity No. '.$i, 'required|is_numeric');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

                    if (!empty($_POST['utensil_detail']['requirement_qty'][$i])&&($_POST['utensil_detail']['requirement_qty'][$i]>0)) {
                        $date1 =  $this->l_general->str_to_date($_POST['utensil_detail']['delivery_date'][$i]);
                        $date2 = $this->l_general->str_to_date($_POST['utensil_header']['created_date']);
                        $datediff = $this->l_general->dateDiff($date1,$date2,'DAY');
       					$check[$j] = $this->l_form_validation->set_rules($_POST['utensil_detail']['lead_time'][$i], "utensil_detail[delivery_date][$i]", 'Delivery Date. '.$i, 'valid_lead_time;'.$datediff);

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
				}

				// set $validation, based on $validation_temp value;
				$validation = $validation_temp;

			}

		}


		if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$utensil_header = $this->m_utensil->utensil_header_select($this->uri->segment(3));

				if($utensil_header['status'] == '2') {
    				$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['utensil_header'] = $this->m_utensil->utensil_header_select($this->uri->segment(3));
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
          $utensil_detail_tmp = array('utensil_detail' => '');
          $this->session->unset_userdata($utensil_detail_tmp);
          unset($utensil_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['utensil_header']['status_string'] = ($object['data']['utensil_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$request_reason = $data['utensil_header']['request_reason'];
		$item_group_code = $data['utensil_header']['item_group_code'];;
		$item_choose = $this->uri->segment(6);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	$object['request_reason'] = $request_reason;
    	$object['request_reasons'][0] = '';
    	$object['request_reasons']['Pastry'] = 'Pastry';
    	$object['request_reasons']['Utensil'] = 'Utensil';

//exit;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_utensil($this->get_request_reason_1($request_reason));
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, $request_reason);
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
			$object['data']['utensil_details'] = $this->m_utensil->utensil_details_select($object['data']['utensil_header']['id_utensil_header']);

			if($object['data']['utensil_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['utensil_details']->result_array() as $object['temp']) {
	//				$object['data']['utensil_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['utensil_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Request untuk Utensil';
		$this->template->write_view('content', 'utensil/utensil_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$utensil = $_POST;
		unset($utensil['utensil_header']['id_utensil_header']);
		unset($utensil['button']);
		// end of assign variables and delete not used variables

		$count = count($utensil['utensil_detail']['id_utensil_h_detail']) - 1;

		// check, at least one product requirement_qty entered
		$requirement_qty_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if($utensil['utensil_detail']['requirement_qty'][$i]>0) {
				$requirement_qty_exist = TRUE;
				break;
			} else {
				continue;
			}
		}

		if($requirement_qty_exist == FALSE)
			redirect('utensil/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('utensil_detail', $utensil['utensil_detail']);

            $id_utensil_header = $this->uri->segment(3);
            $createddate = $this->l_general->str_to_date($utensil['utensil_header']['created_date']);
			$id_utensil_plant = $this->m_utensil->id_utensil_plant_new_select("",$createddate,$id_utensil_header);

    			$data = array (
    				'id_utensil_header' => $id_utensil_header,
    				'created_date' => $createddate,
                    'id_utensil_plant' => $id_utensil_plant,
    				'request_reason' => $utensil['utensil_header']['request_reason'],
    			);
                $this->m_utensil->utensil_header_update($data);
                $edit_utensil_header = $this->m_utensil->utensil_header_select($id_utensil_header);

    			if ($this->m_utensil->utensil_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_utensil->utensil_details_delete($id_utensil_header)) {
    			        $j = 0;
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($utensil['utensil_detail']['requirement_qty'][$i]))&&(!empty($utensil['utensil_detail']['material_no'][$i]))&&($utensil['utensil_detail']['requirement_qty'][$i]>0)) {

        						$utensil_detail['id_utensil_header'] = $id_utensil_header;
        						$utensil_detail['requirement_qty'] = $utensil['utensil_detail']['requirement_qty'][$i];
        						$utensil_detail['id_utensil_h_detail'] = $utensil['utensil_detail']['id_utensil_h_detail'][$i];

                     			$utensil_detail['lead_time'] = $utensil['utensil_detail']['lead_time'][$i];
                     			$utensil_detail['delivery_date'] = $this->l_general->str_to_date($utensil['utensil_detail']['delivery_date'][$i]);

        						$item = $this->m_general->sap_item_select_by_item_code($utensil['utensil_detail']['material_no'][$i]);

        						$utensil_detail['material_no'] = $item['MATNR'];
        						$utensil_detail['material_desc'] = $item['MAKTX'];
        						$utensil_detail['uom'] = $utensil['utensil_detail']['uom'][$i];

                                //array utk parameter masukan pada saat approval
                                $j++;
                                $utensil_to_approve['item'][$j] = $utensil_detail['id_utensil_h_detail'];
                                $utensil_to_approve['material_no'][$j] = $utensil_detail['material_no'];
                                $utensil_to_approve['requirement_qty'][$j] = $utensil_detail['requirement_qty'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $utensil_to_approve['uom'][$j] = $utensil_detail['uom'];
                                } else {
                                    $utensil_to_approve['uom'][$j] = $item['MEINS'];
                                }
                                $utensil_to_approve['delivery_date'][$j] = date('Ymd',strtotime($utensil_detail['delivery_date']));
                                //

        						if($this->m_utensil->utensil_detail_insert($utensil_detail))
                                  $input_detail_success = TRUE;
        					}

            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $utensil_to_approve['created_date'] = date('Ymd',strtotime($edit_utensil_header['created_date']));
                $utensil_to_approve['plant'] = $edit_utensil_header['plant'];
                $utensil_to_approve['id_utensil_plant'] = $edit_utensil_header['id_utensil_plant'];
                $utensil_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $utensil_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_utensil_header['plant'],$edit_utensil_header['created_date'],
                     $edit_utensil_header['id_utensil_plant'],'08');
                $utensil_to_approve['request_reason'] = $this->get_request_reason_1($edit_utensil_header['request_reason']);

			    $approved_data = $this->m_utensil->sap_utensil_header_approve($utensil_to_approve);
    			if((!empty($approved_data['material_document'])) && ($approved_data['material_document'] !== '')) {
    			    $pr_no = $approved_data['material_document'];
    				$data = array (
    					'id_utensil_header' =>$id_utensil_header,
    					'pr_no'	=>	$pr_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				if($this->m_utensil->utensil_header_update($data)) {
    				    $count = count($approved_data['sap_pr_item']);
        				for($i = 1; $i <= $count; $i++) {
            				$data = array (
            					'id_utensil_header'=>$id_utensil_header,
            					'material_no'=>$approved_data['sap_pr_item'][$i]['MATNR'],
            					'id_utensil_pr_line_no' =>	$approved_data['sap_pr_item'][$i]['EBELP']
            				);
                            if($this->m_utensil->utensil_detail_update_by_material_no($data)) {
              				    $approve_data_success = TRUE;
                            }
                        }
    				}
				} else {
				  $approve_data_success = FALSE;
				}
            }


            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Request untuk Utensil berhasil diubah', site_url('utensil/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request untuk Utensil tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
    			  $this->l_general->success_page('Data Request untuk Utensil berhasil diapprove', site_url('utensil/browse'));
              } else {
				  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request untuk Utensil tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'utensil/browse';
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function edit_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$this->template->write_view('content', 'error', $object);
		$this->template->render();
	}*/

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$utensil = $_POST;
		unset($utensil['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($utensil['utensil_header']['created_date']!=$date_today) {
			redirect('utensil/edit_error/Anda tidak bisa mengganti atau menghapus transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        } else {

        	if(isset($_POST['button']['delete_item'])&& empty($utensil['cancel'])) {
                $requirement_qty_exist = FALSE;
        	} else {
        		$requirement_qty_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE)
    			redirect('utensil/edit_error/Anda belum memilih item yang akan di-delete. Mohon ulangi');

      		for($i = 1; $i <= $count; $i++) {
      			if(empty($utensil['utensil_detail']['requirement_qty'][$i])) {
      				continue;
      			} else {
      				$requirement_qty_exist = TRUE;
      				break;
      			}
              }

    		if($requirement_qty_exist == FALSE)
    			redirect('utensil/input_error/Anda belum memasukkan data Requirement Quantity. Mohon ulangi.');

        	if(isset($_POST['button']['change'])) {
                $requirement_qty_exist = FALSE;
                $count = count($utensil['utensil_detail']['id_utensil_h_detail']);
                for($i=1;$i<=$count;$i++){
                  if($utensil['utensil_detail']['requirement_qty'][$i]!=$utensil['utensil_detail']['requirement_qty_old'][$i]){
               		$requirement_qty_exist = TRUE;
                    break;
                  }
                }
        	} else {
        		$requirement_qty_exist = TRUE;
        	}

    		if($requirement_qty_exist == FALSE)
    			redirect('utensil/edit_error/Anda belum mengganti item yang akan di-changed. Mohon ulangi');

    //		if($this->m_config->running_number_select_update('utensil', 1, date("Y-m-d")) {

            $edit_utensil_header = $this->m_utensil->utensil_header_select($utensil['utensil_header']['id_utensil_header']);
    		$edit_utensil_details = $this->m_utensil->utensil_details_select($utensil['utensil_header']['id_utensil_header']);
        	$i = 1;
    	    foreach ($edit_utensil_details->result_array() as $value) {
    		    $edit_utensil_detail[$i] = $value;
    		    $i++;
            }
            unset($edit_utensil_details);

    //echo "<pre>";
    //print '$edit_utensil_detail';
    //print_r($edit_utensil_detail);
    //echo "</pre>";
    //exit;

    		if(isset($_POST['button']['change'])||isset($_POST['button']['delete_item'])) {

        		$this->session->set_userdata('utensil_detail', $utensil['utensil_detail']);

    			$this->db->trans_start();

                if(isset($_POST['button']['delete_item'])) {
                  $utensil_to_cancel['pr_no'] = $edit_utensil_header['pr_no'];
                  $utensil_to_cancel['created_date'] = date('Ymd',strtotime($edit_utensil_header['created_date']));
                  $utensil_to_cancel['plant'] = $edit_utensil_header['plant'];
          		  $utensil_to_cancel['id_utensil_plant'] = $this->m_utensil->id_utensil_plant_new_select($edit_utensil_header['plant'],date('Y-m-d',strtotime($edit_utensil_header['created_date'])));
                  $utensil_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_utensil_header['plant'],$edit_utensil_header['created_date'],
                            $utensil_to_cancel['id_utensil_plant'],'08');
                  $utensil_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                if(isset($_POST['button']['change'])) {
                  $utensil_to_change['pr_no'] = $edit_utensil_header['pr_no'];
                  $utensil_to_change['created_date'] = date('Ymd',strtotime($edit_utensil_header['created_date']));
                  $utensil_to_change['plant'] = $edit_utensil_header['plant'];
                  $utensil_to_change['id_utensil_plant'] = $this->m_utensil->id_utensil_plant_new_select($edit_utensil_header['plant'],date('Y-m-d',strtotime($edit_utensil_header['created_date'])));
                  $utensil_to_change['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_utensil_header['plant'],$edit_utensil_header['created_date'],
                            $utensil_to_change['id_utensil_plant'],'08');
                  $utensil_to_change['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                }

                $count = count($edit_utensil_detail);
        		for($i = 1; $i <= $count; $i++) {
        		   if (isset($_POST['button']['delete_item'])) {
         		       $utensil_to_cancel['item'][$i] = $i;
            		   if(!empty($utensil['cancel'][$i])) {
             		     $utensil_to_cancel['id_utensil_pr_line_no'][$i] = $edit_utensil_detail[$i]['id_utensil_pr_line_no'];
             		     $utensil_to_cancel['material_no'][$i] = $edit_utensil_detail[$i]['material_no'];
             		     $utensil_to_cancel['requirement_qty'][$i] = $edit_utensil_detail[$i]['requirement_qty'];
                       }
                   }
                   if(isset($_POST['button']['change'])) {
             		   $utensil_to_change['item'][$i] = $i;
              		   if(($utensil['utensil_detail']['requirement_qty'][$i]!=$utensil['utensil_detail']['requirement_qty_old'][$i])) {
             		     $utensil_to_change['id_utensil_pr_line_no'][$i] = $edit_utensil_detail[$i]['id_utensil_pr_line_no'];
               		     $utensil_to_change['material_no'][$i] = $edit_utensil_detail[$i]['material_no'];
               		     $utensil_to_change['requirement_qty'][$i] = $utensil['utensil_detail']['requirement_qty'][$i];
               		     $utensil_to_change['requirement_qty_old'][$i] = $utensil['utensil_detail']['requirement_qty_old'][$i];
                  		 $utensil_to_change['delivery_date'][$i] = date('Ymd',strtotime($edit_utensil_detail[$i]['delivery_date']));;
                       }
                   }
                }
                if(isset($_POST['button']['delete_item'])) {
                    $cancelled_data = $this->m_utensil->sap_utensil_header_cancel($utensil_to_cancel);
         			$cancel_data_success = FALSE;
        			if(empty($cancelled_data['sap_return_type'])||($cancelled_data['sap_return_type']=='S')) {
                		for($i = 1; $i <= $count; $i++) {
                			if(!empty($utensil['cancel'][$i])) {
        	    			$utensil_header = array (
        						'id_utensil_header'=>$utensil['utensil_header']['id_utensil_header'],
        						'id_utensil_plant'=>$utensil_to_cancel['id_utensil_plant'],
        					);
        		    		if($this->m_utensil->utensil_header_update($utensil_header)==TRUE) {
            		    		if($this->m_utensil->utensil_detail_delete($edit_utensil_detail[$i]['id_utensil_detail'])==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                            }
                 			}
                        }
                    }
                }

                if(isset($_POST['button']['change'])) {
                    $changed_data = $this->m_utensil->sap_utensil_header_change($utensil_to_change);
         			$cancel_data_success = FALSE;
        			if($changed_data['sap_return_type']=='S') {
                		for($i = 1; $i <= $count; $i++) {
                			if($utensil['utensil_detail']['requirement_qty'][$i]!=$utensil['utensil_detail']['requirement_qty_old'][$i]) {
            	    			$utensil_detail = array (
            						'id_utensil_detail'=>$edit_utensil_detail[$i]['id_utensil_detail'],
            						'requirement_qty'=>$utensil['utensil_detail']['requirement_qty'][$i],
            					);
            		    		if($this->m_utensil->utensil_detail_update($utensil_detail)==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                			}
                        }
                    }
                }

          	    $this->db->trans_complete();

                if($cancel_data_success == TRUE) {
                    if(isset($_POST['button']['delete_item'])) {
    				$this->l_general->success_page('Data Request Tambahan untuk Standard Stock berhasil dibatalkan', site_url('utensil/browse'));
                   } else {
    				$this->l_general->success_page('Data Request Tambahan untuk Standard Stock berhasil diganti', site_url('utensil/browse'));
                  }
                } else {
                    if(isset($_POST['button']['delete_item'])) {
    				   $this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request Tambahan untuk Standard Stock tidak  berhasil dibatalkan.<br>
                                       Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
                   } else {
    				   $this->jagmodule['error_code'] = '008'; 
		$this->l_general->error_page($this->jagmodule, 'Data Request Tambahan untuk Standard Stock tidak  berhasil diganti.<br>
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

		$this->template->write_view('content', 'error', $object);
		$this->template->render();
	}*/

	function _delete($id_utensil_header) {

		$this->db->trans_start();

		// check approve status
		$utensil_header = $this->m_utensil->utensil_header_select($id_utensil_header);

		if($utensil_header['status'] == '1') {
			$this->m_utensil->utensil_header_delete($id_utensil_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_utensil_header) {

		if($this->_delete($id_utensil_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Request untuk Utensil berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['utensil_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Request untuk Utensil gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['utensil_browse_result'];

			$this->template->write_view('content', 'error', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_utensil_header']))
			redirect($this->session->userdata['PAGE']['utensil_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
            if(!empty($_POST['id_utensil_header'][$i])) {
				$object['data']['utensil_headers'][$j++] = $this->m_utensil->utensil_header_select($_POST['id_utensil_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'utensil/utensil_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'utensil/utensil_delete_multiple_confirm', $object);

		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_utensil_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Request untuk Utensil berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['utensil_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_utensil->utensil_select_to_export($_POST['id_utensil_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'NonStandardStock');
        }
    }

 	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'utensil_data';
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

			// is it utensil template file?
			if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // utensil_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same utensil header?

					$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$requirement_qty = $excel['cells'][$i][4];

					// check utensil header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {
                         if($utensil_header_temp = $this->m_general->sap_item_groups_select_all_utensil($this->l_general->leftstr($request_reason,1))) {
                            $j++;
							$object['utensil_headers'][$j]['pr_no'] = $excel['cells'][$i][1];
                            $object['utensil_headers'][$j]['request_reason'] = $request_reason;
							$object['utensil_headers'][$j]['created_date'] = date("Y-m-d H:i:s");
                            $object['utensil_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['utensil_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['utensil_headers'][$j]['status'] = '1';
							$object['utensil_headers'][$j]['item_group_code'] = $item_group_code;
							$object['utensil_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['utensil_headers'][$j]['filename'] = $upload['file_name'];
                        	$utensil_header_exist = TRUE;
							$k = 1; // utensil_detail number
						} else {
            	            $utensil_header_exist = FALSE;
						}
                    }

					if($utensil_header_exist) {


                        if ($utensil_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
							$object['utensil_details'][$j][$k]['id_utensil_h_detail'] = $k;
							$object['utensil_details'][$j][$k]['material_no'] = $material_no;
                            $object['utensil_details'][$j][$k]['material_desc'] = $utensil_detail_temp['MAKTX'];
                            $item_lead_time = $this->m_utensil->sap_item_lead_time_select($material_no);
							$object['utensil_details'][$j][$k]['lead_time'] = $item_lead_time['LEAD_TIME'];

                            $delivery_date = date("Y-m-d H:i:s");
                            $delivery_date = $this->l_general->str_to_date(date("d-m-Y",strtotime($delivery_date) + ($item_lead_time['LEAD_TIME'] * (60 * 60 * 24))));
							$object['utensil_details'][$j][$k]['delivery_date'] = date("d-m-Y",strtotime($delivery_date));
							$object['utensil_details'][$j][$k]['requirement_qty'] = $requirement_qty;
							$object['utensil_details'][$j][$k]['uom'] = $utensil_detail_temp['UNIT'];

							$k++;
                        }

					}

				}

				$this->template->write_view('content', 'utensil/utensil_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Utensil atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'utensil/browse_result/0/0/0/0/0/0/0/10';
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

		// is it utensil template file?
		if($excel['cells'][1][1] == 'Purchase Req. No' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // utensil_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same utensil header?

			  	$item_group_code = 'all';
                    $request_reason =  $excel['cells'][$i][2];
					$material_no =  $excel['cells'][$i][3];
					$requirement_qty = $excel['cells'][$i][4];



				// check utensil header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {
                     if($utensil_header_temp = $this->m_general->sap_item_groups_select_all_utensil($this->l_general->leftstr($request_reason,1))) {
                       $j++;
                        $object['utensil_headers'][$j]['created_date'] = $this->m_general->posting_date_select_max();
                        $object['utensil_headers'][$j]['request_reason'] = $request_reason;
                       	$object['utensil_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
            			$object['utensil_headers'][$j]['id_utensil_plant'] = $this->m_utensil->id_utensil_plant_new_select($object['utensil_headers'][$j]['plant'],$object['utensil_headers'][$j]['created_date']);
            			$object['utensil_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            			$object['utensil_headers'][$j]['status'] = '1';
            			$object['utensil_headers'][$j]['item_group_code'] = $item_group_code;
            			$object['utensil_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            			$object['utensil_headers'][$j]['filename'] = $upload['file_name'];

						$id_utensil_header = $this->m_utensil->utensil_header_insert($object['utensil_headers'][$j]);
                       	$utensil_header_exist = TRUE;
						$k = 1; // utensil_detail number
						} else {
            	            $utensil_header_exist = FALSE;
						}
                   }

				if($utensil_header_exist) {
                        if ($utensil_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
					    	$object['utensil_details'][$j][$k]['id_utensil_header'] = $id_utensil_header ;
					    	$object['utensil_details'][$j][$k]['id_utensil_h_detail'] = $k;

							$object['utensil_details'][$j][$k]['material_no'] = $material_no;
							$object['utensil_details'][$j][$k]['material_desc'] = $utensil_detail_temp['MAKTX'];

                            $item_lead_time = $this->m_utensil->sap_item_lead_time_select($material_no);
							$object['utensil_details'][$j][$k]['lead_time'] = $item_lead_time['LEAD_TIME'];
                            $delivery_date = date("Y-m-d H:i:s");
                            $delivery_date = $this->l_general->str_to_date(date("d-m-Y",strtotime($delivery_date) + ($item_lead_time['LEAD_TIME'] * (60 * 60 * 24))));
							$object['utensil_details'][$j][$k]['delivery_date'] = $delivery_date;

						    $object['utensil_details'][$j][$k]['requirement_qty'] = $requirement_qty;
							$object['utensil_details'][$j][$k]['uom'] = $utensil_detail_temp['UNIT'];
						$id_utensil_detail = $this->m_utensil->utensil_detail_insert($object['utensil_details'][$j][$k]);

						$k++;
                     }

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Utensil  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['utensil_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Utensil atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'utensil/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
