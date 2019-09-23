<?php
class M_employee_attn extends Model {

	function M_employee_attn() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}

	function attn_select_by_nik_and_date($nik, $date_from, $date_to) {

		/*
		//start original
		$this->db->select("kode_cabang as cabang, a.nik, nama, tanggal, max(a.shift) as shift,
                          max(a.kd_shift) as kd_shift,
                          max(a.shift_in) as shift_in,
                          max(a.shift_out) as shift_out,
                          max(a.shift_break_in) as shift_break_in,
                          max(a.shift_break_out) as shift_break_out,
                          max(a.kd_aktual) as kd_aktual,
                          max(a.in) as 'in',
                          max(a.out) as 'out',
                          max(a.break_in) as break_in,
                          max(a.break_out) as break_out,
						  max(a.eod_lock) as eod_lock");
		$this->db->from('t_employee_absent as a');
		$this->db->join('m_employee as b', 'a.nik = b.nik','inner');
		$this->db->where('b.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('b.nik', $nik);
        $this->db->where('tanggal BETWEEN '.$date_from.' AND '.$date_to);
        $this->db->where('a.data_type', 1);
		$this->db->order_by('tanggal', 'asc');
        $this->db->group_by('b.kode_cabang, a.nik, b.nama, a.tanggal');

		$query = $this->db->get();
		
		//end original
		*/
		$swbQuery = "SELECT `b`.`kode_cabang` as `cabang`, `t_union`.`nik`, `b`.`nama`, `t_union`.`tanggal`, max(`t_union`.`shift`) as `shift`, max(`t_union`.`kd_shift`) as `kd_shift`, max(`t_union`.`shift_in`) as `shift_in`, max(`t_union`.`shift_out`) as `shift_out`, max(`t_union`.`shift_break_in`) as `shift_break_in`, max(`t_union`.`shift_break_out`) as `shift_break_out`, if(max(`t_union`.`kd_aktual`)='NO SHIFT',min(`t_union`.`kd_aktual`),max(`t_union`.`kd_aktual`)) as `kd_aktual`, max(`t_union`.`in`) as 'in', max(`t_union`.`out`) as 'out', max(`t_union`.`break_in`) as `break_in`, max(`t_union`.`break_out`) as `break_out`, max(`t_union`.`eod_lock`) as `eod_lock`, max(`data_type`) AS `data_type` FROM ((SELECT `cabang`, `tanggal`, `nik`, `shift`, `kd_shift`, `shift_in`, `shift_break_out`, `shift_break_in`, `shift_out`, `kd_cuti`, `kd_aktual`, `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, `terlambat`, `pulang_cepat`, `jam_kerja`, `data_type`, `on_process`, `eod_lock` FROM `t_employee_absent` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `nik`='".$nik."' AND `data_type`=1) UNION (SELECT `cabang`, `tanggal`, `nik`, 'NONE' AS `shift`, 'NONE' AS `kd_shift`, '?' AS `shift_in`, '?' AS `shift_break_out`, '?' AS `shift_break_in`, '?' AS `shift_out`, '?' AS `kd_cuti`, 'NO SHIFT' AS `kd_aktual`, '?' AS `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, '?' AS `terlambat`, '?' AS `pulang_cepat`, NULL AS `jam_kerja`, 3 AS `data_type`, 0 AS `on_process`, 0 AS `eod_lock` FROM `t_employee_absent_noshift` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `nik`='".$nik."')) AS `t_union` INNER JOIN `m_employee` as `b` ON `t_union`.`nik` = `b`.`nik` WHERE `b`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' AND `b`.`nik` = '".$nik."' GROUP BY `b`.`kode_cabang`, `t_union`.`nik`, `b`.`nama`, `t_union`.`tanggal` ORDER BY `tanggal`, `data_type` DESC";
		$query = $this->db->query($swbQuery);
// echo $this->db->last_query();die();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;

	}

	function attn_select_by_date($date_from, $date_to, $order, $employee_id = '', $nik = '', $divisi = '') {

        //$date_from = date('Y-m-d', strtotime($date_from));
        //$date_to = date('Y-m-d', strtotime($date_to));
		
		/* //start original 2013-06-30
		$this->db->select("cabang,
                          a.nik, nama, tanggal, max(a.shift) as shift,
                          max(a.kd_shift) as kd_shift,
                          max(a.shift_in) as shift_in,
                          max(a.shift_out) as shift_out,
                          max(a.shift_break_in) as shift_break_in,
                          max(a.shift_break_out) as shift_break_out,
                          max(a.kd_aktual) as kd_aktual,
                          max(a.in) as 'in',
                          max(a.out) as 'out',
                          max(a.break_in) as break_in,
                          max(a.break_out) as break_out,
                          max(a.terlambat) as terlambat,
                          max(a.pulang_cepat) as pulang_cepat,
                          max(a.jam_kerja) as jam_kerja");
		//end original 2013-06-30
		*/
		/*
		//start disable 20130713
		$this->db->select("cabang,
                          a.nik, nama, tanggal, a.shift,
                          a.kd_shift,
                          a.shift_in,
                          a.shift_out,
                          a.shift_break_in,
                          a.shift_break_out,
                          a.kd_aktual,
                          a.in as `in`,
                          a.out as `out`,
                          a.break_in,
                          a.break_out,
                          a.terlambat,
                          a.pulang_cepat,
                          a.jam_kerja,
						  a.data_type");
		
		$this->db->from('t_employee_absent as a');
		$this->db->join('m_employee as b', 'a.nik = b.nik','inner');

		if(!empty($employee_id))
		  	$this->db->where('employee_id', $employee_id);

		$this->db->where('b.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('tanggal BETWEEN '.$date_from.' AND '.$date_to.' ');
/*
		if($order == 'ay')
			$this->db->order_by('tanggal', 'asc');
		else if($order == 'az')
			$this->db->order_by('tanggal', 'desc');
		else if($order == 'by')
			$this->db->order_by('nama', 'asc');
		else if($order == 'bz')
			$this->db->order_by('nama', 'desc');
		else if($order == 'cy')
			$this->db->order_by('nik', 'asc');
		else if($order == 'cz')
			$this->db->order_by('nik', 'desc');
*/
/*
		$this->db->order_by('nama', 'asc');
		$this->db->order_by('tanggal', 'asc');
		$this->db->order_by('data_type', 'asc');
		$this->db->order_by('in', 'asc');
//        $this->db->group_by('a.nik, b.nama, a.tanggal');

        $this->db->group_by('a.nik, b.nama, a.tanggal, a.cabang, a.data_type');
		//end disable 20130713
*/		
		if (trim($nik)=='') {
			$sqlNIK = '';
			$sqlEmployeeID = "" ;
		} else {
			$sqlNIK = " AND `nik`='".$nik."' ";
			$sqlEmployeeID = " `employee_id` = ".$employee_id." AND " ;
		}

		if (($divisi=='') || ($divisi == 'ALL') || ($sqlEmployeeID!='')) {
			$swbQuery = "SELECT `t_union`.`cabang`, `t_union`.`nik`, `b`.`nama`, `t_union`.`tanggal`, `t_union`.`shift`, `t_union`.`kd_shift`, `t_union`.`shift_in`, `t_union`.`shift_out`, `t_union`.`shift_break_in`, `t_union`.`shift_break_out`, `t_union`.`kd_aktual`, `t_union`.`in` as `in`, `t_union`.`out` as `out`, `t_union`.`break_in`, `t_union`.`break_out`, `t_union`.`terlambat`, `t_union`.`pulang_cepat`, `t_union`.`jam_kerja`, `t_union`.`data_type` FROM ((SELECT `cabang`, `tanggal`, `nik`, `shift`, `kd_shift`, `shift_in`, `shift_break_out`, `shift_break_in`, `shift_out`, `kd_cuti`, `kd_aktual`, `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, `terlambat`, `pulang_cepat`, `jam_kerja`, `data_type`, `on_process`, `eod_lock` FROM `t_employee_absent` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' ".$sqlNIK.") UNION (SELECT `cabang`, `tanggal`, `nik`, 'NONE' AS `shift`, 'NONE' AS `kd_shift`, '?' AS `shift_in`, '?' AS `shift_break_out`, '?' AS `shift_break_in`, '?' AS `shift_out`, '?' AS `kd_cuti`, IF(`out`-`in`>=80000, 'H', IF(ISNULL(`in`) OR ISNULL(`out`),'TL','TC')) AS `kd_aktual`, '?' AS `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, '?' AS `terlambat`, '?' AS `pulang_cepat`, NULL AS `jam_kerja`, 3 AS `data_type`, 0 AS `on_process`, 0 AS `eod_lock` FROM `t_employee_absent_noshift` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' ".$sqlNIK.")) AS `t_union` INNER JOIN `m_employee` as `b` ON `t_union`.`nik` = `b`.`nik` WHERE ".$sqlEmployeeID." `b`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' ORDER BY `nama` asc, `tanggal` asc, `data_type` asc, `in` asc";

		} else {
			$swbQuery = "SELECT `t_union`.`cabang`, `t_union`.`nik`, `b`.`nama`, `t_union`.`tanggal`, `t_union`.`shift`, `t_union`.`kd_shift`, `t_union`.`shift_in`, `t_union`.`shift_out`, `t_union`.`shift_break_in`, `t_union`.`shift_break_out`, `t_union`.`kd_aktual`, `t_union`.`in` as `in`, `t_union`.`out` as `out`, `t_union`.`break_in`, `t_union`.`break_out`, `t_union`.`terlambat`, `t_union`.`pulang_cepat`, `t_union`.`jam_kerja`, `t_union`.`data_type` FROM ((SELECT `cabang`, `tanggal`, `nik`, `shift`, `kd_shift`, `shift_in`, `shift_break_out`, `shift_break_in`, `shift_out`, `kd_cuti`, `kd_aktual`, `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, `terlambat`, `pulang_cepat`, `jam_kerja`, `data_type`, `on_process`, `eod_lock` FROM `t_employee_absent` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' ".$sqlNIK.") UNION (SELECT `cabang`, `tanggal`, `nik`, 'NONE' AS `shift`, 'NONE' AS `kd_shift`, '?' AS `shift_in`, '?' AS `shift_break_out`, '?' AS `shift_break_in`, '?' AS `shift_out`, '?' AS `kd_cuti`, IF(`out`-`in`>=80000, 'H', IF(ISNULL(`in`) OR ISNULL(`out`),'TL','TC')) AS `kd_aktual`, '?' AS `kd_aktual_temp`, `in`, `break_out`, `break_in`, `out`, '?' AS `terlambat`, '?' AS `pulang_cepat`, NULL AS `jam_kerja`, 3 AS `data_type`, 0 AS `on_process`, 0 AS `eod_lock` FROM `t_employee_absent_noshift` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' ".$sqlNIK.")) AS `t_union` INNER JOIN `m_employee` as `b` ON `t_union`.`nik` = `b`.`nik` INNER JOIN `m_divisi` ON `m_divisi`.`nama_divisi`=`b`.`divisi` WHERE ".$sqlEmployeeID." `b`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' AND `m_divisi`.`kode_divisi`='".$divisi."' ORDER BY `nama` asc, `tanggal` asc, `data_type` asc, `in` asc";
		}
		
		$query = $this->db->query($swbQuery);
// echo $this->db->last_query();echo '<hr />';
//  echo $this->db->last_query(); die();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;

	}


	function employee_machine_data($date_from, $date_to, $order, $employee_id = '', $nik = '', $divisi = '', $finger_status = '') {
		$sqlFingerStatus = '';
		if (trim($nik)=='') {
			$sqlNIK = '';
			$sqlEmployeeID = "" ;
		} else {
			$sqlNIK = " AND `nik`='".$nik."' ";
			$sqlEmployeeID = " `employee_id` = ".$employee_id." AND " ;
		}
		if ((trim($finger_status)=='') || (trim($finger_status)=='fp_all')) {
			$sqlFingerStatus = '';
		} else {
			if ($finger_status=='fp_ok') {
				$sqlFingerStatus = " AND `status_proses`=1 ";
			} else {
				$sqlFingerStatus = " AND `status_proses`=0 ";
			}
		}

		if (($divisi=='') || ($divisi == 'ALL') || ($sqlEmployeeID!='')) {
			if ($sqlNIK!='') {
				$swbQuery = "SELECT `t_union`.`id`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`,`t_union`.`finger_print`, `t_union`.`nik`, `t_union`.`nama`, `t_union`.`tanggal`, `t_union`.`waktu`, `t_union`.`status_absen`, `t_union`.`status_proses`, `t_union`.`data_type` FROM ((SELECT `t_upload_absent`.`id`, `m_employee`.`kode_cabang` AS `cabang_asal`,`t_upload_absent`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent`.`finger_print`, `m_employee`.`nik`, `m_employee`.`nama`, `t_upload_absent`.`tanggal`, `t_upload_absent`.`waktu`, `t_upload_absent`.`status_absen`, `t_upload_absent`.`status_proses`, 1 AS `data_type` FROM `t_upload_absent` INNER JOIN `m_fp` ON `t_upload_absent`.`finger_print`=`m_fp`.`fingerprint_id` AND `t_upload_absent`.`kode_cabang`=`m_fp`.`kode_cabang` INNER JOIN `m_employee` ON `m_employee`.`nik`=`m_fp`.`fnik` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `m_fp`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' ".$sqlNIK.$sqlFingerStatus.") ) AS `t_union` ORDER BY `t_union`.`data_type`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`, `t_union`.`nama`,`t_union`.`tanggal`, `t_union`.`waktu`;";
			
			} else {
				$swbQuery = "SELECT `t_union`.`id`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`,`t_union`.`finger_print`, `t_union`.`nik`, `t_union`.`nama`, `t_union`.`tanggal`, `t_union`.`waktu`, `t_union`.`status_absen`, `t_union`.`status_proses`, `t_union`.`data_type` FROM ((SELECT `t_upload_absent`.`id`, `m_employee`.`kode_cabang` AS `cabang_asal`,`t_upload_absent`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent`.`finger_print`, `m_employee`.`nik`, `m_employee`.`nama`, `t_upload_absent`.`tanggal`, `t_upload_absent`.`waktu`, `t_upload_absent`.`status_absen`, `t_upload_absent`.`status_proses`, 1 AS `data_type` FROM `t_upload_absent` INNER JOIN `m_fp` ON `t_upload_absent`.`finger_print`=`m_fp`.`fingerprint_id` AND `t_upload_absent`.`kode_cabang`=`m_fp`.`kode_cabang` INNER JOIN `m_employee` ON `m_employee`.`nik`=`m_fp`.`fnik` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `m_fp`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' ".$sqlNIK.$sqlFingerStatus.") UNION (SELECT `t_upload_absent`.`id`, '".$this->session->userdata['ADMIN']['hr_plant_code']."' AS `cabang_asal`,`t_upload_absent`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent`.`finger_print`, 'BELUM TERDAFTAR' AS `nik`, 'BELUM TERDAFTAR' AS `nama`, `t_upload_absent`.`tanggal`, `t_upload_absent`.`waktu`, `t_upload_absent`.`status_absen`, `t_upload_absent`.`status_proses`, 2 AS `data_type` FROM `t_upload_absent` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `t_upload_absent`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' ".$sqlFingerStatus.")) AS `t_union` ORDER BY `t_union`.`data_type`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`, `t_union`.`nama`,`t_union`.`tanggal`, `t_union`.`waktu`;";
						}
//die($swbQuery);

		} else {
			$swbQuery = "SELECT `t_union`.`id`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`,`t_union`.`finger_print`, `t_union`.`nik`, `t_union`.`nama`, `t_union`.`tanggal`, `t_union`.`waktu`, `t_union`.`status_absen`, `t_union`.`status_proses`, `t_union`.`data_type`  FROM ((SELECT `t_upload_absent`.`id`,`m_employee`.`kode_cabang` AS `cabang_asal`,`t_upload_absent`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent`.`finger_print`, `m_employee`.`nik`, `m_employee`.`nama`, `t_upload_absent`.`tanggal`, `t_upload_absent`.`waktu`, `t_upload_absent`.`status_absen`, `t_upload_absent`.`status_proses`, 1 AS `data_type` FROM `t_upload_absent` INNER JOIN `m_fp` ON `t_upload_absent`.`finger_print`=`m_fp`.`fingerprint_id` AND `t_upload_absent`.`kode_cabang`=`m_fp`.`kode_cabang` INNER JOIN `m_employee` ON `m_employee`.`nik`=`m_fp`.`fnik` INNER JOIN `m_divisi` ON `m_divisi`.`nama_divisi`=`m_employee`.`divisi` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `m_fp`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' AND `m_divisi`.`kode_divisi`='".$divisi.$sqlFingerStatus."') UNION (SELECT `t_upload_absent`.`id`,'".$this->session->userdata['ADMIN']['hr_plant_code']."' AS `cabang_asal`,`t_upload_absent`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent`.`finger_print`, 'BELUM TERDAFTAR' AS `nik`, 'BELUM TERDAFTAR' AS `nama`, `t_upload_absent`.`tanggal`, `t_upload_absent`.`waktu`, `t_upload_absent`.`status_absen`, `t_upload_absent`.`status_proses`, 2 AS `data_type` FROM `t_upload_absent` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' AND `t_upload_absent`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' ".$sqlFingerStatus.")) AS `t_union` ORDER BY `t_union`.`data_type`, `t_union`.`cabang_asal`,`t_union`.`cabang_mesin`, `t_union`.`nama`,`t_union`.`tanggal`, `t_union`.`waktu`;";
			
		}

		
		$query = $this->db->query($swbQuery);
// echo $this->db->last_query();echo '<hr />';
//  echo $this->db->last_query(); die();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;

	}


	function employee_suspect_data($date_from, $date_to, $order, $finger_status = '') {

		if ((trim($finger_status)=='') || (trim($finger_status)=='fp_all')) {
			$sqlFingerStatus = '';
		} else {
			if ($finger_status=='fp_maju') {
				$sqlFingerStatus = " AND `anomali_type`=2 ";
			} else {
				$sqlFingerStatus = " AND `anomali_type`=1 ";
			}
		}

		$swbQuery = "SELECT `t_upload_absent_anomali`.`id`, `m_employee`.`kode_cabang` AS `cabang_asal`,`t_upload_absent_anomali`.`kode_cabang` AS `cabang_mesin`,`t_upload_absent_anomali`.`finger_print`, `m_employee`.`nik`, `m_employee`.`nama`, `t_upload_absent_anomali`.`tanggal`, `t_upload_absent_anomali`.`waktu`, `t_upload_absent_anomali`.`status_absen`, `t_upload_absent_anomali`.`status_proses`, `t_upload_absent_anomali`.`anomali_type`, `t_upload_absent_anomali`.`waktu_seharusnya` FROM `t_upload_absent_anomali` INNER JOIN `m_fp` ON `t_upload_absent_anomali`.`finger_print`=`m_fp`.`fingerprint_id` AND `t_upload_absent_anomali`.`kode_cabang`=`m_fp`.`kode_cabang` INNER JOIN `m_employee` ON `m_employee`.`nik`=`m_fp`.`fnik` WHERE `tanggal` BETWEEN '".$date_from."' AND '".$date_to."' ".$sqlFingerStatus." ORDER BY `cabang_asal`,`nama`,`tanggal`, `waktu`;";
	
		
		$query = $this->db->query($swbQuery);
// echo $this->db->last_query();echo '<hr />';
//  echo $this->db->last_query(); die();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;

	}


	function data_last_update() {


		$sqlQuery="SELECT `lastmodified` FROM `t_upload_absent` where `kode_cabang`='".$this->session->userdata['ADMIN']['hr_plant_code']."' and `status_proses`=1 order by `lastmodified` desc limit 0,1";
		$query = $this->db->query($sqlQuery);


		if($query->num_rows() > 0){
			$hasilq = $query->result_array();
			$jam_in= $hasilq[0]['lastmodified'];
			$hasil = 'Data per '.date('d M Y - H:i:s',strtotime($jam_in));
		}
		else
			$hasil ='<span style="color:#AA1122;">DATA MASIH OFFLINE: Harap hubungi hr.helpdesk@ybc.co.id untuk bantuan teknis.</span>';

		return $hasil;
	}


}
?>