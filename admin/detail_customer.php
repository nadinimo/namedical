<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';

// Ambil kode customer dari parameter URL
$kode_customer = $_GET['kode'];
$query = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kode_customer'");
$data = mysqli_fetch_assoc($query);

?>

<div class="container">
    <h2><b>Detail Customer</b></h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Kode Customer</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Telepon</th>
                <th scope="col">Alamat</th>
                <th scope="col">Kota</th>
                <th scope="col">Gender</th>
                <th scope="col">Paypal</th>
                <th scope="col">Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $data['kode_customer']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['email']; ?></td>
                <td><?= $data['username']; ?></td>
                <td><?= $data['telp']; ?></td>
                <td><?= $data['alamat']; ?></td>
                <td><?= $data['kota']; ?></td>
                <td><?= $data['gender']; ?></td>
                <td><?= $data['paypal']; ?></td>
                <td><?= $data['ttl']; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Tombol Kembali ke Daftar Customer -->
    <a href="m_customer.php" class="btn btn-secondary">Kembali ke Daftar Customer</a>
</div>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }
</style>
