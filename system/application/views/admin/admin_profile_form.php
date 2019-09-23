<script language="javascript" type="text/javascript">
<!--
function toggle_visibility(id) {
	var e = document.getElementById(id);
		if(e.style.display == '')
			e.style.display = 'none';
		else
			e.style.display = '';
}


function CheckCheckboxes(source){
    var elLength = document.frmPlantList.elements.length;

    for (i=0; i<elLength; i++)
    {
        var cktype = document.frmPlantList.elements[i].type;
				var ckname = document.frmPlantList.elements[i].name;
        if (cktype=="checkbox" && ckname.substr(0,8)=="plant_id"){
            document.frmPlantList.elements[i].checked = source.checked;
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
<input type="checkbox" onClick="CheckCheckboxes(this)"  /> Toggle All<br/><hr /><br />
<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('admin[admin_id]', $this->uri->segment(3));?>
<table class="table-no-border" width="1000">
	<tr>
		<td width="272" colspan="4" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td class="table_field_1">Jenis Outlet</td>
		<td class="table_field_1">:</td>
		<td class="column_input"><?=form_hidden('plant_type_id', $plant_type['id_jenisoutlet']);?><?=$plant_type['jenisoutlet'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_username');?></td>
		<td class="table_field_1">:</td>
		<td class="column_input"><?php if($uri_segment2 == 'input2')
	echo form_input('admin[admin_username]', $data['admin']['admin_username'], 'class="input_text"').' '.$this->lang->line('note1');
else
	echo $data['admin']['admin_username'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_realname');?></td>
		<td class="table_field_1">:</td>
		<td class="column_input"><?=form_input('admin[admin_realname]', $data['admin']['admin_realname'], 'class="input_text"');?> <?=$this->lang->line('note1');?></td>
	</tr>
	<tr>
		<td class="table_field_1">Plant Terdaftar</td>
		<td class="table_field_1">:</td>
		<td class="column_input">
		
<?php
			$tokos = Array();
	sort($plants);
    	foreach ($plants as $plant) {
    		if($data['plant_id']) {
    			foreach($data['plant_id'] as $plant_id) {
    				if($plant['plant'] == $plant_id) {
    					$toko = $plant['plant_name2'];
							$toko = 	str_replace("BT ","",$toko);
							$tokos[] = $toko;
    					break;
    				}
    			}
    		}
			}
sort($tokos);
echo "<b>".count($tokos)." plants</b><br />";
foreach ($tokos as $key => $val) {
    echo $val .", ";
}			
?>		
		</td>
	</tr>

<?php if($uri_segment2 == 'input2') : ?>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_password');?></td>
		<td class="table_field_1">:</td>
		<td class="column_input"><?=form_password('admin_password', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
	<tr>
		<td class="table_field_1"><?=$this->lang->line('admin_password_confirm');?></td>
		<td class="table_field_1">:</td>
		<td class="column_input"><?=form_password('admin_password_confirm', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
<?php endif; // if($uri_segment2 == 'input') : ?>

<?php if($plants !== FALSE) : ?>
	<tr>
		<td class="table_field_1" valign="top">Pilihan Plant</td>
		<td class="table_field_1">:</td>
		<td class="column_input">


		
<?php
	$i = 1; // number of permission group
	sort($plants);
    	foreach ($plants as $plant) {
    		$plant_content[$i] = FALSE;
    		if($data['plant_id']) {
    			foreach($data['plant_id'] as $plant_id) {
    				if($plant['plant'] == $plant_id) {
    					$plant_content[$i] = TRUE;
    					break;
    				}
    			}
    		}

    //		echo form_checkbox('plant_id['.$i.']', $plant['plant'], $plant_content[$i], $plant['plant_name']."<br />");
//    		echo form_checkbox('plant_id['.$i.']', $plant['plant'], $plant_content[$i], $plant['plant']."-".$plant['plant_name']."<br />");
    		echo form_checkbox('plant_id['.$i.']', $plant['plant'], $plant_content[$i], $plant['plant']."-".$plant['plant_name']." (".$plant['plant_name2'].")<br />", ' class="plantlist" ' );
//			$checkplant = !empty($plant_content[$i]) ? ' checked="checked"' : '';
//		echo '<label for="plant_id['.$i.']"><input type="checkbox" name="plant_id['.$i.']" id="plant_id['.$i.']" value="'.$plant['plant'].'" '.$checkplant.'  />'.$plant['plant']."-".$plant['plant_name']." (".$plant['plant_name2'].')</label>'."<br />\r\n";
    		$i++;
    	}
?>

	</td>
	</tr>
<?php endif; ?>

<?php if($perm_groups !== FALSE) : ?>
	<tr>
		<td width="170" class="table_field_1" valign="top"><?=$this->lang->line('perm_group_name');?></td>
		<td width="10"class="table_field_1">:</td>
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
		<td colspan="4" class="space"><?=$this->lang->line('note1');?> <?=$this->lang->line('note_required');?><br /><?php if($uri_segment2 == 'input') echo $this->lang->line('note2').' '.$this->lang->line('note_password');?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="column_description_note">
        <?=form_submit($this->config->item('button_submit'), $this->lang->line($this->config->item('button_submit')));?>
        <?=form_reset('reset', $this->lang->line('button_reset'));?>
        <?=form_button($this->config->item('button_cancel_admin'), $this->lang->line('button_cancel'), "onclick=\"window.location='".site_url('admin/browse')."'\"");?>
        </td>
	</tr>
</table>
<?=form_close();?>