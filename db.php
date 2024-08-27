<?php

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "absen1";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// <?php

// // Konfigurasi database
// $servername = "localhost";
// $username = "sika2255_fiki";
// $password = "7NZ0+jL#kwMh";
// $database = "sika2255_fiki";

// // Membuat koneksi ke database
// $conn = new mysqli($servername, $username, $password, $database);

// // Memeriksa koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }