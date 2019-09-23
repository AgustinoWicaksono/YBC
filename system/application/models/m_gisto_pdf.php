<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_gisto_pdf extends Model {
function tampil($id_gisto_header)
	{
		$query = $this->db->query('SELECT a.po_no,a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,b.num,a.plant,a.receiving_plant,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET = a.plant) AS PLANTNAME,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET = a.receiving_plant) AS REC_NAME
FROM t_gisto_header a
JOIN t_gisto_detail b ON a.id_gisto_header = b.id_gisto_header where a.id_gisto_header ="'.$id_gisto_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */