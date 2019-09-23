<?php
$swbcssver=59;
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
header("Pragma: no-cache");
$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

$controller = $this->uri->segment(1);

if (!$this->l_auth->is_logged_in())
{
	$this->session->set_userdata('lang_name', 'indonesian');
	$this->session->set_userdata('lang_id', '1');
	$this->session->set_userdata('template', 'default');
}

$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_auth', $this->session->userdata('lang_name'));
$this->load->helper('url');

$menu = $this->l_menu->get_menu();
//echo $this->uri->segment(1);
$page = $this->m_page->page_select($this->uri->segment(1), $this->uri->segment(2));
$heads = $this->m_head->heads_select($this->uri->segment(1), $this->uri->segment(2));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ID" lang="ID" >
<head>
<script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Language" content="id" />
<meta http-equiv="Copyright" content="YBC" />
<meta http-equiv="Author" content="YBC" />
<meta name="rating" content="General" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 26 Jul 1997 05:00:00 GMT" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 
$jag_page_title = $page_title;
if (Empty($jag_page_title)) $jag_page_title = "";
if (strpos($jag_page_title,"<")>0) {
	$jag_page_title = explode("<",$jag_page_title);
	$jag_page_title = $jag_page_title[0];
}
$jag_page_title = strip_tags($jag_page_title);
$jag_page_title = trim($jag_page_title);
$jag_user_title = trim($this->session->userdata['ADMIN']['admin_realname']);
if ($jag_user_title!="") $jag_user_title = " | ".$jag_user_title;


if($jag_page_title!="") : ?>
<title><?=$jag_page_title;?> - <?=$this->m_config->content_select('main_sitename');?><?=$jag_user_title;?></title>
<?php else : ?>
<title><?=$this->m_config->content_select('main_sitename');?></title>
<?php endif; ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="icon" type="image/png" href="<?=base_url();?>favicon.png">
<!-- Start of menu and main CSS //-->
<style type="text/css">@import url(<?=base_url();?>css/swebee.css?v=<?php echo $swbcssver; ?>);</style>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/main.css?v=<?php echo $swbcssver; ?>" />
<link href="<?=base_url();?>css/dropdown.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>css/default.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>css/default.ultimate.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />

<!-- End of menu and main CSS //-->
<script src="<?=base_url();?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
var jagservtime = new Date(<?php echo date('y,n,j,G,i,s'); ?>);
</script>
<script src="<?=base_url();?>js/time.js" type="text/javascript"></script>


<?php if ( ( $this->l_auth->is_logged_in() )) : ?>
<script language="javascript" type="text/javascript">
<!--
	function confirm_logout(url) {
		var m = confirm('<?=$this->lang->line('auth_logout_confirm');?>');
		if(m) {
			location.href=url;
		}
	}
//-->
</script>
<?php endif; ?>
<?php //additional code in <HEAD> section
if($heads !== FALSE) {
	foreach ($heads->result_array() as $head) {
/*		eval('?>' . $head['script_content'] . '<?php'); */
		eval('?>' . $head['script_content']);
	}
}
?>
<?php if($refresh): ?>
	<meta http-equiv="refresh" content="<?=$refresh_time;?>;url=<?=site_url($refresh_url);?>" />
	
<?php endif; ?>

</head>

<?php if(!empty($page['page_focus'])) : ?>
<body onload="self.focus();document.<?=$page['page_focus'];?>.focus()">

<?php else : ?>
<body>
<?php endif; ?>
<?php if (($this->session->userdata('logged_in'))&& ($controller != 'po_approval')) { 
include_once (APPPATH."views/currentprocess.php");
 } 

 $jagcompany="YBC";

// print_r($this->session->userdata['ADMIN']);

