<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id_form'])) {
    $id_form = $_GET['id_form'];

    $query = "DELETE FROM form WHERE id_form = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_form);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Pesan berhasil dihapus!');
                window.location.href = 'data_form.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus pesan.');
                window.location.href = 'data_form.php';
              </script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    header("Location: data_form.php");
    exit();
}
?>