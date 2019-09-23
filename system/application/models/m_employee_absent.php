<?php
class M_employee_absent extends Model {

	function M_employee_absent() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}

	function type_codes_select_all() {
		$this->db->from('m_absent_type');
		$this->db->where('type_active', '1');
		$this->db->order_by('type_name', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function type_name_select($id) {
		$this->db->from('m_absent_type');
//		$this->db->where('type_code', $id);
		$this->db->where('kode_absent', $id);
		$this->db->where('type_active', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$data = $query->row_array();
			return $data['type_name'];
		} else {
			return FALSE;
		}
	}

	function employee_absent_select($id) {
		$this->db->from('d_employee_absent');
		$this->db->where('absent_id', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}


    function cek_cuti_ph_exists($absent_id,$data) {
	    $cuti_ph = array('CPH', 'PH');
		$this->db->from('d_employee_absent');
		$this->db->where('absent_emp_id', $data['absent_emp_id']);
		$this->db->where('absent_id <> ', $absent_id);
		$this->db->where('absent_date', $data['absent_date']);
		$this->db->where_in('absent_type', $cuti_ph);

		$query = $this->db->get();
        //echo $this->db->last_query();
        //echo ' jmulah '.$query->num_rows();
        //exit;
		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

    function cek_cuti_exists($data) {
		$this->db->from('d_employee_absent');
		$this->db->where('absent_emp_id', $data['absent_emp_id']);
		$this->db->where('absent_date', $data['absent_date']);

		$query = $this->db->get();
        //echo $this->db->last_query();
        //echo ' jmulah '.$query->num_rows();
        //exit;
		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function employee_absent_select_by_nik($data) {

		$this->db->from('d_employee_absent');
		$this->db->where('absent_id', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function employee_absent_add($data) {
		if($this->db->insert('d_employee_absent', $data)) {
		    $insert_id = $this->db->insert_id();
        $this->t_employee_absent_add_update($data);
			return $insert_id;
		} else
			return FALSE;
	}

	function get_jumlah_cuti($absent_emp_id,$periode_eom='') {
		$sqlQuery = "SELECT max(akhir) as `tanggal` FROM m_employee a inner join d_endofmonth b on a.kode_grouppembayaran=b.period_type AND a.kode_cabang=b.kode_outlet inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran and c.period=b.periode where employee_id=".$absent_emp_id." and eom_status=1";

		$query = $this->db->query($sqlQuery);
        $jumlah_cuti = 0;
		if($query->num_rows() > 0) {
			$hasilq = $query->row_array();
            if (!empty($hasilq['tanggal'])) {
    			$tglakhireom = $hasilq['tanggal'];

                $this->db->select('count(absent_id) as jumlah_cuti');
        		$this->db->from('d_employee_absent');
        		$this->db->where('absent_emp_id', $absent_emp_id);
        		$this->db->where('absent_type', 'AL');
        		$this->db->where('absent_date >', $tglakhireom);
                if(!empty($periode_eom)) {
            		$sqlQuery = "SELECT akhir FROM m_employee a inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran where c.period = '".$periode_eom."' and employee_id = ".$absent_emp_id;
            		$query1 = $this->db->query($sqlQuery);
           			$hasilq = $query1->row_array();
                    $tgl_akhir = $hasilq['akhir'];
                    if (!empty($tgl_akhir)) {
                		$this->db->where('absent_date <=', $tgl_akhir);
                    }
                }
        		$query = $this->db->get();
        		if($query->num_rows() > 0){
       	    	    $data = $query->row_array();
                    //echo "<pre>";
                    //print_r($data);
                    //echo "</pre>";
                    //exit;
                    if (!empty($data['jumlah_cuti']))
        	          	$jumlah_cuti = $data['jumlah_cuti'];
                    else
                       $jumlah_cuti = 0;
                }
            }
		}
        return $jumlah_cuti;

    }

	function get_jumlah_cutihutang($absent_emp_id,$periode_eom='') {
		$sqlQuery = "SELECT max(akhir) as `tanggal` FROM m_employee a inner join d_endofmonth b on a.kode_grouppembayaran=b.period_type AND a.kode_cabang=b.kode_outlet inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran and c.period=b.periode where employee_id=".$absent_emp_id." and eom_status=1";

		$query = $this->db->query($sqlQuery);
        $jumlah_cuti = 0;
		if($query->num_rows() > 0) {
			$hasilq = $query->row_array();
            if (!empty($hasilq['tanggal'])) {
    			$tglakhireom = $hasilq['tanggal'];

                $this->db->select('count(absent_id) as jumlah_cuti');
        		$this->db->from('d_employee_absent');
        		$this->db->where('absent_emp_id', $absent_emp_id);
        		$this->db->where('absent_type', 'CH');
        		$this->db->where('absent_date >', $tglakhireom);
                if(!empty($periode_eom)) {
            		$sqlQuery = "SELECT akhir FROM m_employee a inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran where c.period = '".$periode_eom."' and employee_id = ".$absent_emp_id;
            		$query1 = $this->db->query($sqlQuery);
           			$hasilq = $query1->row_array();
                    $tgl_akhir = $hasilq['akhir'];
                    if (!empty($tgl_akhir)) {
                		$this->db->where('absent_date <=', $tgl_akhir);
                    }
                }
        		$query = $this->db->get();
				
        		if($query->num_rows() > 0){
       	    	    $data = $query->row_array();
                    //echo "<pre>";
                    //print_r($data);
                    //echo "</pre>";
                    //exit;
                    if (!empty($data['jumlah_cuti']))
        	          	$jumlah_cuti = $data['jumlah_cuti'];
                    else
                       $jumlah_cuti = 0;
                }
            }
		}
        return $jumlah_cuti;

    }
	
	function update_jumlah_cuti_ph($absent_emp_id,$status=0) {
        $tglsekarang = date('Y-m-d');

        if ($status == 2) {
            $this->db->select('MIN(tanggal_ph) as tanggal_ph');
    		$this->db->from('m_cuti_ph');
    		$this->db->where('employee_id', $absent_emp_id);
    		$this->db->where('status', 0);
    		$this->db->where('tanggal_ph <', $tglsekarang);
    		$this->db->where('tanggal_exp_ph >', $tglsekarang);

    		$query = $this->db->get();
    		if($query->num_rows() > 0){
        	    $data = $query->row_array();
             	$tanggal_ph = $data['tanggal_ph'];
             }

         	$sqlQuery = "UPDATE m_cuti_ph SET status = ".$status." WHERE employee_id = ".$absent_emp_id."
                         AND tanggal_ph = '".$tanggal_ph."'";
        } else {

            $this->db->select('MAX(tanggal_ph) as tanggal_ph');
    		$this->db->from('m_cuti_ph');
    		$this->db->where('employee_id', $absent_emp_id);
    		$this->db->where('status', 2);

    		$query = $this->db->get();
    		if($query->num_rows() > 0){
        	    $data = $query->row_array();
             	$tanggal_ph = $data['tanggal_ph'];
             }

         	$sqlQuery = "UPDATE m_cuti_ph SET status = ".$status." WHERE employee_id = ".$absent_emp_id."
                     AND tanggal_ph = '".$tanggal_ph."'";
        }

    	$this->db->query($sqlQuery);
	}

	function get_jumlah_cuti_ph($absent_emp_id) {
        $tglsekarang = date('Y-m-d');

        $this->db->select('count(tanggal_ph) as jumlah_cuti');
		$this->db->from('m_cuti_ph');
		$this->db->where('employee_id', $absent_emp_id);
		$this->db->where('tanggal_ph <', $tglsekarang);
		$this->db->where('tanggal_exp_ph >', $tglsekarang);
		$this->db->where('status', 0);

		$query = $this->db->get();
        $jumlah_cuti = 0;
		if($query->num_rows() > 0){
    	    $data = $query->row_array();
            //echo "<pre>";
            //print_r($data);
            //echo "</pre>";
            //exit;
       	$jumlah_cuti = $data['jumlah_cuti'];
        }
        return $jumlah_cuti;

    }

	function employee_absent_check_eom($tgl,$absent_emp_id) {
		$hasil = false;
		$tgldata = strtotime($tgl);

		$sqlQuery = "SELECT max(akhir) as `tanggal` FROM m_employee a inner join d_endofmonth b on a.kode_grouppembayaran=b.period_type AND a.kode_cabang=b.kode_outlet inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran and c.period=b.periode where employee_id=".$absent_emp_id." and eom_status=1";

		$query = $this->db->query($sqlQuery);



		if($query->num_rows() > 0){
			$hasilq = $query->result_array();
			$tglakhireom = strtotime($hasilq[0]['tanggal']);

			if ($tglakhireom<$tgldata) $hasil = true; else $hasil = false;
		} else {
			$hasil = true;
		}

		return $hasil;
	}


	function employee_absent_add_update($data) {
	//print_r($data); die('<hr />');

		$this->db->from('d_employee_absent');
		$this->db->where('absent_emp_id', $data['absent_emp_id']);
		$this->db->where('absent_date', $data['absent_date']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$old_data = $query->row_array();
			

			$this->db->where('absent_emp_id', $data['absent_emp_id']);
			$this->db->where('absent_date', $data['absent_date']);
			$this->db->where('absent_eod_lock', 0);

			if($this->db->delete('d_employee_absent')) {

				if (($old_data['absent_type']=='PH') || ($old_data['absent_type']=='CPH')){
					$this->m_employee_absent->update_jumlah_cuti_ph($data['absent_emp_id']);
				}
                
				if($absent_id = $this->employee_absent_add($data)) {
					/* if (($data['absent_type']=='PH') || ($data['absent_type']=='CPH')){
						$this->m_employee_absent->update_jumlah_cuti_ph($data['absent_emp_id'],2);
					}
					*/
					return $absent_id;
					
				} else {
					return FALSE;
				}

			} else {
				return FALSE;
			}

		} else {

			if($absent_id = $this->employee_absent_add($data)) {
				/*if (($data['absent_type']=='PH') || ($data['absent_type']=='CPH')){
					$this->m_employee_absent->update_jumlah_cuti_ph($data['absent_emp_id'],2);
				}
				*/
				return $absent_id;
			} else {
				return FALSE;
			}

		}
	}

	function t_employee_absent_set_kdaktual_nil($absent_id) {
        // Utk update ke table employee absent pada saat delete absent type

     	$this->db->select('absent_date, m_employee.employee_id, m_employee.nik, m_fp.kode_cabang, m_absent_type.kode_absent');
		$this->db->from('d_employee_absent');
		$this->db->join('m_absent_type','m_absent_type.kode_absent = d_employee_absent.absent_type','inner');
		$this->db->join('m_employee','m_employee.employee_id = d_employee_absent.absent_emp_id','inner');
		$this->db->join('m_fp','m_fp.fnik = m_employee.nik AND m_fp.kode_cabang = m_employee.kode_cabang ','inner');
		$this->db->where('absent_id', $absent_id);
		$this->db->where('absent_eod_lock', 0);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {

    		$shift_emp = $query->row_array();
            $data = array (
              'tanggal' => $shift_emp['absent_date'],
              'cabang' => $shift_emp['kode_cabang'],
              'nik' => $shift_emp['nik'],
//              'kd_aktual = kd_aktual_temp' => '',
//              'kd_cuti = NULL' => '',
            );

    		$this->db->from('t_employee_absent');
//    		$this->db->where('cabang', $shift_emp['kode_cabang']); //20131010 bugs krn cabang tdk ditemukan saat mutasi
    		$this->db->where('tanggal', $shift_emp['absent_date']);
    		$this->db->where('nik', $shift_emp['nik']);
    		$this->db->where('kd_aktual', $shift_emp['kode_absent']);

    		$query = $this->db->get();

    		if($query->num_rows() > 0) {

    			$result = $query->row_array();
				if (intval($result['shift'])!=0) {

					if($this->db->query('UPDATE t_employee_absent SET kd_aktual = kd_aktual_temp, kd_cuti = NULL, on_process=1
										WHERE tanggal = "'.$shift_emp['absent_date'].'"
										AND nik = "'.$shift_emp['nik'].'" AND eod_lock = 0;')) {
						return TRUE;
					} else {
						return FALSE;
					}
				} else {
					if($this->db->query('DELETE FROM t_employee_absent WHERE tanggal = "'.$shift_emp['absent_date'].'"
										AND nik = "'.$shift_emp['nik'].'" AND eod_lock = 0;')) {
						return TRUE;
					} else {
						return FALSE;
					}
				}
				
				$this->set_upload_absent_to_process_absent($shift_emp);
    		}

        } else {
          return TRUE;
        }
    }

	function t_employee_absent_add_update($data) {
        // Utk update ke table employee absent pada saat tambah absent type

     	$this->db->select('absent_date, m_employee.nik, m_fp.kode_cabang, m_absent_type.kode_absent');
		$this->db->from('d_employee_absent');
		$this->db->join('m_absent_type','m_absent_type.kode_absent = d_employee_absent.absent_type','inner');
		$this->db->join('m_employee','m_employee.employee_id = d_employee_absent.absent_emp_id','inner');
		$this->db->join('m_fp','m_fp.fnik = m_employee.nik AND m_fp.kode_cabang = m_employee.kode_cabang ','inner');
		$this->db->where('absent_emp_id', $data['absent_emp_id']);
		$this->db->where('absent_date', $data['absent_date']);
		$this->db->where('absent_eod_lock', 0);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {

    		$shift_emp = $query->row_array();

    		$this->db->from('t_employee_absent');
//    		$this->db->where('cabang', $shift_emp['kode_cabang']); //20131010 bugs saat mutasi, cabang di t_employee_absent tdk perlu dicek lagi seharusnya
    		$this->db->where('tanggal', $shift_emp['absent_date']);
    		$this->db->where('nik', $shift_emp['nik']);

    		$query = $this->db->get();

    		if($query->num_rows() > 0) {

                $data = array (
                  'tanggal' => $shift_emp['absent_date'],
//                  'cabang' => $shift_emp['kode_cabang'],
                  'nik' => $shift_emp['nik'],
                  'kd_aktual' => $shift_emp['kode_absent'],
                  'kd_cuti' => $shift_emp['kode_absent'],
                  'on_process' => 0
                );

    			$result = $query->row_array();

        		$this->db->where('eod_lock', 0);
    	    	$this->db->where('tanggal', $shift_emp['absent_date']);
    		    $this->db->where('nik', $shift_emp['nik']);

    			if (/*$this->db->query('UPDATE t_employee_absent SET kd_aktual_temp = kd_aktual
                                    WHERE cabang = "'.$shift_emp['kode_cabang'].'"
                                    AND tanggal = "'.$shift_emp['absent_date'].'"
                                    AND nik = "'.$shift_emp['nik'].'"
                                    ')&&*/($this->db->update('t_employee_absent', $data))) {
    				return TRUE;
    			} else {
    				return FALSE;
    			}

    		} else {
                $data = array (
                  'tanggal' => $shift_emp['absent_date'],
                  'cabang' => $shift_emp['kode_cabang'],
                  'nik' => $shift_emp['nik'],
                  'kd_aktual' => $shift_emp['kode_absent'],
                  'kd_cuti' => $shift_emp['kode_absent'],
//                  'kd_aktual_temp' => $shift_emp['kode_absent'],
                );

    			if($this->db->insert('t_employee_absent', $data)) {
    				return TRUE;
    			} else {
    				return FALSE;
    			}
    		}

        } else {
          return TRUE;
        }
    }

	/**
	 * Get how many result from a employee header.
	 * @return integer|false Count of result from a employee header.
	 */
	function employee_absents_count_by_criteria($employee_id = '', $date_from = '', $date_to = '', $sort = '') {

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		$this->db->from('d_employee_absent');

		// start of searching

		$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("absent_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("absent_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("absent_date <= '$date_from2'");
			}
		}

//		if(!empty($status))
//			$this->db->where('status', $status);

    	$this->db->where('absent_emp_id', $employee_id);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'absent_date';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'absent_date';
					$field_sort_type = 'desc';
					break;
			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		$query = $this->db->get();
//echo $this->db->last_query();

		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function employee_absents_select_by_criteria($employee_id = '', $date_from = '', $date_to = '', $sort = '', $limit = 10, $start = 0) {

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		$this->db->from('d_employee_absent');

		// start of searching

		$date_from2 = $date_from;
		$date_to2 = $date_to;

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("absent_date BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("absent_date >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("absent_date <= '$date_from2'");
			}
		}


//		if(!empty($status))
//			$this->db->where('status', $status);

    	$this->db->where('absent_emp_id', $employee_id);
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'absent_date';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'absent_date';
					$field_sort_type = 'desc';
					break;
			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		if($limit != 0)
			$this->db->limit($limit, $start);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function employee_absent_delete($absent_id) {
            $this->t_employee_absent_set_kdaktual_nil($absent_id);

			$this->db->where('absent_id', $absent_id);
			$this->db->where('absent_eod_lock', 0);

			if($this->db->delete('d_employee_absent'))
				return TRUE;
			else
				return FALSE;

	}

	function employee_select_all_fp_absent($id) {
		$this->db->select('a.employee_id,a.nik,a.nama,b.kode_cabang,b.fingerprint_id,b.fnik');
		$this->db->from('m_employee a');
		$this->db->join('m_fp b', 'nik = fnik');
		$this->db->where('employee_id', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}
	
	function set_upload_absent_to_process_absent($data) {
		$hasil = FALSE;
//        $employee = $this->m_employee->employee_select_w_cabang($data['shift_emp_id']);
        $employee = $this->employee_select_all_fp_absent($data['employee_id']);
		
		$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=0 WHERE ";
		$sqlQueryWhere = '';
		
		foreach($employee as $karyawan) {
			$sqlQueryWhere .= " ((`kode_cabang`='".$karyawan['kode_cabang']."') AND (`finger_print`=".$karyawan['fingerprint_id'].")) OR";
		}
		$sqlQueryWhere .= '#';
		$sqlQueryWhere = str_replace("OR#","",$sqlQueryWhere);
		$sqlQueryWhere = str_replace("#","",$sqlQueryWhere);
		$sqlQueryWhere = trim($sqlQueryWhere);
		
		if ($sqlQueryWhere!='') {
			if($this->db->query($sqlQuery.'('.$sqlQueryWhere.") AND (`tanggal` = '".$data['absent_date']."') AND (`finger_eod_lock` = 0);")) {
				$hasil = TRUE;
			} else {
				$hasil = FALSE;
			}
		}

		return $hasil;
	}	
	
}
?>