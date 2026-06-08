<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_POST['submit'])) {
    
    // 1. Ambil data teks dari form
    $id_berita = mysqli_real_escape_string($conn, $_POST['id_berita']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    // Ambil ID admin yang sedang login dari session
    $id_admin = $_SESSION["id_admin"];

    // 2. Cek apakah ID Berita sudah pernah digunakan
    $cek_id = mysqli_query($conn, "SELECT id_berita FROM berita WHERE id_berita = '$id_berita'");
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
                alert('Gagal: ID Berita tersebut sudah digunakan!');
                window.location.href = 'admin.php#berita';
              </script>";
        exit();
    }

    // 3. Proses Upload Gambar
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!'); window.location.href = 'admin.php#berita';</script>";
        exit();
    }

    // Cek ekstensi gambar (hanya boleh jpg, jpeg, png)
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda upload bukan gambar (hanya jpg, jpeg, png)!'); window.location.href = 'admin.php#berita';</script>";
        exit();
    }

    // Generate nama file baru agar tidak bentrok jika nama file sama
    $namaFileBaru = uniqid(); 
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Pindahkan file gambar ke folder 'Image/'
    // Pastikan folder Image/ ada di dalam project kamu
    move_uploaded_file($tmp_name, 'Image/' . $namaFileBaru);

    // 4. Masukkan semua data ke tabel berita di database
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