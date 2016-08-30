<?php
require_once("../includes/init.php");
echo $template->header('User Account','');

?>
    <div class="container-fluid">
        <?php
        echo '<div class="google_box">';
        echo '<p class="image"><img src="'.$_SESSION['google_data']['picture'].'" alt="" width="300" height="220"/></p>';
        echo '<p><b>Name : </b>' . $_SESSION['user']['fname']. ' ' . $_SESSION['user']['lname'] .'</p>';
        echo '<p><b>Email : </b>' . $_SESSION['google_data']['email'].'</p>';
        echo '</div>';
        ?>
    </div>

<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>' . var_export($_SESSION, true) . '</pre>';
}
echo $template->footer();
echo $template->notify();
?>


