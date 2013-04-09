<?php /* Smarty version 2.6.15, created on 2013-03-21 14:42:51
         compiled from admin_client_list.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'admin_client_list.tpl.html', 63, false),array('modifier', 'htmlentities', 'admin_client_list.tpl.html', 63, false),array('modifier', 'truncate', 'admin_client_list.tpl.html', 97, false),array('modifier', 'date_format', 'admin_client_list.tpl.html', 100, false),)), $this); ?>
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
<form name="search_form" action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=searchclient" method="post">
<div class="search_bar">
<input name="" type="button" class="right" onclick="this.form.submit();" />
<input type="text" name="txtSearch" maxlength="50" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['SEARCH_KEYWORD'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
" class="right" />
</div>
</form>
<!-- xxxxxxxxx Search Bar xxxxxxxxx -->
<div class="clear"></div>
<h2><?php echo $this->_tpl_vars['TOP_NAVIGATION']; ?>
</h2>
<!-- xxxxxxxxx Grid Table xxxxxxxxx -->
<div class="w100p">
	<div class="new_rec">[<a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=aeclient"><b>Add Client</b></a>]</div>
	<div class="paging_div"><?php echo $this->_tpl_vars['PAGING']; ?>
</div>
</div>
<?php if ($this->_tpl_vars['IS_RECORD'] == false): ?>
	<div class="w100p errMsg">No Record</div>
<?php else: ?>
<?php if ($this->_tpl_vars['ERROR_MSG']): ?>
	<div class="w100p errMsg clear"><?php echo $this->_tpl_vars['ERROR_MSG']; ?>
</div>
<?php endif; ?>

<form name="frm" action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=<?php if ($this->_tpl_vars['SEARCH_KEYWORD']): ?>searchclient&txtSearch=<?php echo $this->_tpl_vars['SEARCH_KEYWORD'];  else: ?>clientlist<?php endif; ?>" method="post" onsubmit="return chkForm(); ">
<input type="hidden" name="page" value="<?php echo $this->_tpl_vars['PAGE']; ?>
">
<table width="100%" cellpadding="0" cellspacing="0" class="grid">		
<tr>
	<th class="check_list"><input type="checkbox" name="chkAll" onclick="javascript:return checkAll();"></th>
	<th>Client Name</th>
	<th>Email</th>
	<th>Apps</th>
	<th>Slots</th>
	<th>Reg Date</th>					
	<th class="status">Status</th>
</tr>
<?php unset($this->_sections['row']);
$this->_sections['row']['name'] = 'row';
$this->_sections['row']['loop'] = is_array($_loop=$this->_tpl_vars['ARR_DATA']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['row']['show'] = true;
$this->_sections['row']['max'] = $this->_sections['row']['loop'];
$this->_sections['row']['step'] = 1;
$this->_sections['row']['start'] = $this->_sections['row']['step'] > 0 ? 0 : $this->_sections['row']['loop']-1;
if ($this->_sections['row']['show']) {
    $this->_sections['row']['total'] = $this->_sections['row']['loop'];
    if ($this->_sections['row']['total'] == 0)
        $this->_sections['row']['show'] = false;
} else
    $this->_sections['row']['total'] = 0;
if ($this->_sections['row']['show']):

            for ($this->_sections['row']['index'] = $this->_sections['row']['start'], $this->_sections['row']['iteration'] = 1;
                 $this->_sections['row']['iteration'] <= $this->_sections['row']['total'];
                 $this->_sections['row']['index'] += $this->_sections['row']['step'], $this->_sections['row']['iteration']++):
$this->_sections['row']['rownum'] = $this->_sections['row']['iteration'];
$this->_sections['row']['index_prev'] = $this->_sections['row']['index'] - $this->_sections['row']['step'];
$this->_sections['row']['index_next'] = $this->_sections['row']['index'] + $this->_sections['row']['step'];
$this->_sections['row']['first']      = ($this->_sections['row']['iteration'] == 1);
$this->_sections['row']['last']       = ($this->_sections['row']['iteration'] == $this->_sections['row']['total']);
?>
<tr>
	<td class="check_list"><input type="checkbox" name="chkPage[]" value="<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
" id="chkPage"></td>
	<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['vName'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</td>	
	<td><a href="mailto:<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['vEmail']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['vEmail'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, "...") : smarty_modifier_truncate($_tmp, 30, "...")); ?>
</a></td>
	<td align="center">[ <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/adminindex.php?action=applist&client_id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
" title="Manage Apps"><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['app_count']; ?>
</a> ]</td>
	<td align="center"><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/adminindex.php?action=slotlist&client_id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
" title="Manage Slots"><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iTotalSlots']; ?>
</a> | <?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iConsumedSlots']; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['dRegDate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
	<td class="status"><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=aeclient&clientid=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
&<?php echo $this->_tpl_vars['EXTRA_ATT']; ?>
" border="0"><img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_edit.png" alt="Edit" title="Edit" border="0"></a>
	<a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/adminindex.php?action=deleteclient&clientid=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
&<?php echo $this->_tpl_vars['EXTRA_ATT']; ?>
" border="0" onclick="javascript:return confirm('Do you really want to delete this record?');">
	<img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_delete.png" alt="Delete" title="Delete" border="0" /></a>
	<?php if ($this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iActive'] == 1): ?>
	<img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_status.png" alt="Active" title="Active">
	<?php else: ?>
	<img src="<?php echo $this->_tpl_vars['ADMIN_GRAPHICS_URL']; ?>
icon_inactive.gif" alt="Inactive" title="Inactive">
	<?php endif; ?>
	</td>
</tr>
<tr>
	<td style="padding:0;background-color:#d5ffff;" colspan="6" align="center" id="campaign_<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['row']['index']]['iId']; ?>
" class="campaign_rows"></td>
</tr>
<?php endfor; endif; ?>			
</table>		

  <!-- xxxxxxxxx Grid Table xxxxxxxxx -->
<div class="row active">
<select name="selAction" class="left">
	<option value="activate">Activate</option>
	<option value="deactivate">Deactivate</option>
	<option value="delete">Delete</option>
</select>
<input name="" type="submit" value="" class="go_btn left" />
</div>
<?php endif; ?>
</form>	