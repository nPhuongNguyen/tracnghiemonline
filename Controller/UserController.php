<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';
    require_once('./Model/UserModel.php');
    require_once('./Model/RoleModel.php');
    require_once('./Model/TracnghiemOnlineModel.php');

    class UserController{
        private $userModel;
        private $roleModel;
        private $db;
        public function __construct(){
            $this->db = (new Database())->getConnection();
            $this->userModel = new UserModel($this->db);
            $this->roleModel = new RoleModel($this->db);
        }
        public function home() {
            $total_users = $this->userModel->getTotalUsers();
            $total_exams = $this->userModel->getTotalExams();
            $total_questions = $this->userModel->getTotalQuestions();
            $total_completed_exams = $this->userModel->getTotalCompletedExams();

            include './View/User/home.php';
        }
        public function homeuser() {
            // Không cần kiểm tra cookie ở đây
            $userName = isset($_COOKIE['userName']) ? $_COOKIE['userName'] : 'Khách'; // Nếu không có cookie, đặt là 'Khách'
            
            $unattemptedExams = $this->userModel->getUnattemptedExams($userName); // Lấy danh sách bài thi chưa làm
        
            include './View/User/homeuser.php'; // Load view
        }
        public function index(){
            $users = $this->userModel->getAllUsers();
            include './View/User/list.php';
        }

        public function edit() {
            if (isset($_GET["userName"])) {
                $userName = $_GET["userName"];
                
                // Lấy thông tin user từ database
                $user = $this->userModel->getUserByUserName($userName);
                
                if (!$user) {
                    echo "Người dùng không tồn tại!";
                    return;
                }
                $roles = $this->roleModel->getAllRoles();
        
                include "./View/User/editUser.php"; // Load giao diện chỉnh sửa
            }
        }
        

        public function editUser(){
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUser"])) {
                $userName = $_POST["userName"];
                $password = $_POST["password"];
                $roleId = $_POST["roleId"];
                $isDeleted = isset($_POST["isDeleted"]) ? 1 : 0; 
                $currentUser = $this->userModel->getUserByUserName($userName);
                  // Nếu password để trống, giữ nguyên password cũ
                if (empty($password)) {
                    $password = $currentUser->password;
                } else {
                    // Nếu có nhập password mới, mã hóa trước khi lưu
                    $password = password_hash($password, PASSWORD_DEFAULT);
                }
                
                if ($this->userModel->updateUser($userName, $password, $roleId,$isDeleted)) {
                    header("Location: index.php?controller=User&action=index&message=success");
                    exit();
                } else {
                    $errorMessage = "Có lỗi xảy ra khi cập nhật!";
                    $roles = $this->roleModel->getAllRoles();
                    include "./View/User/editUser.php";
                }
            }
        }

        public function delete() {
            if (isset($_GET["userName"])) {
                $userName = $_GET["userName"];
        
                if ($this->userModel->softDeleteUser($userName)) {
                    // Chuyển hướng về index với thông báo thành công
                    header("Location: index.php?action=index&message=deleted");
                    exit();
                } else {
                    // Chuyển hướng về index với thông báo thất bại
                    header("Location: index.php?action=index&message=error");
                    exit();
                }
            }
        }

        public function logincheck() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['taikhoan']) && isset($_POST['matkhau'])) {
                    $taikhoan = $_POST['taikhoan'];
                    $matkhau = $_POST['matkhau'];
                    $remember = isset($_POST['remember']);
        
                    // Lấy thông tin user từ model
                    $user = $this->userModel->getUserByUserName($taikhoan);
        
                    if ($user && password_verify($matkhau, $user->passWord)) {
                        // Bắt đầu session và lưu thông tin user
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                            
                        }
                        
                        $_SESSION["userName"] = $user->userName;
                        $_SESSION["role"] = $user->roleName;
        
                        // Ghi nhớ đăng nhập nếu được chọn (lưu vào cookie)
                        if ($remember) {
                            setcookie("userName", $user->userName, time() + (86400 * 30), "/");
                            setcookie("role", $user->roleName, time() + (86400 * 30), "/");
                        }
        
                        if ($user->roleName == 'Admin') {
                            header("Location: index.php?controller=user&action=home");
                        } else {
                            header("Location: index.php?controller=user&action=homeuser");
                        }
                        exit();
                    } else {
                        header("Location: index.php?controller=user&action=login&error=1");
                        exit();
                    }
                } else {
                    header("Location: index.php?controller=user&action=login&error=2");
                    exit();
                }
            }
        }
        

        public function registercheck() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['taikhoan']) && !empty($_POST['matkhau'])) {
                    $taikhoan = trim($_POST['taikhoan']);
                    $matkhau = $_POST['matkhau'];
                    $roleId = 2; // Giả sử 2 là roleId cho customer
                    
                    // Mã hóa mật khẩu
                    $matkhau_ma_hoa = password_hash($matkhau, PASSWORD_DEFAULT);
        
                    if ($this->userModel->checkUserExists($taikhoan)) {
                        $_SESSION["error"] = "Tài khoản đã tồn tại!";
                        header("Location: index.php?controller=user&action=register");
                        exit();
                    }
        
                    // Tiến hành đăng ký
                    if ($this->userModel->registerUser($taikhoan, $matkhau_ma_hoa, $roleId)) {
                        $_SESSION["success"] = "Đăng ký thành công!";
                        header("Location: index.php?controller=user&action=login");
                        exit();
                    } else {
                        $_SESSION["error"] = "Có lỗi xảy ra trong quá trình đăng ký!";
                        header("Location: index.php?controller=user&action=register");
                        exit();
                    }
                } else {
                    $_SESSION["error"] = "Vui lòng điền đầy đủ thông tin!";
                    header("Location: index.php?controller=user&action=register");
                    exit();
                }
            }
        }
        
        

        public function login() {
            
            include "./View/User/login.php";
        }

        public function register() {
            $roles = $this->roleModel->getAllRoles();
            include "./View/User/register.php";
        }

        public function logout() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        
            // Xóa tất cả session
            $_SESSION = []; 
            session_unset();
            session_destroy(); 
        
            // Kiểm tra session đã xóa chưa
            if (empty($_SESSION)) {
                echo "Đã đăng xuất thành công!";
            }
        
            // Xóa cookie nếu có
            setcookie("role", "", time() - 3600, "/");
            setcookie("userName", "", time() - 3600, "/");
        
            // Chuyển hướng về trang home
            header("location: index.php?controller=user&action=Homeuser"); 
            exit(); 
        }
        
        public function profile() {
            if (!isset($_COOKIE['userName'])) {
                header("Location: index.php?controller=user&action=login");
                exit();
            }
        
            $userName = $_COOKIE['userName'];
            $user = $this->userModel->getUserbyuserName($userName);
            $averageScore = $this->userModel->getUserAverageScore($userName); // Lấy điểm trung bình tổng
            $subjectScores = $this->userModel->getUserScoresBySubject($userName); // Lấy điểm trung bình theo môn
        
            if (!$user) {
                echo "Người dùng không tồn tại!";
                return;
            }
        
            include "./View/User/profile.php"; // Layout chung
        }
        
        
        
    }
?>