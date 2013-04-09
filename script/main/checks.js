/* Function to validate the login form in left nav */
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


/* Function to check the perosnal details form */
function verifyPersonalDetails()
{
	if(trim(document.frmPersonalProfile.txtFirstName.value).length==0)
	{
		alert("Please enter the First name.");
		document.frmPersonalProfile.txtFirstName.focus();
		return false;
	}

	if(trim(document.frmPersonalProfile.txtLastName.value).length==0)
	{
		alert("Please enter the Last name.");
		document.frmPersonalProfile.txtLastName.focus();
		return false;
	}
	/*if(trim(document.frmPersonalProfile.txtBuilding.value).length==0)
	{
		alert("Please enter Building/House name.");
		document.frmPersonalProfile.txtBuilding.focus();
		return false;
	}*/
	if(trim(document.frmPersonalProfile.txtStreet.value).length==0)
	{
		alert("Please enter the Number & street.");
		document.frmPersonalProfile.txtStreet.focus();
		return false;
	}
	/*if(trim(document.frmPersonalProfile.txtAreaTown.value).length==0)
	{
		alert("Please enter the Area/town.");
		document.frmPersonalProfile.txtAreaTown.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.txtCityCounty.value).length==0)
	{
		alert("Please enter the City/County.");
		document.frmPersonalProfile.txtCityCounty.focus();
		return false;
	}*/
	if(trim(document.frmPersonalProfile.txtPostCode.value).length==0)
	{
		alert("Please enter the Postcode.");
		document.frmPersonalProfile.txtPostCode.focus();
		return false;
	}

	if(trim(document.frmPersonalProfile.txtPhone.value).length==0)
	{
		alert("Please enter the Telephone No.");
		document.frmPersonalProfile.txtPhone.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.cmbEmploymentStatus.value)=='')
	{
		alert("Please select employment status.");
		document.frmPersonalProfile.cmbEmploymentStatus.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.cmbEmploymentStatus.value) == 'Other, Please state?' && trim(document.frmPersonalProfile.txtEmploymentStatus.value) == '')
	{
		alert("Please enter employment status.");
		document.frmPersonalProfile.txtEmploymentStatus.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.cmbEmploymentStatus.value) == 'Unemployed?' && trim(document.frmPersonalProfile.txtUnEmpDate.value) == '')
	{
		alert("Please enter date of unemployment.");
		document.frmPersonalProfile.txtUnEmpDate.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.cmbEqualOpportunity.value) == '')
	{
		alert("Please select Equal Opportunity Details.");
		document.frmPersonalProfile.cmbEqualOpportunity.focus();
		return false;
	}
	if(trim(document.frmPersonalProfile.txtHear.value).length==0)
	{
		alert("Please enter How did you hear about us.");
		document.frmPersonalProfile.txtHear.focus();
		return false;
	}
	return true;
}

