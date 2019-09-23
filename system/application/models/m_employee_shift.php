<?php
class M_employee_shift extends Model {

	function M_employee_shift() {
		parent::Model();
		$this->load->library('l_upload_absent');
		$this->load->model('m_general');
		$this->load->model('m_employee');
		$this->load->model('m_sync_attendance');
	}

	function shifts_select_by_dates($date_from, $date_to) {
		$this->db->from('d_employee_shift');
		$this->db->where("shift_date BETWEEN '".$date_from."' AND '".$date_to."'");
		$this->db->order_by('shift_date', 'asc');
		$this->db->order_by('shift_emp_id', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function employee_shift_check_eom($tgldata,$absent_emp_id) {
		$hasil = false;
	
		$sqlQuery = "SELECT max(akhir) as `tanggal` FROM m_employee a inner join d_endofmonth b on a.kode_grouppembayaran=b.period_type AND a.kode_cabang=b.kode_outlet inner join m_schedule_pembyaran c on c.kode_grouppembayaran=a.kode_grouppembayaran and c.period=b.periode where employee_id=".$absent_emp_id." and eom_status=1";

		
		$query = $this->db->query($sqlQuery);

		

		if($query->num_rows() > 0){
			$hasilq = $query->result_array();
			$tglakhireom = strtotime($hasilq[0]['tanggal']);
			
			if ($tglakhireom<$tgldata) $hasil = true; else $hasil = false;
		} else {
			$hasil = true;
		}
		
		// $hasil=true;
		
		return $hasil;
	}
	

	function shift_codes_select($company_code) {
		$this->db->select('shift_code, duty_on, duty_off, break_in, break_out');
		$this->db->from('m_shift');
		$this->db->join('m_outlet_employee','m_outlet_employee.OUTLET_HC = m_shift.company_code','inner');
		$this->db->where('OUTLET', $company_code);
		$this->db->order_by('shift_code', 'asc');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function shift_emp_select($data) {
		$this->db->select('m_shift.shift_code, duty_on, duty_off, break_in, break_out');
		$this->db->from('m_shift');
		$this->db->join('m_outlet_employee','m_outlet_employee.OUTLET_HC = m_shift.company_code','inner');
		$this->db->join('d_employee_shift','d_employee_shift.shift_code = m_shift.shift_code','inner');
		$this->db->join('m_employee','m_employee.employee_id = d_employee_shift.shift_emp_id AND m_employee.kode_cabang = OUTLET','inner');
		$this->db->where('shift_date', $data['tanggal']);
		$this->db->where('nik', $data['nik']);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function shift_code_select($shift_code, $company_code) {
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

	function shift_code_check($shift_code, $company_code) {
		$this->db->from('m_shift');
		$this->db->join('m_outlet_employee','m_outlet_employee.OUTLET_HC = m_shift.company_code','inner');
		$this->db->where('OUTLET', $company_code);
		$this->db->where('shift_code', $shift_code);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	function set_upload_absent_to_process($data) {
		$hasil = FALSE;
//        $employee = $this->m_employee->employee_select_w_cabang($data['shift_emp_id']);
        $employee = $this->m_employee->employee_select_all_fp($data['shift_emp_id']);
		
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
			if($this->db->query($sqlQuery.'('.$sqlQueryWhere.") AND (`tanggal` = '".$data['shift_date']."') AND (`finger_eod_lock` = 0);")) {
				$hasil = TRUE;
			} else {
				$hasil = FALSE;
			}
		}

		return $hasil;
	}

	function shift_add_update($data,$longshift_nik) {
		if ($this->employee_shift_check_eom(strtotime($data['shift_date']),$data['shift_emp_id'])) {
		
			$this->db->from('d_employee_shift');
			$this->db->where('shift_emp_id', $data['shift_emp_id']);
			$this->db->where('shift_date', $data['shift_date']);

			$query = $this->db->get();

			if($query->num_rows() > 0) {

				$result = $query->row_array();
				if ($result['shift_code']!=$data['shift_code']){ // kode shift sama tidak perlu diproses
				
				
					$this->db->where('shift_emp_id', $data['shift_emp_id']);
					$this->db->where('shift_date', $data['shift_date']);
					$this->db->where('shift_eod_lock', 0);
					
					$data['shift_status_proses']='0';

					if($this->db->update('d_employee_shift', $data)) {
						$this->set_upload_absent_to_process($data);
						$this->m_sync_attendance->sync_shift($result['shift_id'],$longshift_nik); //ubah data t_employee_absent
						
						return TRUE;
					} else {
						return FALSE;
					}
				} else return TRUE;
			} else {

				if($this->db->insert('d_employee_shift', $data)) {
					$new_shift_id = $this->db->insert_id();
					$this->set_upload_absent_to_process($data);
					$this->m_sync_attendance->sync_shift($new_shift_id,$longshift_nik); //ubah data t_employee_absent
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}	else {
			return TRUE;
		}
	}

	function employee_absent_add_update($data) {
        // Utk update ke table employee absent pada saat tambah shift

     	$this->db->select('shift_date, m_employee.nik, m_employee.outlet, m_fp.fingerprint_id');
     	$this->db->select('m_shift.shift_code, duty_on, duty_off, break_in, break_out');
		$this->db->from('d_employee_shift');
		$this->db->join('m_employee','m_employee.employee_id = d_employee_shift.shift_emp_id','inner');
  		$this->db->join('m_fp','fnik = m_employee.nik','inner');
		$this->db->join('m_outlet_employee','m_outlet_employee.outlet = m_fp.kode_cabang','inner');
		$this->db->join('m_shift','m_shift.company_code = m_outlet_employee.outlet_hc AND m_shift.shift_code = d_employee_shift.shift_code','inner');
		$this->db->join('m_outlet_employee','m_outlet_employee.outlet = m_fp.kode_cabang','inner');
		$this->db->where('shift_emp_id', $data['shift_emp_id']);
		$this->db->where('shift_date', $data['shift_date']);
		$this->db->where('m_employee.kode_cabang', $this->session->userdata['ADMIN']['hr_plant_code']);

		$query = $this->db->get();

		if($query->num_rows() > 0) {

    		$shift_emp = $query->row_array();
            $data = array (
              'tanggal' => $shift_emp['shift_date'],
              'cabang' => $shift_emp['outlet'],
              'nik' => $shift_emp['nik'],
              'shift' => $shift_emp['shift_code'],
              'kd_shift' => $shift_emp['shift_code'],
              'shift_in' => $shift_emp['duty_on'],
              'shift_break_out' => $shift_emp['break_out'],
              'shift_break_in' => $shift_emp['break_in'],
              'shift_out' => $shift_emp['duty_off'],
            );

    		$this->db->from('t_employee_absent');
    		$this->db->where('cabang', $shift_emp['outlet']);
    		$this->db->where('tanggal', $shift_emp['shift_date']);
    		$this->db->where('nik', $shift_emp['nik']);

    		$query = $this->db->get();

    		if($query->num_rows() > 0) {

    			$result = $query->row_array();

        		$this->db->where('cabang', $shift_emp['outlet']);
    	    	$this->db->where('tanggal', $shift_emp['shift_date']);
    		    $this->db->where('nik', $shift_emp['nik']);

    			if($this->db->update('t_employee_absent', $data)) {
    				$return = TRUE;
    			} else {
    				$return = FALSE;
    			}

    		} else {

    			if($this->db->insert('t_employee_absent', $data)) {
    				$return = TRUE;
    			} else {
    				$return = FALSE;
    			}
    		}
             return $return;
        } else {
          return TRUE;
        }
}

}
?>