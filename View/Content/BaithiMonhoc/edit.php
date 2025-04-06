
<h1 class="text-center text-gradient mt-4 fw-bold">✏️ Chỉnh sửa Bài thi & Câu hỏi</h1>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4">
    <form method="post" action="?controller=BaithiMonhoc&action=update">
        <input type="hidden" name="old_id_monhoc" value="<?= $BaithiMonhoc->id_monhoc; ?>">

        <div class="mb-3">
            <label class="fw-bold">Bài thi:</label>
            <select name="id_baithi" id="id_baithi" class="form-control mb-3">
                <?php foreach ($Baithitracnghiems as $Baithitracnghiem): ?>
                    <option value="<?= $Baithitracnghiem->id_baithi; ?>" 
                        <?= ($Baithitracnghiem->id_baithi == $BaithiMonhoc->id_baithi) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($Baithitracnghiem->ten_baithi); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Môn học:</label>
            <select name="id_monhoc" id="id_monhoc" class="form-control mb-3">
                <?php foreach ($monhocs as $monhoc): ?>
                    <option value="<?= $monhoc->id_monhoc; ?>" 
                        <?= ($monhoc->id_monhoc == $BaithiMonhoc->id_monhoc) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($monhoc->name_monhoc); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" name="update" class="btn btn-success px-4">
                <i class="bi bi-save"></i> Cập nhật
            </button>
            <a href="?controller=BaithiMonhoc&action=index" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>

    </div>
</div>

<script>
document.getElementById('id_baithi').addEventListener('change', function() {
    var id_baithi = this.value;
    var id_monhoc = document.getElementById('id_monhoc').value;

    fetch(`?controller=BaithiMonhoc&action=getAvailableQuestions&id_baithi=${id_baithi}`)
    .then(response => response.json())
    .then(data => {
        var select = document.getElementById('id_monhoc');
        select.innerHTML = ''; 

        // Tạo option cho câu hỏi đang chọn
        var selectedOption = document.createElement('option');
        selectedOption.value = id_monhoc;
        selectedOption.selected = true;
        selectedOption.textContent = select.querySelector('option[selected]')?.textContent || "Chọn môn học";
        select.appendChild(selectedOption);

        // Thêm danh sách câu hỏi mới vào select
        data.forEach(function(item) {
            var option = document.createElement('option');
            option.value = item.id_monhoc;
            option.textContent = item.name_monhoc;
            select.appendChild(option);
        });
    });
});

</script>