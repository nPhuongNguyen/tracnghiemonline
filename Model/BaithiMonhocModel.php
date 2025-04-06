<?php
Class BaithiMonhocModel{
    private $conn;
    private $table_name = "ct_baithi_monhoc";
    public function __construct($db){
        $this->conn = $db;
    }

    public function getAllBaithiMonhocs() {
        $query = "SELECT bc.id_baithi, b.ten_baithi, bc.id_monhoc, c.name_monhoc
                  FROM " . $this->table_name . " bc
                  JOIN baithitracnghiem b ON bc.id_baithi = b.id_baithi
                  JOIN monhoc c ON bc.id_monhoc = c.id_monhoc
                  ORDER BY bc.id_baithi, bc.id_monhoc";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Create($id_baithi, $id_monhoc) {
        // Kiểm tra xem cặp id_baithi và id_monhoc đã tồn tại chưa
        $checkQuery = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE id_baithi = :id_baithi AND id_monhoc = :id_monhoc";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmtCheck->bindParam(':id_monhoc', $id_monhoc, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        $count = $stmtCheck->fetchColumn(); 
    
        if ($count > 0) {
            return "Dữ liệu đã tồn tại!"; 
        }
    
        // Nếu không trùng, tiến hành chèn dữ liệu
        $query = "INSERT INTO " . $this->table_name . " (id_baithi, id_monhoc) VALUES (:id_baithi, :id_monhoc)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':id_monhoc', $id_monhoc, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true; 
        }
    
        return false; 
    }

    public function getAvailableQuestions($id_baithi) {
        $query = "SELECT c.id_monhoc, c.name_monhoc 
                  FROM monhoc c 
                  WHERE c.id_monhoc NOT IN (
                      SELECT bc.id_monhoc FROM " . $this->table_name . " bc WHERE bc.id_baithi = :id_baithi
                  )";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Update($id_baithi, $old_id_monhoc, $new_id_monhoc) {
        // Kiểm tra xem câu hỏi mới có bị trùng không
        $checkQuery = "SELECT COUNT(*) FROM " . $this->table_name . " 
                       WHERE id_baithi = :id_baithi AND id_monhoc = :new_id_monhoc";
        
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':new_id_monhoc', $new_id_monhoc, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Bị trùng
        }
    
        // Nếu không trùng, tiến hành cập nhật
        $query = "UPDATE " . $this->table_name . " 
                  SET id_monhoc = :new_id_monhoc 
                  WHERE id_baithi = :id_baithi AND id_monhoc = :old_id_monhoc";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':old_id_monhoc', $old_id_monhoc, PDO::PARAM_INT);
        $stmt->bindParam(':new_id_monhoc', $new_id_monhoc, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    public function getById($id_baithi, $id_monhoc) {
        $query = "SELECT bc.id_baithi, b.ten_baithi, bc.id_monhoc, c.name_monhoc
                  FROM " . $this->table_name . " bc
                  JOIN baithitracnghiem b ON bc.id_baithi = b.id_baithi
                  JOIN monhoc c ON bc.id_monhoc = c.id_monhoc
                  WHERE bc.id_baithi = :id_baithi AND bc.id_monhoc = :id_monhoc";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':id_monhoc', $id_monhoc, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    
    
      
}
?>