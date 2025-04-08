<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = "List Bài Thi";
    $content = './View/Content/TracnghiemOnline/listbaithi.php';  
    include './View/Layout/layoutcus.php';
?>