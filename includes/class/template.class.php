<?php

class Template {

    function header($title, $theme) {
        return '<html>
<head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/latest/cerulean/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</head>';
    }

    function footer() {
        return '</html>';
    }

}
?>
