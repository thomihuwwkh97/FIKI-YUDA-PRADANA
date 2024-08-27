<?php
// Mendapatkan tahun dan bulan saat ini


$tahun = date('Y');
$bulan = date('m');

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

// Menampilkan jumlah hari Minggu dalam bulan ini

echo "Jumlah hari dalam bulan ini: " . $jumlah_hari;




//santri absen hanya
$absen = 19;
$mq = $jumlah_hari-(5+8);
// 
echo "<br><br><br>libur hari 2 hari dalam 1 minggu";
echo "<br>santri masuk: " . $absen;
echo "<br>Jumlah hari masuk dalam bulan ini: " . $mq;
echo "<br> ";
if (($mq) <= $absen) {
    echo 'oke';
}else{
    echo 'ajor';

}


?>


<?php
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

// Menyiapkan query dengan rentang tanggal
$query = "SELECT COUNT(*) FROM lalaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";

// Menampilkan query untuk debugging
// echo $query;

// Jalankan query menggunakan koneksi database
// $result = $conn->query($query);
?>
