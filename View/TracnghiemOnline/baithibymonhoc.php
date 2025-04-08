<?php
    session_start();
    if (!isset($_SESSION['userName'])) {
        header("Location: index.php?controller=user&action=login");
        exit();
    }
    

    $title = "Bài Thi";
    $content = './View/Content/TracnghiemOnline/baithibymonhoc.php';  
    include './View/Layout/layoutcus.php';
?>