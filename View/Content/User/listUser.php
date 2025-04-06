
<?php if (isset($_GET['message']) && $_GET['message'] == 'success'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "✅ Thành công!",
                text: "Cập nhật người dùng thành công!",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['message'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($_GET['message'] == 'deleted'): ?>
                Swal.fire({
                    title: "🗑️ Đã ẩn!",
                    text: "Người dùng đã được ẩn khỏi danh sách!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php elseif ($_GET['message'] == 'error'): ?>
                Swal.fire({
                    title: "❌ Lỗi!",
                    text: "Không thể ẩn người dùng!",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php endif; ?>
        });
    </script>
<?php endif; ?>


<div class="container py-5">
    <h1 class="text-center fw-bold mb-5 position-relative">
        <span class="text-primary">✨ Danh sách Người Dùng ✨</span>
    </h1>

    <div class="card border-0 shadow rounded-3 overflow-hidden">
        <div class="card-header border-0 py-3 bg-primary text-white">
            <div class="row align-items-center px-3">
                <div class="col">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>Quản lý tài khoản
                    </h5>
                </div>
              
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 fw-bold">Người dùng</th>
                            <th class="px-4 py-3 fw-bold">Quyền</th>
                            <th class="px-4 py-3 fw-bold">Trạng thái</th>
                            <th class="px-4 py-3 fw-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="bi bi-person-circle fs-4 text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-primary"><?php echo htmlspecialchars($user->userName); ?></h6>
                                                <?php if (isset($user->email)): ?>
                                                    <small class="text-muted"><?php echo htmlspecialchars($user->email); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-primary rounded-pill p-2 px-3 fs-6 fw-bold">
                                            <i class="bi bi-shield-lock me-1"></i>
                                            <?php echo htmlspecialchars($user->roleName); ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if ($user->isDeleted == 1): ?>
                                            <span class="badge bg-danger rounded-pill p-2 px-3 fs-6 fw-bold">
                                                <i class="bi bi-x-circle me-1"></i>Ẩn
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success rounded-pill p-2 px-3 fs-6 fw-bold">
                                                <i class="bi bi-check-circle me-1"></i>Hiển thị
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                    <a href="?controller=user&action=edit&userName=<?php echo urlencode($user->userName); ?>" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil me-1"></i> Sửa
                                    </a>

                                    <a href="?controller=user&action=delete&userName=<?php echo htmlspecialchars($user->userName); ?>" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Bạn có chắc chắn muốn ẩn người dùng này?');">
                                        <i class="bi bi-trash me-1"></i> Xóa
                                    </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-exclamation-circle text-danger fs-1"></i>
                                        <p class="text-danger fw-bold fs-5 mt-3 mb-0">Không có người dùng nào</p>
                                        <p class="text-muted">Vui lòng thêm người dùng mới</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>