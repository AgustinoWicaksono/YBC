<?php
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
?>
YBC SAP Portal <b><span style="color:#11aa22;">ONLINE</span> | <span style="color:#1122aa;"><?php echo $db_mysql?></span> | <span style="color:red;"><?php echo $db_sap?></span></b><br /><br />


<?php
$swbipaddress=@$_SERVER['REMOTE_ADDR'];

echo 'S:2015';
?>
