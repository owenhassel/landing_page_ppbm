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
<title>Kelola Berita — Ma Chung Mandarin</title>
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
        <a href="admin.php" class="nav-lnk">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <div class="nav-sect">Manajemen Konten</div>
        <a href="admin.php#user" class="nav-lnk">
            <i class="bi bi-people-fill"></i> Kelola Admin
        </a>
        <a href="kelola_berita.php" class="nav-lnk active">
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
            <div class="tb-title">Manajemen Berita</div>
            <div class="tb-sub">Sistem Informasi Program Studi Bahasa Mandarin — Ma Chung</div>
        </div>
        <div class="tb-right">
            <button class="tb-btn" title="Notifikasi"><i class="bi bi-bell"></i></button>
            <div class="dropdown">
                <a class="tb-profile dropdown-toggle" id="ddProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="tb-avi"><?= htmlspecialchars($initials); ?></div>
                    <span class="tb-uname"><?= htmlspecialchars($current_admin); ?></span>
                    <i class="bi bi-chevron-down" style="font-size:10px;color:var(--t3);"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="ddProfile">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2 text-secondary"></i>Profil Saya</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2 text-secondary"></i>Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sec" id="berita">
        <div class="sec-head">
            <div class="sec-ttl">
                <div class="sec-ico ic-slate"><i class="bi bi-newspaper"></i></div>
                <div>
                    <h5>Kelola Data Berita</h5>
                    <small>Artikel dan konten berita program studi</small>
                </div>
            </div>
            <button class="btn-red" data-bs-toggle="modal" data-bs-target="#mBerita">
                <i class="bi bi-plus-lg"></i> Tambah Berita
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table class="dtbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Berita</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Penulis</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY date DESC");
                if (mysqli_num_rows($q) > 0):
                    while ($r = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td><span class="tid"><?= htmlspecialchars($r['id_berita']); ?></span></td>
                        <td>
                            <div class="t-bold"><?= htmlspecialchars($r['judul']); ?></div>
                            <div class="t-sub"><i class="bi bi-image" style="color:var(--red);"></i><?= htmlspecialchars($r['gambar']); ?></div>
                        </td>
                        <td><div class="t-clip"><?= htmlspecialchars($r['deskripsi']); ?></div></td>
                        <td><div class="t-sub"><i class="bi bi-calendar3"></i><?= htmlspecialchars($r['date']); ?></div></td>
                        <td><span class="pill p-slate"><?= htmlspecialchars($r['penulis']); ?></span></td>
                        <td class="t-acts">
                            <button class="iBtn iBtn-edit" title="Edit"><i class="bi bi-pencil-square"></i></button>
                            <button class="iBtn iBtn-del"  title="Hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--t3);">Belum ada data berita</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="mBerita" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="m-hd">
                <div class="m-hd-l">
                    <div class="m-hd-ico ic-slate"><i class="bi bi-newspaper"></i></div>
                    <h5>Tambah Berita Baru</h5>
                </div>
                <button class="m-close" data-bs-dismiss="modal"><i class="bi bi-x"></i></button>
            </div>
            <form action="proses_tambah_berita.php" method="POST" enctype="multipart/form-data">
                <div class="m-body">
                    <div class="grid2">
                        <div class="fg">
                            <label class="fl">ID Berita</label>
                            <input type="text" class="fi" name="id_berita" placeholder="Contoh: BRT-003" required>
                        </div>
                        <div class="fg">
                            <label class="fl">Tanggal</label>
                            <input type="date" class="fi" name="date" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="fl">Judul Berita</label>
                        <input type="text" class="fi" name="judul" placeholder="Masukkan judul berita" required>
                    </div>
                    <div class="fg">
                        <label class="fl">Kategori / Penulis</label>
                        <input type="text" class="fi" name="penulis" placeholder="Contoh: Humas, Kemahasiswaan" required>
                    </div>
                    <div class="fg">
                        <label class="fl">Deskripsi</label>
                        <textarea class="fi" name="deskripsi" rows="3" placeholder="Tuliskan deskripsi berita..." required></textarea>
                    </div>
                    <div class="fg">
                        <label class="fl">Upload Gambar</label>
                        <input type="file" class="fi" name="gambar" accept=".jpg,.jpeg,.png" required>
                        <div class="fh"><i class="bi bi-image"></i>Format: JPG, JPEG, PNG</div>
                    </div>
                </div>
                <div class="m-foot">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn-red">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>