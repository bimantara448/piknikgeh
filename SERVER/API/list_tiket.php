<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['username'])){
	$username = $_POST['username'];
} else {
	$username = $_GET['username'];
}

$query2 = mysqli_query($koneksi, "select * from users where username = '$username'");
$data_pengguna = mysqli_fetch_assoc($query2);
$id_user = $data_pengguna['id_user'];


$query = mysqli_query($koneksi, "select * from pemesanan where id_user = '$id_user' order by id_pemesanan ASC");

//OUTPUT
$data = array();
$list = "";
$jumlah_wisata = mysqli_num_rows($query);
if($jumlah_wisata == 0){
	$data['list_pemesanan']="Anda belum memesan";
} else {
	while($data_pemesanan = mysqli_fetch_assoc($query)){
		$id_wisatanya = $data_pemesanan['id_wisata'];
		$queryxx = mysqli_query($koneksi, "select * from tempat_wisata where id_wisata = '$id_wisatanya'");
		$data_wisata = mysqli_fetch_assoc($queryxx);
		
		if($data_pemesanan['status_pembayaran'] == "Pending"){
			$button = "<a href=\"javascript:location.replace('".$data_pemesanan['gateway_pembayaran']."');\" class='button add-cart-btn button-fill green'>Bayar Tiket</a>";
			$label = "<span class='badge color-yellow'>Belum Dibayar</span>";
		}else if ($data_pemesanan['status_pembayaran'] == "Sukses"){
			$button = "<a href='/tiketnya/".$data_pemesanan['id_pemesanan']."/' class='button add-cart-btn button-fill'>Cetak Tiket</a>";
			$label = " ";
		}else{
			$button = "";
			$label = "<span class='badge color-red'>Tiket dibatalkan</span>";
		}
		
		$list = $list."<li class='swipeout cart-item'>
						<div class='item-content swipeout-content'>
							<div class='item-inner'>
								<div class='item-media'>
									<div class='post-card'>
										<div class='post-media'>
											<img src='".$base_url."assets/galery/".$data_wisata['pic1']."' alt=''>
										</div>
									</div>
								</div>
								<div class='item-info'>
									<div class='item-head'>
										<h6 class='category'>".$data_pemesanan['jumlah_tiket']." Tiket</h6>
										<h2 class='item-title'><a href='/item-details/'>".$data_wisata['nama_wisata']."</a></h2>
										$label
									</div>
									<div class='item-foot'>
									$button
									</div>
								</div>
							</div>
						</div>
						<div class='swipeout-actions-right'>
							<a href='#' class='swipeout-delete'><i class='las la-trash-alt'></i></a>
						</div>
					</li>";
	}
	$data['list_pemesanan'] = $list;
	
}
echo json_encode($data,JSON_PRETTY_PRINT);
