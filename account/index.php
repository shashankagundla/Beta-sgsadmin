<?php
require_once("../includes/init.php");
?>
<html>

<?php
$template->header('User Account')
?>

<body>
<h1>Bootstrap</h1>
<div class="alert alert-info">
    <div class="wrapper">
        <h1>Google Profile Details </h1>
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
</div>
<select></select>
</body>
<script>
    $.getJSON("https://bootswatch.com/api/3.json", function (data) {
        var themes = data.themes;
        var select = $("select");
        select.show();
        $(".alert").toggleClass("alert-info alert-success");
        $(".alert h4").text("Success!");

        themes.forEach(function(value, index){
            select.append($("<option />")
                .val(index)
                .text(value.name));
        });

        select.change(function(){
            var theme = themes[$(this).val()];
            $("link").attr("href", theme.css);
            $("h1").text(theme.name);
        }).change();

    }, "json").fail(function(){
        $(".alert").toggleClass("alert-info alert-danger");
        $(".alert h4").text("Failure!");
    });
</script>
</html>