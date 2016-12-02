<?php
require("../../includes/config.php");
	$gClient->revokeToken();
	unset($_SESSION['token']);
	unset($_SESSION['google_data']); //Google session data unset
	session_destroy();
	header("Location:/");
?>
