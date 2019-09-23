<?php
if (Empty($dirsap)) $dirsap = "";


$swburut = @$_GET['group'];
if (Empty($swburut)) $swburut = 0; else {
	$swburut = intval($swburut);
}

require_once($dirsap."saprfc2.php");
require_once($dirsap."swbsql.php");

$aSQLRef = new MySQLConnector();
$aSQLRef->connect();

$aSQLRefBAPI = new MySQLConnector();
$aSQLRefBAPI->connect();


$isDebug = @$_GET['debug'];
if (Empty($isDebug)) $isDebug = false; else $isDebug = true;

if (Empty($kd_plant)) $kd_plant = @$_GET['plant'];

$comp_id = @$_GET['comp'];
if (Empty($comp_id)) $comp_id = "XXX"; else {
	if ($comp_id=="YBC") $comp_id = "YBC";
	else $comp_id = "XXX";
}


$count = 0;

function CekString($isiString) {
	$isiString = str_replace("'","''",$isiString);

	return $isiString;
}


function GetPOOutStanding($aSQLRef,$kd_plant,$isDebug=false,$webrfcuser='SAPRFC_USER') {
		$kd_plant = strtoupper($kd_plant);
		$hasil = "PLANT: ".$kd_plant."<br />\r\n";
		$plants = Array();
		$sqlINSERT = "";
		if ($isDebug) echo "===START===<br />";

		if ($isDebug) echo "BAPI: ZMM_BAPI_DISP_PO_OUTSTANDING_A<br />\r\n";
		$hasil .= "WAKTU MULAI: ".date('Ymd-His')."<br />\r\n";
		$sqlDELETE = "DELETE FROM `ZMM_BAPI_DISP_PO_OUTSTANDING` WHERE `PLANT`=";

		/*if ($isDebug) echo "===RFC===<br />";
		$aSAP = new EM_saprfc();

		$aSAP->setUserRfc($webrfcuser);
		$aSAP->setPassRfc();
		$aSAP->sapAttr();
		$aSAP->connect();
		$aSAP->functionDiscover("ZMM_BAPI_DISP_PO_OUTSTANDING_A");
		$aSAP->importParameter(array ("OUTLET","PO_ITEM","PO_NUMBER","PO_VENDOR_FLG"),
										  array ($kd_plant,"","","X"));
		$aSAP->setInitTable("PO_OUTS");
		$aSAP->executeSAP();
		$plants = $aSAP->fetch_rows("PO_OUTS");
		$aSAP->free();
		$aSAP->close();
        */

        $server = 'SVR-S-2012-64';
        $username = 'sa';
        $password = 'abc123?';
        $server1='localhost';
        $username1='root';
        $password1='';
        $con = mssql_connect($server, $username, $password);
        $db=mssql_select_db('MSI',$con);

        $con1=mysql_connect($server1,$username1,$password1);
        $db1=mysql_select_db('sap_php',$con1);


          $plant=$this->session->userdata['ADMIN']['plant'];
        $querySQL=mysql_query('SELECT EBELN FROM zmm_bapi_disp_po_outstanding');

    	$querySAP=mssql_query("SELECT WhsCode as PLANT, POR1.DocEntry as EBELN,
        LineNum as EBELP, OPOR.CardCode as VENDOR, OPOR.CardName as VENDOR_NAME,
        OPOR.CardCode as SUPPL_PLANT, OPOR.CardName as SPLANT_NAME,
    	POR1.ItemCode as MATNR, Dscription as MAKTX, OpenQty as BSTMG,
        (Quantity - OpenQty) as BSTMG_APRVD ,
        SPACE(0) as MATKL, SPACE(0) AS MBLNR,
    	unitMsr BSTME, unitMsr AS UNIT, unitMsr AS UNIT_STEXT,
        OITM.ItmsGrpCod AS DISPO, POR1.ShipDate AS DELIV_DATE
        FROM POR1
        JOIN OPOR on POR1.DocEntry = OPOR.DocEntry
        JOIN OITM on POR1.ItemCode = OITM.ItemCode WHERE WhsCode = '$plant'");
        if ($querySAP)
        {
            echo 'Berhasil konek!';
        }
        else
        {
            echo 'Koneksi GAGAL!';
        }
        $plants = mssql_fetch_row($querySAP);
        /*while ($rowSAP = mssql_fetch_array($querySAP))
        {
        $plant =$rowSAP['WhsCode'];
        $ebeln =$rowSAP['DocEntry'];
        $cekQuery=mysql_query("SELECT * FROM zmm_bapi_disp_po_outstanding where EBELN = '$ebeln'");
        $cekRow=mysql_num_rows($cekQuery);
        if ($cekRow==0)
        {
        $ebelp =$rowSAP['LineNum'];
        $vendor =$rowSAP['CardCode'];
        $vendorName=$rowSAP['CardName'];
        $matnr=$rowSAP['ItemCode'];
        $maktx=$rowSAP['Dscription'];
        $bstmg=$rowSAP['OpenQty'];
        $bstmg_aprvd=$rowSAP['BSTMG_APRVD'];
        $bstme=$rowSAP['unitMsr'];
        $dispo=$rowSAP['ItmsGrpCod'];
        $deliv_date=$rowSAP['ShipDate'];


        $saveToSQL=mysql_query("INSERT INTO zmm_bapi_disp_po_outstanding  VALUES ($plant,$ebeln,$ebelp,'$vendor','$vendorName','','','$matnr','$maktx',$bstmg,$bstmg_aprvd,'$bstme','','$dispo','','','','$deliv_date',0,'')") ;
        }

        }
        */
		if ($isDebug) echo "===RFC OK===<br />";
		$count = count($plants);
		$hasil .= "JUMLAH ITEM PO OUTSTANDING VENDOR = ".$count."<br />\r\n";

		$aResult1 = false;
		if ($isDebug) echo "===SQL===<br />";
		$sqlDELETE = $sqlDELETE."'".$kd_plant."';";
//		$aResult1 = $aSQLRef->setquery($sqlDELETE);
//		echo "<br />".$sqlDELETE."<br />";
//		if ($count>0) {
        $aResult1 = $aSQLRef->setquery($sqlDELETE);


		if ($aResult1) {
			for ($i=1;$i<=$count;$i++) {
				$PLANT = $kd_plant;
				$EBELN = CekString($plants[$i]['EBELN']);
				$EBELP = CekString($plants[$i]['EBELP']);
				$VENDOR = CekString($plants[$i]['VENDOR']);
				$VENDOR_NAME = CekString($plants[$i]['VENDOR_NAME']);
				$SUPPL_PLANT = CekString($plants[$i]['SUPPL_PLANT']);
				$SPLANT_NAME = CekString($plants[$i]['SPLANT_NAME']);
				$MATNR = CekString($plants[$i]['MATNR']);
				$MAKTX = CekString($plants[$i]['MAKTX']);
				$BSTMG = CekString($plants[$i]['BSTMG']);

				$BSTME = CekString($plants[$i]['BSTME']);
				$MATKL = CekString($plants[$i]['MATKL']);
				$DISPO = CekString($plants[$i]['DISPO']);
				$MBLNR = CekString($plants[$i]['MBLNR']);
				$UNIT = CekString($plants[$i]['UNIT']);
				$UNIT_STEXT = CekString($plants[$i]['UNIT_STEXT']);
				$DELIV_DATE = CekString($plants[$i]['DELIV_DATE']);

				if (substr($MATKL,0,2)!="01") {
					// echo 'NOT INSERT='.$EBELN."\r\n";
					continue;
				}

				// echo $PLANT.'='.$EBELN."\r\n";


				$sqlINSERT = "INSERT INTO `ZMM_BAPI_DISP_PO_OUTSTANDING` ";
				$sqlINSERT .= "(`PLANT`,`EBELN`,`EBELP`,`VENDOR`,`VENDOR_NAME`,`SUPPL_PLANT`,`SPLANT_NAME`,`MATNR`,`MAKTX`,`BSTMG`,`BSTME`,`MATKL`,`DISPO`,`MBLNR`,`UNIT`,`UNIT_STEXT`,`DELIV_DATE`) ";
				$sqlINSERT .= "VALUES ";
				$sqlINSERT .= "('$PLANT','$EBELN','$EBELP','$VENDOR','$VENDOR_NAME','$SUPPL_PLANT','$SPLANT_NAME','$MATNR','$MAKTX','$BSTMG','$BSTME','$MATKL','$DISPO','$MBLNR','$UNIT','$UNIT_STEXT','$DELIV_DATE'); \r\n";

				$sqlINSERT = str_replace(",'',",",NULL,",$sqlINSERT);

				if ($isDebug) echo $sqlINSERT."<hr />";

				$aResult2 = $aSQLRef->setquery($sqlINSERT);


				if (!$aResult2) $hasil .= "GAGAL = ".$EBELN."<br />\r\n";
			}

		}

		$sqlUpdateTime = "INSERT INTO `t_statusgetdata` (`plant`) VALUES ('$kd_plant') ON DUPLICATE KEY UPDATE `poout_lastupdate`=current_timestamp;";
		if ($isDebug) echo $sqlUpdateTime."<hr />";
		$aResult3 = $aSQLRef->setquery($sqlUpdateTime);
		$hasil .= "WAKTU SELESAI: ".date('Ymd-His')."<br /><hr /><br />\r\n";

		return $hasil;


}
if (Empty($kd_plant)) {

	$query1 = "select distinct `plant`,`admin_rfcusername` from `d_admin` where `admin_realname` like '%(Manager)' and `plant` like '".$comp_id."%' order by `plant` limit ".$swburut.",10;";
// echo $query1;
	$aSQLRef->query($query1);
	$aSQLRef->rowcount();

	if ($aSQLRef->dbrowcount>0) {
		while ($count<$aSQLRef->dbrowcount){
			$kd_plant = mysql_result($aSQLRef->dbresult,$count,0);
			$webrfcuser = mysql_result($aSQLRef->dbresult,$count,1);
			$webrfcuser = 'IN_WEB_SYN';
			echo @GetPOOutStanding($aSQLRefBAPI,$kd_plant,$isDebug,$webrfcuser)."<hr />\r\n";
			sleep(7);
			$count ++;
		}
		sleep(7);
		$aSQLRef->query('OPTIMIZE TABLE `ZMM_BAPI_DISP_PO_OUTSTANDING`');

	} else {
		echo "No Data";
	}
} else {

	$threehours = date('Y-m-d H:i', mktime(date("H")-3, date("i"), 0, date("m") , date("d"), date("Y")));
	$query1 = "SELECT `plant`,`poout_lastupdate` FROM `t_statusgetdata` where `plant`='".$kd_plant."' and `poout_lastupdate`>'".$threehours."';";
// echo $query1;
	$aSQLRef->query($query1);
	$aSQLRef->rowcount();
	$DataExpired = ($aSQLRef->dbrowcount==0);

	$DataExpired = true;

	if ($DataExpired) {
		echo @GetPOOutStanding($aSQLRefBAPI,$kd_plant,$isDebug);
	} else {
		$lastupdate = mysql_result($aSQLRef->dbresult,0,1);
		echo "PESAN KESALAHAN:<br />\r\nData terakhir sudah diperbarui kurang dari 3 jam lalu.<br />\r\nTerakhir di-update pada: ".$lastupdate;
	}

}

$aSQLRefBAPI->disconnect();
unset($aSQLRefBAPI);
$aSQLRef->disconnect();
unset($aSQLRef);

?>