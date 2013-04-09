<?php
class c_CommomFunctions
{
	function __construct()
	{}

	#Force download file.
	function m_ForceFileDownload($filename) 
	{
	  
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
	 
		if( $filename == "" ) 
		{
				echo "<html><title>Download Script</title><body>ERROR: Download file not specified.</body></html>";
				exit;
		}
		elseif ( ! file_exists( $filename ) ) 
		{
				echo "<html><title>eLouai's Download Script</title><body>ERROR: File not found.</body></html>";
				exit;
		};
	 

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-Type: $filename");
		// added quotes to allow spaces in filenames
		header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename));
		readfile("$filename");
		exit();
	}#END function mForceFileDownload($data, $name, $mimetype='', $filesize=false) 

	#Function to validate email address
	function m_ValidateEmail($stEmail)
	{
		$stEmailRegExp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
		if(!eregi($stEmailRegExp,$stEmail) || eregi("MIME-Version: ",$stEmail) || eregi("To:",$stEmail) || eregi("Subject:",$stEmail) || eregi("Cc:",$stEmail) || eregi("Bcc:",$stEmail))
		{	
	   			return false;			
		}
		else
		{	
			return true;
		}    		
	}
}
?>