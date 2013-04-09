<?php /* Smarty version 2.6.15, created on 2013-03-21 14:39:01
         compiled from main_add_publication.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'main_add_publication.tpl.html', 284, false),array('function', 'html_options', 'main_add_publication.tpl.html', 289, false),)), $this); ?>
﻿<script src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
script/main/jquery-ui-1.9.0.custom.min.js" type="text/javascript"></script>

<script type="text/javascript">
<?php echo '
$(document).ready(function() { 
	counter = ';  echo $this->_tpl_vars['DIV_COUNT'];  echo ';
	page_count = ';  echo $this->_tpl_vars['PUB_FILE_COUNT'];  echo ';
	$( "#dActivationDate" ).datepicker({ dateFormat: "yy-mm-dd" });
	//Make element draggable
	f=0;
	
	$(".drag").draggable({
		revert		: \'invalid\', 
		helper		: \'clone\',
		containment	: \'frame\',
		/*cursor		: \'crosshair\',*/
		cursorAt	: { left:-1,top:-1 },

		//When first dragged
		stop		:function(ev, ui) 
		{
		    if(this.id=="drag8")
			{
			 f=1;
			}
			else
			{
			f=0;
			}
			//console.log(ui);
			var pos	= $(ui.helper).offset();
			var left_	= ev.pageX - $("#frame").position().left;
			var top_	= ev.pageY - $("#frame").position().top;
			// get widht and height of the container div#frame element
			var w_ = $("#frame").width();
			var h_ = $("#frame").height();
			
			div_id = "clonediv"+counter;
			objName	 = "#clonediv"+counter++;
			objNamex = "clonediv"+counter;

			element_type = document.getElementById(div_id).querySelector("a").id;
			parent_div = document.getElementById(div_id).parentNode.id;
			parent_id = parent_div.replace(\'frame_file_\',\'\');
			
			//check if dropped inside the conteiner div#frame										
			if((left_ >= 0) && (left_ <= w_) && (top_ >= 0) && (top_ <= h_))
			{
				$(objName).css({"left":left_,"top":top_});
				
				// assign a z-index value
				zindex = left_ + top_;
				$(objName).css({"z-index":zindex});
				//$(objName).attr(\'title\', \'Some Text :: \'+objName);
				$(objName).attr(\'title\', \'\');
				$(objName).addClass("lgutipT");
				$(objName).removeClass("drag");
				
				// Send via ajax XY position of the cloned element
				frm_data = "x="+left_+"&y="+top_+"&pub_file_id="+parent_id+"&element_type="+element_type+"&div_id="+div_id;
				
				//addHotspot(frm_data, div_id);
				
				$.ajax({
					url: siteurl+"product/index.php?action=addhotspot",
					data: frm_data,
					cache: false,
					type: "GET",
					context: document.body,
					success: function(data){
						/*var id = div_id+\'_id\'
						var hfield = document.getElementById(id);
						//Check if the hidden filed is not created then create one for the hotspot id
						if(typeof hfield  == "undeifned" || hfield == null){
							hidden_field = \'<input type="hidden" id="\'+id+\'" value="\'+data+\'" />\';
							$(\'#hidden_fields\').append(hidden_field);
						}*/
						bind_dragstop_event(div_id ,data);
						bind_click_event(div_id, data);
					}
				});
			}
			createPopupLink();
			//When an existiung object is dragged
			recreate_dragable(objName, parent_id, element_type, div_id)
			if(f==1)
			{
			$("#"+div_id).height(200);
			$("#"+div_id).width(200);
			$(".drag1").width(26);
			$("#"+div_id).css("border","1px solid black");
			$("#"+div_id).resizable({
			maxHeight: 300,
			maxWidth: 300,
			minHeight: 200,
			minWidth: 200
			});
			$(".drag1").draggable({
			containment	: "#"+div_id
			});
			}
		}
	});
		
	$(\'#photo_file\').live(\'change\', function(){
		if(!(validate_photo_file($(\'#photo_file\').val(), \'photo_error\'))) {
			return false;
		}
		img = siteurl+\'graphics/main/ajax-loader.gif\';
		$(\'#photo_preview\').attr(\'src\',img);
		$(\'#photo_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#photo_submit_button\').attr(\'disabled\', \'disabled\');
		$("#photo_form").ajaxForm({
			success: function(responseText){
				//alert(responseText);
				img = siteurl+\'product/hotspot/thumb/\'+responseText;
				$(\'#photo_file_name\').val(responseText);
				$(\'#photo_preview\').attr(\'style\', \'margin-top:0px\');
				$(\'#photo_preview\').attr(\'src\',img);
				$(\'#photo_submit_button\').removeAttr(\'disabled\');
			}
		}).submit();
	});
	
	$(\'#sponsor_file\').live(\'change\', function(){
		if(!(validate_photo_file($(\'#sponsor_file\').val(), \'sponsor_error\'))) {
			return false;
		}
		img = siteurl+\'graphics/main/ajax-loader.gif\';
		$(\'#sponsor_preview\').attr(\'src\',img);
		$(\'#sponsor_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#sponsor_submit_button\').attr(\'disabled\', \'disabled\');
		$("#sponsor_form").ajaxForm({
			success: function(responseText){
				//alert(responseText);
				img = siteurl+\'product/hotspot/thumb/\'+responseText;
				$(\'#sponsor_file_name\').val(responseText);
				$(\'#sponsor_preview\').attr(\'style\', \'margin-top:0px\');
				$(\'#sponsor_preview\').attr(\'src\',img);
				$(\'#sponsor_submit_button\').removeAttr(\'disabled\');
			}
		}).submit();
	});
	
	$(\'#video_file\').live(\'change\', function(){
		if(!(validate_video_file($(\'#video_file\').val(), \'video_error\'))) {
			return false;
		}
		$(\'#video_loader\').css("display", "block");
		img = siteurl+\'graphics/main/ajax-loader.gif\';
		//$(\'#video_preview\').attr(\'src\',img);
		//$(\'#video_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#video_submit_button\').attr(\'disabled\', \'disabled\');
		$("#video_form").ajaxForm({
			success: function(responseText){
				$(\'#video_loader\').css("display", "none");
				//alert(responseText);
				img = siteurl+\'product/hotspot/thumb/\'+responseText;
				$(\'#video_file_name\').val(responseText);
				//$(\'#video_preview\').attr(\'style\', \'margin-top:0px\');
				//$(\'#video_preview\').attr(\'src\',img);
				$(\'#video_submit_button\').removeAttr(\'disabled\');
			}
		}).submit();
	});
	
	$(\'#gallery_file\').live(\'change\', function(){
		if(!(validate_photo_file($(\'#gallery_file\').val(), \'gallery_error\'))) {
			return false;
		}
		img = siteurl+\'graphics/main/ajax-loader.gif\';
		$(\'#gallery_loader\').css("display", "block");
		//$(\'#gallery_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#hotspot_id\').val($(\'#current_hotspot_id\').val());
		$(\'#gallery_submit_button\').attr(\'disabled\', \'disabled\');
		$("#gallery_form").ajaxForm({
			success: function(responseText){
				$(\'#gallery_loader\').css("display", "none");
				//alert(responseText);
				li = \'<li><img class="gall_image" src="\'+siteurl+\'product/hotspot/\'+responseText+\'"/></li>\';
				$(\'#pikame\').append(li);
				$(\'#gallery_submit_button\').removeAttr(\'disabled\');
				$(\'#gall_main_img\').attr(\'src\', siteurl+\'product/hotspot/\'+responseText);
				$(\'.gall_image\').click(function() {
					$(\'#gall_main_img\').attr(\'src\', this.src);
				});
			}
		}).submit();
	});
	
	$(\'#view_360_file\').live(\'change\', function(){
		if(!(validate_photo_file($(\'#view_360_file\').val(), \'view_360_error\'))) {
			return false;
		}
		img = siteurl+\'graphics/main/ajax-loader.gif\';
		$(\'#view_360_loader\').css("display", "block");
		//$(\'#view_360_preview\').attr(\'style\', \'margin-top:90px\');
		$(\'#view_360_hotspot_id\').val($(\'#current_hotspot_id\').val());
		$(\'#view_360_submit_button\').attr(\'disabled\', \'disabled\');
		$("#view_360_form").ajaxForm({
			success: function(responseText){
				$(\'#view_360_loader\').css("display", "none");;	
				//alert(responseText);
				li = \'<li><img class="view_360_image" src="\'+siteurl+\'product/hotspot/\'+responseText+\'"/></li>\';
				$(\'#view_360_icon\').append(li);
				$(\'#view_360_submit_button\').removeAttr(\'disabled\');
				$(\'#view_360_main_img\').attr(\'src\', siteurl+\'product/hotspot/\'+responseText);
				$(\'.view_360\').click(function() {
					$(\'#view_360_main_img\').attr(\'src\', this.src);
				});
			}
		}).submit();
	});
		
	//$(\'#file_box\').click(save_pub_basic_info);	

	$(\'#pub_file\').live(\'change\', function(){
		img = \'<img src="\'+siteurl+\'graphics/main/ajax-loader.gif" />\';

		if(!(validate_photopdf_file($(\'#pub_file\').val(), \'pub_loading\'))) {
			return false;
		}
		$(\'#pub_loading\').html(img);
		$("#pub_file_form").ajaxForm({
			success: function(responseText){
				$(\'#pub_file\').val(\'\');
				document.getElementById(\'pub_file\').value = \'\';
				$(\'#pub_loading\').html(\'File uploaded successfully. Browse to upload more files.\');
				$(\'#save_button\').removeAttr(\'disabled\');
				var obj = jQuery.parseJSON(responseText);
				for(i=0; i<obj.length; i++)
				{
					page_count = page_count+1;
					$(\'#page_count\').html(page_count);
					$(\'#pub_file_list\').append(\'<li style="cursor:pointer;" id="file_\'+obj[i].id+\'" onclick="set_image(this.id);">\'+obj[i].disp_name+\'</li>\');
					
					$(\'#frame\').append(\'<div id="frame_file_\'+obj[i].id+\'" class="sub_frame ui-droppable" style="display:none; background-image: url(\\\'\'+siteurl+\'product/publication/small/\'+obj[i].file_name+\'\\\');"></div>\');
				}
				
				create_dropable();
				load_publications();
			}
		}).submit();
	});
	
	//create_gallery();
	createPopupLink();
	$(\'#pub_manage\').click(function(){});
	create_dropable();
	load_publications();
	load_artilces();
});

'; ?>

</script> 
<div style="dispkay:none;" id="hidden_fields"><input type="hidden" id="current_hotspot_id" /></div>
 <!-- xxxxx Title Bar xxxxxxx -->
      <div class="title_bar">
        <!-- xxxxx Left Area xxxxxxx -->
        <div class="left_area">
          <h1>Revistas disponibles</h1>
        </div>
        <!-- xxxxx //Left Area xxxxxxx -->
        <!-- xxxxx Right Panel xxxxxxx -->
        <div class="right_panel" style="display:none">
          <div class="add_magazine_btn"><a rel="example_group" href="#inline1"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/add_icon.png" alt="" /> <span>Agregar nueva revista</span></a> </div>
        </div>
        <!-- xxxxx //Right Panel xxxxxxx -->
      </div>
      <div class="clear"></div>
      <!-- xxxxx //Title Bar xxxxxxx -->
      <!-- xxxxxx Content xxxxxx -->
      <!-- xx Accordian 1 xx -->
      <div class="accordian_cont">
        <h3 class="acc-trigger"> <a href="#">Informacion Basica</a> </h3>
        <div class="acc-container">
		<form name="basic_info" id="basic_info">
		<input type="hidden" name="m_id" value="<?php echo $_GET['m_id']; ?>
" />
		<input type="hidden" name="pub_id" id="pub_id" value="<?php echo $this->_tpl_vars['DATA']['iId']; ?>
" />
          <div class="one_half">
			<div class="clear errMsg" id="pub_err"></div>
            <label>Nombre de la publicacion:</label>
            <br />
           <input type="text" id="vName" name="vName" size="20" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['DATA']['vName'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" maxlength="100" />
            <br />
            <div class="clear"></div>
            <label>Mes de la publicacion:</label>
            <br />
           <?php echo smarty_function_html_options(array('name' => 'iMonth','id' => 'iMonth','options' => $this->_tpl_vars['months'],'selected' => $this->_tpl_vars['DATA']['iMonth']), $this);?>

            <br />
            <div class="clear"></div>
            <label>Descripcion:</label>
            <br />
            <textarea name="vDescription" id="vDescription"><?php echo $this->_tpl_vars['DATA']['vDescription']; ?>
</textarea>
          </div>
          <div class="one_half last">
          <label class="left margintop_10">Fecha de activacion:</label>
		  <input placeholder="yyyy/mm/dd" class="date" type="text" id="dActivationDate" name="dActivationDate" value="<?php echo $this->_tpl_vars['DATA']['dActivationDate']; ?>
" />
          <div class="clear"></div>
          <label>Vista general de la publicacion:</label><br /><br />
          <img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/ipad_graphic.png" alt="" />
          </div>
          <div class="clear"></div>
          </form>
        </div>
      </div>
      <!-- xx //Accordian 1 xx -->
      <!-- xx Accordian 2 xx -->
      <div class="accordian_cont">
        <h3 class="acc-trigger" id="file_box"> <a href="#">Importar Contenido</a> </h3>
        <div class="acc-container">
        	<div class="one_half">
			<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=addpub" name="pub_file_form" id="pub_file_form" enctype="multipart/form-data" method="post">
            <input name="a" type="radio" value="0" checked="checked" /> Un archivo PDF que contiene todas las paginas de la publicacion <br /><br />
            <input name="a" type="radio" value="1" /> Un archivo ZIP que contiene todas las páginas de la publicación <br />
            <span class="small_txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nota: todos los archivos deberan ser de un mismo formato (PDF 0 JPGE 0 PNG)</span>
            <br /><br />
			<!-- <a id="article" rel="example_group" href="#add_article">Add Article</a><br />
            <span id="link_article"></span> -->
			<input type="hidden" name="pub_id" id="file_pub_id" value="" />
			<?php if ($this->_tpl_vars['IE']): ?>
			<input type="file" name="pub_file" id="pub_file" class="fileUpload" />
			<?php else: ?>
			<div style='height: 0px;width:0px; overflow:hidden;'><input type="file" name="pub_file" id="pub_file" class="fileUpload" /></div>
			<input name="" value="Seleccionar" type="button" onclick="getFile();"/>
			<?php endif; ?>
            <br /><br />
           <div class="clear errMsg" id="pub_loading"></div>
           <br />
            Total de paginas: <strong class="black_txt" id="page_count"><?php echo $this->_tpl_vars['PUB_FILE_COUNT']; ?>
</strong>
			</form>
            </div>
            <div class="one_half last center_txt">
            <h4>Estructura Requerida (nombre de los archivos)</h4>
            <img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/importar_graphic.png" alt="" />
           	<h4>Nombre<span class="light_blue_txt">-</span><span class="black_txt">DDMMYYYY</span><span class="light_blue_txt">-</span><span class="green_txt">###</span><span class="light_blue_txt">.pdf</span></h4>
            La resolucion minima requerida por pagina para las vistas<br />
disponsible, debera ser de:<br />
<span class="black_txt">1536 x 2048</span>
            <br /><br />
            
            </div>
            <div class="clear"></div>
          <!-- xxx //onehalf xxx -->
        </div>
      </div>
      <!-- xx //Accordian 2 xx -->
      <!-- xx Accordian 3 xx -->
      <div class="accordian_cont">
        <h3 class="acc-trigger" id="pub_manage"> <a href="#">Organizar Contenido</a> </h3>
        <div class="acc-container">
			<div style="float:left; width:100%;">
				<input type="hidden" id="cur_pub_file_id" />
				<a id="article" rel="example_group" href="#add_article">Add Article</a><br/>
				<span id="link_article">
				
				</span>
			</div>
			<img id="del" title= "delete images" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/delete_red.png" height=30 width=30 onclick=$(".del").css("display","inline");>
			<img id="fin" title= "finish deleting" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/finish_deleting.png" height=37 width=37 onclick=$(".del").css("display","none");>
			<div id="article_output_msg" style="float:left; width:100%; color:red;"></div>
				<!-- Left panel -->
            <div class="left_panel">
            <div class="content" style=" height: 678px;overflow: auto;">
				<h2>Contenido</h2>
				<ul id="pub_file_list">
				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['PUB_FILE']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<li style="cursor:pointer;" id="file_<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']; ?>
" onclick="set_image(this.id);">
					<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['vDispName']; ?>

					<img style="display:none;" title= "delete <?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['vDispName']; ?>
 and its hotspots" class="del" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/delete_red.png" height=16 width=16 onclick='if(confirm("are you sure to delete")){$(this).load("<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=delpubimg&id=<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']; ?>
&name=<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['vFile']; ?>
");$("#file_<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']; ?>
").hide(100);}'>
					<span class="article_title"><?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['art_name']; ?>
</span>
				</li>
				<?php endfor; endif; ?>
				</ul>
			</div>
	</div>
	<!-- // Left panel -->
	<!-- center panel -->
	<div class="center_panel">
		<div id="frame">
		<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['PUB_FILE']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<?php $this->assign('id', $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']); ?>
			<div id="frame_file_<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']; ?>
" class="sub_frame ui-droppable" style="display:none; background: url('<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/publication/small/<?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['vFile']; ?>
'); background-position:center; background-size:473px 630px;">
			<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<div id="<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vDivId']; ?>
" class="ui-draggable dragged3 lgutipT" style="position: absolute; left: <?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iXPos']; ?>
px; top: <?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iYPos']; ?>
px; z-index: 252;"><a href="#add_<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['eType']; ?>
" rel="example_group" id="<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['eType']; ?>
"><img class="icon" alt="" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
/graphics/main/icon_<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['eType']; ?>
.png"></a></div>
				<script language="javascript">
				bind_click_event('<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vDivId']; ?>
', <?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['iId']; ?>
);
				recreate_dragable('#<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vDivId']; ?>
', <?php echo $this->_tpl_vars['PUB_FILE'][$this->_sections['i']['index']]['iId']; ?>
, '<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['eType']; ?>
', '<?php echo $this->_tpl_vars['HOTSPOT'][$this->_tpl_vars['id']][$this->_sections['j']['index']]['vDivId']; ?>
');
				</script>
			<?php endfor; endif; ?>
			
			</div>
		<?php endfor; endif; ?>
		</div>
	</div>
	<!-- //center panel -->
	<!-- xxxxxxxxxxxx Right Panel xxxxxxxxxxxx -->
    <div class="right_panel"> 
    	 <!-- xxxxxx Content xxxxxx -->
    	<div class="content">
        	<h2>Hot Spots</h2>
            <ul>
            <li><div class="drag" id="drag1"><a id="pub_link" rel="" href="#add_pub_link"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_pub_link.png" alt="" class="icon" /></a></div>Vinculo Pagina <a href="#" class="info"></a></li>
            <li><div class="drag" id="drag2"><a id="photo" rel="" href="#add_photo"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_photo.png" alt="" class="icon" /></a></div>Ampliar Imagen <a href="#" class="info"></a></li>
            <li><div class="drag" id="drag3"><a id="gallery" rel="" href="#add_gallery"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_gallery.png" alt="" class="icon" /></a></div>Galeria <a href="#" class="info"></a></li>
            <li><div class="drag" id="drag4"><a id="video" rel="" class="active" href="#add_video"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_video.png" alt="" class="icon" /></a></div>Video <a href="#" class="info"></a></li>
            <li><div class="drag" id="drag5"><a id="link" rel="" href="#add_link"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_link.png" alt="" class="icon" /></a></div>Vinculo Web <a href="#" class="info"></a></li>
            <li><div class="drag" id="drag6"><a id="sponsor" rel="" href="#add_sponsor"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_sponsor.png" alt="" class="icon" /></a></div>Patrocinador <a href="#" class="info"></a></li>
			<li><div class="drag" id="drag7"><a id="view_360" rel="" href="#add_view_360"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_view_360.png" alt="" class="icon" /></a></div>360 View<a href="#" class="info"></a></li>
			<li><div class="drag" id="drag8">
			<div class="drag1" id="drag1"><a id="pub_link" rel="" href="#add_pub_link"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_pub_link.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag2"><a id="photo" rel="" href="#add_photo"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_photo.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag3"><a id="gallery" rel="" href="#add_gallery"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_gallery.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag4"><a id="video" rel="" class="active" href="#add_video"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_video.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag6"><a id="sponsor" rel="" href="#add_sponsor"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_sponsor.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag5"><a id="link" rel="" href="#add_link"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_link.png" alt="" class="icon" /></a></div>
			<div class="drag1" id="drag7"><a id="view_360" rel="" href="#add_view_360"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/icon_view_360.png" alt="" class="icon" /></a></div>
			</div>group<a href="#" class="info"></a></li>
            </ul>
            <!-- popup 1 -->
            <div style="display: none;">
  <div id="pagina_info" class="popup">
  <h1>Agregar revista</h1>
  text
  </div>
  </div>
  <!-- // Popup -->
        </div>
        <!-- xxxxxx //Content xxxxxx -->
    </div>
    <!-- xxxxxxxxxxxx //Right Panel xxxxxxxxxxxx -->
    <div class="clear"></div>
        </div>
      </div>
      <!-- xx //Accordian 3 xx -->
            <input name="" onclick="location.href='<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=publist&m_id=<?php echo $_GET['m_id']; ?>
'" value="Salir" type="button" style="margin-left:10px" class="right" />
            <input name="" onclick="save_pub_basic_info('<?php echo $_GET['m_id']; ?>
', 1);" value="Guardar" type="button" class="right" id="save_button" />
      <!-- xxxxxx //Content xxxxxx -->
      <!-- xxxxxxxxxxxxxxxxxx //Content Area xxxxxxx -->
<!-- Popup sponsor -->
<div style="display: none;" id="">	
	<div id="add_sponsor" class="popup">
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=uploadhotspotfile" id="sponsor_form" enctype="multipart/form-data" method="post" name="sponsor_form" onsubmit="return false;">		
		<input type="hidden" name="sponsor_file_name" id="sponsor_file_name" />
		<input type="hidden" name="sponsor_id" id="sponsor_id" />
			<h1>Patrocinador</h1>
			<div id="sponsor_output" class="errMsg"></div>
			<div class="one_half">
				<label>Nombre del patrocinador:</label><br />
				<input id="sponsor_name" name="sponsor_name" type="text" /><br />
				<label>Link:</label><br />
				<input id="sponsor_link" name="sponsor_link" type="text" /><br />
				<label>Selecciona la imagen correspondiente:</label><br />
				<input type="file" name="userfile" id="sponsor_file" class="fileUpload" /><br />
				<div id="sponsor_error" class="errMsg"></div><br /><br />				
				<input name="" value="Guardar" type="button" id="sponsor_submit_button"  />
				<input name="" value="Salir" type="button" id="sponsor_cancel_button" style="margin-left:10px"  />
				<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
			</div>
			<!-- xxx //onehalf xxx -->
			<div class="one_half last">
				<label>Selecciona la imagen correspondiente:</label><br />
				<div class="m_thumb"  />
					<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/thumb_preview.png" id="sponsor_preview" alt=""   />
				</div>
				<div class="clear"></div>
			</div>
		</form>
		</div>
		<div class="clear"></div>
	</div>
	</div>
	</div>
	  
	  
<!-- Popup image -->
<div style="display: none;" id="">	
	<div id="add_photo" class="popup">
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=uploadhotspotfile" id="photo_form" enctype="multipart/form-data" method="post" name="photo_form" onsubmit="return false;">		
		<input type="hidden" name="photo_file_name" id="photo_file_name" />
		<input type="hidden" name="photo_id" id="photo_id" />
			<h1>Ampliar Imagen</h1>
			<div id="photo_output" class="errMsg"></div>
			<div class="one_half">
				<label>Nombre:</label><br />
				<input id="photo_name" name="photo_name" type="text" /><br />
				<label>Descripcion:</label><br />
				<textarea id="photo_desc" name="photo_desc"></textarea><br />
				<label>Selecciona la imagen correspondiente:</label><br />
				<input type="file" name="userfile" id="photo_file" class="fileUpload" /><br />
				<div id="photo_error" class="errMsg"></div><br /><br />				
				<input name="" value="Guardar" type="button" id="photo_submit_button"  />
				<input name="" value="Salir" type="button" id="photo_cancel_button" style="margin-left:10px"  />
				<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
			</div>
			<!-- xxx //onehalf xxx -->
			<div class="one_half last">
				<label>Selecciona la imagen correspondiente:</label><br />
				<div class="m_thumb"  />
					<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/thumb_preview.png" id="photo_preview" alt=""   />
				</div>
				<div class="clear"></div>
			</div>
		</form>
		</div>
		<div class="clear"></div>
	</div>
	</div>
	</div>

<!-- Popup video -->
<div style="display: none;" id="">	
	<div id="add_video" class="popup">
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=uploadhotspotvideo" id="video_form" enctype="multipart/form-data" method="post" name="video_form" onsubmit="return false;">		
		<input type="hidden" name="video_id" id="video_id" />
		<input type="hidden" name="video_file_name" id="video_file_name" />
			<h1>Cargar Video</h1>
			<div id="video_output" class="errMsg"></div>
			<div class="one_half">Ingresa la liga correspondiente del video(Youtube):</label><br />
				<input id="video_link" name="video_link" type="text" /><br />
				<label>Nombre del video:</label><br />
				<input id="video_name" name="video_name" type="text" /><br />
				<label>Descripcion:</label><br />
				<textarea id="video_desc" name="video_desc"></textarea><br />
				<label>Selecciona el video correspondiente:</label><br />
				<input type="file" name="userfile" id="video_file" class="fileUpload" />
				<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/ajax-loader.gif" id="video_loader" style="display:none;" /><br />
				<div id="video_error" class="errMsg"></div><br /><br />
				<input name="" value="Guardar" type="button" id="video_submit_button" />
				<input name="" value="Salir" type="button" style="margin-left:10px" id="video_cancel_button" />
				<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
			</div>
			<!-- xxx //onehalf xxx -->
			<div class="one_half last">
				<label>Selecciona la imagen correspondiente:</label><br />
				<div class="m_thumb" id="video_file_preview">
					<video width="290" height="200" controls id="">
					  <source src="" type="video/mp4">
					Your browser does not support the video tag.
					</video>
				</div>
				<div class="clear"></div>
			</div>
		</form>
		</div>
		<div class="clear"></div>
	</div>

<!-- Popup link -->
<div style="display: none;" id="">	
	<div id="add_link" class="popup">
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php" id="link_form" method="post" name="link_form" onsubmit="return false;">	
		<input type="hidden" name="link_id" id="link_id" />		
		<h1>Anadir vinculo web</h1>
		<div id="link_output" class="errMsg"></div>
		<div class="one_half">
			<label>Introduce un link para una pagina web:</label><br />
			<input id="link_url" name="link_url" type="text" value="" /><br /><br /><br />
			<input name="" value="Guardar" type="button" id="link_submit_button" />
			<input name="" value="Salir" type="button" id="link_cancel_button" style="margin-left:10px" />
			<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
		</div>
		
		<div class="clear"></div>
		</div>
	</form>
	</div>
	<div class="clear"></div>
</div>
<!-- Popup publication  link -->
<div style="display: none;" id="">	
	<div id="add_pub_link" class="popup">
		<div class="info">
		<form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
user/index.php" id="pub_link_form" method="post" name="pub_link_form" onsubmit="return false;">	
		<input type="hidden" name="pub_link_id" id="pub_link_id" />		
		<h1>Añadir vínculo página</h1>
		<div id="pub_link_output" class="errMsg"></div>
		<div class="one_half">
			<label>Selecciona la pagina deseada:</label><br />
			<span id="link_pub"></span><br /><br /><br />
			<input name="" value="Guardar" type="button" id="pub_link_submit_button" />
			<input name="" value="Salir" type="button" id="pub_link_cancel_button" style="margin-left:10px" />
			<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
		</div>
		
		<div class="clear"></div>
		</div>
	</form>
	</div>
	<div class="clear"></div>
</div>
<!-- ====== gallery popup ======== -->
<div style="display: none;">
  <div id="add_gallery" class="popup">
    <div class="info">
      <h1>Galeria de imagenes</h1>
	  <div id="gallery_output" class="errMsg"></div>
      <div class="one_half">
	  <form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=addhotspotgallery" id="gallery_form" enctype="multipart/form-data" method="post" name="gallery_form" onsubmit="return false;">		
		<input type="hidden" name="hotspot_id" id="hotspot_id" />
		<input type="hidden" name="gallery_id" id="gallery_id" />
		<input type="hidden" name="gallery_file_name" id="gallery_file_name" />
      <h5>Selecciona la opcion deseada:</h5>
      <input name="b" type="radio" value="0" /> Cargar una imagen ( una por una )<br /><br />
      <input name="b" type="radio" value="1" /> Cargar varias imagenes ( carpeta en formato .zip ) <br /><br />
        <input type="file" name="userfile" id="gallery_file" class="fileUpload" />
		<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/ajax-loader.gif" id="gallery_loader" style="display:none;" />
        <br />
        <br /><div class="clear"></div>
        <label>Nombre de la galeria:</label>
        <br />
        <input name="gallery_name" id="gallery_name" type="text" />
        <br />
        <label>Descripcion de la galeria:</label>
        <br />
       <textarea name="gallery_desc" id="gallery_desc" cols="" rows=""></textarea>
        <br />
        <br />
        <br />
        <br />
        <input name="" value="Guardar" type="button" id="gallery_submit_button"/>
        <input name="" value="Salir" type="button" id="gallery_cancel_button" style="margin-left:10px" />
		<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
		</form>
      </div>
      <!-- xxx //onehalf xxx -->
      <div class="one_half last">
		<div class="pika-image"><img id="gall_main_img" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/thumb_preview.png" height="315" width="345"/></div>
        <ul id="pikame"></ul>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- ====== /gallery popup ======== -->

<!-- ====== view_360 popup ======== -->
<div style="display: none;">
  <div id="add_view_360" class="popup">
    <div class="info">
      <h1>360 View de imagenes</h1>
	  <div id="view_360_output" class="errMsg"></div>
      <div class="one_half">
	  <form action="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=addhotspotgallery&type=view_360" id="view_360_form" enctype="multipart/form-data" method="post" name="view_360_form" onsubmit="return false;">		
		<input type="hidden" name="hotspot_id" id="view_360_hotspot_id" />
		<input type="hidden" name="view_360_id" id="view_360_id" />
		<input type="hidden" name="view_360_file_name" id="view_360_file_name" />
      <h5>Selecciona la opcion deseada:</h5>
    
        <input type="file" name="userfile" id="view_360_file" class="fileUpload" />
		<div id="view_360_error" class="errMsg"></div>
		<img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/ajax-loader.gif" id="view_360_loader" style="display:none;" />
        <br />
        <br /><div class="clear"></div>
        <label>Nombre de la galeria:</label>
        <br />
        <input name="view_360_name" id="view_360_name" type="text" />
        <br />
        <!-- <label>Link:</label>
        <br />
       <input name="view_360_link" id="view_360_link" type="text" />
        <br /> -->
        <label>Descripcion de la galeria:</label>
        <br />
       <textarea name="view_360_desc" id="view_360_desc" cols="" rows=""></textarea>
        <br />
        <br />
        <br />
        <br />
        <input name="" value="Guardar" type="button" id="view_360_submit_button"/>
        <input name="" value="Salir" type="button" id="view_360_cancel_button" style="margin-left:10px" />
		<input name="" value="Delete" type="button" class="delete_hotspot_button" style="margin-left:10px" />
		</form>
      </div>
      <!-- xxx //onehalf xxx -->
      <div class="one_half last">
		<div class="pika-image"><img id="view_360_main_img" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/thumb_preview.png" height="315" width="345"/></div>
        <ul id="view_360_icon"></ul>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- ====== /view_360 popup ======== -->
<!-- Popup article -->
<div style="display: none;" id="">	
	<div id="add_article" class="popup">
		<div class="info">
		<form action="" id="article_form" method="post" name="article_form" onsubmit="return false;">	
		<input type="hidden" name="article_id" id="article_id" />		
		<h1>Add new Article</h1>
		<div id="article_output" class="errMsg"></div>
		<div class="one_half">
			<label>Article Title:</label><br />
			<input id="article_title" name="article_title" type="text" value="" /><br /><br /><br />
			<input name="" value="Guardar" type="button" id="article_submit_button" />
			<input name="" value="Salir" type="button" id="article_cancel_button" style="margin-left:10px" />
		</div>
		
		<div class="clear"></div>
		</div>
	</form>
	</div>
	<div class="clear"></div>
</div>
<script><?php echo '
/*	Accordion Content
	/* ---------------------------------------------------------------------- */
	(function() {
		var $container = $(\'.acc-container\'),
			$trigger   = $(\'.acc-trigger\');
		$container.hide();
		$trigger.first().addClass(\'active\').next().show();
		var fullWidth = $container.outerWidth(true);
		$trigger.css(\'width\', fullWidth);
		$container.css(\'width\', fullWidth);		
		$trigger.on(\'click\', function(e) {
			if(save_pub_basic_info()){
				if( $(this).next().is(\':hidden\') ) {
					$trigger.removeClass(\'active\').next().slideUp(300);
					$(this).toggleClass(\'active\').next().slideDown(300);
				}
			}else{
				return false;
			}
			e.preventDefault();
		});
		// Resize
		$(window).on(\'resize\', function() {
			fullWidth = $container.outerWidth(true)
			$trigger.css(\'width\', $trigger.parent().width() );
			$container.css(\'width\', $container.parent().width() );
		});

	})();
	/* end Accordion Content */'; ?>

</script>