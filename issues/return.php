<?php
require_once('../app/config/config.php');

if(!isset($_SESSION["user"])){
    header("Location: /");
    exit();
}

$user_id = (int)$_SESSION["user"]['id'];

// get students.id using users.id
$stu_result = $conn->query("SELECT id FROM students WHERE stu_id = $user_id");
$stu_row    = $stu_result->fetch_assoc();
$student_id = (int)$stu_row['id'];

$result = $conn->query("SELECT issued_books.*, books.title AS book_name 
                        FROM issued_books 
                        LEFT JOIN books ON issued_books.book_id = books.id 
                        WHERE issued_books.student_id = $student_id 
                        AND issued_books.status = 'returned' 
                        ORDER BY issued_books.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Returned Books</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-page">

<div class="dashboard">
<?php include('../includes/sidebar.php'); ?>
<div class="main">

        <div class="topbar">
            <h2>Return Books</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>
<div style="padding:0px">

<?php if($result->num_rows === 0){ ?>
    <p style="text-align:center; padding:20px;">No returned books found.</p>
<?php } else { ?>

<table class="issue-table">

<tr>
<th>ID</th>
<th>Book Name</th>
<th>Issue Date</th>
<th>Due Date</th>
<th>Return Date</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['book_name']; ?></td>
<td><?php echo $row['issue_date']; ?></td>
<td><?php echo $row['due_date']; ?></td>
<td><?php echo $row['return_date']; ?></td>
</tr>

<?php } ?>

</table>

<?php } ?>

</div>
 <?php include('../includes/footer.php'); ?>
</div>
</div>

</body>
</html>