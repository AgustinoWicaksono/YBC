<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printgrsto extends Model {
function tampil($id_grsto_header)
	{
		$query = $this->db->query('SELECT a.po_no, a.grsto_no, a.delivery_date,a.delivery_plant,a.delivery_plant_name,b.material_no,b.material_desc,b.uom,b.outstanding_qty,b.gr_quantity,a.plant,
		(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET=a.plant) as NAME1,
(SELECT OUTLET FROM m_outlet WHERE OUTLET=a.delivery_plant) as PLANT_REC,
(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET=a.delivery_plant) as PLANT_REC_NAME
		 FROM t_grsto_header a 
JOIN t_grsto_detail b ON a.id_grsto_header = b.id_grsto_header
 where a.id_grsto_header ="'.$id_grsto_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */