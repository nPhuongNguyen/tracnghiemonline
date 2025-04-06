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
    
    
    public function getUserbyuserName($userName) {
        $query = "SELECT u.*, r.roleName 
        FROM ".$this->table_name." u 
        JOIN role r ON u.roleId = r.roleId 
        WHERE u.userName = :userName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
      
}
?>