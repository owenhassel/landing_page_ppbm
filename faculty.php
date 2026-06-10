<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faculty - Ma Chung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="Image/logo.png" alt="Logo" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link active" href="faculty.php">Faculty</a></li>
                    <li class="nav-item"><a class="nav-link" href="curiculum.php">Curriculum</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact Us</a></li>
                </ul>
                <a href="https://tinyurl.com/tes-beasiswa-umc" class="btn btn-apply">Tes Beasiswa</a>
            </div>
        </div>
    </nav>

    <div class="container py-5 text-center overflow-hidden">
        <div data-aos="fade-up" data-aos-duration="1000">
            <h1 class="display-4 mb-3 text-danger serif">Our Professor & Lecture</h1>
            <p class="mb-5">Mengenal lebih dekat para pakar dan praktisi yang membawa kearifan budaya Tiongkok ke dalam ruang kelas, membimbing Anda melampaui batas bahasa menuju peluang global.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="mb-3 img-hover-zoom">
                    <img src="Image/Anggrah Diah.png" height="300px" class="img-fluid">
                </div>
                <h6 class="fw-bold">Anggrah Diah Airlinda, SS., MTCSOL.</h6>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="mb-3 img-hover-zoom">
                    <img src="Image/Dhatu Sitaresmi.png" height="300px" class="img-fluid">
                </div>
                <h6 class="fw-bold">Dhatu Sitaresmi, SS., MTCSOL.</h6>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="mb-3 img-hover-zoom">
                    <img src="Image/Yohanna Nirmalasari.png" height="300px" class="img-fluid">
                </div>
                <h6 class="fw-bold">Yohanna Nirmalasari, S.Pd., M.Pd..</h6>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="mb-3 img-hover-zoom">
                    <img src="Image/Hermien Indrawati.png" height="300px" class="img-fluid">
                </div>
                <h6 class="fw-bold">Hermien Indrawati, S.T., S.Pd., M.B.A.</h6>
            </div>
        </div>
    </div>

    <section class="py-5 overflow-hidden">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 text-danger serif"><strong>Latest News</strong></h2>
            </div>

            <?php
            $query = mysqli_query($conn, "SELECT * FROM berita ORDER BY date DESC");
            $nomor = 0;
            if (mysqli_num_rows($query) > 0):
                while ($berita = mysqli_fetch_assoc($query)):
                    $animasi = ($nomor % 2 == 0) ? 'fade-right' : 'fade-left';
                    $nomor++;
            ?>
            <div class="row align-items-center g-4 mb-4" data-aos="<?= $animasi ?>" data-aos-duration="1000">
                <div class="col-md-2 text-center">
                    <img src="Image/<?= htmlspecialchars($berita['gambar']) ?>" class="img-fluid shadow rounded-5" alt="<?= htmlspecialchars($berita['judul']) ?>">
                </div>
                <div class="col-md-10">
                    <div class="p-4 border bg-white card-custom h-100 shadow-sm">
                        <h5 class="fw-bold">
                            <span class="text-dark"><?= htmlspecialchars($berita['judul']) ?></span>
                        </h5>
                        <p class="text-secondary mb-2"><?= htmlspecialchars($berita['deskripsi']) ?></p>
                        <small class="text-muted">
                            <i class="bi bi-calendar3"></i> <?= htmlspecialchars($berita['date']) ?>
                            &nbsp;&bull;&nbsp;
                            <i class="bi bi-person"></i> <?= htmlspecialchars($berita['penulis']) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p class="text-center text-muted">Belum ada berita yang tersedia.</p>
            <?php endif; ?>

        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <img src="Image/logo-umc.png" alt="Logo Universitas Ma Chung" width="150" class="mb-4 d-block footer-logo">
                    <div class="social-icons d-flex align-items-center mt-5 gap-3">
                        <a href="https://x.com/ma_chung" target="_blank" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.instagram.com/universitasmachung/" target="_blank" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/UCujbjU-9Ce5q0zTuTot5wQw" target="_blank" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h6 class="footer-title">About Ma Chung</h6>
                    <ul class="footer-link-list">
                        <li><a href="https://machung.ac.id/tentang-sejarah">Sejarah</a></li>
                        <li><a href="https://machung.ac.id/visi-misi-nilai-ma-chung/">Visi, Misi, dan 12 Nilai Ma Chung</a></li>
                        <li><a href="https://machung.ac.id/susunan-yayasan/">Pengurus Yayasan</a></li>
                        <li><a href="https://machung.ac.id/pimpinan-ma-chung/">Pimpinan</a></li>
                        <li><a href="https://machung.ac.id/tentang-pendiri">Pendiri</a></li>
                        <li><a href="https://machung.ac.id/welcome-to-ma-chung/">Sambutan Yayasan</a></li>
                        <li><a href="https://machung.ac.id/struktur-organisasi-universitas-ma-chung/">Struktur Organisasi</a></li>
                        <li><a href="https://machung.ac.id/keunggulan-ma-chung/">Keunggulan</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <h6 class="footer-title text-uppercase">Tautan Lainnya</h6>
                    <div class="row g-0">
                        <div class="col-6">
                            <ul class="footer-link-list">
                                <li><a href="https://e-learning.machung.ac.id/">Ma Chung Learning Management System (LMS)</a></li>
                                <li><a href="https://malangdigitalcore.co/">Malang Digital Core</a></li>
                                <li><a href="https://maveo.machung.ac.id/">Ma Chung Venue</a></li>
                                <li><a href="https://machung.ac.id/lowongan-kerja/">Karir</a></li>
                                <li><a href="https://machung.ac.id/satgas-ppkpt/">Satgas PPKPT</a></li>
                                <li><a href="https://machung.ac.id/rektorat-reach-out/">Rektorat Reach-Out</a></li>
                            </ul>
                        </div>
                        <div class="col-6 ps-2">
                            <ul class="footer-link-list">
                                <li><a href="http://eprints.machung.ac.id/">Repository Dokumen</a></li>
                                <li><a href="http://lib.machung.ac.id/">Library</a></li>
                                <li><a href="https://merch.machung.ac.id/">Machung Merch</a></li>
                                <li><a href="https://machung.ac.id/jurnal-ma-chung/">Jurnal Online</a></li>
                                <li><a href="https://machung.ac.id/biaya-pendidikan/#faq">FAQ</a></li>
                                <li><a href="https://machung.ac.id/privacy-policy/">Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center py-3 border-top mt-4" data-aos="fade-in" data-aos-duration="2000">
                <small>&copy; 2026 Universitas Ma Chung. All rights reserved.</small>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, 
            offset: 100
        });
    </script>
</body>
</html>