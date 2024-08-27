<?php
include 'db.php'; // Pastikan file db.php menghubungkan ke database Anda

// Ambil filter dari URL
$filter_guru = isset($_GET['filter_guru']) ? $_GET['filter_guru'] : '';
$filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';
$filter_tanggal = isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '';
$filter_nama = isset($_GET['filter_nama']) ? $_GET['filter_nama'] : '';
$kegiatan = isset($_GET['kegiatan']) ? $_GET['kegiatan'] : '';

// Query untuk mengambil data dari tabel ".$kegiatan." dengan filter
$sql = "SELECT 
            ".$kegiatan.".id, 
            ".$kegiatan.".jam, 
            ".$kegiatan.".tanggal, 
            daftar_santri.nama, 
            daftar_santri.kelas, 
            guru.nama AS nama_guru
        FROM 
            ".$kegiatan."
        JOIN 
            daftar_santri ON ".$kegiatan.".id_santri = daftar_santri.id
        JOIN 
            guru ON daftar_santri.guru = guru.id
        WHERE 1=1";

if ($filter_guru != '') {
    $sql .= " AND guru.id = '$filter_guru'";
}

if ($filter_kelas != '') {
    $sql .= " AND daftar_santri.kelas = '$filter_kelas'";
}

if ($filter_tanggal != '') {
    $sql .= " AND ".$kegiatan.".tanggal = '$filter_tanggal'";
}

if ($filter_nama != '') {
    $sql .= " AND daftar_santri.nama LIKE '%$filter_nama%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set headers untuk download CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="data_'.$kegiatan.'.csv"');
    
    // Buka output stream untuk menulis CSV
    $output = fopen('php://output', 'w');
    
    // Tulis header kolom ke dalam CSV
    fputcsv($output, array('NO', 'Jam', 'Tanggal', 'Nama', 'Kelas', 'Guru'));
    
    // Tulis data baris per baris ke dalam CSV
    $n = 0;
    while ($row = $result->fetch_assoc()) {
        $n++;
        fputcsv($output, array($n, $row['jam'], $row['tanggal'], $row['nama'], $row['kelas'], $row['nama_guru']));
    }
    
    // Tutup output stream
    fclose($output);
} else {
    echo "Tidak ada data yang sesuai dengan filter.";
}

$conn->close();
?>
