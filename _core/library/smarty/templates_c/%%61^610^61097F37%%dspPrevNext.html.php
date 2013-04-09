<?php /* Smarty version 2.6.15, created on 2013-03-21 14:42:51
         compiled from dspPrevNext.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'dspPrevNext.html', 21, false),)), $this); ?>
<!-- saved from url=(0022)http://internet.e-mail -->
<?php echo '
<script language="JavaScript">
function sub1(ext)
{
	document.location.href = \'';  echo $this->_tpl_vars['SELF_ADDR'];  echo '?page=\'+document.getElementById(\'pagenum\').value+ext;
	//alert(document.location.href);
}
</script>
'; ?>

<form method="post" action="#" name=""> 
<div class="normal paging">
	<?php if ($this->_tpl_vars['PREV']): ?>
		<span style="position:relative;top:1px;"><a href="<?php echo $this->_tpl_vars['FLINK']; ?>
"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/first.gif" title="First" alt="First" border="0" /></a></span> 
		<span style="position:relative;top:1px;"><a href="<?php echo $this->_tpl_vars['prevLink']; ?>
"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/previous.gif" border="0" title="Previous" alt="Previous" /></a></span> 
	<?php else: ?>
	<span style="position:relative;top:1px;"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/first_disabled.gif" border="0" /></span>
	<span style="position:relative;top:1px;"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/previous_disabled.gif" border="0" /></span>
	<?php endif; ?>		
	<span style="position:relative;top:-3px;">Page</span>&nbsp;<select name="pagenum" id="pagenum" onchange="sub1('<?php echo $this->_tpl_vars['Extra']; ?>
')" class="selectBox" <?php echo $this->_tpl_vars['DISABLED']; ?>
>
	<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['VALS'],'selected' => $this->_tpl_vars['SELECTED'],'output' => $this->_tpl_vars['OUTPUT']), $this);?>

	</select>  
	<?php if ($this->_tpl_vars['NEXT']): ?> 
		<span style="position:relative;top:1px;"><a href="<?php echo $this->_tpl_vars['nextLink']; ?>
"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/next.gif" border="0" title="Next" alt="Next" /></a></span>
		<span style="position:relative;top:1px;"><a href="<?php echo $this->_tpl_vars['pageLink']; ?>
"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/last.gif" border="0" title="Last" alt="Last" /></a></span>
	<?php else: ?>
		<span style="position:relative;top:1px;"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/next_disabled.gif" border="0" /></span>
		<span style="position:relative;top:1px;"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
common/last_disabled.gif" border="0" /></span> 
	<?php endif; ?>
</div>
</form>