<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printgrpodlv extends Model {
function tampil($id_grpodlv_header)
	{
		$query = $this->db->query('SELECT a.do_no, Date_format(a.posting_date, "%d %M %Y") posting_date, a.grpodlv_no, Date_format(a.lastmodified,"%d %M %Y")  lastmodified,b.material_no,b.material_desc,b.uom,b.outstanding_qty,b.gr_quantity,a.plant ,a.id_user_approved  FROM t_grpodlv_header a 
JOIN t_grpodlv_detail b ON a.id_grpodlv_header = b.id_grpodlv_header
 where a.id_grpodlv_header ="'.$id_grpodlv_header.'"');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */