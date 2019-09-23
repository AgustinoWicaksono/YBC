<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form);
$function = $this->uri->segment(2)?>
<?=form_hidden('id_trend_utility_header', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
	<tr>
		<td colspan="4" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpo_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST)&&($function!='edit')) {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['posting_date'])) {
        $posting_date_tmp = $this->session->userdata('posting_date');
	    if (empty($posting_date_tmp)) {
    		$posting_date = date("d-m-Y", strtotime($data['posting_date']));
        } else {
    		$posting_date = $posting_date_tmp;
            unset($posting_date_tmp);
        }
    }
?>
		<td class="column_input"><?php if(($data['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('posting_date', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'posting_date'
					});
		</script><?php else: ?><?=$posting_date;?>
                 <?=form_hidden('posting_date', $posting_date);?>
                 <?php endif;?></td>
	</tr>
				<tr>
					<td class="table_field_1"><strong>Document No.</strong></td>
					<td class="column_input">
                    <?=empty($data['trend_utility_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['trend_utility_no'];?>
                    <?=form_hidden('trend_utility_no', $data['trend_utility_no']);?></td>
				</tr>
				<tr>
					<td class="table_field_1"><strong>Plant</strong></td>
					<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?>
                    <?=form_hidden('plant', $data['plant']);?></td>
				</tr>
				<tr>
					<td class="table_field_1"><strong>KWH Awal</strong></td>
					<td class="column_input"><?php if($data['status'] != '2') : ?>
                    <?=form_input('kwh_awal', $data['kwh_awal'], 'onChange="changeVal(this)"class="input_text"');?>
                    <?php else: ?>
                    <?=$data['kwh_awal'];?>
                    <?=form_hidden('kwh_awal', $data['kwh_awal']);?>
                    <?php endif;?>
                    </td>
				</tr>
				<tr>
					<td class="table_field_1"><strong>KWH Akhir</strong></td>
					<td class="column_input"><?php if($data['status'] != '2') : ?>
                    <?=form_input('kwh_akhir', $data['kwh_akhir'], 'onChange="changeVal(this)" class="input_text"');?>
                    <?php else: ?>
                    <?=$data['kwh_akhir'];?>
                    <?=form_hidden('kwh_akhir', $data['kwh_akhir']);?>
                    <?php endif;?></td>
				</tr>
				<tr>
<script language="javascript">
function changeVal(obj) {
	var y = 'kwh_awal';
	var x = 'kwh_akhir';
	var z = 'kwh_total';
	var num = 0;
	var result = 0;

	if(obj.form.elements[x].value == '') {
		obj.form.elements[x].value = 0;
	} else if(obj.form.elements[y].value == '') {
		obj.form.elements[y].value = 0;
	}
    num = parseFloat(obj.form.elements[x].value) - parseFloat(obj.form.elements[y].value);
	result = num.toFixed(2);
	obj.form.elements[z].value = result;
}
</script>
					<td class="table_field_1"><strong>KWH Total</strong></td>
					<td class="column_input"><?php if($data['status'] != '2') : ?>
                    <?=form_input('kwh_total', $data['kwh_total'], 'class="input_text"');?>
                    <?php else: ?>
                    <?=$data['kwh_total'];?>
                    <?=form_hidden('kwh_total', $data['kwh_total']);?>
                    <?php endif;?></td>
				</tr>
				<tr>
					<td class="table_field_1"><strong>Jam Pencatatan</strong></td>
					<td class="column_input">
                    <?php if(!empty($data['jam_pencatatan'])) : ?>
                    <?=$data['jam_pencatatan'];?>
                    <?php else : ?>
                    <em>(Otomatis pada saat save/approve)</em>
                    <?php endif ?>
                    </td>
				</tr>
            	<tr>
            		<td class="table_field_1"><strong>Status </strong></td>
            		<td class = "column_input"><strong><?=($data['status'] == '2') ? 'Approved' : 'Not Approved';?></strong>
                    <?=form_hidden('status', $data['status']);?>
                    <?=form_hidden('id_trend_utility_plant', $data['id_trend_utility_plant']);?></td>
            	</tr>
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['status'] == '2') : ?><?php if(empty($data['material_docno_cancellation'])) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_cancel').' Trend Utility');?><?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
         <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
         <?php endif; ?>
          <a href="#" onclick="window.open('<?=base_url();?>help/Trend utility.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('trend_utility/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>