<?php
Class DapanModel{
    private $conn;
    private $table_name = "dapan";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllDapans() {
        $query = "SELECT d.id_dapan, d.name_dapan, d.dapan, d.isDeleted, c.id_cauhoi, c.name_cauhoi
                  FROM " . $this->table_name . " d
                  JOIN cauhoi c ON d.id_cauhoi = c.id_cauhoi
                  ORDER BY c.id_cauhoi, d.id_dapan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $rawData = $stmt->fetchAll(PDO::FETCH_OBJ); 
    
        // Nhóm dữ liệu theo id_cauhoi
        $groupedData = [];
        foreach ($rawData as $row) {
            $groupedData[$row->id_cauhoi]['name_cauhoi'] = $row->name_cauhoi;
            $groupedData[$row->id_cauhoi]['answers'][] = [
                'id_dapan' => $row->id_dapan,
                'name_dapan' => $row->name_dapan,
                'dapan' => $row->dapan,
                'isDeleted' => $row->isDeleted
            ];
        }
        
        return $groupedData;
    }
    

    public function getDapansByCauhoi($id_cauhoi) {
        $query = "SELECT id_dapan, name_dapan, dapan FROM " . $this->table_name . " WHERE id_cauhoi = :id_cauhoi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cauhoi", $id_cauhoi, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertDapan($id_cauhoi, $answers, $dapan) {
        $query = "INSERT INTO " . $this->table_name . " (id_cauhoi, name_dapan, dapan) VALUES (:id_cauhoi, :name_dapan, :dapan)";
        $stmt = $this->conn->prepare($query);

        foreach ($answers as $index => $answer) {
            $isCorrect = ($index == $dapan) ? 1 : 0;
            $label = chr(65 + $index);
            $answerWithLabel = $label . ". " . $answer;
            $stmt->bindParam(":id_cauhoi", $id_cauhoi, PDO::PARAM_INT);
            $stmt->bindParam(":name_dapan", $answerWithLabel, PDO::PARAM_STR);
            $stmt->bindParam(":dapan", $isCorrect, PDO::PARAM_INT);
            $stmt->execute();
        }
        return true;
    }

    public function updateDapan($id_cauhoi, $answers, $dapan) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name_dapan = :name_dapan, dapan = :dapan 
                  WHERE id_dapan = :id_dapan AND id_cauhoi = :id_cauhoi";
        $stmt = $this->conn->prepare($query);
    
        foreach ($answers as $id_dapan => $answer) {
            $isCorrect = ($id_dapan == $dapan) ? 1 : 0;
            $stmt->bindParam(":id_cauhoi", $id_cauhoi, PDO::PARAM_INT);
            $stmt->bindParam(":id_dapan", $id_dapan, PDO::PARAM_INT);
            $stmt->bindParam(":name_dapan", $answer, PDO::PARAM_STR);
            $stmt->bindParam(":dapan", $isCorrect, PDO::PARAM_INT);
            $stmt->execute();
        }
        return true;
    }
    
    
    
    public function update($id_Dapan, $name_Dapan,$id_monhoc, $isDeleted) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name_Dapan = :name_Dapan,id_monhoc =:id_monhoc ,isDeleted = :isDeleted 
                  WHERE id_Dapan = :id_Dapan";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name_Dapan", $name_Dapan, PDO::PARAM_STR);
        $stmt->bindParam(":id_monhoc", $id_monhoc, PDO::PARAM_INT);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        $stmt->bindParam(":id_Dapan", $id_Dapan, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = 1 WHERE id_Dapan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>