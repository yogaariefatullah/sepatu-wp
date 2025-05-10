<?php include 'header.php'; ?>
<?php
$update = (isset($_GET['action']) && $_GET['action'] == 'update');
if ($update) {
    $sql = $connection->query("SELECT * FROM kriteria WHERE kd_kriteria='" . $connection->real_escape_string($_GET['key']) . "'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kd_jenis = 1; // Karena hanya satu jenis sepatu (Emporio Armani)
    $nama = $connection->real_escape_string($_POST['nama']);
    $tipe = $connection->real_escape_string($_POST['tipe']);
    $sifat = $connection->real_escape_string($_POST['sifat']);

    $err = false;

    if ($update) {
        $sql = "UPDATE kriteria SET kd_jenis=$kd_jenis, nama='$nama', tipe='$tipe', sifat='$sifat' WHERE kd_kriteria='" . $connection->real_escape_string($_GET['key']) . "'";
    } else {
        // Cek duplikasi
        $check = $connection->query("SELECT * FROM kriteria WHERE kd_jenis=$kd_jenis AND nama='$nama'");
        if ($check->num_rows > 0) {
            echo alert("Kriteria sudah ada!", "?page=kriteria");
            $err = true;
        }

        if (!$err) {
            $sql = "INSERT INTO kriteria VALUES (NULL, $kd_jenis, '$nama', '$tipe', '$sifat')";
        }
    }

    if (!$err && $connection->query($sql)) {
        echo alert("Berhasil!", "?page=kriteria");
    } elseif (!$err) {
        echo alert("Gagal menyimpan data!", "?page=kriteria");
    }
}

// Hapus data
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM kriteria WHERE kd_kriteria='" . $connection->real_escape_string($_GET['key']) . "'");
    echo alert("Berhasil dihapus!", "?page=kriteria");
}
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark"><b><?= ($update ? "EDIT" : "TAMBAH") ?> KRITERIA</b></h2>
                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                <input type="hidden" name="kd_jenis" value="1">

                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select class="form-control" name="tipe" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <?php
                                        $tipe_options = ["Jenis Olahraga", "Gender", "Warna", "Kelenturan", "Tebal Sol", "Harga"];
                                        foreach ($tipe_options as $option) {
                                            $selected = ($update && $row['tipe'] == $option) ? 'selected' : '';
                                            echo "<option value=\"$option\" $selected>$option</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama Kriteria</label>
                                    <textarea name="nama" rows="3" class="form-control" required><?= $update ? htmlspecialchars($row['nama']) : '' ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Sifat</label>
                                    <select class="form-control" name="sifat" required>
                                        <option value="">-- Pilih Sifat --</option>
                                        <option value="min" <?= ($update && $row['sifat'] == 'min') ? 'selected' : '' ?>>Min</option>
                                        <option value="max" <?= ($update && $row['sifat'] == 'max') ? 'selected' : '' ?>>Max</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg float-end"><?= $update ? 'Update' : 'Simpan' ?></button>
                                <?php if ($update) : ?>
                                    <a href="?page=kriteria" class="btn btn-light btn-lg">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kriteria -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>DAFTAR KRITERIA</b></h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Nama Kriteria</th>
                                        <th>Sifat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = $connection->query("SELECT a.nama AS kriteria, a.kd_kriteria, a.tipe, a.sifat FROM kriteria a WHERE kd_jenis = 1");
                                    while ($data = $query->fetch_assoc()) :
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tipe'] ?></td>
                                            <td><?= $data['kriteria'] ?></td>
                                            <td><?= strtoupper($data['sifat']) ?></td>
                                            <td>
                                                <a href="?page=kriteria&action=update&key=<?= $data['kd_kriteria'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="?page=kriteria&action=delete&key=<?= $data['kd_kriteria'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($no == 1) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Table -->
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>