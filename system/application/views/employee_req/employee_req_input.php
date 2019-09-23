<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
/*
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
*/
?>
<?=validation_errors('<tr><td colspan="2" class="error">','</td></tr>');?>
	<tr>
		<td width="272" class="table_field_1">Cabang</td>
		<td class="column_input"><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Standard Employee</td>
		<td class="column_input"><?=$data['outlet_employee']['STANDARD_EMPLOYEE'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Current Employee</td>
		<td class="column_input"><?=$data['outlet_employee']['CURRENT_EMPLOYEE'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Request</td>
		<td class="column_input"><?=date('d-m-Y');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><b>Requester</b></td>
		<td class="column_input"><b><?=$data['employee']['nama'];?></b></td>
	</tr>
	<tr>
       	<td width="272" class="table_field_1">Divisi</td>
        <?php if(!empty($data['req']['req_divisi'])) : ?>
		    <td class="column_input"><?=form_hidden('req[req_divisi]', $data['req']['req_divisi']);?><?=form_dropdown('req[req_divisi]', $divisi, $data['req']['req_divisi'], 'class="input_text" disabled="disabled"');?>
            <?php echo anchor('employee_req/input', '<strong>Pilih ulang Divisi</strong>');?></td>
        <?php else : ?>
		    <td class="column_input"><?=form_dropdown('req[req_divisi]', $divisi, $data['employee']['kode_divisi'], 'class="input_text" onChange="document.form1.submit();"');?>
            <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?></td>
        <?php endif; ?>
	</tr>
    <?php if(!empty($data['req']['req_divisi'])) : ?>
	<tr>
   		<td width="272" class="table_field_1">Department</td>
        <?php if(!empty($data['req']['req_dept'])) : ?>
    		<td class="column_input"><?=form_hidden('req[req_dept]', $data['req']['req_dept']);?><?=form_dropdown('req[req_dept]', $dept, $data['req']['req_dept'], 'class="input_text" disabled="disabled"');?></td>
        <?php else : ?>
    		<td class="column_input"><?=form_dropdown('req[req_dept]', $dept, $data['employee']['kode_dept'], 'class="input_text" onChange="document.form1.submit();"');?>
            <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?></td>
        <?php endif; ?>
	</tr>
        <?php if(!empty($data['req']['req_dept'])) : ?>
    	<tr>
    	<td width="272" class="table_field_1">Bagian</td>
         <?php if(!empty($data['req']['req_bagian'])) : ?>
      		<td class="column_input"><?=form_hidden('req[req_bagian]', $data['req']['req_bagian']);?><?=form_dropdown('req[req_bagian]', $bagian, $data['req']['req_bagian'], 'class="input_text" disabled="disabled"');?></td>
        <?php else : ?>
      		<td class="column_input"><?=form_dropdown('req[req_bagian]', $bagian, $data['employee']['kode_bagian'], 'class="input_text" ');?></td>
        <?php endif; ?>
    	</tr>
    	<tr>
          <?php if(!empty($data['req']['req_dept'])) : ?>
      		<td width="272" class="table_field_1">Jabatan</td>
      		<td class="column_input"><?=form_dropdown('req[req_jabatan]', $jabatan, $data['employee']['kode_job'], 'class="input_text" ');?>
              <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?></td>
          <?php endif; ?>
    	</tr>
        <?php endif; ?>
    <?php endif; ?>
</table>
<?=form_close();?>