<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Thêm Đáp Án</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form method="post" action="?controller=Dapan&action=create">
            <div class="mb-3">
                <label class="form-label">Tên Câu hỏi:</label>
                <select name="id_cauhoi" class="form-control mb-3">
                    <?php foreach ($cauhois as $cauhoi): ?>
                        <option value="<?php echo $cauhoi->id_cauhoi; ?>">
                            <?php echo htmlspecialchars($cauhoi->name_cauhoi); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Đáp án <?php echo chr(65 + $i); ?>:</label>
                    <input type="text" name="answers[]" class="form-control" required>
                    <input type="radio" name="dapan" value="<?php echo $i; ?>" required> Đáp án đúng
                </div>
            <?php endfor; ?>

            <div class="text-center">
                <button type="submit" name="create" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle"></i> Thêm mới
                </button>
                <a href="?controller=Dapan&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
