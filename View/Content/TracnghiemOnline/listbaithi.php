    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh sách bài thi</h2>

        <?php if (!empty($listbaithi)): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($listbaithi as $baithi): ?>
                    <div class="col">
                        <div class="card h-100 shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title text-truncate mb-0" title="<?= htmlspecialchars($baithi->ten_baithi) ?>">
                                    <?= htmlspecialchars($baithi->ten_baithi) ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-info text-dark" title="ID: <?= $baithi->id_baithi ?>">#<?= $baithi->id_baithi ?></span>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($baithi->name_monhoc) ?></span>
                                </div>
                                <p class="card-text">Môn học: <strong><?= htmlspecialchars($baithi->name_monhoc) ?></strong></p>
                            </div>
                            <div class="card-footer bg-white border-0 text-center">
                                 <?php if ($baithi->daLam): ?>
                                    <button class="btn disabled">Đã làm</button>
                                <?php else: ?>
                                    <a href="index.php?controller=TracNghiemOnline&action=baithibymonhoc&id_baithi=<?= $baithi->id_baithi ?>&id_monhoc=<?= $id_monhoc ?>" 
                                    class="btn btn-success">Làm bài</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Không có bài thi nào cho môn học này!
            </div>
        <?php endif; ?>
    </div>
