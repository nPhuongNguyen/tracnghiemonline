<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/BaithiMonhocModel.php');
    require_once('./Model/BaithitracnghiemModel.php');
    require_once('./Model/MonhocModel.php');
    class BaithiMonhocController{
        private $BaithiMonhocModel;
        private $BaithitracnghiemModel;
        private $monhocModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->BaithiMonhocModel = new BaithiMonhocModel($this->db);
            $this->BaithitracnghiemModel = new BaithitracnghiemModel($this->db);    
            $this->monhocModel = new monhocModel($this->db);

        }
    
        public function index() {
            $BaithiMonhocs = $this->BaithiMonhocModel->getAllBaithiMonhocs();
          
            include "./View/BaithiMonhoc/list.php"; 
        }

        public function edit() {
            if (!isset($_GET['id_baithi']) || !isset($_GET['id_monhoc'])) {
                die("Thiếu thông tin bài thi hoặc câu hỏi!");
            }
        
            $id_baithi = intval($_GET['id_baithi']);
            $id_monhoc = intval($_GET['id_monhoc']);
        
            // Lấy thông tin bài thi - câu hỏi
            $BaithiMonhoc = $this->BaithiMonhocModel->getById($id_baithi, $id_monhoc);
            if (!$BaithiMonhoc) {
                die("Không tìm thấy dữ liệu bài thi hoặc câu hỏi!");
            }
        
            // Lấy danh sách bài thi
            $Baithitracnghiems = $this->BaithitracnghiemModel->getAllBaithitracnghiems();
        
            // Lấy danh sách câu hỏi chưa có trong bài thi (lọc sẵn)
            $monhocs = $this->BaithiMonhocModel->getAvailableQuestions($id_baithi);
        
            // Đảm bảo câu hỏi đang chọn cũng có trong danh sách
            $selectedmonhoc = $this->monhocModel->getById($id_monhoc);
            if ($selectedmonhoc) {
                array_unshift($monhocs, $selectedmonhoc); // Thêm vào đầu danh sách
            }
        
            include "./View/BaithiMonhoc/edit.php";
        }
        

        public function CreateForm(){   
            $Baithitracnghiems = $this->BaithitracnghiemModel->getAllBaithitracnghiems();
            $monhocs = $this->monhocModel->getAllmonhocs();
            include "./View/BaithiMonhoc/create.php";

        }
        public function Create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_baithi = $_POST['id_baithi'];
                $id_monhoc = $_POST['id_monhoc'];
                if (!isset($id_baithi) || !isset($id_monhoc)) {
                    echo "Lỗi: Thiếu dữ liệu!";
                    return;
                }
    
                if ($id_baithi && $id_monhoc) {
                    $result = $this->BaithiMonhocModel->Create($id_baithi, $id_monhoc);
    
                    if ($result === true) {
                        header("Location: index.php?controller=BaithiMonhoc&action=index");
                        exit();
                    } elseif ($result === "Dữ liệu đã tồn tại!") {
                        echo "Lỗi: Bài thi đã có câu hỏi này!";
                    } else {
                        echo "Thêm thất bại!";
                    }
                } else {
                    echo "Dữ liệu không hợp lệ!";
                }
            }
        }

        public function getAvailableQuestions() {
            if (isset($_GET['id_baithi'])) {
                $id_baithi = intval($_GET['id_baithi']); // Chuyển đổi thành số nguyên
                $questions = $this->BaithiMonhocModel->getAvailableQuestions($id_baithi);
                
                echo json_encode($questions); // Trả về JSON để dùng với Ajax
            }
        }

        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_baithi = $_POST['id_baithi'] ?? null;
                $old_id_monhoc = $_POST['old_id_monhoc'] ?? null;
                $new_id_monhoc = $_POST['id_monhoc'] ?? null;
        
                if ($id_baithi && $old_id_monhoc && $new_id_monhoc) {
                    $result = $this->BaithiMonhocModel->Update($id_baithi, $old_id_monhoc, $new_id_monhoc);
        
                    if ($result) {
                        header("Location: index.php?controller=BaithiMonhoc&action=index");
                        exit();
                    } else {
                        header("Location: index.php?controller=BaithiMonhoc&action=index&");
                        exit();
                    }
                } else {
                    header("Location: index.php?controller=BaithiMonhoc&action=index");
                    exit();
                }
            }
        }
        
        
        
    }
?>