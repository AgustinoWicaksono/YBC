<?php
class Plant extends Controller {
	private $jagmodule = array();


	function Plant() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1072);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_general');
		$this->load->model('m_general');
		$this->load->model('m_admin');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}

	function index()
	{
		$this->change();
	}

	function change($nexturl='') {
		

		$this->_change_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
			$data['nexturl'] = $nexturl;
  			$this->_change_form(0, $data);
    	} else {
            $data = $this->m_general->sap_plant_select_by_id($this->session->userdata['ADMIN']['plant']);
			$data['nexturl'] = $nexturl;
  			$this->_change_form(0, $data);
      }

		} else {
			$this->_change_update();
    }

	}

	function _change_check() {
		$this->form_validation->set_rules('plant', 'Plant', 'trim|required');
	}

	function _change_form($reset=0, $data=NULL) {
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
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Ubah Outlet Aktif';

		$object['plants'] = $this->m_perm->admin_plants_select_all($this->session->userdata['ADMIN']['admin_id']);
//				print_r($object['plants']);
		if($object['plants'] !== FALSE) {
//			$object['plant'][0] = '';
			$sGroup = '';
			
			foreach ($object['plants'] as $plantkey=>$plant) {
				if (trim($plant['OUTLET'])=="") continue;
				if ($sGroup!=$plant['jenisoutlet']){
					$sGroup = $plant['jenisoutlet'];
				}
				$object['plant'][$sGroup][$plant['OUTLET']] = $plant['OUTLET_NAME2'].' - '.$plant['OUTLET_NAME1']." (".$plant['OUTLET'].")";
			}

		}
// print_r($object['plant']);

		$this->template->write_view('content', 'plant/plant_edit', $object);
		$this->template->render();
	}

	function _change_update()	{
		// start of assign variables and delete not used variables
		$plant = $_POST;
		$admin['plant'] = $plant['plant'];
		$admin['plant_type_id'] = $this->m_general->sap_get_plant_type_id($plant['plant']);
		$admin['admin_id'] = $this->session->userdata['ADMIN']['admin_id'];

		unset($posisi['button']);
		// end of assign variables and delete not used variables

		if($this->m_admin->admin_update($admin)) {

			$userdata['ADMIN'] = $this->session->userdata['ADMIN'];

			$userdata['ADMIN']['plant'] = $admin['plant'];
			$userdata['ADMIN']['plant_type_id'] = $admin['plant_type_id'];
			$userdata['ADMIN']['plants'] = $this->m_general->sap_get_user_plants($this->session->userdata['ADMIN']['admin_id']);
			$plant = $this->m_general->sap_plant_select_by_id($admin['plant']);
        	$userdata['ADMIN']['plant_name'] = $plant['OUTLET_NAME1'];
        	$userdata['ADMIN']['storage_location'] = $plant['STOR_LOC'];
        	$userdata['ADMIN']['storage_location_name'] = $plant['STOR_LOC_NAME'];
        	$userdata['ADMIN']['hr_plant_code'] = $plant['HR_CODE'];
        	$userdata['ADMIN']['cost_center'] = $plant['COST_CENTER'];
        	$userdata['ADMIN']['cost_center_name'] = $plant['COST_CENTER_TXT'];

  	    	$this->session->set_userdata($userdata);

//		    $this->l_general->success_page('Data Plant Aktif Berhasil Diubah', site_url($next_uri));
			$next_uri = $this->uri->segment(3);
			if ((Empty($next_uri)) || (($next_uri!="ipcam") && (strpos("###".$next_uri,"report")==0))) $next_uri = "home";
			redirect($next_uri);
/*			
			$object['page_title'] = 'Data Plant Aktif Berhasil Diubah';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data plant aktif berhasil diubah.';
			$object['refresh_url'] = 'home';

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();      
*/
		}

	}

}
