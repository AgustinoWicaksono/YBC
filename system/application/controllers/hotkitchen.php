<?php
class hotkitchen extends Controller {
	private $jagmodule = array();


	function hotkitchen() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1060);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_hotkitchen'))
			redirect('');

   		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_hotkitchen');

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

     /*   foreach($this->m_hotkitchen->hotkitchen_get_period_selection() as $data) {
           $s_period = $data['S_PERIODE'];
		   $year = substr($s_period, 0, 4);
		   $month = substr($s_period, 4, 2);
		   $day = substr($s_period, 6, 2);
		   $s_period = $day."-".$month."-".$year;

           $e_period = $data['E_PERIODE'];
		   $year = substr($e_period, 0, 4);
		   $month = substr($e_period, 4, 2);
		   $day = substr($e_period, 6, 2);
		   $e_period = $day."-".$month."-".$year;

    	   unset($year);
    	   unset($month);
    	   unset($day);

 		   $object['periode'][$data['S_PERIODE'].$data['E_PERIODE']] = $s_period.' to '.$e_period;
        }
		// end of form attributes*/

		$object['page_title'] = 'Report Hot Kitchen ';
		$this->template->write_view('content', 'hotkitchen/hotkitchen_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_search() {
        $date_from =$_POST['date'];
        //$date_to = $this->l_general->rightstr($_POST['date'],8);
		$date_to =$_POST['to'];
        $group = $_POST['item_group_code'];
        //$date_to = $this->l_general->rightstr($_POST['date'],8);

		redirect('hotkitchen/browse_result/'.$date_from.'/'.$group.'/'.$date_to);

		
	}

	// search result
	function browse_result($date_from = '', $group='',$date_to = '')	{

		$this->l_page->save_page('hotkitchen_browse_result');
	/*	if($date_from !== '0') {
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
		}*/
		//echo '{'.$date_from.'}';

		unset($year);
		unset($month);
		unset($day);

    	/*foreach ($this->m_hotkitchen->hotkitchen_select_matr($date_from) as $object['temp']) {
    	    $j = 0;
    		foreach($object['temp'] as $key => $value) {
                if ($i == 0) $data[$j][0] = $key;
                $data[$j][$i+1] = $value;
      		  $j++;
    		}
    		$i++;
    		unset($object['temp']);
    	}*/
		
		//$this->load->model('m_hotkitchen');
		//$data['data'] = $this->m_hotkitchen->hotkitchen_select_matr($date_from);
		$object['date_from']=$date_from;
		$object['date_to']=$date_to;
		$object['item_group_code']=$group;
		//echo $object['date'];
	//	$object['data'] = $data;
		$object['page_title'] = 'Report Hot Kitchen';

		//$this->load->view('hotkitchen/hotkitchen_browse_result', $object);
		$this->load->view('hotkitchen/hotkitchen_browse_result', $object);

	}
	
	public function cetak($id_stdstock_header)
	{
		$this->load->model('m_printstock');
		$data['data'] = $this->model_data->tampil($id_stdstock_header);
		$this->load->view('store_room',$data);
	}	

}
?>