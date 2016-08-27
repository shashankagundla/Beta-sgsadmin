<?php
include("config.php");
require_once("includes/class/user.class.php");

if(isset($_REQUEST['code'])){
	$gClient->authenticate();
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	$userProfile = $google_oauthV2->userinfo->get(); //Get user profile from our friends at google
	$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
	$_SESSION['token'] = $gClient->getAccessToken(); // Storing Google token in Session
	$gUser = new Users();
	$gUser->auth('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);

} else {
	$authUrl = $gClient->createAuthUrl();
}

if(isset($authUrl)) {
	echo '<a href="'.$authUrl.'"><img src="assets/mages/glogin.png" alt=""/></a>';
} else {
	echo '<a href="account/logout/?logout">Logout</a>';
}

?>
