<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
&nbsp;<a href="<?php echo base_url();?>rpt_waste/input"><img src="<?php echo base_url();?>images/jbtnback2.png" alt="Back" title="Back" border="0" /></a><br />
<table cellpadding="3" cellspacing="0" border="1" class="display" id="JAGTable" width="100%">
<thead>
	<tr>
		<th>Plant</th>
		<th>Date</th>
		<th>Material Number</th>
		<th>UOM</th>
		<th>Waste Quantity</th>
		<th>Reason</th>
	</tr>
</thead>
<tbody>
<?php

foreach($rpt as $reportwaste){
	echo '<tr>';
	echo '<td align="center">'.$reportwaste['Plant'].'</td>';
	echo '<td align="center">'.$reportwaste['Date'].'</td>';
	echo '<td>'.$reportwaste['Material_Number'].'</td>';
	echo '<td align="center">'.$reportwaste['UOM'].'</td>';
	echo '<td align="right">'.$reportwaste['Waste_Quantity'].'</td>';
	echo '<td>'.$reportwaste['Reason'].'</td>';
	echo '<tr>';
}

?>
</tbody>
</table>
<p>&nbsp;</p>
