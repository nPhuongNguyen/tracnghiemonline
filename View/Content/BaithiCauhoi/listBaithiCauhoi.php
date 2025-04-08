
<?php if (isset($_GET['message'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($_GET['message'] == 'success'): ?>
                Swal.fire({ title: "✅ Thành công!", text: "Cập nhật thành công!", icon: "success", timer: 3000, showConfirmButton: false });
            <?php elseif ($_GET['message'] == 'deleted'): ?>
                Swal.fire({ title: "🗑️ Đã ẩn!", text: "Người dùng đã được ẩn!", icon: "success", timer: 3000, showConfirmButton: false });
            <?php elseif ($_GET['message'] == 'error'): ?>
                Swal.fire({ title: "❌ Lỗi!", text: "Không thể ẩn người dùng!", icon: "error", timer: 3000, showConfirmButton: false });
            <?php endif; ?>
        });
    </script>
<?php endif; ?>

<div class="container py-5">
    <h1 class="text-center fw-bold mb-4 text-primary">✨ Danh sách Bài thi trắc nghiệm & Câu hỏi ✨</h1>

    <div class="card border-0 shadow rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-clipboard-check me-2"></i>Quản lý Bài thi & Câu hỏi</h5>
            <a href="?controller=BaithiCauhoi&action=CreateForm" class="btn btn-light fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Thêm mới
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Tên Bài thi</th>
                            <th class="px-4 py-3">Tên Câu hỏi</th>
                            <th class="px-4 py-3">Tên Môn học</th> <!-- Thêm cột mới -->
                            <th class="px-4 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($BaithiCauhois)): ?>
                            <?php foreach ($BaithiCauhois as $baithicauhoi): ?>
                                <tr>
                                    <td class="px-4 py-3 text-primary fw-bold"><?php echo htmlspecialchars($baithicauhoi->ten_baithi); ?></td>
                                    <td class="px-4 py-3 text-secondary"><?php echo htmlspecialchars($baithicauhoi->name_cauhoi); ?></td>
                                    <td class="px-4 py-3 text-success fw-bold"><?php echo htmlspecialchars($baithicauhoi->name_monhoc); ?></td> <!-- Hiển thị môn học -->
                                    <td class="px-4 py-3 text-center">
                                        <a href="index.php?controller=BaithiCauhoi&action=edit&id_baithi=<?php echo $baithicauhoi->id_baithi; ?>&id_cauhoi=<?php echo $baithicauhoi->id_cauhoi; ?>" 
                                           class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </a>
                                        <a href="?controller=baithitracnghiem&action=delete&id_baithi=<?php echo htmlspecialchars($baithicauhoi->id_baithi); ?>" 
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Bạn có chắc chắn muốn ẩn bài thi này?');">
                                            <i class="bi bi-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-exclamation-circle text-danger fs-1"></i>
                                    <p class="fw-bold mt-3">Không có bài thi nào</p>
                                    <p>Vui lòng thêm bài thi mới.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
