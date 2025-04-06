<?php
Class MonhocModel{
    private $conn;
    private $table_name = "monhoc";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllMonhocs() {
        $query = "SELECT *
        FROM ".$this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getById($id_monhoc) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_monhoc = :id_monhoc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_monhoc", $id_monhoc, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($name_monhoc,$isDeleted) {
        $query = "INSERT INTO " . $this->table_name . " (name_monhoc,isDeleted) 
                  VALUES (:name_monhoc,:isDeleted)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name_monhoc", $name_monhoc);
        $stmt->bindParam(":isDeleted", $isDeleted);
    
        return $stmt->execute();
    }
    
    
    public function update($id_monhoc, $name_monhoc, $isDeleted) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name_monhoc = :name_monhoc, isDeleted = :isDeleted 
                  WHERE id_monhoc = :id_monhoc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name_monhoc", $name_monhoc, PDO::PARAM_STR);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        $stmt->bindParam(":id_monhoc", $id_monhoc, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = 1 WHERE id_monhoc = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>