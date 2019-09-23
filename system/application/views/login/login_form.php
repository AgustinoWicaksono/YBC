<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_auth', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
if(!isset($error_db_access))
	$error_db_access = FALSE;
//echo "<pre>";
//print_r($this->session->userdata);
//echo "</pre>";

?>
<?=form_open($this->uri->uri_string(), $form)?>

<div class="swbbodyb" style="min-height: 100%;height: 100%;display:block;width:300px;float:right;margin:30px 70px 10px 35px;padding:20px;background-color:#E7EBF1;border:#95B3D7 1px solid;">
<?php /*
<img src="<?=base_url();?>images/sap-logo.png" border="0" alt="SAP" title="Powered by SAP" align="right"/>
*/ ?>
<div>
<div style="float:left;margin:5px 3px 0px 0px;">
<img src="<?=base_url();?>images/key.png" border="0" alt="Sign In" />
</div>
<h2 style="font-weight:normal;">Sign in ke YBC SAP Portal</h2>
<i style="color:#aa1122;">(perhatikan huruf besar / kecil)</i>
</div>
<?php if ($error_db_access == TRUE) : ?>
	<div class="error" style="margin-top:15px;"><?php echo $error_message;?></div>
<?php else : ?>
	<div class="error" style="margin-top:15px;"><?=validation_errors('<div class="error">','</div>');?></div>
<?php endif ?>
<br /><br />
<?=$this->lang->line('auth_username');?><br />
<?=form_input('username', $this->input->post('email_address'), 'class="swbinput" style="font-size:14px;" size="35"');?>
<br />
<br />
<?=$this->lang->line('auth_password');?><br />
<?=form_password('password', '', 'class="swbinput" style="font-size:14px;" size="35"');?><br />

<br />
<br />
<?=form_submit($this->config->item('button_login'), $this->lang->line('button_login'));?>
<br /><br />
<a href="<?=base_url();?>forget" title="Lupa password">Klik di sini jika Anda lupa password</a>
</div>

<?=form_close();?>
<div class="swbbodyb" style="font-size:120%;padding:30px 100px 30px 50px;">
<?php include_once("pengumumanlogin.php"); ?>

</div>