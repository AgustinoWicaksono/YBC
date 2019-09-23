<?php
class Employee_fp extends Controller {
	private $jagmodule = array();


	function Employee_fp() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1007);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('hrd_input_dl'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->library('user_agent');
		$this->load->model('m_employee');
		$this->load->model('m_general');
		//$this->load->model('m_upload_absent');

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));
	}

	// main function
	function index() {
		$this->enter();
	}

	function enter() {

		$object['data'] = NULL;

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Form Input Dinas Luar';
		$this->template->write_view('content', 'employee_fp/employee_fp_enter', $object);
		$this->template->render();

	}

	function enter2() {

		redirect('employee_fp/input/'.$_POST['nik']);

	}



	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {

	   		$data = $_POST;
			$checknik = $this->m_employee->employee_check_nik($this->uri->segment(3));
			if ($checknik!==FALSE){
                $data2 = $this->m_employee->employee_select_by_nik_wo_cabang($this->uri->segment(3));

				if (!Empty($data2)){
					$data['nama'] = $data2['nama'];


//				$this->_data_form('nik', $data['new']['nik'], 0, $data);
					$this->_data_form(0, $data);
				} else {
					$object['refresh'] = 0;
					$object['refresh_text'] = 'Dinas luar hanya bisa diisi oleh NIK karyawan yang bukan berasal dari '.$this->session->userdata['ADMIN']['hr_plant_code'].'.';
					$object['refresh_url'] = 'employee_fp/';

					$object['web_transdtl'] = 'NIK='.$this->uri->segment(3).'; Outlet='.$this->session->userdata['ADMIN']['hr_plant_code'];
					$object['jag_module'] = $this->jagmodule;
					$object['error_code'] = '001';
					$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
					$this->template->write_view('content', 'errorweb', $object);
					$this->template->render();
				}
			} else {
					$object['refresh'] = 0;
					$object['refresh_text'] = 'NIK "'.$this->uri->segment(3).'" salah atau belum terdaftar di sistem. Silahkan hubungi HRD untuk mendapatkan NIK yang benar.';
					$object['refresh_url'] = 'employee_fp/';

					$object['web_transdtl'] = 'NIK='.$this->uri->segment(3).'; Outlet='.$this->session->userdata['ADMIN']['hr_plant_code'];
					$object['jag_module'] = $this->jagmodule;
					$object['error_code'] = '002';
					$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
					$this->template->write_view('content', 'errorweb', $object);
					$this->template->render();
			}
	   	} else {
			$checknik = $this->m_employee->employee_check_nik($this->uri->segment(3));
			if ($checknik!==FALSE){
                $data = $this->m_employee->employee_select_by_nik_wo_cabang($this->uri->segment(3));

				if (!Empty($data)){
					unset($data['kode_cabang']);
					unset($data['fingerprint_id']);
					$this->_data_form(0, $data);
				} else {
					$object['refresh'] = 0;
					$object['refresh_text'] = 'Dinas luar hanya bisa diisi oleh NIK karyawan yang bukan berasal dari '.$this->session->userdata['ADMIN']['hr_plant_code'].'.';
					$object['refresh_url'] = 'employee_fp/';

					$object['web_transdtl'] = 'NIK='.$this->uri->segment(3).'; Outlet='.$this->session->userdata['ADMIN']['hr_plant_code'];
					$object['jag_module'] = $this->jagmodule;
					$object['error_code'] = '003';
					$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
					$this->template->write_view('content', 'errorweb', $object);
					$this->template->render();
				}
			} else {
					$object['refresh'] = 0;
					$object['refresh_text'] = 'NIK "'.$this->uri->segment(3).'" salah atau belum terdaftar di sistem. Silahkan hubungi HRD di hr.helpdesk@ybc.co.id untuk mendapatkan NIK yang benar.';
					$object['refresh_url'] = 'employee_fp/';

					$object['web_transdtl'] = 'NIK='.$this->uri->segment(3).'; Outlet='.$this->session->userdata['ADMIN']['hr_plant_code'];
					$object['jag_module'] = $this->jagmodule;
					$object['error_code'] = '004';
					$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
					$this->template->write_view('content', 'errorweb', $object);
					$this->template->render();
			}

	  	}

		} else {
			$this->_data_add();
		}

	}

	function _data_check() {
		$this->form_validation->set_rules('kode_cabang', 'Kode Cabang', 'trim|required');
		$this->form_validation->set_rules('fingerprint_id', 'Fingerprint ID', 'trim|required');
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
//			$member['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

/*
		$cabangs = $this->m_employee->outlets_all_select();

		if($cabangs !== FALSE) {
			$object['cabang'][''] = '';
			foreach($cabangs->result_array() as $cabang) {
				$object['cabang'][$cabang['STOR_LOC_NAME']] = $cabang['STOR_LOC_NAME'];
			}
		}
*/

		$object['data']['fps'] = $this->m_employee->employee_fps_select_by_nik($data['nik']);
        if($object['data']['fps']!==FALSE) {
    		foreach ($object['data']['fps']->result_array() as $finger) {
    			$object['data']['fp'][] = $finger;


    		// ambil data cabang saja
        		foreach($object['data']['fp'] as $fp) {
        			$cabs[] = $fp['kode_cabang'];
                    if ($fp['kode_cabang'] == $this->session->userdata['ADMIN']['hr_plant_code']) {
                        $fp_kd_cab_aktif = $fp['fingerprint_id'];
                    }
        		}
    		}

    		$object['cabangs'] = $this->m_perm->admin_plants_select($this->session->userdata['ADMIN']['admin_id']);
    //				print_r($object['plants']);
    		if($object['cabangs'] !== FALSE) {
    //			$object['plant'][0] = '';

    			$object['cabang'][''] = '';

    			foreach ($object['cabangs'] as $cabang) {
    				if (trim($cabang['STOR_LOC_NAME'])=="") continue;

    				// cek apakah data fingerprint untuk cabang tersebut sudah ada?
    				$key = array_search($cabang['STOR_LOC_NAME'], $cabs);

    				if($key === FALSE) {
    					$object['cabang'][$cabang['STOR_LOC_NAME']] = $cabang['OUTLET_NAME2'].' - '.$cabang['OUTLET_NAME1']." (".$cabang['OUTLET'].")";
    				}

    			}

    		}
            //[$this->session->userdata['ADMIN']['hr_plant_code']]
    		//<td class="column_input"><?=form_dropdown('kode_cabang', $cabang, $data['kode_cabang'], 'class="input_text" disabled="disabled"');

    		$object['data']['kode_cabang'] = $this->session->userdata['ADMIN']['hr_plant_code'];
    		$object['data']['fingerprint_id'] = $fp_kd_cab_aktif;
         //   $absent_tmp = $this->m_upload_absent->upload_absent_get_absent_w_shift($absent['cabang'], $data[1]['finger_print'], $tanggal);


    		$object['page_title'] = 'Tambah Employee Fingerprint';
    		$this->l_page->save_page('next');

    		$this->template->write_view('content', 'employee_fp/employee_fp_input', $object);
    		$this->template->render();

        }
	}

	function _data_add() {
		// start of assign variables and delete not used variables
		$employee_fp = $_POST;
		unset($employee_fp['button']);
		unset($employee_fp['nik']);
		// end of assign variables and delete not used variables

		if($this->m_employee->employee_fp_add($employee_fp)) {
			$berhasil = TRUE;
		} else {
			$berhasil = FALSE;
		}

		if($berhasil) {

			$object['page_title'] = 'Data Fingerprint Berhasil Dimasukkan';
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data fingerprint berhasil dimasukkan.';
//			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];

			$object['refresh_url'] = 'employee_fp/input/'.$employee_fp['fnik'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
			$empdata = $this->m_employee->employee_select_by_fp_cabang($employee_fp['fingerprint_id'],$employee_fp['kode_cabang']);
			$empnik = $empdata['nik'];
			$empnama = $empdata['nama'];
			$object['refresh'] = 0;
			$object['refresh_text'] = 'Fingerprint ID gagal ditambahkan. Fingerprint ID (ID: '.$employee_fp['fingerprint_id'].') sudah digunakan di '.$this->session->userdata['ADMIN']['hr_plant_code'].' oleh '.$empnama.' (NIK: '.$empnik.'). Silahkan gunakan ID yang lain.';
			$object['refresh_url'] = 'employee_fp/input/'.$employee_fp['fnik'];

			$object['web_transdtl'] = 'NIK='.$employee_fp['fnik'].'; Finger ID='.$employee_fp['fingerprint_id'].'; Outlet='.$employee_fp['kode_cabang'];
			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '005';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
			
		}

	}


}
// EOF