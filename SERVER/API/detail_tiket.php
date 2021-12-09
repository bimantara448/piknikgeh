<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['tiket_id'])){
	$tiket_id = $_POST['tiket_id'];
} else {
	$tiket_id = $_GET['tiket_id'];
}

$query = mysqli_query($koneksi, "select * from pemesanan where id_pemesanan = '$tiket_id'");

//OUTPUT
$data = array();
$jumlah_wisata = mysqli_num_rows($query);
if($jumlah_wisata == 0){
	$data['error']=true;
	$data['pesan']="Gagal Mencari Tiket";
} else {
	$data_pemesanan = mysqli_fetch_assoc($query);
	$id_wisata = $data_pemesanan['id_wisata'];
	
	$queryyyy = mysqli_query($koneksi, "select * from tempat_wisata where id_wisata = '$id_wisata'");
	$data_wisata = mysqli_fetch_assoc($queryyyy);
	
	$id_metode_pembayaran =  $data_pemesanan['id_metode_pembayaran'];
	$queryyyyy = mysqli_query($koneksi, "select * from metode_pembayaran where id_metode_pembayaran = '$id_metode_pembayaran'");
	$data_metode_pembayaran = mysqli_fetch_assoc($queryyyyy);
	
	$data['img_tiket'] = "<img src='".$base_url."assets/galery/".$data_wisata['pic1']."' alt=''>";
	$data['nama_wisata'] = $data_wisata['nama_wisata'];
	$data['detail_tiket'] = $data_pemesanan['jumlah_tiket']."x Rp ".number_format($data_pemesanan['harga_tiket']);
	$data['code_tiket'] = $data_pemesanan['code_tiket'];
	$data['nama_pemembeli'] = $data_pemesanan['nama_pembeli'];
	$data['jumlah_tiket'] = $data_pemesanan['jumlah_tiket'];
	$data['harga_total'] = "Rp ".number_format($data_pemesanan['harga_tiket']);
	$data['pembayaran_tiket'] =  $data_metode_pembayaran['nama_metode_pembayaran'];
	$data['qr_tiket'] = "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$data_pemesanan['code_tiket']."&choe=UTF-8' title='QRCODE' />";
	
}
echo json_encode($data,JSON_PRETTY_PRINT);
