<?php
class Po_approval_error extends Controller {
	private $jagmodule = array();


	function Po_approval_error() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1044);  //get module data from module ID
		

    	if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
        }

	}

	// main function
	function index()
	{
				$this->template->write_view('content', 'po_approval/po_approval_error', $object);
				$this->template->render();
	}

}
?>