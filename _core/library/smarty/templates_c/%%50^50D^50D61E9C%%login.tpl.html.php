<?php /* Smarty version 2.6.15, created on 2013-03-21 14:41:12
         compiled from login.tpl.html */ ?>
<h2>Administrator Login</h2>
<?php if ($this->_tpl_vars['MESSAGE']): ?>
<div class="w100p errMsg clear"><?php echo $this->_tpl_vars['MESSAGE']; ?>
</div>
<?php endif; ?>
<form name="frm" action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
adminindex.php" method="post">
<input type="hidden" name="action" value="checklogin" />
<div class="row">
	<label class="small_label">Email:<span class="req">*</span></label>
	<input type="text" name="txtUserId" maxlength="50" />
</div>
<div class="row">
	<label class="small_label">Password:<span class="req">*</span></label>
	<input type="password" name="txtPassword" maxlength="50" />
</div>
<div class="row">
	<label class="small_label"></label>
	<input type="submit" name="Submit" value="Sign-in" class="button" />
</div>
<div class="row">
	<label class="small_label"></label>
	<label class="">Forgot Password? <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=forgotpass">Click Here</a></label>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
document.frm.txtUserId.focus();
//-->
</SCRIPT>