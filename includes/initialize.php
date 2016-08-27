<?
// start the PHP session
session_start();

// require all necessary php files for application
require_once('functions.php');

// to show session variables for testing when on local, put ?ss=true at the end of the query string in the browser
$ss = (isset($_GET["ss"])) ? $_GET["ss"] : '';
if($ss != "") {
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
}

// set current timezone
date_default_timezone_set('America/Detroit');

// turn on error reporting
error_reporting(E_ALL);

?>