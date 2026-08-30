<?php
session_start();
require 'db.php';
require 'functions.php';

$genres = getGenres($sql);

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $cover_image = uploadImage('image');

    addBook(
        $sql,
        $cover_image,
        $_POST['name'],
        $_POST['author'],
        $_POST['description'],
        $_POST['publication_year'],
        $_POST['genre_id'],
        $_SESSION['user_id']

    );

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidej knihu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <a href="index.php">Domů</a>
            <span class="logged-in"><?= $_SESSION['name'] ?></span>
            <a href="logout.php">Odhlásit se</a>
        </nav>

        <h1>Přidej novou knihu:</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image"><br>
            <input type="text" name="name" placeholder="Název knihy" required><br>
            <input type="text" name="author" placeholder="Autor" required><br>
            <textarea name="description" placeholder="Popis" required></textarea><br>
            <input type="number" name="publication_year" placeholder="Rok vydání" required><br>
            <select name="genre_id" required>
                <option value="">Vyberte žánr:</option>
                <?php foreach($genres as $genre):?>
                    <option value="<?=$genre['id']?>"><?=$genre['name']?></option>
                    <?php endforeach; ?>
            </select><br>
            <button type="submit" value="submit">Hotovo</button>
        </form>

        
    </div>

</body>

</html>