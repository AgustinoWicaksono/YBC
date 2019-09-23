<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant = $this->session->userdata['ADMIN']['plant'];
$plant_name = $this->session->userdata['ADMIN']['plant_name'];
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<?php if(!empty($page['page_name'])) : ?>
<title><?=$this->lang->line('page_'.$page['page_name']);?> - <?=$this->m_config->content_select('main_sitename');?></title>
<?php else : ?>
<title><?=$this->m_config->content_select('main_sitename');?></title>
<?php endif; ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Start of menu and main CSS //-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/main.css" />
</head>

<body>
<div align="center" class="page_title"><?=$page_title;?>
<br />Outlet <?=$plant;?> - <?=$plant_name;?>
<br />Periode <?=$date_from;?> s/d <?=$date_to;?>
</div>
<?php
//$dates = count($data);
//for($i = 0; $i < $dates; $i++) { // data per date
//echo "<pre>";
//print_r($data_d);
//echo "</pre>";
$row_count_to_show_header = 30;
?>
	<table width="1200" border="0" align="center">
<?php
	$rows = count($data);
	for($j = 0; $j < $rows; $j++) { // date per row

		if(empty($fields))
			$fields = count($data[0]);
			$fields_h = count($data_h[0]);
		if(fmod($j,$row_count_to_show_header) == 0) {
?>
		<tr>
<?php
		for ($g = 1; $g <= $fields_h; $g++) { // create header fields
           if(($g<=3)||(fmod($g,4)==0)) {
             if ($g<=3) {
?>
    			<th bgcolor="#CCCCCC"><?=$data_h[0][$g];?></th>
<?php
            } else {
?>
     			<th bgcolor="#CCCCCC" colspan="4"><?=$data_h[0][$g];?></th>
<?php
            }
?>
<?php
            }
        }
?>
		</tr>
<?php
		}
      if (fmod($j,$row_count_to_show_header) == 0) { // table header
?>
		<tr>
<?php
          for ($k = 1; $k <= $fields; $k++) { // create header fields
?>
			<th bgcolor="#CCCCCC"><?=$data[0][$k];?></th>
<?php
         }
?>
		</tr>
<?php
     }
			if($j % 2) {
?>
	  <tr class="table_row_1">
<?php
			} else {
?>
		<tr class="table_row_2">
<?php
			}
			for ($k = 1; $k <= $fields; $k++) { // create data fields
?>
<?php
				if ($j>0) {

					if(!empty($data[$j][$k])) {
						if($k > 3) { // for number
                           $m = fmod($k,4);
                           if($m==0) {
                             $field_name = 'PR_QTY';
                             $data_qtys = $this->m_prstodlvgr->prstodlvgr_select_qty($data_h[0][$k],$data[$j][1]);
                           } else {
                              switch ($m) {
                                 case 1:
                                       $field_name = 'PO_QTY';
                                       break;
                                 case 2:
                                       $field_name = 'DLV_QTY';
                                       break;
                                 case 3:
                                       $field_name = 'DOVSGR';
                                       break;
                              }
                           }
                          $data_qty = $data_qtys[$field_name];
                          if ($data_qty!=0) :
?>
			<td align="right"><?=number_format($data_qty, 2, ',', '.');?></td>
<?php
                          else :
?>
			<td align="right">-</td>
<?php
                         endif;
						} else {
						if($k==1) {
                          $data_matr = $this->l_general->remove_0_digit_in_item_code($data[$j][$k]);
						} else {
                          $data_matr = $data[$j][$k];
						} // for non number
?>
			<td align="left"><?=$data_matr;?></td>
<?php
						}
					}
				}
			}
?>
		</tr>
<?php
	}
?>
	</table>
</body>

</html>