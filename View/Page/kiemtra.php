<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';

function getMonHocById($id_monhoc) {
    global $conn;
    $sql = "SELECT name_monhoc FROM mohoc WHERE id_monhoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_monhoc);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getBaiThiByMonHoc($id_monhoc) {
    global $conn;
    $sql = "
        SELECT bt.id_baithi, bt.ten_baithi,ctb.id_monhoc 
        FROM baithitracnghiem bt
        INNER JOIN ct_baithi_monhoc ctb ON bt.id_baithi = ctb.id_baithi
        WHERE ctb.id_monhoc = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_monhoc);
    $stmt->execute();
    $result = $stmt->get_result();

    $baiThiList = [];
    while ($row = $result->fetch_assoc()) {
        $baiThiList[] = $row;
    }

    return $baiThiList;
}
?>


<?php
    $title = "Kiểm tra";
    $content = '../Content/kiemtra_content.php';  
    include '../Layout/layout.php';
?>