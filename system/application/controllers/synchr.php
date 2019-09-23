<?php

class Synchr extends Controller {
	private $jagmodule = array();


	function Synchr() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1016);  //get module data from module ID
		
		$this->load->model('m_sync_attendance');
		// $this->load->model('m_sinkron_mysql');
	}

	function index()
	{
	}
	
	function status() {
		$this->m_sync_attendance->sync_status();
	}
	
	function idle(){
		$this->m_sync_attendance->sync_setidle();
	}
	
	function employee_attendance() {
die('Silahkan gunakan url: http://portal.ybc.co.id/feed/employee_attendance');
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_attendance_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /var/www/html/portal.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+1 hour")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start HR Attendance Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sync_attendance->sync_process();
		$data_sync .= $process_sync;

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$end_sync = "End HR Attendance Sync Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}
	
	function employee_reset_attendance() {
	//delete t_employee lalu reset status proses jadi 0
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_reset_attendance_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /var/www/html/portal.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+5 hour")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start HR Reset Attendance Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sync_attendance->sync_reset_process();
		$data_sync .= $process_sync;

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$end_sync = "End HR Reset Attendance Sync Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}
	
	function employee_reload_attendance() {
	//reset status proses jadi 0 tanpa delete t_employee_absent
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_reload_attendance_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /var/www/html/portal.ybc.co.id/system/application/ ');
		$swbann_handle = '<?php $swbann_endtime="'.date('H:i', strtotime ("+5 hour")).' WIB";$swbcurrprocess="synchr";$swbann_datetime="'.date('j M y - H:i').' WIB"; ?>';
		$swbann_file = $swbann_APPPATH."views/currproc.php";
		$swbann_open = fopen ($swbann_file, "w");
		fwrite ($swbann_open, $swbann_handle);
		fclose ($swbann_open);

		$start_sync = "Start HR Reload Attendance Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sync_attendance->sync_reload_process();
		$data_sync .= $process_sync;

		$swbann_handle2 = '<?php $swbann_endtime=NULL;unset($swbann_endtime);$swbcurrprocess=NULL;unset($swbcurrprocess);$swbann_datetime=NULL;unset($swbann_datetime); ?>';
		$swbann_open2 = fopen ($swbann_file, "w");
		fwrite ($swbann_open2, $swbann_handle2);
		fclose ($swbann_open2);

		$end_sync = "End HR Reload Attendance Sync Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}
	
	function eod_lock() {
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'eod_lock'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');

		$start_sync = "Start EOD Lock Sync Process: ".date("Ymd-His")."<br />\r\n";
		$data_sync = $start_sync;
		echo $start_sync;
		ob_flush();

        $process_sync = $this->m_sync_attendance->eod_lock_all();
		$data_sync .= $process_sync;

		$end_sync = "End EOD Lock Sync Process: ".date("Ymd-His").'<br />'."\r\nLog File: ".$sSyncFile;
		echo $end_sync;
		$data_sync .= $end_sync;

		$swbann_open = fopen ($sSyncFile, "w");
		fwrite ($swbann_open, strip_tags($data_sync));
		fclose ($swbann_open);
		
		ob_flush();
	}

/*	function employee_master() {
		$sSyncFile = trim(str_ireplace('index.php','',FCPATH)."sysrpt/ ").'employee_master_'.date('Ymd-His').'.txt';
		header('Content-Type: text/html');
		$swbann_APPPATH = APPPATH;
		if (Empty($swbann_APPPATH)) $swbann_APPPATH = trim(' /var/www/html/portal.ybc.co.id/system/application/ ');
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
*/        

	
}
