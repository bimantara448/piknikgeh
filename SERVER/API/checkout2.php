<?php
function tiket_generate($length) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");

$wisata_id = $_POST['wisata_id'];
$jumlah_tiket = $_POST['jumlah_tiket'];
$username = $_POST['username'];
$nama_pemesan = $_POST['nama_pemesan'];
$pengguna_email = $_POST['pengguna_email'];
$pengguna_notelp = $_POST['pengguna_notelp'];
$pembayaran = $_POST['pembayaran'];

$query = mysqli_query($koneksi, "select * from tempat_wisata where id_wisata = '$wisata_id'");
$data_wisata = mysqli_fetch_assoc($query);

$query2 = mysqli_query($koneksi, "select * from users where username = '$username'");
$data_pengguna = mysqli_fetch_assoc($query2);
$id_user = $data_pengguna['id_user'];

$harga_tiket = $data_wisata['harga_tiket']*$jumlah_tiket;

if($pembayaran == 1){
	$gateway_pembayaran = "-";
	$status_pembayaran = "Sukses";
} else {
	$gateway_pembayaran = "https://app.sandbox.midtrans.com/payment-links/1638815007248";
	$status_pembayaran = "Pending";
}


//OUTPUT
$data = array();
if(mysqli_num_rows($query) != 1){
	$data['error']=true;
	$data['pesan']="id wisata tidak ditemukan";
} else if (mysqli_num_rows($query2) != 1){
	$data['error']=true;
	$data['pesan']="Pengguna tidak ditemukan";
} else {
	$code_ticket = tiket_generate(8);
	
	$insert = mysqli_query($koneksi,"INSERT INTO `pemesanan` (`id_pemesanan`, `id_user`, `id_wisata`, `code_tiket`, `nama_pembeli`, `email_pembeli`, `nohp_pembeli`, `jumlah_tiket`, `harga_tiket`, `id_metode_pembayaran`, `gateway_pembayaran`, `status_pembayaran`) 
	VALUES (NULL, '$id_user', '$wisata_id', '$code_ticket', '$nama_pemesan', '$pengguna_email', '$pengguna_notelp', '$jumlah_tiket', '$harga_tiket', '$pembayaran', '$gateway_pembayaran', '$status_pembayaran');");
	
	if($insert){
		$data['link_pembayaran'] = $gateway_pembayaran;
		$data['pesan']="Pembelian tiket berhasil.";
	} else {
		$data['error']=true;
		$data['pesan']="Gagal Insert";
	}
}
echo json_encode($data,JSON_PRETTY_PRINT);
