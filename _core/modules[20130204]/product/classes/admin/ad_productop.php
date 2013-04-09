<?php
require_once(CLASS_PATH.'prevNext.php'); # Upload class
require(MODULE_PATH."product/message.php");
require(MODULE_PATH."product/classes/admin/productdb.php");
require(LIBRARY_PATH."image.php");

class c_AdProductOperation
{
	var $smarty;
	
	#Constructor
	function __construct($obSmarty)	
	{			
		$this->smarty = $obSmarty;
		$this->dbHandler = new c_AdminProductDb();
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

	
#------------------------- Category Functions -----------------------------#
	#Function to display product list.
	function m_CategoryList()
	{	
		global $attributes,$arAdminDetail,$_CONF;
		$smarty = $this->smarty;	
		$stMsg = "";
		$cond = "";
		// If any message in query string
		if(isset($attributes['msg']) && $attributes['msg'])
		{
			$stMsg = constant($_GET['msg']);
		}
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stCategoryIds = implode(",", $attributes['chkPage']);
				$rsResult = $this->dbHandler->m_RecordAction('tb_category', $stCategoryIds, $attributes['selAction']);
				if($rsResult)
				{				
					header("Location:".SITE_URL."product/adminindex.php?action=categorylist&msg=CATEGORY_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		if(count($_POST)>0 && isset($attributes['txtCategory']))
		{
			#print"<pre>";
			#print_r($attributes);
			$arData = array();
			$arData['stCategory'] = $attributes['txtCategory'];
			// for server side validations						
			if($this->m_ValidateCategory($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{									
				$rsResult= $this->dbHandler->m_AddEditCategory($arData, $attributes['categoryid']);												
				if($rsResult)
				{					
					if(isset($attributes['categoryid']) && !empty($attributes['categoryid']))
					{
						$stMessage = "CATEGORY_EDIT";
					}
					else
					{
						$stMessage = "CATEGORY_ADDED";
					}				
					header("Location:".SITE_URL."product/adminindex.php?action=categorylist&msg=".$stMessage."&".$stExtraAtt);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['categoryid']))
		{			
			$rsResult = $this->dbHandler->m_GetCategoryDetail($attributes['categoryid']);
			if($rsResult)
			{
				$arData['stCategory'] = $rsResult->fields['vTitle'];
				$smarty->assign("CATEGORY_ID", $rsResult->fields['iId']);
			}
			else
			{					
				$stMsg = QUERY_ERROR;
			}
		}
		else
		{
			$arData['stCategory'] = "";
			$arData['stCategoryFR'] = "";
		}
		$smarty->assign("CATEGORY", $arData['stCategory']);
		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;

		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_category');	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			// code for paging		
			$stPagingParam	= "action=".$attributes['action'];
			if(isset($attributes['categoryid']) && !empty($attributes['categoryid']))
				$cond = "WHERE iId<>".$attributes['categoryid'];
			$qry = "SELECT iId, vTitle, iActive FROM tb_category $cond ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$extraStr = $stPagingParam;
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arCategoryId = array();
			$arCategoryTitle = array();	
			$arCategoryStatus = array();
			while(!$resArr['qryRes']->EOF)
			{						
				$arCategoryId[]= $resArr['qryRes']->fields['iId'];
				$arCategoryTitle[] = $resArr['qryRes']->fields['vTitle'];
				$arCategoryStatus[] = $resArr['qryRes']->fields['iActive'];
				$resArr['qryRes']->MoveNext();
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_CATEGORY_ID",$arCategoryId);
			$smarty->assign("ARR_CATEGORY_TITLE",$arCategoryTitle);
			$smarty->assign("ARR_CATEGORY_STATUS",$arCategoryStatus);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
		// $smarty->assign('TOP_NAVIGATION',"<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;&nbsp;<b>Manage Product Categories</b>");
		$smarty->assign('TOP_NAVIGATION',"Manage Categories");
		$innerTemp = $smarty->fetch('categorylist.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to validate form filds
	function m_ValidateCategory($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		
		if($arData['stCategory'] == "") 
		{
			$stErrorMsg .= BLANK_CATEGORY_TITLE."<br>";				
			$blIsError = true;
		}
		else
		{
			$rsCategoryResult = $this->dbHandler->m_CheckCategoryTitleExistence($arData['stCategory'], $attributes['categoryid']);
			if($rsCategoryResult)
			{
				if($rsCategoryResult->NumRows() > 0)
				{					
					$stErrorMsg .= CATEGORY_TITLE_EXISTS."<br>";
					$blIsError = true;
				}
			}
			else
			{				
				$stErrorMsg .= QUERY_ERROR."<br>";
				$blIsError = true;
			}
		}	
		return $blIsError;
	}#END function m_ValidatePage($arData,$stErrorMsg)
	
	#Function to delete category
	function m_DeleteCategory()
	{
		global $attributes,$_CONF;
		$smarty = $this->smarty;

		$rsResult = $this->dbHandler->m_RecordAction('tb_category', $attributes['categoryid'], 'delete');
		if($rsResult)
		{
			header("Location:".SITE_URL."product/adminindex.php?action=categorylist&msg=CATEGORY_DELETE");
			exit();
		}
	}#END function m_DeleteCategory()
	

#------------------------- Campaign Functions -----------------------------#
	function m_GetClientCampaigns()
	{	
		global $attributes;
		$data = $this->dbHandler->m_GetClientCampaigns($attributes['clientid']);
		$html = '';
		if($data && $data->NumRows() > 0)
		{
			$html .= '<table width="100%" cellpadding="0" cellspacing="0" class="grid" style="margin-bottom:0;">';	
			$html .= '<tr>';
			$html .= '<th onclick="hideRows(\'client_rows\', \'client_plus\');" style="cursor:pointer;">+/-</th>';
			$html .= '<th>Campaign Name</th>';
			$html .= '<th>Start Date</th>';					
			$html .= '<th>End Date</th>';					
			$html .= '<th class="status">Status</th>';
			$html .= '</tr>';
			while(!$data->EOF)
			{
				$html .= '<tr>';
				$html .= '<td class="check_list client_plus" id="campaign_expand_'.$data->fields['iId'].'" onclick="showContents('.$data->fields['iId'].')" style="cursor:pointer;font-weight:bold;font-size:20px;">+</td>';
				$html .= '<td>'.$this->m_DisplayData($data->fields['vName']).'</td>';
				$html .= '<td>'.date('d/m/Y', strtotime($data->fields['dStartDate'])).'</td>';
				$html .= '<td>'.date('d/m/Y', strtotime($data->fields['dEndDate'])).'</td>';
				$html .= '<td class="status">';
				$html .= '<a href="'.SITE_URL.'product/adminindex.php?action=aeproduct&productid='.$data->fields['iId'].'"><img src="'.ADMIN_GRAPHICS_URL.'icon_edit.png" alt="Edit" title="Edit" border="0"></a>';
				if($data->fields['iActive'] == 1){
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_status.png" alt="Active" title="Active" />';
				}else{
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_inactive.gif" alt="Inactive" title="Inactive" />';
				}
				$html .= '</td>';
				$html .= '</tr>	';
				$html .= '<tr>';
				$html .= '<td style="padding:0;background-color:#ffffe6;" colspan="5" align="center" class="client_rows" id="content_'.$data->fields['iId'].'"></td>';
				$html .= '</tr>';
				$data->MoveNext();
			}
			$html .= '</table>';	
		}
		else{
			$html .= 'Currently, there is no campaign for this client.';
		}
		print $html;
		die;
	}
	
	function m_GetCampaignContents()
	{	
		global $attributes;
		$data = $this->dbHandler->m_GetCampaignContents($attributes['campaignid']);
		$html = '';
		if($data && $data->NumRows() > 0)
		{
			$html .= '<table width="100%" cellpadding="0" cellspacing="0" class="grid" style="margin-bottom:0;">';	
			$html .= '<tr>';
			$html .= '<th onclick="hideRows(\'content_rows\', \'content_plus\');" style="cursor:pointer;">+/-</th>';
			$html .= '<th>Content Name</th>';
			$html .= '<th>Category</th>';					
			$html .= '<th class="status">Status</th>';
			$html .= '</tr>';
			while(!$data->EOF)
			{
				$html .= '<tr>';
				$html .= '<td class="check_list content_plus" id="content_expand_'.$data->fields['iId'].'" onclick="showARItems('.$data->fields['iId'].')" style="cursor:pointer;font-weight:bold;font-size:20px;">+</td>';
				$html .= '<td>'.$this->m_DisplayData($data->fields['vName']).'</td>';
				$html .= '<td>'.$this->m_DisplayData($data->fields['category']).'</td>';
				$html .= '<td class="status">';
				$html .= '<a href="'.SITE_URL.'product/adminindex.php?action=aecontent&contentid='.base64_encode($data->fields['iId']).'"><img src="'.ADMIN_GRAPHICS_URL.'icon_edit.png" alt="Edit" title="Edit" border="0"></a>';
				if($data->fields['iActive'] == 1){
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_status.png" alt="Active" title="Active" />';
				}else{
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_inactive.gif" alt="Inactive" title="Inactive" />';
				}
				$html .= '</td>';
				$html .= '</tr>	';
				$html .= '<tr>';
				$html .= '<td style="padding:0;background-color:#caffca;" colspan="5" align="center" class="content_rows" id="aritem_'.$data->fields['iId'].'"></td>';
				$html .= '</tr>';
				$data->MoveNext();
			}
			$html .= '</table>';	
		}
		else{
			$html .= 'Currently, there is no content for this campaign.';
		}
		print $html;
		die;
	}

	function m_GetContentARItems()
	{	
		global $attributes;
		$data = $this->dbHandler->m_GetContentARItems($attributes['contentid']);
		$html = '';
		if($data && $data->NumRows() > 0)
		{
			$html .= '<table width="100%" cellpadding="0" cellspacing="0" class="grid" style="margin-bottom:0;">';	
			$html .= '<tr>';
			$html .= '<th>AR Item Name</th>';
			$html .= '<th>Dataset Image Name</th>';					
			$html .= '<th class="status">Status</th>';
			$html .= '</tr>';
			while(!$data->EOF)
			{
				$html .= '<tr>';
				$html .= '<td>';
				$html .= stripslashes($data->fields['vObjectName']);				
				$html .= '</td>';
				$html .= '<td>'.$this->m_DisplayData($data->fields['name']).'</td>';
				$html .= '<td class="status">';
				if($data->fields['iActive'] == 1){
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_status.png" alt="Active" title="Active" />';
				}else{
					$html .= '<img src="'.ADMIN_GRAPHICS_URL.'icon_inactive.gif" alt="Inactive" title="Inactive" />';
				}
				$html .= '</td>';
				$html .= '</tr>	';
				$data->MoveNext();
			}
			$html .= '</table>';	
		}
		else{
			$html .= 'Currently, there is no AR Item for this content.';
		}
		print $html;
		die;
	}
	
	function m_GetClientProducts()
	{	
		global $attributes;
		$content = $this->dbHandler->m_GetClientContent($attributes['clientid']);
		$arProducts = explode(',', $attributes['content_ids']);
		$products = '';
		if($content)
		{
			while(!$content->EOF)
			{
				if(in_array($content->fields['iId'], $arProducts)){
					$checked = "checked=checked";
				}else{
					$checked = "";
				}
				
				$products .= '<div class="product"><input type="checkbox" name="content[]" '.$checked.' value="'.$content->fields['iId'].'" />';
				$products .= $this->m_DisplayData($content->fields['vName'])."</div>";
				$content->MoveNext();
			}
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		if($products == ""){
			$products = "<span class='errMsg'>Currently there is no content uploaded for this client.</span>";
		}
		print $products;
		die;
	}

	#Function to display campaign list.
	function m_CampaignList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stCampaignIds = implode(",", $attributes['chkPage']);
				$rsResult = $this->dbHandler->m_RecordAction('tb_campaign', $stCampaignIds, $attributes['selAction']);
				if($rsResult)
				{	
					header("Location:".SITE_URL."product/adminindex.php?action=productlist&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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

		$where = "WHERE 1=1";
		
		if($_SESSION['user']['vType'] == 'C'){
			$where .= " AND c.iClientId=".$_SESSION['user']['iId'];
		}
		elseif(isset($attributes['client_id']) && $attributes['client_id']>0){
			$where .= " AND c.iClientId=".$attributes['client_id'];
		}
		
		$inRowCount = $this->dbHandler->m_GetCampaignCount($where);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			// code for paging		
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= isset($attributes['client_id'])?"&client_id=".$attributes['client_id']:'';
			$qry = "SELECT c.*, cl.vName as client FROM tb_campaign c INNER JOIN tb_client cl ON c.iClientId=cl.iId $where ORDER BY c.iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			while(!$resArr['qryRes']->EOF)
			{						
				$arData[]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
			}
			// print "<pre>"; print_r($arData); die;
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		
		#Client
		$client = $this->dbHandler->m_GetClient();
		$arClientId = array();
		$arClientTitle = array();
		if($client)
		{
			while(!$client->EOF)
			{
				$arClientId[]= $client->fields['iId'];
				$arClientTitle[] = $this->m_DisplayData($client->fields['vName']);	
				$client->MoveNext();
			}
			if(!isset($attributes['client_id'])){
				$attributes['client_id'] = 0;
			}
			$smarty->assign('SELECTED', $attributes['client_id']);
			$smarty->assign('VALS', $arClientId);
			$smarty->assign('OUTPUT', $arClientTitle);
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
		$smarty->assign('TOP_NAVIGATION',"Manage Campaigns");
		$innerTemp = $smarty->fetch('productlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete product
	function m_DeleteCampaign()
	{
		global $attributes,$_CONF;
		
		$rsResult = $this->dbHandler->m_RecordAction('tb_campaign', $attributes['productid'], 'delete');
		if($rsResult)
		{
			header("Location:".SITE_URL."product/adminindex.php?action=productlist&msg=RECORD_DELETE");
			exit();
		}
	}

	#Function to add/adit a product
	function m_AddEditCampaign()
	{						
		global $attributes,$_CONF;
		$smarty = $this->smarty;
		$stErrorMsg = "";		
		$stExtraAtt = "";
		$arData = "";
		$stMsg = "";
		
		if(!isset($attributes['page']))
			$attributes['page'] = 1;
		$stExtraAtt  = '&page='.$attributes['page'];
		$smarty->assign('EXTRA_ATT',$stExtraAtt);		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($attributes['msg']);
		}
		if(count($_POST)>0)
		{			
			// print "<pre>"; print_r($attributes); die;
			$arData = array();			
			$arData['vName'] = $attributes['vName'];
			$arData['iClientId'] = $attributes['iClientId'];
			$arData['vDescription'] = $attributes['vDescription'];
			$arData['dStartDate'] = $attributes['dStartDate'];
			$arData['dEndDate'] = $attributes['dEndDate'];
			/* if(isset($attributes['content'])){
				$arData['vContentIds'] = implode(',',$attributes['content']);
			}else{
				$arData['vContentIds'] = "";
			} */
			
			if(isset($attributes['iActive']) && $attributes['iActive'] == 'on')
			{
				$arData['iActive'] = 1;
			}
			else
			{
				$arData['iActive'] = 0;
			}
			// for server side validations						
			if($this->m_ValidateCampaign($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{									
				$rsResult= $this->dbHandler->m_AddEditCampaign($arData, $attributes['productid']);												
				if($rsResult)
				{					
					if(isset($attributes['productid']) && !empty($attributes['productid']))
					{
						$stMessage = "RECORD_EDIT";
					}
					else
					{
						$stMessage = "RECORD_ADDED";
					}
				
					header("Location:".SITE_URL."product/adminindex.php?action=productlist&msg=".$stMessage."&".$stExtraAtt);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['productid']))
		{			
			$rsResult = $this->dbHandler->m_GetCampaignDetail($attributes['productid']);
			if($rsResult)
			{
				$arData = array();
				$arData['vName'] = $rsResult->fields['vName'];
				$arData['iClientId'] = $rsResult->fields['iClientId'];
				// $arData['vContentIds'] = $rsResult->fields['vContentIds'];
				$arData['vDescription'] = $rsResult->fields['vDescription'];
				$arData['dStartDate'] = $rsResult->fields['dStartDate'];
				$arData['dEndDate'] = $rsResult->fields['dEndDate'];
				$arData['iActive'] = $rsResult->fields['iActive'];
			}
			else
			{					
				$stMsg = QUERY_ERROR;
			}
		}
		else
		{			
			$arData = array();
				$arData['vName'] = '';
				$arData['iClientId'] = '';
				// $arData['vContentIds'] = '';
				$arData['vDescription'] = '';
				$arData['dStartDate'] = '';
				$arData['dEndDate'] = '';
				$arData['iActive'] = 1;
		}
		// print "<pre>"; print_r($arData);
		$smarty->assign('DATA', $arData);
		
		#Client
		$client = $this->dbHandler->m_GetClient();
		$arClientId = array();
		$arClientTitle = array();
		if($client)
		{
			while(!$client->EOF)
			{
				$arClientId[]= $client->fields['iId'];
				$arClientTitle[] = $this->m_DisplayData($client->fields['vName']);	
				$client->MoveNext();
			}
			$smarty->assign('SELECTED', $arData['iClientId']);
			$smarty->assign('VALS', $arClientId);
			$smarty->assign('OUTPUT', $arClientTitle);
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		
		if(isset($attributes['productid']))
		{
			$stAction = "Edit Campaign";
		}
		else
		{
			$stAction = "Add Campaign";
		}
		
		$smarty->assign('PAGE', $attributes['page']);

		if(isset( $attributes['productid']))
			$smarty->assign('PRODUCT_ID', $attributes['productid']);
		// $smarty->assign('TOP_NAVIGATION', "<a href=".SITE_URL."adminindex.php>Home</a>&nbsp;&raquo;<a href=".SITE_URL."product/adminindex.php?action=productlist>Manage Campaign</a>&nbsp;&raquo;&nbsp;<b>".$stAction."</b>");			
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		$innerTemp = $smarty->fetch('addeditproduct.tpl.html');		
		return $innerTemp;
	}#END function m_AddEditCampaign()
	
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

	#Function to validate form filds
	function m_ValidateCampaign($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
					
		if($arData['vName'] == "") 
		{
			$stErrorMsg .= "Please enter the campaign name.<br>";				
			$blIsError = true;
		}
		
		if($arData['iClientId'] == "0") 
		{
			$stErrorMsg .= "Please select the client.<br>";				
			$blIsError = true;
		}
		/* if($arData['vContentIds'] == "") 
		{
			$stErrorMsg .= "Please select the content for this campaign.<br>";				
			$blIsError = true;
		} */
		if(trim($arData['vDescription']) == '')
		{
			$stErrorMsg .= 'Please enter  the description.<br/>';
			$blIsError = true;
		}
		if($arData['dStartDate'] == "") 
		{
			$stErrorMsg .= "Please select the start date.<br>";				
			$blIsError = true;
		}
		if($arData['dStartDate'] == "") 
		{
			$stErrorMsg .= "Please select the end date.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}#END function m_ValidatePage($arData,$stErrorMsg)
	
#------------------------- Content Functions -----------------------------#
	#Function to display content list.
	function m_ContentList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		// print "<pre>"; print_r($attributes); die;
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stContentIds ='';
				foreach($attributes['chkPage'] as $key){
					$stContentIds .= base64_decode($key).',';
					if($attributes['selAction'] == "delete"){
						$this->m_DeleteContent(base64_decode($key), false);
					}
				}
				$rsResult = $this->dbHandler->m_RecordAction('tb_content', rtrim($stContentIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location:".SITE_URL."product/adminindex.php?action=contentlist&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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

		$where = "WHERE 1=1";
		if($_SESSION['user']['vType'] == 'C'){
			$where .= " AND iClientId=".$_SESSION['user']['iId'];
		}
		elseif(isset($attributes['campaign_id']) && $attributes['campaign_id'] > 0){
			$where .= " AND iCampaignId=".$attributes['campaign_id'];
		}
		
		$inRowCount = $this->dbHandler->m_GetContentCount($where);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{	
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= isset($attributes['campaign_id'])?"&campaign_id=".$attributes['campaign_id']:'';
			$qry = "SELECT c.iId, c.vName, c.iActive, ct.vTitle as category, cl.vName as client, (SELECT COUNT(iId) FROM tb_aritem WHERE iContentId = c.iId ) as itemcnt
			FROM tb_content c INNER JOIN tb_category ct ON c.iCategoryId=ct.iId
			INNER JOIN tb_client cl ON c.iClientId=cl.iId
			$where
			ORDER BY c.iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$arData[$i]['iId']= base64_encode($resArr['qryRes']->fields['iId']);
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		
		#Campaign
		$data = $this->dbHandler->m_GetClientAndCampaign();
		$arId = array();
		$arTitle = array();
		if($data)
		{
			while(!$data->EOF)
			{
				$arId[]= $data->fields['iId'];
				$arTitle[] = $this->m_DisplayData($data->fields['client'].' &raquo; '.$data->fields['vName']);	
				$data->MoveNext();
			}
			if(!isset($attributes['campaign_id'])){
				$attributes['campaign_id'] = 0;
			}
			$smarty->assign('SELECTED', $attributes['campaign_id']);
			$smarty->assign('VALS', $arId);
			$smarty->assign('OUTPUT', $arTitle);
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
		$smarty->assign('TOP_NAVIGATION',"Manage Content");
		$innerTemp = $smarty->fetch('contentlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete content
	function m_DeleteContent($id='', $redirect=true)
	{
		global $attributes,$_CONF;
		
		if($id == ''){
			$id = base64_decode($attributes['contentid']);
		}
		
		$arARItem = $this->dbHandler->m_GetContentARItems($id);
		while(!$arARItem->EOF)
		{						
			@unlink(SITE_PATH."product/object/".$arARItem->fields['vObject']);
			$arARItem->MoveNext();
		}	
		
		$rsResult = $this->dbHandler->m_RecordAction('tb_content', $id, 'delete');
		if($rsResult)
		{
			if($redirect){
				header("Location:".SITE_URL."product/adminindex.php?action=contentlist&msg=RECORD_DELETE");
				exit();
			}
		}
	}
	
	#Function to add/adit a content
	function m_AddEditContent()
	{						
		global $attributes,$_CONF;
		$smarty = $this->smarty;
		$stErrorMsg = "";		
		$stExtraAtt = "";
		$arData = array();
		$stMsg = "";	

		if(!isset($attributes['contentid'])){
			$attributes['contentid'] = "";
		}
		else{
			$attributes['contentid'] = base64_decode($attributes['contentid']);
		}
		
		if(!isset($attributes['page']))
			$attributes['page'] = 1;
		$stExtraAtt  = '&page='.$attributes['page'];
		$smarty->assign('EXTRA_ATT',$stExtraAtt);		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($attributes['msg']);
		}
		if(count($_POST)>0)
		{			
			$arData = array();			
			$arData['vName'] = $attributes['vName'];
			$arData['vDescription'] = trim($attributes['vDescription']);
			$arData['iCategoryId'] = $attributes['iCategoryId'];
			$arData['iCampaignId'] = $attributes['iCampaignId'];
			if($_SESSION['user']['vType'] == 'C'){
				$arData['iClientId'] = $_SESSION['user']['iId'];
			}else{
				$arData['iClientId'] = $attributes['iClientId'];
			}
			$arData['dStartDate'] = $attributes['dStartDate'];
			$arData['dEndDate'] = $attributes['dEndDate'];
			/* if(isset($attributes['txtActive']) && $attributes['txtActive'] == 'on'){
				$arData['iActive'] = 1;
			}
			else{
				$arData['iActive'] = 0;
			} */
			// print "<pre>"; print_r($attributes); die;
			// for server side validations						
			if($this->m_ValidateContent($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{				
				$rsResult= $this->dbHandler->m_AddEditContent($arData, $attributes['contentid']);
				if($rsResult)
				{					
					if(isset($attributes['contentid']) && !empty($attributes['contentid']))
					{
						$stMessage = "RECORD_EDIT";
					}
					else
					{
						$stMessage = "RECORD_ADDED";
					}
				
					header("Location:".SITE_URL."product/adminindex.php?action=contentlist&msg=".$stMessage."&".$stExtraAtt);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif($attributes['contentid'] > 0)
		{			
			$rsResult = $this->dbHandler->m_GetRecordDetail('tb_content', $attributes['contentid']);
			if($rsResult)
			{
				$arData = $rsResult->fields;
			}
			else
			{					
				$stMsg = QUERY_ERROR;
			}
		}
		else
		{			
			$arData = array();
			$arData['vName'] = '';
			$arData['vDescription'] = '';
			$arData['iCategoryId'] = '';
			$arData['iClientId'] = '';
			$arData['iCampaignId'] = '';
			$arData['vLink'] = '';
			$arData['vObject'] = '';
			$arData['dStartDate'] = '';
			$arData['dEndDate'] = '';
			$arData['iActive'] = 1;
		}
		$smarty->assign('DATA', $arData);
		
		if($attributes['contentid'] > 0)
		{
			$stAction = "Edit Content";
		}
		else
		{
			$stAction = "Add Content";
		}
		
		$smarty->assign('PAGE', $attributes['page']);
		
		
		#Client
		$selClient = '<select name="iClientId" class="txtbox" onchange="setCampaign(this.value)">';
		$selClient .= '<option value="0">--Select--</option>';
		$client = $this->dbHandler->m_GetClient();
		if($client)
		{
			while(!$client->EOF)
			{
				if($arData['iClientId'] == $client->fields['iId']){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$selClient .= '<option value="'.$client->fields['iId'].'" '.$selected.'>'.$this->m_DisplayData($client->fields['vName']).'</option>';
				$client->MoveNext();
			}
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		$selClient .= '</select>';
		$smarty->assign('CLIENT', $selClient);
		
		#Category
		$selCategory = '<select name="iCategoryId" class="txtbox">';
		$selCategory .= '<option value="0">--Select--</option>';
		$campaign = $this->dbHandler->m_GetCategory();
		if($campaign)
		{
			while(!$campaign->EOF)
			{
				if($arData['iCategoryId'] == $campaign->fields['iId']){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$selCategory .= '<option value="'.$campaign->fields['iId'].'" '.$selected.'>'.$this->m_DisplayData($campaign->fields['vTitle']).'</option>';
				$campaign->MoveNext();
			}
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		$selCategory .= '</select>';
		$smarty->assign('CATEGORIES', $selCategory);
		
		if($attributes['contentid'] > 0)
			$smarty->assign('CONTENT_ID', $attributes['contentid']);
		$smarty->assign('TOP_NAVIGATION', $stAction);			
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		$innerTemp = $smarty->fetch('addeditcontent.tpl.html');		
		return $innerTemp;
	}#END function m_AddEditContent()
	
	function m_GetCampaigns()
	{
		global $attributes;
		$arData = $this->dbHandler->m_GetCampaign($attributes['clientid']);
		$html = '<select name="iCampaignId">';
		$html .= '<option value="">--Select Campaign--</option>';
		$canada = false;
		while(!$arData->EOF)
		{						
			if($attributes['campaignid'] == $arData->fields['iId'])
				$selected = 'selected="selected"';
			else
				$selected = '';
			$html .= '<option value="'.$arData->fields['iId'].'" '.$selected.'>'.$arData->fields['vName'].'</option>';
			$arData->MoveNext();
		}
		$html .= '</select>';
		print $html;
		die();
	}
	
	#Function to validate form filds
	function m_ValidateContent($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		// print "<pre>";	print_r($arData); die;
		if(trim($arData['vName']) == "") 
		{
			$stErrorMsg .= "Please enter the name.<br>";				
			$blIsError = true;
		}		
		if($_SESSION['user']['vType'] != 'C' && $arData['iClientId'] == 0) 
		{
			$stErrorMsg .= "Please select the client.<br>";				
			$blIsError = true;
		}
		if($arData['iCampaignId'] == 0) 
		{
			$stErrorMsg .= "Please select the campaign.<br>";				
			$blIsError = true;
		}
		if($arData['iCategoryId'] == 0) 
		{
			$stErrorMsg .= "Please select the category.<br>";				
			$blIsError = true;
		}		
		if(trim($arData['vDescription']) == "") 
		{
			$stErrorMsg .= "Please enter the description.<br>";				
			$blIsError = true;
		}
		if($arData['dStartDate'] == "") 
		{
			$stErrorMsg .= "Please select the start date.<br>";				
			$blIsError = true;
		}
		if($arData['dEndDate'] == "") 
		{
			$stErrorMsg .= "Please select the end date.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}#END function m_ValidatePage($arData,$stErrorMsg)	
	
	#------------------------- ARItem Functions -----------------------------#
	#Function to display content list.
	function m_ARItemList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		if(isset($attributes['contentid']) && is_numeric(base64_decode($attributes['contentid']))){
			$attributes['contentid'] = base64_decode($attributes['contentid']);
		}
		else{
			header("Location: ".SITE_URL."product/adminindex.php?action=contentlist"); 
		}
		if(!isset($attributes['id'])){
			$attributes['id'] = '';
		}
		// print "<pre>";	print_r($attributes); die;		
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stARItemIds = "";
				foreach($attributes['chkPage'] as $val){
					$stARItemIds .= base64_decode($val).',';
					if($attributes['selAction'] == "delete"){
						$this->m_DeleteARItem(base64_decode($val), false);
					}
				}
				// print $stARItemIds; die;
				$rsResult = $this->dbHandler->m_RecordAction('tb_aritem', rtrim($stARItemIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location: ".SITE_URL."product/adminindex.php?action=aritemlist&contentid=".base64_encode($attributes['contentid'])."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		elseif(count($_POST)>0)
		{			
			$arData = array();			
			$arData['iDatasetItemId'] = $attributes['iDatasetItemId'];
			$arData['iContentId'] = $attributes['contentid'];
			$arData['vWebLink'] = $attributes['vWebLink'];
			$arData['vObject'] = "";
			
			// for server side validations			
			if($this->m_ValidateARItem($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{	
				$arData['dDateTime'] = "";
				if(isset($_FILES['vObject']['name']) && trim($_FILES['vObject']['name']) != '')
				{
					$source = $_FILES['vObject']['tmp_name'];
					$arName = explode('.', $_FILES['vObject']['name']);
					$fileName = "object_".time().'.'.array_pop($arName);
					
					if(move_uploaded_file($source, SITE_PATH.'product/object/'.$fileName))
					{
						$arData['vObject'] = "vObject='".$fileName."', ";
						$arData['vObject'] .= "vObjectName='".$_FILES['vObject']['name']."', ";
						$arData['dDateTime'] = "dDateTime=NOW(),";
					}					
				} 
				elseif($attributes['iDatasetItemId_old'] != $attributes['iDatasetItemId']){
					$arData['dDateTime'] = "dDateTime=NOW(),";
				}
				$rsResult= $this->dbHandler->m_AddEditARItem($arData, base64_decode($attributes['id']));
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
				
					header("Location:".SITE_URL."product/adminindex.php?action=aritemlist&contentid=".base64_encode($attributes['contentid'])."&msg=".$stMessage);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['id']) && !empty($attributes['id']))
		{			
			$rsData = $this->dbHandler->m_GetRecordDetail('tb_aritem', base64_decode($attributes['id']));
			$arData = $rsData->fields;
		}
		else
		{			
			$arData = array();
			$arData['iDatasetItemId'] = '';
			$arData['iContentId'] = $attributes['contentid'];
			$arData['iActive'] = 1;
		}
		$smarty->assign('DATA', $arData);
		
		#Object Type
		$selContentType = '<select name="iDatasetItemId" class="txtbox">';
		$selContentType .= '<option value="0">--Select--</option>';
		$ContentType = $this->dbHandler->m_GetDatasetItems();
		if($ContentType)
		{
			while(!$ContentType->EOF)
			{
				if($arData['iDatasetItemId'] == $ContentType->fields['iId']){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$selContentType .= '<option value="'.$ContentType->fields['iId'].'" '.$selected.'>'.$this->m_DisplayData($ContentType->fields['vName']).'</option>';
				$ContentType->MoveNext();
			}
			$selContentType .= '<input type="hidden" name="iDatasetItemId_old" value="'.$arData['iDatasetItemId'].'" />';
		}
		else{
			$stMsg = QUERY_ERROR;
		}
		$selContentType .= '</select>';
		$smarty->assign('CONTENTTYPE', $selContentType);

		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;
		// print_r($attributes);
		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_aritem', 'WHERE iContentId='.$attributes['contentid']);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			if($_SESSION['user']['vType'] == 'C'){
				$where = "WHERE iClientId=".$_SESSION['user']['iId'];
			}
			else{
				$where = "";
			}
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= "&contentid=".base64_encode($attributes['contentid']);
			$qry = "SELECT ar.*, dsi.vName FROM tb_aritem ar 
			INNER JOIN tb_dataset_item dsi ON dsi.iId=ar.iDatasetItemId 
			WHERE iContentId = '".($attributes['contentid'])."' ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$arData[$i]['iId']= base64_encode($resArr['qryRes']->fields['iId']);
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
			
		$rsContent = $this->dbHandler->m_GetRecordDetail('tb_content', $attributes['contentid']);
		$smarty->assign('TOP_NAVIGATION',"Manage AR Items for ".stripslashes($rsContent->fields['vName']));
		$innerTemp = $smarty->fetch('aritemlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete aritem
	function m_DeleteARItem($id='', $redirect=true)
	{
		global $attributes,$_CONF;
		
		if($id == ''){
			$id = base64_decode($attributes['id']);
		}
		
		$arData = $this->dbHandler->m_GetRecordDetail("tb_aritem", $id);
		$rsResult = $this->dbHandler->m_RecordAction('tb_aritem', $id, 'delete');
		if($rsResult)
		{
			@unlink(SITE_PATH."product/object/".$arData->fields['vObject']);
			
			if($redirect){
				header("Location:".SITE_URL."product/adminindex.php?action=aritemlist&msg=RECORD_DELETE&contentid=".$attributes['contentid']);
				exit();
			}
		}
	}
	
	#Function to validate form filds
	function m_ValidateARItem($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		// print "<pre>";	print_r($arData); die;
		if($arData['iDatasetItemId'] == 0) 
		{
			$stErrorMsg .= "Please select a dataset image.<br>";				
			$blIsError = true;
		}
		elseif(!$this->dbHandler->m_ValidateDataset($arData['iDatasetItemId'], base64_decode($attributes['id'])))
		{
			$stErrorMsg .= "Dataset image is already associated.<br>";				
			$blIsError = true;
		}
		if($attributes['id'] == "" && $_FILES['vObject']['name'] == "")
		{
			$stErrorMsg .= "Please select the object to upload.<br>";				
			$blIsError = true;
		} 
		return $blIsError;
	}



#------------------------- Dataset Functions -----------------------------#
	#Function to display content list.
	function m_DatasetList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		
		if(!isset($attributes['id'])){
			$attributes['id'] = '';
		}
		// print "<pre>";	print_r($attributes); die;		
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stDatasetIds = "";
				foreach($attributes['chkPage'] as $val){
					$stDatasetIds .= $val.',';
					/* if($attributes['selAction'] == 'delete'){
						$this->m_DeleteDataset($val, false);
					} */
				}
				// print $stDatasetIds; die;
				$rsResult = $this->dbHandler->m_RecordAction('tb_dataset', rtrim($stDatasetIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location: ".SITE_URL."product/adminindex.php?action=datasetlist&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		elseif(count($_POST)>0)
		{			
			$arData = array();			
			if($this->m_ValidateDataset($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{				
				if(isset($_FILES['vObject']['name']) && trim($_FILES['vObject']['name']) != '')
				{
					$source = $_FILES['vObject']['tmp_name'];
					$arName = explode('.', $_FILES['vObject']['name']);
					$fileName = "object_".time().'.'.array_pop($arName);
					if(move_uploaded_file($source, SITE_PATH.'product/dataset/'.$fileName))
					{
						$arData['vObject'] = "vObject='".$fileName."', ";
						$arData['vObject'] .= "vObjectName='".$_FILES['vObject']['name']."', ";
					}					
				}
				// print "<pre>";	print_r($arData); die;
				$rsResult= $this->dbHandler->m_AddEditDataset($arData, $attributes['id']);
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
				
					header("Location:".SITE_URL."product/adminindex.php?action=datasetlist&msg=".$stMessage);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		else
		{			
			$arData = array();
			$arData['vObject'] = '';
		}
		$smarty->assign('DATA', $arData);
		
		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum * $inPerPage;

		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_dataset');	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			$extraStr	= "action=".$attributes['action'];
			$qry = "SELECT ds.*, (SELECT COUNT(iId) FROM tb_dataset_item WHERE iDatasetId=ds.iId) as item_cnt FROM tb_dataset ds ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
			
		$smarty->assign('TOP_NAVIGATION',"Manage Dataset");
		$innerTemp = $smarty->fetch('datasetlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete dataset
	function m_DeleteDataset($id='')
	{
		global $attributes,$_CONF;
		
		if($id == ''){
			$id = $attributes['id'];
		}
		
		$arDataItem = $this->dbHandler->m_GetDatasetItems(" WHERE iDatasetId=".$id);
		while(!$arDataItem->EOF)
		{						
			@unlink(SITE_PATH."product/dataset/small/".$arDataItem->fields['vImage']);
			@unlink(SITE_PATH."product/dataset/thumb/".$arDataItem->fields['vImage']);
			$arDataItem->MoveNext();
		}
		
		$arData = $this->dbHandler->m_GetRecordDetail('tb_dataset', $id);		
		$rsResult = $this->dbHandler->m_RecordAction('tb_dataset', $id, 'delete');
		if($rsResult)
		{
			@unlink(SITE_PATH."product/dataset/".$arData->fields['vObject']);			
			header("Location:".SITE_URL."product/adminindex.php?action=datasetlist&msg=RECORD_DELETE");
				exit();
		}
	}
	
	#Function to validate form filds
	function m_ValidateDataset($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		// print "<pre>";	print_r($arData); die;
		if($attributes['id'] == "" && $_FILES['vObject']['name'] == "")
		{
			$stErrorMsg .= "Please select the object to upload.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}	
	
	
	#------------------------- ARItem Functions -----------------------------#
	#Function to display content list.
	function m_DatasetItemList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		if(!isset($attributes['id'])){
			$attributes['id'] = '';
		}
		// print "<pre>"; print_r($attributes); die;
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			$arData = array();
			$arData['vName'] = '';
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stDatasetItemIds = "";
				foreach($attributes['chkPage'] as $val){
					$stDatasetItemIds .= ($val).',';
					if($attributes['selAction'] == 'delete'){
						$this->m_DeleteDatasetItem($val, false);
					}
				}
				// print $stDatasetItemIds; die;
				$rsResult = $this->dbHandler->m_RecordAction('tb_dataset_item', rtrim($stDatasetItemIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location: ".SITE_URL."product/adminindex.php?action=datasetitemlist&datasetid=".($attributes['datasetid'])."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		elseif(count($_POST)>0)
		{			
			$arData = array();			
			$arData['vName'] = $attributes['vName'];
			$arData['iDatasetId'] = $attributes['datasetid'];
			
			if($this->m_ValidateDatasetItem($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{			
				$smallImgPath = SITE_PATH.'product/dataset/small/';
				$thumbImgPath = SITE_PATH.'product/dataset/thumb/';
				if(isset($_FILES['vObject']['name']) && trim($_FILES['vObject']['name']) != '')
				{
						$source = $_FILES['vObject']['tmp_name'];
						$arName = explode('.', $_FILES['vObject']['name']);
						$fileName = "product_".time().'.'.array_pop($arName);
						$smallImgUpload = $this->m_UploadImage($source, $smallImgPath.$fileName, true,50,50);
						$smallImgUpload = $this->m_UploadImage($source, $thumbImgPath.$fileName, true,200,200);
						$arData['vImage'] = " vImage = '$fileName', ";
				}
				else{
					$arData['vImage'] = '';
				}
				$rsResult= $this->dbHandler->m_AddEditDatasetItem($arData, $attributes['id']);
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
				
					header("Location:".SITE_URL."product/adminindex.php?action=datasetitemlist&datasetid=".($attributes['datasetid'])."&msg=".$stMessage);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['id']) && $attributes['id'] > 0)
		{		
			$rsData = $this->dbHandler->m_GetRecordDetail('tb_dataset_item', $attributes['id']);
			$arData = array();			
			$arData['vName'] = $rsData->fields['vName'];
		}
		else
		{			
			$arData = array();
			$arData['vName'] = '';
		}
		$smarty->assign('DATA', $arData);
		
		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;

		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_dataset_item', 'WHERE iDatasetId='.$attributes['datasetid']);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= "&datasetid=".($attributes['datasetid']);
			$qry = "SELECT * FROM tb_dataset_item  
			WHERE iDatasetId = '".$attributes['datasetid']."' ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, PAGE_SIZE,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
			
		$rsContent = $this->dbHandler->m_GetRecordDetail('tb_dataset', $attributes['datasetid']);
		$smarty->assign('TOP_NAVIGATION',"Manage Dataset Images for ".stripslashes($rsContent->fields['vObjectName']));
		$innerTemp = $smarty->fetch('datasetitemlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete aritem
	function m_DeleteDatasetItem($id='', $redirect=true)
	{
		global $attributes,$_CONF;
		if($id == ''){
			$id = $attributes['id'];
		}
		
		$arData = $this->dbHandler->m_GetRecordDetail('tb_dataset_item', $id);		
		$rsResult = $this->dbHandler->m_RecordAction('tb_dataset_item', $id, 'delete');
		if($rsResult)
		{
			@unlink(SITE_PATH."product/dataset/small/".$arData->fields['vImage']);	
			@unlink(SITE_PATH."product/dataset/thumb/".$arData->fields['vImage']);	
			if($redirect){
				header("Location:".SITE_URL."product/adminindex.php?action=datasetitemlist&msg=RECORD_DELETE&datasetid=".$attributes['datasetid']);
				exit();
			}
		}
	}
	
	#Function to validate form filds
	function m_ValidateDatasetItem($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		if(trim($arData['vName']) == "") 
		{
			$stErrorMsg .= "Please enter the item name.<br>";				
			$blIsError = true;
		}
		elseif(!$this->dbHandler->m_ValidateDatasetItem(trim($arData['vName']), $attributes['id']))
		{
			$stErrorMsg .= "Name already exist.<br>";				
			$blIsError = true;
		}
		if($attributes['id'] == "" && $_FILES['vObject']['name'] == "")
		{
			$stErrorMsg .= "Please select the thumb image.<br>";				
			$blIsError = true;
		} 
		return $blIsError;
	}
	
	#------------------------- App Functions -----------------------------#
	function m_AppList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		if(!isset($attributes['client_id']) || !is_numeric($attributes['client_id'])){
			header("Location: ".SITE_URL."user/adminindex.php?action=clientlist");
		}
		if(!isset($attributes['id'])){
			$attributes['id'] = '';
		}
		// print "<pre>";	print_r($attributes); die;		
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stAppIds = "";
				foreach($attributes['chkPage'] as $val){
					$stAppIds .= $val.',';
					if($attributes['selAction'] == "delete"){
						$this->m_DeleteApp($val, false);
					}
				}
				// print $stAppIds; die;
				$rsResult = $this->dbHandler->m_RecordAction('tb_app', rtrim($stAppIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location: ".SITE_URL."product/adminindex.php?action=applist&client_id=".$attributes['client_id']."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		elseif(count($_POST)>0)
		{			
			$arData = array();			
			$arData['vName'] = $attributes['vName'];
			$arData['iClientId'] = $attributes['client_id'];
			$arData['vDescription'] = $attributes['vDescription'];
			$arData['vInternalDescription'] = $attributes['vInternalDescription'];
			$arData['vReference'] = $attributes['vReference'];
			$arData['dPaidDate'] = $attributes['dPaidDate'];
			
			// for server side validations			
			if($this->m_ValidateApp($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{	
				$rsResult= $this->dbHandler->m_AddEditApp($arData, $attributes['id']);
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
				
					header("Location:".SITE_URL."product/adminindex.php?action=applist&client_id=".$attributes['client_id']."&msg=".$stMessage);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['id']) && !empty($attributes['id']))
		{			
			$rsData = $this->dbHandler->m_GetRecordDetail('tb_app', $attributes['id']);
			$arData = $rsData->fields;
		}
		else
		{			
			$arData = array();
			$arData['vName'] = '';
			$arData['iClientId'] = $attributes['client_id'];
			$arData['vDescription'] = '';
			$arData['vInternalDescription'] = '';
			$arData['vReference'] = '';
			$arData['dPaidDate'] = date('Y-m-d');
			$arData['iActive'] = 1;
		}
		$smarty->assign('DATA', $arData);
		
		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;
		// print_r($attributes);
		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_app', 'WHERE iClientId='.$attributes['client_id']);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= "&client_id=".$attributes['client_id'];
			$qry = "SELECT * FROM tb_app  
			WHERE iClientId = '".($attributes['client_id'])."' ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, $inPerPage,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
			
		$rsContent = $this->dbHandler->m_GetRecordDetail('tb_client', $attributes['client_id']);
		$smarty->assign('TOP_NAVIGATION',"Manage Apps for ".stripslashes($rsContent->fields['vName']));
		$innerTemp = $smarty->fetch('applistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete app
	function m_DeleteApp($id='', $redirect=true)
	{
		global $attributes,$_CONF;
		if($id == ''){
			$id = $attributes['id'];
		}
		
		$rsResult = $this->dbHandler->m_RecordAction('tb_app', $id, 'delete');
		if($rsResult)
		{
			if($redirect){
				header("Location:".SITE_URL."product/adminindex.php?action=applist&msg=RECORD_DELETE&client_id=".$attributes['client_id']);
				exit();
			}
		}
	}
	
	#Function to validate form filds
	function m_ValidateApp($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		// print "<pre>";	print_r($arData); die;
		if(trim($arData['vName']) == "") 
		{
			$stErrorMsg .= "Please enter name.<br>";				
			$blIsError = true;
		} 
		if(trim($arData['vReference']) == "") 
		{
			$stErrorMsg .= "Please enter reference.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}
	
	#------------------------- Slot Functions -----------------------------#
	function m_SlotList()
	{	
		global $attributes,$arAdminDetail;
		$stMsg = "";
		$smarty = $this->smarty;		
		// If any message in query string
		if(isset($attributes['msg']))
		{
			$stMsg = constant($_GET['msg']);
		}
		if(!isset($attributes['client_id']) || !is_numeric($attributes['client_id'])){
			header("Location: ".SITE_URL."user/adminindex.php?action=clientlist");
		}
		if(!isset($attributes['id'])){
			$attributes['id'] = '';
		}
		// print "<pre>";	print_r($attributes); die;		
		
		$stExtraAtt  = isset($attributes['page'])?'page='.$attributes['page']."&"   : '';
		$smarty->assign('EXTRA_ATT',$stExtraAtt);
		
		// for delete action 		
		if(isset($attributes['selAction']))
		{
			if(isset($attributes['chkPage'])) // server side check for deletion process
			{
				$stSlotIds = "";
				foreach($attributes['chkPage'] as $val){
					$stSlotIds .= $val.',';
					if($attributes['selAction'] == "delete"){
						$this->m_DeleteSlot($val, false);
					}
				}
				// print $stSlotIds; die;
				$rsResult = $this->dbHandler->m_RecordAction('tb_slot', rtrim($stSlotIds, ','), $attributes['selAction']);
				if($rsResult)
				{	
					header("Location: ".SITE_URL."product/adminindex.php?action=slotlist&client_id=".$attributes['client_id']."&msg=RECORD_".strtoupper($attributes['selAction'])."&".$stExtraAtt);
					exit();
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
		elseif(count($_POST)>0)
		{			
			$arData = array();			
			$arData['iSlots'] = $attributes['iSlots'];
			$arData['iClientId'] = $attributes['client_id'];
			$arData['vReference'] = $attributes['vReference'];
			$arData['dPaidDate'] = $attributes['dPaidDate'];
			
			// for server side validations			
			if($this->m_ValidateSlot($arData, $stErrorMsg))						
			{				
				$stMsg = $stErrorMsg;
			}
			else		
			{	
				$rsResult= $this->dbHandler->m_AddEditSlot($arData, $attributes['id']);
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
				
					header("Location:".SITE_URL."product/adminindex.php?action=slotlist&client_id=".$attributes['client_id']."&msg=".$stMessage);
					exit();
				}
				else
				{					
					$stMsg = QUERY_ERROR;					
				}			
			}			
		}
		elseif(isset($attributes['id']) && !empty($attributes['id']))
		{			
			$rsData = $this->dbHandler->m_GetRecordDetail('tb_slot', $attributes['id']);
			$arData = $rsData->fields;
		}
		else
		{			
			$arData = array();
			$arData['iSlots'] = '';
			$arData['iClientId'] = $attributes['client_id'];
			$arData['vReference'] = '';
			$arData['dPaidDate'] = date('Y-m-d');
			$arData['iActive'] = 1;
		}
		$smarty->assign('DATA', $arData);
		
		$inPageNum =0;
		$inPerPage = PAGE_SIZE;
		if(isset($attributes['page']))
		{
			$inPageNum = $attributes['page']-1;
		}
		$inStart = $inPageNum*$inPerPage;
		// print_r($attributes);
		$inRowCount = $this->dbHandler->m_GetRecordCount('tb_slot', 'WHERE iClientId='.$attributes['client_id']);	
		$smarty->assign('PAGE_COUNT',$inRowCount);
				
		if($inRowCount > 0)
		{			
			$extraStr	= "action=".$attributes['action'];
			$extraStr	.= "&client_id=".$attributes['client_id'];
			$qry = "SELECT * FROM tb_slot  
			WHERE iClientId = '".($attributes['client_id'])."' ORDER BY iId DESC";			
			$pager = new PrevNext($this->dbHandler->obDbase);
			$resArr = $pager->create($qry, $inPerPage,$extraStr);			
			$smarty->assign('PAGING',$resArr['pnContents']);
			// code for paging		
			$arData = array();

			$i=0;
			while(!$resArr['qryRes']->EOF)
			{						
				$arData[$i]= $resArr['qryRes']->fields;
				$resArr['qryRes']->MoveNext();
				$i++;
			}
			$smarty->assign("IS_RECORD", true);
			$smarty->assign("ARR_DATA",$arData);
		}
		else
		{
			$smarty->assign("IS_RECORD", false);
		}
		if($stMsg)
		{
			$smarty->assign('ERROR_MSG',$stMsg);
		}
		if(isset($attributes['page']))
			$smarty->assign('PAGE', $attributes['page']);
		else
			$smarty->assign('PAGE', 1);
			
		$rsContent = $this->dbHandler->m_GetRecordDetail('tb_client', $attributes['client_id']);
		$smarty->assign('TOP_NAVIGATION',"Manage Slots for ".stripslashes($rsContent->fields['vName']));
		$innerTemp = $smarty->fetch('slotlistadmin.tpl.html');		
		return $innerTemp;
	}#END function m_CmsPageList()

	#Function to delete slot
	function m_DeleteSlot($id='', $redirect=true)
	{
		global $attributes,$_CONF;
		if($id == ''){
			$id = $attributes['id'];
		}
		$rsSlot = $this->dbHandler->m_GetRecordDetail('tb_slot', $id);
		$rsResult = $this->dbHandler->m_RecordAction('tb_slot', $id, 'delete');
		if($rsResult)
		{
			$this->dbHandler->m_UpdateSlots($rsSlot->fields['iClientId']);
			if($redirect){
				header("Location:".SITE_URL."product/adminindex.php?action=slotlist&msg=RECORD_DELETE&client_id=".$attributes['client_id']);
				exit();
			}
		}
	}
	
	#Function to validate form filds
	function m_ValidateSlot($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
		// print "<pre>";	print_r($arData); die;
		if(trim($arData['iSlots']) == "") 
		{
			$stErrorMsg .= "Please enter slots.<br>";				
			$blIsError = true;
		} 
		elseif(!is_numeric($arData['iSlots']) || $arData['iSlots'] < 0) 
		{
			$stErrorMsg .= "Please enter a numeric value for slots.<br>";				
			$blIsError = true;
		}
		if(trim($arData['vReference']) == "") 
		{
			$stErrorMsg .= "Please enter reference.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}


}#END class c_AdUserOperation
?>