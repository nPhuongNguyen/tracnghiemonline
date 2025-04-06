
<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Create Role</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
    <form method="post" action="?controller=Monhoc&action=create">
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên Môn học:</label>
                <input type="text" name="name_monhoc" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="isDeleted" id="isDeleted">
                    <label class="form-check-label" for="isDeleted">Vô hiệu hóa Môn học</label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="create" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle"></i> Thêm mới
                </button>
                <a href="?controller=Monhoc&action=index" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
