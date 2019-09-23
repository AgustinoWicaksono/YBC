<?php
class M_prstodlvgr extends Model {

	function M_prstodlvgr() {
		parent::Model();
		$this->load->model('m_general');
		$this->load->library('l_general');
	}

	// start of browse

	function prstodlvgr_select_matr($date_from,$date_to,$dovsgrfilter) {

		$this->db->select('MATERIAL,MAKTX,UOM');
		$this->db->from('Z_MM_BAPI_PRVSDOVSGR');
		$this->db->join('m_item','MATNR = MATERIAL','inner');
	    $this->db->where("DATE(PERIODE) >= '$date_from'");
	    $this->db->where("DATE(PERIODE) <= '$date_to'");
    	$this->db->where('OUTLET', $this->session->userdata['ADMIN']['plant']);
        if($dovsgrfilter=='Yes') {
  	      $this->db->where("DOVSGR > 0");
        }
    	$this->db->group_by(array("MATERIAL", "MAKTX", "UOM"));

		$query = $this->db->get();
		if($query->num_rows() > 0) {
            return $query->result_array();
        } else {
          return FALSE;
        }
	}

	function prstodlvgr_select_qty($PERIODE,$MATERIAL) {
        $PERIODE = $this->l_general->str_to_date($PERIODE);

		$this->db->select('PR_QTY,PO_QTY,DLV_QTY,DOVSGR');
		$this->db->from('Z_MM_BAPI_PRVSDOVSGR');
	    $this->db->where("DATE(PERIODE) = '$PERIODE'");
	    $this->db->where("MATERIAL = '$MATERIAL'");
    	$this->db->where('OUTLET', $this->session->userdata['ADMIN']['plant']);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
          return $query->row_array();
        } else {
          return FALSE;
        }
	}

}
?>