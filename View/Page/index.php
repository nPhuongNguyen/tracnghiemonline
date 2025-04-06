<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['userName'])) {
    echo "Xin chào " . $_SESSION['userName'] . " với vai trò: " . $_SESSION['role'];
} else {
    echo "Chưa có vai trò người dùng!";
}
?>
