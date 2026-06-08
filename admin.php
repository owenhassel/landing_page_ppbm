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
<style>
/* =======================================================
   MA CHUNG ADMIN PANEL — DESIGN SYSTEM v2.0
   ======================================================= */
:root {
    --red:        #C12020;
    --red-hover:  #971818;
    --red-light:  #FEEDED;
    --red-mid:    rgba(193,32,32,0.12);

    --sidebar:    #700000;
    --sidebar-w:  268px;

    --bg:         #F2F1ED;
    --card:       #FFFFFF;
    --border:     #E6E5E1;
    --divider:    #F0EFEB;

    --t1: #19181A;
    --t2: #4B4B50;
    --t3: #97979C;

    --amber:      #D17A00;
    --amber-bg:   #FEF3DC;
    --teal:       #0C9488;
    --teal-bg:    #D1FAF5;
    --slate:      #3F5068;
    --slate-bg:   #EDF1F6;

    --r:    12px;
    --r-lg: 16px;
    --r-sm: 8px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--t1);
    font-size: 14px;
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
}

/* ─── SIDEBAR ───────────────────────────────── */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sidebar-w);
    height: 100vh;
    background: var(--sidebar);
    display: flex;
    flex-direction: column;
    z-index: 300;
    overflow: hidden;
}
.sidebar::after {
    content: '';
    position: absolute;
    inset: 0 0 auto 0;
    height: 2px;
    background: linear-gradient(90deg, var(--red) 0%, #e57373 60%, transparent 100%);
}
.sidebar::before {
    content: '';
    position: absolute;
    top: -80px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(193,32,32,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.sb-brand {
    padding: 30px 24px 22px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    flex-shrink: 0;
    position: relative;
}
.sb-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: 4px;
    line-height: 1;
}
.sb-rule {
    width: 26px;
    height: 2px;
    background: var(--red);
    margin: 9px 0 7px;
}
.sb-sub {
    font-size: 10px;
    color: rgba(255,255,255,0.3);
    letter-spacing: 2.5px;
    text-transform: uppercase;
    font-weight: 500;
}

.sb-nav {
    flex: 1;
    overflow-y: auto;
    padding: 10px 12px 16px;
    scrollbar-width: none;
}
.sb-nav::-webkit-scrollbar { display: none; }

.nav-sect {
    padding: 16px 12px 5px;
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 2.2px;
    color: rgba(255,255,255,0.18);
    text-transform: uppercase;
    user-select: none;
}

.nav-lnk {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px 13px;
    border-radius: var(--r-sm);
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.18s;
    margin-bottom: 2px;
}
.nav-lnk:hover  { color: rgba(255,255,255,0.9); background: rgba(255,255,255,0.06); }
.nav-lnk.active { background: var(--red); color: #fff; box-shadow: 0 4px 14px rgba(193,32,32,0.35); }
.nav-lnk i { font-size: 1rem; width: 18px; text-align: center; flex-shrink: 0; }

.sb-foot {
    padding: 14px 18px 20px;
    border-top: 1px solid rgba(255,255,255,0.05);
    flex-shrink: 0;
}
.sb-user { display: flex; align-items: center; gap: 10px; }
.sb-avi {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--red), #e57373);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
}
.sb-name { font-size: 13px; font-weight: 600; color: #fff; line-height: 1.2; }
.sb-role { font-size: 11px; color: rgba(255,255,255,0.32); }
.sb-logout {
    margin-left: auto;
    width: 28px; height: 28px;
    border-radius: 7px;
    border: 1px solid rgba(255,255,255,0.07);
    background: transparent;
    color: rgba(255,255,255,0.36);
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; font-size: 13px; transition: all 0.18s;
}
.sb-logout:hover { background: rgba(193,32,32,0.22); border-color: rgba(193,32,32,0.4); color: #ff9999; }

/* ─── MAIN ───────────────────────────────────── */
.main {
    margin-left: var(--sidebar-w);
    padding: 26px 30px;
    min-height: 100vh;
}

/* ─── TOPBAR ─────────────────────────────────── */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--card);
    border-radius: var(--r-lg);
    padding: 14px 22px;
    margin-bottom: 22px;
    border: 1px solid var(--border);
}
.tb-title { font-size: 15px; font-weight: 700; color: var(--t1); }
.tb-sub   { font-size: 12px; color: var(--t3); margin-top: 1px; }
.tb-right { display: flex; align-items: center; gap: 8px; }

.tb-btn {
    width: 36px; height: 36px;
    border-radius: var(--r-sm);
    border: 1px solid var(--border);
    background: transparent;
    color: var(--t2);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 14px; transition: all 0.18s;
}
.tb-btn:hover { background: var(--bg); }

.tb-profile {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 12px 5px 6px;
    border: 1px solid var(--border);
    border-radius: 50px;
    background: transparent;
    cursor: pointer;
    text-decoration: none; color: var(--t1);
    transition: all 0.18s;
}
.tb-profile:hover { background: var(--bg); color: var(--t1); }
.tb-avi {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--red), #e57373);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; color: #fff;
}
.tb-uname { font-size: 13px; font-weight: 600; }

/* ─── STAT CARDS ─────────────────────────────── */
.stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 22px;
}
@media (max-width: 1100px) { .stats { grid-template-columns: repeat(2,1fr); } }

