<?php
include 'header.php';
include 'db.php'; // Include database connection

// Fetch all guru data for dropdown (if needed)
$sql_guru = "SELECT id, nama FROM guru";
$result_guru = $conn->query($sql_guru);

// Ambil filter dari URL
$filter_nama = isset($_GET['filter_nama']) ? $_GET['filter_nama'] : '';
$filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';

// Query SQL untuk mengambil data dengan filter
$sql = "SELECT * FROM daftar_santri WHERE 1=1";

if ($filter_nama != '') {
    $sql .= " AND nama LIKE '%" . $conn->real_escape_string($filter_nama) . "%'";
}

if ($filter_kelas != '') {
    $sql .= " AND kelas = '" . $conn->real_escape_string($filter_kelas) . "'";
}

$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2 class="mb-4">Daftar Santri</h2>
    <div class="mb-3">
        <div style="float: right; padding:10px;">
            <a href="addsantri.php" class="btn btn-success">Tambah Santri</a>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="filter_nama">Filter by Nama</label>
                    <input type="text" name="filter_nama" id="filter_nama" class="form-control" placeholder="Cari Nama Santri..." value="<?php echo isset($_GET['filter_nama']) ? htmlspecialchars($_GET['filter_nama']) : ''; ?>">
                </div>
                <div class="col-md-3">
                    <label for="filter_kelas">Filter by Kelas</label>
                    <select name="filter_kelas" id="filter_kelas" class="form-control">
                        <option value="">Pilih Kelas</option>
                        <?php
                        // Ambil daftar kelas dari database
                        $sql_kelas = "SELECT DISTINCT kelas FROM daftar_santri";
                        $result_kelas = $conn->query($sql_kelas);

                        if ($result_kelas->num_rows > 0) {
                            while ($row = $result_kelas->fetch_assoc()) {
                                $selected = ($row['kelas'] == isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '') ? 'selected' : '';
                                echo "<option value='{$row['kelas']}' $selected>{$row['kelas']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Display Data -->
        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nama</th>';
            echo '<th>Kamar</th>';
            echo '<th>Kelas</th>';
            echo '<th>Formal</th>';
            echo '<th>Diniyah</th>';
            echo '<th>Ortu</th>';
            echo '<th>Alamat</th>';
            echo '<th>Telepon</th>';
            echo '<th>Aksi</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $n = 0;
            while ($row = $result->fetch_assoc()) {
                $n++;
                echo '<tr>';
                echo '<td>' . $n . '</td>';
                echo '<td>' . htmlspecialchars($row["nama"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["kamar"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["kelas"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["formal"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["diniyah"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["ortu"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["alamat"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["telepon"]) . '</td>';
                echo '<td>';
                echo '<a href="kartu.php?id=' . $row["id"] . '" class="btn btn-info btn-sm mr-2">View</a>';
                echo '<a href="edit.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm">Edit</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="alert alert-warning">Tidak ada data.</p>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<?php
include 'footer.php';
$conn->close(); // Close the database connection
?>
