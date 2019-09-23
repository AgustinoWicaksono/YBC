<?php
class posinc extends Controller {
	private $jagmodule = array();


	function posinc() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1042);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_posinc'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_posinc');

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
		$posinc_browse_result = $this->session->userdata['PAGE']['posinc_browse_result'];

		if(!empty($posinc_browse_result))
			redirect($this->session->userdata['PAGE']['posinc_browse_result']);
		else
			redirect('posinc/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('posinc/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('posinc/browse_result/a/0/'.$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('posinc_browse_result');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
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

		$object['data']['sort'] = $sort;

		$object['data']['status'] = $status;
		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;

		$object['field_name'] = array (
			'a'	=>	'Waste Material Doc. No',
			'b'	=>	'Stock Opname Doc. No',

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

		$sort_link1 = 'posinc/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('posinc/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_posinc->posinc_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['posinc_headers'] = $this->m_posinc->posinc_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List End Of Day';
		$this->template->write_view('content', 'posinc/posinc_browse', $object);
		$this->template->render();

	}

	// input data
	function input()	{

		$this->_input_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   	    $data = $_POST;
    		$this->session->set_userdata('posting_date', $data['posting_date']);
	 		$this->_input_form(0, $data);
	   	} else {
 			$this->_input_form();
	     }

		} else {
			$this->_input_add();
		}

	}

	function input_transaksi_baru_error($posting_date) {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Transaksi End of Day untuk tanggal '.date('d-m-Y',strtotime($posting_date)).' sudah ada. Silahkan periksa kembali.<br>
                                   Anda hanya bisa memasukkan 1 transaksi End of Day dalam 1 tanggal.';
        $object['refresh_url'] = 'posinc/browse';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function edit_tgl_transaksi_error($posting_date) {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Transaksi End of Day untuk tanggal '.date('d-m-Y',strtotime($posting_date)).' sudah ada. Silahkan periksa kembali<br>
                                   Anda hanya bisa menginput 1 transaksi End of Day dalam 1 tanggal';
        $object['refresh_url'] = 'posinc/browse';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '002';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function edit() {

		$this->_input_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
    		$this->session->set_userdata('posting_date', $data['posting_date']);
  			$this->_data_form(0, $data);
    	} else {
            $data = $this->m_posinc->posinc_header_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
        }

		} else {
			$this->_data_update();
        }

	}

	function _input_check() {
		if(isset($_POST['id_posinc_header'])) {
          $this->form_validation->set_rules('ok', 'End of Day', 'trim|required');
		  $this->form_validation->set_rules('total_remintance', 'Total Remintance', 'trim|required');
    	}
    }

	function _input_form($reset=0, $data=NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $object array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
            $object['data']['status'] = 1;
            $object['data']['plant'] = $this->session->userdata['ADMIN']['plant'];
            $object['data']['status_string'] = 'Not Approved';
		}

		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);


		// end of form attributes
/*        if ($data == NULL) {
           $posting_date = $this->m_general->posting_date_select_max();
           $id_posinc_outlet = $this->m_posinc->posinc_header_select_id_by_posting_date($posting_date);
        } else
           $id_posinc_outlet = FALSE;
        if ($id_posinc_outlet !== FALSE) {
			redirect('posinc/input_transaksi_baru_error/'.$posting_date);
        } else {*/
    		$this->l_page->save_page('next');
    		$object['page_title'] = 'End of Day';
    		$this->template->write_view('content', 'posinc/posinc_input', $object);
    		$this->template->render();
