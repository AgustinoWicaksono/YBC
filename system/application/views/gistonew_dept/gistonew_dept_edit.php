<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print 'array ';F
//print_r($item_group);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('gistonew_dept_header[id_gistonew_dept_header]', $this->uri->segment(3));?>
<table width="<?php echo $lebar; ?>" border="0" align="center">
  <?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
  <tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td width="744" class="table_field_h"><?php echo $this->m_gistonew_dept->posto_lastupdate(); ?>
        <?php /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>    </td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Store Room Request (SR) Number</strong></td>
    <td class="column_input"><strong>
      <?php
    if ($function!='edit')
	{
	?>
      <?=form_hidden('gistonew_dept_header[po_no]', $gistonew_dept_header['VBELN']);?>
      <?=$gistonew_dept_header['VBELN']; ?>
      </strong>
        <?php if($function == 'input2') echo ' '.anchor('gistonew_dept/input', '<strong>Pilih ulang SR Number dan Jenis Material</strong>');
		}
		else
		{
		  $po=$data['gistonew_dept_header']['po_no'];?>
		   <?=form_hidden('gistonew_dept_header[po_no]', $po);?>
      <?=$po; }?>
	
	
		</td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Transfer Slip Number </strong></td>
    <td class="column_input"><strong>
      <?=empty($data['gistonew_dept_header']['gistonew_dept_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['gistonew_dept_header']['gistonew_dept_no'];?>
    </strong></td>
  </tr>
  <!--tr>
    <td class="table_field_1"><strong>Delivery Date</strong></td>
    <td class="column_input"><?=form_hidden('gistonew_dept_header[delivery_date]', $gistonew_dept_header['delivery_date']);?>
        <strong>
          <?php if(!empty($gistonew_dept_header['delivery_date'])) : ?>
          <?=$this->l_general->sqldate_to_date($gistonew_dept_header['delivery_date']);?>
          <?php endif; ?>
        </strong></td>
  </tr-->
  <tr>
    <td class="table_field_1"><strong>Outlet </strong></td>
    <td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Storage Location </strong> </td>
    <td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Request For </strong></td>
     <td class="column_input">
    <?php
	if ($function != 'edit')
	{
    $rq=mssql_fetch_array(mssql_query("SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$gistonew_dept_header[VBELN]'"));
	?>
	<?=$rq['ToWhsCode'].' - '.$rq['WhsName'];?>
    <?=form_hidden('gistonew_dept_header[receiving_plant]', $rq['ToWhsCode']);
	}else
	{
	$rq=mssql_fetch_array(mssql_query("SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$po'"));
	?>
	<?=$rq['ToWhsCode'].' - '.$rq['WhsName'];?>
    <?=form_hidden('gistonew_dept_header[receiving_plant]', $rq['ToWhsCode']);
	//echo "SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$po'";
	}
	?>
    </td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Status </strong></td>
    <td class = "column_input"><strong>
      <?=($function == 'input2') ? 'Not Approved' : $data['gistonew_dept_header']['status_string'];?>
    </strong></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Material Group
      <?php  $ha=$gistonew_dept_header['VBELN'];
	  
		?>
    </strong> </td>
    <td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_name'];?>
        <?=form_hidden("gistonew_dept_header[item_group_code]", $gistonew_dept_header['item_group_code']);?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Posting Date </strong></td>
    <!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['gistonew_dept_header']['posting_date']));?></td>//-->
    <?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['gistonew_dept_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['gistonew_dept_header']['posting_date']));
        } else {
    		$posting_date = $data['gistonew_dept_header']['posting_date'];
        }

    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['gistonew_dept_header']['posting_date']));
