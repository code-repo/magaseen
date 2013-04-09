<?php
require(LIBRARY_PATH."image.php");
require(MODULE_PATH."user/classes/main/userdb.php");
require_once(CLASS_PATH.'common_functions.php'); # Common functions
require_once(CLASS_PATH.'prevNext.php'); # Paging class

class c_UserOperation
{
	var $smarty;
	
	#Constructor
	function __construct($obSmarty)	
	{			
		$this->smarty = $obSmarty;
		$this->dbHandler = new c_UserDb();
	}
	
	function m_GetTop()
	{
		return $this->smarty->fetch("top.tpl.html");
	}
	
	function m_GetFooter()
	{
		return $this->smarty->fetch("footer.tpl.html");
	}

	#Function to stripslashes and convert \n to <br>
	function m_DisplayData($stValue)
	{
		return stripslashes(nl2br($stValue));
	}#END function m_DisplayData($stValue)
	
	#Function to display welcome screen
	function m_DisplayMyAccount()
	{						
		global $attributes,$arAdminDetail;
		$stMsg='';
		if(isset($attributes['msg']) && $attributes['msg']!='')
		{
			$stMsg=constant(strtoupper($attributes['msg']));
		}
		// print_r($attributes); die;	
		if(isset($_FILES['userfile']['name']) && trim($_FILES['userfile']['name']) != '')
		{
			$smallImgPath = SITE_PATH.'product/magazine/small/';
			$thumbImgPath = SITE_PATH.'product/magazine/thumb/';
			$orgImgPath = SITE_PATH.'product/magazine/';
			$source = $_FILES['userfile']['tmp_name'];
			$arName = explode('.', $_FILES['userfile']['name']);
			$fileName = "magazina_".time().'.'.array_pop($arName);
			$thumbImgPath = $this->m_UploadImage($source, $thumbImgPath.$fileName, true,290, 200);
			$smallImgPath = $this->m_UploadImage($source, $smallImgPath.$fileName, true,290,224);
			move_uploaded_file($source, $orgImgPath.$fileName);
			print $fileName;
			die;
		}
		
		if(isset($_POST) && count($_POST)){
			// print "<pre>"; print_r($attributes); die;
			$arData = array();
			
			$arData['id'] = $attributes['id'];
			$arData['vImage'] = $attributes['image_name'];
			$arData['vName'] = $attributes['vName'];
			$arData['vDescription'] = $attributes['vDescription'];
			$arData['iAppId'] = $attributes['iAppId'];
			
			 // print "<pre>"; print_r($arData); die;
			
			$rsResult= $this->dbHandler->m_AddEditMagazine($arData);
			if($rsResult)
			{					
				if(isset($attributes['id']) && !empty($attributes['id']))
				{
					$stMessage = "RECORD_EDIT";
				}
				else
				{
					$stMessage = "RECORD_ADDED";
				}
			
				header("Location:".SITE_URL."user/index.php?msg=".$stMessage);
				exit();
			}
			else
			{					
				$stMsg = QUERY_ERROR;					
			}
		}
		
		
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$where = 'iClientId='.$_SESSION['sesUserId'].' AND iActive=1';
		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_app', $where);	
		$this->smarty->assign('PAGE_COUNT',$inRowCount);
		$arApp = array();	
		if($inRowCount > 0)
		{			
			$rsData = $this->dbHandler->m_GetRecords('tb_app', $where);	
			$arData = array();
			
			$arMagazine = array();
			
			while(!$rsData->EOF)
			{						
				$arData[]= $rsData->fields;
				$arApp[$rsData->fields['iId']]= $rsData->fields['vName'];
				$rsApp = $this->dbHandler->m_GetRecords('tb_magazine', 'iAppId='.$rsData->fields['iId']);	
				$j=0;
				while(!$rsApp->EOF)
				{
					$arMagazine[$rsData->fields['iId']][$j] = $rsApp->fields;
					$arMagazine[$rsData->fields['iId']][$j]['iId'] = base64_encode($rsApp->fields['iId']);
					$j++;
					$rsApp->MoveNext();
					
				}
				$rsData->MoveNext();
			}
			// print "<pre>"; print_r($arData); 
			// print "<pre>"; print_r($arMagazine); die;
			$this->smarty->assign("IS_RECORD", true);
			$this->smarty->assign("ARR_DATA",$arData);
			$this->smarty->assign("ARR_MAGAZINE", $arMagazine);
		}
		else
		{
			$this->smarty->assign("IS_RECORD", false);
		}
		
		$this->smarty->assign("APPS", $arApp);
		
		
		$innerTemp = $this->smarty->fetch('main_account.tpl.html');		
		return $innerTemp;
	}#END function m_DisplayHome()
	
