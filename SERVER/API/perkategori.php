<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");


if(isset($_POST['id_kat'])){
	$id_kat = $_POST['id_kat'];
} else {
	$id_kat = $_GET['id_kat'];
}

$query = mysqli_query($koneksi, "select * from tempat_wisata where id_kat = '$id_kat' order by rand()");

//OUTPUT
$data = array();
$list = "";
$jumlah_wisata = mysqli_num_rows($query);
if($jumlah_wisata == 0){
	$data['error']=true;
	$data['pesan']="Wisata tidak ada.";
} else {
	while($data_wisata = mysqli_fetch_assoc($query)){
		$list = $list."<div class='col-50 medium-25'>
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
	$data['list_wisata'] = $list;
	$data['jumwiz'] = $jumlah_wisata." Wisata";
	
}
echo json_encode($data,JSON_PRETTY_PRINT);
