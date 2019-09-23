<?php
class M_status extends Model {
		
	function M_status() {
		parent::Model();  
	}

	function statuses_select_all() {
		$this->db->from('t_status');
		$this->db->order_by('id_status');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function status_select($id) {
		$this->db->from('t_status');
		$this->db->order_by('id_status');
		$this->db->where('id_status', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function status_add($data) {
		if($this->db->insert('t_status', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function status_update($data) {
		$this->db->where('id_status', $data['id_status']);
		if($this->db->update('t_status', $data))
			return TRUE;
		else
			return FALSE;
	}

}
