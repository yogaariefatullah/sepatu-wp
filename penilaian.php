<?php include 'header.php'; ?>
<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM penilaian WHERE kd_penilaian='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    $keterangan = $_POST['keterangan'];
    $bobot = $_POST['bobot'];
    // $bobot = 1;
    // if ($keterangan == 'Sangat Baik') {
    //     $bobot = 1;
    // } elseif ($keterangan == 'Baik') {
    //     $bobot = 2;
    // } elseif ($keterangan == 'Cukup') {
    //     $bobot = 3;
    // } else {
    //     $bobot = 4;
    // }
    if ($update) {
        $sql = "UPDATE penilaian SET kd_kriteria='$_POST[kd_kriteria]', keterangan='$_POST[keterangan]', bobot='$bobot' WHERE kd_penilaian='$_GET[key]'";
    } else {
        $ambil = $connection->query("SELECT * FROM penilaian
		WHERE kd_jenis ='$_POST[kd_jenis]' and kd_kriteria  ='$_POST[kd_kriteria]'");
        $cek = $ambil->num_rows;
        if ($cek >= 1) {
            // echo "<script> alert('Data model untuk kriteria ini sudah ada');</script>";
            // echo "<script> location ='penilaian.php';</script>";
            $sql = "INSERT INTO penilaian VALUES (NULL, '$_POST[kd_jenis]', '$_POST[kd_kriteria]', '$_POST[keterangan]', '$bobot')";
            $validasi = true;
        } else {
            $sql = "INSERT INTO penilaian VALUES (NULL, '$_POST[kd_jenis]', '$_POST[kd_kriteria]', '$_POST[keterangan]', '$bobot')";
            $validasi = true;
        }
    }

    if ($validasi) {
        $q = $connection->query("SELECT kd_penilaian FROM penilaian WHERE kd_jenis=$_POST[kd_jenis] AND kd_kriteria=$_POST[kd_kriteria] AND keterangan LIKE '%$_POST[keterangan]%' AND bobot=$bobot");
        if ($q->num_rows) {
            echo alert("Penilaian sudah ada!", "?page=penilaian");
            $err = true;
        }
    }

    if (!$err and $connection->query($sql)) {
        echo alert("Berhasil!", "?page=penilaian");
    } else {
        echo alert("Gagal!", "?page=penilaian");
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM penilaian WHERE kd_penilaian='$_GET[key]'");
    echo alert("Berhasil!", "?page=penilaian");
}
?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
        <div class="row">
                <div class="col-md-4 ">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark"><b> <?= ($update) ? "warning" : "info" ?></b></h2>
                            <h3 class="card-description mt-3">
                                <?= ($update) ? "EDIT" : "TAMBAH" ?>
                            </h3>
                            <form class="forms-sample" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                <div class="form-group">
                                    <label for="kd_kriteria">Kriteria</label>
                                    <input type="hidden" name="kd_jenis" value="1">
                                    <select class="form-control" name="kd_kriteria" id="kriteria">
                                        <option>---</option>
                                        <?php $sql = $connection->query("SELECT * FROM kriteria") ?>
                                        <?php while ($data = $sql->fetch_assoc()) : ?>
                                            <option value="<?= $data["kd_kriteria"] ?>" class="<?= $data["kd_jenis"] ?>" <?= (!$update) ?: (($row["kd_kriteria"] != $data["kd_kriteria"]) ?: 'selected="selected"') ?>><?= $data["nama"] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="keterangan">Nilai</label>
                                    <select name="keterangan" class="form-control">
                                        <option value="Sangat Baik" <?= ($update && $row["keterangan"] === "Sangat Baik") ? "selected" : "" ?>>Sangat Baik</option>
                                        <option value="Baik" <?= ($update && $row["keterangan"] === "Baik") ? "selected" : "" ?>>Baik</option>
                                        <option value="Cukup" <?= ($update && $row["keterangan"] === "Cukup") ? "selected" : "" ?>>Cukup</option>
                                        <option value="Kurang" <?= ($update && $row["keterangan"] === "Kurang") ? "selected" : "" ?>>Kurang</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" value="-" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <!-- <select name="bobot" class="form-control">
                                        <option value="1" <?= ($update && $row["bobot"] === "1") ? "selected" : "" ?>>1</option>
                                        <option value="2" <?= ($update && $row["bobot"] === "2") ? "selected" : "" ?>>2</option>
                                        <option value="3" <?= ($update && $row["bobot"] === "3") ? "selected" : "" ?>>3</option>
                                        <option value="4" <?= ($update && $row["bobot"] === "4") ? "selected" : "" ?>>4</option>
                                    </select> -->
                                    <input type="text" name="bobot" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-lg float-end btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                                <?php if ($update) : ?>
                                    <a href="?page=penilaian" class="btn btn-lg btn-info btn-block">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>DAFTAR</b></h2>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kriteria</th>
                                        <th>Keterangan</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($query = $connection->query("SELECT a.kd_penilaian, c.nama AS nama_jenis, b.nama AS nama_kriteria, a.keterangan, a.bobot FROM penilaian a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN jenis c ON a.kd_jenis=c.kd_jenis")) : ?>
                                        <?php while ($row = $query->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nama_kriteria'] ?></td>
                                                <td><?= $row['keterangan'] ?></td>
                                                <td><?= $row['bobot'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="?page=penilaian&action=update&key=<?= $row['kd_penilaian'] ?>" class="btn btn-warning m-1">Edit</a>
                                                        <a href="?page=penilaian&action=delete&key=<?= $row['kd_penilaian'] ?>" class="btn btn-danger m-1">Hapus</a>
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
<?php include 'footer.php'; ?>