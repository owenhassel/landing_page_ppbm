<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id_form']) && isset($_GET['status'])) {
    $id_form = mysqli_real_escape_string($conn, $_GET['id_form']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    
    if ($status === 'Telah Dibaca' || $status === 'Belum Dibaca') {
        $sql = "UPDATE form SET status = '$status' WHERE id_form = '$id_form'";
        mysqli_query($conn, $sql);
    }
}

// Kembalikan ke halaman form
header("Location: data_form.php");
exit();
?>