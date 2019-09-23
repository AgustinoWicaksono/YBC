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
//$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);


$function = $this->uri->segment(2);
//echo "<pre>";
//print 'array ';F
//print_r($item_group);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('gistonew_out_header[id_gistonew_out_header]', $this->uri->segment(3));?>
<table width="<?php echo $lebar; ?>" border="0" align="center">
  <?php
 
   $con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
   //mssql_connect($server, $username, $password);
   //$db=mssql_select_db('Test_MSI',$con);
	  
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
  <tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td width="744" class="table_field_h"><?php echo $this->m_gistonew_out->posto_lastupdate(); ?>
        <?php /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>    </td>
  </tr>
  
	<tr>
		<td class="table_field_1"><strong>ID Transaksi  </strong></td>
		<td class="column_input"><?=form_hidden('gistonew_out_header[id_gistonew_out_header]', $gistonew_out_header['id_gistonew_out_header']);?><strong><?=$gistonew_out_header['id_gistonew_out_header'];?></strong></td>
	</tr>
  <tr>
    <td class="table_field_1"><strong>Store Room Request (SR) Number</strong></td>
    <td class="column_input"><strong>
    <?php
    if ($function!='edit')
	{
	?>
      <?=form_hidden('gistonew_out_header[po_no]', $gistonew_out_header['VBELN']);?>
      <?=$gistonew_out_header['VBELN']; ?>
      </strong>
        <?php if($function == 'input2') echo ' '.anchor('gistonew_out/input', '<strong>Pilih ulang SR No dan Jenis Material</strong>');
		}
		else
		{
		  $po=$data['gistonew_out_header']['po_no'];?>
		  <?=form_hidden('gistonew_out_header[po_no]', $po);?>
      <?=$po; } ?>
		
		</td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Transfer Slip Number</strong></td>
    <td class="column_input"><strong>
      <?=empty($data['gistonew_out_header']['gistonew_out_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['gistonew_out_header']['gistonew_out_no'];?>
    </strong></td>
  </tr>
  <!--tr>
    <td class="table_field_1"><strong>Delivery Date</strong></td>
    <td class="column_input"><?=form_hidden('gistonew_out_header[posting_date]', $gistonew_out_header['posting_date']);?>
        <strong>
          <?php if(!empty($gistonew_out_header['posting_date'])) : ?>
          <?=$this->l_general->sqldate_to_date($gistonew_out_header['posting_date']);?>
          <?php endif; ?>
        </strong></td>
  </tr-->
  <tr>
    <td class="table_field_1"><strong>Outlet From</strong></td>
    <td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Storage Transit Location </strong></td>
    <td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
  </tr>
   <tr>
    <td class="table_field_1"><strong>Request To</strong></td>
    
    <td class="column_input">
	<?php
	if ($function != 'edit')
	{
    $rq=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$gistonew_out_header[VBELN]'"));
	//echo "SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$gistonew_out_header[VBELN]'";
	?>
	<?=$rq['ToWhsCode'].' - '.$rq['WhsName'];?>
    <?=form_hidden('gistonew_out_header[receiving_plant]', $rq['ToWhsCode']);
	}else
	{
	$rq=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$po'"));
	?>
	<?=$rq['ToWhsCode'].' - '.$rq['WhsName'];?>
    <?=form_hidden('gistonew_out_header[receiving_plant]', $rq['ToWhsCode']);
	//echo "SELECT ToWhsCode,OWHS.WhsName FROM OWTQ JOIN OWHS ON OWHS.WhsCode=OWTQ.ToWhsCode WHERE DOcEntry = '$po'";
	}
	?>    </td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Status </strong></td>
    <td class = "column_input"><strong>
      <?=($function == 'input2') ? 'Not Approved' : $data['gistonew_out_header']['status_string'];?>
    </strong></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Material Group<strong><strong><strong><strong><strong><strong><strong>
      <?php  $ha=$gistonew_out_header['VBELN'];
	  
		?>
    </strong></strong></strong></strong></strong></strong></strong></strong> </td>
    <td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
    <?=$item_group['item_group_name'];?>      <?=form_hidden("gistonew_out_header[item_group_code]", $gistonew_out_header['item_group_code']);?></td>
  </tr>
  <tr>
    <td class="table_field_1"><strong>Posting Date </strong></td>
    <!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['gistonew_out_header']['posting_date']));?></td>//-->
    <?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['gistonew_out_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['gistonew_out_header']['posting_date']));
        } else {
    		$posting_date = $data['gistonew_out_header']['posting_date'];
        }

    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['gistonew_out_header']['posting_date']));
