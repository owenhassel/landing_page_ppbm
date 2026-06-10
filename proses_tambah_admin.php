<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; 

if (isset($_POST['submit'])) {
    
    $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $passcode = mysqli_real_escape_string($conn, $_POST['passcode']);
    
    $cek_username = mysqli_query($conn, "SELECT id_admin FROM users WHERE id_admin = '$id_admin'");
    
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>
                alert('Gagal: ID Admin / Username tersebut sudah digunakan!');
                window.location.href = 'admin.php#user';
              </script>";
        exit();
    }
    
    $passcode_encrypted = md5($passcode);
    
    $query_insert = "INSERT INTO users (id_admin, passcode) VALUES ('$id_admin', '$passcode_encrypted')";
    
    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Berhasil: Admin baru sukses ditambahkan!');
                window.location.href = 'admin.php#user';
              </script>";
    } else {
        echo "<script>
                alert('Error: Gagal menambahkan admin. Silakan coba lagi.');
                window.location.href = 'admin.php#user';
              </script>";
    }
} else {
    header("Location: admin.php");
    exit();
}
?>