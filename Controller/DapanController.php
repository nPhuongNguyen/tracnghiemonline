<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/DapanModel.php');
    require_once('./Model/CauhoiModel.php');
    class DapanController{
        private $DapanModel;
        private $Cauhoimodel;
        private $db;
        public function __construct() {
            $this->db = (new Database())->getConnection();
            $this->DapanModel = new DapanModel($this->db);
            $this->Cauhoimodel = new CauhoiModel($this->db);
        }
    
        public function index() {
            $Dapans = $this->DapanModel->getAllDapans();
          
            include "./View/Dapan/list.php"; 
        }

        public function createForm() {
            $cauhois = $this->Cauhoimodel->getAllCauhois();
            include "./View/Dapan/createDapan.php"; 
        }
        
        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["id_cauhoi"]) && !empty($_POST["answers"])) {
                $id_cauhoi = intval($_POST["id_cauhoi"]);
                $answers = $_POST["answers"];
                $dapan = intval($_POST["dapan"]);
    
                if ($this->DapanModel->insertDapan($id_cauhoi, $answers, $dapan)) {
                    header("Location: ?controller=Dapan&action=index");
                    exit();
                }
            }
        }



        public function editForm() {
            $id_cauhoi = $_GET['id_cauhoi'] ?? null;
            if (!$id_cauhoi) {
                header("Location: ?controller=Dapan&action=index&message=error");
                exit;
            }
            $dapans = $this->DapanModel->getDapansByCauhoi($id_cauhoi);
            $cauhoi = $this->Cauhoimodel->getById($id_cauhoi);
        
            include './View/Dapan/editDapan.php';
        }

        public function update() {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["id_cauhoi"]) && !empty($_POST["answers"])) {
                $id_cauhoi = intval($_POST["id_cauhoi"]);
                $answers = $_POST["answers"];
                $dapan = intval($_POST["dapan"]); // ID đáp án đúng
        
                if ($this->DapanModel->updateDapan($id_cauhoi, $answers, $dapan)) {
                    header("Location: ?controller=Dapan&action=index&message=updated");
                    exit();
                } else {
                    header("Location: ?controller=Dapan&action=index&message=error");
                    exit();
                }
            }
        }
        
        

        public function delete() {
            if (!empty($_GET["id_Dapan"])) {  
                $id = intval($_GET["id_Dapan"]);
                if ($this->DapanModel->delete($id)) {
                    header("Location: index.php?controller=Dapan&action=index");
                    exit();
                }
            }
        }
        
    }
?>