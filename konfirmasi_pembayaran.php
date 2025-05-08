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

// Ambil kode pesanan dari parameter GET
$kode_order = $_GET['kode_order'];

// Ambil data pesanan dari database berdasarkan kode_order
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode_order = '$kode_order'");
$order_data = mysqli_fetch_assoc($query);

// Cek apakah data pesanan ada
if (!$order_data) {
    echo "<script>alert('Pesanan tidak ditemukan.'); window.location = 'pesanan_saya.php';</script>";
    exit();
}

// Proses konfirmasi pembayaran jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $informasi_pembayaran = $_POST['informasi_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tanggal_bayar = $_POST['tanggal_bayar'];

    // Simpan data pembayaran ke tabel pembayaran
    $insert_pembayaran_query = "INSERT INTO pembayaran (order_id, informasi_pembayaran, metode_pembayaran, tanggal_bayar, status_pembayaran) 
                                VALUES ('{$order_data['id']}', '$informasi_pembayaran', '$metode_pembayaran', '$tanggal_bayar', 'Menunggu Konfirmasi Admin')";

    if (mysqli_query($conn, $insert_pembayaran_query)) {
        // Update status pesanan menjadi "Menunggu Konfirmasi Admin"
        $update_status_query = "UPDATE pesanan SET status_pesanan = 'Menunggu Konfirmasi Admin' WHERE kode_order = '$kode_order'";

        if (mysqli_query($conn, $update_status_query)) {
            echo "<script>
                    alert('Pembayaran berhasil dikonfirmasi. Menunggu konfirmasi dari Admin.');
                    window.location = 'pesanan_saya.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Gagal memperbarui status pesanan.');</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan dalam pemrosesan pembayaran. Silakan coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="padding-bottom: 200px">
        <h2><b>Konfirmasi Pembayaran</b></h2>

        <form action="konfirmasi_pembayaran.php?kode_order=<?= $kode_order; ?>" method="POST">
            <!-- Kode Pesanan -->
            <div class="form-group">
                <label for="kode_order">Kode Pesanan</label>
                <input type="text" class="form-control" id="kode_order" name="kode_order" value="<?= $order_data['kode_order']; ?>" readonly>
            </div>

            <!-- Informasi Pembayaran -->
            <div class="form-group">
                <label for="informasi_pembayaran">Informasi Pembayaran</label>
                <input type="text" class="form-control" id="informasi_pembayaran" name="informasi_pembayaran" placeholder="Nama Pemilik Rekening / Sumber Dana" required>
            </div>

            <!-- Pilih Metode Pembayaran -->
            <div class="form-group">
                <label for="metode_pembayaran">Pilih Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="BNI">BNI (Transfer Bank)</option>
                    <option value="COD">COD (Cash on Delivery)</option>
                </select>
            </div>

            <!-- Tanggal Bayar -->
            <div class="form-group">
                <label for="tanggal_bayar">Tanggal Bayar</label>
                <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" required>
            </div>

            <button type="submit" class="btn btn-success">Kirim Konfirmasi Pembayaran</button>
        </form>
    </div>
    <br><br><br><br><br><br>

    <?php include 'footer.php'; ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

<style>
	body{
		font-family: poppins;
	}
</style>
