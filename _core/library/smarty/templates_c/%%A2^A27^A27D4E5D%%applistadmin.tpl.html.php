<?php /* Smarty version 2.6.15, created on 2013-03-21 14:42:59
         compiled from applistadmin.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'applistadmin.tpl.html', 128, false),array('modifier', 'htmlentities', 'applistadmin.tpl.html', 128, false),array('modifier', 'truncate', 'applistadmin.tpl.html', 129, false),)), $this); ?>
<!-- Include jQuery -->
<script src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
script/admin/jquery.js" type="text/javascript" charset="utf-8"></script>	
<!-- Include Core Datepicker JavaScript -->
<script src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
script/admin/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>	
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
css/admin/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script>//<![CDATA[<?php echo '
	function checkAll()
	{
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].type=="checkbox" && document.frm.elements[i].name=="chkPage[]")
			{
				if(!document.frm.elements[i].disabled)
				{
					document.frm.elements[i].checked = document.frm.chkAll.checked;
				}
			}
		}
	}
	function chkForm()
	{
		var totchecked=0;
		flag = false;
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].type=="checkbox" && document.frm.elements[i].name=="chkPage[]" && true == document.frm.elements[i].checked)
			{
				flag = true;
				break;
			}
		}
		if(!flag)
		{
			alert("Please select at least one value to proceed.");
			return false;
		}
		if(document.frm.selAction.value == \'delete\')
		{
			return confirmDeletion();
		}
		return true;
	}
	function confirmDeletion()
	{
		flag =false;		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].type=="checkbox" && document.frm.elements[i].name=="chkPage[]" && true == document.frm.elements[i].checked)
			{
				flag = true;
				break;
			}
		}
		if(true == flag)
		{
			$action = confirm("Do you really want to delete the selected record(s)?");
		}
		if($action)
		{
			return true;
		}
		return false;
	}
//'; ?>
]]></script>
<h2><?php echo $this->_tpl_vars['TOP_NAVIGATION']; ?>
</h2>
<?php if ($this->_tpl_vars['ERROR_MSG']): ?>
	<div class="w100p errMsg clear"><?php echo $this->_tpl_vars['ERROR_MSG']; ?>
</div>
<?php endif; ?>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
<div class="row">
	<label class="small_label">Add New App</label>
</div>
<div class="row">
	<label class="small_label">Name:<span class="req">*</span></label>
	<input type="text" name="vName" value="<?php echo $this->_tpl_vars['DATA']['vName']; ?>
" maxlength="100" />
</div>
<div class="row">
	<label class="small_label">Description:</label>
	<input type="text" name="vDescription" value="<?php echo $this->_tpl_vars['DATA']['vDescription']; ?>
" />
</div>
<div class="row">
	<label class="small_label">Internal Description:</label>
	<input type="text" name="vInternalDescription" value="<?php echo $this->_tpl_vars['DATA']['vInternalDescription']; ?>
" />
</div>
<div class="row">
	<label class="small_label">Paid Date:<span class="req">*</span></label>
	<input type="text" name="dPaidDate" id="dPaidDate" value="<?php echo $this->_tpl_vars['DATA']['dPaidDate']; ?>
" readonly="readonly" />
</div>
<div class="row">
	<label class="small_label">Reference:<span class="req">*</span></label>
	<input type="text" name="vReference" value="<?php echo $this->_tpl_vars['DATA']['vReference']; ?>
" maxlength="100" />
</div>
<?php if ($_GET['id']): ?>
<div class="row">
	<label class="small_label"></label>
	<span style="margin:7px 0 5px 0;float:left;"><?php echo $this->_tpl_vars['DATA']['dDateTime']; ?>

</div>
<?php endif; ?>
<div class="row">
	<label class="small_label"></label>
	<input type="submit" name="submit" value=" Add / Edit " class="submit_button" onclick="document.getElementById('loader').style.display = 'block';" />	
	<div id="loader"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/admin/ajax-loader.gif" alt="Loading..." title="Loading..." /></div>
</div>
</form>
<!-- xxxxxxxxx Grid Table xxxxxxxxx -->

<?php if ($this->_tpl_vars['IS_RECORD'] == false): ?>
	<div class="w100p errMsg">No Record</div>
<?php else: ?>
<div class="w100p">
	<div class="new_rec"><input type="button" name="cancel" value="&laquo; Back" onclick="window.location=('<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=clientlist&page=<?php echo $this->_tpl_vars['PAGE']; ?>
');" class="submit_button" /></div>
	<div class="paging_div"><?php echo $this->_tpl_vars['PAGING']; ?>
</div>
</div>
<form name="frm" action="" method="post" onsubmit="return chkForm();">
<input type="hidden" name="page" value="<?php echo $this->_tpl_vars['PAGE']; ?>
" />
<table width="100%" cellpadding="0" cellspacing="0" class="grid">		
<tr>
	<th class="check_list"><input type="checkbox" name="chkAll" onclick="javascript:return checkAll();"></th>
	<th>Name</th>
	<th>Description</th>					
	<th>Paid Date</th>					
	<th>Reference</th>					
	<th class="status">Status</th>
</tr>
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['ARR_DATA']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
<tr>
	<td class="check_list"><input type="checkbox" name="chkPage[]" value="<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
" id="chkPage"></td>
	<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vName'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</td>
	<td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vDescription'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, "...") : smarty_modifier_truncate($_tmp, 30, "...")); ?>
</td>
	<td><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['dPaidDate']; ?>
</td>
	<td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vReference'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, "...") : smarty_modifier_truncate($_tmp, 30, "...")); ?>
</td>
	<td class="status" align="center">
	<a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/adminindex.php?action=applist&client_id=<?php echo $_GET['client_id']; ?>
&id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
&<?php echo $this->_tpl_vars['EXTRA_ATT']; ?>
" border="0"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_edit.png" alt="Edit" title="Edit" border="0"></a>
	<a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/adminindex.php?action=deleteapp&client_id=<?php echo $_GET['client_id']; ?>
&id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
&<?php echo $this->_tpl_vars['EXTRA_ATT']; ?>
" border="0" onclick="javascript:return confirm('Do you really want to delete this record?');">
	<img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_delete.png" alt="Delete" title="Delete" border="0" /></a>
		</td>
</tr>			
<?php endfor; endif; ?>			
</table>		
<div class="row active">
<select name="selAction" class="left">
		<option value="delete">Delete</option>
</select>
<input name="" type="submit" value="" class="go_btn left" />
</div>
<?php endif; ?>
</form>		
<script type="text/javascript" charset="utf-8">
<?php echo '
jQuery(function($){$("#dPaidDate").attachDatepicker({showOn: \'button\', buttonImage: \'';  echo $this->_tpl_vars['ADMIN_GRAPHICS_URL'];  echo 'CalendarLogo.jpg\', buttonImageOnly: true,yearRange:\'-2:+5\',fileds_to_hide:\'\'});});
'; ?>

</script>