<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));
if(($approved_data['sap_messages_type']=='E'))
 $succeed = FALSE;
else
 $succeed = TRUE;
?>
<table class="table-no-border">
	<tr>
        <?php if($succeed===FALSE) : ?>
		<td class="column_page_subject"><font color="#FF0000"><?=$this->lang->line('error');?></font></td>
        <?php else : ?>
		<td class="column_page_subject"><?=$this->lang->line('success');?></td>
        <?php endif; ?>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
	<tr>
        <?php if($succeed===FALSE) : ?>
		<td>Purchase Order tidak berhasil di-cancel release. <br >Pesan Kesalahan dari SAP :</td>
		<td><?=$approved_data['sap_messages'];?></td>
        <?php else : ?>
		<td>Purchase Order berhasil di-cancel release.</td>
        <?php endif; ?>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
</table>
