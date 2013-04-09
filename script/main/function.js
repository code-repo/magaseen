$(document).ready(function(){
	$("#main-nav .guide").hover(
  function () {
    $("#main-nav .guide .sub-nav").css("display", "block");
  },
  function () {
    $("#main-nav .guide .sub-nav").css("display", "none");
  }
);
$("#main-nav .about").hover(
  function () {
    $("#main-nav .about .sub-nav").css("display", "block");
  },
  function () {
    $("#main-nav .about .sub-nav").css("display", "none");
  }
);
$('#iCountryId').change(setStates);
$('#submit_button').click(validate_magazine); 

$('.delete_hotspot_button').click(delete_hotspot); 

$('#photo_submit_button').click(validate_photo); 
$('#photo_cancel_button').click(close_fancybox); 

$('#link_submit_button').click(validate_link); 
$('#link_cancel_button').click(close_fancybox); 

$('#pub_link_submit_button').click(validate_pub_link); 
$('#pub_link_cancel_button').click(close_fancybox); 

$('#video_submit_button').click(validate_video); 
$('#video_cancel_button').click(close_fancybox); 

$('#sponsor_submit_button').click(validate_sponsor); 
$('#sponsor_cancel_button').click(close_fancybox); 

$('#gallery_submit_button').click(validate_gallery); 
$('#gallery_cancel_button').click(close_fancybox); 

$('#view_360_submit_button').click(validate_view_360); 
$('#view_360_cancel_button').click(close_fancybox); 

$('#article_submit_button').click(validate_article); 
$('#article_cancel_button').click(close_fancybox); 

$('#cur_pub_file_id').val('');//Clear the id of selexted pub file on load
});

function associate_article(){ 
	var file_id = $('#cur_pub_file_id').val();
	var article_id = $('#iArticleId').val();
	var loader = '<img src="'+siteurl+'graphics/main/ajax-loader.gif" />';
	
	if(file_id == ''){
		$('#article_output_msg').html('Please select a page to associate with this article.');
		$("#iArticleId option").each(function () {
			if ($(this).val() == '0')
				$(this).attr('selected', 'selected');
		});
		return false;
	}
	
	$('#article_output_msg').html(loader);
	$.ajax({
		url: siteurl+"product/index.php?action=associatearticle&file_id="+file_id+"&article_id="+article_id,
		context: document.body,
		success: function(data){
			$('#article_output_msg').html('Article has been associated with the current page.');
			var drp = document.getElementById("iArticleId");
			var selText = document.getElementById("iArticleId").options[drp.selectedIndex].text;
			
			$('#file_'+file_id+' span').remove();

			$('#file_'+file_id).append('<span class="article_title">'+selText+'</span>');
			$("#iArticleId option").each(function () {
				if ($(this).val() == '0')
					$(this).attr('selected', 'selected');
			});			
		}
	});
	
}
function close_fancybox(){ $.fancybox.close();}

/* function setPrice(){
		colorPrice = $('#vColor').val().split(':');		
		lengthPrice = $('#vLength').val().split(':');	
		price = (parseInt(colorPrice[1]) + parseInt(lengthPrice[1])) * parseInt($('#iQty').val());
		$('#productprice').html(price.toFixed(2));
	} */
	
function setStates(){
		$.ajax({
		  url: siteurl+"user/index.php?action=getstates&stateid=0&ajax=1&countryid="+$('#iCountryId').val(),
		  context: document.body,
		  success: function(data){
			$('#states').html(data);
		  }
		});
	}
function show_magazine_popup(id, name){
	//$('#app_id').val(id);
	$('#app_name').html(name);
	$('#sign_up').lightbox_me({
		centered: true, 
		onLoad: function() { 
			$('#sign_up').find('input:first').focus()
			}
	});
    // e.preventDefault();
}
/*
function sendForm() {


	var oOutput = document.getElementById("output");
	var oData = new FormData(document.forms.namedItem("fileinfo"));
	oData.append("CustomField", "This is some extra data");
	alert('here');
	var oReq = new XMLHttpRequest();
	oReq.open("POST", siteurl+"product/index.php?action=addmagazine", true);
	oReq.onload = function(oEvent) {
		if (oReq.status == 200) {
			oOutput.innerHTML = "Uploaded!";
		} else {
			oOutput.innerHTML = "Error " + oReq.status + " occurred uploading your file.<br \/>";
		}
	};
	oReq.send(oData);
}*/

