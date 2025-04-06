<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/UserModel.php');
    require_once('./Model/RoleModel.php');
    class RoleController {
        private $roleModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->roleModel = new RoleModel($this->db);
        }
    
        public function index() {
            $roles = $this->roleModel->getAllRoles();
            include "./View/Role/list.php"; 
        }
    
        public function edit() {
            if (isset($_GET["roleId"])) {
                $roleId = $_GET["roleId"];
                
                // Lấy thông tin user từ database
                $role = $this->roleModel->getById($roleId);
                
                if (!$role) {
                    echo "Role không tồn tại!";
                    return;
                }  
                include "./View/Role/editRole.php"; // Load giao diện chỉnh sửa
            }
        }

        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["roleName"])) {
                $roleName = trim($_POST["roleName"]);
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0;
        
                if ($this->roleModel->create($roleName, $isDeleted)) {
                    header("Location: index.php?controller=role&action=index");
                    exit();
                }
            }
        }

        public function createForm() {
            include "./View/Role/createRole.php";
        }
        
        
    
        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["roleId"]) && !empty($_POST["roleName"])) {
                $id = intval($_POST["roleId"]);
                $roleName = trim($_POST["roleName"]);
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0; 
        
                if ($this->roleModel->update($id, $roleName, $isDeleted)) {
                    header("Location: index.php?controller=role&action=index");
                    exit();
                }
            }
        }
        
    
        public function delete() {
            if (!empty($_GET["id"])) {  
                $id = intval($_GET["id"]);
                if ($this->roleModel->delete($id)) {
                    header("Location: index.php?controller=role&action=index");
                    exit();
                }
            }
        }
        
    }
?>