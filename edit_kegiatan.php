<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

// ==========================================
// 1. AMBIL DATA UNTUK DITAMPILKAN
// ==========================================
if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];
    
    $query = "SELECT * FROM kegiatan WHERE id_kegiatan = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_kegiatan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data kegiatan tidak ditemukan!");
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: kelola_kegiatan.php");
    exit();
}

// ==========================================
// 2. PROSES UPDATE SAAT FORM DISUBMIT
// ==========================================
if (isset($_POST['btn_update'])) {
    $id_lama = $_POST['id_kegiatan_lama'];
    $id_baru = htmlspecialchars($_POST['id_kegiatan']);
    $judul   = htmlspecialchars($_POST['judul']);
    $waktu   = $_POST['waktu_kegiatan'];
    
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_baru = $_FILES['gambar']['name'];

    // Jika user mengupload file gambar baru
    if ($gambar_baru != "") {
        $tmp_name = $_FILES['gambar']['tmp_name'];
        // Sesuaikan dengan foldermu
        $direktori = "uploads/" . $gambar_baru; 
        
        // Pindahkan file baru
        move_uploaded_file($tmp_name, $direktori);
        
        // Hapus file lama
        if (file_exists("uploads/" . $gambar_lama) && $gambar_lama != "") {
            unlink("uploads/" . $gambar_lama);
        }

        // Update Teks & Gambar
        $query_update = "UPDATE kegiatan SET id_kegiatan=?, judul=?, waktu_kegiatan=?, gambar=? WHERE id_kegiatan=?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "sssss", $id_baru, $judul, $waktu, $gambar_baru, $id_lama);
    } 
    // Jika gambar tidak diubah
    else {
        // Update Teks Saja
        $query_update = "UPDATE kegiatan SET id_kegiatan=?, judul=?, waktu_kegiatan=? WHERE id_kegiatan=?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "ssss", $id_baru, $judul, $waktu, $id_lama);
    }

    if (mysqli_stmt_execute($stmt_update)) {
        echo "<script>
                alert('Kegiatan berhasil diperbarui!');
                window.location.href = 'kelola_kegiatan.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui kegiatan!');</script>";
    }
    mysqli_stmt_close($stmt_update);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan — Ma Chung Mandarin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_admin.css">
    <style>
        .edit-wrap { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body style="background-color: #f8f9fa;">

<div class="container">
    <div class="edit-wrap border">
        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
            <div class="m-hd-ico ic-amber me-3"><i class="bi bi-pencil-square"></i></div>
            <h4 class="mb-0" style="color: var(--t1); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;">Edit Kegiatan</h4>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Data tersembunyi untuk referensi WHERE dan hapus file -->
            <input type="hidden" name="id_kegiatan_lama" value="<?= htmlspecialchars($data['id_kegiatan']); ?>">
            <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']); ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold" style="color:var(--t2);">ID Kegiatan</label>
                    <input type="text" class="form-control" name="id_kegiatan" value="<?= htmlspecialchars($data['id_kegiatan']); ?>" required>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <label class="form-label fw-bold" style="color:var(--t2);">Waktu Kegiatan</label>
                    <input type="date" class="form-control" name="waktu_kegiatan" value="<?= htmlspecialchars($data['waktu_kegiatan']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold" style="color:var(--t2);">Judul Kegiatan</label>
                <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($data['judul']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold" style="color:var(--t2);">Ubah Poster / Gambar (Opsional)</label><br>
                <small class="text-muted d-block mb-2">Poster saat ini: <b><?= htmlspecialchars($data['gambar']); ?></b></small>
                <input type="file" class="form-control" name="gambar" accept=".jpg,.jpeg,.png">
                <div class="form-text"><i class="bi bi-info-circle"></i> Biarkan kosong jika tidak ingin mengubah poster.</div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <a href="kelola_kegiatan.php" class="btn btn-light border">Batal</a>
                <button type="submit" name="btn_update" class="btn" style="background-color: var(--red); color: white;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>