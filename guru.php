<?php
include 'header.php'; // Include your header file
include 'db.php'; // Include database connection

// Ambil filter dari URL
$filter_nama = isset($_GET['filter_nama']) ? $_GET['filter_nama'] : '';
$filter_pelajaran = isset($_GET['filter_pelajaran']) ? $_GET['filter_pelajaran'] : '';

// Query SQL untuk mengambil data dengan filter
$sql = "SELECT * FROM guru WHERE 1=1";

if ($filter_nama != '') {
    $sql .= " AND nama LIKE '%" . $conn->real_escape_string($filter_nama) . "%'";
}

if ($filter_pelajaran != '') {
    $sql .= " AND pelajaran LIKE '%" . $conn->real_escape_string($filter_pelajaran) . "%'";
}

$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2 class="mb-4">Daftar Guru</h2>
    <div style="float: right; padding:10px;">
        <a href="addguru.php" class="btn btn-success">Tambah Guru</a>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="filter_nama">Filter by Nama</label>
                <input type="text" name="filter_nama" id="filter_nama" class="form-control" placeholder="Cari Nama Guru..." value="<?php echo htmlspecialchars($filter_nama); ?>">
            </div>
            <div class="col-md-4">
                <label for="filter_pelajaran">Filter by Pelajaran</label>
                <input type="text" name="filter_pelajaran" id="filter_pelajaran" class="form-control" placeholder="Cari Pelajaran..." value="<?php echo htmlspecialchars($filter_pelajaran); ?>">
            </div>
            <div class="col-md-4 mt-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <?php
    // Check if there are results
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nama</th>';
        echo '<th>Pelajaran</th>';
        echo '<th>Aksi</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["nama"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["pelajaran"]) . '</td>';
            echo '<td>';
            echo '<a href="editguru.php?id=' . urlencode($row["id"]) . '" class="btn btn-warning btn-sm mr-2">Edit</a>';
            echo '<a href="deleteguru.php?id=' . urlencode($row["id"]) . '" class="btn btn-danger btn-sm">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="alert alert-warning">Tidak ada data.</p>';
    }

    // Free result set
    $result->free();
    ?>

</div>

<?php
include 'footer.php'; // Include your footer file
?>
