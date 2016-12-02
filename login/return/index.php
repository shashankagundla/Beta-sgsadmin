<?php
session_start();
if ($_SESSION['user']['lpage']){
    header("Location: " . $_SESSION['user']['lpage']);
    exit;
}else{
    header("Location: /account/");
    exit;
}
?>