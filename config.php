<?php
session_start();
include("src/Google_Client.php");
include("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '94937420735-tbq29gtr5akj5gjermf58itn8hb95m56.apps.googleusercontent.com'; //Google CLIENT ID
$clientSecret = 'RwB53vzf1-NSuaE9du62hWDC'; //Google CLIENT SECRET
$redirectUrl = 'https://beta.sgsadmin.com';  //return url (url to script)
$homeUrl = 'http://beta.sgsadmin.com';  //return to home

##################################

$gClient = new Google_Client();
$gClient->setApplicationName('Login to SGS Admin V3');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
