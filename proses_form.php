<?php
// 1. Hubungkan file ini dengan database
include 'db.php';

// 2. Ambil data yang dikirim dari form HTML
$nama  = $_POST['full_name'];
$email = $_POST['email'];
$hp    = $_POST['phone'];
$pesan = $_POST['message'];

// 3. Buat ID Form secara acak (karena tipe datanya varchar)
// Hasilnya nanti seperti: FRM-1234
$id_form = "FRM-" . rand(1000, 9999);

// 4. Buat perintah SQL untuk memasukkan data ke tabel 'form'
// Catatan: id_admin kita kosongkan karena pesan ini dari pengunjung, bukan admin
$sql = "INSERT INTO form (id_form, full_name, email, phone, message) 
        VALUES ('$id_form', '$nama', '$email', '$hp', '$pesan')";

// 5. Jalankan perintah SQL tersebut
$simpan = mysqli_query($conn, $sql);

// 6. Cek apakah berhasil disimpan atau tidak
if ($simpan) {
    // Jika berhasil, munculkan pesan sukses dan kembali ke halaman form
    echo "<script>
            alert('Pesan berhasil dikirim!');
            window.location.href = 'contact_us.html';
          </script>";
} else {
    // Jika gagal, munculkan pesan error
    echo "<script>
            alert('Gagal mengirim pesan!');
            window.location.href = 'contact_us.html';
          </script>";
}
?>