<?php
class M_employee extends Model {

	function M_employee() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->load->library('l_upload_absent');
		$this->load->helper('date');
	}

	function outlet_employee_select($outlet) {
		$this->db->from('m_outlet_employee');
		$this->db->where('OUTLET', $outlet);

		$query = $this->db->get();
//echo $this->db->last_query();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function outlets_all_select() {
		$this->db->from('m_outlet');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function work_statuses_select_all() {
		$this->db->from('m_work_status');
		$this->db->order_by('work_name');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function maritals_select_all() {
		$this->db->from('m_marital');
		$this->db->order_by('marital_name');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function educations_select_all() {
		$this->db->from('m_education');
		$this->db->order_by('education_name');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function jabatan_select_all($kode_job='') {
		$this->db->from('m_jabatan');
        if($kode_job!=='') {
            $this->db->where('kode_job', $kode_job);
        }
		$this->db->order_by('nama_job');

		$query = $this->db->get();

		if($query->num_rows() > 0)
            if($kode_job=='') {
			    return $query;
            } else {
                $data = $query->row_array();
                return $data['nama_job'];
            }
		else
			return FALSE;
	}

	function bagian_select_all($kode_bagian='') {
		$this->db->from('m_bagian');
        if($kode_bagian!=='') {
            $this->db->where('kode_bagian', $kode_bagian);
        }
		$this->db->order_by('nama_bagian');

		$query = $this->db->get();

		if($query->num_rows() > 0)
            if($kode_bagian=='') {
			    return $query;
            } else {
                $data = $query->row_array();
                return $data['nama_bagian'];
            }
		else
			return FALSE;
	}

	function bagian_select_by_dept($kode_dept) {
		$this->db->from('m_bagian');
        $this->db->where('kode_dept', $kode_dept);
		$this->db->order_by('nama_bagian');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function divisis_select_all($kode_divisi='') {
		$this->db->from('m_divisi');
        if($kode_divisi!=='') {
            $this->db->where('kode_divisi', $kode_divisi);
        }
		$this->db->order_by('nama_divisi');

		$query = $this->db->get();

		if($query->num_rows() > 0)
            if($kode_divisi=='') {
			    return $query;
            } else {
                $data = $query->row_array();
                return $data['nama_divisi'];
            }
		else
			return FALSE;
	}

	function dept_select_all($kode_dept='') {
		$this->db->from('m_dept');
        if($kode_dept!=='') {
            $this->db->where('kode_dept', $kode_dept);
        }
		$this->db->order_by('nama_dept');

		$query = $this->db->get();

		if($query->num_rows() > 0)
            if($kode_dept=='') {
			    return $query;
            } else {
                $data = $query->row_array();
                return $data['nama_dept'];
            }
		else
			return FALSE;
	}

	function dept_select_by_divisi($kode_divisi) {
		$this->db->from('m_dept');
        $this->db->where('kode_divisi', $kode_divisi);
		$this->db->order_by('nama_dept');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function eod_select_last(){
		$this->db->from('m_eod');
    	$this->db->where('kode_outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->order_by('eod_date', 'desc');
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$data = $query->row_array();
			return $data['eod_date'];
		} else {
			return FALSE;
		}
	}

	function employee_check($employee_id = 0) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
        $this->db->where('employee_id', $employee_id);
//		$this->db->where('outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function employees_select_all_order_by_nik() {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
//		$this->db->where('outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('tanggal_keluar', '0000-00-00');
		$this->db->order_by('nik');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function employees_select_all() {
		$this->db->from('m_employee');
        $this->db->where('tanggal_keluar', '0000-00-00');
		$this->db->order_by('nik');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function employees_select_all_order_by_nama() {
/*
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('tanggal_keluar', '0000-00-00');
		$this->db->order_by('nama');
*/
		$this->db->from('m_employee');
		$this->db->where('kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('tanggal_keluar', '0000-00-00');
		$this->db->order_by('nama');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function employees_select_all_filter_by_division($kode_divisi) {
		if (($kode_divisi=='') || ($kode_divisi == 'ALL')) {
			return $this->employees_select_all_order_by_nama();
		} else {
			$this->db->from('m_employee');
			$this->db->join('m_divisi', 'm_divisi.nama_divisi = m_employee.divisi');
			$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
			$this->db->where('m_divisi.kode_divisi', $kode_divisi);
			$this->db->where('m_employee.tanggal_keluar', '0000-00-00');
			$this->db->order_by('nama');

			$query = $this->db->get();

			if($query->num_rows() > 0)
				return $query;
			else
				return FALSE;
		}
	}

	function divisi_select_all() {
		$sqlQuery = "SELECT `a`.`kode_divisi`, `a`.`nama_divisi` FROM `m_divisi` AS `a`, `m_employee` AS `b` WHERE `b`.`kode_cabang` = '".$this->session->userdata['ADMIN']['hr_plant_code']."' AND `a`.`nama_divisi`=`b`.`divisi` ORDER BY `a`.`nama_divisi`;";
		$query = $this->db->query($sqlQuery);

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Get how many result from a employee header.
	 * @return integer|false Count of result from a employee header.
	 */
	function employees_count_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '') {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'nik';
					break;
				case 'b':
					$field_name_ori = 'nama';
					break;
/*
				case 'c':
					$field_name_ori = 'divisi';
					break;
				case 'd':
					$field_name_ori = 'department';
					break;
				case 'e':
					$field_name_ori = 'bagian';
					break;
				case 'f':
					$field_name_ori = 'jabatan';
					break;
				case 'g':
					$field_name_ori = 'golongan';
					break;
				case 'h':
					$field_name_ori = 'level';
					break;
				case 'i':
					$field_name_ori = 'fingerpint_id';
					break;
				case 'j':
					$field_name_ori = 'status_kerja';
					break;
				case 'k':
					$field_name_ori = 'akhir_kontrak';
					break;
*/
			}

			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		$date_from2 = $date_from.' 00:00:00';
		$date_to2 = $date_to.' 23:59:59';

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("tanggal_akhir BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("tanggal_akhir >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("tanggal_akhir <= '$date_from2'");
			}
		}




//		if(!empty($status))
//			$this->db->where('status', $status);

//		$this->db->where('outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('tanggal_keluar', '0000-00-00');
//    	$this->db->where('tanggal_keluar = 0');
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'nik';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'nik';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'divisi';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'divisi';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'department';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'department';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'bagian';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'bagian';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'jabatan';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'jabatan';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'golongan';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'golongan';
					$field_sort_type = 'desc';
					break;
				case 'hy':
					$field_sort_name = 'level';
					$field_sort_type = 'asc';
					break;
				case 'hz':
					$field_sort_name = 'level';
					$field_sort_type = 'desc';
					break;
				case 'iy':
					$field_sort_name = 'fingerprint_id';
					$field_sort_type = 'asc';
					break;
				case 'iz':
					$field_sort_name = 'fingerprint_id';
					$field_sort_type = 'desc';
					break;
				case 'jy':
					$field_sort_name = 'status_kerja';
					$field_sort_type = 'asc';
					break;
				case 'jz':
					$field_sort_name = 'status_kerja';
					$field_sort_type = 'desc';
					break;
				case 'ky':
					$field_sort_name = 'tanggal_akhir';
					$field_sort_type = 'asc';
					break;
				case 'kz':
					$field_sort_name = 'tanggal_akhir';
					$field_sort_type = 'desc';
					break;
				default:
					$field_sort_name = 'employee_id';
					$field_sort_type = 'asc';
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

	function saldo_ph_from_mCutiPh($employee_id){		
		$datestring = "%Y-%m-%d";
		$time = time();
		$date = mdate($datestring, $time);
		
		$this->db->where('employee_id', $employee_id);
		$this->db->where('status', 0);
		$this->db->where("tanggal_ph <= '$date'");
		$this->db->where("tanggal_exp_ph >= '$date'");
		$this->db->from('m_cuti_ph');
		return $this->db->count_all_results();		
	
	}
	
	function employees_select_by_criteria($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0) {

		if(empty($field_content))
			$field_content = '';

		if(empty($date_from))
			$date_from = '';

		if(empty($date_to))
			$date_to = '';

		if(empty($field_content))
			$field_content = '';

		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');

		// start of searching

		if(!empty($field_content)) {

			switch($field_name) {
				case 'a':
					$field_name_ori = 'nik';
					break;
				case 'b':
					$field_name_ori = 'nama';
					break;
/*
				case 'c':
					$field_name_ori = 'divisi';
					break;
				case 'd':
					$field_name_ori = 'department';
					break;
				case 'e':
					$field_name_ori = 'bagian';
					break;
				case 'f':
					$field_name_ori = 'jabatan';
					break;
				case 'g':
					$field_name_ori = 'golongan';
					break;
				case 'h':
					$field_name_ori = 'level';
					break;
				case 'i':
					$field_name_ori = 'fingerpint_id';
					break;
				case 'j':
					$field_name_ori = 'status_kerja';
					break;
				case 'k':
					$field_name_ori = 'akhir_kontrak';
					break;
*/
			}


			if($field_type == 'part')
				$this->db->like($field_name_ori, $field_content);
			else if($field_type == 'all')
				$this->db->where($field_name_ori, $field_content);

		}

		$date_from2 = $date_from;
		$date_to2 = $date_to;

		if( (!empty($date_from)) || (!empty($date_to)) ) {
			if( (!empty($date_from)) || (!empty($date_to)) ) {
				$this->db->where("tanggal_akhir BETWEEN '$date_from2' AND '$date_to2'");
			} else if( (!empty($date_from))) {
				$this->db->where("tanggal_akhir >= '$date_from2'");
			} else if( (!empty($date_to))) {
				$this->db->where("tanggal_akhir <= '$date_from2'");
			}
		}


//		if(!empty($status))
//			$this->db->where('status', $status);

//		$this->db->where('outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
        $this->db->where('tanggal_keluar', '0000-00-00');
		// end of searching

		// start of sorting
		if(!empty($sort)) {
			switch($sort) {
				case 'ay':
					$field_sort_name = 'nik';
					$field_sort_type = 'asc';
					break;
				case 'az':
					$field_sort_name = 'nik';
					$field_sort_type = 'desc';
					break;
				case 'by':
					$field_sort_name = 'nama';
					$field_sort_type = 'asc';
					break;
				case 'bz':
					$field_sort_name = 'nama';
					$field_sort_type = 'desc';
					break;
				case 'cy':
					$field_sort_name = 'divisi';
					$field_sort_type = 'asc';
					break;
				case 'cz':
					$field_sort_name = 'divisi';
					$field_sort_type = 'desc';
					break;
				case 'dy':
					$field_sort_name = 'department';
					$field_sort_type = 'asc';
					break;
				case 'dz':
					$field_sort_name = 'department';
					$field_sort_type = 'desc';
					break;
				case 'ey':
					$field_sort_name = 'bagian';
					$field_sort_type = 'asc';
					break;
				case 'ez':
					$field_sort_name = 'bagian';
					$field_sort_type = 'desc';
					break;
				case 'fy':
					$field_sort_name = 'jabatan';
					$field_sort_type = 'asc';
					break;
				case 'fz':
					$field_sort_name = 'jabatan';
					$field_sort_type = 'desc';
					break;
				case 'gy':
					$field_sort_name = 'golongan';
					$field_sort_type = 'asc';
					break;
				case 'gz':
					$field_sort_name = 'golongan';
					$field_sort_type = 'desc';
					break;
				case 'hy':
					$field_sort_name = 'level';
					$field_sort_type = 'asc';
					break;
				case 'hz':
					$field_sort_name = 'level';
					$field_sort_type = 'desc';
					break;
				case 'iy':
					$field_sort_name = 'fingerprint_id';
					$field_sort_type = 'asc';
					break;
				case 'iz':
					$field_sort_name = 'fingerprint_id';
					$field_sort_type = 'desc';
					break;
				case 'jy':
					$field_sort_name = 'status_kerja';
					$field_sort_type = 'asc';
					break;
				case 'jz':
					$field_sort_name = 'status_kerja';
					$field_sort_type = 'desc';
					break;
				case 'ky':
					$field_sort_name = 'tanggal_akhir';
					$field_sort_type = 'asc';
					break;
				case 'kz':
					$field_sort_name = 'tanggal_akhir';
					$field_sort_type = 'desc';
					break;
				default:
					$field_sort_name = 'employee_id';
					$field_sort_type = 'asc';
			}

			$this->db->order_by($field_sort_name, $field_sort_type);

		}
		// end of sorting

		if($limit != 0)
			$this->db->limit($limit, $start);

		$query = $this->db->get();

//echo $this->db->last_query();
		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function employee_select($id) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik and m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('employee_id', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function employee_select_w_cabang($id) {
		$this->db->select('fingerprint_id');
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik and m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('employee_id', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function employee_check_nik($nik) {
		$this->db->select('employee_id, nik');
		$this->db->from('m_employee');
		$this->db->where('nik', $nik);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function employee_select_all_fp($id) {
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

	function employee_select_by_nik($nik, $field = '') {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('nik', $nik);

		$query = $this->db->get();

		if(empty($field)) {

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return FALSE;

		} else {

			if($query->num_rows() > 0) {
				$data = $query->row_array();
				return $data[$field];
			} else {
				return FALSE;
			}
		}

	}

	function employee_select_all_by_nik($nik, $field = '') {
		$this->db->from('m_employee');
		$this->db->where('nik', $nik);

		$query = $this->db->get();

		if(empty($field)) {

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return FALSE;

		} else {

			if($query->num_rows() > 0) {
				$data = $query->row_array();
				return $data[$field];
			} else {
				return FALSE;
			}
		}

	}

	function employee_select_by_nik_wo_cabang($nik, $field = '') {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('nik', $nik);
		$this->db->where('m_fp.kode_cabang !=', $this->session->userdata['ADMIN']['hr_plant_code']);

		$query = $this->db->get();

		if(empty($field)) {

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return FALSE;

		} else {

			if($query->num_rows() > 0) {
				$data = $query->row_array();
				return $data[$field];
			} else {
				return FALSE;
			}
		}

	}

	function employee_fps_select_by_nik($nik) {
		$this->db->from('m_fp');
		$this->db->where('fnik', trim($nik));

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	function employee_select_by_fp($fp, $cabang) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('fingerprint_id', $fp);
//		$this->db->where('outlet', $cabang);
		$this->db->where('m_employee.kode_cabang', $cabang);

		$query = $this->db->get();

		if(empty($field)) {

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return FALSE;

		}

	}

	function employee_select_by_fp_cabang($fp, $cabang) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik');
		$this->db->where('fingerprint_id', $fp);
		$this->db->where('m_fp.kode_cabang', $cabang);

		$query = $this->db->get();

		if(empty($field)) {

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return FALSE;

		}

	}

	function employee_select_by_nama($nama) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('nama', $nama);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
	
	function get_current_fingerprintid($kode_cabang,$employee_nik){
		$this->db->select('fingerprint_id');
		$this->db->from('m_fp');
		$this->db->where('fnik', $employee_nik);
		$this->db->where('kode_cabang', $kode_cabang);
		
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$finger_id = $query->row_array();
			return $finger_id;
		} else {
			return FALSE;
		}
	}

	function employee_select_by_fingerid($fp, $cabang) {
		$this->db->select('fnik');
		$this->db->from('m_fp');
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('fingerprint_id', $fp);
		
		$hasil=array();
		$hasil['nama']='-';
		$hasil['nik']='-';
		$hasil['kode_cabang']='-';
		
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$fnik = $query->row_array();
			$fnik = $fnik['fnik'];
			
			$this->db->select('nama,nik,kode_cabang');
			$this->db->from('m_employee');
			$this->db->where('nik', $fnik);
			
			$query = $this->db->get();

			if($query->num_rows() > 0) {
				$employee = $query->row_array();
				$hasil['nama']=$employee['nama'];
				$hasil['nik']=$employee['nik'];
				$hasil['kode_cabang']=$employee['kode_cabang'];
			} 
		} 
		
		return $hasil;

	}



	function employee_update($data) {

		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik AND m_employee.kode_cabang = m_fp.kode_cabang');
		$this->db->where('fingerprint_id', $data['fingerprint_id']);
//		$this->db->where('outlet', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
		$this->db->where('employee_id !=', $data['employee_id']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return FALSE;
		} else {
			$this->db->from('m_employee');
			$this->db->where('employee_id', $data['employee_id']);
			$query = $this->db->get();

			if($query->num_rows() > 0) {
				$employee = $query->row_array();
				
				$fingerid_existing = $this->get_current_fingerprintid($this->session->userdata['ADMIN']['hr_plant_code'],$employee['nik']);
				if ($fingerid_existing!=FALSE){
					$fingerid_existing =  intval($fingerid_existing['fingerprint_id']);
				} else {
					$fingerid_existing = 0;
				}
				
				
				$finger['fingerprint_id'] = $data['fingerprint_id'];
				$kartu_jamsostek = $data['kartu_jamsostek'];
				$kartu_kesehatan = $data['kartu_kesehatan'];
				$kartu_npwp = $data['kartu_npwp'];
				unset($data['kartu_jamsostek']);
				unset($data['kartu_kesehatan']);
				unset($data['kartu_npwp']);

				$this->db->where('fnik', $employee['nik']);
				$this->db->where('kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
				if($this->db->update('m_fp', $finger)) {
				

//					$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=0 WHERE (`kode_cabang`='".$this->session->userdata['ADMIN']['hr_plant_code']."') AND (`finger_print`=".$data['fingerprint_id'].") AND (`finger_eod_lock`=0);";
					
//20151129 - Bug fixed, finger id not updated on t_upload_absent | Edo
					if ($fingerid_existing!=$data['fingerprint_id']){
						$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=0, `finger_print`=".$data['fingerprint_id']." WHERE (`kode_cabang`='".$this->session->userdata['ADMIN']['hr_plant_code']."') AND (`finger_print`=".$fingerid_existing.") AND (`finger_eod_lock`=0);";
					
						$this->db->query($sqlQuery);
					}
//20151129 - Bug fixed, finger id not updated on t_upload_absent | Edo
					
					$sqlQuery = "UPDATE `m_employee` SET `kartu_jamsostek`='".$kartu_jamsostek."', `kartu_kesehatan`='".$kartu_kesehatan."', `kartu_npwp`='".$kartu_npwp."' WHERE `employee_id`=".$data['employee_id'].";";
					
					$this->db->query($sqlQuery);
					
				
                    // $this->l_upload_absent->proses_absen_by_fp($this->session->userdata['ADMIN']['hr_plant_code'],$data['fingerprint_id']); //20130704 off by Edo
					return TRUE;
				} else
					return FALSE;
			}
		}
	}

	function employee_delete($id) {

			$this->db->where('employee_id', $id);

			if($this->db->delete('m_employee'))
				return TRUE;
			else
				return FALSE;

	}

	// end of browse

	function employee_select_to_export($employee_id) {
		$this->db->from('m_employee');
		$this->db->join('m_fp', 'nik = fnik');
		$this->db->where_in('employee_id', $employee_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function employee_fp_add($data) {

		$this->db->from('m_fp');
		$this->db->where('fingerprint_id', $data['fingerprint_id']);
		$this->db->where('kode_cabang', $data['kode_cabang']);
		$this->db->where('fnik !=', $data['fnik']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return FALSE;
		} else {
			
			$fingerid_existing = $this->get_current_fingerprintid($data['kode_cabang'],$data['fnik']);
			if ($fingerid_existing!=FALSE){
				$fingerid_existing =  intval($fingerid_existing['fingerprint_id']);
			} else {
				$fingerid_existing = 0;
			}
			
			
			$this->db->where('fnik', $data['fnik']);
	    	$this->db->where('kode_cabang', $data['kode_cabang']);
			$this->db->delete('m_fp');
			
     		$this->db->insert('m_fp', $data);
	    	$m_fp_id = $this->db->insert_id();
			
//			$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=0 WHERE (`kode_cabang`='".$data['kode_cabang']."') AND (`finger_print`=".$data['fingerprint_id'].")  AND (`finger_eod_lock`=0);";
			
//20151129 - Bug fixed, finger id not updated on t_upload_absent | Edo
					if ($fingerid_existing!=$data['fingerprint_id']){
						$sqlQuery = "UPDATE `t_upload_absent` SET `status_proses`=0, `finger_print`=".$data['fingerprint_id']." WHERE (`kode_cabang`='".$data['kode_cabang']."') AND (`finger_print`=".$fingerid_existing.") AND (`finger_eod_lock`=0);";
						
						$this->db->query($sqlQuery);
					}
//20151129 - Bug fixed, finger id not updated on t_upload_absent | Edo
			
			
			$this->db->query($sqlQuery);

            // $this->l_upload_absent->proses_absen_by_fp($data['kode_cabang'],$data['fingerprint_id']); //20130704 off by Edo

            return $m_fp_id;
 		}

	}

	function employee_UI_kodeabsen($kodeAbsen) {
			$gradeClass = "grdNone";
			$kodeAbsen = trim($kodeAbsen);

			if ($kodeAbsen=='H') $gradeClass = "grdA";
			elseif ($kodeAbsen=='LS') $gradeClass = "grdA";
			elseif ($kodeAbsen=='TM') $gradeClass = "grdB";
			elseif ($kodeAbsen=='CO') $gradeClass = "grdC";
			elseif ($kodeAbsen=='O') $gradeClass = "grdC";
			elseif ($kodeAbsen=='PH') $gradeClass = "grdC";
			elseif ($kodeAbsen=='CR') $gradeClass = "grdC";
			elseif ($kodeAbsen=='ML') $gradeClass = "grdC";
			elseif ($kodeAbsen=='MTL') $gradeClass = "grdC";
			elseif ($kodeAbsen=='CPH') $gradeClass = "grdC";
			elseif ($kodeAbsen=='AL') $gradeClass = "grdC";
			elseif ($kodeAbsen=='UL') $gradeClass = "grdC";
			elseif ($kodeAbsen=='IDT') $gradeClass = "grdC";
			elseif ($kodeAbsen=='IPC') $gradeClass = "grdC";
			elseif ($kodeAbsen=='SWL') $gradeClass = "grdC";
			elseif ($kodeAbsen=='DT') $gradeClass = "grdD";
			elseif ($kodeAbsen=='PC') $gradeClass = "grdD";
			elseif ($kodeAbsen=='TC') $gradeClass = "grdD";
			elseif ($kodeAbsen=='TL') $gradeClass = "grdD";
			elseif ($kodeAbsen=='AM') $gradeClass = "grdD";
			elseif ($kodeAbsen=='A') $gradeClass = "grdE";
			
			return $gradeClass;
	}
	
	function check_m_fp_ok($data){
		$this->db->select('nik');
		$this->db->from('m_employee');
		$this->db->where('employee_id', $data['employee_id']);

		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
			$employee = $query->row_array();
			$nik = $employee['nik'];
			

			$this->db->from('m_fp');
			$this->db->where('fingerprint_id', $data['fingerprint_id']);
			$this->db->where('kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);
			$this->db->where('fnik !=', $nik);

			$query = $this->db->get();
			
			if($query->num_rows() > 0) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	
	}
	
}
?>