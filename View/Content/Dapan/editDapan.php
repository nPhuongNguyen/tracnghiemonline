<div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-primary bg-gradient text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            Chỉnh sửa đáp án cho câu hỏi
                        </h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <strong>Câu hỏi:</strong> <?php echo htmlspecialchars($cauhoi->name_cauhoi); ?>
                        </div>
                        
                        <form action="?controller=Dapan&action=update" method="POST">
                            <input type="hidden" name="id_cauhoi" value="<?php echo $cauhoi->id_cauhoi; ?>">
                            
                            <?php foreach ($dapans as $index => $dapan): ?>
                                <div class="card mb-3 border-light shadow-sm">
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-8">
                                                <label for="answer-<?php echo $dapan->id_dapan; ?>" class="form-label fw-bold">
                                                    <i class="bi bi-chat-left-text me-1"></i>
                                                    Đáp án <?php echo $index + 1; ?>:
                                                </label>
                                                <input type="text" 
                                                    id="answer-<?php echo $dapan->id_dapan; ?>"
                                                    class="form-control" 
                                                    name="answers[<?php echo $dapan->id_dapan; ?>]"
                                                    value="<?php echo htmlspecialchars($dapan->name_dapan); ?>" 
                                                    required>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                        type="radio" 
                                                        name="dapan" 
                                                        id="correct-<?php echo $dapan->id_dapan; ?>"
                                                        value="<?php echo $dapan->id_dapan; ?>"
                                                        <?php echo ($dapan->dapan == 1) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="correct-<?php echo $dapan->id_dapan; ?>">
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            Đáp án đúng
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="?controller=Dapan" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>
                                    Cập nhật đáp án
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>