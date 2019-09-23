<?php
class Ajax extends Controller {
	private $jagmodule = array();


	function Ajax()
	{
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1023);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		$this->load->model('m_trans_select');
	}
	
	function index()
	{
		$this->load->view('index');
	}
	
	function get_ajaxGoodsRecptPO() {
		$purchase_order_no = $this->input->post('purchase_order_no');

		$object['data_1'] = $this->m_trans_select->purchase_data_select_1($purchase_order_no);
		$object['data']['purchase'] = $this->m_trans_select->purchase_data_select($purchase_order_no);

		$this->load->view('ajax/purchase_data_select', $object);
		
	}

	function get_po_no() {
		$this->load->model('m_trans_select');
	
		$vendor_id = $this->uri->segment(3);
	
		if(!empty($vendor_id)) {
			$object['po_nos'] = $this->m_trans_select->po_nos_select_distinct($vendor_id);
			$this->load->view('ajax/ajax_get_po_no', $object);
		}
	
	}
	
}
