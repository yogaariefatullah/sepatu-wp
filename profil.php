<?php include 'header.php';
error_reporting(0);
ini_set('display_errors', 0);
$idakun = $_SESSION['akun']['idakun'];
$ambildata = $koneksi->query("SELECT * FROM akun WHERE idakun='$idakun'");
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
                <form method="post" enctype="multipart/form-data">
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
                                <input type="number" value="<?php echo $data['nik'] ?>" class="form-control" placeholder="Masukkan NIK Anda" name="nik" required>
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
                                <input type="number" value="<?php echo $data['nohp'] ?>" class="form-control" placeholder="Masukkan No. HP Anda" name="nohp" required>

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
                        <div class="col-md-6" id="username">
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="text" value="<?php echo $data['password'] ?>" class="form-control" placeholder="Masukkan Password Anda" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="username">
                            <div class="form-group">
                                <label for="username">Foto</label>
                                <input type="file" class="form-control" name="foto">
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
                    $password = $_POST["password"];

                    // upload foto
                    $lokasifoto = $_FILES['foto']['tmp_name'];
                    if (!empty($lokasifoto)) {
                        $bukti = $_FILES['foto']['name'];
                        move_uploaded_file($lokasifoto, "assets/foto/" . $bukti);
                    } else {
                        $bukti = $data['foto'];
                    }

                    $koneksi->query("UPDATE akun SET nama='$nama' ,nik='$nik',jeniskelamin='$jeniskelamin',email='$email',pekerjaan='$pekerjaan',nohp='$nohp', alamat='$alamat',  password='$password', foto='$bukti' WHERE idakun='$idakun'") or die(mysqli_error($koneksi));

                    echo "<script> alert('Profil Berhasil Di Ubah');</script>";
                    echo "<script> location ='profil.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>