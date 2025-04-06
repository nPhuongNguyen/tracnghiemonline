<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/BaithiCauhoiModel.php');
    require_once('./Model/BaithitracnghiemModel.php');
    require_once('./Model/CauhoiModel.php');
    class BaithiCauhoiController{
        private $BaithiCauhoiModel;
        private $BaithitracnghiemModel;
        private $CauhoiModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->BaithiCauhoiModel = new BaithiCauhoiModel($this->db);
            $this->BaithitracnghiemModel = new BaithitracnghiemModel($this->db);    
            $this->CauhoiModel = new CauhoiModel($this->db);

        }
    
        public function index() {
            $BaithiCauhois = $this->BaithiCauhoiModel->getAllBaithiCauhois();
          
            include "./View/BaithiCauhoi/list.php"; 
        }

        public function edit() {
            if (!isset($_GET['id_baithi']) || !isset($_GET['id_cauhoi'])) {
                die("Thiếu thông tin bài thi hoặc câu hỏi!");
            }
        
            $id_baithi = intval($_GET['id_baithi']);
            $id_cauhoi = intval($_GET['id_cauhoi']);
        
            // Lấy thông tin bài thi - câu hỏi
            $baithicauhoi = $this->BaithiCauhoiModel->getById($id_baithi, $id_cauhoi);
            if (!$baithicauhoi) {
                die("Không tìm thấy dữ liệu bài thi hoặc câu hỏi!");
            }
        
            // Lấy danh sách bài thi
            $Baithitracnghiems = $this->BaithitracnghiemModel->getAllBaithitracnghiems();
        
            // Lấy danh sách câu hỏi chưa có trong bài thi (lọc sẵn)
            $Cauhois = $this->BaithiCauhoiModel->getAvailableQuestions($id_baithi);
        
            // Đảm bảo câu hỏi đang chọn cũng có trong danh sách
            $selectedCauhoi = $this->CauhoiModel->getById($id_cauhoi);
            if ($selectedCauhoi) {
                array_unshift($Cauhois, $selectedCauhoi); // Thêm vào đầu danh sách
            }
        
            include "./View/BaithiCauhoi/edit.php";
        }
        

        public function CreateForm(){   
            $Baithitracnghiems = $this->BaithitracnghiemModel->getAllBaithitracnghiems();
            $Cauhois = $this->CauhoiModel->getAllCauhois();
            include "./View/BaithiCauhoi/create.php";

        }
        public function Create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_baithi = $_POST['id_baithi'];
                $id_cauhoi = $_POST['id_cauhoi'];
                if (!isset($id_baithi) || !isset($id_cauhoi)) {
                    echo "Lỗi: Thiếu dữ liệu!";
                    return;
                }
    
                if ($id_baithi && $id_cauhoi) {
                    $result = $this->BaithiCauhoiModel->Create($id_baithi, $id_cauhoi);
    
                    if ($result === true) {
                        header("Location: index.php?controller=BaithiCauhoi&action=index");
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
                $questions = $this->BaithiCauhoiModel->getAvailableQuestions($id_baithi);
                
                echo json_encode($questions); // Trả về JSON để dùng với Ajax
            }
        }

        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_baithi = $_POST['id_baithi'] ?? null;
                $old_id_cauhoi = $_POST['old_id_cauhoi'] ?? null;
                $new_id_cauhoi = $_POST['id_cauhoi'] ?? null;
        
                if ($id_baithi && $old_id_cauhoi && $new_id_cauhoi) {
                    $result = $this->BaithiCauhoiModel->Update($id_baithi, $old_id_cauhoi, $new_id_cauhoi);
        
                    if ($result) {
                        header("Location: index.php?controller=BaithiCauhoi&action=index");
                        exit();
                    } else {
                        header("Location: index.php?controller=BaithiCauhoi&action=index&");
                        exit();
                    }
                } else {
                    header("Location: index.php?controller=BaithiCauhoi&action=index");
                    exit();
                }
            }
        }
        
        
        
    }
?>