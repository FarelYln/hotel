<?php 
include('../../navbar.php');

// Ambil ID kamar dari parameter URL
$id = $_GET['id'];

// Ambil data kamar berdasarkan ID
$query = "SELECT * FROM kamar WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$kamar = mysqli_fetch_assoc($result);

$pesan = ""; // Initialize pesan variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kamar = mysqli_real_escape_string($koneksi, $_POST['nama_kamar']);
    $tipe_kamar = mysqli_real_escape_string($koneksi, $_POST['tipe_kamar']);
    $harga_per_malam = mysqli_real_escape_string($koneksi, $_POST['harga_per_malam']);
    
    // Validasi harga_per_malam
    if (!ctype_digit($harga_per_malam)) {
        $pesan = "Harga per malam harus berupa angka bulat.";
    } else {
        // Check if nama_kamar already exists (excluding current kamar)
        $checkQuery = "SELECT * FROM kamar WHERE nama_kamar = '$nama_kamar' AND id != $id";
        $checkResult = mysqli_query($koneksi, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $pesan = "Nama kamar sudah ada.";
        } else {
            $updateQuery = "UPDATE kamar SET nama_kamar = '$nama_kamar', tipe_kamar = '$tipe_kamar', harga_per_malam = '$harga_per_malam' WHERE id = $id";
            if (mysqli_query($koneksi, $updateQuery)) {
                echo "<script>alert('Kamar Berhasil Diperbarui');window.location.href='index.php'</script>";
                exit();
            } else {
                $pesan = "Error: " . $updateQuery . "<br>" . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit kamar</title>
    <script>
        function validateForm() {
            var nama_kamar = document.getElementById("nama_kamar").value;
            var harga_per_malam = document.getElementById("harga_per_malam").value;
            var namaKamarError = document.getElementById("namaKamarError");
            var hargaPerMalamError = document.getElementById("hargaPerMalamError");

            // Validasi nama_kamar
            if (nama_kamar.trim() === "") {
                namaKamarError.textContent = "Nama kamar tidak boleh kosong.";
                return false;
            } else {
                namaKamarError.textContent = "";
            }

            // Validasi harga_per_malam
            if (!/^\d+$/.test(harga_per_malam)) {
                hargaPerMalamError.textContent = "Harga per malam harus berupa angka bulat.";
                return false;
            } else {
                hargaPerMalamError.textContent = "";
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit kamar</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>
        <form action="edit.php?id=<?php echo $id; ?>" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nama_kamar">Nama kamar</label>
                <input type="text" class="form-control" id="nama_kamar" name="nama_kamar" value="<?php echo $kamar['nama_kamar']; ?>" required>
                <div id="namaKamarError" class="text-danger"></div>
            </div>
            <div class="form-group">
                <label for="tipe_kamar">Tipe kamar</label>
                <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" value="<?php echo $kamar['tipe_kamar']; ?>" required>
            </div>
            <div class="form-group">
                <label for="harga_per_malam">Harga per malam</label>
                <input type="text" class="form-control" id="harga_per_malam" name="harga_per_malam" value="<?php echo $kamar['harga_per_malam']; ?>" required>
                <div id="hargaPerMalamError" class="text-danger"></div>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
