<?php
require_once(MODULE_PATH."product/classes/main/productdb.php");

class c_ProductOperation
{
	var $smarty;
	
	#Constructor
	function __construct($obSmarty)	
	{			
		$this->smarty = $obSmarty;
		$this->dbHandler = new c_ProductDb();
	}
	
	#Function to stripslashes and convert \n to <br>
	function m_DisplayData($stValue)
	{
		return stripslashes(nl2br($stValue));
	}#END function m_DisplayData($stValue)
	
	function m_GetHotspotData()
	{	
		global $attributes;
		$arData = array();
		// print $attributes['id']; die;
		$rsData = $this->dbHandler->m_GetHotspotData($attributes['id']);	
		while(!$rsData->EOF)
		{
			$arData[] = $rsData->fields;
			$rsData->MoveNext();
		}
		print json_encode($arData);
		die;
	} 
	
	function m_GetMagazineData()
	{	
		global $attributes;
		$arData = array();
		$rsData = $this->dbHandler->m_GetRecordDetail('tb_magazine', base64_decode($attributes['id']));	
		print json_encode($rsData->fields);
		die;
	} 
	
	function m_UploadHotspotFile()
	{
		if(isset($_FILES['userfile']['name']) && trim($_FILES['userfile']['name']) != '')
		{
			// $smallImgPath = SITE_PATH.'product/hotspot/small/';
			$thumbImgPath = SITE_PATH.'product/hotspot/thumb/';
			$orgImgPath = SITE_PATH.'product/hotspot/';
			$source = $_FILES['userfile']['tmp_name'];
			$arName = explode('.', $_FILES['userfile']['name']);
			$fileName = "hotspot_".time().'.'.array_pop($arName);
			$thumbImgPath = $this->m_UploadImage($source, $thumbImgPath.$fileName, true,290, 200);
			// $smallImgPath = $this->m_UploadImage($source, $smallImgPath.$fileName, true,290,224);
			move_uploaded_file($source, $orgImgPath.$fileName);
			print $fileName;
			die;
		}
	}
	
	function m_UploadHotspotVideo()
	{
		// print_r($_FILES['userfile']); die;
		if(isset($_FILES['userfile']['name']) && trim($_FILES['userfile']['name']) != '')
		{
			$orgImgPath = SITE_PATH.'product/hotspot/';
			$source = $_FILES['userfile']['tmp_name'];
			$arName = explode('.', $_FILES['userfile']['name']);
			$fileName = "video_".time().'.'.array_pop($arName);
			move_uploaded_file($source, $orgImgPath.$fileName);
			print $fileName;
			die;
		}
	}
	
	function m_AddHotspotGallery()
	{
		global $attributes;
		// print_r($_FILES['userfile']); die;
		if(isset($_FILES['userfile']['name']) && trim($_FILES['userfile']['name']) != '')
		{
			// $smallImgPath = SITE_PATH.'product/hotspot/small/';
			$thumbImgPath = SITE_PATH.'product/hotspot/thumb/';
			$orgImgPath = SITE_PATH.'product/hotspot/';
			$source = $_FILES['userfile']['tmp_name'];
			$arName = explode('.', $_FILES['userfile']['name']);
			$fileName = "hotspot_".time().'.'.array_pop($arName);
			$thumbImgPath = $this->m_UploadImage($source, $thumbImgPath.$fileName, true,290, 200);
			// $smallImgPath = $this->m_UploadImage($source, $smallImgPath.$fileName, true,290,224);
			move_uploaded_file($source, $orgImgPath.$fileName);
			
			$arData['iHotspotId'] = $attributes['hotspot_id'];
			$arData['vName'] = '';
			$arData['vDesc'] = '';
			$arData['vFile'] = $fileName;
			$arData['vLink'] = '';
			$rsResult= $this->dbHandler->m_AddEditHotspotFile($arData);
			
			print $fileName;
			die;
		}
	}
	
	function m_AssociateArticleWithPubFile()
	{
		global $attributes;
		$arData['iId'] = $attributes['file_id'];
		$arData['iArticleId'] = $attributes['article_id'];
		$rsResult= $this->dbHandler->m_AssociateArticleWithPubFile($arData);
		die;
	}
	
