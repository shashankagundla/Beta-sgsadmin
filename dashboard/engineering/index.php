<?php
/*
 * Page Setup
 */
$page = 'Engineering Dashboard';
require_once("../../includes/init.php");
echo $template->header($page,$subtitle);

/*
 * Init dashboard class and get required select field info
 */

?>








<?php
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>