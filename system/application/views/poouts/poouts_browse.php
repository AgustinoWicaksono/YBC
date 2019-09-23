<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<!--td colspan="5" align="center"><?php //$this->pagination->create_links();?></td-->
</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<th class="table_header_1">No</th>
                    <th class="table_header_1">PO No</th>
					<th class="table_header_1">Entry No </th>
				</tr>
<?php
if($data['poouts'] !== FALSE) :
	$i = 1;
	foreach ($data['poouts']->result_array() as $poouts):
?>
				<tr>
				<?php
				mssql_connect("192.168.0.20","sa","abc123?");
				mssql_select_db("MSI");
				$tampil=mssql_fetch_array(mssql_query("SELECT SeriesName + RIGHT('00000' + CONVERT(varchar, A.DocNum), 5) AS NO_PO FROM OPOR A
				JOIN NNM1 B ON A.Series=B.Series WHERE A.Docentry='$poouts[EBELN]'"));
				?>
					<td class="table_content_1" width="200"><?=$i++;?></td>
                    <td class="table_content_1" width="600"><?=$tampil['NO_PO'];?></td>
					<td class="table_content_1" width="150"><?=$poouts['EBELN'];?></td>
				</tr>
<?php
	endforeach;
endif;
?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
</table>
