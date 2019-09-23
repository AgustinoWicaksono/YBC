<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_gistonew_pdf extends Model {
function tampil($id_gistonew_dept_header)
	{
		$query = $this->db->query('SELECT a.po_no,a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,a.plant,a.receiving_plant,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET = a.plant) AS PLANTNAME,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE TRANSIT = a.receiving_plant) AS REC_NAME
FROM t_gistonew_dept_header a
JOIN t_gistonew_dept_detail b ON a.id_gistonew_dept_header = b.id_gistonew_dept_header where a.id_gistonew_dept_header ="'.$id_gistonew_dept_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */