<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php
include 'header.php';
include 'koneksi/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

// Ambil kode customer dari session
$kode_cs = $_SESSION['kd_cs'];

// Cek apakah ada pencarian
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode_customer = '$kode_cs' AND kode_order LIKE '%$search%' ORDER BY tanggal_order DESC");
} else {
    $query = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode_customer = '$kode_cs' ORDER BY tanggal_order DESC");
}

// Proses ulasan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ulas'])) {
    $order_id = $_POST['order_id'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    // Simpan ulasan ke database
    $insert_ulas_query = "INSERT INTO feedback (order_id, rating, komentar) VALUES ('$order_id', '$rating', '$komentar')";
    
    if (mysqli_query($conn, $insert_ulas_query)) {
        echo "<script>alert('Ulasan berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan ulasan.');</script>";
    }
}
?>

<div class="container" style="padding-bottom: 200px">
    <h2 style=" width: 100%; font-family: poppins; padding-bottom: 20px;"><b>Pesanan Saya</b></h2>

    <!-- Form Search dengan tombol dalam 1 baris -->
    <form method="GET" action="pesanan_saya.php" class="mb-3 d-flex" style="max-width: 600px;">
        <input type="text" name="search" class="form-control" placeholder="Cari Kode Order..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button class="btn btn-primary ml-2" type="submit">Cari</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Tanggal Order</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($order_data = mysqli_fetch_assoc($query)) {
                // Hitung total harga untuk pesanan ini
                $total = 0;
                $order_details_query = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = '{$order_data['id']}'");
                while ($detail = mysqli_fetch_assoc($order_details_query)) {
                    $total += $detail['qty'] * $detail['harga'];
                }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $order_data['kode_order']; ?></td>
                <td><?= date('d-m-Y', strtotime($order_data['tanggal_order'])); ?></td>
                <td>Rp. <?= number_format($total, 0, ',', '.'); ?></td>
                <td><?= $order_data['status_pesanan']; ?></td>
                <td>
                    <a href="konfirmasi_pembayaran.php?kode_order=<?= $order_data['kode_order']; ?>" class="btn btn-warning">Konfirmasi Pembayaran</a>
                    
                    <?php if ($order_data['status_pesanan'] == 'Selesai') { ?>
                        <!-- Tombol Beri Ulasan -->
                        <button class="btn btn-success mt-2" data-toggle="modal" data-target="#ulasanModal-<?= $order_data['id']; ?>">Beri Ulasan</button>

                        <!-- Modal Ulasan -->
                        <div class="modal fade" id="ulasanModal-<?= $order_data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ulasanModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ulasanModalLabel">Beri Ulasan untuk Kode Order: <?= $order_data['kode_order']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="pesanan_saya.php" method="POST">
                                            <input type="hidden" name="order_id" value="<?= $order_data['id']; ?>">

                                            <div class="form-group">
                                                <label for="rating">Rating (1-5)</label>
                                                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="komentar">Komentar</label>
                                                <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                                            </div>

                                            <button type="submit" name="submit_ulas" class="btn btn-primary">Kirim Ulasan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
    }

    .ml-2 {
        margin-left: 0.5rem;
    }
</style>
