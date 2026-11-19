<?php
require_once('../app/config/config.php');

// only admins allowed
if (!isset($_SESSION["user"])) {
    header("Location: /");
    exit();
}

if ($_SESSION["user"]["role"] !== 'admin') {
    header("Location: /");
    exit();
}

// Database counts
$books   = $conn->query("SELECT COUNT(id) as total FROM books")->fetch_assoc()['total'];
$members = $conn->query("SELECT COUNT(id) as total FROM students")->fetch_assoc()['total'];
$issued  = $conn->query("SELECT COUNT(id) as total FROM issued_books WHERE status='issued'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard">

    <?php include('../includes/sidebar.php'); ?>

    <div class="main">

        <div class="topbar">
            <h2>Library Dashboard</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

        <div class="cards">
            <a class="card-link" href="/books">
                <div class="card blue">
                    <h1><?php echo $books; ?></h1>
                    Books
                </div>
            </a>
            <a class="card-link" href="/students">
                <div class="card green">
                    <h1><?php echo $members; ?></h1>
                    Students
                </div>
            </a>
            <a class="card-link" href="/issues">
                <div class="card orange">
                    <h1><?php echo $issued; ?></h1>
                    Issued
                </div>
            </a>
        </div>

        <?php include('../includes/footer.php'); ?>
    </div>
</div>

</body>
</html>