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
 //$c=mssql_connect("192.168.0.20","sa","M$1S@p!#@");
	//	$b=mssql_select_db('Test_MSI',$c);
		$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
		$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);
		
		if ($b)
		{
			//echo "ABC";
		}
		else
		{
			//echo "Koneksi Error";
				//	$this->session->sess_destroy();
		}
//echo "<pre>";
//print 'array ';
//print_r($item_group);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('produksi_header[id_produksi_header]', $this->uri->segment(3));?>
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
		<td class="column_input"><?=form_hidden('produksi_header[id_produksi_header]', $produksi_header['id_produksi_header']);?><strong><?=$produksi_header['id_produksi_header'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet </strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
    <?php
	$whs=$this->session->userdata['ADMIN']['plant'];
	$user=$this->session->userdata['ADMIN']['admin_id'];
	//echo '{'.$user.'}';
	
	if ($function!='edit')
	{
	?>
	<tr>
   
		<td class="table_field_1"><strong>Item Produksi</strong> </td>
		<td class ="column_input"><?=$kode_paket;?><?=" - ";?><?=$nama_paket;?>
        <?=form_hidden("produksi_header[kode_paket]", $kode_paket);?>
        <?=form_hidden("produksi_header[nama_paket]", $nama_paket);?>       <?=anchor('produksi/input', 'Replace Item');?>  </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>Qty Produksi</strong> </td>
		<td class ="column_input"><?=$qty_paket;?>
        <?=form_hidden("produksi_header[qty_paket]", $qty_paket);
		$qty=mysql_fetch_array(mysql_query("SELECT quantity_paket FROM m_mpaket_header WHERE plant='WMSIASST' AND kode_paket = '$kode_paket'",$mysqlcon));
		?>
           <b><?php echo " (Suggest Qty : ".$qty['quantity_paket'].')';?></b>   </td>
	</tr>
	 <tr>
		<td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
		<?php
	  
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$kode_paket'",$mysqlcon);
	   //$ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$kode_paket' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$kode_paket' 
group by m_uom.UomName 

",$mysqlcon);
while($r=mysql_fetch_array($ta))
		{
			$uomH[$r['UNIT']] = $r['UNIT'];
		}
       if(!empty($error) && in_array("produksi_header[uom_paket]", $error)) {
			echo form_dropdown("produksi_header[uom_paket]", $uomH, $data['produksi_header']['uom_paket'], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("produksi_header[uom_paket]", $uomH, $data['produksi_header']['uom_paket'], 'class="input_text" width="20"');
		}
	   ?>
        
        </td>
	</tr>
    <?php
   } else {
	  $id_produksi_header1= $this->uri->segment(3);
   $header=mysql_fetch_array(mysql_query("SELECT kode_paket,nama_paket,qty_paket,uom_paket,posting_date  FROM t_produksi_header WHERE id_produksi_header='$id_produksi_header1'",$mysqlcon));
   //echo "SELECT kode_paket,nama_paket,qty_paket,uom_paket  FROM t_produksi_header WHERE id_produksi_header='$id_produksi_header1'";
	?>
    
		<td class="table_field_1"><strong>Item Produksi</strong> </td>
		<td class ="column_input"><?=$header['kode_paket'];?><?=" - ";?><?=$header['nama_paket'];?>
        <?=form_hidden("produksi_header[kode_paket]", $header['kode_paket']);?>
		<?=form_hidden("produksi_header[id_produksi_header]", $id_produksi_header1);?>
        <?=form_hidden("produksi_header[nama_paket]", $header['nama_paket']);?>       </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>Qty Produksi</strong> </td>
		<td class ="column_input"><?=$header['qty_paket'];?>
        <?=form_hidden("produksi_header[qty_paket]", $header['qty_paket']);?>
              </td>
	</tr>
	 <tr>
		<td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
		<?=$header['uom_paket'];?>
        <?=form_hidden("produksi_header[uom_paket]", $header['uom_paket']);?>
        </td>
	</tr>
    <?php }?>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y",strtotime($header['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
		//$posting_date = date('d-m-Y');
		//$posting_date = $header['posting_date'];
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['produksi_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['produksi_header']['posting_date']));
        } else {
    		$posting_date = $data['produksi_header']['posting_date'];
        }
    }
?>
		<td class="column_input">
		<?php if(($data['produksi_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
		<?php if(!empty($error) && in_array("produksi_header[posting_date]", $error)) {
			echo form_input('produksi_header[posting_date]', $posting_date, 'class="error_text" size="10"');
		} else {
			echo form_input('produksi_header[posting_date]', $posting_date, 'class="input_text" size="10"');
		}			
		?> 
		<?php else: ?><?=$posting_date;?>
		<?=form_hidden("produksi_header[posting_date]", $posting_date);?>
		<?php endif;?>
        <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'produksi_header[posting_date]'
					});
		</script>
		
		</td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['produksi_header']['status'] == '2') : ?>
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
<?php if(!isset($data['produksi_header']['status']) || $data['produksi_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
       <td class="table_header_1"><div align="center"><strong>QC</strong></div></td>
         <td class="table_header_1"><div align="center"><strong>On Hand</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Min Stock</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Oustanding Total</strong></div></td>
		<?php if(($data['produksi_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['produksi_details'] !== FALSE) :
//$i = 0; //=> already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows
	
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	//mysql_query("DELETE FROM m_mpaket_detail_temp WHERE b.kode_paket='$kode_paket'
		//where b.kode_paket='$kode_paket' and b.plant='WMSIASST'",$mysqlcon);
	/*mysql_query("INSERT INTO m_mpaket_detail_temp SELECT '',a.id_mpaket_header,a.id_mpaket_h_detail,
		a.material_no,a.material_desc,a.quantity,a.uom,'$kd_plant',$user FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$kode_paket' and b.plant='WMSIASST'",$mysqlcon);*/
	mysql_query("CREATE TEMPORARY TABLE m_mpaket_detail_tmp SELECT a.id_mpaket_header,a.id_mpaket_h_detail,
		a.material_no,a.material_desc,a.quantity,a.uom FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$kode_paket' and b.plant='WMSIASST'",$mysqlcon);
	
	/*echo "INSERT INTO m_mpaket_detail_temp SELECT a.id_mpaket_detail,a.id_mpaket_header,a.id_mpaket_h_detail,a.material_no,a.material_desc,a.quantity,a.uom,'$kd_plant',$user FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$kode_paket' and b.plant='WMSIASST' AND material_no IN 
		(SELECT MATNR FROM m_item WHERE m_item.MATNR = a.material_no)";*/
		
	if ($function=='edit')
	{
	$kode_paket=$header['kode_paket'];
	$qty_paket= $header['qty_paket'];
	$id=$data['produksi_header']['id_produksi_header'];
	$tk="SELECT * FROM t_produksi_detail WHERE id_produksi_header='$id'";
	}else
		{
		//$tk="SELECT id_mpaket_h_detail, material_no, material_desc from m_mpaket_detail_temp WHERE whs='$kd_plant' AND user='$user'";
		$tk="SELECT id_mpaket_h_detail, material_no, material_desc from m_mpaket_detail_tmp";
		
		}
		//echo $tk;
		$ti=mysql_query($tk,$mysqlcon); 
		$count=mysql_num_rows($ti);
		$JumlahRow=$count;

    $produksi_detail_tmp = $this->session->userdata('produksi_detail');
    if(!empty($produksi_detail_tmp)) {
       $data['produksi_detail'] = $produksi_detail_tmp;
    }

	$count = count($data['produksi_detail']['id_produksi_h_detail']);
	// for POST data
	if((!isset($_POST['delete']))&&(empty($produksi_detail_tmp))&&(empty($error)))
		$count2 = $count;
		
	else
		$count2 = $count - 1;
		//echo "delete";

    unset($produksi_detail_tmp);

	//for($i = 1; $i <= $count2; $i++) {
	while($r=mysql_fetch_array($ti))
		{
		$i++;

		if($data['produksi_header']['status'] == '1' || ( ($data['produksi_header']['status'] == '2') && !empty($data['produksi_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("produksi_detail[gr_quantity][$i]", $error) || in_array("produksi_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['produksi_detail']['material_no'][$i]);
            if (!empty($data['produksi_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['produksi_detail']['material_desc'][$i];
            }
			// dari sini
            if (!empty($data['produksi_detail']['uom'][$i])) {
			  $item_x[$i]['uom'] = $data['produksi_detail']['uom'][$i];
            }
			//====================
			 if (!empty($data['produksi_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['produksi_detail']['num'][$i];
            }
			if(isset($_POST['delete'])) {
			
			
			
			$item=$data['produksi_detail']['material_no'][$i];
			//mysql_query("INSERT INTO m_mpaket_detail_temp_clone () VALUES ('$item')");
			}
			

?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['produksi_header']['status']) || $data['produksi_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]",  $i, FALSE);?></td>
<?php endif; 
	
?>
		<td align="center"><?php if(!isset($data['produksi_header']['status']) || $data['produksi_header']['status'] == '1') : ?>
        <?=form_hidden("produksi_detail[id_produksi_h_detail][$k]", $data['produksi_detail']['id_produksi_h_detail'][$k]);?>
        <?=form_hidden("produksi_detail[id_produksi_detail][$k]", $data['produksi_detail']['id_produksi_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
        <td align="left"><?=form_hidden("produksi_detail[material_no][$k]", $r['material_no']);?>
        <?=$r['material_no'];?></td>
		<td align="left"><?=$r['material_desc'];?>
        <?=form_hidden("produksi_detail[material_desc][$k]",$r['material_desc']); echo $id_mpaket_header;?>
        </td>
        <!--dari sini -->
        <!--td>
       <?php
	   
		$it=$r['material_no'];
		$id_line=$r['id_mpaket_h_detail'];		
		 $temp1=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT OnHand,MinStock FROM OITW WHERE ItemCode='$it' AND WhsCode='$kd_plant'"));
		$trans='T.'.$kd_plant;
		$temp2=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$trans'"));
		$onhand= $temp1['OnHand'];
		/*$cekBatch=mysql_fetch_array(mysql_query("SELECT BATCH FROM m_item where MATNR ='$it'"));
		$tka="SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$kd_plant'";
		$tkb="SELECT DistNumber num FROM OBTQ A
			JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
			WHERE A.ItemCode='$it' AND A.WhsCode='$kd_plant' ";
		$ta=mssql_query($tkb); 
		$count1=mssql_num_rows($ta);
		//echo $tkb;
		$bat=$cekBatch['BATCH'];
		while($r=mssql_fetch_array($ta))
		{
		//echo $iy++;
		$item1[$it][0]='';
			$item1[$it][$r['num']] = $r['num'];
			
		}
		
		//echo $tka;
		if ($function !='edit')
		{
		//echo '{'.$bat.'}'.'{'.$onhand.'}';
			if ($bat == 'Y' && $onhand > 0){
				if(!empty($error) && in_array("produksi_detail[num][$i]", $error)) {
					echo form_dropdown("produksi_detail[num][$k]", $item1[$it], $data['produksi_detail']['num'][$i], 'class="error_text" width="30" onChange="document.form1.submit();"');
				} else {
				echo form_dropdown("produksi_detail[num][$k]", $item1[$it], $data['produksi_detail']['num'][$i], 'class="input_text" width="30" onChange="document.form1.submit();"');
				}
			}
			else
			{
			 echo "<center>------</center>"; 
			}
		}else
		{
		$id= $data['produksi_header']['id_produksi_header'];
		$tpNum="SELECT a.num FROM t_produksi_detail a 
		JOIN t_produksi_header b  on a.id_produksi_header=b.id_produksi_header
		where b.id_produksi_header='$id_produksi_header' AND a.material_no='$it'";
		$tlNUm=mysql_fetch_array(mysql_query($tpNum)); 
		 
		echo $tlNUm['num'];?>
        <?=form_hidden("produksi_detail[num][$k]",$tlNUm['num'],$data['produksi_detail']['num'][$i]);
		//echo $tp;
		} */?>
        </td-->
        <!-- sampe siniii neehhh -->
		<td align="center">
<?php
		$tp="SELECT quantity FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$kode_paket' and b.plant='WMSIASST' AND a.id_mpaket_h_detail='$id_line'";
		//echo $tp;
		$tl=mysql_fetch_array(mysql_query($tp,$mysqlcon)); 
		$th="SELECT quantity_paket FROM m_mpaket_header WHERE kode_paket='$kode_paket' and plant='WMSIASST'";
		$tk=mysql_fetch_array(mysql_query($th,$mysqlcon)); 
		//echo $tp;
		if ($function!='edit')
		{
		$qty=$tl['quantity']*$qty_paket/$tk['quantity_paket'];
		}else
		{
		$qty=$data['produksi_detail']['qty'][$i];
		}
		
		$ctl=mysql_num_rows(mysql_query($tp,$mysqlcon));
		if ($ctl > 0)
		{
			if(!empty($error) && in_array("produksi_detail[qty][$i]", $error)) {
				echo form_input("produksi_detail[qty][$k]", number_format($qty, 4, '.', ''), 'class="error_number" size="8"');
				
			} else {
				echo form_hidden("produksi_detail[qty][$k]", $qty);
                if($data['produksi_header']['status'] != '2')
				
   				  echo form_input("produksi_detail[qty][$k]", number_format($qty, 4, '.', ''), 'class="input_number" size="8"');
				  
                else
   				  echo number_format($qty, 4, '.', ',');
				  
			}
		}
		else
		{
			echo form_input("produksi_detail[qty][$k]", number_format($qty, 4, '.', ''), 'class="input_number" size="8"');	
		}
?></td>
		<td>
        <?php
	  
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'",$mysqlcon);
	   //$ra=mysql_fetch_array($ta);
	   $uom="";//$ra['UNIT'];
$tq=mysql_query("
SELECT uom UNIT FROM m_mpaket_detail where material_no='$it'
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$it' 
group by m_uom.UomName 

",$mysqlcon);

while($r=mysql_fetch_array($ta))
		{
			$uom[$r['UNIT']] = $r['UNIT'];
		}
		
       if(!empty($error) && in_array("produksi_detail[uom][$i]", $error)) {
			echo form_dropdown("produksi_detail[uom][$k]", $uom, $data['produksi_detail']['uom'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("produksi_detail[uom][$k]", $uom, $data['produksi_detail']['uom'][$i], 'class="input_text" width="20"');
		}
	   ?>
        </td>
         <td>
         <?php
         $qc=array(
		''=>'',
		'tes'=>'tes',
		'tes2'=>'tes2'
		);
        if(!empty($error) && in_array("produksi_detail[qc][$i]", $error)) {
			echo form_dropdown("produksi_detail[qc][$k]", $qc, $data['produksi_detail']['qc'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("produksi_detail[qc][$k]", $qc, $data['produksi_detail']['qc'][$i], 'class="input_text" width="20"');
		}
		 ?>
        <?php //$item_x[$i]['qc'];?>
        <?php //form_hidden("mpaket_prod_detail[qc][$k]", $item_x[$i]['qc']);?>
        </td>
          <td>
          <?php
		  
		  $batch=$data['produksi_detail']['num'][$i];
		if ($batch=='')
		{
			$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT OnHand as Quantity FROM OITW WHERE WhsCode ='$kd_plant' AND ItemCode='$it'"));
			$InWh=mysql_fetch_array(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$kd_plant' AND ItemCode='$it'",$mysqlcon));
			$countOITW=mysql_num_rows(mysql_query("SELECT Quantity FROM m_batch WHERE Whs='$kd_plant' AND ItemCode='$it'",$mysqlcon));
			if ($countOITW > 0)
			{
				$OnHandQty=$InWhs['Quantity'];
			}else
			{
				$OnHandQty=$InWhs['Quantity'];
			}
			//echo "{".$OnHandQty.'}';
			
			$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$kd_plant' AND ItemCode='$it'"));
			//echo "SELECT OnHand Quantity FROM OITW WHERE WhsCode ='$kd_plant' AND ItemCode='$it'";
		}else{
		$InWhs=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT A.Quantity FROM OBTQ A
JOIN OBTN B ON A.SysNumber = B.SysNumber AND B.ItemCode = A.ItemCode
WHERE A.WhsCode ='$kd_plant' AND A.ItemCode='$it' AND B.DistNumber='$batch'"));
}
       
		echo substr($OnHandQty,0,-4);?>
        <?=form_hidden("produksi_detail[OnHand][$k]", $OnHandQty,$data['produksi_detail']['OnHand'][$i]);?>
		
        </td>
        <td>
       <?=substr($temp1['MinStock'],0,-4);?>
        <?=form_hidden("produksi_detail[MinStock][$k]", substr($temp1['MinStock'],0,-4),$data['produksi_detail']['MinStock'][$i]);?>
        </td>
         <td>
       <?=substr($temp2['OpenQty'],0,-4);?>
        <?=form_hidden("produksi_detail[OpenQty][$k]", substr($temp2['OpenQty'],0,-4),$data['produksi_detail']['OpenQty'][$i]);?>
        </td>
		<?php if(($data['produksi_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['produksi_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['produksi_detail']['id_produksi_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['produksi_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}
		
		
	}
	if(isset($_POST['delete'])) {
	/*$hapus="DELETE FROM m_mpaket_detail_temp WHERE material_no NOT IN (SELECT material_no m_mpaket_detail_temp_clone)";
	//echo $hapus;
			mysql_query($hapus);*/
	}
	
	// below is for new data
	if($data['produksi_header']['status'] != '2') :
	
	//echo '['.$k.']';
	
?>
	<tr>
<?php if(!isset($data['produksi_header']['status']) || $data['produksi_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['produksi_header']['status']) || $data['produksi_header']['status'] == '1') : ?><?=form_hidden("produksi_detail[id_produksi_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		//reset($item);
		$list=mysql_query("SELECT MATNR,MAKTX FROM m_item",$mysqlcon);
		$item[0]='';
		while ($s=mysql_fetch_array($list))
		{
			$item[$s['MATNR']]=$s['MATNR'].' - '.$s['MAKTX'];
			//echo $s['MATNR'].' - '.$s['MAKTX'].'<br>';
		}
		//print_r($item);
		if(!empty($error) && in_array("produksi_detail[material_no][$i]", $error)) {
			echo form_dropdown("produksi_detail[material_no][$k]", $item, $data['produksi_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("produksi_detail[material_no][$k]", $item, $data['produksi_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		?>
		</td>
       
        <td>
         <?php
		/* $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		$it=$data['produksi_detail']['material_no'][$i];
		$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['num']] = $r['num'];
		}
		
		//print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("produksi_detail[num][$i]", $error)) {
			echo form_dropdown("produksi_detail[num][$k]", $item1, $data['produksi_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("produksi_detail[num][$k]", $item1  , $data['produksi_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		}
		}
		else
		{
		 echo "<center>------</center>"; 
		}*/
		?>
        
        </td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("produksi_detail[gr_quantity][$i]", $error)) {
			echo form_input("produksi_detail[gr_quantity][$k]", $data['produksi_detail']['gr_quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("produksi_detail[gr_quantity][$k]", $data['produksi_detail']['gr_quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
        <!-- dari sini -->
        <!--td>
       <?php
	   /*$ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'");
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
	
		if(!empty($error) && in_array("produksi_detail[uom][$i]", $error)) {
			echo form_dropdown("produksi_detail[uom][$k]", $itemC, $data['produksi_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("produksi_detail[uom][$k]", $itemC  , $data['produksi_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}*/
	   ?>
        </td-->
        <td>
         <?php
         $qc=array(
		''=>'',
		'tes'=>'tes',
		'tes2'=>'tes2'
		);
        if(!empty($error) && in_array("produksi_detail[qc][$i]", $error)) {
			echo form_dropdown("produksi_detail[qc][$k]", $qc, $data['produksi_detail']['qc'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("produksi_detail[qc][$k]", $qc, $data['produksi_detail']['qc'][$i], 'class="input_text" width="20"');
		}
		 ?>
        <?php //$item_x[$i]['qc'];?>
        <?php //form_hidden("mpaket_prod_detail[qc][$k]", $item_x[$i]['qc']);?>
        </td>
          <td>
          <?php
		  
		echo substr($temp1['OnHand'],0,-4);?>
        <?=form_hidden("produksi_detail[OnHand][$k]", substr($temp1['OnHand'],0,-4),$data['produksi_detail']['OnHand'][$i]);?>
		
        </td>
        <td>
       <?=substr($temp1['MinStock'],0,-4);?>
        <?=form_hidden("produksi_detail[MinStock][$k]", substr($temp1['MinStock'],0,-4),$data['produksi_detail']['MinStock'][$i]);?>
        </td>
         <td>
       <?=substr($temp2['OpenQty'],0,-4);?>
        <?=form_hidden("produksi_detail[OpenQty][$k]", substr($temp2['OpenQty'],0,-4),$data['produksi_detail']['OpenQty'][$i]);?>
        </td>
	</tr>
<?php
	endif;
?>
<?php if(($data['produksi_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
<?php if($data['produksi_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0" align="left">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>

<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue Stock Transfer Antar Plant.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a>        </td>
  </tr>
	<tr>
    <td align="center"><?=anchor('produksi/browse', $this->lang->line('button_back'));?></td>
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
<?php        
	mysql_query("DROP TEMPORARY TABLE m_mpaket_detail_tmp",$mysqlcon);
	sqlsrv_close($b);
	mysql_close($mysqlcon);
    endif; ?>
