<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Base64 encoder/decoder</title>
</head>
<body>
<?php
require_once('convert_class.php');

?>
<form action="index.php" method="post">
<textarea name="input" rows="5" cols="30"></textarea><br/>
<select name="type">
<option value="1">Decode</option>
<option value="2">Encode</option>
</select>
<input type="submit" value="GO"/>
</form>
<?php
if(!empty($_POST['input'])){
	$input = new Converter();
	if($_POST['type']=="1"){
		echo "<textarea name='result' rows=5 cols=30>".htmlspecialchars($input->Base64Decode($_POST['input']))."</textarea>";
	}
	if($_POST['type']=="2"){
		echo "<textarea name='result' rows=5 cols=30>".htmlspecialchars($input->Base64Encode($_POST['input']))."</textarea>";
	}
}else{
	echo "<textarea name='result' rows=5 cols=30></textarea>";
	
}
?>
</body>
</html>