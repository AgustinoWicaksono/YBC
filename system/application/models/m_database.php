<?php
	class M_database extends Model{
		
		
function M_database() {
		parent::Model();
		$this->obj =& get_instance();
        $this->load->model('m_saprfc');
        $this->load->model('m_general');
		$this->load->library('l_general');
		
		parent::__construct();
		
		$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$dba=$db_sap[0]['name'];

		
        $this->db2 = $this->load->database($dba, TRUE);
	}
	
		 function get_mysql(){
			$db['hostname'] = "192.168.0.21";
			$db['username'] = "root";
			$db['password'] = "";
			$db['database'] = "msi_addon";
			$db['dbdriver'] = "mysql";
			return $dbc = implode($db);
			mysql_connect($dbc);
			/*return $hostname = "localhost";
			return $username = "root";
			return $password = "";
			return $database = "sap_php";
			return $dbdriver = "mysql";
			
			mysql_connect($hostname, $username, $password);
			mysql_select_db('sap_php',$con);
			*/
			/*$hostname2 = "msi-sap-db";
			$username2 = "sa";
			$password2 = "M$1S@p!#@";
			$database2 = "Test_MSI";
			$dbdriver2 = "sqlsrv";
			
			sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));//mssql_connect($server, $username, $password);
			//return $db2 =mssql_select_db('Test_MSI', $con2);
			*/
			
			
		}
		 function get_sql(){
			$db2['hostname'] = "msi-sap-db";
			$db2['username'] = "sa";
			$db2['password'] = "M$1S@p!#@";
			$db2['database'] = "Staging_MSI_20190101";
			$db2['dbdriver'] = "sqlsrv";
			return $dbc2 = implode($db2);
			//sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
			sqlsrv_connect($dbc2);
		}
		
		 function get_db_mysql()
		 
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db1=$db_sap[0]['mysql_name'];
			return $db1;
		}
		
		 function get_user_mysql()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db2=$db_sap[0]['mysql_user'];
			return $db2;
		}
		
		 function get_pass_mysql()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db3=$db_sap[0]['mysql_pass'];
			return $db3;
		}
		
		 function get_db_sap()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db4=$db_sap[0]['name'];
			return $db4;
		}
		
		 function get_user_sap()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db5=$db_sap[0]['user'];
			return $db5;
		}
		
		 function get_pass_sap()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db6=$db_sap[0]['password'];
			return $db6;
		}
		
		 function get_host_sap()
		{
			$db_sap=$this->m_general->sap_db();
		//echo'{'.$db_sap[0]['name'];
		
		$db7=$db_sap[0]['host'];
			return $db7;
		}
	}	
?>