
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
    <h1 class="text-center fw-bold mb-5">
        <span class="text-primary">✨ Danh sách Câu hỏi & Đáp án ✨</span>
    </h1>

    <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="fw-bold m-0">
                <i class="bi bi-question-circle me-2"></i> Quản lý Câu hỏi & Đáp án
            </h5>
            <a href="?controller=Dapan&action=createForm" class="btn btn-light text-primary fw-bold shadow-sm">
                <i class="bi bi-plus-circle me-2"></i> Thêm Đáp án Mới
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>ID Câu hỏi</th>
                            <th>Câu hỏi</th>
                            <th>Đáp án</th>
                            <th>Trạng thái</th>
                            <th></th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($Dapans)): ?>
                            <?php foreach ($Dapans as $id_cauhoi => $cauhoiData): ?>
                                <!-- Câu hỏi -->
                                <tr class="table-info fw-bold">
                                    <td class="text-center"><?php echo htmlspecialchars($id_cauhoi); ?></td>
                                    <td colspan="4"><?php echo htmlspecialchars($cauhoiData['name_cauhoi']); ?></td>
                                    <td><a href="?controller=Dapan&action=editForm&id_cauhoi=<?php echo $id_cauhoi; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Chỉnh sửa
                                    </a></td>
                                </tr>
                               

                                <!-- Đáp án -->
                                <?php foreach ($cauhoiData['answers'] as $dapan): ?>
                                    <tr class="border-bottom">
                                        <td></td>
                                        <td></td>
                                        <td class="ps-4"><?php echo htmlspecialchars($dapan['name_dapan']); ?></td>
                                        <td class="text-center">
                                            <?php if ($dapan['dapan'] == 1): ?>
                                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold">
                                                    ✅ Đúng
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">
                                                    ❌ Sai
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td></td>
                                       
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-exclamation-circle text-danger fs-1"></i>
                                    <p class="text-danger fw-bold fs-5 mt-3 mb-0">Không có dữ liệu</p>
                                    <p class="text-muted">Vui lòng thêm câu hỏi và đáp án mới.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


