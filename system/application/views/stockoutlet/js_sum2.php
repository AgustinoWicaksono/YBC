<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<script language="javascript">
function changeVal(obj, number) {
	var x = 'stock_detail[qty1]['+number+']';
	var y = 'stock_detail[qty2]['+number+']';
	var z = 'stock_detail[total]['+number+']';
	var num = 0;
	var result = 0;

	if(obj.form.elements[x].value == '') {
		obj.form.elements[z].value = '';
	} else if(obj.form.elements[y].value == '') {
		obj.form.elements[z].value = '';
	} else {
		num = parseFloat(obj.form.elements[x].value) + parseFloat(obj.form.elements[y].value) ;
		result = num.toFixed(2);
		obj.form.elements[z].value = result;
	}
}
</script>
</body>
<form name="data">
<table border="1">
<?php
for($i = 1; $i <= 10; $i++) {
?>
  <tr>
    <td><input type="text" name="stock_detail[qty1][<?=$i;?>]" onChange="changeVal(this, <?=$i;?>)" /></td>
    <td><input type="text" name="stock_detail[qty2][<?=$i;?>]" onChange="changeVal(this, <?=$i;?>)" /></td>
    <td><input type="text" name="stock_detail[total][<?=$i;?>]" disabled="disabled" /></td>
  </tr>
<?php
}
?>
</table>
</form>

</html>
