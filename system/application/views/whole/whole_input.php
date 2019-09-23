<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
	<?php
	 $whs=$this->session->userdata['ADMIN']['storage_location'];
    mysql_connect("localhost","root","");
	mysql_select_db("sap_php");
$gr=mysql_query("SELECT kode_whi,nama_whi FROM m_mwts_header JOIN m_item ON m_item.MATNR=m_mwts_header.kode_whi WHERE plant='$whs'");
$kode_paket[0]='';
while($r=mysql_fetch_array($gr))
		{
			$kode_paket[$r['kode_whi']] = $r['kode_whi'].' - '.$r['nama_whi'];
		}
		//print_r($group);
	?>
 
  <tr>
    <td class="table_field_1"><strong>Item Produksi</strong></td>
		<td class="column_input"><?=form_dropdown('kode_paket', $kode_paket, $data['kode_paket'], ' data-placeholder="Pilih item..." class="chosen-select input_text" onChange="document.form1.submit();"');?></td>
	</tr>
    <?php
    if (!empty($data['kode_paket']))
	{
	?>
    <tr>
		<td class="table_field_1"><strong> Quantity</strong></td>
        <td class = "column_input" >
		<?php
		
		if(!empty($error) && in_array("whole_header[quantity_paket]", $error)) {
  			echo form_input("whole_header[quantity_paket]" ,number_format($data['whole_header']['quantity_paket'], 2, '.', ''), 'class="error_number" onChange="document.form1.submit();" size="8"').' '.$uom_paket;
  		} else {
  			echo form_input("whole_header[quantity_paket]",number_format($data['whole_header']['quantity_paket'], 2, '.', ''), 'class="input_number" onChange="document.form1.submit();" size="8"').' '.$uom_paket;
  		}
		?><?php //form_hidden("mpaket_prod_header[uom_paket]", $uom_paket);?>
        </td>
	</tr>
	<?php } ?>
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