
<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Create Câu hỏi</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form action="index.php?controller=cauhoi&action=create" method="POST">
            <div class="mb-3">
                <label for="name_cauhoi" class="form-label">Tên câu hỏi</label>
                <input type="text" class="form-control" id="name_cauhoi" name="name_cauhoi" required>
            </div>

            <div class="mb-3">
                <label for="id_monhoc" class="form-label">Môn học:</label>
                <select name="id_monhoc" class="form-control mb-3">
                    <?php foreach ($monhocs as $monhoc): ?>
                        <option value="<?php echo $monhoc->id_monhoc; ?>">
                            <?php echo htmlspecialchars($monhoc->name_monhoc); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted">
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa câu hỏi</label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="create" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle"></i> Thêm mới
                </button>
                <a href="?controller=Cauhoi&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>

    </div>
</div>
