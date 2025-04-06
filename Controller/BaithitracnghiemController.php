<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/BaithitracnghiemModel.php');
    class BaithitracnghiemController{
        private $baithitracnghiemModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->baithitracnghiemModel = new BaithitracnghiemModel($this->db);
        }
    
        public function index() {
            $baithitracnghiems = $this->baithitracnghiemModel->getAllbaithitracnghiems();
          
            include "./View/Baithitracnghiem/list.php"; 
        }

        public function createForm() {
            include "./View/Baithitracnghiem/create.php"; 
        }
        
        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ten_baithi = $_POST["ten_baithi"] ?? "";
                $mota_baithi = $_POST["mota_baithi"] ?? "";
                $ngaytaobaithi = date("Y-m-d");
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0;
        
                if ($this->baithitracnghiemModel->create($ten_baithi, $mota_baithi, $ngaytaobaithi,$isDeleted)) {
                    header("Location: index.php?controller=baithitracnghiem&action=index");
                    exit();
                } else {
                    echo "Lỗi khi thêm bài thi!";
                }
            }
        }

        public function edit() {
            if (isset($_GET["id_baithi"])) {
                $id_baithi = $_GET["id_baithi"];
                
                // Lấy thông tin user từ database
                $baithi = $this->baithitracnghiemModel->getById($id_baithi);
                
                if (!$baithi) {
                    echo "Bài thi không tồn tại!";
                    return;
                }  
                include "./View/Baithitracnghiem/editBaithitacnghiem.php"; // Load giao diện chỉnh sửa
            }
        }
        
        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["id_baithi"]) && !empty($_POST["ten_baithi"])&& !empty($_POST["mota_baithi"])) {
                $id_baithi = intval($_POST["id_baithi"]);
                $ten_baithi = trim($_POST["ten_baithi"]);
                $mota_baithi = trim($_POST["mota_baithi"]);
                $ngaysuabaithi = date("Y-m-d");
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0; 
        
                if ($this->baithitracnghiemModel->update($id_baithi, $ten_baithi,$mota_baithi,$ngaysuabaithi, $isDeleted)) {
                    header("Location: index.php?controller=Baithitracnghiem&action=index");
                    exit();
                }
            }
        }

        public function delete() {
            if (!empty($_GET["id_baithi"])) {  
                $id = intval($_GET["id_baithi"]);
                if ($this->baithitracnghiemModel->delete($id)) {
                    header("Location: index.php?controller=Baithitracnghiem&action=index");
                    exit();
                }
            }
        }
        
    }
?>