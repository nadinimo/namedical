<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contact-container">
        <form name="contactForm" action="https://api.web3forms.com/submit" method="POST" class="contact-left">
            <div class="mt-6 mb-1">
                <h2>Hubungi Kami</h2>
                <hr>
            </div>
            <input type="hidden" name="access_key" value="3a6bd65d-63ea-43bb-82ff-41def00b2759">
            <input type="text" name="name" placeholder="Your Name" class="contact-inputs" required>
            <input type="email" name="email" placeholder="Your Email" class="contact-inputs" required>
            <textarea name="message" placeholder="Your Message" class="contact-input" required></textarea>
            <button type="submit">Submit <img src="image/arrow_icon.png" alt=""></button>
        </form>
        <div class="contact-right">
            <img src="image/icon_contact_us.png">
        </div>

        <!-- Tombol Kembali ke Index -->
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="index.php" class="btn btn-secondary">Kembali ke Halaman Utama</a>
            </div>
        </div>

    </div>
    
    <script>
    // Menghapus fungsi validasi email
    </script>

</body>
</html>

<?php 
include 'footer.php';
?>

<style>
    body {
        font-family: poppins;
    }
</style>
