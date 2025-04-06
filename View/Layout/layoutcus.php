<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_BaoCao/Connect/Connect.php';

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM monhoc";
$result = $conn->query($query);
$subjects = $result->fetchAll(PDO::FETCH_ASSOC); 
?>
<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title><?php echo isset($title) ? $title : 'Trắc nghiệm Online'; ?></title>     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
   
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fe;
        }
        
        /* Wrapper chính để đảm bảo footer ở dưới cùng */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1 0 auto; /* Cho phép nội dung mở rộng */
            padding: 20px 0;
        }
        
        footer {
            background-color: rgb(45, 178, 198);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            flex-shrink: 0; /* Ngăn footer co lại */
            width: 100%;
            margin-top: auto; /* Đẩy footer xuống dưới cùng */
        }
        
        footer p {
            color: #f1f1f1;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 0;
        }
        
        /* Đảm bảo sweetalert không ảnh hưởng đến layout */
        .swal2-container {
            position: fixed;
            z-index: 9999;
        }

        /* Thêm style mới cho danh sách bài thi */
        .page-header {
            background: linear-gradient(120deg, rgb(45, 178, 198) 0%, rgb(21, 130, 146) 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 5px 20px rgba(45, 178, 198, 0.2);
        }
        .page-title {
            color: white;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(45, 178, 198, 0.15);
        }
        .card-header {
            position: relative;
            padding: 20px;
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 4px;
            width: 100%;
            background: linear-gradient(to right, rgb(45, 178, 198), rgb(21, 130, 146));
        }
        .subject-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(45, 178, 198, 0.1);
            color: rgb(45, 178, 198);
            font-size: 1.5rem;
            margin-right: 15px;
        }
        .exam-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 30px;
        }
        .btn-take-exam {
            background: linear-gradient(120deg, rgb(45, 178, 198) 0%, rgb(21, 130, 146) 100%);
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-take-exam:hover {
            box-shadow: 0 5px 15px rgba(45, 178, 198, 0.3);
            transform: translateY(-2px);
        }
        .empty-state {
            background-color: white;
            border-radius: 16px;
            padding: 50px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .empty-icon {
            font-size: 60px;
            color: #d1d1d1;
            margin-bottom: 20px;
        }
    </style>
</head> 
<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(45, 178, 198)">
            <div class="container">
            <a class="navbar-brand" href="<?php 
                if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'Admin') {
                    echo 'http://localhost/PHP_BaoCao/index.php?controller=user&action=Home';
                } else {
                    echo 'http://localhost/PHP_BaoCao/index.php?controller=user&action=homeuser';
                }
            ?>">
                Trắc nghiệm Online
            </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Nhóm menu chính nằm gần logo -->
                    <ul class="navbar-nav me-auto">
                       
                        <!-- Hiển thị môn học cho tất cả người dùng -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Môn học
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php foreach ($subjects as $subject): ?>
                                    <li>
                                        <a class="dropdown-item" href="index.php?controller=TracnghiemOnline&action=listbaithi&id_monhoc=<?php echo $subject['id_monhoc']; ?>">
                                            <?php echo $subject['name_monhoc']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>


                    <!-- Nhóm tài khoản nằm bên phải -->
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_COOKIE['userName']) && isset($_COOKIE['role'])): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="index.php?controller=user&action=profile">
                                    Xin chào, <?php echo $_COOKIE['userName']; ?> (<?php echo $_COOKIE['role']; ?>)
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="index.php?controller=user&action=logout">Đăng xuất</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/PHP_BaoCao/index.php?controller=user&action=login">Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="http://localhost/PHP_BaoCao/index.php?controller=user&action=register">Đăng ký</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>


    </header>
    
    <main class="container">
        <?php include $content; ?>
    </main>
    
    <footer>
        <p>&copy; 2025 .Hello World.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 có thể được thêm vào đây nếu cần -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body> 
</html>