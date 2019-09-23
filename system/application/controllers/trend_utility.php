<?php
class trend_utility extends Controller {
	private $jagmodule = array();


	function trend_utility() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1053);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_trend_utility'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_trend_utility');

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
		$trend_utility_browse_result = $this->session->userdata['PAGE']['trend_utility_browse_result'];

		if(!empty($trend_utility_browse_result))
			redirect($this->session->userdata['PAGE']['trend_utility_browse_result']);
		else
			redirect('trend_utility/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('trend_utility/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('trend_utility/browse_result/a/0/'.$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('trend_utility_browse_result');

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
			'a'	=>	'Document No',

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

		$sort_link1 = 'trend_utility/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
			'hy'	=>	$sort_link1.'hy'.$sort_link2,
			'hz'	=>	$sort_link1.'hz'.$sort_link2,
			'iy'	=>	$sort_link1.'iy'.$sort_link2,
			'iz'	=>	$sort_link1.'iz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('trend_utility/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');
//		$config['base_url'] = site_url('trend_utility/browse_result/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_trend_utility->trend_utility_headers_count_by_criteria($field_name, $field_type,$field_content, $date_from2, $date_to2, $status, $sort);;
//		$config['total_rows'] = $this->m_trend_utility->trend_utilitys_count_by_criteria($date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['trend_utilitys'] = $this->m_trend_utility->trend_utility_headers_select_by_criteria($field_name, $field_type,$field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Trend Utility ( Usage )';
		$this->template->write_view('content', 'trend_utility/trend_utility_browse', $object);
		$this->template->render();

	}

	// input data
	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
    		$this->session->set_userdata('posting_date', $data['posting_date']);
	 			$this->_data_form(0, $data);
	   	} else {
	 			$this->_data_form();
	     }

		} else {
			$this->_data_add();
		}

	}

	function edit() {

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
    		$this->session->set_userdata('posting_date', $data['posting_date']);
  			$this->_data_form(0, $data);
    	} else {
            $data = $this->m_trend_utility->trend_utility_header_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
		$this->form_validation->set_rules('kwh_awal', 'KWH Awal', 'is_numeric_no_zero');
		$this->form_validation->set_rules('kwh_akhir', 'KWH Akhir', 'is_numeric_no_zero');
		$this->form_validation->set_rules('kwh_total', 'KWH Total', 'trim|required');
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
            $kwh_awal = $this->m_trend_utility->trend_utility_select_kwh_akhir();
            $object['data']['kwh_awal'] = $kwh_awal['kwh_akhir'];
		}
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Trend Utility (Usage)';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'trend_utility/trend_utility_input', $object);
		$this->template->render();
	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$trend_utility = $_POST;
		unset($trend_utility['button']);

		$this->db->trans_start();

        $data_tmp = array('posting_date' => '');
        $this->session->unset_userdata($data_tmp);
        unset($data_tmp);

		// end of assign variables and delete not used variables
