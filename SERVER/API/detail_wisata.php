<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['id_wisata'])){
	$id_wisata = $_POST['id_wisata'];
} else {
	$id_wisata = $_GET['id_wisata'];
}

$query = mysqli_query($koneksi, "select * from tempat_wisata inner join kategori_wisata using(id_kat) where tempat_wisata.id_wisata = '$id_wisata'");
$data_wisata = mysqli_fetch_assoc($query);

//OUTPUT
$data = array();
if(mysqli_num_rows($query) != 1){
	$data['error']=true;
	$data['pesan']="id wisata tidak ditemukan";
} else {
	$data['id_kat'] = $data_wisata['id_kat'];
	$data['nama_kat'] = $data_wisata['nama_kat']; //finishing
	$data['nama'] = $data_wisata['nama_wisata'];
	$data['deskripsi'] = $data_wisata['deskripsi'];
	$data['harga_tiket'] = $data_wisata['harga_tiket'];
	$data['pic1'] = $base_url."assets/galery/".$data_wisata['pic1'];
	$data['pic2'] = $base_url."assets/galery/".$data_wisata['pic2'];
	$data['pic3'] = $base_url."assets/galery/".$data_wisata['pic3'];
	$data['pic4'] = $base_url."assets/galery/".$data_wisata['pic4'];
}
echo json_encode($data,JSON_PRETTY_PRINT);
