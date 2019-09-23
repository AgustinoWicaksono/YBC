<head>
<title>Load AJAX</title>
<script src="<?=base_url();?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#nim").keyup(function(){
		nim_val = $('#nim').val();
/*
		nim_length =  nim_val.length;		
		
		if (nim_length == 3) {
			$.post("ajax/getname",{nim:nim_val},function(data){
				$('#ajaxName').html(data);
			});     
        }							  
*/
		$.post("ajax/getname",{nim:nim_val},function(data){
			$('#ajaxName').html(data);
		});     
	});
});
</script>
</head>

<body>
<?php
if(isset($_POST)) {
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
}
?>
<form name='myForm' method="post" action="">
Masukkan NIM : <input type="text" name="nim" id="nim" />
<br />
Nama : <span id='ajaxName'></span>
<br />
Kelas : <input type="text" name="kelas" id="kelas" />
<input type="submit">
</form>

</body>
</html>