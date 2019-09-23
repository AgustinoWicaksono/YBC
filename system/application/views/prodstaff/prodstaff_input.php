<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {color: #0000FF}
.style4 {color: #FF0000}
.style5 {font-weight: bold}
-->
</style>
</head>

<body>
<div align="center"  class="page_title"><strong>Productivity Staff / Labor Per Store Per Days Per Hour Per Department </strong></div>
<p align="center">&nbsp;</p>
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
$function = $this->uri->segment(2)
?>
<table width="806" border="0" align="center">
<?=form_open($this->uri->uri_string(), $form1);?>
	<tr>
		<td width="272" class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpo_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST)&&($function!='edit')) {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['prodstaff_header']['posting_date'])) {
        $posting_date_tmp = $this->session->userdata('posting_date');
	    if (empty($posting_date_tmp)) {
    		$posting_date = date("d-m-Y", strtotime($data['prodstaff_header']['posting_date']));
        } else {
    		$posting_date = $posting_date_tmp;
            unset($posting_date_tmp);
        }
    }
?>
		<td class="column_input"><?php if(($data['prodstaff_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input("prodstaff_header[posting_date]", $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'prodstaff_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("prodstaff_header[posting_date]", $posting_date);?><?php endif;?>
        <?=form_hidden("prodstaff_header[id_prodstaff_header]", $data['prodstaff_header']['id_prodstaff_header']);?></td>
	</tr>
  <tr>
    <td class="table_field_1"><strong>Plant</strong></td>
    <td class="column_input" ><strong><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?>
                    <?=form_hidden("prodstaff_header[plant]", $data['prodstaff_header']['plant']);?> </strong></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Status </strong></td>
    <td class="column_input"><strong><?=($data['prodstaff_header']['status'] == '2') ? 'Approved' : 'Not Approved';?></strong>
                    <?=form_hidden("prodstaff_header[status]", $data['prodstaff_header']['status']);?></td>
  </tr>
</table>
<table width="809" height="26" border="0" align="center">
  <tr>
    <td width="803"><span class="style5"><strong>List of Productivity Staff </strong></span></td>
  </tr>
</table>
<table width="813" border="0" align="center">
  <tr bgcolor="#999999">
    <td width="30" class="table_header_1"><strong>No.</strong></td>
    <td width="204" class="table_header_1"><strong>Position</strong></td>
	<td width="174" class="table_header_1"><div align="left"><strong>Employee Status </strong></div></td>
    <td width="218" class="table_header_1"><strong>Sum of Empoyee <br />( Attendance ) </strong></td>
    <td width="151" class="table_header_1"><strong>Total Working Hour </strong></td>
  </tr>
<?php
if(!empty($data['prodstaff_details'])) :
	$i =0;
     	foreach ($data['prodstaff_details'] as $data_prodstaff_detail):
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

    <?php   endif; ?>
     <?php $i++ ;  ?>


     <td><?=$i;?><?=form_hidden("prodstaff_detail[id_prodstaff_h_detail][$i]", $i);?>
     <?=form_hidden("prodstaff_detail[id_prodstaff_detail][$i]", $data_prodstaff_detail['id_prodstaff_detail']);?></td>
    <td><?=$data_prodstaff_detail['posisi'];?>
    <?=form_hidden("prodstaff_detail[id_posisi][$i]", $data_prodstaff_detail['id_posisi']);?>
    <?=form_hidden("prodstaff_detail[posisi][$i]", $data_prodstaff_detail['posisi']);?>
    </td>
	 <td class = ""><?=$data_prodstaff_detail['status'];?>
     <?=form_hidden("prodstaff_detail[id_status][$i]", $data_prodstaff_detail['id_status']);?>
      <?=form_hidden("prodstaff_detail[status][$i]", $data_prodstaff_detail['status']);?>
      </td>
 	 <td class = "" align="center"><?=form_input("prodstaff_detail[jml_karyawan][$i]", $data_prodstaff_detail['jml_karyawan'], 'class="input_text" size="10"');?></td>
	 <td class = "" align="center"><?=form_input("prodstaff_detail[total_jam][$i]", $data_prodstaff_detail['total_jam'], 'class="input_text" size="10"');?></td>

  </tr>
   <?php

    endforeach;

endif;?>
 </table>
<p>&nbsp;</p>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <tr>
    	<td align="center"><?php if($data['prodstaff_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_change')) : ?>
        <?=form_submit($this->config->item('button_change'), $this->lang->line('button_change'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Productivity staff.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('prodstaff/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>

</body>
</html>
