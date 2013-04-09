<?php
require_once(CLASS_PATH.'upload.php'); # Upload class
require_once(CLASS_PATH.'common_functions.php'); # Common functions
require(MODULE_PATH."user/message.php"); # For messages
require(MODULE_PATH."user/classes/admin/userdb.php"); # TO handle DB
require_once(CLASS_PATH.'prevNext.php'); # Paging class

class c_AdUserOperation
{
	var $smarty;
	
	#Constructortc
	function __construct($obSmarty)	
	{			
		$this->smarty = $obSmarty;
		$this->dbHandler = new c_AdminUserDb();
	}
	function pr($arr)
	{
		print"<pre>";
		print_r($arr);
	}
	#Function to stripslashes and convert \n to <br>
	function m_DisplayData($stValue)
	{
		return stripslashes(nl2br($stValue));
	}#END function m_DisplayData($stValue)
	
	#Function to display welcome screen
	function m_DisplayHome()
	{						
		global $attributes,$arAdminDetail;
		$smarty = $this->smarty;		
		$innerTemp = $smarty->fetch('adminhome.tpl.html');		
		return $innerTemp;
	}#END function m_DisplayHome()

	#Function to display login screen
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
			else
			{	
				$smarty->assign('MESSAGE', LOGIN_ERROR);			
			}
		}
		else
		{
			$smarty->assign('MESSAGE', LOGIN_TEXT);
			$smarty->assign('LOGIN_CLASS', 'txt');
		}
		$innerTemp = $smarty->fetch('login.tpl.html');		
		return $innerTemp;
	}#END function m_DisplayLogin()

	#Function to check admin login
	function m_CheckLogin()
	{
		global $attributes;
		$rsResult = $this->dbHandler->m_CheckLogin($attributes['txtUserId'], $attributes['txtPassword']);
		if($rsResult)
		{
			header("Location: ".SITE_URL."adminindex.php");
		}
		else
		{
			header("Location: ".SITE_URL."adminindex.php?err=1");
		}
	}#END function m_CheckLogin()

	#Function for admin logout
	function m_LogOut()
	{
		unset($_SESSION['user']);								
		header("Location: ".SITE_URL."adminindex.php?err=2");
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
					header("Location: ".SITE_URL."user/adminindex.php?action=changepass&msg=PASSWORD_CHANGED");
				else
					$stMsg = QUERY_ERROR;
			}			
		}
		$smarty->assign('TOP_NAVIGATION',"<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;&nbsp;Change Password");			
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		$innerTemp = $smarty->fetch('changepassword.tpl.html');		
		return $innerTemp;
	}#END function m_ChangePassword()

	#Function to validate form filds
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

	#Function to update email
	function m_UpdateEmail()
	{						
		global $attributes;
		$smarty = $this->smarty;
		$stErrorMsg = "";		
		$arData = "";
		$stMsg = "";

		#print"<pre>";
		#print_r($attributes);
		if(isset($attributes['msg']))
		{
			$stMsg = constant($attributes['msg']);
		}		
		if(count($_POST)>0)
		{			
			$arData = array();
			$arData['stEmail'] = $attributes['txtEmail'];			
			
			#For server side validations.
			if($this->m_ValidateEmail($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{			
				$rsResult = $this->dbHandler->m_UpdateEmail($arData['stEmail']);	
				if($rsResult)
					header("Location: ".SITE_URL."user/adminindex.php?action=email&msg=EMAIL_UPDATE");
				else
					$stMsg = QUERY_ERROR;
			}			
		}
		else
		{
			$arData = array();
			$stEmail = $_SESSION['user']['vEmail'];
			if(!$stEmail)
				$stMsg = QUERY_ERROR;
			else
				$arData['stEmail'] = $stEmail;
		}
		$smarty->assign('EMAIL', $arData['stEmail']);
		
		$smarty->assign('TOP_NAVIGATION',"<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;&nbsp;Update Email");			
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		$innerTemp = $smarty->fetch('email.tpl.html');		
		return $innerTemp;
	}#END function  m_UpdateEmail()

	#Function to validate email
	function m_ValidateEmail($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;		
		if(empty($arData['stEmail'])) 
		{
			$stErrorMsg .= BLANK_EMAIL."<br>";				
			$blIsError = true;
		}
		elseif($this->m_ValidEmail($arData['stEmail'])) 
		{
			$stErrorMsg .= INVALID_EMAIL."<br>";				
			$blIsError = true;
		}
		elseif(!$this->dbHandler->m_ValidateEmail(trim($arData['stEmail']), $_SESSION['user']['vType'], $_SESSION['user']['iId']))
		{
			$stErrorMsg.= EMAIL_ALREADY_EXIST."<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}#END function m_ValidateEmail($arData,$stErrorMsg)
	
	#Function to forgot password
	function m_ForgotPassword()
	{		
		include_once(LIBRARY_PATH."html_mime_mail_2.5/htmlMimeMail.php");
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
			$rsResult = $this->dbHandler->m_CheckUserName( $attributes['txtUserId']);
			
			if($rsResult)						
			{		
				if($rsResult->NumRows())
				{
					$this->smarty->assign('LOGIN',$rsResult->fields['vEmail']);
					$this->smarty->assign('PASSWORD',$rsResult->fields['vPassword']);
					$this->smarty->assign('SITE_URL',SITE_URL);
					$this->smarty->assign('SITE_TITLE',SITE_TITLE);
					$stHtmlContent=$this->smarty->fetch("admin_mail_forgotpass.tpl.html");
					$stTextContent=strip_tags(str_replace("<br />","\r\n",$stHtmlContent));

					$obMail=new htmlMimeMail();
					$obMail->setFrom(MAIL_FROM_EMAIL);
					$obMail->setReturnPath(MAIL_FROM_EMAIL);
					$obMail->setSubject("[".SITE_TITLE."] Password Reminder");
					$obMail->setText($stTextContent);
					$obMail->setHtml($stHtmlContent);
					$result = $obMail->send(array($rsResult->fields['vEmail']));
					if($result)
					{
						header("Location: ".SITE_URL."user/adminindex.php?action=forgotpass&msg=PASSWORD_SENT");
					}
					else
					{
						echo "Mail sending failed...";
					}
					exit;
				}
				else		
				{			
					header("Location: ".SITE_URL."user/adminindex.php?action=forgotpass&msg=INVALID_LOGIN");
				}			
			}
			else
			{
				$stMsg = QUERY_ERROR;
			}
		}
	
		if($stMsg)
		{
			$smarty->assign('MESSAGE',$stMsg);
			$smarty->assign('LOGIN_CLASS', 'errMsg');
		}
		else
		{
			$smarty->assign('MESSAGE',"Please enter your Login ID.");
			$smarty->assign('LOGIN_CLASS', 'txt');
		}
		$innerTemp = $smarty->fetch('forgot_password.tpl.html');		
		return $innerTemp;
	}#END function m_ForgotPassword()


	/* Function to display the list of website users */
	function m_UserList()
	{
		global $attributes,$arAdminDetail;
		$stMsg = "";

		
		if(isset($attributes['msg']))
		{
			$stMsg = constant(strtoupper($_GET['msg']));
		}
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$this->smarty->assign('EXTRA_ATT',$stExtraAtt);
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) 
			{
				$stIds = implode(",", $attributes['chkPage']);
				$rsResult = $this->dbHandler->m_UserAction($stIds,$attributes['selAction']);
				if($rsResult)
				{						
					if(isset($attributes['txtSearch']))
					{
						header("Location:".SITE_URL."user/adminindex.php?action=searchuser&txtSearch=".$attributes['txtSearch']."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
						exit();
					}
					else
					{
						header("Location:".SITE_URL."user/adminindex.php?action=userlist&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
						exit();
					}
				}
				else
				{
					$stMsg = QUERY_ERROR;
				}		
			}
			else
			{
				$stMsg = SELECT_VALUE;
			}					
		}

		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;

		$inRowCount = $this->dbHandler->m_GetUserCount();	
		$this->smarty->assign('PAGE_COUNT',$inRowCount);
				
			
		// code for paging		
		$stPagingParam	= "action=".$attributes['action'];
		$stPagingParam .= isset($attributes['txtSearch'])?"&txtSearch=".$attributes['txtSearch']:"";
		$qry = "SELECT * FROM tb_user";		
		if(isset($attributes['action']) && $attributes['action'] == "searchuser")
		{
			$this->smarty->assign("SEARCH_KEYWORD", $attributes['txtSearch']);
			$qry .= " WHERE vEmail LIKE  ('%".addslashes($attributes['txtSearch'])."%') 
					OR vFirstName LIKE  ('%".addslashes($attributes['txtSearch'])."%') 
					OR vLastName LIKE  ('%".addslashes($attributes['txtSearch'])."%')
					OR CONCAT(vFirstName, ' ', vLastName) LIKE  ('%".addslashes($attributes['txtSearch'])."%')";
		}
		$qry .= " ORDER BY iId DESC";

	
		$pager = new PrevNext($this->dbHandler->obDbase);
		$resArr = $pager->create($qry, PAGE_SIZE,$stPagingParam);			
		$this->smarty->assign('PAGING',$resArr['pnContents']);
		// code for paging		
		$arData = array();
		if($resArr['qryRes']->NumRows())
		{
			$this->smarty->assign("IS_RECORD", true);
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
			}
			$this->smarty->assign("IS_RECORD", true);
			$this->smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$this->smarty->assign("IS_RECORD", false);
		}


		if($stMsg)
		{
			$this->smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$this->smarty->assign('PAGE', $attributes['page']);
		else
			$this->smarty->assign('PAGE', 1);
		if(isset($attributes['txtSearch']))
			$stNavigationText = 'User search result';
		else
			$stNavigationText = 'Manage Users';

		$this->smarty->assign('TOP_NAVIGATION',$stNavigationText);
		$innerTemp = $this->smarty->fetch('admin_user_list.tpl.html');		
		return $innerTemp;
	}

	/* Function to edit personal profile */
	function m_AddEditUser()
	{
		global $attributes,$arAdminDetail;
		$stMsg='';
		$this->smarty->assign("GRAPHIC_URL",GRAPHICS_URL);
		$arData=array();		
		if(isset($_POST) && count($_POST))
		{
			if(!isset($attributes['userid'])){
				$attributes['userid'] = NULL;
			}
			$arData['iId'] = $attributes['userid'];
			$arData['vFirstName']=trim($attributes['vFirstName']);
			$arData['vMiddleName']=trim($attributes['vMiddleName']);
			$arData['vLastName']=trim($attributes['vLastName']);
			$arData['vEmail']=trim($attributes['vEmail']);
			$arData['vStreet']=trim($attributes['vStreet']);
			$arData['vSuite']=trim($attributes['vSuite']);
			$arData['vZip']=trim($attributes['vZip']);
			$arData['vCity']=trim($attributes['vCity']);
			$arData['iProvinceId']=trim($attributes['iProvinceId']);
			$arData['vPhone']=trim($attributes['vPhone']);
			$arData['iCountryId']=$attributes['iCountryId'];
			if(isset($attributes['vPassword'])){
				$arData['vPassword'] = trim($attributes['vPassword']);
			}
			if(isset($attributes['vCPassword'])){
				$arData['vCPassword'] = trim($attributes['vCPassword']);
			}
			$stMsg=$this->m_VerifyProfile($arData);

			if($stMsg=='')
			{
				$obResult = $this->dbHandler->m_AddEditUser($arData);
				if($obResult){
					header("Location: ".SITE_URL."user/adminindex.php?action=userlist&msg=record_updated");
					exit;
				}
				else{
					$stMsg = QUERY_ERROR;
				}
			}
		}
		elseif(isset($attributes['userid']) && $attributes['userid'] > 0)
		{
			$user = $this->dbHandler->m_GetUserDetail($attributes['userid']);
			$arData = $user->fields;
		}
		else
		{
			$arData['vFirstName'] = '';
			$arData['vMiddleName'] = '';
			$arData['vLastName'] = '';
			$arData['vEmail'] = '';
			$arData['vStreet'] = '';
			$arData['vSuite'] = '';
			$arData['vZip'] = '';
			$arData['vCity'] = '';
			$arData['iProvinceId'] = '';
			$arData['vPhone'] = '';
			$arData['iCountryId'] = 1;
		}	
		 // print "<pre>"; print_r($arData); die;
		
		$this->smarty->assign("ARR_DATA", $arData);
		$this->smarty->assign("COUNTRIES", $this->m_GetCountries($arData['iCountryId']));
		$this->smarty->assign("STATES", $this->m_GetStates($arData['iProvinceId'], $arData['iCountryId']));
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$this->smarty->assign('TOP_NAVIGATION',"<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;&nbsp;<a href='".SITE_URL."user/adminindex.php?action=userlist'>Manage Users</a>&nbsp;&raquo;&nbsp;<b>Edit user profile</b>");
	
		$innerTemp = $this->smarty->fetch('admin_aeuser.tpl.html');		
		return $innerTemp;
	}
	
	function m_VerifyProfile($arData)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;		

		if(empty($arData['vFirstName'])) 
		{
			$stErrorMsg .= BLANK_FIRST_NAME."<br>";				
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
			if(!$this->dbHandler->m_ValidateEmail(trim($arData['vEmail']), 'U', $attributes['userid']))
			{
				$stErrorMsg.= EMAIL_ALREADY_EXIST."<br>";				
				$blIsError = true;
			}
		}
		if(!isset($attributes['userid']))
		{
			if(trim($arData['vPassword']) == '')
			{
				$stErrorMsg .= BLANK_PASSWORD."<br>";				
				$blIsError = true;
			}
			if(trim($arData['vCPassword']) == '')
			{
				$stErrorMsg .= BLANK_CPASSWORD."<br>";				
				$blIsError = true;
			}
			if(trim($arData['vPassword']) != '' && trim($arData['vCPassword']) != '' && trim($arData['vPassword']) != trim($arData['vCPassword']))
			{
				$stErrorMsg .= PASSWORD_CPASSWORD_NOTMATCH."<br>";				
				$blIsError = true;
			}
		}
		if(empty($arData['vStreet'])) 
		{
			$stErrorMsg .= BLANK_STREET."<br>";				
			$blIsError = true;
		}
		/*if(empty($arData['vSuite'])) 
		{
			$stErrorMsg .= BLANK_SUITE."<br>";				
			$blIsError = true;
		}*/
		if(empty($arData['vZip'])) 
		{
			$stErrorMsg .= BLANK_ZIP."<br>";				
			$blIsError = true;
		}
		if(empty($arData['vCity'])) 
		{
			$stErrorMsg .= BLANK_CITY."<br>";				
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


	/* Function to delete user*/
	function m_DeleteUser()
	{
		global $attributes,$_CONF;
		$smarty = $this->smarty;

		$rsResult = $this->dbHandler->m_UserAction($attributes['userid'], 'delete');
		if($rsResult)
		{
			if(isset($attributes['txtSearch']))
			{
				header("Location:".SITE_URL."user/adminindex.php?action=searchresult&txtSearch=".$attributes['txtSearch']."&msg=RECORD_DELETE");
				exit();
			}
			else
			{
				header("Location:".SITE_URL."user/adminindex.php?action=userlist&msg=RECORD_DELETE");
				exit();
			}
		}
	}
	
	function m_ClientList()
	{
		global $attributes,$arAdminDetail;
		$stMsg = "";

		
		if(isset($attributes['msg']))
		{
			$stMsg = constant(strtoupper($_GET['msg']));
		}
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$this->smarty->assign('EXTRA_ATT',$stExtraAtt);
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) 
			{
				$stIds = implode(",", $attributes['chkPage']);
				$rsResult = $this->dbHandler->m_ClientAction($stIds,$attributes['selAction']);
				if($rsResult)
				{						
					if(isset($attributes['txtSearch']))
					{
						header("Location:".SITE_URL."user/adminindex.php?action=searchclient&txtSearch=".$attributes['txtSearch']."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
						exit();
					}
					else
					{
						header("Location:".SITE_URL."user/adminindex.php?action=clientlist&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
						exit();
					}
				}
				else
				{
					$stMsg = QUERY_ERROR;
				}		
			}
			else
			{
				$stMsg = SELECT_VALUE;
			}					
		}

		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;

		$inRowCount = $this->dbHandler->m_GetClientCount();	
		$this->smarty->assign('PAGE_COUNT',$inRowCount);
				
			
		// code for paging		
		$stPagingParam	= "action=".$attributes['action'];
		$stPagingParam .= isset($attributes['txtSearch'])?"&txtSearch=".$attributes['txtSearch']:"";
		$qry = "SELECT (SELECT COUNT(iId) FROM tb_app where iClientId=c.iId) as app_count, c.* FROM tb_client c";
		if(isset($attributes['action']) && $attributes['action'] == "searchclient")
		{
			$this->smarty->assign("SEARCH_KEYWORD", $attributes['txtSearch']);
			$qry .= " WHERE vEmail LIKE  ('%".addslashes($attributes['txtSearch'])."%') 
					OR vName LIKE  ('%".addslashes($attributes['txtSearch'])."%')";
		}
		$qry .= " ORDER BY iId DESC";

	
		$pager = new PrevNext($this->dbHandler->obDbase);
		$resArr = $pager->create($qry, PAGE_SIZE,$stPagingParam);			
		$this->smarty->assign('PAGING',$resArr['pnContents']);
		// code for paging		
		$arData = array();
		if($resArr['qryRes']->NumRows())
		{
			$this->smarty->assign("IS_RECORD", true);
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
			}
			$this->smarty->assign("IS_RECORD", true);
			$this->smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$this->smarty->assign("IS_RECORD", false);
		}


		if($stMsg)
		{
			$this->smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$this->smarty->assign('PAGE', $attributes['page']);
		else
			$this->smarty->assign('PAGE', 1);
		if(isset($attributes['txtSearch']))
			$stNavigationText = 'Client search result';
		else
			$stNavigationText = 'Manage Clients';

		$this->smarty->assign('TOP_NAVIGATION', $stNavigationText);
		$innerTemp = $this->smarty->fetch('admin_client_list.tpl.html');		
		return $innerTemp;
	}

	/* Function to edit personal profile */
	function m_AddEditClient()
	{
		global $attributes,$arAdminDetail;
		$stMsg='';
		$this->smarty->assign("GRAPHIC_URL",GRAPHICS_URL);
		$arData=array();		
		if(isset($_POST) && count($_POST))
		{
			if(!isset($attributes['clientid'])){
				$attributes['clientid'] = NULL;
			}
			$arData['iId'] = $attributes['clientid'];
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
			
			/* $arData['iTotalSlots'] = $attributes['iTotalSlots'];
			$arData['vReference'] = $attributes['vReference'];
			$arData['dPaidDate'] = $attributes['dPaidDate']; */
			if(isset($attributes['vPassword'])){
				$arData['vPassword'] = trim($attributes['vPassword']);
			}
			if(isset($attributes['vCPassword'])){
				$arData['vCPassword'] = trim($attributes['vCPassword']);
			}
			$stMsg=$this->m_VerifyClient($arData);

			if($stMsg=='')
			{
				$obResult = $this->dbHandler->m_AddEditClient($arData);
				if($obResult){
					if(!$arData['iId'])
					{
						$this->smarty->assign('DATA', $arData);	
						$stHtmlContent=$this->smarty->fetch("mail_new_client.tpl.html"); 
						$stTextContent=strip_tags(str_replace("<br />","\r\n",$stHtmlContent));

						$obMail=new htmlMimeMail();
						$obMail->setFrom(SITE_TITLE_ADMIN);
						$obMail->setReturnPath(SITE_TITLE_ADMIN);
						$obMail->setSubject("[".SITE_TITLE."] Congratulaitons, you account has been created");
						$obMail->setText($stTextContent);
						$obMail->setHtml($stHtmlContent);
						$result = $obMail->send(array($arData['vEmail']));
					}
				
				
					header("Location: ".SITE_URL."user/adminindex.php?action=clientlist&msg=record_updated");
					exit;
				}
				else{
					$stMsg = QUERY_ERROR;
				}
			}
		}
		elseif(isset($attributes['clientid']) && $attributes['clientid'] > 0)
		{
			$client = $this->dbHandler->m_GetClientDetail($attributes['clientid']);
			$arData = $client->fields;
		}
		else
		{
			$arData['vName'] = '';
			$arData['vRFC']='';
			$arData['vColonia']='';
			$arData['vDelegMunic']='';
			$arData['vEmail']='';
			$arData['vPassword']='';
			$arData['vContact']='';
			$arData['vAddress']='';
			$arData['vCity']='';
			$arData['vZip']='';
			$arData['iProvinceId']='';
			$arData['vPhone']='';
			$arData['iCountryId']=1;
			
			$arData['iTotalSlots'] = '';
			$arData['vReference'] = '';
			$arData['dPaidDate'] = date('Y-m-d');
		}	
		// print "<pre>"; print_r($arData); die;
		
		$this->smarty->assign("ARR_DATA", $arData);
		$this->smarty->assign("COUNTRIES", $this->m_GetCountries($arData['iCountryId']));
		$this->smarty->assign("STATES", $this->m_GetStates($arData['iProvinceId'], $arData['iCountryId']));
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$this->smarty->assign('TOP_NAVIGATION',"<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;&nbsp;<a href='".SITE_URL."user/adminindex.php?action=clientlist'>Manage Clients</a>&nbsp;&raquo;&nbsp;<b>Edit client profile</b>");
	
		$innerTemp = $this->smarty->fetch('admin_aeclient.tpl.html');		
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
			if(!$this->dbHandler->m_ValidateEmail(trim($arData['vEmail']), $attributes['clientid']))
			{
				$stErrorMsg.= EMAIL_ALREADY_EXIST."<br>";				
				$blIsError = true;
			}
		}
		if(!isset($attributes['clientid']))
		{
			if(trim($arData['vPassword']) == '')
			{
				$stErrorMsg .= BLANK_PASSWORD."<br>";				
				$blIsError = true;
			}
			if(trim($arData['vCPassword']) == '')
			{
				$stErrorMsg .= BLANK_CPASSWORD."<br>";				
				$blIsError = true;
			}
			if(trim($arData['vPassword']) != '' && trim($arData['vCPassword']) != '' && trim($arData['vPassword']) != trim($arData['vCPassword']))
			{
				$stErrorMsg .= PASSWORD_CPASSWORD_NOTMATCH."<br>";				
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
		/* if(trim($arData['iTotalSlots']) <= 0) 
		{
			$stErrorMsg .= "Please enter total slots.<br>";				
			$blIsError = true;
		} 
		if(trim($arData['vReference']) == "") 
		{
			$stErrorMsg .= "Please enter reference.<br>";				
			$blIsError = true;
		} */
		if($blIsError)
		{
			return $stErrorMsg;
		}
	}
	
	/* Function to delete client*/
	function m_DeleteClient()
	{
		global $attributes,$_CONF;
		$smarty = $this->smarty;

		$rsResult = $this->dbHandler->m_ClientAction($attributes['clientid'], 'delete');
		if($rsResult)
		{
			if(isset($attributes['txtSearch']))
			{
				header("Location:".SITE_URL."user/adminindex.php?action=searchclient&txtSearch=".$attributes['txtSearch']."&msg=RECORD_DELETE");
				exit();
			}
			else
			{
				header("Location:".SITE_URL."user/adminindex.php?action=clientlist&msg=RECORD_DELETE");
				exit();
			}
		}
	}
	
	function m_GetCountries($inCountryId=0)
	{
		$arCountry = $this->dbHandler->m_GetCountries();
		$html = '<select name="iCountryId" id="iCountryId" class="txtbox">';
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

}#END class c_AdUserOperation
?>