<?php
class Employee_shift extends Controller {
	private $jagmodule = array();


	function Employee_shift() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1010);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_input_shift'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
//		$this->load->model('m_saprfc');
		$this->load->model('m_employee');
		$this->load->model('m_employee_shift');
		$this->load->model('m_upload_absent');

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
		$employee_shift_browse_result = $this->session->userdata['PAGE']['employee_shift_browse_result'];

		if(!empty($employee_shift_browse_result))
			redirect($this->session->userdata['PAGE']['employee_shift_browse_result']);
		else
			redirect('employee_shift/browse_result');

	}

	// search data
	function browse_search() {

		if(!empty($_POST['date_from']) && !empty($_POST['date_to'])) {

			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];

			$date = explode("-", $_POST['date_to']);
			$date_to = $date[2].$date[1].$date[0];

		} else if(!empty($_POST['date_from'])) {

			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];
			$date_to = $date_from;

		} else if(!empty($_POST['date_to'])) {

			$date = explode("-", $_POST['date_to']);
			$date_from = $date[2].$date[1].$date[0];
			$date_to = $date_from;

		} else {

			$date_from = date("Ymd", time());
			$date_to = $date_from;

		}

		redirect('employee_shift/browse_result/'.$date_from.'/'.$date_to.'/ay');

	}

	// list data
	function browse_result($date_from = '', $date_to = '', $sort = '') {

   	if(!empty($_POST['shift'])) {
   		$data = $_POST;
		$longshift_nik = $this->m_sync_attendance->sync_final_get_long_shift();

			foreach($data['shift'] as $key => $value) {

				foreach ($value as $key2 => $value2) {

					$content['shift_emp_id'] = $key;
					$content['shift_date'] = date('Y-m-d', $key2);
					$content['shift_code'] = $value2;

//					if($content['shift_code'] == 0) {
					if($content['shift_code'] === '') {
						continue;
					} else {
						$employee = $this->m_employee->employee_select($content['shift_emp_id']);
						$eod = $this->m_employee->eod_select_last();
						$eod_int = strtotime($eod);
						$shift_code_check = $this->m_employee_shift->shift_code_check($content['shift_code'], $this->session->userdata['ADMIN']['hr_plant_code']);

						if( (strtotime($employee['tanggal_masuk']) <= strtotime($content['shift_date'])) AND ($eod_int < strtotime($content['shift_date'])) AND $shift_code_check) {
							if($this->m_employee_shift->shift_add_update($content,$longshift_nik)) {
								/*$shift = $this->m_employee_shift->shift_code_select($content['shift_code'], $this->session->userdata['ADMIN']['hr_plant_code']);

								$absent['cabang'] = $this->session->userdata['ADMIN']['hr_plant_code'];
								$absent['tanggal'] = $content['shift_date'];
								$absent['nik'] = $employee['nik'];
								$absent['shift'] = $shift['shift_code'];
								$absent['kd_shift'] = $shift['shift_code'];

                                if ($this->m_upload_absent->employee_absent_select($absent)==FALSE) {
    								$absent['kd_aktual'] = 'A';
    								$absent['kd_aktual_temp'] = 'A';
                                }

								$absent['shift_in'] = $shift['duty_on'];
								$absent['shift_out'] = $shift['duty_off'];
								$absent['shift_break_in'] = $shift['break_in'];
								$absent['shift_break_out'] = $shift['break_out'];

                                $this->m_upload_absent->employee_absent_add_update($absent);*/
							}
						} else {
							continue;
						}

					}
				}
			}

			$object['page_title'] = 'Data Shift Karyawan Berhasil Disimpan';
			$object['refresh'] = 7;
			$object['refresh_text'] = 'Data shift karyawan berhasil disimpan.';
//			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_shift_browse_result'];

			$object['refresh_url'] = site_url('employee_shift/browse_result');


			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

   	}

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

		if(!empty($date_from) || !empty($date_to)) {

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


			$codes = $this->m_employee_shift->shift_codes_select($this->session->userdata['ADMIN']['hr_plant_code']);

			$object['shift_code'][''] = '';

			if($codes !== FALSE) {
				foreach ($codes->result_array() as $c) {
					$object['shift_code'][$c['shift_code']] = $c['shift_code'].' ('.$c['duty_on'].'-'.$c['duty_off'].')';
				}
			}

			$sort_link1 = 'employee_shift/browse_result/'.$date_from.'/'.$date_to.'/';

			$object['sort_link'] = array (
				'ay'	=>	$sort_link1.'ay',
				'az'	=>	$sort_link1.'az',
				'by'	=>	$sort_link1.'by',
				'bz'	=>	$sort_link1.'bz',
			);



			$object['data']['employees'] = $this->m_employee->employees_select_by_criteria('', '', '', '', '', 0, $sort, 0, 0);

			$shifts = $this->m_employee_shift->shifts_select_by_dates($date_from, $date_to);

			if($shifts !== FALSE) {
 				foreach ($shifts->result_array() as $s) {
					$shift1[] = $s;
				}

				foreach ($shift1 as $shift2) {
					$shift2['shift_date_timestamp'] = strtotime($shift2['shift_date']);

					$object['data']['shift'][$shift2['shift_emp_id']][$shift2['shift_date_timestamp']] = $shift2['shift_code'];
					$object['data']['lock'][$shift2['shift_emp_id']][$shift2['shift_date_timestamp']] = $shift2['shift_eod_lock'];
				}
			}


			$one_day = 60 * 60 * 24;

			$object['days'] = ((strtotime($date_to) - strtotime($date_from)) / $one_day) + 1;

			$object['date_from'] = $date_from;
			$object['date_to'] = $date_to;

			$object['total_rows'] = $this->m_employee->employees_count_by_criteria('', '', '', '', '', 0, $sort, 0, 0);

		}

//		$object['data'] = $data;

		$object['page_title'] = 'Employee Shift';

		$this->template->write_view('content', 'employee_shift/employee_shift_browse_result', $object);
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
		$config['file_name'] = 'employee_shift';
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
				$file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php/excel_upload/'.$upload['file_name'];
			else
				$file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it employee shift template file?
			if($excel['cells'][1][1] == 'NIK') {

				// nik, nama dan tanggal
				$object['shift'][1][1] = 'NIK';
				$object['shift'][1][2] = 'Nama';
				for($j = 3; $j <= $excel['numCols']+1; $j++) {

					$date = $excel['cells'][1][$j-1];
					$date_int = $this->convertexceltime($date);

					$eod = $this->m_employee->eod_select_last();
					$eod_int = strtotime($eod);

					if($eod_int < $date_int) {
						$object['shift'][1][$j] = date('Y-m-d', $date_int);
					}

				}

				// data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					//$x = $i - 1; // to check, is it same data with previous?

					// cek apakah NIK ada isinya?
					if(!empty($excel['cells'][$i][1])) {
						$employee = $this->m_employee->employee_select_by_nik($excel['cells'][$i][1]);
						$employee_check = $this->m_employee->employee_check($employee['employee_id']);

						if($employee_check) {
//echo $excel['cells'][$i][1].'-- ';
							$object['shift'][$i][1] = $excel['cells'][$i][1];
							$object['shift'][$i][2] = $employee['nama'];

							for($j = 3; $j <= $excel['numCols']+1; $j++) {

								if(!empty($object['shift'][1][$j])) {
									$shift_code_check = $this->m_employee_shift->shift_code_check($excel['cells'][$i][$j-1], $this->session->userdata['ADMIN']['hr_plant_code']);

									if($shift_code_check) {
										$object['shift'][$i][$j] = $excel['cells'][$i][$j-1];
									} else {
										$object['shift'][$i][$j] = '';
									}
								}
							}
						}
					}
				}

				$object['rows'] = count($object['shift']);
				$object['cols'] = count($object['shift'][1]);

/*
echo '<pre>';
print_r($object['shift']);
echo '</pre>';
*/
				$this->template->write_view('content', 'employee_shift/employee_shift_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Shift Karyawan atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'employee_shift/browse_result';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '001';
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

		// is it employee shift template file?
		if($excel['cells'][1][1] == 'NIK') {

			$longshift_nik = $this->m_sync_attendance->sync_final_get_long_shift();
			$this->db->trans_start();

			for($j = 1; $j <= $excel['numCols']; $j++) {

				$date = $excel['cells'][1][$j+1];
				$date_int[$j] = $this->convertexceltime($date);

				$eod = $this->m_employee->eod_select_last();
				$eod_int = strtotime($eod);

				if($eod_int < $date_int[$j]) {
					$date_arr[$j] = date("Y-m-d", $date_int[$j]);
				}

			}

			for ($i = 2; $i <= $excel['numRows']; $i++) {

				// cek apakah NIK ada isinya?
				if(!empty($excel['cells'][$i][1])) {

					$employee = $this->m_employee->employee_select_by_nik($excel['cells'][$i][1]);
					$employee_check = $this->m_employee->employee_check($employee['employee_id']);

					if($employee_check) {

						$employee_shift['shift_emp_id'] = $employee['employee_id'];

						for($j = 1; $j <= $excel['numCols']+1; $j++) {

							if(strtotime($employee['tanggal_masuk']) <= $date_int[$j]) {

								if(!empty($date_arr[$j])) {

									$employee_shift['shift_date'] = $date_arr[$j];
									$shift_code_check = $this->m_employee_shift->shift_code_check($excel['cells'][$i][$j+1], $this->session->userdata['ADMIN']['hr_plant_code']);

									if($shift_code_check) {

										$employee_shift['shift_code'] = $excel['cells'][$i][$j+1];

										if($this->m_employee_shift->shift_add_update($employee_shift,$longshift_nik)) {
											/*$shift = $this->m_employee_shift->shift_code_select($employee_shift['shift_code'], $this->session->userdata['ADMIN']['hr_plant_code']);

											$absent['cabang'] = $this->session->userdata['ADMIN']['hr_plant_code'];
											$absent['tanggal'] = $employee_shift['shift_date'];
											$absent['nik'] = $employee['nik'];
											$absent['shift'] = $shift['shift_code'];
											$absent['kd_shift'] = $shift['shift_code'];

                                            if ($this->m_upload_absent->employee_absent_select($absent)==FALSE) {
                								$absent['kd_aktual'] = 'A';
                								$absent['kd_aktual_temp'] = 'A';
                                            }

											$absent['shift_in'] = $shift['duty_on'];
											$absent['shift_out'] = $shift['duty_off'];
											$absent['shift_break_in'] = $shift['break_in'];
											$absent['shift_break_out'] = $shift['break_out'];

                			                $this->m_upload_absent->employee_absent_add_update($absent);*/

											$berhasil = 1;
										}

									}

								}

							}

						}

					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 7;
			$object['refresh_text'] = 'Data Shift Karyawan berhasil di-upload';
			$object['refresh_url'] = 'employee_shift';

			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Shift Karyawan atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'employee_shift/browse_result';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '002';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>