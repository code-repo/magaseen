<?php
if(!defined('QUERY_ERROR'))
	define('QUERY_ERROR', 'Oops! We are working on fixing this issue for you.');
#Login
define("LOGIN_ERROR", 'Wrong Login ID/Password combination.');
define('LOGIN_TEXT', 'Please enter your login details');
define('LOGOUT', 'You have successfully logged out.');
define('BOOKING', 'Please login to book a seminar.');
define('SELECT_VALUE', 'Please select at least one value to proceed.');

#Change Password
define('BLANK_OLD_PASSWORD', 'Please enter the old password.');
define('BLANK_NEW_PASSWORD' ,'Please enter the new password.');
define('BLANK_CONFIRM_PASSWORD' ,'Please enter the confirm password.');
define('INVALID_OLDPASSWORD' ,'Invalid old password.');
define('PASSWORD_CPASSWORD_NOTMATCH' ,'New password and confirm password doesnot match.');
define('PASSWORD_CHANGED' ,'Password has been changed sucessfully.');

#Update Email
define('EMAIL_UPDATE' ,'Email has been updated sucessfully.');
if(!defined('INVALID_EMAIL'))
	define('INVALID_EMAIL' ,'You have entered an invalid email address.');
define('BLANK_EMAIL' ,'Please enter an email address.');
define('BLANK_CONFIRM_EMAIL' ,'Please enter the confirm email address.');
define('EMAIL_ALREADY_EXIST' ,'Email address already in use.');
define('EMAIL_MISMATCH' ,'Email and confirm email do not match.');
define('BLANK_PASSWORD' ,'Please enter an password.');
define('BLANK_CPASSWORD' ,'Please confirm the password.');
define('PASSWORD_MISMATCH','Passwords and confirm password do not match.');
define('BLANK_FIRST_NAME','Please enter the first name.');
define('BLANK_LAST_NAME','Please enter the last name.');
define('BLANK_PROVINCE','Please select the state.');
define('BLANK_COUNTRY','Please select the country.');
define('BLANK_SUITE','Please enter the Bldg/Floor/Suite.');
define('BLANK_STREET','Please enter the street address.');
define('BLANK_CITY','Please enter the City.');
define('BLANK_ZIP','Please enter the Zip / Postal Code.');
if(!defined('BLANK_PHONE'))
	define('BLANK_PHONE','Please enter the Phone/Mobile.');
define('PASSWORD_SENT','the password has been sent to your Email Address.');
define('MAIL_FORGOT_SUBJECT','Password Reminder!');
define('INVALID_LOGIN','Your email address is invalid or currently disabled.');
define('PROFILE_UPDATED','Your has profile has been updated successfully.');

#Admin
define('RECORD_DELETE', 'Record have been deleted successfully.');
define('RECORD_ACTIVATE', 'Record have been activated successfully.');
define('RECORD_DEACTIVATE', 'Record have been deactivated successfully.');
define('RECORD_ADDED', 'Record have been added successfully.');
define('RECORD_UPDATED', 'Record has been updated successfully.');
?>
