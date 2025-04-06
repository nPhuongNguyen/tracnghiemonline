<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/BaithiCauhoiModel.php');
    require_once('./Model/BaithitracnghiemModel.php');
    require_once('./Model/CauhoiModel.php');
    require_once('./Model/TracnghiemOnlineModel.php');
    require_once('./Model/MonhocModel.php');
    require_once('./Model/BaithiMonhocModel.php');
    class TracnghiemOnlineController{
        private $TracnghiemOnlneModel;
        private $BaithiMonhocModel;
        private $BaithiCauhoiModel;
        private $BaithitracnghiemModel;
        private $CauhoiModel;
        private $MonhocModel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->TracnghiemOnlneModel = new TracnghiemOnlineModel($this->db); 
            $this->BaithiCauhoiModel = new BaithiCauhoiModel($this->db);
            $this->BaithitracnghiemModel = new BaithitracnghiemModel($this->db);    
            $this->CauhoiModel = new CauhoiModel($this->db);
            $this->MonhocModel = new MonhocModel($this->db);
            $this->BaithiMonhocModel = new BaithiMonhocModel($this->db);

        }
        public function listbaithi(){
            if (!isset($_GET['id_monhoc']) || empty($_GET['id_monhoc'])) {
                die("Lỗi: id_monhoc không hợp lệ!"); 
            }
        
            $id_monhoc = intval($_GET['id_monhoc']); 
        
            $listbaithi = $this->TracnghiemOnlneModel->listbaithi($id_monhoc);
            
            include './View/TracnghiemOnline/listbaithi.php';
        }

        public function baithibymonhoc(){
            if (!isset($_GET['id_monhoc']) || empty($_GET['id_monhoc']) || 
                !isset($_GET['id_baithi']) || empty($_GET['id_baithi'])) {
                die("Lỗi: id_monhoc hoặc id_baithi không hợp lệ!"); 
            }
        
            $id_monhoc = intval($_GET['id_monhoc']); 
            $id_baithi = intval($_GET['id_baithi']);  
        
            $BaithiCauhois = $this->TracnghiemOnlneModel->kiemtra($id_baithi, $id_monhoc);
        
            include './View/TracnghiemOnline/baithibymonhoc.php';
        }

        public function nopbai() {
            $id_nguoidung = $_COOKIE['userName'] ?? null;
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_nguoidung) {
                $id_baithi = $_POST['id_baithi'];
                $thoigian_batdau = $_SESSION['thoigian_batdau'];
                // Lấy danh sách câu hỏi từ input hidden `cauhoi[]`
                $answers = [];
                foreach ($_POST['cauhoi'] as $id_cauhoi) {
                    if (isset($_POST["cauhoi_$id_cauhoi"])) {
                        $answers[$id_cauhoi] = $_POST["cauhoi_$id_cauhoi"];
                    } else {
                        $answers[$id_cauhoi] = null; // Câu hỏi chưa trả lời
                    }
                }
        
                $id_lambai = $this->TracnghiemOnlneModel->saveBaiLam($id_nguoidung, $id_baithi, $answers,$thoigian_batdau);
                header("Location: index.php?controller=TracNghiemOnline&action=ketqua&id_lambai=$id_lambai");
                exit;
            }
        }
        

        public function ketqua($id_lambai = null) {
            if ($id_lambai === null) {
                $id_lambai = $_GET['id_lambai'] ?? null;
            }
        
            if (!$id_lambai) {
                die("Lỗi: Không tìm thấy ID bài làm.");
            }
            $ketqua = $this->TracnghiemOnlneModel->getKetQua($id_lambai);
            require_once './View/TracnghiemOnline/ketqua.php';
        }
        
        public function Home(){
            include "./View/TracnghiemOnline/Home.php";
        }
        
        
    }
?>