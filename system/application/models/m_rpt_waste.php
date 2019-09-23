<?php
class M_rpt_waste extends Model {


	function M_rpt_waste() {
		parent::Model();
//		$this->load->model('m_saprfc');
		$this->load->model('m_general');
	}

	function waste_by_sfg($data, $tipedata = 'screen', $tipetanggal=0, $sfg='sfg') {
	
		if ($tipetanggal==0)
			$sqlFormatTanggal = '%m/%d/%Y';
		else
			$sqlFormatTanggal = '%Y-%m-%d';
		
		$plants = $data['plants'];
		$sqlPlant = '';
		foreach ($plants as $plant=>$value){
			$sqlPlant .= "a.plant = '".$value."' OR ";
		}
		$sqlPlant .= "#";
		$sqlPlant = str_replace('OR #','',$sqlPlant);
			
		if ($sfg=='sfg'){
			$sqlWaste = "select a.`plant` as `Plant`,DATE_FORMAT(a.`posting_date`,'".$sqlFormatTanggal."') as `Date`,b.`material_no` as `Material_Number`, b.`uom` as `UOM`, b.quantity as `Waste_Quantity`,b.reason_name as `Reason` from t_waste_header a, t_waste_detail b WHERE a.id_waste_header=b.id_waste_header AND a.`posting_date`>='".$data['date_from']."' and a.`posting_date`<='".$data['date_to']."' and a.`status`=2 and (".$sqlPlant.") and b.`quantity` IS NOT NULL  order by a.`plant`, a.`posting_date`, b.`material_no` limit 0,100000000000;";
		} else {
			$sqlPlant = str_replace('a.plant','`t_waste_header`.`plant`',$sqlPlant);
			$sqlWaste = "(select `t_waste_header`.`plant` as `Plant`,DATE_FORMAT(`t_waste_header`.`posting_date`,'".$sqlFormatTanggal."') as `Date`,`t_waste_detail_bom`.`material_no` as `Material_Number`, `t_waste_detail_bom`.`uom` as `UOM`, `t_waste_detail_bom`.quantity as `Waste_Quantity`,`t_waste_detail`.reason_name as `Reason`,`t_waste_detail`.other_reason as `Detail Reason` from t_waste_header, t_waste_detail_bom, t_waste_detail WHERE `t_waste_header`.id_waste_header=`t_waste_detail_bom`.id_waste_header AND `t_waste_header`.id_waste_header=`t_waste_detail`.id_waste_header AND `t_waste_detail_bom`.id_waste_detail=`t_waste_detail`.id_waste_detail AND `t_waste_header`.`posting_date`>='".$data['date_from']."' and `t_waste_header`.`posting_date`<='".$data['date_to']."' and `t_waste_header`.`status`=2 and (".$sqlPlant.") and `t_waste_detail_bom`.`quantity` IS NOT NULL) union (select `t_waste_header`.`plant` as `Plant`,DATE_FORMAT(`t_waste_header`.`posting_date`,'".$sqlFormatTanggal."') as `Tanggal`,`t_waste_detail`.`material_no` as `Material_Number`, `t_waste_detail`.`uom` as `UOM`, `t_waste_detail`.quantity as `Waste_Quantity`,`t_waste_detail`.reason_name as `Reason`,`t_waste_detail`.other_reason as `Detail Reason` from t_waste_header, t_waste_detail WHERE `t_waste_header`.id_waste_header=`t_waste_detail`.id_waste_header AND `t_waste_header`.`posting_date`>='".$data['date_from']."' and `t_waste_header`.`posting_date`<='".$data['date_to']."' and `t_waste_header`.`status`=2 and (".$sqlPlant.") and `t_waste_detail`.`quantity` IS NOT NULL AND (not(`t_waste_detail`.`id_waste_detail` in (select `t_waste_detail_bom`.`id_waste_detail` AS `id_waste_detail` from `t_waste_detail_bom` where ((`t_waste_detail_bom`.`id_waste_header` = `t_waste_detail`.`id_waste_header`) and (`t_waste_detail_bom`.`id_waste_detail` = `t_waste_detail`.`id_waste_detail`))))) ) order by `plant`, `Date`, `Material_Number` limit 0,100000000000;";
		}
 // echo $sqlWaste; die();
		
		if ($tipedata!='screen') {$this->load->dbutil(); }
		$query = $this->db->query($sqlWaste);
//echo $this->db->last_query();
		if($query->num_rows() > 0){
			if ($tipedata=='screen')
				return $query->result_array();
			else {
				$datahasil = $this->dbutil->csv_from_result($query); 
//				$namafile = 'waste.csv';
				return $datahasil;
			}
		} else
			return FALSE;
	}
	


}
?>