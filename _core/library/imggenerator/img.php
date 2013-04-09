<?php
session_start();
include("vImage.php");
$vImage = new vImage();
$vImage->gerText($_GET['size']);
$vImage->showimage();
?>