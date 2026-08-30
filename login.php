<?php
session_start();
require 'db.php';
require 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (loginUser($sql, $_POST['email'], $_POST['password'])) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Nesprávně zadaný e-mail nebo heslo!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="styles.css"><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <a href="index.php">Domů</a>
            <a href="register.php">Zaregistrujte se</a>
        </nav>

        <h1>Přihlaste se</h1>

        <form class="login" method="post">
            <input type="email" name="email" placeholder="E-mail" required><br>
            <input type="password" name="password" placeholder="Heslo" required><br>
            <button type="submit">Přihlásit se</button>
        </form>
    </div>


</body>

</html>