/* Function to check the business details form */
function verifyBusinessDetails()
{
	if(trim(document.frmBusinessProfile.cmbBusinessSector.value).length==0)
	{
		alert("Please enter the Business Sector.");
		document.frmBusinessProfile.cmbBusinessSector.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.cmbBusinessSector.value)=="46" && trim(document.frmBusinessProfile.txtBusinessSector.value).length==0)
	{
		alert("Please enter the Business Sector.");
		document.frmBusinessProfile.txtBusinessSector.focus();
		return false;
	}
	
	if(document.frmBusinessProfile.chkBusinessStatus[0].checked==true)
	{
		return true;
	}
	

	if(trim(document.frmBusinessProfile.txtCompany.value).length==0)
	{
		alert("Please enter the company name.");
		document.frmBusinessProfile.txtCompany.focus();
		return false;
	}
	if(trim(document.frmBusinessProfile.txtBusinessStart.value).length==0)
	{
		alert("Please enter the Date Business Started.");
		document.frmBusinessProfile.txtBusinessStart.focus();
		return false;
	}
	if(trim(document.frmBusinessProfile.cmbLegalStructure.value).length==0)
	{
		alert("Please select Legal Structure.");
		document.frmBusinessProfile.cmbLegalStructure.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.txtNoEmployee.value).length==0)
	{
		alert("Please enter the No. of employees.");
		document.frmBusinessProfile.txtNoEmployee.focus();
		return false;
	}

	/*if(trim(document.frmBusinessProfile.txtBuildingName.value).length==0)
	{
		alert("Please enter the Building Name.");
		document.frmBusinessProfile.txtBuildingName.focus();
		return false;
	}*/
	if(trim(document.frmBusinessProfile.txtBuildingNumber.value).length==0)
	{
		alert("Please enter the Number Street.");
		document.frmBusinessProfile.txtBuildingNumber.focus();
		return false;
	}

	/*if(trim(document.frmBusinessProfile.txtStreet.value).length==0)
	{
		alert("Please enter the Street.");
		document.frmBusinessProfile.txtStreet.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.txtTown.value).length==0)
	{
		alert("Please enter the Town.");
		document.frmBusinessProfile.txtTown.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.txtCounty.value).length==0)
	{
		alert("Please enter the County.");
		document.frmBusinessProfile.txtCounty.focus();
		return false;
	}*/

	if(trim(document.frmBusinessProfile.txtPostCode.value).length==0)
	{
		alert("Please enter the Postcode.");
		document.frmBusinessProfile.txtPostCode.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.txtPhone.value).length==0)
	{
		alert("Please enter the Telephone No.");
		document.frmBusinessProfile.txtPhone.focus();
		return false;
	}

	if(trim(document.frmBusinessProfile.txtWebsite.value).length>0 && isUrl(document.frmBusinessProfile.txtWebsite.value)==false)
	{
		alert("Please enter valid Website url.");
		document.frmBusinessProfile.txtWebsite.focus();
		return false;
	}

	return true;
}

/* Function to show the tab 2 of registration process */
function showStep1()
{
	document.getElementById('cstatus').value=1;
	document.getElementById('step1').style.display='block';
	document.getElementById('step2').style.display='none';
	document.getElementById('step3').style.display='none';
}

/* Function to show the tab 2 of registration process */
function showStep2()
{
	document.getElementById('cstatus').value=2;
	document.getElementById('step1').style.display='none';
	document.getElementById('step2').style.display='block';
	document.getElementById('step3').style.display='none';
}

/* Function to show the tab 2 of registration process */
function showStep3()
{
	document.getElementById('cstatus').value=3;
	document.getElementById('step1').style.display='none';
	document.getElementById('step2').style.display='none';
	document.getElementById('step3').style.display='block';
}


/* Function to verify registration process step1*/
function verifyStep1()
{
	if(trim(document.frmRegister.txtEmail.value).length==0)
	{
		alert("Please enter your Email Address(username).");
		document.frmRegister.txtEmail.focus();
		return false;
	}

	if(trim(document.frmRegister.txtEmail.value).length==0)
	{
		alert("Please enter the Email Address(username).");
		document.frmRegister.txtEmail.focus();
		return false;
	}

	if(!	isEmail(trim(document.frmRegister.txtEmail.value)))
	{
		alert("Please enter valid Email Address(username).");
		document.frmRegister.txtEmail.focus();
		return false;
	}

	if(trim(document.frmRegister.txtPassword.value).length==0)
	{
		alert("Please enter the Password.");
		document.frmRegister.txtPassword.focus();
		return false;
	}

	if(trim(document.frmRegister.txtCPassword.value).length==0)
	{
		alert("Please enter the Confirm Password.");
		document.frmRegister.txtCPassword.focus();
		return false;
	}

	if(trim(document.frmRegister.txtPassword.value)!=trim(document.frmRegister.txtCPassword.value))
	{
		alert("Your Password should match with Confirm password.");
		document.frmRegister.txtCPassword.focus();
		return false;
	}

	if(trim(document.frmRegister.txtFirstName.value).length==0)
	{
		alert("Please enter the First name.");
		document.frmRegister.txtFirstName.focus();
		return false;
	}

	if(trim(document.frmRegister.txtLastName.value).length==0)
	{
		alert("Please enter the Last name.");
		document.frmRegister.txtLastName.focus();
		return false;
	}

	if(trim(document.frmRegister.txtLastName.value).length==0)
	{
		alert("Please enter the Last name.");
		document.frmRegister.txtLastName.focus();
		return false;
	}

	if(document.frmRegister.optHealth[0].checked==true && trim(document.frmRegister.txtHealth.value).length==0)
	{
		alert("Please enter the Health Disability details.");
		document.frmRegister.txtHealth.focus();
		return false;
	}

	showStep2();
}


