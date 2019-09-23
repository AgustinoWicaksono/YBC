<?php if ($data['view_mode']==0) { ?>
<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<?php } ?>
<link href="<?=base_url();?>css/simpletabs.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?=base_url();?>js/simpletabs.js" type="text/javascript"></script>
<div align="center" class="page_title"><?=$page_title;?></div>
<?php
$uri_segment2 = $this->uri->segment(2);
$uri_segment3 = $this->uri->segment(3);
$form .= ' name="frmBranch" ';

if ((!Empty($data['store']['OPENING_DATE'])) || ($data['store']['OPENING_DATE']!='')) {
	$open_date = $data['store']['OPENING_DATE'];
	$data['store']['OPENING_DATE'] = date('d-m-Y',strtotime($open_date));
	$data['store']['OPENING_DATE2'] = date('l, j F Y',strtotime($open_date));
} else {
	$data['store']['OPENING_DATE2'] = '';
}
if ((!Empty($data['store']['CLOSING_DATE'])) || ($data['store']['CLOSING_DATE']!='')) {
	$close_date = $data['store']['CLOSING_DATE'];
	$data['store']['CLOSING_DATE'] = date('d-m-Y',strtotime($close_date));
	$data['store']['CLOSING_DATE2'] = date('l, j F Y',strtotime($close_date));
} else {
	$data['store']['CLOSING_DATE2'] = '';
}

if ($data['store']['OUTLET_STATUS']==0) $data['store']['OUTLET_STATUS2'] = 'New / Developing';
elseif ($data['store']['OUTLET_STATUS']==1) $data['store']['OUTLET_STATUS2'] = 'Running';
elseif ($data['store']['OUTLET_STATUS']==4) $data['store']['OUTLET_STATUS2'] = 'Closed';
else $data['store']['OUTLET_STATUS2'] = '';

if ($data['store']['OUTLET_STATUS']!=1) {$data['store']['AREAMANAGER_NAME']='N/A';$data['store']['AREAMANAGER_MAIL']='';}

?>

