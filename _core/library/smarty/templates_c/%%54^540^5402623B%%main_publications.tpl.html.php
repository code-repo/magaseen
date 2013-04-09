<?php /* Smarty version 2.6.15, created on 2013-02-05 08:45:06
         compiled from main_publications.tpl.html */ ?>
<div class="title_bar">
        <!-- xxxxx Left Area xxxxxxx -->
        <div class="left_area">
          <h1>Revistas disponibles</h1>
			<?php if ($this->_tpl_vars['MESSAGE']): ?>
				<span class="errMsg"><?php echo $this->_tpl_vars['MESSAGE']; ?>
</span>
			<?php endif; ?>
			<br /><br /><h4>Publicaciones (# <?php echo $this->_tpl_vars['AVAILABLE_SLOTS']; ?>
)</h4>
        </div>
        <!-- xxxxx //Left Area xxxxxxx -->
        <!-- xxxxx Right Panel xxxxxxx -->
        <div class="right_panel">
          <div class="add_magazine_btn" id="pub_button"><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=addpub&m_id=<?php echo $_GET['m_id']; ?>
"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/add_icon.png" alt="" /> <span>Agregar nueva publicacion</span></a> </div>
          <div class="clear"></div>
          <div class="search_box"><input name="" type="text" /><input name="" type="image" class="right" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/search_btn.png" /></div>
        </div>
        <!-- xxxxx //Right Panel xxxxxxx -->
      </div>
      <div class="clear"></div>
      <!-- xxxxx //Title Bar xxxxxxx -->
       <!-- xxxxxxxxxxxx Left Area xxxxxxxxxxxx -->
    <!-- xxxxxx Content xxxxxx -->
    <div class="content">
	<?php if ($this->_tpl_vars['IS_RECORD']): ?>
    <ul class="publication_list">
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
    	<li>
        <h4><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vName']; ?>
</h4>
		<span class="green_txt"><?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iMonth']; ?>
</span><br/>
        <a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
product/index.php?action=addpub&id=<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
&m_id=<?php echo $_GET['m_id']; ?>
"><!-- <img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/cover_image.jpg" alt="" /> --><img src="<?php echo $this->_tpl_vars['SITE_URL'];  if ($this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vFile'] == ''): ?>graphics/main/thumb_preview.png<?php else: ?>product/publication/<?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['vFile'];  endif; ?>" alt="" /></a>
        <div class="clear"></div>
        <input type="button" class="left" value="<?php if ($this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iPublished']): ?>Dejar de publicar<?php else: ?>Publicar en app<?php endif; ?>" name="" onclick="publish_publication('<?php echo $_GET['m_id']; ?>
', <?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
, <?php if ($this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iPublished']): ?>0<?php else: ?>1<?php endif; ?>)">
		<input class="delete_icon" name="" onclick="delete_publication('<?php echo $_GET['m_id']; ?>
', <?php echo $this->_tpl_vars['ARR_DATA'][$this->_sections['i']['index']]['iId']; ?>
)" type="image" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
graphics/main/delete_icon.png" />
        </li>
	<?php endfor; endif; ?>
    </ul>
	<?php else: ?>
	No record.
	<?php endif; ?>
    <div class="clear"></div>
    </div>
    


<script src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
script/main/jquery.easing-1.3.min.js"></script>
<script src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
script/main/jquery.jcarousel.min.js"></script>
<script>
<?php echo '
(function() {

		var $carousel = $(\'.publication_list\');

		if( $carousel.length ) {

			var scrollCount;

				scrollCount = 3;

			$carousel.jcarousel({
				animation : 600,
				easing    : \'easeOutCubic\',
				scroll    : scrollCount
			});

			// Detect swipe gestures support
			if( Modernizr.touch ) {
				
				function swipeFunc( e, dir ) {
				
					var $carousel = $(e.currentTarget);
					
					if( dir === \'left\' ) {
						$carousel.parent(\'.jcarousel-clip\').siblings(\'.jcarousel-next\').trigger(\'click\');
					}
					
					if( dir === \'right\' ) {
						$carousel.parent(\'.jcarousel-clip\').siblings(\'.jcarousel-prev\').trigger(\'click\');
					}
					
				}
			
				$carousel.swipe({
					swipeLeft       : swipeFunc,
					swipeRight      : swipeFunc,
					allowPageScroll : \'auto\'
				});
				
			}

		}

	})();
'; ?>

</script>