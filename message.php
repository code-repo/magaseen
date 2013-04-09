<?php
if(!defined('QUERY_ERROR'))
	define('QUERY_ERROR', 'Oops! We are working on fixing this issue for you.');
#Login
define("LOGIN_ERROR", 'Wrong Login ID/Password combination.');
define('LOGIN_TEXT', 'Please enter your login details');
define('LOGOUT', 'You have successfully logged out.');
define('RECORD_ADDED', 'Record has been added successfully.');
define('RECORD_EDIT', 'Record has been updated successfully.');

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
#define('BLANK_EMAIL' ,'Please enter an email address.');
define('BLANK_CONFIRM_EMAIL' ,'Please enter the confirm email address.');
define('EMAIL_ALREADY_EXIST' ,'Email address already in use.');
define('EMAIL_MISMATCH' ,'Email and confirm email do not match.');
define('BLANK_PASSWORD' ,'Please enter an password.');
define('BLANK_CPASSWORD' ,'Please confirm your password.');
define('PASSWORD_MISMATCH','Passwords and confirm password do not match.');
define('BLANK_FIRST_NAME','Please enter your first name.');
define('BLANK_LAST_NAME','Please enter your last name.');
define('BLANK_PROVINCE','Please select your province.');
define('BLANK_COUNTRY','Please select your country.');
define('BLANK_SUITE','Please enter your Apt/Bldg/Floor/Suite.');
define('BLANK_STREET','Please enter your street address.');
define('BLANK_CITY','Please enter your City.');
define('BLANK_ZIP','Please enter your Zip / Postal Code.');
if(!defined('BLANK_PHONE'))
	define('BLANK_PHONE','Please enter your Phone/Mobile.');
define('PASSWORD_SENT','Your password has been sent to your Email Address.');
define('MAIL_FORGOT_SUBJECT','Password Reminder!');
define('INVALID_LOGIN','Your have entered an invalid Loin ID.');
define('PROFILE_UPDATED','Your has profile has been updated successfully.');

#Admin
define('USER_DELETE', 'User have been deleted successfully.');
define('USER_ACTIVATE', 'User have been activated successfully.');
define('USER_DEACTIVATE', 'User have been deactivated successfully.');
define('USER_ADDED', 'User have been added successfully.');
define('USER_UPDATED', 'User has been updated successfully.');

define('LBL_WELCOME', 'Welcome');
define('LBL_LOGIN', 'Login');
define('LBL_LOGOUT', 'Logout');
define('LBL_MY_ACCOUNT', 'My Account');
define('LBL_MY_ORDERS', 'My Orders');
define('LBL_MY_PROFILE', 'My Profile');
define('LBL_CHANGE_PASSWORD', 'Change Password');
define('LBL_SHOPPING_CART', 'Shopping Cart');
define('LBL_SEARCH', 'Search');

define('LBL_SHIPPING_INFORMATION', 'Shipping Information');
define('LBL_FIRST_NAME', 'First Name');
define('LBL_MIDDLE_NAME', 'Middle Name');
define('LBL_LAST_NAME', 'Last Name');
define('LBL_CONFIRM_EMAIL', 'Confirm Email');
define('LBL_EMAIL', 'Email');
define('LBL_STREET_ADDRESS', 'Street address');
define('LBL_APT_BLDG_FLOOR_SUITE', 'Apt/Bldg/Floor/Suite');
define('LBL_PO_BOX', 'P.O. Box');
define('LBL_ZIP', 'Zip / Postal Code');
define('LBL_CITY', 'City');
define('LBL_PROVINCE', 'U.S State/Canadian Province');
define('LBL_COUNTRY', 'Country');
define('LBL_PHONE_MOBILE', 'Phone/Mobile');
define('LBL_EMPTY_CART', 'Currently, there is item in your cart.');
define('LBL_ADD_MORE_PRODUCTS', 'Add more products');
define('LBL_SHIPPING_METHOD', 'Shipping Method');
define('LBL_TAX', 'Tax');
define('LBL_SHIPPING', 'Shipping');
define('LBL_GRAND_TOTAL', 'Grand Total');
define('LBL_EXPIRY_DATE', 'Expiry Date');
define('LBL_CREDIT_CARD_TYPE', 'Credit Card Type');
define('LBL_CREDIT_CARD_NUMBER', 'Credit Card Number');
define('LBL_PAYMENT_DETAILS', 'Payment Details');
define('LBL_BUSINESS_SALON_NAME', 'Business/Salon Name');
define('LBL_MESSAGE', 'Message');
define('LBL_PLEASE_VERIFY', 'Please Verify');
define('LBL_SEND', 'Send');
define('LBL_UPDATE', 'Update');
define('LBL_CANCEL', 'Cancel');

#User
define('LBL_ORDER_NUMBER', 'Order Number');
define('LBL_AMOUNT', 'Amount');
define('LBL_DATE', 'Date');
define('LBL_DETAILS', 'Details');
define('LBL_INVALID_ORDER', 'Invalid Order');
define('LBL_OLD_PASSWORD', 'Old Password');
define('LBL_NEW_PASSWORD', 'New Password');
define('LBL_CONFIRM_PASSWORD', 'Confirm Password');
define('LBL_FORGOT_PASSWORD', 'Forgot Password');
define('LBL_PASSWORD', 'Password');
define('LBL_ENTER_EMAIL', 'Enter your email address below to get your password.');
define('LBL_REGISTER', 'Register');

#Publications
define('PUB_ERR', 'Sorry! you dont have enough slots to publish this publication.');
define('PUB', 'Publication has been published successfully.');
define('UNPUB', 'Publication has been un-published successfully.');
define('PUBDEL', 'Publication has been deleted successfully.');
?>
