<?php
class c_ProductAdmin
{
	var $smarty;
	function __construct()
	{	
		$this->smarty = new Smarty(MODULE_PATH.'product/templates/admin/');		
		$this->smarty->assign('SITE_URL', SITE_URL);	
		$this->smarty->assign('GRAPHICS_URL', GRAPHICS_URL);
		$this->smarty->assign('ADMIN_GRAPHICS_URL', ADMIN_GRAPHICS_URL);				
	}
	
	# Function to handle the events of user admin section 
	function m_InnerTemp($action='')
	{			
		global $attributes,$arMsg;
		$smarty = $this->smarty;
		include_once(MODULE_PATH."product/classes/admin/ad_productop.php");
		$obAdmin = new c_AdProductOperation($smarty);				
		
		if($attributes['action'] != '')
			$action = $attributes['action'];
	
		switch($action)
		{	#Category
			case "deletecategory":
				$innerOutput = $obAdmin->m_DeleteCategory();
			break;
			case "categorylist": 				
				$innerOutput = $obAdmin->m_CategoryList();
			break;
			
			#Product
			case "getcampaigns": 				
				$innerOutput = $obAdmin->m_GetClientCampaigns();
			break;
			case "getcontents": 				
				$innerOutput = $obAdmin->m_GetCampaignContents();
			break;	
			case "getaritems": 				
				$innerOutput = $obAdmin->m_GetContentARItems();
			break;				
			case "getproducts": 				
				$innerOutput = $obAdmin->m_GetClientProducts();
			break;			
			case "productlist": 				
				$innerOutput = $obAdmin->m_CampaignList();
			break;
			case "deleteproduct":
				$innerOutput = $obAdmin->m_DeleteCampaign();
			break;
			case "aeproduct": 				
				$innerOutput = $obAdmin->m_AddEditCampaign();
			break;			
			
			#Content
			case "contentlist": 				
				$innerOutput = $obAdmin->m_ContentList();
			break;
			case "deletecontent":
				$innerOutput = $obAdmin->m_DeleteContent();
			break;
			case "aecontent": 				
				$innerOutput = $obAdmin->m_AddEditContent();
			break;
			case "getcampaignsdropdown": 				
				$innerOutput = $obAdmin->m_GetCampaigns();
			break;
			
			#ARItem
			case "aritemlist": 				
				$innerOutput = $obAdmin->m_ARItemList();
			break;
			case "deletearitem":
				$innerOutput = $obAdmin->m_DeleteARItem();
			break;
			
			#Dataset
			case "datasetlist": 				
				$innerOutput = $obAdmin->m_DatasetList();
			break;
			case "deletedataset":
				$innerOutput = $obAdmin->m_DeleteDataset();
			break;
			
			#Dataset Item
			case "datasetitemlist": 				
				$innerOutput = $obAdmin->m_DatasetItemList();
			break;
			case "deletedatasetitem":
				$innerOutput = $obAdmin->m_DeleteDatasetItem();
			break;
			
			#Apps
			case "applist": 				
				$innerOutput = $obAdmin->m_AppList();
			break;
			case "deleteapp":
				$innerOutput = $obAdmin->m_DeleteApp();
			break;
			
			#Slots
			case "slotlist": 				
				$innerOutput = $obAdmin->m_SlotList();
			break;
			case "deleteslot":
				$innerOutput = $obAdmin->m_DeleteSlot();
			break;
			
			default:					
				$innerOutput = $obAdmin->m_CampaignList();
			break;
		}			
		return $innerOutput;

	}#END function m_InnerTemp()	
}
?>