
<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Chỉnh sửa Bài thi & Câu hỏi</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
    <form method="post" action="?controller=BaithiCauhoi&action=update">
        <input type="hidden" name="old_id_cauhoi" value="<?= $baithicauhoi->id_cauhoi; ?>">

        <div class="mb-3">
            <label class="fw-bold">Bài thi:</label>
            <select name="id_baithi" id="id_baithi" class="form-control mb-3">
                <?php foreach ($Baithitracnghiems as $Baithitracnghiem): ?>
                    <option value="<?= $Baithitracnghiem->id_baithi; ?>" 
                        <?= ($Baithitracnghiem->id_baithi == $baithicauhoi->id_baithi) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($Baithitracnghiem->ten_baithi); ?>
                       
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Câu hỏi:</label>
            <select name="id_cauhoi" id="id_cauhoi" class="form-control mb-3">
                <?php foreach ($Cauhois as $Cauhoi): ?>
                    <option value="<?= $Cauhoi->id_cauhoi; ?>" 
                        <?= ($Cauhoi->id_cauhoi == $baithicauhoi->id_cauhoi) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($Cauhoi->name_cauhoi); ?>
                        <?= isset($baithicauhoi->name_monhoc) ? htmlspecialchars($baithicauhoi->name_monhoc) : 'Không có môn học'; ?>

                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" name="update" class="btn btn-success px-4">
                <i class="bi bi-save"></i> Cập nhật
            </button>
            <a href="?controller=BaithiCauhoi&action=index" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>

    </div>
</div>

<script>
document.getElementById('id_baithi').addEventListener('change', function() {
    var id_baithi = this.value;
    var id_cauhoi = document.getElementById('id_cauhoi').value;

    fetch(`?controller=BaithiCauhoi&action=getAvailableQuestions&id_baithi=${id_baithi}`)
    .then(response => response.json())
    .then(data => {
        var select = document.getElementById('id_cauhoi');
        select.innerHTML = ''; 

        // Tạo option cho câu hỏi đang chọn
        var selectedOption = document.createElement('option');
        selectedOption.value = id_cauhoi;
        selectedOption.selected = true;
        selectedOption.textContent = select.querySelector('option[selected]')?.textContent || "Chọn câu hỏi";
        select.appendChild(selectedOption);

        // Thêm danh sách câu hỏi mới vào select
        data.forEach(function(item) {
            var option = document.createElement('option');
            option.value = item.id_cauhoi;
            option.textContent = `${item.name_cauhoi} - [${item.name_monhoc}]`;
            select.appendChild(option);
        });
    });
});

</script>