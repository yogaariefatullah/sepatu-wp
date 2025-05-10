<?php include 'headerhome.php';
error_reporting(0);
ini_set('display_errors', 0);
$idakun = $_SESSION['akun']['idakun'];
$ambildata = $koneksi->query("SELECT * FROM akun WHERE idakun='$idakun'");
$data = $ambildata->fetch_assoc();
?>
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Profil</h1>
            <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-white">Profil</a></li>
            </ol>
    </div>
</div>

<div class="container-fluid overflow-hidden py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.1s">
                <form method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="mb-2">Nama</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo $data['nama'] ?>" class="form-control" name="nama" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-2">NIK</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo $data['nik'] ?>" class="form-control" placeholder="Masukkan NIK Anda" name="nik" readonly required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Jenis Kelamin</label>
                            <div class="form-group">
                                <select class="form-control valid" name="jeniskelamin" required>
                                    <option <?php if ($data['jeniskelamin'] == 'Laki - Laki') echo 'selected'; ?> value="Laki - Laki">Laki - Laki</option>
                                    <option <?php if ($data['jeniskelamin'] == 'Perempuan') echo 'selected'; ?> value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Email</label>
                            <div class="form-group">
                                <input type="email" value="<?php echo $data['email'] ?>" class="form-control" placeholder="Masukkan Email Anda" name="email" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">No. Telepon</label>
                            <div class="form-group">
                                <input type="number" value="<?php echo $data['nohp'] ?>" class="form-control" placeholder="Masukkan No. HP Anda" name="nohp" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Pekerjaan</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo $data['pekerjaan'] ?>" class="form-control" placeholder="Masukkan Pekerjaan Anda" name="pekerjaan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Alamat</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Anda" name="alamat" required><?php echo $data['alamat'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Password</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo $data['password'] ?>" class="form-control" placeholder="Masukkan Password Anda" name="password" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="mb-2">Foto Profil</label>
                            <div class="form-group">
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary float-end rounded-pill py-3 px-5" type="submit" type="submit" name="simpan" value="simpan">Simpan</button>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['simpan'])) {
                    $jeniskelamin = $_POST["jeniskelamin"];
                    $email = $_POST["email"];
                    $nohp = $_POST["nohp"];
                    $pekerjaan = $_POST["pekerjaan"];
                    $alamat = $_POST["alamat"];
                    $password = $_POST["password"];

                    // upload foto
                    $lokasifoto = $_FILES['foto']['tmp_name'];
                    if (!empty($lokasifoto)) {
                        $fotoprofil = $_FILES['foto']['name'];
                        move_uploaded_file($lokasifoto, "assets/foto/" . $fotoprofil);
                    } else {
                        $fotoprofil = $data['foto'];
                    }

                    $koneksi->query("UPDATE akun SET pekerjaan='$pekerjaan',jeniskelamin='$jeniskelamin',email='$email',nohp='$nohp', alamat='$alamat',  password='$password', foto='$fotoprofil' WHERE idakun='$idakun'") or die(mysqli_error($koneksi));

                    echo "<script> alert('Profil Berhasil Di Ubah');</script>";
                    echo "<script> location ='profiluser.php';</script>";
                }
                ?>
            </div>
            <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.3s">
                <?php
                if ($data['foto'] != "") { ?>
                    <img src="assets/foto/<?php echo $data['foto'] ?>" width="50%" style="border-radius: 10px;">
                <?php } else { ?>
                    <img src="assets/foto/user.png" width="50%" style="border-radius: 10px;">
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footerhome.php'; ?>