<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$koneksi = mysqli_connect('localhost', 'root', '', 'db_pasarejo');

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Query untuk mengambil jumlah siswa berdasarkan jenis kelamin
$sql_siswa = "SELECT jenis_kelamin, COUNT(*) as jumlah FROM siswa GROUP BY jenis_kelamin";
$result_siswa = mysqli_query($koneksi, $sql_siswa);

$labels_siswa = [];
$data_siswa = [];

while ($row = mysqli_fetch_assoc($result_siswa)) {
    $labels_siswa[] = $row['jenis_kelamin'];
    $data_siswa[] = $row['jumlah'];
}

// Query untuk mengambil jumlah siswa berdasarkan tahun lahir
$sql_tahun_lahir = "SELECT YEAR(tgl_lahir) as tahun, COUNT(*) as jumlah FROM siswa GROUP BY tahun";
$result_tahun_lahir = mysqli_query($koneksi, $sql_tahun_lahir);

$labels_tahun_lahir = [];
$data_tahun_lahir = [];

while ($row = mysqli_fetch_assoc($result_tahun_lahir)) {
    $labels_tahun_lahir[] = $row['tahun'];
    $data_tahun_lahir[] = $row['jumlah'];
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
    background-color: #f8f9fa; /* Warna latar belakang */
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.text-center {
    text-align: center;
}

.my-4 {
    margin: 20px 0;
}

.col-md-12 {
    flex: 1; /* Set elemen menjadi fleksibel */
    max-width: calc(70% - 20px); /* Grafik mengambil 1/3 lebar baris */
    box-sizing: border-box; /* Pastikan padding tidak memengaruhi lebar */
}

.chart-container {
    flex: 1; /* Ukuran fleksibel untuk menyesuaikan */
    
    background-color: white;
    padding: 20px;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.chart-title {
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
}

.row {
    display: flex; /* Flexbox aktif */
    flex-wrap: wrap; /* Grafik turun ke bawah jika layar kecil */
    justify-content: space-between; /* Spasi di antara elemen */
    gap: 20px; /* Jarak antar elemen */
}


    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center my-4"><strong>Visualisasi Data Siswa</strong></h1>

    <!-- Baris Grafik -->
    <div class="row">

        <!-- Pie Chart -->
        
        <!-- Bar Chart -->
        <div class="col-md-12">
        <div class="chart-container">
            <div class="chart-title">Jumlah Siswa Berdasarkan Jenis Kelamin</div>
            <canvas id="barChartSiswa"></canvas>
        </div>
        </div>

        <!-- Line Chart -->
        <div class="col-md-12">
        <div class="chart-container">
            <div class="chart-title">Jumlah Siswa Berdasarkan Tahun Lahir</div>
            <canvas id="lineChartTahunLahir"></canvas>
            </div>
        </div>

        <div class="col-md-12">
        <div class="chart-container">
            <div class="chart-title">Distribusi Siswa Berdasarkan Jenis Kelamin</div>
            <canvas id="pieChartSiswa"></canvas>
        </div>
        </div>
    </div>
</div>


    <script>
        // Pie Chart untuk distribusi siswa berdasarkan jenis kelamin
        const ctxPieSiswa = document.getElementById('pieChartSiswa').getContext('2d');
        const pieChartSiswa = new Chart(ctxPieSiswa, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels_siswa); ?>,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: <?php echo json_encode($data_siswa); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribusi Siswa Berdasarkan Jenis Kelamin'
                    }
                }
            }
        });

        // Bar Chart untuk jumlah siswa berdasarkan jenis kelamin
        const ctxBarSiswa = document.getElementById('barChartSiswa').getContext('2d');
        const barChartSiswa = new Chart(ctxBarSiswa, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_siswa); ?>,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: <?php echo json_encode($data_siswa); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Siswa Berdasarkan Jenis Kelamin'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart untuk jumlah siswa berdasarkan tahun lahir
        const ctxLineTahunLahir = document.getElementById('lineChartTahunLahir').getContext('2d');
        const lineChartTahunLahir = new Chart(ctxLineTahunLahir, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_tahun_lahir); ?>,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: <?php echo json_encode($data_tahun_lahir); ?>,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Siswa Berdasarkan Tahun Lahir'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>