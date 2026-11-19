<?php
require_once('../app/config/config.php');

$_SESSION = [];

session_destroy();

header("Location: /");
exit();
?>