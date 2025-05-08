<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php
include 'header.php'; // Mengimpor header yang sudah berisi session_start()
include '../koneksi/koneksi.php'; // Pastikan path koneksi.php sudah benar

// Menentukan tanggal default
$date = date('Y-m-d');

// Jika form submit, ambil tanggal yang dipilih
if (isset($_POST['submit'])) {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
} else {
    $date1 = $date2 = $date; // Defaultkan tanggal ke hari ini jika tidak ada input
}
?>

<style type="text/css">
    @media print {
        .print {
            display: none;
        }
    }
</style>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid gray; padding-bottom: 5px;"><b>Laporan Penjualan</b></h2>

    <div class="row print">
        <div class="col-md-9">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td><input type="date" name="date1" class="form-control" value="<?= $date1; ?>"></td>
                        <td>&nbsp; - &nbsp;</td>
                        <td><input type="date" name="date2" class="form-control" value="<?= $date2; ?>"></td>
                        <td> &nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-primary" value="Tampilkan"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="col-md-3">
            <form action="exp_penjualan.php" method="POST">
                <table>
                    <tr>
                        <td><input type="hidden" name="date1" class="form-control" value="<?= $date1; ?>"></td>
                        <td><input type="hidden" name="date2" class="form-control" value="<?= $date2; ?>"></td>
                        <td> &nbsp;</td>
                        <td><a href="" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <br><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Tanggal</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Inisialisasi variabel $total sebelum loop
            $grand_total = 0;
            if (isset($_POST['submit'])) {
                // Query untuk menampilkan data penjualan berdasarkan rentang tanggal
                $result = mysqli_query($conn, "
                    SELECT 
                        p.kode_order,
                        p.tanggal_order,
                        d.qty,
                        pr.nama,
                        pr.harga
                    FROM pesanan p
                    JOIN order_detail d ON p.id = d.order_id
                    JOIN produk pr ON d.kode_produk = pr.kode_produk
                    WHERE p.tanggal_order BETWEEN '$date1' AND '$date2' AND p.status_pesanan = 'Selesai'");

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $total = $row['qty'] * $row['harga']; // Hitung total untuk setiap produk
                    $grand_total += $total; // Tambahkan total ke grand total
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_order'])); ?></td>
                        <td><?= $row['qty']; ?></td>
                        <td>Rp. <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>Rp. <?= number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                    $no++;
                }
            }
            ?>
            <tr>
                <td colspan="5" class="text-right"><b>Total Jumlah Terjual:</b></td>
                <td><b>Rp. <?= number_format($grand_total, 0, ',', '.'); ?></b></td>
            </tr>
        </tbody>
    </table>
</div>

<br><br><br><br><br>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: Poppins;
    }
</style>
