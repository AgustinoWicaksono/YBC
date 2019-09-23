<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printgrpodlv_dept extends Model {
function tampil($id_grpodlv_dept_header)
	{
		$query = $this->db->query('SELECT a.do_no, a.grpodlv_dept_no, a.posting_date,a.lastmodified,b.material_no,b.material_desc,b.uom,b.outstanding_qty,b.gr_quantity,a.plant, a.id_user_approved  FROM t_grpodlv_dept_header a 
JOIN t_grpodlv_dept_detail b ON a.id_grpodlv_dept_header = b.id_grpodlv_dept_header
 where a.id_grpodlv_dept_header ="'.$id_grpodlv_dept_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */