<?php 
include('../../navbar.php');
include('../../koneksi.php'); // Koneksi ke database

// Inisialisasi pesan
$pesan = ""; 
$total_harga = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reservasi = mysqli_real_escape_string($koneksi, $_POST['id_reservasi']);
    $jumlah_bayar = (float)mysqli_real_escape_string($koneksi, $_POST['jumlah_bayar']); // Konversi ke float
    $tanggal_bayar = date('Y-m-d'); // Tanggal hari ini

    // Ambil harga per malam dari tabel reservasi
    $reservasi_query = "
        SELECT
            kamar.harga_per_malam * DATEDIFF(reservasi.checkout, reservasi.checkin) AS total_harga
        FROM reservasi
        JOIN kamar ON reservasi.id_kamar = kamar.id
        WHERE reservasi.id = '$id_reservasi'
    ";
    $reservasi_result = mysqli_query($koneksi, $reservasi_query);
    $reservasi_data = mysqli_fetch_assoc($reservasi_result);

    if ($reservasi_data) {
        $total_harga = (float)$reservasi_data['total_harga']; // Konversi ke float

        // Validasi jumlah bayar
        if ($jumlah_bayar < $total_harga) {
            $pesan = "Pembayaran Gagal. Uang Anda Kurang: Rp." . number_format($total_harga - $jumlah_bayar, 0, ',', '.');
        } else {
            // Masukkan data pembayaran ke tabel pembayaran
            $query = "INSERT INTO bayar (id_reservasi, tanggal_bayar, jumlah_bayar, total) VALUES ('$id_reservasi', '$tanggal_bayar', '$jumlah_bayar', '$total_harga')";
            
            if (mysqli_query($koneksi, $query)) {
                $kembalian = $jumlah_bayar - $total_harga;
                if ($kembalian > 0) {
                    $pesan = "Pembayaran Berhasil. Kembalian Anda: Rp." . number_format($kembalian, 0, ',', '.');
                } else {
                    $pesan = "Pembayaran Berhasil.";
                }
                echo "<script>alert('$pesan');window.location.href='index.php'</script>";
                exit();
            } else {
                $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
            }
        }
    } else {
        $pesan = "Reservasi tidak ditemukan.";
    }
}

// Fetch data reservasi, kamar, dan tamu
$reservasi_query = "
    SELECT
        reservasi.id AS id_reservasi,
        kamar.nama_kamar,
        tamu.nama AS nama_tamu
    FROM reservasi
    JOIN kamar ON reservasi.id_kamar = kamar.id
    JOIN tamu ON reservasi.id_tamu = tamu.id
";
$reservasi_result = mysqli_query($koneksi, $reservasi_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembayaran</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Pembayaran</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $pesan; ?>
            </div>
        <?php } ?>
        <form action="tambah.php" method="post">
            <div class="form-group">
                <label for="id_reservasi">Nama Kamar (Nama Pemesan)</label>
                <select class="form-control" id="id_reservasi" name="id_reservasi" required>
                    <option value="" disabled selected>Pilih Kamar</option>
                    <?php while ($row = mysqli_fetch_assoc($reservasi_result)) { ?>
                        <option value="<?= $row['id_reservasi'] ?>" <?= (isset($_POST['id_reservasi']) && $_POST['id_reservasi'] == $row['id_reservasi']) ? 'selected' : '' ?>>
                            <?= $row['nama_kamar'] ?> (<?= $row['nama_tamu'] ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar</label>
                <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
