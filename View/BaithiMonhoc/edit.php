<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        die("Bạn không có quyền truy cập trang này!");
    }
    $title = "Edit Chi tiết bài thi và Môn học";
    $content = './View/Content/BaithiMonhoc/edit.php';  
    include './View/Layout/layout.php';
?>