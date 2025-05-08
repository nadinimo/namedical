<?php 
session_start();
include '../koneksi/koneksi.php';
if(!isset($_SESSION['admin'])){
	header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>NAMEDIC-ADMIN</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
	<script  src="../js/jquery.js"></script>
	<script  src="../js/bootstrap.min.js"></script>


</head>
<body>

	<nav class="navbar" style="padding: 5px; background-color: rgb(203, 221, 205);">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

            
            
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
                    <li><a href="halaman_utama.php">
                        <img src="../image/logo-namedic.png" alt="Logo NAMEDIC" style="height: 30px; display: inline-block; vertical-align: middle; margin-right: 5px;"></a>
                    </li>

					<li><a href="halaman_utama.php">Dashboard</a></li>
                    <li><a href="m_customer.php">Daftar Pelanggan</a></li>
					<li><a href="m_produk.php">Daftar Produk</a></li>
                    <li><a href="kelola_penjualan.php">Kelola Penjualan</a></li>
                    <li><a href="kelola_toko.php">Kelola Toko</a></li>
					<li><a href="laporan_penjualan.php">Laporan</a></li>
                    <li><a href="kelola_feedback.php">Feedback</a></li>

				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="proses/logout.php">Log Out</a></li>
						</ul>
					</li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>



