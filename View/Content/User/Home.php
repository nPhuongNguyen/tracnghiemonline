<div class="container mt-4">
    <h2 class="text-center mb-4">📊 Thống kê hệ thống</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">👤 Người dùng</div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo $total_users; ?></h3>
                    <p class="card-text">Tổng số người dùng</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">📝 Bài kiểm tra</div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo $total_exams; ?></h3>
                    <p class="card-text">Tổng số bài kiểm tra</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">❓ Câu hỏi</div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo $total_questions; ?></h3>
                    <p class="card-text">Tổng số câu hỏi</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">✅ Bài làm hoàn thành</div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo $total_completed_exams; ?></h3>
                    <p class="card-text">Tổng số bài làm đã hoàn thành</p>
                </div>
            </div>
        </div>
    </div>
</div>
