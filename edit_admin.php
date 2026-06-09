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
if (isset($_GET['id_admin'])) {
    $id_admin = $_GET['id_admin'];
    
    $query = "SELECT * FROM users WHERE id_admin = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_admin);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data admin tidak ditemukan!");
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: admin.php");
    exit();
}

// ==========================================
// 2. PROSES UPDATE SAAT FORM DISUBMIT
// ==========================================
if (isset($_POST['btn_update'])) {
    $id_admin_lama = $_POST['id_admin_lama'];
    $id_admin_baru = htmlspecialchars($_POST['id_admin_baru']);
    $passcode_baru = $_POST['passcode_baru'];

    // Jika admin mengisi password baru, update beserta passwordnya
    if (!empty($passcode_baru)) {
        // Enkripsi password baru menggunakan MD5 agar cocok dengan login.php
        $password_hashed = md5($passcode_baru);
        
        $query_update = "UPDATE users SET id_admin = ?, passcode = ? WHERE id_admin = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "sss", $id_admin_baru, $password_hashed, $id_admin_lama);
    } 
    // Jika password kosong, hanya update id_admin (username) saja
    else {
        $query_update = "UPDATE users SET id_admin = ? WHERE id_admin = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "ss", $id_admin_baru, $id_admin_lama);
    }

    if (mysqli_stmt_execute($stmt_update)) {
        // Jika yang diedit adalah akun yang sedang login, update sessionnya juga
        if ($_SESSION["id_admin"] === $id_admin_lama) {
            $_SESSION["id_admin"] = $id_admin_baru;
        }

        echo "<script>
                alert('Data admin berhasil diperbarui!');
                window.location.href = 'admin.php#user';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
    mysqli_stmt_close($stmt_update);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin — Ma Chung Mandarin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_admin.css">
    <style>
        .edit-container { max-width: 500px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body style="background-color: #f8f9fa;">

    <div class="container">
        <div class="edit-container border">
            <h4 class="mb-4" style="color: var(--red);"><i class="bi bi-pencil-square"></i> Edit Data Admin</h4>
            
            <form action="" method="POST">
                <input type="hidden" name="id_admin_lama" value="<?= htmlspecialchars($data['id_admin']); ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold">Username / ID Admin</label>
                    <input type="text" class="form-control" name="id_admin_baru" value="<?= htmlspecialchars($data['id_admin']); ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" class="form-control" name="passcode_baru" placeholder="Kosongkan jika tidak ingin mengubah password">
                    <small class="text-muted"><i class="bi bi-info-circle"></i> Password akan dienkripsi secara otomatis.</small>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="admin.php#user" class="btn btn-light border">Batal</a>
                    <button type="submit" name="btn_update" class="btn btn-danger" style="background-color: var(--red); border-color: var(--red);">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>