<?php
// Start Session
session_start();

//required PHP files
require_once('general_functions.php');
require_once('class/user.class.php');
require_once('class/template.class.php');
require_once('class/form.class.php');
require_once('class/dashboard.class.php');
require_once('class/job.class.php');

//init template
$template = new Template;

//debug mode
$debug = 0;

//check if user is authenticated
if (!$_SESSION['user']){
    header("location: /account/logout/");
    exit;
}
if (!$_SESSION['google_data']){
    header("location: /account/logout/");
    exit;
}
$user = new Users;
$user->checkAuth($_SESSION['user']['id'],$_SESSION['user']['o_id']);

?>