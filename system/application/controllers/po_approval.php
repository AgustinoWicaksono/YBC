<?php
class Po_approval extends Controller {
	private $jagmodule = array();


	function Po_approval() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1043);  //get module data from module ID
		

    	if(!$this->l_auth->is_logged_in()) {
			$this->l_page->save_page_and_login('login_redirect');
        }

		if(!$this->l_auth->is_have_perm('trans_po_approval'))
			redirect('po_approval_error');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_po_approval');

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

	}

	function approve($po, $release)	{

//        $po = $this->uri->segment(3);
//        $release = $this->uri->segment(4);

		$this->_approve_check();

		if ($this->form_validation->run() == FALSE) {
 			$this->_approve_form($po, $release);
		} else {
			$this->_approve_update();
		}

	}

	function _approve_check() {
		$this->form_validation->set_rules('po', 'PO', 'trim|required');
		$this->form_validation->set_rules('release', 'Release', 'trim|required');
	}


	function _approve_form($po, $release) {

		if(!empty($po) && !empty($release)) {

			if($object['data']['po_approval_header'] = $this->m_po_approval->sap_po_approval_header_select($po, $release)) {

                $user_release_status = $this->m_po_approval->sap_po_approval_select_release_status($release,$object['data']['po_approval_header']['REL_GROUP']);
                $po_status = $this->m_po_approval->sap_po_approval_details_po_status($po);

				if($user_release_status == FALSE) {

					$this->template->write_view('content', 'po_approval/po_approval_not_autorized_user', $object);
					$this->template->render();

				} else {
                    if ($object['data']['po_approval_header']['REL_STATUS'] == str_repeat('X',$user_release_status))
                      $object['data']['po_approval_header']['status_string'] = 'Approved';
                    else if ($po_status=='08')
                      $object['data']['po_approval_header']['status_string'] = 'Rejected';
                    else
                      $object['data']['po_approval_header']['status_string'] = 'Not Approved';

					$object['data']['po_approval_details'] = $this->m_po_approval->sap_po_approval_details_select($po, $release);
					if($object['data']['po_approval_details'] !== FALSE) {
						$i = 1;
						foreach ($object['data']['po_approval_details'] as $object['temp']) {
							foreach($object['temp'] as $key => $value) {
								$object['data']['po_approval_detail'][$key][$i] = $value;
							}
							$i++;
							unset($object['temp']);
						}
					}

					$object['data']['po_delivery_dates'] = $this->m_po_approval->sap_po_approval_details_select_delivery_date($po);
					if($object['data']['po_delivery_dates'] !== FALSE) {
						$i = 1;
						foreach ($object['data']['po_delivery_dates'] as $object['temp']) {
							foreach($object['temp'] as $key => $value) {
								$object['data']['po_delivery_date'][$key][$i] = $value;
							}
							$i++;
							unset($object['temp']);
						}
					}

					$object['data']['po_cost_centers'] = $this->m_po_approval->sap_po_approval_details_select_cost_center($po);
					if($object['data']['po_cost_centers'] !== FALSE) {
						$i = 1;
						foreach ($object['data']['po_cost_centers'] as $object['temp']) {
							foreach($object['temp'] as $key => $value) {
								$object['data']['po_cost_center'][$key][$i] = $value;
							}
							$i++;
							unset($object['temp']);
						}
					}

                    $count = count($object['data']['po_approval_detail']);
                    $object['data']['po_approval_header']['total_price'] = 0;
                    for($i=1;$i<=$count;$i++) {
                      $object['data']['po_approval_header']['total_price'] =
                      $object['data']['po_approval_header']['total_price'] +
                      $object['data']['po_approval_detail']['NET_VALUE'][$i];
                    }

					$object['page_title'] = 'PO Approval';
					$this->template->write_view('content', 'po_approval/po_approval_approve_form', $object);
					$this->template->render();

				}

			} else {

				$this->template->write_view('content', 'po_approval/po_approval_blank', $object);
				$this->template->render();

			}

		} else {

			$this->template->write_view('content', 'po_approval/po_approval_blank', $object);
			$this->template->render();

		}

	}

	function _approve_update() {
		// start of assign variables and delete not used variables
		$po_approval = $_POST;
		unset($po_approval['button']);
		// end of assign variables and delete not used variables

         $user_release_status = $this->m_po_approval->sap_po_approval_select_release_status($release,$po_approval['po_approval_header']['rel_group']);


         if(isset($_POST['button']['approve'])) {

			$data = array (
				'po' =>	$po_approval['po_approval_header']['po'],
				'release' =>	$po_approval['po_approval_header']['release'],
				'status' =>	1,
			);

			$object['approved_data']= $this->m_po_approval->sap_po_approval_header_update($data);

			$this->template->write_view('content', 'po_approval/po_approval_approve_update', $object);
			$this->template->render();

		} else if(isset($_POST['button']['cancel'])) {

			$data = array (
				'po' =>	$po_approval['po_approval_header']['po'],
				'release' =>	$po_approval['po_approval_header']['release'],
				'status' =>	2,
			);

			$object['approved_data']= $this->m_po_approval->sap_po_approval_header_update($data);

			$this->template->write_view('content', 'po_approval/po_approval_reset_update', $object);
			$this->template->render();

		} else if(isset($_POST['button']['reject'])) {

			$data = array (
				'po' =>	$po_approval['po_approval_header']['po'],
			);

			$object['approved_data']= $this->m_po_approval->sap_po_approval_header_reject($data);

			$this->template->write_view('content', 'po_approval/po_approval_reject_update', $object);
			$this->template->render();

		}

	}

	function reset($po, $release)	{

		$this->_reset_check();

		if ($this->form_validation->run() == FALSE) {
 			$this->_reset_form($po, $release);
		} else {
			$this->_reset_update();
		}

	}

	function _reset_check() {
		$this->form_validation->set_rules('po', 'PO', 'trim|required');
		$this->form_validation->set_rules('release', 'Release', 'trim|required');
	}


	function _reset_form($po, $release) {

		if(!empty($po) && !empty($release)) {

			$object['data']['po_approval_header'] = $this->m_po_approval->sap_po_approval_header_select($po, $release);

			if(empty($object['data']['po_approval_header']['status'])) {

				$this->template->write_view('content', 'po_approval/po_approval_original', $object);
				$this->template->render();

			} else {

				$object['data']['po_approval_details'] = $this->m_po_approval->sap_po_approval_details_select($po, $release);

				if($object['data']['po_approval_details'] !== FALSE) {
					$i = 1;
					foreach ($object['data']['po_approval_details'] as $object['temp']) {
						foreach($object['temp'] as $key => $value) {
							$object['data']['po_approval_detail'][$key][$i] = $value;
						}
						$i++;
						unset($object['temp']);
					}
				}

				$object['page_title'] = 'PO Approval Reset';
				$this->template->write_view('content', 'po_approval/po_approval_approve_form', $object);
				$this->template->render();

			}

		}

	}

	function _reset_update() {
		// start of assign variables and delete not used variables
		$po_approval = $_POST;
		unset($po_approval['button']);
		// end of assign variables and delete not used variables

		if(isset($_POST['button']['reset'])) {

			$data = array (
				'po' =>	$po_approval['po_approval_header']['po'],
				'release' =>	$po_approval['po_approval_header']['release'],
				'status' =>	0,
			);

			$this->m_po_approval->sap_po_approval_header_update($data);

			$this->template->write_view('content', 'po_approval/po_approval_reset_update', $object);
			$this->template->render();

		}

	}

}
?>