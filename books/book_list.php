<?php
require_once('../app/config/config.php');

if(!isset($_SESSION["user"])){
header("Location: /");
exit();
}

$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<?php if($_SESSION["user"]['role'] == 'admin'){ ?>
<!DOCTYPE html>
<html>
<head>

<title>Books</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="dashboard-page">

<div class="dashboard">

<!-- SIDEBAR -->
  <?php include('../includes/sidebar.php'); ?>
<!-- MAIN -->
<div class="main">
    <div class="topbar">
            <h2>Book List</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

<div style="padding:0px">

<a href="/add_book" class="login-btn">+ Add Book</a>

<br><br>

<table class="table">

<tr>
<th>ID</th>
<th>Title</th>
<th>Author</th>
<th>Total</th>
<th>Available</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['author']; ?></td>
<td><?php echo $row['total_qty']; ?></td>
<td><?php echo $row['available_qty']; ?></td>

<td>

<a href="/add_book?id=<?php echo $row['id']; ?>" title="edit">📝</a>


<a href="/book_delete?id=<?php echo $row['id']; ?>" 
title="delete"
onclick="return confirm('Delete book?')">🗑️</a>

</td>

</tr>

<?php } ?>

</table>

</div>
 <?php include('../includes/footer.php'); ?>
</div>

</div>

</body>
</html><?php }else{ ?>
<!DOCTYPE html>
<html>
<head>

<title>Books</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="dashboard-page">

<div class="dashboard">
    <?php include('../includes/sidebar.php'); ?>
<!-- MAIN -->

<div class="main">
        <div class="topbar">
            <h2>Book List</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

<div style="padding:0px">

<table class="table">

<tr>
<th>ID</th>
<th>Title</th>
<th>Author</th>
<th>Total</th>
<th>Available</th>  
<th>Action</th> 
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['author']; ?></td>
<td><?php echo $row['total_qty']; ?></td>
<td><?php echo $row['available_qty']; ?></td>
<td>
    <?php if($row['available_qty'] > 0){ ?>
    <a href="/is?id=<?php echo $row['id']; ?>" 
   onclick="return confirm('Issue this book?')">
   📚 Issue
    </a>
    <?php } else { ?>
        ❌ Not Available
<?php } ?>
</td>

</tr>

<?php } ?>

</table>

</div>
 <?php include('../includes/footer.php'); ?>
</div>

</div>

</body>
</html>
<?php } ?>