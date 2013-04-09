<?php /* Smarty version 2.6.15, created on 2013-02-05 08:44:00
         compiled from main_login.tpl.html */ ?>
<div id="content_area">
	<!-- xxxxx Title Bar xxxxxxx -->
	<div class="title_bar">
	<!-- xxxxx Left Area xxxxxxx -->
	<div class="left_area">
	<h1>Login</h1>
	</div>
	</div>
	<div class="clear"></div>
	<!-- xxxxx //Title Bar xxxxxxx -->
	<!-- xxxxxxxxxxxx Left Area xxxxxxxxxxxx -->
	<div class="left_area">
		<div class="content">
		<form name="frmLoginMain" id="userForm" method="post" action="" onsubmit="return validateLoginInner();">
		<table border="0" id="register" width="100%">
			<?php if ($this->_tpl_vars['MESSAGE']): ?>
			<tr>
				<td colspan="2" class="errMsg"><?php echo $this->_tpl_vars['MESSAGE']; ?>
</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2"><?php echo @LOGIN_TEXT; ?>
</td>
			</tr>
			<tr>
				<td width="25%"><?php echo @LBL_EMAIL; ?>
*:</td>
				<td width="75%"><input type="text" name="txtUserId" maxlength="50" /> </td>
			</tr>
			<tr>
				<td><?php echo @LBL_PASSWORD; ?>
*:</td>
				<td><input type="password" name="txtPassword" maxlength="50" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Login" name="form[Send]" id="Login" class="rsform-submit-button" />				</td>
			</tr>
		</table>
		</form>
		<div class="clear"></div>
		</div>
	<!-- xxxxxx //Content xxxxxx -->
	</div>
	<div class="clear"></div>
</div>