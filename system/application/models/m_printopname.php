<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printopname extends Model {
function tampil($id_opname_header)
	{
		$query = $this->db->query('SELECT a.opname_no,  a.created_date,b.material_no,b.material_desc,b.uom,b.requirement_qty,a.plant, a.id_user_approved,b.num  FROM t_opname_header a 
JOIN t_opname_detail b ON a.id_opname_header = b.id_opname_header
 where a.id_opname_header ="'.$id_opname_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */