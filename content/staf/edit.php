<?php
session_start();
include('../../navbar.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query = mysqli_query($koneksi, "SELECT * FROM staf WHERE id = '$id'");
    if ($query) {
        $staf = mysqli_fetch_assoc($query);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Validasi email
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
        $_SESSION['pesan'] = "Email harus diakhiri dengan @gmail.com.";
        header("Location: edit.php?id=$id");
        exit();
    }

    // Check if nama or no_hp or email already exists for other stafs
    $checkQuery = "SELECT * FROM staf WHERE (nama = '$nama' OR no_hp = '$no_hp' OR email = '$email') AND id != '$id'";
    $checkResult = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['pesan'] = "Nama, Nomor HP, atau Email sudah ada. Gunakan yang lain.";
        header("Location: edit.php?id=$id");
        exit();
    } else {
        $query = "UPDATE staf SET nama = '$nama', no_hp = '$no_hp', email = '$email' WHERE id = '$id'";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data Berhasil di Ubah');window.location.href='index.php'</script>";
            exit();
        } else {
            $_SESSION['pesan'] = "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staf</title>
    <script>
        function validateForm() {
            var nama = document.getElementById("nama").value;
            var no_hp = document.getElementById("no_hp").value;
            var email = document.getElementById("email").value;

            var namaRegex = /^[a-zA-Z\s]+$/;
            var no_hpRegex = /^[0-9]{11,14}$/;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            if (!namaRegex.test(nama)) {
                alert("Nama tidak boleh mengandung angka.");
                return false;
            }

            if (!no_hpRegex.test(no_hp)) {
                alert("Nomor HP harus memiliki panjang antara 11 dan 14 digit dan hanya mengandung angka.");
                return false;
            }

            if (!emailRegex.test(email)) {
                alert("Email tidak valid.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h2 class="mt-2">Edit Staf</h2>
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['pesan'];
                unset($_SESSION['pesan']);
                ?>
            </div>
        <?php endif; ?>
        <form action="edit.php" method="POST" id="form" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?= htmlspecialchars($staf['id']); ?>">
            <div class="row g-2 mt-3">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($staf['nama']); ?>" required>
                        <label for="nama">Nama Staf</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row g-2 mt-3">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($staf['no_hp']); ?>" required>
                        <label for="no_hp">Nomor HP</label>
                    </div>
                </div>
            </div>
            <div class="row g-2 mt-3">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($staf['email']); ?>" required>
                        <label for="email">Email</label>
                    </div>
                </div>
            </div>
            <br>
            <a href="index.php" class="btn btn-secondary">&#x276E;&#x276E;Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>


