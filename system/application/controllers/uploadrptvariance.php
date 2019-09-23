<?php
class uploadrptvariance extends Controller {
	private $jagmodule = array();


	function uploadrptvariance() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1056);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_upload_varianceoutlet'))
			redirect('');

   		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_uploadrptvariance');

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

		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
			'target'	=>	'_blank',
		);
		// end of form attributes

		$object['page_title'] = 'Upload Report Variance Outlet';
		$this->template->write_view('content', 'uploadrptvariance/uploadrptvariance_browse', $object);
		$this->template->render();
	}

	// search data

	function file_import($date_from = '', $date_to = '') {

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

      $object['uploadrptvariance_datas'] = $this->m_uploadrptvariance->sap_rpt_variance($date_from,$date_to);

      $this->template->write_view('content', 'uploadrptvariance/uploadrptvariance_file_import_confirm', $object);
      $this->template->render();

	}

	function file_import_execute() {
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//exit;

      if(isset($_POST['button']['upload'])) {
        if($this->m_uploadrptvariance->uploadrptvariance_upload($_POST['date_from'],$_POST['date_to'])) {
 	      $this->l_general->success_page('Report Variance berhasil diupload', site_url('uploadrptvariance/browse'));
        } else {
 		  $this->jagmodule['error_code'] = '001'; 
		$this->l_general->error_page($this->jagmodule, 'Report Variance tidak berhasil diupload', site_url($this->session->userdata['PAGE']['next']));
        }
      }
    }

}
?>