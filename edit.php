<?php
include 'db.php';

// Pastikan parameter id tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql = "SELECT * FROM `daftar_santri` WHERE `id` = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Santri dengan ID $id tidak ditemukan.";
        exit();
    }
} else {
    echo "Parameter ID tidak valid.";
    exit();
}

// Fetch guru data for dropdown
$sql_guru = "SELECT id, nama FROM guru";
$result_guru = $conn->query($sql_guru);

// Jika form disubmit, proses update data
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

    // Gunakan query SQL biasa untuk update data
    $sql_update = "UPDATE `daftar_santri` 
                   SET `nama` = '$nama', `kamar` = '$kamar', `kelas` = '$kelas', 
                       `formal` = '$formal', `diniyah` = '$diniyah', `ortu` = '$ortu', 
                       `alamat` = '$alamat', `telepon` = '$telepon', `guru` = '$guru' 
                   WHERE `id` = $id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data santri');</script>";
    }
}

include 'header.php';
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-4">Update Data Santri</h2>
            <div style="float: right;">
                <form method="POST" action="delete.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">Delete Data</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . urlencode($id); ?>" style="padding: 10px;">
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="kamar">Kamar</label>
                    <input type="text" class="form-control" id="kamar" name="kamar" value="<?php echo htmlspecialchars($row['kamar']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo htmlspecialchars($row['kelas']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="formal">Formal</label>
                    <input type="text" class="form-control" id="formal" name="formal" value="<?php echo htmlspecialchars($row['formal']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="diniyah">Diniyah</label>
                    <input type="text" class="form-control" id="diniyah" name="diniyah" value="<?php echo htmlspecialchars($row['diniyah']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="ortu">Ortu</label>
                    <input type="text" class="form-control" id="ortu" name="ortu" value="<?php echo htmlspecialchars($row['ortu']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($row['alamat']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo htmlspecialchars($row['telepon']); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="guru">Guru</label>
                    <select class="form-control" id="guru" name="guru" required>
                        <option value="">Pilih Guru</option>
                        <?php
                        if ($result_guru->num_rows > 0) {
                            while ($guru = $result_guru->fetch_assoc()) {
                                // Select the current guru
                                $selected = ($guru['id'] == $row['guru']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($guru['id']) . '" ' . $selected . '>' . htmlspecialchars($guru['nama']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Tidak ada guru</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
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
