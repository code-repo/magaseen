<?php
require_once(CLASS_PATH.'database.php');
class c_UserDb
{
	var $obDbase;

	#Constructor
	function __construct()
	{
		$this->m_ConnectDb();		
	}
	
	function m_ConnectDb()
	{
		global $dbCon;
		$this->obDbase = $dbCon;	
		$this->obDbase->SetFetchMode(ADODB_FETCH_ASSOC);
	}

	#Function to check admin login
	function m_CheckLogin($user, $pass)
	{						
		$stQuery = "SELECT * FROM tb_client  WHERE vEmail = '".trim(addslashes($user))."' AND BINARY vPassword='".trim(addslashes($pass))."' and iActive=1";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult;			 
		}				
	}#END function m_CheckLogin()

	/* Function to get the member details by id */
	function m_GetClientDetail($inMemberId)
	{
		$stQuery="SELECT * FROM tb_client WHERE iId='".$inMemberId."'";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult;			 
		}				
	}
	
	function m_AddEditClient($arData)
	{
		$stQuery="UPDATE tb_client 
		SET vEmail='".$arData['vEmail']."',
		vName='".addslashes($arData['vName'])."',
		vRFC='".addslashes($arData['vRFC'])."',
		vContact='".addslashes($arData['vContact'])."',
		vPhone='".addslashes($arData['vPhone'])."',
		vAddress='".addslashes($arData['vAddress'])."',
		vCity='".addslashes($arData['vCity'])."',
		vZip='".addslashes($arData['vZip'])."',
		vColonia='".addslashes($arData['vColonia'])."',
		vDelegMunic='".addslashes($arData['vDelegMunic'])."',
		iProvinceId='".addslashes($arData['iProvinceId'])."',
		iCountryId='".addslashes($arData['iCountryId'])."',
		dUpdatedOn=NOW()
		WHERE iId=".$arData['iId'];
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return true;			 
		}
	}

	/* Function to get the member details by id */
	function	m_GetUserDetailByEmail($stEmail='')
	{
		 $stQuery="SELECT m.* FROM tb_client m WHERE m.vEmail='".$stEmail."'";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult;			 
		}				
	}

	#Function to validate password old password
	function m_CheckOldPassWord($stPass)
	{						
		$stQuery="SELECT iId FROM tb_client  WHERE iId='".$_SESSION['sesUserId']."' AND BINARY vPassword='".trim(addslashes($stPass))."' AND iActive=1";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)	
		{     							
			return false;
		}
		else
		{
			return $rsResult->NumRows();			 
		}				
	}#END m_ValidatePassword($stPass)

	#Function to change password.
	function m_ChangePassword($stPass)
	{						
		$stQuery = "UPDATE tb_client SET vPassword='".trim(addslashes($stPass))."' WHERE iId = '".$_SESSION['sesUserId']."'";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return true;			 
		}				
	}#END m_ChangePassword($arData['stNewPassword']);

	

	/* Function to validate user email from database */
	function m_ValidateEmail($stEmail, $iId='')
	{
		$stQuery="SELECT iId FROM tb_client WHERE vEmail='".$stEmail."'";
		if($iId){
			$stQuery .= " AND iId<>".$iId;
		}
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)	
		{     							
			return false;
		}
		else
		{
			return $rsResult->NumRows();			 
		}			
	}

	#Function to get admin email.
	function m_GetAdminEmail()
	{						
		$stQuery = "SELECT vEmail FROM tb_admin WHERE iId = 1";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult->fields['vEmail'];			 
		}				
	}
	
	function m_GetCountries()
	{						
		$stQuery = "SELECT * FROM tb_country";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult;			 
		}				
	}
	
	function m_GetStates($inCountryId=1)
	{						
		$stQuery = "SELECT * FROM tb_state WHERE iCountryId=$inCountryId";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			return $rsResult;			 
		}				
	}
	
	function m_GetRecordCount($table, $where='1=1')
	{						
		$stQuery = "SELECT COUNT(iId) as cnt FROM $table WHERE $where";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{
			return false;
		}
		else
		{
			return $rsResult->fields['cnt'];
		}				
	}
	
	function m_GetRecords($table, $where='1=1')
	{						
		$stQuery = "SELECT * FROM $table WHERE $where";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{
			return false;
		}
		else
		{
			return $rsResult;
		}				
	}
	
	function m_AddEditMagazine($arData)
	{
		if($arData['id'] == '')
		{						
			$stQuery = "INSERT INTO tb_magazine 
			SET vName ='".addslashes($arData['vName'])."',
				vDescription ='".addslashes($arData['vDescription'])."',
				iAppId ='".addslashes($arData['iAppId'])."',
				vImage ='".addslashes($arData['vImage'])."'";
		}
		else
		{
			$stQuery = "UPDATE tb_magazine 
			SET vName ='".addslashes($arData['vName'])."',
				vDescription ='".addslashes($arData['vDescription'])."',
				iAppId ='".addslashes($arData['iAppId'])."',
				vImage ='".addslashes($arData['vImage'])."'
			WHERE iId=".$arData['id'];
		}
		
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			return true;			
		}
	}


}#END class c_AdminUserDb
?>