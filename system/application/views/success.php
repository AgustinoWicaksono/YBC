<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));

?>
<div style="padding:17px;">

<div style="float:left;margin-right:10px;">
<img src="<?=base_url();?>images/success.png" alt="Error" border="0" />
</div>
<div style="display:block;float:left;"><h2>TRANSAKSI BERHASIL</h2>


<?php 
	// echo $this->lang->line('error');
	$success_text = $refresh_text;
	
	?><br /><br />
	<div style="color:#6c9a08;font-weight:bold;font-size:12px;">
	<?php echo $success_text; ?>
	</div>
	
	</div><div style="clear:both;"></div><br />
<?php
if($refresh == 1)
	echo sprintf($this->lang->line('redirect_refresh_text'), $refresh_time, site_url($refresh_url));
else
	echo sprintf($this->lang->line('redirect_no_refresh_text'), site_url($refresh_url));
?>
</div>