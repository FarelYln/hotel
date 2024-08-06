<?php 
include('../../navbar.php');

$pesan = ""; // Initialize pesan variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kamar = mysqli_real_escape_string($koneksi, $_POST['nama_kamar']);
    $tipe_kamar = mysqli_real_escape_string($koneksi, $_POST['tipe_kamar']);
    $harga_per_malam = mysqli_real_escape_string($koneksi, $_POST['harga_per_malam']);
    
    // Validasi harga_per_malam
    if (!ctype_digit($harga_per_malam)) {
        $pesan = "Harga per malam harus berupa angka bulat.";
    } else {
        // Check if nama_kamar already exists
        $checkQuery = "SELECT * FROM kamar WHERE nama_kamar = '$nama_kamar'";
        $checkResult = mysqli_query($koneksi, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $pesan = "Nama kamar sudah ada.";
        } else {
            $query = "INSERT INTO kamar (nama_kamar, tipe_kamar, harga_per_malam) VALUES ('$nama_kamar', '$tipe_kamar', '$harga_per_malam')";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Kamar Berhasil Ditambahkan');window.location.href='index.php'</script>";
                exit();
            } else {
                $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
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
    <title>Tambah kamar</title>
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
        <h2>Tambah kamar</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>
        <form action="tambah.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nama_kamar">Nama kamar</label>
                <input type="text" class="form-control" id="nama_kamar" name="nama_kamar" required>
                <div id="namaKamarError" class="text-danger"></div>
            </div>
            <div class="form-group">
                <label for="tipe_kamar">Tipe kamar</label>
                <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" required>
            </div>
            <div class="form-group">
                <label for="harga_per_malam">Harga per malam</label>
                <input type="text" class="form-control" id="harga_per_malam" name="harga_per_malam" required>
                <div id="hargaPerMalamError" class="text-danger"></div>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
