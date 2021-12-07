<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials:true");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE,OPTIONS");
header("Access-Control-Max-Age:604800");
header("Access-Control-Request-Headers: x-requested-with");
header("Access-Control-Allow-Headers: x-requested-with, x-requested-by");

include("../CONFIG/config.php");

$username = $_POST['username'];
$query = mysqli_query($koneksi, "select * from users where username = '$username'");
$data_user = mysqli_fetch_assoc($query);

//OUTPUT
$data = array();
$data['nama'] = $data_user['nama'];
$data['email'] = $data_user['email'];

echo json_encode($data,JSON_PRETTY_PRINT);
