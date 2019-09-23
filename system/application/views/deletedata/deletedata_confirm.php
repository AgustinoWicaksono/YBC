<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>

<?=form_open('deletedata/delete_execute', $form1);?>
<?=form_hidden('delete_date', $data['delete_date']);?>
<?=form_hidden('delete_tgl', $data['delete_tgl']);?>
<?=form_hidden('delete_option', $data['delete_option']);?>
<div style="background-image:url(<?=base_url();?>images/question.png);background-repeat:no-repeat;padding:17px;padding-left:135px;">

	Anda yakin akan <b><?php if ($data['delete_option']=="delete") echo "menghapus"; else echo "me-reset"; ?> data</b> dengan <b>POSTING DATE</b> dan <b>OUTLET</b> di bawah ini?<br />Teliti kembali sebelum melanjutkan karena setelah menjalankan proses ini tidak bisa dikembalikan!<br /><br />
	<div style="width:300px;display:block;">
		<div style="padding:10px;border:#AA1122 2px solid;background-color:#fde2dc;">
			<ul>
			<li>Posting Date: <b><?php echo $data['delete_tgl'];?></b></li>
			<li>Plant: <b><?php echo $this->session->userdata['ADMIN']['plant']; ?></b></li>
			<li>Outlet: <b><?php echo $this->session->userdata['ADMIN']['storage_location_name']." - ".$this->session->userdata['ADMIN']['plant_name']; ?></b></li>
			</ul>
		</div>
		<br /><br />
		<div style="text-align:center;">
		&nbsp; <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_submit'));?>
		</div>
	</div>
	<div style="clear:both"></div><br />   <?=anchor('/', $this->lang->line('button_back'));?>
<?=form_close();?>
</div>
