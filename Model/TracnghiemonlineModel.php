<?php
Class TracnghiemOnlineModel{
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }

    public function listbaithi($id_monhoc) {
        $query = "SELECT 
                    b.id_baithi, 
                    b.ten_baithi, 
                    m.id_monhoc, 
                    m.name_monhoc
                  FROM ct_baithi_monhoc ct
                  JOIN baithitracnghiem b ON ct.id_baithi = b.id_baithi
                  JOIN monhoc m ON ct.id_monhoc = m.id_monhoc
                  WHERE ct.id_monhoc = ?";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_monhoc]); 
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function kiemtra($id_baithi, $id_monhoc){
        try {
            $query = "SELECT DISTINCT
                        b.id_baithi, 
                        b.ten_baithi, 
                        m.id_monhoc, 
                        m.name_monhoc,
                        ch.id_cauhoi,
                        ch.name_cauhoi,
                        d.id_dapan,
                        d.name_dapan,
                        d.dapan
                      FROM ct_baithi_monhoc ct
                      JOIN baithitracnghiem b ON ct.id_baithi = b.id_baithi
                      JOIN monhoc m ON ct.id_monhoc = m.id_monhoc
                      JOIN ct_baithi_cauhoi cbc ON b.id_baithi = cbc.id_baithi
                      JOIN cauhoi ch ON cbc.id_cauhoi = ch.id_cauhoi
                      JOIN dapan d ON ch.id_cauhoi = d.id_cauhoi  
                      WHERE ct.id_monhoc = ? 
                        AND ct.id_baithi = ? 
                        AND ch.id_monhoc = ?";  
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id_monhoc, $id_baithi, $id_monhoc]); 
            $result = $stmt->fetchAll(PDO::FETCH_OBJ); 
    
            return $result ?: []; 
        } catch (PDOException $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }
    }
    
    public function saveBaiLam($id_nguoidung, $id_baithi, $answers, $thoigian_batdau) {
        try {
            $this->conn->beginTransaction();
            $thoigian_batdau = time(); // Lưu thời gian bắt đầu
            // ... mã xử lý bài thi ...
            $thoigian_ketthuc = time(); // Lưu thời gian kết thúc

            $thoigian_lambai = $thoigian_ketthuc - $thoigian_batdau; // Tính số giây
            // Lưu vào cơ sở dữ liệu
            $stmt = $this->conn->prepare("INSERT INTO baithi_user (userName, id_baithi, thoigianlambai) VALUES (?, ?, ?)");
            $stmt->execute([$id_nguoidung, $id_baithi, $thoigian_lambai]);
            $id_lambai = $this->conn->lastInsertId();
            
            $so_cau_dung = 0;
    
            foreach ($answers as $id_cauhoi => $id_dapan) {
                // Kiểm tra câu hỏi có tồn tại không
                $stmt = $this->conn->prepare("SELECT COUNT(*) FROM cauhoi WHERE id_cauhoi = ?");
                $stmt->execute([$id_cauhoi]);
                if ($stmt->fetchColumn() == 0) {
                    throw new Exception("Lỗi: Câu hỏi ID $id_cauhoi không tồn tại.");
                }
    
                // Kiểm tra đáp án có hợp lệ không
                $stmt = $this->conn->prepare("SELECT COUNT(*) FROM dapan WHERE id_dapan = ? AND id_cauhoi = ?");
                $stmt->execute([$id_dapan, $id_cauhoi]);
                if ($stmt->fetchColumn() == 0) {
                    throw new Exception("Lỗi: Đáp án ID $id_dapan không hợp lệ cho câu hỏi ID $id_cauhoi.");
                }
    
                // Kiểm tra xem đáp án có đúng không
                $stmt = $this->conn->prepare("SELECT dapan FROM dapan WHERE id_dapan = ?");
                $stmt->execute([$id_dapan]);
                $dapan_dung = $stmt->fetchColumn();
                $dung_sai = $dapan_dung ? 1 : 0;
    
                if ($dung_sai) {
                    $so_cau_dung++;
                }
    
                // Lưu câu trả lời vào `chitiet_traloi`
                $stmt = $this->conn->prepare("INSERT INTO chitiet_traloi (id_lambai, id_cauhoi, id_dapan, dung_sai) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_lambai, $id_cauhoi, $id_dapan, $dung_sai]);
            }
    
            // Cập nhật điểm
            $stmt = $this->conn->prepare("UPDATE baithi_user SET diem = ? WHERE id_lambai = ?");
            $stmt->execute([$so_cau_dung, $id_lambai]);
    
            $this->conn->commit();
            return $id_lambai;
        } catch (Exception $e) {
            $this->conn->rollBack();
            die("Lỗi: " . $e->getMessage());
        }
    }
    

    public function getKetQua($id_lambai) {
        $query = "SELECT btu.*, bt.ten_baithi 
                  FROM baithi_user btu
                  JOIN baithitracnghiem bt ON btu.id_baithi = bt.id_baithi
                  WHERE btu.id_lambai = ? LIMIT 1"; 
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_lambai]);
        $ketqua = $stmt->fetch(PDO::FETCH_OBJ); // Trả về 1 object duy nhất
    
        // Lấy danh sách câu hỏi và câu trả lời từ bảng chitiet_traloi
        $query_chitiet = "SELECT ct.id_cauhoi, 
                                ch.name_cauhoi, 
                                ct.dung_sai,  
                                da_user.name_dapan AS name_dapan_user, 
                                da_dung.name_dapan AS name_dapan_dung
                        FROM chitiet_traloi ct
                        JOIN cauhoi ch ON ct.id_cauhoi = ch.id_cauhoi
                        LEFT JOIN dapan da_user ON ct.id_dapan = da_user.id_dapan
                        LEFT JOIN dapan da_dung ON ch.id_cauhoi = da_dung.id_cauhoi AND da_dung.dapan = 1
                        WHERE ct.id_lambai = ?";


        
        $stmt_chitiet = $this->conn->prepare($query_chitiet);
        $stmt_chitiet->execute([$id_lambai]);
        $ketqua->chitiet = $stmt_chitiet->fetchAll(PDO::FETCH_OBJ); // Lấy danh sách câu hỏi và đáp án
    
        return $ketqua;
    }
    
    public function kiemTraDaLamBai($id_nguoidung, $id_baithi) {
        $query = "
            SELECT ctb.id_monhoc 
            FROM baithi_user btu 
            JOIN ct_baithi_monhoc ctb ON btu.id_baithi = ctb.id_baithi 
            WHERE btu.userName = ? AND btu.id_baithi = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_nguoidung, $id_baithi]);
        
        return $stmt->fetchColumn(); // Trả về id_monhoc nếu tìm thấy, hoặc null
    }

    
}
?>