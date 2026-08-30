<?php
session_start();
require 'db.php';
require 'functions.php';

$id = $_GET['id'] ?? null; 

if (!$id) {
    header('Location: index.php');
    exit;
}

$genre = getGenre($sql, $id);
$books = getBooksByGenre($sql, $id);

if (!$genre) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail žánru</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                <a href="register.php">Zaregistruj se</a>
                <a href="login.php">Přihlas se</a>
            <?php endif; ?>
        </nav>

        <div class="genre-detail">
            <h1>Detail žánru:</h1>
            <div class="genre-info">
                <p>Název: <?=$genre['name']?></p>
                <p>Popis: <?=$genre['description']?></p>

                <h2>Knihy s tímto žánrem:</h2>
                <?php foreach($books as $book):?>
                <img src="uploads/<?= $book['image'] ?>">
                <a href="detail.php?id=<?= $book['id'] ?>"><?= $book['name'] ?></a>
                <p>Autor: <?= $book['author'] ?></p>
                <p>Popis: <?= $book['description'] ?></p>
                <p>Přidal: <?= $book['user_name'] ?></p>
                <p>Kontakt: <?= $book['contact'] ?></p>
                <?php if (isLoggedIn() && isOwner($book)): ?>
                    <a class="edit-btn" href="edit.php?id=<?= $book["id"] ?>">Upravit</a>
                    <a class="delete-btn" href="delete.php?id=<?= $book["id"] ?>">Smazat</a>
                <?php endif; ?>
                <?php endforeach; ?>

            </div>

        </div>
    </div>

</body>

</html>