<?php
$swbcssver=55;
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
header("Pragma: no-cache");
$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

$controller = $this->uri->segment(1);

if (!$this->l_auth->is_logged_in())
{
	$this->session->set_userdata('lang_name', 'indonesian');
	$this->session->set_userdata('lang_id', '1');
	$this->session->set_userdata('template', 'default');
}

$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_auth', $this->session->userdata('lang_name'));
$this->load->helper('url');

$menu = $this->l_menu->get_menu();
//echo $this->uri->segment(1);
$page = $this->m_page->page_select($this->uri->segment(1), $this->uri->segment(2));
$heads = $this->m_head->heads_select($this->uri->segment(1), $this->uri->segment(2));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ID" lang="ID" >
<head>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Language" content="id" />
<meta http-equiv="Copyright" content="JAG" />
<meta http-equiv="Author" content="JAG" />
<meta name="rating" content="General" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 26 Jul 1997 05:00:00 GMT" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 
$jag_page_title = $page_title;
if (Empty($jag_page_title)) $jag_page_title = "";
if (strpos($jag_page_title,"<")>0) {
	$jag_page_title = explode("<",$jag_page_title);
	$jag_page_title = $jag_page_title[0];
}
$jag_page_title = strip_tags($jag_page_title);
$jag_page_title = trim($jag_page_title);
$jag_user_title = trim($this->session->userdata['ADMIN']['admin_realname']);
if ($jag_user_title!="") $jag_user_title = " | ".$jag_user_title;


if($jag_page_title!="") : ?>
<title><?php echo $jag_page_title;?> - <?php echo $this->m_config->content_select('main_sitename');?><?php echo $jag_user_title;?></title>
<?php else : ?>
<title><?php echo $this->m_config->content_select('main_sitename');?></title>
<?php endif; ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="icon" type="image/png" href="<?php echo base_url();?>favicon.png">
<!-- Start of menu and main CSS //-->
<style type="text/css">@import url(<?php echo base_url();?>css/swebee.css?v=<?php echo $swbcssver; ?>);</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/main.css?v=<?php echo $swbcssver; ?>" />
<link href="<?php echo base_url();?>css/dropdown.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/default.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/default.ultimate.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />


<!-- End of menu and main CSS //-->
<script src="<?php echo base_url();?>js/jquery-1.11.0.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
		$('#gridTable2').dataTable( {	
				"destroy": true,
				"scrollY": "400px",
				"scrollCollapse": true,					
				"scrollX": true,
				"bProcessing": true,
				"bServerSide": true,
				/*
				"fnServerParams": function (aoData) {
					aoData.push( { "name": "idd", "value": id } );
				},		*/		
				"sAjaxSource": "../browse_complete_data_history/<?php echo $this->uri->segment(3)?>",

				'fnServerData': function(sSource, aoData, fnCallback){
				
					$.ajax({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : function(res){
							 console.log(res.data);
							 fnCallback(res);
						},
						'error'	:	function(){
							alert("Error");
						}
					});
				}	
		});	


});

</script>

<script type="text/javascript">
var jagservtime = new Date(<?php echo date('y,n,j,G,i,s'); ?>);
</script>
<script src="<?php echo base_url();?>js/time.js" type="text/javascript"></script>


<?php if ( ( $this->l_auth->is_logged_in() )) : ?>
<script language="javascript" type="text/javascript">
<!--
	function confirm_logout(url) {
		var m = confirm('<?php echo $this->lang->line('auth_logout_confirm');?>');
		if(m) {
			location.href=url;
		}
	}
//-->
</script>
<?php endif; ?>
<?php
if($heads !== FALSE) {
	foreach ($heads->result_array() as $head) {
/*		eval('?>' . $head['script_content'] . '<?php'); */
		eval('?>' . $head['script_content']);
	}
}
?>
<?php if($refresh): ?>
	<meta http-equiv="refresh" content="<?php echo $refresh_time;?>;url=<?php echo site_url($refresh_url);?>" />
<?php endif; ?>

</head>

<?php if(!empty($page['page_focus'])) : ?>
<body onload="self.focus();document.<?php echo $page['page_focus'];?>.focus()">

<?php else : ?>
<body>
<?php endif; ?>
<?php

//pengumuman harian
//include_once ("/srv/www/vhosts/sap.ybc.co.id/system/application/views/dailymessage.php");
include_once (APPPATH."views/currentprocess.php");
//echo "<pre>";
/*if ($this->session->userdata['ADMIN']['admin_username']=='cobasaja'){
 print_r($this->session->userdata['ADMIN']);
 echo '#'.$this->session->userdata['ADMIN']['admin_perm_grup_ids'].'#';
}*/
//echo "</pre>";
// echo "<br /><hr />";

if(($this->session->userdata['ADMIN']['plant_type_id']=='JID') || ($this->session->userdata['ADMIN']['plant_type_id']=='JMY') || ($this->session->userdata['ADMIN']['plant_type_id']=='JSG')) { $jagcompany="JCO";}
elseif($this->session->userdata['ADMIN']['plant_type_id']=='BID') { $jagcompany="BreadTalk";}
elseif($this->session->userdata['ADMIN']['plant_type_id']=='RID') { $jagcompany="Roppan";}