function validate_magazine()
{
	var errMsg = '';
	if ($('#vName').val() == ""){
		errMsg += '<br />Please enter the magazine name.';
	}
	if ($('#vDescription').val() == ""){
		errMsg += '<br />Please enter the magazine description.';
	}
	var ext = $('#photoimg').val().split('.').pop().toLowerCase();
	if($('#id').val() == ''  && $.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		errMsg += '<br />Please select a valid image.';
	}
	$('#output').html(errMsg);
	if(errMsg == ''){
		$('#photoimg').attr('disabled', 'disabled');
		document.fileinfo.submit();
	}
	else{
		return false;
	}
}

function validate_photo()
{
	var errMsg = '';
	if ($('#photo_name').val() == ""){
		errMsg += '<br />Please enter the name.';
	}
	if ($('#photo_desc').val() == ""){
		errMsg += '<br />Please enter the desc.';
	}
	if($('#photo_id').val() == "" && !validate_photo_file($('#photo_file').val())) {
		errMsg += '<br />Please select a valid image.';
	}
	$('#photo_output').html(errMsg);
	if(errMsg == ''){
		$('#photo_file').attr('disabled', 'disabled');
		var frm_data = $('#photo_form').serialize();
		frm_data += '&type=photo&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/*For video popup*/
function validate_video()
{
	var errMsg = '';
	/* if ($('#video_link').val() == ""){
		errMsg += '<br />Please enter the Youtube link.';
	} */
	if ($('#video_name').val() == ""){
		errMsg += '<br />Please enter the name.';
	}
	if ($('#video_desc').val() == ""){
		errMsg += '<br />Please enter the desc.';
	}
	if($('#video_id').val() == "" && !validate_video_file($('#video_file').val())) {
		errMsg += '<br />Please select a valid video file.';
	}
	$('#video_output').html(errMsg);
	if(errMsg == ''){
		$('#video_file').attr('disabled', 'disabled');
		var frm_data = $('#video_form').serialize();
		frm_data += '&type=video&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/* For sponsor popup*/
function validate_sponsor()
{
	var errMsg = '';
	if ($('#sponsor_name').val() == ""){
		errMsg += '<br />Please enter the name.';
	}
	if ($('#sponsor_link').val() == ""){
		errMsg += '<br />Please enter the link.';
	}
	if($('#sponsor_id').val() == "" && !validate_photo_file($('#sponsor_file').val())) {
		errMsg += '<br />Please select a valid image.';
	}
	$('#sponsor_output').html(errMsg);
	if(errMsg == ''){
		$('#sponsor_file').attr('disabled', 'disabled');
		var frm_data = $('#sponsor_form').serialize();
		frm_data += '&type=sponsor&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/*For gallery popup*/
function validate_gallery()
{
	var errMsg = '';
	if ($('#gallery_name').val() == ""){
		errMsg += '<br />Please enter the name.';
	}
	if ($('#gallery_desc').val() == ""){
		errMsg += '<br />Please enter the description.';
	}
	/* if($('#gallery_id').val() == "" && !validate_photo_file($('#sponsor_file').val())) {
		errMsg += '<br />Please select a valid image.';
	} */
	$('#gallery_output').html(errMsg);
	if(errMsg == ''){
		$('#galler_file').attr('disabled', 'disabled');
		var frm_data = $('#gallery_form').serialize();
		frm_data += '&type=gallery&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/*For gallery popup*/
function validate_view_360()
{
	var errMsg = '';
	if ($('#view_360_name').val() == ""){
		errMsg += '<br />Please enter the name.';
	}
	if ($('#view_360_desc').val() == ""){
		errMsg += '<br />Please enter the description.';
	}
	/* if($('#view_360_id').val() == "" && !validate_photo_file($('#sponsor_file').val())) {
		errMsg += '<br />Please select a valid image.';
	} */
	$('#view_360_output').html(errMsg);
	if(errMsg == ''){
		$('#galler_file').attr('disabled', 'disabled');
		var frm_data = $('#view_360_form').serialize();
		frm_data += '&type=view_360&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/* For link popup*/
function validate_link()
{
	var errMsg = '';
	if ($('#link_url').val() == ""){
		errMsg += '<br />Please enter the link.';
	}
	
	$('#link_output').html(errMsg);
	if(errMsg == ''){
		var frm_data = $('#link_form').serialize();
		frm_data += '&type=link&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/* For pub link popup*/
function validate_pub_link()
{
	var errMsg = '';
	if ($('#iPubFileId').val() == ""){
		errMsg += '<br />Please select publication page for link.';
	}
	
	$('#pub_link_output').html(errMsg);
	if(errMsg == ''){
		var frm_data = $('#pub_link_form').serialize();
		frm_data += '&type=pub_link&hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=addhotspotdata",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
			}
		});
	}
	else{
		return false;
	}
}

/* For link popup*/
function validate_article()
{
	var errMsg = '';
	if ($('#article_title').val() == ""){
		errMsg += '<br />Please enter the title.';
	}
	
	$('#article_output').html(errMsg);
	if(errMsg == ''){
		var frm_data = $('#article_form').serialize();
		frm_data += '&pub_id='+$('#pub_id').val();
		// alert(frm_data);
		$.ajax({
			url: siteurl+"product/index.php?action=addarticle",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				load_artilces();
				close_fancybox();				
			}
		});
	}
	else{
		return false;
	}
}

function save_pub_basic_info(m_id, r){
	var err = '';
	if($('#vName').val() == ''){
		err += 'Please enter the name.<br />';
	}
	if($('#iMonth').val() == '0'){
		err += 'Please select the month.<br />';
	}
	if($('#vDescription').val() == ''){
		err += 'Please enter the description.<br />';
	}
	if($('#dActivationDate').val() == '' || $('#dActivationDate').val() == 'dd/mm/yyyy'){
		err += 'Please select the activation date.<br />';
	}
	$('#pub_err').html(err);
	
	if(err == '')
	{
		var frm_data = $('#basic_info').serialize();
		$.ajax({
			url: siteurl+"product/index.php?action=addpub",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(data){
				$('#pub_id').val(data);
				$('#file_pub_id').val(data);
				if(r==1){
					location.href=siteurl+'product/index.php?action=publist&m_id='+m_id
				}
			}
		});
		return true;
	}else{
		return false;
	}
}

function delete_hotspot()
{
	if(confirm('Do you really want to delete this hotspot?')){
		var frm_data = 'hotspot_id='+$('#current_hotspot_id').val();
		$.ajax({
			url: siteurl+"product/index.php?action=deletehotspot",
			data: frm_data,
			type: "POST",
			context: document.body,
			success: function(responseText){
				close_fancybox();
				$("#"+responseText).css("display", "none");
			}
		});
	}
	else{
		return false;
	}
}

function reset_all_popup(){
	file_src = siteurl+'graphics/main/thumb_preview.png';
	$('#gallery_name').val('');				
	$('#gallery_desc').val('');
	$('#gallery_file').removeAttr('disabled');
	$('#gallery_file').val('');
	$('#pikame').html('');
	
	$('#view_360_name').val('');				
	$('#view_360_desc').val('');
	$('#view_360_file').removeAttr('disabled');
	$('#view_360_file').val('');
	$('#view_360_icon').html('');
	
	$('#photo_id').val('');
	$('#photo_name').val('');				
	$('#photo_desc').val('');
	$('#photo_preview').attr('src', file_src);
	$('#photo_file').removeAttr('disabled');
	$('#photo_file').val('');
	$('#photo_output').html('');
	
	$('#video_id').val('');
	$('#video_name').val('');				
	$('#video_desc').val('');
	$('#video_link').val('');
	$('#video_preview').attr('src', file_src);
	$('#video_file').removeAttr('disabled');
	$('#video_file').val('');
	$('#video_output').html('');
	
	$('#sponsor_id').val('');
	$('#sponsor_name').val('');				
	$('#sponsor_link').val('');
	$('#sponsor_preview').attr('src', file_src);
	$('#sponsor_file').removeAttr('disabled');
	$('#sponsor_file').val('');
	$('#sponsor_output').html('');

	$('#link_url').val('');
	$('#link_output').html('');
	
	$("#iPubFileId option").each(function () {
		if ($(this).val() == '')
			$(this).attr('selected', 'selected');
	});
	$('#pub_link_output').html('');
	
	$("#article_title").val('');
}

function close_popup(){
	$('#sign_up').lightbox_me();
	$('#sign_up').trigger('close');
}

function validate_photo_file(photo, msg_id){
	var ext = photo.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		if(msg_id){
			$('#'+msg_id).html("Please select a valid image.('gif','png','jpg','jpeg')");
		}
		return false;
	}
	else{
		if(msg_id){
			$('#'+msg_id).html("");
		}
		return true;
	}
}

function validate_photopdf_file(photo, msg_id){
	var ext = photo.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg', 'pdf', 'zip']) == -1) {
		if(msg_id){
			$('#'+msg_id).html("Please select a valid image.('gif','png','jpg','jpeg', 'pdf', 'zip')");
		}
		return false;
	}
	else{
		if(msg_id){
			$('#'+msg_id).html("");
		}
		return true;
	}
}

function validate_video_file(video, msg_id){
	var ext = video.split('.').pop().toLowerCase();
	if($.inArray(ext, ['wmv','flv','3gp','avi', 'mp4']) == -1) {
		if(msg_id){
			$('#'+msg_id).html("Please select a valid video file.('wmv','flv','3gp','avi', 'mp4')");
		}
		return false;
	}
	else{
		if(msg_id){
			$('#'+msg_id).html("");
		}
		return true;
	}
}

function delete_publication(m_id, id)
{
	if(confirm('Do you really want to delete this record?')){
		location.href = siteurl+'product/index.php?action=deletepub&id='+id+'&m_id='+m_id;
	}
}

function publish_publication(m_id, id, pub)
{
	if(pub){
		msg = 'publish';
	}
	else{
		msg = 'un-publish';
	}
	if(confirm('Do you really want to '+msg+' this record?')){
		location.href = siteurl+'product/index.php?action=publishpub&id='+id+'&m_id='+m_id+'&pub='+pub;
	}
}

/*
function create_gallery(){
	$("#pikame").PikaChoose();
	 $("#pikame").jcarousel({scroll:4,					
		initCallback: function(carousel) 
		{
			$(carousel.list).find('img').click(function() {
				carousel.scroll(parseInt($(this).parents('.jcarousel-item').attr('jcarouselindex')));
			});
		}
	}); 
}
*/
function recreate_dragable(objName, parent_id, element_type, div_id)
{
	$(objName+' a').attr('rel', 'example_group');
	createPopupLink();
	$(objName).draggable({
		containment	: "#frame",
		/*grid		: [10,10],*/
		stop		: function(ev, ui)
		{
			var position		= $(ui.helper).position();
			//var offset		= $(ui.helper).offset();
			/*======================================================*/
			// try to get the xy position when moved
			var xPos_		= position.left;
			var yPos_		= position.top;
			
			// assign a z-index value
			zindex = xPos_ + yPos_;
			$(ui.helper).css({"z-index":zindex});
			
			//obtain the element id is dragging
			var elem_id = $(ui.helper).attr("id");
			
			// Send via ajax XY position of the cloned element
			frm_data = "x="+xPos_+"&y="+yPos_+"&pub_file_id="+parent_id+"&element_type="+element_type+"&div_id="+div_id;
			
			addHotspot(frm_data, div_id);
			
		}
	});
}

function bind_dragstop_event(div_id ,data)
{   
	//When a hotspot is clicked
	$('#'+div_id).bind("dragstop", function() {
		$('#current_hotspot_id').val(data);
		$.ajax({
		url: siteurl+"product/index.php?action=gethotspotdata",
			data: 'id='+data,
			cache: false,
			type: "POST",
			context: document.body,
			success: function(responseText){
				var hotObj = jQuery.parseJSON(responseText);
				if(typeof hotObj[0] != "undefined" && hotObj[0] != null)
				{
					//alert(hotObj[0].eType);
					if(hotObj[0].eType == 'photo'){
						file_src = siteurl+'product/hotspot/thumb/'+hotObj[0].vFile;
						$('#photo_id').val(hotObj[0].iId);
						$('#photo_name').val(hotObj[0].vName);
						$('#photo_file_name').val(hotObj[0].vFile);
						$('#photo_desc').val(hotObj[0].vDesc);
						$('#photo_preview').attr('src', file_src);
					}
					else if(hotObj[0].eType == 'sponsor'){
						file_src = siteurl+'product/hotspot/thumb/'+hotObj[0].vFile;
						$('#sponsor_id').val(hotObj[0].iId);
						$('#sponsor_name').val(hotObj[0].vName);
						$('#sponsor_file_name').val(hotObj[0].vFile);
						$('#sponsor_link').val(hotObj[0].vLink);
						$('#sponsor_preview').attr('src', file_src);
					}
					else if(hotObj[0].eType == 'video'){
						file_src = siteurl+'product/hotspot/'+hotObj[0].vFile;
						$('#video_id').val(hotObj[0].iId);
						$('#video_link').val(hotObj[0].vLink);
						$('#video_name').val(hotObj[0].vName);
						$('#video_file_name').val(hotObj[0].vFile);
						$('#video_desc').val(hotObj[0].vDesc);
						
						var ext = hotObj[0].vFile.split('.').pop();
						video = '<video width="290" height="200" controls id="">';
						video += '<source src="'+file_src+'" type="video/'+ext+'">';
						video += 'Your browser does not support the video tag.';
						video += '</video>';
						$('#video_file_preview').html(video);
						//alert('here');
					}
					else if(hotObj[0].eType == 'link'){
						$('#link_id').val(hotObj[0].iId);
						$('#link_url').val(hotObj[0].vLink);
					}
					else if(hotObj[0].eType == 'pub_link'){
					//alert(hotObj[0].iId);
						$('#pub_link_id').val(hotObj[0].iId);
						$("#iPubFileId option").each(function () {
							if ($(this).val() == hotObj[0].vLink)
								$(this).attr('selected', 'selected');
						});
					}
					else if(hotObj[0].eType == 'gallery'){
						//console.log(hotObj);
						for(i=0; i<hotObj.length; i++){
							li = '<li><img class="gall_image" src="'+siteurl+'product/hotspot/'+hotObj[i].vFile+'"/></li>';
							$('#pikame').append(li);
						}
						$('#gall_main_img').attr('src', siteurl+'product/hotspot/'+hotObj[0].vFile);
						$('.gall_image').click(function() {
							$('#gall_main_img').attr('src', this.src);
						});
						//create_gallery();
						$('#gallery_name').val(hotObj[0].vName);
						$('#gallery_desc').val(hotObj[0].vDesc);
					}
					else if(hotObj[0].eType == 'view_360'){
						//console.log(hotObj);
						for(i=0; i<hotObj.length; i++){
							li = '<li><img class="view_360" src="'+siteurl+'product/hotspot/'+hotObj[i].vFile+'"/></li>';
							$('#view_360_icon').append(li);
						}
						$('#view_360_main_img').attr('src', siteurl+'product/hotspot/'+hotObj[0].vFile);
						$('.view_360').click(function() {
							$('#view_360_main_img').attr('src', this.src);
						});
						//create_gallery();
						$('#view_360_name').val(hotObj[0].vName);
						$('#view_360_desc').val(hotObj[0].vDesc);
					}
				}
				else{
					$('#photo_id').val('');
					$('#sponsor_id').val('');
					$('#video_id').val('');
					$('#link_id').val('');
					$('#pub_link_id').val('');
					$('#gall_main_img').attr('src', siteurl+'graphics/main/thumb_preview.png');
					$('#view_360_main_img').attr('src', siteurl+'graphics/main/thumb_preview.png');
				}
			}
		});
	});
}

function bind_click_event(div_id ,data)
{
	//When a hotspot is clicked
	$('#'+div_id).bind("click", function() {
		$('#current_hotspot_id').val(data);
		$.ajax({
			url: siteurl+"product/index.php?action=gethotspotdata",
			data: 'id='+data,
			cache: false,
			type: "POST",
			context: document.body,
			success: function(responseText){
				var hotObj = jQuery.parseJSON(responseText);
				if(typeof hotObj[0] != "undefined" && hotObj[0] != null)
				{
					//alert(hotObj[0].eType);
					if(hotObj[0].eType == 'photo'){
						file_src = siteurl+'product/hotspot/thumb/'+hotObj[0].vFile;
						$('#photo_id').val(hotObj[0].iId);
						$('#photo_name').val(hotObj[0].vName);
						$('#photo_file_name').val(hotObj[0].vFile);
						$('#photo_desc').val(hotObj[0].vDesc);
						$('#photo_preview').attr('src', file_src);
					}
					else if(hotObj[0].eType == 'sponsor'){
						file_src = siteurl+'product/hotspot/thumb/'+hotObj[0].vFile;
						$('#sponsor_id').val(hotObj[0].iId);
						$('#sponsor_name').val(hotObj[0].vName);
						$('#sponsor_file_name').val(hotObj[0].vFile);
						$('#sponsor_link').val(hotObj[0].vLink);
						$('#sponsor_preview').attr('src', file_src);
					}
					else if(hotObj[0].eType == 'video'){
						file_src = siteurl+'product/hotspot/'+hotObj[0].vFile;
						$('#video_id').val(hotObj[0].iId);
						$('#video_link').val(hotObj[0].vLink);
						$('#video_name').val(hotObj[0].vName);
						$('#video_file_name').val(hotObj[0].vFile);
						$('#video_desc').val(hotObj[0].vDesc);
						
						var ext = hotObj[0].vFile.split('.').pop();
						video = '<video width="290" height="200" controls id="">';
						video += '<source src="'+file_src+'" type="video/'+ext+'">';
						video += 'Your browser does not support the video tag.';
						video += '</video>';
						$('#video_file_preview').html(video);
						//alert('here');
					}
					else if(hotObj[0].eType == 'link'){
						$('#link_id').val(hotObj[0].iId);
						$('#link_url').val(hotObj[0].vLink);
					}
					else if(hotObj[0].eType == 'pub_link'){
					//alert(hotObj[0].iId);
						$('#pub_link_id').val(hotObj[0].iId);
						$("#iPubFileId option").each(function () {
							if ($(this).val() == hotObj[0].vLink)
								$(this).attr('selected', 'selected');
						});
					}
					else if(hotObj[0].eType == 'gallery'){
						//console.log(hotObj);
						for(i=0; i<hotObj.length; i++){
							li = '<li><img class="gall_image" src="'+siteurl+'product/hotspot/'+hotObj[i].vFile+'"/></li>';
							$('#pikame').append(li);
						}
						$('#gall_main_img').attr('src', siteurl+'product/hotspot/'+hotObj[0].vFile);
						$('.gall_image').click(function() {
							$('#gall_main_img').attr('src', this.src);
						});
						//create_gallery();
						$('#gallery_name').val(hotObj[0].vName);
						$('#gallery_desc').val(hotObj[0].vDesc);
					}
					else if(hotObj[0].eType == 'view_360'){
						//console.log(hotObj);
						for(i=0; i<hotObj.length; i++){
							li = '<li><img class="view_360" src="'+siteurl+'product/hotspot/'+hotObj[i].vFile+'"/></li>';
							$('#view_360_icon').append(li);
						}
						$('#view_360_main_img').attr('src', siteurl+'product/hotspot/'+hotObj[0].vFile);
						$('.view_360').click(function() {
							$('#view_360_main_img').attr('src', this.src);
						});
						//create_gallery();
						$('#view_360_name').val(hotObj[0].vName);
						$('#view_360_desc').val(hotObj[0].vDesc);
					}
				}
				else{
					$('#photo_id').val('');
					$('#sponsor_id').val('');
					$('#video_id').val('');
					$('#link_id').val('');
					$('#pub_link_id').val('');
					$('#gall_main_img').attr('src', siteurl+'graphics/main/thumb_preview.png');
					$('#view_360_main_img').attr('src', siteurl+'graphics/main/thumb_preview.png');
				}
			}
		});
	});
}

function set_id(div_id)
{
	alert(div_id);
}

function addHotspot(frm_data, div_id){
	$.ajax({
		url: siteurl+"product/index.php?action=addhotspot",
		data: frm_data,
		type: "GET",
		context: document.body,
		success: function(data){
			var id = div_id+'_id'
			var hfield = document.getElementById(id);
			if(typeof hfield  == "undeifned" || hfield == null){
				hidden_field = '<input type="hidden" id="'+id+'" value="'+data+'" />';
				$('#hidden_fields').append(hidden_field);
			}
		}
	});
	//$('#'+div_id).click(set_id(div_id));
	
}

function getFile(){
        document.getElementById("pub_file").click();
    }
function createPopupLink(){
        $("a[rel=example_group]").fancybox({
			     'opacity'		    : true,
				'cyclic'	   	 	: true,
				'overlayShow'	    : true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'showNavArrows' 	: false,
				'onClosed' 			: function() { reset_all_popup() },
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
    }

function create_dropable(id)
{
	//Make element droppable
	$(".sub_frame").droppable({
		accept	: '.drag', 
		live: true,
		drop	: function(ev, ui) 
		{
			//if (ui.draggable.attr('id').search(/drag[0-9]+/) != -1)
			{
				counter++;
				var element = $(ui.draggable).clone();
				element.addClass("tempclass");
				$(this).append(element);
				new_id = "clonediv"+counter;
				$(".tempclass").attr("id", new_id);
				$(".tempclass").css({"position":"absolute"});
				$("#clonediv"+counter).removeClass("tempclass");			
				//Get the dynamically item id
				draggedNumber	= ui.draggable.attr('id').search(/drag([0-9]+)/);
				itemDragged		= "dragged" + RegExp.$1;
				//console.log(itemDragged)
				$("#clonediv"+counter).addClass(itemDragged);
			}
		}
	});
}
function set_image(id)
{
	$('.sub_frame').hide();
	$('#frame_'+id).show();
	$('#cur_pub_file_id').val(id.split('_').pop());
}

function load_publications(){
	var seloptions = '<select name="iPubFileId" id="iPubFileId">'; 
	seloptions += '<option value="">--Select--</option>'; 
	$.ajax({
		url: siteurl+"product/index.php?action=getpubfiles&pub_id="+$('#pub_id').val(),
		context: document.body,
		success: function(data){
			seloptions += data;
			seloptions += '</select>';
			$('#link_pub').html(seloptions);
		}
	});
}

function load_artilces(){
	var seloptions = '<select name="iArticleId" id="iArticleId" onchange="associate_article()">'; 
	seloptions += '<option value="0">--Select Article--</option>'; 
	$.ajax({
		url: siteurl+"product/index.php?action=getarticles"+'&pub_id='+$('#pub_id').val(),
		context: document.body,
		success: function(data){
			seloptions += data;
			seloptions += '</select>';
			$('#link_article').html(seloptions);
		}
	});
}