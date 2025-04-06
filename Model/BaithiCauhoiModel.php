<?php
Class BaithiCauhoiModel{
    private $conn;
    private $table_name = "ct_baithi_cauhoi";
    public function __construct($db){
        $this->conn = $db;
    }

    public function getAllBaithiCauhois() {
        $query = "SELECT bc.id_baithi, b.ten_baithi, 
                         bc.id_cauhoi, c.name_cauhoi, 
                         m.id_monhoc, m.name_monhoc
                  FROM " . $this->table_name . " bc
                  JOIN baithitracnghiem b ON bc.id_baithi = b.id_baithi
                  JOIN cauhoi c ON bc.id_cauhoi = c.id_cauhoi
                  JOIN monhoc m ON c.id_monhoc = m.id_monhoc 
                  ORDER BY bc.id_baithi, bc.id_cauhoi";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    

    public function Create($id_baithi, $id_cauhoi) {
        // Kiểm tra xem cặp id_baithi và id_cauhoi đã tồn tại chưa
        $checkQuery = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE id_baithi = :id_baithi AND id_cauhoi = :id_cauhoi";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmtCheck->bindParam(':id_cauhoi', $id_cauhoi, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        $count = $stmtCheck->fetchColumn(); 
    
        if ($count > 0) {
            return "Dữ liệu đã tồn tại!"; 
        }
    
        // Nếu không trùng, tiến hành chèn dữ liệu
        $query = "INSERT INTO " . $this->table_name . " (id_baithi, id_cauhoi) VALUES (:id_baithi, :id_cauhoi)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':id_cauhoi', $id_cauhoi, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true; 
        }
    
        return false; 
    }

    public function getAvailableQuestions($id_baithi) {
        $query = "SELECT c.id_cauhoi, c.name_cauhoi, m.name_monhoc 
        FROM cauhoi c 
        JOIN monhoc m ON c.id_monhoc = m.id_monhoc
        WHERE c.id_cauhoi NOT IN (
            SELECT bc.id_cauhoi FROM " . $this->table_name . " bc WHERE bc.id_baithi = :id_baithi
        )";

        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Update($id_baithi, $old_id_cauhoi, $new_id_cauhoi) {
        // Kiểm tra xem câu hỏi mới có bị trùng không
        $checkQuery = "SELECT COUNT(*) FROM " . $this->table_name . " 
                       WHERE id_baithi = :id_baithi AND id_cauhoi = :new_id_cauhoi";
        
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':new_id_cauhoi', $new_id_cauhoi, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Bị trùng
        }
    
        // Nếu không trùng, tiến hành cập nhật
        $query = "UPDATE " . $this->table_name . " 
                  SET id_cauhoi = :new_id_cauhoi 
                  WHERE id_baithi = :id_baithi AND id_cauhoi = :old_id_cauhoi";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
        $stmt->bindParam(':old_id_cauhoi', $old_id_cauhoi, PDO::PARAM_INT);
        $stmt->bindParam(':new_id_cauhoi', $new_id_cauhoi, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    public function getById($id_baithi, $id_cauhoi) {
        try {
            $query = "SELECT bc.id_baithi, 
                             b.ten_baithi, 
                             bc.id_cauhoi, 
                             c.name_cauhoi, 
                             m.name_monhoc 
                      FROM " . $this->table_name . " bc
                      JOIN baithitracnghiem b ON bc.id_baithi = b.id_baithi
                      JOIN cauhoi c ON bc.id_cauhoi = c.id_cauhoi
                      JOIN monhoc m ON c.id_monhoc = m.id_monhoc 
                      WHERE bc.id_baithi = :id_baithi AND bc.id_cauhoi = :id_cauhoi";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_baithi', $id_baithi, PDO::PARAM_INT);
            $stmt->bindParam(':id_cauhoi', $id_cauhoi, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$result) {
                echo "Không tìm thấy dữ liệu!";
            }
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
        }
    }
    
    
    
    
      
}
?>