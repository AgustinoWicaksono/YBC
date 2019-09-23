<?php
class endofmonth extends Controller {
	private $jagmodule = array();


	function endofmonth() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1012);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_input_dl'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_endofmonth');

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));
	}

	// main function
	function index() {
		$this->enter();
	}

	function enter() {

		$object['data'] = NULL;

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
        $periods = $this->m_endofmonth->m_shcedule_pmbyrn_select();
        if(!empty($periods)) {
            $i = 0;
            foreach($periods as $period) {
                if ($i==0) $periode1 = $period['kode_grouppembayaran'];
    			$object['periodes'][$period['kode_grouppembayaran'].$period['period']] = $period['kode_grouppembayaran'].' - '.$period['period'].' ('.$period['mulai'].' s/d '.$period['akhir'].')';
                $i++;
            }
        }
        $object['data']['periode'] = $periode1.date('Ym');
		$object['page_title'] = 'End of Month';
		$this->template->write_view('content', 'endofmonth/endofmonth_form', $object);
		$this->template->render();

	}

	function enter2() {

		redirect('endofmonth/input/'.$_POST['periode']);

	}



	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {

    	   		$data = $_POST;

				if (!Empty($data['periode'])){
					$this->_data_form(0, $data);
				} else {
					$object['refresh'] = 0;
					$object['refresh_text'] = 'Periode harus diisi';
					$object['refresh_url'] = 'endofmonth/';

					$object['jag_module'] = $this->jagmodule;
					$object['error_code'] = '001';
					$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
					$this->template->write_view('content', 'errorweb', $object);
					$this->template->render();
				}

	   	} else {
    	   		$data = $_POST;
				$this->_data_form(0, $data);

	  	}

		} else {
			$this->_data_add();
		}

	}

	function _data_check() {
		$this->form_validation->set_rules('periode', 'Periode', 'trim|required');
	}

	function _data_form($reset=0, $data=NULL) {
		$object['reset'] = $reset;


		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
		}
        //echo "<pre>";
        //echo print_r($data);
        //echo "</pre>";
        //exit;
		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
        $periode = $this->uri->segment(3);
		
		$current_periode='';
		$current_kodegroup='';

        $periods = $this->m_endofmonth->m_shcedule_pmbyrn_select();
        if(!empty($periods)) {
            foreach($periods as $period) {
    			$object['periodes'][$period['kode_grouppembayaran'].$period['period']] = $period['kode_grouppembayaran'].' - '.$period['period'].' ('.$period['mulai'].' s/d '.$period['akhir'].')';
				if ((!Empty($periode)) && ($period['kode_grouppembayaran'].$period['period']==$periode)) {
					$current_periode=$period['period'];
					$current_kodegroup=$period['kode_grouppembayaran'];
				}
            }
        }
		

        $object['data']['periode'] = $periode;
       	$object['cabangs'] = $this->m_endofmonth->endofmoth_plants_select($this->session->userdata['ADMIN']['admin_id'],$current_kodegroup,$current_periode);
		//print_r($object['cabangs']);

  		$object['page_title'] = 'End of Month';
  		$this->l_page->save_page('next');

  		$this->template->write_view('content', 'endofmonth/endofmonth_input', $object);
  		$this->template->render();

	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$endofmonth = $_POST;
		unset($endofmonth['submit']);
		// end of assign variables and delete not used variables

		if($this->m_endofmonth->endofmoth_add($endofmonth)) {
			$berhasil = 1;
		} else {
			$berhasil = 0;
		}

		if($berhasil) {

			$object['page_title'] = 'Data End Of Month Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data End of Month berhasil dimasukkan.';
//			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$object['refresh_url'] = 'endofmonth/';

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
			$object['refresh'] = 0;
			$object['refresh_text'] = 'Data End of Month gagal ditambahkan';
			$object['refresh_url'] = 'endofmonth/input/'.$endofmonth['periode'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '002';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}


}
// EOF