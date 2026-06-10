<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id_berita'])) {
    $id_berita = $_GET['id_berita'];

    $query_gambar = "SELECT gambar FROM berita WHERE id_berita = ?";
    $stmt_gambar = mysqli_prepare($conn, $query_gambar);
    mysqli_stmt_bind_param($stmt_gambar, "s", $id_berita);
    mysqli_stmt_execute($stmt_gambar);
    $result = mysqli_stmt_get_result($stmt_gambar);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $gambar_lama = $row['gambar'];
        
        $path_gambar = "uploads/" . $gambar_lama; 
        if (file_exists($path_gambar) && is_file($path_gambar)) {
            unlink($path_gambar); 
        }
    }
    mysqli_stmt_close($stmt_gambar);

    $query_hapus = "DELETE FROM berita WHERE id_berita = ?";
    $stmt_hapus = mysqli_prepare($conn, $query_hapus);
    mysqli_stmt_bind_param($stmt_hapus, "s", $id_berita);

    if (mysqli_stmt_execute($stmt_hapus)) {
        echo "<script>
                alert('Berita berhasil dihapus!');
                window.location.href = 'kelola_berita.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus berita.');
                window.location.href = 'kelola_berita.php';
              </script>";
    }
    mysqli_stmt_close($stmt_hapus);
} else {
    header("Location: kelola_berita.php");
    exit();
}
?>