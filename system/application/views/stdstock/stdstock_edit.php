<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$function = $this->uri->segment(2);
$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
		$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);

		//echo "<pre>";
//print '$request_reasons ';
//print_r($data['stdstock_header']);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('stdstock_header[id_stdstock_header]', $this->uri->segment(3));?>
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
		<td class="column_input"><?=form_hidden('stdstock_header[id_stdstock_header]', $stdstock_header['id_stdstock_header']);?><strong><?=$stdstock_header['id_stdstock_header'];?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Store Room Reques(SR) Number </strong></td>
	  <td class="column_input">
        <?=empty($data['stdstock_header']['pr_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['stdstock_header']['pr_no'];?>
        <?=form_hidden("stdstock_header[pr_no]", $data['stdstock_header']['pr_no']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet From</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
      <td class="table_field_1"><strong>Storage Location </strong> </td>
	  <td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
  </tr>
  
     <tr>
      <?php 
	  $con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
	  
	//mysql_connect("localhost","root","");
	//mysql_select_db("sap_php2");
	$p=$this->session->userdata['ADMIN']['plant'];
	$ta=mysql_query("SELECT otd_code FROM m_outlet WHERE outlet = '$p'",$mysqlcon);
	$tr=mysql_fetch_array(mysql_query("SELECT TRANSIT FROM m_outlet WHERE OUTLET='$p'",$mysqlcon));
	$pL=$tr['TRANSIT'];
	$ra=mysql_fetch_array($ta);
	$plant=$ra['otd_code'];
	if($to=='Outlet')
	{
	$t=mysql_query("SELECT * FROM m_outlet where   LEFT(outlet,1) <> 'T' ",$mysqlcon);
	//echo "SELECT * FROM m_outlet where outlet NOT like '%$plant%' AND  LEFT(outlet,1) <> 'T' ";
	}
	else 
	{
	$t=mysql_query("SELECT * FROM m_outlet where outlet like '%$plant%' AND LEFT(outlet,1) <> 'T' AND outlet <> '$p'",$mysqlcon);
	}
	
	$pl[0]='';
	while ($r=mysql_fetch_array($t))
	{
		$pl[$r['OUTLET']] =$r['OUTLET_NAME1']."(".$r['OUTLET'].")"; 
	}?>
		<td class="table_field_1"><strong>Request To <?=$to;?></strong></td>
		<td class="column_input">
		<?php if($function != 'edit') : ?>
		<?= form_dropdown("stdstock_header[to_plant]", $pl, $data['stdstock_header']['to_plant'], ' data-placeholder="Pilih Departement..." class="chosen-select error_text" style="width:450px;" ');?>
         <?php else : ?>
        <?php
        $out=$data['stdstock_header']['to_plant'];
		$res=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET ='$out' ",$mysqlcon));
		echo $out.' - '.$res['OUTLET_NAME1'];
		?>
        <?php endif;?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Request Reason</strong> </td>
		<td class ="column_input">
        <?php if($function != 'edit') : ?>
        <?=form_dropdown('stdstock_header[request_reason]', $request_reasons, $request_reason, 'class="input_text"');?>
        <?php else : ?>
        <?=$request_reason;?>
        <?=form_hidden("stdstock_header[request_reason]", $request_reason);?>
        <?php endif;?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=$data['stdstock_header']['status_string'];?></strong>
        <?=form_hidden("stdstock_header[status]", $data['stdstock_header']['status']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("stdstock_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
<?php
   if($data['stdstock_header']['status'] != '2') {
    	if(empty($_POST) && $function == 'input2')
    		$delivery_date = date("d-m-Y");
    	else if(!empty($data['stdstock_header']['delivery_date']))
            if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0)||(!empty($error)))
        		$delivery_date = $data['stdstock_header']['delivery_date'];
            else
        		$delivery_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['delivery_date'])));
   } else {
      $delivery_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['delivery_date'])));
   }
?>
		<td class="column_input">
        <?php if($data['stdstock_header']['status'] != '2') : ?>
        <?=form_input('stdstock_header[delivery_date]', $delivery_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stdstock_header[delivery_date]'
					});
		</script><?php else : ?>
    <?=$delivery_date;?>
    <?php endif;?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Created Date</strong></td>
<?php
   if($data['stdstock_header']['status'] != '2') {
    	if(empty($_POST) && $function == 'input2')
//    		$created_date = date("d-m-Y");
    		$created_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
    	else if(!empty($data['stdstock_header']['created_date']))
            if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0)||(!empty($error)))
        		$created_date = $data['stdstock_header']['created_date'];
            else
        		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['created_date'])));
   } else {
     $created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['created_date'])));;
   }
