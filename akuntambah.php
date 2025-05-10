<?php include 'header.php';
if ($_SESSION['akun']['role'] != 'Admin') {
    echo "<script> alert('Maaf, anda tidak mempunyak hak untuk mengakses fitur ini');</script>";
    echo "<script> location ='dashboard.php';</script>";
}
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Tambah Data</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pd-20 card-box mb-30">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Anda" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempatlahir">NIK</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIK Anda" name="nik" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggallahir">Jenis Kelamin</label>
                                <select class="form-control" name="jeniskelamin" required>
                                    <option value="Laki - Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jeniskelamin">Email</label>
                                <input type="email" class="form-control" placeholder="Masukkan Email Anda" name="email" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agama">Telepon</label>
                                <input type="number" class="form-control" placeholder="Masukkan No. HP Anda" name="nohp" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" placeholder="Masukkan Pekerjaan Anda" name="pekerjaan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="statusperkawinan">Alamat</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Anda" name="alamat" required></textarea>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Role</label>
                                <select class="form-control" name="role" required>
                                    <option value="Peserta">Peserta</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="username">
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="password" class="form-control" placeholder="Masukkan Password Anda" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" name="simpan" value="simpan" class="btn btn-success float-right pull-right float-end">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['simpan'])) {
                    $nama = $_POST["nama"];
                    $nik = $_POST["nik"];
                    $jeniskelamin = $_POST["jeniskelamin"];
                    $email = $_POST["email"];
                    $nohp = $_POST["nohp"];
                    $pekerjaan = $_POST["pekerjaan"];
                    $alamat = $_POST["alamat"];
                    $role = $_POST["role"];
                    $password = $_POST["password"];
                    $koneksi->query("INSERT INTO akun(nama, nik, jeniskelamin, email, nohp, pekerjaan, alamat, role, password)
		                                VALUES ('$nama','$nik','$jeniskelamin','$email','$nohp','$pekerjaan', '$alamat', '$role', '$password')") or die(mysqli_error($koneksi));
                    echo "<script> alert('Data Sudah Disimpan');</script>";
                    echo "<script> location ='akundaftar.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>