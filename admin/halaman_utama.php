<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Menambahkan Chart.js -->
</head>

<?php
include 'header.php'; // Mengimpor header yang sudah berisi session_start()
include '../koneksi/koneksi.php'; // Pastikan path koneksi.php sudah benar

// Menentukan tanggal default
$date = date('yy-m-d');

// Jika form submit, ambil tanggal yang dipilih
if (isset($_POST['submit'])) {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
} else {
    $date1 = $date2 = $date; // Defaultkan tanggal ke hari ini jika tidak ada input
}

// Mendapatkan jumlah pelanggan
$total_pelanggan_query = mysqli_query($conn, "SELECT COUNT(*) as total_pelanggan FROM customer");
$total_pelanggan_data = mysqli_fetch_assoc($total_pelanggan_query);
$total_pelanggan = $total_pelanggan_data['total_pelanggan'];

// Mendapatkan jumlah pesanan berdasarkan status
$status_pesanan_query = mysqli_query($conn, "
    SELECT 
        COUNT(CASE WHEN status_pesanan = 'Menunggu Pembayaran' THEN 1 END) as menunggu_pembayaran,
        COUNT(CASE WHEN status_pesanan = 'Dikemas' THEN 1 END) as dikemas,
        COUNT(CASE WHEN status_pesanan = 'Dikirim' THEN 1 END) as dikirim,
        COUNT(CASE WHEN status_pesanan = 'Selesai' THEN 1 END) as selesai
    FROM pesanan");
$status_pesanan_data = mysqli_fetch_assoc($status_pesanan_query);

// Mendapatkan total omset (total harga produk yang telah terjual)
$total_omset_query = mysqli_query($conn, "
    SELECT SUM(d.qty * pr.harga) as total_omset 
    FROM pesanan p 
    JOIN order_detail d ON p.id = d.order_id 
    JOIN produk pr ON d.kode_produk = pr.kode_produk 
    WHERE p.status_pesanan = 'Selesai' 
    AND p.tanggal_order BETWEEN '$date1' AND '$date2'");
$total_omset_data = mysqli_fetch_assoc($total_omset_query);
$total_omset = $total_omset_data['total_omset'];

// Mendapatkan data 5 produk terlaris
$produk_terlaris_query = mysqli_query($conn, "
    SELECT pr.nama, SUM(d.qty) as total_qty
    FROM order_detail d
    JOIN produk pr ON d.kode_produk = pr.kode_produk
    GROUP BY pr.nama
    ORDER BY total_qty DESC
    LIMIT 10");

// Mendapatkan jumlah permintaan toko yang statusnya 'Menunggu'
$permintaan_toko_query = mysqli_query($conn, "SELECT COUNT(*) as jumlah_menunggu FROM toko WHERE status_pengajuan = 'Menunggu'");
$permintaan_toko_data = mysqli_fetch_assoc($permintaan_toko_query);
$jumlah_menunggu = $permintaan_toko_data['jumlah_menunggu'];

?>

<div class="container mt-5">
    <div class="row">
        <!-- Kartu Jumlah Pelanggan -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Pelanggan</h5>
                    <p class="card-text"><?= $total_pelanggan; ?></p>
                </div>
            </div>
        </div>

        <!-- Kartu Pesanan Menunggu Pembayaran -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Menunggu Pembayaran</h5>
                    <p class="card-text"><?= $status_pesanan_data['menunggu_pembayaran']; ?></p>
                </div>
            </div>
        </div>

        <!-- Kartu Pesanan Dikemas -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Dikemas</h5>
                    <p class="card-text"><?= $status_pesanan_data['dikemas']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Pesanan Dikirim dan Pesanan Selesai (Baris Kedua) -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Dikirim</h5>
                    <p class="card-text"><?= $status_pesanan_data['dikirim']; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <p class="card-text"><?= $status_pesanan_data['selesai']; ?></p>
                </div>
            </div>
        </div>
    

    <!-- Kartu Permintaan Buka Toko (Jumlah Menunggu) -->
    
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Permintaan Buka Toko</h5>
                    <p class="card-text"><?= $jumlah_menunggu; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Batang Produk Terlaris dalam satu baris -->
    <div class="row">
        <div class="col-md-12">
            <canvas id="produkTerlarisChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Diagram Batang Produk Terlaris
    var ctx2 = document.getElementById('produkTerlarisChart').getContext('2d');
    var produkTerlarisChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php 
                $labels = [];
                while ($row = mysqli_fetch_assoc($produk_terlaris_query)) {
                    $labels[] = '"' . $row['nama'] . '"';
                }
                echo '[' . implode(',', $labels) . ']';
            ?>,
            datasets: [{
                label: 'Jumlah Terjual',
                data: <?php 
                    $data = [];
                    mysqli_data_seek($produk_terlaris_query, 0);
                    while ($row = mysqli_fetch_assoc($produk_terlaris_query)) {
                        $data[] = $row['total_qty'];
                    }
                    echo '[' . implode(',', $data) . ']';
                ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<br><br><br><br><br><br>

<?php include 'footer.php'; ?>

<style>
    body {
        font-family: poppins;
    }
    .card {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    .card-body {
        padding: 15px;
    }
    canvas {
        max-height: 300px; /* Menyesuaikan ukuran grafik */
    }
</style>
