<?php
class Variance2 extends Controller {
	private $jagmodule = array();


	function Variance2() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1059);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_variance2'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_grpo');
		$this->load->model('m_general');

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

		$object['page_title'] = 'Report Variance 2';
		$this->template->write_view('content', 'variance/variance2_browse', $object);
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

		redirect('variance2/browse_result/'.$date_from."/".$date_to);

	}

	// search result
	function browse_result($date_from = '', $date_to = '')	{

		$this->l_page->save_page('variance2_browse_result');

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
			
			if($this->session->userdata['ADMIN']['plant_type_id'] == 'BID'){
				$filename = './report/'.$sap_client['CLIENT'].'_TrendVariance_BID_'.date('Ymd', $timestamp_check).'.csv';
			}
			
			if($this->session->userdata['ADMIN']['plant_type_id'] == 'JID'){
				$filename = './report/'.$sap_client['CLIENT'].'_TrendVariance_JID_'.date('Ymd', $timestamp_check).'.csv';
			}
			
			//$filename = './report/'.$sap_client['CLIENT'].'_Trend_Variance_'.date('Ymd', $timestamp_check).'.csv';
			//echo 'filename: '.$filename;

			if(@$handle = fopen($filename, 'r')) {

				$filetime[$i] = filemtime($filename);
				$timestamp[$i] = $timestamp_check;

				$subtotal[$i][5] = 0; // Std. Value
				$subtotal[$i][9] = 0; // Actual Value
				$subtotal[$i][12] = 0; // Var+ Value
				$subtotal[$i][14] = 0; // Var- Value
				$subtotal[$i][16] = 0; // Denda Penggantian

				$j = 0; // row
				while (($data[$i][$j] = fgetcsv($handle, 1000, ";")) !== FALSE) {
//					$num = count($data[$i][$j]);

            		if($data[$i][$j][0] == $this->session->userdata['ADMIN']['plant']) { // check is it the plant's data?
    					$subtotal[$i][5] += $data[$i][$j][5];
    					$subtotal[$i][9] += $data[$i][$j][9];
    					$subtotal[$i][12] += $data[$i][$j][12];
    					$subtotal[$i][14] += $data[$i][$j][14];
    					$subtotal[$i][16] += $data[$i][$j][16];

    					$total[5] += $data[$i][$j][5];
    					$total[9] += $data[$i][$j][9];
    					$total[12] += $data[$i][$j][12];
    					$total[14] += $data[$i][$j][14];
    					$total[16] += $data[$i][$j][16];
                    }

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
		$object['subtotal'] = $subtotal;
		$object['total'] = $total;

		$object['page_title'] = 'Report Variance 2';

		$this->load->view('variance/variance2_browse_result', $object);

	}

}
?>