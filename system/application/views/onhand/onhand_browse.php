<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
?>
<style type="text/css">
<!--
.style2 {font-size: 8px}
-->
</style>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="834" height="35" border="0" align="center">
<?=form_open('onhand/browse_search', $form1);?>
  <tr>
    <td width="10">Item group</td>
    <?php
	$c=mssql_connect($host_sap,$user_sap,$pass_sap);
$b=mssql_select_db($db_sap,$c);
$gr=mssql_query("SELECT ItmsGrpNam as item_group_code FROM OITB");
$group[0]='';
$group['all']='==All==';
while($r=mssql_fetch_array($gr))
		{
			$group[$r['item_group_code']] = $r['item_group_code'];
		}
		//print_r($group);
	?>
    <td width="17"> <?=form_dropdown('item_group_code', $group, $data['item_group_code'], ' data-placeholder="Pilih Group..." class="chosen-select input_text" ');?></td>
	<td width="132"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>