<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
$kode = mysqli_real_escape_string($conn,$_GET['produk']);
$result = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk = '$kode'");
$row = mysqli_fetch_assoc($result);

?>
<div class="container">
	<h2 style=" width: 100%; font-family: poppins"><b>Detail Produk</b></h2>

	<div class="row">
		<div class="col-md-4">
			<div class="thumbnail">
				<img src="image/produk/<?= $row['image']; ?>" width="400">
			</div>
		</div>

		<div class="col-md-8">
			<form action="proses/add.php" method="GET">
				<input type="hidden" name="kd_cs" value="<?= $kode_cs; ?>">
				<input type="hidden" name="produk" value="<?= $kode;  ?>">
				<input type="hidden" name="hal"  value="2">
				<h1><?= $row['nama']; ?></h1>
				<table class="table">
					<tbody>
						<tr>
							<td><b>Deskripsi</b></td>
							<td><?= $row['deskripsi'];  ?></td>
						</tr>
						<tr>
							<td><b>Harga</b></td>
							<td>Rp.<?= number_format($row['harga']); ?></td>
						</tr>
						<tr>
							<td><b>Jumlah</b></td>
							<td><input class="form-control" type="number" min="1" name="jml" value="1" style="width: 155px;"></td>
						</tr>
					</tbody>
				</table>
				<?php 
				if(isset($_SESSION['user'])){
					?>
					<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</button>
					<?php 
				}else{

					?>
					<a href="keranjang.php" class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
					<?php 
				}
				?>
				<a href="produk.php" class="btn btn-danger">Back</a>
			</div>
		</form>
	</div>


</div>	
<br>
<br>

<?php 
include 'footer.php';
?>

<style>
	body{
		font-family: poppins;
	}
</style>