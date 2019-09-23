<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printgisto_new extends Model {
function tampil($id_gistonew_out_header)
	{
		$query = $this->db->query('SELECT a.gistonew_out_no,a.po_no,a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,b.num,a.plant,a.receiving_plant,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET=a.plant) as NAME1,
(SELECT OUTLET FROM m_outlet WHERE TRANSIT=a.receiving_plant) as PLANT_REC,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE TRANSIT=a.receiving_plant) as PLANT_REC_NAME
FROM t_gistonew_out_header a
JOIN t_gistonew_out_detail b ON a.id_gistonew_out_header = b.id_gistonew_out_header 
where a.id_gistonew_out_header ="'.$id_gistonew_out_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */