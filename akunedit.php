<?php include 'header.php';
if ($_SESSION['akun']['role'] != 'Admin') {
    echo "<script> alert('Maaf, anda tidak mempunyak hak untuk mengakses fitur ini');</script>";
    echo "<script> location ='dashboard.php';</script>";
}
?>
<?php
$idakun = $_GET['id'];
$ambildata = $koneksi->query("SELECT * FROM akun WHERE idakun='$_GET[id]'");
$data = $ambildata->fetch_assoc();
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Edit Data</h4>
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
                                <input type="text" value="<?php echo $data['nama'] ?>" class="form-control" placeholder="Masukkan Nama Anda" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempatlahir">NIK</label>
                                <input type="text" value="<?php echo $data['nik'] ?>" class="form-control" placeholder="Masukkan NIK" name="nik" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggallahir">Jenis Kelamin</label>
                                <select class="form-control" name="jeniskelamin" required>
                                    <option <?php if ($data['jeniskelamin'] == 'Laki - Laki') echo 'selected'; ?> value="Laki - Laki">Laki - Laki</option>
                                    <option <?php if ($data['jeniskelamin'] == 'Perempuan') echo 'selected'; ?> value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jeniskelamin">Email</label>
                                <input type="email" value="<?php echo $data['email'] ?>" class="form-control" placeholder="Masukkan Email Anda" name="email" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agama">Telepon</label>
                                <input type="number" value="<?php echo $data['nohp'] ?>" class="form-control" placeholder="Masukkan No Hp Anda" name="nohp" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" value="<?php echo $data['pekerjaan'] ?>" class="form-control" placeholder="Masukkan Pekerjaan Anda" name="pekerjaan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="statusperkawinan">Alamat</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Anda" name="alamat" required><?php echo $data['alamat'] ?></textarea>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Role</label>
                                <input type="text" value="<?php echo $data['role'] ?>" class="form-control" name="role" readonly required>

                            </div>
                        </div>
                        <div class="col-md-6" id="username">
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="text" value="<?php echo $data['password'] ?>" class="form-control" placeholder="Masukkan Password Anda" name="password" required>
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
                    $koneksi->query("UPDATE akun SET nama='$nama',nik='$nik',jeniskelamin='$jeniskelamin',email='$email',nohp='$nohp',pekerjaan='$pekerjaan', alamat='$alamat', role='$role', password='$password' WHERE idakun='$_GET[id]'") or die(mysqli_error($koneksi));

                    $koneksi->query("UPDATE nilai SET nik='$nik' WHERE nik='$data[nik]'") or die(mysqli_error($koneksi));


                    echo "<script> alert('Data Akun Berhasil di Perbarui');</script>";
                    echo "<script> location ='akundaftar.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>