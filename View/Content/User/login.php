<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
    });
</script>

<div class="container">
    <h2 class="text-center text-primary mt-4">Trang Đăng Nhập</h2>
    <?php if (isset($_SESSION["error"])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION["error"]; ?>
        </div>
        <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>
    <form action="index.php?controller=user&action=logincheck" method="post" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label for="taikhoan" class="form-label">Tài khoản:</label>
            <input type="text" class="form-control" placeholder="Nhập tài khoản" name="taikhoan" required>
        </div>
        <div class="mb-3">
            <label for="matkhau" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control"  placeholder="Nhập mật khẩu" name="matkhau" required>
        </div>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Ghi nhớ đăng nhập</label><br>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
    </form>
    <div class="mt-3 text-center">
        <p>Chưa có tài khoản? <a href="?controller=user&action=register" class="btn btn-link">Đăng ký ngay</a></p>
    </div>
</div>