<?php
$base_url = "/project";
$current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file dari URL
?>

<!-- Bootstrap CSS dan Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="col-md-2 sidebar bg-dark sticky-top p-0">
    <div class="d-flex flex-column p-3 text-white bg-primary" style="height: 100vh;">
        <!-- Header Sidebar -->
        <div class="sidebar-header d-flex flex-column align-items-center justify-content-center">
        <img src="<?php echo $base_url; ?>/img/logo_sd.png" alt="Logo" class="logo-white mb-2" width="90" height="100">
         <a href="<?php echo $base_url; ?>/dashboard.php" class="text-decoration-none text-white">
            <span class="fs-4 shiny-text text-center">SDN PASAREJO 1</span>
         </a>
    </div>

        <style>
            .sidebar-header {
            display: flex;
            flex-direction: column; /* Susun secara vertikal */
            align-items: center;    /* Sejajarkan secara horizontal */
            justify-content: center; /* Sejajarkan secara vertikal */
            height: 150px; /* Sesuaikan tinggi kontainer */
            }


            .shiny-text {
                font-weight: bold;
                background: linear-gradient(90deg, #000000, #C62828, #4adeff);
                background-size: 200% auto;
                color: white;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shine 3s linear infinite;
            }

            @keyframes shine {
                to {
                    background-position: 200% center;
                }
            }

            /* Styling untuk menu aktif */
            .sidebar .nav-link.active-main {
                background-color: white;
                color: black !important;
                border-radius: 10px;
                font-weight: bold;
            }

            /* Styling ikon panah */
            .arrow-icon {
                transition: transform 0.3s ease;
            }
        </style>

        <hr>

        <!-- Menu Sidebar -->
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Data Master -->
            <li>
                <a href="#inventarisSubMenu" class="nav-link text-white d-flex align-items-center <?php echo (in_array($current_page, ['data_guru.php', 'data_siswa.php', 'data_kelas.php', 'barang.php'])) ? 'active-main' : ''; ?>" 
                data-bs-toggle="collapse">
                    <i class="bi bi-collection me-2"></i> Data Master
                    <i class="bi bi-chevron-down ms-auto arrow-icon"></i>
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['data_guru.php', 'data_siswa.php', 'data_kelas.php', 'barang.php'])) ? 'show' : ''; ?>" 
                id="inventarisSubMenu" data-bs-parent=".nav">
                    <li><a href="<?php echo $base_url; ?>/data_guru.php" class="nav-link text-white ms-3">Data Guru</a></li>
                    <li><a href="<?php echo $base_url; ?>/data_siswa.php" class="nav-link text-white ms-3">Data Siswa</a></li>
                    <li><a href="<?php echo $base_url; ?>/data_kelas.php" class="nav-link text-white ms-3">Data Ruangan</a></li>
                    <li><a href="<?php echo $base_url; ?>/inventaris/barang.php" class="nav-link text-white ms-3">Data Barang</a></li>
                </ul>
            </li>

            <!-- Transaksi -->
            <li>
                <a href="#transaksiSubMenu" class="nav-link text-white d-flex align-items-center <?php echo (in_array($current_page, ['barang_masuk.php', 'barang_keluar.php', 'peminjaman.php'])) ? 'active-main' : ''; ?>" data-bs-toggle="collapse">
                    <i class="bi bi-layout-wtf"></i> Transaksi
                    <i class="bi bi-chevron-down ms-auto arrow-icon"></i>
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['barang_masuk.php', 'barang_keluar.php', 'peminjaman.php'])) ? 'show' : ''; ?>" 
                id="transaksiSubMenu" data-bs-parent=".nav">
                    <li><a href="<?php echo $base_url; ?>/inventaris/barang_masuk.php" class="nav-link text-white ms-3">Barang Masuk</a></li>
                    <li><a href="<?php echo $base_url; ?>/inventaris/barang_keluar.php" class="nav-link text-white ms-3">Barang Keluar</a></li>
                    <li><a href="<?php echo $base_url; ?>/inventaris/peminjaman.php" class="nav-link text-white ms-3">Peminjaman</a></li>
                </ul>
            </li>

            <!-- Laporan -->
            <li>
                <a href="#laporanSubMenu" class="nav-link text-white d-flex align-items-center <?php echo (in_array($current_page, ['laporan_barang_keluar.php', 'laporan_peminjaman.php', 'laporan_barang_masuk.php', 'laporan_barang.php'])) ? 'active-main' : ''; ?>" data-bs-toggle="collapse">
                    <i class="bi bi-envelope"></i> Laporan
                    <i class="bi bi-chevron-down ms-auto arrow-icon"></i>
                </a>
                <ul class="collapse <?php echo (in_array($current_page, ['laporan_barang_keluar.php', 'laporan_peminjaman.php', 'laporan_barang_masuk.php', 'laporan_barang.php'])) ? 'show' : ''; ?>" 
                id="laporanSubMenu" data-bs-parent=".nav">
                    <li><a href="<?php echo $base_url; ?>/laporan/laporan_barang_masuk.php" class="nav-link text-white ms-3">Laporan Barang Masuk</a></li>
                    <li><a href="<?php echo $base_url; ?>/laporan/laporan_barang_keluar.php" class="nav-link text-white ms-3">Laporan Barang Keluar</a></li>
                    <li><a href="<?php echo $base_url; ?>/laporan/laporan_peminjaman.php" class="nav-link text-white ms-3">Laporan Peminjaman</a></li>
                    <li><a href="<?php echo $base_url; ?>/laporan/laporan_barang.php" class="nav-link text-white ms-3">Laporan Barang</a></li>
                </ul>
            </li>

            <!-- Visualisasi -->
            <li>
                <a href="<?php echo $base_url; ?>/data_visualisasi.php" class="nav-link text-white <?php echo ($current_page == 'data_visualisasi.php') ? 'active-main' : ''; ?>">
                    <i class="bi bi-bar-chart-line"></i> Visualisasi
                </a>
            </li>
        </ul>

        <hr>
        <a href="<?php echo $base_url; ?>/fitur/logout.php" class="btn btn-outline-light">Logout</a>
    </div>
</div>

<!-- JavaScript -->
<script>
document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(function (menu) {
    const arrow = menu.querySelector('.arrow-icon');
    const submenu = document.querySelector(menu.getAttribute('href'));

    if (arrow && submenu) {
        submenu.addEventListener('shown.bs.collapse', function () {
            arrow.style.transform = 'rotate(-180deg)';
        });
        submenu.addEventListener('hidden.bs.collapse', function () {
            arrow.style.transform = 'rotate(0deg)';
        });
    }
});
</script>
