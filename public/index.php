<?php
require_once('../app/config/config.php');

// Logout
if($_SERVER['REQUEST_URI'] == '/logout'){
    include('../auth/logout.php');
    exit();
}

// Not logged in
if(!isset($_SESSION["user"])){
    if($_SERVER['REQUEST_URI'] == '/register'){
        include('../auth/register.php');
    } else {
        include('../auth/login.php');
    }
    exit();
}

$role = $_SESSION["user"]["role"];
$url = explode('?', $_SERVER['REQUEST_URI'])[0];
// Admin 
if($role === 'admin'){
    switch($url){
        case '/adashboard':
            include('../admin/admin_dashboard.php');
        break;
        case '/books':
            include('../books/book_list.php');
            break;
        // Admin routes
        case '/add_book':
            include('../books/book_add.php');
            break;
        case '/book_save':
            include('../books/book_save.php');
            break;
        case '/book_delete':
            include('../books/book_delete.php');
            break;
        case '/students':
            include('../student/student.php');
            break;
        case '/edit_student':
            include('../student/editstudent.php');
            break;
        case '/change_password':
            include('../student/studentedit.php');
            break;
        case '/delete_student':
            include('../student/student_delete.php');
            break;
        case '/issues':
            include('../issues/i.php');
            break;
        case '/return_book':
            include('../issues/return_book.php');
            break;
        case '/add_users':
            include('../addusers/add_users.php');
            break;
        default:
            header('Location: /adashboard');
        break;
    }
        exit();
}
if($role === 'student'){
    switch($url){
        case '/dashboard':
            include('../student_dashboard/student_dashboard.php');
        break;
        case '/books':
            include('../books/book_list.php');
            break;
        case '/is':
            include('../issues/is.php');
            break;
        case '/due_book':
            include('../books/due_book.php');
            break;
        case '/return':
            include('../issues/return.php');
            break;
    default:
            header('Location: /dashboard');
        break;
}
    exit();
}

// Unknown role fallback
session_destroy();
header('Location: /');
exit();