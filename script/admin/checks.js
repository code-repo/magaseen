$(document).ready(function(){
	$('#iCountryId').change(setStates);
});

function _$(id)
{
	return document.getElementById(id);
}

function validateLogin()
{		
	if(trim(document.frmLoginLeft.txtUserId.value).length==0)
	{
		alert("Please enter username.");
		document.frmLoginLeft.txtUserId.focus();
		return false;
	}

	if(trim(document.frmLoginLeft.txtPassword.value).length==0)
	{
		alert("Please enter password.");
		document.frmLoginLeft.txtPassword.focus();
		return false;
	}
	return true;
}

/* Function to validate the login form in main window */
function validateLoginInner()
{		
	if(trim(document.frmLoginMain.txtUserId.value).length==0)
	{
		alert("Please enter username.");
		document.frmLoginMain.txtUserId.focus();
		return false;
	}

	if(trim(document.frmLoginMain.txtPassword.value).length==0)
	{
		alert("Please enter password.");
		document.frmLoginMain.txtPassword.focus();
		return false;
	}
	return true;
}

/* Function to check the change password window */
function verifyChangePassword()
{
	if(trim(document.frmChangePassword.txtOldPassword.value).length==0)
	{
		alert("Please enter the old password.");
		document.frmChangePassword.txtOldPassword.focus();
		return false;
	}

	if(trim(document.frmChangePassword.txtNewPassword.value).length==0)
	{
		alert("Please enter the new password.");
		document.frmChangePassword.txtNewPassword.focus();
		return false;
	}

	if(trim(document.frmChangePassword.txtConfirmPassword.value).length==0)
	{
		alert("Please confirm the new password.");
		document.frmChangePassword.txtConfirmPassword.focus();
		return false;
	}

	if(trim(document.frmChangePassword.txtNewPassword.value)!=trim(document.frmChangePassword.txtConfirmPassword.value))
	{
		alert("Your new password should match with Confirm password.");
		document.frmChangePassword.txtConfirmPassword.focus();
		return false;
	}

	return true;
}


/* Function to check the change password window */
function verifyForgotPassword()
{
	if(trim(document.frmForgotPassword.txtEmail.value).length==0)
	{
		alert("Please enter the Email Address.");
		document.frmForgotPassword.txtEmail.focus();
		return false;
	}

	if(!	isEmail(trim(document.frmForgotPassword.txtEmail.value)))
	{
		alert("Please enter valid Email Address.");
		document.frmForgotPassword.txtEmail.focus();
		return false;
	}

	return true;
}

function setInputType(id)
{
	if(id == 2){
		_$('link').style.display = 'block';
		_$('object').style.display = 'none';
	}
	else{
		_$('link').style.display = 'none';
		_$('object').style.display = 'block';
	}
}

function getClientProducts(id, content_ids){	
		$.ajax({
		  url: siteurl+"product/adminindex.php?action=getproducts&ajax=1&clientid="+id+"&content_ids="+content_ids,
		  success: function(data){
			if(data != ""){
				$('#products').html(data);
				_$('client_products').style.display = 'block';
			}
			else{
				_$('client_products').style.display = 'none';
			}
			
		  }
		});
		return false;
	}
function setStates(){
		$.ajax({
		  url: siteurl+"user/adminindex.php?action=getstates&stateid=0&ajax=1&countryid="+$('#iCountryId').val(),
		  context: document.body,
		  success: function(data){
			$('#states').html(data);
		  }
		});
	}
function showCampaigns(id){	
	// $('#campaign_'+id).css("display","block");
	if($('#client_'+id).html() == '-'){
		$('#client_'+id).html('+');
		$('#campaign_'+id).html('');
		return false;
	}else{
		$('#client_'+id).html('-');
	}
	$('#campaign_'+id).html("<img src=\""+siteurl+"graphics/admin/ajax-loader.gif\" />");
	$.ajax({
	  url: siteurl+"product/adminindex.php?action=getcampaigns&ajax=1&clientid="+id,
	  success: function(data){
		$('#campaign_'+id).html(data);
	  }
	});	
	return false;
}

function showContents(id){	
	if($('#campaign_expand_'+id).html() == '-'){
		$('#campaign_expand_'+id).html('+');
		$('#content_'+id).html('');
		return false;
	}else{
		$('#campaign_expand_'+id).html('-');
	}
	$('#content_'+id).html("<img src=\""+siteurl+"graphics/admin/ajax-loader.gif\" />");
	$.ajax({
	  url: siteurl+"product/adminindex.php?action=getcontents&ajax=1&campaignid="+id,
	  success: function(data){
		$('#content_'+id).html(data);
	  }
	});	
	return false;
}

function showARItems(id){	
	if($('#content_expand_'+id).html() == '-'){
		$('#content_expand_'+id).html('+');
		$('#aritem_'+id).html('');
		return false;
	}else{
		$('#content_expand_'+id).html('-');
	}
	$('#aritem_'+id).html("<img src=\""+siteurl+"graphics/admin/ajax-loader.gif\" />");
	$.ajax({
	  url: siteurl+"product/adminindex.php?action=getaritems&ajax=1&contentid="+id,
	  success: function(data){
		$('#aritem_'+id).html(data);
	  }
	});	
	return false;
}

function setCampaign(clientid){
	$.ajax({
			url: siteurl+"product/adminindex.php?action=getcampaignsdropdown&clientid="+clientid+"&campaignid="+$('#camp_id').val(),
			success: function(data){
			$('#campaign').html(data);
		}
	});
}

function hideRows(row_class, plus_class){
	var row = document.getElementsByClassName(row_class);
	Array.filter( row, function(elem){
	  elem.innerHTML = '';
	});
	
	var plus = document.getElementsByClassName(plus_class);
	Array.filter( plus, function(elem){
	  elem.innerHTML = '+';
	});
	// $("."+row_class).css("display","none");
}