<?php
include 'header.php'; // Include your header file

// Include database connection
include 'db.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the record for the given ID
    $sql = "SELECT * FROM guru WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_assoc();

        if (!$record) {
            echo '<p class="alert alert-danger">Record not found.</p>';
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get updated data from form
                $nama = $_POST['nama'];
                $pelajaran = $_POST['pelajaran'];

                // Update the record
                $sql_update = "UPDATE guru SET nama = ?, pelajaran = ? WHERE id = ?";
                if ($stmt = $conn->prepare($sql_update)) {
                    $stmt->bind_param("ssi", $nama, $pelajaran, $id);

                    if ($stmt->execute()) {
                        echo "<script>alert('Data guru berhasil diupdate'); window.location.href='guru.php';</script>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                }
            }
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo '<p class="alert alert-danger">Invalid ID.</p>';
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Edit Data Guru</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . urlencode($id); ?>" style="padding: 10px;">
        <div class="form-group mb-3">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($record['nama']); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="pelajaran">Pelajaran</label>
            <input type="text" class="form-control" id="pelajaran" name="pelajaran" value="<?php echo htmlspecialchars($record['pelajaran']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Data</button>
        <a href="guru.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include 'footer.php'; // Include your footer file
?>
