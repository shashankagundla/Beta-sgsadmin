<?php

class Template {

    function header($title, $theme) {
        $html = '
<html>
<head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="/assets/css/theme/'.$theme.'.css">
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</head>
';

        return $html;
    }

    function navbar(){
        return'';
    }

    function footer() {
        return '</html>';
    }

}
?>