.scard {
    background: var(--card);
    border-radius: var(--r-lg);
    padding: 20px 20px 18px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    animation: fadeUp 0.4s ease both;
}
.scard:nth-child(2) { animation-delay:.06s; }
.scard:nth-child(3) { animation-delay:.12s; }
.scard:nth-child(4) { animation-delay:.18s; }
.scard:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
.scard::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--r-lg) var(--r-lg) 0 0;
}
.scard.ac-red::before    { background: var(--red); }
.scard.ac-slate::before  { background: var(--slate); }
.scard.ac-amber::before  { background: var(--amber); }
.scard.ac-teal::before   { background: var(--teal); }

.scard-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
.scard-badge {
    display: inline-flex;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 10.5px; font-weight: 700;
    letter-spacing: 0.3px; text-transform: uppercase;
}
.bd-red   { background: var(--red-light);  color: var(--red);   }
.bd-slate { background: var(--slate-bg);   color: var(--slate); }
.bd-amber { background: var(--amber-bg);   color: var(--amber); }
.bd-teal  { background: var(--teal-bg);    color: var(--teal);  }

.scard-ico {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; flex-shrink: 0;
}
.ic-red   { background: var(--red-light);  color: var(--red);   }
.ic-slate { background: var(--slate-bg);   color: var(--slate); }
.ic-amber { background: var(--amber-bg);   color: var(--amber); }
.ic-teal  { background: var(--teal-bg);    color: var(--teal);  }

.scard-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.7rem; font-weight: 700;
    color: var(--t1); line-height: 1;
    margin-bottom: 4px;
}
.scard-desc { font-size: 12px; color: var(--t3); }

/* ─── SECTION CARD ───────────────────────────── */
.sec {
    background: var(--card);
    border-radius: var(--r-lg);
    padding: 22px 26px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
    animation: fadeUp 0.4s ease 0.22s both;
}

.sec-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--divider);
}
.sec-ttl { display: flex; align-items: center; gap: 11px; }
.sec-ico {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; flex-shrink: 0;
}
.sec-ttl h5 { font-size: 14.5px; font-weight: 700; margin: 0; }
.sec-ttl small { display: block; font-size: 11.5px; color: var(--t3); margin-top: 1px; }

