<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_printretin extends Model {
function tampil($id_retin_header)
	{
		$query = $this->db->query('SELECT a.id_user_approved,a.do_no, a.retin_no, a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,a.plant, 
(select f.reason from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
and a.do_no=d.gisto_dept_no
and d.receiving_plant=a.plant
and f.material_no=b.material_no ) reason,
(select D.plant from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
and a.do_no=d.gisto_dept_no
and d.receiving_plant=a.plant
and f.material_no=b.material_no )  FromPlant ,
(select e.OUTLET_NAME1 from t_gisto_dept_header d, t_gisto_dept_detail f ,m_outlet e where d.id_gisto_dept_header =f.id_gisto_dept_header
and a.do_no=d.gisto_dept_no
and d.receiving_plant=a.plant
and D.plant=e.OUTLET
and f.material_no=b.material_no )  OUTLET_NAME1,
(select D.posting_date from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
and a.do_no=d.gisto_dept_no
and d.receiving_plant=a.plant
and f.material_no=b.material_no )  delivery,
(select f.gr_quantity from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
and a.do_no=d.gisto_dept_no
and d.receiving_plant=a.plant
and f.material_no=b.material_no ) Qty_Retur
from  t_retin_header a 
, t_retin_detail b 
where a.id_retin_header = b.id_retin_header

and a.id_retin_header ="'.$id_retin_header.'"
 ');
		return $query;
	}
}
	

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */