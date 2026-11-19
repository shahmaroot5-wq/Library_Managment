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

// Get the correct student id using stu_id
$student_result = $conn->query("SELECT id FROM students WHERE stu_id = $user_id");

if (!$student_result || $student_result->num_rows === 0) {
    header("Location: /books");
    exit();
}

$student    = $student_result->fetch_assoc();
$student_id = (int)$student['id'];

$result = $conn->query("SELECT b.title, b.author, ib.issue_date, ib.return_date 
                        FROM issued_books ib 
                        LEFT JOIN books b ON b.id = ib.book_id 
                        WHERE ib.student_id = $student_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-page">

<div class="dashboard">
 <?php include('../includes/sidebar.php'); ?>

<div class="main">
<div class="topbar">
            <h2>Issued Books</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

        <table class="table">
<tr>
<th>Book</th>
<th>Author</th>
<th>Issued Date</th>
<th>Return Date</th>
</tr>

            <?php if ($result->num_rows === 0) { ?>
            <tr>
                <td colspan="4" style="text-align:center;">No books issued yet.</td>
            </tr>
            <?php } else { ?>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
<td><?php echo $row['issue_date']; ?></td>
                <td><?php echo $row['return_date'] ? $row['return_date'] : 'Not returned yet'; ?></td>
</tr>
<?php } ?>
            <?php } ?>
</table>

        <?php include('../includes/footer.php'); ?>
</div>
</div>

</body>
</html>