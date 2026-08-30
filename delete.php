<?php
session_start();
require 'db.php';
require 'functions.php';

if(!isLoggedIn()){
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$book = getBook($sql, $id);

if(!isOwner($book)){
    header('Location: index.php');
    exit;
}

deleteBook($sql, $id);
header('Location: detail.php');
exit;


?>