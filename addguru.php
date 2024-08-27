<?php

include "db.php"; // Include your database connection

// Jika form disubmit, proses simpan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $pelajaran = $_POST['pelajaran'];

    // Buat query SQL untuk menyimpan data ke dalam database
    $sql_insert = "INSERT INTO guru (id, nama, pelajaran) VALUES (NULL, '$nama', '$pelajaran')";

    // Eksekusi query dan cek apakah berhasil
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Data guru berhasil ditambahkan');</script>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
include 'header.php';
?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-4">Tambah Data Guru</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="padding: 10px;">
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="pelajaran">Pelajaran</label>
                        <input type="text" class="form-control" id="pelajaran" name="pelajaran" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
