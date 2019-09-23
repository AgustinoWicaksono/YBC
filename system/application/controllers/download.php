<?php
class Download extends Controller {
	private $jagmodule = array();


	function Download () {

		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1026);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('download_excel'))
			redirect('');

//
	}

	function index() {
		$this->template();
	}


	function template() {

      	$this->template->write_view('content', 'download', $object);
		$this->template->render();
	}
}

/* End of file download.php */
/* Location: ./system/application/controller/download.php */