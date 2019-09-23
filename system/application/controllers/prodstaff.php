<?php
class prodstaff extends Controller {
	private $jagmodule = array();


	function prodstaff() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1045);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_prodstaff'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_prodstaff');

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
		$prodstaff_browse_result = $this->session->userdata['PAGE']['prodstaff_browse_result'];

		if(!empty($prodstaff_browse_result))
			redirect($this->session->userdata['PAGE']['prodstaff_browse_result']);
		else
			redirect('prodstaff/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('prodstaff/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('prodstaff/browse_result/a/0/'.$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('prodstaff_browse_result');

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
			'a'	=>	'Material Document No',
			
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

		$sort_link1 = 'prodstaff/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('prodstaff/browse_result/a/0/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_prodstaff->prodstaff_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['prodstaff_headers'] = $this->m_prodstaff->prodstaff_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Productivity Staff / Labour per Store per hari per jam per Departement';
		$this->template->write_view('content', 'prodstaff/prodstaff_browse', $object);
		$this->template->render();

	}


  	// input data
	function input()	{
		$validation = FALSE;

		if(count($_POST) != 0) {

    		// first post, assume all data TRUE
    		$validation_temp = TRUE;

/*    		$count = count($_POST['prodstaff_detail']['id_prodstaff_h_detail']);
    		$i = 1; // counter for each row
    		$j = 1; // counter for each field

    		// for POST data
    		for($i = 1; $i <= $count; $i++) {
    			$check[$j] = $this->l_form_validation->set_rules($_POST['prodstaff_detail']['jml_karyawan'][$i], "prodstaff_detail[jml_karyawan][$i]", 'Sum of Empoyee (Attendance). '.$i, 'required|is_natural_no_zero');

    			// if one data FALSE, set $validation_temp to FALSE
    			if($check[$j]['error'] == TRUE)
    				$validation_temp = FALSE;

    			$j++;
    		}

    		// set $validation, based on $validation_temp value;
            */
    		$validation = $validation_temp;
		}

		if ($validation == FALSE) {
    	   	if(!empty($_POST)) {
    	   		$data = $_POST;
     			$this->_data_form(0, $data);
    	   	} else {
    	 			$this->_data_form();
     	    }

		} else {
			$this->_data_add();
		}

	}

	function edit() {

		$validation = FALSE;

		if(count($_POST) != 0) {

    		// first post, assume all data TRUE
    		$validation_temp = TRUE;

/*    		$count = count($_POST['prodstaff_detail']['id_prodstaff_h_detail']);
    		$i = 1; // counter for each row
    		$j = 1; // counter for each field

    		// for POST data
    		for($i = 1; $i <= $count; $i++) {
    			$check[$j] = $this->l_form_validation->set_rules($_POST['prodstaff_detail']['jml_karyawan'][$i], "prodstaff_detail[jml_karyawan][$i]", 'Sum of Empoyee (Attendance). '.$i, 'required|is_natural_no_zero');

    			// if one data FALSE, set $validation_temp to FALSE
    			if($check[$j]['error'] == TRUE)
    				$validation_temp = FALSE;

    			$j++;
    		}

    		// set $validation, based on $validation_temp value;
            */
    		$validation = $validation_temp;
		}

		if ($validation == FALSE) {

    	if(!empty($_POST)) {
      		$data = $_POST;
   			$this->_data_form(0, $data);
      	} else {
          $data = $this->m_prodstaff->prodstaff_header_select($this->uri->segment(3));
 		  $this->_data_form(0, $data);
          }
  		} else {
      		$this->_data_update();
        }

	}

	function _data_form($reset=0, $data=NULL) {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data']['prodstaff_header'] = $data;
            $object['data']['prodstaff_details'] = $this->m_prodstaff->prodstaff_details_select($data['id_prodstaff_header']);
//echo "<pre>";
//print 'prodstaff_details ';
//print_r($object['data']['prodstaff_details']);
//echo "</pre>";
//exit;
		} else {
			$object['data']['prodstaff_header'] = NULL;
            $object['data']['prodstaff_header']['status'] = 1;
            $object['data']['prodstaff_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
            $object['data']['prodstaff_header']['status_string'] = 'Not Approved';
            $object['data']['prodstaff_details'] =$this->m_prodstaff->prodstaff_detail_select_posisi_status();
			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes


        $object['page_title'] = 'Trend Utility (Usage)';

		$this->l_page->save_page('next');
        	$this->template->write_view('content', 'prodstaff/prodstaff_input', $object);
		$this->template->render();
		$this->template->render();
	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$prodstaff_header = $_POST['prodstaff_header'];
		$prodstaff_detail = $_POST['prodstaff_detail'];
        $prodstaff = $_POST;
        unset($prodstaff['button']);
		// end of assign variables and delete not used variables

//echo "<pre>";
//print '$prodstaff_header ';
//print_r($prodstaff_header);
//echo "</pre>";

//echo "<pre>";
//print '$prodstaff_detail ';
//print_r($prodstaff_detail);
//echo "</pre>";
//exit;

        $prodstaff_header['posting_date'] = $this->l_general->str_to_date($prodstaff_header['posting_date']);
		$prodstaff_header['id_prodstaff_plant'] = $this->m_prodstaff->id_prodstaff_plant_new_select($prodstaff_header['plant'],$prodstaff_header['posting_date']);

		if($id_prodstaff_header = $this->m_prodstaff->prodstaff_header_insert($prodstaff_header)) {
          $count = count($prodstaff_detail['id_prodstaff_h_detail']);
          $input_detail_success = FALSE;
          for($i=1;$i<=$count;$i++) {
              $prodstaff_detail_to_save['id_prodstaff_header'] = $id_prodstaff_header;
              $prodstaff_detail_to_save['id_prodstaff_h_detail'] = $prodstaff_detail['id_prodstaff_h_detail'][$i];
              $prodstaff_detail_to_save['id_posisi'] = $prodstaff_detail['id_posisi'][$i];
              $prodstaff_detail_to_save['posisi'] = $prodstaff_detail['posisi'][$i];
              $prodstaff_detail_to_save['id_status'] = $prodstaff_detail['id_status'][$i];
              $prodstaff_detail_to_save['status'] = $prodstaff_detail['status'][$i];
              $prodstaff_detail_to_save['jml_karyawan'] = $prodstaff_detail['jml_karyawan'][$i];
              $prodstaff_detail_to_save['total_jam'] = $prodstaff_detail['total_jam'][$i];
              if($id_prodstaff_detail = $this->m_prodstaff->prodstaff_detail_insert($prodstaff_detail_to_save)) {
                $input_detail_success = TRUE;
              }
          }
        }
        if (($input_detail_success == TRUE)&&(isset($_POST['button']['save']))) {
			$object['page_title'] = 'Data Produktivity Staff Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Produktivity Staff berhasil dimasukkan.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
        }

        if(($input_detail_success == TRUE)&&(isset($_POST['button']['approve']))) {
          $prodstaff['prodstaff_header']['id_prodstaff_header'] = $id_prodstaff_header;
          $this->approve_prodstaff($prodstaff);
        }

	}

	function approve_prodstaff($data) {
      $data['web_trans_id'] = $this->l_general->_get_web_trans_id($data['prodstaff_header']['plant'],
                              $data['prodstaff_header']['posting_date'],
                              $data['prodstaff_header']['id_prodstaff_plant'],'13');
      $approved_data = $this->m_prodstaff->sap_prodstaff_header_approve($data);
      if(($approved_data['sap_messages_type'])=='S'||empty($approved_data['sap_messages_type'])) {
          $prodstaff_no = $approved_data['material_document'];
          $data_to_save = array (
          	'id_prodstaff_header'	=>$data['prodstaff_header']['id_prodstaff_header'],
          	'status'=>'2',
          	'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
          );
          if($this->uri->segment(2) == 'edit')
            $ket = 'changed';
          else
            $ket = 'approved';
          if($this->m_prodstaff->prodstaff_header_update($data_to_save) == TRUE) {
            $this->_input_approve_success('Data Trend Utility berhasil di '.$ket.'.');
          }
      } else {
       $err_msg = 'Data Trend Utility tidak  berhasil di '.$ket.'.<br>
                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'];
       $this->_input_approve_failed($err_msg);
      }
    }

	function _input_approve_failed($error_messages) {
		$object['refresh'] = 0;
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
      	$object['refresh_url'] = 'prodstaff/browse';
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}


	function _data_update()	{
		// start of assign variables and delete not used variables
		$prodstaff_header = $_POST['prodstaff_header'];
		$prodstaff_detail = $_POST['prodstaff_detail'];
        $prodstaff = $_POST;
        unset($prodstaff['button']);

//echo "<pre>";
//print '$prodstaff_header ';
//print_r($prodstaff_header);
//echo "</pre>";

//echo "<pre>";
//print '$prodstaff ';
//print_r($prodstaff);
//echo "</pre>";
//exit;

		// end of assign variables and delete not used variables

        $prodstaff_header['posting_date'] = $this->l_general->str_to_date($prodstaff_header['posting_date']);
		$prodstaff_header['id_prodstaff_plant'] = $this->m_prodstaff->id_prodstaff_plant_new_select("",$prodstaff_header['posting_date'],$prodstaff_header['id_prodstaff_header']);
        $prodstaff['prodstaff_header']['posting_date'] = $prodstaff_header['posting_date'];
		if($this->m_prodstaff->prodstaff_header_update($prodstaff_header)) {
          $input_detail_success = FALSE;
          $count = count($prodstaff_detail['id_prodstaff_h_detail']);
          for($i=1;$i<=$count;$i++) {
              $prodstaff_detail_to_save['id_prodstaff_detail'] = $prodstaff_detail['id_prodstaff_detail'][$i];
              $prodstaff_detail_to_save['jml_karyawan'] = $prodstaff_detail['jml_karyawan'][$i];
              $prodstaff_detail_to_save['total_jam'] = $prodstaff_detail['total_jam'][$i];
              if($this->m_prodstaff->prodstaff_detail_update($prodstaff_detail_to_save)) {
                $input_detail_success = TRUE;
              }
          }
        }

        if (($input_detail_success == TRUE)&&(isset($_POST['button']['save']))) {
			$object['page_title'] = 'Data Trend Utility (usage) Berhasil Diubah';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Trend Utility (usage) berhasil diubah.';
    		$object['refresh_url'] = 'prodstaff/browse';
			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		}

        if(($input_detail_success == TRUE)&&((isset($_POST['button']['approve']))||(isset($_POST['button']['change'])))) {
          $this->approve_prodstaff($prodstaff);
        }

	}

	function _delete($id_prodstaff_header) {

		$this->db->trans_start();

		// check approve status
		$prodstaff_header = $this->m_prodstaff->prodstaff_header_select($id_prodstaff_header);

		if($prodstaff_header['status'] == '1') {
			$this->m_prodstaff->prodstaff_header_delete($id_prodstaff_header);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_prodstaff_header) {

		if($this->_delete($id_prodstaff_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Productivity Staff berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['prodstaff_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Productivity Staff gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['prodstaff_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '002';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_prodstaff_header']))
			redirect($this->session->userdata['PAGE']['prodstaff_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_prodstaff_header'][$i])) {
				$object['data']['prodstaff_headers'][$j++] = $this->m_prodstaff->prodstaff_header_select($_POST['id_prodstaff_header'][$i]);
			}
		}

		$this->template->write_view('content', 'prodstaff/prodstaff_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_prodstaff_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Productivity Staff berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['prodstaff_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

       	function file_import() {

	$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'prodstaff_data';
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
			$this->session->set_userdata('file_name_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpo template file?
			if($excel['cells'][1][1] == 'Produktivity .No' && $excel['cells'][1][2] == 'Position') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$position = $excel['cells'][$i][2];
					$employee_status = $excel['cells'][$i][3];
					$sum_employee = $excel['cells'][$i][4];
					$working_hour = $excel['cells'][$i][5];

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;

							$object['prodstaff_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['prodstaff_headers'][$j]['prodstaff_no'] = $excel['cells'][$i][1];
							$object['prodstaff_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['prodstaff_headers'][$j]['status'] = '1';
							$object['prodstaff_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['prodstaff_headers'][$j]['filename'] = $upload['file_name'];

            	$prodstaff_header_exist = TRUE;
							$k = 1; // grpo_detail number

					}

					if($prodstaff_header_exist) {

   						if($prodstaff_detail_temp = $this->m_prodstaff->prodstaff_detail_select_posisi_status()) {
							$object['prodstaff_details'][$j][$k]['id_prodstaff_h_detail'] = $k;
							$object['prodstaff_details'][$j][$k]['id_posisi'] = $prodstaff_detail_temp['id_posisi'];
							$object['prodstaff_details'][$j][$k]['id_status'] = $prodstaff_detail_temp['id_status'];
							$object['prodstaff_details'][$j][$k]['posisi'] =$position ;
							$object['prodstaff_details'][$j][$k]['status'] = 	$employee_status;
							$object['prodstaff_details'][$j][$k]['jml_karyawan'] = $sum_employee;
							$object['prodstaff_details'][$j][$k]['total_jam'] = $working_hour;
							$k++;
						}

					}

				}

//				print_r($excel);
//				print_r($object);

				$this->template->write_view('content', 'prodstaff/prodstaff_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Productivity Staff / Labour per Store atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'prodstaff/browse_result/0/0/0/0/0/0/0/10';
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

        $upload['file_name'] = $this->session->userdata('file_name_upload');
		$this->excel_reader->read($this->session->userdata('file_upload'));
		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it grpo template file?
			if($excel['cells'][1][1] == 'Produktivity .No' && $excel['cells'][1][2] == 'Position') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

				$position = $excel['cells'][$i][2];
					$employee_status = $excel['cells'][$i][3];
					$sum_employee = $excel['cells'][$i][4];
					$working_hour = $excel['cells'][$i][5];


				// check grpo header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;


						$object['prodstaff_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['prodstaff_headers'][$j]['prodstaff_no'] = $excel['cells'][$i][1];
							$object['prodstaff_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
                            $object['prodstaff_headers'][$j]['id_prodstaff_plant'] = $this->m_prodstaff->id_prodstaff_plant_new_select($object['prodstaff_headers'][$j]['plant'],$object['prodstaff_headers'][$j]['posting_date']);
							$object['prodstaff_headers'][$j]['status'] = '1';
							$object['prodstaff_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['prodstaff_headers'][$j]['filename'] = $upload['file_name'];

						$id_prodstaff_header = $this->m_prodstaff->prodstaff_header_insert($object['prodstaff_headers'][$j]);

           	$prodstaff_header_exist = TRUE;
						$k = 1; // grpo_detail number


				}




				if($prodstaff_header_exist) {

					if($prodstaff_detail_temp = $this->m_prodstaff->prodstaff_detail_select_posisi_status()) {
							$object['prodstaff_details'][$j][$k]['id_prodstaff_h_detail'] = $k;
							$object['prodstaff_details'][$j][$k]['id_posisi'] = $prodstaff_detail_temp['id_posisi'];
							$object['prodstaff_details'][$j][$k]['id_status'] = $prodstaff_detail_temp['id_status'];
							$object['prodstaff_details'][$j][$k]['posisi'] =$position ;
							$object['prodstaff_details'][$j][$k]['status'] = 	$employee_status;
							$object['prodstaff_details'][$j][$k]['jml_karyawan'] = $sum_employee;
							$object['prodstaff_details'][$j][$k]['total_jam'] = $working_hour;

						$id_prodstaff_detail = $this->m_prodstaff->prodstaff_detail_insert($object['prodstaff_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Productivity Staff / Labour per Store per hari per jam per Departement berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['prodstaff_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Productivity Staff / Labour per Store atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'prodstaff/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '004';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>