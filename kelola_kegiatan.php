<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$current_admin = $_SESSION["id_admin"];
$initials = strtoupper(substr($current_admin, 0, 2));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Kegiatan — Ma Chung Mandarin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="style_admin.css">
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">MA CHUNG</div>
        <div class="sb-rule"></div>
        <div class="sb-sub">PPBM Admin Panel</div>
    </div>

    <nav class="sb-nav">
        <div class="nav-sect">Menu Utama</div>
        <a href="admin.php#user" class="nav-lnk">
            <i class="bi bi-people-fill"></i> Kelola Admin
        </a>
        <a href="kelola_berita.php" class="nav-lnk">
            <i class="bi bi-newspaper"></i> Kelola Berita
        </a>
        <a href="kelola_kegiatan.php" class="nav-lnk active">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>
        <a href="data_form.php" class="nav-lnk">
            <i class="bi bi-envelope-open-fill"></i> Data Form
        </a>
    </nav>

    <div class="sb-foot">
        <div class="sb-user">
            <div class="sb-avi"><?= htmlspecialchars($initials); ?></div>
            <div>
                <div class="sb-name"><?= htmlspecialchars($current_admin); ?></div>
                <div class="sb-role">Super Admin</div>
            </div>
            <a href="logout.php" class="sb-logout" title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn d-md-none me-3" id="sidebarToggle" style="border:none; padding:0; background:transparent; outline:none;">
                <i class="bi bi-list" style="font-size: 1.8rem; color: var(--red);"></i>
            </button>
            
            <div>
                <div class="tb-title">Dashboard Overview</div> <!-- Sesuaikan judul per halaman -->
                <div class="tb-sub">Sistem Informasi Program Studi Bahasa Mandarin — Ma Chung</div>
            </div>
        </div>
    </div>

    <div class="sec" id="kegiatan">
        <div class="sec-head">
            <div class="sec-ttl">
                <div class="sec-ico ic-amber"><i class="bi bi-calendar-event"></i></div>
                <div>
                    <h5>Kelola Agenda & Kegiatan</h5>
                    <small>Poster dan jadwal kegiatan program studi</small>
                </div>
            </div>
            <button class="btn-red" data-bs-toggle="modal" data-bs-target="#mKegiatan">
                <i class="bi bi-plus-lg"></i> Tambah Kegiatan
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table class="dtbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Kegiatan</th>
                        <th>Poster / Gambar</th>
                        <th>Waktu</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY waktu_kegiatan DESC");
                if (mysqli_num_rows($q) > 0):
                    while ($r = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td><span class="tid"><?= htmlspecialchars($r['id_kegiatan']); ?></span></td>
                        <td class="t-bold"><?= htmlspecialchars($r['judul']); ?></td>
                        <td><div class="t-sub"><i class="bi bi-image" style="color:var(--red);"></i><?= htmlspecialchars($r['gambar']); ?></div></td>
                        <td><span class="pill p-amber"><?= htmlspecialchars($r['waktu_kegiatan']); ?></span></td>
                        <td class="t-acts">
                            <button class="iBtn iBtn-edit" title="Edit"><i class="bi bi-pencil-square"></i></button>
                            <button class="iBtn iBtn-del"  title="Hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--t3);">Belum ada data kegiatan</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="mKegiatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="m-hd">
                <div class="m-hd-l">
                    <div class="m-hd-ico ic-amber"><i class="bi bi-calendar-event"></i></div>
                    <h5>Tambah Kegiatan Baru</h5>
                </div>
                <button class="m-close" data-bs-dismiss="modal"><i class="bi bi-x"></i></button>
            </div>
            <form action="proses_tambah_kegiatan.php" method="POST" enctype="multipart/form-data">
                <div class="m-body">
                    <div class="grid2">
                        <div class="fg">
                            <label class="fl">ID Kegiatan</label>
                            <input type="text" class="fi" name="id_kegiatan" placeholder="Contoh: KGT-001" required>
                        </div>
                        <div class="fg">
                            <label class="fl">Waktu Kegiatan</label>
                            <input type="date" class="fi" name="waktu_kegiatan" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="fl">Judul Kegiatan</label>
                        <input type="text" class="fi" name="judul" placeholder="Masukkan judul kegiatan" required>
                    </div>
                    <div class="fg">
                        <label class="fl">Upload Poster / Gambar</label>
                        <input type="file" class="fi" name="gambar" accept=".jpg,.jpeg,.png" required>
                        <div class="fh"><i class="bi bi-image"></i>Format: JPG, JPEG, PNG</div>
                    </div>
                </div>
                <div class="m-foot">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn-red">Simpan Kegiatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        // Ketika tombol hamburger diklik
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah efek klik bocor ke belakang
            sidebar.classList.toggle('show-sidebar');
        });

        // Fitur Tambahan: Tutup sidebar secara otomatis jika user klik di luar sidebar (area konten)
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) { // Hanya berlaku di HP
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show-sidebar');
                }
            }
        });
    }
});
</script>
</body>
</html>