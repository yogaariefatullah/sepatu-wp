<?php include 'header.php'; ?>

<?php
$update = (isset($_GET['action']) && $_GET['action'] === 'update');
if ($update) {
    $key = $connection->real_escape_string($_GET['key']);
    $sql = $connection->query("SELECT * FROM nilai_kriteria WHERE kd_nilaikriteria='$key'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;

    // Sanitasi input
    $kd_kriteria = $connection->real_escape_string($_POST['kd_kriteria']);
    $nilai = $connection->real_escape_string($_POST['nilai']);
    $keterangan = $connection->real_escape_string(trim($_POST['keterangan']));

    // Validasi kosong
    if (empty($kd_kriteria) || empty($nilai) || empty($keterangan)) {
        echo alert("Semua field wajib diisi!", "?page=subkriteria");
        $err = true;
    }

    if ($update && !$err) {
        $key = $connection->real_escape_string($_GET['key']);
        $sql = "UPDATE nilai_kriteria SET kd_kriteria='$kd_kriteria', nilai='$nilai', keterangan='$keterangan' WHERE kd_nilaikriteria='$key'";
    } elseif (!$update && !$err) {
        $sql = "INSERT INTO nilai_kriteria (kd_kriteria, nilai, keterangan) VALUES ('$kd_kriteria', '$nilai', '$keterangan')";
        $validasi = true;
    }

    if ($validasi && !$err) {
        $cek = $connection->query("SELECT kd_nilaikriteria FROM nilai_kriteria WHERE kd_kriteria='$kd_kriteria' AND keterangan='$keterangan'");
        if ($cek->num_rows > 0) {
            echo alert("Subkriteria sudah ada!", "?page=subkriteria");
            $err = true;
        }
    }

    if (!$err && $connection->query($sql)) {
        echo alert("Berhasil!", "?page=subkriteria");
    } elseif (!$err) {
        echo alert("Gagal menyimpan data!", "?page=subkriteria");
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $key = $connection->real_escape_string($_GET['key']);
    $connection->query("DELETE FROM nilai_kriteria WHERE kd_nilaikriteria='$key'");
    echo alert("Berhasil dihapus!", "?page=subkriteria");
}
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <!-- Form -->
                <div class="col-md-4 ">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark"><b><?= $update ? "EDIT" : "TAMBAH" ?></b></h2>
                            <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
                                <div class="form-group">
                                    <label for="kd_kriteria">Kriteria</label>
                                    <select class="form-control" name="kd_kriteria" required>
                                        <option value="">-- Pilih Kriteria --</option>
                                        <?php
                                        $result = $connection->query("SELECT * FROM kriteria");
                                        while ($kriteria = $result->fetch_assoc()) {
                                            $selected = ($update && $row['kd_kriteria'] == $kriteria['kd_kriteria']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($kriteria['kd_kriteria']) . '" ' . $selected . '>' . htmlspecialchars($kriteria['nama']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="nilai">Nilai</label>
                                    <input type="number" name="nilai" class="form-control" required value="<?= $update ? htmlspecialchars($row['nilai']) : '' ?>">
                                </div>

                                <div class="form-group mt-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" rows="3" class="form-control" required><?= $update ? htmlspecialchars($row['keterangan']) : '' ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3 float-end"><?= $update ? "Update" : "Simpan" ?></button>
                                <?php if ($update) : ?>
                                    <a href="?page=subkriteria" class="btn btn-secondary mt-3">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>DAFTAR SUBKRITERIA</b></h2>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = $connection->query("SELECT nk.kd_nilaikriteria, k.nama AS kriteria, nk.nilai, nk.keterangan FROM nilai_kriteria nk JOIN kriteria k ON nk.kd_kriteria = k.kd_kriteria");
                                    while ($row = $query->fetch_assoc()) :
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['kriteria']) ?></td>
                                            <td><?= htmlspecialchars($row['nilai']) ?></td>
                                            <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="?page=subkriteria&action=update&key=<?= $row['kd_nilaikriteria'] ?>" class="btn btn-warning m-1">Edit</a>
                                                    <a href="?page=subkriteria&action=delete&key=<?= $row['kd_nilaikriteria'] ?>" class="btn btn-danger m-1" onclick="return confirm('Yakin ingin menghapus subkriteria ini?')">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
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