	function m_AddHotspotData()
	{						
		global $attributes;
		$stMsg='';
		$arData = array();	
		
		if(count($_POST)>0)
		{			
			// print "<pre>"; print_r($attributes); die;
			$arData['iHotspotId'] = $attributes['hotspot_id'];
			$arData['vName'] = '';
			$arData['vDesc'] = '';
			$arData['vFile'] = '';
			$arData['vLink'] = '';
			if($attributes['type'] == 'photo')
			{
				$id = $attributes['photo_id'];				
				$arData['vName'] = $attributes['photo_name'];
				$arData['vDesc'] = $attributes['photo_desc'];
				$arData['vFile'] = $attributes['photo_file_name'];
			}
			elseif($attributes['type'] == 'sponsor')
			{
				$id = $attributes['sponsor_id'];				
				$arData['vName'] = $attributes['sponsor_name'];
				$arData['vLink'] = $attributes['sponsor_link'];
				$arData['vFile'] = $attributes['sponsor_file_name'];
			}
			elseif($attributes['type'] == 'video')
			{
				$id = $attributes['video_id'];				
				$arData['vName'] = $attributes['video_name'];
				$arData['vDesc'] = $attributes['video_desc'];
				$arData['vFile'] = $attributes['video_file_name'];
				$arData['vLink'] = $attributes['video_link'];
			}
			elseif($attributes['type'] == 'gallery')
			{
				$arData['vName'] = $attributes['gallery_name'];
				$arData['vDesc'] = $attributes['gallery_desc'];
				print $rsResult= $this->dbHandler->m_UpdateGalleryRecords($arData);
				die;
			}
			elseif($attributes['type'] == 'view_360')
			{
				$arData['vName'] = $attributes['view_360_name'];
				//$arData['vLink'] = $attributes['view_360_link'];
				$arData['vDesc'] = $attributes['view_360_desc'];
				print $rsResult= $this->dbHandler->m_UpdateGalleryRecords($arData);
				die;
			}
			elseif($attributes['type'] == 'link')
			{
				$id = $attributes['link_id'];
				$arData['vLink'] = $attributes['link_url'];
			}
			elseif($attributes['type'] == 'pub_link')
			{
				$id = $attributes['pub_link_id'];
				$arData['vLink'] = $attributes['iPubFileId'];
			}
			print $rsResult= $this->dbHandler->m_AddEditHotspotFile($arData, $id);
			die;
						
		}
	}
	
	function m_ListPublication()
	{						
		global $attributes;
		$stMsg='';
		if(isset($attributes['msg']) && $attributes['msg']!='')
		{
			$stMsg = constant(strtoupper($attributes['msg']));
		}
		// print"<pre>"; print_r($_SESSION);
		$this->smarty->assign("MESSAGE",$stMsg);
		$rsData = $this->dbHandler->m_GetPublications(base64_decode($attributes['m_id']));	
		$arData = array();
		$i = 0;
		while(!$rsData->EOF)
		{				
			// print "<pre>"; print_r($rsData->fields); die;
			$arData[$i]= $rsData->fields;
			$arData[$i]['iMonth']= date('F', strtotime('2010-'.$rsData->fields['iMonth'].'-01'));
			$i++;
			$rsData->MoveNext();
		}
		// print "<pre>"; print_r($arData); 
		$this->smarty->assign("MESSAGE",$stMsg);
		$this->smarty->assign("ARR_DATA",$arData);
		$this->smarty->assign("IS_RECORD", count($arData));
		
		$innerTemp = $this->smarty->fetch('main_publications.tpl.html');		
		return $innerTemp;
	}#END function m_DisplayHome()
	
