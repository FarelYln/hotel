<?php 
include('../../navbar.php');

$pesan = ""; // Initialize pesan variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tamu = mysqli_real_escape_string($koneksi, $_POST['id_tamu']);
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $checkin = mysqli_real_escape_string($koneksi, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($koneksi, $_POST['checkout']);
    
    // Check if checkin and checkout are valid
    if ($checkin >= $checkout) {
        $pesan = "Tanggal check-in harus sebelum tanggal check-out.";
    } else {
        // Fetch the price per night for the selected room
        $price_query = "SELECT harga_per_malam FROM kamar WHERE id = '$id_kamar'";
        $price_result = mysqli_query($koneksi, $price_query);
        $price_row = mysqli_fetch_assoc($price_result);
        $harga_per_malam = $price_row['harga_per_malam'];
        
        // Calculate the total price
        $jumlah_malam = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
        $total_harga = $harga_per_malam * $jumlah_malam;

        // Check if the room is already booked
        $check_query = "SELECT * FROM reservasi WHERE id_kamar = '$id_kamar' AND ('$checkin' < checkout AND '$checkout' > checkin)";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $pesan = "Kamar sudah dipesan untuk tanggal tersebut.";
        } else {
            // Insert reservation with total price
            $query = "INSERT INTO reservasi (id_tamu, id_kamar, checkin, checkout, harga_pm) VALUES ('$id_tamu', '$id_kamar', '$checkin', '$checkout', '$total_harga')";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Reservasi Berhasil Ditambahkan');window.location.href='index.php'</script>";
                exit();
            } else {
                $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
            }
        }
    }
}

// Fetch tamu data
$tamu_query = "SELECT id, nama FROM tamu";
$tamu_result = mysqli_query($koneksi, $tamu_query);

// Fetch kamar data
$kamar_query = "SELECT id, nama_kamar FROM kamar";
$kamar_result = mysqli_query($koneksi, $kamar_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah reservasi</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah reservasi</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>
        <form action="tambah.php" method="post">
            <div class="form-group">
                <label for="id_tamu">Tamu</label>
                <select class="form-control" id="id_tamu" name="id_tamu" required>
                    <option value="" disabled selected>Pilih Tamu</option>
                    <?php while ($row = mysqli_fetch_assoc($tamu_result)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_kamar">Kamar</label>
                <select class="form-control" id="id_kamar" name="id_kamar" required>
                    <option value="" disabled selected>Pilih Kamar</option>
                    <?php while ($row = mysqli_fetch_assoc($kamar_result)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nama_kamar'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="checkin">Check In</label>
                <input type="date" class="form-control" id="checkin" name="checkin" required>
            </div>
            <div class="form-group">
                <label for="checkout">Check Out</label>
                <input type="date" class="form-control" id="checkout" name="checkout" required>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