	function m_UploadImage($source, $destination, $resize, $width, $height)
	{		
		$obj_img = new ImageComponent();
		$obj_img->ImageFile=$source;
		$obj_img->Resize = $resize;
		$obj_img->ResizeScale = 100;
		$obj_img->Position = 'topleft';
		$obj_img->Compression = 80;
		$obj_img->Width = $width;
		$obj_img->Height = $height;
		return $obj_img->SaveImageAs($destination,$resize);
	}

	function m_DisplayLogin()
	{						
		global $attributes;
		$smarty = $this->smarty;	
		if(isset($attributes['err']))
		{
			$smarty->assign('LOGIN_CLASS', 'errMsg');
			if($attributes['err'] == 'qe')
				$smarty->assign('MESSAGE', QUERY_ERROR);
			elseif($attributes['err'] == 2)
				$smarty->assign('MESSAGE', LOGOUT);
			elseif($attributes['err'] == 3)
				$smarty->assign('MESSAGE', BOOKING);
			else
			{	
				$smarty->assign('MESSAGE', LOGIN_ERROR);			
			}
		}
		else
		{
			$smarty->assign('LOGIN_CLASS', 'txt');
		}
		
		if(isset($_POST) && count($_POST))
		{
			$rsResult = $this->dbHandler->m_CheckLogin($attributes['txtUserId'], $attributes['txtPassword']);
			if($rsResult)
			{
				if($rsResult->numRows())
				{					
					$_SESSION['sesUserId'] = $rsResult->fields['iId'];
					$_SESSION['sesUserName'] = $rsResult->fields['vName'];
					$_SESSION['sesUserEmail'] = $rsResult->fields['vEmail'];
					$_SESSION['client'] = $rsResult->fields;
					if(isset($_SESSION['afert_login_url']) && !empty($_SESSION['afert_login_url']))
						header("Location: ".$_SESSION['afert_login_url']);
					else
						header("Location: ".SITE_URL."user/index.php");
				}
				else
				{
					header("Location: ".SITE_URL."user/index.php?action=login&err=1");
				}
			}
			else
			{
				header("Location: ".SITE_URL."user/index.php?action=login&err=qe");
			}
		}
		
		$innerTemp = $smarty->fetch('main_login.tpl.html');		
		return $innerTemp;
	}#END function m_DisplayLogin()

	#Function to display profile
	function m_EditProfile()
	{
		global $attributes,$arAdminDetail;
		$stMsg='';
		$this->smarty->assign("GRAPHIC_URL",GRAPHICS_URL);
		$arData=array();		
		if(isset($_POST) && count($_POST))
		{
			$arData['iId'] = $_SESSION['sesUserId'];
			$arData['vName']=trim($attributes['vName']);
			$arData['vRFC']=trim($attributes['vRFC']);
			$arData['vColonia']=trim($attributes['vColonia']);
			$arData['vDelegMunic']=trim($attributes['vDelegMunic']);
			$arData['vEmail']=trim($attributes['vEmail']);
			$arData['vContact']=trim($attributes['vContact']);
			$arData['vAddress']=trim($attributes['vAddress']);
			$arData['vCity']=trim($attributes['vCity']);
			$arData['vZip']=trim($attributes['vZip']);
			$arData['iProvinceId']=trim($attributes['iProvinceId']);
			$arData['vPhone']=trim($attributes['vPhone']);
			$arData['iCountryId']=$attributes['iCountryId'];
			
			$stMsg = $this->m_VerifyClient($arData);

			if($stMsg=='')
			{
				$obResult = $this->dbHandler->m_AddEditClient($arData);
				if($obResult){
					$_SESSION['sesUserName'] = $arData['vName'];	
					$_SESSION['sesUserEmail'] = $arData['vEmail'];	
					header("Location: ".SITE_URL."user/index.php?msg=profile_updated");
					exit;
				}
				else{
					$stMsg = QUERY_ERROR;
				}
			}
		}
		else
		{
			$client = $this->dbHandler->m_GetClientDetail($_SESSION['sesUserId']);
			$arData = $client->fields;
		}
		
		// print "<pre>"; print_r($arData); die;
		
		$this->smarty->assign("ARR_DATA", $arData);
		$this->smarty->assign("COUNTRIES", $this->m_GetCountries($arData['iCountryId']));
		$this->smarty->assign("STATES", $this->m_GetStates($arData['iProvinceId'], $arData['iCountryId']));
		$this->smarty->assign("MESSAGE",$stMsg);
	
		$innerTemp = $this->smarty->fetch('main_edit_profile.tpl.html');		
		return $innerTemp;
	}
	
