<?php 
include('../../navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">
            Kamar
        </h1>
        <a href="tambah.php" class="btn btn-primary mt-3">Tambah Kamar</a>
        <table class="table mt-3 text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama Kamar</th>
                    <th scope="col">Tipe Kamar</th>
                    <th scope="col">Harga per Malam</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                $query =
                "
                    SELECT
                    kamar.id,
                    kamar.nama_kamar,
                    kamar.tipe_kamar,
                    kamar.harga_per_malam
                    FROM kamar
                ";
                $data = mysqli_query($koneksi, $query);
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                ?> 
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($d['nama_kamar']) ?></td>
                    <td><?= htmlspecialchars($d['tipe_kamar']) ?></td>
                    <td>Rp.<?= number_format($d['harga_per_malam'], 0, ',', '.') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="hapus.php?id=<?= $d['id']; ?>" onclick="return confirm('Apakah Anda yakin?&#x2639;')" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
