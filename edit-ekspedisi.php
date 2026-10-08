<?php
$koneksi = new mysqli("localhost", "root", "", "db_ekspedisi");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// 1. Ambil data lama berdasarkan parameter 'kode' di URL
$kode = $_GET['kode'] ?? '';

$stmt = $koneksi->prepare("SELECT * FROM ekspedisi WHERE kode = ?");
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data ekspedisi tidak ditemukan!");
}

// 2. Proses simpan perubahan ketika tombol 'Simpan Perubahan' diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ekspedisi = $_POST['nama_ekspedisi'];
    $nomor_telepon  = $_POST['nomor_telepon'];
    $layanan        = $_POST['layanan'];
    $zonasi         = $_POST['zonasi'];

    $update_stmt = $koneksi->prepare("UPDATE ekspedisi SET nama_ekspedisi = ?, nomor_telepon = ?, layanan = ?, zonasi = ? WHERE kode = ?");
    $update_stmt->bind_param("sssss", $nama_ekspedisi, $nomor_telepon, $layanan, $zonasi, $kode);

    if ($update_stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengupdate data: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Ekspedisi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container kecil">
    <div class="header">
        <div>
            <h1>Edit Kurir</h1>
            <p>Ubah data ekspedisi.</p>
        </div>
        <a href="index.php" class="btn">← Kembali</a>
    </div>

    <div class="card">
        <form action="" method="POST">
            <label>Kode Kurir</label>
            <input type="text" value="<?= htmlspecialchars($data['kode']); ?>" disabled>

            <label>Nama Ekspedisi</label>
            <input type="text" name="nama_ekspedisi" value="<?= htmlspecialchars($data['nama_ekspedisi']); ?>" required>

            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="<?= htmlspecialchars($data['nomor_telepon']); ?>" required>

            <label>Jenis Layanan</label>
            <select name="layanan">
                <option value="Reguler" <?= $data['layanan'] == 'Reguler' ? 'selected' : ''; ?>>Reguler</option>
                <option value="Express" <?= $data['layanan'] == 'Express' ? 'selected' : ''; ?>>Express</option>
                <option value="Kargo" <?= $data['layanan'] == 'Kargo' ? 'selected' : ''; ?>>Kargo</option>
            </select>

            <label>Zonasi</label>
            <input type="text" name="zonasi" value="<?= htmlspecialchars($data['zonasi']); ?>" required>

            <button type="submit">Simpan Perubahan</button>  
        </form>
    </div>
</div>

</body>
</html>