<?php
class Employee_attn_list extends Controller {
	private $jagmodule = array();


	function Employee_attn_list() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1006);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_report_attendance'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
//		$this->load->model('m_saprfc');

		$this->load->model('m_employee');
		$this->load->model('m_employee_attn');


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
	// list data
	function browse() {

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
			'target'	=>	'_blank',
		);
		// end of form attributes

		$divisions = $this->m_employee->divisi_select_all();

		if($divisions !== FALSE) {
//			$i = 1;
			$object['divisi'][0] = '';
			foreach ($divisions->result_array() as $division) {
			 
				$object['divisi'][$division['kode_divisi']] = $division['nama_divisi'];
			}
		}

		$object['order'] = array (
			'by'	=>	'Nama Karyawan (A-Z)',
			'bz'	=>	'Nama Karyawan (Z-A)',
			'cy'	=>	'NIK (Kecil ke Besar)',
			'cz'	=>	'NIK (Besar ke Kecil)',
		);

		$object['page_title'] = 'Report Attendance List';
		$this->template->write_view('content', 'employee_attn_list/employee_attn_list_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_search() {

		$employee_id = $_POST['employee_id'];

		$order = $_POST['order'];

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
		
		if (Empty($_POST['divisi'])) {
			$divisi='ALL';
		} else {
			$divisi = str_replace(' ','%20',$_POST['divisi']);
		}

		redirect('employee_attn_list/browse_result/'.$date_from.'/'.$date_to.'/'.$divisi.'/'.$order);

	}

	// search result
	function browse_result($date_from = '', $date_to = '', $divisi = '', $order = '')	{
		$object['page_title'] = 'Attendance List: '.$this->session->userdata['ADMIN']['storage_location_name'];

		// supaya perhitungan waktu tidak salah
		date_default_timezone_set("UTC");

		$this->l_page->save_page('employee_attn_list_browse_result');

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
//			$object['data']['date_from'] = '';
			$object['date_from'] = date("d-m-Y", now());
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['date_to'] = '';
			$date_to2 = '0';
		}

		unset($year);
		unset($month);
		unset($day);

		$timestamp['from'] = strtotime($date_from2);
		$timestamp['to'] = strtotime($date_to2);

		$oneday = 60 * 60 * 24;

		$timestamp['interval'] = $timestamp['to'] - $timestamp['from'];

		$days_interval = (int) (($timestamp['interval'] / $oneday) + 1);

		$employees = $this->m_employee->employees_select_all_filter_by_division($divisi);

		if($employees !== FALSE) {

			$i = 1;
			foreach($employees->result_array() as $employee) {

				$object['data']['employee'][$i] = $employee;
				$object['data']['employee'][$i]['kd_aktual_total'] = 0;

				$attns = $this->m_employee_attn->attn_select_by_nik_and_date($employee['nik'], $date_from, $date_to);

				if($attns !== FALSE) {

					$j = 1;
					foreach($attns->result_array() as $attn) {

						$object['data']['employee'][$i]['attn'][$attn['tanggal']] = $attn['kd_aktual'];
						$object['data']['employee'][$i]['lock'][$attn['tanggal']] = $attn['eod_lock'];

//						$i = 0;  // $i => date
//						for($a = 0; $a < $days_interval; $a++) {
//						}

						if(isset($object['data']['employee'][$i]['kd_aktual'][$attn['kd_aktual']]))
							$object['data']['employee'][$i]['kd_aktual'][$attn['kd_aktual']]++;
						else
							$object['data']['employee'][$i]['kd_aktual'][$attn['kd_aktual']] = 1;

						$object['data']['employee'][$i]['kd_aktual_total']++;

					}

				}

				$object['data']['employee'][$i]['kd_aktual_count'] = count($object['data']['employee'][$i]['kd_aktual']);

	      $i++;

			}
		}
/*
		echo '<pre>';
    print_r($object['data']['employee']);
		echo '</pre>';
*/
		$object['days_interval'] = $days_interval;
		$object['timestamp'] = $timestamp;
		
		$absen_data_last_updated = $this->m_employee_attn->data_last_update();

		$object['absen_data_last_updated']= $absen_data_last_updated;

		$this->load->view('employee_attn_list/employee_attn_list_browse_result', $object);

	}

}
?>