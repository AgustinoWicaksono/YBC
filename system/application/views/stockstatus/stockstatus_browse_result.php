<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$diredo = "../pos.ybc.co.id/";
include_once($diredo."swbsql.php");

$aSQLRef = new MySQLConnector();
$aSQLRef->connect();

$plant = $this->session->userdata['ADMIN']['plant'];

/*	
	function tdbgcolor($date) {
		echo 'date: '.$date;
		$ret = '';
		if ($date == 1)
			$ret = 'bgcolor="#92D050"';
		
		if ($date == 2)
			$ret = 'bgcolor="#953735"';
			
		return $ret;
	}
*/
function drawCells($record, $tablistclassno) {
	/*
	$ApprStat = 'V';
	$NotApprStat = 'X';
	
	if (intval($record) == 2){
		echo '<td class="tablistyes'.$tablistclassno.'">'.$ApprStat.'</td>';
	}
	else if (intval($record) == 1){
		echo '<td class="tablistno'.$tablistclassno.'">'.$NotApprStat.'</td>';
	}
	else {
		echo '<td class="tablist'.$tablistclassno.'">'.$record.'</td>';
	}
	*/
	
	if ($record != ''){
		echo '<td class="tablist'.$tablistclassno.'">'.intval($record).'</td>';
	} else {
		echo '<td class="tablist'.$tablistclassno.'">'.$record.'</td>';
	}
	
	return 0;
}

?>
<div align="center" class="page_title"><?=$page_title;?><br /><?=$input_month.' '.$input_year;?></div><br /><br />
<table class="swbbodyb" cellpadding="0" cellspacing="0" align="center" border="0" width="100%" style="border:#363535 1px solid;border-right:0;border-bottom:0;">

<tr>
	<td width="10%" class="ticketcolt">Mat no</td>
	<td width="20%" class="ticketcolt">Mat desc</td>
	<?php
		//echo 'satu';
		
		$i = 1;
		
		if (fmod($input_year,4) == 0){
			$ito = 29;
		}
		
		if ($int_month != '2' ) {
			$ito = 30;
		}
		
		if ($int_month == '1' || $int_month == '3' || $int_month == '5' || $int_month == '7' || $int_month == '8' 
					|| $int_month == '10' || $int_month == '12'){
			$ito = 31;
		}
		
		for ($i=1; $i<=$ito; $i++) {
			echo '<td width="1%" class="ticketcolt">'.$i.'</td>';
		}
		
	?>
</tr>

