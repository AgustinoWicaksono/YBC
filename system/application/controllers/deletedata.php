<?php
class deletedata extends Controller {
	private $jagmodule = array();

	function UbahBulan($nilai)
		{
		if ($nilai == "01") {
			$hasil = "Januari";
		}
		elseif ($nilai == "02") {
			$hasil = "Februari";
		}
		elseif ($nilai == "03") {
			$hasil = "Maret";
		}
		elseif ($nilai == "04") {
			$hasil = "April";
		}
		elseif ($nilai == "05") {
			$hasil = "Mei";
		}
		elseif ($nilai == "06") {
			$hasil = "Juni";
		}
		elseif ($nilai == "07") {
			$hasil = "Juli";
		}
		elseif ($nilai == "08") {
			$hasil = "Agustus";
		}
		elseif ($nilai == "09") {
			$hasil = "September";
		}
		elseif ($nilai == "10") {
			$hasil = "Oktober";
		}
		elseif ($nilai == "11") {
			$hasil = "November";
		}
		elseif ($nilai == "12") {
			$hasil = "Desember";
		}
		else
		{ $hasil = ""; }


		return $hasil;
	}

	function deletedata() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1024);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_deletedata'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_deletedata');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));
	}
	
	function index()
	{
		$this->input();
	}

	
	
	
	function input()	{

		$this->_data_check();

		if ($this->form_validation->run() == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_data_form(0, $data);
	   	} else {
	 			$this->_data_form();
	     }

		} else {
			$this->_data_confirm();
			
		}

	}

	function not_exist() {
		$tgl = $this->uri->segment(3);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Data pada tanggal '.$tgl.' tidak ada dalam sistem atau bisa jadi belum di-approve.';
        $object['refresh_url'] = 'deletedata';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function delete_failed() {
		$tgl = $this->uri->segment(3);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Gagal melakukan penghapusan data. Silahkan hubungi IT.';
        $object['refresh_url'] = 'deletedata';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '002';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _data_check() {
		$this->form_validation->set_rules('delete_date', 'Posting Date', 'trim|required');
		$this->form_validation->set_rules('delete_confirmation[]', 'Konfirmasi Reset/Hapus Opname', 'required');
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
            $object['data']['email'] = "";

			// For add data, assign the default variable here
//			$member['data']['membership_status'] = 2;
		}

		// start of form attributes
		$object['form'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['page_title'] = 'Reset/Hapus Data';
		$this->l_page->save_page('next');

		$this->template->write_view('content', 'deletedata/deletedata_input', $object);
		$this->template->render();
	}
	

	function _data_confirm() {
		$data = $_POST;
		$date_from = $data['delete_date'];
		
		
		$delete_date = explode("-", $date_from);
		$data['delete_tgl']=$delete_date[0]." ".$this->UbahBulan($delete_date[1])." ".$delete_date[2];
		$delete_date = $delete_date[2]."-".$delete_date[1]."-".$delete_date[0];
		$data['delete_date']=$delete_date;

		unset($data['button']);
		unset($data['delete_opname']);
		
		$dataexist = $this->m_deletedata->checkdata($delete_date);
		if ($dataexist==FALSE) {
		  redirect('deletedata/not_exist/'.$data['delete_tgl']);
		}
		
		$object['data'] = $data;
		
		$swbuser = strtolower($deletedata["delete_opname"]);
		$object['page_title'] = 'Konfirmasi Reset/Hapus Data';
		$this->l_page->save_page('next');
		$this->template->write_view('content', 'deletedata/deletedata_confirm', $object);
		$this->template->render();
	}

	function delete_execute() {
		$data = $_POST;
		$delete_date = $data['delete_date'];
		$tglhapus = $data['delete_tgl'];
		$delete_option=$data['delete_option'];
		$delete_option=strtolower($delete_option);
		
//		echo "OPTION: ".$delete_option."<hr>";
		
		if (($delete_option!="delete")&&($delete_option!="reset")){
			$delete_option=NULL;unset($delete_option);
		}
		
		//echo $tglhapus;


		if ($this->m_deletedata->deleteopname($delete_date,$delete_option)) {
			$this->l_general->success_page('Data Opname tanggal '.$tglhapus.' sudah berhasil dihapus dari sistem.', site_url('deletedata'));
		} else {
			redirect('deletedata/delete_failed');
		}
		
	}

}
