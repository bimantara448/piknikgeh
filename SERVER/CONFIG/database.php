<?php
$sqli = array(
	"host" => "localhost", // Host
	"user" => "root", // Username Database
	"pass" => "", // Password Database
	"name" => "team7_piknikgeh" // Nama Database
);
	
$koneksi = mysqli_connect($sqli['host'], $sqli['user'], $sqli['pass'], $sqli['name']);

if(!$koneksi) {
	//die("Koneksi Gagal : ".mysqli_connect_error());
	die("DATABASENYA ERROR! => ".mysqli_connect_error());
}
?>