<?php
class M_saprfc extends Model
{
	function M_saprfc()
	{
		parent::Model();
		$this->obj =& get_instance();
	}

	function setUserRfc($nik='IN_WEB_SYN')
	{
	    $admin_data = $this->m_admin->admin_select();
        if(!empty($admin_data['admin_rfcusername']))
          $nik = $admin_data['admin_rfcusername'];
		$this->username = $nik;

	}

	function setPassRfc($pass='myDefaultPassword')
	{
		$this->password = $pass;

	}

	function setConfig($typeConf)
	{
		if (Empty($SAPserverip)) $SAPserverip = "192.168.1.10";
		if ($typeConf == "developer") {
			 	$sapConf = array (
						"sapServer"=>"192.168.1.11",
						"sysnr"=>"10",
						"client"=>"110",
						"codePage"=>"1100",
						"trace"=>"X",
				);
		 	}
			elseif ($typeConf == "qa") {
			 	$sapConf = array (
						"sapServer"=>"192.168.1.11",
						"sysnr"=>"20",
						"client"=>"200",
						"codePage"=>"1100",
						"trace"=>"X"
						);
			}
			elseif ($typeConf == "training") {
			 	$sapConf = array (
						"sapServer"=>"192.168.1.11",
						"sysnr"=>"20",
						"client"=>"240",
						"codePage"=>"1100",
						"trace"=>"X"
						);
            }
			elseif ($typeConf == "production") {
			 	$sapConf = array (
						"sapServer"=>"192.168.1.10",
						"sysnr"=>"30",
						"client"=>"360",
						"codePage"=>"1100",
						"trace"=>"X"
						);
            }
		return $sapConf;
	}

	function sapAttr() {

	        $servConf = $this->setConfig('production');
			$sapUser = $this->username;
			$sapPass = $this->password;
			//echo $sapPass.'-'.$sapPass;
			 $this->sapConn = array (
            	"ASHOST"=>$servConf["sapServer"],      //SAP server address
	            "SYSNR"=>$servConf["sysnr"],           // system number
      	        "CLIENT"=>$servConf["client"],         // client
                "USER"=>$sapUser,          // user
                "PASSWD"=>$sapPass,        // password
                "CODEPAGE"=>$servConf["codePage"],
				"TRACE"=>$servConf["trace"] //untuk tracing
				);   // codepage
    	return $this->sapConn;
	}

	function connect() {
	   return $this->rfc = saprfc_open ($this->sapConn);
	}

	function functionDiscover($functionName) {
	   $this->fce = saprfc_function_discover($this->rfc, $functionName) or die ('<div style="border:#112233 1px solid;margin:10px;padding:10px;background-color:#ddeeff;color:#223344;font-family:segoe ui,verdana,arial,sans-serif;font-size:11px;"><div style="color:#ffffff;background-color:#112233;padding:10px;font-size:120%;"><b style="color:#fdd250;">Maaf,</b> server SAP di kantor pusat terlalu sibuk saat ini sehingga sulit atau lambat diakses. </div><br /><br /><b>PESAN KESALAHAN</b>:<br />Tidak dapat memanggil fungsi SAP: <b style="color:#aa1122;">'.$functionName.'</b><br /><br /><b style="color:#11aa22;font-size:140%;">Silahkan coba kembali beberapa menit lagi.</b><br /><br />SAP Helpdesk</div>');
	}

	function importParameter($importParamName, $importParamValue) {
		for ($i=0;$i<count($importParamName);$i++) {
		    $importParamName[$i]." = ".$importParamValue[$i]."<br>";
			saprfc_import ($this->fce,$importParamName[$i],$importParamValue[$i]);
		}
	}

	function setInitTable($initTableName) {
		saprfc_table_init ($this->fce,$initTableName);
	}

	function executeSAP() {
		$this->rfc_rc = @saprfc_call_and_receive ($this->fce);
		if ($this->rfc_rc != SAPRFC_OK){
      	   if ($this->rfc == SAPRFC_EXCEPTION )
   		   		echo ("Exception raised: ".saprfc_exception($this->fce));
		   else
        	    echo ("Call error: ".saprfc_error($this->fce));
		}
		return $this->rfc_rc;
	}

	function fetch_rows($initTableName) {
	   $rows = saprfc_table_rows ($this->fce,$initTableName);
	   if($rows < 1){ $_dataRows = NULL; }
       for ($i=1; $i<=$rows; $i++)
      	   $_dataRows[$i] = saprfc_table_read ($this->fce,$initTableName,$i);
	   return $_dataRows;
	}

	function free() {
		saprfc_function_free($this->fce);
	}

	function close() {
		saprfc_close($this->rfc);
	}

	function insert($initTableName,$importParamValue){
		return saprfc_table_insert ($this->fce, $initTableName, $importParamValue, 1);
	}

	function append($initTableName,$importParamValue){
		return saprfc_table_append ($this->fce, $initTableName, $importParamValue);
	}

	function export($initTableName){
		return saprfc_export ($this->fce,$initTableName);
	}
}
?>
