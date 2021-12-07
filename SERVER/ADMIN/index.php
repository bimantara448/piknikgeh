<?php 
$msg_type = "";
session_start();
require_once("../CONFIG/config.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	
	$check_user = $koneksi->query("SELECT * FROM admin WHERE username = '$sess_username'");
	if(mysqli_num_rows($check_user) == 1){
		$data_user_cek = mysqli_fetch_assoc($check_user);
		
		$sess_pass = $_SESSION['user']['password'];
		$data_pass = $data_user_cek['password'];
		
		$sess_pass_md5 = md5("$sess_pass");
		$data_pass_md5 = md5("$data_pass");
		if($sess_pass_md5 == $data_pass_md5){
			$LOGIN = TRUE;
		} else {
			$LOGIN = FALSE;
		}
	} else {
		$LOGIN = FALSE;
	}
} else {
	$LOGIN = FALSE;
}

if($LOGIN == TRUE){
	$check_user = $koneksi->query("SELECT * FROM admin WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	
	$u_nama = $data_user['nama'];
	$u_username = $data_user['username'];
	$u_password = $data_user['password'];
	$u_status = $data_user['status'];
	
	if($u_status == "NONAKTIF"){
		header("Location : /logout.php");
	}
}

if(isset($_GET['PAGE'])){
	$halaman = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_GET['PAGE'],ENT_QUOTES)))));
} else {
	$halaman = "";
}

if($LOGIN == FALSE){
	if($halaman == "DAFTAR"){
		include("z.pages/daftar.php");
	} else {
		include("z.pages/login.php");
	}
} else {
	require_once("z.inc/header.php");
	
	if($halaman == "Kategori-Wisata"){
		include("z.pages/kategori-wisata.php");
	} else if ($halaman == "Tempat-Wisata"){
		include("z.pages/tempat-wisata.php");
	} else {
		include("z.pages/dashboard.php");
	}
	
	require_once("z.inc/footer.php");
}

?>