?>
    <td class="column_input"><?php /* //disabled-20111011- requested by Bu Narti
		<?php if(($data['gistonew_dept_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('gistonew_dept_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'gistonew_dept_header[posting_date]'
					});
		</script><?php else: ?>
		
		//end of disabled-20111011- requested by Bu Narti 
		*/
		?>
        <?=$posting_date;?>
      <?=form_hidden("gistonew_dept_header[posting_date]", $posting_date);?>
        <?php /*
		//disabled-20111011- requested by Bu Narti
		<?php endif;?>
		//end of disabled-20111011- requested by Bu Narti
		*/ ?>    </td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="table_field_1"><?php if($data['gistonew_dept_header']['status'] == '2') : ?>
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
<?php if(!isset($data['gistonew_dept_header']['status']) || $data['gistonew_dept_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td>
         <td class="table_header_1"><div align="center"><strong>In Whs Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Outstanding Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Uom Req.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<?php if(($data['gistonew_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['gistonew_dept_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $gistonew_dept_detail_tmp = $this->session->userdata('gistonew_dept_detail');
    if(!empty($gistonew_dept_detail_tmp)) {
       $data['gistonew_dept_detail'] = $gistonew_dept_detail_tmp;
    }

	$count = count($data['gistonew_dept_detail']['id_gistonew_dept_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($gistonew_dept_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($gistonew_dept_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['gistonew_dept_header']['status'] == '1' || ( ($data['gistonew_dept_header']['status'] == '2') && !empty($data['gistonew_dept_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("gistonew_dept_detail[gr_quantity][$i]", $error) || in_array("gistonew_dept_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['gistonew_dept_detail']['material_no'][$i]);
            if (!empty($data['gistonew_dept_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['gistonew_dept_detail']['material_desc'][$i];
            }
			if (!empty($data['gistonew_dept_detail']['POSNR'][$i])) {
              $item_x[$i]['MAKTX'] = $data['gistonew_dept_detail']['POSNR'][$i];
            }
            if (!empty($data['gistonew_dept_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['gistonew_dept_detail']['uom'][$i];
            }
			 if (!empty($data['gistonew_dept_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['gistonew_dept_detail']['num'][$i];
            }
			if (!empty($data['gistonew_dept_detail']['outstanding_qty'][$i])) {
              $item_x[$i]['outstanding_qty'] = $data['gistonew_dept_detail']['outstanding_qty'][$i];
            }

?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['gistonew_dept_header']['status']) || $data['gistonew_dept_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gistonew_dept_header']['status']) || $data['gistonew_dept_header']['status'] == '1') : ?>
        <?=form_hidden("gistonew_dept_detail[id_gistonew_dept_h_detail][$k]", $data['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$k]);?>
        <?=form_hidden("gistonew_dept_detail[id_gistonew_dept_detail][$k]", $data['gistonew_dept_detail']['id_gistonew_dept_detail'][$k]);?>
        <?=form_hidden("gistonew_dept_detail[posnr][$k]", $data['gistonew_dept_detail']['posnr'][$i]);?> 
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("gistonew_dept_detail[material_no][$k]", $data['gistonew_dept_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("gistonew_dept_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <td>
        <?=$item_x[$i]['num'];?>
        <?=form_hidden("gistonew_dept_detail[num][$k]", $item_x[$i]['num']);?>
        </td>
        <td>
         <?php
       $stock= number_format($data['gistonew_dept_detail']['stock'][$i], 2, '.', '')
		?>
        <?=$stock;?>
        <?=form_hidden("gistonew_dept_detail[stock][$k]", $stock);?>
        </td>
        <td> <?=substr($item_x[$i]['outstanding_qty'],0,-2);?>
        <?=form_hidden("gistonew_dept_detail[outstanding_qty][$k]", $item_x[$i]['outstanding_qty']);?> </td>
		<td align="center">
<?php
$out=$data['gistonew_dept_detail']['outstanding_qty'][$i];
$item=$data['gistonew_dept_detail']['material_no'][$i];
$gr=$data['gistonew_dept_detail']['gr_quantity'][$i];
//mysql_query("INSERT INTO t_gistonew_dept_detail_temp SET material_no='$item' , outstanding_qty='$out', gr_quantity='$gr'");

			if(!empty($error) && in_array("gistonew_dept_detail[gr_quantity][$i]", $error)) {
				echo form_input("gistonew_dept_detail[gr_quantity][$k]", number_format($data['gistonew_dept_detail']['gr_quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("gistonew_dept_detail[gr_quantity][$k]", $data['gistonew_dept_detail']['gr_quantity'][$i]);
                if($data['gistonew_dept_header']['status'] != '2')
    				echo form_input("gistonew_dept_detail[gr_quantity][$k]", number_format($data['gistonew_dept_detail']['gr_quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
    				echo number_format($data['gistonew_dept_detail']['gr_quantity'][$i], 2, '.', ',');
			}
?></td>
<td> <?=$data['gistonew_dept_detail']['uom_req'][$i];?>
        <?=form_hidden("gistonew_dept_detail[uom_req][$k]",$data['gistonew_dept_detail']['uom_req'][$i]);?> </td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['gistonew_dept_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['gistonew_dept_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT'];?>
         <?=form_hidden("gistonew_dept_detail[uom][$k]", $item_x[$i]['UNIT']);?>
        </td>
		<?php if(($data['gistonew_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['gistonew_dept_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['gistonew_dept_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr> 
<?php
			$k++;
		}
		
	}
	
	// below is for new data
	if($data['gistonew_dept_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['gistonew_dept_header']['status']) || $data['gistonew_dept_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gistonew_dept_header']['status']) || $data['gistonew_dept_header']['status'] == '1') : ?><?=form_hidden("gistonew_dept_detail[id_gistonew_dept_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		$te=mssql_query("SELECT WTQ1.ItemCode MATNR,Dscription MAKTX, OpenQty qty,LineNum POSNR  FROM OWTQ INNER JOIN WTQ1 ON
		OWTQ.DocEntry = WTQ1.DocEntry INNER JOIN OITM ON WTQ1.ItemCode = OITM.ItemCode INNER JOIN OWHS ON OWHS.WhsCode = OWTQ.Filler
		WHERE
OWTQ.DocEntry = '$gistonew_dept_header[VBELN]'
		");
		/*echo "SELECT WTQ1.ItemCode MATNR,Dscription MAKTX, WTQ1.OpenQty qty  FROM OWTQ INNER JOIN WTQ1 ON
		OWTQ.DocEntry = WTQ1.DocEntry INNER JOIN OITM ON WTQ1.ItemCode = OITM.ItemCode INNER JOIN OWHS ON OWHS.WhsCode = OWTQ.Filler
		WHERE
OWTQ.DocEntry = '$gistonew_dept_header[VBELN]'
		";*/
		$item1[0]='';
		while ($re=mssql_fetch_array($te))
		{
			$item1[$re['MATNR']]= $re['MATNR']." - ".$re['MAKTX']."(".$re['POSNR'].")";
			$qty[$i] = substr($re['qty'],0,-4);
			//$posnr[$i]=$re['POSNR'];
		}
		if(!empty($error) && in_array("gistonew_dept_detail[material_no][$i]", $error)) {
			echo form_dropdown("gistonew_dept_detail[material_no][$k]", $item1, $data['gistonew_dept_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("gistonew_dept_detail[material_no][$k]", $item1, $data['gistonew_dept_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		?>
		</td>
       
        <td>
         <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		$it=$data['gistonew_dept_detail']['material_no'][$i];
		$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2[0]='';
		while($r=mysql_fetch_array($t))
		{
			$item2[$r['num']] = $r['num'];
		}
		
		//print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("gistonew_dept_detail[num][$i]", $error)) {
			echo form_dropdown("gistonew_dept_detail[num][$k]", $item2, $data['gistonew_dept_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
		echo form_dropdown("gistonew_dept_detail[num][$k]", $item2  , $data['gistonew_dept_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');  
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}
		?>
        
        </td>
         <td align="center">
		<?php
		
		$batch=$data['gistonew_dept_detail']['num'][$i];
		if ($batch=='')
		{
			$InWhs=mssql_fetch_array(mssql_query("SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'"));
		}else{
		$InWhs=mssql_fetch_array(mssql_query("SELECT A.Quantity FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$whs' AND A.ItemCode='$it' AND B.DistNumber='$batch'"));
}
		
       
		echo substr($InWhs['Quantity'],0,-4);?>
        <?=form_hidden("gistonew_dept_detail[stock][$k]", substr($InWhs['Quantity'],0,-4),$data['gistonew_dept_detail']['stock'][$i]);?>
		
        </td>
        <td align="center">
		<?php
		$rowQty=mssql_fetch_array(mssql_query("SELECT (OpenQty-U_grqty_web) OpenQty,LineNum, UomCode FROM WTQ1 WHERE DocEntry='$gistonew_dept_header[VBELN]' AND ItemCode='$it'"));
		$rowSql=mysql_fetch_array(mysql_query("SELECT gr_quantity FROM t_gistonew_dept_detail_temp WHERE material_no='$it'"));
		$qty=substr($rowQty['OpenQty'],0,-4);//-$rowSql['gr_quantity'];
		$posnr=$rowQty['LineNum'];
		$uom=$rowQty['UomCode'];
		if ($it != '')
		{
		//echo $qty[$i];
		echo number_format($qty, 2, '.', ',');?><?=form_hidden("gistonew_dept_detail[outstanding_qty][$i]",$qty);?>
		<?=form_hidden("gistonew_dept_detail[posnr][$i]",$posnr);
		}
		?>
		</td>
		<td align="center">
		<?php
	/*	if ($it != '')
		{
		if(!empty($error) && in_array("gistonew_dept_detail[gr_quantity][$i]", $error)) {
			echo form_input("gistonew_dept_detail[gr_quantity][$k]",$qty, $data['gistonew_dept_detail']['gr_quantity'][$i], 'class="error_number" size="8" ');
		} else {
			echo form_input("gistonew_dept_detail[gr_quantity][$k]",$qty, $data['gistonew_dept_detail']['gr_quantity'][$i], 'class="input_number" size="8" ');
		}
		}*/
		//else
		//{
			if(!empty($error) && in_array("gistonew_dept_detail[gr_quantity][$i]", $error)) {
			echo form_input("gistonew_dept_detail[gr_quantity][$k]", $data['gistonew_dept_detail']['gr_quantity'][$i], 'class="error_number" size="8" ');
		} else {
			echo form_input("gistonew_dept_detail[gr_quantity][$k]", $data['gistonew_dept_detail']['gr_quantity'][$i], 'class="input_number" size="8" ');
		}
		//}
		
		?>
		</td>
          <!-- dari sini -->
          <td> <?=$uom;?>
        <?=form_hidden("gistonew_dept_detail[uom_req][$k]",$uom);?> </td>
        <td>
       <?php
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'");
	   $ra=mysql_fetch_array($ta);
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

");

		$count1=mysql_num_rows($tq);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($tq))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("gisto_detail[uom][$i]", $error)) {
			echo form_dropdown("gistonew_dept_detail[uom][$k]", $itemC, $data['gistonew_dept_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("gistonew_dept_detail[uom][$k]", $itemC  , $data['gistonew_dept_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
		
		//echo $uom;?>
        <?php //form_hidden("gistonew_dept_detail[uom][$k]", $uom,$data['gistonew_dept_detail']['uom'][$i]);?>
	   
        </td>
        <!-- sampe sini -->
	</tr>
<?php
	endif;
?>
<?php if(($data['gistonew_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="5">&nbsp;</td>
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
<?php if($data['gistonew_dept_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0" align="left">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue Stock Transfer Antar Plant.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a>        </td>
  </tr>
	<tr>
    <td align="center"><?=anchor('gistonew_dept/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?=form_close();?>
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