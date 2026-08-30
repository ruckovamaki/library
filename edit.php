<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$book = getBook($sql, $id);
$genres = getGenres($sql);

if (!isOwner($book)) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $cover_image = uploadImage('image');

    editBookWithImage(
        $sql,
        $id,
        $cover_image,
        $_POST['name'],
        $_POST['author'],
        $_POST['description'],
        $_POST['publication_year'],
        $_POST['genre_id']
    );

    } else {

        editBook(
            $sql,
            $id,
            $_POST['name'],
            $_POST['author'],
            $_POST['description'],
            $_POST['publication_year'],
            $_POST['genre_id']
        );
    }
    
    header('Location: detail.php?id=' . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uprav knihu</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <a href="add.php">Přidat knihu</a>
            <a href="index.php">Domů</a>
            <span class="logged-in"><?= $_SESSION['name'] ?></span>
            <a href="logout.php">Odhlásit se</a>
        </nav>

        <h1>Uprav knihu:</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image"><br>
            <input type="text" name="name" value="<?= $book['name'] ?>" required><br>
            <input type="text" name="author" value="<?= $book['author'] ?>" required><br>
            <textarea name="description" required><?= $book['description'] ?></textarea><br>
            <input type="number" name="publication_year" value="<?= $book['publication_year'] ?>" required><br>
            <select name="genre_id" required>
                <option value="">Vyberte žánr:</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre['id'] ?>" <?php if ($genre['id'] == $book['genre_id'])
                            echo 'selected'; ?>><?= $genre['name'] ?></option>
                <?php endforeach; ?>
            </select><br>
            <button type="submit" value="submit">Hotovo</button>
        </form>


    </div>

</body>

</html>