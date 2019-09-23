<?php
class M_agging extends Model {
		
	function M_agging() {
		parent::Model();  
	}

	function aggings_select_all() {
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->select('a.id_grpo_header,a.delivery_date,b.material_no,b.material_desc');
	$this->db->from('t_grpo_header a');
	$this->db->join('t_grpo_detail b','a.id_grpo_header=b.id_grpo_header','inner');
	$this->db->where('delivery_date >= CURDATE() -3');
	$this->db->where('delivery_date <= NOW()');
	$this->db->where('a.plant',$kd_plant);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	function aggings_select_all_count() {
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->select('a.id_grpo_header,a.delivery_date,b.material_no,b.material_desc');
	$this->db->from('t_grpo_header a');
	$this->db->join('t_grpo_detail b','a.id_grpo_header=b.id_grpo_header','inner');
	$this->db->where('delivery_date >= CURDATE() -3');
	$this->db->where('delivery_date <= NOW()');
	$this->db->where('a.plant',$kd_plant);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->num_rows();
		else
			return FALSE;
	}

	function agging_select($id) {
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->select('a.id_grpo_header,a.delivery_date,b.material_no,b.material_desc');
	$this->db->from('t_grpo_header a');
	$this->db->join('t_grpo_detail b','a.id_grpo_header=b.id_grpo_header','inner');
	$this->db->where('delivery_date >= CURDATE() -3');
	$this->db->where('delivery_date <= NOW()');
	$this->db->where('a.plant',$kd_plant);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function agging_add($data) {
		if($this->db->insert('t_agging', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function agging_update($data) {
		$this->db->where('id_agging', $data['id_agging']);
		if($this->db->update('t_agging', $data))
			return TRUE;
		else
			return FALSE;
	}

}
