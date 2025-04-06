
<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Create Role</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
        <form action="index.php?controller=baithitracnghiem&action=create" method="POST">
            <div class="mb-3">
                <label for="ten_baithi" class="form-label">Tên bài thi</label>
                <input type="text" class="form-control" id="ten_baithi" name="ten_baithi" required>
            </div>

            <div class="mb-3">
                <label for="mota_baithi" class="form-label">Mô tả</label>
                <textarea class="form-control" id="mota_baithi" name="mota_baithi"></textarea>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted">
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa bài thi</label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="create" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle"></i> Thêm mới
                </button>
                <a href="?controller=Baithitracnghiem&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>

    </div>
</div>
