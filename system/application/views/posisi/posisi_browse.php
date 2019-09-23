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
				<th class="table_header_1">No</th>
					<th class="table_header_1">Modul</th>
                    <th class="table_header_1">Message</th>
					<th class="table_header_1">Error Time</th>
					<th class="table_header_1">Trans ID</th>
					<th class="table_header_1">Edit</th>
				</tr>
<?php
if($data['posisi_headers'] !== FALSE) :
	$i = $start;
	foreach ($data['posisi_headers']->result_array() as $posisi):
	$mod =$posisi['modul'];
	
	if ($mod=='Good Issue from Production' || $mod=='Good Receipt Produksi')
	{
		//echo "abc";
		$modul='produksi';
	}else if ($mod=='Purchase Request')
	{
		$modul='pr';
	}else if ($mod=='Store Room Request')
	{
		$modul='stdstock';
	}else if ($mod=='GR PO From Vendor')
	{
		$modul='grpo';
	}else if ($mod=='Good Issue')
	{
		$modul='issue';
	}else if ($mod=='Good Receipt Whole to Slice'||$mod=='Good Issue from Whole Outlet')
	{
		//echo "123";
		$modul='twtsnew';
	}else if ($mod=='Transfer Out Inter Outlet')
	{
		$modul='gistonew_out';
	}else if ($mod=='Retur')
	{
		$modul='gisto_dept';
	}else if ($mod=='Purchase Request')
	{
		$modul='pr';
	}else if ($mod=='Store Room Request')
	{
		$modul='stdstock';
	}else if ($mod=='GR From Sentul')
	{
		$modul='grpodlv';
	}else if ($mod=='Stock Counting Opname')
	{
		$modul='opname';
	}else if ($mod=='Transfer In Inter Outlet')
	{
		$modul='grsto';
	}
?>
				<tr>
				<td class="table_content_1" width="10"><?=$i;?></td>
					<td class="table_content_1" width="200"><?=$posisi['modul'];?></td>
                    <td class="table_content_1" width="600"><?=$posisi['message'];?></td>
					<td class="table_content_1" width="150"><?=$posisi['time_error'];?></td>
					<td class="table_content_1" width="150"><?=$posisi['id_trans'];?></td>
					<?php if  ($modul!='issue' && $modul !='twtsnew' && $modul != 'grpodlv' && $modul !='opname' && $modul !='grpo' && $modul !='grsto')
					{?>
					<td class="table_content_1" align="left" nowrap="nowrap"><?=anchor_image($modul.'/edit/'.$posisi['id_trans'].'/'.$produksi_header['receiving_plant'].'/'.$produksi_header['item_group_code'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> </td>
					<?php
					}else if ($modul=='grpodlv' || $modul =='grpo' || $modul =='grsto')
					{ ?>
					<td class="table_content_1" align="left" nowrap="nowrap"><?=anchor_image($modul.'/edit/'.$posisi['id_trans'], 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> </td>	
					<?php }
					else
					{
					?>
					<td class="table_content_1" align="left" nowrap="nowrap"><?=anchor_image($modul.'/edit/'.$posisi['id_trans'].'/all/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> </td>
					<?php }?>
				</tr>
<?php
$i++;
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
