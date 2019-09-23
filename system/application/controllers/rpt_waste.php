<?php
class Rpt_waste extends Controller {
	private $jagmodule = array();

	function UbahBulanWaste($nilai)
		{
		if ($nilai == "01") {
			$hasil = "Januari";
		}
		elseif ($nilai == "02") {
			$hasil = "Februari";
		}
		elseif ($nilai == "03") {
			$hasil = "Maret";
		}
		elseif ($nilai == "04") {
			$hasil = "April";
		}
		elseif ($nilai == "05") {
			$hasil = "Mei";
		}
		elseif ($nilai == "06") {
			$hasil = "Juni";
		}
		elseif ($nilai == "07") {
			$hasil = "Juli";
		}
		elseif ($nilai == "08") {
			$hasil = "Agustus";
		}
		elseif ($nilai == "09") {
			$hasil = "September";
		}
		elseif ($nilai == "10") {
			$hasil = "Oktober";
		}
		elseif ($nilai == "11") {
			$hasil = "November";
		}
		elseif ($nilai == "12") {
			$hasil = "Desember";
		}
		else
		{ $hasil = ""; }


		return $hasil;
	}
	
	function Rpt_waste() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1075);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if ((!$this->l_auth->is_have_perm('report_waste')) && (!$this->l_auth->is_have_perm('report_waste_detail')))
			redirect('');

		$this->load->helper('form');
		$this->load->helper('download');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_rpt_waste');

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
		$this->input();
	}

	// input data
	function input() {
		$this->_input_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->browse(0, $data);
			} else {
				$this->browse();
			}

		} else {
			$this->browse_result();
		}
	}
	
	function _input_check() {
		$this->form_validation->set_rules('date_from', 'From Date', 'trim|required|');
		$this->form_validation->set_rules('ckplant[]', 'Plant', 'required');
	}
	
	// list data
	function browse($reset=0, $data=NULL) {
	
		$object['reset'] = $reset;
		
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

		}		
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'frmWasteReport',
			'id'	=>	'frmWasteReport',
			'target'	=>	'_blank',
		);
		// end of form attributes

		$object['page_title'] = 'Report Waste';
		$plants = $this->m_perm->admin_plants_select_all($this->session->userdata['ADMIN']['admin_id']);
		$object['plants'] = $plants;
		$this->template->write_view('content', 'rpt_waste/rpt_waste_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_result() {
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
		$tgl1 = substr($date_from,6,2).' '.$this->UbahBulanWaste(substr($date_from,4,2)).' '.substr($date_from,0,4);
		$tgl2 = substr($date_to,6,2).' '.$this->UbahBulanWaste(substr($date_to,4,2)).' '.substr($date_to,0,4);

		$date_from = substr($date_from,0,4).'-'.substr($date_from,4,2).'-'.substr($date_from,6,2);
		$date_to = substr($date_to,0,4).'-'.substr($date_to,4,2).'-'.substr($date_to,6,2);
		
		$data['plants'] = $_POST['ckplant'];
		$data['date_from'] = $date_from;
		$data['date_to'] = $date_to;
		$data['tgl1'] = $tgl1;
		$data['tgl2'] = $tgl2;
		
		$data['stock_type']= $_POST['stock_type'];
		
		if ($_POST['report_option']=='excel'){
			$this->browse_result_excel($data);
		} else {
			if (count($data['plants']) > 25) {
				$object['refresh_text'] = 'Jika lebih dari 25 plant, harap gunakan fasilitas export ke Excel. Browser Anda tidak akan sanggup menampilkan jumlah data yang banyak.';
				$object['refresh_url'] = site_url('rpt_waste/input');
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '001';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
			} else {
				$this->browse_result_screen($data);
			}
		}

	}

	// screen result
	function browse_result_screen($data)	{
		//print_r($data);
		$object = $data;
		$object['page_title'] = 'Report Waste: '.$data['tgl1'].' - '.$data['tgl2'];
		$object['rpt'] = $this->m_rpt_waste->waste_by_sfg($data,'screen',1,$data['stock_type']);
		
		$this->template->write_view('content', 'rpt_waste/rpt_waste_browse_result', $object);
		$this->template->render();		
	}
	
	// search result
	function browse_result_excel($data)	{
		$object = $data;
		$object['page_title'] = 'Report Waste: '.$data['tgl1'].' - '.$data['tgl2'];
		$object['rpt'] = $this->m_rpt_waste->waste_by_sfg($data,'excel',0,$data['stock_type']);

		force_download('Waste_'.date('Ymd-His').'.csv', $object['rpt']); 		
		
		// $this->l_general->export_to_excel($object['rpt'],'waste');
	}	

}
?>