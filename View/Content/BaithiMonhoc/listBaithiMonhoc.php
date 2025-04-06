
<div class="container py-5">
    <h1 class="text-center fw-bold mb-4 text-primary">✨ Danh sách Bài thi trắc nghiệm & Môn học ✨</h1>

    <div class="card border-0 shadow rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-clipboard-check me-2"></i>Quản lý Bài thi & Môn học</h5>
            <a href="?controller=Baithimonhoc&action=CreateForm" class="btn btn-light fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Thêm mới
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Tên Bài thi</th>
                            <th class="px-4 py-3">Tên Môn học</th>
                            <th class="px-4 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($BaithiMonhocs)): ?>
                            <?php foreach ($BaithiMonhocs as $baithimonhoc): ?>
                                <tr>
                                    <td class="px-4 py-3 text-primary fw-bold"><?php echo htmlspecialchars($baithimonhoc->ten_baithi); ?></td>
                                    <td class="px-4 py-3 text-secondary"><?php echo htmlspecialchars($baithimonhoc->name_monhoc); ?></td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="index.php?controller=Baithimonhoc&action=edit&id_baithi=<?php echo $baithimonhoc->id_baithi; ?>&id_monhoc=<?php echo $baithimonhoc->id_monhoc; ?>" 
                                           class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </a>
                                        <a href="?controller=baithitracnghiem&action=delete&id_baithi=<?php echo htmlspecialchars($baithimonhoc->id_baithi); ?>" 
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Bạn có chắc chắn muốn ẩn bài thi này?');">
                                            <i class="bi bi-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
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
