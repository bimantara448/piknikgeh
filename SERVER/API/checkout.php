<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['wisata_id'])){
	$wisata_id = $_POST['wisata_id'];
	$jumlah_tiket = $_POST['jumlah_tiket'];
	$username = $_POST['username'];
} else {
	$wisata_id = $_GET['wisata_id'];
	$jumlah_tiket = $_GET['jumlah_tiket'];
	$username = $_GET['username'];
}

$query = mysqli_query($koneksi, "select * from tempat_wisata where id_wisata = '$wisata_id'");
$data_wisata = mysqli_fetch_assoc($query);

$query2 = mysqli_query($koneksi, "select * from users where username = '$username'");
$data_pengguna = mysqli_fetch_assoc($query2);

//OUTPUT
$data = array();
if(mysqli_num_rows($query) != 1){
	$data['error']=true;
	$data['pesan']="id wisata tidak ditemukan";
} else if (mysqli_num_rows($query2) != 1){
	$data['error']=true;
	$data['pesan']="Pengguna tidak ditemukan";
} else {
	$data['nama_wisata'] = $data_wisata['nama_wisata'];
	$data['harga_wisata'] = $data_wisata['harga_tiket'];
	$data['tiketnya_brapa'] = $jumlah_tiket;
	$data['total_harga'] = $data_wisata['harga_tiket']*$jumlah_tiket;
	
	$data['nama_pemesan'] = $data_pengguna['nama'];
	$data['email_pemesan'] = $data_pengguna['email'];
	
	
	$pem = "<option value='0'>Pilih Salah Satu...</option>";
	
	$query3 = mysqli_query($koneksi, "select * from metode_pembayaran order by id_metode_pembayaran ASC");
	while ($data_pembayaran = mysqli_fetch_assoc($query3)){
		$pem = $pem."<option value='".$data_pembayaran['id_metode_pembayaran']."'>".$data_pembayaran['nama_metode_pembayaran']."</option>";
	}
	
	$data['pembayaran_via'] = $pem;
}
echo json_encode($data,JSON_PRETTY_PRINT);
