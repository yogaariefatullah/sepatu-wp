<?php include 'header.php'; ?>
<?php
$tahun = date('Y');
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM nilai JOIN nilai_kriteria USING(kd_kriteria) WHERE kd_nilai='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["save"])) {
    $validasi = false;
    $err = false;
    if ($update) {
        $sql = "UPDATE nilai SET kd_kriteria='$_POST[kd_kriteria]', nik='$_POST[nik]', nilai='$_POST[nilai]' WHERE kd_nilai='$_GET[key]'";
        $nik = $_POST['nik'];
    } else {
        $nik = $_POST['nik'];
        $ambil = $connection->query("SELECT * FROM nilai
		WHERE nik='$nik'")  or die(mysqli_error($connection));
        $cek = $ambil->num_rows;
        if ($cek >= 1) {
            echo "<script> alert('Data model untuk guru ini sudah ada, harap hapus terlebih dahulu');</script>";
            echo "<script> location ='nilai.php?page=nilai';</script>";
        } else {
            $query = "INSERT INTO nilai VALUES ";
            foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
                $query .= "(NULL, '$_POST[kd_jenis]', '$kd_kriteria', '$_POST[nik]', '$nilai'),";
            }
            $sql = rtrim($query, ',');
            $validasi = true;
        }
    }
    if ($validasi) {
        http: //localhost/prakerjasaw/kriteria.php?page=kriteria&action=update&key=1
        $nik = $_POST['nik'];
        foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
            $q = $connection->query("SELECT kd_nilai FROM nilai WHERE kd_jenis=$_POST[kd_jenis] AND kd_kriteria=
            '$kd_kriteria' AND nik='$nik'") or die(mysqli_error($connection));
            if ($q->num_rows) {
                echo alert("Nilai untuk " . $_POST["nik"] . " sudah ada!", "?page=nilai");
                $err = true;
            }
        }
    }

    if (!$err and $connection->query($sql)  or die(mysqli_error($connection))) {
        echo alert("Berhasil!", "?page=nilai");
    } else {
        // echo alert("Gagal!", "?page=nilai");
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM nilai WHERE nik='$_GET[key]'");
    echo alert("Berhasil!", "?page=nilai");
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
                                    <label for="nik">Peserta</label>
                                    <?php if ($_POST) :
                                        $ambilpeserta = $koneksi->query("SELECT * FROM akun WHERE nik='$_POST[nik]'");
                                        $peserta = $ambilpeserta->fetch_assoc();
                                    ?>
                                        <input type="hidden" name="nik" value="<?= $_POST["nik"] ?>" class="form-control" readonly="on">
                                        <input type="text" name="nama" value="<?= $_POST['nik'] . ' | ' . $peserta['nama'] ?>" class="form-control" readonly="on">
                                    <?php else : ?>
                                        <select class="form-control" name="nik">
                                            <option value="">Pilih Peserta</option>
                                            <?php $sql = $connection->query("SELECT * FROM akun where role='Peserta'");
                                            while ($data = $sql->fetch_assoc()) : ?>
                                                <option value="<?= $data["nik"] ?>" <?= (!$update) ? "" : (($row["nik"] != $data["nik"]) ? "" : 'selected="selected"') ?>><?= $data["nik"] ?> | <?= $data["nama"] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" value="1" class="form-control" name="kd_jenis">
                                <?php if ($_POST) : ?>
                                    <?php $q = $connection->query("SELECT * FROM kriteria WHERE kd_jenis=$_POST[kd_jenis]");
                                    while ($r = $q->fetch_assoc()) : ?>
                                        <div class="form-group">
                                            <label for="nilai"><?= ucfirst($r["nama"]) ?></label>
                                            <select class="form-control" name="nilai[<?= $r["kd_kriteria"] ?>]" id="nilai">
                                                <option>---</option>
                                                <?php $sql = $connection->query("SELECT * FROM nilai_kriteria WHERE kd_kriteria=$r[kd_kriteria]");
                                                while ($data = $sql->fetch_assoc()) : ?>
                                                    <option value="<?= $data["nilai"] ?>" class="<?= $data["kd_kriteria"] ?>" <?= (!$update) ? "" : (($row["kd_nilaikriteria"] != $data["kd_nilaikriteria"]) ? "" : ' selected="selected"') ?>><?= $data["keterangan"] ?> - <?= $data["nilai"] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    <?php endwhile; ?>
                                    <input type="hidden" name="save" value="true">
                                <?php endif; ?>
                                <button type="submit" id="simpan" class="btn btn-lg float-end btn-<?= ($update) ? "warning" : "info" ?> btn-block"><?= ($_POST) ? "Simpan" : "Tampilkan" ?></button>
                                <?php if ($_POST) : ?>
                                    <a href="?page=nilai" class="btn btn-danger btn-block">Batal</a>
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
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama AS nama_jenis, b.nama AS nama_kriteria, d.nik, d.nama AS nama_akun, a.nilai FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN jenis c ON a.kd_jenis=c.kd_jenis JOIN akun d ON d.nik=a.nik order by d.nik")) : ?>
                                        <?php while ($row = $query->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nik'] ?></td>
                                                <td><?= $row['nama_akun'] ?></td>
                                                <td><?= $row['nama_kriteria'] ?></td>
                                                <td><?= $row['nilai'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="?page=nilai&action=delete&key=<?= $row['nik'] ?>" class="btn btn-danger m-1">Hapus</a>
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