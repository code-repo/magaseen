<?php
require_once(CLASS_PATH.'database.php');
class c_AdminProductDb
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

#------------------------- Category Functions -----------------------------#
	#Function to activate/deactive/delete teh category
	function m_RecordAction($table, $ids, $stAction)
	{		
		$stQuery = "";
		if($stAction == 'activate')
		{
			$stQuery = "UPDATE $table SET iActive=1 WHERE iId IN (".$ids.")";			
		}
		elseif($stAction == 'deactivate')
		{
			$stQuery = "UPDATE $table SET iActive=0 WHERE iId IN (".$ids.")";
		}
		else if($stAction == 'delete')
		{			
			$stQuery = "DELETE FROM $table WHERE iId IN (".$ids.")";
		}		
		// print ($stQuery); die;
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        			
			return false;
		}		
		return true;					
	}#END function m_CategoryAction($stCategoryId, $stAction)

	#Function to count total number of records
	function m_GetRecordCount($table, $where='')
	{						
		$stQuery = "SELECT COUNT(iId) as cnt FROM $table $where";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{
			return false;
		}
		else
		{
			return $rsResult->fields['cnt'];
		}				
	}#END function m_GetCategoryCount()
	
	function m_AddEditCategory($arData, $inCategoryId = NULL)
	{
		if($inCategoryId == NULL)
		{						
			$stQuery = "INSERT INTO tb_category 
			SET vTitle ='".addslashes($arData['stCategory'])."',
				iActive=1,
				dAddedOn=NOW()";
		}
		else
		{
			$stQuery = "UPDATE tb_category 
			SET vTitle ='".addslashes($arData['stCategory'])."'
			WHERE iId=$inCategoryId";
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
	}#END function m_AddEditCategory($arData, $inCategoryId = NULL)

	function m_CheckCategoryTitleExistence($stTitle, $inCategoryId = NULL)
	{
		$stQuery = "SELECT iId FROM tb_category WHERE vTitle ='".addslashes($stTitle)."'";
		if($inCategoryId != NULL)
		{		
		 	$stQuery .= " AND iId != ".$inCategoryId;
		}	
		$rsResult = $this->obDbase->Execute($stQuery);		
		if (!$rsResult)
		{			
			return false;
		}
		else
		{
			return $rsResult;								
		}		
	}#END function m_CheckCategoryTitleExistence($stTitle, $inCategoryId = NULL)	

	#Function to get productcategory details
	function m_GetCategoryDetail($inCategoryId)
	{						
		$stQuery = "SELECT * FROM tb_category WHERE iId =".$inCategoryId;		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult;			
		}				
	}#END function m_GetCategoryDetail($inCategoryId)
	

