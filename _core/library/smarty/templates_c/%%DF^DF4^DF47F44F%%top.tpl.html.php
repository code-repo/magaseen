<?php /* Smarty version 2.6.15, created on 2013-02-05 08:44:00
         compiled from top.tpl.html */ ?>
<!-- xxxxxxxxxxxxxxxxxx Header xxxxxxx -->
<div id="header"> <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
" id="logo"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/logo.png" alt="" /></a>
  <!-- xxxxx Signout xxxxxxx -->
  <div class="signout_btn"><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php?action=logout">Sign Out</a>
  <?php if ($_SESSION['client']['iId']): ?><br />ID #<?php echo $_SESSION['client']['iId'];  endif; ?></div>
  <!-- xxxxx //Signout xxxxxxx -->
</div>
	<!-- <h1><a href="<?php echo @SITE_URL; ?>
"><?php echo @SITE_TITLE; ?>
 Client Section</a></h1>
	<?php if ($_SESSION['sesUserName']): ?>
	<ul>
		<li><?php echo @LBL_WELCOME; ?>
 <i><?php echo $_SESSION['sesUserName']; ?>
</i></li>
		<li><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php?action=profile"><?php echo @LBL_MY_PROFILE; ?>
</a></li>
		<li><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php?action=changepass"><?php echo @LBL_CHANGE_PASSWORD; ?>
</a></li>
		<li><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php?action=logout"><?php echo @LBL_LOGOUT; ?>
</a>
	</ul>
	<?php endif; ?>
</div> -->