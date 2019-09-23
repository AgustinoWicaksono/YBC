<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printnonstock extends Model {
function tampil($id_nonstdstock_header)
	{
		$query = $this->db->query('SELECT a.pr_no, a.created_date, b.material_no,b.material_desc,b.uom,b.requirement_qty,b.price,b.delivery_date,a.plant FROM t_nonstdstock_header a 
JOIN t_nonstdstock_detail b ON a.id_nonstdstock_header = b.id_nonstdstock_header where a.id_nonstdstock_header ="'.$id_nonstdstock_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */