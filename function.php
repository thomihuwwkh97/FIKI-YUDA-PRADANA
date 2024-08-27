<?php
include '../db.php';
header("Content-Type: application/json");
function addLalaran($id_santri)
{
    global $conn;

    // Atur zona waktu ke Asia/Bangkok
    date_default_timezone_set('Asia/Bangkok');

    // Dapatkan waktu dan tanggal saat ini
    $jam = date('H:i:s');
    $tanggal = date('Y-m-d');

    

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql_insert = "INSERT INTO `lalaran` (`jam`, `tanggal`, `id_santri`) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssi", $jam, $tanggal, $id_santri);
    $response = array();
    if ($stmt_insert->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Data lalaran berhasil ditambahkan';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql_insert . '<br>' . $conn->error;
    }

    echo json_encode($response);

    $stmt_insert->close();
}
function addSorogan($id_santri)
{
    global $conn;

    // Atur zona waktu ke Asia/Bangkok
    date_default_timezone_set('Asia/Bangkok');

    // Dapatkan waktu dan tanggal saat ini
    $jam = date('H:i:s');
    $tanggal = date('Y-m-d');
    $current_day = date('d'); // Mendapatkan tanggal saat ini dalam format hari

    // Mendapatkan tahun dan bulan saat ini
    $tahun = date('Y');
    $bulan = date('m');

    // Menentukan tanggal awal bulan
    $tanggal_awal = "$tahun-$bulan-01";

    // Menentukan tanggal akhir bulan
    $tanggal_akhir = date("Y-m-t", strtotime($tanggal_awal));

    // Mengubah tanggal akhir bulan menjadi objek DateTime
    $akhir = new DateTime($tanggal_akhir);

    // Mengecek apakah tanggal akhir bulan adalah hari Minggu
    while ($akhir->format('N') == 7) {
        // Mengurangi satu hari dari tanggal akhir bulan
        $akhir->modify('-1 day');
    }

    // Mendapatkan tanggal akhir bulan yang sudah disesuaikan
    $tanggal_akhir = $akhir->format('Y-m-d');

    // Menyiapkan query dengan rentang tanggal untuk menghitung jumlah sorogan
    $query = "SELECT COUNT(*) as count FROM Sorogan WHERE tanggal BETWEEN ? AND ?";
    $stmt_query = $conn->prepare($query);
    $stmt_query->bind_param("ss", $tanggal_awal, $tanggal_akhir);
    $stmt_query->execute();
    $result = $stmt_query->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Menghitung jumlah hari dalam bulan ini
    $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $jumlah_minggu = 0;

    // Iterasi melalui setiap hari dalam bulan ini
    for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
        // Mendapatkan timestamp untuk tanggal saat ini
        $timestamp = mktime(0, 0, 0, $bulan, $hari, $tahun);
        
        // Mendapatkan nama hari dalam seminggu (0 = Minggu, 1 = Senin, ...)
        $hari_dalam_seminggu = date('w', $timestamp);
        
        // Cek apakah hari tersebut adalah hari Minggu (0 = Minggu)
        if ($hari_dalam_seminggu == 0) {
            $jumlah_minggu++;
        }
    }

    // Logika tambahan untuk absen santri
    $absen = $count;
    $mq = $jumlah_hari - (5 + 8); // Penyesuaian hari libur dalam bulan

    $lapor = $mq - $absen;
    // Cek apakah tanggal saat ini di atas tanggal 25
    if ($current_day > 25) {
        if ($mq <= $absen) {
            echo 'oke';
        } else {
            echo 'ajor';
            $kegiatan = 'Sorogan';
            // Correct function call with 3 arguments
        sendSms($id_santri, $kegiatan, $lapor);

        }
    }

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql_insert = "INSERT INTO `Sorogan` (`jam`, `tanggal`, `id_santri`) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssi", $jam, $tanggal, $id_santri);

    $response = array();
    if ($stmt_insert->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Data Madrasah berhasil ditambahkan';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $conn->error;
    }

    // Pretty print JSON response
    echo json_encode($response, JSON_PRETTY_PRINT);

    // Menutup statement
    $stmt_insert->close();
    $stmt_query->close();
}



