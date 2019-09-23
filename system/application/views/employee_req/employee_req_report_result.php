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
<!-- Start of menu and main CSS
//-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/main.css" />
</head>
<body>
<div align="center" class="page_title"><?=$page_title;?></div>
<p></p>
<table>
	<tr>
		<td width="200"><b>Pilihan Cabang</b></td>
		<td><?=$pilihan_cabang;?> </td>
	</tr>
  <tr>
    <td><strong>Tanggal</strong></td>
		<td>Dari <?=$date_from;?> s/d <?=$date_to;?></td>
	</tr>
</table>
<p></p>
<table width="1150" border="0" align="center">
	<tr class="table_header_1">
		<th class="table_header_1">Cabang</th>
		<th class="table_header_1">No. Request</th>
		<th class="table_header_1">No. Req. HRMS</th>
		<th class="table_header_1">Tanggal Request</th>
		<th class="table_header_1">Requester</th>
		<th class="table_header_1">No. Candidate</th>
		<th class="table_header_1">Nama Candidate</th>
		<th class="table_header_1">Job Apply</th>
		<th class="table_header_1">Tanggal Interview</th>
		<th class="table_header_1">Interview Phase</th>
		<th class="table_header_1">Interviewer</th>
		<th class="table_header_1">Status</th>
		<th class="table_header_1">Tanggal Recruitment</th>
		<th class="table_header_1">NIK Kandidat di Rekrut</th>
  </tr>
<?php
if($data['reqs'] !== FALSE) :
	$i = 1;
	foreach ($data['reqs']->result_array() as $req):
?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
		<td><?=$req['outlet'];?></td>
		<td><?=$req['employee_req_id'];?></td>
		<td><?=$req['norequest'];?></td>
		<td><?=$req['req_date'];?></td>
		<td><?=$req['requestbyname'];?></td>
		<td><?=$req['candidate_no'];?></td>
		<td><?=$req['nama'];?></td>
		<td><?=$req['job_apply'];?></td>
		<td><?=$req['interview_date'];?></td>
		<td><?=$req['interview_phase'];?></td>
		<td><?=$req['interviewer'];?></td>
		<td><?=$req['status'];?></td>
		<td><?=$req['recruit_date'];?></td>
		<td><?=$req['nikrecruit'];?></td>
  </tr>
<?php
		$i++;
	endforeach;
endif;
?>
</table>

</body>