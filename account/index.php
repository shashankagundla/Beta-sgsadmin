<?php
require_once("../includes/init.php");
echo $template->header('User Account', 11);
?>
    <div class="container-fluid">
    <div class = "page-header">
        <h2>Example page header</h2>
    </div>
        <?php
        echo '<div class="welcome_txt">Welcome <b>'.$_SESSION['google_data']['given_name'].'</b></div>';
        echo '<div class="google_box">';
        echo '<p class="image"><img src="'.$_SESSION['google_data']['picture'].'" alt="" width="300" height="220"/></p>';
        echo '<p><b>Google ID : </b>' . $_SESSION['google_data']['id'].'</p>';
        echo '<p><b>Name : </b>' . $_SESSION['google_data']['name'].'</p>';
        echo '<p><b>Email : </b>' . $_SESSION['google_data']['email'].'</p>';
        echo '<p><b>Gender : </b>' . $_SESSION['google_data']['gender'].'</p>';
        echo '<p><b>Locale : </b>' . $_SESSION['google_data']['locale'].'</p>';
        echo '<p><b>Google+ Link : </b>' . $_SESSION['google_data']['link'].'</p>';
        echo '<p><b>You are login with : </b>Google</p>';
        echo '<p><b>Logout from <a href="logout/?logout">Google</a></b></p>';
        echo '</div>';
        ?>
    </div>
<?php
echo $template->footer();
?>


