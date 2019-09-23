<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
//$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
//						$b=mssql_select_db('Test_MSI',$c);
$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($_POST);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('issue_header[id_issue_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>

	<tr>
		<td class="table_field_1"><strong>ID Transaksi  </strong></td>
		<td class="column_input"><?=form_hidden('issue_header[id_issue_header]', $issue_header['id_issue_header']);?><strong><?=$issue_header['id_issue_header'];?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Issue No.</strong></td>
		<td class="column_input"><?=empty($data['issue_header']['material_doc_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['issue_header']['material_doc_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Cost Center</strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['cost_center'].' - '.$this->session->userdata['ADMIN']['cost_center_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['issue_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_code'];?><?=form_hidden("issue_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['issue_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	else if(!empty($data['issue_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
    		$posting_date = $data['issue_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['issue_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['issue_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['issue_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('issue_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'issue_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("issue_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
    
    <tr>
		<td class="table_field_1"><strong>Notes</strong></td>
		<td class="column_input"><?php
			if(!empty($error) && in_array("issue_header[no_acara]", $error)) {
			echo form_input("issue_header[no_acara]", $data['issue_header']['no_acara'], 'class="error_text" size="24"');
		} else {
			echo form_input("issue_header[no_acara]", $data['issue_header']['no_acara'], 'class="input_text" size="24"');
		}
		?></td>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['issue_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?>
        <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?></td>
  </tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['issue_header']['status']) || $data['issue_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Issue No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
        <td class="table_header_1"><div align="center"><strong>In Whs Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Reason</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Other Reason</strong></div></td>
	</tr>
<?php
//if($data['issue_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $issue_detail_tmp = $this->session->userdata('issue_detail');
    if(!empty($issue_detail_tmp)) {
       $data['issue_detail'] = $issue_detail_tmp;
    }

	$count = count($data['issue_detail']['id_issue_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($issue_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['issue_header']['status'] == '1' || ( ($data['issue_header']['status'] == '2') && !empty($data['issue_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("issue_detail[quantity][$i]", $error) || in_array("issue_detail[material_no][$i]", $error) || in_array("issue_detail[reason_name][$i]", $error ) || in_array("issue_header[no_acara]", $error ) || in_array("delete[$i]", $error ) || in_array("issue_detail[num][$i]", $error ) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['issue_detail']['material_no'][$i]);
            if (!empty($data['issue_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['issue_detail']['material_desc'][$i];
            }
            if (!empty($data['issue_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['issue_detail']['uom'][$i];
            }
			if (!empty($data['issue_detail']['num'][$i])) {
		
			 $item_x[$i]['BatchNum'] = $data['issue_detail']['num'][$i];
            }
			
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['issue_header']['status']) || $data['issue_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['issue_header']['status']) || $data['issue_header']['status'] == '1') : ?>
        <?=form_hidden("issue_detail[id_issue_h_detail][$k]", $data['issue_detail']['id_issue_h_detail'][$k]);?>
        <?=form_hidden("issue_detail[id_issue_detail][$k]", $data['issue_detail']['id_issue_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("issue_detail[material_no][$k]", $data['issue_detail']['material_no'][$i]);?><?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("issue_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--td>
        <?php /*$item_x[$i]['BatchNum'];?>
        <?=form_hidden("issue_detail[num][$k]",  $item_x[$i]['BatchNum']); */
		$whs=$this->session->userdata['ADMIN']['storage_location'];
		$itm=$item_x[$i]['MATNR1'];
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$itm'"));
		$stock=$InWhs['Quantity'];
		$oitw=number_format($stock, 2, '.', '');
		?>
		 </td-->
          <td>
		  
        <?=$oitw;?>
        <?=form_hidden("issue_detail[stock][$k]", $stock);?>
		
        </td>
		<td align="center">
<?php
			if(!empty($error) && in_array("issue_detail[quantity][$i]", $error)) {
				echo form_input("issue_detail[quantity][$k]", number_format($data['issue_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("issue_detail[quantity][$k]", $data['issue_detail']['quantity'][$i]);
                if($data['issue_header']['status'] == '2')
    				echo number_format($data['issue_detail']['quantity'][$i], 2, '.', ',');
                else
    				echo form_input("issue_detail[quantity][$k]", number_format($data['issue_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td>
		<td>
        <?php /*if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['issue_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['issue_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; */?>
        <?=$data['issue_detail']['uom'][$i];?>
         <?=form_hidden("issue_detail[uom][$k]", $data['issue_detail']['uom'][$i]);?>
        </td>
		<td align="center"><?=form_hidden("issue_detail[reason_name][$k]", $data['issue_detail']['reason_name'][$i]);?>
        <?php if($data['issue_header']['status'] == '2') : ?>
            <?=$data['issue_detail']['reason_name'][$i];?>
        <?php else: ?>
            <?php if(!empty($error) && in_array("issue_detail[reason_name][$i]", $error)) : ?>
                <?=form_dropdown("issue_detail[reason_name][$k]", $reason, $data['issue_detail']['reason_name'][$i], 'class="error_text"');?>
            <?php else: ?>
                <?=form_dropdown("issue_detail[reason_name][$k]", $reason, $data['issue_detail']['reason_name'][$i], 'class="input_text"');?>
            <?php endif; ?>
        <?php endif; ?>
        </td>
		<td align="center"><?=form_hidden("issue_detail[other_reason][$k]", $data['issue_detail']['other_reason'][$i]);?>
        <?php if($data['issue_header']['status'] == '2') : ?>
            <?=$data['issue_detail']['other_reason'][$i];?>
        <?php else: ?>
            <?=form_input("issue_detail[other_reason][$k]", $data['issue_detail']['other_reason'][$i], 'class="input_number" size="24"');?>
        <?php endif; ?>
        </td>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['issue_header']['status'] != '2') :

?>
	<tr>
<?php if(!isset($data['issue_header']['status']) || $data['issue_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['issue_header']['status']) || $data['issue_header']['status'] == '1') : ?><?=form_hidden("issue_detail[id_issue_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2">
		<?php
		$SWB=mysql_query("SELECT MATNR,MAKTX FROM m_item",$mysqlcon); 
		$count=mysql_num_rows($SWB);
		$item12[0]='';
		while($ra=mysql_fetch_array($SWB))
		{
			$item12[$ra['MATNR']] = $ra['MATNR'].' - '.$ra['MAKTX'];
		} 
		if(!empty($error) && in_array("issue_detail[material_no][$i]", $error)) {
			echo form_dropdown("issue_detail[material_no][$k]", $item12, $data['issue_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();" ');
		} else {
			echo form_dropdown("issue_detail[material_no][$k]", $item12, $data['issue_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');
		}
		?>
		</td>
         <?php
		 
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		$it=$data['issue_detail']['material_no'][$i];
		/*$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs' AND Quantity > 0"); 
		$count=mysql_num_rows($t);
		$item1[0]= '';
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['num']] = $r['num'];
		} ?>
        <!--td >
		<?php
		if ($count > 0){
		if(!empty($error) && in_array("issue_detail[num][$i]", $error)) {
			echo form_dropdown("issue_detail[num][$k]", $item1, $data['issue_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("issue_detail[num][$k]", $item1, $data['issue_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		} else
		{
		echo "Tidak ada Batch Number";
		}*/
		?>
		</td-->
        <td align="center">
		<?php
		
		$batch=$data['issue_detail']['num'][$i];
		if ($batch=='')
		{
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'"));
		$InWh=mysql_fetch_array(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$whs' AND ItemCode='$it'",$mysqlcon));
			$countOITW=mysql_num_rows(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$whs' AND ItemCode='$it'",$mysqlcon));
			$OnHandQty=$InWhs['Quantity'];
			/*if ($countOITW > 0)
			{
				$OnHandQty=$InWhs['Quantity'];
			}else
			{
				$OnHandQty=$InWhs['Quantity'];
			}*/
		}else{
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT A.Quantity FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$whs' AND A.ItemCode='$it' AND B.DistNumber='$batch'"));
		}
		sqlsrv_close($b);
       
		echo substr($OnHandQty,0,-4);?>
        <?=form_hidden("issue_detail[stock][$k]", $OnHandQty,$data['issue_detail']['stock'][$i]);?>
		
        </td>
       
		<td align="center">
		<?php
		if(!empty($error) && in_array("issue_detail[quantity][$i]", $error)) {
			echo form_input("issue_detail[quantity][$k]", $data['issue_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("issue_detail[quantity][$k]", $data['issue_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
		<td>
         <?php
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'",$mysqlcon);
	   //$ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
WHERE m_item_uom.ItemCode = '$it' 
and m_item_uom.UomEntry='$UOM'
UNION ALL
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
WHERE m_item_uom.ItemCode = '$it' 
",$mysqlcon);


		$count1=mysql_num_rows($ta);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($ta))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("issue_detail[uom][$i]", $error)) {
			echo form_dropdown("issue_detail[uom][$k]", $itemC, $data['issue_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("issue_detail[uom][$k]", $itemC  , $data['issue_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
	   ?>
        </td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("issue_detail[reason_name][$i]", $error)) {
			echo form_dropdown("issue_detail[reason_name][$k]", $reason, $data['issue_detail']['reason_name'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("issue_detail[reason_name][$k]", $reason, $data['issue_detail']['reason_name'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
			echo form_input("issue_detail[other_reason][$k]", $data['issue_detail']['other_reason'][$i], 'class="input_number" size="24"');
		?>
		</td>
	</tr>
<?php
	endif;
?>
</table>
<?php if($data['issue_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
        <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?> </td>
	</tr>
</table>
<?php 
    mysql_close($mysqlcon);
	endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
<?php if($data['issue_header']['status'] != '2') : ?>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Waste Material.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
<?php endif; ?>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('issue/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
<script language="javascript">
	function selectAll(){
//		t=document.form2.length;
//		document.write(t); 
		//for(i=1; i<t-1; i++)
		for(i=1; i <= <?=$j;?>; i++)
			document.form1[i].checked=document.form1[<?=++$j;?>].checked;
	}
</script>
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