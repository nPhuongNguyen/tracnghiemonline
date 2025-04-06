<?php
Class CauhoiModel{
    private $conn;
    private $table_name = "cauhoi";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllCauhois() {
        $query = "SELECT c.id_cauhoi, c.name_cauhoi, c.isDeleted, m.name_monhoc
        FROM " .$this->table_name. " c
        JOIN monhoc m ON c.id_monhoc = m.id_monhoc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getById($id_cauhoi) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cauhoi = :id_cauhoi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cauhoi", $id_cauhoi, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($name_cauhoi,$id_monhoc,$isDeleted) {
        $query = "INSERT INTO " . $this->table_name . " (name_cauhoi,id_monhoc,isDeleted) 
                  VALUES (:name_cauhoi,:id_monhoc,:isDeleted)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name_cauhoi", $name_cauhoi);
        $stmt->bindParam(":id_monhoc", $id_monhoc);
        $stmt->bindParam(":isDeleted", $isDeleted);
    
        return $stmt->execute();
    }
    
    
    public function update($id_cauhoi, $name_cauhoi,$id_monhoc, $isDeleted) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name_cauhoi = :name_cauhoi,id_monhoc =:id_monhoc ,isDeleted = :isDeleted 
                  WHERE id_cauhoi = :id_cauhoi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name_cauhoi", $name_cauhoi, PDO::PARAM_STR);
        $stmt->bindParam(":id_monhoc", $id_monhoc, PDO::PARAM_INT);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        $stmt->bindParam(":id_cauhoi", $id_cauhoi, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = 1 WHERE id_cauhoi = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>