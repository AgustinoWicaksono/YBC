<?php
class Agging extends Controller {
	private $jagmodule = array();


	function Agging() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1013);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('masterdata_agging'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_agging');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}
	
	function index()
	{
		$this->browse();
	}

	function browse() {
		$agging_browse_result = $this->session->userdata['PAGE']['agging_browse_result'];

		if(!empty($agging_browse_result))
			redirect($this->session->userdata['PAGE']['agging_browse_result']);
		else
			redirect('agging/browse_result');
	
	}

	function browse_result()	{

		$this->l_page->save_page('agging_browse_result');
		$this->load->library('pagination');

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		
		
		$config['per_page'] = 20;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 8;
		$config['base_url'] = site_url('agging/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_agging->aggings_select_all_count();
		$this->pagination->initialize($config);
		$object['data']['agging'] = $this->m_agging->aggings_select_all();
		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];


		$object['page_title'] = 'ITEM AGGING';
		$this->template->write_view('content', 'agging/agging_browse', $object);
		$this->template->render();

	}

	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_data_form(0, $data);
	   	} else {
	 			$this->_data_form();
	     }

		} else {
			$this->_data_add();
		}

	}

	function edit() {

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_data_form(0, $data);
    	} else {
        $data = $this->m_agging->agging_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
//		$this->form_validation->set_rules('id_agging', 'Employee Position Code', 'trim|required');
		$this->form_validation->set_rules('agging', 'Employee Position', 'trim|required');
	}
	
	function _data_form($reset=0, $data=NULL) {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $member array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Employee Position';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'agging/agging_input', $object);
		$this->template->render();
	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$agging = $_POST;
		unset($agging['button']);
		// end of assign variables and delete not used variables

		if($this->m_agging->agging_add($agging)) {

			$object['page_title'] = 'Data Agging Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data agging berhasil dimasukkan.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
	
			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		
		}
	}

	function _data_update()	{
		// start of assign variables and delete not used variables
		$agging = $_POST;
		unset($agging['button']);
		// end of assign variables and delete not used variables

		if($this->m_agging->agging_update($agging)) {
			
			$object['page_title'] = 'Data Agging Berhasil Diubah';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data agging berhasil diubah.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
	
			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
		
	}

}
