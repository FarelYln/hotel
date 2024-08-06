<?php 
include('../../navbar.php');

$pesan = ""; // Initialize pesan variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    
    // Validasi di sisi server
    if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
        $pesan = "Nama tidak boleh mengandung angka.";
    } elseif (!preg_match("/^[0-9]+$/", $no_hp)) {
        $pesan = "Nomor Telepon harus berisi angka saja.";
    } elseif (strlen($no_hp) < 12 || strlen($no_hp) > 13) {
        $pesan = "Nomor Telepon harus memiliki panjang antara 11 dan 14 digit.";
    } else {
        // Check if nama or no_hp already exists
        $checkQuery = "SELECT * FROM tamu WHERE nama = '$nama' OR no_hp = '$no_hp'";
        $checkResult = mysqli_query($koneksi, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $pesan = "Nama atau Nomor HP sudah ada.";
        } else {
            $query = "INSERT INTO tamu (nama, no_hp) VALUES ('$nama', '$no_hp')";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Tamu Berhasil Ditambahkan');window.location.href='index.php'</script>";
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
    <title>Tambah Tamu</title>
    <script>
        function validateForm() {
            var nama = document.getElementById("nama").value;
            var no_hp = document.getElementById("no_hp").value;

            // Check if nama contains digits
            var namePattern = /^[a-zA-Z\s]+$/;
            if (!namePattern.test(nama)) {
                alert("Nama tidak boleh mengandung angka.");
                return false;
            }

            // Check if no_hp contains only digits
            var phonePattern = /^[0-9]+$/;
            if (!phonePattern.test(no_hp)) {
                alert("Nomor Telepon harus berisi angka saja.");
                return false;
            }

            // Check length of no_hp
            if (no_hp.length < 12 || no_hp.length > 13) {
                alert("Nomor Telepon harus memiliki panjang antara 12 dan 13 digit.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Tamu</h2>
        <?php if (!empty($pesan)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $pesan; ?>
            </div>
        <?php } ?>
        <form action="tambah.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="no_hp">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