<?=form_open($this->uri->uri_string(), $form);?>
<table class="table-no-border" align="center" >
<?php if ($data['view_mode']==0) { ?>
	<tr>
		<td colspan="2" class="table_field_h" style="text-align:left">Isi form di bawah ini dengan selengkapnya</td>
	</tr>
	<tr>
		<td colspan="2" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
<?php } ?>
	<tr>
		<td class="table_field_1">Kode Outlet <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input" >
			<?php if($uri_segment2 == 'input')
				echo '<em>Auto Generated ID</em>';
			else {
				echo '<img src="'.base_url().'images/jlogo-'.strtolower($data['store_readonly']['COMP_CODE']).'-01.png" border="0" alt="" align="left" style="float:left;" /> <div style="padding:3px;margin-left:10px;float:left;"><b>'.$data['store']['OUTLET'].' <span style="color:#787878;font-weight:normal;font-size:120%;">|</span> <span style="color:#AA1122;">'.$data['store_readonly']['OUTLET_NAME2'].'</span></b> <span style="color:#787878;font-weight:normal;font-size:120%;">|</span> '.strtoupper($data['store_readonly']['OUTLET_NAME1']);
				echo form_hidden('store[OUTLET]', $data['store']['OUTLET']);
			}
			?>
			<br />
			Area Manager: <b><?php echo $data['store_readonly']['AREAMANAGER_NAME']; ?></b><br />
			Area Manager Email: <b><a href="mailto:<?php echo $data['store_readonly']['AREAMANAGER_MAIL']; ?>"><?php echo $data['store_readonly']['AREAMANAGER_MAIL']; ?></a></b>
			</div>
		</td>
	</tr>
	<?php /*
	<tr>
		<td class="table_field_1">Gedung / Mall <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_dropdown("store[BUILDING]", $data['building_list'], $data['store']['OUTLET_BUILDING'], ' data-placeholder="Pilih gedung/mall..." class="chosen-select input_text" style="width:350px;" onChange="javascript:getMallData(this.value)" '); 
				echo '['.anchor('building/input', 'Tambah Gedung/Mall').']';
			} 
			?>
			<div id="malldetail" name="malldetail" style="font-size:80%;padding:10px;"></div>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Lokasi Unit <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_input('store[OUTLET_BUILDING_LOC]', $data['store']['OUTLET_BUILDING_LOC'], 'class="input_text" maxlength="50" size="50" ');
			} else {
				echo $data['store']['OUTLET_BUILDING_LOC'];
			}
			?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Nama Outlet <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_input('store[OUTLET_NAME1]', $data['store']['OUTLET_NAME1'], 'class="input_text" maxlength="50" size="50" ');
			} else {
				echo $data['store']['OUTLET_NAME2'].' &mdash; '.$data['store']['OUTLET_NAME1'];
			}
			?>
		</td>
	</tr>	
		*/?>
	<tr>
		<td class="table_field_1">Alamat <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
		<?php
			if ($data['view_mode']==0) { 
				$dataalamat = array(
				  'name'        => 'store[ADDRESS]',
				  'id'          => 'store[ADDRESS]',
				  'value'       => $data['store']['ADDRESS'],
				  'rows'   => '5',
				  'cols'        => '50',
				  'class'       => 'input_text',
				);
				echo form_textarea($dataalamat);
			} else {
				echo str_replace("\r\n",'<br />',str_replace("\r",'<br />',str_replace("\n",'<br />',$data['store']['ADDRESS'])));
			}
		?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">URL Google Maps <?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
			<?php 
			/* //TEMP
			$data['store']['OUTLET_GOOGLEMAPS']='https://www.google.co.id/maps/place/Plaza+Kalibata,+Jl.+Raya+Kalibata,+Pancoran,+Kota+Jakarta+Selatan,+Daerah+Khusus+Ibukota+Jakarta+12750/@-6.2571092,106.8536797,17z/data=!4m7!1m4!3m3!1s0x2e69f252d4af04a7:0x56ff7ea9eae0917b!2sPlaza+Kalibata,+Jl.+Raya+Kal';
			$data['store']['LAT']=0;
			//TEMP
			*/
			
			if ($data['view_mode']==0) { 
				echo 'Silahkan copy URL Google Maps di browser Anda lalu paste ke kolom di bawah ini:<br />';
				echo form_input('store[OUTLET_GOOGLEMAPS]', $data['store']['OUTLET_GOOGLEMAPS'], 'class="input_text" maxlength="255" size="100" ').'<br />';
			} else {
				//echo $data['store']['OUTLET_GOOGLEMAPS'].'<br />';
				//https://www.google.co.id/maps/place/Plaza+Kalibata,+Jl.+Raya+Kalibata,+Pancoran,+Kota+Jakarta+Selatan,+Daerah+Khusus+Ibukota+Jakarta+12750/@-6.2571092,106.8536797,17z/data=!4m7!1m4!3m3!1s0x2e69f252d4af04a7:0x56ff7ea9eae0917b!2sPlaza+Kalibata,+Jl.+Raya+Kal
			}
			
			
			if ((trim($data['store']['OUTLET_GOOGLEMAPS'])!='') || ($data['store']['LAT']!=0)){
				$gMaps=$data['store']['OUTLET_GOOGLEMAPS'];
				$koordinat = $this->m_store->get_gps_googlemaps($gMaps);
				//print_r($koordinat);die();//TEMP
				if (($koordinat!==FALSE) || ($data['store']['LAT']!=0)){
					if ($data['store']['LAT']!=0){
//						echo 'ASLI';
					} else {
						$data['store']['LAT']=$koordinat['LAT'];
						$data['store']['LNG']=$koordinat['LNG'];
					}
					//echo 'Lokasi Koordinat GPS: '.$data['store']['LAT'].','.$data['store']['LNG'];
					if ($data['view_mode']!=0){ 
					}
					
					?>
					
<script src="http://maps.googleapis.com/maps/api/js?callback=initialize"></script>
<script>

var myCenter=new google.maps.LatLng(<?php echo $data['store']['LAT'];?>,<?php echo $data['store']['LNG'];?>);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:18,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);


	map.addListener('click', function(event) {
	   $('#store\\[LAT\\]').val( event.latLng.lat());
	   $('#store\\[LNG\\]').val( event.latLng.lng());
	   
	   
	});
}

google.maps.event.addDomListener(window, 'load', initialize);

function moveMarker( map, marker ) {
    
    //delayed so you can see it move
    setTimeout( function(){ 
    
        marker.setPosition( new google.maps.LatLng( 0, 0 ) );
        map.panTo( new google.maps.LatLng( 0, 0 ) );
        
    }, 1500 );

};