//        }
	}

	function _data_form($reset=0, $data=NULL) {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
            $object['data']['status'] = 1;
            $object['data']['plant'] = $this->session->userdata['ADMIN']['plant'];
            $object['data']['status_string'] = 'Not Approved';
			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'End Of Day';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'posinc/posinc_input', $object);
		$this->template->render();
	}

    function _input_add() {
			// start of assign variables and delete not used variables
			$posinc = $_POST;

			$data_tmp = array('posting_date' => '');
			$this->session->unset_userdata($data_tmp);
			unset($data_tmp);

			if(((isset($_POST['button']['approve_waste']))||(isset($_POST['button']['approve_stockopname'])))&&($this->m_general->check_is_can_approve($posinc['posting_date'])==FALSE)) {
			   redirect('posinc/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
			} else {

			$posinc['posting_date'] = $this->l_general->str_to_date($posinc['posting_date']);

			$id_posinc_outlet = $this->m_posinc->posinc_header_select_id_by_posting_date($posinc['posting_date']);
			if($id_posinc_outlet != FALSE) {
				redirect('posinc/input_transaksi_baru_error/'.$posinc['posting_date']);
			} else {
				$this->db->trans_start();
				unset($posinc['button']);
				// end of assign variables and delete not used variables
				$posinc['id_posinc_plant'] = $this->m_posinc->id_posinc_plant_new_select($posinc['plant']);
				$id_posinc_header = $this->m_posinc->posinc_add($posinc);
				if((($id_posinc_header!=FALSE)&&(isset($_POST['button']['save'])))) {
				  $this->l_general->success_page('Data End of Day Berhasil Dimasukkan', site_url('posinc/browse'));
				}
				$this->db->trans_complete();
				if(($id_posinc_header!=FALSE)&&(isset($_POST['button']['approve_waste']))) {
				  $this->approve_waste($id_posinc_header,$posinc['posting_date']);
				}
				if(($id_posinc_header!=FALSE)&&(isset($_POST['button']['approve_stockopname']))) {
				  $this->approve_stockoutlet($id_posinc_header,$posinc['posting_date']);
				}

			}

			}
	}
/*
	function _input_success() {
    	$object['page_title'] = 'Data End of Day Berhasil Dimasukkan';
    	$object['refresh'] = 1;
    	$object['refresh_text'] = 'Data End of Day berhasil dimasukkan.';
   		$object['refresh_url'] = 'posinc/browse';
    	$this->template->write_view('content', 'refresh', $object);
    	$this->template->render();
	}
  */
	function _data_update()	{
			// start of assign variables and delete not used variables
			$posinc = $_POST;
			unset($posinc['button']);

			$data_tmp = array('posting_date' => '');
			$this->session->unset_userdata($data_tmp);
			unset($data_tmp);

			if(((isset($_POST['button']['approve_waste']))||(isset($_POST['button']['approve_stockopname'])))&&($this->m_general->check_is_can_approve($posinc['posting_date'])==FALSE)) {
			   redirect('posinc/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
			} else {

			$posinc['posting_date'] = $this->l_general->str_to_date($posinc['posting_date']);

			if($this->m_posinc->posinc_header_select_other_id_by_posting_date($posinc['id_posinc_header'],$posinc['posting_date'])) {
				redirect('posinc/edit_tgl_transaksi_error/'.$posinc['posting_date']);
			} else {
				// end of assign variables and delete not used variables
				$this->db->trans_start();
				$data = array (
					'id_posinc_header'	=>$posinc['id_posinc_header'],
					'total_remintance'	=>	$posinc['total_remintance'],
					'ok'	=>	$posinc['ok'],
				);
				$update_succeed = $this->m_posinc->posinc_update($data);
				if(($update_succeed)&&(isset($_POST['button']['save']))) {
				  $this->l_general->success_page('Data End of Day Berhasil diubah', site_url('posinc/browse'));
				}
				$this->db->trans_complete();
				if(($update_succeed)&&(isset($_POST['button']['approve_waste']))) {
				  $this->approve_waste($posinc['id_posinc_header'],$posinc['posting_date']);
				}
				if(($update_succeed)&&(isset($_POST['button']['approve_stockopname']))) {
				  $this->approve_stockoutlet($posinc['id_posinc_header'],$posinc['posting_date']);
				}
			}

			}
	}

	function approve_waste($id_posinc_header,$posinc_posting_date) {
     // $approved_data = $this->m_posinc->sap_waste_header_approve($posinc_posting_date);
      //if(!empty($approved_data['material_document'])) {
        // $waste_no = $approved_data['material_document'];
		$id_waste_header = $this->m_waste->waste_header_select_id_by_posting_date($posinc_posting_date);
		$approved_data['id_waste_header'] = $id_waste_header;
          $data = array (
          	'id_posinc_header'	=>$id_posinc_header,
          	'waste_no'	=>	$waste_no,
          	'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
          );
          if ($this->m_posinc->posinc_update($data)==TRUE) {
            $data = array (
            	'id_waste_header'	=>$approved_data['id_waste_header'],
              	'status'	=>	'2',
              	'material_doc_no'	=>	$waste_no,
            	'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id']
            );
            if($this->m_waste->waste_header_update($data) == TRUE) {
              $data = array (
            	'posting_date'	=>$posinc_posting_date,
              	'status_eod_waste'	=>	1,
                );
              if($this->m_posinc->t_status_eod_update($data) == TRUE) {
                $this->_input_approve_success('Data Waste berhasil di approved.');
              }
            }
          }
    /*  } else {
       $err_msg = 'Data Waste tidak berhasil diapprove.<br>
                   Pesan Kesalahan dari sistem SAP: '.$approved_data['sap_messages'];
       $this->_input_approve_failed($err_msg);
      }*/
    }

	function approve_stockoutlet($id_posinc_header,$posinc_posting_date) {
		$swbsuccess = "";
		  //$approved_data = $this->m_posinc->sap_stockoutlet_waste_header_approve($posinc_posting_date);
		  //if(!empty($approved_data['material_document'])) {
			// $stockoutlet_no = $approved_data['material_document'];
			$id_stockouptlet_header = $this->m_stockoutlet->stockoutlet_header_select_id_by_posting_date($posinc_posting_date);
			$id_waste_header = $this->m_waste->waste_header_select_id_by_posting_date($posinc_posting_date);
			$approved_data['id_waste_header'] = $id_waste_header;
			$approved_data['id_stockoutlet_header'] = $id_stockouptlet_header;
			  $data = array (
				'id_posinc_header'	=>	$id_posinc_header,
				'stockoutlet_no'	=>	$stockoutlet_no,
				'waste_no'			=>	$stockoutlet_no,
				'status'			=>	'2',
				'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
			  );
			  if ($this->m_posinc->posinc_update($data)==TRUE) {
				unset($data);
				$data = array (
					'id_stockoutlet_header'	=>$approved_data['id_stockoutlet_header'],
					'status'	=>	'2',
					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id']
				);
				if($this->m_stockoutlet->stockoutlet_header_update($data) == TRUE) {
					unset($data);
				  $data = array (
					'posting_date'	=>$posinc_posting_date,
					'status_eod_opname'	=>	1,
					);
				  if($this->m_posinc->t_status_eod_update($data) == TRUE) {
					$swbsuccess .= "Data Stock Opname berhasil di approved.<br>";
				  }
				}
				unset($data);
				$data = array (
					'id_waste_header'	=>	$approved_data['id_waste_header'],
					'status'			=>	'2',
					'material_doc_no'	=>	$stockoutlet_no,
					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id']
				);
				if($this->m_waste->waste_header_update($data) == TRUE) {
					unset($data);
				  $data = array (
					'posting_date'	=>$posinc_posting_date,
					'status_eod_waste'	=>	1,
					);
				  if($this->m_posinc->t_status_eod_update($data) == TRUE) {
					$swbsuccess .= "Data Waste berhasil di approved.<br>";
				  }
				}
				if ($swbsuccess!="")
					$this->_input_approve_success($swbsuccess);
			  }
		/*  } else {
			$pesanerror = $approved_data['sap_messages'];
			$analisaerror = "";
			if (strpos($pesanerror,"Duplicate Material Number")>0)
				$analisaerror = "<br>ANALISA KESALAHAN: Anda salah memasukkan UOM dalam file Excel pada kode item/material yang ditunjuk dalam penjelasan di bawah ini. Harap koreksi UOM sesuai standar yang diberikan.<br><br>";
			$err_msg = 'Data Stock Opname dan Waste Material gagal disetujui.'.$analisaerror.'<br>======================================<br>Pesan Kesalahan dari sistem SAP: '.$pesanerror;
			$this->_input_approve_failed($err_msg);
		  }*/
    }

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _input_approve_failed($error_messages) {
	    $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, $error_messages, site_url($this->session->userdata['PAGE']['next']));
	}

	function _input_approve_success($text_messages) {
  	    $this->l_general->success_page($text_messages, site_url('posinc/browse'));
	}
      /*
	function _edit_success() {
    	$object['page_title'] = 'Data End of Day  Berhasil Diubah';
    	$object['refresh'] = 1;
    	$object['refresh_text'] = 'Data End of Day berhasil diubah.';
      	$object['refresh_url'] = 'posinc/browse';
    	$this->template->write_view('content', 'refresh', $object);
    	$this->template->render();
	}
        */

// view ga jadi
/*	function view() {

		$this->_view_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->_view_form(0, $data);
			} else {
				$data = $this->m_posinc->posinc_header_select($this->uri->segment(3));
				$this->_view_form(0, $data);
			 }

		} else {
			$this->_view_update();
		 }

	}
*/

	function _delete($id_posinc_header) {

		// check approve status
		$posinc_header = $this->m_posinc->posinc_header_select($id_posinc_header);

		if($posinc_header['status'] == '1') {
			$this->m_posinc->posinc_header_delete($id_posinc_header);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_posinc_header) {

		if($this->_delete($id_posinc_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data List of End of Day berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['posinc_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data List of End of Day gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['posinc_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '006';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_posinc_header']))
			redirect($this->session->userdata['PAGE']['posinc_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_posinc_header'][$i])) {
				$object['data']['posinc_headers'][$j++] = $this->m_posinc->posinc_header_select($_POST['id_posinc_header'][$i]);
			}
		}

		$this->template->write_view('content', 'posinc/posinc_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_posinc_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data List of End of day berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['posinc_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

}
