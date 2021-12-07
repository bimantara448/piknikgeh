<?php
// ERROR REPORTING
//error_reporting(0);

// BASE url
	$base_url = "http://localhost/SERVER/";

// Konek db
	require_once("database.php");

// include function
	require_once("function.php");
	
// Date Time
	date_default_timezone_set('Asia/Jakarta');
	$date_time = date('d-m-Y H:i:s');
	$date = date('d-m-Y');
	$time = date('H:i:s');
	$jam = date('H:i');
	
// Variable
$config = array(
    'name' => 'PIKNIK GEH',
    'desc' => 'Aplikasi Piknik geh'
);
?>