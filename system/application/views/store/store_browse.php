<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<style type="text/css">
<!--
.style2 {font-size: 8px}
-->
</style>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="797" border="0" align="center">
<?=form_open('store/browse_search', $form1);?>
  <tr>
    <!--td width="320" align="left"><strong>Dari Tanggal <span class="style2">(YYYY-MM-DD)</span>
      <?=form_input('date', $data['date'], 'class="input_text" size="10"');?> 
      <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});
				
		</script>
    </strong></td>
    <td width="357" align="left"><strong>Sampai Tanggal <span class="style2">(YYYY-MM-DD)</span> 
      <?=form_input('to', $data['to'], 'class="input_text" size="10"');?> 
        <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});
				
		</script>
    </strong></td-->
    <td width="10"><strong>Item Group</strong></td>
    <?php
    $con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
//$gr=mssql_query("SELECT ItmsGrpNam as item_group_code FROM OITB");
$group[0]='';
$group['all']='==All==';
while( $r=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ItmsGrpNam as item_group_code FROM OITB")))
		{
			$group[$r['item_group_code']] = $r['item_group_code'];
		}
		sqlsrv_close($con);		
		//print_r($group);
	?>
    <td width="17"> <?=form_dropdown('item_group_code', $group, $data['item_group_code'], ' data-placeholder="Pilih Group..." class="chosen-select input_text" ');?></td>
    <td width="81"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
