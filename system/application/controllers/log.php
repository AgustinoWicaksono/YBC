<?php
class User extends Controller {
	private $jagmodule = array();


	function User() {

		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1073);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
			//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		$function = $this->uri->segment(2);

		if($function != 'password_edit')
	 		if(!$this->l_auth->is_have_perm('masterdata_admin'))
				redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->library('l_form_validation');
		$this->load->library('l_pagination');
        $this->load->library('user_agent');
		$this->load->model('m_log');
		$this->load->model('m_general');
		$this->load->model('m_employee');

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('date', $this->session->userdata('lang_name'));
		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
;
		$this->lang->load('g_admin', $this->session->userdata('lang_name'));
		$this->lang->load('g_perm', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
	}

	function index()
	{
		$this->browse();
	}

	// list data
	function browse() {
		$admin_browse_result = $this->session->userdata['PAGE']['admin_browse_result'];

		if(!empty($admin_browse_result))
			redirect($this->session->userdata['PAGE']['admin_browse_result']);
		else
			redirect('log/browse_result/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}

    if (empty($limit)) {
		  $limit = 10;
    }
//		redirect('user/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('log/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('admin_browse_result');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);

		$object['form2'] = array(
			'name'	=>	'form2',
			'id'	=>	'form2',
		);
		// end of form attributes

		$object['data']['field_name'] = $field_name;
		$object['data']['field_type'] = $field_type;

		if($field_content !== '0') {
			$object['data']['field_content'] = $field_content;
		} else {
			$object['data']['field_content'] = '';
		}
/*
		$object['data']['sort1'] = $sort1;
		$object['data']['sort2'] = $sort2;
		$object['data']['sort3'] = $sort3;
*/
		$object['data']['sort'] = $sort;

		$object['data']['status'] = $status;
		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;

		$object['field_name'] = array (
			'a'	=>	'User ID',
			'b'	=>	'User Name',
			'c'	=>	'Nama Lengkap',
		);

		$object['field_type'] = array (
			'part'	=>	'Any Part of Field',
			'all'	=>	'All Part of Field',
		);


/*
		$object['sort'] = array (
			'gy'	=>	'Goods Receipt No ASC',
			'gz'	=>	'Goods Receipt No DESC',
			'py'	=>	'Purchase Order No ASC',
			'pz'	=>	'Purchase Order No DESC',
			'vy'	=>	'Vendor Code ASC',
			'vz'	=>	'Vendor Code DESC',
			'ny'	=>	'Vendor Name ASC',
			'nz'	=>	'Vendor Name DESC',
			'dy'	=>	'Posting Date ASC',
			'dz'	=>	'Posting Date DESC',
		);
*/

		$sort_link1 = 'log/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
			'by'	=>	$sort_link1.'by'.$sort_link2,
			'bz'	=>	$sort_link1.'bz'.$sort_link2,
			'cy'	=>	$sort_link1.'cy'.$sort_link2,
			'cz'	=>	$sort_link1.'cz'.$sort_link2,

		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 8;
		$config['base_url'] = site_url('log/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_log->admin_count_by_criteria($field_name, $field_type, $field_content, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['admins'] = $this->m_log->admin_select_by_criteria($field_name, $field_type, $field_content, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'Managemen Pengguna';
		$this->template->write_view('content', 'log/admin_browse', $object);
		$this->template->render();

	}

	// display all segment on admin profile
	function view($admin_id = 0) {

		$admin_id = (int) $admin_id;

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('date', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));


		if(empty($admin_id))
			$admin_id = $this->session->userdata['ADMIN']['admin_id'];

		$object['admin_id'] = $admin_id;

		$object['data'] = $this->m_log->admin_select($admin_id);

		// save this page to referer
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'log/admin_view', $object);
		$this->template->render();

	}

	function delete($admin_id) {

		$admin_id = (int) $admin_id;

		$this->m_log->admin_delete($admin_id);

		redirect($this->session->userdata['PAGE']['next']);
	}

