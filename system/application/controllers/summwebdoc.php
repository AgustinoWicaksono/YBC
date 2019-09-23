<?php
class summwebdoc extends Controller {
	private $jagmodule = array();


	function summwebdoc() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1051);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_summwebdoc'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_summwebdoc');
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
		$summwebdoc_browse_result = $this->session->userdata['PAGE']['summwebdoc_browse_result'];

		if(!empty($summwebdoc_browse_result))
			redirect($this->session->userdata['PAGE']['summwebdoc_browse_result']);
		else
			redirect('summwebdoc/browse_result/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['outlet_type'])) {
			$outlet_type = 0;
		} else {
			$outlet_type = $_POST['outlet_type'];
		}

		if(empty($_POST['outlet_from'])) {
			$outlet_from = 0;
		} else {
			$outlet_from = $_POST['outlet_from'];
		}

		if(empty($_POST['outlet_to'])) {
			$outlet_to = 0;
		} else {
			$outlet_to = $_POST['outlet_to'];
		}

        if($_POST['outlet_type']!=$_POST['outlet_type_old']) {
          $outlet_from=0;
          $outlet_to=0;
        }

		if(empty($_POST['date_from']) || ($_POST['date_from'] == '--')) {
			$date_from = date('d-m-Y');
		} else {
			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}
        if (empty($limit)) {
		  $limit = 10;
        }
		redirect('summwebdoc/browse_result/'.$outlet_type."/".$date_from."/".$outlet_from.'/'.$outlet_to.'/'.$limit);

	}

	// search result
	function browse_result($outlet_type = '', $date_from = '', $outlet_from = '', $outlet_to = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('summwebdoc_browse_result');

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

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['data']['date_from'] = $day."-".$month."-".$year;
		} else {
			$object['data']['date_from'] =  date('d-m-Y');
		}

		unset($year);
		unset($month);
		unset($day);

		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;
		$object['data']['outlet_type'] = $outlet_type;
		$object['data']['outlet_from'] = $outlet_from;
		$object['data']['outlet_to'] = $outlet_to;

		$object['outlet_types'] = array (
			'YBC'	=>	'YBC SOFTWARE',
		);

		$outlets = $this->m_summwebdoc->summwebdoc_headers_select_by_criteria($date_from, $outlet_type);
  		if(!empty($outlets)) {
  			$object['outlets'][0] = '';
  			foreach ($outlets->result_array() as $outlet) {
			  $object['outlets'][$outlet['OUTLET']] = $outlet['OUTLET_NAME2'].' - '.$outlet['OUTLET_NAME1'];
  			}
  		}

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 8;
		$config['base_url'] = site_url('summwebdoc/browse_result/'.$outlet_type."/".$date_from."/".$outlet_from.'/'.$outlet_to.'/'.$limit);

		$config['total_rows'] = $this->m_summwebdoc->summwebdoc_headers_count_by_criteria($date_from, $outlet_type, $outlet_from, $outlet_to);

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['summwebdoc_headers'] = $this->m_summwebdoc->summwebdoc_headers_select_by_criteria($date_from, $outlet_type, $outlet_from, $outlet_to, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];
		$object['ttl_eod_success'] = $this->m_summwebdoc->eod_success_count($date_from, $outlet_type, $outlet_from, $outlet_to);

        $object['grpos'] = $this->m_summwebdoc->grpo_select($date_from);
        $object['grpodlvs'] = $this->m_summwebdoc->grpodlv_select($date_from);
        $object['stockoutlets'] = $this->m_summwebdoc->stockoutlet_select($date_from);
        $object['gistos'] = $this->m_summwebdoc->gisto_select($date_from);
        $object['grstos'] = $this->m_summwebdoc->grsto_select($date_from);
        $object['wastes'] = $this->m_summwebdoc->waste_select($date_from);
        $object['nonstdstocks'] = $this->m_summwebdoc->nonstdstock_select($date_from);
        $object['stdstocks'] = $this->m_summwebdoc->stdstock_select($date_from);
        $object['grfgs'] = $this->m_summwebdoc->grfg_select($date_from);
        $object['tsscks'] = $this->m_summwebdoc->tssck_select($date_from);
        $object['trend_utilitys'] = $this->m_summwebdoc->trend_utility_select($date_from);
        $object['gitccs'] = $this->m_summwebdoc->gitcc_select($date_from);
        $object['prodstaffs'] = $this->m_summwebdoc->prodstaff_select($date_from);
        $object['eods'] = $this->m_summwebdoc->eod_select($date_from);
		$object['page_title'] = 'Material Document Summary';
		$this->template->write_view('content', 'summwebdoc/summwebdoc_browse', $object);
		$this->template->render();

	}

	// input data

}


?>