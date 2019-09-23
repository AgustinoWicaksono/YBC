<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space"><?=anchor('sinkron/input', 'Add New Position');?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<th class="table_header_1">Position</th>
					<th class="table_header_1">Aksi</th>
				</tr>
<?php
if($data['sinkron'] !== FALSE) :
	$i = 1;
	foreach ($data['sinkron']->result_array() as $sinkron):
?>
				<tr>
					<td class="table_content_1" width="150"><?=$sinkron['NoPeg'];?></td>
					<td class="table_content_1" width="150"><?=$sinkron['NamaPertama'];?></td>
					<td class="table_content_1" width="*">
<?=anchor_image('sinkron/edit/'.$sinkron['id_sinkron'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?></td>
				</tr>
<?php
	endforeach;
endif;
?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
</table>
