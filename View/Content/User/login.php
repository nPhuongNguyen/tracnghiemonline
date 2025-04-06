<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Thêm thư viện SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card shadow">
                    <div class="card-header" style="background-color: rgb(45, 178, 198); color: white; text-align: center; padding: 1rem;">
                        <h4 class="mb-0"><i class="bi bi-person-lock me-2"></i>Đăng Nhập</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="index.php?controller=user&action=logincheck" method="post">
                            <!-- Tài khoản -->
                            <div class="mb-3">
                                <label for="taikhoan" class="form-label">Tài khoản</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" id="taikhoan" name="taikhoan" placeholder="Nhập tài khoản" required autofocus>
                                </div>
                            </div>
                            
                            <!-- Mật khẩu -->
                            <div class="mb-3">
                                <label for="matkhau" class="form-label">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="matkhau" name="matkhau" placeholder="Nhập mật khẩu" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="eye-icon"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Ghi nhớ đăng nhập -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                            
                            <!-- Nút đăng nhập -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn" style="background-color: rgb(45, 178, 198); color: white;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                                </button>
                            </div>
                            
                            <!-- Đường kẻ phân cách -->
                            <hr class="my-4">
                            
                            <!-- Liên kết đăng ký -->
                            <div class="text-center">
                                <p class="mb-0">Chưa có tài khoản? 
                                    <a href="?controller=user&action=register" class="text-decoration-none">Đăng ký ngay</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Xử lý lỗi từ URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has("error")) {
                let errorMessage = "Lỗi không xác định!";
                
                switch (urlParams.get("error")) {
                    case "1":
                        errorMessage = "❌ Tài khoản hoặc mật khẩu không chính xác!";
                        break;
                    case "2":
                        errorMessage = "❌ Vui lòng nhập đầy đủ thông tin!";
                        break;
                }
                
                Swal.fire({
                    icon: "error",
                    title: "Đăng nhập thất bại",
                    text: errorMessage,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Thử lại"
                });
            }
            
            // Xử lý hiển thị/ẩn mật khẩu
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('matkhau');
            const eyeIcon = document.getElementById('eye-icon');
            
            togglePassword.addEventListener('click', function () {
                // Thay đổi kiểu input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Chuyển đổi biểu tượng
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>