// print_r($this->session->userdata['ADMIN']);

$office_array = $this->m_constant_fixed->office_plants();
$is_office = array_search($this->session->userdata['ADMIN']['plant'], $office_array);
if (Empty($is_office)) $is_office = -1;
$logo_company = strtolower($this->session->userdata['ADMIN']['plant_type_id']);
if ($is_office>-1) $logo_company = 'jag';
?>
<div align="center" class="page_title"><?php echo $page_title;?></div>
<p>&nbsp;</p>


<?php
// echo "<pre>"; 
// print_r($sewa_mall);
// echo "</pre>";
?>
<div style="margin-left:1%;margin-right:1%;">
	<div class="well">
			<span class="label">OUTLET</span> <?php echo $sewa_mall[0]['SEWA_OUTLET'];?> (<?php echo $sewa_mall[0]['SEWA_COMPANY'];?>)			
			<span class="label">MALL</span> <?php echo $sewa_mall[0]['SEWA_MALL'];?>				
			<span class="label">PLANT</span> <?php echo $sewa_mall[0]['SEWA_PLANT'];?>			
			<span class="label">CITY</span> <?php echo $sewa_mall[0]['SEWA_CITY'];?>			
	</div>
</div>
<br/><br/><br/>	
<table id="gridTable2" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            
			<th>Opening Date</th>
			<th>Closing Date</th>	
			<th>Thn Sewa</th>
			<th>Mulai Sewa</th>
			<th>Akhir Sewa</th>
			<th>Summary</th>
			<th>LOI</th>
			<th>PSM</th>			
			<th>Opsi Sewa</th>
			<th>Location</th>
			<th>Large Area</th>
			<th>Large Area 2</th>
			<th>Large Area 3</th>
			<th>Large Area Free</th>	
			<th>Grace Period</th>
			<th>Discount</th>
			<th>Advance Money/ DP</th>
			<th>Installment</th>
			<th>Tahun Sewa: 1</th>
			<th>Tahun Sewa: 2</th>		
			<th>Tahun Sewa: 3</th>
			<th>Tahun Sewa: 4</th>	
			<th>Tahun Sewa: 5</th>
			<th>Tahun Sewa: 6</th>	
			<th>Tahun Sewa: 7</th>
			<th>Tahun Sewa: 8</th>	
			<th>Tahun Sewa: 9</th>
			<th>Tahun Sewa: 10</th>	
			<th>Service Charge <br/>Tahun: 1</th>
			<th>Service Charge <br/>Tahun: 2</th>		
			<th>Service Charge <br/>Tahun: 3</th>
			<th>Service Charge <br/>Tahun: 4</th>	
			<th>Service Charge <br/>Tahun: 5</th>
			<th>Service Charge <br/>Tahun: 6</th>	
			<th>Service Charge <br/>Tahun: 7</th>
			<th>Service Charge <br/>Tahun: 8</th>	
			<th>Service Charge <br/>Tahun: 9</th>
			<th>Service Charge <br/>Tahun: 10</th>	
			<th>Indoor Charge <br/>(USD) : 1</th>
			<th>Indoor Charge <br/>(IDR) : 1</th>
			<th>Outdoor Charge <br/>(USD) : 1</th>	
			<th>Outdoor Charge <br/>(IDR) : 1</th>	
			<th>Indoor Charge <br/>(USD) : 2</th>
			<th>Indoor Charge <br/>(IDR) : 2</th>
			<th>Outdoor Charge <br/>(USD) : 2</th>	
			<th>Outdoor Charge <br/>(IDR) : 2</th>			
			<th>Indoor Charge <br/>(USD) : 3</th>
			<th>Indoor Charge <br/>(IDR) : 3</th>
			<th>Outdoor Charge <br/>(USD) : 3</th>	
			<th>Outdoor Charge <br/>(IDR) : 3</th>			
			<th>Indoor Charge <br/>(USD) : 4</th>
			<th>Indoor Charge <br/>(IDR) : 4</th>
			<th>Outdoor Charge <br/>(USD) : 4</th>	
			<th>Outdoor Charge <br/>(IDR) : 4</th>			
			<th>Indoor Charge <br/>(USD) : 5</th>
			<th>Indoor Charge <br/>(IDR) : 5</th>
			<th>Outdoor Charge <br/>(USD) : 5</th>	
			<th>Outdoor Charge <br/>(IDR) : 5</th>			
			<th>Indoor Charge <br/>(USD) : 6</th>
			<th>Indoor Charge <br/>(IDR) : 6</th>
			<th>Outdoor Charge <br/>(USD) : 6</th>	
			<th>Outdoor Charge <br/>(IDR) : 6</th>		
			<th>Indoor Charge <br/>(USD) : 7</th>
			<th>Indoor Charge <br/>(IDR) : 7</th>
			<th>Outdoor Charge <br/>(USD) : 7</th>	
			<th>Outdoor Charge <br/>(IDR) : 7</th>			
			<th>Indoor Charge <br/>(USD) : 8</th>
			<th>Indoor Charge <br/>(IDR) : 8</th>
			<th>Outdoor Charge <br/>(USD) : 8</th>	
			<th>Outdoor Charge <br/>(IDR) : 8</th>
			<th>Indoor Charge <br/>(USD) : 9</th>
			<th>Indoor Charge <br/>(IDR) : 9</th>
			<th>Outdoor Charge <br/>(USD) : 9</th>	
			<th>Outdoor Charge <br/>(IDR) : 9</th>			
			<th>Indoor Charge <br/>(USD) : 10</th>
			<th>Indoor Charge <br/>(IDR) : 10</th>	
			<th>Outdoor Charge <br/>(USD) : 10</th>	
			<th>Outdoor Charge <br/>(IDR) : 10</th>				
			<th>Service Charge <br/>Indoor (USD)</th>	
			<th>Service Charge <br/>Indoor (IDR)</th>
			<th>Service Charge <br/>Outdoor (USD)</th>
			<th>Service Charge <br/>Outdoor (IDR)</th>	
			<th>PL @ Month <br/>(USD)</th>	
			<th>PL @ Month <br/>(IDR)</th>
			<th>PL Tahun <br/>(USD)</th>	
			<th>PL Tahun <br/>(IDR)</th>			
			<th>PL Onetime <br/>(USD)</th>
			<th>PL Onetime <br/>(IDR)</th>	
			<th>Singking Fund <br/>(USD)</th>				
			<th>Singking Fund <br/>(IDR)</th>
			<th>Deposit <br/>Sewa (IDR)</th>	
			<th>Deposit <br/>Service Charge (IDR)</th>	
			<th>Deposit <br/>Telpon (IDR)</th>
			<th>Deposit <br/>Internet (IDR)</th>
			<th>Deposit <br/>Listrik (IDR)</th>
			<th>Deposit <br/>Air & Gas (IDR)</th>
			<th>Deposit <br/>Wallsign (IDR)</th>
			<th>Deposit <br/>Holding (IDR)</th>
			<th>Deposit <br/>Fitout/ Renovation (IDR)</th>					
			<th>Total Biaya <br/>Sewa (USD)</th>		
			<th>Total Biaya <br/>Sewa (IDR)</th>	
			<th>Total Biaya <br/>Service Charge (USD)</th>		
			<th>Total Biaya <br/>Service Charge (IDR)</th>
			<th>Total Biaya <br/>PL (USD)</th>				
			<th>Total Biaya <br/>PL (IDR)</th>	
			<th>Total Biaya <br/>Singking (USD)</th>				
			<th>Total Biaya <br/>Singking (IDR)</th>			
			<th>TOTAL (USD)</th>	
			<th>TOTAL (IDR)</th>	
			<th>Biaya Sewa <br/>/ Bulan (USD)</th>	
			<th>Biaya Sewa <br/>/ Bulan (IDR)</th>	
			<th>Biaya Service Charge <br/>/ Bulan (USD)</th>	
			<th>Biaya Service Charge <br/>/ Bulan (IDR)</th>	
			<th>Biaya PL <br/>/ Bulan (USD)</th>	
			<th>Biaya PL <br/>/ Bulan (IDR)</th>	
			<th>Biaya SF <br/>/ Bulan (USD)</th>	
			<th>Biaya SF <br/>/ Bulan (IDR)</th>				
			<th>Total Biaya <br/>/ Bulan (USD)</th>	
			<th>Total Biaya <br/>/ Bulan (IDR)</th>				
			<th>Gudang Support <br/>Jumlah Thn Sewa</th>	
			<th>Gudang Support <br/>Awal Masa Sewa</th>			
			<th>Gudang Support <br/>Akhir Masa Sewa</th>
			<th>Gudang Support <br/>Luas</th>
			<th>Gudang Support <br/>Tarif 1</th>
			<th>Gudang Support <br/>Tarif 2</th>
			<th>Gudang Support <br/>Tarif 3</th>
			<th>Gudang Support <br/>Tarif 4</th>
			<th>Gudang Support <br/>Tarif 5</th>	
			<th>Gudang Support <br/>TOTAL BIAYA</th>
			<th>Sewa <br/>Konstruksi (Rp)</th>
			<th>Sewa <br/>Polesign (Rp)</th>
			<th>Sewa <br/>Wallsign (Rp)</th>
			<th>Sewa <br/>Pylonsign (Rp)</th>
			<th>Daya Listrik</th>
			<th>Tarif Listrik</th>	
			<th>Fasilitas</th>
			<th>Keterangan</th>
			<th>PIC <br/>Perusahaan</th>
			<th>PIC <br/>Alamat</th>
			<th>PIC <br/>Telpon/Fax</th>
			<th>PIC <br/>Nama</th>
			<th>PIC <br/>Financial</th>		
			<th>NOTES</th>		
        </tr>
    </thead>
</table>			


<br/><br/>
</body>
</html>