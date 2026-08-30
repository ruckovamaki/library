<?php
session_start();
require 'db.php';
require 'functions.php';

if(isLoggedIn()){
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    registerUser($sql, $_POST['name'], $_POST['email'], $_POST['password']);
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <?php if (isLoggedIn()): ?>
                <a href="add.php">Přidej knihu</a>
                <span class="logged-in"><?= $_SESSION['name'] ?></span>
                <a href="logout.php">Odhlásit se</a>
            <?php else: ?>
                <a href="index.php">Domů</a>
                <a href="login.php">Přihlas se</a>
            <?php endif; ?>
        </nav>

        <h1>Zaregistrujte se</h1>

        <form class="register" method="post">
            <input type="text" name="name" placeholder="Uživatelské jméno" required><br>
            <input type="email" name="email" placeholder="E-mail" required><br>
            <input type="password" name="password" placeholder="Heslo" required><br>
            <button type="submit">Zaregistrovat se</button>
        </form>
    </div>


</body>
</html>