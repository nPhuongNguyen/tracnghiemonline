<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/your/bootstrap.css"> <!-- Đảm bảo đường dẫn đúng -->
    <title>Danh sách bài thi</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Danh sách bài thi chưa làm</h2>

    <?php if (!empty($unattemptedExams)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($unattemptedExams as $exam): ?>
                <div class="col">
                    <div class="card h-100 shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title text-truncate mb-0" title="<?= htmlspecialchars($exam->ten_baithi) ?>">
                                <?= htmlspecialchars($exam->ten_baithi) ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-info text-dark" title="ID: <?= $exam->id_baithi ?>">#<?= $exam->id_baithi ?></span>
                                <span class="badge bg-secondary"><?= htmlspecialchars($exam->name_monhoc) ?></span>
                            </div>
                            <p class="card-text">Môn học: <strong><?= htmlspecialchars($exam->name_monhoc) ?></strong></p>
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

    <script src="path/to/your/bootstrap.bundle.js"></script> <!-- Đảm bảo đường dẫn đúng -->
</body>
</html>