?>
     <td class="column_input">
     <?php if(($data['stdstock_header']['status'] != '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
		<?=form_input('stdstock_header[created_date]', $created_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stdstock_header[created_date]'
					});
		</script>
    <?php else : ?>
    <?=$created_date;?><?=form_hidden("stdstock_header[created_date]", $created_date);?>
    <?php endif;?></td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['stdstock_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_change')) : ?>
        <?=form_submit($this->config->item('button_change'), $this->lang->line('button_change'));?>
        <?=form_submit($this->config->item('button_delete_item'),'Delete Item');?>
        <?php endif; ?>
        <?php else: ?>
        <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
		<?php
		  $admin=$this->session->userdata['ADMIN']['admin_username'];
		  $perm=substr($admin,0,2);
		  if ($perm == 'SX')
		  {
		  ?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
		  <?php endif; }?>
        <?php endif; ?></td>
  </tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(empty($data['stdstock_header']['status']) || $data['stdstock_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Price / Item</strong></div></td-->
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>On Hand</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Min Stock</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Oustanding Total</strong></div></td>
		<?php if(($data['stdstock_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))) : ?><td class="table_header_1"><div align="center"><strong>Delete</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['stdstock_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $stdstock_detail_tmp = $this->session->userdata('stdstock_detail');
    if(!empty($stdstock_detail_tmp)) {
       $data['stdstock_detail'] = $stdstock_detail_tmp;
    }

	$count = count($data['stdstock_detail']['id_stdstock_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($stdstock_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($stdstock_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['stdstock_header']['status'] == '1' || ( ($data['stdstock_header']['status'] == '2') && !empty($data['stdstock_detail']['requirement_qty'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("stdstock_detail[requirement_qty][$i]", $error) || in_array("stdstock_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['stdstock_detail']['material_no'][$i]);
            if (!empty($data['stdstock_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['stdstock_detail']['material_desc'][$i];
              $item_x[$i]['uom'] = $data['stdstock_detail']['uom'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(empty($data['stdstock_header']['status']) || $data['stdstock_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['stdstock_header']['status']) || $data['stdstock_header']['status'] !== '0') : ?>
        <?=form_hidden("stdstock_detail[id_stdstock_h_detail][$k]", $data['stdstock_detail']['id_stdstock_h_detail'][$k]);?>
        <?=form_hidden("stdstock_detail[id_stdstock_detail][$k]", $data['stdstock_detail']['id_stdstock_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("stdstock_detail[material_no][$k]", $data['stdstock_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("stdstock_detail[requirement_qty][$i]", $error)) {
				echo form_input("stdstock_detail[requirement_qty][$k]", number_format($data['stdstock_detail']['requirement_qty'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i]);
                if($data['stdstock_header']['status'] == '2') {
    			  echo form_hidden("stdstock_detail[requirement_qty_old][$k]", $data['stdstock_detail']['requirement_qty'][$i]);
                }
                echo form_input("stdstock_detail[requirement_qty][$k]", number_format($data['stdstock_detail']['requirement_qty'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td>
<!--td align="center">
<?php
			/*if(!empty($error) && in_array("stdstock_detail[price][$i]", $error)) {
				echo form_input("stdstock_detail[price][$k]", number_format($data['stdstock_detail']['price'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i]);
                if($data['stdstock_header']['status'] == '2') {
    			  echo form_hidden("stdstock_detail[price_old][$k]", $data['stdstock_detail']['price'][$i]);
                }
                echo form_input("stdstock_detail[price][$k]", number_format($data['stdstock_detail']['price'][$i], 3, '.', ''), 'class="input_number" size="8"');
			}*/
?></td-->
        <td>
        <?=$data['stdstock_detail']['uom'][$i];?>
        <?=form_hidden("stdstock_detail[uom][$k]", $data['stdstock_detail']['uom'][$i]);?>
        </td>
         <td>
        <?=$data['stdstock_detail']['OnHand'][$i];?>
        <?=form_hidden("stdstock_detail[OnHand][$k]", $data['stdstock_detail']['OnHand'][$i]);?>
        </td>
        <td>
        <?=$data['stdstock_detail']['MinStock'][$i];?>
        <?=form_hidden("stdstock_detail[MinStock][$k]", $data['stdstock_detail']['MinStock'][$i]);?>
        </td>
        <td>
        <?=$data['stdstock_detail']['OpenQty'][$i];?>
         <?=form_hidden("stdstock_detail[OpenQty][$k]", $data['stdstock_detail']['OpenQty'][$i]);?>
        </td>
		<?php if(($data['stdstock_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))): ?>
        <td align="center">
        <?php if($data['stdstock_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['stdstock_detail']['id_stdstock_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['stdstock_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['stdstock_header']['status'] != '2') :

?>
	<tr>
<?php if(empty($data['stdstock_header']['status']) || $data['stdstock_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['stdstock_header']['status']) || $data['stdstock_header']['status'] !== '0') : ?><?=form_hidden("stdstock_detail[id_stdstock_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2">
		<?php
		if(!empty($error) && in_array("stdstock_detail[material_no][$i]", $error)) {
			echo form_dropdown("stdstock_detail[material_no][$k]", $item, $data['stdstock_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();" ');
		} else {
			echo form_dropdown("stdstock_detail[material_no][$k]", $item, $data['stdstock_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');
		}
		?>
		</td>
		<td align="center">
		<?php
		$ot=$data['stdstock_detail']['material_no'][$i];
		if ($ot != '')
		{
			if(!empty($error) && in_array("stdstock_detail[requirement_qty][$i]", $error)) {
				echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="error_number" size="8" autofocus=”autofocus”');
			} else {
				echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="input_number" size="8" autofocus=”autofocus”');
			}
		}else
		{
			if(!empty($error) && in_array("stdstock_detail[requirement_qty][$i]", $error)) {
				echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="error_number" size="8" ');
			} else {
				echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="input_number" size="8" ');
			}
		}
		?>
		</td>
        <!--td align="center">
		<?php
		/*if(!empty($error) && in_array("stdstock_detail[price][$i]", $error)) {
			echo form_input("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i], 'class="input_number" size="8"');
		}*/
		?>
		</td-->
        <td>
        <?php
		$it=$data['stdstock_detail']['material_no'][$i];
         $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'",$mysqlcon);
	  // $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
/*$tq=mysql_query("
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

");*/

$count1=mysql_num_rows($ta);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($ta))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("stdstock_detail[uom][$i]", $error)) {
			echo form_dropdown("stdstock_detail[uom][$k]",$itemC, $data['stdstock_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("stdstock_detail[uom][$k]" ,$itemC  , $data['stdstock_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
?>
        </td>
           <td>
          <?php
       // $temp1=mssql_fetch_array(mssql_query("SELECT OnHand,MinStock FROM OITW WHERE ItemCode='$it' AND WhsCode='$p'"));
		//$InWhs=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OnHand as Quantity FROM OITW WHERE WhsCode ='$p' AND ItemCode='$it'"));
		$temp1=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OnHand,MinStock FROM OITW WHERE ItemCode='$it' AND WhsCode='$p'"));
		//$temp2=mssql_fetch_array(mssql_query("SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$pL'"));
		$temp2=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$pL'"));
		//echo "SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$pL'";
		//$InWh=mysql_fetch_array(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$p' AND ItemCode='$it'"));
		sqlsrv_close($con);		
			//$countOITW=mysql_num_rows(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$p' AND ItemCode='$it'"));
			$OnHandQty=$temp1['Quantity'];
			/*if ($countOITW > 0)
			{
				$OnHandQty=$InWhs['Quantity'];
			}else
			{
				$OnHandQty=$InWhs['Quantity'];
			}*/
		
		echo $OnHandQty;?>
        <?=form_hidden("stdstock_detail[OnHand][$k]", $OnHandQty,$data['stdstock_detail']['OnHand'][$i]);?>
		
        </td>
        <td>
       <?=substr($temp1['MinStock'],0,-4);?>
        <?=form_hidden("stdstock_detail[MinStock][$k]", substr($temp1['MinStock'],0,-4),$data['stdstock_detail']['MinStock'][$i]);?>
        </td>
         <td>
       <?=substr($temp2['OpenQty'],0,-4);?>
        <?=form_hidden("stdstock_detail[OpenQty][$k]", substr($temp2['OpenQty'],0,-4),$data['stdstock_detail']['OpenQty'][$i]);?>
        </td>
	</tr>
<?php
	mysql_close($mysqlcon);
	endif;
?>
<?php
//endif;
?>
</table>
<?php if($data['stdstock_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
            <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
            <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?>
        </td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Request Tambahan untuk Standard Stock.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
  </tr>
	<tr>
    <td align="center"><?=anchor('stdstock/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
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