	function m_AddPublication()
	{						
		global $attributes;
		$stMsg='';
		$arData = array();	

		if(isset($_FILES['pub_file']['name']) && trim($_FILES['pub_file']['name']) != '')
		{
			$smallImgPath = SITE_PATH.'product/publication/small/';
			$thumbImgPath = SITE_PATH.'product/publication/thumb/';
			$orgImgPath = SITE_PATH.'product/publication/';
			
			$source = $_FILES['pub_file']['tmp_name'];
			$arName = explode('.', $_FILES['pub_file']['name']);
			$ext = array_pop($arName);
			$dispName = implode('.', $arName).date('-Ymd', time()).'.'.$ext;
			$fileName = "publication_".time().'.'.$ext;
			
			if($ext == 'pdf')
			{
				move_uploaded_file($source, $orgImgPath.$fileName);
				//pdf to png
				ini_set('max_execution_time', 100);
				$file = $orgImgPath.$fileName;
				$pages = exec("identify -format %n $file");
				$explode = explode('.',$fileName);
				$explode = $explode[0];
				for($i=0;$i<$pages;$i++)
				{
					$im = new imagick( $file.'['.$i.']' ); 
					//$im->setImageColorspace(500); 
					$im->setResolution(200, 200);
					
					//for thumbnail
					//$im->cropThumbnailImage(90,90);
					$im->setImageCompression(Imagick::COMPRESSION_LZW);
					//$im->setImageCompressionQuality(100); 
					$im->setImageFormat('png'); 
					$im->adaptiveResizeImage(473, 630);
					// $im->adaptiveResizeImage(768,1024);
					
					$newFile = $explode.$i.'.png';
					$im->writeImage($smallImgPath.$newFile); 
					//echo $explode.$i.'.png';
					$im->clear(); 
					$im->destroy();
					
					$dispName = implode('.', $arName).'['.($i+1).']'.date('-Ymd', time()).'.png';
					$arData['file_name'] = $newFile;
					$arData['disp_name'] = $dispName;
					$arData['pub_id'] = $attributes['pub_id'];
					//$arData['iArticleId'] = $attributes['iArticleId'];
					$id= $this->dbHandler->m_AddPublicationImage($arData);
				
					$result[$i]['id'] = $id;
					$result[$i]['disp_name'] = $dispName;
					$result[$i]['file_name'] = $newFile;
				}
			}
			else{
				$thumbImgPath = $this->m_UploadImage($source, $thumbImgPath.$fileName, true,150, 106);
				$smallImgPath = $this->m_UploadImage($source, $smallImgPath.$fileName, true,473,630);
				move_uploaded_file($source, $orgImgPath.$fileName);
				$arData['file_name'] = $fileName;
				$arData['disp_name'] = $dispName;
				$arData['pub_id'] = $attributes['pub_id'];
				//$arData['iArticleId'] = $attributes['iArticleId'];
				$id= $this->dbHandler->m_AddPublicationImage($arData);
				$result[0]['id'] = $id;
				$result[0]['disp_name'] = $dispName;
				$result[0]['file_name'] = $fileName;
			}
			
			print json_encode($result);
			die;
		}
		
		if(count($_POST)>0)
		{			
			// print "<pre>"; print_r($attributes); die;
			$id = $attributes['pub_id'];
			$arData['vName'] = $attributes['vName'];
			$arData['iMagazineId'] = base64_decode($attributes['m_id']);
			$arData['vDescription'] = $attributes['vDescription'];
			$arData['iMonth'] = $attributes['iMonth'];
			$arData['dActivationDate'] = $attributes['dActivationDate'];
				
			print $rsResult= $this->dbHandler->m_AddEditPublication($arData, $id);
			die;
						
		}
		if(strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')){
			$IE = true;
		}else{
			$IE = false;
		}
		$this->smarty->assign('IE', $IE);	
		
		if(isset($attributes['msg']) && $attributes['msg']!='')
		{
			$stMsg=constant(strtoupper($attributes['msg']));
		}
		
		if(isset($attributes['id']) && !empty($attributes['id'])){
			$id = base64_decode($attributes['id']);
		}else{
			$id = null;
		}
		$arPubFiles = array();
		$arHotspot = array();
		$arDiv = array(0);
		if(isset($attributes['id']) && $attributes['id'] >0)
		{
			$rsResult= $this->dbHandler->m_GetRecordDetail('tb_publication', $attributes['id']);
			$arData = $rsResult->fields;
			
			$rsPubFile = $this->dbHandler->m_GetPublicationFiles($attributes['id']);
			
			$arPubId = array();
			while(!$rsPubFile->EOF)
			{
				$arPubId[] = $rsPubFile->fields['iId'];
				$arPubFiles[] = $rsPubFile->fields;
				$rsPubFile->MoveNext();
			}
			if(count($arData))
			{
				$rsHotspot = $this->dbHandler->m_GetRecords('tb_hotspots', 'iPubFileId IN('.implode(',', $arPubId).')');
				
				while(!$rsHotspot->EOF)
				{
					$arDiv[] = str_replace('clonediv', '', $rsHotspot->fields['vDivId']);
					$arHotspot[$rsHotspot->fields['iPubFileId']][] = $rsHotspot->fields;
					$rsHotspot->MoveNext();
				}
				sort($arDiv);
				// print "<pre>"; print_r(array_pop($arDiv)); die;
			}
		}
				
		$this->smarty->assign('DATA', $arData);		
		$this->smarty->assign('PUB_FILE_COUNT', count($arPubFiles));		
		$this->smarty->assign('PUB_FILE', $arPubFiles);		
		$this->smarty->assign('HOTSPOT', $arHotspot);		
		$this->smarty->assign('DIV_COUNT', array_pop($arDiv));		
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$arMonth[0] = '- Select Month -';
		for($i=1; $i<=12; $i++){
			$arMonth[$i] = date('F', strtotime('2010-'.$i.'-1'));
		}
		$this->smarty->assign("months", $arMonth);
		$this->smarty->assign("TIME", time());
		
		$innerTemp = $this->smarty->fetch('main_add_publication.tpl.html');		
		return $innerTemp;
	}
	