	function m_VerifyClient($arData)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;		

		if(empty($arData['vName'])) 
		{
			$stErrorMsg .= "Please enter your name.<br>";				
			$blIsError = true;
		}
		if(empty($arData['vRFC'])) 
		{
			$stErrorMsg .= "Please enter RFC.<br>";				
			$blIsError = true;
		}
		if(empty($arData['vEmail'])) 
		{
			$stErrorMsg .= BLANK_EMAIL."<br>";				
			$blIsError = true;
		}
		elseif(!$this->m_ValidEmail($arData['vEmail']))
		{
			$stErrorMsg .= INVALID_EMAIL."<br>";				
			$blIsError = true;
		}
		else
		{
			if($this->dbHandler->m_ValidateEmail(trim($arData['vEmail']), $_SESSION['sesUserId']))
			{
				$stErrorMsg.= EMAIL_ALREADY_EXIST."<br>";				
				$blIsError = true;
			}
		}
		if(empty($arData['vAddress'])) 
		{
			$stErrorMsg .= "Please enter your address.<br>";				
			$blIsError = true;
		}
		if(empty($arData['vCity'])) 
		{
			$stErrorMsg .= BLANK_CITY."<br>";				
			$blIsError = true;
		}
		if(empty($arData['vZip'])) 
		{
			$stErrorMsg .= BLANK_ZIP."<br>";				
			$blIsError = true;
		}		
		if(($arData['iCountryId'] == 1 || $arData['iCountryId'] == 3) && empty($arData['iProvinceId'])) 
		{
			$stErrorMsg .= BLANK_PROVINCE."<br>";				
			$blIsError = true;
		}
		if(empty($arData['iCountryId'])) 
		{
			$stErrorMsg .= BLANK_COUNTRY."<br>";				
			$blIsError = true;
		}
		if(empty($arData['vPhone'])) 
		{
			$stErrorMsg .= BLANK_PHONE."<br>";				
			$blIsError = true;
		}
		if($blIsError)
		{
			return $stErrorMsg;
		}
	}
	
	function m_ValidEmail($email) 
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;					
		else
			return false;				
	}
	
	#Function for admin logout
	function m_LogOut()
	{
		session_unset();
		header("Location: ".SITE_URL."user/index.php?err=2");
	}#END function m_LogOut()

	#Function to change password
	function m_ChangePassword()
	{						
		global $attributes;
		$smarty = $this->smarty;
		$stErrorMsg = "";		
		$arData = "";
		$stMsg = "";

		if(isset($attributes['msg']))
		{
			$stMsg = constant($attributes['msg']);
		}		
		// print_r($_POST); die;
		if(count($_POST)>0)
		{			
			$arData = array();
			$arData['stNewPassword'] = $attributes['txtNewPassword'];
			$arData['stConfirmPassword'] = $attributes['txtConfirmPassword'];
			$arData['stOldPassword'] = $attributes['txtOldPassword'];
			// for server side validations						

			if($this->m_ValidatePassword($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{			
				$rsResult = $this->dbHandler->m_ChangePassword($arData['stNewPassword']);
				if($rsResult)
				{
					header("Location: ".SITE_URL."user/index.php?action=changepass&msg=PASSWORD_CHANGED");
					exit;
				}
				else
				{
					$stMsg = QUERY_ERROR;
				}
			}			
		}
		if($stMsg)
		{
			$smarty->assign('MESSAGE',$stMsg);
		}
		$innerTemp = $smarty->fetch('main_changepass.tpl.html');		
		return $innerTemp;
	}#END function m_ChangePassword()

	/* Function to retrieve the password */
	function m_Forgot()
	{						
		global $attributes;
		$smarty = $this->smarty;
		$stErrorMsg = "";		
		$arData = "";
		$stMsg = "";

		if(isset($attributes['msg']))
		{
			$stMsg = constant($attributes['msg']);
		}		
	
		if(count($_POST)>0)
		{			
			$arData = array();
			$arData['txtEmail']=trim($attributes['txtEmail']);
			// for server side validations						
			if($this->m_ValidateForgot($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{	
				$rsResult = $this->dbHandler->m_GetUserDetailByEmail($attributes['txtEmail']);
				if($rsResult)
				{
					$this->smarty->assign('NAME',$rsResult->fields['vFirstName'].' '.$rsResult->fields['vLastName']);
					$this->smarty->assign('EMAIL',$rsResult->fields['vEmail']);
					$this->smarty->assign('PASSWORD',$rsResult->fields['vPassword']);
					$this->smarty->assign('SITE_URL',SITE_URL);
					$this->smarty->assign('SITE_TITLE',SITE_TITLE);
					$stHtmlContent=$this->smarty->fetch("main_mail_forgotpass.tpl.html");
					$stTextContent=strip_tags(str_replace("<br />","\r\n",$stHtmlContent));
				}

				$obMail=new htmlMimeMail();
				$obMail->setFrom(MAIL_FROM_EMAIL);
				$obMail->setReturnPath(MAIL_FROM_EMAIL);
				$obMail->setSubject(MAIL_FORGOT_SUBJECT);
				$obMail->setHtml($stHtmlContent);
				$result=$obMail->send(array($arData['txtEmail']));
				if($result)
				{
				header("Location: ".SITE_URL."user/index.php?action=forgot&msg=PASSWORD_SENT");
				}
				else
				{
					echo "Mail sent failed";
				}
				exit;
			}			
		}
		if($stMsg)
		{
			$smarty->assign('MESSAGE',$stMsg);
		}
		$innerTemp = $smarty->fetch('main_forgot.tpl.html');		
		return $innerTemp;
	}#END function m_ChangePassword()


	/* Function to validate form filds */
	function m_ValidatePassword($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;		
		if(empty($arData['stOldPassword'])) 
		{
			$stErrorMsg .= BLANK_OLD_PASSWORD."<br>";				
			$blIsError = true;
		}
		elseif($this->dbHandler->m_CheckOldPassWord($arData['stOldPassword']) == 0)
		{
			$stErrorMsg .= INVALID_OLDPASSWORD."<br>";
			$blIsError = true;
		}
		if(empty($arData['stNewPassword'])) 
		{
			$stErrorMsg .= BLANK_NEW_PASSWORD."<br>";				
			$blIsError = true;
		}
		if(empty($arData['stConfirmPassword']))
		{
			$stErrorMsg .= BLANK_CONFIRM_PASSWORD."<br>";				
			$blIsError = true;
		}
		if($arData['stNewPassword'] != $arData['stConfirmPassword']) 
		{
			$stErrorMsg .= PASSWORD_CPASSWORD_NOTMATCH."<br>";				
			$blIsError = true;
		}				
		return $blIsError;
	}#END function m_ValidatePassword($arData,$stErrorMsg)

	#Function to validate form filds
	function m_ValidateForgot($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;		
		if(empty($arData['txtEmail'])) 
		{
			$stErrorMsg .= BLANK_EMAIL."<br>";				
			$blIsError = true;
		}
		elseif($this->dbHandler->m_ValidateEmail($arData['txtEmail']) == 0)
		{
			$stErrorMsg .= INVALID_EMAIL."<br>";
			$blIsError = true;
		}

		return $blIsError;
	}


	function m_GetCountries($inCountryId=0)
	{
		$arCountry = $this->dbHandler->m_GetCountries();
		$html = '<select name="iCountryId" id="iCountryId">';
		$html .= '<option value="">--Select Country--</option>';
		while(!$arCountry->EOF)
		{						
			if($inCountryId == $arCountry->fields['iId'])
				$selected = 'selected="selected"';
			else
				$selected = '';
			$html .= '<option value="'.$arCountry->fields['iId'].'" '.$selected.'>'.$arCountry->fields['vName'].'</option>';
			$arCountry->MoveNext();
		}
		$html .= '</select>';
		return $html;
	}
	
	function m_GetStates($inStateId=0, $inCountryId=1, $ajax=0)
	{
		$arState = $this->dbHandler->m_GetStates($inCountryId);
		$html = '<select name="iProvinceId">';
		$html .= '<option value="">--Select Province--</option>';
		$canada = false;
		while(!$arState->EOF)
		{						
			if($inStateId == $arState->fields['iId'])
				$selected = 'selected="selected"';
			else
				$selected = '';
			$html .= '<option value="'.$arState->fields['iId'].'" '.$selected.'>'.$arState->fields['vName'].'</option>';
			$arState->MoveNext();
		}
		$html .= '</select>';
		if($ajax==1){
			print $html;
			die();
		}
		else
			return $html;
	}
	

	function m_GetClientApps(){
		global $attributes;
		print "<pre>"; print_r($attributes); die;
	}

}#END class c_AdUserOperation
?>