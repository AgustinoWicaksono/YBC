<?php
class Employee_req extends Controller {
	private $jagmodule = array();


	function Employee_req() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1009);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_employee');
		$this->load->model('m_employee_req');
		$this->load->model('m_admin');
		$this->load->model('m_perm');

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

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

		$employee_req_browse_result = $this->session->userdata['PAGE']['employee_req_browse_result'];

		if(!empty($employee_req_browse_result))
			redirect($this->session->userdata['PAGE']['employee_req_browse_result']);
		else
			redirect('employee_req/browse_result/0/0/0/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		if(empty($_POST['date_from']) || ($_POST['date_from'] == '--')) {
			$date_from = 0;
		} else {
			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['date_to']) || ($_POST['date_to'] == '--')) {
			$date_to = 0;
		} else {
			$date = explode("-", $_POST['date_to']);
			$date_to = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}

		if (empty($limit)) {
			$limit = 10;
		}

		$_POST['status'] = 0;
//		redirect('employee_req/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('employee_req/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

		$this->l_page->save_page('employee_req_browse_result');

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

		$object['req_type'] = array (
			'Additional'	=>	'Additional',
			'Substitute'	=>	'Substitute',
		);

		$object['req_kelamin'] = array (
			''	=>	'',
			'Pria'	=>	'Pria',
			'Wanita'	=>	'Wanita',
		);
		$object['data']['outlet_employee'] = $this->m_employee->outlet_employee_select($this->session->userdata['ADMIN']['storage_location_name']);


		$object['data']['field_name'] = $field_name;
		$object['data']['field_type'] = $field_type;

		if($field_content !== '0') {
			$object['data']['field_content'] = $field_content;
		} else {
			$object['data']['field_content'] = '';
		}

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['data']['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
			$object['data']['date_from'] = '';
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['data']['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['data']['date_to'] = '';
			$date_to2 = '0';
		}


		unset($year);
		unset($month);
		unset($day);
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
			'a'	=>	'NIK',
			'b'	=>	'Nama',
		);

		$object['field_type'] = array (
			'part'	=>	'Any Part of Field',
			'all'	=>	'All Part of Field',
		);
/*
		$object['status'] = array (
			'0'	=>	'',
			'1'	=>	'Not Approved',
			'2'	=>	'Approved',
		);
*/
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

		$sort_link1 = 'employee_req/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
			'by'	=>	$sort_link1.'by'.$sort_link2,
			'bz'	=>	$sort_link1.'bz'.$sort_link2,
			'cy'	=>	$sort_link1.'cy'.$sort_link2,
			'cz'	=>	$sort_link1.'cz'.$sort_link2,
			'dy'	=>	$sort_link1.'dy'.$sort_link2,
			'dz'	=>	$sort_link1.'dz'.$sort_link2,
			'ey'	=>	$sort_link1.'ey'.$sort_link2,
			'ez'	=>	$sort_link1.'ez'.$sort_link2,
			'fy'	=>	$sort_link1.'fy'.$sort_link2,
			'fz'	=>	$sort_link1.'fz'.$sort_link2,
			'gy'	=>	$sort_link1.'gy'.$sort_link2,
			'gz'	=>	$sort_link1.'gz'.$sort_link2,
			'hy'	=>	$sort_link1.'hy'.$sort_link2,
			'hz'	=>	$sort_link1.'hz'.$sort_link2,
			'iy'	=>	$sort_link1.'iy'.$sort_link2,
			'iz'	=>	$sort_link1.'iz'.$sort_link2,
			'jy'	=>	$sort_link1.'jy'.$sort_link2,
			'jz'	=>	$sort_link1.'jz'.$sort_link2,
			'ky'	=>	$sort_link1.'ky'.$sort_link2,
			'kz'	=>	$sort_link1.'kz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('employee_req/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_employee_req->employee_reqs_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['employee_reqs'] = $this->m_employee_req->employee_reqs_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Employee Request';

		$this->template->write_view('content', 'employee/employee_browse', $object);
		$this->template->render();

	}
