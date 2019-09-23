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
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<th class="table_header_1">Delivery Date</th>
                    <th class="table_header_1">Material No</th>
					<th class="table_header_1">Material </th>
				</tr>
<?php
if($data['agging'] !== FALSE) :
	$i = 1;
	foreach ($data['agging']->result_array() as $agging):
?>
				<tr>
					<td class="table_content_1" width="200"><?=$agging['delivery_date'];?></td>
                    <td class="table_content_1" width="600"><?=$agging['material_no'];?></td>
					<td class="table_content_1" width="150"><?=$agging['material_desc'];?></td>
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
