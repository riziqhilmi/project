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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar bg-dark sticky-top">
            <?php include 'partials/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container">
                <h1 class="mb-4">Data Ruangan</h1>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Ruangan Pasarejo 1</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        

                        <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                Tambah Data Ruangan
                            </button>

                            <form class="d-flex mb-3" id="searchForm" method="GET">
                                <input type="text" class="form-control form-control-sm me-2" name="query" placeholder="Cari Ruangan..." style="width: 200px;" required>
                                    <button class="btn btn-primary btn-sm" type="submit">Search</button>
                            </form>
                            
                        </div>  

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <tr>
                                        <th>No</th>
                                        <th>Ruangan</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <?php
                                   $query = isset($_GET['query']) ? $_GET['query'] : '';

                                   if ($query) {
                                       $query = mysqli_real_escape_string($koneksi, $query); 
                                       $sql = "SELECT * FROM ruangan WHERE nama_ruangan LIKE '%$query%' OR keterangan LIKE '%$query%'"; 
                                   } else {
                                       $sql = "SELECT * FROM ruangan";
                                   }
                                   
                                   $result = mysqli_query($koneksi, $sql);
                                   $no = 1;

                                   while ($row = mysqli_fetch_array($result)) {
                                    $nama = $row['nama_ruangan'];
                                    $ket = $row['keterangan'];
                                    
                            ?>
                          
                            
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $nama; ?></td>
                                    <td><?php echo $ket; ?></td>
                                    
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?php echo $row['id_ruangan']; ?>">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <a href="fitur/hapus_ruangan.php?id=<?php echo $row['id_ruangan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Ruangan ini?');" class="btn btn-danger btn-sm">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data Ruangan -->
                                    <div class="modal fade" id="editTeacherModal<?php echo $row['id_ruangan']; ?>" tabindex="-1" aria-labelledby="editTeacherLabel<?php echo $row['id_ruangan']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTeacherLabel<?php echo $row['id_ruangan']; ?>">Edit Data Ruangan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="fitur/edit_ruangan.php" method="POST">
    <input type="hidden" name="id_ruangan" value="<?php echo $row['id_ruangan']; ?>">
    
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Ruangan</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $row['nama_ruangan']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="ket" class="form-label">Keterangan</label>
        <input type="text" class="form-control" name="ket" value="<?php echo $row['keterangan']; ?>" required>
    </div>
    

    <button type="submit" class="btn btn-primary">Simpan</button>
    
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

                <!-- Modal for Adding Teacher -->
                <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTeacherLabel">Tambah Data Ruangan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="fitur/tambah_ruangan.php" method="POST">
    <div class="mb-3">
        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
        <input type="text" class="form-control" name="nama_ruangan" required>
    </div>
    
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <input type="text" class="form-control" name="keterangan" required>
    </div>
    

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
