<?
include("vImage.php");
$vImage = new vImage();
$vImage->loadCodes();
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
	  <?
	  	 $vImage->postCode;
	     if($vImage->checkCode())
		 {
			echo "Valid Code!<br>";
				}else{
			echo "Wrong Code!<br>";
		}
		?>
</body>
</html>