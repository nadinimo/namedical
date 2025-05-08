<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';

$selectedCategory = mysqli_real_escape_string($conn, $_GET['kategori']);

// Ambil nama kategori
$categoryQuery = mysqli_query($conn, "SELECT nama_kategori FROM kategori_produk WHERE id_kategori = '$selectedCategory'");
$categoryRow = mysqli_fetch_assoc($categoryQuery);
$categoryName = $categoryRow['nama_kategori'];
?>

<div class="container">
    <div class="row">
        <!-- Kategori di sebelah kiri -->
        <div class="col-md-3">
            <div class="category">
                <h2><b>Kategori</b></h2>
                <ul class="list-group">
                    <?php 
                    $result1 = mysqli_query($conn, "SELECT * FROM kategori_produk");
                    while($row = mysqli_fetch_assoc($result1)){
                    ?>
                    <li class="list-group-item">
                        <a href="kategori_proses.php?kategori=<?= $row['id_kategori']; ?>"><?= $row['nama_kategori']; ?></a>
                    </li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Produk di sebelah kanan -->
        <div class="col-md-9">
            <h2 style="width: 100%; font-family: poppins; margin-bottom: 20px;"><b>Daftar Produk <?= $categoryName; ?></b></h2>

            <!-- Search form -->
            <form method="GET" action="" class="mb-4">
                <input type="hidden" name="kategori" value="<?= $selectedCategory ?>">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama Produk" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <?php 
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $query = "SELECT * FROM produk WHERE id_kategori = '$selectedCategory'";
                if ($search != '') {
                    $query .= " AND nama LIKE '%$search%'";
                }

                $result = mysqli_query($conn, $query);

                if ($result === false) {
                    echo "Error: " . mysqli_error($conn);
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <img src="image/produk/<?= $row['image']; ?>" class="card-img-top" alt="<?= $row['nama']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['nama']; ?></h5>
                            <p class="card-text"><?= substr($row['deskripsi'], 0, 100); ?>...</p>
                            <h5 class="card-price">Rp. <?= number_format($row['harga']); ?></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn btn-info btn-block">Lihat</a> 
                                </div>
                                <?php if(isset($_SESSION['kd_cs'])){ ?>
                                <div class="col-md-6">
                                    <a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-primary btn-block" role="button">Beli</a>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-6">
                                    <a href="keranjang.php" class="btn btn-primary btn-block" role="button">Beli</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
    body {
        font-family: poppins;
    }
    .category {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
    }
    .category ul {
        padding-left: 0;
    }
    .category ul li a {
        text-decoration: none;
        color: #176b87;
    }
    .card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }
    .card-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
    }
    .card-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #176b87;
    }
</style>
