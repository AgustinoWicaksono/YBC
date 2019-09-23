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
<br />Periode <?=$date_from;?> s/d <?=$date_to;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$row_count_to_show_header = 30;
?>
	<table width="1200" border="0" align="center">
<?php
	$rows = count($data[0]);
	for($j = 0; $j < $rows; $j++) { // date per row

	 if(empty($fields)) $fields = count($data)-1;

     if (fmod($j,$row_count_to_show_header) == 0) { // table header
?>
		<tr>
<?php
     	for ($k = 0; $k <= $fields; $k++) { // create header fields
?>
			<th bgcolor="#CCCCCC"><?=$data[$k][0];?></th>
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
?>
<?php
			for ($k = 0; $k <= $fields; $k++) { // create data fields
                if ($j > 0) {

					if(!empty($data[$k][$j])) {
						if($k > 2) { // for number
                          if (is_numeric($data[$k][$j])&&($data[$k][$j]!=0)) {
?>
			<td align="right"><?=number_format($data[$k][$j], 2, ',', '.');?></td>
<?php
                          } else {
?>
			<td align="right">-</td>
<?php
                          }
						} else {
						if($k==0) {
                          $data_matr = $this->l_general->remove_0_digit_in_item_code($data[$k][$j]);
						} else {
                          $data_matr = $data[$k][$j];
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