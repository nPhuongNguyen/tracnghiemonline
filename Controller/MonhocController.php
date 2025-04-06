<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/MonhocModel.php');
    class MonhocController{
        private $MonhocModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->MonhocModel = new MonhocModel($this->db);
        }
    
        public function index() {
            $Monhocs = $this->MonhocModel->getAllMonhocs();
          
            include "./View/Monhoc/list.php"; 
        }

        public function createForm() {
            include "./View/Monhoc/createMonhoc.php"; 
        }
        
        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name_monhoc = $_POST["name_monhoc"] ?? "";
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0;
        
                if ($this->MonhocModel->create($name_monhoc,$isDeleted)) {
                    header("Location: index.php?controller=Monhoc&action=index");
                    exit();
                } else {
                    echo "Lỗi khi thêm bài thi!";
                }
            }
        }

        public function edit() {
            if (isset($_GET["id_monhoc"])) {
                $id_monhoc = $_GET["id_monhoc"];
                
                // Lấy thông tin user từ database
                $monhoc = $this->MonhocModel->getById($id_monhoc);
                
                if (!$monhoc) {
                    echo "Môn học không tồn tại!";
                    return;
                }  
                include "./View/Monhoc/editMonhoc.php"; // Load giao diện chỉnh sửa
            }
        }
        
        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["id_monhoc"]) && !empty($_POST["name_monhoc"])) {
                $id_monhoc = intval($_POST["id_monhoc"]);
                $name_monhoc = trim($_POST["name_monhoc"]);
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0; 
        
                if ($this->MonhocModel->update($id_monhoc, $name_monhoc, $isDeleted)) {
                    header("Location: index.php?controller=Monhoc&action=index");
                    exit();
                }
            }
        }

        public function delete() {
            if (!empty($_GET["id_monhoc"])) {  
                $id = intval($_GET["id_monhoc"]);
                if ($this->MonhocModel->delete($id)) {
                    header("Location: index.php?controller=Monhoc&action=index");
                    exit();
                }
            }
        }
        
    }
?>