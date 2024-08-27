<?php
include 'function.php';

header("Content-Type: application/json");
// Pastikan parameter id tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_santri = $_GET['id'];

    // Ambil jenis data dari parameter 'type'
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        switch ($type) {
            case 'Lalaran':
                addLalaran($id_santri);
                sendSms($id_santri, "Lalaran",0);
                break;
            case 'Sorogan':
                addSorogan($id_santri);
               
                break;
            case 'Madrasah':
                addMQ($id_santri);
                

                break;
            case 'login':
                login($id_santri);
                break;
            default:
                $response = array('message' => 'Parameter \'type\' tidak valid.');
                echo json_encode($response, JSON_PRETTY_PRINT);
                break;
        }
    } else {
        $response = array('message' => 'Parameter \'type\' tidak ditemukan.');
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
} else {
    $response = array('message' => 'Parameter \'id\' tidak valid.');
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit();
}
