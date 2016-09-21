<?php
/**
 * VFM - veno file manager thumb
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <info@veno.it>
 * @copyright 2013-2016 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://codecanyon.net/item/veno-file-manager-host-and-share-files/6114247
 * @link      http://filemanager.veno.it/
 */

/**
* Try to increase memory limit if the script cant render big images.
*/
// ini_set('memory_limit', '512M');
require_once 'vfm-admin/config.php';
session_name($_CONFIG["session_name"]);
session_start();
require_once 'vfm-admin/class.php'; 
if (!GateKeeper::isAccessAllowed()) {
    die('access denied');
}
$imageServer = new ImageServer();
$imageServer->showImage();
exit;