<html>
<head>
<body>
<?
require_once("saprfc.php");

// Create saprfc-instance
$sap = new saprfc(array(
"logindata"=>array(
"ASHOST"=>"172.16.0.62" // application server
,"SYSNR"=>"10" // system number
,"CLIENT"=>"110" // client
,"USER"=>"web_int01" // user
,"PASSWD"=>"123456" // password
)
,"show_errors"=>false // let class printout errors
,"debug"=>false)) ; // detailed debugging information

?>
<?
echo"<form method=get action=''>";
echo"<table border=0>";
echo"<select name='VENDOR' >";
echo "<option value=vendorcode selected>- Pilih Vendor -</option>";
	$result=$sap->callFunction("ZMM_BAPI_LIST_VENDOR_OUTLET",
array( 
array("IMPORT","OUTLET","$_GET[VENDOR]"),
array("TABLE","VENDOR_DATA",array())
));

// Call successfull?
if ($sap->getStatus() == SAPRFC_OK) {
?>


<?
foreach ($result["VENDOR_DATA"] as $user) {

echo "<option value=$user[LIFNR]>$user[LIFNR]</option>";
}
} else {
// No, print long Version of last Error
$sap->printStatus();
// or print your own error-message with the strings received from
// $sap->getStatusText() or $sap->getStatusTextLong()
}
 echo"</select>";
 echo"<td><input type=submit name=CARI value=CEK></td";
 echo"</table>";
 echo"</form>";

 echo"<select name=VENDOR_NAME>";
 echo "<option value=vendorname selected>- Pilih Vendor Name -</option>";

foreach ($result["VENDOR_DATA"] as $user) {
echo "<option value=$user[NAME1]>$user[NAME1]</option>";
}


?>
<?
//if (! isset($_GET[CARI])){
//echo"<select name=VENDOR_NAME>";
//echo "<option value=0 selected>- Pilih Vendor Name -</option>";
//}
//	$result1=$sap->callFunction("ZMM_BAPI_LIST_VENDOR_OUTLET",
//array( array("IMPORT","OUTLET","$_GET[CARI]"),
//array("TABLE","VENDOR_DATA",array())
//));

// Call successfull?
//if ($sap->getStatus() == SAPRFC_OK) {

//foreach ($result1["VENDOR_DATA"] as $user) {

//echo "<option value=$user1[NAME1]>$user1[NAME1]</option>";
//}
//} else {
// No, print long Version of last Error
//$sap->printStatus();
// or print your own error-message with the strings received from
// $sap->getStatusText() or $sap->getStatusTextLong()
//}
// echo"</select>";

  $sap->logoff();
  
 ?>

