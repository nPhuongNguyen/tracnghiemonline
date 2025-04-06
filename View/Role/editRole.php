<?php    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        die("Bạn không có quyền truy cập trang này!");
    }
    $title = "Edit Role";
    $content = './View/Content/Role/editRole.php';  
    include './View/Layout/layout.php';
?>
