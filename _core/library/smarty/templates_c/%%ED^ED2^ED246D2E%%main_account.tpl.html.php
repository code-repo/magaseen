<?php /* Smarty version 2.6.15, created on 2013-02-05 08:34:33
         compiled from main_account.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'main_account.tpl.html', 147, false),)), $this); ?>
<script type="text/javascript" >
<?php echo '
 $(document).ready(function() { 
	$(\'#photoimg\').live(\'change\', function(){
	//alert(\'here\');
		loader = img = siteurl+\'graphics/main/ajax-loader.gif\';
		$(\'#img_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#img_preview\').attr(\'src\',img);
		$(\'#submit_button\').attr(\'disabled\', \'disabled\');
		$("#imageform").ajaxForm({
			success: function(responseText){
				//alert(responseText);
				img = siteurl+\'product/magazine/thumb/\'+responseText;
				$(\'#image_name\').val(responseText);
				$(\'#img_preview\').attr(\'style\', \'margin-top:0px\');
				$(\'#img_preview\').attr(\'src\',img);
				$(\'#submit_button\').removeAttr(\'disabled\');
			}
		}).submit();
	});
	$("a[rel=example_group]").fancybox({
			     \'opacity\'		    : true,
				\'overlayShow\'	    : true,
				\'transitionIn\'		: \'elastic\',
				\'transitionOut\'		: \'elastic\',
				\'titlePosition\' 	: \'over\',
				\'showNavArrows\' 	: false,
				\'onClosed\' 			: function() { reset_magazine_popup() },
				\'titleFormat\'		: function(title, currentArray, currentIndex, currentOpts) {
					return \'<span id="fancybox-title-over">Image \' + (currentIndex + 1) + \' / \' + currentArray.length + (title.length ? \' &nbsp; \' + title : \'\') + \'</span>\';
				}
			});
});
function set_magazine_popup(id){
	$.ajax({
		url: siteurl+"product/index.php?action=get_magazine_data&id="+id,
		type: "GET",
		context: document.body,
		success: function(data){
			var obj = jQuery.parseJSON(data);
			$(\'#id\').val(obj.iId);
			$(\'#vName\').val(obj.vName);
			$(\'#vDescription\').val(obj.vDescription);
			$("#iAppId option").each(function () {
				if ($(this).val() == obj.iAppId)
					$(this).attr(\'selected\', \'selected\');
			});
			img = siteurl+\'product/magazine/thumb/\'+obj.vImage;
			$(\'#image_name\').val(obj.vImage);
			$(\'#img_preview\').attr(\'src\',img);
		}
	});
}
function reset_magazine_popup(){
	file_src = siteurl+\'graphics/main/thumb_preview.png\';
	$(\'#id\').val(\'\');				
	$(\'#vName\').val(\'\');
	$(\'#vDescription\').val(\'\');
	$(\'#image_name\').val(\'\');
	$(\'#gallery_file\').val(\'\');
	$(\'#img_preview\').attr(\'src\', file_src);
}
'; ?>
		
</script>
<div id="content_area">
	<!-- xxxxx Title Bar xxxxxxx -->
	<div class="title_bar">
	<!-- xxxxx Left Area xxxxxxx -->
	<div class="left_area">
	<h1>Administrador de Contenidos</h1>
	</div>
	<!-- xxxxx //Left Area xxxxxxx -->
	<!-- xxxxx Right Panel xxxxxxx -->
	<div class="right_panel">
	<div class="add_magazine_btn"><a rel="example_group" href="#inline1"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/add_icon.png" alt="" /> <span>Agregar nueva revista</span></a> </div>
	</div>
	<!-- xxxxx //Right Panel xxxxxxx -->
	</div>
	<div class="clear"></div>
	<!-- xxxxx //Title Bar xxxxxxx -->
	<!-- xxxxxxxxxxxx Left Area xxxxxxxxxxxx -->
	<div class="left_area">
		<div class="content">
		<?php if ($_GET['showapps']): ?>
			<!-- <h2>Magazines for <?php echo $_GET['name']; ?>
</h2> -->
			<?php $this->assign('id', $_GET['app_id']); ?>
			<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
				<div class="magazine_list">
					<a rel="example_group" href="#inline1" onclick="set_magazine_popup('<?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iId']; ?>
');"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/magazine/thumb/<?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vImage']; ?>
" /></a>
					<h3><?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
</h3>
					<p><?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vDescription']; ?>
</p>
				</div>
			<?php endfor; else: ?>
				No record.
			<?php endif; ?>
		<?php else: ?>
			<h4>Bienvenido. Utiliza las herramientas de la derecha para administrar tus publicaciones</h4>

			Lorem ipsum dolor sit amet, consectetueng elit. Praesent vestibulum molestie lacusanmy hender it mauris lroetes. Phasellus porta. Fusce scipit variusmiu. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla dui. Fusce feugiat malesuada odio. Morbi nunc odio ravida at.
		<?php endif; ?>
		<div class="clear"></div>
		</div>
	<!-- xxxxxx //Content xxxxxx -->
	</div>
	<!-- xxxxxxxxxxxx //Left Area xxxxxxxxxxxx -->
	<!-- xxxxxxxxxxxx Right Panel xxxxxxxxxxxx -->
	<div class="right_panel"> 
	<!-- xxxxxx Content xxxxxx -->
	<div class="content">
	<h2>Proyectos disponibles</h2>
	<ul>
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
	<?php $this->assign('id', $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']); ?>
	<li>
		 <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php?showapps=1&app_id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
&name=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vName']; ?>
" title="<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vDescription']; ?>
"><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vName']; ?>
</a> &nbsp;
		<!--  (<a href="javascript:void(0);" onclick="show_magazine_popup(<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
, '<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vName']; ?>
');">Add Magazine</a>) -->
		<ul>
			<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
			<!-- <li> <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=publist&m_id=<?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iId']; ?>
&name=<?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
" title="View/Add publications for <?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
"><?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
</a></li> -->
			<li> <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=publist&m_id=<?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iId']; ?>
" title="Add publications for <?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
"><?php echo $this->_tpl_vars['ARR_MAGAZINE'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vName']; ?>
</a></li>
			<?php endfor; endif; ?>
		</ul>
	</li>
	<?php endfor; endif; ?>
	</ul>
	</div>
	<!-- xxxxxx //Content xxxxxx -->
	</div>
	<!-- xxxxxxxxxxxx //Right Panel xxxxxxxxxxxx -->
	<!-- xxxxxxxxxxxxxxxxxx //Content Area xxxxxxx -->
	<div class="clear"></div>
</div>

<div style="display: none;" id="">	
	<div id="inline1" class="popup">
		<!-- <div class="image"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/portfolio_l.jpg" /></div> -->
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php" id="imageform" enctype="multipart/form-data" method="post" name="fileinfo" onsubmit="return false;">		
		<input type="hidden" name="image_name" id="image_name" />
		<input type="hidden" name="id" id="id" />
			<h1>Agregar revista</h1>
			<div id="output" class="errMsg"></div>
			<div class="one_half">
				<label>Nombre de la revista:</label><br />
				<input id="vName" name="vName" type="text" /><br />
				<label>Tipo de la revista:</label><br />
				<?php echo smarty_function_html_options(array('name' => 'iAppId','id' => 'iAppId','options' => $this->_tpl_vars['APPS']), $this);?>
<br />
				<label>Description:</label><br />
				<textarea id="vDescription" name="vDescription"></textarea><br />
				<label>Selecciona la imagen correspondiente:</label><br />
				<input type="file" name="userfile" id="photoimg" class="fileUpload" /><br />
				<br /><br />
				<input name="" value="Guardar" type="button" id="submit_button" onclick="return validate_magazine();" />
				<input name="" value="Salir" type="button" style="margin-left:10px" onclick="$.fancybox.close()" />
			</div>
			<!-- xxx //onehalf xxx -->
			<div class="one_half last">
				<label>Selecciona la imagen correspondiente:</label><br />
				<div class="m_thumb"  />
					<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/thumb_preview.png" id="img_preview" alt=""   />
				</div>
				<div class="clear"></div>
			</div>
		</form>
		</div>
		<div class="clear"></div>
	</div>
	
</div>