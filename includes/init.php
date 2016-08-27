<?php
//required PHP files
require_once('class/user.class.php');
require_once('class/template.class.php');
require_once('class/form.class.php');

//init template
$template = new Template;

//check if user is authenticated
$user = new Users;
$user->checkAuth();
?>