#------------------------- Product Functions -----------------------------#	
	
	#Function to count total number of records
	function m_GetCampaignCount($where='')
	{						
		$stQuery = "SELECT COUNT(c.iId) as cnt FROM tb_campaign c $where";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{
			return false;
		}
		else
		{
			return $rsResult->fields['cnt'];
		}				
	}#END function m_GetCampaignCount()
	
	#Function to insert/update product
	function m_AddEditCampaign($arData, $inCampaignId = NULL)
	{
		if($inCampaignId == NULL)
		{						
			$stQuery = "INSERT INTO tb_campaign 
			SET vName='".addslashes($arData['vName'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dStartDate='".$arData['dStartDate']."',
				dEndDate='".$arData['dEndDate']."',
				iActive='".$arData['iActive']."'";
		}
		else
		{
			$stQuery = "UPDATE tb_campaign 
			SET vName='".addslashes($arData['vName'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dStartDate='".$arData['dStartDate']."',
				dEndDate='".$arData['dEndDate']."',
				iActive='".$arData['iActive']."'
			WHERE iId=$inCampaignId";
		}		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			return true;			
		}
	}#END function m_AddEditCampaign($arData, $inCampaignId = NULL)

	function m_CheckCampaignTitleExistence($stTitle, $inCampaignId = NULL, $inCategoryId = NULL)
	{
		$stQuery = "SELECT iId FROM tb_campaign WHERE vTitleEN ='".addslashes($stTitle)."' AND iCategoryId=$inCategoryId";
		if($inCampaignId != NULL)
		{		
		 	$stQuery .= " AND iId != ".$inCampaignId;
		}	
		$rsResult = $this->obDbase->Execute($stQuery);		
		if (!$rsResult)
		{        			
			return false;
		}
		else
		{
			return $rsResult;								
		}		
	}#END function m_CheckCampaignTitleExistence($stTitle, $inCampaignId = NULL)	
	
	function getCampaignTitle($inCampaignId)
	{						
		$stQuery = "SELECT p.vTitleEN as product, c.vTitleEN as category FROM tb_campaign p INNER JOIN tb_category c ON p.iCategoryId=c.iId WHERE p.iId =".$inCampaignId;		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult->fields['category'].' - '.$rsResult->fields['product'];			
		}				
	}

	#Function to get product details
	function m_GetCampaignDetail($inCampaignId)
	{						
		$stQuery = "SELECT * FROM tb_campaign WHERE iId =".$inCampaignId;		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult;			
		}				
	}#END function m_GetCampaignDetail($inCampaignId)

	#Function to get product categories
	function m_GetCategory()
	{						
		$stQuery = "SELECT iId, vTitle FROM tb_category ORDER BY vTitle";		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult;			
		}				
	}#END function m_GetCategory($inPageId)
	
	function m_GetDatasetItems($where='')
	{						
		$stQuery = "SELECT * FROM tb_dataset_item $where ORDER BY vName";		
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
	
	function m_GetClient()
	{						
		$stQuery = "SELECT iId, vName FROM tb_client ORDER BY vName";		
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
	
	function m_GetClientContent($clientid)
	{						
		$stQuery = "SELECT iId, vName FROM tb_content WHERE iClientId=".$clientid;		
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
	
	function m_GetClientCampaigns($clientid)
	{						
		$stQuery = "SELECT * FROM tb_campaign WHERE iClientId=".$clientid." ORDER BY vName";		
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
	
	function m_GetClientAndCampaign()
	{						
		$stQuery = "SELECT cm.iId, cm.vName, cl.vName as client FROM tb_campaign cm INNER JOIN tb_client cl ON cm.iClientId=cl.iId ORDER BY client, cm.vName";		
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
	
	function m_GetCampaignContents($id)
	{						
		$stQuery = "SELECT c.*, ct.vTitle as category FROM tb_content c INNER JOIN tb_category ct ON c.iCategoryId=ct.iId WHERE c.iCampaignId IN (".$id.")";	
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
	
	function m_GetContentARItems($id)
	{						
		$stQuery = "SELECT a.*, dsi.vName as name FROM tb_aritem a INNER JOIN tb_dataset_item dsi ON a.iDatasetItemId=dsi.iId WHERE a.iContentId = ".$id;	
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
	
	function m_GetCampaign($clientId=0)
	{						
		$stQuery = "SELECT iId, vName FROM tb_campaign";
		if($clientId > 0){
			$stQuery .= " WHERE iClientId=".$clientId;
		}
		$stQuery .= " ORDER BY vName";
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

	function m_GetCountry()
	{						
		$stQuery = "SELECT iId, vName FROM tb_country ORDER BY vName";		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult;			
		}				
	}#END function m_GetCategory($inPageId)
	
	#------------------------- Content Functions -----------------------------#	
	

	#Function to count total number of records
	function m_GetContentCount($where)
	{						
		$stQuery = "SELECT COUNT(iId) as contentcnt FROM tb_content $where";
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{
			return false;
		}
		else
		{
			return $rsResult->fields['contentcnt'];
		}				
	}#END function m_GetContentCount()

	#Function to insert/update content
	function m_AddEditContent($arData, $inContentId = NULL)
	{
		if($inContentId == NULL)
		{						
			$stQuery = "INSERT INTO tb_content 
			SET iClientId='".addslashes($arData['iClientId'])."',
				iCategoryId='".addslashes($arData['iCategoryId'])."',
				iCampaignId='".addslashes($arData['iCampaignId'])."',
				vName='".addslashes($arData['vName'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dStartDate='".addslashes($arData['dStartDate'])."',
				dEndDate='".addslashes($arData['dEndDate'])."',
				iActive=1";
			
		}
		else
		{
			$stQuery = "UPDATE tb_content 
			SET iClientId='".addslashes($arData['iClientId'])."',
				iCategoryId='".addslashes($arData['iCategoryId'])."',
				iCampaignId='".addslashes($arData['iCampaignId'])."',
				vName='".addslashes($arData['vName'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dStartDate='".addslashes($arData['dStartDate'])."',
				dEndDate='".addslashes($arData['dEndDate'])."'
			WHERE iId=$inContentId";
		}		
		$rsResult = $this->obDbase->Execute($stQuery);	
// print "<pre>"; print_r($this->obDbase); die('here');		
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			return true;			
		}
	}#END function m_AddEditContent($arData, $inContentId = NULL)

	function m_CheckContentTitleExistence($stTitle, $inContentId = NULL)
	{
		$stQuery = "SELECT iId FROM tb_content WHERE vContent ='".addslashes($stTitle)."'";
		if($inContentId != NULL)
		{		
		 	$stQuery .= " AND iId != ".$inContentId;
		}	
		$rsResult = $this->obDbase->Execute($stQuery);		
		if (!$rsResult)
		{        			
			return false;
		}
		else
		{
			return $rsResult;								
		}		
	}#END function m_CheckContentTitleExistence($stTitle, $inContentId = NULL)	

	#Function to get content details
	function m_GetRecordDetail($table, $id)
	{						
		$stQuery = "SELECT * FROM $table WHERE iId =".$id;		
		$rsResult = $this->obDbase->Execute($stQuery);
		if (!$rsResult)
		{        				
			return false;
		}
		else
		{
			return $rsResult;			
		}				
	}#END function m_GetContentDetail($inContentId)
	
	
	function m_AddEditARItem($arData, $id = NULL)
	{
		if($id == NULL)
		{						
			$stQuery = "INSERT INTO tb_aritem 
			SET iDatasetItemId='".addslashes($arData['iDatasetItemId'])."',
				iContentId='".addslashes($arData['iContentId'])."',
				".$arData['vObject']."
				vWebLink='".addslashes($arData['vWebLink'])."',				
				dDateTime=NOW(),
				iActive=1";
		}
		else
		{
			$stQuery = "UPDATE tb_aritem 
			SET iDatasetItemId='".addslashes($arData['iDatasetItemId'])."',
				iContentId='".addslashes($arData['iContentId'])."',
				".$arData['dDateTime']."
				".$arData['vObject']."
				vWebLink='".addslashes($arData['vWebLink'])."'				
			WHERE iId=$id";
		}		
		// print $stQuery; die;
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
	
	function m_AddEditDataset($arData, $id = NULL)
	{
		if($id == NULL)
		{						
			$stQuery = "INSERT INTO tb_dataset 
			SET ".$arData['vObject']."
				dCreated=NOW()";
		}
		else
		{
			$stQuery = "UPDATE tb_dataset 
			SET ".$arData['vObject']."
				dCreated=NOW()
			WHERE iId=$id";
		}		
		// print $stQuery; die;
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
	
	function m_AddEditDatasetItem($arData, $id = NULL)
	{
		if($id == NULL)
		{						
			$stQuery = "INSERT INTO tb_dataset_item 
			SET iDatasetId='".addslashes($arData['iDatasetId'])."',
				".$arData['vImage']."
				vName='".addslashes($arData['vName'])."'";
		}
		else
		{
			$stQuery = "UPDATE tb_dataset_item 
			SET ".$arData['vImage']."
			vName='".addslashes($arData['vName'])."'
			WHERE iId=$id";
		}		
		// print $stQuery; die;
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
	
	function m_ValidateDatasetItem($name, $iId='')
	{
		$stQuery="SELECT iId FROM tb_dataset_item WHERE vName='".$name."'";
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
	}
	
	function m_ValidateDataset($datasetId, $iId='')
	{
		$stQuery="SELECT iId FROM tb_aritem WHERE iDatasetItemId='".$datasetId."'";
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
	}
	
	function m_AddEditApp($arData, $id = NULL)
	{
		if($id == NULL)
		{						
			$stQuery = "INSERT INTO tb_app 
			SET vName='".addslashes($arData['vName'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vDescription='".addslashes($arData['vDescription'])."',				
				vInternalDescription='".addslashes($arData['vInternalDescription'])."',				
				vReference='".addslashes($arData['vReference'])."',				
				dPaidDate='".addslashes($arData['dPaidDate'])."'";
		}
		else
		{
			$stQuery = "UPDATE tb_app 
			SET vName='".addslashes($arData['vName'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vDescription='".addslashes($arData['vDescription'])."',				
				vInternalDescription='".addslashes($arData['vInternalDescription'])."',				
				vReference='".addslashes($arData['vReference'])."',
				dPaidDate='".addslashes($arData['dPaidDate'])."'				
			WHERE iId=$id";
		}		
		// print $stQuery; die;
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
	
	function m_AddEditSlot($arData, $id = NULL)
	{
		if($id == NULL)
		{						
			$stQuery = "INSERT INTO tb_slot 
			SET iSlots='".addslashes($arData['iSlots'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vReference='".addslashes($arData['vReference'])."',				
				dPaidDate='".addslashes($arData['dPaidDate'])."'";
		}
		else
		{
			$stQuery = "UPDATE tb_slot 
			SET iSlots='".addslashes($arData['iSlots'])."',
				iClientId='".addslashes($arData['iClientId'])."',
				vReference='".addslashes($arData['vReference'])."',
				dPaidDate='".addslashes($arData['dPaidDate'])."'				
			WHERE iId=$id";
		}		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			if($arData['iClientId'] == null){
				$arData['iClientId'] = $this->obDbase->Insert_ID();
			} 
			$this->m_UpdateSlots($arData['iClientId']);
			return true;			
		}
	}
	
	function m_UpdateSlots($client_id){
		$stQuery = "UPDATE tb_client 
			SET iTotalSlots=(SELECT SUM(iSlots) FROM tb_slot WHERE iClientId=tb_client.iId)				
			WHERE iId='".$client_id."'";
			// $stQuery="SELECT SUM(iSlots) AS total_slots FROM tb_slot WHERE iClientId='".$arData['iClientId']."'";			
			$rsResult = $this->obDbase->Execute($stQuery);
	}

}#END class c_AdminScheduleDb
?>