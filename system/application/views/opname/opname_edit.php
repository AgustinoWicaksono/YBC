<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
.style1 {font-size: 9px}
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
		$c=mssql_connect($host_sap,$user_sap,$pass_sap);
		$b=mssql_select_db($db_sap,$c);
		$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);		
$function = $this->uri->segment(2);
//echo "<opnamee>";
//opnameint '$request_reasons ';
//opnameint_r($data['opname_header']);
//echo "</opnamee>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('opname_header[id_opname_header]', $this->uri->segment(3));?>
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
		<td class="column_input"><?=form_hidden('opname_header[id_opname_header]', $opname_header['id_opname_header']);?><strong><?=$opname_header['id_opname_header'];?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Stock Opname Number </strong></td>
	  <td class="column_input">
        <?=empty($data['opname_header']['opname_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['opname_header']['opname_no'];?>
        <?=form_hidden("opname_header[opname_no]", $data['opname_header']['opname_no']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet </strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
      <td class="table_field_1"><strong>Storage Location </strong> </td>
	  <td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
  </tr>
    <!--tr>
      <?php 
	//mysql_connect("localhost","root","");
	//mysql_select_db("sap_php2");
	$p=$this->session->userdata['ADMIN']['plant'];
	$ta=mysql_query("SELECT otd_code FROM m_outlet WHERE outlet = '$p'", $mysqlcon);
	$ra=mysql_fetch_array($ta);
	$plant=$ra['otd_code'];
	//echo $plant;
	$t=mysql_query("SELECT * FROM m_outlet where  LEFT(outlet,1) <> 'T' ", $mysqlcon);
	while ($r=mysql_fetch_array($t))
	{
		$pl[$r['OUTLET']] =$r['OUTLET_NAME1']."(".$r['OUTLET'].")"; 
	}?>
		<td class="table_field_1"><strong>Request To Outlet</strong></td>
		<td class="column_input"><?= form_dropdown("opname_header[to_plant]", $pl, $data['opname_header']['to_plant'], ' data-placeholder="Pilih Departement..." class="chosen-select error_text" style="width:450px;" ');?></td>
	</tr-->
	<!--tr>
		<td class="table_field_1"><strong>Request Reason</strong> </td>
		<td class ="column_input">
        <?php if($data['opname_header']['status'] != '2') : ?>
        <?=form_dropdown('opname_header[request_reason]', $request_reasons, $request_reason, 'class="input_text"');?>
        <?php else : ?>
        <?=$request_reason;?>
        <?php endif;?></td>
	</tr-->
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=$data['opname_header']['status_string'];?></strong>
        <?=form_hidden("opname_header[status]", $data['opname_header']['status']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("opname_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
   
	</tr>
	<tr>
	  <td class="table_field_1"><strong>Posting Date</strong></td>
	  <td class="column_input"><?php 
	  if ($function != 'edit')
		{
        $date=date('Y-m-d');
		//echo $date;
		}
		else
		{
		$date=substr($data['opname_header']['posting_date'],0,10);
		}
	  if(($data['opname_header']['status'] != '2')) : ?>
	    <?=form_input('opname_header[posting_date]', $date, 'class="input_text" size="10"');?>
	    <?php else : ?>
      <?=$data['opname_header']['posting_date'];?><?=form_hidden("opname_header[posting_date]", $data['opname_header']['posting_date']);?>
      <?php endif;?>
      <span class="style1"> &nbsp;(YYYY-MM-DD)</span></td>
  </tr>
	<tr>
		<td colspan="2" align="right" class="table_field_1"><script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'opname_header[created_date]'
					});
		</script>
          <?php if($data['opname_header']['status'] == '2') : ?>
	      <?php if ($this->l_auth->is_have_perm('auth_change')) : ?>
	      <?=form_submit($this->config->item('button_change'), $this->lang->line('button_change'));?>
	      <?=form_submit($this->config->item('button_delete_item'),'Delete Item');?>
	      <?php endif; ?>
	      <?php else: ?>
	      <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
	      <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
	      <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
	      <?php endif; ?>
	      <?php endif; ?></td>
<?php
   if($data['opname_header']['status'] != '2') {
    	if(empty($_POST) && $function == 'input2')
//    		$created_date = date("d-m-Y");
    		$created_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
    	else if(!empty($data['opname_header']['created_date']))
            if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0)||(!empty($error)))
        		$created_date = $data['opname_header']['created_date'];
            else
        		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['opname_header']['created_date'])));
   } else {
     $created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['opname_header']['created_date'])));;
   }
