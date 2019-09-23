<?php
class M_upload_absent extends Model {

	function M_upload_absent() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->load->model('m_employee');
		$this->load->library('l_general');
	}

	function upload_absent_add($data) {
		if($this->db->insert('t_upload_absent', $data)){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}

	function upload_absent_add_anomali($data,$anomali_type=0,$desc='ANOMALI') {
		$data['waktu_seharusnya'] = $desc;
		$data['anomali_type'] = $anomali_type;
		if($this->db->insert('t_upload_absent_anomali', $data)){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}

	function upload_absent_get_absent($kode_cabang,$finger_print,$tanggal) {
      $this->db->select("COALESCE((select b.waktu from t_upload_absent b where b.status_absen='1'
                         and b.finger_print=a.finger_print and a.kode_cabang = b.kode_cabang and b.tanggal=a.tanggal order by b.waktu limit 1),space(0)) as 'in'");
      $this->db->select("COALESCE((select c.waktu from t_upload_absent c where c.status_absen='0' and a.kode_cabang = c.kode_cabang and c.finger_print=a.finger_print and c.tanggal=a.tanggal and c.waktu >
	                     COALESCE((select b1.waktu from t_upload_absent b1 where b1.status_absen='1' and b1.finger_print=a.finger_print and a.kode_cabang = b1.kode_cabang and b1.tanggal=a.tanggal order by b1.waktu limit 1),space(0))  order by c.waktu limit 1 ),space(0)) as break_out");
      $this->db->select("COALESCE((select d.waktu from t_upload_absent d where d.status_absen='1' and d.finger_print=a.finger_print and a.kode_cabang = d.kode_cabang and d.tanggal=a.tanggal order by d.waktu desc limit 1 ),space(0)) as break_in");
      $this->db->select("COALESCE((select e.waktu from t_upload_absent e where e.status_absen='0' and e.finger_print=a.finger_print and e.tanggal=a.tanggal and a.kode_cabang = e.kode_cabang
                         and e.waktu > COALESCE((select d1.waktu from t_upload_absent d1 where d1.status_absen='1' and a.kode_cabang = d1.kode_cabang and d1.finger_print=a.finger_print and d1.tanggal=a.tanggal order by d1.waktu desc limit 1),space(0)) order by e.waktu desc limit 1),space(0)) as 'out'");
      $this->db->from('t_upload_absent as a');
	  $this->db->where('finger_print', $finger_print);
	  $this->db->where('kode_cabang', $kode_cabang);
	  $this->db->where('tanggal', $tanggal);
      $this->db->group_by('finger_print');
      $this->db->group_by('kode_cabang');
      $this->db->group_by('tanggal');

      $query = $this->db->get();

      if($query->num_rows() > 0) {
      	return $query->row_array();
      } else {
      	return FALSE;
      }

   }

	function upload_absent_get_absent_w_shift($kode_cabang,$finger_print,$tanggal) {
      $this->db->select("(CASE WHEN h.fdiff_date = 1 THEN
                         COALESCE((select b.waktu from t_upload_absent b where b.status_absen='1'
                         and b.finger_print=a.finger_print and a.kode_cabang = b.kode_cabang
                         and b.tanggal=a.tanggal order by b.waktu limit 1),space(0))
                         ELSE
			             COALESCE((select b.waktu from t_upload_absent b where b.status_absen='1'
                         and b.finger_print=a.finger_print and a.kode_cabang = b.kode_cabang
                         and b.tanggal=a.tanggal order by b.waktu limit 1),space(0))
            			 END) as 'in'");
      $this->db->select("(CASE WHEN h.fdiff_date = 1 THEN
                         COALESCE((select c.waktu from t_upload_absent c where c.status_absen='0'
                         and a.kode_cabang = c.kode_cabang and c.finger_print=a.finger_print
                         and c.tanggal= case when break_out < duty_on then ADDDATE(a.tanggal,(1)) else a.tanggal end
                         and c.waktu > COALESCE((select b1.waktu from t_upload_absent b1 where b1.status_absen='1'
                         and b1.finger_print=a.finger_print and a.kode_cabang =
                         b1.kode_cabang and b1.tanggal=a.tanggal order by b1.waktu limit 1),space(0))
                         order by c.waktu limit 1),space(0))
                         ELSE
                         COALESCE((select c.waktu from t_upload_absent c where c.status_absen='0' and a.kode_cabang = c.kode_cabang and c.finger_print=a.finger_print and c.tanggal=a.tanggal and c.waktu >
	                     COALESCE((select b1.waktu from t_upload_absent b1 where b1.status_absen='1'
                         and b1.finger_print=a.finger_print and a.kode_cabang =
                         b1.kode_cabang and b1.tanggal=a.tanggal order by b1.waktu limit 1),space(0))  order by c.waktu limit 1 ),space(0))
                         END) as break_out");
      $this->db->select("(CASE WHEN h.fdiff_date = 1 THEN
                         COALESCE((select d.waktu from t_upload_absent d where d.status_absen='1'
                         and d.finger_print=a.finger_print and a.kode_cabang = d.kode_cabang
                         and d.tanggal=case when break_in < duty_on then ADDDATE(a.tanggal,(1)) else a.tanggal end order by d.waktu desc limit 1 ),space(0))
                     	 ELSE
                         COALESCE((select d.waktu from t_upload_absent d where d.status_absen='1'
                         and d.finger_print=a.finger_print and a.kode_cabang = d.kode_cabang
                         and d.tanggal=a.tanggal order by d.waktu desc limit 1 ),space(0))
                      	 END) as break_in");
      $this->db->select("(CASE WHEN h.fdiff_date = 1 THEN
                    	 COALESCE((select e.waktu from t_upload_absent e where e.status_absen='0' and e.finger_print=a.finger_print
                         and e.tanggal=ADDDATE(a.tanggal,(1)) and a.kode_cabang = e.kode_cabang
                         order by e.waktu desc limit 1),space(0))
                         ELSE
                    	 COALESCE((select e.waktu from t_upload_absent e where e.status_absen='0' and e.finger_print=a.finger_print and e.tanggal=a.tanggal and a.kode_cabang = e.kode_cabang
                         and e.waktu > COALESCE((select d1.waktu from t_upload_absent d1 where d1.status_absen='1'
                         and a.kode_cabang = d1.kode_cabang and d1.finger_print=a.finger_print
                         and d1.tanggal=a.tanggal order by d1.waktu desc limit 1),space(0))
                         order by e.waktu desc limit 1),space(0))
                    	 END) as 'out'");
      $this->db->from('t_upload_absent as a');
  	  $this->db->join('m_fp as g','g.kode_cabang = a.kode_cabang AND g.fingerprint_id = a.finger_print','inner');
  	  $this->db->join('m_employee as k','k.nik = g.fnik','inner');
  	  $this->db->join('d_employee_shift as i','a.tanggal = i.shift_date AND i.shift_emp_id = k.employee_id','inner');
  	  $this->db->join('m_shift as h','i.shift_code = h.shift_code ','inner');
  	  $this->db->join('m_outlet_employee as j','j.OUTLET_HC = h.company_code and j.outlet  = k.kode_cabang','inner');
	  $this->db->where('finger_print', $finger_print);
	  $this->db->where('a.kode_cabang', $kode_cabang);
	  $this->db->where('a.tanggal', $tanggal);
      $this->db->group_by('finger_print');
      $this->db->group_by('a.kode_cabang');
      $this->db->group_by('a.tanggal');

      $query = $this->db->get();

      if($query->num_rows() > 0) {
      	return $query->row_array();
      } else {
      	return FALSE;
      }

   }

	function upload_absent_delete($data) {
		$this->db->where('finger_print', $data['finger_print']);
	    $this->db->where('tanggal', $data['tanggal']);
		$this->db->where('waktu', $data['waktu']);
		$this->db->where('kode_cabang', $data['kode_cabang']);
		if($this->db->delete('t_upload_absent')) {
			$this->db->where('finger_print', $data['finger_print']);
			$this->db->where('tanggal', $data['tanggal']);
			$this->db->where('waktu', $data['waktu']);
			$this->db->where('kode_cabang', $data['kode_cabang']);
			$this->db->delete('t_upload_absent_anomali');
			return TRUE;
		} else {
			return FALSE;
		}

	}

	function upload_absent_temp_truncate() {

		$temp1 = $this->db->truncate('t_upload_absent_temp_1');
		$temp2 = $this->db->truncate('t_upload_absent_temp_2');
		$temp3 = $this->db->truncate('t_upload_absent_temp_3');

		if($temp1 && $temp2 && $temp3) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	function upload_absent_cabangs_select($date = '') {

		$this->db->distinct();
		$this->db->select('kode_cabang');
		$this->db->from('t_upload_absent');

		if ($date != '') {
			$this->db->where('tanggal', $date);
			$this->db->where('status_proses', 0);
		}

		$this->db->order_by('id', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0) {

			return $query;
		} else {
			return FALSE;
		}

	}

	function upload_absent_fps_select($date, $cabang) {

		$this->db->distinct();
		$this->db->select('finger_print');
		$this->db->from('t_upload_absent');
		$this->db->where('tanggal', $date);
		$this->db->where('kode_cabang', $cabang);
		$this->db->order_by('id', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function upload_absent_datas_select($date, $cabang, $fp) {

		$this->db->from('t_upload_absent');
		$this->db->where('tanggal', $date);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('finger_print', $fp);
		$this->db->where('status_proses', 0);
//		$this->db->order_by('id', 'asc');
		$this->db->order_by('waktu', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function upload_absent_dates_select($cabang) {

		$this->db->distinct();
		$this->db->select('tanggal');
		$this->db->from('t_upload_absent');
		$this->db->where('kode_cabang', $cabang);
		$this->db->order_by('tanggal', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function upload_absent_dates_select_by_fp($fingerprint_id,$cabang) {

		$this->db->distinct();
		$this->db->select('tanggal');
		$this->db->from('t_upload_absent');
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('finger_print', $fingerprint_id);
		$this->db->order_by('tanggal', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

	function employee_absent_select($data) {
		$this->db->from('t_employee_absent');
		$this->db->where('tanggal', $data['tanggal']);
		$this->db->where('cabang', $data['cabang']);
		$this->db->where('nik', $data['nik']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}

	}

	function cek_kdaktual_izin($kode_absent) {
		$this->db->from('m_absent_type');
		$this->db->where('kode_absent', $kode_absent);
		$this->db->where('type_active', 1);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	function employee_absent_add($data) {
		if($this->db->insert('t_employee_absent', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function employee_absent_add_update($data) {
		
		$this->db->from('t_employee_absent');
		$this->db->where('tanggal', $data['tanggal']);
		$this->db->where('cabang', $data['cabang']);
		$this->db->where('nik', $data['nik']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$this->db->where('tanggal', $data['tanggal']);
			$this->db->where('cabang', $data['cabang']);
			$this->db->where('nik', $data['nik']);

			if($this->db->update('t_employee_absent', $data)) {
  				return TRUE;
  			} else {
  				return FALSE;
  			}

		} else {

			if($this->db->insert('t_employee_absent', $data)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	function employee_absent_add_update_w_proses($data) {
        if ($this->employee_absent_add_update($data)) {
            $fingerprint_id = $this->m_employee->employee_select_by_nik($data['nik'],'fingerprint_id');
            if($this->l_upload_absent->proses_absen($data['cabang'], $data['tanggal'] , $fingerprint_id)=='')
               return TRUE;
            else
               return FALSE;
        }
	}

	// 20130603 by Edo  --> Update field 'status_process' di raw tabel t_upload_absent
	function update_status_proses_absen($data_id_raw_absen) {
		$data_id_raw_absen = trim($data_id_raw_absen);
		if ($data_id_raw_absen!=''){
			$swbquery1 = "UPDATE `t_upload_absent` SET `status_proses`=1 WHERE `id` IN (".$data_id_raw_absen.");";
			$this->db->query($swbquery1);
		}
	}
	// 20130603 by Edo  --> Update field 'status_process' di raw tabel t_upload_absent


}
?>