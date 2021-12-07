<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");

// AMBIL USERNAME PASS
$username = $_POST['username'];
$password = $_POST['password'];

// QUERY CEK USERNAME PASS
$qry = mysqli_query($koneksi,"select * from users where (username='$username' or email='$username') and password='$password'");

$output = array();
if(mysqli_num_rows($qry) == 1){
	while($data=mysqli_fetch_object($qry)){
		$output[]=$data;
	}
	$output['pesan']="Berhasil Masuk!";
}else{
	$output['error']=true;
	$output['pesan']="Gagal Masuk! Username/Password Salah!";
}
echo json_encode($output,JSON_PRETTY_PRINT);