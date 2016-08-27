<?php

class Template {

    function header($title) {
return <<<HTML
<html>
<head>
    <meta charset="utf-8">
    <title>{ $title }</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</head>
HTML;
    }

    function footer(){

    }
}
?>
