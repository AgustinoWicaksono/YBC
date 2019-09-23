<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form);?>
<table class="table-no-border">
	<tr>
		<td colspan="4" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td>
        <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?>
		<br />
			<table class="table-section">
				<tr>
					<td class="table_field_1">Outlet Aktif Saat ini</td>
					<td class="table_field_1">:</td>
					<td class="column_input"><b><?php echo $this->session->userdata['ADMIN']['plant_name'];?></b> &mdash; <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
				</tr>
				<tr>
					<td class="table_field_1">Pilihan Outlet</td>
					<td class="table_field_1">:</td>
					<td class="column_input">

					<?=form_dropdown('plant', $plant, $data['plant'], ' data-placeholder="Pilih cabang..." class="chosen-select" style="width:350px;" tabindex="2" ');?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="column_description_note">
        <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>
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
</script>