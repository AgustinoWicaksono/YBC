<?php
class Employee_absent extends Controller {
	private $jagmodule = array();


	function Employee_absent() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1005);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_input_izin'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_employee');
		$this->load->model('m_employee_absent');
		$this->load->model('m_employee_shift');

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
		$this->enter();
	}

	function enter() {

		$object['data'] = NULL;

		// For add data, assign the default variable here
		$object['data']['po_no'] = 0;

		$this->session->set_userdata('nik', '0');
		$this->session->set_userdata('nama', '0');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$data['employees'] = $this->m_employee->employees_select_all_order_by_nik();

		if($data['employees'] !== FALSE) {
			$object['nik'][0] = '';

			foreach ($data['employees']->result_array() as $employee) {
				$object['nik'][$employee['nik']] = $employee['nik'];
	//			$object['nama'][$employee['nama']] = $employee['nama'];
			}
		}

		$data['employees2'] = $this->m_employee->employees_select_all_order_by_nama();
//		$data['employees2'] = $this->m_employee->employees_select_all_order_by_nik();

		if($data['employees2'] !== FALSE) {
//			$object['nama'][0] = '';
			$object['nama'][0] = '';

			foreach ($data['employees2']->result_array() as $employee2) {
//				$object['nik'][$employee2['nik']] = $employee2['nik'];
				$object['nama'][$employee2['nik']] = $employee2['nama'].' - '.$employee2['nik'];
			}
		}

		$object['page_title'] = 'Form Input Izin Karyawan';
		$this->template->write_view('content', 'employee_absent/employee_absent_enter', $object);
		$this->template->render();

	}

	function enter_search() {

		if(!empty($_POST['nik'])) {
			$employee = $this->m_employee->employee_select_by_nik($_POST['nik']);
		} else if(!empty($_POST['nama'])) {
			$employee = $this->m_employee->employee_select_by_nik($_POST['nama']);
		} else {
			exit;
		}
		redirect('employee_absent/enter_result/'.$employee['employee_id']);

	}

	function enter_result($employee_id) {

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$employee = $this->m_employee->employee_select($employee_id);
		$employee['saldo_cuti'] = intval($employee['saldo_cuti']);
        $employee['saldo_cuti'] = $employee['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee_id);
        $employee['saldo_ph'] = $this->m_employee_absent->get_jumlah_cuti_ph($employee_id);
		$employee['saldo_ph'] = intval($employee['saldo_ph']);
		$employee['saldo_cutihutang'] = intval($employee['saldo_cutihutang']);
        $employee['saldo_cutihutang'] = $employee['saldo_cutihutang'] + $this->m_employee_absent->get_jumlah_cutihutang($employee_id);

		$object['data'] = $employee;

		$object['page_title'] = 'Form Input Izin Karyawan';
		$this->template->write_view('content', 'employee_absent/employee_absent_enter_result', $object);
		$this->template->render();

	}

	// search data
	function browse_search($employee_id = 0) {

/*
		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}
*/
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
			$limit = 50;
		} else {
			$limit = $_POST['limit'];
		}

		if(empty($employee_id))
			$employee_id = $_POST['employee_id'];

		redirect('employee_absent/browse_result/'.$employee_id."/".$date_from."/".$date_to."/0/".$limit);

	}

	// search result
	function browse_result($employee_id = '', $date_from = '', $date_to = '', $sort = '', $limit = 50, $start = 0)	{

		$this->l_page->save_page('employee_absent_browse_result');

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['data']['employee'] = $this->m_employee->employee_select($employee_id);
		$object['data']['employee']['saldo_cuti'] = intval($object['data']['employee']['saldo_cuti']);
        $object['data']['employee']['saldo_cuti'] = $object['data']['employee']['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee_id);
        $object['data']['employee']['saldo_ph'] = $this->m_employee_absent->get_jumlah_cuti_ph($employee_id);
		$object['data']['employee']['saldo_ph'] = intval($object['data']['employee']['saldo_ph']);
		$object['data']['employee']['saldo_cutihutang'] = intval($object['data']['employee']['saldo_cutihutang']);
        $object['data']['employee']['saldo_cutihutang'] = $object['data']['employee']['saldo_cutihutang'] + $this->m_employee_absent->get_jumlah_cutihutang($employee_id);

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['data']['date_from'] = $day."-".$month."-".$year;
		} else {
			$object['data']['date_from'] = '';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['data']['date_to'] = $day."-".$month."-".$year;
		} else {
			$object['data']['date_to'] = '';
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

		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;

		$sort_link1 = 'employee_absent/browse_result/'.$employee_id.'/'.$date_from.'/'.$date_to.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 9;
		$config['base_url'] = site_url('employee_absent/browse_result/'.$employee_id.'/'.$date_from.'/'.$date_to.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_employee_absent->employee_absents_count_by_criteria($employee_id, $date_from, $date_to, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['employee_absents'] = $this->m_employee_absent->employee_absents_select_by_criteria($employee_id, $date_from, $date_to, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'Form Input Izin Karyawan';
		$this->template->write_view('content', 'employee_absent/employee_absent_browse', $object);
		$this->template->render();

	}

	function input($employee_id = 0)	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {

	   		$data = $_POST;

//				$this->_data_form('nik', $data['new']['nik'], 0, $data);
	 			$this->_data_form($employee_id, 0, $data);

	   	} else {
	 			$this->_data_form($employee_id);
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
  			$this->_data_form(0, $data);
    	} else {
            $data = $this->m_employee_absent->employee_absent_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
//		$this->form_validation->set_rules('id_posisi', 'Employee Position Code', 'trim|required');
		$this->form_validation->set_rules('absent_date_1', 'Tanggal Awal Izin', 'trim|required');
//		$this->form_validation->set_rules('saldo_cuti', 'Saldo Cuti', 'is_numeric_no_zero');
	}

	function _data_form($employee_id = 0, $reset=0, $data=NULL) {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

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

		$employee = $this->m_employee->employee_select($employee_id);
		$employee['saldo_cuti'] = intval($employee['saldo_cuti']);
        $employee['saldo_cuti'] = $employee['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee_id);
        $employee['saldo_ph'] = $this->m_employee_absent->get_jumlah_cuti_ph($employee_id);
		$employee['saldo_ph'] = intval($employee['saldo_ph']);
		$employee['saldo_cutihutang'] = intval($employee['saldo_cutihutang']);
        $employee['saldo_cutihutang'] = $employee['saldo_cutihutang'] + $this->m_employee_absent->get_jumlah_cutihutang($employee_id);
		
		$object['data'] = $employee;

		$types = $this->m_employee_absent->type_codes_select_all();

		if($types !== FALSE) {
			foreach ($types->result_array() as $type) {
				if ($type['kode_absent']=='AL') {
					if ($employee['saldo_cuti']<1) {
						continue;
					}
				} elseif ($type['kode_absent']=='CH') {
					if ($employee['saldo_cuti']>0) {
						continue;
					}
				}
				$object['type'][$type['kode_absent']] = $type['type_name'];
			}
		}

		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data']['new'] = $data['new'];
		} else {
			$object['data']['new'] = NULL;
			$object['data']['new']['employee_id'] = $employee['employee_id'];
			$object['data']['new']['absent_emp_id'] = $employee['employee_id'];

			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}


		$object['page_title'] = 'Izin Karyawan';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'employee_absent/employee_absent_input', $object);
		$this->template->render();
	}

	function _data_add() {
		$errordate='';
		// start of assign variables and delete not used variables
        $employee_absent = $_POST;
		unset($employee_absent['button']);
		// end of assign variables and delete not used variables


		$date = explode("-", $_POST['absent_date_1']);
		$date_from_ymd = $date[2].'-'.$date[1].'-'.$date[0];
		$date_from_int = strtotime($date_from_ymd);
		unset($date);

		if(!empty($_POST['absent_date_2'])) {
			$date = explode("-", $_POST['absent_date_2']);
			$date_to_ymd = $date[2].'-'.$date[1].'-'.$date[0];
			$date_to_int = strtotime($date_to_ymd);
			unset($date);
		}
		unset($date_to_int); // 20130819: karena tanggal TO dihilangkan

		if($date_from_int != 0) {

			$employee = $this->m_employee->employee_select($employee_absent['new']['absent_emp_id']);
            $saldo_ph = $employee_absent['saldo_ph'];

            if ($employee_absent['new']['absent_type'] == 'AL') {
              $saldo_cuti = $employee_absent['saldo_cuti'];
            } else if (($employee_absent['new']['absent_type'] == 'PH') OR ($employee_absent['new']['absent_type'] == 'CPH')) {
              $saldo_cuti = $saldo_ph;
            } else {
              $saldo_cuti = 1;
            }
			$eod = $this->m_employee_absent->employee_absent_check_eom(date('Y-m-d',$date_from_int),$employee_absent['new']['absent_emp_id']);
            //$cuti_exists = $this->m_employee_absent->cek_cuti_exists($employee_absent['new']);
			if ($eod AND ($saldo_cuti > 0) /*AND (!$cuti_exists)*/) {
			// pengecekan, tanggal masuk harus lebih kecil dari tanggal yang dimasukkan
				if( (strtotime($employee['tanggal_masuk']) <= $date_from_int) AND
					(($date_from_int <= strtotime($employee['tanggal_keluar'])) || ($employee['tanggal_keluar']=='0000-00-00'))
					 ) {

	//				echo strtotime($employee['tanggal_masuk']).' ',$date_int_1;

					if(empty($date_to_int))
						$date_diff = 0;
					else
						$date_diff = $date_to_int - $date_from_int;

					if($date_diff >= 0) {
						$date_diff_div = $date_diff / 86400;
						$date_int_curr = $date_from_int;
						$i = 0;

						while ($i <= $date_diff_div) {
			    				$employee_absent['new']['absent_date'] = date("Y-m-d", $date_int_curr);
								if($absent_id = $this->m_employee_absent->employee_absent_add_update($employee_absent['new'])) {
								    if ((($employee_absent['new']['absent_type'] == 'PH') || ($employee_absent['new']['absent_type'] == 'CPH')) && ($this->m_employee_absent->cek_cuti_ph_exists($absent_id,$employee_absent['new'])==FALSE)) {
                                      $this->m_employee_absent->update_jumlah_cuti_ph($employee_absent['new']['absent_emp_id'],2);
								   }
                                   $absent_id = 0;
								   $berhasil = 1;
								} else {
									$berhasil = 0;
								}

							$date_int_curr = $date_int_curr + 86400;
							$i++;
						}
					}
				}
			} else { $errordate='error'; }
		}

		if($berhasil) {

			$object['page_title'] = 'Data Izin Karyawan Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data izin karyawan berhasil dimasukkan.';
			if ($errordate!='') $object['refresh_text'] .= ' Kecuali tanggal berikut ini: '.$errordate;
//			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$object['refresh_url'] = 'employee_absent/enter_result/'.$employee_absent['new']['absent_emp_id'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
			$empdata = $this->m_employee->employee_select($employee_absent['new']['absent_emp_id']);
			$empnik = $empdata['nik']; 
			$empcab = $empdata['kode_cabang']; 
			if ($errordate!='') {
				$object['refresh'] = 0;
                $ref_text = '';
                if(!$eod)
  				  $ref_text = 'Anda tidak dapat memasukan data pada periode yang sudah End of Month. ';
                if($saldo_cuti <= 0)
                   $ref_text = $ref_text.' Anda tidak dapat memasukan data. Sisa cuti utk karyawan ini (NIK='.$empnik.') sudah habis. ';
                //if($cuti_exists)
                //   $ref_text = $ref_text.' Anda tidak dapat memasukan data. Sudah ada cuti untuk tanggal '.$employee_absent['new']['absent_date'];
                $object['refresh_text'] = $ref_text;
				$object['refresh_url'] = 'employee_absent/enter_result/'.$employee_absent['new']['absent_emp_id'];
				$object['web_transdtl'] = 'NIK='.$empnik.'; Cabang='.$empcab.'; Saldo Cuti='.$saldo_cuti.'; Date='.date('Y-m-d',$date_from_int).';';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '001';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
			} else {
				$object['refresh'] = 0;
				$object['refresh_text'] = 'Data izin karyawan gagal dimasukkan. Periksa kembali tanggal yang dimasukkan. Data tidak akan masuk jika tanggal yang dimasukkan kurang dari tanggal masuk karyawan atau tanggal yang di masukkan lebih besar dari tanggal Resign Karyawan. ';
				$object['refresh_url'] = 'employee_absent/enter_result/'.$employee_absent['new']['absent_emp_id'];

				$object['web_transdtl'] = 'NIK='.$empnik.'; Cabang='.$empcab.'; Date='.date('Y-m-d',$date_from_int).';';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '002';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
			}
		}
	}

	function _delete($absent_id) {

		// check approve status
		$absent = $this->m_employee_absent->employee_absent_select($absent_id);

		if($absent['absent_endofday'] == '0') {
		    $data['shift_date'] = $absent['absent_date'];
		    $data['shift_emp_id'] = $absent['absent_emp_id'];
    	    $this->m_employee_shift->set_upload_absent_to_process($data);
            if (($absent['absent_type'] == 'PH') OR ($absent['absent_type'] == 'CPH')) {
              $this->m_employee_absent->update_jumlah_cuti_ph($absent['absent_emp_id']);
            }
			$this->m_employee_absent->employee_absent_delete($absent_id);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($absent_id) {

		if($this->_delete($absent_id)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Izin Karyawan berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_absent_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data izin karyawan gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_absent_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '003';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grpo_header']))
			redirect($this->session->userdata['PAGE']['grpo_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grpo_header'][$i])) {
				$object['data']['grpo_headers'][$j++] = $this->m_grpo->grpo_header_select($_POST['id_grpo_header'][$i]);
			}
		}

		$this->template->write_view('content', 'grpo/grpo_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grpo_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO from Vendor berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grpo_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}


	function convertexceltime($date_from){

		$date_from=str_replace('/', '-', $date_from);
		$iTimestamp = strtotime( $date_from );
		if ($iTimestamp >= 0 && false !== $iTimestamp)
		{
		// Its good.echo '
		}
		else
		{
			$iTimestamp = mktime(0,0,0,1,$date_from-1,1900);
			$date_from = date('Ymd',$iTimestamp);
			$iTimestamp = strtotime($date_from);
		}

		return $iTimestamp;
	}

	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'employee_absent';
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
			$employee_cuti_excel = Array();
			$employee_ph_excel = Array();
			$employee_cutihutang_excel = Array();

			// is it employee absent template file?
			if($excel['cells'][1][1] == 'NIK' AND $excel['cells'][1][4] == 'Kode Jenis Izin') {

				for ($i = 2; $i <= $excel['numRows']; $i++) {
					//$x = $i - 1; // to check, is it same data with previous?

					$nik = $excel['cells'][$i][1];
					$date_from = $excel['cells'][$i][2];
					$date_to = $excel['cells'][$i][3];
					$type_code = $excel['cells'][$i][4];
					$note = $excel['cells'][$i][5];


					// is it same data with previous? if not, continue to next data
					// ngga perlu dicek, karena data nama boleh sama
					//if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

					$date_from_int = $this->convertexceltime($date_from);
					$date_to_int = $this->convertexceltime($date_to);
					
					if(empty($date_to_int)){
						$date_diff = 1;
					} else {
						$date_diff = $date_to_int - $date_from_int;
						$date_diff = $date_diff / 86400;
						$date_diff = $date_diff + 1;
					}

					/*
					echo 'From1='.date('Ymd',$this->convertexceltime($date_from)).'<hr />';
					echo 'From2='.date('Ymd',$date_from_int).'<hr />';
					echo 'To1='.date('Ymd',$this->convertexceltime($date_to)).'<hr />';
					echo 'To2='.date('Ymd',$date_to_int).'<hr />';
					die();
					*/

					$eod = $this->m_employee->eod_select_last();
					$eod_int = strtotime($eod);

					$employee = $this->m_employee->employee_select_by_nik($nik);
					$employee_check = $this->m_employee->employee_check($employee['employee_id']);

					if($employee_check) {
						if ($type_code == 'AL') {
						  $saldo_cuti = $employee['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee['employee_id']);
						  if (Empty($employee_cuti_excel[$employee['employee_id']])) $employee_cuti_excel[$employee['employee_id']] = 0;
						  $employee_cuti_excel[$employee['employee_id']] = $employee_cuti_excel[$employee['employee_id']] + $date_diff;
						} elseif ($type_code == 'CH') {
						  $saldo_cutihutang = $employee['saldo_cutihutang'] + $this->m_employee_absent->get_jumlah_cutihutang($employee['employee_id']);
						  if (Empty($employee_cutihutang_excel[$employee['employee_id']])) $employee_cutihutang_excel[$employee['employee_id']] = 0;
						  $employee_cutihutang_excel[$employee['employee_id']] = $employee_cutihutang_excel[$employee['employee_id']] + $date_diff;
						} elseif (($type_code == 'PH') OR ($type_code == 'CPH')) {
						  $saldo_cuti = $this->m_employee_absent->get_jumlah_cuti_ph($employee['employee_id']);
						  if (Empty($employee_ph_excel[$employee['employee_id']])) $employee_ph_excel[$employee['employee_id']] = 0;
						  $employee_ph_excel[$employee['employee_id']] = $employee_ph_excel[$employee['employee_id']] + $date_diff;
						} else {
						  $saldo_cuti = 1;
						}

						$type_name = $this->m_employee_absent->type_name_select($type_code);

						if (($employee_cuti_excel[$employee['employee_id']]>$saldo_cuti) && ($type_code == 'AL')){
							$object['absent'][$i]['nik'] = $nik;
							$object['absent'][$i]['nama'] = $employee['nama'];
							$object['absent'][$i]['date_from'] = date('Y-m-d', $date_from_int);
							$object['absent'][$i]['date_to'] = date('Y-m-d', $date_to_int);
							$object['absent'][$i]['type_code'] = $type_code;
							$object['absent'][$i]['type_name'] = $type_name;
							$object['absent'][$i]['note'] = 'CUTI TIDAK DAPAT DIAMBIL: (Maksimal hanya boleh '.$saldo_cuti.' hari sedangkan diambil '.$employee_cuti_excel[$employee['employee_id']].' hari)';
						} elseif (($employee['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee['employee_id'])>0) && ($type_code == 'CH')){
							$object['absent'][$i]['nik'] = $nik;
							$object['absent'][$i]['nama'] = $employee['nama'];
							$object['absent'][$i]['date_from'] = date('Y-m-d', $date_from_int);
							$object['absent'][$i]['date_to'] = date('Y-m-d', $date_to_int);
							$object['absent'][$i]['type_code'] = $type_code;
							$object['absent'][$i]['type_name'] = $type_name;
							$object['absent'][$i]['note'] = 'CUTI HUTANG TIDAK DAPAT DIAMBIL: Masih ada sisa SALDO CUTI';
						} elseif (($employee_ph_excel[$employee['employee_id']]>$saldo_cuti) && ($type_code == 'PH')){
							$object['absent'][$i]['nik'] = $nik;
							$object['absent'][$i]['nama'] = $employee['nama'];
							$object['absent'][$i]['date_from'] = date('Y-m-d', $date_from_int);
							$object['absent'][$i]['date_to'] = date('Y-m-d', $date_to_int);
							$object['absent'][$i]['type_code'] = $type_code;
							$object['absent'][$i]['type_name'] = $type_name;
							$object['absent'][$i]['note'] = 'CUTI TIDAK DAPAT DIAMBIL: (Maksimal hanya boleh '.$saldo_cuti.' hari sedangkan diambil '.$employee_ph_excel[$employee['employee_id']].' hari)';
						} else {
							if($employee AND $type_name AND !empty($date_from)
							   AND (strtotime($employee['tanggal_masuk']) <= $date_from_int)
							   AND (($date_from_int <= strtotime($employee['tanggal_keluar'])) || ($employee['tanggal_keluar']=='0000-00-00'))
//							   AND (($saldo_cuti > 0) || ($saldo_cutihutang > 0))
							   AND ($eod_int < $date_from_int) ) {
								$object['absent'][$i]['nik'] = $nik;
								$object['absent'][$i]['nama'] = $employee['nama'];
								$object['absent'][$i]['date_from'] = date('Y-m-d', $date_from_int);
								$object['absent'][$i]['date_to'] = date('Y-m-d', $date_to_int);
								$object['absent'][$i]['type_code'] = $type_code;
								$object['absent'][$i]['type_name'] = $type_name;
								$object['absent'][$i]['note'] = $note;
							}
						}
					}  else {
						$type_name = $this->m_employee_absent->type_name_select($type_code);
						$object['absent'][$i]['nik'] = $nik;
						$object['absent'][$i]['nama'] = 'KARYAWAN TIDAK TERDAFTAR';
						$object['absent'][$i]['date_from'] = date('Y-m-d', $date_from_int);
						$object['absent'][$i]['date_to'] = date('Y-m-d', $date_to_int);
						$object['absent'][$i]['type_code'] = $type_code;
						$object['absent'][$i]['type_name'] = $type_name;
						$object['absent'][$i]['note'] = 'DATA SALAH!';
					}
				}

				$this->template->write_view('content', 'employee_absent/employee_absent_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Izin Karyawan atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'employee_absent/enter';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '004';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();


			 }
		}

	}

	function file_import_execute() {
		$errordate = '';

		// Load the spreadsheet reader library
		$this->load->library('excel_reader');

		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');

		$this->excel_reader->read($this->session->userdata('file_upload'));

		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it employee absent template file?
		if($excel['cells'][1][1] == 'NIK' AND $excel['cells'][1][4] == 'Kode Jenis Izin') {

			$this->db->trans_start();

			for ($i = 2; $i <= $excel['numRows']; $i++) {

				$nik = $excel['cells'][$i][1];
				$date_from = $excel['cells'][$i][2];
				$date_to = $excel['cells'][$i][3];
				$type_code = $excel['cells'][$i][4];
				$note = $excel['cells'][$i][5];

				$date_from_int = $this->convertexceltime($date_from);
				$date_to_int = $this->convertexceltime($date_to);

				$eod = $this->m_employee->eod_select_last();
				$eod_int = strtotime($eod);

				$employee = $this->m_employee->employee_select_by_nik($nik);
				$employee_check = $this->m_employee->employee_check($employee['employee_id']);

				if($employee_check) {

					if ($type_code == 'AL') {
					  $saldo_cuti = $employee['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($employee['employee_id']);
					} else if (($type_code == 'PH') OR ($type_code == 'CPH')) {
					  $saldo_cuti = $this->m_employee_absent->get_jumlah_cuti_ph($employee['employee_id']);
					} else {
					  $saldo_cuti = 1;
					}

					$type_name = $this->m_employee_absent->type_name_select($type_code);

					// pengecekan, tanggal masuk harus lebih kecil dari tanggal yang dimasukkan
					if($employee AND $type_name AND !empty($date_from)
						AND (strtotime($employee['tanggal_masuk']) <= $date_from_int)
						AND (($date_from_int <= strtotime($employee['tanggal_keluar'])) || ($employee['tanggal_keluar']=='0000-00-00'))
						AND ($saldo_cuti > 0)
						AND ($eod_int < $date_from_int) ) {

						if(empty($date_to_int))
							$date_diff = 0;
						else
							$date_diff = $date_to_int - $date_from_int;
							
						if($date_diff >= 0) {
							$date_diff_div = $date_diff / 86400;
							$date_int_curr = $date_from_int;
							$j = 0;

							while ($j <= $date_diff_div) {

								$employee_absent['absent_emp_id'] = $employee['employee_id'];
								$employee_absent['absent_date'] = date("Y-m-d", $date_int_curr);
								$employee_absent['absent_type'] = $type_code;
								$employee_absent['absent_note'] = $note;

								if ($this->m_employee_absent->employee_absent_check_eom($employee_absent['absent_date'],$employee_absent['absent_emp_id'])) {


									if($absent_id = $this->m_employee_absent->employee_absent_add_update($employee_absent)) {
										if ((($employee_absent['absent_type'] == 'PH') || ($employee_absent['absent_type'] == 'CPH')) && ($this->m_employee_absent->cek_cuti_ph_exists($absent_id,$employee_absent)==FALSE)) {
											$this->m_employee_absent->update_jumlah_cuti_ph($employee_absent['absent_emp_id'],2);
										}
										$absent_id = 0;
										$berhasil = 1;
									} else {
										$berhasil = 0;
									}
								} else {
									$errordate = $errordate.$employee_absent['absent_date'].',';
								}
								$date_int_curr = $date_int_curr + 86400;
								$j++;
							}
						}

					}
				}
			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Izin Karyawan berhasil di-upload';
			if ($errordate!='') $object['refresh_text'] .= ' Kecuali tanggal berikut ini: '.$errordate;
			$object['refresh_url'] = 'employee_absent/enter';

			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Izin Karyawan atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'employee_absent/enter';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '005';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