</script>
						<div id="googleMap" style="width:100%;height:450px;"></div>
					<?php
					if ($data['view_mode']!=0) { 
						echo 'Koordinat GPS: '.$data['store']['LAT'].','.$data['store']['LNG'];
					} else {
						echo 'Koordinat GPS: '.form_input('store[LAT]', $data['store']['LAT'], 'class="input_text" maxlength="15" size="15" ').','.form_input('store[LNG]', $data['store']['LNG'], 'class="input_text" maxlength="15" size="15" ');
					}
				}
				
			}
			?>
			
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Telpon Outlet Utama<?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?></td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_input('store[OUTLET_PHONE]', $data['store']['OUTLET_PHONE'], 'class="input_text" maxlength="50" size="50" ');
			} else {
				echo $data['store']['OUTLET_PHONE'];
			}
			?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Telpon Outlet Lainnya</td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_input('store[OUTLET_PHONE2]', $data['store']['OUTLET_PHONE2'], 'class="input_text" maxlength="50" size="50" ');
			} else {
				echo $data['store']['OUTLET_PHONE2'];
			}
			?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Kode Pos</td>
		<td class="column_input">
			<?php 
			if ($data['view_mode']==0) { 
				echo form_input('store[POST_CODE]', $data['store']['POST_CODE'], 'class="input_text" maxlength="50" size="50" ');
			} else {
				echo $data['store']['POST_CODE'];
			}
			?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Kota </td>
		<td class="column_input">
			<?php 
				echo $data['store_readonly']['CITY'];
			?>
		</td>
	</tr>	
	<tr>
		<td class="table_field_1">Email</td>
		<td class="column_input">
			<?php if ($data['store_readonly']['EMAIL']!='') echo '<a target="_blank" href="mailto:'.$data['store_readonly']['EMAIL'].'">'.$data['store_readonly']['EMAIL'].'</a>';?>
			<?php if ($data['view_mode']==0) { ?>&nbsp;<span class="note">(Filled by IT Division)</span><?php } ?>
		</td>
	</tr>
	<tr>
		<td class="table_field_1">Tanggal Pembukaan Pertama</td>
		<td class="column_input">
			<?php
				echo $data['store_readonly']['OPENING_DATE2'];
			?>
		</td>
	</tr>
	<?php /*
	<tr>
		<td class="table_field_1">Tanggal Tutup</td>
		<td class="column_input">
			<?php
			if ($data['view_mode']==0) { 
			echo form_input('store[CLOSING_DATE]', $data['store']['CLOSING_DATE'], 'class="input_text" maxlength="10" size="10" ');?>
			<script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'frmBranch',
						// input name
						'controlname': 'store[CLOSING_DATE]'
					});
			</script>
			<?php } else {
				echo $data['store']['CLOSING_DATE2'];
			} ?>

		</td>
	</tr>	
	*/ ?>
	<tr>
		<td class="table_field_1">Status</td>
		<td class="column_input">
			<?php if ($data['store']['OUTLET_STATUS2']!='') echo $data['store']['OUTLET_STATUS2'];?>
		</td>
	</tr>
	<tr>
		<td class="table_field_1">Status Data</td>
		<td class="column_input">
			<?php if (@$data['store']['LOCK_DATA']==1) echo '<span style="color:#11AA23;">Data sudah diverifikasi</span>'; else echo '<span style="color:#AA1122;">Data belum diverifikasi</span>';?>
		</td>
	</tr>
	<?php if ($data['view_mode']==0) { ?>
	<tr><td colspan="2" class="space"><?php if ($data['view_mode']==0) echo $this->lang->line('note1'); ?> <?=$this->lang->line('note_required');?></td></tr>
	<tr><td colspan="2" class="space">&nbsp;</td></tr>
	<?php } ?>
	

	

	<tr>
		<td colspan="2" class="column_description_note">
		<?php if ($data['view_mode']==0) { ?>
			<?php if($this->l_auth->is_have_perm('masterdata_admin')){ 
				echo '<input type="checkbox" id="store[LOCK_DATA]" name="store[LOCK_DATA]" value="1">Lock &nbsp;';
			}
			?>
			<?=form_submit($this->config->item('button_submit'), $this->lang->line($this->config->item('button_submit')));?>
			<?=form_button($this->config->item('button_cancel_admin'), $this->lang->line('button_cancel'), "onclick=\"window.location='".site_url('store/browse')."'\"");?>
			
			
		<?php } elseif (@$data['store']['LOCK_DATA']!=1) { ?>	
			<a href="<?php echo base_url();?>store"><img src="<?php echo base_url();?>images/jbtnedit.png" title="Ubah Data Outlet" border="0" /></a>
		<?php } ?>
        </td>
	</tr>
	<tr>
		<td colspan="2" class="space">&nbsp;</td>
	</tr>
</table>
<?=form_close();?>
<?php /*
<?php if ($data['view_mode']==0) { ?>
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
<?php } ?>
<script>
function getMallData(MallCode){
	malldetail.innerHTML = '<img src="<?php echo base_url(); ?>images/loading.gif" border="0" alt="" align="left" />';
    $.get("/building/xmldetail/xml/"+MallCode,function(data,status){
		if (status=='success'){
			malldetail.innerHTML = data;
		}
    });
}


getMallData('<?php echo $data['store']['OUTLET_BUILDING']; ?>');
</script>
*/?>