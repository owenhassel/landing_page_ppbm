<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit();
    }
    include 'db.php';
    $current_admin = $_SESSION["id_admin"];
    
    $count_form = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM form WHERE status='Belum Dibaca'"))['total'];
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
                <div class="tb-title">Dashboard Overview</div>
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
            <?php if($count_form > 0): ?>
                <span class="pill p-red"><?= $count_form; ?> Pesan Belum Dibaca</span>
            <?php endif; ?>
        </div>
        <div style="overflow-x:auto;">
            <table class="dtbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Pesan</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                $limit = 10;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $total_data = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM form"))[0];
                $total_page = ceil($total_data / $limit);
                if ($total_page == 0) { $total_page = 1; }

                $q = mysqli_query($conn, "SELECT * FROM form ORDER BY status ASC, id_form DESC LIMIT $offset, $limit");

                if (mysqli_num_rows($q) > 0):
                    while ($r = mysqli_fetch_assoc($q)):
                        
                        $is_read = ($r['status'] == 'Telah Dibaca');
                        $badgeClass = $is_read ? 'p-teal' : 'p-red';
                        $statusText = $is_read ? 'Telah Dibaca' : 'Belum Dibaca';
                        $toggleStatus = $is_read ? 'Belum Dibaca' : 'Telah Dibaca';
                        $toggleIcon = $is_read ? 'bi-envelope-open-fill' : 'bi-envelope-fill';
                        $toggleColor = $is_read ? 'color: var(--t3);' : 'color: var(--teal);';
                ?>
                    <tr>
                        <td><span class="tid"><?= htmlspecialchars($r['id_form']); ?></span></td>
                        <td class="t-bold"><?= htmlspecialchars($r['full_name']); ?></td>
                        <td>
                            <div class="t-sub"><i class="bi bi-envelope" style="color:var(--red);"></i> <?= htmlspecialchars($r['email']); ?></div>
                            <div class="t-sub" style="margin-top:3px;"><i class="bi bi-telephone-fill" style="color:var(--teal);"></i> <?= htmlspecialchars($r['phone']); ?></div>
                        </td>
                        <td><span class="pill <?= $badgeClass ?>">● <?= $statusText ?></span></td>
                        <td>
                            <button class="btn btn-sm view-msg-btn" 
                                    style="background-color: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.85rem;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#mPesan"
                                    data-name="<?= htmlspecialchars($r['full_name']); ?>"
                                    data-email="<?= htmlspecialchars($r['email']); ?>"
                                    data-msg="<?= htmlspecialchars($r['message']); ?>">
                                <i class="bi bi-eye"></i> Lihat Pesan
                            </button>
                        </td>
                        <td class="t-acts">
                            <a href="update_status_form.php?id_form=<?= urlencode($r['id_form']); ?>&status=<?= urlencode($toggleStatus); ?>" class="iBtn" title="Tandai <?= $toggleStatus ?>" style="<?= $toggleColor ?>">
                                <i class="bi <?= $toggleIcon ?>"></i>
                            </a>
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
        <div style="text-align: center; padding: 25px 0 10px 0;">
            <div style="display: inline-block;">
                <?php if($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid #e2e8f0; margin: 0 3px; color: var(--red); background: white; border-radius: 6px; font-weight: 500; font-size: 0.9rem;">&laquo; Prev</a>
                <?php endif; ?>
                
                <?php for($i = 1; $i <= $total_page; $i++): ?>
                    <a href="?page=<?= $i ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid <?= $i == $page ? 'var(--red)' : '#e2e8f0' ?>; margin: 0 3px; background-color: <?= $i == $page ? 'var(--red)' : 'white' ?>; color: <?= $i == $page ? 'white' : '#475569' ?>; border-radius: 6px; font-weight: 600; font-size: 0.9rem;">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if($page < $total_page): ?>
                    <a href="?page=<?= $page + 1 ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid #e2e8f0; margin: 0 3px; color: var(--red); background: white; border-radius: 6px; font-weight: 500; font-size: 0.9rem;">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="mPesan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="m-hd">
                <div class="m-hd-l">
                    <div class="m-hd-ico ic-teal"><i class="bi bi-chat-left-text-fill"></i></div>
                    <h5>Detail Pesan</h5>
                </div>
                <button class="m-close" data-bs-dismiss="modal"><i class="bi bi-x"></i></button>
            </div>
            <div class="m-body">
                <div class="fg">
                    <label class="fl">Dari:</label>
                    <div id="modalSenderName" class="t-bold" style="font-size: 1.1rem;"></div>
                    <div id="modalSenderEmail" class="t-sub"></div>
                </div>
                <div class="fg mt-3">
                    <label class="fl">Isi Pesan:</label>
                    <div id="modalMessageContent" style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; white-space: pre-wrap; word-break: break-word; overflow-wrap: break-word; font-size: 0.95rem; color: #334155; min-height: 100px;"></div>
                </div>
            </div>
            <div class="m-foot">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show-sidebar');
        });

        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show-sidebar');
                }
            }
        });
    }

    const viewButtons = document.querySelectorAll('.view-msg-btn');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {

            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const msg = this.getAttribute('data-msg');

            document.getElementById('modalSenderName').innerText = name;
            document.getElementById('modalSenderEmail').innerText = email;
            document.getElementById('modalMessageContent').innerText = msg;
        });
    });
});
</script>
</body>
</html>