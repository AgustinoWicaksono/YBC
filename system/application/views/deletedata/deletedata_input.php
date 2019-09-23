<?php 
//print_r($this->session->userdata['ADMIN']); 

?>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>

<?=form_open($this->uri->uri_string(), $form);
?>
<div style="padding:17px;">

	<?=validation_errors('<div class="error">','</div>'); ?>

					
	Silahkan masukkan <b>POSTING DATE</b> di bawah ini.<br />Teliti kembali sebelum melanjutkan.<br /><br />
	<div style="float:left;width:300px;">
	<strong>Posting Date</strong>: <?=form_input('delete_date', $data['delete_date'], 'class="input_text" size="10" readonly="readonly"');?>
	<script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'delete_date'
					});
	</script>
	<br /><br />
	Pilih salah satu metode<br />(lihat penjelasan di sebelah kanan):<br /><br />
	<input type="radio" name="delete_option" id="delete_option" value="reset" checked /> Reset Data<br>
	<input type="radio" name="delete_option" id="delete_option" value="delete" /> Hapus Data<br>
	<br /><br />
	<input type="checkbox" name="delete_confirmation" id="delete_confirmation" /> <strong style="color:#aa1122;">Saya setuju melakukan ini setelah membaca penjelasan di bagian kanan halaman ini</strong>
	<br />
	
	<br /><br />
	<div style="float:right;margin-right:100px;">
	&nbsp; <?=form_submit($this->config->item('button_submit'), $this->lang->line('button_submit'));?>
	</div>
	</div>
	
	<div style="float:left;border-left:#778899 1px solid;padding:10px;">
	<b>Catatan:</b><br />
	<h2>Reset Data Stock Opname</h2>
	<b>Tujuan:</b> Data yang dimasukkan outlet sudah benar, tapi data yang masuk ke SAP salah, maka perlu reset data.<br />
	Reset data akan melakukan proses berikut ini (hanya di Web dan bukan di SAP):<ul>
	<li>Mengembalikan status Stock Opname menjadi belum Approved</li>
	<li>Mengembalikan status Waste menjadi belum Approved</li>
	<li>Mengembalikan status EOD menjadi belum End of Day</li>
	<li>Data stock opname dan waste tetap ada seperti yang telah di-input</li>
	</ul>
	
	<h2>Hapus Data Stock Opname</h2>
	<b>Tujuan:</b> Data yang dimasukkan outlet salah, maka perlu hapus data.<br />
	Hapus data akan melakukan proses berikut ini (hanya di Web dan bukan di SAP):<ul>
	<li>Hapus seluruh data Opname pada tanggal yang dipilih</li>
	<li>Mengembalikan status Waste menjadi belum Approved</li>
	<li>Mengembalikan status EOD menjadi belum End of Day</li>
	</ul>

	<br /><br />Jika Anda setuju, silahkan tekan tombol submit.
	</div>
	
	<div style="clear:both"></div><br /><hr />    <?=anchor('/', $this->lang->line('button_back'));?>

<?=form_close();?>
</div>