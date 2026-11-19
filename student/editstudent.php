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

$msg = "";

$query = "SELECT users.id, users.name, users.email, students.phone, students.class, users.role
          FROM users
          LEFT JOIN students ON users.id = students.stu_id
          WHERE users.id=$id
          LIMIT 1";

$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) == 0){
    header("Location: /students");
    exit();
}

$row = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    if($_SESSION["user"]["role"] === "student"){
        $phone = trim($_POST["phone"]);
        $class = trim($_POST["class"]);
    }

    if($name == "" || $email == ""){
        $msg = "All fields are required.";
    } else {

        $name  = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);

        $check = "SELECT id FROM users WHERE email='$email' AND id != $id LIMIT 1";
        $check_result = mysqli_query($conn, $check);

        if(mysqli_num_rows($check_result) > 0){
            $msg = "Email already exists.";
        } else {

            $update1 = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
            mysqli_query($conn, $update1);

            if($_SESSION["user"]["role"] === "student"){
                $phone = mysqli_real_escape_string($conn, $phone);
                $class = mysqli_real_escape_string($conn, $class);
                $update2 = "UPDATE students SET phone='$phone', class='$class' WHERE stu_id=$id";
                mysqli_query($conn, $update2);
            }

            header("Location: /students");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard">

    <?php include('../includes/sidebar.php'); ?>

    <div class="main">

        <div class="topbar">
            <h2>Edit Student</h2>
            <a class="logout" href="/logout">Logout</a>
        </div>

        <div class="form-area">
            <div class="book-form-box">

                <h3>Update Student Details</h3>

                <?php if($msg != ""){ ?>
                    <p class="error"><?php echo $msg; ?></p>
                <?php } ?>

                <form method="POST">

                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>

                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

                    <?php if($_SESSION["user"]["role"] === "student"){ ?>

                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required>

                        <label>Class</label>
                        <input type="text" name="class" value="<?php echo $row['class']; ?>" required>

                    <?php } ?>

                    <div class="form-buttons">
                        <button type="submit" class="save-btn">Update</button>
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