<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';

// Hapus data jika ada request 'page=del'
if(isset($_GET['page']) && $_GET['page'] === 'del'){
    $kode = $_GET['kode'];
    $result = mysqli_query($conn, "DELETE FROM customer WHERE kode_customer = '$kode'");
    if($result){
        echo "
        <script>
        alert('DATA BERHASIL DIHAPUS');
        window.location = 'm_customer.php';
        </script>
        ";
    }
}

// Cek jika ada pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM customer";
if (!empty($search)) {
    $query .= " WHERE kode_customer LIKE '%$search%' OR nama LIKE '%$search%' OR email LIKE '%$search%'";
}
$query .= " ORDER BY kode_customer ASC";
$result = mysqli_query($conn, $query);
?>

<div class="container">
    <h2><b>Data Customer</b></h2>

    <!-- Form Search -->
    <form method="GET" action="m_customer.php" class="form-inline mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau kode..." value="<?= htmlspecialchars($search); ?>" />
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="m_customer.php" class="btn btn-secondary">Reset</a>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Customer</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_customer']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <a href="detail_customer.php?kode=<?= $row['kode_customer']; ?>" class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i> Lihat Detail
                    </a>
                    <a href="m_customer.php?kode=<?= $row['kode_customer']; ?>&page=del" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus Data ?')">
                        <i class="glyphicon glyphicon-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

<style>
    body {
        font-family: Poppins, sans-serif;
    }
    .form-inline {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
</style>
