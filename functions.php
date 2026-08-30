<?php

function getBook($sql, $id)
{
    $stmt = $sql->prepare('SELECT b.*, g.name AS genre, u.name AS user_name, u.email AS contact FROM books b
    JOIN genres g
    ON b.genre_id = g.id
    JOIN users u
    ON b.user_id = u.id
    WHERE b.id = ?
    ');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getBooks($sql)
{
    $stmt = $sql->prepare('SELECT b.*, g.name AS genre, u.name AS user_name, u.email AS contact FROM books b
    JOIN genres g
    ON b.genre_id = g.id
    JOIN users u
    ON b.user_id = u.id
    ORDER BY b.id ASC
    LIMIT 10');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getBooksByGenre($sql, $id)
{
    $stmt = $sql->prepare('SELECT b.*, u.name AS user_name, u.email AS contact FROM books b
    JOIN users u
    ON b.user_id = u.id
    WHERE genre_id = ?
    ORDER BY b.name DESC');
    $stmt->execute([$id]);
    return $stmt->fetchAll();

}

function searchBooks($sql, $search, $genre_id)
{
    $stmt = $sql->prepare("
        SELECT b.*, g.name AS genre, u.name AS user_name, u.email AS contact
        FROM books b
        JOIN genres g ON b.genre_id = g.id
        JOIN users u ON b.user_id = u.id
        WHERE (b.name LIKE ? OR b.author LIKE ?)
        AND (? = '' OR b.genre_id = ?)
        ORDER BY b.id DESC
    ");
    $stmt->execute([
        "%" . $search . "%",
        "%" . $search . "%",
        $genre_id,
        $genre_id
    ]);
    return $stmt->fetchAll();
}

function addBook($sql, $image, $name, $author, $description, $publication_year, $genre_id, $user_id)
{
    $stmt = $sql->prepare('INSERT INTO books (image, name, author, description, publication_year, genre_id, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)');
    return $stmt->execute([$image, $name, $author, $description, $publication_year, $genre_id, $user_id]);
}

function editBookWithImage($sql, $id, $image, $name, $author, $description, $publication_year, $genre_id)
{
    $stmt = $sql->prepare('UPDATE books SET image = ?, name = ?, author = ?, description = ?, publication_year = ?, genre_id = ?
    WHERE id = ?');
    return $stmt->execute([$image, $name, $author, $description, $publication_year, $genre_id, $id]);
}

function editBook($sql, $id, $name, $author, $description, $publication_year, $genre_id)
{
    $stmt = $sql->prepare('UPDATE books SET name = ?, author = ?, description = ?, publication_year = ?, genre_id = ?
    WHERE id = ?');
    return $stmt->execute([$name, $author, $description, $publication_year, $genre_id, $id]);
}


function deleteBook($sql, $id)
{
    $stmt = $sql->prepare('DELETE FROM books WHERE id = ?');
    return $stmt->execute([$id]);
}

function getGenre($sql, $id)
{
    $stmt = $sql->prepare('SELECT * FROM genres WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getGenres($sql)
{
    $stmt = $sql->prepare('SELECT * FROM genres');
    $stmt->execute();
    return $stmt->fetchAll();
}

function registerUser($sql, $name, $email, $password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $sql->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $email, $hashedPassword]);
}

function loginUser($sql, $email, $password)
{
    $stmt = $sql->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        return true;
    }

    return false;

}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isOwner($book)
{
    return isLoggedIn() && $_SESSION['user_id'] == $book['user_id'];
}

function uploadImage($inputName)
{
    if (isset($_FILES[$inputName])) {
        $fileName = $_FILES[$inputName]['name'];
        move_uploaded_file($_FILES[$inputName]['tmp_name'], 'uploads/' . $fileName);
        return $fileName;
    }
    return '';
}