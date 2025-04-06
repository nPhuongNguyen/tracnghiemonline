<?php
Class RoleModel{
    private $conn;
    private $table_name = "role";
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAllroles() {
        $query = "SELECT *
        FROM ".$this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getById($roleId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE roleId = :roleId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roleId", $roleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($roleName, $isDeleted) {
        $query = "INSERT INTO " . $this->table_name . " (roleName, isDeleted) VALUES (:roleName, :isDeleted)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roleName", $roleName, PDO::PARAM_STR);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function update($id, $roleName, $isDeleted) {
        $query = "UPDATE " . $this->table_name . " 
                  SET roleName = :roleName, isDeleted = :isDeleted 
                  WHERE roleId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roleName", $roleName, PDO::PARAM_STR);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_INT); // Thêm tham số mới
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = 1 WHERE roleId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>