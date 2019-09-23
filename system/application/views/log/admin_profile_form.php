<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <style>
.ui-autocomplete-loading {
background: white url('<?=base_url();?>images/ui-anim_basic_16x16.gif') right center no-repeat;
}
</style>
<script>
$(function() {
function showNama( message, valueid, email, realnama, username ) {
$( "<div>" ).text( 'Karyawan: '+message ).replaceAll( "#niklog" );
$('input[name=admin_emp_id]').val(valueid);
$('input[name=admin_email]').val(email);
$('input[name=admin_realname]').val(realnama);
$('input[name=admin_username]').val(username);
}
$( "#data_nik" ).autocomplete({
source: "<?=base_url();?>monitor/search-nik.php",
minLength: 2,
select: function( event, ui ) {
showNama( ui.item.label , ui.item.id, ui.item.email, ui.item.empname, ui.item.username );

}
});
});
</script>


<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php 
	$def_ck_style = 'float:left;width:30%;font-size:80%;';
	$def_ckall_style = 'pointer-events:none; opacity: 0.5;background: #CCC;';
//	$def_ckall_style = 'disabled: true;opacity: 0.5;background: #CCC;';
  
?>
<style>
.def_ck_style {float:left;width:30%;font-size:80%;}
.def_ckall_style {pointer-events:none; opacity: 0.5;background: #CCC;}
</style>

<link href="<?=base_url();?>css/simpletabs.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?=base_url();?>js/simpletabs.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">
<!--
function toggle_visibility(id) {
	var e = document.getElementById(id);
		if(e.style.display == '')
			e.style.display = 'none';
		else
			e.style.display = '';
}


function CheckCheckboxes(source,kodeplant){

    var elLength = document.frmPlantList.elements.length;

    for (i=0; i<elLength; i++)
    {
        var cktype = document.frmPlantList.elements[i].type;
		var ckname = document.frmPlantList.elements[i].name;
        if ((cktype=="checkbox") && (ckname.indexOf(kodeplant)==0)){
            document.frmPlantList.elements[i].checked = source.checked;
        }
            
    }
	
	for (i=1; i<7; i++)
	{
		if (source.checked) {
			document.getElementById(kodeplant+"_Col"+i+"]").className = "def_ck_style def_ckall_style";
		} else {
			document.getElementById(kodeplant+"_Col"+i+"]").className = "def_ck_style";
		}
	}
}

//-->
</script>

<?php
$uri_segment2 = $this->uri->segment(2);
$uri_segment3 = $this->uri->segment(3);
$form .= ' name="frmPlantList" ';
// $form .= ' id="frmPlantList" ';
?>
<div align="center" class="page_title"><?=$page_title;?></div>

<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('admin[admin_id]', @$this->uri->segment(3));?>
<table class="table-no-border" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
<?php /*	
	<tr>
		<td class="table_field_1">Jenis Outlet</td>
		<td class="column_input"><?=form_hidden('plant_type_id', $plant_type['id_jenisoutlet']);?><?=$plant_type['jenisoutlet'];?></td>
	</tr>
*/ ?>	
	<tr>
		<td class="table_field_1">NIK</td>
		<td class="column_input">
			<div class="ui-widget">
				<?=form_input('data_nik', $data['admin']['nik'], 'class="input_text" maxlength="50" size="50" ');?> <?=$this->lang->line('note1');?>
			</div>
			<div id="niklog">
			<?php if ($data['admin']['nik']=='') { echo 'NIK karyawan wajib diisi'; } else { ?>
			Karyawan: <?php echo $data['admin']['nama'].' - '.$data['admin']['nik']. ' ('.$data['admin']['divisi'].')'; } ?>
			</div>
			<?php echo form_hidden('admin_emp_id', $data['admin']['admin_emp_id']); ?>
		</td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_username');?></td>
		<td class="column_input"><?php if($uri_segment2 == 'input')
	echo form_input('admin_username', $data['admin']['admin_username'], 'class="input_text" maxlength="50" size="50" ').' '.$this->lang->line('note1');
else
	echo $data['admin']['admin_username'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_realname');?></td>
		<td class="column_input"><?=form_input('admin_realname', $data['admin']['admin_realname'], 'class="input_text" maxlength="50" size="50" ');?> <?=$this->lang->line('note1');?></td>
	</tr>
	<tr>
		<td class="table_field_1">Email</td>
		<td class="column_input"><?=form_input('admin_email', $data['admin']['admin_email'], 'class="input_text" maxlength="50" size="50" ');?> <?=$this->lang->line('note1');?></td>
	</tr>
	<?php /*
	<tr>
		<td class="table_field_1"><strong>Employee</strong></td>
		<td class="column_input"><?=form_dropdown('admin[admin_emp_id]', $employee, $data['admin']['admin_emp_id'], 'class="input_text" ');?></td>
	</tr>
	*/ ?>
	
	<tr>
		<td class="table_field_1">Plant Terdaftar</td>
		<td class="column_input">
		
<?php
echo "<b>".$plant_terpilih_count." plants</b>";
echo "<hr />".$plant_terpilih;
?>



		</td>
	</tr>

<?php if($uri_segment2 == 'input') : ?>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_password');?></td>
		<td class="column_input"><?=form_password('admin_password', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_password_confirm');?></td>
		<td class="column_input"><?=form_password('admin_password_confirm', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
<?php endif; // if($uri_segment2 == 'input') : ?>

<?php if($plants !== FALSE) : ?>
	<tr>
		<td class="table_field_1" valign="top">Pilihan Plant</td>
		<td class="column_input">


		
<?php

		if (intval($plant_terpilih_count)< 25){
			$combo_plants = array();
			$combo_plants_selected = array();
			foreach($plants as $plant=>$value){
				unset($plant_list);
				$plant_list = $plants[$plant];
				$comp_code = $plant;
				
				foreach($plant_list as $outlet=>$value){
					$combo_plants[$comp_code.'_'.$outlet] = $plant_list[$outlet]['plant_code'].' - '.$plant_list[$outlet]['plant_name'].' ('.$outlet.')';
					if (intval($plant_list[$outlet]['is_selected'])==1) $combo_plants_selected[$comp_code.'_'.$outlet] = $comp_code.'_'.$outlet;
				}
			}
			echo form_dropdown('comboPlant', $combo_plants, $combo_plants_selected, ' placeholder_text_multiple="Pilih salah satu atau lebih cabang..." class="chosen-select" style="width:750px;" tabindex="3"  multiple tabindex="3" ');
			echo '<br /><br /><span style="color:#aa1122;font-style:italic;font-size:120%;">------- OR -------</span><br /><br />';
		}

?>

			
		  <div class="simpleTabs">
		    <ul class="simpleTabsNavigation">
				<?php
					foreach($plant_type as $plant=>$value){
						echo '<li><a href="#" style="font-size:90%;">'.$plant_type[$plant].'</a></li>';
					}
				?>
		    </ul>
				<?php
					
					
					foreach($plants as $plant=>$value){
						echo '<div class="simpleTabsContent">';
						unset($plant_list);
						$plant_list = Array();
						$plant_list = $plants[$plant];
						//print_r($plant_list);die();
						$jumlahdata = count($plant_list);
						echo $jumlahdata.' plants | ';
						echo form_checkbox('ALL['.$plant.']', $plant, $allplant[$plant], 'Semua '.$plant_type[$plant], ' class="plantlist" '."onClick=\"CheckCheckboxes(this,'ckplant[".$plant."')\"" );
						echo '<hr />';
						
						if ($allplant[$plant]==1) {
							$selectallstyle = ' def_ckall_style';
//							$dis_style = ' disabled ';
							$dis_style = ' ';
						} else {
							$selectallstyle = '';
							$dis_style = ' ';
						}
						
						// echo '<input type="checkbox" name="ALL'.$plant.'" id="ALL'.$plant.'" value="ALL'.$plant.'"  class="plantlist"  '."onClick=\"CheckCheckboxes(this,'ckplant_".$plant."')\"".' /> Semua '.$plant_type[$plant].'<hr />';
						
						$jumlahperkolom = ceil($jumlahdata/3);
						
						$countperkolom = 0;
						$n_kolom = 1;
							echo '<div id="ckplant['.$plant.'_Col'.$n_kolom.']" class="def_ck_style'.$selectallstyle.'">';
							foreach($plant_list as $outlet=>$value){
								echo form_checkbox('ckplant['.$plant.'_'.$outlet.']', $outlet, $plant_list[$outlet]['is_selected'], $outlet."-".$plant_list[$outlet]['plant_name']." (".$plant_list[$outlet]['plant_code'].")", ' class="plantlist" '.$dis_style ).'<br />';
								
								$countperkolom++;
								if ($jumlahperkolom==$countperkolom) { 
									$n_kolom++;
									echo '</div><div id="ckplant['.$plant.'_Col'.$n_kolom.']" class="def_ck_style'.$selectallstyle.'">';
									$countperkolom = 0; 
								}
							}
							echo '</div>';
						
						echo '<div style="clear:both;"></div></div>';
					}
				?>			

		  </div>	

	</td>
	</tr>
<?php endif; ?>

<?php if($perm_groups !== FALSE) : ?>
	<tr>
		<td width="170" class="table_field_1" valign="top"><?=$this->lang->line('perm_group_name');?></td>
		<td class="column_input">
<?php

//if($uri_segment3 == 1) {
//	echo $this->lang->line('all');
//} else {
	$i = 1; // number of permission group
	//$number = count($data['perm_group_ids']); // number of member_perm_group_id

	foreach ($perm_groups->result_array() as $perm_group) {
		$perm_content[$i] = FALSE;
		if($data['perm_group_id']) {
			foreach($data['perm_group_id'] as $perm_group_id) {
				if($perm_group['group_id'] == $perm_group_id) {
					$perm_group_id2[$i] = $perm_group_id;
					$perm_content[$i] = TRUE;
					break;
				}
			}
		}

?>
<div id="header[<?=$i;?>]">
<?php
		if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) :
?>
<a href="#header[<?=$i;?>]" onclick="toggle_visibility('detail[<?=$i;?>]');"><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/arrow_down.png" title="<?=$this->lang->line('show_detail');?>" alt="<?=$this->lang->line('show_detail');?>" width="15" /></a>
<?php
		endif;
?>
<?=form_checkbox('perm_group_id['.$i.']', $perm_group['group_id'], $perm_content[$i], $perm_group['group_name']);?> </div> 
<?php
		if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) :
?>
<div id="detail[<?=$i;?>]" style="display:none"><?=$this->l_auth->perm_group_detail_show($perm_group['group_id']);?></div>
<?php
		endif;

		$i++;	
	}
//}
?></td>
	</tr>
<?php endif; ?>
	<tr>
		<td colspan="2" class="space"><?=$this->lang->line('note1');?> <?=$this->lang->line('note_required');?><br /><?php if($uri_segment2 == 'input') echo $this->lang->line('note2').' '.$this->lang->line('note_password');?></td>
	</tr>
	<tr>
		<td colspan="2" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="column_description_note">
        <?=form_submit($this->config->item('button_submit'), $this->lang->line($this->config->item('button_submit')));?>
        <?=form_reset('reset', $this->lang->line('button_reset'));?>
        <?=form_button($this->config->item('button_cancel_admin'), $this->lang->line('button_cancel'), "onclick=\"window.location='".site_url('log/browse')."'\"");?>
        </td>
	</tr>
</table>
<?=form_close();?>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data cabang tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
$(".chosen-select").chosen().change(function() {
//alert('a');
         var cbPlant = document.getElementById('comboPlant');
         var x = 0;
         for (x=0; x < cbPlant.length; x++)
         {
            if (cbPlant[x].selected)
            {
				document.getElementById('ckplant['+cbPlant[x].value+']').checked = true;
            } else {
				document.getElementById('ckplant['+cbPlant[x].value+']').checked = false;
			}
         }
});
</script>