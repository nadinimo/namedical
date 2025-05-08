<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';

if (isset($_GET['hapus_keranjang'])) {
    $kd = mysqli_real_escape_string($conn, $_GET['hapus_keranjang']);

    // Hapus semua item keranjang yang terkait dengan kode pelanggan
    $queryHapusKeranjang = "DELETE FROM keranjang WHERE kode_customer = '$kd'";
    mysqli_query($conn, $queryHapusKeranjang);
}


if(isset($_POST['submit1'])){
	$id_keranjang = $_POST['id'];
	$qty = $_POST['qty'];

	$edit = mysqli_query($conn, "UPDATE keranjang SET qty = '$qty' where id_keranjang = '$id_keranjang'");
	if($edit){
			echo "
		<script>
		alert('KERANJANG BERHASIL DIPERBARUI');
		window.location = 'keranjang.php';
		</script>
		";
	}
}else if(isset($_GET['del'])){
	$id_keranjang = $_GET['id'];
	$del = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");
}

?>


<div class="container" style="padding-bottom: 300px;">
	<h2 style=" width: 100%; font-family: poppins; padding-bottom: 20px;"><b>Keranjang Belanja</b></h2>
		<table class="table">
			<?php 
			if(isset($_SESSION['user'])){
				$kode_cs = $_SESSION['kd_cs'];
			// CEK JUMLAH KERANJANG
				$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");
				$jml = mysqli_num_rows($cek);

				if($jml > 0){
					?>	
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Gambar</th>
							<th scope="col">Nama</th>
							<th scope="col">Harga</th>
							<th scope="col">Jumlah</th>
							<th scope="col">Total</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<?php 
					if(isset($_SESSION['kd_cs'])){
						$kode_cs = $_SESSION['kd_cs'];

						$result = mysqli_query($conn, "SELECT k.id_keranjang as keranjang, k.kode_produk as kd, k.nama_produk as nama, k.qty as jml, p.image as gambar, p.harga as hrg FROM keranjang k join produk p on k.kode_produk=p.kode_produk WHERE kode_customer = '$kode_cs'");
						$no = 1;
						$hasil = 0;
						while($row = mysqli_fetch_assoc($result)){
				
					?>
					<tbody>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<input type="hidden" name="id" value="<?php echo $row['keranjang']; ?>">
						<tr>
							<th scope="row"><?= $no;  ?></th>
							<td><img src="image/produk/<?= $row['gambar']; ?>" width="100"></td>
							<td><?= $row['nama']; ?></td>
							<td>Rp.<?= number_format($row['hrg']);  ?></td>
							<td><input type="number" name="qty" class="form-control" style="text-align: center; width: 50px;" value="<?= $row['jml']; ?>"></td>
							<td>Rp.<?= number_format($row['hrg'] * $row['jml']);  ?></td>
							<td><button type="submit" name="submit1" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></button> | <a href="keranjang.php?del=1&id=<?= $row['keranjang']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin dihapus ?')"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
						</form>
					<?php 
							$sub = $row['hrg'] * $row['jml'];
							$hasil += $sub;
							$no++;
						}
					}
					 ?>
					 
						<tr>
							<td colspan="7" style="text-align: right; font-weight: bold;">Total Keseluruhan = Rp.<?= number_format($hasil); ?></td>
						</tr>
						<tr>
							<td colspan="7" style="text-align: right; font-weight: bold;"><a href="produk.php" class="btn btn-info">Belanja Lagi</a> <a href="checkout.php?kode_cs=<?= $kode_cs; ?>" class="btn btn-primary">Checkout</a></td>
						</tr>
						<?php 
					}else{
						echo "
						<tr>
						<th scope='col'>No</th>
						<th scope='col'>Gambar</th>
						<th scope='col'>Nama</th>
						<th scope='col'>Harga</th>
						<th scope='col'>Jumlah</th>
						<th scope='col'>Total</th>
						<th scope='col'>Aksi</th>
						</tr>
						<tr>
						<td colspan='7' class='text-center bg-warning'><h5><b>KERANJANG ANDA MASIH KOSONG, SILAHKAN MELAKUKAN PEMBELIAN!</b></h5></td>
						</tr>
						<tr>

						<td><a href='produk.php' class='btn btn-primary' role='button'>Belanja Sekarang</a></td>
						</tr>
						";
					}

				}else{
					echo "<script>
					alert('MAAF ANDA BELUM LOGIN!');
					window.location = 'user_login.php';
					</script>";
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