<?php
#Paging Class
class PrevNext
{
	var $selfAddr;
	var $pntemplate;
	var $templatepath;		
	var $dbCon;
	var $prevLinkInfo;

	function PrevNext($dbConn)
	{
		global $PHP_SELF;
		$tempArr=array_reverse(explode("/",$PHP_SELF));
		$this->selfAddr=$tempArr[0];
		$this->dbCon = $dbConn;
	}
	
	function create($qry,$pageSize=10,$extraStr="")
	{
		if(!isset($_REQUEST['page'])){
			$page=1;
		}else{
			$page=$_REQUEST['page'];
		}
		
		if($extraStr!=""){
			$extraStr="&".$extraStr ;
		}

		$query=$qry;
		$cn=$this->dbCon;
		#print $query;
		if(!$qryResult =$cn->Execute($query)) trigger_error("Paging Error",E_USER_ERROR);
		
		$totalRecs = $qryResult->RecordCount(); 
		$numPages = ceil($totalRecs / $pageSize);
		
		if($page <= 1){
			$page = 1; 
			$query = $query . " LIMIT 0, " . $pageSize; 
		}else{ 
			$query = $query . " LIMIT " . (($page-1) * $pageSize) . ", " . $pageSize; 
		}		
		
		if(!$qryResult =$cn->Execute($query)) trigger_error("Paging Error",E_USER_ERROR);
		$resArr['qryRes']=$cn->Execute($query);			
		$resArr['totalRecs']=$qryResult->RecordCount();
		$resArr['numPages']=$numPages;
		
		$smarty = new Smarty(TEMPLATE_PATH);
		if($totalRecs <= $pageSize)
			$smarty->assign("DISABLED", 'disabled');
		else
			$smarty->assign("DISABLED", '');
		$smarty->assign('SITE_URL', SITE_URL);
		$smarty->assign('ADMIN_GRAPHICS_URL', ADMIN_GRAPHICS_URL);
		$smarty->assign("Extra", htmlentities($extraStr));
		$smarty->assign("pageNo",$page);
		$smarty->assign("totalPages",$numPages);
		if($page>1)
		{
			if(!isset($prevLinkInfo))
				$smarty->assign("prevLink",$this->selfAddr."?page=".($page -1).$extraStr);
			else
				$smarty->assign("prevLink",$prevLinkInfo);
			$smarty->assign("PREV", true);
		}else{
			$smarty->assign("PREV", false);
		}
		$arPage = array();
		for($i = 1; $i<=$numPages; $i++)
		{ 
			$smarty->assign("pageLink",$this->selfAddr."?page=".$i.$extraStr);
			$smarty->assign("dspPage",$i);
			$arPage[] = $i;
		}
		$smarty->assign("SELF_ADDR", $_SERVER['PHP_SELF']);
		$smarty->assign("VALS", $arPage);
		$smarty->assign("OUTPUT", $arPage);
		$smarty->assign("SELECTED", $page);					

		if($page < $numPages){
			$smarty->assign("nextLink",$this->selfAddr."?page=".($page+1).$extraStr);
			$smarty->assign("NEXT", true);
		}else{
			$smarty->assign("NEXT", false);
		}
		$smarty->assign("FLINK",$this->selfAddr."?page=1".$extraStr);			
		$resArr['pnContents']=$smarty->fetch('dspPrevNext.html');			
		return $resArr;
	}
}
?>