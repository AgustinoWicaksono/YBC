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
// die('Saat ini input issue ditutup untuk sementara hingga proses perbaikan data di kantor pusat selesai. <FORM><INPUT TYPE="button" VALUE="Kembali" onClick="history.go(-1);return true;"> </FORM>');
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Spoiled No.</strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Cost Center</strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['cost_center'].' - '.$this->session->userdata['ADMIN']['cost_center_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
    
	<tr>
    <?php
	//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
	//$b=mssql_select_db('Test_MSI',$c);
	$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap));
	$gr=sqlsrv_query($b,"SELECT ItmsGrpNam as item_group_code FROM OITB");
	
$group[0]='';
$group['all']='==All==';
while($r=sqlsrv_fetch_array($gr))
		{
			$group[$r['item_group_code']] = $r['item_group_code'];
		}
		sqlsrv_close($b);
		//print_r($group);
	?>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input">
         <?php 
		 
		 if((!empty($_POST))&&(!empty($data['item_group_code']))) : ?>
         <?=form_hidden('item_group_code', $data['item_group_code']);?>
         <?=form_dropdown('item_group_code', $group, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();" disabled="disabled"');?>
         <? echo anchor('issue/input', '<strong>Pilih Ulang Material Group</strong>'); ?>
         <?else : ?><?=form_dropdown('item_group_code', $group, $data['item_group_code'], ' data-placeholder="Pilih material group..." class="chosen-select input_text" style="width:250px;" onChange="document.form1.submit();"');;?>
         <?endif;?>
         </td>
	</tr>
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