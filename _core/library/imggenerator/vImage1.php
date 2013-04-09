<? 
class vImage{
	var $numChars = 3;
	var $w;
	var $h = 80;
	var $colBG = "255 220 131";
	var $colTxt = "0 0 0";
	var $colBorder = "0 128 192";
	var $charx = 20;
	var $numCirculos = 10;
	

	function vImage(){
		session_start();
	}
	function gerText($num){
		if (($num != '')&&($num > $this->numChars)) $this->numChars = $num;		
		$this->texto = $this->gerString();
		$_SESSION['vImageCode'] = $this->texto;
	}
	function showImage(){
		$this->gerImage();		
		header("Content-type: image/jpeg");
		ImageJpeg($this->im);
	}
	function gerImage(){
		$this->w = ($this->numChars*$this->charx) + 40;
		$this->im=@imagecreatefromjpeg("rose02.jpg"); 
	//	$this->im = imagecreatetruecolor($this->w, $this->h); 
		//imagefill($this->im, 0, 0, $this->getColor($this->colBorder));
		//imagefilledrectangle ( $this->im, 1, 1, ($this->w-2), ($this->h-2), $this->getColor($this->colBG) );

		
	/*	for ($i=1;$i<=$this->numCirculos;$i++) {
			$randomcolor = imagecolorallocate ($this->im , rand(100,255), rand(100,255),rand(100,255));
			imageellipse($this->im,rand(0,$this->w-10),rand(0,$this->h-3), rand(20,60),rand(20,60),$randomcolor);
		}*/
		$ident = 25;
		for ($i=0;$i<$this->numChars;$i++){
			$char = substr($this->texto, $i, 1);
			$font = rand(10,12);
			$y = round(($this->h-35)/2);
			$z = rand(15,25);
			$t = rand(5,9);
			$col = $this->getColor($this->colTxt);
			if (($i%4) == 0){
				imagechar ( $this->im, $font, $ident, $y+$t, $char, $col );
			}else{
				imagechar ( $this->im, $font, $ident, $y+$z, $char, $col );
			}
			$ident = $ident+$this->charx;
		}
	}
	function getColor($var){
		$rgb = explode(" ",$var);
		$col = imagecolorallocate ($this->im, $rgb[0], $rgb[1], $rgb[2]);
		return $col;
	}
	function gerString(){
		rand(0,time());
		$possible="AGHIPSUNFKQTVLY624579";
		while(strlen($str)<$this->numChars)
		{
			$str.=substr($possible,(rand()%(strlen($possible))),1);
		}
		$txt = $str;
		return $txt;
	}
} 
?>