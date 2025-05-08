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

// Proses update status menggunakan POST (via AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE pesanan SET status_pesanan = '$status' WHERE id = '$order_id'";
    if (mysqli_query($conn, $update_query)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "Status pesanan berhasil diupdate";
        } else {
            echo "Tidak ada perubahan status";
        }
    } else {
        echo "Gagal mengupdate status pesanan: " . mysqli_error($conn);
    }
    exit();
}

// Pencarian
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = mysqli_query($conn, "SELECT * FROM pesanan 
                                  WHERE kode_order LIKE '%$search%' 
                                     OR status_pesanan LIKE '%$search%' 
                                     OR tanggal_order LIKE '%$search%' 
                                  ORDER BY tanggal_order DESC");
} else {
    $query = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY tanggal_order DESC");
}
?>

<div class="container mt-4">
    <h2><b>Kelola Penjualan</b></h2>

    <!-- Form Pencarian -->
    <form method="GET" class="form-inline mb-3 mt-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Cari kode, status, atau tanggal" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <!-- Tabel Pesanan -->
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Tanggal Order</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($query) > 0) {
                while ($order_data = mysqli_fetch_assoc($query)) {
            ?>
            <tr id="order-row-<?= $order_data['id']; ?>">
                <td><?= $no++; ?></td>
                <td><?= $order_data['kode_order']; ?></td>
                <td><?= date('d-m-Y', strtotime($order_data['tanggal_order'])); ?></td>
                <td id="status-<?= $order_data['id']; ?>"><?= $order_data['status_pesanan']; ?></td>
                <td>
                    <!-- Form untuk update status -->
                    <form class="update-status-form" data-order-id="<?= $order_data['id']; ?>">
                        <input type="hidden" name="order_id" value="<?= $order_data['id']; ?>">
                        <select name="status" class="form-control">
                            <option value="Menunggu Pembayaran" <?= ($order_data['status_pesanan'] == 'Menunggu Pembayaran') ? 'selected' : ''; ?>>Menunggu Pembayaran</option>
                            <option value="Dikemas" <?= ($order_data['status_pesanan'] == 'Dikemas') ? 'selected' : ''; ?>>Dikemas</option>
                            <option value="Dikirim" <?= ($order_data['status_pesanan'] == 'Dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                            <option value="Selesai" <?= ($order_data['status_pesanan'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
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

<!-- Include jQuery untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.update-status-form').on('submit', function(e) {
            e.preventDefault();

            var orderId = $(this).data('order-id');
            var status = $(this).find('select[name="status"]').val();

            $.ajax({
                url: 'kelola_penjualan.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    $('#status-' + orderId).text(status);
                    alert("Status berhasil diperbarui.");
                },
                error: function() {
                    alert("Terjadi kesalahan saat memperbarui status.");
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>

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
