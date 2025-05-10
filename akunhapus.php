<?php
include 'koneksi.php';
session_start();
if ($_SESSION['akun']['role'] != 'Admin') {
    echo "<script> alert('Maaf, anda tidak mempunyak hak untuk mengakses fitur ini');</script>";
    echo "<script> location ='dashboard.php';</script>";
}
$ambildata = $koneksi->query("SELECT * FROM akun WHERE idakun='$_GET[id]'");
$data = $ambildata->fetch_assoc();
$koneksi->query("DELETE FROM akun WHERE idakun='$_GET[id]'");
$koneksi->query("DELETE FROM nilai WHERE nik='$data[nik]'");
echo "<script>alert('Data Peserta Berhasil Di Hapus');</script>";
echo "<script>location='akundaftar.php';</script>";
