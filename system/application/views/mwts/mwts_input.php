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
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
mysql_select_db($db_mysql,$mysqlcon);
$t=mysql_query("select MATNR,MAKTX from m_item", $mysqlcon);
while($r=mysql_fetch_array($t))
{
	$item1[$r['MATNR']]=$r['MATNR']."-".$r['MAKTX'];
}
	mysql_close($mysqlcon);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<tr>
	<?php if(!empty($data['item_choose'])) : ?>
		<td class="table_field_1"><strong>Whole Item Code</strong></td>
        <?php if((!empty($_POST))&&(!empty($data['item']))) : ?>
           <td class="column_input">
           <?=form_hidden('mwts_header[kode_whi]', $data['item']);?><?=$data['item'];?></td>
           <tr>
  		   <td class="table_field_1"><strong>Whole Item Description</strong></td>
           <td class="column_input"><?=form_hidden('mwts_header[nama_whi]', $item_whi_name);?><?=$item_whi_name;?></td>
           </tr>
        <?else : ?>
          <td class="column_input"><?=form_dropdown('item', $item, $data['item'], 'class="input_text chosen-select" onChange="document.form1.submit();"');?></td>
        <?endif;?>
	<?php 
	mysql_close($mysqlcon);
	endif; ?>
	</tr>
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