/* Function to verify registration process step2*/
function verifyStep2()
{
	if(document.frmRegister.chkBusinessStatus[0].checked==false && document.frmRegister.chkBusinessStatus[1].checked==false)
	{
		alert("Please select Business Status.");
		return false;
	}
	else
	{
	if(trim(document.frmRegister.cmbBusinessSector.value).length==0)
	{
		alert("Please enter Business sector.");
		document.frmRegister.cmbBusinessSector.focus();
		return false;
	}
	
	if(trim(document.frmRegister.cmbBusinessSector.value)=="46" && trim(document.frmRegister.txtBusinessSector.value).length==0)
	{
		alert("Please enter Business sector.");
		document.frmRegister.txtBusinessSector.focus();
		return false;
	}
	if(document.frmRegister.chkBusinessStatus[0].checked==true)
	{
		showStep3();
		return true;
	}
	}
	if(trim(document.frmRegister.cmbBusinessSector.value).length==0)
	{
		alert("Please enter Business sector.");
		document.frmRegister.cmbBusinessSector.focus();
		return false;
	}
	
	if(trim(document.frmRegister.cmbBusinessSector.value)=="46" && trim(document.frmRegister.txtBusinessSector.value).length==0)
	{
		alert("Please enter Business sector.");
		document.frmRegister.txtBusinessSector.focus();
		return false;
	}
	if(trim(document.frmRegister.txtCompany.value).length==0)
	{
		alert("Please enter Company name.");
		document.frmRegister.txtCompany.focus();
		return false;
	}
	if(trim(document.frmRegister.txtBusinessStart.value).length==0)
	{
		alert("Please enter your Business start date.");
		document.frmRegister.txtBusinessStart.focus();
		return false;
	}
	if(trim(document.frmRegister.txtBusinessStart.value).length==0)
	{
		alert("Please enter Business start date.");
		document.frmRegister.txtBusinessStart.focus();
		return false;
	}
	if(trim(document.frmRegister.cmbLegalStructure.value).length==0)
	{
		alert("Please enter Business Legal structure.");
		document.frmRegister.cmbLegalStructure.focus();
		return false;
	}
	if(trim(document.frmRegister.txtNoEmployee.value).length==0)
	{
		alert("Please enter No. of employees.");
		document.frmRegister.txtNoEmployee.focus();
		return false;
	}

	/*if(trim(document.frmRegister.txtBuildingName.value).length==0)
	{
		alert("Please enter Building Name.");
		document.frmRegister.txtBuildingName.focus();
		return false;
	}

	if(trim(document.frmRegister.txtBuildingName.value).length==0)
	{
		alert("Please enter Building Name.");
		document.frmRegister.txtBuildingName.focus();
		return false;
	}*/

	if(trim(document.frmRegister.txtBuildingNumber.value).length==0)
	{
		alert("Please enter Number Street.");
		document.frmRegister.txtBuildingNumber.focus();
		return false;
	}
	
	/*if(trim(document.frmRegister.txtBStreet.value).length==0)
	{
		alert("Please enter Street.");
		document.frmRegister.txtBStreet.focus();
		return false;
	}
	
	if(trim(document.frmRegister.txtTown.value).length==0)
	{
		alert("Please enter Town.");
		document.frmRegister.txtTown.focus();
		return false;
	}

	if(trim(document.frmRegister.txtCounty.value).length==0)
	{
		alert("Please enter County.");
		document.frmRegister.txtCounty.focus();
		return false;
	}*/

	if(trim(document.frmRegister.txtBPostCode.value).length==0)
	{
		alert("Please enter Post code.");
		document.frmRegister.txtBPostCode.focus();
		return false;
	}

	if(trim(document.frmRegister.txtBPhone.value).length==0)
	{
		alert("Please enter Telephone No.");
		document.frmRegister.txtBPhone.focus();
		return false;
	}

	if(trim(document.frmRegister.txtWebsite.value).length>0 && isUrl(document.frmRegister.txtWebsite.value)==false)
	{
		alert("Please enter valid Website url.");
		document.frmRegister.txtWebsite.focus();
		return false;
	}

	showStep3();
}

