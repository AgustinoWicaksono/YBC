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
<table width="880" border="0" align="center">
<?=form_open('storedaily/browse_search', $form1);?>
  <tr>
    <td width="328" align="left"><strong>Transaksi Tanggal <span class="style2">(YYYY-MM-DD)</span>
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
    
    <?php
    $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
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
    <td width="192"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
