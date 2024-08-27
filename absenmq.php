<?php
include 'db.php'; // Pastikan file db.php menghubungkan ke database Anda

// Ambil daftar guru dan kelas untuk filter dropdown
$guru_sql = "SELECT id, nama FROM guru";
$guru_result = $conn->query($guru_sql);

$kelas_sql = "SELECT DISTINCT kelas FROM daftar_santri";
$kelas_result = $conn->query($kelas_sql);

// Inisialisasi filter
$filter_guru = isset($_GET['filter_guru']) ? $_GET['filter_guru'] : '';
$filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';
$filter_tanggal = isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '';
$filter_nama = isset($_GET['filter_nama']) ? $_GET['filter_nama'] : '';

// Query untuk mengambil data dari tabel mq dengan filter
$sql = "SELECT 
            mq.id, 
            mq.jam, 
            mq.tanggal, 
            mq.id_santri, 
            daftar_santri.nama, 
            daftar_santri.kelas, 
            daftar_santri.guru, 
            daftar_santri.kamar, 
            guru.id AS id_guru, 
            guru.nama AS nama_guru
        FROM 
            mq
        JOIN 
            daftar_santri ON mq.id_santri = daftar_santri.id
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
    $sql .= " AND mq.tanggal = '$filter_tanggal'";
}

if ($filter_nama != '') {
    $sql .= " AND daftar_santri.nama LIKE '%$filter_nama%'";
}

$result = $conn->query($sql);

include 'header.php';
?>

<body>
    <div class="container mt-4">
        <h2>Data mq</h2>
        
        <!-- Filter Form -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="filter_guru">Filter by Guru</label>
                    <select name="filter_guru" id="filter_guru" class="form-control">
                        <option value="">Pilih Guru</option>
                        <?php
                        if ($guru_result->num_rows > 0) {
                            while ($row = $guru_result->fetch_assoc()) {
                                $selected = ($row['id'] == $filter_guru) ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['nama']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_kelas">Filter by Kelas</label>
                    <select name="filter_kelas" id="filter_kelas" class="form-control">
                        <option value="">Pilih Kelas</option>
                        <?php
                        if ($kelas_result->num_rows > 0) {
                            while ($row = $kelas_result->fetch_assoc()) {
                                $selected = ($row['kelas'] == $filter_kelas) ? 'selected' : '';
                                echo "<option value='{$row['kelas']}' $selected>{$row['kelas']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_tanggal">Filter by Tanggal</label>
                    <input type="date" name="filter_tanggal" id="filter_tanggal" class="form-control" value="<?php echo isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : ''; ?>">
                </div>
                <div class="col-md-3">
                    <label for="filter_nama">Filter by Nama</label>
                    <input type="text" name="filter_nama" id="filter_nama" class="form-control" placeholder="Cari Nama Santri..." value="<?php echo isset($_GET['filter_nama']) ? $_GET['filter_nama'] : ''; ?>">
                </div>
                <div class="col-md-3 mt-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        
        <!-- Tombol Export CSV -->
        <div class="row">
            <div class="col-md-4">
                <a href="export_csv.php?filter_guru=<?php echo $filter_guru; ?>&filter_kelas=<?php echo $filter_kelas; ?>&filter_tanggal=<?php echo $filter_tanggal; ?>&filter_nama=<?php echo $filter_nama; ?>&kegiatan=mq" class="btn btn-success mt-4">Export CSV</a>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Jam</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Guru</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $n = 0;
                    while ($row = $result->fetch_assoc()) {
                        $n++;
                        echo '<tr>';
                        echo '<td>' . $n . '</td>';
                        echo '<td>' . $row['jam'] . '</td>';
                        echo '<td>' . $row['tanggal'] . '</td>';
                        echo '<td>' . $row['nama'] . '</td>';
                        echo '<td>' . $row['kelas'] . '</td>';
                        echo '<td>' . $row['nama_guru'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

<?php include 'footer.php'; ?>
</body>