/* Verify registration process step3 */
function verifyStep3()
{
	/*if(trim(document.frmRegister.txtBuilding.value).length==0)
	{
		alert("Please enter Building/House name.");
		document.frmRegister.txtBuilding.focus();
		return false;
	}*/
	if(trim(document.frmRegister.txtStreet.value).length==0)
	{
		alert("Please enter Number & street.");
		document.frmRegister.txtStreet.focus();
		return false;
	}
	/*if(trim(document.frmRegister.txtAreaTown.value).length==0)
	{
		alert("Please enter Area/Town.");
		document.frmRegister.txtAreaTown.focus();
		return false;
	}	
	if(trim(document.frmRegister.txtCityCounty.value).length==0)
	{
		alert("Please enter City/County.");
		document.frmRegister.txtCityCounty.focus();
		return false;
	}*/	
	if(trim(document.frmRegister.txtPostCode.value).length==0)
	{
		alert("Please enter Post code.");
		document.frmRegister.txtPostCode.focus();
		return false;
	}
	if(trim(document.frmRegister.txtPhone.value).length==0)
	{
		alert("Please enter Telephone No.");
		document.frmRegister.txtPhone.focus();
		return false;
	}
	if(trim(document.frmRegister.cmbEmploymentStatus.value)=='')
	{
		alert("Please select employment status.");
		document.frmRegister.cmbEmploymentStatus.focus();
		return false;
	}
	if(trim(document.frmRegister.cmbEmploymentStatus.value) == 'Other, Please state?' && trim(document.frmRegister.txtEmploymentStatus.value) == '')
	{
		alert("Please enter employment status.");
		document.frmRegister.txtEmploymentStatus.focus();
		return false;
	}
	if(trim(document.frmRegister.cmbEmploymentStatus.value) == 'Unemployed?' && trim(document.frmRegister.txtUnEmpDate.value) == '')
	{
		alert("Please enter date of unemployment.");
		document.frmRegister.txtUnEmpDate.focus();
		return false;
	}
	if(trim(document.frmRegister.cmbEqualOpportunity.value) == '')
	{
		alert("Please select Equal Opportunity Details.");
		document.frmRegister.cmbEqualOpportunity.focus();
		return false;
	}
	if(trim(document.frmRegister.txtHear.value).length==0)
	{
		alert("Please enter How did you hear about us.");
		document.frmRegister.txtHear.focus();
		return false;
	}

	if(document.frmRegister.chkTerms.checked==false)
	{
		alert("Please accept the terms of use and data protection.");
		document.frmRegister.txtHear.focus();
		return false;
	}
	
	document.frmRegister.submit();
}

