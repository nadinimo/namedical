<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
?>

<div class="container">
    <h2 style=" width: 100%;"><b>Master Produk</b></h2>
	<br>
	<br>

    <!-- Menyusun Form Pencarian dan Tombol Tambah dalam satu baris -->
    <div class="d-flex justify-content-between mb-3">
        <!-- Form Pencarian -->
        <form method="GET" action="" class="d-flex w-75">
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari Berdasarkan Kode Produk atau Nama Produk" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="width: 80%;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Tombol Tambah Produk -->
        <a href="tm_produk.php" class="btn btn-primary ml-3">Tambah Produk</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Kategori Produk</th>
                <th scope="col">Gambar</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ambil input pencarian
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Menyesuaikan query untuk mencari berdasarkan kode produk atau nama produk
            $query = "SELECT produk.*, kategori_produk.nama_kategori 
                      FROM produk 
                      LEFT JOIN kategori_produk 
                      ON produk.id_kategori = kategori_produk.id_kategori";
            
            // Menambahkan kondisi pencarian pada query
            if ($search != '') {
                $query .= " WHERE produk.kode_produk LIKE '%$search%' OR produk.nama LIKE '%$search%'";
            }

            // Urutkan produk berdasarkan kode produk secara DESC
            $query .= " ORDER BY produk.kode_produk DESC";

            // Eksekusi query
            $result = mysqli_query($conn, $query);
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['kode_produk']; ?></td>
                    <td><?= $row['nama'];  ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td><img src="../image/produk/<?= $row['image']; ?>" width="100"></td>
                    <td>Rp.<?= number_format($row['harga']);  ?></td>
                    <td>
                        <a href="edit_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-warning">
                            <i class="glyphicon glyphicon-pencil"></i> 
                        </a>
                        <a href="proses/del_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus Data ?')">
                            <i class="glyphicon glyphicon-trash"></i> 
                        </a>
                    </td>
                </tr>
            <?php
                $no++; 
            }
            ?>
        </tbody>
    </table>

</div>
<br>
<br>
<br>
<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }

    /* Additional custom styles */
    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .d-flex .form-control {
        width: 80%;
    }
</style>
