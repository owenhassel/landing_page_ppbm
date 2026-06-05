<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Prodi Mandarin Ma Chung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Tema Warna Utama */
            --machung-red: #b71c1c;
            --machung-red-hover: #800000;
            --machung-grey: #961515;
            --machung-dark-text: #333333;
            --machung-light-bg: #f4f6f9;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--machung-light-bg);
            color: var(--machung-dark-text);
        }
 
        .serif {
            font-family: 'Crimson Text', serif;
        }
 
        /* Sidebar Styling (Silver/Grey Theme) */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--machung-grey);
            box-shadow: 2px 0 15px rgba(0,0,0,0.08);
            z-index: 100;
            transition: all 0.3s;
        }
 
        .sidebar-brand {
            padding: 25px 20px;
        }
 
        .sidebar-brand h4 {
            color: #ffffff; /* Putih agar kontras di atas abu-abu */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
 
        .sidebar-brand .brand-red {
            color: #800000; /* Merah gelap untuk variasi */
            background-color: #ffffff;
            padding: 2px 8px;
            border-radius: 4px;
        }
 
        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }
 
        .sidebar-menu li {
            margin-bottom: 5px;
            padding: 0 15px;
        }
 
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ffffff; /* Teks putih agar elegan */
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
            border-radius: 8px;
        }
 
        .sidebar-menu li a:hover {
            color: var(--machung-red);
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
 
        .sidebar-menu li a.active {
            color: #fff;
            background-color: var(--machung-red);
            box-shadow: 0 4px 10px rgba(183, 28, 28, 0.3);
        }
 
        .sidebar-menu li a i {
            font-size: 1.25rem;
            margin-right: 15px;
        }
 
        /* Main Content Styling */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
        }
 
        /* Top Navbar Styling */
        .top-navbar {
            background-color: #fff;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(164, 164, 164, 0.15); /* Shadow menggunakan warna grey */
            margin-bottom: 30px;
        }
 
        /* Dashboard Stat Cards (Red & Grey Theme) */
        .stat-card {
            background-color: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(164, 164, 164, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
 
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(164, 164, 164, 0.25);
        }
 
        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
        }
 
        .icon-red { background-color: var(--machung-red); }
        .icon-grey { background-color: var(--machung-grey); }
 
        /* Data Section / Tables Styling */
        .data-card {
            background-color: #fff;
            border: none;
            border-top: 4px solid var(--machung-grey);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(164, 164, 164, 0.15);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .data-card.border-red {
            border-top: 4px solid var(--machung-red);
        }
 
        .table th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
 
        .table td {
            vertical-align: middle;
            color: #444;
        }
 
        .btn-action {
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 6px;
            transition: all 0.2s;
        }
 
        .btn-add {
            background-color: var(--machung-red);
            color: #fff;
            border: none;
            font-weight: 500;
        }
        
        .btn-add:hover {
            background-color: var(--machung-red-hover);
            color: #fff;
            box-shadow: 0 4px 10px rgba(183, 28, 28, 0.2);
        }
 
        /* Badge Customization */
        .badge-red { background-color: var(--machung-red); color: white; }
        .badge-grey { background-color: var(--machung-grey); color: white; }
 
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
 
    <div class="sidebar">
        <div class="sidebar-brand text-center">
            <h4 class="m-0 serif fw-bold" style="letter-spacing: 1px; font-size: 2rem;">MA CHUNG</h4>
            <small class="text-white mt-2 d-block" style="font-size: 1rem; opacity: 0.9;">PPBM Admin Panel</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#dashboard" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="#user"><i class="bi bi-people-fill"></i> Kelola Admin</a></li>
            <li><a href="#berita"><i class="bi bi-newspaper"></i> Kelola Berita</a></li>
            <li><a href="#kegiatan"><i class="bi bi-calendar-event"></i> Kelola Kegiatan</a></li>
            <li><a href="#form"><i class="bi bi-envelope-open-fill"></i> Data Form</a></li>
        </ul>
    </div>
 
    <div class="main-content">
        
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0 fw-bold text-dark">Dashboard Overview</h4>
                <p class="text-muted small m-0">Sistem Informasi Program Studi Bahasa Mandarin</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-light border-0 shadow-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-2" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 50px;">
                    <i class="bi bi-person-circle fs-5" style="color: var(--machung-red);"></i>
                    <span class="fw-medium">Administrator</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                    <li><a class="dropdown-menu-item dropdown-item py-2" href="#"><i class="bi bi-gear me-2 text-secondary"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-menu-item dropdown-item text-danger py-2" href="#"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>
 
        <div class="row g-4 mb-4" id="dashboard">
            <div class="col-6 col-lg-3">
                <div class="card stat-card h-100 border-start border-danger border-4">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Total Admin</p>
                            <h3 class="m-0 fw-bold" style="color: var(--machung-red);">2</h3>
                        </div>
                        <div class="stat-icon icon-red shadow-sm">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card h-100" style="border-left: 4px solid var(--machung-grey);">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Total Berita</p>
                            <h3 class="m-0 fw-bold" style="color: var(--machung-dark-text);">3</h3>
                        </div>
                        <div class="stat-icon icon-grey shadow-sm">
                            <i class="bi bi-newspaper"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card h-100" style="border-left: 4px solid var(--machung-grey);">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Total Kegiatan</p>
                            <h3 class="m-0 fw-bold" style="color: var(--machung-dark-text);">3</h3>
                        </div>
                        <div class="stat-icon icon-grey shadow-sm">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card h-100 border-start border-danger border-4">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Form Masuk</p>
                            <h3 class="m-0 fw-bold" style="color: var(--machung-red);">2</h3>
                        </div>
                        <div class="stat-icon icon-red shadow-sm">
                            <i class="bi bi-envelope-open-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        <div id="user" class="card data-card border-red">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-people-fill me-2" style="color: var(--machung-red);"></i> Kelola Akun Admin</h5>
                <button class="btn btn-add rounded-pill px-4 py-2 shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Admin</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle">
                    <thead>
                        <tr>
                            <th width="200">ID Admin (Username)</th>
                            <th>Passcode</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold text-dark">admin_01</td>
                            <td class="text-muted">•••••••• (Tersembunyi)</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold text-dark">owen_admin</td>
                            <td class="text-muted">•••••••• (Tersembunyi)</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
 
        <div id="berita" class="card data-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-newspaper me-2" style="color: var(--machung-grey);"></i> Kelola Data Berita</h5>
                <button class="btn btn-add rounded-pill px-4 py-2 shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Berita</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle">
                    <thead>
                        <tr>
                            <th width="100">ID Berita</th>
                            <th>Judul & Gambar</th>
                            <th>Deskripsi</th>
                            <th width="120">Date</th>
                            <th width="120">Penulis</th>
                            <th width="100">ID Admin</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">BRT-001</td>
                            <td>
                                <div class="fw-bold text-dark">Kelas Kolaboratif EWDW</div>
                                <div class="text-muted small"><i class="bi bi-image me-1"></i>ewdw.png</div>
                            </td>
                            <td><p class="mb-0 text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Universitas Ma Chung terus mendorong mahasiswanya memiliki pengalaman global...</p></td>
                            <td><span class="text-muted small"><i class="bi bi-clock me-1"></i>2026-06-04</span></td>
                            <td><span class="badge badge-grey rounded-pill">Humas</span></td>
                            <td class="fw-bold text-muted small">admin_01</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">BRT-002</td>
                            <td>
                                <div class="fw-bold text-dark">Atlet Wushu Ma Chung Juara</div>
                                <div class="text-muted small"><i class="bi bi-image me-1"></i>wushu.png</div>
                            </td>
                            <td><p class="mb-0 text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Samuel Enrico Jose Fernando berhasil mengukir prestasi membanggakan...</p></td>
                            <td><span class="text-muted small"><i class="bi bi-clock me-1"></i>2026-06-02</span></td>
                            <td><span class="badge badge-grey rounded-pill">Kemahasiswaan</span></td>
                            <td class="fw-bold text-muted small">owen_admin</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
 
        <div id="kegiatan" class="card data-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-calendar-event me-2" style="color: var(--machung-grey);"></i> Kelola Agenda & Kegiatan</h5>
                <button class="btn btn-add rounded-pill px-4 py-2 shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Kegiatan</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle">
                    <thead>
                        <tr>
                            <th width="120">ID Kegiatan</th>
                            <th>Judul Kegiatan</th>
                            <th>File Gambar (Poster)</th>
                            <th width="150">Waktu Kegiatan</th>
                            <th width="120">ID Admin</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">KGT-001</td>
                            <td class="fw-bold text-dark">Sinoculture of Imlek</td>
                            <td class="text-muted small"><i class="bi bi-image text-danger me-1"></i>imlek_poster.jpg</td>
                            <td><span class="badge badge-red rounded-pill fw-normal">2026-02-23</span></td>
                            <td class="fw-bold text-muted small">owen_admin</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">KGT-002</td>
                            <td class="fw-bold text-dark">Chinese Bridge Competition PT</td>
                            <td class="text-muted small"><i class="bi bi-image text-danger me-1"></i>cb_pt_2025.jpg</td>
                            <td><span class="badge badge-red rounded-pill fw-normal">2025-05-24</span></td>
                            <td class="fw-bold text-muted small">admin_01</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-primary me-1 border shadow-sm"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-action text-danger border shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
 
        <div id="form" class="card data-card border-red">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-envelope-open-fill me-2" style="color: var(--machung-red);"></i> Data Form Masuk</h5>
                <span class="badge badge-red rounded-pill px-3 py-2 shadow-sm">2 Pesan Baru</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle">
                    <thead>
                        <tr>
                            <th width="100">ID Form</th>
                            <th>Full Name</th>
                            <th>Kontak (Email / Phone)</th>
                            <th>Message</th>
                            <th width="120">ID Admin</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">FRM-001</td>
                            <td class="fw-bold text-dark">Budi Santoso</td>
                            <td>
                                <div class="text-muted small"><i class="bi bi-envelope me-1"></i>budi.s@example.com</div>
                                <div class="text-muted small"><i class="bi bi-telephone-fill text-success me-1"></i>081234567890</div>
                            </td>
                            <td><p class="mb-0 text-dark small" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; background: #f8f9fa; padding: 10px; border-radius: 6px; border-left: 3px solid var(--machung-red);">Saya ingin bertanya mengenai kuota pendaftaran beasiswa...</p></td>
                            <td class="text-muted small fst-italic">Belum direspon</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-danger border shadow-sm" title="Hapus Pesan"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="fw-bold">FRM-002</td>
                            <td class="fw-bold text-dark">Siti Aminah</td>
                            <td>
                                <div class="text-muted small"><i class="bi bi-envelope me-1"></i>sitia@example.com</div>
                                <div class="text-muted small"><i class="bi bi-telephone-fill text-success me-1"></i>085712345678</div>
                            </td>
                            <td><p class="mb-0 text-dark small" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; background: #f8f9fa; padding: 10px; border-radius: 6px; border-left: 3px solid var(--machung-red);">Apakah program short course pertukaran ke Hunan Normal...</p></td>
                            <td class="fw-bold text-dark small">owen_admin</td>
                            <td class="text-center">
                                <button class="btn btn-light btn-action text-danger border shadow-sm" title="Hapus Pesan"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
 
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>