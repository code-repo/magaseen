<?php
require_once(CLASS_PATH.'database.php');
class c_ProductDb
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
	}
	
	function m_GetHotspotData($id)
	{						
		$stQuery = "SELECT hf.*, h.eType, h.vDivId FROM tb_hotspots h INNER JOIN tb_hotspot_files hf ON h.iId=hf.iHotspotId WHERE h.iId=$id";
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
	
	function m_AddEditPublication($arData, $id = NULL)
	{
		if($id > 0)
		{						
			$stQuery = "UPDATE tb_publication 
			SET vName='".addslashes($arData['vName'])."',
				iMagazineId='".addslashes($arData['iMagazineId'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dActivationDate='".$arData['dActivationDate']."',
				iMonth='".$arData['iMonth']."'
			WHERE iId=$id";
		}
		else
		{
			$stQuery = "INSERT INTO tb_publication 
			SET vName='".addslashes($arData['vName'])."',
				iMagazineId='".addslashes($arData['iMagazineId'])."',
				vDescription='".addslashes($arData['vDescription'])."',
				dActivationDate='".$arData['dActivationDate']."',
				iMonth='".$arData['iMonth']."'";
		}		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);	
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			if($id > 0){
				return $id;
			}else{
				return $this->obDbase->Insert_ID();			
			}
		}
	}
	
	function m_AddEditHotspot($arData, $id = NULL)
	{
		#for potrait mode
		$x = 473;
		$x1 = 768/$x;
		$x_pos = $x1 * $arData['iXPos'];
		
		$y = 630;
		$y1 = 1004/$y;
		$y_pos = $y1 * $arData['iYPos'];
		
		#for landscape mode
		//$xa = ;
		$xa1 = 1024/$x;
		$xa_pos = $xa1 * $arData['iXPos'];
		
		//$ya = ;
		$ya1 = 748/$y;
		$ya_pos = $ya1 * $arData['iYPos'];
		
		if($id > 0)
		{						
			$stQuery = "UPDATE tb_hotspots 
			SET iXPos='".$arData['iXPos']."',
				iYPos='".$arData['iYPos']."',
				iXPosPotrait='".$x_pos."',
				iYPosPotrait='".$y_pos."',
				iXPosLandscape='".$xa_pos."',
				iYPosLandscape='".$ya_pos."'
			WHERE iId=".$id;
		}
		else
		{
			$stQuery = "INSERT INTO tb_hotspots 
			SET iPubFileId='".$arData['iPubFileId']."',
				iXPos='".$arData['iXPos']."',
				iYPos='".$arData['iYPos']."',
				iXPosPotrait='".$x_pos."',
				iYPosPotrait='".$y_pos."',
				iXPosLandscape='".$xa_pos."',
				iYPosLandscape='".$ya_pos."',
				eType='".$arData['eType']."',
				vDivId='".$arData['vDivId']."'";
		}		
		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);	
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			if($id > 0){
				return $id;
			}else{
				return $this->obDbase->Insert_ID();			
			}
		}
	}
	
	function m_AddArticle($arData, $id = NULL)
	{
		if($id > 0)
		{						
			$stQuery = "UPDATE tb_article 
			SET iClientId='".$arData['iClientId']."',
				vName='".addslashes($arData['vName'])."'
			WHERE iId=".$id;
		}
		else
		{
			$stQuery = "INSERT INTO tb_article 
			SET iClientId='".$arData['iClientId']."',
			iPublicationId='".$arData['iPublicationId']."',
			vName='".addslashes($arData['vName'])."'";
		}		
		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);	
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			if($id > 0){
				return $id;
			}else{
				return $this->obDbase->Insert_ID();			
			}
		}
	}
	
	function m_AssociateArticleWithPubFile($arData)
	{
		$stQuery = "UPDATE tb_publication_files 
		SET iArticleId='".$arData['iArticleId']."'
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
	
	function m_UpdateGalleryRecords($arData)
	{
		$stQuery = "UPDATE tb_hotspot_files 
		SET vName='".addslashes($arData['vName'])."',
			vDesc='".addslashes($arData['vDesc'])."'
		WHERE iHotspotId=".$arData['iHotspotId'];
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
	
	function m_AddEditHotspotFile($arData, $id = NULL)
	{
		if($id > 0)
		{						
			$stQuery = "UPDATE tb_hotspot_files 
			SET iHotspotId='".addslashes($arData['iHotspotId'])."',
				vName='".addslashes($arData['vName'])."',
				vDesc='".addslashes($arData['vDesc'])."',
				vLink='".addslashes($arData['vLink'])."',
				vFile='".$arData['vFile']."'
			WHERE iId=$id";
		}
		else
		{
			$stQuery = "INSERT INTO tb_hotspot_files 
			SET iHotspotId='".addslashes($arData['iHotspotId'])."',
				vName='".addslashes($arData['vName'])."',
				vDesc='".addslashes($arData['vDesc'])."',
				vLink='".addslashes($arData['vLink'])."',
				vFile='".$arData['vFile']."'";
		}		
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);	
		if (!$rsResult)
		{  				
			return false;
		}
		else
		{
			if($id > 0){
				return $id;
			}else{
				return $this->obDbase->Insert_ID();			
			}
		}
	}
	
	function m_AddPublicationImage($arData)
	{
		$stQuery = "INSERT INTO tb_publication_files
		SET vFile='".$arData['file_name']."', 
			vDispName='".addslashes($arData['disp_name'])."',
			
			iPublicationId='".$arData['pub_id']."'";
		// print $stQuery; die;
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult){  				
			return false;
		}else{
			return $this->obDbase->Insert_ID();			
		}
	}
	
	function m_DeleteRecord($table, $id)
	{
		$stQuery = "DELETE FROM $table WHERE iId IN ($id)";
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult){  				
			return false;
		}else{
			return $this->obDbase->Insert_ID();			
		}
	}
	
	function m_PublishPublication($id, $val)
	{
		$stQuery = "UPDATE tb_publication SET iPublished=$val WHERE iId=$id";
		$rsResult = $this->obDbase->Execute($stQuery);					
		if (!$rsResult){  				
			return false;
		}else{
			if($val == 0){
				$val=-1;
			}
			$stQuery = "UPDATE tb_client SET iConsumedSlots=iConsumedSlots+($val) WHERE iId=".$_SESSION['sesUserId'];
			$rsResult = $this->obDbase->Execute($stQuery);					
			if (!$rsResult){  				
				return false;
			}else{
				return true;			
			}		
		}
	}
	
	function m_GetClientMagazines($id)
	{						
		$stQuery = "SELECT m.* FROM tb_app a INNER JOIN tb_magazine m ON a.iId=m.iAppId WHERE a.iClientId=$id";
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
	
	function m_GetPublicationFiles($pub_id)
	{						
		$stQuery = "SELECT pf.*, a.vName as art_name FROM tb_publication_files pf LEFT JOIN tb_article a ON a.iId=pf.iArticleId WHERE pf.iPublicationId=$pub_id";
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
	
	function m_GetPublications($id)
	{						
		$stQuery = "SELECT p.*, 
		(SELECT COUNT(iId) FROM tb_publication_files WHERE iPublicationId=p.iId) AS total_pages, 
		(SELECT vFile FROM tb_publication_files WHERE iPublicationId=p.iId ORDER BY iId LIMIT 1) AS vFile FROM tb_publication p WHERE p.iMagazineId=$id ORDER BY p.iId DESC";
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

}#END class c_ProductDb
?>
