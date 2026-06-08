<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$current_admin = $_SESSION["id_admin"];
$count_admin    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$count_berita   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM berita"))['total'];
$count_kegiatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM kegiatan"))['total'];
$count_form     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM form"))['total'];
$initials = strtoupper(substr($current_admin, 0, 2));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — Ma Chung Mandarin</title>
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
        <a href="admin.php#user" class="nav-lnk active">
            <i class="bi bi-people-fill"></i> Kelola Admin
        </a>
        <a href="kelola_berita.php" class="nav-lnk">
            <i class="bi bi-newspaper"></i> Kelola Berita
        </a>
        <a href="kelola_kegiatan.php" class="nav-lnk">
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
        <div>
            <div class="tb-title">Dashboard Overview</div>
            <div class="tb-sub">Sistem Informasi Program Studi Bahasa Mandarin — Ma Chung</div>
        </div>
    </div>

    <div class="stats" id="dashboard">
        <div class="scard ac-red">
            <div class="scard-top">
                <span class="scard-badge bd-red">Admin</span>
                <div class="scard-ico ic-red"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="scard-num"><?= $count_admin; ?></div>
            <div class="scard-desc">Akun admin aktif terdaftar</div>
        </div>
        <div class="scard ac-slate">
            <div class="scard-top">
                <span class="scard-badge bd-slate">Berita</span>
                <div class="scard-ico ic-slate"><i class="bi bi-newspaper"></i></div>
            </div>
            <div class="scard-num"><?= $count_berita; ?></div>
            <div class="scard-desc">Artikel berita terpublish</div>
        </div>
        <div class="scard ac-amber">
            <div class="scard-top">
                <span class="scard-badge bd-amber">Kegiatan</span>
                <div class="scard-ico ic-amber"><i class="bi bi-calendar-event"></i></div>
            </div>
            <div class="scard-num"><?= $count_kegiatan; ?></div>
            <div class="scard-desc">Agenda kegiatan terdaftar</div>
        </div>
        <div class="scard ac-teal">
            <div class="scard-top">
                <span class="scard-badge bd-teal">Form</span>
                <div class="scard-ico ic-teal"><i class="bi bi-envelope-open-fill"></i></div>
            </div>
            <div class="scard-num"><?= $count_form; ?></div>
            <div class="scard-desc">Pesan masuk dari pengunjung</div>
        </div>
    </div>

    <div class="sec" id="user">
        <div class="sec-head">
            <div class="sec-ttl">
                <div class="sec-ico ic-red"><i class="bi bi-people-fill"></i></div>
                <div>
                    <h5>Kelola Akun Admin</h5>
                    <small>Manajemen akses administrator sistem</small>
                </div>
            </div>
            <button class="btn-red" data-bs-toggle="modal" data-bs-target="#mAdmin">
                <i class="bi bi-plus-lg"></i> Tambah Admin
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table class="dtbl">
                <thead>
                    <tr>
                        <th>Username / ID Admin</th>
                        <th>Passcode</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM users");
                if (mysqli_num_rows($q) > 0):
                    while ($r = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td>
                            <div class="t-bold"><?= htmlspecialchars($r['id_admin']); ?></div>
                            <div class="t-sub"><i class="bi bi-person"></i> Administrator</div>
                        </td>
                        <td><span style="letter-spacing:3px;color:var(--t3);">••••••••</span></td>
                        <td><span class="pill p-teal">● Aktif</span></td>
                        <td class="t-acts">
                            <button class="iBtn iBtn-edit" title="Edit"><i class="bi bi-pencil-square"></i></button>
                            <button class="iBtn iBtn-del"  title="Hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="4" style="text-align:center;padding:40px;color:var(--t3);">Belum ada data admin</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="mAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="m-hd">
                <div class="m-hd-l">
                    <div class="m-hd-ico ic-red"><i class="bi bi-person-plus-fill"></i></div>
                    <h5>Tambah Admin Baru</h5>
                </div>
                <button class="m-close" data-bs-dismiss="modal"><i class="bi bi-x"></i></button>
            </div>
            <form action="proses_tambah_admin.php" method="POST">
                <div class="m-body">
                    <div class="fg">
                        <label class="fl">Username / ID Admin</label>
                        <input type="text" class="fi" name="id_admin" placeholder="Masukkan username admin" required>
                    </div>
                    <div class="fg">
                        <label class="fl">Password</label>
                        <input type="password" class="fi" name="passcode" placeholder="Masukkan password" required>
                        <div class="fh"><i class="bi bi-shield-lock"></i>Password dienkripsi sebelum disimpan.</div>
                    </div>
                </div>
                <div class="m-foot">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn-red">Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>