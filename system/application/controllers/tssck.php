<?php
class tssck extends Controller {
	private $jagmodule = array();


	function tssck() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1054);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_tssck'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_tssck');

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
		$tssck_browse_result = $this->session->userdata['PAGE']['tssck_browse_result'];

		if(!empty($tssck_browse_result))
			redirect($this->session->userdata['PAGE']['tssck_browse_result']);
		else
			redirect('tssck/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('tssck/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('tssck/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('tssck_browse_result');

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
			'a'	=>	'Goods Issue Stock Transfer No',
			'b'	=>	'Purchase Order No',
			'c'	=>	'Delivery Order No',
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

		$sort_link1 = 'tssck/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
			'gy'	=>	$sort_link1.'gy'.$sort_link2,
			'gz'	=>	$sort_link1.'gz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('tssck/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_tssck->tssck_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['tssck_headers'] = $this->m_tssck->tssck_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Transfer Selisih Stock ke CK';
		$this->template->write_view('content', 'tssck/tssck_browse', $object);
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

        $tssck_detail_tmp = array('tssck_detail' => '');
        $this->session->unset_userdata($tssck_detail_tmp);
        unset($tssck_detail_tmp);

  		$data['plants'] = $this->m_general->sap_plants_select_all_ck_outlet();
          //print_r($data['plant']);
  		if($data['plants'] !== FALSE) {
  			$object['receiving_plant'][0] = '';
  			foreach ($data['plants'] as $plant) {
  				$object['receiving_plant'][$plant['plant']] = $plant['plant'].' - '.$plant['plant_name'] ;
  			}
  		}

		if(!empty($data['receiving_plant'])) {
			$data['do_nos'] = $this->m_tssck->tssck_do_select();

			if($data['do_nos'] !== FALSE) {
				$object['do_no'][0] = '';

				foreach ($data['do_nos'] as $do_no) {
					$object['do_no'][$do_no['do_no']] = $do_no['do_no'];
				}
			}
		}

		if(!empty($data['do_no'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('tssck/input2/'.$data['receiving_plant'].'/'.$data['do_no'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Transfer Selisih Stock ke CK';
		$this->template->write_view('content', 'tssck/tssck_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(5);
   		$do_no = $this->uri->segment(4);

		$validation = FALSE;

  		if(count($_POST) != 0) {

  			if(!isset($_POST['delete'])) {
  				// first post, assume all data TRUE
  				$validation_temp = TRUE;

  				$count = count($_POST['tssck_detail']['id_tssck_h_detail']);
  				$i = 1; // counter for each row
  				$j = 1; // counter for each field

  				// for POST data
  				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
  					$count2 = $count - 1;
  				else
  					$count2 = $count;

//echo "<pre>";
//print 'array ';
//print_r($_POST['tssck_detail']);
//echo "</pre>";

	        	for($i = 1; $i <= $count2; $i++) {
  					$check[$j] = $this->l_form_validation->set_rules($_POST['tssck_detail']['material_no'][$i], "tssck_detail[material_no][$i]", 'Material No. '.$i, 'required');

  					// if one data FALSE, set $validation_temp to FALSE
  					if($check[$j]['error'] == TRUE)
  						$validation_temp = FALSE;

  					$j++;

                    $qty_to_check = $this->m_tssck->tssck_do_item_select_by_material_no($do_no,$_POST['tssck_detail']['material_no'][$i]);
  					$check[$j] = $this->l_form_validation->set_rules($_POST['tssck_detail']['gr_quantity'][$i], "tssck_detail[gr_quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero|valid_quantity;'.$qty_to_check['quantity']);

  					// if one data FALSE, set $validation_temp to FALSE
  					if($check[$j]['error'] == TRUE)
  						$validation_temp = FALSE;
                    /*else {
    					$check[$j] = $this->l_form_validation->set_rules($_POST['tssck_detail']['gr_quantity'][$i], "tssck_detail[gr_quantity][$i]", 'Quantity No. '.$i, );
    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$j]['error'] == TRUE)
    						$validation_temp = FALSE;
                    } */
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
          $tssck_detail_tmp = array('tssck_detail' => '');
          $this->session->unset_userdata($tssck_detail_tmp);
          unset($tssck_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
     	    $receiving_plant = $this->uri->segment(4);
    		$do_no = $this->uri->segment(5);
    		$item_choose = $this->uri->segment(6);
        } else {
     	    $receiving_plant = $this->uri->segment(3);
    		$do_no = $this->uri->segment(4);
    		$item_choose = $this->uri->segment(5);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $object['receiving_plant'] = $this->m_general->sap_plant_select_2($receiving_plant);
        $object['do_no'] = $do_no;

		$data['items'] = $this->m_tssck->tssck_do_item_select($do_no);

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
			    if(!in_array($data['item']['material_no'],$data['tssck_detail']['material_no'])||(!empty($object['error'])))
    				if($item_choose == 1) {
    					$object['item'][$data['item']['material_no']] = $data['item']['MATNR1'].' - '.$data['item']['material_desc'].' (Qty : '.$data['item']['quantity'].' '.$data['item']['uom'].')';
    				} elseif ($item_choose == 2) {
    					$object['item'][$data['item']['material_no']] = $data['item']['material_desc'].' - '.$data['item']['MATNR1'].' (Qty : '.$data['item']['quantity'].' '.$data['item']['uom'].')';
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
		  $object['data']['tssck_header'] = $_POST['tssck_header'];//$this->m_tssck->tssck_details_select($this->uri->segment(3));
		  $object['data']['tssck_detail'] = $_POST['tssck_detail'];//$this->m_tssck->tssck_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Transfer Selisih Stock ke CK';
		$this->template->write_view('content', 'tssck/tssck_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$tssck = $_POST;
		unset($tssck['tssck_header']['id_tssck_header']);
		unset($tssck['button']);
		// end of assign variables and delete not used variables

		$count = count($tssck['tssck_detail']['id_tssck_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($tssck['tssck_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('tssck/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($tssck['tssck_header']['posting_date'])==FALSE)) {
     	   redirect('tssck/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

//		if($this->m_config->running_number_select_update('tssck', 1, date("Y-m-d")) {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

//			$tssck_header['id_tssck_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('tssck_detail', $tssck['tssck_detail']);

    		$tssck_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$tssck_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$tssck_header['posting_date'] = $this->m_general->posting_date_select_max($tssck_header['plant']);
 			$tssck_header['posting_date'] = $this->l_general->str_to_date($tssck['tssck_header']['posting_date']);
			$tssck_header['id_tssck_plant'] = $this->m_tssck->id_tssck_plant_new_select($tssck_header['plant'],$tssck_header['posting_date']);

 			$tssck_header['do_no'] = $tssck['tssck_header']['do_no'];
 			$tssck_header['receiving_plant'] = $tssck['tssck_header']['receiving_plant'];
 			$tssck_header['receiving_plant_name'] = $tssck['tssck_header']['receiving_plant_name'];

 			$tssck_header['po_no'] = '';
			$tssck_header['tssck_no'] = '';

			if(isset($_POST['button']['approve']))
				$tssck_header['status'] = '2';
			else
				$tssck_header['status'] = '1';

			$tssck_header['item_group_code'] = $tssck['tssck_header']['item_group_code'];
			$tssck_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];


         //   $web_trans_id = $this->l_general->_get_web_trans_id($tssck_header['plant'],$tssck_header['posting_date'],
           //           $tssck_header['id_tssck_plant'],'11');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $tssck_to_approve = array (
                      'plant' => $tssck_header['plant'],
                      'do_no' => $tssck_header['do_no'],
                      'posting_date' => date('Ymd',strtotime($tssck_header['posting_date'])),
                      'id_user_input' => $tssck_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $tssck_header['receiving_plant'],
                );
              }

			if($id_tssck_header = $this->m_tssck->tssck_header_insert($tssck_header)) {

                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($tssck['tssck_detail']['gr_quantity'][$i]))&&(!empty($tssck['tssck_detail']['material_no'][$i]))) {

						$tssck_detail['id_tssck_header'] = $id_tssck_header;
						$tssck_detail['gr_quantity'] = $tssck['tssck_detail']['gr_quantity'][$i];
						$tssck_detail['id_tssck_h_detail'] = $tssck['tssck_detail']['id_tssck_h_detail'][$i];

						$item = $this->m_general->sap_item_select_by_item_code($tssck['tssck_detail']['material_no'][$i]);

  						$tssck_detail['material_no'] = $tssck['tssck_detail']['material_no'][$i];
  						$tssck_detail['material_desc'] = $tssck['tssck_detail']['material_desc'][$i];
  						$tssck_detail['uom'] = $tssck['tssck_detail']['uom'][$i];
						$tssck_detail['num'] = $tssck['tssck_detail']['num'][$i];

                        //array utk parameter masukan pada saat approval
                        $tssck_to_approve['item'][$i] = $tssck_detail['id_tssck_h_detail'];
                        $tssck_to_approve['material_no'][$i] = $tssck_detail['material_no'];
                        $tssck_to_approve['gr_quantity'][$i] = $tssck_detail['gr_quantity'];
                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $tssck_to_approve['uom'][$i] = $tssck_detail['uom'];
                        } else {
                            $tssck_to_approve['uom'][$i] = $item['MEINS'];
                        }

						if(($this->m_tssck->tssck_detail_insert($tssck_detail))&&
                          ($this->m_tssck->tssck_do_outstanding_update($tssck_header['do_no'],$tssck_detail['material_no'],$tssck_detail['gr_quantity'],'+')))
                            $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    $approved_data = $this->m_tssck->sap_tssck_header_approve($tssck_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			    $tssck_no = $approved_data['material_document'];
    			    $po_no = $approved_data['po_document'];
    				$data = array (
    					'id_tssck_header'	=>$id_tssck_header,
    					'tssck_no'	=>	$tssck_no,
    					'po_no'	=>	$po_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_tssck->tssck_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Transfer Selisih Stock ke CK berhasil dimasukkan', site_url('tssck/input'));
              } else {
                $this->m_tssck->tssck_header_delete($id_tssck_header);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Selisih Stock ke CK tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Transfer Selisih Stock ke CK berhasil diapprove', site_url('tssck/input'));
              } else {
                $this->m_tssck->tssck_header_delete($id_tssck_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Selisih Stock ke CK tidak berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));

            }

		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('tssck/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK berhasil diapprove';
		$object['refresh_url'] = site_url('tssck/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('tssck/input');
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

	    $tssck_header = $this->m_tssck->tssck_header_select($this->uri->segment(3));
		$status = $tssck_header['status'];
		$do_no = $tssck_header['do_no'];
        unset($tssck_header);

        $tssck_detail_tmp = array('tssck_detail' => '');
        $this->session->unset_userdata($tssck_detail_tmp);
        unset($tssck_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['tssck_detail']['id_tssck_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['tssck_detail']['material_no'][$i], "tssck_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

                    $qty_to_check = $this->m_tssck->tssck_do_item_select_by_material_no($do_no,$_POST['tssck_detail']['material_no'][$i]);
  					$check[$j] = $this->l_form_validation->set_rules($_POST['tssck_detail']['gr_quantity'][$i], "tssck_detail[gr_quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero|valid_quantity;'.$qty_to_check['quantity']);

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

//		$this->form_validation->set_rules("tssck_header[do_no]", 'Delivery Number', 'trim|required');
//		$validation_temp = TRUE;

//        if ($this->form_validation->run() == FALSE) {
//      	  $validation_temp = FALSE;
//        }
//    	$validation = $validation_temp;

    	if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$tssck_header = $this->m_tssck->tssck_header_select($this->uri->segment(3));

				if($tssck_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['tssck_header'] = $this->m_tssck->tssck_header_select($this->uri->segment(3));
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
          $tssck_detail_tmp = array('tssck_detail' => '');
          $this->session->unset_userdata($tssck_detail_tmp);
          unset($tssck_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['tssck_header']['status_string'] = ($object['data']['tssck_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$receiving_plant = $data['tssck_header']['receiving_plant'];
		$do_no = $data['tssck_header']['do_no'];;
		$item_choose = $this->uri->segment(6);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['tssck_header']['item_group_code'];
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
        $object['do_no'] = $do_no;
//exit;
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }


		if(count($_POST) == 0) {
			$object['data']['tssck_details'] = $this->m_tssck->tssck_details_select($object['data']['tssck_header']['id_tssck_header']);

			if($object['data']['tssck_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['tssck_details']->result_array() as $object['temp']) {
	//				$object['data']['tssck_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['tssck_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$data['items'] = $this->m_tssck->tssck_do_item_select($do_no);

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
			    if((!in_array($data['item']['material_no'],$data['tssck_detail']['material_no']))
                 &&(!in_array($data['item']['material_no'],$object['data']['tssck_detail']['material_no']))
                 ||(!empty($object['error'])))
    				if($item_choose == 1) {
    					$object['item'][$data['item']['material_no']] = $data['item']['MATNR1'].' - '.$data['item']['material_desc'].' (Qty : '.$data['item']['quantity'].' '.$data['item']['uom'].')';
    				} elseif ($item_choose == 2) {
    					$object['item'][$data['item']['material_no']] = $data['item']['material_desc'].' - '.$data['item']['MATNR1'].' (Qty : '.$data['item']['quantity'].' '.$data['item']['uom'].')';
    				}
			}
		}

		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transfer Selisih Stock ke CK';
		$this->template->write_view('content', 'tssck/tssck_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$tssck = $_POST;
		unset($tssck['tssck_header']['id_tssck_header']);
		unset($tssck['button']);
		// end of assign variables and delete not used variables

		$count = count($tssck['tssck_detail']['id_tssck_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($tssck['tssck_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('tssck/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($tssck['tssck_header']['posting_date'])==FALSE)) {
     	   redirect('tssck/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('tssck_detail', $tssck['tssck_detail']);

            $id_tssck_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($tssck['tssck_header']['posting_date']);
			$id_tssck_plant = $this->m_tssck->id_tssck_plant_new_select("",$postingdate,$id_tssck_header);

    			$data = array (
    				'id_tssck_header' => $id_tssck_header,
    				'posting_date' => $postingdate,
                    'id_tssck_plant' => $id_tssck_plant,
         			'do_no' => $tssck['tssck_header']['do_no'],
    			);
                $this->m_tssck->tssck_header_update($data);
                $edit_tssck_header = $this->m_tssck->tssck_header_select($id_tssck_header);

    			if ($this->m_tssck->tssck_header_update($data)) {
                    $input_detail_success = FALSE;
    			    if($this->m_tssck->tssck_details_delete($id_tssck_header)) {
                		for($i = 1; $i <= $count; $i++) {
        					if((!empty($tssck['tssck_detail']['gr_quantity'][$i]))&&(!empty($tssck['tssck_detail']['material_no'][$i]))) {

        						$tssck_detail['id_tssck_header'] = $id_tssck_header;
        						$tssck_detail['gr_quantity'] = $tssck['tssck_detail']['gr_quantity'][$i];
        						$tssck_detail['id_tssck_h_detail'] = $tssck['tssck_detail']['id_tssck_h_detail'][$i];

        						$item = $this->m_general->sap_item_select_by_item_code($tssck['tssck_detail']['material_no'][$i]);

        						$tssck_detail['material_no'] = $tssck['tssck_detail']['material_no'][$i];
        						$tssck_detail['material_desc'] = $tssck['tssck_detail']['material_desc'][$i];
        						$tssck_detail['uom'] = $tssck['tssck_detail']['uom'][$i];

                                //array utk parameter masukan pada saat approval
                                $tssck_to_approve['item'][$i] = $tssck_detail['id_tssck_h_detail'];
                                $tssck_to_approve['material_no'][$i] = $tssck_detail['material_no'];
                                $tssck_to_approve['gr_quantity'][$i] = $tssck_detail['gr_quantity'];
                                if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $tssck_to_approve['uom'][$i] = $tssck_detail['uom'];
                                } else {
                                    $tssck_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                //

        						if(($this->m_tssck->tssck_detail_insert($tssck_detail))&&
                                  ($this->m_tssck->tssck_do_outstanding_update($tssck['tssck_header']['do_no'],$tssck_detail['material_no'],$tssck_detail['gr_quantity'],'+')))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($tssck['tssck_detail']['gr_quantity'][$i])) {
            	    			$tssck_detail = array (
            						'id_tssck_detail'=>$tssck['tssck_detail']['id_tssck_detail'][$i],
            						'gr_quantity'=>$tssck['tssck_detail']['gr_quantity'][$i],
            					);
            		    		if($this->m_tssck->tssck_detail_update($tssck_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_tssck->tssck_detail_delete($tssck['tssck_detail']['id_tssck_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $tssck_to_approve['posting_date'] = date('Ymd',strtotime($edit_tssck_header['posting_date']));
                $tssck_to_approve['do_no'] = $edit_tssck_header['do_no'];
                $tssck_to_approve['plant'] = $edit_tssck_header['plant'];
                $tssck_to_approve['receiving_plant'] = $edit_tssck_header['receiving_plant'];
                $tssck_to_approve['id_tssck_plant'] = $edit_tssck_header['id_tssck_plant'];
                $tssck_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $tssck_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_tssck_header['plant'],$edit_tssck_header['posting_date'],
                      $edit_tssck_header['id_tssck_plant'],'11');
			   /* $approved_data = $this->m_tssck->sap_tssck_header_approve($tssck_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			    $tssck_no = $approved_data['material_document'];
    			    $po_no = $approved_data['po_document'];*/
    				$data = array (
    					'id_tssck_header' =>$id_tssck_header,
    					'tssck_no'	=>	$tssck_no,
    					'po_no'	=>	$po_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$tssck_header_update_status = $this->m_tssck->tssck_header_update($data);
  				    $approve_data_success = TRUE;
			/*	} else {
				  $approve_data_success = FALSE;
				} */
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
    			  $this->l_general->success_page('Data Transfer Selisih Stock ke CK berhasil diubah', site_url('tssck/browse'));
              } else {
		    	  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Selisih Stock ke CK tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
    			  $this->l_general->success_page('Data Transfer Selisih Stock ke CK berhasil diapprove', site_url('tssck/browse'));
              } else {
	    		  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Selisih Stock ke CK tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'tssck/browse';
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
		$tssck = $_POST;
		unset($tssck['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($tssck['tssck_header']['posting_date']!=$date_today) {
			redirect('tssck/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($tssck['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('tssck/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('tssck', 1, date("Y-m-d")) {

        $edit_tssck_header = $this->m_tssck->tssck_header_select($tssck['tssck_header']['id_tssck_header']);
		$edit_tssck_details = $this->m_tssck->tssck_details_select($tssck['tssck_header']['id_tssck_header']);
    	$i = 1;
	    foreach ($edit_tssck_details->result_array() as $value) {
		    $edit_tssck_detail[$i] = $value;
		    $i++;
        }
        unset($edit_tssck_details);

		if(isset($_POST['button']['cancel'])) {

//			$tssck_header['id_tssck_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $tssck_to_cancel['tssck_no'] = $edit_tssck_header['tssck_no'];
            $tssck_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_tssck_header['posting_date']));
            $tssck_to_cancel['posting_date'] = date('Ymd',strtotime($edit_tssck_header['posting_date']));
            $tssck_to_cancel['plant'] = $edit_tssck_header['plant'];
			$tssck_to_cancel['id_tssck_plant'] = $this->m_tssck->id_tssck_plant_new_select($edit_tssck_header['plant'],date('Y-m-d',strtotime($edit_tssck_header['posting_date'])));
            $tssck_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_tssck_header['plant'],$edit_tssck_header['posting_date'],
                      $tssck_to_cancel['id_tssck_plant'],'11');
            $tssck_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_tssck_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($tssck['cancel'][$i]))
       		     $tssck_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_tssck->sap_tssck_header_cancel($tssck_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($tssck['cancel'][$i])) {
    	    			$tssck_header = array (
    						'id_tssck_header'=>$tssck['tssck_header']['id_tssck_header'],
    						'id_tssck_plant'=>$tssck_to_cancel['id_tssck_plant'],
    					);
    		    		if($this->m_tssck->tssck_header_update($tssck_header)==TRUE) {
        	    			$tssck_detail = array (
        						'id_tssck_detail'=>$edit_tssck_detail[$i]['id_tssck_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
      						if(($this->m_tssck->tssck_detail_update($tssck_detail))&&
                              ($this->m_tssck->tssck_do_outstanding_update($edit_tssck_header['do_no'],$edit_tssck_detail[$i]['material_no'],$edit_tssck_detail[$i]['gr_quantity'],'-'))) {
            				    $cancel_data_success = TRUE;
        			    	}
                      }
        			}
                }
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
    			$this->l_general->success_page('Data Transfer Selisih Stock ke CK berhasil dibatalkan', site_url('tssck/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Selisih Stock ke CK  tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_tssck_header) {

		$this->db->trans_start();

		// check approve status
		$tssck_header = $this->m_tssck->tssck_header_select($id_tssck_header);

		if($tssck_header['status'] == '1') {
			$this->m_tssck->tssck_header_delete($id_tssck_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_tssck_header) {

		if($this->_delete($id_tssck_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tssck_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tssck_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_tssck_header']))
			redirect($this->session->userdata['PAGE']['tssck_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_tssck_header'][$i])) {
				$object['data']['tssck_headers'][$j++] = $this->m_tssck->tssck_header_select($_POST['id_tssck_header'][$i]);
			}
		}

		$this->template->write_view('content', 'tssck/tssck_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_tssck_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['tssck_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'tssck_data';
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

			// is it tssck template file?
			if($excel['cells'][1][1] == 'Goods Issue Stock Transfer No' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // tssck_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same tssck header?

					$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                    $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];

					// check tssck header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($tssck_header_temp = $this->m_general->sap_plants_select_all_ck_outlet()) {

							$object['tssck_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");


							$object['tssck_headers'][$j]['receiving_plant'] = $receiving_plant;
                            $object['tssck_headers'][$j]['tssck_no'] = $excel['cells'][$i][1];
							$object['tssck_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['tssck_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['tssck_headers'][$j]['status'] = '1';
							$object['tssck_headers'][$j]['item_group_code'] = $item_group_code;
                            $object['tssck_headers'][$j]['do_no'] = $do_no;
							$object['tssck_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['tssck_headers'][$j]['filename'] = $upload['file_name'];

            	$tssck_header_exist = TRUE;
							$k = 1; // tssck_detail number
						} else {
            	$tssck_header_exist = FALSE;
						}
					}

					if($tssck_header_exist) {

						if($tssck_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['tssck_details'][$j][$k]['id_tssck_h_detail'] = $k;
							$object['tssck_details'][$j][$k]['item'] = $k;
							$object['tssck_details'][$j][$k]['material_no'] = $material_no;
							$object['tssck_details'][$j][$k]['material_desc'] = $tssck_detail_temp['MAKTX'];
							$object['tssck_details'][$j][$k]['gr_quantity'] = $gr_quantity;
                            $uom_import = $tssck_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
                			$object['tssck_details'][$j][$k]['uom'] = $uom_import;
							$k++;
						}

					}

				}

				$this->template->write_view('content', 'tssck/tssck_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer Selisih Stock ke CK atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'tssck/browse_result/0/0/0/0/0/0/0/10';
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

		// is it tssck template file?
		if($excel['cells'][1][1] == 'Goods Issue Stock Transfer No' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // tssck_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same tssck header?

				$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                    $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];

				// check tssck header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
					if($tssck_header_temp = $this->m_general->sap_plants_select_all_ck_outlet())

						$object['tssck_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

                        $object['tssck_headers'][$j]['receiving_plant'] = $receiving_plant;
                            $plant = $this->m_general->sap_plant_select($receiving_plant);
                       		$object['tssck_headers'][$j]['receiving_plant_name'] = $plant['NAME1'];
							$object['tssck_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['tssck_headers'][$j]['id_tssck_plant'] = $this->m_tssck->id_tssck_plant_new_select($object['tssck_headers'][$j]['plant'],$object['tssck_headers'][$j]['posting_date']);
							$object['tssck_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['tssck_headers'][$j]['status'] = '1';
							$object['tssck_headers'][$j]['item_group_code'] = $item_group_code;
                            $object['tssck_headers'][$j]['do_no'] = $do_no;
							$object['tssck_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['tssck_headers'][$j]['filename'] = $upload['file_name'];

						$id_tssck_header = $this->m_tssck->tssck_header_insert($object['tssck_headers'][$j]);

           	$tssck_header_exist = TRUE;
						$k = 1; // tssck_detail number

					} else {
           	$tssck_header_exist = FALSE;
					}
				}

				if($tssck_header_exist) {

					if($tssck_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

						$object['tssck_details'][$j][$k]['id_tssck_header'] = $id_tssck_header;
						$object['tssck_details'][$j][$k]['id_tssck_h_detail'] = $k;

						$object['tssck_details'][$j][$k]['material_no'] = $material_no;
						$object['tssck_details'][$j][$k]['material_desc'] = $tssck_detail_temp['MAKTX'];
						$object['tssck_details'][$j][$k]['gr_quantity'] = $gr_quantity;

                        $uom_import = $tssck_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['tssck_details'][$j][$k]['uom'] = $uom_import;

						$id_tssck_detail = $this->m_tssck->tssck_detail_insert($object['tssck_details'][$j][$k]);

						$k++;
					}

				}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Selisih Stock ke CK berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['tssck_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer Selisih Stock ke CK atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'tssck/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
}
?>