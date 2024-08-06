<?php 
include('../../navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamu</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">
            Tamu yang terdaftar
        </h1>
        <a href="tambah.php" class="btn btn-primary mt-3">Tambah Tamu</a>
    <table class="table mt-3 text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        
        <tbody><?php
            $query =
            "
                SELECT
                tamu.id,
                tamu.nama,
                tamu.no_hp
                FROM tamu
            ";
            $data = mysqli_query($koneksi, $query);
            $no = 1;
            while ($d = mysqli_fetch_array($data)) {
            ?> 
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama'] ?></td>
                <td><?= $d['no_hp'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $d['id']; ?>" onclick="return confirm('Apakah Anda yakin?&#x2639;')" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
    <?php 
    }
    ?>
    </table>
    </div>
</body>
</html>