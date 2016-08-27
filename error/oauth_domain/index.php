<?php
include_once("../../config.php");

echo 'Error: You must login using an SGS Towers account. ';
echo 'Attempted login e-mail was: ';
echo $_SESSION['google_data']['email'];

unset($_SESSION['token']);
unset($_SESSION['google_data']); //Google session data unset
$gClient->revokeToken();
session_destroy();

?>