<?php
class M_spoiled2 extends Model {

	function M_spoiled2() {
		parent::Model();
		$this->load->model('m_general');
		$this->load->library('l_general');
		$this->load->library('msdb');
	}
	public function __construct()
 	{
  		parent::__construct();
        $this->db2 = $this->load->database('MSI_GO', TRUE);
		$this->load->library('msdb');
	}

	// start of browse

	function bread_get_period_selection() {
      $plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->select('S_PERIODE, E_PERIODE');
      $this->db->from('rpt_variance');
      $this->db->where('OUTLET',$plant);
      $this->db->group_by(array("S_PERIODE", "E_PERIODE"));
      $this->db->order_by("E_PERIODE", "desc");
      $this->db->limit(10);
      $query = $this->db->get();
      if($query->num_rows() > 0) {
         return $query->result_array();
      } else {
         return FALSE;
      }
    }

	function spoiled2_select_matr($date_from) {
        $plant = $this->session->userdata['ADMIN']['plant'];
		$swbQuery = "select a.docnum, a.DocDate,b.ItemCode, b.Dscription, b.Quantity,b.WhsCode, * from OIGE a , IGE1 b, OITM C
where a.DocEntry= b.DocEntry
and b.ItemCode = c.ItemCode
and b.U_Waste=1
and b.WhsCode='$plant'
AND ItmsGrpCod='$grup_item'


(SELECT SUM(Quantity) FROM WTR1 D
JOIN OWTR E ON D.DocEntry = E.DocEntry WHERE E.ToWhsCode=A.WhsCode AND D.ItemCode=A.ItemCode AND LEFT(CONVERT(VARCHAR(19), D.DocDate, 120),10) = '$date_from'
)Qty_In,
(SELECT SUM(Quantity) FROM WTR1 D
JOIN OWTR E ON D.DocEntry = E.DocEntry WHERE E.Filler=A.WhsCode AND D.ItemCode=A.ItemCode AND U_Retur = 1 AND LEFT(CONVERT(VARCHAR(19), D.DocDate, 120),10) = '$date_from'
) as Qty_Retur,
(SELECT SUM(Quantity) FROM WTR1 D
JOIN OWTR E ON D.DocEntry = E.DocEntry 
JOIN OWHS H ON E.ToWhsCode = H.WhsCode
WHERE H.WhsName LIKE '%cake%' AND E.ToWhsCode NOT LIKE '%T.%' AND D.ItemCode=A.ItemCode AND LEFT(CONVERT(VARCHAR(19), D.DocDate, 120),10) = '$date_from'
) as Qty_Out_Department,
(SELECT SUM(Quantity) FROM WTR1 D
JOIN OWTR G ON D.DocEntry = G.DocEntry WHERE RIGHT(G.ToWhsCode,2) != RIGHT(A.WhsCode,2) AND D.ItemCode=A.ItemCode AND G.ToWhsCode NOT LIKE '%T.%'
AND LEFT(CONVERT(VARCHAR(19), D.DocDate, 120),10) = '$date_from'
) as Qty_Out_Outlet,
(SELECT SUM(Quantity) FROM IGN1 I
JOIN OIGN J ON I.DocEntry = J.DocEntry WHERE I.ItemCode = A.ItemCode AND I.WhsCode = A.WhsCode AND U_Cutting = 1 AND LEFT(CONVERT(VARCHAR(19), I.DocDate, 120),10) = '$date_from'
) AS Qty_In_Cutting,
(SELECT SUM(Quantity) FROM IGE1 K
JOIN OIGN L ON K.DocEntry = L.DocEntry WHERE K.ItemCode = A.ItemCode AND K.WhsCode = A.WhsCode AND U_Cutting = 1 AND LEFT(CONVERT(VARCHAR(19), K.DocDate, 120),10) = '$date_from'
) AS Qty_Out_Cutting,
B.BVolume,
A.WhsCode
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant' 
AND B.ItemCode LIKE '%BR%' OR B.ItemCode LIKE '%CS%'
AND B.U_bread=1
";
//echo $swbQuery;
//echo $swbQuery;
 // AND AC.ItmsGrpCod=131 
//$this->db2->query("Usp_Report_bar '$plant','$date_from'");
//$this->db2->from('rpt_bar');
//$this->db2->where('WhsCode',$plant);*/
//$result = $this->msdb->output('Usp_Report_bar', array('Whs'=>$plant, 'Date'=>$date_from), 'EXECUTE');
//$SP = "EXEC Usp_Report_bar ?,?";
//$this->db2->query($SP,array('Whs'=>$plant,'Date'=>$date_from));
$this->db2->query($swbQuery);

			
			// echo $swbQuery.'<hr />';
		$query = $this->db2->get();

		if($query->num_rows() > 0) {
            return $query;
        } else {
          return FALSE;
        }
	}
}
?>