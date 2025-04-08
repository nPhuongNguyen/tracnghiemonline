<?php    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        die("Bạn không có quyền truy cập trang này!");
    }
    $title = "Trang Chủ Môn học";
    $content = './View/Content/Monhoc/listMonhoc.php';  
    include './View/Layout/layout.php';
?>