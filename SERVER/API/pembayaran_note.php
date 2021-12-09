<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['pembayaran_id'])){
	$pembayaran_id = $_POST['pembayaran_id'];
} else {
	$pembayaran_id = $_GET['pembayaran_id'];
}

$query = mysqli_query($koneksi, "select * from metode_pembayaran WHERE id_metode_pembayaran = '$pembayaran_id'");
$data_pembayaran = mysqli_fetch_assoc($query);

//OUTPUT
$data = array();
if(mysqli_num_rows($query) != 1){
	$data['error']=true;
	$data['pesan']="pembayaran Tidak Ditemukan";
} else {
	$data['catatan_metode_pembayaran'] = $data_pembayaran['catatan_metode_pembayaran'];
}
echo json_encode($data,JSON_PRETTY_PRINT);
