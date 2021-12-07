<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");

// AMBIL USERNAME PASS
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];
$passwordd=$_POST['passwordd'];

$qry = mysqli_query($koneksi,"select * from users where username='$username' or email='$username'");

$output = array();
if(empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password) || empty($passwordd)){
	$output['error']=true;
	$output['pesan']="Masih ada yang kosong!";
}else if(mysqli_num_rows($qry) >= 1){
	$output['error']=true;
	$output['pesan']="Username/Email Terdaftar!";
}else if($password != $passwordd){
	$output['error']=true;
	$output['pesan']="Password tidak sama!";
}else{
	$insert = mysqli_query($koneksi,"INSERT INTO `users` (`id_user`, `nama`, `email`, `username`, `password`) VALUES (NULL, '$first_name $last_name', '$email', '$username', '$password')");
	if(!$insert){
		$output['error']=true;
		$output['pesan']="Error System!";
	} else {
		$qry = mysqli_query($koneksi,"select * from users where username='$username'");
		while($data=mysqli_fetch_object($qry)){
			$output[]=$data;
		}
		$output['pesan']="Pendaftaran Berhasil!";
	}
	
}
echo json_encode($output,JSON_PRETTY_PRINT);