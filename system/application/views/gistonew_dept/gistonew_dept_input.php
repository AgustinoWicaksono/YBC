<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<p>
  <?=validation_errors('<div class="error">','</div>');?>
  <?=form_open($this->uri->uri_string(), $form1);?>
</p>
<table width="1038" border="0" align="center">
  <tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td class="table_field_h"><?php echo $this->m_gistonew_dept->posto_lastupdate(); ?>
        <?php
		/*mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		mysql_query("DELETE FROM t_gistonew_dept_detail_temp");*/
		 /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>
    </td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Store Room Request (SR)  Number</strong></td>
    <?php 
	
	if(!empty($data['do_no'])) : ?>
    <td valign="top" class="column_input"><?=form_hidden('do_no', $data['do_no']);?>
        <?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['do_no'])) : echo anchor('gistonew_dept/input', '<strong>Pilih ulang SR</strong>'); endif; endif;?>    </td>
    <?php else : ?>
    <?php if (count($do_no)>0) { ?>
    <td class="column_input">Anda memiliki <b style="color:#aa1122;"><?php echo count($do_no)-1; ?> nomor SR </b> yang harus <b><u>segera</u></b> diterima dan disetujui.
        <hr />
      <?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" onChange="document.form1.submit();"');?></td>
    <?php } else { ?>
    <td class="column_input"><b style="color:#aa1122;">Saat ini tidak ada nomor SR.</b><br />
        <i>Silahkan hubungi bagian inventory di SX untuk informasi lebih lanjut, jika Anda merasa ada kesalahan sistem.</i>
      <hr />
      Silahkan email: <b>sap.helpdesk@ybc.co.id</b></td>
    <?php } ?>
    <?php endif; ?>
  </tr>
  <?php if(isset($_POST['do_no'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Transfer Slip Number </strong></td>
    <td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Delivery Date </strong></td>
    <td class="column_input"><?php if(!empty($data['gistonew_dept_header']['DELIV_DATE'])) : ?>
        <?=$this->l_general->sqldate_to_date($data['gistonew_dept_header']['DELIV_DATE']);?>
      <?php endif; ?></td>
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
  <?php if(!empty($data['do_no'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Material Group</strong></td>
    <td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
  </tr>
  <?php endif; ?>
</table>
<p>&nbsp;</p>
<p>
  <?=form_close();?>
</p>
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
