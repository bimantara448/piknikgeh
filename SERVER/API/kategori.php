<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");

$query = mysqli_query($koneksi, "SELECT * FROM kategori_wisata");

$datas = "";
while($data_kat = mysqli_fetch_assoc($query)){
	$id_katnya = $data_kat['id_kat'];
	$querys = mysqli_query($koneksi, "SELECT * FROM tempat_wisata WHERE id_kat = '$id_katnya'");
	$counter_wisata = mysqli_num_rows($querys);
	
	$datas = $datas."<div class='col-100'>
					<a href='/deals/".$data_kat['id_kat']."/' class='item-category'>
						<div class='item-info'>
							<h3 class='title'>".$data_kat['nama_kat']."</h3>
							<p>".$counter_wisata." ".$data_kat['nama_kat']."</p>
						</div>
						<img src='".$base_url."assets/icon/".$data_kat['logo_kat']."' width='150px' class='layer-icon' alt=''>
						<div class='item-icon'>
							<img src='".$base_url."assets/icon/".$data_kat['logo_kat']."' width='65px' alt=''>
						</div>
					</a>
				</div>";
}
	$data['kategorii'] = $datas;
echo json_encode($data,JSON_PRETTY_PRINT);
