<?php
//required PHP files
require_once ('user.class.php');



//check if user is authenticated
$user = new Users;
$user->checkAuth();
?>