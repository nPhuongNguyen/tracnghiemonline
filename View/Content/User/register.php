<div class="container">
    <h2 class="text-center text-primary mt-4">Trang Đăng Ký</h2>

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
    <form action="index.php?controller=user&action=registercheck" method="post" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label for="taikhoan" class="form-label">Tài khoản:</label>
            <input type="text" class="form-control" name="taikhoan" required>
        </div>
        <div class="mb-3">
            <label for="matkhau" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" name="matkhau" required>
        </div>
        

        


        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
    </form>
    <div class="mt-3 text-center">
        <p>Đã có tài khoản? <a href="?controller=user&action=login" class="btn btn-link">Đăng nhập ngay</a></p>
    </div>
</div>