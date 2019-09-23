<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_transfer extends Model {
function tampil($id_gisto_header)
	{
		$query = $this->db->query('SELECT a.plant, a.receiving_plant,a.lastmodified ,b.material_no,b.material_desc,b.uom,b.gr_quantity FROM t_gisto_header a 
JOIN t_gisto_detail b ON a.id_gisto_header = b.id_gisto_detail WHERE a.id_gisto_header ="'.$id_gisto_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */