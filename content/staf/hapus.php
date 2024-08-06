<?php
include('../../koneksi.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
        $query = mysqli_query($koneksi, "DELETE FROM staf WHERE id = '$id'");

        if ($query) {
            echo "<script>alert('staf Berhasil Dihapus');window.location.href='index.php'</script>";
        } else {
            throw new Exception("Gagal menghapus staf.");
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to a foreign key constraint
        
            echo "<script>alert('staf sedang digunakan. Tidak bisa dihapus.');window.location.href='index.php'</script>";
    }
}