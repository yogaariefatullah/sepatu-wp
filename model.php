<?php include 'header.php'; ?>
<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM model WHERE kd_model='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    if ($update) {
        $sql = "UPDATE model SET kd_kriteria='$_POST[kd_kriteria]', kd_jenis='$_POST[kd_jenis]', bobot='$_POST[bobot]' WHERE kd_model='$_GET[key]'";
    } else {
        $sql = "INSERT INTO model VALUES (NULL, '$_POST[kd_jenis]', '$_POST[kd_kriteria]', '$_POST[bobot]')";
        $validasi = true;
    }

    if ($validasi) {
        $q = $connection->query("SELECT kd_model FROM model WHERE kd_jenis=$_POST[kd_jenis] AND kd_kriteria=$_POST[kd_kriteria] AND bobot LIKE '%$_POST[bobot]%'");
        if ($q->num_rows) {
            echo alert("Model sudah ada!", "?page=model");
            $err = true;
        }
    }

    if (!$err and $connection->query($sql)) {
        echo alert("Berhasil!", "?page=model");
    } else {
        echo alert("Gagal!", "?page=model");
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM model WHERE kd_model='$_GET[key]'");
    echo alert("Berhasil!", "?page=model");
}
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
        <div class="row">
                <div class="col-md-4 ">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-description mt-3">
                                <?= ($update) ? "EDIT" : "TAMBAH" ?>
                            </h3>
                            <form class="forms-sample" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                <input type="hidden" value="1" class="form-control" name="kd_jenis">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Kriteria</label>
                                    <select class="form-control" name="kd_kriteria" id="kriteria">
                                        <option>---</option>
                                        <?php $sql = $connection->query("SELECT * FROM kriteria") ?>
                                        <?php while ($data = $sql->fetch_assoc()) : ?>
                                            <option value="<?= $data["kd_kriteria"] ?>" class="<?= $data["kd_jenis"] ?>" <?= (!$update) ?: (($row["kd_kriteria"] != $data["kd_kriteria"]) ?: ' selected="on"') ?>><?= $data["tipe"] . ' | ' . $data["nama"] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bobot</label>
                                    <input type="text" name="bobot" class="form-control" value="" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sifat</label>
                                    <select class="form-control" name="sifat" required>
                                        <option value="max">Max</option>
                                        <option value="">---</option>
                                        <option value="min">Min</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary me-2 float-end <?= ($update) ? "warning" : "info" ?>">Simpan</button>
                                <?php if ($update) : ?>
                                    <a href="?page=kriteria" class="btn btn-light">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>DAFTAR KRITERIA</b></h2>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Kriteria</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($query = $connection->query("SELECT c.nama AS nama_jenis, b.nama AS nama_kriteria, a.bobot, tipe, a.kd_model FROM model a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN jenis c ON a.kd_jenis=c.kd_jenis")) : ?>
                                        <?php while ($row = $query->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['tipe'] ?></td>
                                                <td><?= $row['nama_kriteria'] ?></td>
                                                <td><?= $row['bobot'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="?page=model&action=update&key=<?= $row['kd_model'] ?>" class="btn btn-warning m-1">Edit</a>
                                                        <a href="?page=model&action=delete&key=<?= $row['kd_model'] ?>" class="btn btn-danger m-1">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ambiltotal = $connection->query("SELECT SUM(bobot) AS total FROM model");
$total = $ambiltotal->fetch_assoc();
echo $total['total'];
?>
<?php include 'footer.php'; ?>