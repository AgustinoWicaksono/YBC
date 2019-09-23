<?php
class M_employee_req extends Model {

	function M_employee_req() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
		$this->load->model('m_sinkron_mssql');
		$this->load->model('m_employee');
	}

	function employee_req_add($data) {
		if($this->db->insert('d_employee_req', $data)) {
            $id = $this->db->insert_id();
            $employee = $this->m_employee->employee_select($data['emp_id']);
            $data['requestby'] = $employee['nik'];
            $data['employee_req_id'] = $id;
            $this->m_sinkron_mssql->t_requestkaryawan_insert_update($data);
			return $id;
		} else
			return FALSE;
	}

	function employee_req_stat_select_by_date($date_from, $date_to, $plant) {

/*
		$this->db->from('d_employee_req');
		$this->db->join('m_employee', 'employee_id = emp_id');
		$this->db->join('t_employee_req_stat', 'request_id = employee_req_id', 'right outer');
		$this->db->where('cabang', $this->session->userdata['ADMIN']['storage_location_name']);
    $this->db->where('req_date BETWEEN '.$date_from.' AND '.$date_to);
		$this->db->order_by('req_date');
		$this->db->from('d_employee_req');
		$this->db->join('m_employee', 'employee_id = emp_id');
		$this->db->join('t_employee_req_stat', 'request_id = employee_req_id', 'left');
//		$this->db->where('outlet', $this->session->userdata['ADMIN']['storage_location_name']);
		$this->db->where("req_date BETWEEN '".$date_from."' AND '".$date_to."'");
		$this->db->order_by('req_date');
*/
     	$query = $this->m_sinkron_mssql->employee_req_hrms_select_by_date($date_from, $date_to, $plant);

		if (($query !=FALSE) AND ($query->num_rows() > 0))
			return $query;
		else
			return FALSE;

	}

}
?>