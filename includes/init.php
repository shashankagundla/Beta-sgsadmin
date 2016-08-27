<?php
//required PHP files
require_once ('functions.php');



//check if user is authenticated
$user = new Users;
$user->checkAuth();
?>