	function m_GetPublicationFiles()
	{	
		global $attributes;
		$html = "";
		
		$rsApp = $this->dbHandler->m_GetRecords('tb_publication_files', 'iPublicationId='.$attributes['pub_id']);	

		while(!$rsApp->EOF)
		{
			$html .= '<option value="'.$rsApp->fields['iId'].'">'.addslashes($rsApp->fields['vDispName']).'</option>';
			$rsApp->MoveNext();
		}
		print $html;
		die;
	}
	
	function m_GetArticles()
	{	
		global $attributes;
		$html = "";
		
		$rsApp = $this->dbHandler->m_GetRecords('tb_article', 'iClientId='.$_SESSION['client']['iId']);	

		while(!$rsApp->EOF)
		{
			$html .= '<option value="'.$rsApp->fields['iId'].'">'.stripslashes($rsApp->fields['vName']).'</option>';
			$rsApp->MoveNext();
		}
		print $html;
		die;
	}
	
	function m_CreateImageDivs()
	{	
		global $attributes;
		$html = "";
		
		$rsApp = $this->dbHandler->m_GetRecords('tb_publication_files', 'iPublicationId='.$attributes['id']);	

		while(!$rsApp->EOF)
		{
			$html .= '<div id="frame_file_'.$rsApp->fields['iId'].'" class="sub_frame ui-droppable" style="display:none; background-image: url(\''.SITE_URL.'product/publication/small/'.$rsApp->fields['vFile'].'\');"></div>';
			$rsApp->MoveNext();
		}
		print $html;
		die;
	}
	
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
	function m_ValidatePublication($arData, &$stErrorMsg)
	{
		global $attributes;
		$stErrorMsg = "";
		$blIsError = false;	
					
		if($arData['vName'] == "") 
		{
			$stErrorMsg .= "Please enter the name.<br>";				
			$blIsError = true;
		}
		if($arData['iMonth'] == 0) 
		{
			$stErrorMsg .= "Please select the month.<br>";				
			$blIsError = true;
		}
		if(trim($arData['vDescription']) == '')
		{
			$stErrorMsg .= 'Please enter  the description.<br/>';
			$blIsError = true;
		}
		if($arData['dActivationDate'] == "") 
		{
			$stErrorMsg .= "Please select the activation date.<br>";				
			$blIsError = true;
		}
		return $blIsError;
	}
	
	/* function m_AddPublicationFile()
	{						
		global $attributes;
		$stMsg='';
		if(isset($attributes['msg']) && $attributes['msg']!='')
		{
			$stMsg=constant(strtoupper($attributes['msg']));
		}
		
		if(isset($_FILES['vFile']['name']) && trim($_FILES['vFile']['name']) != '')
		{
			
			$allowedFileType = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'application/pdf');
			// print "<pre>"; print_r($arData); die;
			if(!in_array($_FILES['vFile']['type'], $allowedFileType))						
			{				
				$stMsg = "Invalid file type selected.";
			}
			else		
			{				
				$orgImgPath = SITE_PATH.'product/magazine/publication/';
				$source = $_FILES['vFile']['tmp_name'];
				$fileName = date("dmY").'-'.$_FILES['vFile']['name'];
				if(move_uploaded_file($source, $orgImgPath.$fileName))
				{
					$arData['vFile'] = $fileName;
					$arData['iPublicationId'] = base64_decode($attributes['pubid']);
					// print "<pre>"; print_r($arData); die;
					$rsResult= $this->dbHandler->m_AddPublicationFile($arData, $id);
					if($rsResult)
					{					
						$stMessage = "RECORD_ADDED";
						header("Location:".SITE_URL."product/index.php?action=publist&m_id=".$attributes['m_id']."&name=".$attributes['name']."&msg=".$stMessage);
						exit();
					}
					else
					{					
						$stMsg = QUERY_ERROR;					
					}	
				}
				else{
					$stMsg = QUERY_ERROR;
				}
			}			
			
			
		}
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$innerTemp = $this->smarty->fetch('main_add_publication_file.tpl.html');		
		return $innerTemp;
	} */
	
