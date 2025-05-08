<?php 
include '../koneksi/koneksi.php';

// Memastikan data dikirim dengan benar
if (isset($_POST['kode_cs'])) {
    // Mengambil kode customer yang dikirimkan melalui form
    $kd_cs = mysqli_real_escape_string($conn, $_POST['kode_cs']); 

    // Ambil data customer
    $cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd_cs'");
    $rows = mysqli_fetch_assoc($cs);

    // Auto-generate Nomor Pesanan (Order ID)
    $kode_order = 'ORD' . strtoupper(uniqid());

    // Simpan data pesanan ke tabel pesanan
    $pembayaran = 'COD'; // Static payment method as per your setup
    $status_pesanan = 'Menunggu Pembayaran'; // Status pesanan baru

    // Insert data pesanan
    $insert_order = "INSERT INTO pesanan (kode_order, kode_customer, pembayaran, status_pesanan, tanggal_order) 
                     VALUES ('$kode_order', '$kd_cs', '$pembayaran', '$status_pesanan', NOW())";
    
    if (mysqli_query($conn, $insert_order)) {
        // Ambil ID pesanan terbaru
        $order_id = mysqli_insert_id($conn);

        // Simpan item keranjang ke dalam pesanan
        $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd_cs'");
        
        // Periksa apakah ada item di keranjang
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $kode_produk = $row['kode_produk'];
                $qty = $row['qty'];
                $harga = $row['harga'];

                // Insert ke tabel order_detail
                $insert_detail = "INSERT INTO order_detail (order_id, kode_produk, qty, harga) 
                                  VALUES ('$order_id', '$kode_produk', '$qty', '$harga')";
                if (!mysqli_query($conn, $insert_detail)) {
                    // Jika terjadi error dalam insert ke order_detail
                    echo "<script>alert('Gagal menyimpan item pesanan.');</script>";
                    exit();
                }
            }

            // Hapus keranjang setelah pemesanan selesai
            $del_keranjang = mysqli_query($conn, "DELETE FROM keranjang WHERE kode_customer = '$kd_cs'");

            if ($del_keranjang) {
                // Redirect to selesai page
                header("Location: ../selesai.php?kode_cs=$kd_cs");
                exit();
            } else {
                echo "<script>alert('Gagal menghapus keranjang.');</script>";
            }
        } else {
            echo "<script>alert('Keranjang kosong. Tidak ada barang untuk dipesan.');</script>";
        }

    } else {
        // Jika gagal insert ke pesanan
        echo "<script>alert('Terjadi kesalahan dalam pemrosesan pesanan. Silakan coba lagi.');</script>";
    }
} else {
    echo "<script>alert('Data tidak lengkap.');</script>";
}
?>
