<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Danh sách bài thi chưa làm</h2>
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                <i class="bi bi-book-half me-1"></i> Học tập
            </span>
        </div>
    </div>
</div>

<div class="container pb-5">
    <?php if (!empty($unattemptedExams)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($unattemptedExams as $exam): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="subject-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div>
                                    <h6 class="text-black-50 mb-1">Bài thi</h6>
                                    <h5 class="card-title fw-bold text-truncate mb-0" title="<?= htmlspecialchars($exam->ten_baithi) ?>">
                                        <?= htmlspecialchars($exam->ten_baithi) ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="exam-badge bg-info bg-opacity-10 text-info" title="ID: <?= $exam->id_baithi ?>">
                                    <i class="bi bi-hash me-1"></i>Mã: <?= $exam->id_baithi ?>
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-mortarboard-fill me-2 text-primary"></i>
                                    <h6 class="mb-0">Môn học:</h6>
                                </div>
                            </div>
                            <div class="ps-4 mb-3">
                                <span class="fw-semibold"><?= htmlspecialchars($exam->name_monhoc) ?></span>
                            </div>
                            <hr class="my-3 opacity-10">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-search empty-icon"></i>
            <h4 class="fw-bold text-secondary mb-3">Không tìm thấy bài thi</h4>
            <p class="text-muted mb-4">Không có bài thi nào cho môn học này!</p>
        </div>
    <?php endif; ?>
</div>