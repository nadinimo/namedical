<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
include '../koneksi/koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Proses pencarian
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Ambil daftar semua toko yang telah diajukan (dengan pencarian jika ada)
$query_toko = mysqli_query($conn, "SELECT * FROM toko WHERE nama_toko LIKE '%$search_query%' OR kategori_toko LIKE '%$search_query%' OR alamat_toko LIKE '%$search_query%'");

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_toko = $_GET['id_toko'];
    
    // Hapus data toko
    $delete_query = "DELETE FROM toko WHERE id_toko = '$id_toko'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Toko berhasil dihapus');</script>";
        header("Location: kelola_toko.php");
    } else {
        echo "<script>alert('Gagal menghapus toko');</script>";
    }
}

// Proses pembaruan status toko
if (isset($_POST['update_status'])) {
    $id_toko = $_POST['id_toko'];
    $status_pengajuan = $_POST['status_pengajuan'];

    // Validasi agar status tidak kosong
    if (!in_array($status_pengajuan, ['Menunggu', 'Disetujui', 'Ditolak'])) {
        echo "<script>alert('Status tidak valid');</script>";
    } else {
        $update_status_query = "UPDATE toko SET status_pengajuan = '$status_pengajuan' WHERE id_toko = '$id_toko'";
        if (mysqli_query($conn, $update_status_query)) {
            echo "<script>alert('Status toko berhasil diperbarui');</script>";
            header("Location: kelola_toko.php");
        } else {
            echo "<script>alert('Gagal memperbarui status toko');</script>";
        }
    }
}
?>

<div class="container">
    <h2><b>Kelola Toko</b></h2>
    
    <!-- Form Pencarian dalam satu baris -->
    <form action="kelola_toko.php" method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" value="<?= $search_query ?>" placeholder="Cari Toko, Kategori, atau Alamat">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>
    
    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Toko</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($toko = mysqli_fetch_assoc($query_toko)) {
                // Pastikan status_pengajuan ada, jika tidak beri nilai default "Menunggu"
                $status_pengajuan = isset($toko['status_pengajuan']) ? $toko['status_pengajuan'] : 'Menunggu';
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $toko['nama_toko']; ?></td>
                    <td><?= $toko['kategori_toko']; ?></td>
                    <td><?= $toko['alamat_toko']; ?></td>
                    <td><?= $toko['deskripsi_toko']; ?></td>
                    <td>
                        <form action="kelola_toko.php" method="POST">
                            <input type="hidden" name="id_toko" value="<?= $toko['id_toko']; ?>">
                            <select name="status_pengajuan" class="form-control" required>
                                <option value="Menunggu" <?= $status_pengajuan == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="Disetujui" <?= $status_pengajuan == 'Disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="Ditolak" <?= $status_pengajuan == 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-warning mt-2">Perbarui Status</button>
                        </form>
                    </td>
                    <td>
                        <a href="kelola_toko.php?action=delete&id_toko=<?= $toko['id_toko']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus toko ini?')">Hapus</a>
                    </td>
                </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>

<?php 
include 'footer.php';
?>

<style>
    body{
        font-family: poppins;
    }
</style>
