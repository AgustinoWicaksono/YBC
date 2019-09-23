<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Page Class
 * Used to redirect to specific page
 * or : 'Remember' page layout
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class L_page {

	/**
	 * Page Class
	 * Used to redirect to specific page
	 * or : 'Remember' page layout
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function L_page() {
		$this->obj =& get_instance();
	}

	/**
	 * Save page to session, on $this->session->userdata['PAGE'][$page_name],
	 * and then go to login page
	 * @param string $page_name page name, page variable
	 * @return void
	 */
	function save_page_and_login($page_name, $content = '') {
		$page1 = $this->obj->session->userdata('PAGE');
		if(!empty($page1))
			$PAGE = $page1;

		if(empty($content))
//			$PAGE[$page_name] = $_SERVER['REQUEST_URI'];
			$PAGE[$page_name] = $this->obj->uri->uri_string();
		else
			$PAGE[$page_name] = $content;

		$this->obj->session->set_userdata('PAGE', $PAGE);
//		print_r($this->obj->session->userdata('PAGE'));
		redirect('');
	}

	/**
	 * Save page to session, on $this->session->userdata['PAGE'][$page_name]
	 * @param string $page_name page name, page variable
	 * @return void
	 */
	function save_page($page_name, $content = '') {
		$page1 = $this->obj->session->userdata('PAGE');
		if(!empty($page1))
			$PAGE = $page1;

		if(empty($content))
//			$PAGE[$page_name] = $_SERVER['REQUEST_URI'];
			$PAGE[$page_name] = $this->obj->uri->uri_string();
		else if ($content == 'referer')
			$PAGE[$page_name] = $_SERVER['HTTP_REFERER'];
		else
			$PAGE[$page_name] = $content;

		$this->obj->session->set_userdata('PAGE', $PAGE);
//		print_r($this->obj->session->userdata('PAGE'));
	}

}

/* End of file L_page.php */
/* Location: ./system/application/libraries/L_page.php */