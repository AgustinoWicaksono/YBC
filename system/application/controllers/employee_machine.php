<?php
class employee_machine extends Controller {
	private $jagmodule = array();


	function employee_machine() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1008);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_report_machine'))
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
	function browse() {

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
			'target'	=>	'_blank',
		);
		// end of form attributes

		$employees = $this->m_employee->employees_select_all_order_by_nama();

		if($employees !== FALSE) {
//			$i = 1;
			$object['employee'][0] = '';

			foreach ($employees->result_array() as $employee) {
				$object['employee'][$employee['employee_id']] = $employee['nama'];
			}
		}

		$divisions = $this->m_employee->divisi_select_all();

		if($divisions !== FALSE) {
//			$i = 1;
			$object['divisi'][0] = '';
			foreach ($divisions->result_array() as $division) {
			 
				$object['divisi'][$division['kode_divisi']] = $division['nama_divisi'];
			}
		}
		
		$object['finger_status']['fp_all'] = 'Semua kondisi';
		$object['finger_status']['fp_ok'] = 'Hanya yang sudah diproses Sistem Web HR';
		$object['finger_status']['fp_not_ok'] = 'Hanya yang belum atau tidak dapat diproses di Sistem Web HR';
		
		$object['order'] = array (
			'ay'	=>	'Tanggal ASC',
			'az'	=>	'Tanggal DESC',
			'by'	=>	'Nama Karyawan ASC',
			'bz'	=>	'Nama Karyawan DESC',
			'cy'	=>	'NIK ASC',
			'cz'	=>	'NIK DESC',
		);

		$object['page_title'] = 'Report Data Mesin Absen';
		$this->template->write_view('content', 'employee_machine/employee_machine_browse', $object);
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
		
		if (Empty($_POST['finger_status'])) {
			$finger_status='fp_all';
		} else {
			$finger_status = trim($_POST['finger_status']);
		}
		
		redirect('employee_machine/browse_result/'.$date_from.'/'.$date_to.'/'.$divisi.'/'.$order.'/'.$employee_id.'/'.$finger_status.'/');

	}

	// search result
	function browse_result($date_from = '', $date_to = '', $divisi = '', $order = '', $employee_id = '', $finger_status = '')	{
		$object['page_title'] = 'Data Mesin Absen: '.$this->session->userdata['ADMIN']['storage_location_name'];

		// supaya perhitungan waktu tidak salah
		date_default_timezone_set("UTC");

		$this->l_page->save_page('employee_machine_browse_result');

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
//			$object['data']['date_from'] = '';
			$object['date_from'] = date("d-m-Y", time());
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

		$timestamp_from = strtotime($date_from2);
		$timestamp_to = strtotime($date_to2);

		if(!empty($employee_id)) {
			$object['data']['employee'] = $this->m_employee->employee_select($employee_id);
		}

		$data_machines = $this->m_employee_attn->employee_machine_data($date_from, $date_to, $order, $employee_id, $object['data']['employee']['nik'], $divisi,$finger_status);
		
		$data_ids = Array();
		if (!Empty($data_machines)){
		foreach ($data_machines as $data_machine => $value){
			if (in_array($data_machines[$data_machine]['id'],$data_ids)){
				unset($data_machines[$data_machine]);
			} else {
				$data_ids[] = $data_machines[$data_machine]['id'];
			}
		}
		}
		
		$object['data']['attns'] = $data_machines;
		$object['data']['divisi'] = $divisi;
		$object['data']['finger_status'] = $finger_status;
		$this->load->view('employee_machine/employee_machine_browse_result', $object);

	}

}
?>