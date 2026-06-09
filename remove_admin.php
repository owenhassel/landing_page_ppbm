<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id_admin'])) {
    $id_hapus = $_GET['id_admin'];
    $current_admin = $_SESSION["id_admin"];

    // Cegah admin menghapus dirinya sendiri
    if ($id_hapus === $current_admin) {
        echo "<script>
                alert('Akses ditolak: Anda tidak bisa menghapus akun yang sedang Anda gunakan!');
                window.location.href = 'admin.php#user';
              </script>";
        exit();
    }

    // Query hapus prosedural ('s' karena id_admin biasanya string/varchar)
    $query = "DELETE FROM users WHERE id_admin = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_hapus);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Admin berhasil dihapus!');
                window.location.href = 'admin.php#user';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus admin.');
                window.location.href = 'admin.php#user';
              </script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    header("Location: admin.php");
    exit();
}
?>