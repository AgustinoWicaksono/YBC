<?php
class M_jenisoutlet extends Model {
		
	function M_jenisoutlet() {
		parent::Model();  
	}

	function jenisoutlets_select_all() {
		$this->db->from('t_jenisoutlet');
		$this->db->order_by('id_jenisoutlet');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	function jenisoutlet_select($id) {
		$this->db->from('t_jenisoutlet');
		$this->db->order_by('id_jenisoutlet');
		$this->db->where('id_jenisoutlet', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function jenisoutlet_add($data) {
		if($this->db->insert('t_jenisoutlet', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function jenisoutlet_update($data) {
		$this->db->where('id_jenisoutlet', $data['id_jenisoutlet']);
		if($this->db->update('t_jenisoutlet', $data))
			return TRUE;
		else
			return FALSE;
	}

}
