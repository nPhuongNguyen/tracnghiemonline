<div class="container mt-4">
    <h2>Thông tin cá nhân</h2>
    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user->userName); ?></p>
    <p><strong>Vai trò:</strong> <?php echo htmlspecialchars($user->roleName); ?></p>
    
    <h3>Điểm trung bình tổng:</h3>
<p><?php echo number_format($averageScore, 2); ?> điểm</p>

<h3>Điểm trung bình theo môn:</h3>
<ul>
    <?php if (!empty($subjectScores)): ?>
        <?php foreach ($subjectScores as $subjectScore): ?>
            <li><?php echo htmlspecialchars($subjectScore->name_monhoc); ?>: <?php echo number_format($subjectScore->average_score, 2); ?> điểm</li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Chưa có điểm cho môn nào.</li>
    <?php endif; ?>
</ul>   
    <a href="index.php?controller=user&action=editProfile" class="btn btn-primary">Chỉnh sửa thông tin</a>
</div>