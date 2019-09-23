<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div align="center" class="page_title"><?=$page_title;?></div>
<p align="center">&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?=form_hidden('id_posinc_header', $this->uri->segment(3));?>
<table width="652" border="0" align="center">
<tr>
		<td colspan="4" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
  <tr>
    <td width="305" class="table_field_1"><strong>Posting Date</strong></td>
<!--    <td width="437"  class="column_input">><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpo_header']['posting_date']));?></td>//-->
	<?php
    $function = $this->uri->segment(2);
	if(empty($_POST)&& $function == 'input') {
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
	 <td class="column_input"><?php if(($data['status'] !== '2')&&($function == 'input')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('posting_date', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'posting_date'
					});
		</script><?php else: ?><?=$posting_date;?>
        <?=form_hidden('posting_date', $posting_date);?><?php endif;?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Plant</strong></td>
    <td class="column_input"><strong>
     <?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?>
    </strong><?=form_hidden('plant', $data['plant']);?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Total Remintance / Uang Setor </strong></td>
     <td class="column_input"><?php if($data['status'] == '2') : ?>
     <?=number_format($data['total_remintance'], 2, '.', ',');?>
     <?=form_hidden('total_remintance', $data['total_remintance']);?>
     <?php else: ?>
     <?=form_input('total_remintance', $data['total_remintance'], 'class="input_text"');?>
     <?php endif;?></td>
  </tr>
    <tr>
    <td class="table_field_1"><strong>End of Day</strong></td>
    <td class="column_input"><?php if($data['status'] == '2') : ?>
        <?=($data['ok'] == '1') ? 'Y' : 'N';?>
        <?=form_hidden('ok', $data['ok']);?>
    <?php else: ?>
        <?=form_checkbox('ok', 1, $data['ok']);?>
    <?php endif;?></td>
    </tr>
  	<tr>
  		<td class="table_field_1"><strong>Status </strong></td>
  		<td class = "column_input"><strong><?=($data['status'] == '2') ? 'Approved' : 'Not Approved';?></strong>
          <?=form_hidden('status', $data['status']);?></td>
  	</tr>
  <tr>
    <td class="table_field_1"><strong>Waste Material Document No.</strong></td>
     <td class="column_input"><?=$data['waste_no'];?><?=form_hidden('waste_no', $data['waste_no']);?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Stock Opname Document No.</strong></td>
     <td class="column_input"><?=$data['stockoutlet_no'];?><?=form_hidden('stockoutlet_no', $data['stockoutlet_no']);?></td>
  </tr>
  </table>
<p>&nbsp;</p>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
		<td align="center">
        <?php if((empty($data['waste_no']))&&($data['status'] != '2')) : ?>
        <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php endif; ?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
<?php /*		

        <?php if(empty($data['waste_no'])) : ?>
        <?=form_submit($this->config->item('button_approve_waste'), $this->lang->line('button_approve').' Waste Material');?><?php endif;?>
*/	?>	
        <?php if(empty($data['stockoutlet_no'])) : ?>
        <?=form_submit($this->config->item('button_approve_stockopname'), $this->lang->line('button_approve').' Stock Opname');?><?php endif;?>
        <?php endif; ?><a href="#" onclick="window.open('<?=base_url();?>help/End of Day.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('posinc/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