	// input data
	function input() {
	/*

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
//		if(!empty($_POST['kd_vendor'])) {
			$data = $_POST;
			$object['data'] = $data;

		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
			$object['data']['plant'] = 0;

		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['plant_types'] = $this->m_general->sap_jenisoutlets_select_all();

		if($object['plant_types'] !== FALSE) {
			$object['plant_type'][0] = '';

			foreach ($object['plant_types']->result_array() as $plant_type) {
				$object['plant_type'][$plant_type['id_jenisoutlet']] = $plant_type['jenisoutlet'];
			}

		}

		if(!empty($data['plant_type'])) {
			redirect('user/input2/'.$data['plant_type']);
		}

		$object['page_title'] = 'Manajemen User';
		$this->template->write_view('content', 'user/admin_input_form', $object);
		$this->template->render();
*/
		$this->_input_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_input_form(0, $data);
	   	} else {
	 			$this->_input_form();
	     }

		} else {
			$this->_input_add();
		}
	}

	// input admin data
	function input2()	{

		$this->_input_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_input_form(0, $data);
	   	} else {
	 			$this->_input_form();
	     }

		} else {
			$this->_input_add();
		}

	}

	function _input_check() {
		$this->form_validation->set_rules('admin_username', $this->lang->line('admin_username'), 'trim|required|username_exist');
		$this->form_validation->set_rules('admin_realname', $this->lang->line('admin_realname'), 'trim|required|');
//		$this->form_validation->set_rules('admin_password', $this->lang->line('admin_password'), 'required|valid_password|md5');
		$this->form_validation->set_rules('admin_password', $this->lang->line('admin_password'), 'required|md5');
		$this->form_validation->set_rules('admin_password_confirm', $this->lang->line('admin_password_confirm'), 'required|matches[admin_password]');
	}

	function _input_form($reset=0, $data=NULL) {
		// if admin added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		$plant_type_id = $this->uri->segment(3);

		// if $data exist, add to the $admin array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
//			$admin['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = $this->lang->line('admin_add');

		//$object['plant_type'] = $this->m_general->sap_jenisoutlet_select($plant_type_id);

		//$object['plants'] = $this->m_general->sap_plants_select_all($plant_type_id);

		$object['perm_groups'] = $this->m_perm->perm_groups_select_all();

		/* //temporary disabled 20140217
		$data['employees'] = $this->m_employee->employees_select_all();

		if($data['employees'] !== FALSE) {

			foreach ($data['employees']->result_array() as $employee) {
				$object['employee'][$employee['employee_id']] = $employee['nik'].' - '.$employee['nama'];
			}
		}
		 //temporary disabled 20140217 */

//new
// print_r($data['admin']['admin_id']);die();

		$object['plant_types'] = $this->m_general->sap_jenisoutlets_select_all();

		if($object['plant_types'] !== FALSE) {
			$object['plant_terpilih'] = '';$object['plant_terpilih_count'] = 0;
			
			//hardcode
			$object['plant_type']['OFFICE'] = 'YBC Office';
			$hasil = $this->m_log->select_plants('OFFICE',$data['admin']['admin_id'],$object['data']['admin']['plants'],$object['plant_terpilih'],$object['plant_terpilih_count']);
			$object['plant_terpilih'] = $hasil['plant_terpilih'];
			$object['plant_terpilih_count'] = $hasil['plant_terpilih_count'];
			$object['plants']['OFFICE'] = $hasil['plant'];
			$object['allplant']['OFFICE'] = $hasil['allplant'];
			//hardcode
			
			
			foreach ($object['plant_types']->result_array() as $plant_type) {
				$object['plant_type'][$plant_type['id_jenisoutlet']] = $plant_type['jenisoutlet'];
				$hasil = $this->m_log->select_plants($plant_type['id_jenisoutlet'],$data['admin']['admin_id'],$object['data']['admin']['plants'],$object['plant_terpilih'],$object['plant_terpilih_count']);
				$object['plant_terpilih'] = $hasil['plant_terpilih'];
				$object['plant_terpilih_count'] = $hasil['plant_terpilih_count'];
				$object['plants'][$plant_type['id_jenisoutlet']] = $hasil['plant'];
				$object['allplant'][$plant_type['id_jenisoutlet']] = $hasil['allplant'];
			}
			
		}
		//print_r($object['plants']);die();
//new			
		//		$admin['submit_text'] = 'button_submit';

		$this->template->write_view('content', 'log/admin_profile_form', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign admin data and delete not used vars
		$admin = $_POST['admin'];
		unset($admin['admin_id']);

		$admin['plant_type_id'] = $_POST['plant_type_id'];
		$admin['admin_password'] = $_POST['admin_password']; // specially for admin_password field, it must define individually
		$admin['admin_username'] = $_POST['admin_username'];
		
		if (!$this->m_log->check_username_exist($admin['admin_username'])) {
			$data_nik = $_POST['data_nik'];
			if ($data_nik!='') {
				$admin['admin_emp_id'] = $this->m_log->select_employee_id($data_nik);
			} else {
				$admin['admin_emp_id'] = 0;
			}
			$admin['admin_realname'] = $_POST['admin_realname'];
			$admin['admin_email'] = $_POST['admin_email'];

			$plant_all = $_POST['ALL'];
			$plant_id = $_POST['ckplant'];
			$perm_group_id = $_POST['perm_group_id'];
			// end of assign $admin vars and delete not used vars

			$admin['plants'] = ' ';
			foreach ($plant_id as $value) {
				$admin['plants'] .= trim($value).", ";
				if(empty($admin['plant']))
					$admin['plant'] = trim($value);
			}
			if ($admin['plant']!='')
				$admin['plant_type_id'] = $this->m_log->select_company_code($admin['plant']);

			$admin['admin_selectall'] = '';
			foreach ($plant_all as $value) {
				$admin['admin_selectall'] .= trim($value).", ";
			}

			$admin['admin_perm_grup_ids'] = ' ';

			foreach ($perm_group_id as $value) {
				$admin['admin_perm_grup_ids'] .= $value.", ";
			}
			if (intval($admin['admin_emp_id'])>0) {
				if (strpos('#'.$admin['admin_perm_grup_ids'], ' 0,')>0) {
				} else {
					$admin['admin_perm_grup_ids'] = ' 0,'.$admin['admin_perm_grup_ids'];//tambahkan employee self-service jika ada nik
				}
			} else {
				$admin['admin_perm_grup_ids'] = str_replace(' 0,','',$admin['admin_perm_grup_ids']);
			}

			$admin['admin_add_id'] = $this->session->userdata['ADMIN']['admin_id'];
			$admin['add_time'] = date("Y-m-d H:i:s");
			$admin['edit_time'] = date("Y-m-d H:i:s");

			//print_r($admin);die();
			$admin_id = $this->m_log->admin_add($admin);

			$this->_input_success($admin['admin_username']);
		} else {
			$object['refresh_text'] = 'Username telah ada. Harap gunakan username lain.';
			$object['refresh_url'] = 'log/input';
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '003';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}
	}

	function _input_success($admin_username) {
		$object['refresh'] = 1;
		$object['refresh_text'] = sprintf($this->lang->line('admin_add_success'), $admin['admin_name']);
		$object['refresh_url'] = site_url('log/browse_result/b/part/'.$admin_username.'/0/100');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	// edit password
	function password_edit($admin_id = 0) {

		if(empty($admin_id) || !$this->l_auth->is_have_perm('masterdata_admin'))
			$admin_id = $this->session->userdata['ADMIN']['admin_id'];

		$this->_password_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->_password_form(0, $data);
			} else {
				$this->l_page->save_page('next', 'referer');
				$data = $this->m_log->admin_select($admin_id);
				$this->_password_form(0, $data);
			}

		} else {
			$this->_password_update();
		}
	}

	function _password_check() {

		if (!$this->l_auth->is_have_perm('admin_password_edit_all'))
			$this->form_validation->set_rules('admin_password_old', $this->lang->line('admin_password_old'), 'required|admin_password_old_right');

//		$this->form_validation->set_rules('admin_password', $this->lang->line('admin_password_new'), 'required|valid_password|md5');
		$this->form_validation->set_rules('admin_password', $this->lang->line('admin_password_new'), 'required|md5');
		$this->form_validation->set_rules('admin_password_confirm', $this->lang->line('admin_password_new_confirm'), 'required|matches[admin_password]');
	}

	function _password_form($reset, $data)	{

		// if admin added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $admin array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
			//      $admin['data']['sex'] = 2;
		}

		// form attributes
		$admin_header['form'] = array(
			'name'	=>	'admin',
			'id'	=>	'admin',
		);
		// end of form attributes

		$object['page_title'] = $this->lang->line('admin_password_edit');

		$this->template->write_view('content', 'log/admin_password_form', $object);
		$this->template->render();
	}

	function _password_update()	{
		// assign admin data and delete not used vars
		$admin = $_POST;
		$uri_segment3 = $this->uri->segment(3);

		if (!$this->l_auth->is_have_perm('masterdata_admin') || empty($uri_segment3))
			$admin['admin_id'] = $this->session->userdata['ADMIN']['admin_id'];

		unset($admin['admin_password_old']);
		unset($admin['admin_password_confirm']);
		unset($admin['submit']);
		unset($admin['submit_x']);
		unset($admin['submit_y']);

		if($this->m_log->admin_update($admin)) {
			$this->session->unset_userdata('password');

			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('redirect_admin_password_update_success'), $admin['admin_name']);
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
	}

	// edit admin data
	function profile_edit($admin_id = 0) {

		if(empty($admin_id) || !$this->l_auth->is_have_perm('masterdata_admin'))
			$admin_id = $this->session->userdata['ADMIN']['admin_id'];

		$this->_profile_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$data['admin_perm_group_ids'] = $this->m_perm->admin_perm_group_ids_select($admin_id);
				$this->_profile_form(0, $data);
			} else {
				$this->l_page->save_page('next', 'referer');
				$data['admin'] = $this->m_log->admin_select($admin_id);
				
//				print_r($data['admin']);

				$plants = $this->m_perm->admin_plants_select($admin_id);

				foreach($plants as $plant) {
					$data['plant_id'][] = $plant['OUTLET'];
				}

				$data['perm_group_id'] = $this->m_perm->admin_perm_group_ids_select($admin_id);
				$this->_profile_form(0, $data);
			}

		} else {
			$this->_profile_update();
		}
	}


	// check admin inputted from form
	function _profile_check() {
		$this->form_validation->set_rules('admin_realname', $this->lang->line('admin_realname'), 'trim|required|');
	}

	// admin form
	function _profile_form($reset=0, $data=NULL) {

		// if admin added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $admin array
		if($data != NULL) {
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
			//      $admin['data']['sex'] = 2;
		}

        if ($this->uri->segment(2)=='profile_edit') {
            $plant_type_id = $data['admin']['plant_type_id'];
        } else {
    		$plant_type_id = $this->uri->segment(4);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
//echo $object['data']['admin']['plants'];echo '<hr />';
		$object['page_title'] = $this->lang->line('admin_profile_edit');

		// $object['plant_type'] = $this->m_general->sap_jenisoutlet_select($plant_type_id);

		// $object['plants'] = $this->m_general->sap_plants_select_all($plant_type_id);

		$object['perm_groups'] = $this->m_perm->perm_groups_select_all();

		/* //temporary disabled 20140217

		$data['employees'] = $this->m_employee->employees_select_all();

		if($data['employees'] !== FALSE) {

			foreach ($data['employees']->result_array() as $employee) {
				$object['employee'][$employee['employee_id']] = $employee['nik'].' - '.$employee['nama'];
			}
		}
		 //temporary disabled 20140217 */

		
//new
// print_r($data['admin']['admin_id']);die();

		$object['plant_types'] = $this->m_general->sap_jenisoutlets_select_all();

		if($object['plant_types'] !== FALSE) {
			$object['plant_terpilih'] = '';$object['plant_terpilih_count'] = 0;
			
			//hardcode
			$object['plant_type']['OFFICE'] = 'YBC Office';
			$hasil = $this->m_log->select_plants('OFFICE',$data['admin']['admin_id'],$object['data']['admin']['plants'],$object['plant_terpilih'],$object['plant_terpilih_count']);
			$object['plant_terpilih'] = $hasil['plant_terpilih'];
			$object['plant_terpilih_count'] = $hasil['plant_terpilih_count'];
			$object['plants']['OFFICE'] = $hasil['plant'];
			$object['allplant']['OFFICE'] = $hasil['allplant'];
			//hardcode
			
			
			foreach ($object['plant_types']->result_array() as $plant_type) {
				$object['plant_type'][$plant_type['id_jenisoutlet']] = $plant_type['jenisoutlet'];
				$hasil = $this->m_log->select_plants($plant_type['id_jenisoutlet'],$data['admin']['admin_id'],$object['data']['admin']['plants'],$object['plant_terpilih'],$object['plant_terpilih_count']);
				$object['plant_terpilih'] = $hasil['plant_terpilih'];
				$object['plant_terpilih_count'] = $hasil['plant_terpilih_count'];
				$object['plants'][$plant_type['id_jenisoutlet']] = $hasil['plant'];
				$object['allplant'][$plant_type['id_jenisoutlet']] = $hasil['allplant'];
			}
			
		}
//new		
		
		$this->template->write_view('content', 'log/admin_profile_form', $object);
		$this->template->render();
	}

	// update admin
	function _profile_update()	{
	
	

		// start of assign admin data and delete not used vars
		$admin = $_POST['admin'];

		if(empty($admin['admin_id']) || !$this->l_auth->is_have_perm('masterdata_admin'))
			$admin['admin_id'] = $this->session->userdata['ADMIN']['admin_id'];

		$data_nik = $_POST['data_nik'];
		if ($data_nik!='') {
			$admin['admin_emp_id'] = $this->m_log->select_employee_id($data_nik);
		} else {
			$admin['admin_emp_id'] = 0;
		}
		$admin['admin_realname'] = $_POST['admin_realname'];
		$admin['admin_email'] = $_POST['admin_email'];
        $plant_all = $_POST['ALL'];
        $plant_id = $_POST['ckplant'];
        $perm_group_id = $_POST['perm_group_id'];
		// end of assign $admin vars and delete not used vars

		$admin['plants'] = ' ';
		foreach ($plant_id as $value) {
			$admin['plants'] .= trim($value).", ";
			if(empty($admin['plant']))
				$admin['plant'] = trim($value);
		}
		if ($admin['plant']!='')
			$admin['plant_type_id'] = $this->m_log->select_company_code($admin['plant']);

		$admin['admin_selectall'] = '';
		foreach ($plant_all as $value) {
			$admin['admin_selectall'] .= trim($value).", ";
		}

		$admin['admin_perm_grup_ids'] = ' ';

		foreach ($perm_group_id as $value) {
			$admin['admin_perm_grup_ids'] .= $value.", ";
		}
		if (intval($admin['admin_emp_id'])>0) {
			if (strpos('#'.$admin['admin_perm_grup_ids'], ' 0,')>0) {
			} else {
				$admin['admin_perm_grup_ids'] = ' 0,'.$admin['admin_perm_grup_ids']; //tambahkan employee self-service jika ada nik
			}
		} else {
			$admin['admin_perm_grup_ids'] = str_replace(' 0,','',$admin['admin_perm_grup_ids']);
		}

		$admin['admin_edit_id'] = $this->session->userdata['ADMIN']['admin_id'];
		$admin['edit_time'] = date("Y-m-d H:i:s");
		
//		print_r($admin);die();

		if($this->m_log->admin_update($admin)) {

			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('redirect_admin_profile_update_success'), $admin['admin_name']);
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			//redirect('admin_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
			$object['refresh_text'] = sprintf($this->lang->line('error_admin_profile_update'), $admin['admin_name']);
			$object['refresh_url'] = 'log/browse';
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '001';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function perm_group_edit($admin_id) {

		$this->_perm_group_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->_perm_group_form(0, $data);
			} else {
				$this->l_page->save_page('next', 'referer');
				$data['admin'] = $this->m_log->admin_select($admin_id);
//				$data['admin_perm_group_id'] = $this->m_log->admin_perm_groups_select($admin_id);
				$data['admin_perm_group_ids'] = $this->m_perm->admin_perm_group_ids_select($admin_id);
				$this->_perm_group_form(0, $data);
			}

		} else {
			$this->_perm_group_update();
		}

	}

	function _perm_group_check() {
		$this->form_validation->set_rules('admin_name', $this->lang->line('admin_name'), 'trim|required');
	}

	function _perm_group_form($reset=0, $data=NULL) {
		// if group permission added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

		// if $data exist, add to the $object array
		if($data != NULL) {
			$object['data'] = $data;
			$object['page_title'] = $this->lang->line('admin_perm_group_edit');
		} else {
			$object['data'] = NULL;

			// For add data, assign the default variable here
			//      $object['data']['stock_type'] = 2;
			$object['new'] = 1;
			$object['page_title'] = $this->lang->line('admin_perm_group_edit');
		}

		$object['perm_groups'] = $this->m_perm->perm_groups_select_all();
		$this->template->write_view('content', 'log/admin_perm_group_form', $object);
		$this->template->render();
	}

	// update admin section 1
	function _perm_group_update()	{

		// assign group permission data and delete not used vars
		$group = $_POST;
		unset($group['submit']);

		$admin = $this->m_log->admin_select($_POST['admin_id']);

//		$this->m_log->admin_perm_group_delete($group);

//		$admin_perm_group_ids = $this->m_perm->admin_perm_group_ids_select($_POST['admin_id']);
		$admin_perm_group_ids = ' ';

		foreach ($group['perm_group_id'] as $value) {
			$admin_perm_group_ids .= $value.", ";
		}

		$data = array(
			'admin_id' => $_POST['admin_id'],
			'admin_perm_grup_ids' => $admin_perm_group_ids,
		);

		if($this->m_log->admin_update($data)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('redirect_admin_perm_group_update_success'), $admin['admin_name']);
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			//redirect('admin_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

			//redirect('perm/group_browse');
			//$this->group_browse();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('error_admin_profile_update'), $admin['admin_name']);
			$object['refresh_url'] = 'log/browse';
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '002';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

}

/* End of file admin.php */
/* Location: ./system/application/controller/admin.php */