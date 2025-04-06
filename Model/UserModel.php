<?php
Class UserModel{
    private $conn;
    private $table_name = "user";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllUsers() {
        $query = "SELECT u.userName, u.passWord, u.isDeleted, r.roleName 
        FROM ".$this->table_name." u 
        JOIN role r ON u.roleId = r.roleId";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function updateUser($userName, $password, $roleId, $isDeleted) {
        if (empty($password)) {
            // Nếu password rỗng, không cập nhật password
            $query = "UPDATE user SET roleId = :roleId, isDeleted = :isDeleted WHERE userName = :userName";
            $stmt = $this->conn->prepare($query);
        } else {
            // Nếu có nhập password, cập nhật luôn password
            $query = "UPDATE user SET password = :password, roleId = :roleId, isDeleted = :isDeleted WHERE userName = :userName";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        }
    
        $stmt->bindParam(":roleId", $roleId, PDO::PARAM_INT);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
    public function checkUserExists($taikhoan) {
        $sql = "SELECT * FROM User WHERE userName = :taikhoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":taikhoan", $taikhoan, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0; // PDO không có num_rows, dùng rowCount()
    }

    public function registerUser($userName, $passWord, $roleId) {
        $stmt = $this->conn->prepare("INSERT INTO user (userName, passWord, roleId) VALUES (:userName, :password, :roleId)");
        $stmt->bindValue(":userName", $userName, PDO::PARAM_STR);
        $stmt->bindValue(":password", $passWord, PDO::PARAM_STR);
        $stmt->bindValue(":roleId", $roleId, PDO::PARAM_INT);
    
        // Thực thi câu lệnh & kiểm tra kết quả
        return $stmt->execute(); 
    }
    
    
    
    public function softDeleteUser($userName) {
        $query = "UPDATE user SET isDeleted = 1 WHERE userName = :userName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        
        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
    
    public function getUserAverageScore($userName) {
        $query = "SELECT AVG(subject_avg.average_score) AS average_score
                  FROM (
                      SELECT m.name_monhoc, AVG(b.diem) AS average_score
                      FROM baithi_user b
                      JOIN baithitracnghiem bt ON b.id_baithi = bt.id_baithi
                      JOIN ct_baithi_monhoc ct ON bt.id_baithi = ct.id_baithi
                      JOIN monhoc m ON ct.id_monhoc = m.id_monhoc
                      WHERE b.userName = :userName
                      GROUP BY m.name_monhoc
                  ) AS subject_avg";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->average_score ?? 0; // Trả về 0 nếu không có điểm
    }
    public function getUserbyuserName($userName) {
        $query = "SELECT u.*, r.roleName, 
                        COALESCE((
                            SUM(CASE WHEN b.id_baithi = 2 THEN b.diem ELSE 0 END) +
                            SUM(CASE WHEN b.id_baithi = 3 THEN b.diem * 2 ELSE 0 END)
                        ) / 
                        (COUNT(CASE WHEN b.id_baithi IN (2,3) THEN 1 END) * 1.5), 0) AS diem_tb
                FROM ".$this->table_name." u
                JOIN role r ON u.roleId = r.roleId
                LEFT JOIN baithi_user b ON u.userName = b.userName
                WHERE u.userName = :userName
                GROUP BY u.userName";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);

    }
    public function getUserScoresBySubject($userName) {
        $query = "SELECT m.name_monhoc, AVG(b.diem) AS average_score
                  FROM baithi_user b
                  JOIN baithitracnghiem bt ON b.id_baithi = bt.id_baithi
                  JOIN ct_baithi_monhoc ct ON bt.id_baithi = ct.id_baithi
                  JOIN monhoc m ON ct.id_monhoc = m.id_monhoc
                  WHERE b.userName = :userName
                  GROUP BY m.name_monhoc";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Lấy danh sách điểm trung bình theo môn
    }
    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) AS total FROM user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalExams() {
        $sql = "SELECT COUNT(*) AS total FROM baithi_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalQuestions() {
        $sql = "SELECT COUNT(*) AS total FROM cauhoi";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalCompletedExams() {
        $sql = "SELECT COUNT(*) AS total FROM baithi_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    public function getUnattemptedExams($userName) {
        $query = "SELECT b.id_baithi, b.ten_baithi, m.name_monhoc
                  FROM baithitracnghiem b
                  JOIN ct_baithi_monhoc ct ON b.id_baithi = ct.id_baithi
                  JOIN monhoc m ON ct.id_monhoc = m.id_monhoc
                  LEFT JOIN baithi_user bu ON b.id_baithi = bu.id_baithi AND bu.userName = :userName
                  WHERE bu.id_baithi IS NULL"; // Chỉ lấy bài thi chưa làm
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Lấy tất cả bài thi chưa làm
    }
    
}
?>