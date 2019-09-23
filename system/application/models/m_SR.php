<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_SR extends Model {
function tampil($id_stdstock_header)
	{
		$query = $this->db->query('SELECT a.pr_no,Date_format(a.created_date, "%d %M %Y") created_date,Date_format(a.delivery_date, "%d %M %Y") delivery_date,
		b.material_no,b.material_desc,b.uom,b.requirement_qty,b.price,a.plant,a.id_user_approved ,to_plant,c.OUTLET_NAME1
		FROM t_stdstock_header a 
JOIN t_stdstock_detail b ON a.id_stdstock_header = b.id_stdstock_header 
JOIN m_outlet c ON a.to_plant=c.OUTLET
where a.id_stdstock_header ="'.$id_stdstock_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */