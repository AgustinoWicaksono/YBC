<?php
class Dispnonstdstock extends Controller {
	private $jagmodule = array();


	function Dispnonstdstock() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1025);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_dispnonstdstock'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_saprfc');

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

		$object['page_title'] = 'Display Standard Stock di Outlet';
		$this->template->write_view('content', 'dispnonstdstock/dispnonstdstock_browse', $object);
		$this->template->render();

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

		redirect('dispnonstdstock/browse_result/'.$date_from."/".$date_to);

	}

	// search result
	function browse_result($date_from = '', $date_to = '')	{

		$this->l_page->save_page('dispnonstdstock_browse_result');

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

		$timestamp_from = strtotime($date_from2);
		$timestamp_to = strtotime($date_to2);

		$oneday = 60 * 60 * 24;

		$timestamp_interval = $timestamp_to - $timestamp_from;

		$days_interval = (int) (($timestamp_interval / $oneday) + 1);

		$total[5] = 0; // Std. Value
		$total[9] = 0; // Actual Value
		$total[12] = 0; // Var+ Value
		$total[14] = 0; // Var- Value
		$total[16] = 0; // Denda Penggantian
        $sap_client = $this->m_saprfc->sapAttr();
		$i = 0;  // $i => date
		for($a = 0; $a < $days_interval; $a++) {

			$timestamp_check = $timestamp_from + ($oneday * $a);
			$filename = './report/'.$sap_client['CLIENT'].'_StdStock_'.date('Ymd', $timestamp_check).'.csv';
//            print '<br> $filename '.$filename;
			if(@$handle = fopen($filename, 'r')) {
				$filetime[$i] = filemtime($filename);
				$timestamp[$i] = $timestamp_check;

				$j = 0; // row
				while (($data[$i][$j] = fgetcsv($handle, 1000, ";")) !== FALSE) {
//					$num = count($data[$i][$j]);
					$j++;
				}
				fclose($handle);

				$i++;
			}
		}

		$object['days_interval'] = $days_interval;
		$object['filetime'] = $filetime;
		$object['timestamp'] = $timestamp;
		$object['data'] = $data;

		$object['page_title'] = 'Display Standard Stock di Outlet';

		$this->load->view('dispnonstdstock/dispnonstdstock_browse_result', $object);

	}

}
?>