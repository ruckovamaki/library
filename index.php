<?php
session_start();
require 'db.php';
require 'functions.php';

$genres = getGenres($sql);

if (isset($_GET["search"]) || isset($_GET["genre_id"])) {
    $books = searchBooks($sql, $_GET["search"] ?? "", $_GET["genre_id"] ?? "");
} else {
    $books = getBooks($sql);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
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

        <form method="get" class="search">
            <input type="text" name="search" placeholder="Název knihy nebo jméno autora">

            <select name="genre_id">
                <option value="">Všechny žánry</option>

                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre["id"] ?>">
                        <?= $genre["name"] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Vyhledat</button>
        </form>

        <img src="banner.avif" class="banner" alt="Banner">
        <h1>Vítej v knihovně!</h1>

        <div class="latest-books">
            <h2>Poslední přidané knihy:</h2>
            <div class="book-list">
                <?php foreach ($books as $book): ?>
                    <div class="book-card"></div>
                    <img src="uploads/<?= $book['image'] ?>" class="book-img">
                    <a href="detail.php?id=<?= $book['id'] ?>"><?= $book['name'] ?></a>
                    <a href="genre.php?id=<?= $book['genre_id'] ?>"><?= $book['genre'] ?></a>
                    <p>Autor: <?= $book['author'] ?></p>
                    <p>Popis: <?= $book['description'] ?></p>
                    <p>Přidal: <?= $book['user_name'] ?></p>
                    <p>Kontakt: <?= $book['contact'] ?></p>
                </div>
                <div class="buttons">
                    <a class="detail-btn" href="detail.php?id=<?= $book["id"] ?>">Zobrazit detail</a>
                    <?php if (isOwner($book)): ?>
                        <a class="edit-btn" href="edit.php?id=<?= $book["id"] ?>">Upravit</a>
                        <a class="delete-btn" href="delete.php?id=<?= $book["id"] ?>">Smazat</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
    </div>

</body>

</html>