/*Advert rating form checks*/
function validateAdvertRating()
{
	if(document.form1.txtRate.value == "")
	{
		alert("Please select a rating for the advert.");		
		return false;
	}
	if(trim(document.form1.txtUserName.value).length == 0)
	{
		alert("Please enter the name.");
		document.form1.txtUserName.focus();
		return false;
	}
	if(trim(document.form1.txtUserEmail.value).length == 0)
	{
		alert("Please enter the email address.");
		document.form1.txtUserEmail.focus();
		return false;
	}
	if(!isEmail(document.form1.txtUserEmail.value))
	{
		alert("Please enter a valid email address.");
		document.form1.txtUserEmail.focus();
		return false;
	}
	if(trim(document.form1.txtComments.value).length == 0 || trim(document.form1.txtComments.value).length > 250)
	{
		alert("Please enter the comments with in 250 characters.");
		document.form1.txtComments.value = document.form1.txtComments.value.substring(0, 249);
		document.form1.txtComments.focus();
		return false;
	}	
}

function checkBusinessSector()
{
	if(trim(document.frmRegister.cmbBusinessSector.value)=='46')
	{
		document.getElementById('businesssectorcol1').style.display='block';
		document.getElementById('businesssectorcol2').style.display='block';
	}
	else
	{
		document.frmRegister.txtBusinessSector.value='';
		document.getElementById('businesssectorcol1').style.display='none';
		document.getElementById('businesssectorcol2').style.display='none';
	}
}

function checkBusinessSectorEdit()
{
	if(trim(document.frmBusinessProfile.cmbBusinessSector.value)=='46')
	{
		document.getElementById('businesssectorcol1').style.display='block';
		document.getElementById('businesssectorcol2').style.display='block';
	}
	else
	{
		document.frmBusinessProfile.txtBusinessSector.value='';
		document.getElementById('businesssectorcol1').style.display='none';
		document.getElementById('businesssectorcol2').style.display='none';
	}
}

function checkHealthStatus()
{
	if(document.frmPersonalProfile.optHealth[0].checked==true)
	{
		document.getElementById('healthcol1').style.display='block';
		document.getElementById('healthcol2').style.display='block';
	}
	else
	{
		document.frmPersonalProfile.txtHealth.value='';
		document.getElementById('healthcol1').style.display='none';
		document.getElementById('healthcol2').style.display='none';
	}
}

function checkHealthStatusReg()
{
	if(document.frmRegister.optHealth[0].checked==true)
	{
		document.getElementById('healthcol1').style.display='block';
		document.getElementById('healthcol2').style.display='block';
	}
	else
	{
		document.frmRegister.txtHealth.value='';
		document.getElementById('healthcol1').style.display='none';
		document.getElementById('healthcol2').style.display='none';
	}
}

