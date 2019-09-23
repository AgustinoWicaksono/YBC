 <?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_employee_delete(url, id_employee_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Karyawan dengan ID "' + id_employee_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table>
<?=form_open('employee_shift/browse_search', $form1);?>
	<tr>
		<td><b>Cabang</b></td>
		<td><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
  <tr>
    <td align="center"><strong>Tanggal</td>
		<td><?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});

		</script> s/d <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});

					</script></strong>
    </td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'View');?></td>
  </tr>
</table>
<?php
if(isset($_POST['date_from']) || isset($_POST['date_to'])) :
?>

<table border="0" align="center">
	<tr class="table_header_1">
		<th class="table_header_1">NIK</th>
<?php

$date_current =
for($i = 1; $i < $days; $i++) {
?>
		<th width="150" class = "table_header_1"><?=date<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?> <?=
		<th width="150" class = "table_header_1">Nama<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?></th>
		<th width="200" class = "table_header_1">Divisi<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class="table_header_1">Department<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class ="table_header_1">Bagian<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class="table_header_1" >Jabatan<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class="table_header_1" >Golongan<br /><?=anchor_image($sort_link['gy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['gz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class="table_header_1" >Level<br /><?=anchor_image($sort_link['hy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['hz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="200" class="table_header_1" >ID Finger Print<br /><?=anchor_image($sort_link['iy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['iz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="180" class ="table_header_1">Status Kerja<br /><?=anchor_image($sort_link['jy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['jz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="180" class ="table_header_1">Tanggal Akhir Kontrak<br /><?=anchor_image($sort_link['ky'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['kz'],'Z-A', 'panahatas.jpg');?></th>
  </tr>
<?=form_open('employee/delete_multiple_confirm', $form2);?>
<?php
if($data['employees'] !== FALSE) :
	$i = 1;
	foreach ($data['employees']->result_array() as $employee):
?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
		<td><?=form_checkbox('employee_id['.$i.']', $employee['employee_id'], FALSE);?></td>
		<td align="left" nowrap="nowrap"><?=anchor_image('employee/edit/'.$employee['employee_id'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?> <?php if($employee['status'] == 1) : ?><a href="#" onClick='confirm_employee_delete("<?=site_url('employee/delete/'.$employee['employee_id']);?>", "<?=$employee['employee_id'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
		<td><?=$employee['nik'];?></td>
		<td><?=$employee['nama'];?></td>
		<td><?=$employee['divisi'];?></td>
		<td><?=$employee['department'];?></td>
		<td><?=$employee['bagian'];?></td>
		<td><?=$employee['jabatan'];?></td>
		<td><?=$employee['golongan'];?></td>
		<td><?=$employee['level'];?></td>
		<td><?=$employee['fingerprint_id'];?></td>
		<td><?=$employee['status_kerja'];?></td>
		<td><?=$employee['tanggal_akhir'];?></td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="11"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
<?php
endif;
?>