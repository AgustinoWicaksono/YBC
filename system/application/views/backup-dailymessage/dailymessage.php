<?php
$dailymsg_status = 1; //1: ok, 2: warning, 3:error
if ($dailymsg_status==1) $dailymsg_hcolor = "#7ae35e";
elseif ($dailymsg_status==2) $dailymsg_hcolor = "#fdd250";
else	$dailymsg_hcolor = "#aa1122";


$dailymsg_datetime = "02 Feb 2012 - 20.00 WIB";
$dailymsg_content = '';

?>
<?php 
if ($dailymsg_content!='') { ?>
<div style="background-color:#353537;color:#ffffff;padding:10px;border-right:#aa1122 75px solid;"><div style="float:left;margin:0px 5px 5px 0px;"><img src="http://portal.ybc.co.id/images/pengumuman.jpg" alt="Pengumuman Harian" /></div>
<div style="margin-left:50px;background-color:#353537;color:#ffffff;">
<b style="color:<?php echo $dailymsg_hcolor; ?>;font-size:120%;">PENGUMUMAN HARIAN (<?php echo $dailymsg_datetime; ?>): </b><br /><?php echo $dailymsg_content; ?></div>
</div>

<?php } ?>