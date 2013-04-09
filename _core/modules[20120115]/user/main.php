<?php
class c_UserMain
{
	var $smarty;
	function __construct()
	{	
		$this->smarty = new Smarty(MODULE_PATH.'user/templates/main/');		
		$this->smarty->assign('SITE_URL', SITE_URL);	
		$this->smarty->assign('GRAPHICS_URL',GRAPHICS_URL);				
	}
	
	# Function to handle the events of user admin section 
	function m_InnerTemp($action='')
	{			
		global $attributes,$arMsg;
		$smarty = $this->smarty;
		
		$obMain = new c_UserOperation($smarty);				
		if(isset($attributes['action']) && $attributes['action'] != '')
		{
			$action = $attributes['action'];
		}
		else
		{
			$action ='';
		}
		
		if(!isset($_SESSION['sesUserId']) && $action != 'login')
		{
			header('Location: '.SITE_URL.'user/index.php?action=login');
		}
				
		switch($action)
		{	
			case "verify":
				$innerOutput = $obMain->m_CheckLogin();
			break;

			case "profile":
				$this->m_CheckLogin();
				$innerOutput = $obMain->m_EditProfile();
			break;

			case "changepass":
				$this->m_CheckLogin();
				$innerOutput = $obMain->m_ChangePassword();
			break;

			case "logout": 
				$innerOutput = $obMain->m_LogOut();
			break;

			case "forgot":
				$innerOutput = $obMain->m_Forgot();
			break;
			
			case "getstates": #Send product mail.
				$innerOutput = $obMain->m_GetStates($attributes['stateid'], $attributes['countryid'], 1);
			break;
			case "login": #Send product mail.
				$innerOutput = $obMain->m_DisplayLogin();
			break;

			default:	
				$innerOutput = $obMain->m_DisplayMyAccount();				
			break;
		}			
		return $innerOutput;

	}#END function m_InnerTemp()	

	function m_CheckLogin()
	{
		if(!isset($_SESSION['sesUserId']))
		{
			header("Location: ".SITE_URL."user/");
		}
	}
}
?>