function updateFields()
{
	if(document.frmRegister.chkBusinessStatus[0].checked==true)
	{
		document.frmRegister.txtCompany.disabled=true;
		document.frmRegister.cmbLegalStructure.disabled=true;
		//document.frmRegister.cmbBusinessSector.disabled=true;
		document.frmRegister.txtNoEmployee.disabled=true;
		document.frmRegister.txtBuildingName.disabled=true;
		document.frmRegister.txtBuildingNumber.disabled=true;
		//document.frmRegister.txtBStreet.disabled=true;
		document.frmRegister.txtTown.disabled=true;
		document.frmRegister.txtCounty.disabled=true;
		document.frmRegister.txtBPostCode.disabled=true;
		document.frmRegister.txtBPhone.disabled=true;
		document.frmRegister.txtBMobile.disabled=true;
		document.frmRegister.txtFax.disabled=true;
		document.frmRegister.txtWebsite.disabled=true;
		document.frmRegister.txtCompany.value='';
		document.frmRegister.cmbLegalStructure.value='';
		//document.frmRegister.cmbBusinessSector.value='';
		document.frmRegister.txtNoEmployee.value='';
		document.frmRegister.txtBuildingName.value='';
		document.frmRegister.txtBuildingNumber.value='';
		//document.frmRegister.txtBStreet.value='';
		document.frmRegister.txtTown.value='';
		document.frmRegister.txtCounty.value='';
		document.frmRegister.txtBPostCode.value='';
		document.frmRegister.txtBPhone.value='';
		document.frmRegister.txtBMobile.value='';
		document.frmRegister.txtFax.value='';
		document.frmRegister.txtWebsite.value='';
		document.frmRegister.txtBusinessStart.value='';
		document.frmRegister.txtBusinessStart.style.background='#dcdcdc';
		document.frmRegister.txtCompany.style.background='#dcdcdc';
		document.frmRegister.cmbLegalStructure.style.background='#dcdcdc';
		//document.frmRegister.cmbBusinessSector.style.background='#dcdcdc';
		document.frmRegister.txtNoEmployee.style.background='#dcdcdc';
		document.frmRegister.txtBuildingName.style.background='#dcdcdc';
		document.frmRegister.txtBuildingNumber.style.background='#dcdcdc';
		//document.frmRegister.txtBStreet.style.background='#dcdcdc';
		document.frmRegister.txtTown.style.background='#dcdcdc';
		document.frmRegister.txtCounty.style.background='#dcdcdc';
		document.frmRegister.txtBPostCode.style.background='#dcdcdc';
		document.frmRegister.txtBPhone.style.background='#dcdcdc';
		document.frmRegister.txtBMobile.style.background='#dcdcdc';
		document.frmRegister.txtFax.style.background='#dcdcdc';
		document.frmRegister.txtWebsite.style.background='#dcdcdc';
	}
	else
	{
		document.frmRegister.txtCompany.disabled=false;
		document.frmRegister.cmbLegalStructure.disabled=false;
		//document.frmRegister.cmbBusinessSector.disabled=false;
		document.frmRegister.txtNoEmployee.disabled=false;
		document.frmRegister.txtBuildingName.disabled=false;
		document.frmRegister.txtBuildingNumber.disabled=false;
		//document.frmRegister.txtBStreet.disabled=false;
		document.frmRegister.txtTown.disabled=false;
		document.frmRegister.txtCounty.disabled=false;
		document.frmRegister.txtBPostCode.disabled=false;
		document.frmRegister.txtBPhone.disabled=false;
		document.frmRegister.txtBMobile.disabled=false;
		document.frmRegister.txtFax.disabled=false;
		document.frmRegister.txtWebsite.disabled=false;
		document.frmRegister.txtBusinessStart.style.background='#ffffff';
		document.frmRegister.txtCompany.style.background='#ffffff';
		document.frmRegister.cmbLegalStructure.style.background='#ffffff';
		//document.frmRegister.cmbBusinessSector.style.background='#ffffff';
		document.frmRegister.txtNoEmployee.style.background='#ffffff';
		document.frmRegister.txtBuildingName.style.background='#ffffff';
		document.frmRegister.txtBuildingNumber.style.background='#ffffff';
		//document.frmRegister.txtBStreet.style.background='#ffffff';
		document.frmRegister.txtTown.style.background='#ffffff';
		document.frmRegister.txtCounty.style.background='#ffffff';
		document.frmRegister.txtBPostCode.style.background='#ffffff';
		document.frmRegister.txtBPhone.style.background='#ffffff';
		document.frmRegister.txtBMobile.style.background='#ffffff';
		document.frmRegister.txtFax.style.background='#ffffff';
		document.frmRegister.txtWebsite.style.background='#ffffff';
	}
}

