<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_POST['submit'])) {
    
    $id_berita = mysqli_real_escape_string($conn, $_POST['id_berita']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    $id_admin = $_SESSION["id_admin"];

    $cek_id = mysqli_query($conn, "SELECT id_berita FROM berita WHERE id_berita = '$id_berita'");
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
                alert('Gagal: ID Berita tersebut sudah digunakan!');
                window.location.href = 'admin.php#berita';
              </script>";
        exit();
    }

    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!'); window.location.href = 'admin.php#berita';</script>";
        exit();
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda upload bukan gambar (hanya jpg, jpeg, png)!'); window.location.href = 'admin.php#berita';</script>";
        exit();
    }

    $namaFileBaru = uniqid(); 
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmp_name, 'Image/' . $namaFileBaru);

    $query_insert = "INSERT INTO berita (id_berita, id_admin, gambar, judul, deskripsi, date, penulis) 
                     VALUES ('$id_berita', '$id_admin', '$namaFileBaru', '$judul', '$deskripsi', '$date', '$penulis')";

    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Berita berhasil ditambahkan!');
                window.location.href = 'admin.php#berita';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan berita ke database!');
                window.location.href = 'admin.php#berita';
              </script>";
    }

} else {
    header("Location: admin.php");
    exit();
}
?>