<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}
?>
<?php
include ("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="img/logo sd pasarejo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/table_guru.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Data Guru</h1>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Guru Pasarejo 1</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        

                        <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                Tambah Data Guru
                            </button>

                            <form class="d-flex mb-3" id="searchForm" method="GET">
                                <input type="text" class="form-control form-control-sm me-2" name="query" placeholder="Cari guru..." style="width: 200px;" required>
                                    <button class="btn btn-primary btn-sm me-2" type="submit">Search</button>
                                    <a class="btn btn-danger btn-sm" href="data_guru.php">Reset</a>
                            </form>
                            
                        </div>  

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <tr class="kolom">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>No Telepon</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <?php
                                   $query = isset($_GET['query']) ? $_GET['query'] : '';
                                   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                   $items_per_page = 10; // Jumlah data per halaman
                                   $offset = ($page - 1) * $items_per_page;
   
                                   if ($query) {
                                       $query = mysqli_real_escape_string($koneksi, $query);
                                       $sql = "SELECT * FROM guru WHERE nama LIKE '%$query%' OR NIP LIKE '%$query%' OR kontak LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR alamat LIKE '%$query%' OR status LIKE '%$query%' LIMIT $items_per_page OFFSET $offset";
                                       $countSql = "SELECT COUNT(*) as total FROM guru WHERE nama LIKE '%$query%' OR NIP LIKE '%$query%' OR kontak LIKE '%$query%' OR tempat_lahir LIKE '%$query%' OR tgl_lahir LIKE '%$query%' OR alamat LIKE '%$query%' OR status LIKE '%$query%'";
                                   } else {
                                       $sql = "SELECT * FROM guru LIMIT $items_per_page OFFSET $offset";
                                       $countSql = "SELECT COUNT(*) as total FROM guru";
                                   }
   
                                   $result = mysqli_query($koneksi, $sql);
                                   $countResult = mysqli_query($koneksi, $countSql);
                                   $totalRows = mysqli_fetch_assoc($countResult)['total'];
                                   $totalPages = ceil($totalRows / $items_per_page);
                                   
                                   $no = $offset + 1;
                                   while ($row = mysqli_fetch_array($result)) {
                                       $nama = $row['nama'];
                                       $nip = $row['NIP'];
                                       $kontak = $row['kontak'];
                                       $tempatLahir = $row['tempat_lahir'];
                                       $tglLahir = $row['tgl_lahir'];
                                       $alamat = $row['alamat'];
                                       $status = $row['status'];
                            ?>
                          
                            
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $nama; ?></td>
                                    <td><?php echo $nip; ?></td>
                                    <td><?php echo $kontak; ?></td>
                                    <td><?php echo $tempatLahir; ?></td>
                                    <td><?php echo $tglLahir; ?></td>
                                    <td><?php echo $alamat; ?></td>
                                    <td><?php echo $status; ?></td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?php echo $row['id_guru']; ?>">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <a href="fitur/hapus_guru.php?id=<?php echo $row['id_guru']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?');" class="btn btn-danger btn-sm">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data guru -->
<div class="modal fade" id="editTeacherModal<?php echo $row['id_guru']; ?>" tabindex="-1" aria-labelledby="editTeacherLabel<?php echo $row['id_guru']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg for wider modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeacherLabel<?php echo $row['id_guru']; ?>">Edit Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="fitur/edit_guru.php" method="POST">
                    <input type="hidden" name="id_guru" value="<?php echo $row['id_guru']; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" value="<?php echo $row['NIP']; ?>" required oninput="validateNIP()">
                            <small id="nipError" class="text-danger" style="display:none;">NIP harus terdiri dari 16 karakter.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" name="kontak" value="<?php echo $row['kontak']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" value="<?php echo $row['tempat_lahir']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tgl_lahir" value="<?php echo $row['tgl_lahir']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="Aktif" <?php echo ($row['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Cuti" <?php echo ($row['status'] == 'Cuti') ? 'selected' : ''; ?>>Cuti</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" required><?php echo $row['alamat']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
</form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault(); // Menghindari reload halaman
                var query = $('input[name="query"]').val(); // Mengambil nilai dari input

                $.ajax({
                    url: 'fitur/cari_guru.php', // URL untuk memproses pencarian
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#searchResults').html(response); // Menampilkan hasil di div searchResults
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error); // Menampilkan kesalahan jika ada
                    }
                });
            });
        });

    function validateNIP() {
    const nipInput = document.getElementById('nip');
    const nipError = document.getElementById('nipError');
    
    if (nipInput.value.length > 16) {
        nipError.style.display = 'block';
        nipInput.setCustomValidity(''); // Reset custom validity
    } else {
        nipError.style.display = 'none';
        nipInput.setCustomValidity(''); // Reset custom validity
    }
}
    </script>

                <!-- Modal for Adding Teacher -->
                <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Make modal wider -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTeacherLabel">Tambah Data guru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="fitur/tambah_guru.php" method="POST">
                                <div class="row mb-3">
    <div class="col-md-6">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" required>
    </div>
    
    <div class="col-md-6">
    <label for="nip" class="form-label">NIP</label>
    <input type="text" class="form-control" name="nip" required>
    </div>
    
    
    <div class="col-md-6">
        <label for="kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" name="kontak" required>
    </div>

    <div class="col-md-6">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" class="form-control" name="tempat_lahir" required>
    </div>
    
    <div class="mb-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" class="form-control" name="tgl_lahir" required>
    </div>
    
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" name="status" required>
            <option value="Aktif">Aktif</option>
            <option value="Cuti">Cuti</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&query=<?php echo $query; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&query=<?php echo $query; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&query=<?php echo $query; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("input[type=date]", {
    dateFormat: "Y-m-d",
    maxDate: "today"
});
</script>


</body>
</html>
