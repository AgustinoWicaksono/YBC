<?php

$servermode = @$_GET['mode'];
if (Empty($servermode)) $servermode = "on";
$servermode = strtolower($servermode);
if (($servermode!="off") && ($servermode!="on")) $servermode = "on";

if ($servermode=="on")
	$handle = '<?php $SAPserverip = "192.168.1.10";$SAPserverstatus = "ONLINE"; ?>';
else	
	$handle = '<?php $SAPserverip = "192.168.1.10";$SAPserverstatus = "OFFLINE"; ?>';

$cache_file = "/var/www/html/portal.ybc.co.id/servermode.php";
$open_file = fopen ($cache_file, "w");
fwrite ($open_file, $handle);
fclose ($open_file);
echo "Successfully change to: <b>".$servermode."</b><br /><hr /><br />";

include_once("setstatus.php");
?>
