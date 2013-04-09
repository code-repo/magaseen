<?php
class ImageComponent
{
	var $controller;
	var $ImageFile;				// location of an image file saved on the server.
	var $ImageContents;		// Contents of an image in a variable.
	var $Width;      				// width (or max width) of image to output
	var $Height;      				// height (or max height) of image to output
	var $Err;							// error if (and when) they occur
	var $InternalImage;			// Internal variable for working with the image

	//Function to upload image
	function SaveImageAs($destination,$resize=false) {
		/*$extrastring="product_".rand(1,100).substr(md5(time()),8,3);
		//If file already exists then change destination file name
		if(file_exists($destination) && is_file($destination)){
			$dirName=dirname($destination);
			$basename=substr(basename($destination),0,strrpos(basename($destination),"."));
			$baseext=substr(basename($destination),strrpos(basename($destination),"."));
			$destination=$dirName."/".$basename."_".$extrastring.$baseext;
		}*/

		$extrastring="image_".rand(1,100).substr(md5(time()),8,3);
		//If file already exists then change destination file name

		$dirName=dirname($destination);
		$basename=substr(basename($destination),0,strrpos(basename($destination),"."));
		$baseext=substr(basename($destination),strrpos(basename($destination),"."));
		$basename=$this->replaceSpecial($basename);
		$destination=$dirName."/".$basename.$baseext;

		if(file_exists($destination) && is_file($destination)){

			$dirName=dirname($destination);
			$basename=substr(basename($destination),0,strrpos(basename($destination),"."));
			$baseext=substr(basename($destination),strrpos(basename($destination),"."));
			$basename=$this->replaceSpecial($basename);
			$destination=$dirName."/".$basename."_".$extrastring.$baseext;

		}

		if($this->ProcessImage($destination,$resize))
		{
			if (!$handle = fopen($destination, 'w+')){
			$this->Err = 'Cannot open file (' . $destination . ')';
			return false;
			}else {
				if(fwrite($handle, $this->InternalImage) === FALSE){
					$this->Err = 'Cannot write to file';
					return false;
				}
				fclose($handle);
				return basename($destination);

			}
		}else{
			return false;
		}
	}

	function GetImageContents(){
		return $this->InternalImage;
	}

	// process Image
	function ProcessImage($destination,$resize){

		//Check if file is uploaded or not
		/* if(!is_uploaded_file($this->ImageFile)){
			return false;
		} */



		//Processes the image. Resize if needed. fills the internal image with the contents of the changed image.
		//Internal function
		if (strlen($this->ImageFile) > 0){

    		if (file_exists($this->ImageFile)){
				//load it!
				$data = getimagesize($this->ImageFile); //[0] = w, [1] = h, [2] = type, [3] = attr

				switch ($data[2]){
					case 1:
						$tmp_image = imagecreatefromgif($this->ImageFile);
						break;
					case 2:
						$tmp_image = imagecreatefromjpeg($this->ImageFile);
						break;
					case 3:
						$tmp_image = imagecreatefrompng($this->ImageFile);
						break;
					default:
						$this->Err = 'File is not a valid image type';
						return false;
						exit;
						break;
				}
			}else{
			$this->Err = 'File "' . $this->ImageFile . '" does not exist!';
			return false;
			}
			//END LOAD FROM FILE
		}
		else
		{
			$this->Err = 'No image was loaded, use ImageFile, ImageContents or ImageField before output';
			return false;
			exit;
		}

		//If no resiging is selected
		if(!$resize){
			//move_uploaded_file($this->ImageFile,$destination);
			copy($this->ImageFile,$destination);
			return  $destination;
		}

		// upload image size
		$FullImage_width = imagesx ($tmp_image);
		$FullImage_height = imagesy ($tmp_image);

		// default size [output image size]
		$max_width	  = $this->Width;
		$max_height	  = $this->Height;

		$size= $this->scale($this->ImageFile, $this->Width, $this->Height);

		$new_width 	= $size['width'];
		$new_height = $size['height'];

		$new_photo= imagecreatetruecolor( $new_width , $new_height );
		imagecopyresampled ($new_photo, $tmp_image, 0,0,0,0, $new_width, $new_height, $FullImage_width, $FullImage_height);
		$tmp_image=$new_photo;

		$new_photo = imagecreatetruecolor($this->Width, $this->Height);
		$white = ImageColorAllocate($new_photo, 255, 255,255);
		ImageFilledRectangle($new_photo, 0, 0, $this->Width, $this->Height, $white);
		$insertWidth  = imagesx($tmp_image);
		$insertHeight = imagesy($tmp_image);
		$imageWidth   = imagesx($new_photo);
		$imageHeight  = imagesy($new_photo);

		$overlapX = ($imageWidth-$insertWidth)/2;
		$overlapY = ($imageHeight-$insertHeight)/2;

		$opacity = 100;
		ImageCopyMerge($new_photo, $tmp_image, $overlapX, $overlapY, 0, 0, $new_width, $new_height, $opacity);
		ob_start();
		imagejpeg($new_photo);
		$this->InternalImage = ob_get_contents();
		ob_end_clean();
		return true;
		# end new code
		//END SNAPSHOT
	}

	function scale($img,$maxwidth,$maxheight) {
		$imginfo = getimagesize($img);
		$imgwidth = $imginfo[0];
		$imgheight = $imginfo[1];
		if($imgwidth> $maxwidth) {
		$ration = $maxwidth/$imgwidth;
		$newwidth = round($imgwidth*$ration);
		$newheight = round($imgheight*$ration);
		if ($newheight> $maxheight) {
		$ration = $maxheight/$newheight;
		$newwidth = round($newwidth*$ration);
		$newheight = round($newheight*$ration);
		return array("image" => $img, "width" => $newwidth, "height" => $newheight);
		} else {
		return array("image" => $img, "width" => $newwidth, "height" => $newheight);
		}
		} else if ($imgheight> $maxheight) {
		$ration = $maxheight/$imgheight;
		$newwidth = round($imgwidth*$ration);
		$newheight = round($imgheight*$ration);
		if ($newwidth> $maxwidth) {
		$ration = $maxwidth/$newwidth;
		$newwidth = round($newwidth*$ration);
		$newheight = round($newheight*$ration);
		return array("image" => $img, "width" => $newwidth, "height" => $newheight);
		} else {
		return array("image" => $img, "width" => $newwidth, "height" => $newheight);
		}
		} else {
		return array("image" => $img, "width" => $imgwidth, "height" => $imgheight);
		}
	}

	/*
		Function to delete existing file
		@parm1 File with full path
	*/
	function deleteFile($file){
		if(!isNull($file)){
			if(is_file($file) && file_exists($file)){
				unlink($file);
			}
		}
	}//EF

	function replaceSpecial($name=null)
	{
		$new_name=$this->ImageFile;
		$special_chars = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*"," ","-","+","=");

		$new_name = str_replace($special_chars, "", $name);
		//$this->ImageFile=$new_name;
		return $new_name;

	}
}
?>