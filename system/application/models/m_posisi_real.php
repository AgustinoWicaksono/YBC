<?php
class M_posisi extends Model {
		
	function M_posisi() {
		parent::Model();  
	}

	function posisis_select_all() {
		$this->db->from('t_posisi');
		$this->db->order_by('id_posisi');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function posisi_select($id) {
		$this->db->from('t_posisi');
		$this->db->order_by('id_posisi');
		$this->db->where('id_posisi', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function posisi_add($data) {
		if($this->db->insert('t_posisi', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function posisi_update($data) {
		$this->db->where('id_posisi', $data['id_posisi']);
		if($this->db->update('t_posisi', $data))
			return TRUE;
		else
			return FALSE;
	}

}