?>
    <td class="column_input"><?php /* //disabled-20111011- requested by Bu Narti
		<?php if(($data['gistonew_out_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('gistonew_out_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'gistonew_out_header[posting_date]'
					});
		</script><?php else: ?>
		
		//end of disabled-20111011- requested by Bu Narti 
		*/
		?>
      <?=$posting_date;?>
      <?=form_hidden("gistonew_out_header[posting_date]", $posting_date);?>
      <?php /*
		//disabled-20111011- requested by Bu Narti
		<?php endif;?>
		//end of disabled-20111011- requested by Bu Narti
		*/ ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="table_field_1"><?php if($data['gistonew_out_header']['status'] == '2') : ?>
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
<?php if(!isset($data['gistonew_out_header']['status']) || $data['gistonew_out_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
         <td class="table_header_1"><div align="center"><strong>In Whs Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Outstanding Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Uom Req.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<?php if(($data['gistonew_out_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['gistonew_out_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $gistonew_out_detail_tmp = $this->session->userdata('gistonew_out_detail');
    if(!empty($gistonew_out_detail_tmp)) {
       $data['gistonew_out_detail'] = $gistonew_out_detail_tmp;
    }

	$count = count($data['gistonew_out_detail']['id_gistonew_out_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($gistonew_out_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($gistonew_out_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['gistonew_out_header']['status'] == '1' || ( ($data['gistonew_out_header']['status'] == '2') && !empty($data['gistonew_out_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("gistonew_out_detail[gr_quantity][$i]", $error) || in_array("gistonew_out_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['gistonew_out_detail']['material_no'][$i]);
            if (!empty($data['gistonew_out_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['gistonew_out_detail']['material_desc'][$i];
            }
			if (!empty($data['gistonew_out_detail']['POSNR'][$i])) {
              $item_x[$i]['MAKTX'] = $data['gistonew_out_detail']['POSNR'][$i];
            }
            if (!empty($data['gistonew_out_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['gistonew_out_detail']['uom'][$i];
            }
			 if (!empty($data['gistonew_out_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['gistonew_out_detail']['num'][$i];
            }
			if (!empty($data['gistonew_out_detail']['outstanding_qty'][$i])) {
              $item_x[$i]['outstanding_qty'] = $data['gistonew_out_detail']['outstanding_qty'][$i];
            }

?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['gistonew_out_header']['status']) || $data['gistonew_out_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gistonew_out_header']['status']) || $data['gistonew_out_header']['status'] == '1') : ?>
        <?=form_hidden("gistonew_out_detail[id_gistonew_out_h_detail][$k]", $data['gistonew_out_detail']['id_gistonew_out_h_detail'][$k]);?>
        <?=form_hidden("gistonew_out_detail[id_gistonew_out_detail][$k]", $data['gistonew_out_detail']['id_gistonew_out_detail'][$k]);?>
        <?=form_hidden("gistonew_out_detail[posnr][$k]", $data['gistonew_out_detail']['posnr'][$i]);?> 
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("gistonew_out_detail[material_no][$k]", $data['gistonew_out_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("gistonew_out_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--td>
        <?php /*$item_x[$i]['BatchNum'];?>
        <?=form_hidden("issue_detail[num][$k]",  $item_x[$i]['BatchNum']); */
		$whs=$this->session->userdata['ADMIN']['storage_location'];
		$itm=$item_x[$i]['MATNR1'];
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$itm'"));
		//$oitw=$InWhs['Quantity'];
		$oitw=number_format($InWhs['Quantity'], 2, '.', '');
		?>
		 </td-->
          <td>
		  
        <?=$oitw;?>
        <?=form_hidden("gistonew_out_detail[stock][$k]", $oitw);?>
		
        </td>
        <td> <?=number_format($data['gistonew_out_detail']['outstanding_qty'][$i], 2, '.', '');?>
        <?=form_hidden("gistonew_out_detail[outstanding_qty][$k]", number_format($data['gistonew_out_detail']['outstanding_qty'][$i], 2, '.', ''));?> </td>
		<td align="center">
<?php

			if(!empty($error) && in_array("gistonew_out_detail[gr_quantity][$i]", $error)) {
				echo form_input("gistonew_out_detail[gr_quantity][$k]", number_format($data['gistonew_out_detail']['gr_quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("gistonew_out_detail[gr_quantity][$k]", $data['gistonew_out_detail']['gr_quantity'][$i]);
                if($data['gistonew_out_header']['status'] != '2')
    				echo form_input("gistonew_out_detail[gr_quantity][$k]", number_format($data['gistonew_out_detail']['gr_quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
    				echo number_format($data['gistonew_out_detail']['gr_quantity'][$i], 2, '.', ',');
			}
?></td>

 <td> <?=$data['gistonew_out_detail']['uom_req'][$i];?>
        <?=form_hidden("gistonew_out_detail[uom_req][$k]",$data['gistonew_out_detail']['uom_req'][$i]);?> </td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['gistonew_out_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['gistonew_out_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT'];?>
         <?=form_hidden("gistonew_out_detail[uom][$k]", $item_x[$i]['UNIT']);?>
        </td>
		<?php if(($data['gistonew_out_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['gistonew_out_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['gistonew_out_detail']['id_gistonew_out_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['gistonew_out_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr> 
<?php
			$k++;
		}
		
	}
	
	// below is for new data
	if($data['gistonew_out_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['gistonew_out_header']['status']) || $data['gistonew_out_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gistonew_out_header']['status']) || $data['gistonew_out_header']['status'] == '1') : ?><?=form_hidden("gistonew_out_detail[id_gistonew_out_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		$te=sqlsrv_query($con,"SELECT WTQ1.ItemCode MATNR,Dscription MAKTX, (OpenQty - U_grqty_web) qty,LineNum POSNR  FROM OWTQ INNER JOIN WTQ1 ON
		OWTQ.DocEntry = WTQ1.DocEntry INNER JOIN OITM ON WTQ1.ItemCode = OITM.ItemCode INNER JOIN OWHS ON OWHS.WhsCode = OWTQ.Filler
		WHERE OWTQ.DocEntry = '$gistonew_out_header[VBELN]'");
		/*echo "SELECT WTQ1.ItemCode MATNR,Dscription MAKTX, WTQ1.OpenQty qty  FROM OWTQ INNER JOIN WTQ1 ON
		OWTQ.DocEntry = WTQ1.DocEntry INNER JOIN OITM ON WTQ1.ItemCode = OITM.ItemCode INNER JOIN OWHS ON OWHS.WhsCode = OWTQ.Filler
		WHERE
OWTQ.DocEntry = '$gistonew_out_header[VBELN]'
		";*/
		$item1[0]='';
		while ($re=sqlsrv_fetch_array($te))
		{
			$item1[$re['MATNR']]= $re['MATNR']." - ".$re['MAKTX']."(".$re['POSNR'].")";
			$qty[$i] = substr($re['qty'],0,-2);
		}
		if(!empty($error) && in_array("gistonew_out_detail[material_no][$i]", $error)) {
			echo form_dropdown("gistonew_out_detail[material_no][$k]", $item1, $data['gistonew_out_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("gistonew_out_detail[material_no][$k]", $item1, $data['gistonew_out_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		?>
		</td>
       
        <!--td>
         <?php
		 $it=$data['gistonew_out_detail']['material_no'][$i];
		  $whs=$this->session->userdata['ADMIN']['storage_location'];
		 /*
		
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		
		$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2[0]='';
		while($r=mysql_fetch_array($t))
		{
			$item2[$r['num']] = $r['num'];
		}
		
		//print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("gistonew_out_detail[num][$i]", $error)) {
			echo form_dropdown("gistonew_out_detail[num][$k]", $item2, $data['gistonew_out_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
		echo form_dropdown("gistonew_out_detail[num][$k]", $item2  , $data['gistonew_out_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();" ');  
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}
		*/
		?>
        
        </td-->
        <td align="center">
		<?php
		/*$server = '192.168.0.20';
  $username = 'sa';
      $password = 'abc123?';
      $con = mssql_connect($server, $username, $password);
      $db=mssql_select_db('Test_MSI',$con);*/
		
		$batch=$data['gistonew_out_detail']['num'][$i];
		if ($batch=='')
		{
			//echo "xxx";
			$InWhs=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OnHand as Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'"));
			//echo "SELECT OnHand as Quantity FROM OITW WHERE WhsCode ='$whs' AND ItemCode='$it'";
			$InWh=mysql_fetch_array(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$whs' AND ItemCode='$it'", $mysqlcon));
			$countOITW=mysql_num_rows(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$whs' AND ItemCode='$it'", $mysqlcon));
			if ($countOITW > 0)
			{
				$OnHandQty=$InWhs['Quantity'];
			}else
			{
				//$OnHandQty=0;
				$OnHandQty=$InWhs['Quantity'];
			}
		}else{
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT A.Quantity as Quantity FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$whs' AND A.ItemCode='$it' AND B.DistNumber='$batch'"));
}
		
       
		echo substr($OnHandQty,0,-4);?>
        <?=form_hidden("gistonew_out_detail[stock][$k]", $OnHandQty);?>
		
        </td>
        <td align="center">
		<?php
		$rowQty=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OpenQty as OpenQty,LineNum,unitMsr FROM WTQ1 WHERE DocEntry='$gistonew_out_header[VBELN]' AND ItemCode='$it'"));
		$qty=$rowQty['OpenQty'];
		$posnr=$rowQty['LineNum'];
		$uom=$rowQty['unitMsr'];
		sqlsrv_close($con);

		if ($it != '')
		{
		//echo $qty[$i];
		echo number_format($qty, 2, '.', ',');?><?=form_hidden("gistonew_out_detail[outstanding_qty][$i]",$qty);
		}
		?>
        <?=form_hidden("gistonew_out_detail[posnr][$i]",$posnr);?>
		</td>
		<td align="center">
		<?php
	/*	if ($it != '')
		{
		if(!empty($error) && in_array("gistonew_out_detail[gr_quantity][$i]", $error)) {
			echo form_input("gistonew_out_detail[gr_quantity][$k]",$qty, $data['gistonew_out_detail']['gr_quantity'][$i], 'class="error_number" size="8" ');
		} else {
			echo form_input("gistonew_out_detail[gr_quantity][$k]",$qty, $data['gistonew_out_detail']['gr_quantity'][$i], 'class="input_number" size="8" ');
		}
		}
		else
		{*/
			if(!empty($error) && in_array("gistonew_out_detail[gr_quantity][$i]", $error)) {
			echo form_input("gistonew_out_detail[gr_quantity][$k]", $data['gistonew_out_detail']['gr_quantity'][$i], 'class="error_number" size="8" ');
		} else {
			echo form_input("gistonew_out_detail[gr_quantity][$k]", $data['gistonew_out_detail']['gr_quantity'][$i], 'class="input_number" size="8" ');
		}
		//}
		
		?>
        
		</td>
          <!-- dari sini -->
          
          <td> <?=$uom;?>
        <?=form_hidden("gistonew_out_detail[uom_req][$k]",$uom);?> </td>
        <td>
       <?php
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
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("gisto_detail[uom][$i]", $error)) {
			echo form_dropdown("gistonew_out_detail[uom][$k]", $itemC, $data['gistonew_out_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("gistonew_out_detail[uom][$k]", $itemC  , $data['gistonew_out_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
	   ?>
        </td>
        <!-- sampe sini -->
	</tr>
<?php
mysql_close($mysqlcon);
	endif;
?>
<?php if(($data['gistonew_out_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
<?php if($data['gistonew_out_header']['status'] != '2') : ?>
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
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('gistonew_out/browse', $this->lang->line('button_back'));?></td>
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