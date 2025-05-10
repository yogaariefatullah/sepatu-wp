<?php include 'header.php'; ?>

<?php
$update = (isset($_GET['action']) && $_GET['action'] == 'update');

if ($update) {
    $id_sepatu = $connection->real_escape_string($_GET['key']);
    $kd_kriteria = $connection->real_escape_string($_GET['kriteria']);
    $sql = $connection->query("SELECT * FROM nilai_wp WHERE id_sepatu='$id_sepatu' AND kd_kriteria='$kd_kriteria'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $err = false;
    $id_sepatu = $connection->real_escape_string($_POST['id_sepatu']);
    $kd_kriteria = $connection->real_escape_string($_POST['kd_kriteria']);
    $nilai = $connection->real_escape_string($_POST['nilai']);

    if (!is_numeric($nilai)) {
        echo alert("Nilai harus berupa angka!", "?page=nilai_wp");
        $err = true;
    }

    if (!$err) {
        if ($update) {
            $sql = "UPDATE nilai_wp SET nilai='$nilai' WHERE id_sepatu='$id_sepatu' AND kd_kriteria='$kd_kriteria'";
        } else {
            $cek = $connection->query("SELECT * FROM nilai_wp WHERE id_sepatu='$id_sepatu' AND kd_kriteria='$kd_kriteria'");
            if ($cek->num_rows > 0) {
                echo alert("Nilai sudah ada untuk kombinasi sepatu dan kriteria tersebut!", "?page=nilai_wp");
                $err = true;
            } else {
                $sql = "INSERT INTO nilai_wp (id_sepatu, kd_kriteria, nilai) VALUES ('$id_sepatu', '$kd_kriteria', '$nilai')";
            }
        }

        if (!$err && $connection->query($sql)) {
            echo alert("Berhasil disimpan!", "?page=nilai_wp");
        } else {
            echo alert("Gagal menyimpan data!", "?page=nilai_wp");
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_sepatu = $connection->real_escape_string($_GET['key']);
    $kd_kriteria = $connection->real_escape_string($_GET['kriteria']);
    $connection->query("DELETE FROM nilai_wp WHERE id_sepatu='$id_sepatu' AND kd_kriteria='$kd_kriteria'");
    echo alert("Berhasil dihapus!", "?page=nilai_wp");
}
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <!-- Form Tambah/Edit -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark"><b><?= $update ? "Update" : "Tambah" ?> Nilai WP</b></h2>
                            <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
                                <div class="form-group">
                                    <label for="id_sepatu">Sepatu</label>
                                    <select class="form-control" name="id_sepatu" required>
                                        <option value="">Pilih Sepatu</option>
                                        <?php
                                        $querySepatu = $connection->query("SELECT * FROM sepatu");
                                        while ($data = $querySepatu->fetch_assoc()) :
                                        ?>
                                            <option value="<?= $data['id_sepatu'] ?>" <?= ($update && $row['id_sepatu'] == $data['id_sepatu']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($data['nama_sepatu']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_kriteria">Kriteria</label>
                                    <select class="form-control" name="kd_kriteria" required>
                                        <option value="">Pilih Kriteria</option>
                                        <?php
                                        $queryKriteria = $connection->query("SELECT * FROM kriteria");
                                        while ($data = $queryKriteria->fetch_assoc()) :
                                        ?>
                                            <option value="<?= $data['kd_kriteria'] ?>" <?= ($update && $row['kd_kriteria'] == $data['kd_kriteria']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($data['nama']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nilai">Nilai</label>
                                    <input type="text" class="form-control" name="nilai" value="<?= $update ? htmlspecialchars($row['nilai']) : '' ?>" required>
                                </div>

                                <button type="submit" class="btn btn-lg btn-<?= $update ? "warning" : "info" ?> btn-block"><?= $update ? "Update" : "Tambah" ?></button>
                                <?php if ($update) : ?>
                                    <a href="?page=nilai_wp" class="btn btn-secondary btn-block">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>Data Nilai Alternatif</b></h2>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sepatu</th>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = $connection->query("SELECT n.id_sepatu, s.nama_sepatu, k.nama AS kriteria, n.nilai, n.kd_kriteria
                                        FROM nilai_wp n
                                        JOIN sepatu s ON n.id_sepatu = s.id_sepatu
                                        JOIN kriteria k ON n.kd_kriteria = k.kd_kriteria");
                                    while ($row = $query->fetch_assoc()) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_sepatu']) ?></td>
                                            <td><?= htmlspecialchars($row['kriteria']) ?></td>
                                            <td><?= htmlspecialchars($row['nilai']) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="?page=nilai_wp&action=update&key=<?= $row['id_sepatu'] ?>&kriteria=<?= $row['kd_kriteria'] ?>" class="btn btn-warning m-1">Edit</a>
                                                    <a href="?page=nilai_wp&action=delete&key=<?= $row['id_sepatu'] ?>&kriteria=<?= $row['kd_kriteria'] ?>" class="btn btn-danger m-1" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
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
