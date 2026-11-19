<?php
require_once('../app/config/config.php');

if(!isset($_SESSION["user"])){
    header("Location: /");
    exit();
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: /students");
    exit();
}

$id = (int)$_GET['id'];

mysqli_query($conn, "DELETE FROM students WHERE stu_id = $id");

mysqli_query($conn, "DELETE FROM users WHERE id = $id");

header("Location: /students");
exit();
?>