<?php
require_once('../app/config/config.php');

if (!isset($_SESSION["user"])) {
    header("Location: /");
    exit();
}

if ($_SESSION["user"]["role"] !== 'admin') {
    header("Location: /");
    exit();
}

$msg = "";

if (!isset($_GET['id'])) {
    header("Location: /students");
    exit();
}

if (empty($_GET['id'])) {
    header("Location: /students");
    exit();
}

$id = (int)$_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = trim($_POST['password']);

    if ($password == "") {
        $msg = "Password cannot be empty.";
    } else {

        $hash = md5($password);

        $query = "UPDATE users SET password_hash='$hash' WHERE id=$id";

        if (mysqli_query($conn, $query)) {
            header("Location: /students");
            exit();
        } else {
            $msg = "Update failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard">

    <?php include('../includes/sidebar.php'); ?>

<div class="main">

        <div class="topbar">
            <h2>Change Password</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

        <div class="form-area">
            <div class="book-form-box">

                <?php if ($msg != "") { ?>
<p class="error"><?php echo $msg; ?></p>
<?php } ?>

<form method="POST">

<label>New Password</label>
<input type="password" name="password" placeholder="Enter new password" required>

                    <div class="form-buttons">
                        <button type="submit" class="save-btn">Update Password</button>
                        <a href="/students" class="cancel-btn">Back</a>
                    </div>

</form>

</div>
        </div>

        <?php include('../includes/footer.php'); ?>

</div>

</div>

</body>
</html>