<?php
require_once('../app/config/config.php');

if (!isset($_SESSION["user"])) {
    header("Location: /");
    exit();
}

if ($_SESSION["user"]["role"] !== 'student') {
    header("Location: /");
    exit();
}

$user_id = (int)$_SESSION["user"]["id"];

// get students.id using users.id
$stu_result = $conn->query("SELECT id FROM students WHERE stu_id = $user_id");
$stu_row    = $stu_result->fetch_assoc();
$student_id = (int)$stu_row['id'];

$books    = $conn->query("SELECT COUNT(id) as total FROM books")->fetch_assoc()['total'];
$issued   = $conn->query("SELECT COUNT(id) as total FROM issued_books WHERE status='issued' AND student_id=$student_id")->fetch_assoc()['total'];
$returned = $conn->query("SELECT COUNT(id) as total FROM issued_books WHERE status='returned' AND student_id=$student_id")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
            <a class="card-link" href="/due_book">
                <div class="card orange">
                    <h1><?php echo $issued; ?></h1>
                    Issued
                </div>
            </a>
            <a class="card-link" href="/return">
                <div class="card red">
                    <h1><?php echo $returned; ?></h1>
                    Returned
                </div>
            </a>
        </div>

        <?php include('../includes/footer.php'); ?>
    </div>
</div>

</body>
</html>