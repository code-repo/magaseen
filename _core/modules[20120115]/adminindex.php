<?php
error_reporting(E_ALL);
include_once(LIBRARY_PATH."smarty/libs/Smarty.class.php");
include_once(LIBRARY_PATH."html_mime_mail_2.5/htmlMimeMail.php");

#setting all post and get variables into attributes array
if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET, $_POST, $_FILES); //get overwrites post
}
// print "<pre>"; print_r($_SESSION); die;
$smarty = new Smarty(MODULE_PATH.'user/templates/admin');

$smarty->assign('SITE_URL', SITE_URL);
if(!isset($sMode))
	$sMode = "";
if(isset($_SESSION['user'])  || (isset($attributes['action']) && $attributes['action'] == "forgotpass"))
{
	switch($sMode)
	{
			case 'user':		
				include(MODULE_PATH.'user/admin.php');	
				$userAdmin = new c_UserAdmin();
				$templateOutput = $userAdmin->m_InnerTemp();
			break;

			case 'common':	
				include(MODULE_PATH.'common/admin.php');		
				$commonAdmin = new c_CommonAdmin();
				$templateOutput = $commonAdmin->m_InnerTemp();
			break;

			case 'product':	
				include(MODULE_PATH.'product/admin.php');		
				$productAdmin = new c_ProductAdmin();
				$templateOutput = $productAdmin->m_InnerTemp();
			break;
			default:
				include(MODULE_PATH.'user/admin.php');		
				$cmsAdmin = new c_UserAdmin();
				$templateOutput = $cmsAdmin->m_InnerTemp();
			break;
	}
}
else
{
	if(isset($sMode) && $sMode!="") 
	{
		header("location:".SITE_URL."adminindex.php");
	}	
	include(MODULE_PATH.'user/admin.php');		
	$cmsAdmin = new c_UserAdmin();	
	$templateOutput = $cmsAdmin->m_InnerTemp('displogin');
	$smarty->assign('TPL_VALIGN', "top");
}
# Main Contents
$smarty->assign('TPL_VAR_BODY', $templateOutput);
$smarty->assign('TPL_VAR_COPYRIGHTYEAR', date('Y'));
$smarty->assign('FOOTER_SITE_TITLE', SITE_TITLE);
$smarty->assign('SITE_ADMIN_TITLE', SITE_TITLE_ADMIN);
$smarty->assign('ADMIN_GRAPHICS_URL', ADMIN_GRAPHICS_URL);

if(isset($attributes['omitheader']) && $attributes['omitheader'] == 'yes')
{	
	$smarty->display('blank.tpl.html');
	
}
elseif(isset($_SESSION['user']))
{
	$smarty->display('admin_inner.tpl.html');
}
else
{
	$smarty->display('admin_default.tpl.html');
}

?>