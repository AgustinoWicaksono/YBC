<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_retur extends Model {
function tampil($id_gisto_dept_header)
	{
		$query = $this->db->query('SELECT a.plant,a.gisto_dept_no do_no, a.receiving_plant,a.lastmodified ,b.material_no,b.material_desc,b.uom,b.gr_quantity,b.reason
 FROM t_gisto_dept_header a
JOIN t_gisto_dept_detail b ON a.id_gisto_dept_header=b.id_gisto_dept_header WHERE a.id_gisto_dept_header ="'.$id_gisto_dept_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */