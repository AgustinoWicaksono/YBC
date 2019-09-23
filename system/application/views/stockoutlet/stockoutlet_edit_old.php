<?php
$function = $this->uri->segment(2);


$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
?>


<script language="javascript">
function changeVal(obj, number) {
	var x = 'stockoutlet_detail[qty_gso]['+number+']';
	var y = 'stockoutlet_detail[qty_gss]['+number+']';
	var z = 'stockoutlet_detail[quantity]['+number+']';
	var num = 0;
	var result = 0;

	if(obj.form.elements[x].value == '') {
		obj.form.elements[x].value = 0;
	} else if(obj.form.elements[y].value == '') {
		obj.form.elements[y].value = 0;
	}
    num = parseFloat(obj.form.elements[x].value) ; //+ parseFloat(obj.form.elements[y].value);
	result = num.toFixed(2);
	obj.form.elements[z].value = result;
}
</script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('stockoutlet_header[id_stockoutlet_header]', $this->uri->segment(3));
}
?>
<table width="930" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Material Document No. </strong></td>
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['stockoutlet_header']['stockoutlet_no'];?></td>
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
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['stockoutlet_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
    	<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
            <?=form_hidden("stockoutlet_header[item_group_code]", $stockoutlet_header['item_group_code']);?>
            <?php if(!empty($stockoutlet_header['item_group_code'])&&($function!=='edit')) : echo anchor('stockoutlet/input','<strong>Pilih ulang Material Group</strong>'); endif;?>
        </td>

	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['stockoutlet_header']['posting_date']));?></td>//-->
<?php
$plant= $this->session->userdata['ADMIN']['storage_location'];
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
  		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['stockoutlet_header']['posting_date'])) {
		$posting_date = date("d-m-Y", strtotime($data['stockoutlet_header']['posting_date']));
    }
?>
		<td class="column_input">
            <?php
            if($function!=='edit') : ?>
            <?php
            if(($data['stockoutlet_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
            <?=form_input('stockoutlet_header[posting_date]', $posting_date, 'class="input_text" size="10"');?>
                <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stockoutlet_header[posting_date]'
					});
		        </script><?php else: ?><?=$posting_date;?><?=form_hidden("stockoutlet_header[posting_date]", $posting_date);?><?php endif;?>
            <?php else: ?><?=$posting_date;?><?=form_hidden("stockoutlet_header[posting_date]", $posting_date);?><?php endif;?>
        </td>
	</tr>
</table>

<div class="div_freezepanes_wrapper"  >


<table width="930" border="0" align="center" id="t1header">
<thead>
  <tr bgcolor="#797979">
    <th width="37" class="table_header_1_opname"><div align="center"><strong>No.</strong></div></th>
    <th width="177" class="table_header_1_opname"><div align="center"><strong>Material No</strong></div></th>
    <th width="275" class="table_header_1_opname"><div align="center"><strong>Material Desc</strong></div></th>
     <th width="177" class="table_header_1_opname"><div align="center"><strong>Batch Number </strong></div></th>
    <th width="120" class="table_header_1_opname"><div align="center"><strong>Qty Bin Card<br>
    </strong></div></th>
    <!--th width="120" class="table_header_1_opname"><div align="center"><strong>Qty Warehouse <br> Stock Support</strong></div></th-->
    <th width="100" class="table_header_1_opname"><div align="center"><strong>Qty Fisik</strong></div></th>
    <th width="90" class="table_header_1_opname"><div align="center"><strong>Uom</strong></div></th>
    <!--th width="35" class="table_header_1_opname" >&nbsp;</th-->
  </tr>
</thead>  
  <tr>
	<td colspan="9" style="padding:0px;text-align:left;margin:0px;" align="left">
<table class="filterable" border="0" width="100%" cellpadding="0" cellspacing="0" />
<tr><td>

<div style="height:350px;vertical-align:top;overflow:auto;background:none;margin-left:-2px;border-bottom:#376091 1px solid;">
<table width="100%" border="0" align="center" id="t1" style="margin:0px;padding:0px;">
  <tr bgcolor="#999999">
    <td width="37"></td>
    <td width="177"></td>
    <td width="270"></td>
    <td width="177"></td>
    <!--td width="120"></td-->
    <td width="120"></td>
    <td width="100"></td>
   
  </tr>
<?php
//if($data['stockoutlet_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
	mysql_connect("localhost",$user_mysql,$pass_mysql);
	mysql_select_db($db_mysql);
	if(!empty($data['stockoutlet_detail']['id_stockoutlet_detail'])) {
   	  $count = count($data['stockoutlet_detail']['id_stockoutlet_detail']);
	 
    
    } else {
   	  $count = count($stockoutlet_detail['id_stockoutlet_h_detail']);
    }
	
    $qty_gso = $this->session->userdata('qty_gso');
    $qty_gss = $this->session->userdata('qty_gss');
    $quantity = $this->session->userdata('quantity');

    $item_qty = $this->m_stockoutlet->stockoutlet_detail_select_qty_by_date_and_material_no($posting_date);
	for($i = 1; $i <= $count; $i++) :
		if($data['stockoutlet_header']['status'] == '1' || ( ($data['stockoutlet_header']['status'] == '2') && !empty($data['stockoutlet_detail']['gr_quantity'][$i]) )) {
			$j++;
		}
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td align="center"><?php if(!isset($data['stockoutlet_header']['status']) || $data['stockoutlet_header']['status'] == '1') : ?>
        <?=form_hidden("stockoutlet_detail[id_stockoutlet_h_detail][$i]", $stockoutlet_detail['id_stockoutlet_h_detail'][$i]);?>
        <?=form_hidden("stockoutlet_detail[id_stockoutlet_detail][$i]", $data['stockoutlet_detail']['id_stockoutlet_detail'][$i]);?>
        <?=form_hidden("stockoutlet_detail[MATNR][$i]", $stockoutlet_detail['MATNR'][$i]);?>
        <?=form_hidden("stockoutlet_detail[MAKTX][$i]", $stockoutlet_detail['MAKTX'][$i]);?>
        <?=form_hidden("stockoutlet_detail[num][$i]", $stockoutlet_detail['num'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
      <?php
      
	  ?>
    <td><?=$stockoutlet_detail['MATNR1'][$i];?></td>
    <td><?=$stockoutlet_detail['MAKTX'][$i];?></td>
     <td><?=$stockoutlet_detail['num'][$i];?></td>
    <td align="center"><?php
		if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($qty_gso)) {
            $qtygso = $qty_gso[$i];
			} else {
            $qtygso = $data['stockoutlet_detail']['qty_gso'][$i];
            }
            if ($function == 'input2') {
              $qtygso = $item_qty['qty_gso'][$stockoutlet_detail['MATNR'][$i]];
            }
?><?=form_input("stockoutlet_detail[qty_gso][$i]", number_format($qtygso, 2, '.', ''), 'onChange="changeVal(this, '.$i.')" class="input_number" size="8"');?> <span class="jcalc"><a title="calculator" href="javascript:TCR.TCRPopup(document.forms['form1'].elements['stockoutlet_detail[qty_gso][<?=$i;?>]'])">Calculator</a></span>
<?php
		} else {
			echo number_format($data['stockoutlet_detail']['qty_gso'][$i], 2, '.', ',');
		}
		?></td>
    <!--td align="center"><?php
		/*if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($qty_gss)) {
                $qtygss = $qty_gss[$i];
			} else {
                $qtygss = $data['stockoutlet_detail']['qty_gss'][$i];
            }
            if ($function == 'input2') {
              $qtygss = $item_qty['qty_gss'][$stockoutlet_detail['MATNR'][$i]];
            }
?> <?=form_input("stockoutlet_detail[qty_gss][$i]", number_format($qtygss, 2, '.', ''), 'onChange="changeVal(this, '.$i.')" class="input_number" size="8"');?> <span class="jcalc"><a title="calculator" href="javascript:TCR.TCRPopup(document.forms['form1'].elements['stockoutlet_detail[qty_gss][<?=$i;?>]'])">Calculator</a></span>
<?php
		} else {
			echo number_format($data['stockoutlet_detail']['qty_gss'][$i], 2, '.', ',');
		}*/
		?></td-->
    <td align="center"><?php
		if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($quantity)) {
                $qty = $quantity[$i];
			} else {
                $qty = $data['stockoutlet_detail']['quantity'][$i];
            }
            if ($function == 'input2') {
              $qty = $item_qty['quantity'][$stockoutlet_detail['MATNR'][$i]];
            }
          	echo form_input("stockoutlet_detail[quantity][$i]", number_format($qty, 2, '.', ''), 'class="input_number" size="8" disabled="disabled" ');
		} else {
			echo number_format($data['stockoutlet_detail']['quantity'][$i], 2, '.', ',');
		}
		?></td>
    <td><?php
		$item_x[$i] = $this->m_general->sap_item_select_by_item_code($stockoutlet_detail['MATNR'][$i]);
        if (!empty($data['stockoutlet_detail']['uom'][$i])) {
          $item_x[$i]['UNIT'] = $data['stockoutlet_detail']['uom'][$i];
        }
        ?>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['stockoutlet_header']['status'] != '2')):
           if($function == 'input2') { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['stockoutlet_header']['status'] != '2')):
           if($function == 'input2') { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
        
        </td>
          <!-- dari sini -->
        <td>
       <?php
	   $it=$stockoutlet_detail['MATNR'][$i];
	//echo $it;
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
	
		if(!empty($error) && in_array("stockoutlet_detail[uom][$i]", $error)) {
			echo form_dropdown("stockoutlet_detail[uom][$i]", $itemC, $data['stockoutlet_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:60px;" ');
		} else {
		echo form_dropdown("stockoutlet_detail[uom][$i]", $itemC  , $data['stockoutlet_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:60px;"  ');  
		}
		}
		unset($itemC);
	   ?>
        </td>
        <!-- sampe sini -->

  </tr>
 
  <?php
	endfor;
?>
 <?php
  if($data['stockoutlet_header']['status'] != '2') :
    ?>
	<!--tr>
<?php if(empty($data['stockoutlet_header']['status']) || $data['stockoutlet_header']['status'] == '1') : ?>
		
<?php endif; ?>
		<td align="center"><?php if(!isset($data['stockoutlet_header']['status']) || $data['stockoutlet_header']['status'] !== '0') : ?><?=form_hidden("stockoutlet_detail[id_stockoutlet_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		
	/*	mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		$query="SELECT material_no,material_desc FROM m_opnd_detail JOIN m_opnd_header ON m_opnd_detail.id_opnd_header=m_opnd_header.id_opnd_header 
		JOIN m_item ON m_opnd_detail.material_no=m_item.MATNR
		WHERE plant ='$plant'";
		while($r=mysql_fetch_array(mysql_query($query)))
		{
			$item1[$r['material_no']] = $r['material_no'].' - '.$r['material_desc'] ;
		}
		
		if(!empty($error) && in_array("stockoutlet_detail[material_no][$i]", $error)) {
			echo form_dropdown("stockoutlet_detail[material_no][$k]", $item, $data['stockoutlet_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" ');
		} else {
			echo form_dropdown("stockoutlet_detail[material_no][$k]", $item, $data['stockoutlet_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" ');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("stockoutlet_detail[num][$i]", $error)) {
			echo form_input("stockoutlet_detail[num][$k]", $data['stockoutlet_detail']['num'][$i], 'class="error_number" size="15"');
		} else {
			echo form_input("stockoutlet_detail[num][$k]", $data['stockoutlet_detail']['num'][$i], 'class="input_number" size="15"');
		}
		?>
		</td>
        <td align="center">
		<?php
		if(!empty($error) && in_array("stockoutlet_detail[price][$i]", $error)) {
			echo form_input("stockoutlet_detail[price][$k]", $data['stockoutlet_detail']['price'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("stockoutlet_detail[price][$k]", $data['stockoutlet_detail']['price'][$i], 'class="input_number" size="8"');
		}*/
		?>
		</td>
		
	</tr-->
<?php endif; ?>
</table>
</div>
</td>
</tr>
</table>
<script src="<?=base_url();?>js/filterTable.js?88" type="text/javascript"></script>
</td></tr>
</table>
<?php /*if($data['stockoutlet_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
        <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?>
        </td>
	</tr>
</table>
<?php endif; */?>
<p>&nbsp;</p>
</div>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
<?php if($data['stockoutlet_header']['status'] != '2') : ?>
		<td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Stock Opname.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a>
        </td>
<?php endif; ?>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('stockoutlet/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<div style="clear:both;">&nbsp;</div>