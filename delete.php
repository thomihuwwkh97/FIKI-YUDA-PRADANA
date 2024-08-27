<?php
include 'db.php';

// Pastikan parameter id tersedia dan merupakan angka
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql_delete = "DELETE FROM `daftar_santri` WHERE `id` = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Data santri berhasil dihapus');</script>";
        // Redirect ke halaman index.php atau halaman lain setelah menghapus
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data santri');</script>";
    }
} else {
    echo "Parameter ID tidak valid.";
    exit();
}
