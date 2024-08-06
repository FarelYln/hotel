<?php 
include('../../navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">
            Reservasi
        </h1>
        <a href="tambah.php" class="btn btn-primary mt-5">Tambah reservasi</a>
        <table class="table mt-3 text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tamu</th>
                    <th scope="col">Kamar</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data with JOINs to get related names and calculate total price
                $query = "
                    SELECT
                        reservasi.id,
                        tamu.nama AS nama_tamu,
                        kamar.nama_kamar AS nama_kamar,
                        reservasi.checkin,
                        reservasi.checkout,
                        kamar.harga_per_malam,
                        DATEDIFF(reservasi.checkout, reservasi.checkin) AS jumlah_malam,
                        kamar.harga_per_malam * DATEDIFF(reservasi.checkout, reservasi.checkin) AS total_harga
                    FROM reservasi
                    JOIN tamu ON reservasi.id_tamu = tamu.id
                    JOIN kamar ON reservasi.id_kamar = kamar.id
                ";
                $data = mysqli_query($koneksi, $query);
                $no = 1;
                while ($d = mysqli_fetch_assoc($data)) {
                ?> 
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($d['nama_tamu']) ?></td>
                    <td><?= htmlspecialchars($d['nama_kamar']) ?></td>
                    <td><?= htmlspecialchars($d['checkin']) ?></td>
                    <td><?= htmlspecialchars($d['checkout']) ?></td>
                    <td>Rp.<?= number_format($d['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="hapus.php?id=<?= $d['id']; ?>" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-danger">Hapus</a>
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