//echo "<pre>";
//print '$request_reasons ';
//print_r($trend_utility);
//echo "</pre>";
        $trend_utility['posting_date'] = $this->l_general->str_to_date($trend_utility['posting_date']);
        $trend_utility['jam_pencatatan'] = date('H:s:i');
		$trend_utility['id_trend_utility_plant'] = $this->m_trend_utility->id_trend_utility_plant_new_select($trend_utility['plant'],$trend_utility['posting_date']);
    	$trend_utility['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
		if((($id_trend_utility_header = $this->m_trend_utility->trend_utility_add($trend_utility))&&(isset($_POST['button']['save'])))) {
          $this->_input_success();
		}
		$this->db->trans_complete();

        if(isset($_POST['button']['approve'])) {
          $trend_utility['id_trend_utility_header'] = $id_trend_utility_header;
          $this->approve_trend_utility($trend_utility);
        }
	}

	function _input_success() {
    	$object['page_title'] = 'Data Trend Utility (usage) Berhasil Dimasukkan';
    	$object['refresh'] = 1;
    	$object['refresh_text'] = 'Data Trend Utility (usage) berhasil dimasukkan.';
    	$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

    	$this->template->write_view('content', 'refresh', $object);
    	$this->template->render();
	}

	function approve_trend_utility($data) {
      $data['web_trans_id'] = $this->l_general->_get_web_trans_id($data['plant'],$data['posting_date'],
                              $data['id_trend_utility_plant'],'12');
      $approved_data = $this->m_trend_utility->sap_trend_utility_header_approve($data);
      if(!empty($approved_data['material_document'])) {
         $trend_utility_no = $approved_data['material_document'];
          $data = array (
          	'id_trend_utility_header'	=>$data['id_trend_utility_header'],
          	'trend_utility_no'	=>	$trend_utility_no,
          	'status'	=>	'2',
          	'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
          );
          if($this->m_trend_utility->trend_utility_update($data) == TRUE) {
            $this->_input_approve_success('Data Trend Utility berhasil di approved.');
          }
      } else {
       $err_msg = 'Data Trend Utility tidak  berhasil diapprove.<br>
                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'];
       $this->_input_approve_failed($err_msg);
      }
    }

	function cancel_trend_utility($data) {
   	  $data['id_trend_utility_plant'] = $this->m_trend_utility->id_trend_utility_plant_new_select($data['plant'],$data['posting_date']);
      $data['web_trans_id'] = $this->l_general->_get_web_trans_id($data['plant'],$data['posting_date'],
                              $data['id_trend_utility_plant'],'12');
      $cancelled_data = $this->m_trend_utility->sap_trend_utility_header_cancel($data);
      if(!empty($cancelled_data['material_document'])) {
         $trend_utility_no = $cancelled_data['material_document'];
          $data = array (
          	'id_trend_utility_header'=>$data['id_trend_utility_header'],
			'id_trend_utility_plant'=>$data['id_trend_utility_plant'],
          	'material_docno_cancellation'=>$trend_utility_no,
          	'id_user_cancel'	=>	$this->session->userdata['ADMIN']['admin_id'],
          );
          if($this->m_trend_utility->trend_utility_update($data) == TRUE) {
              $this->_input_approve_success('Data Trend Utility berhasil di batalkan.');
          }
      } else {
       $err_msg = 'Data Trend Utility tidak  berhasil di batalkan.<br>
                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'];
       $this->_input_approve_failed($err_msg);
      }
    }

	function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success($text_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $text_messages;
      	$object['refresh_url'] = 'trend_utility/browse';
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _data_update()	{
		// start of assign variables and delete not used variables
		$trend_utility = $_POST;
		unset($trend_utility['button']);
		// end of assign variables and delete not used variables

		$this->db->trans_start();

        $data_tmp = array('posting_date' => '');
        $this->session->unset_userdata($data_tmp);
        unset($data_tmp);

//echo "<pre>";
//print '$trend_utility ';
//print_r($trend_utility);
//echo "</pre>";
//exit;
        $trend_utility['jam_pencatatan'] = date('H:s:i');
        $trend_utility['posting_date'] = $this->l_general->str_to_date($trend_utility['posting_date']);
		$trend_utility['id_trend_utility_plant'] = $this->m_trend_utility->id_trend_utility_plant_new_select("",$trend_utility['posting_date'],$trend_utility['id_trend_utility_header']);
    	$trend_utility['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
		if(($this->m_trend_utility->trend_utility_update($trend_utility))&&(isset($_POST['button']['save']))) {
           $this->_edit_success();
		}
		$this->db->trans_complete();
        if(isset($_POST['button']['approve'])) {
          $this->approve_trend_utility($trend_utility);
        }
        if(isset($_POST['button']['cancel'])) {
          $this->cancel_trend_utility($trend_utility);
        }

	}

	function _edit_success() {
    	$object['page_title'] = 'Data Trend Utility (usage) Berhasil Diubah';
    	$object['refresh'] = 1;
    	$object['refresh_text'] = 'Data Trend Utility (usage) berhasil diubah.';
      		$object['refresh_url'] = 'trend_utility/browse';
    	$this->template->write_view('content', 'refresh', $object);
    	$this->template->render();
	}

	function _delete($id_trend_utility_header) {

		$this->db->trans_start();

		// check approve status
		$trend_utility_header = $this->m_trend_utility->trend_utility_header_select($id_trend_utility_header);

		if($trend_utility_header['status'] == '1') {
			$this->m_trend_utility->trend_utility_header_delete($id_trend_utility_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_trend_utility_header) {

		if($this->_delete($id_trend_utility_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Trend Utility berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['trend_utility_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Trend Utility gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['trend_utility_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '002';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_trend_utility_header']))
			redirect($this->session->userdata['PAGE']['trend_utility_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_trend_utility_header'][$i])) {
				$object['data']['trend_utility_headers'][$j++] = $this->m_trend_utility->trend_utility_header_select($_POST['id_trend_utility_header'][$i]);
			}
		}

		$this->template->write_view('content', 'trend_utility/trend_utility_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_trend_utility_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Trend Utility berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['trend_utility_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

    function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'trend_utility_data';
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

//			$file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php/excel_upload/'.$upload['file_name'];
			 if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];


			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it trend_utility template file?
			if($excel['cells'][1][1] == 'Document No.' && $excel['cells'][1][2] == 'Kwh Awal.') {

				$j = 0; // trend_utility_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same trend_utility header?

					$kwh_awal = $excel['cells'][$i][2];
				 	$kwh_akhir = $excel['cells'][$i][3];
					$kwh_total = $excel['cells'][$i][4];

					// check trend_utility header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;


							$object['trend_utility_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['trend_utility_headers'][$j]['trend_utility_no'] = $excel['cells'][$i][1];
							$object['trend_utility_headers'][$j]['kwh_awal'] = $kwh_awal;
                            $object['trend_utility_headers'][$j]['kwh_akhir'] = $kwh_akhir;
                            $object['trend_utility_headers'][$j]['kwh_total'] = $kwh_total;
                            $object['trend_utility_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
						    $object['trend_utility_headers'][$j]['status'] = '1';
							$object['trend_utility_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['trend_utility_headers'][$j]['filename'] = $upload['file_name'];


					}

				   }

				$this->template->write_view('content', 'trend_utility/trend_utility_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Trend Utility (Usage) atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'trend_utility/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '003';
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

		// is it trend_utility template file?
	  	if($excel['cells'][1][1] == 'Document No.'&& $excel['cells'][1][2] == 'Kwh Awal.') {

			$this->db->trans_start();

			$j = 0; // trend_utility_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same trend_utility header?

			  	$kwh_awal = $excel['cells'][$i][2];
				 	$kwh_akhir = $excel['cells'][$i][3];
					$kwh_total = $excel['cells'][$i][4];

				// check trend_utility header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;


							$object['trend_utility_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
							$object['trend_utility_headers'][$j]['kwh_awal'] = $kwh_awal;
                            $object['trend_utility_headers'][$j]['kwh_akhir'] = $kwh_akhir;
                            $object['trend_utility_headers'][$j]['kwh_total'] = $kwh_total;
                            $object['trend_utility_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
                            $object['trend_utility_headers'][$j]['id_trend_utility_plant'] = $this->m_trend_utility->id_trend_utility_plant_new_select($object['trend_utility_headers'][$j]['plant'],$object['trend_utility_headers'][$j]['posting_date']);
						  	$object['trend_utility_headers'][$j]['status'] = '1';
                            $object['trend_utility_headers'][$j]['jam_pencatatan'] =   date('H:s:i');;
							$object['trend_utility_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['trend_utility_headers'][$j]['filename'] = $upload['file_name'];

						$id_trend_utility_header = $this->m_trend_utility->trend_utility_add($object['trend_utility_headers'][$j]);


				}

			  	}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Trend Utility (usage) berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['trend_utility_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Trend Utility (Usage) atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'trend_utility/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '004';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
}
