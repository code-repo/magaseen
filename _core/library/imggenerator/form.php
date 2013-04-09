<?
include("vImage.php");
$vImage = new vImage();	
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="form1" method="post" action="verify.php">
<img src="img.php?size=5"><br>
 <?
	$vImage->showCodBox(1);
?>
<input type="submit" name="Submit" value="Send">
</form>
</body>
</html>