/*
	function input()	{

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

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
  */
	function input2()	{

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

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

		if(!$this->l_auth->is_have_perm('hrd_input_request'))
			redirect('');

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_data_form(0, $data);
    	} else {
        $data = $this->m_employee_req->employee_req_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
		$this->form_validation->set_rules('req[req_status_kerja]', 'Status Kerja', 'trim|required');
		$this->form_validation->set_rules('req[req_jumlah]', 'Jumlah', 'is_natural_no_zero|trim|required');
		$this->form_validation->set_rules('req[req_type]', 'Request Type', 'trim|required');
//		$this->form_validation->set_rules('req[req_umur]', 'Umur', 'is_natural_no_zero|trim');
	}

	function input() {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		// if $data exist, add to the $member array

		if (count($_POST) != 0) {
    		$data = $_POST;
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
        /*
		$object['req_type'] = array (
			'Additional'	=>	'Additional',
			'Substitute'	=>	'Substitute',
		);

		$object['req_kelamin'] = array (
			''	=>	'Bebas',
			'Pria'	=>	'Pria',
			'Wanita'	=>	'Wanita',
		);

		$maritals = $this->m_employee->maritals_select_all();

		if($maritals !== FALSE) {
			$object['marital'][''] = '';
			foreach($maritals->result_array() as $marital) {
				$object['marital'][$marital['marital_code']] = $marital['marital_name'];
			}
		}

		$work_statuses = $this->m_employee->work_statuses_select_all();

		if($work_statuses !== FALSE) {
			$object['work_status'][''] = '';
			foreach($work_statuses->result_array() as $work_status) {
				$object['work_status'][$work_status['work_code']] = $work_status['work_name'];
			}
		}

		$educations = $this->m_employee->educations_select_all();

		if($educations !== FALSE) {
			$object['education'][''] = '';
			foreach($educations->result_array() as $education) {
				$object['education'][$education['education_code']] = $education['education_name'];
			}
		}
        */
        //echo '<pre>';
        // print_r($data);
        //echo '</pre>';
		$divisis = $this->m_employee->divisis_select_all();
		$object['divisi'][''] = '';
		if($divisis !== FALSE) {
			foreach($divisis->result_array() as $divisi) {
				$object['divisi'][$divisi['kode_divisi']] = $divisi['nama_divisi'];
			}
		}

        if (!empty($data['req']['req_divisi'])) {

      		$depts = $this->m_employee->dept_select_by_divisi($data['req']['req_divisi']);
    		$object['dept'][''] = '';

      		if($depts !== FALSE) {
      			foreach($depts->result_array() as $dept) {
      				$object['dept'][$dept['kode_dept']] = $dept['nama_dept'];
      			}
      		}

            if (!empty($data['req']['req_dept'])) {
        		$bagians = $this->m_employee->bagian_select_by_dept($data['req']['req_dept']);
      			$object['bagian'][''] = '';

        		if($bagians !== FALSE) {
        			foreach($bagians->result_array() as $bagian) {
        				$object['bagian'][$bagian['kode_bagian']] = $bagian['nama_bagian'];
        			}
        		}
            }

        }

		$jabatans = $this->m_employee->jabatan_select_all();
    	$object['jabatan'][''] = '';
		if($jabatans !== FALSE) {
			foreach($jabatans->result_array() as $jabatan) {
				$object['jabatan'][$jabatan['kode_job']] = $jabatan['nama_job'];
			}
		}

		$object['data']['outlet_employee'] = $this->m_employee->outlet_employee_select($this->session->userdata['ADMIN']['storage_location_name']);

		$admin = $this->m_admin->admin_select($this->session->userdata['ADMIN']['admin_id']);

		$object['data']['employee'] = $this->m_employee->employee_select($admin['admin_emp_id']);

		$object['page_title'] = 'Employee Request';
		$this->l_page->save_page('next');
		if(!empty($data['req']['req_jabatan'])) {
            if (empty($data['req']['req_bagian'])) {
                $data['req']['req_bagian'] = '-';
            }
			redirect('employee_req/input2/'.$data['req']['req_divisi'].'/'.$data['req']['req_dept'].'/'.$data['req']['req_bagian'].'/'.$data['req']['req_jabatan']);
		}

		$this->template->write_view('content', 'employee_req/employee_req_input', $object);
		$this->template->render();
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
			$object['data']['req']['req_jumlah'] = 1;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['req_type'] = array (
			'Additional'	=>	'Additional',
			'Substitute'	=>	'Substitute',
		);

		$object['req_kelamin'] = array (
			''	=>	'Bebas',
			'Pria'	=>	'Pria',
			'Wanita'	=>	'Wanita',
		);

		$maritals = $this->m_employee->maritals_select_all();

		if($maritals !== FALSE) {
			$object['marital'][''] = '';
			foreach($maritals->result_array() as $marital) {
				$object['marital'][$marital['marital_code']] = $marital['marital_name'];
			}
		}

		$work_statuses = $this->m_employee->work_statuses_select_all();

		if($work_statuses !== FALSE) {
			$object['work_status'][''] = '';
			foreach($work_statuses->result_array() as $work_status) {
				$object['work_status'][$work_status['work_code']] = $work_status['work_name'];
			}
		}

		$educations = $this->m_employee->educations_select_all();

		if($educations !== FALSE) {
			$object['education'][''] = '';
			foreach($educations->result_array() as $education) {
				$object['education'][$education['education_code']] = $education['education_name'];
			}
		}

		/*$divisis = $this->m_employee->divisis_select_all();

		if($divisis !== FALSE) {
			$object['divisi'][''] = '';
			foreach($divisis->result_array() as $divisi) {
				$object['divisi'][$divisi['kode_divisi']] = $divisi['nama_divisi'];
			}
		}

		$bagians = $this->m_employee->bagian_select_all();

		if($bagians !== FALSE) {
			$object['bagian'][''] = '';
			foreach($bagians->result_array() as $bagian) {
				$object['bagian'][$bagian['kode_bagian']] = $bagian['nama_bagian'];
			}
		}

		$depts = $this->m_employee->dept_select_all();

		if($depts !== FALSE) {
			$object['dept'][''] = '';
			foreach($depts->result_array() as $dept) {
				$object['dept'][$dept['kode_dept']] = $dept['nama_dept'];
			}
		}

		$jabatans = $this->m_employee->jabatan_select_all();

		if($jabatans !== FALSE) {
			$object['jabatan'][''] = '';
			foreach($jabatans->result_array() as $jabatan) {
				$object['jabatan'][$jabatan['kode_job']] = $jabatan['nama_job'];
			}
		}
        */
		$object['data']['outlet_employee'] = $this->m_employee->outlet_employee_select($this->session->userdata['ADMIN']['storage_location_name']);

		$admin = $this->m_admin->admin_select($this->session->userdata['ADMIN']['admin_id']);

		$object['data']['employee'] = $this->m_employee->employee_select($admin['admin_emp_id']);

        $divisi = $this->uri->segment(3);
        $dept = $this->uri->segment(4);
        $bagian = $this->uri->segment(5);
        $jabatan = $this->uri->segment(6);

		$object['data']['req']['req_divisi'] = $divisi;
		$object['data']['req']['req_dept'] = $dept;
		$object['data']['req']['req_bagian'] = $bagian;
		$object['data']['req']['req_jabatan'] = $jabatan;

        $object['divisi'] = $this->m_employee->divisis_select_all($divisi);
        $object['dept'] = $this->m_employee->dept_select_all($dept);
        $object['bagian'] = $this->m_employee->bagian_select_all($bagian);
        $object['jabatan'] = $this->m_employee->jabatan_select_all($jabatan);

		$object['page_title'] = 'Employee Request';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'employee_req/employee_req_edit', $object);
		$this->template->render();
	}


	function _data_add() {
		// start of assign variables and delete not used variables
		$employee_req = $_POST['req'];
		unset($employee_req['button']);
		// end of assign variables and delete not used variables

		$admin = $this->m_admin->admin_select($this->session->userdata['ADMIN']['admin_id']);

        $employee_req['emp_id'] = $admin['admin_emp_id'];

		if(!empty($_POST['start_date'])) {
			$employee_req['req_start_date'] = $this->l_general->date_dmy_to_ymd($_POST['start_date']);
		}
        $employee_req['req_date'] = date('Y-m-d');
		if($this->m_employee_req->employee_req_add($employee_req)) {

			$object['page_title'] = 'Data Employee Request Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Employee Request berhasil dimasukkan.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
	}

	function _data_update()	{
		// start of assign variables and delete not used variables
		$posisi = $_POST;
		unset($posisi['button']);
		// end of assign variables and delete not used variables

		if($this->m_employee->employee_update($posisi)) {

			$object['page_title'] = 'Data Employee Request Berhasil Diubah';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data employee request berhasil diubah.';
//			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			$object['refresh_url'] = site_url('employee_req/browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}

	}

	function _delete($id_employee_header) {

		// check approve status
		$employee_header = $this->m_employee->employee_header_select($id_employee_header);

		if($employee_header['status'] == '1') {
			$this->m_employee->employee_header_delete($id_employee_header);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_employee_header) {

		if($this->_delete($id_employee_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Employee Request berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Employee Request gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '001';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['employee_id']))
			redirect($this->session->userdata['PAGE']['employee_req_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['employee_req_id'][$i])) {
				$object['data']['employee_reqs'][$j++] = $this->m_employee->employee_header_select($_POST['employee_req_id'][$i]);
			}
		}

		$this->template->write_view('content', 'employee_req/employee_req_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['employee_id'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Employee Request berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['employee_req_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

	function report() {

		if(!$this->l_auth->is_have_perm('hrd_report_employee_req'))
			redirect('');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
			'target'	=>	'_blank',
		);
		// end of form attributes

		$object['plants'] = $this->m_perm->admin_plants_select($this->session->userdata['ADMIN']['admin_id']);
		if($object['plants'] !== FALSE) {
			foreach ($object['plants'] as $plant) {
				if (trim($plant['OUTLET'])=="") continue;
				$object['plant'][$plant['HR_CODE']] = $plant['OUTLET_NAME2'].' - '.$plant['OUTLET_NAME1']." (".$plant['HR_CODE'].")";
			}
            $object['plant']['ALL'] = 'ALL';
		}

		$object['page_title'] = 'Report Employee Request Status';
		$this->template->write_view('content', 'employee_req/employee_req_report', $object);
		$this->template->render();

	}

	// search data
	function report_search() {

		if(!$this->l_auth->is_have_perm('hrd_report_employee_req'))
			redirect('');

		$employee_id = $_POST['employee_id'];
        $plant = $_POST['plant'];

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
        $plant = str_replace('&','',$plant);
		redirect('employee_req/report_result/'.$date_from.'/'.$date_to.'/'.$plant);

	}

	// search result
	function report_result($date_from = '', $date_to = '', $plant = '')	{

		$this->l_page->save_page('employee_req_report_result');

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
//			$object['data']['date_from'] = '';
			$object['date_from'] = date("d-m-Y", now());
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['date_to'] = '';
			$date_to2 = '0';
		}

		unset($year);
		unset($month);
		unset($day);

		$timestamp['from'] = strtotime($date_from2);
		$timestamp['to'] = strtotime($date_to2);

		$object['data']['reqs'] = $this->m_employee_req->employee_req_stat_select_by_date($date_from2, $date_to2, $plant);
        $object['pilihan_cabang'] = $plant;
         //<?php echo $this->session->userdata['ADMIN']['storage_location_name'];php echo $this->session->userdata['ADMIN']['plant']

		$object['page_title'] = 'Report Employee Request Status';
		$this->template->write_view('content', 'employee_req/employee_req_report_result', $object);
		$this->template->render();

	}

}
// EOF