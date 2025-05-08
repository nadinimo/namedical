<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<?php 
include 'header.php';
?>

<img src="image/logo-namedic.png" alt="Logo NA MEDICAL" style="width: 100px; margin: 0 auto; display: block; margin-bottom: 20px;"> <!-- Logo ditambahkan -->
<h2 style="width: 100%; text-align: center; font-family: poppins; margin-top: 10px; margin-bottom: 50px;"><b>Selamat datang di NA MEDICAL</b></h2>


<div class="form" style="padding-bottom: 250px;">
	<h2 style=" width: 100%;"><b>Form Register</b></h2>
	<form action="proses/register.php" method="POST">
		<div class="row">
				<div class="form-group">
					<!-- awalnya nama -->
					<label for="exampleInputPassword1">Nama</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama" name="nama" required>

					<label for="exampleInputPassword1">Username</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Username" name="username" required >
				
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>

					<label for="exampleInputPassword1">Retype-Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Konfirmasi Password" name="konfirmasi" required>
				
					<label for="exampleInputPassword1">Email</label>
					<input type="email" class="form-control" id="exampleInputPassword1" placeholder="Email" name="email" required>
					
					<label for="exampleInputPassword1">Day Of Birth</label>
					<input type="date" class="form-control" id="exampleInputPassword1" placeholder="Tanggal Lahir" name="ttl" required>

					<!-- tidak ada di db -->
					<label for="exampleInputPassword1">Gender</label>
					<div>
    					<label class="radio-inline">
      					<input type="radio" name="gender" value="laki-laki" required> Laki-laki
    					</label>
    					<label class="radio-inline">
      					<input type="radio" name="gender" value="perempuan" required> Perempuan
    					</label>
  					</div>
					
					<!-- tidak ada di db -->
					<label for="exampleInputPassword1">Address</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Alamat" name="alamat" required>

					<!-- tidak ada di db -->
					<label for="exampleInputPassword1">City</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kota" name="kota" required>

					<!-- tidak ada di db -->
					<label for="exampleInputPassword1">No.Telp</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="No. Telp" name="telp" required>

					<label for="exampleInputPassword1">Pay-pal id :</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="PayPal" name="paypal" required>
					<br>
					<!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Connect no" name="nama"> -->
					<table>
						<tr>
							<td><button type="submit" class="btn btn-primary">Register</button></td>
							<td>&nbsp&nbsp</td>
							<td><button type="reset" class="btn btn-info">Clear</button></td>
						</tr>
					</table>
					
				</div>
		</div>
	</form>
</div>

<?php 
include 'footer.php';
?>
<style>
.form {
  box-sizing: border-box;
  padding: 20px;
  border: 1px solid #ccc;
  background-color: white;
  border-radius: 10px;
  max-width: 600px;
  max-height: 900px;
  margin: 0 auto;
  margin-bottom: 20px;
}

/* Gaya untuk judul */
h2 {
  text-align: center;
  color: #333;
}

/* Gaya untuk tombol */
.btn {
  background-color: #ff8680;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
}

/* Gaya untuk radio button */
.radio-inline {
  margin-right: 10px;
}

/* Gaya untuk label */
label {
  color: #555;
  font-weight: bold;
}

/* Gaya untuk form input */
.form-control {
  margin-bottom: 10px;
}
body{
	font-family: poppins;
}
</style>
