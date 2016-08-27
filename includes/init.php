<?php
//required PHP files
require_once('class/user.class.php');

//check if user is authenticated
$user = new Users;
$user->checkAuth();
?>