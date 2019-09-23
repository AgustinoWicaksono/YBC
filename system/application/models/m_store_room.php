<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_store_room extends Model {
function tampil($id_stdstock_header)
	{
		$query = $this->db->query('SELECT a.pr_no, a.created_date, a.delivery_date,b.material_no,b.material_desc,b.uom,b.requirement_qty,b.price FROM t_stdstock_header a 
JOIN t_stdstock_detail b ON a.id_stdstock_header = b.id_stdstock_header where a.id_stdstock_header ="'.$id_stdstock_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */