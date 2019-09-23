<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));
?>
<table class="table-no-border">
	<tr>
		<td class="column_page_subject"><font color="#FF0000"><?=$this->lang->line('error');?></font></td>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>User Id anda tidak berhak untuk melakukan approval terhadap PO ini. <br>
            Silakan Logout terlebih dahulu, kemudian login kembali dengan 
            menggunakan user id yang berhak utk melakukan PO Approval.</td>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
</table>
