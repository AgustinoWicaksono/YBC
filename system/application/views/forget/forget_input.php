<?php 
//print_r($this->session->userdata['ADMIN']); 

?>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>

<?=form_open($this->uri->uri_string(), $form);
?>
<div style="padding:17px;">
	<?=validation_errors('<div class="error">','</div>'); ?>
	Silahkan masukkan <b>Username</b> Anda di bawah ini.<br /><br />
	<div style="float:left;">
	<strong>Username</strong>: <?=form_input('password_username', $data['password_username'], ' maxlength="50" size="30" class="input_text"');?>
	</div><div style="float:left;margin-top:-2px;">
	&nbsp; <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_submit'));?>
	</div>
	<div style="clear:both;"></div>
	<br /><br />
    <?=anchor('/', $this->lang->line('button_back'));?>

<?=form_close();?>