/* ─── BUTTONS ────────────────────────────────── */
.btn-red {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--r-sm);
    font-size: 13px; font-weight: 600; font-family: inherit;
    cursor: pointer; transition: all 0.18s; text-decoration: none;
}
.btn-red:hover { background: var(--red-hover); color: #fff; box-shadow: 0 4px 14px rgba(193,32,32,0.26); transform: translateY(-1px); }

.btn-ghost {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px;
    background: transparent; color: var(--t2);
    border: 1.5px solid var(--border); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 600; font-family: inherit;
    cursor: pointer; transition: all 0.18s;
}
.btn-ghost:hover { background: var(--bg); }

.iBtn {
    width: 31px; height: 31px;
    border-radius: 7px;
    border: 1px solid var(--border);
    background: transparent;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: all 0.15s;
    text-decoration: none; line-height: 1;
}
.iBtn-edit   { color: #2563EB; }
.iBtn-del    { color: #DC2626; }
.iBtn-edit:hover { background: #EFF6FF; border-color: #BFDBFE; }
.iBtn-del:hover  { background: #FEF2F2; border-color: #FECACA; }

/* ─── TABLE ──────────────────────────────────── */
.dtbl { width: 100%; border-collapse: collapse; }
.dtbl thead th {
    padding: 10px 14px;
    text-align: left;
    font-size: 10.5px; font-weight: 700;
    color: var(--t3); letter-spacing: 0.8px; text-transform: uppercase;
    background: #FAFAF8; border-bottom: 1px solid var(--divider);
    white-space: nowrap;
}
.dtbl thead th:first-child { border-radius: var(--r-sm) 0 0 0; }
.dtbl thead th:last-child  { border-radius: 0 var(--r-sm) 0 0; }
.dtbl tbody td {
    padding: 13px 14px;
    border-bottom: 1px solid var(--divider);
    vertical-align: middle; font-size: 13.5px;
}
.dtbl tbody tr:last-child td { border-bottom: none; }
.dtbl tbody tr:hover { background: #FAFAF8; }

.tid {
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: 11.5px; color: var(--t3);
    background: var(--divider);
    padding: 3px 8px; border-radius: 5px;
    display: inline-block; letter-spacing: 0.2px;
}
.t-bold  { font-weight: 600; color: var(--t1); }
.t-sub   { font-size: 12px; color: var(--t3); display: flex; align-items: center; gap: 4px; margin-top: 1px; }
.t-clip  { font-size: 12.5px; color: var(--t2); max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.t-acts  { display: flex; align-items: center; gap: 5px; justify-content: center; }

.pill {
    display: inline-flex; align-items: center;
    padding: 3px 9px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600;
}
.p-red   { background: var(--red-light);  color: var(--red); }
.p-slate { background: var(--slate-bg);   color: var(--slate); }
.p-amber { background: var(--amber-bg);   color: var(--amber); }
.p-teal  { background: var(--teal-bg);    color: var(--teal); }
.p-ghost { background: transparent; border: 1px solid var(--border); color: var(--t3); font-style: italic; font-weight: 400; }

.msg-bbl {
    background: #FAFAF8;
    border-left: 3px solid var(--red);
    border-radius: 0 6px 6px 0;
    padding: 8px 12px;
    font-size: 12.5px; color: var(--t2);
    max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

/* ─── MODAL ──────────────────────────────────── */
.modal-content  { border: none; border-radius: var(--r-lg); overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.14); }
.m-hd {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 26px;
    border-bottom: 1px solid var(--border);
}
.m-hd-l { display: flex; align-items: center; gap: 10px; }
.m-hd-ico {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.m-hd h5 { font-size: 15px; font-weight: 700; margin: 0; }
.m-close {
    width: 28px; height: 28px; border-radius: 7px;
    border: 1px solid var(--border); background: transparent; color: var(--t3);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 13px; transition: all 0.15s;
}
.m-close:hover { background: #FEF2F2; color: var(--red); border-color: #FECACA; }
.m-body { padding: 24px 26px; }
.m-foot {
    padding: 15px 26px;
    background: #FAFAF8; border-top: 1px solid var(--border);
    display: flex; justify-content: flex-end; gap: 8px;
}

.fg { margin-bottom: 17px; }
.fg:last-child { margin-bottom: 0; }
.fl { display: block; font-size: 12.5px; font-weight: 600; color: var(--t2); margin-bottom: 6px; }
.fi {
    width: 100%; padding: 10px 13px;
    border: 1.5px solid var(--border); border-radius: var(--r-sm);
    font-family: inherit; font-size: 13.5px; color: var(--t1);
    background: #fff; outline: none; transition: border-color 0.18s, box-shadow 0.18s;
}
.fi:focus { border-color: var(--red); box-shadow: 0 0 0 3px var(--red-mid); }
textarea.fi { resize: vertical; }
.fh { font-size: 11.5px; color: var(--t3); margin-top: 5px; display: flex; align-items: center; gap: 4px; }
.grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* ─── DROPDOWN override ──────────────────────── */
.dropdown-menu { border: 1px solid var(--border); border-radius: var(--r); box-shadow: 0 8px 28px rgba(0,0,0,0.09); padding: 6px; }
.dropdown-item { border-radius: var(--r-sm); font-size: 13.5px; padding: 8px 12px; color: var(--t2); }
.dropdown-item:hover { background: var(--bg); }
.dropdown-divider { border-color: var(--divider); margin: 4px 0; }

/* ─── SCROLLBAR ──────────────────────────────── */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #D0CECA; border-radius: 10px; }

/* ─── ANIMATION ──────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ─── RESPONSIVE ─────────────────────────────── */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; padding: 16px; }
    .stats { grid-template-columns: repeat(2,1fr); gap: 12px; }
    .grid2 { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- ═══════════════════════════════════════════════
     SIDEBAR
     ═══════════════════════════════════════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">MA CHUNG</div>
        <div class="sb-rule"></div>
        <div class="sb-sub">PPBM Admin Panel</div>
    </div>

    <nav class="sb-nav">
        <div class="nav-sect">Menu Utama</div>
        <a href="#dashboard" class="nav-lnk active" data-section="dashboard">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <div class="nav-sect">Manajemen Konten</div>
        <a href="#user" class="nav-lnk" data-section="user">
            <i class="bi bi-people-fill"></i> Kelola Admin
        </a>
        <a href="#berita" class="nav-lnk" data-section="berita">
            <i class="bi bi-newspaper"></i> Kelola Berita
        </a>
        <a href="#kegiatan" class="nav-lnk" data-section="kegiatan">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>
        <a href="#form" class="nav-lnk" data-section="form">
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

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
     ═══════════════════════════════════════════════ -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <div class="tb-title">Dashboard Overview</div>
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

    <!-- STAT CARDS -->
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

    <!-- ─── KELOLA ADMIN ─── -->
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

    <!-- ─── KELOLA BERITA ─── -->
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

    <!-- ─── KELOLA KEGIATAN ─── -->
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

    <!-- ─── DATA FORM ─── -->
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
                            <button class="iBtn iBtn-del" title="Hapus"><i class="bi bi-trash"></i></button>
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

<!-- ═══════════════════════════════════════════════
     MODAL — TAMBAH ADMIN
     ═══════════════════════════════════════════════ -->
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

<!-- ═══════════════════════════════════════════════
     MODAL — TAMBAH BERITA
     ═══════════════════════════════════════════════ -->
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

<!-- ═══════════════════════════════════════════════
     MODAL — TAMBAH KEGIATAN
     ═══════════════════════════════════════════════ -->
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
/* Active nav on scroll */
const sections = ['dashboard','user','berita','kegiatan','form'];
const links    = document.querySelectorAll('.nav-lnk[data-section]');

function updateNav() {
    let cur = '';
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el && window.scrollY >= el.offsetTop - 110) cur = id;
    });
    links.forEach(l => {
        l.classList.toggle('active', l.dataset.section === cur);
    });
}

window.addEventListener('scroll', updateNav, { passive: true });

/* Smooth scroll on nav click */
links.forEach(l => {
    l.addEventListener('click', e => {
        e.preventDefault();
        const target = document.getElementById(l.dataset.section);
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
</body>
</html>