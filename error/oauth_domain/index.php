<?php
include_once("../../config.php");
?>

<h3>Error: You must login using an SGS Towers account. Attempted login e-mail <?=$_SESSION['google_data']['email']?></h3>
<h3><a href="https://accounts.google.com/logout">Logout from Google</a> and try again.</h3>

unset($_SESSION['token']);
unset($_SESSION['google_data']); //Google session data unset
$gClient->revokeToken();
session_destroy();

?>