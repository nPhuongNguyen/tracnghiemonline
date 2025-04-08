<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = "Kết quả Bài Thi";
    $content = './View/Content/TracnghiemOnline/ketqua.php';  
    include './View/Layout/layoutcus.php';
?>