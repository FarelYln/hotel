<?php
include('../../koneksi.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
        $query = mysqli_query($koneksi, "DELETE FROM bayar WHERE id = '$id'");

        if ($query) {
            echo "<script>alert('Data Pembayaran Berhasil Dihapus');window.location.href='index.php'</script>";
        } else {
            throw new Exception("Gagal menghapus Data Pembayaran.");
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to a foreign key constraint
        
            echo "<script>alert('Data Pembayaran sedang digunakan. Tidak bisa dihapus.');window.location.href='index.php'</script>";
    }
}