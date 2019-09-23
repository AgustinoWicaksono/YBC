<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant = $this->session->userdata['ADMIN']['plant'];
$plant_name = $this->session->userdata['ADMIN']['plant_name'];
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<style type="text/css">
<!--
.style5 {font-size: 9px}
-->
</style>
<?php if(!empty($page['page_name'])) : ?>
<title><?=$this->lang->line('page_'.$page['page_name']);?> - <?=$this->m_config->content_select('main_sitename');?></title>
<?php else : ?>
<title><?=$this->m_config->content_select('main_sitename');?></title>
<?php endif; ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Start of menu and main CSS //-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/main.css" />
<style type="text/css">
<!--
.style11 {	font-size: 27px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div align="center" class="page_title">
  <p align="left"><span class="style11"><u>THE HARVEST </u></span><br />
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="style5">Partisier &amp; Chocolatier</span> </p>
  <p>
    <?=$page_title;?>
    <br />
    Outlet 
    <?=$plant;?> 
    - 
    <?=$plant_name;?>
    <br />
    Tanggal </p>
<?=$date_from.' sampai '.$date_to;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$swbQuery="SELECT user,module,date,d_admin.admin_realname FROM t_delete join d_admin on t_delete.user=d_admin.admin_id WHERE t_delete.plant='$plant' ";
$tmp=mysql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>User Delete History</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="459" border="1" align="center" class="table">
  <tr>
    <td width="72" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="168" align="center" bgcolor="#999999"><strong><span class="style5">User</span></strong></td>
    <td width="100" align="center" bgcolor="#999999"><strong><span class="style5">Module</span></strong></td>
    <td width="100" align="center" bgcolor="#999999"><strong><span class="style5">Date</span></strong></td>
    
  </tr>
  <?php
  $no=1;
	while($r=mysql_fetch_array($tmp))
	{
?>
  <tr>
  
    <td><span class="style5"><?=$no++;?></span></td>
    <td><span class="style5"><?=$r['admin_realname'];?></span></td>
    <td><span class="style5"><?=$r['module'];?></span></td>
    <td><span class="style5"><?=$r['date'];?></span></td>
    
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  </table>
  
</body>

</html>