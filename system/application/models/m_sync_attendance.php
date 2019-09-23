<?php
/**
 * Synchronize Model
 * This model class used to synchronize employee absent data
 * @author Edward
 */

class m_sync_attendance extends Model {

  # the mysql db instance
  private $_db = NULL;
  private $_tolerate_hour = 3;

	function date_normalizer($d){
		if($d instanceof DateTime){
			return $d->getTimestamp();
		} else {
			return strtotime($d);
		}
	}

	function m_sync_attendance() {
		parent::Model();
		$this->obj =& get_instance();
		$this->obj->load->library('l_general');
        $this->_db = $this->load->database('default', TRUE);
	}
	function sync_set_time_data($time_data){
		if (Empty($time_data))  $time_data='';
		if ($time_data=='') { $time_data = 'NULL'; } else { $time_data = "'".$time_data."'"; }
		return $time_data;
	}


// ============================= SHIFT =============================
	function sync_shift_code_select($shift_code, $company_code) {
		$this->db->select('shift_code, duty_on, duty_off, break_in, break_out');
		$this->db->from('m_shift');
		$this->db->join('m_outlet_employee','m_outlet_employee.OUTLET_HC = m_shift.company_code','inner');
		$this->db->where('OUTLET', $company_code);
		$this->db->where('shift_code', $shift_code);
		$this->db->order_by('shift_code', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function sync_shift_select_all() {
	    //$period = date('Ym');
		$this->_db->select('a.shift_id,c.outlet_hc,b.nik,a.shift_emp_id,a.shift_date,b.kode_cabang,a.shift_code');
		$this->_db->from('d_employee_shift as a');
		$this->_db->from('m_employee as b');
		$this->_db->from('m_outlet_employee as c');
		$this->_db->where('c.outlet = b.kode_cabang');
		$this->_db->where('a.shift_emp_id = b.employee_id');
		$this->_db->where('a.shift_status_proses',0);
		$this->_db->where('a.shift_eod_lock',0);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function sync_shift_select($shift_id) {
	    //$period = date('Ym');
		$this->_db->select('a.shift_id,c.outlet_hc,b.nik,a.shift_emp_id,a.shift_date,b.kode_cabang,a.shift_code');
		$this->_db->from('d_employee_shift as a');
		$this->_db->from('m_employee as b');
		$this->_db->from('m_outlet_employee as c');
		$this->_db->where('c.outlet = b.kode_cabang');
		$this->_db->where('a.shift_emp_id = b.employee_id');
		$this->_db->where('a.shift_status_proses',0);
		$this->_db->where('a.shift_eod_lock',0);
		$this->_db->where('a.shift_id',$shift_id);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function sync_shift_statusproses($shift_id) {
		$swbquery1 = "UPDATE `d_employee_shift` SET `shift_status_proses`=1 WHERE `shift_id` = ".$shift_id." AND `shift_eod_lock`=0;";
		$this->db->query($swbquery1);
	}

	function sync_shift_insert_attendance($data) {
		$shifts=$this->sync_shift_code_select($data['shift_code'], $data['kode_cabang']);
	
		$swbquery1 = "INSERT INTO `t_employee_absent`  (`cabang`,`tanggal`,`nik`,`shift`,`kd_shift`,`shift_in`,`shift_break_out`,`shift_break_in`,`shift_out`,`kd_aktual`,`kd_aktual_temp`, `on_process`) VALUES ('".$data['kode_cabang']."','".$data['shift_date']."','".$data['nik']."','".$data['shift_code']."','".$data['shift_code']."','".$shifts['duty_on']."','".$shifts['break_out']."','".$shifts['break_in']."','".$shifts['duty_off']."','A','A',1);";


		$this->db->query($swbquery1);
		
		$this->sync_fingerprint_cleaning_noshift($data['nik'],$data['shift_date']);
	}

	function sync_shift_update_attendance($data) {
		$shifts=$this->sync_shift_code_select($data['shift_code'], $data['kode_cabang']);
	
		$swbquery1 = "UPDATE `t_employee_absent` SET `shift`='".$data['shift_code']."',`kd_shift`='".$data['shift_code']."',`shift_in`='".$shifts['duty_on']."',`shift_break_out`='".$shifts['break_out']."',`shift_break_in`='".$shifts['break_in']."',`shift_out`='".$shifts['duty_off']."', `on_process`=1 WHERE `tanggal`='".$data['shift_date']."' AND `nik`='".$data['nik']."' AND `eod_lock`=0;";

		$this->db->query($swbquery1);
		$this->sync_fingerprint_cleaning_noshift($data['nik'],$data['shift_date']);
	}

	function sync_shift($shift_id=0,$longshift_nik) {
		$shift_id = intval($shift_id);
		$num_shift=Array();
		$num_shift['insert']=0;
		$num_shift['update']=0;
	    set_time_limit(0);
	    if ($shift_id > 0) {
			$shifts = $this->sync_shift_select($shift_id);
		} else {
			$shifts = $this->sync_shift_select_all();
		}
        if(!empty($shifts)) {
          foreach($shifts as $shift) {
			
        	$this->db->select('absent_id,nik, eod_lock, shift');
        	$this->db->from('t_employee_absent');
        	$this->db->where('tanggal',$shift['shift_date']);
        	$this->db->where('nik',$shift['nik']);

        	$query = $this->db->get();

            if($query->num_rows() > 0) {
                $data = $query->row_array();
				if (($data['eod_lock']==0) && (intval($shift['shift_code'])!=intval($data['shift']))) {
					$this->sync_shift_update_attendance($shift);
					if ($shift_id > 0) { $this->sync_final_calculation($data['absent_id'],$longshift_nik); } //proses individual shift, bukan melalui sync
					$num_shift['update'] ++; 
				}
            } else {
				$this->sync_shift_insert_attendance($shift);
				$num_shift['insert'] ++; 
			}
			
			$this->sync_shift_statusproses($shift['shift_id']);
          }
        }
		
		return $num_shift;
    }
	
	
// ============================= LEAVE =============================
	function sync_leave_select() {
	    //$period = date('Ym');
		// select a.absent_emp_id, b.nik, b.kode_cabang, a.absent_date, a.absent_type from d_employee_absent a, m_employee b where a.absent_status_proses=0 and a.absent_emp_id=b.employee_id
		$this->_db->select('a.absent_id, a.absent_emp_id, b.nik, b.kode_cabang, a.absent_date, a.absent_type');
		$this->_db->from('d_employee_absent as a');
		$this->_db->from('m_employee as b');
		$this->_db->where('a.absent_emp_id = b.employee_id');
		$this->_db->where('a.absent_status_proses',0);
		$this->_db->where('a.absent_eod_lock',0);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function sync_leave_statusproses($absent_id) {
		$swbquery1 = "UPDATE `d_employee_absent` SET `absent_status_proses`=1 WHERE `absent_id` = ".$absent_id." AND `absent_eod_lock`=0;";
		$this->db->query($swbquery1);
	}

	function sync_leave_insert_attendance($data) {
		$swbquery1 = "INSERT INTO `t_employee_absent`  (`cabang`,`tanggal`,`nik`,`kd_cuti`,`kd_aktual`,`on_process`) VALUES ('".$data['kode_cabang']."','".$data['absent_date']."','".$data['nik']."','".$data['absent_type']."','".$data['absent_type']."',0);";
		$this->db->query($swbquery1);
	}

	function sync_leave_update_attendance($data) {
		$swbquery1 = "UPDATE `t_employee_absent` SET `kd_cuti`='".$data['absent_type']."',`kd_aktual`='".$data['absent_type']."',`on_process`=0 WHERE `tanggal`='".$data['absent_date']."' AND `nik`='".$data['nik']."' AND `cabang`='".$data['kode_cabang']."' AND `eod_lock`=0;";

		$this->db->query($swbquery1);
	}

	function sync_leave() {
		$num_leave=Array();
		$num_leave['insert']=0;
		$num_leave['update']=0;
	    set_time_limit(0);
	    $leaves = $this->sync_leave_select();
        if(!empty($leaves)) {
          foreach($leaves as $leave) {
			
        	$this->db->select('nik');
        	$this->db->from('t_employee_absent');
        	$this->db->where('tanggal',$leave['absent_date']);
        	$this->db->where('nik',$leave['nik']);

        	$query = $this->db->get();

            if($query->num_rows() > 0) {
                $data = $query->result_array();
				if (trim($data[0]['nik'])=='') {
					$this->sync_leave_insert_attendance($leave);
					$num_leave['insert'] ++; 
				} else {
					$this->sync_leave_update_attendance($leave);
					$num_leave['update'] ++; 
				}
				
            } else {
				$this->sync_leave_insert_attendance($leave);
				$num_leave['insert'] ++; 
			}
			
			$this->sync_leave_statusproses($leave['absent_id']);
          }
        }
		
		return $num_leave;
    }
	
	
	

	
// ============================= FINGERPRINT =============================
	function sync_fingerprint_check_data_exist($nik, $tanggal, $kode_cabang) {
		$sqlQuery = "SELECT `absent_id` FROM `t_employee_absent` WHERE `cabang`='".$kode_cabang."' AND `tanggal`='".$tanggal."' AND `nik`='".$nik."' AND `data_type`=2;";
		$query = $this->_db->query($sqlQuery);

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
	
	function sync_fingerprint_select_nik() {
		$sqlQuery = "SELECT DISTINCT `c`.`nik`, `c`.`employee_id`, `c`.`kode_cabang` FROM (`t_upload_absent` as a, `m_fp` as b, `m_employee` as c) WHERE `a`.`finger_print` = b.fingerprint_id AND `a`.`kode_cabang` = b.kode_cabang AND `b`.`fnik` = c.nik AND `a`.`status_proses` = 0 AND `a`.`finger_eod_lock`=0 ORDER BY `nik`";

		$query = $this->_db->query($sqlQuery);

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}
	
	function sync_fingerprint_select_date($nik) {
		$sqlQuery = "SELECT DISTINCT `a`.`tanggal` FROM (`t_upload_absent` as a, `m_fp` as b) WHERE `a`.`finger_print` = b.fingerprint_id AND `a`.`kode_cabang` = b.kode_cabang AND `a`.`status_proses` = 0 AND `a`.`finger_eod_lock`=0 AND `b`.`fnik`='".$nik."' ORDER BY `a`.`tanggal`";
// echo $sqlQuery.'<br />';
		$query = $this->_db->query($sqlQuery);

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}
	
	function sync_fingerprint_select_shift($nik,$kode_cabang,$range_dates) {
		$sqlQuery = "SELECT `tanggal`, `shift`, `shift_in`, `shift_break_out`, `shift_break_in`, `shift_out`,`absent_id` FROM `t_employee_absent` WHERE `tanggal` IN (".$range_dates.") AND `nik`=".$nik." AND `shift`<>'' AND `data_type`=1 AND `eod_lock`=0 ORDER BY `tanggal`";
		// echo $sqlQuery.'<br />';

		$query = $this->_db->query($sqlQuery);

		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			return $hasils;
			
		} else {
			return FALSE;
		}
	}

	function sync_fingerprint_select_t_upload($nik,$kode_cabang,$shifts) {
		$kode_cabang = trim($kode_cabang);
		if (strtotime($shifts['shift_in']) > strtotime($shifts['shift_out'])) { //shift lintas hari
		
			$jam_shift_masuk = strtotime($shifts['tanggal'].' '.$shifts['shift_in']) - ($this->_tolerate_hour*60*60);
			$jam_shift_keluar = strtotime($shifts['tanggal'].' '.$shifts['shift_out']) + ((24+$this->_tolerate_hour)*60*60);

//			echo 'LINTAS HARI<br />';
			
		} else { //shift normal
			$jam_shift_masuk = strtotime($shifts['tanggal'].' '.$shifts['shift_in']) - ($this->_tolerate_hour*60*60);
			$jam_shift_keluar = strtotime($shifts['tanggal'].' '.$shifts['shift_out']) + ($this->_tolerate_hour*60*60);

//			echo 'NORMAL HARI<br />';
		}
		
		
		$shift_in_tgl = date('Y-m-d',$jam_shift_masuk);
		$shift_in_jam = date('H:i:s',$jam_shift_masuk);
		
		$shift_out_tgl = date('Y-m-d',$jam_shift_keluar);
		$shift_out_jam = date('H:i:s',$jam_shift_keluar);
		
//		echo 'Shift asli = '.$shifts['tanggal'].' '.$shifts['shift_in'].' -- '.$shifts['tanggal'].' '.$shifts['shift_out'].'<br />';
//		echo 'Shift hitung = '.$shift_in_tgl.' '.$shift_in_jam.' -- '.$shift_out_tgl.' '.$shift_out_jam.'<br />';
		
		if ($shift_in_tgl!=$shift_out_tgl) {
			$sqlTanggal = "((`a`.`tanggal`='".$shift_in_tgl."' AND `a`.`waktu`>='".$shift_in_jam."') OR (`a`.`tanggal`='".$shift_out_tgl."' AND `a`.`waktu`<='".$shift_out_jam."'))";
		} else {
			$sqlTanggal = "(`a`.`tanggal`='".$shift_in_tgl."' AND `a`.`waktu`>='".$shift_in_jam."' AND `a`.`waktu`<='".$shift_out_jam."')";
		}
		
		$sqlQuery = "SELECT `a`.`id`, `a`.`kode_cabang`, `a`.`tanggal`, `a`.`waktu`, `a`.`status_absen`, 0 as `statproc` FROM (`t_upload_absent` as a, `m_fp` as b) WHERE `a`.`finger_print` = b.fingerprint_id AND `a`.`kode_cabang` = `b`.`kode_cabang` AND ".$sqlTanggal." AND `b`.`fnik`='".$nik."' AND `a`.`finger_eod_lock`=0 ORDER BY `a`.`tanggal`,`a`.`waktu`";
		
		$query = $this->_db->query($sqlQuery);
		
		$total_data = 0;
		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			unset($data);
			unset($data_dl);
			$data = Array();
			$data_dl = Array(); //dinas luar --> kode cabang asal dan tujuan beda
			$data['absent_id']=$shifts['absent_id'];
			$cabang = $kode_cabang;
			$count_cabang = 0;
			$data_dl[0]['kode_cabang'] = $cabang;
			foreach($hasils as $hasil => $value) {
				$hasils[$hasil]['kode_cabang'] = trim($hasils[$hasil]['kode_cabang']);
				if (($total_data==0) && ($hasils[$hasil]['status_absen']==0) && (strtotime($shift_in_tgl.' '.$shift_in_jam) >= strtotime($shift_in_tgl.' '.$hasils[$hasil]['waktu']))) { //cek jika finger pertama adalah 0 (abnormal), maka dijadikan IN
					$hasils[$hasil]['status_absen']=1;
				}
			
				if ((Empty($data['in'])) && ($hasils[$hasil]['status_absen']==1)) {
					$hasils[$hasil]['statproc']=1;
					$data['in'] = $hasils[$hasil]['waktu'];
				}
				if ((Empty($data['break_out'])) && ($hasils[$hasil]['status_absen']==0)) {
					$hasils[$hasil]['statproc']=1;
					$data['break_out'] = $hasils[$hasil]['waktu'];
				}
				if ($hasils[$hasil]['status_absen']==1) {
					$hasils[$hasil]['statproc']=1;
					$data['break_in'] = $hasils[$hasil]['waktu'];
				}
				if ($hasils[$hasil]['status_absen']==0) {
					$hasils[$hasil]['statproc']=1;
					$data['out'] = $hasils[$hasil]['waktu'];
				}

				//DINAS LUAR, CATAT CABANG ASAL SBG REFERENSI
				if ((Empty($data_dl[0]['in'])) && ($hasils[$hasil]['status_absen']==1) && ($kode_cabang==$hasils[$hasil]['kode_cabang'])) {
					$data_dl[0]['in'] = $hasils[$hasil]['waktu'];
				}
				if (($hasils[$hasil]['status_absen']==0) && ($kode_cabang==$hasils[$hasil]['kode_cabang'])) {
					$data_dl[0]['out'] = $hasils[$hasil]['waktu'];
				}
				
				
				if ($kode_cabang<>$hasils[$hasil]['kode_cabang']){
					if ($cabang<>$hasils[$hasil]['kode_cabang']){
						$cabang = $hasils[$hasil]['kode_cabang'];
						$count_cabang ++;
					}
					if ((Empty($data_dl[$count_cabang]['in'])) && ($hasils[$hasil]['status_absen']==1)) {
						$data_dl[$count_cabang]['in'] = $hasils[$hasil]['waktu'];
						$data_dl[$count_cabang]['kode_cabang'] = $hasils[$hasil]['kode_cabang'];
					}
					if ($hasils[$hasil]['status_absen']==0) {
						$data_dl[$count_cabang]['out'] = $hasils[$hasil]['waktu'];
						$data_dl[$count_cabang]['kode_cabang'] = $hasils[$hasil]['kode_cabang'];
					}
				}
			
				$this->sync_fingerprint_statusproses($hasils[$hasil]['id']);
				$total_data++;
			}
			
			if ((!Empty($data['in'])) && (!Empty($data['break_in']))){
				if ($data['in']==$data['break_in']) unset($data['break_in']);
			}
			if ((!Empty($data['out'])) && (!Empty($data['break_out']))){
				if ($data['out']==$data['break_out']) unset($data['break_out']);
			}

			$data['in'] = $this->sync_set_time_data(@$data['in']);
			$data['break_out'] = $this->sync_set_time_data(@$data['break_out']);
			$data['break_in'] = $this->sync_set_time_data(@$data['break_in']);
			$data['out'] = $this->sync_set_time_data(@$data['out']);
			
			
			
//			 print_r($data);echo '<hr />';
//			 print_r($data_dl);echo '<hr />';
			
			if (count($data_dl)>1){
				for ($i = 0; $i <= (count($data_dl)-1); $i++) {
					$data_dl_exists = $this->sync_fingerprint_check_data_exist($nik, $shifts['tanggal'], $data_dl[$i]['kode_cabang']);
					if (!Empty($data_dl_exists)) {
						$this->sync_fingerprint_update_dinas_luar($data_dl_exists['absent_id'],$data_dl[$i]);
					} else {
						$this->sync_fingerprint_insert_dinas_luar($nik,$data_dl[$i],$shifts);
					}
				}			
			}
			
			$this->sync_fingerprint_update_attendance($data); //update t_employee_absent
			$hasils[$hasil]['statproc']=1;
		
			unset($data);
			unset($data_dl);
			return $total_data;
			
		} else {
			return $total_data;
		}
	}
	
	function sync_fingerprint_clearing_check_t_employee($finger_type, $nik, $tanggal) {	
		$t_tanggal = strtotime($tanggal);
		$tanggal_prev = date('Y-m-d',$t_tanggal - 86400); // tgl sebelum
		$tanggal_next = date('Y-m-d',$t_tanggal + 86400); // tgl sebelum
		
		if ($finger_type==1) {
			$sqlQuery = "SELECT `absent_id`, CONCAT(`tanggal`, ' ', `shift_in`) as `shift_time`, `break_in` as `break_time`, `in` as `finger_time`, IF (`shift_out`<`shift_in`,1,0) AS `lintas_hari` FROM `t_employee_absent` WHERE `nik` = '".$nik."' AND `tanggal` >= '".$tanggal_prev."' AND `tanggal` <= '".$tanggal_next."' AND `shift`<>'0' AND `shift`<>'' AND `eod_lock`=0 ORDER BY `tanggal`;";
		} else {
			$sqlQuery = "SELECT `absent_id`, CONCAT(IF (`shift_out`<`shift_in`,ADDDATE(`tanggal`,1),`tanggal`), ' ', `shift_out`) as `shift_time`, `break_out` as `break_time`, `out` as `finger_time` FROM `t_employee_absent` WHERE `nik` = '".$nik."' AND `tanggal` >= '".$tanggal_prev."' AND `tanggal` <= '".$tanggal_next."' AND `shift`<>'0' AND `shift`<>'' AND `eod_lock`=0 ORDER BY `tanggal`;";
		}
		$query = $this->_db->query($sqlQuery);
		
		
		$total_data = 0;
		if($query->num_rows() > 0) {
			return $query->result_array();
			
		} else { 
			return FALSE;
		}
	}
	
	
	function sync_fingerprint_clearing_t_upload($process_all=false) {
		if ($process_all){
			$sqlQuery = "delete from `t_employee_absent_noshift`;";
			$query = $this->_db->query($sqlQuery);
		}

		$sqlQuery = "SELECT `a`.`id`, `a`.`kode_cabang`, `b`.`fnik`, `a`.`tanggal`, `a`.`waktu`, `a`.`status_absen`, 0 as `statproc` FROM (`t_upload_absent` as a, `m_fp` as b) WHERE `a`.`finger_print` = b.fingerprint_id AND `a`.`kode_cabang` = b.kode_cabang AND `a`.`status_proses` = 0 AND `a`.`finger_eod_lock`=0 ORDER BY `b`.`fnik`, `a`.`tanggal`,`a`.`waktu`";
		
		$query = $this->_db->query($sqlQuery);
		
		
		$total_data = 0;
		$total_data_noshift = 0;
		$jml_data = Array();
		$jml_data['shift'] = 0;
		$jml_data['noshift'] = 0;
		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			
			
			// print_r($hasils);echo '<hr />';
			$tmp_nik = $hasils[0]['fnik'];
			$tmp_tgl = $hasils[0]['tanggal'];
			$noshift_in='';
			$noshift_breakout='';
			$noshift_breakin='';
			$noshift_out='';
			foreach($hasils as $hasil => $value) {
				unset($data);
				$data = Array();
				$check_time_results = $this->sync_fingerprint_clearing_check_t_employee($hasils[$hasil]['status_absen'], $hasils[$hasil]['fnik'], $hasils[$hasil]['tanggal']);
				
				$shift_exist = false;
				if (!Empty($check_time_results)) {
					$time_diff = 999999999;
					$machine_time = strtotime($hasils[$hasil]['tanggal'].' '.$hasils[$hasil]['waktu']);

					foreach($check_time_results as $check_time) {
						$shift_time = strtotime($check_time['shift_time']);
						if (abs($machine_time-$shift_time)<$time_diff){
							$time_diff = abs($machine_time-$shift_time);
							$absent_id = $check_time['absent_id'];
							$break_time = $check_time['break_time'];
							$finger_time = $check_time['finger_time'];
						}
					}
					if ($time_diff<43200) { //lebih kecil dari 12 jam perbedaan finger dan shift baru diproses, jika beda jauh maka anomali
						if (Empty($break_time)) $break_time = '';
						if (Empty($finger_time)) $finger_time = '';
						
						if (($finger_time=='') && ($hasils[$hasil]['status_absen']==1)) {
							$finger_time = $hasils[$hasil]['waktu'];
						}
						if (($break_time=='') && ($hasils[$hasil]['status_absen']==0)) {
							$finger_time = $hasils[$hasil]['waktu'];
							$break_time = $hasils[$hasil]['waktu'];
						}
						if ($hasils[$hasil]['status_absen']==1) {
							$break_time = $hasils[$hasil]['waktu'];
						}
						if ($hasils[$hasil]['status_absen']==0) {
							$finger_time = $hasils[$hasil]['waktu'];
						}
						
						
						// if ($break_time==$finger_time) $break_time='';
						
						$data['absent_id'] = $absent_id;
						$data['break_time'] = $this->sync_set_time_data($break_time);
						$data['finger_time'] = $this->sync_set_time_data($finger_time);
						$this->sync_fingerprint_clearing_update_attendance($hasils[$hasil]['status_absen'],$data);
						
						$shift_exist = true;
						$noshift_in='';
						$noshift_breakout='';
						$noshift_breakin='';
						$noshift_out='';
						$this->sync_fingerprint_statusproses($hasils[$hasil]['id']);
						$total_data++;
					}
				}
				
				
				if (!$shift_exist) {
				//masuk data ke t_employee_absent_noshift
				
					if (($tmp_tgl != $hasils[$hasil]['tanggal']) || ($tmp_nik != $hasils[$hasil]['fnik'])) {
						$tmp_tgl = $hasils[$hasil]['tanggal'];
						$tmp_nik = $hasils[$hasil]['fnik'];
						$noshift_in='';
						$noshift_breakout='';
						$noshift_breakin='';
						$noshift_out='';
					}
				

					if ((Empty($noshift_in)) && ($hasils[$hasil]['status_absen']==1)) {
						$noshift_in = $hasils[$hasil]['waktu'];
					}
					if ((Empty($noshift_breakout)) && ($hasils[$hasil]['status_absen']==0)) {
						$noshift_breakout = $hasils[$hasil]['waktu'];
					}
					if ($hasils[$hasil]['status_absen']==1) {
						$noshift_breakin = $hasils[$hasil]['waktu'];
					}
					if ($hasils[$hasil]['status_absen']==0) {
						$noshift_out = $hasils[$hasil]['waktu'];
					}
				
				
					if (($noshift_in!='') && ($noshift_breakin!='')){
						if ($noshift_in==$noshift_breakin) $noshift_breakin='';
					}
					if (($noshift_out!='') && ($noshift_breakout!='')){
						if ($noshift_out==$noshift_breakout) $noshift_breakout='';
					}


					$this->sync_fingerprint_insert_noshift($hasils[$hasil]['fnik'],$hasils[$hasil]['kode_cabang'],$hasils[$hasil]['tanggal'],$noshift_in,$noshift_breakout,$noshift_breakin,$noshift_out);
					$total_data_noshift++;
				/*echo 'NOSHIFT='.$tmp_nik.'|'.$hasils[$hasil]['fnik'].'=='.$tmp_tgl.'|'.$hasils[$hasil]['tanggal'].'<br />';
				echo 'DATA  = '.$hasils[$hasil]['waktu'].'<br />';
				echo 'IN='.$noshift_in.'<br />';
				echo 'BREAKOUT='.$noshift_breakout.'<br />';
				echo 'BREAKIN='.$noshift_breakin.'<br />';
				echo 'OUT='.$noshift_out.'<br />';
				echo '<hr />';*/
				} 
				
				unset($data);
			}
			
			$jml_data['shift'] = $total_data;
			$jml_data['noshift'] = $total_data_noshift;
			return $jml_data;
			
		} else {
			return $jml_data;
		}
	}
		
	function sync_fingerprint_statusproses($table_id) {
		$swbquery1 = "UPDATE `t_upload_absent` SET `status_proses`=1 WHERE `id`=".$table_id." ;";
		$this->db->query($swbquery1);
	}

	function sync_fingerprint_insert_dinas_luar($nik,$data,$shifts) {
		$swbquery1 = "INSERT INTO `t_employee_absent`  (`cabang`,`tanggal`,`nik`,`shift`,`kd_shift`,`shift_in`,`shift_break_out`,`shift_break_in`,`shift_out`,`in`,`out`,`data_type`,`on_process`) VALUES ('".$data['kode_cabang']."','".$shifts['tanggal']."','".$nik."','".$shifts['shift']."','".$shifts['shift']."','".$shifts['shift_in']."','".$shifts['shift_break_out']."','".$shifts['shift_break_in']."','".$shifts['shift_out']."','".$data['in']."','".$data['out']."',2,1);";
		$this->db->query($swbquery1);
	}

	function sync_fingerprint_update_dinas_luar($absent_id,$data) {
		$swbquery1 = "UPDATE `t_employee_absent` SET `in`='".$data['in']."',`out`='".$data['out']."',`data_type`=2,`on_process`=1 WHERE `absent_id`=".$absent_id.";";
		
		$this->db->query($swbquery1);
	}

	function sync_fingerprint_update_attendance($data) {
		$swbquery1 = "UPDATE `t_employee_absent` SET `in`=".$data['in'].", `break_out`=".$data['break_out'].", `break_in`=".$data['break_in'].", `out`=".$data['out'].", `on_process`=1 WHERE `absent_id`=".$data['absent_id']." AND `eod_lock`=0;";
		$this->db->query($swbquery1);
	}

	function sync_fingerprint_clearing_update_attendance($finger_type,$data) {
		if ($finger_type==1){
			$swbquery1 = "UPDATE `t_employee_absent` SET `in`=".$data['finger_time'].", `break_in`=".$data['break_time'].", `on_process`=1 WHERE `absent_id`=".$data['absent_id']." AND `eod_lock`=0 AND `shift`<>'0' AND `shift`<>''  ;";
		} else {
			$swbquery1 = "UPDATE `t_employee_absent` SET `out`=".$data['finger_time'].", `break_out`=".$data['break_time'].", `on_process`=1 WHERE `absent_id`=".$data['absent_id']." AND `eod_lock`=0 AND `shift`<>'0' AND `shift`<>'' ;";
		}
		
		$this->db->query($swbquery1);
	}	

	function sync_fingerprint_insert_noshift($nik,$kode_cabang,$tanggal,$noshift_in,$noshift_breakout,$noshift_breakin,$noshift_out) {
		$noshift_in = $this->sync_set_time_data($noshift_in);
		$noshift_breakout = $this->sync_set_time_data($noshift_breakout);
		$noshift_breakin = $this->sync_set_time_data($noshift_breakin);
		$noshift_out = $this->sync_set_time_data($noshift_out);

		$sqlQuery = "SELECT `absent_id` FROM `t_employee_absent` WHERE `nik` = '".$nik."' AND `tanggal` = '".$tanggal."';";
		$query = $this->db->query($sqlQuery);
		
		if($query->num_rows() > 0) {
			$this->sync_fingerprint_cleaning_noshift($nik,$tanggal);
		} else {
			$swbquery1 = "INSERT INTO `t_employee_absent_noshift`  (`cabang`,`tanggal`,`nik`,`in`,`break_out`,`break_in`,`out`) VALUES ('".$kode_cabang."','".$tanggal."','".$nik."',".$noshift_in.",".$noshift_breakout.",".$noshift_breakin.",".$noshift_out.") ON DUPLICATE KEY UPDATE `in`=".$noshift_in.",`break_out`=".$noshift_breakout.",`break_in`=".$noshift_breakin.",`out`=".$noshift_out.";";
			$this->db->query($swbquery1);
		}
	}

	function sync_fingerprint_cleaning_noshift($nik,$tanggal) {
		$sqlQuery = "DELETE FROM `t_employee_absent_noshift` WHERE `nik`='".$nik."' AND `tanggal`='".$tanggal."';";

		$this->db->query($sqlQuery);

	}

	function sync_fingerprint($process_all=false) {
		$sync_stat = '';
		$num_fingerprint=Array();
		$num_fingerprint['insert']=0;
		$num_fingerprint['update']=0;
	    set_time_limit(0);
		
	    $fingerprints_nik = $this->sync_fingerprint_select_nik(); //ambil data nik dari t_upload_absent
        if(!empty($fingerprints_nik)) {
			foreach($fingerprints_nik as $fingerprint_nik) {
				$fingerprint_nik_dates = $this->sync_fingerprint_select_date($fingerprint_nik['nik']); //ambil minimum - maximum date di t_upload_absent
				if(!empty($fingerprint_nik_dates)) {
					$range_date = "";
					foreach ($fingerprint_nik_dates as $fingerprint_nik_date) {
						$range_date .= "'".$fingerprint_nik_date['tanggal']."',";
					}
					$range_date .= '#';
					$range_date = str_replace(',#','',$range_date);
					$range_date = str_replace('#','',$range_date);
					$fingerprint_shifts = $this->sync_fingerprint_select_shift($fingerprint_nik['nik'],$fingerprint_nik['kode_cabang'],$range_date); //ambil data shift sesuai t_upload_absent dari t_employee_absent
					
					if(!empty($fingerprint_shifts)) {
						foreach($fingerprint_shifts as $fingerprint_shift) {
							if (intval($fingerprint_shift['shift'])!=0) {
								$hasil = $this->sync_fingerprint_select_t_upload($fingerprint_nik['nik'],$fingerprint_nik['kode_cabang'],$fingerprint_shift); //proses t_upload_absent sesuai shift
								
								$num_fingerprint['update'] = $num_fingerprint['update'] + $hasil;
						
							}
						}
					}
				
				
			}
			
          }
        }
		$sync_stat .= '['.date('Ymd-H:i:s').']: Shift checking finished<br />'."\r\n";
		
		$clear_t_upload = $this->sync_fingerprint_clearing_t_upload($process_all); //bersihkan sisa di t_upload_absent yang masih status_proses=0
		$sync_stat .= '['.date('Ymd-H:i:s').']: Clearing_t_upload<br />'."\r\n";
		$sync_stat .= '+++++++ Shift exist: '.$clear_t_upload['shift'].'<br />'."\r\n";
		$sync_stat .= '+++++++ No shift: '.$clear_t_upload['noshift'].'<br /><br />'."\r\n\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `t_upload_absent` = '.$num_fingerprint['update'];$sync_stat .= '<br />'."\r\n";
		
		return $sync_stat;
    }
	
	
	
		
// ============================= FINAL CALCULATION =============================
	function sync_final_update_attendance($absent_id,$kd_aktual,$terlambat,$pulangcepat,$jamkerja) {
		$swbquery1 = "UPDATE `t_employee_absent` SET `kd_aktual`='".$kd_aktual."', `kd_aktual_temp`='".$kd_aktual."', `terlambat`=".$terlambat.", `pulang_cepat`=".$pulangcepat.", `jam_kerja`=".$jamkerja.", `on_process`=0 WHERE `absent_id`=".$absent_id." AND `eod_lock`=0;";
		$this->db->query($swbquery1);
	}

	function sync_final_get_long_shift() {
		$ls[] = 'NONE';
		$swbquery1 = "SELECT DISTINCT(`nik`) FROM `m_employee` WHERE `bagian` = 'MANAGER ON DUTY' ORDER BY `nik`;";
		$query = $this->db->query($swbquery1);
		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			foreach ($hasils as $hasil){
				$ls[] = $hasil['nik'];
			}
		}
		return $ls;
	}

	function sync_final_calculation($table_id=0,$longshift_nik) {
	
		//get longshift shift code
		$swbquery = "SELECT `shift_code`, `company_code` FROM `m_shift` WHERE `flag_ls`=1";
		$queryls = $this->db->query($swbquery);
		$hasil_ls = $queryls->result_array();
	
		$table_id = intval($table_id);
		if ($table_id > 0) {
			$swbquery1 = "UPDATE `t_employee_absent` SET `break_out`=NULL WHERE `absent_id`=".$table_id." AND `break_out`=`out` AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			$swbquery1 = "UPDATE `t_employee_absent` SET `break_in`=NULL WHERE `absent_id`=".$table_id." AND `break_in`=`in` AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			$swbquery1 = "UPDATE `t_employee_absent` SET `on_process`=0 WHERE `absent_id`=".$table_id." AND `kd_cuti`<>'' AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			
			$sqlQuery = "SELECT `absent_id`, `nik`, `tanggal`, `shift_in`, `shift_out`, `kd_cuti`, `in`, `out` FROM `t_employee_absent` WHERE `absent_id`=".$table_id." AND `eod_lock`=0";
		} else {
			$swbquery1 = "UPDATE `t_employee_absent` SET `break_out`=NULL WHERE `break_out`=`out` AND `on_process`=1 AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			$swbquery1 = "UPDATE `t_employee_absent` SET `break_in`=NULL WHERE `break_in`=`in` AND `on_process`=1 AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			$swbquery1 = "UPDATE `t_employee_absent` SET `on_process`=0 WHERE `kd_cuti`<>'' AND `eod_lock`=0;";
			$this->db->query($swbquery1);
			
			$sqlQuery = "SELECT `absent_id`, `nik`, `tanggal`, `cabang`, `shift`, `shift_in`, `shift_out`, `kd_cuti`, `in`, `out` FROM `t_employee_absent` WHERE `on_process`=1 AND (`kd_cuti` IS NULL OR `kd_cuti`='') AND `eod_lock`=0";
		}
		
		$query = $this->_db->query($sqlQuery);
		
		$total_data = 0;
		if($query->num_rows() > 0) {
			
			$hasils = $query->result_array();
			
			
			
			unset($data);
			$data = Array();
			$date_default_timezone = date_default_timezone_get();
			date_default_timezone_set("UTC");
			foreach($hasils as $hasil) {
				if ($hasil['kd_cuti']==''){
					$kd_shift = intval($hasil['shift']);
					$is_LongShift = FALSE;
					foreach($hasil_ls as $ls_shift) {
						if ((strpos('###'.$hasil['cabang'],$ls_shift['company_code'])>0) && ($kd_shift==$ls_shift['shift_code'])) {
							$is_LongShift = TRUE;
							break;
						}
					}
					
				
					$shift_in = strtotime($hasil['tanggal'].' '.$hasil['shift_in']);
					$shift_out = strtotime($hasil['tanggal'].' '.$hasil['shift_out']);
					$shift_in_time = strtotime($hasil['shift_in']); 
					$shift_out_time = strtotime($hasil['shift_out']);

					
					$finger_in = strtotime($hasil['tanggal'].' '.$hasil['in']);
					$finger_out = strtotime($hasil['tanggal'].' '.$hasil['out']);
					
					$finger_in_time = strtotime($hasil['in']); 
					$finger_out_time = strtotime($hasil['out']);

					$linstashari = false;
					if ($shift_in > $shift_out){
					//lintas hari
						$linstashari = true;
						$shift_out = $shift_out + 86400; //tambah 1 hari jam keluar
					}
					
					if ($finger_in > $finger_out){
					//lintas hari
						if ($linstashari) $finger_out = $finger_out + 86400; //tambah 1 hari jam keluar
						else {
							$finger_out = $finger_out + 86400;
						}
					}
					
					$terlambat = '';
					$pulangcepat = '';
					$jamkerja = '';
					if ($finger_in > $shift_in) {
						$terlambat = date('H:i:s',$finger_in - $shift_in);
					}
					if ($finger_out < $shift_out) {
						$pulangcepat = date('H:i:s',$shift_out - $finger_out);
					}
					
					
					//KODE AKTUAL
					if ((Empty($hasil['in'])) && (Empty($hasil['out']))) {
						$kd_aktual = 'A';
						
					}
					elseif ((Empty($hasil['in'])) || (Empty($hasil['out']))) {
						$kd_aktual = 'TL';
						
					}
					else {
						$jamkerja = date('H:i:s',$finger_out - $finger_in);
						$kd_aktual = 'A';
						if( ($finger_in > $shift_in) && ($finger_out < $shift_out) ){
							$kd_aktual = 'TC';
						} elseif ($finger_in > $shift_in) {
							$kd_aktual = 'DT';
						} elseif($finger_out < $shift_out) {
							$kd_aktual = 'PC';
						} elseif( ($finger_in <= $shift_in) && ($finger_out >= $shift_out) ) {
							$kd_aktual = 'H';
/*							if(( ($finger_out - $finger_in) >= (12 * 60 * 60) )&&( ($finger_out_time >= (strtotime('23:00:00'))) && ($finger_in_time <= (strtotime('11:00:00'))) ) && (in_array($hasil['nik'], $longshift_nik))) {
								$kd_aktual = 'LS';
							}*/
							if(($is_LongShift==TRUE) && (in_array($hasil['nik'], $longshift_nik))) {
								$kd_aktual = 'LS';
							}
							elseif ( ($shift_in_time >= (strtotime('23:00:00'))) || ($shift_in_time <= (strtotime('06:00:00'))) || ($shift_out_time >= (strtotime('23:00:00'))) || ($shift_out_time <= (strtotime('06:00:00'))) ) {
									$kd_aktual = 'TM';
							}
						}
					}
					
					$terlambat = $this->sync_set_time_data($terlambat);
					$pulangcepat = $this->sync_set_time_data($pulangcepat);
					$jamkerja = $this->sync_set_time_data($jamkerja);
					
					/*
					echo '<b>'.$hasil['absent_id'].'</b><br />';
					echo 'SHIFT IN='.date('Y-m-d H:i:s',$shift_in).' == harusnya: '.$hasil['tanggal'].' '.$hasil['shift_in'].'<br />';
					echo 'IN='.date('Y-m-d H:i:s',$finger_in).' == harusnya: '.$hasil['tanggal'].' '.$hasil['in'].'<br />';
					echo '<br />';
					echo 'SHIFT OUT='.date('Y-m-d H:i:s',$shift_out).' == harusnya: '.$hasil['tanggal'].' '.$hasil['shift_out'].'<br />';
					echo 'OUT='.date('Y-m-d H:i:s',$finger_out).' == harusnya: '.$hasil['tanggal'].' '.$hasil['out'].'<br />';
					echo 'KD AKTUAL='.$kd_aktual.'<br />';
					echo '<hr />';
					*/
					$this->sync_final_update_attendance($hasil['absent_id'],$kd_aktual,$terlambat,$pulangcepat,$jamkerja);
					$total_data++;
					
				}
			}
			date_default_timezone_set($date_default_timezone);
		}
		
		return $total_data;
	}


// ============================= EOM LOCK =============================
	function eod_lock_check_date($employee_id) {
		$sqlQuery = "SELECT max(akhir) as `tanggal` FROM m_employee a inner join d_endofmonth b on a.kode_grouppembayaran=b.period_type AND a.kode_cabang=b.kode_outlet inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran and c.period=b.periode where employee_id=".$employee_id." and eom_status=1";
		$query=$this->db->query($sqlQuery);
		if($query->num_rows() > 0) {
			$hasils = $query->row_array();
			return $hasils['tanggal'];
		} else {
			return '';
		}
	}

	function eod_lock_process($employee_id, $nik, $tanggal) {
		$sqlQuery = "UPDATE `d_employee_shift` SET `shift_eod_lock`=1,`shift_status_proses`=1 WHERE `shift_emp_id`=".$employee_id." AND `shift_eod_lock`=0 AND `shift_date`<='".$tanggal."';";
		$this->db->query($sqlQuery);
		$sqlQuery = "UPDATE `d_employee_absent` SET `absent_eod_lock`=1,`absent_status_proses`=1 WHERE `absent_emp_id`=".$employee_id." AND `absent_eod_lock`=0 AND `absent_date`<='".$tanggal."';";
		$this->db->query($sqlQuery);
		$sqlQuery = "UPDATE `t_employee_absent` SET `eod_lock`=1, `on_process`=0 WHERE `nik`='".$nik."' AND `eod_lock`=0 AND `tanggal`<='".$tanggal."';";
		$this->db->query($sqlQuery);
		
		$sqlQuery = "SELECT `kode_cabang`, `fingerprint_id` FROM `m_fp` WHERE `fnik`='".$nik."'";
		
		$query = $this->_db->query($sqlQuery);
		
		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			foreach ($hasils as $hasil){
				if (intval($hasil['fingerprint_id'])>0){
					$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=1,`finger_eod_lock`=1 WHERE `kode_cabang`='".$hasil['kode_cabang']."' AND `finger_print`='".$hasil['fingerprint_id']."' AND `finger_eod_lock`=0 AND `tanggal`<='".$tanggal."';";
					$this->db->query($sqlQuery);
				}
			}
			
		}
	}

	
	
// ============================= CORESYNC =============================
	function sync_checking() {
		$sqlQuery = "SELECT UPPER(`sync_stat`) AS `sync_stat` FROM `t_status_sync` WHERE `sync_stat`<>'' AND `sync_stat` IS NOT NULL LIMIT 0,1";
		$query=$this->db->query($sqlQuery);
		if($query->num_rows() > 0) {
			$hasils = $query->row_array();
			return $hasils['sync_stat'];
		} else {
			return '';
		}
	}

	function sync_setidle() {
		$sqlQuery = "UPDATE `t_status_sync` SET `sync_stat`='IDLE'";
		if ($this->db->query($sqlQuery)) {
			echo 'OK';
			return TRUE;
		} else {
			echo 'FAILED';
			return FALSE;
		}
	}

	function sync_setrunning($sync_stat='') {
		$sqlQuery = "UPDATE `t_status_sync` SET `sync_stat`='RUNNING ".$sync_stat.": ".date('Y-m-d H:i:s')."'";
		$this->db->query($sqlQuery);
	}

	function sync_setstatus($sync_stat) {
		$sqlQuery = "UPDATE `t_status_sync` SET `sync_desc`='".$sync_stat."'";
		$this->db->query($sqlQuery);
	}

	function eod_lock_all($run_type=1) {
		if ($run_type==1) $this->sync_setrunning('EOD LOCKING');
		
		$sqlQuery = "SELECT `employee_id`, `nik` FROM `m_employee`;";
		$query = $this->_db->query($sqlQuery);
		
		$count_data = 0;
		if($query->num_rows() > 0) {
			$hasils = $query->result_array();
			$total_data = count($hasils);
			foreach($hasils as $hasil){
				if (intval($hasil['employee_id'])!=0){
					$tanggal_eod = $this->eod_lock_check_date($hasil['employee_id']);
					if ($tanggal_eod!='') {
						$this->eod_lock_process($hasil['employee_id'], $hasil['nik'], $tanggal_eod);
						$count_data++;
					}
				}
				
				if (($count_data % 10)==0) {
					$this->sync_setstatus('EOD Lock: '.$count_data.' of '.$total_data);
				}
			
			}
		}
		$this->sync_setstatus('EOD Lock: '.$count_data.' of '.$total_data.' employees');
		if ($run_type==1)  $this->sync_setidle();
		
		$sync_stat = 'Total data = '.$total_data.'<br />'."\r\n";
		echo $sync_stat;
		return $sync_stat;
		
		
/*		$sqlQuery = "CALL eom_lock();";
		$query = $this->_db->query($sqlQuery);
		$sync_stat = 'Finish EOM Checking<br />'."\r\n";
		echo $sync_stat;
		return $sync_stat;
*/		
	}
	
	function eod_lock_daily() {
		$hasil = $this->eod_lock_all(0);
		/*
		$sqlQuery = "CALL eom_lock();";
		$query = $this->_db->query($sqlQuery);
		*/
		$sync_stat = 'Finish EOM Checking<br />'."\r\n";
//		echo $sync_stat;
		return $sync_stat;
	}
	
	
	function sync_process() {
	$check_sync = $this->sync_checking();
	if ($check_sync == 'IDLE') {
		$this->sync_setrunning();
	
		$sync_stat = '';
		$num_eom=$this->eod_lock_daily();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Lock EOM = '.$num_eom;$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_shift=$this->sync_shift(0,NULL);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_shift` = '.$num_shift['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_shift` = '.$num_shift['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_leave=$this->sync_leave();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_absent` = '.$num_leave['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_absent` = '.$num_leave['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_fingerprint=$this->sync_fingerprint(FALSE);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= $num_fingerprint;
//		$sync_stat .= 'Inserted FINGERPRINT = '.$num_fingerprint['insert'];echo '<br />'."\r\n";

		$longshift_nik = $this->sync_final_get_long_shift();
		$num_calculate=$this->sync_final_calculation(0,$longshift_nik);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated `t_employee_absent` = '.$num_calculate;$sync_stat .= '<br /><br />'."\r\n\r\n";
		$this->sync_setstatus($sync_stat);
		
		$swbquery1 = 'call clean_noshift();';
		$this->db->query($swbquery1); //temporary
		$sync_stat .= '['.date('Ymd-H:i:s').']: Cleaning NO SHIFT';$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);
		
		$this->sync_setidle();
		echo $sync_stat;
		return strip_tags($sync_stat);
	} else {
		$sync_stat = 'Sync already run in other process';
		$sync_stat .= '<br />'."\r\n";
		echo $sync_stat;
		return strip_tags($sync_stat);
	}
	}
	
	function sync_reload_process() {
	$check_sync = $this->sync_checking();
	if ($check_sync == 'IDLE') {
		$this->sync_setrunning();
		$sync_stat = '';
		$num_eom=$this->eod_lock_daily();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Lock EOM = '.$num_eom;$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$swbquery1 = 'call reload_data();';
		$this->db->query($swbquery1); //temporary
		$sync_stat .= '['.date('Ymd-H:i:s').']: Reload data';$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);
	
		$num_shift=$this->sync_shift(0,NULL);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_shift` = '.$num_shift['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_shift` = '.$num_shift['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_leave=$this->sync_leave();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_absent` = '.$num_leave['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_absent` = '.$num_leave['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_fingerprint=$this->sync_fingerprint(TRUE);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= $num_fingerprint;
//		$sync_stat .= 'Inserted FINGERPRINT = '.$num_fingerprint['insert'];echo '<br />'."\r\n";

		$longshift_nik = $this->sync_final_get_long_shift();
		$num_calculate=$this->sync_final_calculation(0,$longshift_nik);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated `t_employee_absent` = '.$num_calculate;$sync_stat .= '<br /><br />'."\r\n\r\n";
		$this->sync_setstatus($sync_stat);
		
		$swbquery1 = 'call clean_noshift();';
		$this->db->query($swbquery1); //temporary
		$sync_stat .= '['.date('Ymd-H:i:s').']: Cleaning NO SHIFT';$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);
		
		$this->sync_setidle();
		echo $sync_stat;
		return strip_tags($sync_stat);
	} else {
		$sync_stat = 'Sync already run in other process';
		$sync_stat .= '<br />'."\r\n";
		echo $sync_stat;
		return strip_tags($sync_stat);
	}
	}

	function sync_reset_process() {
	$check_sync = $this->sync_checking();
	if ($check_sync == 'IDLE') {
		$this->sync_setrunning();
		$sync_stat = '';
		$num_eom=$this->eod_lock_daily();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Lock EOM = '.$num_eom;$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$swbquery1 = 'call reset_data();';
		$this->db->query($swbquery1); //temporary
		$sync_stat .= '['.date('Ymd-H:i:s').']: Reset data';$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);
	
		$num_shift=$this->sync_shift(0,NULL);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_shift` = '.$num_shift['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_shift` = '.$num_shift['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_leave=$this->sync_leave();
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated from `d_employee_absent` = '.$num_leave['update'];$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Inserted from `d_employee_absent` = '.$num_leave['insert'];$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);

		$num_fingerprint=$this->sync_fingerprint(TRUE);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= $num_fingerprint;
//		$sync_stat .= 'Inserted FINGERPRINT = '.$num_fingerprint['insert'];echo '<br />'."\r\n";

		$longshift_nik = $this->sync_final_get_long_shift();
		$num_calculate=$this->sync_final_calculation(0,$longshift_nik);
		$sync_stat .= '<br />'."\r\n";
		$sync_stat .= '['.date('Ymd-H:i:s').']: Updated `t_employee_absent` = '.$num_calculate;$sync_stat .= '<br /><br />'."\r\n\r\n";
		$this->sync_setstatus($sync_stat);
		
		$swbquery1 = 'call clean_noshift();';
		$this->db->query($swbquery1); //temporary
		$sync_stat .= '['.date('Ymd-H:i:s').']: Cleaning NO SHIFT';$sync_stat .= '<br />'."\r\n";
		$this->sync_setstatus($sync_stat);
		
		$this->sync_setidle();
		echo $sync_stat;
		return strip_tags($sync_stat);
	} else {
		$sync_stat = 'Sync already run in other process';
		$sync_stat .= '<br />'."\r\n";
		echo $sync_stat;
		return strip_tags($sync_stat);
	}
	}
	
	function sync_status() {
		$sqlQuery = "SELECT * FROM `t_status_sync` LIMIT 0,1";
		$query = $this->db->query($sqlQuery);
		
		if($query->num_rows() > 0) {
			$hasils = $query->row_array();
		}
		echo $hasils['sync_stat'];
		echo '<hr /><b>Last Updated on (or previous running Sync): '.date('Y-m-d H:i:s').'</b><br />';
		echo $hasils['sync_desc'];
	}
}

?>