$office_array = $this->m_constant_fixed->office_plants();
$is_office = array_search($this->session->userdata['ADMIN']['plant'], $office_array);
if (Empty($is_office)) $is_office = -1;
$logo_company = strtolower($this->session->userdata['ADMIN']['plant_type_id']);
if ($is_office>-1) $logo_company = 'ybc';
?>
<div id="jaghead" class="swbbodyb">
    <?php if($this->session->userdata('logged_in')&& $controller != 'po_approval') : ?>
	<div style="float:left;margin-right:5px;padding:5px;height:70px;">
		<div style="float:left;margin-right:5px;">
		
        <img src="<?=base_url();?>images/ybc-logo-small.png" border="0" alt="" />
		</div>
		<div style="float:left;margin-right:15px;">
		
         <strong style="font-size:120%;"><?php echo $this->session->userdata['ADMIN']['plant_name'];?></strong><br />
		 <a href="<?=base_url();?>store"><?php echo $this->session->userdata['ADMIN']['storage_location_name'];?></a> / <?php echo $this->session->userdata['ADMIN']['plant'];?>
<?php if (strlen($this->session->userdata['ADMIN']['plants'])>8) { ?>		
         <span class="jchange"><a href="<?=base_url();?>plant/change/<?php echo $controller; ?>" title="Ganti Outlet">Ganti Outlet</a></span>
<?php } ?>		 
         </div>
	</div>
    <? endif; ?>
         <?php if($controller != 'po_approval') : ?>
		<div style="<?php if($this->session->userdata('logged_in')) {?>border-left:#778899 2px solid;<?php } ?>float:left;margin-right:5px;padding:7px;"><?=$this->session->userdata('redirect_login');?><div class="jag_title"><?=$this->m_config->content_select('main_sitename');?></div>
        <?php else : ?>
		<div style="float:left;margin-right:5px;"><?=$this->session->userdata('redirect_login');?><div class="jag_title">Purchase Order Approval</div>
         <? endif; ?>
        <?php if($this->session->userdata('logged_in')) : ?>
        <br /><div style="float:left;margin-top:-1px;margin-right:3px;"><img src="<?=base_url();?>images/user.png" alt="" border="0" /></div> <strong style="color:#337ac3;"><?php
			if (!Empty($this->session->userdata['ADMIN']['employee_name'])) echo $this->session->userdata['ADMIN']['employee_name']. ' ['.$this->session->userdata['ADMIN']['admin_username'].']';
			else echo $this->session->userdata['ADMIN']['admin_realname']. ' ['.$this->session->userdata['ADMIN']['admin_username'].']';
		?></strong>
		<span style="color:#AEAEAE;"> &nbsp; | &nbsp; 
         <?php if($controller != 'po_approval') : ?>
         <?=anchor('user/password_edit', 'Ubah Password');?>
         <? endif; ?>
         &nbsp; | &nbsp; <a href="#" onClick='confirm_logout("<?=site_url('logout');?>")'>Sign Out</a>
         <? endif; ?>
		 <br />&nbsp;
         </div>
		 <?php if($this->session->userdata('logged_in')) { ?>
         <div style="float:right;margin-left:5px;padding:7px;"><?php /* <img src="<?=base_url();?>images/sap-logo.png" alt="SAP" title="Powered by SAP" border="0" /> */ ?>
         </div>
		 <?php } else { ?>
         <div style="float:right;margin-left:5px;padding:7px 7px 3px 3px;">
		 <img src="<?=base_url();?>images/ybc-logo-small.png?v=1" border="0" alt="JCO" width="70" height="27" title="YBC Software" alt="YBC Software" />
         </div>
		 <?php } ?>
		 
		 <div style="clear:both;"></div>
</div>

<?php if($this->session->userdata('logged_in')&& $controller != 'po_approval') : ?>


<?php $startup = $this->session->userdata('startup'); ?>
<?php if ( $this->l_auth->is_logged_in() && $controller != 'po_approval') : ?>
<div class="menu_bar">
<div style="text-align:right;" id="jag_time">Load time...</div>
		<?=$this->l_menu->create_menu($menu);?>
<div style="clear:both;"></div>
</div>
<?php else : ?>
		<?=$this->l_menu->blank_menu();?>
<?php endif; ?>

<? endif; ?>


<div class="wrapper">
<?php 
	echo $content;
?>
</div>
<div id="jagfoot">
&copy;<?php echo date('Y'); ?> YBC Software &mdash; Indonesia. All rights reserved.
</div>
<amp-auto-ads type="adsense" data-ad-client="ca-pub-9603648248729539"></amp-auto-ads>
</body>
</html>