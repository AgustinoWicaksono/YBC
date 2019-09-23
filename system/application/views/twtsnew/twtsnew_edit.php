<?php
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
//$c=mssql_connect($host_sap,$user_sap,$pass_sap);
//						$b=mssql_select_db($db_sap,$c);
$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
mysql_select_db($db_mysql,$mysqlcon);
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($twtsnew_detail);
//echo "</pre>";
//echo '$item_paket_name'.$item_paket_name
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('twtsnew_header[id_twtsnew_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
 $whs=$this->session->userdata['ADMIN']['plant'];
if ($function=='edit') {
  $item_paket_code = $data['twtsnew_header']['kode_paket'];
  $item_paket_name = $data['twtsnew_header']['nama_paket'];
  $uom_paket = $data['twtsnew_header']['uom_paket'];
 
}
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
$var_cek=1;
?>
	<tr>
		<td class="table_field_1"><strong>ID Transaksi  </strong></td>
		<td class="column_input"><?=form_hidden('twtsnew_header[id_twtsnew_header]', $this->uri->segment(3));?><strong><?=$this->uri->segment(3);?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Item Code</strong></td>
		<td class="column_input"><?=form_hidden("twtsnew_header[kode_paket]", $item_paket_code);?>
        <strong><?=$this->l_general->remove_0_digit_in_item_code($item_paket_code);?></strong> <? if($function!='edit') : echo anchor('twtsnew/input', '<strong>Pilih Ulang Item paket</strong>'); endif; ?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong> Item Description</strong></td>
		<td class="column_input"><?=form_hidden("twtsnew_header[nama_paket]", $item_paket_name);?>
        <strong><?=$item_paket_name;?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong> Quantity</strong></td>
        <td class = "column_input" >
		<?php
  		if(!empty($error) && in_array("twtsnew_header[quantity_paket]", $error)) {
  			echo form_input("twtsnew_header[quantity_paket]", number_format($data['twtsnew_header']['quantity_paket'], 2, '.', ''), 'class="error_number" size="8"').' '.$uom_paket;
  		} else {
  			echo form_input("twtsnew_header[quantity_paket]", number_format($data['twtsnew_header']['quantity_paket'], 2, '.', ''), 'class="input_number" size="8"').' '.$uom_paket;
  		}
		?><?=form_hidden("twtsnew_header[uom_paket]", $uom_paket);
//		$cekStock=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT Onhand Quantity FROM OITW WHERE ItemCode='$item_paket_code' AND WhsCode='$whs'"));
//		$cekRow=mysql_num_rows(mysql_query("SELECT Quantity FROM m_batch WHERE ItemCode='$item_paket_code' AND Whs='$whs'"));
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$cekRow=sqlsrv_num_rows(sqlsrv_query($b,"SELECT Onhand Quantity FROM OITW WHERE ItemCode='$item_paket_code' AND WhsCode='$whs'",$params,$options));
		if ($cekRow)
		{
//		$cekStock1=mysql_fetch_array(mysql_query("SELECT Quantity FROM m_batch WHERE ItemCode='$item_paket_code' AND Whs='$whs'"));
			$cekStock1=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT Onhand Quantity FROM OITW WHERE ItemCode='$item_paket_code' AND WhsCode='$whs'"));
			$qtyOH=$cekStock1['Quantity'];
		}else
		{
			$qtyOH=0;
		}
		sqlsrv_close($b);
		//echo "SELECT * FROM OITW WHERE ItemCode='$item_paket_code' AND WhsCode='$whs'";
		?>
	<b>	On Hand : <?=substr($qtyOH,0,-4);?> </b> <b> <i> <font color="#FF0000"> (Tekan Enter Setelah Input Quantity) </font>  </i> </b>
        </td>
	</tr>
    <tr>
		<td colspan="2" align="right" class="table_field_1">
			<?php if($data['twtsnew_header']['status'] == '2') : ?>
			<?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
			<?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
			<?php endif; ?>
			<?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
			<?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
			<?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
			<?php endif; ?>
			<?php endif; ?>
		</td>
		<!--td class="table_field_1"><strong>Batch Number</strong></td>
        <td class = "column_input" >
		<?php
		
		//$to="SELECT * FROM m_batch WHERE ItemCode='$item_paket_code' AND Whs = '$whs' AND Quantity > 0 AND Whs='$whs'";
		/*$to1="SELECT  B.DistNumber FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$whs' AND A.ItemCode='$item_paket_code' AND A.Quantity > 0";
		$t=mssql_query($to1);
		while($r=mssql_fetch_array($t))
		{
			$item1[$r['DistNumber']] = $r['DistNumber'];
		}
  		if(!empty($error) && in_array("twtsnew_header[num]", $error)) {
			echo form_dropdown("twtsnew_header[num]", $item1, $data['twtsnew_header']['num'], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("twtsnew_header[num]", $item1  , $data['twtsnew_header']['num'], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		} // echo $to;*/?>
        
        </td-->
	</tr>
    
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
		<td width="1038" class="table_header_1"><div align="center"><strong>BOM Item</strong></div></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['twtsnew_header']['status']) || $data['twtsnew_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1" width="200"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Var</strong></div></td>
	</tr>
<?php
//if($data['twtsnew_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $twtsnew_detail_tmp = $this->session->userdata('twtsnew_detail');
    if(!empty($twtsnew_detail_tmp)) {
       $data['twtsnew_detail'] = $twtsnew_detail_tmp;
    }

	$count = count($data['twtsnew_detail']['id_twtsnew_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($twtsnew_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['twtsnew_header']['status'] == '1' || ( ($data['twtsnew_header']['status'] == '2') && !empty($data['twtsnew_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("twtsnew_detail[quantity][$i]", $error) || in_array("twtsnew_detail[material_no][$i]", $error)  ))
				break;
			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['twtsnew_detail']['material_no'][$i]);
            if (!empty($data['twtsnew_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['twtsnew_detail']['material_desc'][$i];
            }
            if (!empty($data['twtsnew_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['twtsnew_detail']['uom'][$i];
            }
			 if (!empty($data['twtsnew_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['twtsnew_detail']['num'][$i];
            } 
			
			//echo $data['twtsnew_detail']['num'][$i];
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['twtsnew_header']['status']) || $data['twtsnew_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center">
        <?=form_hidden("twtsnew_detail[id_twtsnew_h_detail][$k]", $data['twtsnew_detail']['id_twtsnew_h_detail'][$k]);?>
        <?=form_hidden("twtsnew_detail[id_twtsnew_detail][$k]", $data['twtsnew_detail']['id_twtsnew_detail'][$k]);?>
        <?=$k;?></td>
		<td align="left"><?=form_hidden("twtsnew_detail[material_no][$k]", $data['twtsnew_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("twtsnew_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--td>
        <?=$item_x[$i]['num'];?>
        <?=form_hidden("twtsnew_detail[num][$k]", $item_x[$i]['num']);?>
        </td-->
		<td align="center">
<?php
			if(!empty($error) && in_array("twtsnew_detail[quantity][$i]", $error)) {
				echo form_input("twtsnew_detail[quantity][$k]", number_format($data['twtsnew_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("twtsnew_detail[quantity][$k]", $data['twtsnew_detail']['quantity'][$i]);
                if($data['twtsnew_header']['status'] != '2')
   				  echo form_input("twtsnew_detail[quantity][$k]", number_format($data['twtsnew_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
   				  echo number_format($data['twtsnew_detail']['quantity'][$i], 2, '.', ',');
			}
?></td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['twtsnew_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['twtsnew_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT1'];?>
         <?=form_hidden("twtsnew_detail[uom][$k]", $item_x[$i]['UNIT1']);?>
        </td>
         <td>
        <?php
		 $qtyH=$data['twtsnew_header']['quantity_paket'];
		 $itemSlice=$item_paket_code;
		 $itemRec=$item_x[$i]['MATNR1'];
		 if ($i == 1)
		 {
         $req=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemSlice'", $mysqlcon));
		 $vol_hed=$req['VOL']*$qtyH;
		 //echo '{'.$req['VOL'].'-'.$qtyH.'}';
		 }
		 else
		 {
		  $req=mysql_fetch_array(mysql_query("SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'", $mysqlcon));
		  $vol_hed=$req['VOL_TEMP'];
		  //echo "SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'";
		 }
		
		$req1=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemRec'", $mysqlcon));
		$qty1=$data['twtsnew_detail']['quantity'][$i];
		$vol_det=$req1['VOL']*$qty1;
		$var_cek=$vol_hed-$vol_det;
	//echo "$vol_det=$req1[VOL]*$qty1 <br>";
		//echo "$var_cek=$vol_hed-$vol_det;";
		mysql_query("update m_item set VOL_TEMP ='$var_cek' WHERE MATNR='$itemSlice' ", $mysqlcon);
		 ?>
        <?php if ($function != 'edit') 
		{?>
		 <?=-1*abs($var_cek);?>
        <?=form_hidden("twtsnew_detail[var][$k]", $var_cek); }
		else {
		$item=$item_x[$i]['MATNR1'];
		$id=$data['twtsnew_header']['id_twtsnew_header'];
		$varQuery=mysql_fetch_array(mysql_query("SELECT var FROM m_twtsnew_detail where  id_twtsnew_header='$id' AND material_no='$item'", $mysqlcon));
		?> 
        <?=$varQuery['var']; }?>
         <?=form_hidden("twtsnew_detail[var][$k]", $varQuery['var']);?>
        
        </td>
  </tr>
<?php
			$k++;
		}

	}
	
	// below is for new data
	if($data['twtsnew_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['twtsnew_header']['status']) || $data['twtsnew_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['twtsnew_header']['status']) || $data['twtsnew_header']['status'] == '1') : ?><?=form_hidden("twtsnew_detail[id_twtsnew_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		
		//echo '{'.$var_cek;
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
		$tk="SELECT * FROM m_mwts_detail a 
		JOIN m_mwts_header b  on a.id_mwts_header=b.id_mwts_header
		JOIN m_item c on a.material_no=c.MATNR
		where b.kode_whi='$item_paket_code' and b.plant='$kd_plant'";
		//echo $tk;
		$ti=mysql_query($tk, $mysqlcon); 
		$count=mysql_num_rows($ti);
		$item2= "Tidak ada Batch Number";
		$item3[0]='';
		while($r=mysql_fetch_array($ti))
		{
			$item3[$r['material_no']] = $r['material_no'].' - '.$r['MAKTX'];
		}
		if ($var_cek > 0)
		{
		
		if(!empty($error) && in_array("twtsnew_detail[material_no][$i]", $error)) {
			echo form_dropdown("twtsnew_detail[material_no][$k]", $item3, $data['twtsnew_detail']['material_no'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("twtsnew_detail[material_no][$k]", $item3, $data['twtsnew_detail']['material_no'][$i], 'class="input_text" onChange="document.form1.submit();"');
		}
		}
		?>
		</td>
         <!--td>
         <?php
		/*$it=$data['twtsnew_detail']['material_no'][$i];
		$tk="SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'";
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($ti);
		//$item5= "Tidak ada Batch Number";
		$item4[0]='';
		while($r=mysql_fetch_array($ti))
		{
			$item4[$r['num']] = $r['num'];
		}
		
		//echo $tk;
		
		if ($count > 0){
	
		if(!empty($error) && in_array("twtsnew_detail[num][$i]", $error)) {
			echo form_dropdown("twtsnew_detail[num][$k]", $item4, $data['twtsnew_detail']['num'][$i], 'class="error_text" ');
		} else {
			echo form_dropdown("twtsnew_detail[num][$k]", $item4, $data['twtsnew_detail']['num'][$i], 'class="input_text" ');
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}*/
		?>
        
        </td-->
		<td align="center">
		<?php
		$mat=$data['twtsnew_detail']['material_no'][$i];
		$tp="SELECT * FROM m_mwts_detail a 
		JOIN m_mwts_header b  on a.id_mwts_header=b.id_mwts_header
		where b.kode_whi='$item_paket_code' and b.plant='$kd_plant' AND a.material_no='$mat'";
		$tl=mysql_fetch_array(mysql_query($tp, $mysqlcon)); 
		$qty=substr($tl['quantity'],0,-2);
		$ctl=mysql_num_rows(mysql_query($tp, $mysqlcon));
		if ($ctl > 0)
		{
		
		if(!empty($error) && in_array("twtsnew_detail[quantity][$i]", $error)) {
			echo form_input("twtsnew_detail[quantity][$k]", $qty,$data['twtsnew_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("twtsnew_detail[quantity][$k]", $qty,$data['twtsnew_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		}
		?>
		</td>
        <td>
        <?php
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$mat'", $mysqlcon);
	   //$ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$mat' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$mat' 
group by m_uom.UomName 

", $mysqlcon);

		$count1=mysql_num_rows($ta);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($ta))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("twtsnew_detail[uom][$i]", $error)) {
			echo form_dropdown("twtsnew_detail[uom][$k]", $itemC, $data['twtsnew_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:50px;" ');
		} else {
		echo form_dropdown("twtsnew_detail[uom][$k]", $itemC  , $data['twtsnew_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:50px;"  ');  
		}
		}
	   ?>
        </td>
        <td>
        </td>
	</tr>
<?php
	endif;
?>
<?php if(($data['twtsnew_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="6">&nbsp;</td>
		<td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', $j);?></td>
	</tr>
<script language="javascript">
	function selectAll(){
		for(i=1; i <= <?=$j;?>; i++)
			document.getElementById('cancel['+i+']').checked = document.getElementById('select_all').checked;
	}
</script>
<?php endif; ?>
<?php
//endif;
?>
</table>
<?php if($data['twtsnew_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
<?php //if ($var_cek == 0 && $cekStock['Onhand'] >= $data['twtsnew_header']['quantity_paket'])
	if ($qtyOH >= $data['twtsnew_header']['quantity_paket'])
		{ ?>
	<tr>
		<!--td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue to Cost Center.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td-->
         <td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue Stock Transfer Antar Plant.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a>
        </td>
        
	</tr>
    <?php
    }
	?>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('twtsnew/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();
	mysql_close($mysqlcon);
?>
