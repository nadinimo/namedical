<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
include 'koneksi/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

// Ambil kode customer dari session
$kode_cs = $_SESSION['kd_cs'];

// Ambil data customer dari database
$query = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kode_cs'");
$user_data = mysqli_fetch_assoc($query);

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['nama_toko'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $gender = $_POST['gender'];
    $ttl = $_POST['ttl'];
    $paypal = $_POST['paypal'];
    $gambar_lama = $user_data['image'];

    // Proses upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_temp = $image['tmp_name'];
        $image_size = $image['size'];

        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $ext;

        // Validasi ekstensi gambar
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($ext), $allowed_ext)) {
            echo "<script>alert('Ekstensi gambar tidak valid. Harus jpg, jpeg, atau png.');</script>";
        } elseif ($image_size > 2 * 1024 * 1024) { // Maksimal 2MB
            echo "<script>alert('Ukuran gambar terlalu besar. Maksimal 2MB.');</script>";
        } else {
            // Menghapus gambar lama jika ada
            if ($gambar_lama && file_exists("image/profil/$gambar_lama")) {
                unlink("image/profil/$gambar_lama");
            }
            
            // Pindahkan gambar ke folder
            move_uploaded_file($image_temp, "image/profil/$new_image_name");
        }
    } else {
        $new_image_name = $gambar_lama; // Jika gambar tidak diubah
    }

    // Update data user ke database
    $update_query = "UPDATE customer SET 
                     nama = '$nama', 
                     email = '$email', 
                     telp = '$telp', 
                     alamat = '$alamat', 
                     kota = '$kota', 
                     gender = '$gender', 
                     ttl = '$ttl', 
                     paypal = '$paypal', 
                     image = '$new_image_name' 
                     WHERE kode_customer = '$kode_cs'";

    if (mysqli_query($conn, $update_query)) {
        // Setelah berhasil update, update sesi
        $_SESSION['user'] = $nama; // Update session dengan nama baru
        echo "<script>alert('Profil berhasil diperbarui');</script>";
        header('Location: profil.php');
    } else {
        echo "<script>alert('Terjadi kesalahan. Coba lagi.');</script>";
    }
}

// Proses ajukan buka toko
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_toko'])) {
    $nama_toko = $_POST['nama_toko'];
    $kategori_toko = $_POST['kategori_toko'];
    $alamat_toko = $_POST['alamat_toko'];
    $deskripsi_toko = $_POST['deskripsi_toko'];

    // Simpan data pengajuan toko ke database
    $insert_query = "INSERT INTO toko (kode_customer, nama_toko, kategori_toko, alamat_toko, deskripsi_toko, status_pengajuan) 
                     VALUES ('$kode_cs', '$nama_toko', '$kategori_toko', '$alamat_toko', '$deskripsi_toko', 'Menunggu')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Pengajuan toko berhasil!');</script>";
        header('Location: profil.php');
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengajukan toko. Coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .profil-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .container {
            max-width: 800px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
        }

        /* CSS untuk Status Pengajuan seperti tombol */
        .status-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        .approved {
            background-color: #28a745; /* Warna hijau untuk Disetujui */
        }

        .pending {
            background-color: #ffc107; /* Warna kuning untuk Pending */
        }

        .rejected {
            background-color: #dc3545; /* Warna merah untuk Ditolak */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><b>Profil Pengguna</b></h2>
        
        <!-- Display Foto Profil -->
        <div class="text-center mb-4">
            <img src="image/profil/<?= $user_data['image'] ? $user_data['image'] : 'default.png'; ?>" alt="Foto Profil" class="profil-image">
        </div>

        <!-- Formulir Update Profil -->
        <form action="profil.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Ganti Foto Profil</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= $user_data['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $user_data['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telp">Nomor Telepon</label>
                <input type="text" name="telp" id="telp" class="form-control" value="<?= $user_data['telp']; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $user_data['alamat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control" value="<?= $user_data['kota']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="L" <?= $user_data['gender'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= $user_data['gender'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ttl">Tanggal Lahir</label>
                <input type="date" name="ttl" id="ttl" class="form-control" value="<?= $user_data['ttl']; ?>" required>
            </div>
            <div class="form-group">
                <label for="paypal">Paypal</label>
                <input type="text" name="paypal" id="paypal" class="form-control" value="<?= $user_data['paypal']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Profil</button>
        </form>

        <br><br>

        <!-- Formulir Ajukan Toko -->
        <form action="profil.php" method="POST">
            <h3><b>Ajukan Buka Toko</b></h3>

            <div class="form-group">
                <label for="nama_toko">Nama Toko</label>
                <input type="text" name="nama_toko" id="nama_toko" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="kategori_toko">Kategori Toko</label>
                <input type="text" name="kategori_toko" id="kategori_toko" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat_toko">Alamat Toko</label>
                <input type="text" name="alamat_toko" id="alamat_toko" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi_toko">Deskripsi Toko</label>
                <textarea name="deskripsi_toko" id="deskripsi_toko" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Ajukan Toko</button>
        </form>
        
        <br><br>
        
        <?php 
        // Menampilkan status pengajuan toko jika ada
        $query_toko = mysqli_query($conn, "SELECT * FROM toko WHERE kode_customer = '$kode_cs'");
        $toko_data = mysqli_fetch_assoc($query_toko);
        if ($toko_data) {
            echo "<h3>Status Pengajuan Toko</h3>";
            echo "<p>Nama Toko: " . $toko_data['nama_toko'] . "</p>";
            echo "<p>Kategori: " . $toko_data['kategori_toko'] . "</p>";
            echo "<p>Alamat: " . $toko_data['alamat_toko'] . "</p>";
            echo "<p>Deskripsi: " . $toko_data['deskripsi_toko'] . "</p>";

            // Menampilkan status dengan tampilan button untuk 'Disetujui'
            $status = $toko_data['status_pengajuan'];
            if ($status == 'Disetujui') {
                echo "<p><span class='status-button approved'>$status</span></p>";
            } elseif ($status == 'Menunggu') {
                echo "<p><span class='status-button pending'>$status</span></p>";
            } else {
                echo "<p><span class='status-button rejected'>$status</span></p>";
            }
        }
        ?>
    </div>
</body>
</html>

<br><br><br><br><br><br>

<?php 
include 'footer.php';
?>

<style>
    body{
        font-family: poppins;
    }
</style>
