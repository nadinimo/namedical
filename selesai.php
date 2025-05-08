<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
include 'koneksi/koneksi.php';

// Mendapatkan kode pelanggan dari URL
$kd = mysqli_real_escape_string($conn, $_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);

// Mengecek apakah data pelanggan ditemukan
if (!$rows) {
    echo "<script>alert('Data pelanggan tidak ditemukan.'); window.location = 'index.php';</script>";
    exit();
}

// Mengambil data pesanan terbaru untuk pelanggan
$order_query = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode_customer = '$kd' ORDER BY id DESC LIMIT 1");
$order_data = mysqli_fetch_assoc($order_query);

// Jika tidak ada pesanan ditemukan
if (!$order_data) {
    echo "<script>alert('Tidak ada pesanan untuk pelanggan ini.'); window.location = 'index.php';</script>";
    exit();
}

// Mengambil detail pesanan berdasarkan order_id
$order_details_query = mysqli_query($conn, "
    SELECT od.qty, od.harga, p.nama 
    FROM order_detail od
    JOIN produk p ON od.kode_produk = p.kode_produk
    WHERE od.order_id = '{$order_data['id']}'
");

?>

<div class="container" style="padding-bottom: 200px">    
    <img src="image/logo-namedic.png" alt="Logo NA MEDICAL" style="width: 150px; margin: 0 auto; display: block;">
    <h2 style="width: 100%; font-family: poppins;"><b>NA MEDICAL</b></h2>
    <h3 style="width: 100%; font-family: poppins;"><b>Invoice Pesanan <?= $order_data['kode_order'] ?></b></h3>
    
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <td>Kode Pelanggan</td>
                    <td>:</td>
                    <td><?= $order_data['kode_customer']; ?></td>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?= date('d-m-Y', strtotime($order_data['tanggal_order'])); ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?= $rows['nama']; ?></td>
                    <td>ID Paypal</td>
                    <td>:</td>
                    <td><?= $rows['paypal']; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $rows['alamat']; ?></td>
                    <td>No. HP</td>
                    <td>:</td>
                    <td><?= $rows['telp']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Daftar Pesanan -->
    <h4><b>Daftar Pesanan</b></h4>
    <table class="table table-stripped">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
        <?php 
        $total_amount = 0;
        $no = 1;
        while ($row = mysqli_fetch_assoc($order_details_query)) {
            $total_item_price = $row['qty'] * $row['harga'];
            $total_amount += $total_item_price;
        ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['qty']; ?></td>
            <td>Rp. <?= number_format($total_item_price); ?></td>
        </tr>
        <?php 
            $no++;
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: left; font-weight: bold;">Total belanja (termasuk pajak): Rp. <?= number_format($total_amount); ?></td>
        </tr>
    </table>

    <!-- TTD NA MEDICAL -->
    <div style="text-align: right; font-weight: bold; margin-top: 30px; margin-right: 50px;">
    TTD NA MEDICAL
    </div>

    
    <!Gambar Tanda Tangan -->
    <div style="text-align: right;">
        <img src="image/ttd.png" alt="Tanda Tangan" style="width: 200px; height: 100px; object-fit: contain;">
    </div>
    
    <!-- Tombol Cetak Invoice dan Konfirmasi Pembayaran -->
    <form action="selesai.php?kode_cs=<?= $kd; ?>" method="POST">
        <a href="javascript:void(0)" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak Invoice</a>
        <a href="pesanan_saya.php" class="btn btn-success">Lihat Pesanan Saya</a>
        <a href="keranjang.php?hapus_keranjang=<?= $kd; ?>" class="btn btn-danger">Back</a>
    </form>
</div>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }
    h2 {
        text-align: center;
    }
    h3 {
        text-align: center;
    }
</style>
