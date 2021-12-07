<?php 
if (isset($_COOKIE["login"])) {
	$keynya = $_COOKIE["login"];
	$keyy = base64_decode($keynya);
	
	$check_user = $koneksi->query("SELECT * FROM admin WHERE api_key = '$keyy'");
	if (mysqli_num_rows($check_user) == 0) {
		$msg_type = "error";
		$msg_content = " Anda Harus Login.";
	} else {
		$data_user = mysqli_fetch_assoc($check_user);
		if ($data_user['status'] == "NONAKTIF") {
			$msg_type = "error";
			$msg_content = " Akun Nonaktif 2.";
		} else {
			$_SESSION['user'] = $data_user;
			header("Location: /");
		}
	}
	
}

if (isset($_POST['login'])) {

	$post_username = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['username'],ENT_QUOTES)))));
	$post_password = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['password'],ENT_QUOTES)))));
	
	if(isset($_POST['remember'])){
		if($_POST['remember'] == "remember"){
			$remember = "yes";
		} else {
			$remember = "no";
		}
	} else {
		$remember = "no";
	}
		if (empty($post_username) || empty($post_password)) {
			$msg_type = "error";
			$msg_content = " Mohon Mengisi Semua Input.";
		} else {
			$check_user = $koneksi->query("SELECT * FROM admin WHERE email = '$post_username' OR username = '$post_username'");
			if (mysqli_num_rows($check_user) == 0) {
				$msg_type = "error";
				$msg_content = " Akun Tidak Terdaftar.";
			} else {
				$data_user = mysqli_fetch_assoc($check_user);
				if ($data_user['status'] == "NONAKTIF") {
					$msg_type = "error";
					$msg_content = " Akun Nonaktif.";
				} else {
					if(password_verify($post_password, $data_user['password'])) {
						$_SESSION['user'] = $data_user;
						
						$key = $data_user['api_key'];
						$en = base64_encode($key);
						$enn = str_replace("=","",$en);
						if($remember == "yes"){
							setcookie("login", $enn, strtotime('+1 year'),"/");
						}
						echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=\">";
					} else {
						$msg_type = "error";
						$msg_content = " Username/Password Salah.";
					}
				}
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b><?php echo $config["name"];?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login for start your session.</p>
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
          <input type="text" class="form-control" placeholder="Username/Email" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" value="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
	  <br>
      <p class="mb-0">
        <a href="?PAGE=DAFTAR" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
