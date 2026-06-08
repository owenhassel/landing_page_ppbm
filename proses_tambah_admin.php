<?php
session_start();

// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Panggil koneksi database

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    
    // Ambil data dari form dan bersihkan dari injeksi karakter aneh
    $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $passcode = mysqli_real_escape_string($conn, $_POST['passcode']);
    
    // Cek apakah ID Admin sudah digunakan sebelumnya
    $cek_username = mysqli_query($conn, "SELECT id_admin FROM users WHERE id_admin = '$id_admin'");
    
    if (mysqli_num_rows($cek_username) > 0) {
        // Jika username sudah ada
        echo "<script>
                alert('Gagal: ID Admin / Username tersebut sudah digunakan!');
                window.location.href = 'admin.php#user';
              </script>";
        exit();
    }
    
    // Enkripsi Password
    // Karena di database kolom passcode kamu bertipe varchar(32), ini sangat cocok menggunakan enkripsi MD5.
    $passcode_encrypted = md5($passcode);
    
    // Insert data ke database
    $query_insert = "INSERT INTO users (id_admin, passcode) VALUES ('$id_admin', '$passcode_encrypted')";
    
    if (mysqli_query($conn, $query_insert)) {
        // Jika berhasil
        echo "<script>
                alert('Berhasil: Admin baru sukses ditambahkan!');
                window.location.href = 'admin.php#user';
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Error: Gagal menambahkan admin. Silakan coba lagi.');
                window.location.href = 'admin.php#user';
              </script>";
    }
} else {
    // Jika file diakses langsung tanpa lewat form
    header("Location: admin.php");
    exit();
}
?>