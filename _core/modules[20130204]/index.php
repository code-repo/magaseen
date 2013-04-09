<?php
error_reporting(E_ALL);
include_once(LIBRARY_PATH."smarty/libs/Smarty.class.php");
include_once(LIBRARY_PATH."html_mime_mail_2.5/htmlMimeMail.php");
include_once(SITE_PATH."message.php");
include_once(MODULE_PATH."user/classes/main/ue_userop.php");

session_start();

#setting all post and get variables into attributes array
if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET, $_POST, $_FILES); //get overwrites post
}

$smarty = new Smarty(MODULE_PATH.'user/templates/main');
$smarty->assign('SITE_URL', SITE_URL);

if(!isset($sMode))
	$sMode = "";

switch($sMode)
{
	case 'user':		
		include(MODULE_PATH.'user/main.php');		
		$userMain = new c_UserMain();
		$templateOutput = $userMain->m_InnerTemp();
	break;
	case 'product':		
		include(MODULE_PATH.'product/main.php');		
		$productMain = new c_ProductMain();
		$templateOutput = $productMain->m_InnerTemp();
	break;
	default:	
		include(MODULE_PATH.'user/main.php');		
		$userMain = new c_UserMain();
		$templateOutput = $userMain->m_InnerTemp();
	break;
}

# Main Contents
$commonOp = new c_UserOperation($smarty);

$smarty->assign("TPL_VAR_TOP", $commonOp->m_GetTop());
$smarty->assign("TPL_VAR_FOOTER", $commonOp->m_GetFooter());

$smarty->assign('TPL_VAR_BODY', $templateOutput);
$smarty->assign('TPL_VAR_COPYRIGHTYEAR', date('Y'));
$smarty->assign('FOOTER_SITE_TITLE', SITE_TITLE);
$smarty->assign('GRAPHICS_URL', GRAPHICS_URL);

if((isset($attributes['popup']) && $attributes['popup']=='yes'))
{
	$smarty->display('plain_default_blank.tpl.html');
}
else
{
	$smarty->display('plain_default.tpl.html');
}
?>
