<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_POST['submit'])) {
    
    $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $waktu_kegiatan = mysqli_real_escape_string($conn, $_POST['waktu_kegiatan']);
    
    $id_admin = $_SESSION["id_admin"];

    $cek_id = mysqli_query($conn, "SELECT id_kegiatan FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
                alert('Gagal: ID Kegiatan tersebut sudah digunakan!');
                window.location.href = 'admin.php#kegiatan';
              </script>";
        exit();
    }

    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih gambar poster terlebih dahulu!'); window.location.href = 'admin.php#kegiatan';</script>";
        exit();
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda upload bukan file gambar (hanya jpg, jpeg, png)!'); window.location.href = 'admin.php#kegiatan';</script>";
        exit();
    }

    $namaFileBaru = uniqid() . '-kegiatan.' . $ekstensiGambar;

    move_uploaded_file($tmp_name, 'Image/' . $namaFileBaru);

    $query_insert = "INSERT INTO kegiatan (id_kegiatan, judul, gambar, waktu_kegiatan, id_admin) 
                     VALUES ('$id_kegiatan', '$judul', '$namaFileBaru', '$waktu_kegiatan', '$id_admin')";

    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Berhasil: Data kegiatan sukses ditambahkan!');
                window.location.href = 'admin.php#kegiatan';
              </script>";
    } else {
        echo "<script>
                alert('Error: Gagal menambahkan data kegiatan!');
                window.location.href = 'admin.php#kegiatan';
              </script>";
    }

} else {
    header("Location: admin.php");
    exit();
}
?>