function addMQ($id_santri)
{
    global $conn;

    // Atur zona waktu ke Asia/Bangkok
    date_default_timezone_set('Asia/Bangkok');

    // Dapatkan waktu dan tanggal saat ini
    $jam = date('H:i:s');
    $tanggal = date('Y-m-d');
    $current_day = date('d'); // Mendapatkan tanggal saat ini dalam format hari

    // Mendapatkan tahun dan bulan saat ini
    $tahun = date('Y');
    $bulan = date('m');

    // Menentukan tanggal awal bulan
    $tanggal_awal = "$tahun-$bulan-01";

    // Menentukan tanggal akhir bulan
    $tanggal_akhir = date("Y-m-t", strtotime($tanggal_awal));

    // Mengubah tanggal akhir bulan menjadi objek DateTime
    $akhir = new DateTime($tanggal_akhir);

    // Mengecek apakah tanggal akhir bulan adalah hari Minggu
    while ($akhir->format('N') == 7) {
        // Mengurangi satu hari dari tanggal akhir bulan
        $akhir->modify('-1 day');
    }

    // Mendapatkan tanggal akhir bulan yang sudah disesuaikan
    $tanggal_akhir = $akhir->format('Y-m-d');

    // Menyiapkan query dengan rentang tanggal untuk menghitung jumlah sorogan
    $query = "SELECT COUNT(*) as count FROM mq WHERE tanggal BETWEEN ? AND ?";
    $stmt_query = $conn->prepare($query);
    $stmt_query->bind_param("ss", $tanggal_awal, $tanggal_akhir);
    $stmt_query->execute();
    $result = $stmt_query->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Menghitung jumlah hari dalam bulan ini
    $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $jumlah_minggu = 0;

    // Iterasi melalui setiap hari dalam bulan ini
    for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
        // Mendapatkan timestamp untuk tanggal saat ini
        $timestamp = mktime(0, 0, 0, $bulan, $hari, $tahun);
        
        // Mendapatkan nama hari dalam seminggu (0 = Minggu, 1 = Senin, ...)
        $hari_dalam_seminggu = date('w', $timestamp);
        
        // Cek apakah hari tersebut adalah hari Minggu (0 = Minggu)
        if ($hari_dalam_seminggu == 0) {
            $jumlah_minggu++;
        }
    }

    // Logika tambahan untuk absen santri
    $absen = $count;
    $mq = $jumlah_hari - (5 + 8); // Penyesuaian hari libur dalam bulan

    $lapor = $mq - $absen;
    // Cek apakah tanggal saat ini di atas tanggal 25
    if ($current_day > 25) {
        if ($mq <= $absen) {
            echo 'oke';
        } else {
            echo 'ajor';
            $kegiatan = 'Madrasah Al Qur`an';
            // Correct function call with 3 arguments
        sendSms($id_santri, $kegiatan, $lapor);

        }
    }

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql_insert = "INSERT INTO `mq` (`jam`, `tanggal`, `id_santri`) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssi", $jam, $tanggal, $id_santri);

    $response = array();
    if ($stmt_insert->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Data Madrasah berhasil ditambahkan';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $conn->error;
    }

    // Pretty print JSON response
    echo json_encode($response, JSON_PRETTY_PRINT);

    // Menutup statement
    $stmt_insert->close();
    $stmt_query->close();
}

function sendSms($id, $kegiatan, $lapor)
{
    global $conn;

    // Mengambil data santri berdasarkan id dengan prepared statement
    $sql = "SELECT `nama`, `telepon` FROM `daftar_santri` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Mengecek apakah data santri ditemukan
        if ($row) {
            // Mengambil tanggal dan waktu saat ini
            $tanggal_waktu = date('Y-m-d H:i:s');

            if($kegiatan == 'Lalaran'){
                $text = "Santri yang bernama *" . $row['nama'] . "* Telah mengikuti kegiatan *" . $kegiatan . "* Pada " .$tanggal_waktu ;
            }else{
                // Menyiapkan pesan
                $text = "Santri yang bernama *" . $row['nama'] . "* tidak mengikuti kegiatan *" . $kegiatan . "* selama " . $lapor . " kali.";

            }
           
            // Menyiapkan payload JSON
            $jsonPayload = json_encode([
                "to" => $row['telepon'], // Pastikan nomor telepon tersedia di data santri
                "text" => $text
            ]);

            // Menyiapkan cURL untuk melakukan permintaan POST
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://layanan.bulusari.id/api.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $jsonPayload,
                CURLOPT_HTTPHEADER => [
                    "Accept: */*",
                    "Content-Type: application/json",
                    "User-Agent: Thunder Client (https://www.thunderclient.com)"
                ],
            ]);

            // Menjalankan cURL dan menangani respons
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                // Handle response if necessary
                // echo $response;
            }
        } else {
            echo "Santri dengan ID $id tidak ditemukan.";
        }
    } else {
        echo "Error dalam eksekusi SQL: " . $stmt->error;
    }

    $stmt->close();
}



function login($password)
{
    global $conn;

    // Query untuk mengambil data dari tabel `id` di mana `password` adalah '1234'
    $sql = "SELECT * FROM `id` WHERE `password` LIKE '" . $password . "'";
    $result = $conn->query($sql);

    // Memeriksa apakah query berhasil dan menampilkan hasilnya
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo json_encode(array('status' => 'sukses'));
        }
    } else {
        echo "Tidak ada data yang ditemukan.";
    }

    // Menutup koneksi
    $conn->close();
}
