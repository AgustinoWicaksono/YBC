<?php
class Ajax_model extends Model {
		
	function Ajax_model() {
        parent::Model();  
    }
    
    function get_name($nip) 
    {        
		$this->db->select('nama');
		$this->db->where('useridfp',$nip);
        $query = $this->db->get('absen_bridge');
        
        if ($query->num_rows() > 0) {
            $row =  $query->row();
			return $row->nama;
        } else {
            return "error";     
		}
    }
    
}
?>