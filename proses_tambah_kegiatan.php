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
    $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $waktu_kegiatan = mysqli_real_escape_string($conn, $_POST['waktu_kegiatan']);
    
    // Ambil ID admin yang sedang login dari session
    $id_admin = $_SESSION["id_admin"];

    // 2. Cek apakah ID Kegiatan sudah pernah digunakan
    $cek_id = mysqli_query($conn, "SELECT id_kegiatan FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
                alert('Gagal: ID Kegiatan tersebut sudah digunakan!');
                window.location.href = 'admin.php#kegiatan';
              </script>";
        exit();
    }

    // 3. Proses Upload Gambar (Poster Kegiatan)
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // Cek apakah ada gambar yang diupload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar poster terlebih dahulu!'); window.location.href = 'admin.php#kegiatan';</script>";
        exit();
    }

    // Cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda upload bukan file gambar (hanya jpg, jpeg, png)!'); window.location.href = 'admin.php#kegiatan';</script>";
        exit();
    }

    // Generate nama file baru (agar tidak tertimpa jika ada nama file yang sama)
    $namaFileBaru = uniqid() . '-kegiatan.' . $ekstensiGambar;

    // Pindahkan file gambar ke folder 'Image/'
    move_uploaded_file($tmp_name, 'Image/' . $namaFileBaru);

    // 4. Masukkan semua data ke tabel kegiatan di database
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
    // Jika diakses tanpa submit form
    header("Location: admin.php");
    exit();
}
?>