function updateFieldsB()
{
	if(document.frmBusinessProfile.chkBusinessStatus[0].checked==true)
	{
		document.frmBusinessProfile.txtCompany.disabled=true;
		document.frmBusinessProfile.cmbLegalStructure.disabled=true;
		//document.frmBusinessProfile.cmbBusinessSector.disabled=true;
		document.frmBusinessProfile.txtNoEmployee.disabled=true;
		document.frmBusinessProfile.txtBuildingName.disabled=true;
		document.frmBusinessProfile.txtBuildingNumber.disabled=true;
		//document.frmBusinessProfile.txtStreet.disabled=true;
		document.frmBusinessProfile.txtTown.disabled=true;
		document.frmBusinessProfile.txtCounty.disabled=true;
		document.frmBusinessProfile.txtPostCode.disabled=true;
		document.frmBusinessProfile.txtPhone.disabled=true;
		document.frmBusinessProfile.txtMobile.disabled=true;
		document.frmBusinessProfile.txtFax.disabled=true;
		document.frmBusinessProfile.txtWebsite.disabled=true;
		document.frmBusinessProfile.txtCompany.value='';
		document.frmBusinessProfile.cmbLegalStructure.value='';
		//document.frmBusinessProfile.cmbBusinessSector.value='';
		document.frmBusinessProfile.txtNoEmployee.value='';
		document.frmBusinessProfile.txtBuildingName.value='';
		document.frmBusinessProfile.txtBuildingNumber.value='';
		//document.frmBusinessProfile.txtStreet.value='';
		document.frmBusinessProfile.txtTown.value='';
		document.frmBusinessProfile.txtCounty.value='';
		document.frmBusinessProfile.txtPostCode.value='';
		document.frmBusinessProfile.txtPhone.value='';
		document.frmBusinessProfile.txtMobile.value='';
		document.frmBusinessProfile.txtFax.value='';
		document.frmBusinessProfile.txtWebsite.value='';
		document.frmBusinessProfile.txtBusinessStart.value='';
		document.frmBusinessProfile.txtCompany.style.background='#dcdcdc';
		document.frmBusinessProfile.cmbLegalStructure.style.background='#dcdcdc';
		//document.frmBusinessProfile.cmbBusinessSector.style.background='#dcdcdc';
		document.frmBusinessProfile.txtNoEmployee.style.background='#dcdcdc';
		document.frmBusinessProfile.txtBuildingName.style.background='#dcdcdc';
		document.frmBusinessProfile.txtBuildingNumber.style.background='#dcdcdc';
		//document.frmBusinessProfile.txtStreet.style.background='#dcdcdc';
		document.frmBusinessProfile.txtTown.style.background='#dcdcdc';
		document.frmBusinessProfile.txtCounty.style.background='#dcdcdc';
		document.frmBusinessProfile.txtPostCode.style.background='#dcdcdc';
		document.frmBusinessProfile.txtPhone.style.background='#dcdcdc';
		document.frmBusinessProfile.txtMobile.style.background='#dcdcdc';
		document.frmBusinessProfile.txtFax.style.background='#dcdcdc';
		document.frmBusinessProfile.txtWebsite.style.background='#dcdcdc';
		document.frmBusinessProfile.txtBusinessStart.style.background='#dcdcdc';
	
	}
	else
	{
		document.frmBusinessProfile.txtCompany.disabled=false;
		document.frmBusinessProfile.cmbLegalStructure.disabled=false;
		//document.frmBusinessProfile.cmbBusinessSector.disabled=false;
		document.frmBusinessProfile.txtNoEmployee.disabled=false;
		document.frmBusinessProfile.txtBuildingName.disabled=false;
		document.frmBusinessProfile.txtBuildingNumber.disabled=false;
		//document.frmBusinessProfile.txtStreet.disabled=false;
		document.frmBusinessProfile.txtTown.disabled=false;
		document.frmBusinessProfile.txtCounty.disabled=false;
		document.frmBusinessProfile.txtPostCode.disabled=false;
		document.frmBusinessProfile.txtPhone.disabled=false;
		document.frmBusinessProfile.txtMobile.disabled=false;
		document.frmBusinessProfile.txtFax.disabled=false;
		document.frmBusinessProfile.txtWebsite.disabled=false;
		document.frmBusinessProfile.txtCompany.style.background='#ffffff';
		document.frmBusinessProfile.cmbLegalStructure.style.background='#ffffff';
		//document.frmBusinessProfile.cmbBusinessSector.style.background='#ffffff';
		document.frmBusinessProfile.txtNoEmployee.style.background='#ffffff';
		document.frmBusinessProfile.txtBuildingName.style.background='#ffffff';
		document.frmBusinessProfile.txtBuildingNumber.style.background='#ffffff';
		//document.frmBusinessProfile.txtStreet.style.background='#ffffff';
		document.frmBusinessProfile.txtTown.style.background='#ffffff';
		document.frmBusinessProfile.txtCounty.style.background='#ffffff';
		document.frmBusinessProfile.txtPostCode.style.background='#ffffff';
		document.frmBusinessProfile.txtPhone.style.background='#ffffff';
		document.frmBusinessProfile.txtMobile.style.background='#ffffff';
		document.frmBusinessProfile.txtFax.style.background='#ffffff';
		document.frmBusinessProfile.txtWebsite.style.background='#ffffff';
		document.frmBusinessProfile.txtBusinessStart.style.background='#ffffff';
	}
}


