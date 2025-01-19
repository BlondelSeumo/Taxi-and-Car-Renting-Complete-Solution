<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $car = new mysqli("localhost", "username", "password", "database");
  $car->set_charset("utf8mb4"); 
} catch(Exception $e) {
  error_log($e->getMessage());
  //Should be a message a typical user could understand
}
    
$set = $car->query("SELECT * FROM `tbl_setting`")->fetch_assoc();
date_default_timezone_set($set['timezone']);
$data_set = $car->query("SELECT * FROM `tbl_car_validate`")->fetch_assoc();
$apiKey = $set['api_key'];
?>