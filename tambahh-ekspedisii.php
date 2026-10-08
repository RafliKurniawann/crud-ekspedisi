<?php
$koneksi = new mysqli("localhost", "root", "", "db_ekspedisi");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode           = $_POST['kode'];
    $nama_ekspedisi = $_POST['nama_ekspedisi'];
    $nomor_telepon  = $_POST['nomor_telepon'];
    $layanan        = $_POST['layanan'];
    $zonasi         = $_POST['zonasi'];

    $sql = "INSERT INTO ekspedisi (kode, nama_ekspedisi, nomor_telepon, layanan, zonasi) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);

    if (!$stmt) {
        die("Prepare gagal: " . $koneksi->error);
    }

    $stmt->bind_param("sssss", $kode, $nama_ekspedisi, $nomor_telepon, $layanan, $zonasi);

    if ($stmt->execute()) {
        // Redirect otomatis balik ke index.php
        header("Location: index.php");
        exit();
    } else {
        die("Data gagal disimpan: " . $stmt->error);
    }

    $stmt->close();
}

$koneksi->close();
?>