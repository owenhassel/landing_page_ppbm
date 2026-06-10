<?php
include 'db.php';

$nama  = $_POST['full_name'];
$email = $_POST['email'];
$hp    = $_POST['phone'];
$pesan = $_POST['message'];

$id_form = "FRM-" . rand(1000, 9999);

$sql = "INSERT INTO form (id_form, full_name, email, phone, message) 
        VALUES ('$id_form', '$nama', '$email', '$hp', '$pesan')";

$simpan = mysqli_query($conn, $sql);

if ($simpan) {
    echo "<script>
            alert('Pesan berhasil dikirim!');
            window.location.href = 'contact_us.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal mengirim pesan!');
            window.location.href = 'contact_us.php';
          </script>";
}
?>