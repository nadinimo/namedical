<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
$kd = mysqli_real_escape_string($conn, $_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<div class="container" style="padding-bottom: 200px">
    <h2 style=" width: 100%; font-family: poppins;"><b>Checkout</b></h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Daftar Pesanan</h4>
            <table class="table table-stripped">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
                $no = 1;
                $hasil = 0;
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['nama_produk']; ?></td>
                        <td>Rp.<?= number_format($row['harga']); ?></td>
                        <td><?= $row['qty']; ?></td>
                        <td>Rp.<?= number_format($row['harga'] * $row['qty']);  ?></td>
                    </tr>
                    <?php 
                    $total = $row['harga'] * $row['qty'];
                    $hasil += $total;
                    $no++;
                }
                ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Total Keseluruhan = <?= number_format($hasil); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 bg-warning">
            <h5>Pastikan produk dan jumlahnya sudah sesuai. </h5>
        </div>
    </div>
    <br>
    <!-- Mengirimkan data kode_cs menggunakan metode POST -->
    <form action="proses/order.php" method="POST">
        <input type="hidden" name="kode_cs" value="<?= $kd; ?>"> <!-- Mengirim kode_customer dengan POST -->
        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
        <a href="keranjang.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }
</style>
