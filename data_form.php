<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$current_admin = $_SESSION["id_admin"];
$count_form    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM form"))['total'];
$initials = strtoupper(substr($current_admin, 0, 2));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Form — Ma Chung Mandarin</title>
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
        <a href="kelola_kegiatan.php" class="nav-lnk">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>
        <a href="data_form.php" class="nav-lnk active">
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

    <div class="sec" id="form">
        <div class="sec-head">
            <div class="sec-ttl">
                <div class="sec-ico ic-red"><i class="bi bi-envelope-open-fill"></i></div>
                <div>
                    <h5>Data Form Masuk</h5>
                    <small>Pesan & pertanyaan dari calon mahasiswa</small>
                </div>
            </div>
            <span class="pill p-red"><?= $count_form; ?> Pesan Baru</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="dtbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Kontak</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM form");
                if (mysqli_num_rows($q) > 0):
                    while ($r = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td><span class="tid"><?= htmlspecialchars($r['id_form']); ?></span></td>
                        <td class="t-bold"><?= htmlspecialchars($r['full_name']); ?></td>
                        <td>
                            <div class="t-sub"><i class="bi bi-envelope" style="color:var(--red);"></i><?= htmlspecialchars($r['email']); ?></div>
                            <div class="t-sub" style="margin-top:3px;"><i class="bi bi-telephone-fill" style="color:var(--teal);"></i><?= htmlspecialchars($r['phone']); ?></div>
                        </td>
                        <td><div class="msg-bbl"><?= htmlspecialchars($r['message']); ?></div></td>
                        <td>
                            <?php if (empty($r['id_admin'])): ?>
                                <span class="pill p-ghost">Belum direspon</span>
                            <?php else: ?>
                                <span class="pill p-teal">✓ Sudah Direspon</span>
                            <?php endif; ?>
                        </td>
                        <td class="t-acts">
                            <a href="remove_form.php?id_form=<?= urlencode($r['id_form']); ?>" class="iBtn iBtn-del" title="Hapus" onclick="return confirm('Yakin ingin menghapus pesan form ini?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--t3);">Belum ada pesan masuk</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah efek klik bocor ke belakang
            sidebar.classList.toggle('show-sidebar');
        });

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