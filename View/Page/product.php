<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Kiểm tra nếu có dữ liệu
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Tên: " . $row["ten"] . " - Giá: " . $row["gia"] . "<br>";
        echo "<td><img src='" . $row["anh"] . "' width='100' height='100'></td>";
    }
} else {
    echo "Không có sản phẩm nào.";
}
?>