<?php
// Memulai session jika belum ada yang aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sertakan koneksi ke database
include 'koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAMEDIC-USER</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">
                    <img src="image/logo-namedic.png" alt="Logo NAMEDIC" style="height: 30px; display: inline-block; vertical-align: middle; margin-right: 5px;">
                    <b>NAMEDIC</b>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><a href="about_us.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="pesanan_saya.php">Pesanan Saya</a></li>

                    <?php 
                    if (isset($_SESSION['kd_cs'])) {
                        $kode_cs = $_SESSION['kd_cs'];
                        $cek = mysqli_query($conn, "SELECT kode_produk from keranjang where kode_customer = '$kode_cs'");
                        $value = mysqli_num_rows($cek);
                        ?>
                        <li><a href="keranjang.php"><i class="glyphicon glyphicon-shopping-cart"></i> <b>[ <?= $value ?> ]</b></a></li>
                    <?php 
                    } else {
                        echo "<li><a href='keranjang.php'><i class='glyphicon glyphicon-shopping-cart'></i> [0]</a></li>";
                    }

                    // Jika sudah login, tampilkan nama pengguna dan tombol logout
                    if (isset($_SESSION['user'])) {
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="glyphicon glyphicon-user"></i> <?= $_SESSION['user']; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="profil.php">Profil</a></li>
                                <li><a href="proses/logout.php">Log Out</a></li>
                            </ul>
                        </li>
                    <?php 
                    } else {
                        // Jika belum login, tampilkan link login dan register
                        echo '<li><a href="user_login.php"><i class="glyphicon glyphicon-user"></i> Login</a></li>';
                        echo '<li><a href="register.php"><i class="glyphicon glyphicon-pencil"></i> Register</a></li>';
                    }
                    ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</body>
</html>

<style>
    .navbar {
        background-color: rgb(203, 221, 205); 
        padding: 5px;
    }

    .navbar-brand {
        color: #176B87;
    }

    .navbar-nav li a {
        color: #176B87;
        padding: 10px 15px;
    }

    .navbar-nav li a:hover {
        background-color: #f8f8f8;
    }
</style>