	function m_DeletePublication()
	{						
		global $attributes;
		if(isset($attributes['id']) && $attributes['id'] > 0)
		{
			$rsResult= $this->dbHandler->m_DeleteRecord('tb_publication', $attributes['id']);
		}
		header('Location: '.SITE_URL.'product/index.php?action=publist&m_id='.$attributes['m_id'].'&msg=pubdel');
		exit();
	}
	
	function m_PublishPublication()
	{						
		global $attributes;
		$msg = '';
		if(isset($attributes['id']) && $attributes['id'] > 0)
		{
			$rsResult= $this->dbHandler->m_GetRecordDetail('tb_client', $_SESSION['sesUserId']);
			// print "<pre>"; print_r($rsResult->fields); die;
			if($attributes['pub'] == 1 && ($rsResult->fields['iTotalSlots'] - $rsResult->fields['iConsumedSlots']) > 0)
			{
				$rsResult= $this->dbHandler->m_PublishPublication($attributes['id'], 1);
				$msg = 'pub';
			}
			elseif($attributes['pub'] === '0' )
			{
				$rsResult= $this->dbHandler->m_PublishPublication($attributes['id'], 0);
				$msg = 'unpub';
			}
			else
			{
				$msg = 'pub_err';
			}
			
		}
		header('Location: '.SITE_URL.'product/index.php?action=publist&m_id='.$attributes['m_id'].'&msg='.$msg);
		exit();
	}
	
	function m_AddHotspot()
	{						
		global $attributes;
		
		$where = 'iPubFileId='.$attributes['pub_file_id'].' AND vDivId="'.$attributes['div_id'].'"';
		$rec = $this->dbHandler->m_GetRecords('tb_hotspots', $where);

		if($rec->NumRows()){
			$id = $rec->fields['iId'];
		}else{
			$id = 0;
		}
		
		// print "<pre>"; print_r($attributes); die;
		$arData['iPubFileId'] = $attributes['pub_file_id'];
		$arData['iXPos'] = $attributes['x'];
		$arData['iYPos'] = $attributes['y'];
		$arData['eType'] = $attributes['element_type'];
		$arData['vDivId'] = $attributes['div_id'];
		
		print $this->dbHandler->m_AddEditHotspot($arData, $id);
		die;
	}
	
	function m_AddArticle()
	{						
		global $attributes;
		
		// print "<pre>"; print_r($attributes); die;
		$arData['vName'] = $attributes['article_title'];
		$arData['iClientId'] = $_SESSION['client']['iId'];
		print $this->dbHandler->m_AddArticle($arData);
		die;
	}
	
	function m_DeleteHotspot()
	{						
		global $attributes;
		
		$id = $attributes['hotspot_id'];
		$rsData = $this->dbHandler->m_GetRecordDetail('tb_hotspots', $id);
		$this->dbHandler->m_DeleteRecord('tb_hotspots', $id);
		print $rsData->fields['vDivId'];
		die;
	}
	
	/* function m_AddMedia()
	{						
		global $attributes;
		$stMsg='';
		if(isset($attributes['msg']) && $attributes['msg']!='')
		{
			$stMsg=constant(strtoupper($attributes['msg']));
		}
		
		if(isset($_FILES['vFile']['name']) && trim($_FILES['vFile']['name']) != '')
		{
			
			$allowedFileType = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'application/pdf');
			// print "<pre>"; print_r($arData); die;
			if(!in_array($_FILES['vFile']['type'], $allowedFileType))						
			{				
				$stMsg = "Invalid file type selected.";
			}
			else		
			{				
				$orgImgPath = SITE_PATH.'product/magazine/publication/';
				$source = $_FILES['vFile']['tmp_name'];
				$fileName = date("dmY").'-'.$_FILES['vFile']['name'];
				if(move_uploaded_file($source, $orgImgPath.$fileName))
				{
					$arData['vFile'] = $fileName;
					$arData['iPublicationId'] = base64_decode($attributes['pubid']);
					// print "<pre>"; print_r($arData); die;
					$rsResult= $this->dbHandler->m_AddPublicationFile($arData, $id);
					if($rsResult)
					{					
						$stMessage = "RECORD_ADDED";
						header("Location:".SITE_URL."product/index.php?action=publist&m_id=".$attributes['m_id']."&name=".$attributes['name']."&msg=".$stMessage);
						exit();
					}
					else
					{					
						$stMsg = QUERY_ERROR;					
					}	
				}
				else{
					$stMsg = QUERY_ERROR;
				}
			}			
		}
		$this->smarty->assign("MESSAGE",$stMsg);
		
		$innerTemp = $this->smarty->fetch('main_add_media.tpl.html');		
		return $innerTemp;
	} */


