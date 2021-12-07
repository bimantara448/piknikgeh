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


$query = mysqli_query($koneksi, "select * from users where username = '$username'");
$data_user = mysqli_fetch_assoc($query);

//OUTPUT
$data = array();

if ($jam > '03:30' && $jam < '10:00') {
    $salam = 'Selamat Pagi';
} elseif ($jam >= '10:00' && $jam < '15:00') {
    $salam = 'Selamat Siang';
} elseif ($jam >= '15:00' && $jam < '18:30') {
    $salam = 'Selamat Sore';
} else {
    $salam = 'Selamat Malam';
}

// DATA PENGGUNA
$data['salam'] = $salam;
$data['nama'] = $data_user['nama'];

// BANNER WISATA
$wisatanya = " ";
$query0 = mysqli_query($koneksi, "select * from tempat_wisata ORDER BY rand() limit 5"); //rand order
while ($data_wisata = mysqli_fetch_assoc($query0)){
	$wisatanya = $wisatanya."
	<a href='/item-details/".$data_wisata['id_wisata']."/' class='swiper-slide'>
		<div class='post-card'>
			<div class='post-media'>
				<img src='".$base_url."assets/galery/".$data_wisata['pic1']."' alt=''>
			</div>
			<div class='post-info'>
				<h3 class='title'>".$data_wisata['nama_wisata']."</h3>
			</div>
		</div>
	</a>";
}
$data['banner'] = $wisatanya;

// KATEGORI WISATA
$kategorinya = " ";
$query01 = mysqli_query($koneksi, "select * from kategori_wisata ORDER BY rand() limit 5"); //rand order
while ($data_kategori = mysqli_fetch_assoc($query01)){
	$kategorinya = $kategorinya."
	<div class='swiper-slide'>
		<a href='/deals/".$data_kategori['id_kat']."/' class='tag button button-outline'>
			<img src='".$base_url."assets/icon/".$data_kategori['logo_kat']."' alt='' width='50px'>
		</a>
	</div>";
}
$data['categories'] = $kategorinya;

$trending = "";
$query = mysqli_query($koneksi, "select * from tempat_wisata order by rand() limit 6");
while($data_wisata = mysqli_fetch_assoc($query)){
$trending = $trending."
					<div class='col-50 medium-25'>
					<a href='/item-details/".$data_wisata['id_wisata']."/'>
							<div class='item-box'>
									<div class='item-media'>
										<img src='".$base_url."assets/galery/".$data_wisata['pic1']."' alt=''>
									</div>
									<div class='item-content'>
										<h3 class='title'>".$data_wisata['nama_wisata']."</h3>
										<h4 class='price'></h4>
									</div>
							</div>
							</a>
					</div>";
}

$data['trending'] = $trending;

echo json_encode($data,JSON_PRETTY_PRINT);
