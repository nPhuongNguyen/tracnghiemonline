<?php if (isset($errorMessage)): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "❌ Lỗi!",
                text: "<?php echo $errorMessage; ?>",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
<?php endif; ?>


<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Chỉnh sửa Role</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form method="post" action="?controller=Role&action=update">
            <input type="hidden" name="roleId" value="<?php echo htmlspecialchars($role->roleId); ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold">Tên đăng nhập:</label>
                <input type="text" name="roleName" class="form-control" value="<?php echo htmlspecialchars($role->roleName); ?>" required>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted"
                        <?php echo $role->isDeleted ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa Role</label>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" name="update" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="?action=list" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>