<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-Type: text/html; charset=utf-8");

$pdo = new PDO("mysql:host=localhost;dbname=test","root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$pdo->exec('SET NAMES utf8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $sql = "SELECT * FROM books WHERE ((name LIKE :name) AND (isbn LIKE :isbn) AND (author LIKE :author))";
    $statement = $pdo->prepare($sql);
    $statement->execute(["name"=>"%{$name}%","isbn"=>"%{$isbn}%","author"=>"%{$author}%"]);
}else{
    $sql = "SELECT * FROM books";
    $statement = $pdo->prepare($sql);
    $statement->execute();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>


<div class="">
    <h1>Библиотека успешного человека</h1>
    <form method="POST">
        <div class="" uk-grid>
            <div class=""><input type="text" name="isbn" placeholder="ISBN" value="<?php if (!empty($_POST)){echo $_POST['isbn'];} ?>"></div>
            <div class=""><input type="text" name="name" placeholder="Название книги" value="<?php if (!empty($_POST)){echo $_POST['name'];} ?>"></div>
            <div class=""><input type="text" name="author" placeholder="Автор книги" value="<?php if (!empty($_POST)){echo $_POST['author'];} ?>"></div>
            <div class=""><button type="submit" class="">Поиск</button></div>
        </div>
    </form>
    <table class="">
        <thead>
        <tr>
            <th class="">Название</th>
            <th class="">Автор</th>
            <th class="">Год выпуска</th>
            <th class="">Жанр</th>
            <th class="">ISBN</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statement as $row) : ?>
            <tr>
                <td><?=$row['name']?></td>
                <td class=""><?=$row['author']?></td>
                <td class=""><?=$row['year']?></td>
                <td><?=$row['genre']?></td>
                <td class=""><?=$row['isbn']?></td>
            </tr>
        <?php endforeach;?>

        </tbody>

    </table>
</div>