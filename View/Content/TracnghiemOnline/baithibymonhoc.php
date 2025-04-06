<?php
$thoiGianThi = 45; // Mặc định 30 phút
// Nếu chưa có thời gian bắt đầu thì lưu vào session
if (!isset($_SESSION['thoigian_batdau'])) {
    $_SESSION['thoigian_batdau'] = time();
}
?>
<div class="container py-5">
  <h2 class="text-center mb-4">Bài Thi Trắc Nghiệm</h2>
    <!-- Đồng hồ đếm ngược -->
    <div id="timer" class="alert alert-danger text-center fw-bold">
        Thời gian còn lại: <span id="countdown"><?= $thoiGianThi * 60 ?></span>
    </div>
  <form action="index.php?controller=TracnghiemOnline&action=nopbai" method="post">
    <input type="hidden" name="id_baithi" value="<?= htmlspecialchars($id_baithi); ?>">
    
    <?php if (!empty($BaithiCauhois)) { 
      $currentQuestion = null;
      $questionCount = 0;
      
      foreach ($BaithiCauhois as $cauhoi):
        if ($currentQuestion !== $cauhoi->id_cauhoi): // Khi gặp câu hỏi mới
          if ($currentQuestion !== null) {
            echo "</div>"; // Kết thúc card-body
            echo "</div>"; // Kết thúc card của câu hỏi trước
          }
          $currentQuestion = $cauhoi->id_cauhoi;
          $questionCount++;
    ?>
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="m-0">Câu <?= $questionCount ?>: <?= htmlspecialchars($cauhoi->name_cauhoi) ?></h5>
            </div>
            <div class="card-body">
              <input type="hidden" name="cauhoi[]" value="<?= htmlspecialchars($cauhoi->id_cauhoi) ?>">
    <?php endif; ?>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" 
                       name="cauhoi_<?= $cauhoi->id_cauhoi ?>" 
                       id="dapan_<?= $cauhoi->id_cauhoi ?>_<?= $cauhoi->id_dapan ?>"
                       value="<?= htmlspecialchars($cauhoi->id_dapan) ?>" required>
                <label class="form-check-label" for="dapan_<?= $cauhoi->id_cauhoi ?>_<?= $cauhoi->id_dapan ?>">
                  <?= htmlspecialchars($cauhoi->name_dapan) ?>
                </label>
              </div>
    <?php endforeach; 
          echo "</div>"; // Kết thúc card-body cuối cùng
          echo "</div>"; // Kết thúc card cuối cùng
    ?>
    
    <div class="d-grid gap-2 mt-4">
        <button type="submit" id="submit" class="btn btn-primary btn-lg">Nộp bài</button>

    </div>
    
    <?php } else { ?>
      <div class="alert alert-info text-center">
        Không có câu hỏi nào trong bài thi.
      </div>
    <?php } ?>
  </form>
</div>
<script>
    let timeLeft = <?= $thoiGianThi * 60 ?>;
    let timerDisplay = document.getElementById("countdown");
    let submitButton = document.getElementById("submit");

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerDisplay.textContent = minutes + " phút " + (seconds < 10 ? "0" : "") + seconds + " giây";

        if (timeLeft <= 0) {
            clearInterval(timer);
            if (submitButton) {
                submitButton.disabled = false; // Đảm bảo nút không bị vô hiệu hóa
                submitButton.click(); // Tự động click
                Swal.fire({
                title: "Nộp bài thành công!",
                text: "Bài thi của bạn đã được gửi.",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "index.php?controller=TracnghiemOnline&action=ketqua&id_lambai=<?= $id_baithi ?>  ";                }
            });

            } else {
                console.error("Không tìm thấy nút #submit!");
            }
        } else {
            timeLeft--;
        }
    }
    let timer = setInterval(updateTimer, 1000);
</script>
