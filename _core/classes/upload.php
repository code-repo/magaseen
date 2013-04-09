<?php
class FileUpload 
{
	var $source;
	var $target;
	
	function upload($overwrite=false)
	{
		if($overwrite)
		{
			copy($this->source, $this->target); 
		}
		else
		{
			$file_ext = substr(basename($this->target), strrpos(basename($this->target),"."));
			$dir_path = dirname($this->target);
			$base_name = basename($this->source);
			if(file_exists($this->target))
			{
				$this->target = $dir_path."/".substr($base_name,0,-4).time().$file_ext;
			}
			if(!file_exists($this->target))
				copy($this->source, $this->target); 
		}
		return basename($this->target);
	}

	function deleteFile()
	{
		if(file_exists($this->source))
			return unlink($this->source);
		else
			return false;
	}
}
?>