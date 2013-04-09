<?php
require_once(CLASS_PATH.'database.php');
class c_AdminUserDb
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
		$stQuery = "SELECT * FROM tb_user  WHERE vEmail = '".trim(addslashes($user))."' AND BINARY vPassword='".trim(addslashes($pass))."' and iActive=1";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if ($rsResult)
		{     			
			if($rsResult->numRows()){
				$_SESSION['user'] = $rsResult->fields;
				$_SESSION['user']['vName'] = stripslashes($rsResult->fields['vFirstName'].' '.$rsResult->fields['vLastName']);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;			 
		}				
	}#END function m_CheckLogin()

	#Function to validate password old password
	function m_CheckOldPassWord($stPass)
	{		
		$stQuery = "SELECT iId FROM tb_user  WHERE iId = '".$_SESSION['user']['iId']."' AND BINARY vPassword='".trim(addslashes($stPass))."' AND iActive=1";	
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
		$stQuery = "UPDATE tb_user  SET vPassword='".trim(addslashes($stPass))."' WHERE iId = '".$_SESSION['user']['iId']."'";
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

	#Function to update email.
	function m_UpdateEmail($stEmail)
	{						
		$stQuery = "UPDATE tb_user  SET vEmail='".trim($stEmail)."' WHERE iId = '".$_SESSION['user']['iId']."'";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{     							
			return false;
		}
		else
		{
			$_SESSION['user']['vEmail'] = trim($stEmail);
			return true;			 
		}				
	}#END m_ChangePassword($arData['stNewPassword']);
	
	#Function to check admin login
	function m_CheckUserName($user)
	{						
		$stQuery = "SELECT vPassword, vEmail  FROM tb_user WHERE vEmail = '".trim($user)."' AND iActive=1";	
		$rsResult = $this->obDbase->Execute($stQuery);
		if ($rsResult)
		{   
			if($rsResult->NumRows()){
				return $rsResult;
			}else{
				return false;
			}
		}
		else{
			return false;
		}				
	}#END function m_CheckLogin()

		
	/* Function to activate/deactive/delete the users */
	function m_UserAction($stId, $stAction)
	{		
		$stQuery = "";
		if($stAction == 'activate')
		{
			$stQuery = "UPDATE tb_user SET iActive=1 WHERE iId IN (".$stId.")";			
		}
		elseif($stAction == 'deactivate')
		{
			$stQuery = "UPDATE tb_user SET iActive=0 WHERE iId IN (".$stId.")";
		}
		elseif($stAction == 'delete')
		{			
			$stQuery = "DELETE FROM tb_user WHERE iId IN (".$stId.")";
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

	/* Function to count total number of records in user table */
	function m_GetUserCount()
	{						
		$stQuery = "SELECT COUNT(iId) as cnt FROM tb_user";
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
	
	function m_AddEditUser($arData)
	{
		if($arData['iId'] == NULL)
		{
			$stQuery="INSERT INTO tb_user 
			SET vEmail='".$arData['vEmail']."',
			vPassword='".addslashes($arData['vPassword'])."',
			vFirstName='".addslashes($arData['vFirstName'])."',
			vMiddleName='".addslashes($arData['vMiddleName'])."',
			vLastName='".addslashes($arData['vLastName'])."',
			vStreet='".addslashes($arData['vStreet'])."',
			vSuite='".addslashes($arData['vSuite'])."',
			vZip='".addslashes($arData['vZip'])."',
			vCity='".addslashes($arData['vCity'])."',
			iProvinceId='".addslashes($arData['iProvinceId'])."',
			vPhone='".addslashes($arData['vPhone'])."',
			iCountryId='".addslashes($arData['iCountryId'])."',
			dRegDate=NOW()";
		}
		else
		{
			$stQuery="UPDATE tb_user 
			SET vEmail='".$arData['vEmail']."',
			vFirstName='".addslashes($arData['vFirstName'])."',
			vMiddleName='".addslashes($arData['vMiddleName'])."',
			vLastName='".addslashes($arData['vLastName'])."',
			vStreet='".addslashes($arData['vStreet'])."',
			vSuite='".addslashes($arData['vSuite'])."',
			vZip='".addslashes($arData['vZip'])."',
			vCity='".addslashes($arData['vCity'])."',
			iProvinceId='".addslashes($arData['iProvinceId'])."',
			vPhone='".addslashes($arData['vPhone'])."',
			iCountryId='".addslashes($arData['iCountryId'])."',
			dUpdatedOn=NOW()
			WHERE iId=".$arData['iId'];
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

	/* Function to get the member details by id */
	function m_GetUserDetail($inMemberId)
	{
		$stQuery="SELECT * FROM tb_user WHERE iId='".$inMemberId."'";
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
	
	
	/* Function to count total number of records in user table */
	function m_GetClientCount()
	{						
		$stQuery = "SELECT COUNT(iId) as cnt FROM tb_client";
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
	
	function m_AddEditClient($arData)
	{
		if($arData['iId'] == NULL)
		{
			$stQuery="INSERT INTO tb_client 
			SET vEmail='".$arData['vEmail']."',
			vPassword='".addslashes($arData['vPassword'])."',
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
			iActive=1,
			dRegDate=NOW()";
		}
		else
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
	
	function m_ClientAction($stId, $stAction)
	{		
		$stQuery = "";
		if($stAction == 'activate')
		{
			$stQuery = "UPDATE tb_client SET iActive=1 WHERE iId IN (".$stId.")";			
		}
		elseif($stAction == 'deactivate')
		{
			$stQuery = "UPDATE tb_client SET iActive=0 WHERE iId IN (".$stId.")";
		}
		elseif($stAction == 'delete')
		{			
			$stQuery = "DELETE FROM tb_client WHERE iId IN (".$stId.")";
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


	/* Function to save users personal details */
	function m_SaveProfile($arData)
	{
		$stQuery="";
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

	/* Function to validate user email from database */
	function m_ValidateEmail($stEmail, $iId='')
	{
			$stQuery="SELECT iId FROM tb_client WHERE vEmail='".$stEmail."'";
			if($iId){
				$stQuery .= " AND iId<>".$iId;
			}
			$rsResult = $this->obDbase->Execute($stQuery);
			if($rsResult->NumRows()){
				return false;
			}
			else{
				return true;
			}
	
		/* if($type == 'C'){
			$stQuery="SELECT iId FROM tb_user WHERE vEmail='".$stEmail."'";
			$rsResult = $this->obDbase->Execute($stQuery);
			if($rsResult->NumRows()){
				return false;
			}
			else{
				$stQuery="SELECT iId FROM tb_client WHERE vEmail='".$stEmail."'";
				if($iId){
					$stQuery .= " AND iId<>".$iId;
				}
				$rsResult = $this->obDbase->Execute($stQuery);
				if($rsResult->NumRows()){
					return false;
				}
			}
		}else{
			$stQuery="SELECT iId FROM tb_client WHERE vEmail='".$stEmail."'";
			$rsResult = $this->obDbase->Execute($stQuery);
			if($rsResult->NumRows()){
				return false;
			}
			else{
				$stQuery="SELECT iId FROM tb_user WHERE vEmail='".$stEmail."'";
				if($iId){
					$stQuery .= " AND iId<>".$iId;
				}
				$rsResult = $this->obDbase->Execute($stQuery);
				if($rsResult->NumRows()){
					return false;
				}
			}
		} */	
		return true;
	}
	function m_CheckEmailExistence($stEmail, $inMemberId = NULL)
	{
		$stQuery = "SELECT COUNT(iId) as cnt FROM tb_user WHERE vEmail ='".$stEmail."'";
		if($inMemberId != NULL)
		{		
		 	$stQuery .= " AND iId != ".$inMemberId;
		}	
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

}#END class c_AdminUserDb
?>