	function m_DownloadFile()
	{
		global $attributes;
		if(isset($attributes['type']) && $attributes['type']== 'dataset'){
			$file = SITE_PATH.'product/dataset/'.$attributes['filename'];
		}elseif(isset($attributes['type']) && $attributes['type']== 'dataset_thumb'){
			$file = SITE_PATH.'product/dataset/thumb/'.$attributes['filename'];
		}else{
			$file = SITE_PATH.'product/object/'.$attributes['filename'];
		}
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
	
	/* function m_GetClientData()
	{	
		global $attributes;
		$xml = '<objects>';
		$rsMagazine = $this->dbHandler->m_GetClientMagazines($attributes['client_id']);
		
		$i=1;
		if($rsMagazine){
		while(!$rsMagazine->EOF)
		{
			$xml .= '<object ';
			$xml .= 'Name="'.addslashes($rsMagazine->fields['vName']).'" ';
			$xml .= 'object_type = "Magazine" ';
			$xml .= 'Sequenceno="'.$i.'" ';
			$xml .= 'Date="'.$rsMagazine->fields['dCreated'].'" ';
			$xml .= 'id="'.$rsMagazine->fields['iId'].'" ';
			$xml .= 'parentid="0" ';
			$xml .= '>';
			
			$rsPub = $this->dbHandler->m_GetRecords('tb_publication', 'iPublished=1 AND iMagazineId='.$rsMagazine->fields['iId']);
			if($rsPub){
			while(!$rsPub->EOF)
			{
				// print_r($rsPub->fields);
				$xml .= '<object ';
				$xml .= 'Name="'.addslashes($rsPub->fields['vName']).'" ';
				$xml .= 'object_type = "Publication" ';
				$xml .= 'Sequenceno="'.$i.'" ';
				$xml .= 'Description="'.addslashes($rsPub->fields['vDescription']).'" ';
				$xml .= 'Date="'.$rsPub->fields['dCreated'].'" ';
				$xml .= 'id="'.$rsPub->fields['iId'].'" ';
				$xml .= 'parentid="'.$rsPub->fields['iMagazineId'].'" ';
				$xml .= '>';
				
				$rsPubFile = $this->dbHandler->m_GetRecords('tb_publication_files', 'iPublicationId='.$rsPub->fields['iId']);
				if($rsPubFile){				
				while(!$rsPubFile->EOF)
				{
					// print_r($rsPubFile->fields);
					$xml .= '<object ';
					$xml .= 'object_type = "Publication_File" ';
					$xml .= 'File="'.SITE_URL.'product/publication/'.addslashes($rsPubFile->fields['vFile']).'" ';
					$xml .= 'Name="'.addslashes($rsPubFile->fields['vDispName']).'" ';
					$xml .= 'Date="'.$rsPubFile->fields['dCreated'].'" ';
					$xml .= 'id="'.$rsPubFile->fields['iId'].'" ';
					$xml .= 'parentid="'.$rsPubFile->fields['iPublicationId'].'" ';
					$xml .= '>';
					
					$rsHotspot = $this->dbHandler->m_GetRecords('tb_hotspots', 'iPubFileId='.$rsPubFile->fields['iId']);
					if($rsHotspot){
					while(!$rsHotspot->EOF)
					{
						// print_r($rsHotspot->fields);
						$xml .= '<object ';
						$xml .= 'object_type = "Hotspot" ';
						$xml .= 'type = "'.$rsHotspot->fields['eType'].'" ';
						$xml .= 'XPosPotrait="'.$rsHotspot->fields['iXPosPotrait'].'" ';
						$xml .= 'YPosPotrait="'.$rsHotspot->fields['iYPosPotrait'].'" ';
						$xml .= 'XPosLandscape="'.$rsHotspot->fields['iXPosLandscape'].'" ';
						$xml .= 'YPosLandscape="'.$rsHotspot->fields['iYPosLandscape'].'" ';
						$xml .= 'id="'.$rsHotspot->fields['iId'].'" ';
						$xml .= 'parentid="'.$rsHotspot->fields['iPubFileId'].'" ';
						$xml .= '>';
						
						$rsHotspotFile = $this->dbHandler->m_GetRecords('tb_hotspot_files', 'iHotspotId='.$rsHotspot->fields['iId']);
						if($rsHotspotFile){
						while(!$rsHotspotFile->EOF)
						{
							// print_r($rsHotspotFile->fields);
							$xml .= '<object ';
							$xml .= 'object_type = "Hotspot" ';
							$xml .= 'Name = "'.addslashes($rsHotspotFile->fields['vName']).'" ';
							$xml .= 'Description="'.addslashes($rsHotspotFile->fields['vDesc']).'" ';
							$xml .= 'Link="'.addslashes($rsHotspotFile->fields['vLink']).'" ';
							$xml .= 'File="'.SITE_URL.'product/hotspot/'.$rsHotspotFile->fields['vFile'].'" ';
							$xml .= 'id="'.$rsHotspotFile->fields['iId'].'" ';
							$xml .= 'parentid="'.$rsHotspotFile->fields['iHotspotId'].'" ';
							$xml .= '>';

							$xml .= '</object>';
							$rsHotspotFile->MoveNext();
						}}
						$xml .= '</object>';
						$rsHotspot->MoveNext();
					}}
					$xml .= '</object>';
					$rsPubFile->MoveNext();
				}}
				$xml .= '</object>';
				$rsPub->MoveNext();
			}}
			$xml .= '</object>';
			$i++;
			$rsMagazine->MoveNext();
		}}
		$xml .= '</objects>';
		print $xml;
		die();
	} */
	
	function m_GetClientPublication()
	{	
		global $attributes;
		$xml = '<objects>';
		$rsMagazine = $this->dbHandler->m_GetClientMagazines($attributes['client_id']);
		// print "<pre>";
		$i=1;
		if($rsMagazine){
		while(!$rsMagazine->EOF)
		{
			$xml .= '<object ';
			$xml .= 'Name="'.addslashes($rsMagazine->fields['vName']).'" ';
			$xml .= 'Description="'.addslashes($rsMagazine->fields['vDescription']).'" ';
			$xml .= 'object_type="Magazine" ';
			$xml .= 'Sequenceno="'.$i.'" ';
			$xml .= 'Date="'.$rsMagazine->fields['dCreated'].'" ';
			$xml .= 'id="'.$rsMagazine->fields['iId'].'" ';
			$xml .= 'parentid="0" ';
			$xml .= '>';
			
			$rsPub = $this->dbHandler->m_GetPublications($rsMagazine->fields['iId']);
			$j=1;
			if($rsPub){
			while(!$rsPub->EOF)
			{
				// print_r($rsPub->fields);
				$xml .= '<object ';
				$xml .= 'Name="'.addslashes($rsPub->fields['vName']).'" ';
				$xml .= 'object_type="Publication" ';
				$xml .= 'Sequenceno="'.$j.'" ';
				$xml .= 'Coverurl="'.$rsPub->fields['vFile'].'" ';
				$xml .= 'Description="'.addslashes($rsPub->fields['vDescription']).'" ';
				$xml .= 'Released_date="'.$rsPub->fields['dActivationDate'].'" ';
				$xml .= 'Totalpages="'.$rsPub->fields['total_pages'].'" ';
				$xml .= 'Downloadurl="'.SITE_URL.'product/publication/'.$rsPub->fields['vFile'].'" ';
				$xml .= 'id="'.$rsPub->fields['iId'].'" ';
				$xml .= 'parentid="'.$rsPub->fields['iMagazineId'].'" ';
				$xml .= '>';
				$xml .= '</object>';
				$j++;
				$rsPub->MoveNext();
			}}
			$xml .= '</object>';
			$i++;
			$rsMagazine->MoveNext();
		}}
		$xml .= '</objects>';
		print $xml;
		die();
	}
	
	function m_GetPublicationHotspot()
	{	
		global $attributes;
		$xml = '<objects>';
		$rsPub = $this->dbHandler->m_GetRecordDetail('tb_publication', $attributes['pub_id']);
		// print "<pre>"; print_r($rsPub->fields['iMagazineId']); die;
		$rsPubFile = $this->dbHandler->m_GetRecords('tb_publication_files', 'iPublicationId='.$attributes['pub_id']);
		$i=1;
		if($rsPubFile){				
		while(!$rsPubFile->EOF)
		{
			// print_r($rsPubFile->fields);
			$xml .= '<object ';
			$xml .= 'id="'.$rsPubFile->fields['iId'].'" ';
			$xml .= 'Name="Page-'.$i.'" ';
			$xml .= 'ObjectiveType="Page" ';
			$xml .= 'Magazine_Id="'.$rsPub->fields['iMagazineId'].'" ';
			$xml .= 'Issue_Id="'.$rsPubFile->fields['iPublicationId'].'" ';
			$xml .= 'File="'.SITE_URL.'product/publication/'.addslashes($rsPubFile->fields['vFile']).'" ';
			$xml .= '>';
			
			//article and section
			$xml .= '<object Id="1" Name ="Cover" ObjectiveType ="Section" TotalSection="1" Issue_Id ="'.$rsPubFile->fields['iPublicationId'].'" obj_ParentId="1">';
			$rsArticle = $this->dbHandler->m_GetRecordDetail('tb_article', $rsPubFile->fields['iArticleId']);
			if(isset($rsArticle->fields['iId']))
			{
				$xml .= '<object Id="'.$rsArticle->fields['iId'].'" Name ="'.$rsArticle->fields['vName'].'" ObjectiveType ="Article" section_id="1" obj_ParentId="'.$rsPubFile->fields['iId'].'"></object>';
			}
			$rsHotspot = $this->dbHandler->m_GetRecords('tb_hotspots', 'iPubFileId='.$rsPubFile->fields['iId']);
			if($rsHotspot){
			while(!$rsHotspot->EOF)
			{
				// print_r($rsHotspot->fields);
				$xml .= '<object ';
				$xml .= 'Id="'.$rsHotspot->fields['iId'].'" ';
				$xml .= 'ObjectiveType="Hotspots" ';
				$xml .= 'type="'.$rsHotspot->fields['eType'].'" ';
				$xml .= 'Issue_Id="'.$rsPubFile->fields['iPublicationId'].'" ';
				$xml .= 'Magazine_Id="'.$rsPub->fields['iMagazineId'].'" ';
				$xml .= 'XPosition_Portrait="'.$rsHotspot->fields['iXPosPotrait'].'" ';
				$xml .= 'YPosition_Portrait="'.$rsHotspot->fields['iYPosPotrait'].'" ';
				$xml .= 'XPosition_Landscape="'.$rsHotspot->fields['iXPosLandscape'].'" ';
				$xml .= 'YPosition_Landscape="'.$rsHotspot->fields['iYPosLandscape'].'" ';
				$xml .= 'obj_ParentId="'.$rsHotspot->fields['iPubFileId'].'" ';
				$xml .= '>';
				
				$rsHotspotFile=$this->dbHandler->m_GetRecords('tb_hotspot_files', 'iHotspotId='.$rsHotspot->fields['iId']);
				if($rsHotspotFile){
				while(!$rsHotspotFile->EOF)
				{
					// print_r($rsHotspotFile->fields);
					$xml .= '<object ';
					$xml .= 'ObjectiveType="Hotspot_Data" ';
					$xml .= 'Name="'.SITE_URL.'product/hotspot/'.$rsHotspotFile->fields['vFile'].'" ';
					$xml .= 'Description="'.addslashes($rsHotspotFile->fields['vDesc']).'" ';
					$xml .= 'Link="'.addslashes($rsHotspotFile->fields['vLink']).'" ';
					$xml .= 'File="'.addslashes($rsHotspotFile->fields['vName']).'" ';
					$xml .= 'Id="'.$rsHotspotFile->fields['iId'].'" ';
					$xml .= 'obj_ParentId="'.$rsHotspotFile->fields['iHotspotId'].'" ';
					$xml .= '>';

					$xml .= '</object>';
					$rsHotspotFile->MoveNext();
				}}
				$xml .= '</object>';
				$rsHotspot->MoveNext();
			}}
			$xml .= '</object>';
			$i++;
			$rsPubFile->MoveNext();
		}}
		$xml .= '</objects>';
		print $xml;
		die();
	}
	
	function m_GetAllMagazineData()
	{	
		global $attributes;
		$xml = '<objects>';
		$rsmag = $this->dbHandler->m_GetRecordDetail('tb_magazine');
		if($rsmag)
		{
			while(!$rsmag->EOF)
			{
				$xml .= '<object ';
				$xml .= 'id="'.$rsmag->fields['iId'].'" ';
				$xml .= 'Image="'.addslashes($rsmag->fields['vImage']).'" ';
				$xml .= '>';
				$rsmag->MoveNext();
			}
		}
		$xml .= '</objects>';
		print $xml;
		die();
		
	}

}#END class c_ProductOperation
?>
