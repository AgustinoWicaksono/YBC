<?php
/**
 * Synchronize Model
 * This model class used to synchronize between MySQL and MS SQL data
 * This Model for MySQL
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */

class M_sinkron_mysql extends Model {

  # the mysql db instance
  private $_db = NULL;

	/**
	 * Synchronize Model
	 * This model class used to synchronize between MySQL and MS SQL data
	 * This Model for MySQL
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function date_normalizer($d){
		if($d instanceof DateTime){
			return $d->getTimestamp();
		} else {
			return strtotime($d);
		}
	}

	function M_sinkron_mysql() {
		parent::Model();
		$this->obj =& get_instance();
		$this->load->model('m_sinkron_mssql');
		$this->load->model('m_employee_absent');
		$this->load->model('m_employee');
        $this->_db = $this->load->database('default', TRUE);
	}

	function shift_select() {
	    //$period = date('Ym');
		$this->_db->select('c.outlet_hc,b.nik,a.shift_emp_id,a.shift_date,b.kode_cabang,a.shift_code');
		$this->_db->from('d_employee_shift as a');
		$this->_db->from('m_employee as b');
		$this->_db->from('m_outlet_employee as c');
		$this->_db->where('c.outlet = b.kode_cabang');
		$this->_db->where('a.shift_emp_id = b.employee_id');
		$this->_db->where('a.shift_status_proses',0);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function shift_status($tanggal,$employee_id) {
		$swbquery1 = "UPDATE `d_employee_shift` SET `shift_status_proses`=1 WHERE `shift_emp_id` = ".$employee_id." AND `shift_date` = '".$tanggal."';";
		$this->db->query($swbquery1);
	}

	function t_employee_absent_insert($data) {
		$shifts=$this->m_employee_shift->shift_code_select($data['shift_code'], $data['kode_cabang']);
	
		$swbquery1 = "INSERT INTO `t_employee_absent`  (`cabang`,`tanggal`,`nik`,`shift`,`kd_shift`,`shift_in`,`shift_break_out`,`shift_break_in`,`shift_out`,`kd_aktual`,`kd_aktual_temp`) VALUES ('".$data['kode_cabang']."','".$data['shift_date']."','".$data['nik']."','".$data['shift_code']."','".$data['shift_code']."','".$shifts['duty_on']."','".$shifts['break_out']."','".$shifts['break_in']."','".$shifts['duty_off']."','A','A');";
//		die($swbquery1);
		$this->db->query($swbquery1);
	}

	
	function update_shift() {
	    set_time_limit(0);
	    $shifts = $this->shift_select();
        if(!empty($shifts)) {
          foreach($shifts as $shift) {

        	$this->db->select('nik');
        	$this->db->from('t_employee_absent');
        	$this->db->where('tanggal',$shift['shift_date']);
        	$this->db->where('nik',$shift['nik']);

        	$query = $this->db->get();
//			echo "\r\n";
//			echo "\r\n";

            if($query->num_rows() > 0) {
                $data = $query->result_array();
				if (trim($data[0]['nik'])=='') {
//				echo $this->db->last_query();
//				echo "\r\n";
					$this->t_employee_absent_insert($shift);
				}
				
            } else {
//				echo $this->db->last_query();
//				echo "\r\n";
				$this->t_employee_absent_insert($shift);
			}

			$this->shift_status($shift['shift_date'],$shift['shift_emp_id']);
          }
        }
    }


	function end_of_month() {
	    set_time_limit(0);
	    $endofmonths = $this->endofmonth_select();
        if(!empty($endofmonths)) {
          foreach($endofmonths as $endofmonth) {

            //--------------update cuti 
        	$this->db->select('b.nik, b.saldo_cuti, b.saldo_cutihutang, b.saldo_ph, b.employee_id');
        	$this->db->from('m_employee as b');
        	$this->db->where('b.kode_cabang',$endofmonth['kode_outlet']);
        	$query = $this->db->get();
            if($query->num_rows() > 0) {
                $datas = $query->result_array();
                foreach($datas as $data) {
                  $data['saldo_cuti'] = intval($data['saldo_cuti']) - $this->m_employee_absent->get_jumlah_cuti($data['employee_id'],$endofmonth['periode']);
                  $data['saldo_cutihutang'] = intval($data['saldo_cutihutang']) + $this->m_employee_absent->get_jumlah_cutihutang($data['employee_id'],$endofmonth['periode']);
                  $this->m_sinkron_mssql->t_employee_update_cuti($data);
                }
            }
            //--------------end update cuti 

        	$this->db->select('`a`.`absent_id`, `a`.`cabang`, `a`.`tanggal`, `a`.`nik`, `a`.`shift`, `a`.`kd_shift`, CAST(`a`.`shift_in` AS char(5)) AS `shift_in`, CAST(`a`.`shift_break_out` AS char(5)) AS `shift_break_out`, CAST(`a`.`shift_break_in` AS char(5)) AS `shift_break_in`, CAST(`a`.`shift_out` AS char(5)) AS `shift_out`, `a`.`kd_cuti`, `a`.`kd_aktual`, `a`.`kd_aktual_temp`, CAST(`a`.`in` AS char(5)) AS `in`, CAST(`a`.`break_out` AS char(5)) AS `break_out`, CAST(`a`.`break_in` AS char(5)) AS `break_in`, CAST(`a`.`out` AS char(5)) AS `out`, `a`.`terlambat`, `a`.`pulang_cepat`, `a`.`jam_kerja`, `a`.`data_type`, `a`.`on_process`, `a`.`eod_lock`');
        	$this->db->from('t_employee_absent as a');
        	$this->db->join('m_employee as b','a.nik = b.nik','inner');
        	$this->db->join('m_schedule_pembyaran as c','c.kode_grouppembayaran = b.kode_grouppembayaran AND a.tanggal BETWEEN c.mulai AND c.akhir','inner');
        	$this->db->where('b.kode_cabang',$endofmonth['kode_outlet']);
        	$this->db->where('a.data_type',1);
        	$this->db->where('c.period',$endofmonth['periode']);
        	$this->db->where('c.kode_grouppembayaran',$endofmonth['period_type']);

        	$query = $this->db->get();
//			echo $this->db->last_query();
//			die();
//			echo "\r\n";
//			echo "\r\n";

            if($query->num_rows() > 0) {
                $data = $query->result_array();

				foreach($data as $datapegawai => $value) {
					if (trim($data[$datapegawai]['kd_aktual'])!=''){
						$data[$datapegawai]['kd_aktual'] = $this->endofmonth_kode_absent_system($data[$datapegawai]['kd_aktual']);
					}

					if ($data[$datapegawai]['kd_aktual']=='TM') $data[$datapegawai]['ftransport']='TM';

					if ((trim($data[$datapegawai]['in'])=='') && (trim($data[$datapegawai]['break_out'])=='') && (trim($data[$datapegawai]['break_in'])=='') && (trim($data[$datapegawai]['out'])=='')){
						if (($this->endofmonth_check_absent($data[$datapegawai]['nik'],$data[$datapegawai]['tanggal'])) && (trim($data[$datapegawai]['kd_aktual'])=='') )
							$data[$datapegawai]['kd_aktual'] = 'A';
					}

					if (trim($data[$datapegawai]['kd_shift'])=='')
						$data[$datapegawai]['kode_schedule_import'] = '';
					elseif ($data[$datapegawai]['kd_shift']==0)
						$data[$datapegawai]['kode_schedule_import'] = 'O';
					else
						$data[$datapegawai]['kode_schedule_import'] = 'H';
				}
                $this->m_sinkron_mssql->t_kehadiran_insert($data);
            }

			$this->endofmonth_done($endofmonth['periode'],$endofmonth['kode_outlet'],$endofmonth['period_type']);
          }
        }

		$this->m_sync_attendance->eod_lock_all(0);
		//$sqlQuery = "CALL eom_lock();";
		//if ($this->db->query($sqlQuery)) echo 'EOM Lock Success'."\r\n";

    }

	function employee_update() {
	    set_time_limit(0);

 	    $outlets = $this->m_sinkron_mssql->outlet_select_all();
        if(!empty($outlets)) {
          $this->db->truncate('m_outlet_employee');
          foreach($outlets as $outlet) {
        	$this->db->from('m_outlet_employee');
        	$this->db->where('OUTLET',$outlet['kode_cabang']);

        	$query = $this->db->get();

            if($query->num_rows() == 0) {
              if (!empty($outlet['kode_cabang_induk'])) {
                $kode_cabang_induk = $outlet['kode_cabang_induk'];
              } else {
                $kode_cabang_induk = $outlet['kode_cabang'];
              }
              $data = array(
                'OUTLET'=>$outlet['kode_cabang'],
                'OUTLET_HC'=>$kode_cabang_induk,
                'STANDARD_EMPLOYEE'=>$outlet['standard_employee'],
                'CURRENT_EMPLOYEE'=>$outlet['current_employee'],
              );
              $this->db->insert('m_outlet_employee', $data);
            }
          }
        }

 	    $emp_statuss = $this->m_sinkron_mssql->emp_status_select_all();
        if(!empty($emp_statuss)) {
          $this->db->truncate('m_work_status');
          foreach($emp_statuss as $emp_status) {
        	$this->db->from('m_work_status');
        	$this->db->where('work_code',$emp_status['employeestatus_id']);

        	$query = $this->db->get();

            if($query->num_rows() == 0) {
              $data = array(
                'work_code'=>$emp_status['employeestatus_id'],
                'work_name'=>$emp_status['employeestatus_name'],
              );
              $this->db->insert('m_work_status', $data);
            }
          }
        }

 	    $divisions = $this->m_sinkron_mssql->divisi_select_all();
        if(!empty($divisions)) {
          $this->db->truncate('m_divisi');
          foreach($divisions as $division) {
        	$this->db->from('m_divisi');
        	$this->db->where('kode_divisi',$division['division']);

        	$query = $this->db->get();

            if($query->num_rows() == 0) {
              $data = array(
                'kode_divisi'=>$division['kode_divisi'],
                'nama_divisi'=>$division['nama_divisi'],
                'fwarning'=>$division['fwarning'],
              );
              $this->db->insert('m_divisi', $data);
            }
          }
        }

 	    $bagians = $this->m_sinkron_mssql->bagian_select_all();
        if(!empty($bagians)) {
          $this->db->truncate('m_bagian');
          foreach($bagians as $bagian) {
              $data = array(
                'kode_bagian'=>$bagian['kode_bagian'],
                'nama_bagian'=>$bagian['nama_bagian'],
                'kode_dept'=>$bagian['kode_dept'],
              );
              $this->db->insert('m_bagian', $data);
          }
        }

 	    $jabatans = $this->m_sinkron_mssql->jabatan_select_all();
        if(!empty($jabatans)) {
          $this->db->truncate('m_jabatan');
          foreach($jabatans as $jabatan) {
        	$this->db->from('m_jabatan');
              $data = array(
                'kode_job'=>$jabatan['kode_job'],
                'nama_job'=>$jabatan['nama_job'],
              );
              $this->db->insert('m_jabatan', $data);
          }
        }

 	    $depts = $this->m_sinkron_mssql->dept_select_all();
        if(!empty($depts)) {
          $this->db->truncate('m_dept');
          foreach($depts as $dept) {
              $data = array(
                'kode_dept'=>$dept['kode_dept'],
                'kode_divisi'=>$dept['kode_divisi'],
                'nama_dept'=>$dept['nama_dept'],
              );
              $this->db->insert('m_dept', $data);
          }
        }


 	    $emp_educations = $this->m_sinkron_mssql->emp_education_select_all();
        if(!empty($emp_educations)) {
          $this->db->truncate('m_education');
          foreach($emp_educations as $emp_education) {
        	$this->db->from('m_education');
        	$this->db->where('education_code',$emp_education['kode_pend']);

        	$query = $this->db->get();

            if($query->num_rows() == 0) {
              $data = array(
                'education_code'=>$emp_education['kode_pend'],
                'education_name'=>$emp_education['nama_pend'],
              );
              $this->db->insert('m_education', $data);
            }
          }
        }

 	    $m_kehadirans = $this->m_sinkron_mssql->m_kehadiran_select_all();
        if(!empty($m_kehadirans)) {
          foreach($m_kehadirans as $m_kehadiran) {
        	$this->db->from('m_absent_type');
        	$this->db->where('kode_absent',$m_kehadiran['KdCuti']);

        	$query = $this->db->get();

            $data = array(
              'kode_absent'=>$m_kehadiran['KdCuti'],
              'type_name'=>$m_kehadiran['Keterangan'],
              'kode_absent_system'=>$m_kehadiran['KdAbsen'],
            );

            if($query->num_rows() == 0) {
              $this->db->insert('m_absent_type', $data);
            } else {
         	  $this->_db->where('kode_absent',$m_kehadiran['KdCuti']);
              $this->_db->update('m_absent_type', $data);
            }
          }
        }

 	    $working_shifts = $this->m_sinkron_mssql->working_shift_select_all();
        if(!empty($working_shifts)) {
          // $this->db->truncate('m_shift');
          foreach($working_shifts as $working_shift) {
        	$this->db->from('m_shift');
        	$this->db->where('shift_code',intval($working_shift['Shift']));
        	$this->db->where('company_code',$working_shift['KdCabang']);

        	$query = $this->db->get();
			//echo $this->db->last_query();die();

			  $data = array(
				'shift_code'=>$working_shift['Shift'],
				'company_code'=>$working_shift['KdCabang'],
				'duty_on'=>$working_shift['DutyOn'],
				'duty_off'=>$working_shift['DutyOff'],
				'break_in'=>$working_shift['BreakIn'],
				'break_out'=>$working_shift['BreakOut'],
				'fdiff_date'=>$working_shift['fdifdate'],
			  );
            if($query->num_rows() == 0) {
				$this->_db->insert('m_shift', $data);
            } else {
				$this->_db->where('shift_code',intval($working_shift['Shift']));
				$this->_db->where('company_code',$working_shift['KdCabang']);
				$this->_db->update('m_shift', $data);
			}
          }
        }

 	    $schedule_pembayarans = $this->m_sinkron_mssql->m_schedule_pembayaran();
        if(!empty($schedule_pembayarans)) {
          $this->db->truncate('m_schedule_pembyaran');
          foreach($schedule_pembayarans as $schedule_pembayaran) {
        	$this->db->from('m_schedule_pembyaran');
        	$this->db->where('kode_grouppembayaran',$schedule_pembayaran['kode_grouppembayaran']);
        	$this->db->where('period',$schedule_pembayaran['period']);

        	$query = $this->db->get();

            if($query->num_rows() == 0) {

              if (!empty($schedule_pembayaran['komponentetap_dari']))
                  $tgl_mulai = $schedule_pembayaran['komponentetap_dari'];
              else
                  $tgl_mulai = '0000-00-00';

              if (!empty($schedule_pembayaran['komponentetap_sampai']))
                  $tgl_akhir = $schedule_pembayaran['komponentetap_sampai'];
              else
                  $tgl_akhir = '0000-00-00';

              $data = array(
                'kode_grouppembayaran'=>$schedule_pembayaran['kode_grouppembayaran'],
                'period'=>$schedule_pembayaran['period'],
                'mulai'=>$tgl_mulai,
                'akhir'=>$tgl_akhir,
                'status'=>$schedule_pembayaran['status'],
              );
              $this->db->insert('m_schedule_pembyaran', $data);
            }
          }
        }

 	    $employees = $this->m_sinkron_mssql->employee_select_all();
		//date_default_timezone_set('Asia/Jakarta');
        foreach($employees as $employee) {

			$tgl_masuk=$employee['tglmasuk'];
			$tgl_akhir=$employee['tglakhir'];
			if (($tgl_akhir=='2999-01-01') || ($tgl_akhir=='0000-00-00')) $tgl_akhir='0000-00-00';

//			if ($employee['nik']=='0111200057') echo $employee['nama'].': '."\r\nMASUK:".$tgl_masuk.'--KELUAR:'.$tgl_akhir."\r\nMASUKREAL:".$employee['tglmasuk'].'--KELUARREAL:'.$employee['tglakhir']."\r\n";


            if (!empty($employee['tglkeluar']))
                $tgl_keluar = $employee['tglkeluar'];
            else
                $tgl_keluar = '0000-00-00';
            $data = array(
              'nik'=>$employee['nik'],
              'nama'=>strtoupper($employee['nama']),
              'kode_cabang'=>strtoupper($employee['outlet']),
              'divisi'=>strtoupper($employee['divisi']),
              'department'=>strtoupper($employee['dept']),
              'bagian'=>strtoupper($employee['bagian']),
              'jabatan'=>strtoupper($employee['jabatan']),
              'golongan'=>strtoupper($employee['golongan']),
              'level'=>strtoupper($employee['kodelevel']),
              'status_kerja'=>$employee['statuskerja'],
              'tanggal_masuk'=>$tgl_masuk,
              'tanggal_akhir'=>$tgl_akhir,
              'tanggal_keluar'=>$tgl_keluar,
              'saldo_cuti'=>$employee['saldo_cuti'],
              'saldo_cutihutang'=>$employee['saldo_cutihutang'],
              'saldo_ph'=>$employee['saldo_ph'],
              'kelamin'=>$employee['kelamin'],
              'kode_divisi'=>$employee['kode_divisi'],
              'kode_bagian'=>$employee['kode_bagian'],
              'kode_job'=>$employee['kode_job'],
              'kode_dept'=>$employee['kode_dept'],
              'kartu_npwp'=>$employee['NPWP'],
              'tempat_lahir'=>$employee['TmpLahir'],
              'tanggal_lahir'=>$employee['TglLahir'],
              'nomor_hp'=>$employee['HandPhone'],
              'email_kantor'=>$employee['EmailPerusahaan'],
              'agama'=>strtoupper($employee['Agama']),
              'marital'=>strtoupper($employee['marital']),
              'kode_grouppembayaran'=>strtoupper($employee['kode_grouppembayaran']),
            );
        	$this->db->from('m_employee');
        	$this->db->where('nik',$employee['nik']);

        	$query = $this->db->get();
			
				//if ($employee['nik']=='0102400001') echo $employee['nik'].' == #'.$employee['NPWP'].'#'.$employee['nama']."#\r\n";

          if($query->num_rows() == 0) {
             if (!empty($employee['tglkeluar'])) {

             } else {
               if($this->db->insert('m_employee', $data))
                  $success = TRUE;
                else
                  $success = FALSE;
             }
          } else {
       	     $this->_db->where('nik', $data['nik']);
             if($this->_db->update('m_employee', $data))
                $success = TRUE;
              else
                $success = FALSE;
          }
          if ($success) {
        	$this->db->from('m_fp');
        	$this->db->where('fnik',$employee['nik']);
        	$this->db->where('kode_cabang',$employee['outlet']);
        	$query = $this->db->get();
            if($query->num_rows() == 0) {
                $data = array(
                  'fnik'=>$employee['nik'],
                  'kode_cabang'=>strtoupper($employee['outlet']),
                  'fingerprint_id'=>'0',
                );
               if($this->db->insert('m_fp', $data))
                  $success = TRUE;
                else
                  $success = FALSE;
            } else
                $success = TRUE;
          }

        }
		
		$updateplantquery = 'update `m_employee` set `plant`= (select `outlet` from `m_outlet` where `hr_code`=`kode_cabang` limit 0,1);';
		$this->db->query($updateplantquery);

		//update fingerprint ID - 20140416
		$updatefingerquery = "UPDATE `m_fp` AS `a` INNER JOIN `m_employee` AS `b` ON `a`.`fnik` = `b`.`nik` SET `a`.`fingerprint_id` =0 WHERE `b`.`tanggal_keluar` <>  '0000-00-00' AND `a`.`fingerprint_id` <>0;";
		$this->db->query($updatefingerquery);
		
 	    $m_cuti_phs = $this->m_sinkron_mssql->m_cuti_ph_select_all();
        if(!empty($m_cuti_phs)) {
          foreach($m_cuti_phs as $m_cuti_ph) {
            $employee_id = $this->m_employee->employee_select_all_by_nik($m_cuti_ph['nik'],'employee_id');
        	$this->db->from('m_cuti_ph');
        	$this->db->where('employee_id',$employee_id);
        	$this->db->where('tanggal_ph',$m_cuti_ph['tanggal_ph']);

        	$query = $this->db->get();


            if($query->num_rows() == 0) {
              $data = array(
                'employee_id'=>$employee_id,
                'tanggal_ph'=>$m_cuti_ph['tanggal_ph'],
                'keterangan'=>$m_cuti_ph['keterangan'],
                'tanggal_exp_ph'=>$m_cuti_ph['tanggal_exp_ph'],
                'status'=>$m_cuti_ph['status'],
              );
              $this->db->insert('m_cuti_ph', $data);
            } else {
              $data = array(
                'status'=>$m_cuti_ph['status'],
              );
        	  $this->db->where('employee_id',$employee_id);
        	  $this->db->where('tanggal_ph',$m_cuti_ph['tanggal_ph']);
        	  $this->db->where('status <> ',1); //sudah ambil
        	  $this->db->where('status <> ',2); //sudah expired
        	  $this->db->where('status <> ',3); //join lebih kecil tanggalnya
              $this->db->update('m_cuti_ph', $data);
            }
          }
        }

        return $success;

    }

	function posisis_select_all() {
		$this->_db->from('t_posisi');
		$this->_db->order_by('id_posisi');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function posisi_select($id) {
		$this->_db->from('t_posisi');
		$this->_db->order_by('id_posisi');
		$this->_db->where('id_posisi', $id);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function endofmonth_select() {
	    //$period = date('Ym');
		$this->_db->select('periode,kode_outlet,period_type');
		$this->_db->from('d_endofmonth');
		$this->_db->where('eom_status', 0);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function endofmonth_kode_absent_system($kode_absent) {
	    //$period = date('Ym');
		$this->_db->select('kode_absent_system');
		$this->_db->from('m_absent_type');
		$this->_db->where('kode_absent',$kode_absent);

		$query = $this->_db->get();

		if($query->num_rows() > 0){
			$hasil = $query->result_array();
			return $hasil[0]['kode_absent_system'];
		} else
			return $kode_absent;
	}

	function endofmonth_check_absent($nik,$shift_date) {
	    //$period = date('Ym');
		$this->_db->select('shift_date');
		$this->_db->from('d_employee_shift as a');
		$this->_db->from('m_employee as b');
		$this->_db->where('a.shift_emp_id = b.employee_id ');
		$this->_db->where('b.nik',$nik);
		$this->_db->where('a.shift_date',$shift_date);

		$query = $this->_db->get();

		if($query->num_rows() > 0){
			$hasil = $query->result_array();
			if (trim($hasil[0]['shift_date'])!='')
				return true;
			else
				return false;
		} else
			return false;
	}

	function endofmonth_done($periode,$kode_outlet,$period_type) {
		$swbquery1 = "UPDATE `d_endofmonth` SET `eom_status`=1 WHERE `periode` = '".$periode."' AND `kode_outlet` = '".$kode_outlet."' AND `period_type` = '".$period_type."'  ;";
		$this->db->query($swbquery1);
	}

	function posisi_add($data) {
		if($this->_db->insert('t_posisi', $data))
			return $this->_db->insert_id();
		else
			return FALSE;
	}

	function posisi_update($data) {
		$this->_db->where('id_posisi', $data['id_posisi']);
		if($this->_db->update('t_posisi', $data))
			return TRUE;
		else
			return FALSE;
	}

}