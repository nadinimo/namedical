<?php
session_start();
include '../koneksi/koneksi.php';

$username = $_POST['username'];
$password = $_POST['pass'];

// Cek apakah username ada di database
$cek = mysqli_query($conn, "SELECT * FROM customer WHERE username = '$username'");
$jml = mysqli_num_rows($cek);
$row = mysqli_fetch_assoc($cek);

if($jml == 1){
    if(password_verify($password, $row['password'])){
        // Set session data setelah login berhasil
        $_SESSION['user'] = $row['nama'];
        $_SESSION['kd_cs'] = $row['kode_customer'];
        header('Location: ../index.php');  // Arahkan ke halaman utama setelah login
    } else {
        echo "
        <script>
        alert('USERNAME/PASSWORD SALAH');
        window.location = '../user_login.php';
        </script>
        ";
        die;
    }
} else {
    echo "
    <script>
    alert('USERNAME/PASSWORD SALAH');
    window.location = '../user_login.php';
    </script>
    ";
    die;
}
