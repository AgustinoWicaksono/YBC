<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$page=$this->uri->segment(8);
?>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="1150" border="0" align="center">
<?=form_open('summwebdoc/browse_search', $form1);?>
  <tr>
    <td><strong>Outlet Type</strong>
     <?=form_dropdown('outlet_type', $outlet_types, $data['outlet_type'], 'class="input_text" onChange="document.form1.submit();"');?>
     <?=form_hidden('outlet_type_old', $data['outlet_type']);?>
     </td>
  </tr>
  <tr>
    <td><strong>Dari Outlet</strong>
     <?=form_dropdown('outlet_from', $outlets, $data['outlet_from'], 'class="input_text"');?>
     <strong>Sampai Outlet </strong>
     <?=form_dropdown('outlet_to', $outlets, $data['outlet_to'], 'class="input_text"');?>
    <?=form_submit($this->config->item('button_search'), 'Search');?>
    </td>
  </tr>
  <tr>
    <td><strong>Document Date Per Tgl. </strong><?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?>
        <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});

		</script>
        <strong>Jumlah Baris per halaman</strong> <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?>
    </td>
  </tr>
<tr>
  </tr>
	<?=form_close();?>
<table class="table-browse" width="1150" align="center">
<tr>
	<td align="center">Jumlah Outlet: <strong><?=$total_rows;?></strong></td>
	<td align="center">| Yang sudah EOD: <strong><?=$ttl_eod_success;?></strong></td>
	<td align="center">| Yang belum EOD: <strong><?=$total_rows-$ttl_eod_success;?></strong></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
</table>

<!--<div class="div_freezepanes_wrapper"  >-->

<table width="1000" border="0" align="center" style="margin:auto;padding:0px;">
	<tr class="table_header_1">
		<th width="30">&nbsp;</th>
		<th width="40" class = "table_header_1">Kode Outlet</th>
		<th width="160" class = "table_header_1">Nama Outlet</th>
		<th width="90" class="table_header_1">GR PO from Vendor</th>
		<th width="80" class ="table_header_1">GR PO STO with Delivery</th>
		<th width="50" class="table_header_1" >Stk. Opn.</th>
		<th width="85" class ="table_header_1">Goods Issue Stock Transfer</th>
		<th width="85" class ="table_header_1">Goods Receipt Stock Transfer</th>
		<th width="85" class="table_header_1" >Waste Material</th>
		<th width="105" class="table_header_1" >Req. Non Std Stock</th>
		<th width="105" class="table_header_1" >Req. Std Stock</th>
		<th width="100" class="table_header_1" >GR FG Outlet</th>
		<th width="100" class="table_header_1" >Transfer Selisih Stock ke CK</th>
		<th width="90" class="table_header_1" >Trend Utility</th>
		<th width="90" class="table_header_1" >Prd. Staff</th>
		<th width="100" class="table_header_1" >Goods Issue To Cost Center</th>
		<th width="20" class="table_header_1" >E O D</th>
        <!--<td width="10" class="table_header_1" >&nbsp;</td>-->
  </tr>
<!--  <tr>
	<td colspan="17" style="padding:0px;text-align:left;margin:auto;" align="left">

<div style="height:550px;width:1200px;vertical-align:top;overflow:auto;background:none;margin-left:-2px;">
<table width="1180" border="0" bordercolor="#000000" align="center" id="t1" style="margin:auto;padding:0px;">
  <tr bgcolor="#999999">
    <td width="10"></td>
    <td width="60"></td>
    <td width="100"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="60"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="70"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="80"></td>
    <td width="20"></td>
  </tr>
-->

