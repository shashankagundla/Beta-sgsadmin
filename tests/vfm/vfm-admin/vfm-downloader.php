<?php
/**
 * VFM - veno file manager downloader
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2016 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */
require_once 'config.php';
require_once 'users/users.php';
require_once 'class.php';
require_once 'users/remember.php';

$cookies = new Cookies();
$encodeExplorer = new EncodeExplorer();
$encodeExplorer->init();

require_once 'translations/'.$encodeExplorer->lang.'.php';

$gateKeeper = new GateKeeper();
$gateKeeper->init();
$setUp = new SetUp();
$downloader = new Downloader();
$utils = new Utils();
$logger = new Logger();
$actions = new Actions();

$timeconfig = $setUp->getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

$script_url = $setUp->getConfig('script_url');

$getfile = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$getfilelist = filter_input(INPUT_GET, 'dl', FILTER_SANITIZE_STRING);
$getcloud = filter_input(INPUT_GET, 'd', FILTER_SANITIZE_STRING);
$hash = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_STRING);
$supah = filter_input(INPUT_GET, 'sh', FILTER_SANITIZE_STRING);
$playmp3 = filter_input(INPUT_GET, 'audio', FILTER_SANITIZE_STRING);
$getpass = filter_input(INPUT_GET, 'pw', FILTER_SANITIZE_STRING);
if ($getpass) {
    $getpass = urldecode($getpass);
}

$alt = $setUp->getConfig('salt');
$altone = $setUp->getConfig('session_name');
$maxfiles = $setUp->getConfig('max_zip_files');
$maxfilesize = $setUp->getConfig('max_zip_filesize');

$android = false;
$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);

if (stripos($useragent, 'android') !== false) {
    $android = true;
}

if ($getfile && $hash && $supah
    && $downloader->checkFile($getfile) == true
    && md5($hash.$alt.$getfile) === $supah
) {
    /**
    * Download single file 
    * (for non-logged users)
    */
    $headers = $downloader->getHeaders($getfile);
    
    if ($downloader->download(
        $headers['file'], 
        $headers['filename'], 
        $headers['file_size'], 
        $headers['content_type'], 
        $headers['disposition'],
        $android
    ) === true ) {
        $logger->logDownload($headers['trackfile']);
    }
    exit;

} elseif ($getfile && $hash
    && $downloader->checkFile($getfile) == true
    && md5($alt.$getfile.$altone.$alt) === $hash
) {
    /**
    * Download single file, 
    * play Audio or show PDF 
    * (for logged users)
    */
    $headers = $downloader->getHeaders($getfile, $playmp3);

    if (($gateKeeper->isUserLoggedIn() 
        && $downloader->subDir($headers['dirname']) == true) 
        || $gateKeeper->isLoginRequired() == false
    ) {
        if ($downloader->download(
            $headers['file'], 
            $headers['filename'], 
            $headers['file_size'], 
            $headers['content_type'], 
            $headers['disposition'],
            $android
        ) === true ) {
            if ($headers['content_type'] == 'audio/mp3') {
                $logger->logPlay($headers['trackfile']);
            } else {
                $logger->logDownload($headers['trackfile']);
            }
        }
        exit;
    }
    $_SESSION['error'] = '<i class="fa fa-ban"></i> Access denied';
    header('Location:'.$script_url);
    
    exit;

    /**
    * Download multiple files 
    * as .zip archive
    */
} elseif ($getfilelist && file_exists('shorten/'.$getfilelist.'.json')) {
    $datarray = json_decode(file_get_contents('shorten/'.$getfilelist.'.json'), true);

    $hash = $datarray['hash'];
    $time = $datarray['time'];
    $pass = $datarray['pass'];
    $passa = true;

    if ($pass) { 
        $passa = false;
        if ($getpass && md5($getpass) === $pass) {
            $passa = true;
        }
    }

    if ($downloader->checkTime($time) == true && $passa === true) {

        $pieces = explode(",", $datarray['attachments']);

        if (count($pieces) > $maxfiles) {
            $_SESSION['error'] = $encodeExplorer->getString('too_many_files').' '.$maxfiles;
            header('Location:'.$script_url);
            exit;
        }

        $totalsize = 0;
        $maxbytes = $maxfilesize*1024*1024;

        foreach ($pieces as $pezzo) {
            $myfile = "../".urldecode(base64_decode($pezzo));
            $totalsize = $totalsize + File::getFileSize($myfile);
        }
        
        if ($totalsize > $maxbytes) {
            $_SESSION['error'] = '<strong>'.$setUp->formatsize($totalsize).'</strong>: '.$encodeExplorer->getString('size_exceeded');
            header('Location:'.$script_url);
            exit;
        }

        if (!file_exists('tmp')) {
            if (!mkdir('tmp', 0755)) {
                $_SESSION['error'] = 'Cannot create a tmp dir for .zip files';
                header('Location:'.$script_url);
                exit;
            } if (!chmod('tmp', 0755)) {
                $_SESSION['error'] = 'Cannot set CHMOD 755 to tmp dir';
                header('Location:'.$script_url);
                exit;
            }
        }

        $file = tempnam('tmp', 'zip');
        
        if (!$file) {
            $_SESSION['error'] = 'cannot set: tempnam("tmp","zip") from vfm-downloader';
            header('Location:'.$script_url);
            exit;         
        }

        $zip = new ZipArchive();

        if ($zip->open($file, ZipArchive::OVERWRITE) !== true) {
            $_SESSION['error'] = "cannot open: $file\n";
            header('Location:'.$script_url);
            exit;
        }
        $logarray = array();
        foreach ($pieces as $pezzo) {
            if ($downloader->checkFile($pezzo) == true) {
                $decoded = urldecode(base64_decode($pezzo));
                $myfile = "../".$decoded;
                $filepathinfo = $utils->mbPathinfo($myfile);
                $filename = $filepathinfo['basename'];
                $zip->addFile($myfile, $filename);
                array_push($logarray, "./".$decoded);
            }
        }
        $zip->close();

        $filename = $time.'.zip';
        $file_size = File::getFileSize($file);
        $content_type = 'application/zip';
        $disposition = 'attachment';

        if ($downloader->download(
            $file, 
            $filename, 
            $file_size, 
            $content_type, 
            $disposition,
            $android
        ) === true) {
            $logger->logDownload($logarray);
        }
        unlink($file);
        exit;
    }
    $_SESSION['error'] = '<i class="fa fa-ban"></i> Access denied';
    header('Location:'.$script_url);
    exit;
}
$_SESSION['error'] = $encodeExplorer->getString("link_expired");
header('Location:'.$script_url);
exit; ?>