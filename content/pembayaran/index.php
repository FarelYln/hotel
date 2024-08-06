<?php 
include('../../navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">
            Pembayaran
        </h1>
        <a href="tambah.php" class="btn btn-primary mt-3">Lakukan Pembayaran</a>
        <table class="table mt-3 text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Reservasi</th>
                    <th scope="col">Tamu</th>
                    <th scope="col">Tanggal Bayar</th>
                    <th scope="col">Total</th>
                    <th scope="col">Jumlah Bayar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $query = "
                    SELECT
                        bayar.id,
                        reservasi.id AS id_reservasi,
                        tamu.id AS id_tamu,
                        tamu.nama AS nama_tamu,
                        bayar.tanggal_bayar,
                        (DATEDIFF(reservasi.checkout, reservasi.checkin) * kamar.harga_per_malam)
                        AS total_harga,
                        bayar.jumlah_bayar
                    FROM bayar 
                    JOIN reservasi ON bayar.id_reservasi = reservasi.id
                    JOIN kamar ON reservasi.id_kamar = kamar.id
                    JOIN tamu ON reservasi.id_tamu = tamu.id
                ";
                $data = mysqli_query($koneksi, $query);
                while ($d = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($d['id_reservasi']) ?></td>
                    <td><?= htmlspecialchars($d['nama_tamu']) ?> </td>
                    <td><?= htmlspecialchars($d['tanggal_bayar']) ?></td>
                    <td>Rp.<?= number_format($d['total_harga'], 0, ',', '.') ?></td>
                    <td>Rp.<?= number_format($d['jumlah_bayar'], 0, ',', '.') ?></td>
                    <td>
                        <!-- <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning">Edit</a> -->
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
