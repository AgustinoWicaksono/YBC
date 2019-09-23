<?php
class Upload_absent extends Controller {
	private $jagmodule = array();


	function Upload_absent() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1017);  //get module data from module ID
		
		$this->load->library('l_upload_absent');
		$this->load->model('m_upload_absent');
		$this->load->model('m_employee');
		$this->load->model('m_employee_shift');
	}

	function index() {
	}

	function trigger_convert() {
		date_default_timezone_set ("Asia/Jakarta" );

		echo date("Y-m-d H:i:s");

	}

	function remote_file(){
		$this->load->view('upload_absent/remote_file');
	}

	function source_file(){
		$this->load->view('upload_absent/source_file');
	}

	// dijalankan tepat ketika file absen di-upload
	function convert($kode_cabang=""){

        $object['status'] = "OK";
// echo $_SERVER['HTTP_HOST'];die();
		if(strpos('###'.$_SERVER['HTTP_HOST'],'localhost')>0) {
			$handle = @fopen('C:/Data/ybc/www/sap.ybc.co.id/hr-attendance/absen'.$kode_cabang.'.txt', "r");
		} else {
			$link = site_url('upload_absent/remote_file');
			$remote_file = str_replace(file_get_contents($link),'absen','absen'.$kode_cabang.'.txt');
			$handle = @fopen("/var/www/html/portal.ybc.co.id/hr-attendance/".$remote_file, "r");
//			echo "/var/www/html/portal.ybc.co.id/hr-attendance/".$remote_file.'<hr />';die();
//			$handle = @fopen("/srv/www/vhosts/sap.ybc.co.id/hr-attendance/".$remote_file, "r");
//			$handle = @fopen("/srv/www/vhosts/portal.ybc.co.id/".$remote_file, "r");
		}

		$allowed_time = strtotime(date("Y-m-d H:i:s", strtotime ("+3 hour")));
		$compared_time = strtotime(date("Y-m-d H:i:s", strtotime ("-1 month")));
		$tmp_time = '';
		$blacklisted_id = Array();
		$suspect_occured = 0;
		if ($handle) {

			$i = 1;

		  while (($buffer = fgets($handle, 4096)) !== false) {

				$explode = explode(';', $buffer);
				

				$berkas['finger_print'] = trim($explode[0]);
				$berkas['tanggal'] = trim($explode[1]);
				$berkas['tanggal'] = '20'.substr($berkas['tanggal'],0,2).'-'.substr($berkas['tanggal'],2,2).'-'.substr($berkas['tanggal'],4,2);
				$berkas['waktu'] = substr(trim($explode[2]),0,2).':'.substr(trim($explode[2]),2,2).':00';
				$berkas['status_absen'] = trim($explode[3]);
				
				$inserted_time = strtotime($berkas['tanggal'].' '.$berkas['waktu']);
				
				
				if ($inserted_time >= $compared_time) {
					$data_valid = true;
					$tmp_time = $compared_time;
					$compared_time = $inserted_time;
				} else {
					if ($suspect_occured<1){
						$data_valid = false;
						$blacklisted_id[] = $berkas['finger_print'];
					}
					$suspect_occured ++;
				}
				
				if (in_array($berkas['finger_print'],$blacklisted_id)) {
					$data_valid = false;
				}

				if($i == 1) {
    				$berkas['kode_cabang'] = trim($explode[4]);
                    $kode_cabang = $berkas['kode_cabang'];
				} else {
                    $berkas['kode_cabang'] = $kode_cabang;
				}

    			$this->m_upload_absent->upload_absent_delete($berkas);
				
				
				if ($inserted_time <= $allowed_time) {
					if ($data_valid) {
						$absent_id = $this->m_upload_absent->upload_absent_add($berkas);
					} else {
						$absent_id = $this->m_upload_absent->upload_absent_add_anomali($berkas,1,date('Y-m-d H:i:s',$tmp_time));
//						$berkas['tanggal'] = date('Y-m-d',$tmp_time);
//						$berkas['waktu'] = date('H:i:s',$tmp_time);
						$absent_id = $this->m_upload_absent->upload_absent_add($berkas);
					}
				} else {
					$absent_id = $this->m_upload_absent->upload_absent_add_anomali($berkas,2,date('Y-m-d H:i:s',$allowed_time));
				}
				$data_valid = true;

				$i++;
		  }

		  if (!feof($handle)) {
	      $object['status'] = "Error: unexpected fgets() fail.";
		  }

		  fclose($handle);
		} else {
          $object['status'] = "File tidak bisa dibuka";
		}

		$this->load->view('upload_absent/convert', $object);

	}


	// dijalankan tepat ketika file absen di-upload
	function convert2($kode_cabang=""){

        $object['status'] = "OK";
// echo $_SERVER['HTTP_HOST'];die();
		if(strpos('###'.$_SERVER['HTTP_HOST'],'localhost')>0) {
			$handle = @fopen('C:/Data/Edward/www/sap.ybc.co.id/hr-attendance/absen'.$kode_cabang.'.txt', "r");
		} else {
			$link = site_url('upload_absent/remote_file');
			$remote_file = str_replace(file_get_contents($link),'absen','absen'.$kode_cabang.'.txt');
			$handle = @fopen("/var/www/html/portal.ybc.co.id/hr-attendance/".$remote_file, "r");
//			$handle = @fopen("/srv/www/vhosts/sap.ybc.co.id/hr-attendance/".$remote_file, "r");
//			$handle = @fopen("/srv/www/vhosts/portal.ybc.co.id/".$remote_file, "r");
		}

		$allowed_time = strtotime(date("Y-m-d H:i:s", strtotime ("+6 hour")));
		$compared_time = strtotime(date("Y-m-d H:i:s", strtotime ("-1 month")));
		$tmp_time = '';
		$blacklisted_id = '';
		$suspect_occured = 0;
		if ($handle) {

			$i = 1;

		  while (($buffer = fgets($handle, 4096)) !== false) {

				$explode = explode(';', $buffer);
				

				$berkas['finger_print'] = trim($explode[0]);
				$berkas['tanggal'] = trim($explode[1]);
				$berkas['tanggal'] = '20'.substr($berkas['tanggal'],0,2).'-'.substr($berkas['tanggal'],2,2).'-'.substr($berkas['tanggal'],4,2);
				$berkas['waktu'] = substr(trim($explode[2]),0,2).':'.substr(trim($explode[2]),2,2).':00';
				$berkas['status_absen'] = trim($explode[3]);
				
				$inserted_time = strtotime($berkas['tanggal'].' '.$berkas['waktu']);
				

				if($i == 1) {
    				$berkas['kode_cabang'] = trim($explode[4]);
                    $kode_cabang = $berkas['kode_cabang'];
				} else {
                    $berkas['kode_cabang'] = $kode_cabang;
				}

    			$this->m_upload_absent->upload_absent_delete($berkas);
				
				
				if ($inserted_time <= $allowed_time) {
					$absent_id = $this->m_upload_absent->upload_absent_add($berkas);
				} else {
					$absent_id = $this->m_upload_absent->upload_absent_add_anomali($berkas,'Jam dimajukan, seharusnya maksimal jam '.date('Y-m-d H:i:s',$allowed_time));
				}

				$i++;
		  }

		  if (!feof($handle)) {
	      $object['status'] = "Error: unexpected fgets() fail.";
		  }

		  fclose($handle);
		} else {
          $object['status'] = "File tidak bisa dibuka";
		}

		$this->load->view('upload_absent/convert2', $object);

	}


}

/* End of file upload_absent.php */
/* Location: ./system/application/controller/upload_absent.php */