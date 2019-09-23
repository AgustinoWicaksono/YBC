<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printwaste extends Model {
function tampil($id_waste_header)
	{
		$query = $this->db->query('SELECT a.plant,a.posting_date,b.material_no,b.material_desc,b.uom,b.quantity,b.reason_name,a.no_acara ,c.OUTLET_NAME1,a.material_doc_no
FROM t_waste_header a
JOIN t_waste_detail b ON a.id_waste_header=b.id_waste_header 
JOIN m_outlet c ON a.plant=c.OUTLET
WHERE a.id_waste_header ="'.$id_waste_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */