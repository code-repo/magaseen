function trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}

// Function to compare dates
function compareDates(dt1,dt2)
{	
	var datepart1 = dt1.split("/");
	var datepart2 = dt2.split("/");
		
	for(i=0;i<datepart1.length;i++)
	{
		datepart1[i] = parseInt(parseFloat(datepart1[i]));
		datepart2[i] = parseInt(parseFloat(datepart2[i]));		
	}	
	
	if(datepart1[2] > datepart2[2])
		return 1;
	else if(datepart1[2] < datepart2[2])	 
		return -1;
	else if(datepart2[2] == datepart1[2])	 	
	{
		if(datepart1[1] > datepart2[1])
			return 1;
		else if(datepart1[1] < datepart2[1])	
			return -1;
		else if(datepart1[1] == datepart2[1])					 
		{
			if(datepart1[0] > datepart2[0])
				return 1;
			else if(datepart1[0] < datepart2[0])	
				return -1;			
		}
	}
	return 0;	
}

function checkForCurrentDate(ddate)
{
	var currentTime = new Date()
	var month = currentTime.getMonth() + 1
	var day = currentTime.getDate()
	var year = currentTime.getFullYear()
	var validdate = 1;
		
	arrddate = ddate.split("/");
	if(year > arrddate[2])
	{
		validdate = 0;	
	}
	else
	{		
		if(year >= arrddate[2] && month > arrddate[1])
		{			
			validdate = 0;
		}
		else 
		{	
			if(month >= arrddate[1] && day > arrddate[0] && year >= arrddate[2])
			{
				validdate = 0;
			}			
		}
	}
	return validdate;
}

function isEmail(aStr)
{
	var reEmail=/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/;
	if(!reEmail.test(aStr))
	{
		return false;
	}
	return true;
}


function isUrl(s) 
{
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}

function special_characters_check(str)
{	
	arfile = str.split('\\');
	len = arfile.length;
	var vld_Special_Char = /^[a-zA-Z0-9._\- ]*$/;

	if(!vld_Special_Char.test(arfile[len-1]))
		return false;
	else
		return true;
}

// function check for valid file formats
// File = filename with extension
// AllowedType = 1 for gif
// AllowedType = 2 for flv,swf
function checkFile(File, AllowedType)
{
	// project dependent
	if(AllowedType==1)
	{
		pattren = /.\.(gif)$/i;
	}
	if(AllowedType==2)
	{
		pattren = /.\.(swf|flv)$/i;
	}
	var isExtention = pattren.test(File);
	return isExtention;
}

function fileTypeCheck(filename)
{ 
	var testStr = '.pdf.doc.xls.docx.PDF.DOC.XLS.DOCX';
	var txt = filename;
	//just for illustration!
	if(testStr.indexOf(txt.substring(txt.lastIndexOf('.'))) == -1)
	{
		return false;
	}
	return true;
}