<?php
if($data['summwebdoc_headers'] !== FALSE) :
    $i=1+$page;
	foreach ($data['summwebdoc_headers']->result_array() as $summwebdoc_header):
        $outlet = $summwebdoc_header['OUTLET'];
        unset($grpo);
		foreach ($grpos[$outlet] as $grpo_temp) {
		   if (!empty($grpo))
             $grpo = $grpo.' <br> '.$grpo_temp;
           else
             $grpo = $grpo_temp;
        }

        unset($grpodlv);
		foreach ($grpodlvs[$outlet] as $grpodlv_temp) {
		   if (!empty($grpodlv))
             $grpodlv = $grpodlv.' <br> '.$grpodlv_temp;
           else
             $grpodlv = $grpodlv_temp;
        }

        $stockoutlet = 'N';
        if (!empty($stockoutlets[$outlet]))
          $stockoutlet = 'Y';

        unset($gisto);
		foreach ($gistos[$outlet] as $gisto_temp) {
		   if (!empty($gisto))
             $gisto = $gisto.' <br> '.$gisto_temp;
           else
             $gisto = $gisto_temp;
        }

        unset($grsto);
		foreach ($grstos[$outlet] as $grsto_temp) {
		   if (!empty($grsto))
             $grsto = $grsto.' <br> '.$grsto_temp;
           else
             $grsto = $grsto_temp;
        }

        unset($waste);
		foreach ($wastes[$outlet] as $waste_temp) {
		   if (!empty($waste))
             $waste = $waste.' <br> '.$waste_temp;
           else
             $waste = $waste_temp;
        }

        unset($nonstdstock);
		foreach ($nonstdstocks[$outlet] as $nonstdstock_temp) {
		   if (!empty($nonstdstock))
             $nonstdstock = $nonstdstock.' <br> '.$nonstdstock_temp;
           else
             $nonstdstock = $nonstdstock_temp;
        }

        unset($stdstock);
		foreach ($stdstocks[$outlet] as $stdstock_temp) {
		   if (!empty($stdstock))
             $stdstock = $stdstock.' <br> '.$stdstock_temp;
           else
             $stdstock = $stdstock_temp;
        }

        unset($grfg);
		foreach ($grfgs[$outlet] as $grfg_temp) {
		   if (!empty($grfg))
             $grfg = $grfg.' <br> '.$grfg_temp;
           else
             $grfg = $grfg_temp;
        }

        unset($tssck);
		foreach ($tsscks[$outlet] as $tssck_temp) {
		   if (!empty($tssck))
             $tssck = $tssck.' <br> '.$tssck_temp;
           else
             $tssck = $tssck_temp;
        }

        unset($trend_utility);
		foreach ($trend_utilitys[$outlet] as $trend_utility_temp) {
		   if (!empty($trend_utility))
             $trend_utility = $trend_utility.' <br> '.$trend_utility_temp;
           else
             $trend_utility = $trend_utility_temp;
        }

        unset($gitcc);
		foreach ($gitccs[$outlet] as $gitcc_temp) {
		   if (!empty($gitcc))
             $gitcc = $gitcc.' <br> '.$gitcc_temp;
           else
             $gitcc = $gitcc_temp;
        }

        $prodstaff = 'N';
 	    if (!empty($prodstaffs[$outlet]))
             $prodstaff = 'Y';

/*
        if((!empty($waste))&&($stockoutlet=='Y'))
          $eod = 'Y';
        else
          $eod = 'N';
*/
        $eod = 'N';
	if (!empty($eods[$outlet]))
             $eod = 'Y';


?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
		<td><?=$i;?></td>
		<td class="column_row_1"><strong><?=$outlet;?></strong></td>
		<td><strong><?=$summwebdoc_header['OUTLET_NAME2'].' - '.$summwebdoc_header['OUTLET_NAME1']?></strong></td>
		<td class = "column_row_1"><?=$grpo;?></td>
		<td ><?=$grpodlv;?></td>
        <?php if($stockoutlet=='Y') : ?>
        <td class="column_row_1"><strong><?=$stockoutlet?></strong></td>
        <?php else : ?>
        <td class="merah"><strong><?=$stockoutlet?></strong></td>
        <?php endif; ?>
		<td ><?=$gisto;?></td>
		<td class = "column_row_1"><?=$grsto;?></td>
		<td ><?=$waste;?></td>
		<td class = "column_row_1"><?=$nonstdstock;?></td>
		<td ><?=$stdstock;?></td>
		<td class = "column_row_1"><?=$grfg;?></td>
		<td ><?=$tssck;?></td>
		<td class = "column_row_1"><?=$trend_utility;?></td>
        <?php if($prodstaff=='Y') : ?>
        <td align="center"><strong><?=$prodstaff?></strong></td>
        <?php else : ?>
        <td class="merah"><strong><?=$prodstaff?></strong></td>
        <?php endif; ?>
		<td class="column_row_1"><?=$gitcc;?></td>
        <?php if($eod=='Y') : ?>
		<td class = "eod_y"><?=$eod;?></td>
        <?php else : ?>
		<td class = "eod_n"><?=$eod;?></td>
        <?php endif; ?>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?>
<!--</table>
</td></tr>-->

<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah Outlet: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
<tr>
<td align="center">
<?=anchor('home/home', $this->lang->line('button_back'));?>
</td>
</tr>
</table>
