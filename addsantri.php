<?php
include "db.php"; // Include your database connection file

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    $kelas = $_POST['kelas'];
    $formal = $_POST['formal'];
    $diniyah = $_POST['diniyah'];
    $ortu = $_POST['ortu'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $guru = $_POST['guru']; // New field for guru

    // Prepare and execute the SQL query
    $sql_insert = "INSERT INTO daftar_santri (id, nama, kamar, kelas, formal, diniyah, ortu, alamat, telepon, guru) 
                   VALUES (NULL, '$nama', '$kamar', '$kelas', '$formal', '$diniyah', '$ortu', '$alamat', '$telepon', '$guru')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Data santri berhasil ditambahkan');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch guru data for dropdown
$sql_guru = "SELECT id, nama FROM guru";
$result_guru = $conn->query($sql_guru);

include 'header.php';
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-4">Tambah Data Santri</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="padding: 10px;">
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group mb-3">
                    <label for="kamar">Kamar</label>
                    <input type="text" class="form-control" id="kamar" name="kamar" required>
                </div>
                <div class="form-group mb-3">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" required>
                </div>
                <div class="form-group mb-3">
                    <label for="formal">Formal</label>
                    <input type="text" class="form-control" id="formal" name="formal" required>
                </div>
                <div class="form-group mb-3">
                    <label for="diniyah">Diniyah</label>
                    <input type="text" class="form-control" id="diniyah" name="diniyah" required>
                </div>
                <div class="form-group mb-3">
                    <label for="ortu">Ortu</label>
                    <input type="text" class="form-control" id="ortu" name="ortu" required>
                </div>
                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="form-group mb-3">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" required>
                </div>
                <div class="form-group mb-3">
                    <label for="guru">Guru</label>
                    <select class="form-control" id="guru" name="guru" required>
                        <option value="">Pilih Guru</option>
                        <?php
                        if ($result_guru->num_rows > 0) {
                            while ($row = $result_guru->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['nama']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Tidak ada guru</option>';
                        }
                        ?>
                    </select>
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

<?php
$conn->close(); // Close the database connection
?>
