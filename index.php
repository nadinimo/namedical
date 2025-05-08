<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
?>
<!-- IMAGE -->
<div class="container-fluid" style="margin: 0;padding: 0;">
	<table>
		<tr>
			<td>
				<h2 class="datang">Selamat datang di NAMEDIC!</h2>
				<h4 class="text-left">Pusat Alat Kesehatan Terpercaya untuk Kebutuhan Rumah & Medis. Butuh alat kesehatan yang berkualitas tanpa ribet?
				Kami hadir sebagai solusi untuk Anda — dari kebutuhan rumah tangga, klinik, hingga rumah sakit!</h4>
				<a href="produk.php" class="btn btn-primary" role="button" style="margin-left: 50px;">Belanja Sekarang</a> 
			</td>
			<td>
				<div class="image" style="margin-top: -21px">
				<img src="image/home/icon-hero1.png" style="width: 400px;  height: 400px; float: right;">
				</div>
			</td>
		</tr>
	</table>
</div>
<br>
<br>

<!-- PRODUK KAMI -->
<div class="container">
    <h2><b>Produk Kami</b></h2>

    <div class="row">
        <?php 
        $result = mysqli_query($conn, "SELECT * FROM produk");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <!-- Kolom Produk -->
        <div class="col-sm-6 col-md-3 mb-4"> <!-- 4 produk per baris -->
            <div class="card shadow-sm">
                <img src="image/produk/<?= $row['image']; ?>" class="card-img-top" alt="<?= $row['nama']; ?>" style="height: 250px; object-fit: cover; border-radius: 10px 10px 0 0;">
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 1.1rem;"><?= $row['nama'];  ?></h5> <!-- Increased font size -->
                    <h6 class="card-text"><?= substr($row['deskripsi'], 0, 100); ?>...</h6> <!-- Shortened description -->
                    <h5 class="card-price" style="font-size: 1.1rem; font-weight: bold; color: #176B87;">Rp. <?= number_format($row['harga']); ?></h5>
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
        ?>
    </div>
</div>
<br>
<br>

<br>
<br>
<br>
<br>
<?php 
include 'footer.php';
?>
<style>
	body{
		font-family: poppins; 
	}
	h4{
		font-family: poppins; 
		font-size: 15px; 
		padding-top: 10px; 
		padding-bottom: 10px; 
		margin-left: 50px;
	}
	h2{
		width: 100%; 
		margin-top: 40px;
		font-family: poppins;
		font-size: 30px; 
		margin-bottom: 20px; 
	}
	.datang{
		font-family: poppins; 
		font-size: 40px; 
		padding-top: 10px; 
		margin-left: 50px;
	}
	.card {
		border: none;
		border-radius: 10px;
		transition: all 0.3s ease;
	}
	.card:hover {
		box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
	}
	.card-title {
		font-size: 1.1rem;
		font-weight: bold;
		color: #333;
	}
	.card-price {
		font-size: 1.1rem;
		font-weight: bold;
		color: #176b87;
	}
	.card-img-top {
		object-fit: cover;
		height: 250px;
		border-radius: 10px 10px 0 0;
	}
</style>
