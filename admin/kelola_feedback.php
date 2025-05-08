<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
include '../koneksi/koneksi.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit();
}

// Cek jika tombol hapus ditekan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM feedback WHERE id = '$delete_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Feedback berhasil dihapus'); window.location = 'kelola_feedback.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus feedback');</script>";
    }
}

// Pencarian
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = mysqli_query($conn, "SELECT feedback.*, pesanan.kode_order FROM feedback 
                                  JOIN pesanan ON feedback.order_id = pesanan.id 
                                  WHERE pesanan.kode_order LIKE '%$search%' 
                                     OR feedback.rating LIKE '%$search%' 
                                     OR feedback.komentar LIKE '%$search%'");
} else {
    $query = mysqli_query($conn, "SELECT feedback.*, pesanan.kode_order FROM feedback 
                                  JOIN pesanan ON feedback.order_id = pesanan.id");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Feedback</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="container mt-4">
        <h2><b>Kelola Feedback</b></h2>

        <!-- Form Pencarian -->
        <form method="GET" class="form-inline mb-3 mt-3">
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari berdasarkan kode, rating, komentar" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Tabel Feedback -->
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Kode Order</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($query) > 0) {
                    while ($feedback_data = mysqli_fetch_assoc($query)) {
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $feedback_data['kode_order']; ?></td>
                            <td><?= $feedback_data['rating']; ?></td>
                            <td><?= $feedback_data['komentar']; ?></td>
                            <td>
                                <a href="kelola_feedback.php?delete_id=<?= $feedback_data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus feedback ini?')">Hapus</a>
                            </td>
                        </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <?php include 'footer.php'; ?>
</body>
</html>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .form-inline input {
        width: 300px;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>
