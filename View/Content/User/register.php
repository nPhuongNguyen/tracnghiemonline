<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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
                        <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Đăng Ký</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Hiển thị thông báo lỗi hoặc thành công -->
                        <?php if (isset($_SESSION["error"])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION["error"]; ?>
                            </div>
                            <?php unset($_SESSION["error"]); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION["success"])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION["success"]; ?>
                            </div>
                            <?php unset($_SESSION["success"]); ?>
                        <?php endif; ?>

                        <form action="index.php?controller=user&action=registercheck" method="post">
                            <div class="mb-3">
                                <label for="taikhoan" class="form-label">Tài khoản:</label>
                                <input type="text" class="form-control" name="taikhoan" placeholder="Nhập tên tài khoản" required>
                            </div>
                            <div class="mb-3">
                                <label for="matkhau" class="form-label">Mật khẩu:</label>
                                <input type="password" class="form-control" name="matkhau" placeholder="Nhập mật khẩu" required>
                            </div>

                            <?php if (isset($_COOKIE['userName']) && isset($_COOKIE['role'])): ?>
                                <?php if ($_COOKIE['role'] === 'Admin'): ?>
                                    <div class="mb-3">
                                        <label for="roleId" class="form-label">Quyền:</label>
                                        <select name="roleId" class="form-select" required>
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?php echo $role->roleId; ?>">
                                                    <?php echo htmlspecialchars($role->roleName); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <button type="submit" class="btn" style="background-color: rgb(45, 178, 198); color: white; width: 100%;">Đăng ký</button>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <p class="mb-0">Đã có tài khoản? <a href="?controller=user&action=login" class="btn btn-link">Đăng nhập ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>