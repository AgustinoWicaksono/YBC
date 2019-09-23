<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td class="table_field_h"><?php echo $this->m_retin->posto_lastupdate(); ?> 
<?php /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>    </td>
	</tr>
	<tr>
    <td class="table_field_1"><strong>Retur Out Number</strong></td>
  <?php 
	
	if(!empty($data['do_no'])) : ?>
		<td class="column_input"><?=form_hidden('do_no', $data['do_no']);?>
	    <?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" disabled="disabled"');?>		  <?php if(!empty($_POST)) : if(!empty($data['do_no'])) : echo anchor('retin/input', '<strong>Pilih ulang Delivery Order</strong>'); endif; endif;?>        </td>
<?php else : ?>
		<?php if (count($do_no)>0) { ?>
		<td class="column_input">Anda memiliki <b style="color:#aa1122;"><?php echo count($do_no)-1; ?> nomor Retur Out No </b>yang harus <b><u>segera</u></b> diterima dan disetujui.
		  <hr /><?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" onChange="document.form1.submit();"');?></td>
		<?php } else { ?>
		<td class="column_input"><b style="color:#aa1122;">Saat ini tidak ada nomor Retur Out</b> <b style="color:#aa1122;">No</b><br />
	  <i>Silahkan hubungi bagian inventory di SX untuk informasi lebih lanjut, jika Anda merasa ada kesalahan sistem.</i><hr />Silahkan email: <b>sap.helpdesk@ybc.co.id</b></td>
	  <?php } ?>
	<?php endif; ?>
	</tr>
<?php if(isset($_POST['do_no'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Retur In Number </strong></td>	
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr> 
		<td class="table_field_1"><strong>Delivery Date </strong></td>
		<td class="column_input"><?php if(!empty($data['retin_header']['DELIV_DATE'])) : ?><?=$this->l_general->sqldate_to_date($data['retin_header']['DELIV_DATE']);?><?php endif; ?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet From</strong></td>
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
<?=form_close();?>