<?php

	class PrevNext{
		var $selfAddr;
		var $pntemplate;
		var $templatepath;		
		var $dbCon;
		var $prevLinkInfo;

		function PrevNext($path,$tpl,$dbConn){
			global $PHP_SELF;
			$tempArr=array_reverse(explode("/",$PHP_SELF));
			$this->selfAddr=$tempArr[0];
			$this->templatepath=$path;
			$this->pntemplate=$tpl;
			$this->dbCon = $dbConn;
		}
		
		function create($qry,$pageSize=10,$extraStr=""){
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
			//$resArr['totalRecs']=$totalRecs;
			$resArr['totalRecs']=$qryResult->RecordCount();
			$resArr['numPages']=$numPages;
			
			$t = new Template($this->templatepath);	
			$t->set_file("htmlpage",$this->pntemplate);
			$t->set_block("htmlpage","prev","prevs");
			$t->set_block("htmlpage","next","nexts");
			$t->set_block("htmlpage","pagelist","pagelists");
			$t->set_var("Extra",$extraStr);
			$t->set_var("pageNo",$page);
			$t->set_var("totalPages",$numPages);
			if($page>1){
				if(!isset($prevLinkInfo))
				$t->set_var("prevLink",$this->selfAddr."?page=".($page -1).$extraStr);
				else
				$t->set_var("prevLink",$prevLinkInfo);


				$t->parse("prevs","prev",true);
			}else{
				$t->set_var("prevs","");
			}
			for($i = 1; $i<$numPages+1; $i++){ 
				$t->set_var("pageLink",$this->selfAddr."?page=".$i.$extraStr);
				$t->set_var("dspPage",$i);
					if($page == $i){
						$t->set_var("sel","selected");
					}else{
						$t->set_var("sel","");
					}
				$t->parse("pagelists","pagelist",true);
			}
				

			if($page < $numPages){
				$t->set_var("nextLink",$this->selfAddr."?page=".($page+1).$extraStr);
				$t->parse("nexts","next");
			}else{
				$t->set_var("nexts","");
			}
			$t->set_var("FLINK",$this->selfAddr."?page=1".$extraStr);

			$t->parse('output','htmlpage');	
			$resArr['pnContents']=$t->get_var("output");
			
			return $resArr;
		}
	}
?>