<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<style>
.def_ck_style {float:left;width:30%;font-size:80%;}
.def_ckall_style {pointer-events:none; opacity: 0.5;background: #CCC;}
</style>
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


    var elLength = document.frmWasteReport.elements.length;

    for (i=0; i<elLength; i++)
    {
        var cktype = document.frmWasteReport.elements[i].type;
		var ckname = document.frmWasteReport.elements[i].name;
        if ((cktype=="checkbox") && (ckname.indexOf(kodeplant)==0)){
            document.frmWasteReport.elements[i].checked = source.checked;
        }
            
    }
	

}

//-->
</script>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table border="0" align="left" style="margin:0 10px 10px 25px;" width="80%">
<?php

echo form_open($this->uri->uri_string(), $form1);?>
	<tr><td colspan="2" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td></tr>
	<tr>
		<td colspan="2" align="right">
		<div style="float:left;"><a href="<?php echo base_url();?>rpt_waste/input"><img src="<?php echo base_url();?>images/jbtnreset.png" alt="Back" title="Back" border="0" /></a></div>

		<?=form_submit($this->config->item('button_search'), 'Search');?></td>
	</tr>	
	<tr>
			<td width="150" class="table_field_1">Date</td>
			<td class="column_input">From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'frmWasteReport',
						// input name
						'controlname': 'date_from'
					});

			</script> &nbsp; &nbsp;To <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'frmWasteReport',
						// input name
						'controlname': 'date_to'
					});

					</script>
		</td>
	</tr>
	<tr>
		<td class="table_field_1">Stock Type</td>
		<td class="column_input">
			<input type="radio" name="stock_type" id="stock_type" value="sfg" checked /> SFG &nbsp; &nbsp;
			<?php if ($this->l_auth->is_have_perm('report_waste_detail')) { ?>
			<input type="radio" name="stock_type" id="stock_type" value="detail" /> Detail
			<?php } ?>
			<br />
		
		</td>
	</tr>
	<tr>
		<td class="table_field_1">Report Type</td>
		<td class="column_input">
			<input type="radio" name="report_option" id="report_option" value="screen" checked /> Screen &nbsp; &nbsp;
			<input type="radio" name="report_option" id="report_option" value="excel" /> CSV File (Excel)<br>
		
		</td>
	</tr>
	<tr>
		<td class="table_field_1">Plant</td>
		<td class="column_input">
		<?php
		
			$comp_code=$this->session->userdata['ADMIN']['plant_type_id'];
			$jumlahdata = count($plants);
			$jumlahperkolom = ceil($jumlahdata/3);
			
			$countperkolom = 0;
			$n_kolom = 1;
			echo form_checkbox('ALL['.$comp_code.']', $comp_code, 0, 'Semua '.$comp_code, ' class="plantlist" '."onClick=\"CheckCheckboxes(this,'ckplant[".$comp_code."')\"" );
			echo '<hr />';
			echo '<div id="ckplant['.$comp_code.'_Col'.$n_kolom.']" class="def_ck_style'.$selectallstyle.'">';
			foreach($plants as $outlet=>$value){
				$dataoutlet = $plants[$outlet];
				if (($dataoutlet['COMP_CODE']!=$comp_code) || ($dataoutlet['COMP_CODE']=='1OFFICE')) continue;
				echo form_checkbox('ckplant['.$comp_code.'_'.$dataoutlet['OUTLET'].']', $dataoutlet['OUTLET'], 0, $dataoutlet['OUTLET']." - ".$dataoutlet['OUTLET_NAME2'], ' class="plantlist" '.$dis_style ).'<br />';
				
				$countperkolom++;
				if ($jumlahperkolom==$countperkolom) { 
					$n_kolom++;
					echo '</div><div id="ckplant['.$comp_code.'_Col'.$n_kolom.']" class="def_ck_style'.$selectallstyle.'">';
					$countperkolom = 0; 
				}
			}
			echo '</div>';
			
			echo '<div style="clear:both;"></div></div>';
		?>
		</td>
	</tr>	

</table>
<?php echo form_close(); ?>