?>
    </tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(empty($data['opname_header']['status']) || $data['opname_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
         <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
		 <!--td class="table_header_1"><div align="center"><strong>In Whs Quantity</strong></div></td-->
         <!--td class="table_header_1"><div align="center"><strong>Available Batch</strong></div></td-->
        <td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Price / Item</strong></div></td-->
		<!--td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Var</strong></div></td-->
		<?php if(($data['opname_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))) : ?><td class="table_header_1"><div align="center"><strong>Delete</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['opname_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $opname_detail_tmp = $this->session->userdata('opname_detail');
    if(!empty($opname_detail_tmp)) {
       $data['opname_detail'] = $opname_detail_tmp;
    }

	$count = count($data['opname_detail']['id_opname_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($opname_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($opname_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['opname_header']['status'] == '1' || ( ($data['opname_header']['status'] == '2') && !empty($data['opname_detail']['requirement_qty'][$i]) && !empty($data['opname_detail']['uom'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("opname_detail[requirement_qty][$i]", $error) || in_array("opname_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['opname_detail']['material_no'][$i]);
            if (!empty($data['opname_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['opname_detail']['material_desc'][$i];
              $item_x[$i]['UNIT1'] = $data['opname_detail']['uom'][$i];
			  $item_x[$i]['num'] = $data['opname_detail']['num'][$i];
			   
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(empty($data['opname_header']['status']) || $data['opname_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['opname_header']['status']) || $data['opname_header']['status'] !== '0') : ?>
        <?=form_hidden("opname_detail[id_opname_h_detail][$k]", $data['opname_detail']['id_opname_h_detail'][$k]);?>
        <?=form_hidden("opname_detail[id_opname_detail][$k]", $data['opname_detail']['id_opname_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("opname_detail[material_no][$k]", $data['opname_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
        <!--td align="left"><?php /*form_hidden("opname_detail[num][$k]", $data['opname_detail']['num'][$i]);?>
        <?=$data['opname_detail']['num'][$i];*/?></td-->
       <!--td>
        <?php //echo $data['opname_detail']['stock'][$i];?>
        <?php //form_hidden("opname_detail[stock][$k]",number_format($data['opname_detail']['stock'][$i]), 2, '.', '');?>
        </td-->
         <!--td>
        <?php /*$data['opname_detail']['stock_batch'][$i];?>
        <?=form_hidden("opname_detail[stock_batch][$k]",number_format($data['opname_detail']['stock_batch'][$i]), 2, '.', ''); */?>
        </td-->
		<td align="center">
<?php
			if(!empty($error) && in_array("opname_detail[requirement_qty][$i]", $error)) {
				echo form_input("opname_detail[requirement_qty][$k]", number_format($data['opname_detail']['requirement_qty'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i]);
                if($data['opname_header']['status'] == '2') {
    			  echo form_hidden("opname_detail[requirement_qty_old][$k]", $data['opname_detail']['requirement_qty'][$i]);
                }
                echo form_input("opname_detail[requirement_qty][$k]", number_format($data['opname_detail']['requirement_qty'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td>
<!--td align="center">
<?php

			/*if(!empty($error) && in_array("opname_detail[opnameice][$i]", $error)) {
				echo form_input("opname_detail[opnameice][$k]", number_format($data['opname_detail']['opnameice'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("opname_detail[opnameice][$k]", $data['opname_detail']['opnameice'][$i]);
                if($data['opname_header']['status'] == '2') {
    			  echo form_hidden("opname_detail[opnameice_old][$k]", $data['opname_detail']['opnameice'][$i]);
                }
                echo form_input("opname_detail[opnameice][$k]", number_format($data['opname_detail']['opnameice'][$i], 3, '.', ''), 'class="input_number" size="8"');
			}*/
?></td-->
        <td>
        <?=$item_x[$i]['UNIT1'];?>
        <?=form_hidden("opname_detail[uom][$k]",$item_x[$i]['UNIT1']);?>
        </td>
		<?php if(($data['opname_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))): ?>
        <td align="center">
        <?php if($data['opname_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['opname_detail']['id_opname_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['opname_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['opname_header']['status'] != '2') :

?>
	<tr>
<?php if(empty($data['opname_header']['status']) || $data['opname_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['opname_header']['status']) || $data['opname_header']['status'] !== '0') : ?><?=form_hidden("opname_detail[id_opname_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2">
		<?php
		if ($function =='edit')
		{
			$item2=mysql_query("SELECT MATNR,MAKTX FROM m_item", $mysqlcon);
			if ($item2)
			{
				//echo "sukses";
			}
			while($s=mysql_fetch_array($item2))
			{
				$item[$s['MATNR']] = $s['MATNR'].' - '.$s['MAKTX'];
			}
		}
		//$item=array('1','2');
		
		if(!empty($error) && in_array("opname_detail[material_no][$i]", $error)) {
			echo form_dropdown("opname_detail[material_no][$k]", $item, $data['opname_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();" ');
		} else {
			echo form_dropdown("opname_detail[material_no][$k]", $item, $data['opname_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');
		}
		?>
		</td>
        <!--td align="center">
		 <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php2");
		$it=$data['opname_detail']['material_no'][$i];
		/*$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'");
		//echo "SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"; 
		$count=mysql_num_rows($t);
		$item1[0]= '';
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['num']] = $r['num'];
		}
		
		//print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("opname_detail[num][$i]", $error)) {
			echo form_dropdown("opname_detail[num][$k]", $item1, $data['opname_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
		echo form_dropdown("opname_detail[num][$k]", $item1  , $data['opname_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');  
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}*/
		?>
		</td-->
        <!--td align="center">
		<?php
			$InWhs=mssql_fetch_array(mssql_query("SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'"));
		//echo "SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'";
       
		//echo substr($InWhs['Quantity'],0,-4);?>
        <?=form_hidden("opname_detail[stock][$k]", substr($InWhs['Quantity'],0,-4),$data['opname_detail']['stock'][$i]);?>
		
        </td-->
         <!--td align="center">
		<?php
		
		/*$batch=$data['opname_detail']['num'][$i];
		if ($batch=='')
		{
			$InWhs=mssql_fetch_array(mssql_query("SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'"));
		}else{
		$InWhs=mssql_fetch_array(mssql_query("SELECT A.Quantity FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$whs' AND A.ItemCode='$it' AND B.DistNumber='$batch'"));
}
		
       
		echo substr($InWhs['Quantity'],0,-4);?>
        <?=form_hidden("opname_detail[stock_batch][$k]", substr($InWhs['Quantity'],0,-4),$data['opname_detail']['stock_batch'][$i]); */?>
		
        </td-->
        <td align="center">
		<?php
		if(!empty($error) && in_array("opname_detail[requirement_qty][$i]", $error)) {
			echo form_input("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
		<td>
        <?php
		$it=$data['opname_detail']['material_no'][$i];
		
         $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'", $mysqlcon);
	   //$ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$it' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$it' 
group by m_uom.UomName 

", $mysqlcon);


$count1=mysql_num_rows($ta);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($ta))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//opnameint_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("opname_detail[uom][$i]", $error)) {
			echo form_dropdown("opname_detail[uom][$k]", $itemC, $data['opname_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("opname_detail[uom][$k]", $itemC  , $data['opname_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
?>
        </td>
	</tr>
<?php
mssql_close($c);
	endif;
?>
<?php
//endif;
?>
</table>
<?php if($data['opname_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
            <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
            <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?>
        </td>
	</tr>
</table>
<?php 
mysql_close($mysqlcon);
endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Request Tambahan untuk Standard Stock.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
  </tr>
	<tr>
    <td align="center"><span class="column_input">
      <?=anchor('opname/browse', $this->lang->line('button_back'));?>
    </span></td>
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