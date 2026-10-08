<?php
$koneksi = new mysqli("localhost", "root", "", "db_ekspedisi");

if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];

    $stmt = $koneksi->prepare("DELETE FROM ekspedisi WHERE kode = ?");
    $stmt->bind_param("s", $kode);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . $koneksi->error;
    }
}
?>