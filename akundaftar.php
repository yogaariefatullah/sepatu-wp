<?php include 'header.php';
if ($_SESSION['akun']['role'] != 'Admin') {
    echo "<script> alert('Maaf, anda tidak mempunyai hak untuk mengakses halaman ini');</script>";
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
                            <h4>Daftar Akun</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary mb-4" href="akuntambah.php">Tambah Akun</a>
                    </div>
                </div>
            </div>
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Data Akun</h4>
                </div>
                <div class="pb-20">
                    <table class="table table-striped text-dark" id="tabel" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Pekerjaan</th>
                                <th scope="col">Email</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1;
                            $idakun = $_SESSION['akun']['idakun'];
                            $ambildata = $koneksi->query("SELECT*FROM akun where idakun!='$idakun' order by idakun asc") or die(mysqli_error($koneksi));
                            while ($data = $ambildata->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $data['nik'] ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['pekerjaan'] ?></td>
                                    <td><?php echo $data['email'] ?></td>
                                    <td>
                                        <?php
                                        if ($data['foto'] != "") { ?>
                                            <img src="assets/foto/<?php echo $data['foto'] ?>" width="50px" style="border-radius: 10px;">
                                        <?php } else { ?>
                                            <img src="assets/foto/user.png" width="50px" style="border-radius: 10px;">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $data['role'] ?>
                                    </td>
                                    <td>
                                        <a href="akunedit.php?id=<?php echo $data['idakun']; ?>" class="btn btn-warning m-1">Edit</a>
                                        <a href="akunhapus.php?id=<?php echo $data['idakun']; ?>" class="btn btn-danger m-1" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                                $nomor = $nomor + 1;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include 'footer.php'; ?>