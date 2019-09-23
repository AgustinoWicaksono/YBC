<?php 
// print_r($this->session->userdata['ADMIN']); 

?>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>

<?=form_open($this->uri->uri_string(), $form);
?>
<div style="margin:0px 0px 0px 20px;padding:17px;border:#abc 1px solid;width:350px;">
<?php 
echo form_hidden('pass_email', trim(strtolower($this->session->userdata['ADMIN']['admin_email'])));
echo form_hidden('pass_storecode', trim(str_replace(" ","",strtolower($this->session->userdata['ADMIN']['storage_location_name']))));
echo form_hidden('plant_type_id', trim(str_replace(" ","",strtolower($this->session->userdata['ADMIN']['plant_type_id']))));
echo form_hidden('pass_name', trim($this->session->userdata['ADMIN']['admin_realname']));

?>
	<?=validation_errors('<div class="error">','</div>'); ?>
	<h2><?php echo $this->session->userdata['ADMIN']['storage_location_name']; ?></h2>
	<h4><?php echo $this->session->userdata['ADMIN']['plant_name']; ?></h4><br />
	Silahkan pilih <b>Username</b> yang ingin Anda ganti password:<br /><br />
	<div style="border-bottom:#aabbcc 1px solid;">
	<input type="checkbox" name="pass_manager" id="pass_manager" /> Manager
	</div>
	<div style="border-bottom:#aabbcc 1px solid;"><br />
	<input type="checkbox" name="pass_supervisor" id="pass_supervisor" /> Supervisor / MOD
	</div>
	<?php if ($this->session->userdata['ADMIN']['plant_type_id']!='RID') { ?>
	<div style="border-bottom:#aabbcc 1px solid;"><br />
	<input type="checkbox" name="pass_stocker" id="pass_stocker" /> Stocker
	</div>
	<?php } ?>
</div>
<div style="margin:0px 0px 0px 20px;padding:17px;width:350px;text-align:right;">
<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_submit'));?>
</div>
	<div style="clear:both;"></div>
	<br /><br />
    <?=anchor('/', $this->lang->line('button_back'));?>
<?=form_close();?>