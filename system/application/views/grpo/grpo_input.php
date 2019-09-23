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
<td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
<td class="table_field_h"><?php 
$jagpo_lastupdate = $this->m_grpo->po_lastupdate();
if ($jagpo_lastupdate==FALSE) $jagpo_lastupdated = "Belum ada data";
	else $jagpo_lastupdated = $jagpo_lastupdate;
echo $jagpo_lastupdated; ?>
</td>
</tr>

<tr>
<td class="table_field_1"><strong>Purchase Order Number</strong></td>
<?php if($data['po_no']!='-') : ?>
<td class="column_input"><?=form_hidden('po_no', $data['po_no']);?><?=form_dropdown('po_no', $po_no, $data['po_no'], 'class="input_text" disabled="disabled"');?>
<?=' '?><?php echo anchor('grpo/input', '<strong>Pilih ulang Purchase Order</strong>');
		$url = 'http://'.+$_SERVER['HTTP_HOST'].'/images/loading.gif';
?>
</td>
<?php else : ?>
	<td class="column_input">

	<script type="text/javascript">
	function LoadingPOData(){
	document.getElementById("loadingdatapo").innerHTML = '<center><div style="color:#aa1122;padding:7px;margin:7px;border:#777777 1px solid;display:block;width:70%;background-color:#ffffff;"><div style="float:left;margin:0px 7px 7px 0px;"><img src="http://localhost/images/loading.gif" border="0" alt="Loading data" /></div> &nbsp; <b>Loading data...</b><br />Harap tunggu 3-5 menit untuk proses perbarui data PO Anda.</div></center>';
	}
	</script>

	<?php if (count($po_no)>0) { 
	
	?>
	<div id="loadingdatapo">Anda memiliki <b style="color:#aa1122;"><?php echo count($po_no)-1; ?> Nomor PO</b> yang harus <b><u>segera</u></b> diterima dan disetujui.<hr /><br /><?=form_dropdown('po_no', $po_no, $data['po_no'], 'class="chosen-select input_text" data-placeholder="Pilih Nomor PO..." onChange="document.form1.submit();"');?>
	<?php if($this->m_grpo->is_po_ref_btn_can_show()==TRUE): ?>
	&nbsp; <span style="background-color:#fdd250;padding:3px;border:#ffac00 1px solid;"><?php echo anchor('grpo/refresh_po_list', '<strong>Refresh PO List</strong>','onClick="LoadingPOData();"');?></span>
	<?php endif;?>
	<br />&nbsp;
	</div>
	<?php } else { ?>
	<div id="loadingdatapo"><span style="color:#aa1122;"><b>Saat ini tidak ada pengiriman barang berdasarkan PO dari vendor.</b> &mdash; Silahkan tekan tombol &quot;REFRESH PO&quot; untuk memperbarui data. Jika tombol tidak tampil, silahkan tunggu 30 menit dari jam data teraktual hingga tombol tampil kembali.</span><hr />
	<?php if($this->m_grpo->is_po_ref_btn_can_show()==TRUE): ?>
	<div style="margin:10px;font-size:120%;">Silahkan klik link di sebelah kanan: <span style="background-color:#fdd250;padding:3px;border:#ffac00 1px solid;"><?php echo anchor('grpo/refresh_po_list', '<strong>Refresh PO List</strong>','onClick="LoadingPOData();"');?></span></div><hr />
	<?php endif;?>
	<br /><i>Silahkan hubungi bagian inventory di SX untuk informasi lebih lanjut, jika Anda merasa ada kesalahan sistem atau Anda sedang menerima pengiriman barang namun nomor PO belum ada.</i><br />Silahkan email: <b>sap.helpdesk@ybc.co.id</b>
	</div>
	<?php } ?>	
	</td>
<?php endif; ?>
</tr>
<?php if(isset($_POST['po_no'])) : ?>
	<tr>
		<td width="272" class="table_field_1"><strong>Vendor Code  </strong></td>
		<td class="column_input"><?=form_hidden('grpo_header[kd_vendor]', $data['grpo_header']['VENDOR']);?><strong><?=$data['grpo_header']['VENDOR'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Vendor Name </strong></td>
		<td class="column_input"><strong><?=$data['grpo_header']['VENDOR_NAME'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><strong><?php if(!empty($data['grpo_header']['DELIV_DATE'])) : ?><?=$this->l_general->sqldate_to_date($data['grpo_header']['DELIV_DATE']);?><?php endif; ?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt Number </strong></td>
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
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
<?php endif; ?>
<?php if($data['po_no']!='-') : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
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