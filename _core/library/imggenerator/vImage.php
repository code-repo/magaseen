<?php
//ob_start();
class vImage
{
	var $numChars = 3;
	var $w;
	var $h = 80;
	var $colBG = "255 220 131";
	var $colTxt = "153 0 0";
	var $colBorder = "0 128 192";
	var $charx = 30;
	var $numCirculos = 10;
	
	function vImage()
	{
		#session_start();
	}
	
	function gerText($num)
	{
		if (($num != '')&&($num > $this->numChars)) 
			$this->numChars = $num;		
		$this->texto = $this->gerString();
		$_SESSION['vImageCode'] = $this->texto;
	}
	
	function loadCodes()
	{
		$this->postCode = $_POST['vCaptcha'];		
		$this->sessionCode = $_SESSION['vImageCode'];
	}
	
	function checkCode()
	{
/*		if (isset($this->postCode)) $this->loadCodes();
		if ($this->postCode == $this->sessionCode)*/		
		if (isset($_REQUEST['vCaptcha']))
			$this->loadCodes();
		if ($_REQUEST['vCaptcha'] == $this->sessionCode)
			return true;
		else
			return false;
	}
	
	function showCodBox($mode=0,$extra='')
	{
		$str = "<input type=\"text\" name=\"vCaptcha\" ".$extra." > ";
		if ($mode)
			echo $str;
		else
			return $str;
	}
	
	function showImage(){
		$this->gerImage();		
		header("Content-type: image/jpeg");
		ImageJpeg($this->im);
	}
	
	function gerImage()
	{
		$this->w = ($this->numChars*$this->charx) + 40;
		$this->im=@imagecreatefromjpeg("form_clip_image001.jpg"); 
		$ident = 25;
		for ($i=0;$i<$this->numChars;$i++)
		{
			$char = substr($this->texto, $i, 1);
			$font="verdana.ttf";
			$y = round(($this->h-10)/2);
			$t = rand(2,20);
			$size=rand(20,25);
			$col = $this->getColor($this->colTxt);
			if (($i%2) == 0)
			{
				imagettftext($this->im, $size, 0, $ident, $y+$t, $grey, $font, $char);
			}else
			{
				imagettftext($this->im, $size, 10, $ident, $y+$t, $grey, $font, $char);
			}
			$ident = $ident+(rand (30, 40));;
		}
	}
	
	function getColor($var)
	{
		$rgb = explode(" ",$var);
		$col = imagecolorallocate ($this->im, $rgb[0], $rgb[1], $rgb[2]);
		return $col;
	}
	
	function gerString()
	{
		rand(0,time());
		$possible="AHLFTDSKNPRVY24579";
		while(strlen($str)<$this->numChars)
		{
			$str.=substr($possible,(rand()%(strlen($possible))),1);
		}
		$txt = $str;
		return $txt;
	}
} 
?>