<?php
class M_onhand extends Model {

	function M_onhand() {
		parent::Model();
		$this->load->model('m_general');
		$this->load->library('l_general');
		$this->load->library('msdb');
	}
	public function __construct()
 	{
  		parent::__construct();
		
		$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$dba=$db_sap[0]['name'];
        $this->db2 = $this->load->database($dba, TRUE);
		$this->load->library('msdb');
	}

	// start of browse

	function onhand_get_period_selection() {
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

	function onhand_select_matr($date_from) {
        $plant = $this->session->userdata['ADMIN']['plant'];
		$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
(SELECT SUM(Quantity) FROM IGE1 WHERE WhsCode = A.WhsCode AND U_BaseType=202 AND ItemCode= A.ItemCode AND  LEFT(CONVERT(VARCHAR(19), DocDate, 120),10) = '$date_from' ) as Qty_Production,
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
WHERE A.WhsCode = '$plant' AND AC.ItmsGrpCod=131
AND B.U_onhand = 1
";
//echo $swbQuery;
//echo $swbQuery;
//$this->db2->query("Usp_Report_onhand '$plant','$date_from'");
//$this->db2->from('rpt_onhand');
//$this->db2->where('WhsCode',$plant);*/
//$result = $this->msdb->output('Usp_Report_onhand', array('Whs'=>$plant, 'Date'=>$date_from), 'EXECUTE');
//$SP = "EXEC Usp_Report_onhand ?,?";
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