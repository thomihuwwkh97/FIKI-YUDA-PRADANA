<?php
include 'db.php';

// Pastikan parameter id tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql = "SELECT * FROM `daftar_santri` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate QR Code URL
        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($row["id"]);

        // Get QR Code image content
        $content = file_get_contents($qr_url);
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Kartu Tanda Santri</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                .card {
                    max-width: 650px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .card img {
                    width: 200px;
                    height: 200px;
                    float: left;
                    margin-right: 20px;
                    padding: 10px;
                    border: 2px solid black;
                }

                .card-body {
                    float: left;
                    width: calc(100% - 220px);
                    /* 200px (image width) + 20px (margin-right) */
                }

                .card-text {
                    margin-bottom: 1px;
                    /* Margin antar baris teks */
                }
            </style>
        </head>

        <body>
            <div class="container">
                <div class="card">
                    <h2 class="text-center">Kartu Tanda Santri</h2>
                    <div class="card-body">
                        <img src="data:image/png;base64,<?= base64_encode($content) ?>" alt="QR Code">
                        <h5 class="card-title">Nama: <?= htmlspecialchars($row["nama"]) ?></h5>
                        <p class="card-text">Kamar: <?= htmlspecialchars($row["kamar"]) ?></p>
                        <p class="card-text">Kelas: <?= htmlspecialchars($row["kelas"]) ?></p>
                        <p class="card-text">Diniyah: <?= htmlspecialchars($row["diniyah"]) ?></p>
                        <p class="card-text">Ortu: <?= htmlspecialchars($row["ortu"]) ?></p>
                        <p class="card-text">Alamat: <?= htmlspecialchars($row["alamat"]) ?></p>
                        <p class="card-text">Telepon: <?= htmlspecialchars($row["telepon"]) ?></p>
                    </div>
                </div>
            </div>
        </body>

        </html>

<?php
    } else {
        echo "Santri dengan ID $id tidak ditemukan.";
    }
} else {
    echo "Parameter ID tidak valid.";
}
?>