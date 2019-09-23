<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_perm', $this->session->userdata('lang_name'));
$this->lang->load('g_admin', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('group_id', $data['group_id']);?>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space"><a href="javascript:history.go(-1)"><?=$this->lang->line('back');?></a></td>
	</tr>
<?php
if(!empty($_POST)) :
?>
	<tr>
		<td colspan="3"><?=validation_errors('<div><font color="#FF0000">','</font></div>'); ?></td>
	</tr>
<?php
endif;

if(isset($reset) && $reset == 1) :
?>
  <tr> 
    <td colspan="2"><font color="#0000FF"><b><?=$this->lang->line('perm_group_perm_added');?></b></font></td>
  </tr>
<?php
endif;
?>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<td class="column_description"><?=$this->lang->line('perm_group_name');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_input('group_name', $data['group_name'], 'class="input_text"');?></td>
				</tr>
<?php if($perms !== FALSE) : ?>
				<tr>
					<td class="column_description"><?=$this->lang->line('perm_perms');?></td>
					<td class="column_colon">:</td>
					<td class="column_input">
<?php
// $i and $j variables used for shown permission category

$i = 0;
foreach ($perms->result_array() as $perm) {
	$j = $perm['cat_id'];
		
	if($j != $i) {
		if($i != 0) echo "<br />";
		echo "<strong>".$this->lang->line('perm_opt_category_'.$perm['category_name'])."</strong>\n<br />";
	}

	if($new == 1) {
		if($perm['perm_default'] == 1) {
			$perm_content = 1;
		} else {
			$perm_content = 0;
		}
	} else {
//		echo '$data["group_perms"] = '.$data['group_perms']."<br />";
//		echo '$perm["perm_code"] = '.$perm['category_code'].sprintf("%02s", $perm['perm_code'])."<br />";
		if(substr_count($data['group_perms'], $perm['category_code'].sprintf("%02s", $perm['perm_code']))) {
			$perm_content = 1;
		} else {
			$perm_content = 0;
		}
	}	
	echo form_checkbox('perm['.$perm['cat_id'].'_'.$perm['perm_order_id'].']', $perm['category_code'].sprintf("%02d", $perm['perm_code']), $perm_content, $this->lang->line('perm_opt_'.$perm['perm_name']), 'id=perm[]')."<br />";

	$i = $j;
}
?></td>
				</tr>
<?php endif; ?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note">
        <?=form_submit('submit', $this->lang->line('button_save'));?>
        <?=form_reset('reset', $this->lang->line('button_reset'));?>
        <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), "onclick=\"window.location='".site_url('perm/group_browse')."'\"");?></td>
	</tr>
</table>
<?=form_close();?>