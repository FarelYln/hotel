<?php 
include('../../navbar.php');

$pesan = ""; // Initialize pesan variable

// Fetch the reservation details based on the reservation ID
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $reservation_query = "SELECT * FROM reservasi WHERE id = '$id'";
    $reservation_result = mysqli_query($koneksi, $reservation_query);
    $reservation = mysqli_fetch_assoc($reservation_result);

    if (!$reservation) {
        echo "<script>alert('Reservasi tidak ditemukan');window.location.href='index.php'</script>";
        exit();
    }
} else {
    echo "<script>alert('ID Reservasi tidak valid');window.location.href='index.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tamu = mysqli_real_escape_string($koneksi, $_POST['id_tamu']);
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $checkin = mysqli_real_escape_string($koneksi, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($koneksi, $_POST['checkout']);
    
    // Ensure check-in date is not before today
    if ($checkin < date('Y-m-d')) {
        $pesan = "Tanggal check-in tidak boleh sebelum hari ini.";
    } elseif ($checkout <= $checkin) {
        $pesan = "Tanggal checkout harus lebih dari tanggal check-in.";
    } else {
        // Check if the room is already booked
        $check_query = "SELECT * FROM reservasi WHERE id_kamar = '$id_kamar' AND id != '$id' AND ('$checkin' < checkout AND '$checkout' > checkin)";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $pesan = "Kamar sudah dipesan untuk tanggal tersebut.";
        } else {
            $query = "UPDATE reservasi SET id_tamu = '$id_tamu', id_kamar = '$id_kamar', checkin = '$checkin', checkout = '$checkout' WHERE id = '$id'";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Reservasi Berhasil Diperbarui');window.location.href='index.php'</script>";
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
    <title>Edit reservasi</title>
    <script>
        function validateForm() {
            var checkin = document.getElementById("checkin").value;
            var checkout = document.getElementById("checkout").value;
            var today = new Date().toISOString().split('T')[0];

            if (checkin < today) {
                alert("Tanggal check-in tidak boleh sebelum hari ini.");
                return false;
            }

            if (checkout <= checkin) {
                alert("Tanggal checkout harus lebih dari tanggal check-in.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit reservasi</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>
        <form action="edit.php?id=<?= $reservation['id'] ?>" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="id_tamu">Tamu</label>
                <select class="form-control" id="id_tamu" name="id_tamu" required>
                    <option value="" disabled>Pilih Tamu</option>
                    <?php while ($row = mysqli_fetch_assoc($tamu_result)) { ?>
                        <option value="<?= $row['id'] ?>" <?= $row['id'] == $reservation['id_tamu'] ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_kamar">Kamar</label>
                <select class="form-control" id="id_kamar" name="id_kamar" required>
                    <option value="" disabled>Pilih Kamar</option>
                    <?php while ($row = mysqli_fetch_assoc($kamar_result)) { ?>
                        <option value="<?= $row['id'] ?>" <?= $row['id'] == $reservation['id_kamar'] ? 'selected' : '' ?>><?= $row['nama_kamar'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="checkin">Check In</label>
                <input type="date" class="form-control" id="checkin" name="checkin" value="<?= $reservation['checkin'] ?>" required>
            </div>
            <div class="form-group">
                <label for="checkout">Check Out</label>
                <input type="date" class="form-control" id="checkout" name="checkout" value="<?= $reservation['checkout'] ?>" required>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
