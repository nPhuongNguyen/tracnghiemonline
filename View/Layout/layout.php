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
    <title><?php echo isset($title) ? $title : 'Trắc nghiệm Online - Admin Dashboard'; ?></title>     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
    <style>
        :root {
            --primary: #3b7ddd;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-width: 250px;
            --sidebar-bg: #222e3c;
            --sidebar-color: #e9ecef;
            --topbar-bg: #ffffff;
            --topbar-color: #495057;
            --card-border-radius: 0.5rem;
        }
        
        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f7fb;
            color: #495057;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 100;
            padding: 0;
            box-shadow: 0 0 2rem 0 rgba(0, 0, 0, .05);
            background: var(--sidebar-bg);
            transition: all 0.3s ease-in-out;
        }
        
        .sidebar-header {
            background: rgba(0, 0, 0, .1);
            padding: 1.5rem 1.5rem;
            font-size: 1.2rem;
            color: #fff;
        }
        
        .sidebar-logo {
            font-weight: 600;
            color: #fff;
            font-size: 1.25rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar-logo:hover {
            color: #fff;
        }
        
        .sidebar-logo i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }
        
        .sidebar-nav {
            padding: 0;
            list-style: none;
            margin: 1rem 0;
        }
        
        .sidebar-item {
            position: relative;
        }
        
        .sidebar-link {
            padding: 0.75rem 1.5rem;
            color: rgba(233, 236, 239, 0.5);
            position: relative;
            display: block;
            font-size: 0.9rem;
            font-weight: 400;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }
        
        .sidebar-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            vertical-align: middle;
            width: 1.5rem;
            text-align: center;
        }
        
        .sidebar-link:hover,
        .sidebar-link.active {
            color: rgba(233, 236, 239, 1);
            background: rgba(255, 255, 255, 0.075);
        }
        
        .sidebar-dropdown .sidebar-link {
            padding-left: 3rem;
            color: rgba(233, 236, 239, 0.4);
        }
        
        .sidebar-dropdown .sidebar-link:hover {
            color: rgba(233, 236, 239, 0.75);
        }
        
        /* Navbar Styles */
        .navbar {
            height: 70px;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background: #fff;
            box-shadow: 0 0 2rem 0 rgba(0, 0, 0, .05);
        }
        
        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .navbar-expand {
            margin-right: 1rem;
        }
        
        .navbar-expand i {
            font-size: 1.5rem;
            color: #6c757d;
            cursor: pointer;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            margin-right: 1rem;
        }
        
        .navbar .dropdown-toggle::after {
            display: none;
        }
        
        .navbar .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
            padding: 0.75rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .navbar .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }
        
        .navbar .dropdown-item:hover {
            background-color: rgba(59, 125, 221, 0.1);
            color: var(--primary);
        }
        
        .navbar-nav .nav-link {
            color: var(--topbar-color);
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #3b7ddd;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0;
        }
        
        .user-role {
            color: #6c757d;
            font-size: 0.75rem;
            margin-bottom: 0;
        }
        
        /* Main Content Styles */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            transition: all 0.3s ease-in-out;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        
        .content {
            padding: 1.5rem;
        }
        
        .page-title {
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        
        /* Card Styles */
        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: var(--card-border-radius);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header h5 {
            margin-bottom: 0;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Table Styles */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 500;
            border-top: 0;
            background-color: #f8f9fa;
        }
        
        .table-action {
            white-space: nowrap;
        }
        
        .table-action a {
            color: #6c757d;
            margin-right: 0.5rem;
            text-decoration: none;
        }
        
        .table-action .edit {
            color: var(--primary);
        }
        
        .table-action .delete {
            color: var(--danger);
        }
        
        /* Button Styles */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.15s ease-in-out;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #2d6dc1;
            border-color: #2a67b8;
        }
        
        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .btn-info {
            background-color: var(--info);
            border-color: var(--info);
            color: #fff;
        }
        
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: #fff;
        }
        
        /* Form Styles */
        .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(59, 125, 221, 0.25);
            border-color: #8aabdf;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        /* Footer Styles */
        footer {
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease-in-out;
        }
        
        footer p {
            margin-bottom: 0;
            text-align: center;
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }
            
            .sidebar.toggled {
                left: 0;
            }
            
            .main, footer {
                margin-left: 0;
            }
            
            .main.toggled, footer.toggled {
                margin-left: var(--sidebar-width);
            }
        }
        
        /* Special Elements */
        .stat-widget {
            background-color: #fff;
            border-radius: var(--card-border-radius);
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .stat-widget-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        
        .stat-widget-info h3 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.5rem;
        }
        
        .stat-widget-info p {
            color: #6c757d;
            margin-bottom: 0;
            font-size: 0.875rem;
        }
        
        /* Alert Styling */
        .alert {
            border-radius: var(--card-border-radius);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        }
        
        /* Override Sweetalert styles */
        .swal2-popup {
            font-size: 0.9rem;
            border-radius: var(--card-border-radius);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .swal2-styled.swal2-confirm {
            background-color: var(--primary);
        }
        
        .dropdown-toggle::after {
            display: none;
        }
        
        /* Sidebar toggle for mobile */
        .sidebar-toggle {
            display: none;
        }
        
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head> 
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="<?php 
                if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'Admin') {
                    echo 'http://localhost/PHP_BaoCao/index.php?controller=user&action=Home';
                } else {
                    echo 'http://localhost/PHP_BaoCao/index.php?controller=user&action=homeuser';
                }
            ?>" class="sidebar-logo">
                <i class="fas fa-book-reader"></i>
                <span>Trắc nghiệm Online</span>
            </a>
        </div>

        <ul class="sidebar-nav">
            <?php if (isset($_COOKIE['userName']) && isset($_COOKIE['role']) && $_COOKIE['role'] === 'Admin'): ?>
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=user&action=Home" class="sidebar-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/php_baocao/index.php?controller=user&action=index" class="sidebar-link">
                        <i class="fas fa-users"></i>
                        <span>Quản lý User</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=role&action=index" class="sidebar-link">
                        <i class="fas fa-user-tag"></i>
                        <span>Role</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=Dapan&action=index" class="sidebar-link">
                        <i class="fas fa-check-circle"></i>
                        <span>Đáp án</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=cauhoi&action=index" class="sidebar-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Câu hỏi</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=baithicauhoi&action=index" class="sidebar-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Bài thi Câu hỏi</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="http://localhost/PHP_BaoCao/index.php?controller=baithimonhoc&action=index" class="sidebar-link">
                        <i class="fas fa-book"></i>
                        <span>Bài thi môn học</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <li class="sidebar-header">
                Danh mục môn học
            </li>
            
            <?php foreach ($subjects as $subject): ?>
                <li class="sidebar-item">
                    <a href="index.php?controller=TracnghiemOnline&action=listbaithi&id_monhoc=<?php echo $subject['id_monhoc']; ?>" class="sidebar-link">
                        <i class="fas fa-graduation-cap"></i>
                        <span><?php echo $subject['name_monhoc']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main">
        <!-- Top Navigation -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-content">
                    <div class="d-flex">
                        <button class="btn sidebar-toggle" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ol class="breadcrumb mb-0 ms-3">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo isset($title) ? $title : 'Dashboard'; ?></li>
                        </ol>
                    </div>
                    
                    <div class="dropdown">
                        <?php if (isset($_COOKIE['userName']) && isset($_COOKIE['role'])): ?>
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar">
                                    <?php echo substr($_COOKIE['userName'], 0, 1); ?>
                                </div>
                                <div>
                                    <p class="user-name"><?php echo $_COOKIE['userName']; ?></p>
                                    <p class="user-role"><?php echo $_COOKIE['role']; ?></p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="index.php?controller=user&action=profile"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?controller=user&action=logout"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                            </ul>
                        <?php else: ?>
                            <div class="d-flex">
                                <a href="/PHP_BaoCao/index.php?controller=user&action=login" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                                </a>
                                <a href="http://localhost/PHP_BaoCao/index.php?controller=user&action=register" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i> Đăng ký
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="content">
            <?php include $content; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container-fluid">
            <p>&copy; 2025 .Hello World. | Hệ thống trắc nghiệm trực tuyến</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const main = document.querySelector('.main');
            const footer = document.querySelector('footer');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('toggled');
                    main.classList.toggle('toggled');
                    footer.classList.toggle('toggled');
                });
            }
            
            // Set active menu item
            const currentLocation = window.location.href;
            const menuItems = document.querySelectorAll('.sidebar-link');
            menuItems.forEach(item => {
                if (currentLocation.includes(item.getAttribute('href'))) {
                    item.classList.add('active');
                }
            });
            
            // Check for flash messages
            const flashMessage = "<?php echo isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : ''; ?>";
            const flashType = "<?php echo isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : ''; ?>";
            
            if (flashMessage) {
                Swal.fire({
                    title: flashType === 'error' ? 'Lỗi!' : 'Thành công!',
                    text: flashMessage,
                    icon: flashType === 'error' ? 'error' : 'success',
                    confirmButtonColor: '#3b7ddd',
                    timer: 3000
                });
                
                // Clear the flash message after displaying
                <?php 
                if(isset($_SESSION['flash_message'])) {
                    echo "delete_flash_messages();";
                }
                ?>
            }
            
            function delete_flash_messages() {
                <?php
                if(isset($_SESSION['flash_message'])) {
                    echo "delete _SESSION['flash_message'];";
                }
                if(isset($_SESSION['flash_type'])) {
                    echo "delete _SESSION['flash_type'];";
                }
                ?>
            }
        });
    </script>
</body> 
</html>