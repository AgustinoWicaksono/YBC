<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class L_upload_absent
{

	function L_upload_absent() {
		$this->obj =& get_instance();

		$this->obj->load->model('m_upload_absent');
		$this->obj->load->model('m_employee');
		$this->obj->load->model('m_employee_shift');
		$this->obj->load->library('l_general');

	}

	function condition_normal($absent, $data) {
        /*
		$count = count($data);

		// menentukan waktu datang
		$absent['in'] = $data[1]['waktu'];

		// menentukan waktu break keluar
		$i = 1;
		foreach($data as $a) {
			if($i == 1) {
				$i++;
				continue;
  		} else if($a['status_absen'] == '1') {
				$i++;
				continue;
			} else {
				$absent['break_out'] = $a['waktu'];
				$current2 = $i;
				break;
			}
		}

		if(empty($absent['break_out'])) {
			$current2 = 1;
      $absent['break_out'] = '';
		}

		if($absent['break_out'] != '') {
			// menentukan waktu break masuk
			for($i = $current2+1; $i <= $count; $i++) {
				if($data[$i]['status_absen'] == '1') {
					$absent['break_in'] = $data[$i]['waktu'];
					$current3 = $i;
					break;
				} else {
					continue;
				}
			}
		}

		if(empty($absent['break_in'])) {
			$current3 = $current2;
			$absent['break_in'] = '';
		}

		// menentukan waktu pulang
		for($i = $count; $i >= $current3+1; $i--) {
			if($data[$i]['status_absen'] == '1') {
				continue;
			} else {
      	$absent['out'] = $data[$i]['waktu'];
			}
		}

		if(empty($absent['out'])) {
      $absent['out'] = '';
		}
         */
        $tanggal = date('Y-m-d', strtotime($absent['tanggal']));
        $absent_tmp = $this->obj->m_upload_absent->upload_absent_get_absent($absent['cabang'], $data[1]['finger_print'], $tanggal);
/*		if (($absent['cabang']=='JCO TCY') && ($data[1]['finger_print']==88)){
			echo "\r\nupload_absent_get_absent:\r\n";
			print_r($absent_tmp);
			echo "\r\n";
		}
*/
        $absent['in'] = $absent_tmp['in'];
        $absent['break_out'] = $absent_tmp['break_out'];
        $absent['break_in'] = $absent_tmp['break_in'];
        $absent['out'] = $absent_tmp['out'];

    	if(empty($absent['in'])) {
  	      $absent['in'] = '';
    	}
    	if(empty($absent['break_out'])) {
  	      $absent['break_out'] = '';
    	}
    	if(empty($absent['break_in'])) {
  	      $absent['break_in'] = '';
    	}
    	if(empty($absent['out'])) {
  	      $absent['out'] = '';
    	}

    	if(($absent['break_out'] != '00:00:00')&&($absent['out'] == '00:00:00')&&($absent['break_in'] == '00:00:00')) {
           $absent['out'] = $absent['break_out'];
           unset($absent['break_out']);
    	}
    	if(($absent['break_out'] != '')&&($absent['out'] == '')&&($absent['break_in'] == '')) {
           $absent['out'] = $absent['break_out'];
           unset($absent['break_out']);
    	}
    	if(($absent['break_in'] != '00:00:00')&&($absent['in'] != '00:00:00')&&($absent['in'] == $absent['break_in'])) {
           unset($absent['break_in']);
    	}
    	if(($absent['break_in'] != '')&&($absent['in'] != '')&&($absent['in'] == $absent['break_in'])) {
           unset($absent['break_in']);
    	}
    	if($absent['break_in'] < $absent['break_out']) {
           unset($absent['break_in']);
    	}

/*		if (($absent['cabang']=='JCO TCY') && ($data[1]['finger_print']==88)){
			echo "\r\nNORMAL:\r\n";
			print_r($absent);
			echo "\r\n";
		}
*/
		return $absent;

	}

	function condition_abnomal($absent, $data) {
        /*
		$count = count($data);
        $kemarin = date('Y-m-d', strtotime($absent['tanggal']) - 86400);
		$yesterdays = $this->obj->m_upload_absent->upload_absent_datas_select($kemarin, $absent['cabang'], $data[1]['finger_print']);

		$temp['tanggal'] = $kemarin;
		$temp['cabang'] = $absent['cabang'];
		$temp['nik'] = $absen['nik'];

		$yesterday = $this->obj->m_upload_absent->employee_absent_select($temp);

		// ada schedule shift
		if($this->check_schedule_shift($absent)) {

			// menentukan waktu datang
			if($data[1]['waktu'] > $absent['shift_in']) {
				$absent['in'] = '';
			} else if($data[1]['waktu'] <= $absent['shift_in']) {
				if($yesterdays || $yesterday) { // jika hari kemarin ADA datanya

					$i = 1;
					foreach($data as $a) {
						if($i == 1) {
							$i++;
							continue;
			  		} else if($a['status_absen'] == '1') {
							$absent['in'] = $a['waktu'];
							$current1 = $i;
							break;
						} else {
							$i++;
							continue;
						}
					}
				} else { // jika hari kemarin TIDAK ada datanya
					$absent['in'] = $data[1]['waktu'];
				}
			}

			if(empty($absent['in'])){
				$current1 = 1;
				$absent['in'] = '';
			}

			// menentukan waktu break keluar
			if($absent['in'] == '') {
				$absent['break_out'] = $data[1]['waktu'];
				$current2 = 1;
			} else {
				for($i = $current1+1; $i <= $count; $i++) {
					if($data[$i]['status_absen'] == '1') {
						continue;
					} else {
						$absent['break_out'] = $data[$i]['waktu'];
						$current2 = $i;
						break;
					}
				}
			}

			if(empty($absent['break_out'])){
				$current2 = $current1;
				$absent['break_out'] = '';
			}

			if($absent['break_out'] != '') {
				// menentukan waktu break masuk
				for($i = $current2+1; $i <= $count; $i++) {
					if($data[$i]['status_absen'] == '1') {
						$absent['break_in'] = $data[$i]['waktu'];
						$current3 = $i;
						break;
					} else {
						continue;
					}
				}
			}

			if(empty($absent['break_in'])) {
				$current3 = $current2;
	            $absent['break_in'] = '';
			}

			// menentukan waktu pulang
			for($i = $count; $i >= $current3+1; $i--) {
				if($data[$i]['status_absen'] == '1') {
					continue;
				} else {
	      	$absent['out'] = $data[$i]['waktu'];
				}
			}

			if(empty($absent['out'])) {
    	      $absent['out'] = '';
			}

		// tidak ada schedule shift
		} else {

			// menentukan waktu datang
			if($yesterdays) { // jika hari kemarin ADA datanya
				$i = 1;
				foreach($data as $a) {

					if($i == 1) {
						$i++;
						continue;
		  		} else if($a['status_absen'] == '1') {
						$absent['in'] = $a['waktu'];
						$current1 = $i;
						break;
					} else {
						$i++;
						continue;
					}
				}
			} else { // jika hari kemarin TIDAK ada datanya
				$absent['in'] = '';
			}

			if(empty($absent['in'])){
				$current1 = 1;
				$absent['in'] = '';
			}

			// menentukan waktu break keluar
			if($absent['in'] == '') {
				$absent['break_out'] = $data[1]['waktu'];
				$current2 = 1;
			} else {
				for($i = $current1+1; $i <= $count; $i++) {
					if($data[$i]['status_absen'] == '1') {
						continue;
					} else {
						$absent['break_out'] = $data[$i]['waktu'];
						$current2 = $i;
						break;
					}
				}
			}

			if(empty($absent['break_out'])){
				$current2 = $current1;
				$absent['break_out'] = '';
			}

			if($absent['break_out'] != '') {
				// menentukan waktu break masuk
				for($i = $current2+1; $i <= $count; $i++) {
					if($data[$i]['status_absen'] == '1') {
						$absent['break_in'] = $data[$i]['waktu'];
						$current3 = $i;
						break;
					} else {
						continue;
					}
				}
			}

			if(empty($absent['break_in'])) {
				$current3 = $current2;
      	        $absent['break_in'] = '';
			}

			// menentukan waktu pulang
			for($i = $count; $i >= $current3+1; $i--) {
				if($data[$i]['status_absen'] == '1') {
					continue;
				} else {
        	      	$absent['out'] = $data[$i]['waktu'];
				}
			}

			if(empty($absent['out'])) {
    	      $absent['out'] = '';
			}

		}
    	if(($absent['break_out'] != '')&&($absent['out'] == '')&&($absent['break_in'] == '')) {
           $absent['out'] = $absent['break_out'];
           $absent['break_out'] = '';
    	}
        */
        $tanggal = date('Y-m-d', strtotime($absent['tanggal']));
		if($this->check_schedule_shift($absent)) {
          $absent_tmp = $this->obj->m_upload_absent->upload_absent_get_absent_w_shift($absent['cabang'], $data[1]['finger_print'], $tanggal);

			//20130617-Edo: Jadi TL namun angka nya tidak tampil di report, diperbaiki dengan cek raw data.
			if ( ($absent_tmp['in']=='') && ($absent_tmp['break_out']=='') && ($absent_tmp['break_in']=='') && ($absent_tmp['out']=='') ){
			  $absent_tmp = $this->obj->m_upload_absent->upload_absent_get_absent($absent['cabang'], $data[1]['finger_print'], $tanggal);
			}
			//20130617-Edo: Jadi TL namun angka nya tidak tampil di report, diperbaiki dengan cek raw data.
		} else {
          $absent_tmp = $this->obj->m_upload_absent->upload_absent_get_absent($absent['cabang'], $data[1]['finger_print'], $tanggal);
        }


        $absent['in'] = $absent_tmp['in'];
        $absent['break_out'] = $absent_tmp['break_out'];
        $absent['break_in'] = $absent_tmp['break_in'];
        $absent['out'] = $absent_tmp['out'];



    	if(empty($absent['in'])) {
  	      $absent['in'] = '';
    	}
    	if(empty($absent['break_out'])) {
  	      $absent['break_out'] = '';
    	}
    	if(empty($absent['break_in'])) {
  	      $absent['break_in'] = '';
    	}
    	if(empty($absent['out'])) {
  	      $absent['out'] = '';
    	}

    	if(($absent['break_out'] != '00:00:00')&&($absent['out'] == '00:00:00')&&($absent['break_in'] == '00:00:00')) {
           $absent['out'] = $absent['break_out'];
           unset($absent['break_out']);
    	}
    	if(($absent['break_out'] != '')&&($absent['out'] == '')&&($absent['break_in'] == '')) {
           $absent['out'] = $absent['break_out'];
           unset($absent['break_out']);
    	}
    	if(($absent['break_in'] != '00:00:00')&&($absent['in'] != '00:00:00')&&($absent['in'] == $absent['break_in'])) {
           unset($absent['break_in']);
    	}
    	if(($absent['break_in'] != '')&&($absent['in'] != '')&&($absent['in'] == $absent['break_in'])) {
           unset($absent['break_in']);
    	}
    	if($absent['break_in'] < $absent['break_out']) {
           unset($absent['break_in']);
    	}


		return $absent;
	}

	function get_aktual($absent,$mod=FALSE) {

		// agar strtotime() bernilai 0
		$date_default_timezone = date_default_timezone_get();
		date_default_timezone_set("UTC");

			//20130617-Edo: Angka jadi salah , krn tadinya copy-paste shift_in semua
		$shift_in = strtotime('1970-01-01 '.$absent['shift_in']);
		$shift_break_out = strtotime('1970-01-01 '.$absent['shift_break_out']);
		$shift_break_in = strtotime('1970-01-01 '.$absent['shift_break_in']);
		$shift_out = strtotime('1970-01-01 '.$absent['shift_out']);
			//20130617-Edo: Angka jadi salah , krn tadinya copy-paste shift_in semua

		$in = strtotime('1970-01-01 '.$absent['in']);
		$break_out = strtotime('1970-01-01 '.$absent['break_out']);
		$break_in = strtotime('1970-01-01 '.$absent['break_in']);
		$out = strtotime('1970-01-01 '.$absent['out']);
		// ada schedule shift
		if($this->check_schedule_shift($absent)) {

			if( empty($in) || empty($out) )
   				$aktual = 'TL';
			else {
			//20130617-Edo: TC ditaruh di atas, krn tdk akan pernah dicek jika di baris ketiga
    			if( ($in > $shift_in) && ($out < $shift_out) )
    				$aktual = 'TC';
    			else if($in > $shift_in)
    				$aktual = 'DT';
    			else if($out < $shift_out)
    				$aktual = 'PC';
    			else if( ($in <= $shift_in) && ($out >= $shift_out) ) {
    				$aktual = 'H';
        			if(( ($out - $in) >= (12 * 60 * 60) )&&( ($out >= (23 * 60 * 60)) && ($in <= (11 * 60 * 60)) ) &&($mod==TRUE))
        				$aktual = 'LS';
    	    		else if( ($out >= (23 * 60 * 60)) || ($out <= (6 * 60 * 60)) )
    		    		$aktual = 'TM';
    	    		else if( ($in >= (23 * 60 * 60)) || ($in <= (6 * 60 * 60)) )
    		    		$aktual = 'TM';
                }
            }
			// kode LS1, LM dan O belum ada karena belum tahu maksudnya

		} else {
			// tidak ada schedule shift

			if( empty($in) || empty($out) )
   				$aktual = 'TL';
			else {
    			if( ($out - $in) < ((8 * 60 * 60)-60) )
    				$aktual = 'DT';
    			else if( ($out - $in) >= (8 * 60 * 60) ) {
    				$aktual = 'H';
        			if(( ($out - $in) >= (12 * 60 * 60) )&&( ($out >= (23 * 60 * 60)) && ($in <= (11 * 60 * 60)) )&&($mod==TRUE))
        				$aktual = 'LS';
    	    		else if( ($out >= (23 * 60 * 60)) || ($out <= (6 * 60 * 60)) )
    		    		$aktual = 'TM';
    	    		else if( ($in >= (23 * 60 * 60)) || ($in <= (6 * 60 * 60)) )
    		    		$aktual = 'TM';
                }
            }
			// kode LS1, LM dan O belum ada karena belum tahu maksudnya

		}

		// kembalikan setting awal
		date_default_timezone_set($date_default_timezone);

		return $aktual;
	}

	function check_schedule_shift($absent) {
		if($absent['shift_in'] != '00:00:00' || $absent['shift_break_out'] != '00:00:00' || $absent['shift_break_in'] != '00:00:00' || $absent['shift_in'] != '00:00:00') {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    function proses_absen($cabang,$date,$fp) {

        $employee = $this->obj->m_employee->employee_select_by_fp_cabang($fp, $cabang);

        $absent_data['tanggal'] = $date;
        $absent_data['cabang'] = $cabang;
        $absent_data['nik'] = $employee['nik'];
        $kode_aktual = '';
      	$absent['cabang'] = $cabang;
      	$absent['tanggal'] = $date;
      	$absent['nik'] = $employee['nik'];
        if($absent_e = $this->obj->m_upload_absent->employee_absent_select($absent_data)) {
            $kode_aktual = $absent_e['kd_aktual'];
        } else {
    		$absent['kd_aktual'] = 'A';
    		$absent['kd_aktual_temp'] = 'A';
        }
        if($shift = $this->obj->m_employee_shift->shift_emp_select($absent)) {
        	$absent['shift'] = $shift['shift_code'];
        	$absent['kd_shift'] = $shift['shift_code'];
        	$absent['shift_in'] = $shift['duty_on'];
        	$absent['shift_break_out'] = $shift['break_out'];
        	$absent['shift_break_in'] = $shift['break_in'];
        	$absent['shift_out'] = $shift['duty_off'];
        } else {
        	$absent['shift'] = '';
        	$absent['kd_shift'] = '';
        	$absent['shift_in'] = '00:00:00';
        	$absent['shift_break_out'] = '00:00:00';
        	$absent['shift_break_in'] = '00:00:00';
        	$absent['shift_out'] = '00:00:00';
        }

        $datas = $this->obj->m_upload_absent->upload_absent_datas_select($date, $cabang, $fp);
        $object['status'] = '';
		$data_id_raw_absen = ''; // 20130603 by Edo

        if($datas === FALSE) {

        	$object['status'] = "Data untuk cabang ".$cabang." tidak ada";

        } else {

        	$i = 1;
        	foreach($datas->result_array() as $s) {
        		$data[$i++] = $s;
				if (intval($s['id'])!=0) $data_id_raw_absen .= intval($s['id']).','; // 20130603 by Edo
        	}
			$data_id_raw_absen .= '#';// 20130603 by Edo
			$data_id_raw_absen = str_replace(',#','',$data_id_raw_absen);// 20130603 by Edo
			$data_id_raw_absen = str_replace('#','',$data_id_raw_absen);// 20130603 by Edo
			$this->obj->m_upload_absent->update_status_proses_absen($data_id_raw_absen); // 20130603 by Edo  --> Update field 'status_process' di raw tabel t_upload_absent

/*		if (($cabang=='JCO TCY') && ($fp==88)){
			echo "\r\nABSENT#1";
			print_r($absent);
			echo "\r\n";
		}
*/
        	if($data[1]['status_absen'] == 1) {
/*		if (($cabang=='JCO TCY') && ($fp==88)){
			echo "\r\nCOND_NORM\r\n";
		}
*/
        		$absent = $this->condition_normal($absent, $data);

        	} else {
/*		if (($cabang=='JCO TCY') && ($fp==88)){
			echo "\r\nCOND_ABNORM\r\n";
		}
*/
        		$absent = $this->condition_abnomal($absent, $data);

        	}

/*		if (($cabang=='JCO TCY') && ($fp==88)){
			echo "\r\nABSENT#2";
			print_r($absent);
			echo "\r\n";
		}
*/
            if ($this->obj->m_upload_absent->cek_kdaktual_izin($kode_aktual)==FALSE) {
                if ($employee['bagian'] == 'MANAGER ON DUTY') {
                    $mod = TRUE;
                } else {
                    $mod = FALSE;
                }
            	$absent['kd_aktual'] = $this->get_aktual($absent,$mod);
                $absent['kd_aktual_temp'] = $absent['kd_aktual'];
            }

			//20130617-Edo: Tadinya tidak diproses jika MOD dan ditambah set NULL
			if ($absent['in']=='') { $absent['in']=NULL;unset($absent['in']); }
			if ($absent['break_out']=='') { $absent['break_out']=NULL;unset($absent['break_out']); }
			if ($absent['break_in']=='') { $absent['break_in']=NULL;unset($absent['break_in']); }
			if ($absent['out']=='') { $absent['out']=NULL;unset($absent['out']); }
	if (( (($cabang=='SX BT&JCO') && ($fp==537)) || (($cabang=='BT XCS') && ($fp==5)) || (($cabang=='BT PGC') && ($fp==99)) ) && (($tanggal='2013-06-13') || ($tanggal='2013-06-14'))) {
			echo $cabang.'--'.$fp.'--'.$tanggal."\r\n";
			echo "\r\nUPDATE DB:\r\n";
			print_r($absent);
			echo "\r\n";
		}
            $this->obj->m_upload_absent->employee_absent_add_update($absent);
			$object['status'] = "OK";

        	unset($data);
        } // if($datas === FALSE) {

/*		if (($cabang=='JCO TCY') && ($fp==88)){
			echo "\r\nFINAL!";
			print_r($absent);
			echo "\r\n";
		}
*/

        unset($absent);

        return $object['status'];
    }

    function proses_absen_by_fp($cabang,$fp) {
		$dates = $this->obj->m_upload_absent->upload_absent_dates_select_by_fp($fp,$cabang);

		if($dates === FALSE) {

			$object['status'] = "Data untuk cabang ".$cabang." di database temporary tidak ada";

		} else {
			foreach($dates->result_array() as $d) {
			  $date = $d['tanggal'];
          	  $object['status'] = $this->proses_absen($cabang,$date,$fp);
			} // if($fps === FALSE) {

			$object['status'] = "OK";

		} // 	if($cabangs === FALSE) {

    }

    function sinkron_absen() {
        $date_counter = 1;
		$date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        while ($date_counter < 40) {

			$jumlahdata = 0;
            $cabangs = $this->obj->m_upload_absent->upload_absent_cabangs_select($date);

			if($cabangs === FALSE) { // 20130603 by Edo
				echo "NO DATA: ".$date." \r\n";  // 20130603 by Edo
			} else { // 20130603 by Edo
				foreach($cabangs->result_array() as $c) {
					$cabang = $c['kode_cabang'];
					$fps = $this->obj->m_upload_absent->upload_absent_fps_select($date,$cabang);
					if($fps !== FALSE) {
						foreach($fps->result_array() as $f) {
						  $fp = $f['finger_print'];
						  $hasil = $this->proses_absen($cabang,$date,$fp);

						  if ($hasil == 'OK') $jumlahdata++;  // 20130603 by Edo

						}
					}
				}
				echo "SUKSES: ".$date." : ".$jumlahdata." orang \r\n"; // 20130603 by Edo
			}
            $date = $this->obj->l_general->date_add_day_ymd($date,-1);
            $date_counter++;
        }
    }

}

/* End of file L_upload_absent.php */
/* Location: ./system/application/libraries/L_upload_absent.php */
