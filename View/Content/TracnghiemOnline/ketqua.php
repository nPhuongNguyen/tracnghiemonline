<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <!-- Card Chính -->
      <div class="card shadow-lg border-0 rounded-3 mb-4">
        <!-- Header với gradient -->
        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
          <div class="d-flex align-items-center">
            <div class="bg-white rounded-circle p-2 me-3">
              <i class="bi bi-file-earmark-check text-primary" style="font-size: 1.5rem;"></i>
            </div>
            <h2 class="m-0 fw-bold">Kết Quả Bài Thi</h2>
          </div>
        </div>
        
        <!-- Thông tin chính -->
        <div class="card-body p-4">
          <!-- Thẻ thông tin -->
          <div class="card bg-light border-0 mb-4">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h3 class="h4 mb-3 text-primary"><?= htmlspecialchars($ketqua->ten_baithi ?? 'Không xác định') ?></h3>
                  <p class="mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>Thí sinh:</strong> <?= htmlspecialchars($ketqua->userName ?? 'Không xác định') ?>
                  </p>
                  <p class="mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    <strong>Ngày thi:</strong> <?= date('d/m/Y') ?>
                  </p>
                  <p class="mb-0">
                    <i class="bi bi-clock me-2"></i>
                    <strong>Thời gian làm bài:</strong> 
                    <?php
                      
                      // Lấy số giây và định dạng
                      $seconds = $ketqua->thoigianlambai; // Lấy số giây từ kết quả
                      $formattedTime = sprintf("%02d:%02d:%02d", 
                          floor($seconds / 3600), 
                          floor(($seconds % 3600) / 60), 
                          $seconds % 60
                      );
                      echo htmlspecialchars($formattedTime);
                    ?>
                  </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                  <div class="d-inline-block p-3 rounded-3 shadow-sm text-center" 
                       style="background: <?= ($ketqua->diem ?? 0) >= 5 ? 'linear-gradient(135deg, #20c997, #198754)' : 'linear-gradient(135deg, #dc3545, #b02a37)' ?>;">
                    <h5 class="text-white mb-1">Điểm số của bạn</h5>
                    <h2 class="display-5 fw-bold text-white mb-0"><?= htmlspecialchars($ketqua->diem ?? '0') ?>/10</h2>
                    <p class="text-white opacity-75 mb-0">
                      <?= ($ketqua->diem ?? 0) >= 5 ? 'Đạt' : 'Chưa đạt' ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Bảng chi tiết kết quả -->
          <h4 class="mb-3">Chi tiết kết quả</h4>
          <div class="table-responsive">
            <table class="table table-hover table-striped border">
              <thead class="table-dark">
                <tr class="text-center">
                  <th width="5%" class="py-3">STT</th>
                  <th width="40%" class="py-3">Câu Hỏi</th>
                  <th width="20%" class="py-3">Đáp Án Của Bạn</th>
                  <th width="20%" class="py-3">Đáp Án Đúng</th>
                  <th width="15%" class="py-3">Kết Quả</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($ketqua->chitiet as $index => $cauhoi): ?>
                  <tr class="<?= $cauhoi->dung_sai ? 'table-success bg-opacity-25' : 'table-danger bg-opacity-25' ?>">
                    <td class="text-center fw-bold"><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($cauhoi->name_cauhoi) ?></td>
                    <td>
                      <?php if ($cauhoi->name_dapan_user): ?>
                        <?= htmlspecialchars($cauhoi->name_dapan_user) ?>
                      <?php else: ?>
                        <span class="text-muted fst-italic">Không chọn</span>
                      <?php endif; ?>
                    </td>
                    <td class="fw-bold text-success">
                      <?= htmlspecialchars($cauhoi->name_dapan_dung) ?>
                    </td>
                    <td class="text-center">
                      <?php if ($cauhoi->dung_sai): ?>
                        <div class="d-inline-block rounded-circle bg-success text-white p-2" style="width: 32px; height: 32px;">
                          <i class="bi bi-check-lg"></i>
                        </div>
                      <?php else: ?>
                        <div class="d-inline-block rounded-circle bg-danger text-white p-2" style="width: 32px; height: 32px;">
                          <i class="bi bi-x-lg"></i>
                        </div>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Các phần khác như thống kê và nhận xét... -->
          
        </div>

        <!-- Footer -->
        <div class="card-footer py-3 d-flex justify-content-between align-items-center bg-light">
          <a href="http://localhost/PHP_BaoCao/index.php?controller=user&action=homeuser" class="btn btn-primary">
            <i class="bi bi-house-door me-1"></i> Trang chủ
          </a>
          <a href="index.php?controller=TracnghiemOnline&action=lambai&id=<?= htmlspecialchars($ketqua->id_baithi ?? '') ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-repeat me-1"></i> Làm lại bài thi
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Thêm thư viện Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">