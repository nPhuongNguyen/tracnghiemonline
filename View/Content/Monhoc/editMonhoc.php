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


<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Chỉnh sửa Môn học</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form method="post" action="?controller=Monhoc&action=update">
            <input type="hidden" name="id_monhoc" value="<?php echo htmlspecialchars($monhoc->id_monhoc); ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold">Tên môn học:</label>
                <input type="text" name="name_monhoc" class="form-control" value="<?php echo htmlspecialchars($monhoc->name_monhoc); ?>" required>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted"
                        <?php echo $monhoc->isDeleted ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa Môn học</label>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" name="update" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="?controller=Monhoc&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>