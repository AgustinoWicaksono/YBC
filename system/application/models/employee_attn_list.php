<?php
class Employee_attn_list extends Controller {

	function Employee_attn_list() {
		parent::Controller();

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

//		if(!$this->l_auth->is_have_perm('report_employee_attn_detail'))
//			redirect('');

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

		$object['page_title'] = 'Report Attendance List';
		$this->template->write_view('content', 'employee_attn_list/employee_attn_list_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_search() {

		$employee_id = $_POST['employee_id'];

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

		redirect('employee_attn_list/browse_result/'.$date_from.'/'.$date_to);

	}

	// search result
	function browse_result($date_from = '', $date_to = '')	{

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

		$employees = $this->m_employee->employees_select_all_order_by_nama();

		if($employees !== FALSE) {

			$i = 1;
			foreach($employees as $employee) {

				print_r($employee);

				$object['data']['employee'][$i] = $employee;
//				$object['data']['employee'][$i]['kd_aktual_total'] = 0;

				$attns = $this->m_employee_attn->attn_select_by_nik_and_date($employee['nik'], $date_from, $date_to);

				if($attns !== FALSE) {

					$j = 1;
					foreach($attns as $attn) {

						$object['data']['employee'][$i]['attn'][$j] = $attn['kd_aktual'];

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

	//			$object['data']['employee'][$i]['kd_aktual_count'] = count($object['data']['employee'][$i]['kd_aktual']);



			}

		}

		print_r($object['data']);

		$object['days_interval'] = $days_interval;
		$object['timestamp'] = $timestamp;

		$object['page_title'] = 'Report Attendance List';

		$this->load->view('employee_attn_list/employee_attn_list_browse_result', $object);

	}

}
?>