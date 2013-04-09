<?php
class c_ProductMain
{
	var $smarty;
	function __construct()
	{	
		$this->smarty = new Smarty(MODULE_PATH.'product/templates/main/');		
		$this->smarty->assign('SITE_URL', SITE_URL);	
		$this->smarty->assign('GRAPHICS_URL', GRAPHICS_URL);				
	}
	
	# Function to handle the events of product mail section 
	function m_InnerTemp($action='')
	{			
		global $attributes,$arMsg;
		$smarty = $this->smarty;
		include_once(MODULE_PATH."product/classes/main/ue_productop.php");
		$obProduct = new c_ProductOperation($smarty);				
		
		if(isset($attributes['action']) && $attributes['action'] != '')
			$action = $attributes['action'];
			
		/*if(!isset($_SESSION['sesUserId']))
		{
			header('Location: '.SITE_URL.'user/index.php?action=login');
		}*/
	
		switch($action)
		{	
			case "publist": 				
				$innerOutput = $obProduct->m_ListPublication();
			break;
			case "addpub": 				
				$innerOutput = $obProduct->m_AddPublication();
			break;
			case "addpubfile": 				
				$innerOutput = $obProduct->m_AddPublicationFile();
			break;
			case "deletepub": 				
				$innerOutput = $obProduct->m_DeletePublication();
			break;
			case "publishpub": 				
				$innerOutput = $obProduct->m_PublishPublication();
			break;
			case "addhotspot": 				
				$innerOutput = $obProduct->m_AddHotspot();
			break;
			case "deletehotspot": 				
				$innerOutput = $obProduct->m_DeleteHotspot();
			break;
			case "uploadhotspotfile": 				
				$innerOutput = $obProduct->m_UploadHotspotFile();
			break;
			case "uploadhotspotvideo": 				
				$innerOutput = $obProduct->m_UploadHotspotVideo();
			break;
			case "addhotspotgallery": 				
				$innerOutput = $obProduct->m_AddHotspotGallery();
			break;
			case "associatearticle": 				
				$innerOutput = $obProduct->m_AssociateArticleWithPubFile();
			break;
			case "addhotspotdata": 				
				$innerOutput = $obProduct->m_AddHotspotData();
			break;
			case "addarticle": 				
				$innerOutput = $obProduct->m_AddArticle();
			break;
			case "get_magazine_data": 				
				$innerOutput = $obProduct->m_GetMagazineData();
			break;
			case "getpubfiles": 				
				$innerOutput = $obProduct->m_GetPublicationFiles();
			break; 
			case "getarticles": 				
				$innerOutput = $obProduct->m_GetArticles();
			break; 
			case "gethotspotdata": 				
				$innerOutput = $obProduct->m_GetHotspotData();
			break;
			case "createimagedivs": 				
				$innerOutput = $obProduct->m_CreateImageDivs();
			break;
			case "addmedia": 				
				$innerOutput = $obProduct->m_AddMedia();
			break;			
			case "download": 
				$innerOutput = $obProduct->m_DownloadFile();
			break;
			
			case "getclientdata": 
				$innerOutput = $obProduct->m_GetClientData();
			break;
			case "getclientpublication": 
				$innerOutput = $obProduct->m_GetClientPublication();
			break;
			case "getpublicationhotspot": 
				$innerOutput = $obProduct->m_GetPublicationHotspot();
			break;
			
			//amit start
			case "getmagazinerecord": 
				$innerOutput = $obProduct->m_GetAllMagazineData();
			break;
			case "delpubimg": 
				$innerOutput = $obProduct->m_DeletePublicationImage();
			//amit start
			
			default:
				die("<h1>You are not supposed to be here.</h1>");
				// $innerOutput = $obProduct->m_GetProductList();
			break;
		}
		return $innerOutput;
	}#END function m_InnerTemp()	
}
?>
