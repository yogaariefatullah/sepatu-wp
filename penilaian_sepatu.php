<?php include 'header.php'; ?>
<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM penilaian_sepatu WHERE kd_penilaian='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    $keterangan = $_POST['keterangan'];
    $bobot = $_POST['bobot'];
    if ($update) {
        $sql = "UPDATE penilaian_sepatu SET id_sepatu='$_POST[id_sepatu]', kd_kriteria='$_POST[kd_kriteria]', keterangan='$_POST[keterangan]', bobot='$bobot' WHERE kd_penilaian='$_GET[key]'";
    } else {
        $ambil = $connection->query("SELECT * FROM penilaian_sepatu WHERE id_sepatu ='$_POST[id_sepatu]' AND kd_kriteria='$_POST[kd_kriteria]'");
        $cek = $ambil->num_rows;
        if ($cek >= 1) {
            echo "<script> alert('Penilaian untuk sepatu ini sudah ada');</script>";
            $err = true;
        } else {
            $sql = "INSERT INTO penilaian_sepatu (id_sepatu, kd_kriteria, keterangan, bobot) VALUES ('$_POST[id_sepatu]', '$_POST[kd_kriteria]', '$_POST[keterangan]', '$bobot')";
            $validasi = true;
        }
    }

    if (!$err and $connection->query($sql)) {
        echo alert("Berhasil!", "?page=penilaian_sepatu");
    } else {
        echo alert("Gagal!", "?page=penilaian_sepatu");
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM penilaian_sepatu WHERE kd_penilaian='$_GET[key]'");
    echo alert("Berhasil!", "?page=penilaian_sepatu");
}
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark"><b><?= ($update) ? "Update" : "Tambah" ?></b></h2>
                            <h3 class="card-description mt-3">
                                <?= ($update) ? "EDIT" : "TAMBAH" ?>
                            </h3>
                            <form class="forms-sample" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                <div class="form-group">
                                    <label for="id_sepatu">Sepatu</label>
                                    <select class="form-control" name="id_sepatu" id="id_sepatu">
                                        <option>---</option>
                                        <?php
                                        $querySepatu = $connection->query("SELECT * FROM sepatu");
                                        while ($data = $querySepatu->fetch_assoc()) : ?>
                                            <option value="<?= $data['id_sepatu'] ?>" <?= ($update && $row['id_sepatu'] == $data['id_sepatu']) ? 'selected' : '' ?>><?= $data['nama_sepatu'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_kriteria">Kriteria</label>
                                    <select class="form-control" name="kd_kriteria" id="kd_kriteria">
                                        <option>---</option>
                                        <?php
                                        $queryKriteria = $connection->query("SELECT * FROM kriteria");
                                        while ($data = $queryKriteria->fetch_assoc()) : ?>
                                            <option value="<?= $data['kd_kriteria'] ?>" <?= ($update && $row['kd_kriteria'] == $data['kd_kriteria']) ? 'selected' : '' ?>><?= $data['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" value="<?= $update ? $row['keterangan'] : '' ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <input type="text" name="bobot" value="<?= $update ? $row['bobot'] : '' ?>" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-lg float-end btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                                <?php if ($update) : ?>
                                    <a href="?page=penilaian_sepatu" class="btn btn-lg btn-info btn-block">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>Daftar Penilaian Sepatu</b></h2>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sepatu</th>
                                        <th>Kriteria</th>
                                        <th>Keterangan</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $query = $connection->query("SELECT a.kd_penilaian, b.nama_sepatu, c.nama AS nama_kriteria, a.keterangan, a.bobot 
                                                                        FROM penilaian_sepatu a 
                                                                        JOIN sepatu b ON a.id_sepatu = b.id_sepatu 
                                                                        JOIN kriteria c ON a.kd_kriteria = c.kd_kriteria"); ?>
                                    <?php while ($row = $query->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_sepatu'] ?></td>
                                            <td><?= $row['nama_kriteria'] ?></td>
                                            <td><?= $row['keterangan'] ?></td>
                                            <td><?= $row['bobot'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="?page=penilaian_sepatu&action=update&key=<?= $row['kd_penilaian'] ?>" class="btn btn-warning m-1">Edit</a>
                                                    <a href="?page=penilaian_sepatu&action=delete&key=<?= $row['kd_penilaian'] ?>" class="btn btn-danger m-1">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>