<?php 
include 'header.php';
// Ambil kode produk dari parameter URL
$kode_produk = $_GET['kode'];
$kode = mysqli_query($conn, "SELECT * from produk where kode_produk = '$kode_produk'");
$data = mysqli_fetch_assoc($kode);

// Mengambil data kategori produk
$categories = mysqli_query($conn, "SELECT * FROM kategori_produk");
?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Edit Produk</b></h2>

    <form action="proses/edit_produk.php" method="POST" enctype="multipart/form-data">

        <!-- Kode Produk -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kode Produk</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Kode Produk" disabled value="<?= $data['kode_produk']; ?>">
                    <input type="hidden" name="kode" class="form-control" value="<?= $data['kode_produk']; ?>">
                </div>
            </div>
        </div>

        <!-- Nama Produk dan Harga -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Produk" name="nama" value="<?= $data['nama']; ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Harga</label>
                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Harga" name="harga" value="<?= $data['harga']; ?>" required>
                </div>
            </div>
        </div>

        <!-- Deskripsi Produk -->
        <div class="form-group">
            <label for="exampleInputPassword1">Deskripsi</label>
            <textarea name="desk" class="form-control" required><?= $data['deskripsi']; ?></textarea>
        </div>

        <!-- Kategori Produk -->
        <div class="form-group">
            <label for="category">Kategori Produk</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <?php while($category = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $category['id_kategori']; ?>" <?= $category['id_kategori'] == $data['id_kategori'] ? 'selected' : ''; ?>><?= $category['nama_kategori']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Gambar Produk -->
        <div class="form-group">
            <label for="exampleInputFile"><img src="../image/produk/<?= $data['image']; ?>" width="100"></label>
            <input type="file" id="exampleInputFile" name="files">
            <p class="help-block">Pilih Gambar untuk Produk</p>
        </div>

        <!-- Tombol Submit dan Cancel -->
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-edit"></i> Edit</button>
            </div>
            <div class="col-md-6">
                <a href="m_produk.php" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>
    </form>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>

<?php 
include 'footer.php';
?>
