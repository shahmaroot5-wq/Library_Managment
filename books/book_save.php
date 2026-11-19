<?php
require_once('../app/config/config.php');

if(!isset($_SESSION["user"])){
    header("Location: /");
    exit();
}

$id     = $_POST['id'] ?? 0;
$title  = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$total  = $_POST['total_qty'] ?? 0;

if ($id) {

    $conn->query("UPDATE books 
        SET title='$title', author='$author', total_qty='$total' 
        WHERE id=$id");

} else {

    $conn->query("
        INSERT INTO books(title, author, total_qty, available_qty)
        VALUES('$title', '$author', '$total', '$total')
    ");
}

header("Location: /books");
exit();