<?php
  //echo 'dua';
	//echo 'int_month: '.$int_month;
	
	//$query1 = "";
	/*
	$query2 = "SELECT d.material_no, d.material_desc, h.status, h.posting_date ".
						"FROM t_stockoutlet_header h ".
						"INNER JOIN t_stockoutlet_detail d ".
						"ON (h.id_stockoutlet_header = d.id_stockoutlet_header) ".
						"WHERE h.plant = '".$plant."' ".
						"AND h.posting_date >= '".$date_start."' AND h.posting_date <= '".$date_end."' ";
	*/
	$query1 = "SELECT d.material_no, d.material_desc, ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 1, `quantity`, NULL)) AS 'day1', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 2, `quantity`, NULL)) AS 'day2', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 3, `quantity`, NULL)) AS 'day3', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 4, `quantity`, NULL)) AS 'day4', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 5, `quantity`, NULL)) AS 'day5', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 6, `quantity`, NULL)) AS 'day6', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 7, `quantity`, NULL)) AS 'day7', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 8, `quantity`, NULL)) AS 'day8', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 9, `quantity`, NULL)) AS 'day9', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 10, `quantity`, NULL)) AS 'day10', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 11, `quantity`, NULL)) AS 'day11', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 12, `quantity`, NULL)) AS 'day12', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 13, `quantity`, NULL)) AS 'day13', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 14, `quantity`, NULL)) AS 'day14', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 15, `quantity`, NULL)) AS 'day15', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 16, `quantity`, NULL)) AS 'day16', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 17, `quantity`, NULL)) AS 'day17', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 18, `quantity`, NULL)) AS 'day18', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 19, `quantity`, NULL)) AS 'day19', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 20, `quantity`, NULL)) AS 'day20', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 21, `quantity`, NULL)) AS 'day21', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 22, `quantity`, NULL)) AS 'day22', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 23, `quantity`, NULL)) AS 'day23', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 24, `quantity`, NULL)) AS 'day24', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 25, `quantity`, NULL)) AS 'day25', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 26, `quantity`, NULL)) AS 'day26', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 27, `quantity`, NULL)) AS 'day27', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 28, `quantity`, NULL)) AS 'day28', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 29, `quantity`, NULL)) AS 'day29', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 30, `quantity`, NULL)) AS 'day30', ".
							"GROUP_CONCAT(if(DAY(`posting_date`) = 31, `quantity`, NULL)) AS 'day31' ".
						"FROM t_stockoutlet_header h INNER JOIN t_stockoutlet_detail d ".
						"ON (h.id_stockoutlet_header = d.id_stockoutlet_header) ".
						"WHERE h.plant = '".$plant."' ".
						"AND h.status = 2 ".
						"AND (h.posting_date BETWEEN '".$date_start."' AND '".$date_end."') ".
						"GROUP BY d.material_no";
	
	//die ($query1);
	//echo 'query: '.$query1;

	$aSQLRef->query($query1);
	$aSQLRef->rowcount();
	
	//echo 'tiga';
	
	if ($aSQLRef->dbrowcount>0) {
	//echo 'empat';
			$count = 0;
			while ($count<$aSQLRef->dbrowcount){				
				$mat_no = mysql_result($aSQLRef->dbresult,$count,0);
				$mat_desc = mysql_result($aSQLRef->dbresult,$count,1);
				
				for ($i=2; $i<=32; $i++) {
					$date_result[$i-1] = mysql_result($aSQLRef->dbresult,$count,$i);
				}

				if ($count%2) {
					echo '<tr>';
					//echo '<td class="tablist1">'.$mat_no.'</td>';
					if (intval($mat_no) > 0){
						echo '<td class="tablist1">'.intval($mat_no).'</td>';
					} else {
						echo '<td class="tablist1">'.$mat_no.'</td>';
					}
					echo '<td class="tablist1">'.$mat_desc.'</td>';
					
					for ($i=1; $i<=28; $i++) {
						drawCells($date_result[$i], '1');
					}

					if (fmod($input_year,4) == 0){
						drawCells($date_result[29], '1');
					}
					
					if ($int_month != '2') {
						if (fmod($input_year,4) > 0) {
							drawCells($date_result[29], '1');
						}
							drawCells($date_result[30], '1');
					}
					
					if ($int_month == '1' || $int_month == '3' || $int_month == '5' || $int_month == '7' || $int_month == '8' 
								|| $int_month == '10' || $int_month == '12'){
						drawCells($date_result[31], '1');
					}		
					
					echo '</tr>';
					
				} else {
					echo '<tr>';
					//echo '<td class="tablist2">'.$mat_no.'</td>';
					if (intval($mat_no) > 0){
						echo '<td class="tablist2">'.intval($mat_no).'</td>';
					} else {
						echo '<td class="tablist2">'.$mat_no.'</td>';
					}
					echo '<td class="tablist2">'.$mat_desc.'</td>';
					
					for ($i=1; $i<=28; $i++) {
						drawCells($date_result[$i], '2');
					}

					if (fmod($input_year,4) == 0){
						drawCells($date_result[29], '2');
					}
					
					if ($int_month != '2') {
						if (fmod($input_year,4) > 0) {
							drawCells($date_result[29], '2');
						}
							drawCells($date_result[30], '2');
					}
					
					if ($int_month == '1' || $int_month == '3' || $int_month == '5' || $int_month == '7' || $int_month == '8' 
								|| $int_month == '10' || $int_month == '12'){
						drawCells($date_result[31], '2');
					}	
					
					echo '</tr>';
				}				
				
				$count++;
			}
	} else {
		echo '<tr>';
		echo '<td class="tablistt" colspan="5" style="color:#fdd250;">Tidak ada data</td>';
		echo '</tr>';
	}


$aSQLRef->disconnect();
unset($aSQLRef);


// print_r($this->session->userdata);
?>

</table>

<?php 

?>