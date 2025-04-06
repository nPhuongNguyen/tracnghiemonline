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


<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Chỉnh sửa Câu hỏi</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form method="post" action="?controller=Cauhoi&action=update">
            <input type="hidden" name="id_cauhoi" value="<?php echo htmlspecialchars($Cauhoi->id_cauhoi); ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold">Tên câu hỏi:</label>
                <input type="text" name="name_cauhoi" class="form-control" value="<?php echo htmlspecialchars($Cauhoi->name_cauhoi); ?>" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Môn học:</label>
                <select name="id_monhoc" class="form-control mb-3">
                    <?php foreach ($monhocs as $monhoc): ?>
                        <option value="<?php echo $monhoc->id_monhoc; ?>" 
                            <?php echo ($monhoc->id_monhoc == $Cauhoi->id_monhoc) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($monhoc->name_monhoc); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted"
                        <?php echo $Cauhoi->isDeleted ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa câu hỏi</label>
                </div>
            </div>
           
            <div class="text-center">
                <button type="submit" name="update" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="?controller=Cauhoi&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>