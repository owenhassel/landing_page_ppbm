<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];

    $query_gambar = "SELECT gambar FROM kegiatan WHERE id_kegiatan = ?";
    $stmt_gambar = mysqli_prepare($conn, $query_gambar);
    mysqli_stmt_bind_param($stmt_gambar, "s", $id_kegiatan);
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

    $query_hapus = "DELETE FROM kegiatan WHERE id_kegiatan = ?";
    $stmt_hapus = mysqli_prepare($conn, $query_hapus);
    mysqli_stmt_bind_param($stmt_hapus, "s", $id_kegiatan);

    if (mysqli_stmt_execute($stmt_hapus)) {
        echo "<script>
                alert('Data kegiatan berhasil dihapus!');
                window.location.href = 'kelola_kegiatan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus kegiatan.');
                window.location.href = 'kelola_kegiatan.php';
              </script>";
    }
    mysqli_stmt_close($stmt_hapus);
} else {
    header("Location: kelola_kegiatan.php");
    exit();
}
?>