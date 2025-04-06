<?php
Class BaithitracnghiemModel{
    private $conn;
    private $table_name = "baithitracnghiem";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllbaithitracnghiems() {
        $query = "SELECT *
        FROM ".$this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getById($id_baithi) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_baithi = :id_baithi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_baithi", $id_baithi, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($ten_baithi, $mota_baithi, $ngaytaobaithi, $isDeleted) {
        $query = "INSERT INTO " . $this->table_name . " (ten_baithi, mota_baithi, ngaytaobaithi,isDeleted) 
                  VALUES (:ten_baithi, :mota_baithi, :ngaytaobaithi,:isDeleted)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":ten_baithi", $ten_baithi);
        $stmt->bindParam(":mota_baithi", $mota_baithi);
        $stmt->bindParam(":ngaytaobaithi", $ngaytaobaithi);
        $stmt->bindParam(":isDeleted", $isDeleted);
    
        return $stmt->execute();
    }
    
    
    public function update($id_baithi, $ten_baithi,$mota_baithi,$ngaysuabaithi, $isDeleted) {
        $query = "UPDATE " . $this->table_name . " 
                  SET ten_baithi = :ten_baithi,mota_baithi=:mota_baithi,ngaytaobaithi=:ngaysuabaithi, isDeleted = :isDeleted 
                  WHERE id_baithi = :id_baithi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ten_baithi", $ten_baithi, PDO::PARAM_STR);
        $stmt->bindParam(":mota_baithi", $mota_baithi, PDO::PARAM_STR);
        $stmt->bindParam(":ngaysuabaithi", $ngaysuabaithi, PDO::PARAM_STR);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        $stmt->bindParam(":id_baithi", $id_baithi, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = 1 WHERE id_baithi = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>