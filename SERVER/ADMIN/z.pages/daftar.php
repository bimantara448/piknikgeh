<?php
if (isset($_POST['daftar'])) {
	    
		$post_nama = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['nama'],ENT_QUOTES)))));
		$post_username = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['username'],ENT_QUOTES)))));
		$post_password1 = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['password1'],ENT_QUOTES)))));
		$post_password2 = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['password2'],ENT_QUOTES)))));
		$post_email = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['email'],ENT_QUOTES)))));
		
		$new_password = password_hash($post_password1, PASSWORD_DEFAULT);
		
		$check_user = $koneksi->query("SELECT * FROM admin WHERE username = '$post_username'");
		$check_email = $koneksi->query("SELECT * FROM admin WHERE email = '$post_email'");

		if (empty($post_nama) || empty($post_username) || empty($post_password1) || empty($post_password2) || empty($post_email)) {
			$msg_type = "error";
			$msg_content = "Mohon Mengisi Semua Input.";
		}else if (mysqli_num_rows($check_user) > 0) {
			$msg_type = "error";
			$msg_content = "Username Telah Terdaftar.";
		} else if (mysqli_num_rows($check_email) > 0) {
			$msg_type = "error";
			$msg_content = "Email Telah Terdaftar.";
		}  else if (strlen($post_username) > 16) {
			$msg_type = "error";
			$msg_content = "Username Maksimal 16 Karakter.";
		} else if (strlen($post_username) < 5) {
			$msg_type = "error";
			$msg_content = "Username Minimal 5 Karakter.";
		} else if (strlen($post_password1) > 16) {
			$msg_type = "error";
			$msg_content = "Password Maksimal 16 Karakter.";
		} else if (strlen($post_password1) < 5) {
			$msg_type = "error";
			$msg_content = "Password Minimal 5 Karakter.";
		} else if ($post_password1 <> $post_password2) {
			$msg_type = "error";
			$msg_content = "Konfirmasi Password Tidak Sesuai.";
		} else {
			$post_api = random(30);
			
			$insert_user = $koneksi->query("INSERT INTO admin (nama, email, username, password, api_key, status) VALUES 
			('$post_nama', '$post_email', '$post_username', '$new_password', '$post_api', 'AKTIF')");			
			
			if ($insert_user) {
				$check_user = $koneksi->query("SELECT * FROM admin WHERE username = '$post_username'");
				$data_user = mysqli_fetch_assoc($check_user);
				$_SESSION['user'] = $data_user;
				$msg_type = "success";
				$msg_content = "Pendaftaran Berhasil. Anda Akan Dialihkan Ke Halaman Login.<META HTTP-EQUIV=Refresh CONTENT=\"3; URL=\">";
			} else {
				$msg_type= "error";
				$msg_content = "Error System.";
			}
			
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $config["name"];?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="/"><b><?php echo $config["name"];?></b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>
		<?php if($msg_type == "success"){ ?>
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <h5><i class="icon fas fa-ban"></i> Sukses!</h5>
				<?php echo $msg_content;?>
			</div>
		<?php } else if ($msg_type == "error") { ?>
			<div class="alert alert-danger alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
				<?php echo $msg_content;?>
			</div>
		<?php } ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="nama">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password1">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password2">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="daftar">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <br>
      <a href="?" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
