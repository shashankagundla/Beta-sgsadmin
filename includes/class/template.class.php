<?php

class Template {

    function header($title, $theme) {
        return '<html>
<head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
    <script>$.getJSON("https://bootswatch.com/api/3.json",function(a){var b=a.themes,d=($("select"),b['.$theme.']);$("link").attr("href",d.css)},"json").fail(function(){$(".alert").toggleClass("alert-info alert-danger"),$(".alert h4").text("Failure!")});</script>
</head>';
    }

    function footer() {
        return '</html>';
    }

}
?>
