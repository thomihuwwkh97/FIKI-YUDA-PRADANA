<?php
include 'header.php'; // Include your header file

// Include database connection
include 'db.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the record for the given ID
    $sql_delete = "DELETE FROM guru WHERE id = ?";
    if ($stmt = $conn->prepare($sql_delete)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Data guru berhasil dihapus'); window.location.href='guru.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo '<p class="alert alert-danger">Invalid ID.</p>';
}
?>

<?php
include 'footer.php'; // Include your footer file
?>