function checkEnter(e)
{ //e is event object passed from function invocation
	var characterCode;// literal character code will be stored in this variable
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e;
		characterCode = e.which; //character code is contained in NN4's which property
	}
	else
	{
		e = e;
		characterCode = e.keyCode; //character code is contained in IE's keyCode property
	}

	if(characterCode == 13)
	{ //if generated character code is equal to ascii 13 (if enter key)
	 //submit the form
	 	if(document.getElementById('cstatus').value==1)
		{
			verifyStep1();
		}
		else if(document.getElementById('cstatus').value==2)
		{
			verifyStep2();
		}
		else if(document.getElementById('cstatus').value==3)
		{
			verifyStep3();
		}
	}
}

function copyfields(frm)
{	
	if(frm.ship_add.checked)
	{
		frm.txtBuilding.value = frm.txtBuildingName.value;
		frm.txtStreet.value = frm.txtBuildingNumber.value;
		frm.txtAreaTown.value = frm.txtTown.value;
		frm.txtCityCounty.value = frm.txtCounty.value;
		frm.txtPostCode.value = frm.txtBPostCode.value;
		frm.txtPhone.value = frm.txtBPhone.value;			
		frm.txtMobile.value = frm.txtBMobile.value;
	}
	else
	{
		frm.txtBuilding.value = '';
		frm.txtStreet.value = '';
		frm.txtAreaTown.value = '';
		frm.txtCityCounty.value = '';
		frm.txtPostCode.value = '';
		frm.txtPhone.value = '';
		frm.txtMobile.value = '';
	}
}
function checkEmpStatus()
{
	if(trim(document.getElementById('cmbEmploymentStatus').value)=='Other, Please state?')
	{
		document.getElementById('employment_status1').style.display='block';
		document.getElementById('employment_status2').style.display='block';
		document.getElementById('unempdate').style.display='none';
		document.getElementById('txtUnEmpDate').value=document.getElementById('txtUnEmpDate_H').value;
		document.getElementById('txtEmploymentStatus').value=document.getElementById('txtEmploymentStatus_H').value;
	}		
	else if(trim(document.getElementById('cmbEmploymentStatus').value)=='Unemployed?')
	{
		document.getElementById('unempdate').style.display='block';
		document.getElementById('txtEmploymentStatus').value=document.getElementById('txtEmploymentStatus_H').value;
		document.getElementById('txtUnEmpDate').value=document.getElementById('txtUnEmpDate_H').value;
		document.getElementById('employment_status1').style.display='none';
		document.getElementById('employment_status2').style.display='none';
	}
	else
	{
		document.getElementById('unempdate').style.display='none';
		document.getElementById('txtUnEmpDate').value=document.getElementById('txtUnEmpDate_H').value;
		document.getElementById('txtEmploymentStatus').value=document.getElementById('txtEmploymentStatus_H').value;
		document.getElementById('employment_status1').style.display='none';
		document.getElementById('employment_status2').style.display='none';
	}
}
function setDate()
{
	document.getElementById('txtDOB').value = document.getElementById('txtDOB2').value;
}