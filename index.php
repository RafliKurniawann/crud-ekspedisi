<?php
$koneksi = new mysqli("localhost", "root", "", "db_ekspedisi");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$result = $koneksi->query("SELECT * FROM ekspedisi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Direktori Ekspedisi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1>Direktori Ekspedisi</h1>
            <p>Kelola data kurir, layanan, dan zonasi pengiriman.</p>
        </div>
        <a href="tambahh-ekspedisii.html" class="btn">+ Tambah Kurir</a>
    </div>
    
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>KODE</th>
                    <th>NAMA EKSPEDISI</th>
                    <th>NOMOR TELEPON</th>
                    <th>LAYANAN</th>
                    <th>ZONASI</th>
                    <th>AKSI</th> <!-- Kolom Aksi -->
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode']); ?></td>
                            <td><?= htmlspecialchars($row['nama_ekspedisi']); ?></td>
                            <td><?= htmlspecialchars($row['nomor_telepon']); ?></td>
                            <td><?= htmlspecialchars($row['layanan']); ?></td>
                            <td><?= htmlspecialchars($row['zonasi']); ?></td>
                            <td>
                                <a href="edit-ekspedisi.php?kode=<?= $row['kode']; ?>">Edit</a> | 
                                <a href="hapus-ekspedisi.php?kode=<?= $row['kode']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Belum ada data ekspedisi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>