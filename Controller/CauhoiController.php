<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/CauhoiModel.php');
    require_once('./Model/MonhocModel.php');
    class CauhoiController{
        private $CauhoiModel;
        private $MonhocModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->CauhoiModel = new CauhoiModel($this->db);
            $this->MonhocModel = new MonhocModel($this->db);
        }
    
        public function index() {
            $Cauhois = $this->CauhoiModel->getAllCauhois();
          
            include "./View/Cauhoi/list.php"; 
        }

        public function createForm() {
            $monhocs = $this->MonhocModel->getAllMonhocs();
            include "./View/Cauhoi/createCauhoi.php"; 
        }
        
        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name_cauhoi = $_POST["name_cauhoi"] ?? "";
                $id_monhoc = $_POST["id_monhoc"] ?? "";
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0;
        
                if ($this->CauhoiModel->create($name_cauhoi,$id_monhoc,$isDeleted)) {
                    header("Location: index.php?controller=Cauhoi&action=index");
                    exit();
                } else {
                    echo "Lỗi khi thêm bài thi!";
                }
            }
        }

        public function edit() {
            if (isset($_GET["id_cauhoi"])) {
                $id_cauhoi = $_GET["id_cauhoi"];
                
                // Lấy thông tin user từ database
                $Cauhoi = $this->CauhoiModel->getById($id_cauhoi);
                $monhocs = $this->MonhocModel->getAllMonhocs();
                
                if (!$Cauhoi) {
                    echo "Môn học không tồn tại!";
                    return;
                }  
                include "./View/Cauhoi/editCauhoi.php"; // Load giao diện chỉnh sửa
            }
        }
        
        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["id_cauhoi"]) && !empty($_POST["name_cauhoi"])&& !empty($_POST["id_monhoc"])) {
                $id_cauhoi = intval($_POST["id_cauhoi"]);
                $name_cauhoi = trim($_POST["name_cauhoi"]);
                $id_monhoc = intval($_POST["id_monhoc"]);
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0; 
        
                if ($this->CauhoiModel->update($id_cauhoi, $name_cauhoi,$id_monhoc, $isDeleted)) {
                    header("Location: index.php?controller=Cauhoi&action=index");
                    exit();
                }
            }
        }

        public function delete() {
            if (!empty($_GET["id_cauhoi"])) {  
                $id = intval($_GET["id_cauhoi"]);
                if ($this->CauhoiModel->delete($id)) {
                    header("Location: index.php?controller=Cauhoi&action=index");
                    exit();
                }
            }
        }
        
    }
?>