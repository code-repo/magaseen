<?php
class c_UserAdmin
{
	var $smarty;
	function __construct()
	{	
		$this->smarty = new Smarty(MODULE_PATH.'user/templates/admin/');		
		$this->smarty->assign('SITE_URL', SITE_URL);	
		$this->smarty->assign('ADMIN_GRAPHICS_URL', ADMIN_GRAPHICS_URL);				
	}
	
	# Function to handle the events of user admin section 
	function m_InnerTemp($action='')
	{			
		global $attributes,$arMsg;

		$smarty = $this->smarty;
		include_once(MODULE_PATH."user/classes/admin/ad_userop.php");
		$obAdmin = new c_AdUserOperation($smarty);				
		
		if(isset($attributes['action']) && $attributes['action'] != '')
			$action = $attributes['action'];
		
		switch($action)
		{	
			case "getstates": #Send product mail.
				$innerOutput = $obAdmin->m_GetStates($attributes['stateid'], $attributes['countryid'], 1);
			break;
			case "forgotpass": #Change Password
				$innerOutput = $obAdmin->m_ForgotPassword();
			break;
			case "email": # Display and Update Email				
				$innerOutput = $obAdmin->m_UpdateEmail();
			break;
			case "changepass": #Change Password
				$innerOutput = $obAdmin->m_ChangePassword();
			break;
			case "displogin": #Dispaly Login
				$innerOutput = $obAdmin->m_DisplayLogin();
			break;
			case "checklogin": #Check Login
				$innerOutput = $obAdmin->m_CheckLogin();
			break;
			case "logout": # Logout				
				$innerOutput = $obAdmin->m_LogOut();
			break;

			case "userlist":
			case "searchuser":
				$innerOutput = $obAdmin->m_UserList();
			break;

			case "aeuser":
				$innerOutput = $obAdmin->m_AddEditUser();
			break;

			case "deleteuser":
				$innerOutput = $obAdmin->m_DeleteUser();
			break;
			
			#Manage Client
			case "clientlist":
			case "searchclient":
				$innerOutput = $obAdmin->m_ClientList();
			break;

			case "aeclient":
				$innerOutput = $obAdmin->m_AddEditClient();
			break;

			case "deleteclient":
				$innerOutput = $obAdmin->m_DeleteClient();
			break;

			default:	
				if(isset($_SESSION['user']))
					$innerOutput = $obAdmin->m_DisplayHome();				
				else
					$innerOutput = $obAdmin->m_DisplayLogin();
			break;
		}			
		return $innerOutput;

	}#END function m_InnerTemp()	
}
?>