<?php
class Employee extends Controller {
	private $jagmodule = array();


	function Employee() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1003);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_list_employee'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_employee');
    	$this->load->model('m_employee_absent');
		$this->load->model('m_general');
		$this->load->model('m_database');

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
		$employee_browse_result = $this->session->userdata['PAGE']['employee_browse_result'];

		if(!empty($employee_browse_result))
			redirect($this->session->userdata['PAGE']['employee_browse_result']);
		else
			redirect('employee/browse_result/0/0/0/0/0/0/0/10');

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
		
//		redirect('employee/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('employee/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{
		if ($sort == $limit) $sort = 0;
		$this->l_page->save_page('employee_browse_result');

		$object['data']['outlet_employee'] = $this->m_employee->outlet_employee_select($this->session->userdata['ADMIN']['hr_plant_code']);

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

		$sort_link1 = 'employee/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
			'ly'	=>	$sort_link1.'ly'.$sort_link2,
			'lz'	=>	$sort_link1.'lz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		if ($sort==$limit) $sort = 0;
		$config['base_url'] = site_url('employee/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_employee->employees_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['employees'] = $this->m_employee->employees_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Employee';
		
		if($object['data']['employees'] !== FALSE) {
			$object['data']['employees'] = $object['data']['employees']->result_array();

			foreach($object['data']['employees'] as $datakey=>$value){
				$object['data']['employees'][$datakey]['current_saldo_cuti'] = intval($object['data']['employees'][$datakey]['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($object['data']['employees'][$datakey]['employee_id']));
				$object['data']['employees'][$datakey]['saldo_ph'] = $this->m_employee->saldo_ph_from_mCutiPh($value['employee_id']);	
			}
		
		}
	
//		$data['saldo_cuti'] = $data['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($data['employee_id']);
// print_r($object['data']['employees']);die();

		$this->template->write_view('content', 'employee/employee_browse', $object);
		$this->template->render();

	}

	function fp()	{

		$this->_data_fp_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {

	   		$data = $_POST;

//				$this->_data_form('nik', $data['new']['nik'], 0, $data);
	 			$this->_data_fp_form(0, $data);

	   	} else {
        $data = $this->m_employee->employee_select_by_nik($this->uri->segment(3));

				unset($data['kode_cabang']);
				unset($data['fingerprint_id']);
				unset($data['kartu_jamsostek']);
				unset($data['kartu_kesehatan']);
				unset($data['kartu_npwp']);
	 			$this->_data_fp_form(0, $data);
	  	}

		} else {
			$this->_data_fp_add();
		}

	}

	function _data_fp_check() {
		$this->form_validation->set_rules('kode_cabang', 'Kode Cabang', 'trim|required');
		$this->form_validation->set_rules('fingerprint_id', 'Fingerprint ID', 'trim|required');
	}

	function _data_fp_form($reset=0, $data=NULL) {
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

		$cabangs = $this->m_employee->outlets_all_select();

		if($cabangs !== FALSE) {
			$object['cabang'][''] = '';
			foreach($cabangs->result_array() as $cabang) {
				$object['cabang'][$cabang['STOR_LOC_NAME']] = $cabang['STOR_LOC_NAME'];
			}
		}

		$object['data']['fingers'] = $this->m_employee->employee_fingers_select_by_nik($data['nik']);

		$object['page_title'] = 'Tambah Employee Fingerprint';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'employee/employee_fp', $object);
		$this->template->render();
	}

	function edit() {

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_data_form(0, $data);
    	} else {
        $data = $this->m_employee->employee_select($this->uri->segment(3));
  			$this->_data_form(0, $data);
      }

		} else {
			$this->_data_update();
    }

	}

	function _data_check() {
//		$this->form_validation->set_rules('id_posisi', 'Employee Position Code', 'trim|required');
		$this->form_validation->set_rules('fingerprint_id', 'Fingerprint ID', 'trim|required');
	}

	function _data_form($reset=0, $data=NULL) {
		// if member added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;

        $data['saldo_cuti'] = intval($data['saldo_cuti']);
		$data['saldo_cuti'] = $data['saldo_cuti'] - $this->m_employee_absent->get_jumlah_cuti($data['employee_id']);
        $data['saldo_ph'] = $this->m_employee_absent->get_jumlah_cuti_ph($data['employee_id']);
        $data['saldo_ph'] = intval($data['saldo_ph']);
		$data['saldo_cutihutang'] = intval($data['saldo_cutihutang']);
        $data['saldo_cutihutang'] = $data['saldo_cutihutang'] + $this->m_employee_absent->get_jumlah_cutihutang($data['employee_id']);

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

		$object['page_title'] = 'Employee';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'employee/employee_edit', $object);
		$this->template->render();
	}

	function _data_update()	{
		// start of assign variables and delete not used variables
		$posisi = $_POST;
		unset($posisi['button']);
		// end of assign variables and delete not used variables
		
		//print_r($posisi);die();

		if($this->m_employee->check_m_fp_ok($posisi)) {
			if($this->m_employee->employee_update($posisi)) {

				$object['page_title'] = 'Data Employee Berhasil Diubah';
				$object['refresh'] = 1;
				$object['refresh_text'] = 'Data employee berhasil diubah.';
	//			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
				$object['refresh_url'] = site_url('employee/browse');

				$this->template->write_view('content', 'refresh', $object);
				$this->template->render();

			} else {
				$object['refresh_time'] = 5;
				$object['refresh_text'] = 'Data Employee gagal diubah. Fingerprint ID '.$posisi['fingerprint_id'].' untuk cabang ini sudah digunakan.';
				$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '001';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
			}
		} else {
			$employee_error = $this->m_employee->employee_select_by_fingerid($posisi['fingerprint_id'],$this->session->userdata['ADMIN']['hr_plant_code']);
			// print_r($employee_error);die();
			$object['refresh_time'] = 5;
			$object['refresh_text'] = 'Data Employee gagal diubah. Fingerprint ID '.$posisi['fingerprint_id'].' untuk cabang ini sudah digunakan oleh karyawan atas nama '.strtoupper($employee_error['nama']).' dari cabang '.strtoupper($employee_error['kode_cabang']).'.';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '001';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
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
			$object['refresh_text'] = 'Data Employee berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Employee gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '002';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {
		if(!count($_POST['employee_id']))
			redirect($this->session->userdata['PAGE']['employee_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
	  	if(!empty($_POST['employee_id'][$i])) {
				$object['data']['employees'][$j++] = $this->m_employee->employee_select($_POST['employee_id'][$i]);
			}
		}

		if (isset($_POST['button']['savetoexcel']))
			$this->template->write_view('content', 'employee/employee_export_confirm', $object);
//		else
//			$this->template->write_view('content', 'employee/employee_delete_multiple_confirm', $object);

		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['employee_id'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Employee berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['employee_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

	function file_export() {
		$data = $this->m_employee->employee_select_to_export($_POST['employee_id']);
		if($data!=FALSE) {
		
			$this->l_general->export_to_excel($data,'employee');
		}
	}

}
// EOF