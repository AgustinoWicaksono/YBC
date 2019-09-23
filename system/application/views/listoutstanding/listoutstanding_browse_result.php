<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<div align="center" class="page_title"><?=$page_title;?><br />Dari <?=$date_from;?> s/d <?=$date_to;?></div>
<?php
$dates = count($data);

for($i = 0; $i < $dates; $i++) { // data per date
?>
	<table width="1150" border="0" align="center">
<?php
	$rows = count($data[$i]);

	for($j = 0; $j < $rows; $j++) { // date per row

		if(empty($fields))
			$fields = count($data[$i][$j]);
//echo '<h1>'.$fields.'</h1>';
		if($j == 0) {
?>
		<tr>
			<th colspan="<?=$fields;?>" bgcolor="#999999"><Strong>Tanggal <?=date("d-m-Y", $timestamp[$i]);?></Strong></th>
		</tr>
		<tr>
			<th colspan="<?=$fields;?>" bgcolor="#CCCCCC"><Strong>Last Update <?=date("d-m-Y H:i:s", $filetime[$i]);?></Strong></th>
		</tr>
<?php
		}

		if($data[$i][$j][3] == $this->session->userdata['ADMIN']['plant'] || $j == 0) { // check is it the plant's data?
			if($j % 2) {
?>
	  <tr class="table_row_1">
<?php
			} else {
?>
		<tr class="table_row_2">
<?php
			}

			for ($k = 0; $k < $fields; $k++) { // create data fields
				if ($j == 0) { // table header
?>
			<th><?=$data[$i][$j][$k];?></th>
<?php
				} else {

					if(!empty($data[$i][$j])) {
						//if(is_numeric($data[$i][$j][$k]))
						if($k == 4) { // for number
?>
			<td align="right"><?=number_format($data[$i][$j][$k], 2, ',', '.');?></td>
<?php
						} else { // for non number
?>
			<td align="left"><?=$data[$i][$j][$k];?></td>
<?php
						}
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
<?php
}
?>
</body>