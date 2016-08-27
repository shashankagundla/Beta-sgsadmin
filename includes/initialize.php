<?

// define paths
define("APP_ROOT", "/");
define("INC_PATH", APP_ROOT . "/includes");
define("PUBLIC_PATH", APP_ROOT . "/");

// define URL
define("URL", "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
define("ESCAPED_URL", htmlspecialchars(URL, ENT_QUOTES, 'UTF-8'));

// start the PHP session
session_start();

// require all necessary php files for application
require_once(INC_PATH . "/functions.php");

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