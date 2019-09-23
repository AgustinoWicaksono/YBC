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
    var elLength = document.frmEOMList.elements.length;

    for (i=0; i<elLength; i++)
    {
        var cktype = document.frmEOMList.elements[i].type;
				var ckname = document.frmEOMList.elements[i].name;
        if (cktype=="checkbox" && ckname.substr(0,6)=="cabang"){
            document.frmEOMList.elements[i].checked = source.checked;
        }
     }
}

//-->
</script>
<?php
$form1 .= ' name="frmEOMList" ';
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<input type="checkbox" onClick="CheckCheckboxes(this)"  /> Pilih semua<br/><hr /><br />
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<td class="column_description">Periode</td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_hidden('periode', $data['periode']);?>
                    <?=form_dropdown('periode', $periodes, $data['periode'], 'class="input_text" disabled="disabled"');?>
					</td>
				</tr>
				<tr>
					<td class="column_description" valign="top">Outlet</td>
					<td class="column_colon">:</td>
                    <td class="column_input">
<?php

	$i = 1;
	foreach ($cabangs as $cabang) {
        $period_type = substr($data['periode'], 0, strlen($data['periode'])-6);
        $periode = $this->l_general->rightstr($data['periode'],6);
        $cabang_proses = $this->m_endofmonth->endofmoth_exists($period_type,$periode,$cabang['HR_CODE']);
		echo form_checkbox('cabang['.$i++.']', $cabang['HR_CODE'], $cabang_proses, $cabang['HR_CODE'])."<br />";

	}

?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note">
			<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  
			<a href="javascript:document.form1.reset()" title="Reset"><img src="<?php echo base_url();?>images/jbtnreset.png" border="0" alt="Reset"></a> 
		</td>
	</tr>
</table>
<?=form_close();?>
