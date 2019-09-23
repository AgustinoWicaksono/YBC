<?php
class Sinkron extends Controller {
	private $jagmodule = array();


	function Sinkron() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1014);  //get module data from module ID
		
		$this->load->model('m_sinkron_mysql');
		$this->load->library('l_upload_absent');
	}

	function index()
	{
	}

	function update_end_of_month() {
die('Silahkan gunakan url: http://sap.ybc.co.id/feed/update_end_of_month');
		header('Content-Type: text/plain');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = "/srv/www/vhosts/sap.ybc.co.id/system/application/";
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+25 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		echo "Proses update End Of Month Start: ".date("Ymd-His")."<br />";
		ob_flush();

        $this->m_sinkron_mysql->end_of_month();

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		echo "Proses update End Of Month Finish: ".date("Ymd-His");
		ob_flush();
	}

	function update_employee() {
die('Silahkan gunakan url: http://portal.ybc.co.id/feed/update_employee');
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_master_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /srv/www/vhosts/sap.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+5 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start Employee Master Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sinkron_mysql->employee_update();
		

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$end_sync = "End HR Employee Master Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}

	function absen() {
die('Fitur ini dinonaktifkan untuk sementara. Silahkan gunakan fitur baru.');
		header('Content-Type: text/plain');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = "/srv/www/vhosts/sap.ybc.co.id/system/application/";
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+25 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		echo "Proses Sinkronisasi Absen Start: ".date("Ymd-His")."<br />";
		ob_flush();

        $this->l_upload_absent->sinkron_absen();
		ob_flush();
        $this->m_sinkron_mysql->update_shift();

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		echo "Proses Sinkronisasi Absen Finish: ".date("Ymd-His");
		ob_flush();
	}
	
	function update_shift() {
die('Fitur ini dinonaktifkan untuk sementara. Silahkan gunakan fitur baru.');
		header('Content-Type: text/plain');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = "/srv/www/vhosts/sap.ybc.co.id/system/application/";
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+25 minute")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		echo "Proses update Shift Start: ".date("Ymd-His")."<br />";
		ob_flush();

        $this->m_sinkron_mysql->update_shift();

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		echo "Proses update Shift Finish: ".date("Ymd-His");
		ob_flush();
	}	
}
