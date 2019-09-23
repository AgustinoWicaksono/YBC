<?php
include_once("servermode.php");
$swbDomain = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].str_replace('//','/',dirname($_SERVER['SCRIPT_NAME']).'/');
?>
<h1>CURRENT STATUS</h1>
<?php echo "Date/Time: ".date('D, d M Y - H:i:s'); ?>
<br />
Status: <b style="font-size:170%;"><?php echo $SAPserverstatus;?></b><br /><hr /><br />
<h1>Turn On / Off SAP Connection from Web Server</h1><br /><hr /><br />
<b><a href="<?php echo $swbDomain; ?>systemstatus.php?mode=on" style="color:#008000;">Turn On SAP Connection</a></b><br /><hr /><br /><b><a href="<?php echo $swbDomain; ?>systemstatus.php?mode=off"  style="color:#e01818;">Turn Off SAP Connection</a></b>
<br /><br />&nbsp;<hr />
