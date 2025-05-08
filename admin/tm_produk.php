<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
// generate kode produk
$kode = mysqli_query($conn, "SELECT kode_produk from produk order by kode_produk desc");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['kode_produk'], 1, 4);
$add = (int) $num + 1;
if(strlen($add) == 1){
    $format = "P000".$add;
}else if(strlen($add) == 2){
    $format = "P00".$add;
}else if(strlen($add) == 3){
    $format = "P0".$add;
}else{
    $format = "P".$add;
}

// Mengambil data kategori produk dari database
$categories = mysqli_query($conn, "SELECT * FROM kategori_produk");
?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Tambah Produk</b></h2>

    <form action="proses/tm_produk.php" method="POST" enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kode Produk</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Kode Produk" disabled value="<?= $format; ?>">
                    <input type="hidden" name="kode" class="form-control" value="<?= $format; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Produk" name="nama" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Dropdown Kategori Produk -->
                <div class="form-group">
                    <label for="category">Kategori Produk</label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php while($category = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?= $category['id_kategori']; ?>"><?= $category['nama_kategori']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Harga</label>
                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Contoh : 12000" name="harga" required>
                    <p class="help-block">Isi Harga tanpa menggunakan Titik(.) atau Koma (,)</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Deskripsi</label>
            <textarea name="desk" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputFile">Pilih Gambar </label>
            <input type="file" id="exampleInputFile" name="files" required>
            <p class="help-block">Pilih Gambar untuk Produk</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-success btn-block"><i class="glyphicon glyphicon-plus-sign"></i> Tambah</button>
            </div>
            <div class="col-md-6">
                <a href="m_produk.php" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>

        <br>
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
