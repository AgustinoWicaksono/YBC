<?php
class Stockstatus extends Controller {
	private $jagmodule = array();


	function Stockstatus() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1050);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_stockstatus'))
			redirect('');

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
		
		$object['input_month'] = array (
			'1'	=>	'January',
			'2'	=>	'February',
			'3'	=>	'March',
			'4'	=>	'April',
			'5'	=>	'May',
			'6'	=>	'June',
			'7'	=>	'July',
			'8'	=>	'August',
			'9'	=>	'September',
			'10'	=>	'October',
			'11'	=>	'November',
			'12'	=>	'December',			
		);
		
		$object['input_year'] = array (
			'2012'	=>	'2012',
		);

		$object['page_title'] = 'Report Status Stock Opname';
		$this->template->write_view('content', 'stockstatus/stockstatus_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_search() {

		$input_month = $_POST['input_month'];
		$input_year = $_POST['input_year'];
		
		redirect('stockstatus/browse_result/'.$input_month."/".$input_year);

	}

	// search result
	function browse_result($input_month = '', $input_year = '')	{

		$this->l_page->save_page('stockstatus_browse_result');
		
		$object['int_month'] = $input_month;
		$int_month = $input_month;
		
		switch ($input_month){
			case '1': 
				$object['input_month'] = 'January';
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '2': 
				$object['input_month'] = 'February'; 
				$dayfrom = 1;
				$dayto = 28;
			break;
			case '3': 
				$object['input_month'] = 'March'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '4': 
				$object['input_month'] = 'April'; 
				$dayfrom = 1;
				$dayto = 30;
			break;
			case '5': 
				$object['input_month'] = 'May'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '6': 
				$object['input_month'] = 'June'; 
				$dayfrom = 1;
				$dayto = 30;
			break;
			case '7': 
				$object['input_month'] = 'July'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '8': 
				$object['input_month'] = 'August'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '9': 
				$object['input_month'] = 'September'; 
				$dayfrom = 1;
				$dayto = 30;
			break;
			case '10': 
				$object['input_month'] = 'October'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			case '11': 
				$object['input_month'] = 'November'; 
				$dayfrom = 1;
				$dayto = 30;
			break;
			case '12': 
				$object['input_month'] = 'December'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
			default: 
				$object['input_month'] = 'January'; 
				$dayfrom = 1;
				$dayto = 31;
			break;
		}
		
		//tahun kabisat
		if (fmod($input_year,4) == 0){
			$dayfrom = 1;
			$dayto = 29;
		}

		//date from
		if($date_from !== '0') {
			$year = $input_year;
			$month = $input_month;
			$object['date_from'] = $dayfrom."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$dayfrom.' 00:00:00';
		} else {
//			$object['data']['date_from'] = '';
			$object['date_from'] = date("d-m-Y", now());
			$date_from2 = '0';
		}
		
		//date to
		if($date_to !== '0') {
			$object['date_to'] = $dayto."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$dayto.' 23:59:59';
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
		
		//bla bla bla			
		$object['input_year'] = $input_year;
		
		$object['date_start'] = $date_from2;
		$object['date_end'] = $date_to2;
		
		$object['days_interval'] = $days_interval;
		$object['filetime'] = $filetime;
		$object['timestamp'] = $timestamp;
		$object['data'] = $data;

		$object['page_title'] = 'Report Status Stock Opname';
		$this->template->write_view('content', 'stockstatus/stockstatus_browse_result', $object);
		$this->template->render();
	}
	
}
?>