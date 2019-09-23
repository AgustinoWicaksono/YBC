<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
//echo "<opnamee>";
//opnameint_r($request_reasons);
//echo "</opnamee>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Stock Opname Number</strong></td>
	  <td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<!--tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr-->
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
	<?php /*if(!empty($data['request_reason'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Request Reason</strong></td>
        <?=form_hidden('request_reason', $data['request_reason']);?>
		<td class="column_input"><?=form_dropdown('request_reason', $request_reasons, $data['request_reason'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['item_group_code'])) : echo anchor('opname/input', '<strong>Pilih ulang Request Reason dan Material Group</strong>'); else : echo anchor('opname/input', '<strong>Pilih Ulang Request Reason</strong>'); endif; endif;?>
        </td>
	</tr>
	<?php else : ?>
  <tr>
    <td class="table_field_1"><strong>Request Reason</strong></td>
		<td class="column_input"><?=form_dropdown('request_reason', $request_reasons, "", 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif;*/ ?>
    <?php
    $c=mssql_connect($host_sap,$user_sap,$pass_sap);
$b=mssql_select_db($db_sap,$c);
$gr=mssql_query("SELECT ItmsGrpNam as item_group_code FROM OITB");
$group[0]='';
$group['all']='==All==';
while($r=mssql_fetch_array($gr))
		{
			$group[$r['item_group_code']] = $r['item_group_code'];
		}
		//print_r($group);
	?>
	<?php if( !empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group_code', $data['item_group_code']);?><?=form_dropdown('item_group_code', $group, $data['item_group_code'], 'class="input_text" disabled="disabled"');?></td>
	</tr>
	<?php else : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $group, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	<?php endif; ?>
	<?php if(!empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>