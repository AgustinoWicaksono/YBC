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
 $c=mssql_connect($host_sap,$user_sap,$pass_sap);
		$b=mssql_select_db($db_sap,$c);
//echo "<pre>";
//print 'array ';
//print_r($item_group);
//echo "</pre>";
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('whole_header[id_whole_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {

	echo "Anda baru saja menghapus data";
}
$var_cek=1;
?>
	<tr>
		<td class="table_field_1"><strong>Outlet </strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
    <?php
	if ($function!='edit')
	{
	?>
	<tr>
   
		<td class="table_field_1"><strong>Item Produksi</strong> </td>
		<td class ="column_input"><?=$kode_paket;?><?=" - ";?><?=$nama_paket;?>
        <?=form_hidden("whole_header[kode_paket]", $kode_paket);?>
        <?=form_hidden("whole_header[nama_paket]", $nama_paket);?>        </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>Qty Produksi</strong> </td>
		<td class ="column_input"><?=$qty_paket;?>
        <?=form_hidden("whole_header[qty_paket]", $qty_paket);?>
              </td>
	</tr>
	 <tr>
		<td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
		<?php
	  
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$kode_paket'");
	   $ra=mysql_fetch_array($ta);
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

");
while($r=mysql_fetch_array($tq))
		{
			$uomH[$r['UNIT']] = $r['UNIT'];
		}
       if(!empty($error) && in_array("whole_header[uom_paket]", $error)) {
			echo form_dropdown("whole_header[uom_paket]", $uomH, $data['whole_header']['uom_paket'], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("whole_header[uom_paket]", $uomH, $data['whole_header']['uom_paket'], 'class="input_text" width="20"');
		}
	   ?>
        
        </td>
	</tr>
    <?php
   } else {
   $header=mysql_fetch_array(mysql_query("SELECT kode_paket,nama_paket,qty_paket,uom_paket  FROM t_whole_header WHERE id_whole_header='$id_whole_header'"));
	?>
    
		<td class="table_field_1"><strong>Item Produksi</strong> </td>
		<td class ="column_input"><?=$header['kode_paket'];?><?=" - ";?><?=$header['nama_paket'];?>
        <?=form_hidden("whole_header[kode_paket]", $header['kode_paket']);?>
        <?=form_hidden("whole_header[nama_paket]", $header['nama_paket']);?>        </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>Qty Produksi</strong> </td>
		<td class ="column_input"><?=$header['qty_paket'];?>
        <?=form_hidden("whole_header[qty_paket]", $header['qty_paket']);?>
              </td>
	</tr>
	 <tr>
		<td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
		<?=$header['uom_paket'];?>
        <?=form_hidden("whole_header[uom_paket]", $header['uom_paket']);?>
        </td>
	</tr>
    <?php }?>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['whole_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date('d-m-Y');
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if(!empty($data['whole_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
    		$posting_date = $data['whole_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['whole_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['whole_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['whole_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('whole_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'whole_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("whole_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['whole_header']['status'] == '2') : ?>
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
<?php if(!isset($data['whole_header']['status']) || $data['whole_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
       <td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Var</strong></div></td>
		<?php if(($data['whole_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['whole_details'] !== FALSE) :
$i = 0; //=> already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows
	
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	

    $whole_detail_tmp = $this->session->userdata('whole_detail');
    if(!empty($whole_detail_tmp)) {
       $data['whole_detail'] = $whole_detail_tmp;
    }

	$count = count($data['whole_detail']['id_whole_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($whole_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count ;

    unset($whole_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {
		$i++;

		if($data['whole_header']['status'] == '1' || ( ($data['whole_header']['status'] == '2') && !empty($data['whole_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("whole_detail[gr_quantity][$i]", $error) || in_array("whole_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['whole_detail']['material_no'][$i]);
            if (!empty($data['whole_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['whole_detail']['material_desc'][$i];
            }
			// dari sini
            if (!empty($data['whole_detail']['uom'][$i])) {
			  $item_x[$i]['uom'] = $data['whole_detail']['uom'][$i];
            }
			//====================
			 if (!empty($data['whole_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['whole_detail']['num'][$i];
            }
			

?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['whole_header']['status']) || $data['whole_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['whole_header']['status']) || $data['whole_header']['status'] == '1') : ?>
        <?=form_hidden("whole_detail[id_whole_h_detail][$k]", $data['whole_detail']['id_whole_h_detail'][$k]);?>
        <?=form_hidden("whole_detail[id_whole_detail][$k]", $data['whole_detail']['id_whole_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
        <td align="left"><?=form_hidden("whole_detail[material_no][$k]", $data['whole_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("whole_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--dari sini -->
       
        <!-- sampe siniii neehhh -->
		<td align="center">
<?php
		if(!empty($error) && in_array("whole_detail[quantity][$i]", $error)) {
				echo form_input("whole_detail[quantity][$k]", number_format($data['whole_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("whole_detail[quantity][$k]", $data['whole_detail']['quantity'][$i]);
                if($data['header_header']['status'] != '2')
   				  echo form_input("whole_detail[quantity][$k]", number_format($data['whole_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
   				  echo number_format($data['whole_detail']['quantity'][$i], 2, '.', ',');
			}
?></td>
		<td>
       <?=$item_x[$i]['UNIT1'];?>
         <?=form_hidden("whole_detail[uom][$k]", $item_x[$i]['UNIT1']);?>
        </td>
         <td>
        <?php
		 $qtyH=$data['whole_header']['quantity_paket'];
		 $itemSlice=$item_paket_code;
		 $itemRec=$item_x[$i]['MATNR1'];
		 if ($i == 1)
		 {
         $req=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemSlice'"));
		 $vol_hed=$req['VOL']*$qtyH;
		// echo '{'.$req['VOL']*.'}';
		 }
		 else
		 {
		  $req=mysql_fetch_array(mysql_query("SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'"));
		  $vol_hed=$req['VOL_TEMP'];
		  //echo "SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'";
		 }
		
		$req1=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemRec'"));
		$qty1=$data['whole_detail']['quantity'][$i];
		$vol_det=$req1['VOL']*$qty1;
		$var_cek=$vol_hed-$vol_det;
	//echo "$vol_det=$req1[VOL]*$qty1 <br>";
		//echo "$var_cek=$vol_hed-$vol_det;";
		mysql_query("update m_item set VOL_TEMP ='$var_cek' WHERE MATNR='$itemSlice' ");
		 ?>
		 <?=-1*abs($var_cek);?>
        <?=form_hidden("twts_detail[var][$k]", $var_cek);?> 
        </td>
       
  </tr>
<?php
			$k++;
		}
		
	}
	
	// below is for new data
	if($data['whole_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['whole_header']['status']) || $data['whole_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['whole_header']['status']) || $data['whole_header']['status'] == '1') : ?><?=form_hidden("whole_detail[id_whole_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		$kd_plant = $this->session->userdata['ADMIN']['plant'];
		$tk="SELECT * FROM m_mwts_detail a 
		JOIN m_mwts_header b  on a.id_mwts_header=b.id_mwts_header
		where b.kode_whi='$kode_paket' and b.plant='$kd_plant'";
		//echo $tk;
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($ti);
		$item2= "Tidak ada Batch Number";
		$item3[0]='';
		while($r=mysql_fetch_array($ti))
		{
			$item3[$r['material_no']] = $r['material_no'].' - '.$r['material_desc'];
		}
		if ($var_cek > 0)
		{
		if(!empty($error) && in_array("whole_detail[material_no][$i]", $error)) {
			echo form_dropdown("whole_detail[material_no][$k]", $item3, $data['whole_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("whole_detail[material_no][$k]", $item3, $data['whole_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		}
		?>
		</td>
       
     
		<td align="center">
		<?php
		$mat=$data['whole_detail']['material_no'][$i];
		$tp="SELECT quantity FROM m_mwts_detail a 
		JOIN m_mwts_header b  on a.id_mwts_header=b.id_mwts_header
		where b.kode_whi='$kode_paket' and b.plant='$kd_plant' AND a.material_no='$mat'";
		$tl=mysql_fetch_array(mysql_query($tp)); 
		$qty=$tl['quantity'];
		$ctl=mysql_num_rows(mysql_query($tp));
		if ($ctl > 0)
		{
		if(!empty($error) && in_array("whole_detail[gr_quantity][$i]", $error)) {
			echo form_input("whole_detail[gr_quantity][$k]", $qty,$data['whole_detail']['gr_quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("whole_detail[gr_quantity][$k]", $qty,$data['whole_detail']['gr_quantity'][$i], 'class="input_number" size="8"');
		}
		}
		?>
		</td>
        <!-- dari sini -->
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
	
		if(!empty($error) && in_array("whole_detail[uom][$i]", $error)) {
			echo form_dropdown("whole_detail[uom][$k]", $itemC, $data['whole_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("whole_detail[uom][$k]", $itemC  , $data['whole_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
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
<?php if(($data['whole_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
<?php if($data['whole_header']['status'] != '2') : ?>
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
    <td align="center"><?=anchor('whole/browse', $this->lang->line('button_back'));?></td>
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