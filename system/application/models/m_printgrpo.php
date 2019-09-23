<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printgrpo extends Model {
function tampil($id_grpo_header)
	{
		$query = $this->db->query('SELECT a.po_no, a.grpo_no, a.delivery_date,b.material_no,b.material_desc,b.uom,b.outstanding_qty,b.gr_quantity,a.plant,a.nm_vendor  FROM t_grpo_header a 
JOIN t_grpo_detail b ON a.id_grpo_header = b.id_grpo_header
 where a.id_grpo_header ="'.$id_grpo_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */